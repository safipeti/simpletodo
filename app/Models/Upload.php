<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = ['orig_filename', 'filename'];

    public function todo()
    {
        return $this->belongsTo(Todo::class, 'todo_id');
    }
}
