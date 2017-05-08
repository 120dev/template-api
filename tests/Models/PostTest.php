<?PHP
use App\DEV\Models\Post;
use App\DEV\Models\Category;

use Tests\BaseController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class PostTest
 */
class PostTest extends BaseController
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    protected $headers = ['Accept' => 'application/vnd.templateApi.v1+json'];

    public function testPost()
    {
        /**
         * |-------------------------------------------
         * | Creation of a category
         * |-------------------------------------------
         */
        try {
            $category = factory(Category::class)->create();
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        /**
         * |-------------------------------------------
         * | Creation of an post
         * |-------------------------------------------
         */
        try {
            factory(Post::class)->create([
                'category_id' => $category->id
            ]);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }

        $this->assertEquals($category->name, (Post::find(1)->category)->name);

    }

}
