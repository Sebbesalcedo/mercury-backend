<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\VarDumper\VarDumper;

class ApiAuthMiddleware
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
      
        //COMPROBAR SI EL USUARIO ESTA IDENTIFICADO  

        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        
        if ($checkToken) {
            return $next($request);
        } else {
            $data = array(
                'code' => 400,
                'status' => 'error',
                'mensaje' => 'El usuario no esta identificado.',
            );
            return response()->json($data, $data['code']);
        }
    }
}
