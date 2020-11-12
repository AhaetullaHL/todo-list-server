<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Group;
use App\Models\Table;
use App\Models\Todo;
use App\Models\TodoCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(['name'=>'test','email'=>'test@test.com','password'=>bcrypt('password')]);
        Table::create(['label' =>'testTable','user_id'=>1]);
        Group::create(['label' =>'testGroup','table_id'=>1]);
        Group::create(['label' =>'testGroup2','table_id'=>1]);
        Todo::create(['label' =>'testTodo1','desc' =>'test','percent_done' =>20,'group_id'=>1]);
        Todo::create(['label' =>'testTodo2','desc' =>'test','percent_done' =>20,'group_id'=>1]);
        Todo::create(['label' =>'testTodo3','desc' =>'test','percent_done' =>20,'group_id'=>2]);
        Todo::create(['label' =>'testTodo4','desc' =>'test','percent_done' =>20,'group_id'=>2]);
        Todo::create(['label' =>'testTodo5','desc' =>'test','percent_done' =>20,'group_id'=>2]);
        Category::create(['label' =>'red','table_id'=>1,'color' =>'ff0000']);
        Category::create(['label' =>'golden','table_id'=>1,'color' =>'ffd700']);
        Category::create(['label' =>'blue','table_id'=>1,'color' =>'0000FF']);
        Category::create(['label' =>'green','table_id'=>1,'color' =>'00FF00']);
        TodoCategory::create(['todo_id'=>1,'category_id'=>1]);
        TodoCategory::create(['todo_id'=>1,'category_id'=>2]);
        TodoCategory::create(['todo_id'=>2,'category_id'=>3]);
        TodoCategory::create(['todo_id'=>2,'category_id'=>1]);
        TodoCategory::create(['todo_id'=>3,'category_id'=>1]);
        TodoCategory::create(['todo_id'=>3,'category_id'=>4]);
        TodoCategory::create(['todo_id'=>3,'category_id'=>3]);
        TodoCategory::create(['todo_id'=>4,'category_id'=>2]);
        TodoCategory::create(['todo_id'=>5,'category_id'=>1]);
        TodoCategory::create(['todo_id'=>5,'category_id'=>2]);
    }
}
