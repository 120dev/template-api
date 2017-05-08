<?php

namespace App\DEV\Controllers;

use App\DEV\Models\Category;

use App\DEV\Requests\PostRequest;
use App\DEV\Requests\CategoryRequest;
use DEV\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Sorskod\Larasponse\Larasponse;

/**
 * Class PostsController
 * @package App\Http\Controllers
 */
class CategoriesController extends BaseController
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
     * @route GET /api/categories
     * @return Response
     */
    public function index()
    {
        return $this->response->collection(Category::all(), new CategoryTransformer());
    }

    /**
     * Display the specified resource.
     *
     * @route GET /api/categories/{category}
     * @param  int $id
     * @return Response
     *
     */
    public function show($id)
    {
        try {
            $data = Category::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(null, 404);
        }

        return $this->response->item($data, new CategoryTransformer());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest|Request $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        $input = $request->input();
        $data = new Category($input);

        $response = DB::transaction(function () use ($data, $input) {
            try {
                $data->save();
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 422);
            }

            return response()->json($data, 201);
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
        $data = Category::findOrFail($id);

        $response = DB::transaction(function () use ($data, $input) {
            try {
                $data->update($input);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 422);
            }

            return response()->json($data, 200);
        });

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $data = Category::findOrFail($id);

        $response = DB::transaction(function () use ($id, $data) {
            try {
                $data->delete();
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 422);
            }

            return response()->json(null, 204);
        });

        return $response;
    }

}
