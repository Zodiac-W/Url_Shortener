<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;


class ZodiacController extends Controller
{
    //
    public function getZodiacSigns (){
        $zodiacSigns = ['Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 'Virgo', 'Libra', 'Scorpio', 'Sagittarius', 'Capricorn', 'Aquarius', 'Pisces'];

        return response()->json(['zodiac_signs' => $zodiacSigns]);
        // return 'Hello';
        
    }
}