<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'todos';
    protected $fillable = ['name', 'description', 'due', 'done'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function uploadedFiles()
    {
        return $this->hasMany(Upload::class, 'todo_id');
    }
}
