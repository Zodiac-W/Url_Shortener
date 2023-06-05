<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urls extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url'
    ];

    public function userUrls()
    {
        return $this->hasMany(User_Urls::class);
    }

    public function meta()
    {
        return $this->hasMany(Url_meta::class);
    }
}