<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;

class Table extends Model
{
    use HasFactory, PowerJoins;
    protected $fillable = ['label','user_id'];
    protected $primaryKey = 'id';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
