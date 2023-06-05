<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Urls extends Model
{
    use HasFactory;

    protected $table = 'user_urls';

    protected $fillable = [
        'user_id', 
        'url_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function url()
    {
        return $this->belongsTo(Urls::class);
    }
}