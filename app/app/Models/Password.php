<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Password extends Model
{
    use HasFactory;

    protected $fillable = ['site', 'login', 'password', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
