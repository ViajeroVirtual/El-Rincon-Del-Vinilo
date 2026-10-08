<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['discogs_id', 'name', 'artist', 'description', 'cover_url', 'price'];
}
