<?PHP
use App\DEV\Models\Post;
use Tests\BaseController;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostControllerTest extends BaseController
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    protected $postFields = ['id', 'title', 'body', 'category', 'active'];

    public function testStore()
    {
        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $this->createHttpPost()->assertStatus(201);

        // Checking output field mapping
        $post = $this->json('GET', '/api/posts/1', [], $this->headers);
        $this->assertArraySubset($this->postFields, array_keys((array)json_decode($post->getContent())));

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('POST', '/api/posts', [], $this->headers)
            ->assertStatus(500);

    }

    public function testIndex()
    {
        foreach (range(1, 5) as $index) {
            $this->createHttpPost()->assertStatus(201);
        }

        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $data = $this->json('GET', '/api/posts', [], $this->headers);
        $data->assertStatus(200);

        $data = json_decode($data->getContent());
        $data = $data->data;

        $this->assertCount(5, $data);

        // Checking output field mapping
        $this->assertArraySubset($this->postFields, array_keys((array)$data[rand(0, 4)]));

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('GET', '/api/posts/6', [], $this->headers)
            ->assertStatus(404);
    }

    public function testShow()
    {
        $this->createHttpPost()->assertStatus(201);

        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $post = $this->json('GET', '/api/posts/1', [], $this->headers);
        $post->assertStatus(200);

        // Checking output field mapping
        $this->assertArraySubset($this->postFields, array_keys((array)json_decode($post->getContent())));

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('GET', '/api/posts/2', [], $this->headers)
            ->assertStatus(404);
    }

    public function testUpdate()
    {
        $this->createHttpPost()->assertStatus(201);

        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $this->json('PUT', '/api/posts/1', ['title' => 'new title'], $this->headers)
            ->assertStatus(200);

        $post = $this->json('GET', '/api/posts/1', [], $this->headers);
        $post = json_decode($post->getContent());

        // Checking output field mapping
        $this->assertArraySubset($this->postFields, array_keys((array)$post));

        $this->assertEquals('new title', $post->title);

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('PUT', '/api/posts/2', ['toto' => 'new title'], $this->headers)
            ->assertStatus(500);
    }

    public function testDestroy()
    {
        $this->createHttpPost()->assertStatus(201);

        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $this->json('DELETE', '/api/posts/1', [], $this->headers)
            ->assertStatus(204);

        $this->json('GET', '/api/posts/1', [], $this->headers)
            ->assertStatus(404);

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('DELETE', '/api/posts/1', [], $this->headers)
            ->assertStatus(500);
    }

}
