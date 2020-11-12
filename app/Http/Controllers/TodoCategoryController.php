<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class TodoCategoryController extends Controller
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
            "group_id"=>"required|numeric",
            "todo_id"=>"required|numeric",
        ]);
        return $this->user->tables()->find($request->table_id)->groups()->find($request->group_id)->todos()->find($request->todo_id)->todoCategories()->select(['categories.id','label','color'])->leftJoinRelationship('category')->get()->toArray();
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
            "group_id"=>"required|numeric",
            "todo_id"=>"required|numeric",
            "category_id"=>"required|numeric"
        ]);
        if($todoCategory = $this->user->tables()->find($request->table_id)->groups()->find($request->group_id)->todos()->find($request->todo_id)->todoCategories()->create(['category_id'=>$request->category_id])){
            return response(['todoCategory' => $todoCategory], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot add'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $todoCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Category $todoCategory)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
            "group_id"=>"required|numeric",
            "todo_id"=>"required|numeric",
        ]);
        return $this->user->tables()->find($request->table_id)->groups()->find($request->group_id)->todos()->find($request->todo_id)->todoCategories()->where('category_id',$todoCategory->id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $todoCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $todoCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $todoCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $todoCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $todoCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request, Category $todoCategory)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
            "group_id"=>"required|numeric",
            "todo_id"=>"required|numeric",
        ]);
        if($this->user->tables()->find($request->table_id)->groups()->find($request->group_id)->todos()->find($request->todo_id)->todoCategories()->where('category_id',$todoCategory->id)->delete()){
            return response(['message' => 'deleted'], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot delete'], 500)->header('Content-Type', 'application/json');
        }
    }
}
