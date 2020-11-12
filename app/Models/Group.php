<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class Group extends Model
{
    use HasFactory, PowerJoins;
    protected $fillable = ['label','table_id'];
    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
}
