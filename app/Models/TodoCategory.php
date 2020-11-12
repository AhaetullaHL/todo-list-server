<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class TodoCategory extends Model
{
    use HasFactory, PowerJoins;
    protected $fillable = ['category_id','todo_id'];
    protected $table = 'todo_category';
    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
