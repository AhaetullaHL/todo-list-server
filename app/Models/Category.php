<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class Category extends Model
{
    use HasFactory, PowerJoins;
    protected $fillable = ['label','color','table_id'];
    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function categoryTodos()
    {
        return $this->hasMany(TodoCategory::class);
    }
}
