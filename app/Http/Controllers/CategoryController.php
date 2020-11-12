<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Todo;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class CategoryController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
        ]);
        return $this->user->tables()->find($request->table_id)->categories()->get(['id','label','color'])->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
            "label"=>"required|string",
            "color"=>"required|string",
        ]);
        if($category = $this->user->tables()->find($request->table_id)->categories()->create(['label' => $request->label, 'color'=>$request->color])){
            return response(['category' => $category], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot add'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Category $category)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
        ]);
        return $this->user->tables()->find($request->table_id)->categories()->find($category->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
            "label"=>"required|string",
            "color"=>"required|string",
        ]);

        if($this->user->tables()->find($request->table_id)->categories()->find($category->id)->update(['label' => $request->label, 'color'=>$request->color])){
            return response(['message' => 'updated'], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot update'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request, Category $category)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
        ]);
        if($this->user->tables()->find($request->table_id)->categories()->find($category->id)->delete()){
            return response(['message' => 'deleted'], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot delete'], 500)->header('Content-Type', 'application/json');
        }
    }
}
