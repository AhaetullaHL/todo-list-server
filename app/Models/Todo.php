<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class Todo extends Model
{
    use HasFactory, PowerJoins;
    protected $fillable = ['label','desc','percent_done','group_id'];
    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function todoCategories()
    {
        return $this->hasMany(TodoCategory::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'todo_category');
    }
}
