<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
