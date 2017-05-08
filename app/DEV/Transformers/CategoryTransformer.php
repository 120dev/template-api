<?php

namespace DEV\Transformers;

use App\DEV\Models\Category;
use League\Fractal\TransformerAbstract;

/**
 * Class CategoryTransformer
 * @package DEV\Categorys
 */
class CategoryTransformer extends TransformerAbstract
{

    /**
     * @param Category $category
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            'id'   => (int)$category->id,
            'name' => $category->name,
        ];
    }
}
