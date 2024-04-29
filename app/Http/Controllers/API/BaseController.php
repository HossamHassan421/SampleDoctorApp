<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class BaseController extends Controller
{
    public function __construct(Request $request)
    {
        if ($request->header('lang') != null&&($request->header('lang') =='en')||$request->header('lang') =='ar') {
            $lang =  $request->header('lang');
            App::setLocale($lang);
        }
    }

}
