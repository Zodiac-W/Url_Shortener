<?php

namespace App\Http\Controllers;

use App\Models\Url_meta;
use App\Models\Urls;
use App\Models\User_Urls;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShortenController extends Controller
{
    //
    public function shorten(Request $request){
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

        $value = $request->value;

        if($this->checkValue($value)){
            return response()->json([
                'message' => 'This value is already taken'
            ]);
        }

        $meta = new Url_meta([
            'url_id' => $url->id,
            'key' => $request->key,
            'value' => $value
        ]);

        $meta->save();

        return response()->json([
            'new-url' => 'http://127.0.0.1:8000/api/' . $value
        ]);
    }

    public function redirectToOriginal($value){
        // $value = $request->value;
        $meta = Url_meta::where('value', $value)->first();

        if(!$meta){
            abort(404);
        }

        $url = $meta->url;

        if(!$url){
            abort(404);
        }

        return redirect($url->url);
    }

    private function checkValue($value){
        $existingMeta = Url_meta::where('value', $value)->first();
        return $existingMeta? true: false;
    }
}