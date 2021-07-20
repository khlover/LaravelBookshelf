<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Book extends Model
{
    use Sortable;

    protected $guarded = ['bookid'];
    protected $primaryKey = 'bookid';

    public $sortable = ['title', 'author'];
    public $timestamps = false;
}
