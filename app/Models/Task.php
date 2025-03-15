<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'description', 'user_id', 'status', 'start_time'];

    // Kullanıcı ile ilişki
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
