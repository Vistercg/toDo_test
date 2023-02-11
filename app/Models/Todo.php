<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    public function tags()
    {
        return $this->belongsToMany(Tag::class); //пост может иметь много тегов
    }

    public function user()
    {
        return $this->belongsTo(Todo::class);
    }

    protected $fillable = [
        'name',
        'description',
        'status',
        'image'
    ];
}
