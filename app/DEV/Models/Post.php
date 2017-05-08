<?php

namespace App\DEV\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * @package App
 */
class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['title', 'body', 'active', 'category_id'];
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
