<?php

namespace App\Http\Middleware;

use Closure;

class RequireCampaign
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Session::has('campaign')){
            return $next($request);
        } else {
            return redirect(action('CampaignsController@index'));
        }
    }
}
