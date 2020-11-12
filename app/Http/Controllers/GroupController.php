<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Table;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class GroupController extends Controller
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
        return $this->user->tables()->find($request->table_id)->groups()->get(['id','label'])->toArray();
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
        ]);
        if($group = $this->user->tables()->find($request->table_id)->groups()->create(['label' => $request->label])){
            return response(['group' => $group], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot add'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Group $group)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
        ]);
        return $this->user->tables()->find($request->table_id)->groups()->find($group->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
            "label"=>"required|string",
        ]);

        if($this->user->tables()->find($request->table_id)->groups()->find($group->id)->update(['label' => $request->label])){
            return response(['message' => 'updated'], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot update'], 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request, Group $group)
    {
        $this->validate($request,[
            "table_id"=>"required|numeric",
        ]);
        if($this->user->tables()->find($request->table_id)->groups()->find($group->id)->delete()){
            return response(['message' => 'deleted'], 200)->header('Content-Type', 'application/json');
        }else{
            return response(['message' => 'oops cannot delete'], 500)->header('Content-Type', 'application/json');
        }
    }
}
