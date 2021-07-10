<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;


class JwtAuth
{
   
    public $key;

    public function __construct()
    {
        $this->key = "Me'r'cu!@&oFt¡";
    }

    public function signUp($email, $contrasena, $getToken = null)
    {

        //Buscar si existe el usuario con sus credenciales Email y password
        $user = User::where([
            'email' => $email,
            'contrasena' => $contrasena
        ])->first();
        //Comprobar si son correctos
        $signup = false;
        if (is_object($user)) {
            $signup = true;
        }

        //Generar el token con los datos del usuario identificado
        if ($signup) {
            $token = array(
                'sub'           => $user->id,
                'email'         => $user->email,
                'nombres'       => $user->nombres,
                'apellidos'     => $user->apellidos,
                'perfil_id'     => $user->perfil_id,
                'iat'           => time(),
                'exp'           => time() + (7 * 24 * 60 * 60)
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');

            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
            //Devolver los datos decodificados o el token en funcion de un parametro
            if (is_null($getToken)) {
                $data =  $jwt;
            } else {
                $data =  $decoded;
            }
        } else {
            $data = array(
                'code' => 404,
                'status' => 'error',
                'mensaje' => 'Login Incorrecto'

            );
        }

        return $data;
    }

    public function checkToken($jwt, $getIdentity = false)
    {

        $auth = false;
        try {
            $jwt = str_replace('"','',$jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        } catch (\DomainException $e) {
            $auth = false;
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->sub)) {
            $auth = true;
        } else {
            $auth = false;
        }
        if($getIdentity){
            return $decoded;
        }

        return $auth;
    }
}
