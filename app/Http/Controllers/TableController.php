<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class TableController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->user->tables()->get(['id','label'])->toArray();
    }


    /**
     * Display the specified resource.
     *
     * @param $table
     * @return \Illuminate\Http\Response
     */
    public function getContent($table)
    {
        $table = $this->user->tables()->find($table)->with('groups')->with('groups.todos')->with('groups.todos.categories')->get()->toArray();

        return $table;
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
            "label"=>"required|string",
        ]);
        if($table = $this->user->tables()->create(['label' => $request->label])){
            return response(['table' => $table], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot add'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Table  $tables
     * @return \Illuminate\Http\Response
     */
    public function show(Table $table)
    {
        return $this->user->tables()->find($table->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Table  $tables
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Table  $tables
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        $this->validate($request,[
            "label"=>"required|string",
        ]);

        if($this->user->tables()->find($table->id)->update(['label' => $request->label])){
            return response(['message' => 'updated'], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot update'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Table  $tables
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        if($this->user->tables()->find($table->id)->delete()){
            return response(['message' => 'deleted'], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot delete'], 500)->header('Content-Type', 'application/json');
        }
    }
}
