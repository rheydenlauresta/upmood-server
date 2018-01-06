<?php

namespace App\Http\Middleware;

use Closure;

class AccountStatus
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
        if(request()->user()->deleted == 1){

            $data = [
                'status'   => (int) env('INACTIVE_CODE'),
                'messagge' => 'Inactive Account',
                'module'   => 'user_signin',
                'errors'   => [],
                'data'     => [],
            ];

            return response()->json($data, (int) env('INACTIVE_CODE'));

        }

        return $next($request);
    }
}
