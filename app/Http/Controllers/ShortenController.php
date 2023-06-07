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
            'newUrl' => 'http://127.0.0.1:8000/api/' . $value
        ]);
    }

    public function redirectToOriginal($value){
        // $value = $request->value;
        $meta = Url_meta::where('value', $value)->first();

        if(!$meta){
            abort(404);
        }

        $url = $meta->url;

        $visitors = new Url_meta([
            'url_id' => $url->id,
            'key' => 'visitors',
            'value' => ''
        ]);

        if(!$url){
            abort(404);
        }
        $visitors_value =  'visitors';
        $old_visitors = Url_meta::where('key', $visitors_value)->where('url_id', $url->id)->orderBy('created_at', 'desc')->first();
        $new_visitors = 0;
        if($old_visitors->value > 0){
            $old = $old_visitors->value + 1;
            $new_visitors = $old;
        }

        if($old_visitors->value < 1){
            $new_visitors = 1;
        }
        

        $visitors = new Url_meta([
            'url_id' => $url->id,
            'key' => 'visitors',
            'value' => $new_visitors
        ]);

        $visitors->save();

        return redirect($url->url);
    }

    public function visitFrequency(Request $request){
        $meta = Url_meta::where('value', $request->value)->first();
        $url = $meta->url;

        $visitors = Url_meta::where('key', 'visitors')->where('url_id', $url->id)->orderBy('created_at', 'desc')->first();
        $visitors_value = $visitors->value;
        
        return response()->json([
            'visits' => $visitors_value
        ]);
    }

    private function checkValue($value){
        $existingMeta = Url_meta::where('value', $value)->first();
        return $existingMeta? true: false;
    }
}