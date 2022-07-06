<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App;

class LanguageMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = $request->header('lang') ? $request->header('lang') : 'ar';
 
        $availLocale=['en','ar'];

        // $session = $request->getSession();
        $cookie = isset($_COOKIE["language"])?$_COOKIE["language"]:"";
        // dd($cookie);
        if(in_array($cookie,$availLocale)){
            App::setLocale($lang);
        }if ($cookie && in_array($cookie,$availLocale)) {
            App::setLocale($cookie);
        }else{
            App::setLocale('ar');
        }
        return $next($request);
    }
}
