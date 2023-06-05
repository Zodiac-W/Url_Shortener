<?php

namespace App\Http\Controllers;

use App\Models\Urls;
use App\Models\User_Urls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserUrlController extends Controller
{
    public function store(Request $request){
        $user = Auth::guard('sanctum')->user();
        
        $url = new Urls([
            'url' => $request->url
        ]);

        $url->save();

        $user_url = new User_Urls([
            'user_id' => $user->id,
            'url_id' => $url->id
        ]);

        $user_url->save();
        
        return response()->json(['message' => 'URL created successfully'], 201);
    }
}