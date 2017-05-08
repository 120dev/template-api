<?php

namespace App\DEV\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * @package App
 */
class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['id', 'name'];

}
