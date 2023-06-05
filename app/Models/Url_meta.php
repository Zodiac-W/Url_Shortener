<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url_meta extends Model
{
    use HasFactory;

    protected $table = 'url_meta';

    protected $fillable = [
        'url_id',
        'key',
        'value'
    ];

    public function url()
    {
        return $this->belongsTo(Urls::class);
    }

    
}