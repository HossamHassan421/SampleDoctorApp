<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
//use App\Models\Setting;
//use App\Services\ServiceCategoriesService;
//use App\Services\DynamicPagesService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Session::has('applocale') and array_key_exists(Session::get('applocale'), Config::get('languages'))) {
                $selected_lang=Session::get('applocale');
                App::setLocale($selected_lang);
                $lang = '_' . Session::get('applocale');
            } else {
                $selected_lang=Config::get('app.fallback_locale');
                App::setLocale($selected_lang);
                $lang = '_' . Config::get('app.fallback_locale');
            }
            if($lang == '_ar'){
                $sitelang = 'rtl';
            } else {
                $sitelang = 'ltr';
            }
            \View::share('lang', $lang);
            \View::share('sitelang', $sitelang);
            \View::share('selected_lang', $selected_lang);
            return $next($request);
        });
    }

    protected function parametersToRemove(&$request ,$parameters = []) {
        foreach ($parameters as $parameter) {
            $request->request->remove($parameter);
        }
    }
}
