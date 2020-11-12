<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\todo;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class TodoController extends Controller
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
        ]);
        return $this->user->tables()->find($request->table_id)->groups()->find($request->group_id)->todos()->get(['id','label','desc','percent_done'])->toArray();
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
            "label"=>"required|string",
            "desc"=>"required|string",
            "percent_done"=>"required|numeric",
        ]);
        if($todo = $this->user->tables()->find($request->table_id)->groups()->find($request->group_id)->todos()->create(['label' => $request->label, 'desc'=>$request->desc, 'percent_done'=>$request->percent_done])){
            return response(['todo' => $todo], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot add'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Todo $todo)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
            "group_id"=>"required|numeric",
        ]);
        return $this->user->tables()->find($request->table_id)->groups()->find($request->group_id)->todos()->find($todo->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
            "group_id"=>"required|numeric",
            "label"=>"required|string",
            "desc"=>"required|string",
            "percent_done"=>"required|numeric",
        ]);

        if($this->user->tables()->find($request->table_id)->groups()->find($request->group_id)->todos()->find($todo->id)->update(['label' => $request->label, 'desc'=>$request->desc, 'percent_done'=>$request->percent_done])){
            return response(['message' => 'updated'], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot update'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request, Todo $todo)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
            "group_id"=>"required|numeric",
        ]);
        if($this->user->tables()->find($request->table_id)->groups()->find($request->group_id)->todos()->find($todo->id)->delete()){
            return response(['message' => 'deleted'], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot delete'], 500)->header('Content-Type', 'application/json');
        }
    }
}
