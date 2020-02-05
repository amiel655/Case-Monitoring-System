<?php
namespace App\Http\Middleware;
use Closure;
class checkUser
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
        if ($request->user_id !== auth()->user()->id)
        {
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
