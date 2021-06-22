<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        $size = $request->query('size');
        $categories = $query->get();
        if ($size) {
            $categories = $query->paginate($size);
        }
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "name" => 'required|string|min:2|max:50|unique:categories'
            ]
        );

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        $categories = Category::create($request->all());

        if ($categories) {
            return new CategoryResource($categories);
        }

        throw new Exception('Unexpected Error');
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function getByName($name)
    {
        $category = Category::where('name', $name)->first();
        if (! $category) {
            return response()->json(['error' => 'name'], 400);
        }
        return new CategoryResource($category);

    }

    public function update(Request $request, Category $category)
    {
        $validate = Validator::make(
            $request->all(),
            [
                "id" => 'required|numeric|unique:categories'. $category->id,
                "name" => 'required|string|min:2|max:50|unique:categories',
            ]);

        if ($validate->fails()) {
            return response()->json($validate->failed(), 400);
        }

        if ($category->update($request->all())) {
            $category->flash();
            return new CategoryResource($category);
        }

        throw new Exception('Unexpected Error');
    }

    public function destroy(Category $category)
    {
        if ($category->delete()) {
            return ['data' => $category->id];
        }

        throw new Exception('Unexpected Error');
    }
}
