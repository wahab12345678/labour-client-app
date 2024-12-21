<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'cnic_no', 'cnic_front_img', 'cnic_back_img', 'address'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
