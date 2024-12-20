<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    protected $fillable = ['user_id', 'account_type_id', 'account_no', 'account_title'];
}
