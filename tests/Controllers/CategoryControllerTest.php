<?PHP
use App\DEV\Models\Category;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryControllerTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    protected $headers = ['Accept' => 'application/vnd.templateApi.v1+json'];
    protected $input = ['name' => 'test-name'];
    protected $output = ['id' => 1, 'name' => 'test-name'];

    public function testStore()
    {
        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $this->json('POST', '/api/categories', $this->input, $this->headers)
            ->assertStatus(201);

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('POST', '/api/categories', [], $this->headers)
            ->assertStatus(500);

    }

    public function testIndex()
    {
        factory(Category::class, 5)->create();

        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $data = $this->json('GET', '/api/categories', [], $this->headers);
        $data->assertStatus(200);

        $data = json_decode($data->getContent());
        $data = $data->data;

        $this->assertCount(5, $data);
        $this->assertArraySubset(
            array_keys($this->output),
            array_keys((array)$data[rand(0, 4)])
        );

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('GET', '/api/categories/6', [], $this->headers)
            ->assertStatus(404);
    }

    public function testShow()
    {
        factory(Category::class)->create($this->input);

        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $this->json('GET', '/api/categories/1', [], $this->headers)
            ->assertStatus(200);

        $data = $this->json('GET', '/api/categories/1', [], $this->headers);
        $data = json_decode($data->getContent());

        $this->assertArraySubset(
            array_keys($this->output),
            array_keys((array)$data)
        );

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('GET', '/api/categories/2', [], $this->headers)
            ->assertStatus(404);
    }

    public function testUpdate()
    {
        factory(Category::class)->create();

        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $this->json('PUT', '/api/categories/1', ['name' => 'test-name'], $this->headers)
            ->assertStatus(200);

        $post = $this->json('GET', '/api/categories/1', [], $this->headers);
        $post = json_decode($post->getContent());

        $this->assertEquals('test-name', $post->name);

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('PUT', '/api/categories/2', ['name' => 'test-name'], $this->headers)
            ->assertStatus(500);
    }

    public function testDestroy()
    {
        factory(Category::class)->create();

        /**
         * |-------------------------------------------
         * | Success
         * |-------------------------------------------
         */
        $this->json('DELETE', '/api/categories/1', [], $this->headers)
            ->assertStatus(204);

        $this->json('GET', '/api/categories/1', [], $this->headers)
            ->assertStatus(404);

        /**
         * |-------------------------------------------
         * | Failed
         * |-------------------------------------------
         */
        $this->json('DELETE', '/api/categories/1', [], $this->headers)
            ->assertStatus(500);
    }

}
