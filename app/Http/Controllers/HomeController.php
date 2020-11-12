<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        /*
             dd([
                User::find(1),
                User::find(1)->tables,
                User::find(1)->tables[0]->groups,
                User::find(1)->tables[0]->groups[0]->todos,
                User::find(1)->tables[0]->groups[0]->todos[0]->todoCategories,
                User::find(1)->tables[0]->groups[0]->todos[0]->todoCategories[0]->category,
            ]);
        */
        return view('welcome');
    }
}
