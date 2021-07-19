<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'bookid';
    protected $guarded = ['bookid'];
    public $timestamps = false;
}
