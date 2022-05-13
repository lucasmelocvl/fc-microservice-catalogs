<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $rules = [
        'name' => 'required|max:255',
        'is_active' => 'boolean'
    ];

    /*
     * Return status code 200 on success
     */
    public function index()
    {
        return Category::all();
    }

    /*
     * Return status code 201 (created) on success
     */
    public function store(Request $request) //
    {
        $this->validate($request, $this->rules);
        return Category::create($request->all());
    }

    /*
     * 'Category $category' usa Route Model Binding Implicit (ligação do model com a rota)
     * Route Model Binding Explict seria especificando pelo RouteServiceProvider mapApiRoutes;
     */
    public function show(Category $category)
    {
        return $category;
    }

    /*
     * Return status code 200 on success
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, $this->rules);
        $category->update($request->all());
        return $category;
    }

    /*
     * Return status code 204 (no content) on success
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}
