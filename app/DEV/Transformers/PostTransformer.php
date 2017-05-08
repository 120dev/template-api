<?php

namespace DEV\Transformers;

use App\DEV\Models\Post;
use League\Fractal\TransformerAbstract;

/**
 * Class PostTransformer
 * @package DEV\Posts
 */
class PostTransformer extends TransformerAbstract
{

    /**
     * @param Post $post
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id'       => (int)$post->id,
            'title'    => $post->title,
            'body'     => $post->body,
            'category' => $post->category->name,
            'active'   => (boolean)$post->active,
        ];
    }
}
