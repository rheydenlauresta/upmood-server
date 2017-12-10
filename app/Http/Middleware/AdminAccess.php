<?php

namespace App\Http\Middleware;

use Closure;

class AdminAccess
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
        if(request()->user()->api_token != 'TaisonAPI-a0XbCZeTxi1zW9sU5Y2GoQf1M0G55m3JNPrHNH96JSJNpj2SOwaMUggW5V9U'){

            $data = [
                'status'   => (int) env('NON_AUTHORITATIVE_CODE'),
                'messagge' => 'Non Authoritative Token',
                'module'   => 'user_signin',
                'errors'   => [],
                'data'     => [],
            ];

            return response()->json($data, (int) env('NON_AUTHORITATIVE_CODE'));

        }

        return $next($request);
    }
}
