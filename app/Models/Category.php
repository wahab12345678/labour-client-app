<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'key_points','slug', 'status', 'img_path', 'is_visible'];
}
