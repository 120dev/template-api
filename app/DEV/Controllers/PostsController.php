<?php

namespace App\DEV\Controllers;

use App\DEV\Models\Post;

use App\DEV\Requests\PostRequest;
use DEV\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sorskod\Larasponse\Larasponse;

/**
 * Class PostsController
 * @package App\Http\Controllers
 */
class PostsController extends BaseController
{
    /**
     * @var Larasponse
     */
    protected $response;

    /**
     * PostsController constructor.
     * @param Larasponse $response
     */
    public function __construct(Larasponse $response)
    {
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @route GET /api/posts
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response->collection(Post::all(), new PostTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @route GET /api/posts/{post}
     * @param  int $id
     * @return \Illuminate\Http\Response
     *
     */
    public function show($id)
    {
        try {
            $post = Post::with('category')->findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(null, 404);
        }

        return $this->response->item($post, new PostTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $input = $request->input();
        $post = new Post($input);

        $response = DB::transaction(function () use ($post, $input) {

            try {
                $post->save();
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 422);
            }

            $response = $this->response->item($post, new PostTransformer());
            return response()->json($response, 201);

        });

        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HoldingRequest|Request $request
     * @param $id
     * @return mixed
     * @internal param $user_id
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();
        $post = Post::findOrFail($id);

        $response = DB::transaction(function () use ($post, $input) {

            try {
                $post->update($input);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 422);
            }

            return $this->response->item($post, new PostTransformer());
        });

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $response = DB::transaction(function () use ($id, $post) {
            try {
                $post->delete();
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 422);
            }

            return response()->json(null, 204);
        });

        return $response;
    }

}
