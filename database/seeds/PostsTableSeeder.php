<?php

use App\DEV\Models\Category;
use App\DEV\Models\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(0, 100) as $index) {
            $category = factory(Category::class)->create();
            factory(Post::class)->create([
                'category_id' => $category->id
            ]);
        }

    }
}
