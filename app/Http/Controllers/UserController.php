<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class UserController extends Controller
{

     public function index()
     {

          $user = User::all();

          return response()->json([
               'code' => 200,
               'status' => 'success',
               'users' => $user
          ]);
     }

     public function register(Request $request)
     {

          //Recoger los datos del usuario por post

          $json = $request->input('json', null);
          $params = json_decode($json);
          $params_array = json_decode($json, true); //array

          //validar si no envian nada

          if (!empty($params_array)) {


               //Limpiar datos
               $params_array = array_map('trim', $params_array);


               //Validar los datos

               $validate = \Validator::make($params_array, [

                    'User_Name'         => 'required',
                    'User_Apellido'     => 'required',
                    'contrasena'        => 'required',
                    'User_Contrasena'   => 'required',
                    'Perfil_User'       => 'required',
                    'User_Email'        => 'required|User_Email|unique:t_users'

               ]);

               if ($validate->fails()) {

                    $data = array(
                         'code' => 404,
                         'status' => 'error',
                         'mensaje' => 'Datos del usuario erroneos.',
                         'error' => $validate->errors()
                    );
               } else {

                    //cifrado de contraseña

                    $pwd = hash('sha256', $params->contrasena);
                    //crear el usuario
                    $user = new User();

                    $user->User_Name         = $params_array['User_Name'];
                    $user->User_Apellido     = $params_array['User_Apellido'];
                    $user->User_Contrasena   = $pwd;
                    $user->Perfil_User       = $params_array['Perfil_User'];
                    $user->Perfil_Descr	     = $params_array['Perfil_Descr'];
                 
                    $user->User_Email        = $params_array['User_Email'];
                    $user->User_Descripcion  = $params_array['User_Descripcion'];


                    //Guardar El usuario

                    $user->save();

                    $data = array(
                         'code' => 200,
                         'status' => 'success',
                         'mensaje' => 'se ha a creado correctamente el usuario.',
                         'usuario' => $user
                    );
               }
          } else {
               $data = array(
                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Los datos enviados no son los correctos.',
                    'data' => $json
               );
          }



          return response()->json($data, $data['code']);
     }

     public function login(Request $request)
     {
          $jwtAuth = new \JwtAuth();

          //Resivir el Post
          $json = $request->input('json', null);
          $params = json_decode($json); //objeto
          $params_array = json_decode($json, true); //array    
          //Validar esos datos
          $validate = \Validator::make($params_array, [


               'User_Email'        => 'required',
               'User_Contrasena'   => 'required'



          ]);
          if ($validate->fails()) {

               $signup = array(
                    'code' => 404,
                    'status' => 'error',
                    'mensaje' => 'El usuario no se ha podido identificar.',
                    'error' => $validate->errors()
               );
          } else {
               //Cifrar la contraseña
               $pwd = hash('sha256', $params->contrasena);
               //Devolver token o datos
               $signup = $jwtAuth->signup($params->email, $pwd);
               if (!empty($params->gettoken)) {
                    $signup = $jwtAuth->signup($params->email, $pwd, true);
               }
          }


          return response()->json(($signup), 200);
     }

     public function update(Request $request)
     {

          //COMPROBAR SI EL USUARIO ESTA IDENTIFICADO  

          $token = $request->header('Authorization');
          $jwtAuth = new \JwtAuth();
          $checkToken = $jwtAuth->checkToken($token);


          //recoger los datos por post
          $json = $request->input('json', null);
          $params_array = json_decode($json, true);

          if ($checkToken && !empty($params_array)) {



               //sacar usuario identificado

               $user = $jwtAuth->checkToken($token, true);

               //Validar los datos

               $validate = \validator($params_array, [

                    'User_Name'       => 'required|alpha',
                    'User_Apellido'   => 'required|alpha',
                    'User_Contrasena' => 'required',


                    //comprobar si el email esta duplicado
                    'User_Email'       => 'required|User_Email|unique:t_users,' . $user->sub

               ]);

               //quitar los campos que no quiero actualizar

               unset($params_array['id']);
               unset($params_array['Perfil_User']);
               // unset($params_array['empresa_id']);
               unset($params_array['created_at']);
               unset($params_array['User_Contrasena']);
               unset($params_array['remember_token']);
               //actualizar el usuario en la base de datos

               $user_update = User::where('id', $user->sub)->update($params_array);
               //devolver un array

               $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'mensaje' => 'Usuario actualizado.',
                    'user' => $user,
                    'changes' => $params_array
               );
          } else {
               $data = array(
                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'El usuario no esta identificado o no has enviado ningun dato.',
                    'data' => $params_array
               );
          }
          return response()->json($data, $data['code']);
     }

     public function upload(Request $request)
     {

          //Recoger los datos de la peticion

          $image = $request->file('file0');


          //Validacion de la image

          $validate = \Validator::make($request->all(), [
               'file0' => 'required|User_Ruta_Imagen|mimes:jpg,jpeg,png'
          ]);

          //subir imagen y guardar la imagen
          if (!$image || $validate->fails()) {

               $data = array(
                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'Error al subir imagen.',
               );
          } else {

               $image_name = time() . $image->getClientOriginalName();
               \Storage::disk('users')->put($image_name, \File::get($image));

               $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'image' => $image_name


               );
          }
          return response()->json($data, $data['code']);
     }


     public function getImage($filename)
     {

          $isset = \Storage::disk('users')->exists($filename);

          if ($isset) {

               $file = \Storage::disk('users')->get($filename);

               return new  Response($file);
          } else {
               $data = array(
                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No existe la imagen:' . $filename
               );
               return response()->json($data, $data['code']);
          }
     }

     public function detail($id)
     {

          $user = User::find($id);

          if (is_object($user)) {

               $data = array(
                    'code' => 200,
                    'status' => 'success',
                    'user' => $user
               );
          } else {
               $data = array(
                    'code' => 400,
                    'status' => 'error',
                    'mensaje' => 'No existe el usuario.'
               );
          }
          return response()->json($data, $data['code']);
     }
     public function delete($id)
     {

          $dt = User::find($id);
          if (!empty($dt)) {

               $dt->delete();
               $data = [

                    'code'      => 200,
                    'status'    => 'success',
                    'mensaje'   => 'Se ha eliminado el dato con exito',
                    'data'      => $dt

               ];
          } else {

               $data = [
                    'code' => 404,
                    'status' => 'error',
                    'mensaje' => 'No existe ese elemento'
               ];
          }
          return response()->json($data, $data['code']);
     }
}
