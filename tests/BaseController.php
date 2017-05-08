<?php

namespace Tests;

use Mockery\Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BaseController extends TestCase
{
    protected $headers = ['Accept' => 'application/vnd.templateApi.v1+json'];

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function createHttpPost()
    {
        /**
         * |-------------------------------------------
         * | Create an category
         * |-------------------------------------------
         */
        $category = $this->json('POST', '/api/categories', ['name' => 'test-name'], $this->headers);
        $category->assertStatus(201);

        $category = json_decode($category->getContent());

        if (empty($category->id)) {
            Throw new Exception(500);
        }

        $data = [
            'title'       => 'test-title',
            'body'        => 'test-body',
            'active'      => 1,
            'category_id' => $category->id
        ];

        return $this->json('POST', '/api/posts', $data, $this->headers);
    }

}