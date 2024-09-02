<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Category::all();
            if ($categories == []) {
                return $this->notFound('there is no category');
            }

            return $this->success('got all category successfully', $categories);
        } catch (\Throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required',
            ]);
            $category = Category::create($data);

            return $this->success('created category successfully', $category);
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $data = $request->validate([
                'name' => 'string',
            ]);

            $category->update($data);

            return $this->success('updated category successfully', $category);
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return $this->success('deleted category successfully');
        } catch (\throwable $th) {
            return $this->serverError($th->getMessage());
        }
    }
}
