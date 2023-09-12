<?php

namespace App\Http\Middleware;

use App\Models\Breadcrumb as ModelsBreadcrumb;
use Closure;
use Illuminate\Http\Request;

class Breadcrumb
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
        // session('breadcrumb')->forget();

        //get current url
        $url = $request->path();
        //get current breadcrumb from session
        $breadcrumb = session('breadcrumb', []);

        // check if current url already exists in breadcrumb
        if (($key = array_search($url, $breadcrumb)) !== false) {
            // remove all elements after the current url
            $breadcrumb = array_slice($breadcrumb, 0, $key + 1);
        } else {
            // check if current url is not equal to default url
            if ($url != '/') {
                // make current url relative to default url
                $url = substr($url, strlen($breadcrumb[0]));
                // add current url to breadcrumb
                array_push($breadcrumb, $url);
            }
        }
        //save breadcrumb to session
        session(['breadcrumb' => $breadcrumb]);

        return $next($request);
    }
}
