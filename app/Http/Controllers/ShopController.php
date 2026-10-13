<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $key = config('services.discogs.key');
        $secret = config('services.discogs.secret');
        
        $page = $request->get('page', 1);
        
        // Detectar país por el idioma del navegador para priorizar la región
        $lang = substr($request->server('HTTP_ACCEPT_LANGUAGE', 'es'), 0, 2);
        $countryMap = [
            'es' => 'Spain',
            'en' => 'UK', 
            'fr' => 'France',
            'it' => 'Italy',
            'de' => 'Germany',
            'pt' => 'Brazil'
        ];
        $country = $countryMap[$lang] ?? 'US';
        $regionMap = [
            'Spain' => 'de España',
            'UK' => 'del Reino Unido',
            'France' => 'de Francia',
            'Italy' => 'de Italia',
            'Germany' => 'de Alemania',
            'Brazil' => 'de Brasil',
            'US' => 'de Estados Unidos'
        ];
        $regionName = $regionMap[$country] ?? 'Internacionales';

        $params = [
            'type' => 'release',
            'format' => 'vinyl',
            'per_page' => 9,
            'page' => $page,
            'country' => $country, // Añadido para priorizar la región local
            'key' => $key,
            'secret' => $secret
        ];
        
        $novedades = collect();
        $recomendados = collect();

        // Solo cargamos novedades y recomendados en la portada (sin búsqueda y página 1)
        if (!$request->filled('search') && $page == 1) {
            $novedades = Cache::remember('shop_novedades_' . date('Y'), 3600, function () use ($key, $secret) {
                try {
                    $resNovedades = Http::timeout(5)->withHeaders(['User-Agent' => 'RinconDelVinilo/1.0'])
                        ->get('https://api.discogs.com/database/search', [
                            'type' => 'release', 'format' => 'vinyl', 'year' => date('Y'), 'per_page' => 6, 'key' => $key, 'secret' => $secret
                        ]);
                    return $resNovedades->successful() ? $this->formatDiscogsResults($resNovedades->json()['results'], false, $key, $secret)->toArray() : [];
                } catch (\Exception $e) {
                    Log::error('Error fetching Discogs novedades: ' . $e->getMessage());
                    return [];
                }
            });

            $recomendados = Cache::remember('shop_recomendados_' . $country, 3600, function () use ($country, $key, $secret) {
                try {
                    $resRecomendados = Http::timeout(5)->withHeaders(['User-Agent' => 'RinconDelVinilo/1.0'])
                        ->get('https://api.discogs.com/database/search', [
                            'type' => 'release', 'format' => 'vinyl', 'country' => $country, 'per_page' => 6, 'key' => $key, 'secret' => $secret
                        ]);
                    return $resRecomendados->successful() ? $this->formatDiscogsResults($resRecomendados->json()['results'], false, $key, $secret)->toArray() : [];
                } catch (\Exception $e) {
                    Log::error('Error fetching Discogs recomendados: ' . $e->getMessage());
                    return [];
                }
            });
        }

        if ($request->filled('search')) {
            $params['q'] = $request->search;
        } elseif (!$request->filled('genre')) {
            $params['year'] = date('Y') - 1; // El catálogo mostrará el año anterior por defecto si no hay búsqueda ni filtro
        }

        if ($request->filled('genre')) {
            $params['genre'] = $request->genre;
        }

        $cacheKey = 'discogs_search_' . md5(json_encode($params));

        try {
            $cachedData = Cache::remember($cacheKey, 600, function() use ($params, $key, $secret) {
                $response = Http::timeout(5)
                    ->withHeaders(['User-Agent' => 'RinconDelVinilo/1.0'])
                    ->get('https://api.discogs.com/database/search', $params);

                if ($response->successful()) {
                    $data = $response->json();
                    $totalItems = min($data['pagination']['items'] ?? 0, 10000);
                    // IMPORTANTE: Cambiamos a true para que traiga los precios y se puedan comprar
                    $products = $this->formatDiscogsResults($data['results'], true, $key, $secret)->toArray();
                    return ['products' => $products, 'total' => $totalItems];
                }
                
                throw new \Exception('API de Discogs saturada');
            });
        } catch (\Exception $e) {
            Log::error('Error fetching Discogs catalog: ' . $e->getMessage());
            return view('shop.error');
        }

        $products = collect($cachedData['products']);
        
        // Filtro de solo disponibles
        if ($request->has('disponibles')) {
            $products = $products->filter(function($p) {
                return $p['price'] > 0;
            });
        }

        $totalItems = $cachedData['total'];
        
        $paginator = new LengthAwarePaginator(
            $products,
            $totalItems,
            9,
            $page,
            ['path' => route('tienda'), 'query' => $request->query()]
        );

        return view('shop.index', [
            'products' => $paginator,
            'novedades' => $novedades,
            'recomendados' => $recomendados,
            'regionName' => $regionName
        ]);
    }

    private function formatDiscogsResults($results, $fetchPrice, $key, $secret)
    {
        $products = collect();
        $releaseResponses = [];
        
        if ($fetchPrice && count($results) > 0) {
            $releaseResponses = Http::pool(function (Pool $pool) use ($results, $key, $secret) {
                return collect($results)->map(function ($item) use ($pool, $key, $secret) {
                    return $pool->as((string)$item['id'])->withHeaders(['User-Agent' => 'RinconDelVinilo/1.0'])
                        ->get('https://api.discogs.com/releases/' . $item['id'], ['key' => $key, 'secret' => $secret]);
                })->toArray();
            });
        }
        
        foreach ($results as $item) {
            $coverUrl = $item['cover_image'] ?? null;
            
            // Si no tiene portada o es la imagen por defecto de Discogs vacía, lo saltamos
            if (!$coverUrl || str_contains((string)$coverUrl, 'spacer.gif')) {
                continue;
            }

            $price = 0;
            $artist = 'Artista Desconocido';
            
            $idStr = (string)$item['id'];
            if ($fetchPrice && isset($releaseResponses[$idStr]) && $releaseResponses[$idStr]->successful()) {
                $releaseData = $releaseResponses[$idStr]->json();
                $price = $releaseData['lowest_price'] ?? 0;
                if (isset($releaseData['artists'][0]['name'])) {
                    $artist = preg_replace('/\s\(\d+\)$/', '', $releaseData['artists'][0]['name']);
                }
            } else {
                $titleParts = explode(' - ', $item['title']);
                if (count($titleParts) > 1) {
                    $artist = trim($titleParts[0]);
                }
            }
            
            $titleParts = explode(' - ', $item['title']);
            $name = count($titleParts) > 1 ? trim($titleParts[1]) : trim($item['title']);
            if ($artist === 'Artista Desconocido' && count($titleParts) > 1) {
                $artist = trim($titleParts[0]);
            }
            
            $products->push([
                'id' => $item['id'],
                'name' => $name,
                'artist' => $artist,
                'cover_url' => $item['cover_image'] ?? null,
                'price' => $price,
                'description' => 'Géneros: ' . implode(', ', $item['genre'] ?? ['Vinyl']) . '. Año: ' . ($item['year'] ?? 'N/A')
            ]);
        }
        return $products;
    }

    public function show($id)
    {
        $key = config('services.discogs.key');
        $secret = config('services.discogs.secret');

        try {
            $response = Http::timeout(8)->withHeaders(['User-Agent' => 'RinconDelVinilo/1.0'])
                ->get('https://api.discogs.com/releases/' . $id, [
                    'key' => $key,
                    'secret' => $secret
                ]);

            if ($response->successful()) {
                $data = $response->json();
            
                $price = $data['lowest_price'] ?? 0;
                $artist = $data['artists'][0]['name'] ?? 'Artista Desconocido';
                $artist = preg_replace('/\s\(\d+\)$/', '', $artist);
                
                $name = $data['title'];

                $product = (object)[
                    'id' => $data['id'],
                    'name' => $name,
                    'artist' => $artist,
                    'cover_url' => $data['images'][0]['uri'] ?? ($data['thumb'] ?? null),
                    'price' => $price,
                    'description' => $data['notes'] ?? 'Una pieza fantástica para cualquier colección. Sin descripción adicional en Discogs.',
                    'genres' => $data['genres'] ?? [],
                    'styles' => $data['styles'] ?? [],
                    'year' => $data['year'] ?? 'Desconocido',
                    'tracklist' => collect($data['tracklist'] ?? [])->filter(fn($t) => $t['type_'] === 'track')
                ];

                return view('shop.show', compact('product'));
            }
        } catch (\Exception $e) {
            Log::error('Error fetching Discogs release detail: ' . $e->getMessage());
            return view('shop.error');
        }

        abort(404, 'Vinilo no encontrado en Discogs');
    }
}
