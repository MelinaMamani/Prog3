<?php
require_once "AutentificadorJWT.php";

class MWparaAutentificar
{
	public function VerificarUsuario($request, $response, $next) {
		//$arrayConToken = $request->getHeader('token');
		//$token = isset($arrayConToken[0]) ? $arrayConToken[0] : null;
		if(isset($request->getHeader('token')[0])) // si hay token en el header
		{
			$token = $request->getHeader('token')[0];
		}
		else
		{
			$error = array('tipo' => 'acceso', 'descripcion' => "Acceso denegado.");
			return $response->withJson( $error , 403);
		}
	
		try
		{
			AutentificadorJWT::VerificarToken($token);

			$newResponse = $next($request, $response);
		}
		catch (Exception $e) 
		{
			$textoError="error ".$e->getMessage();
			$error = array('tipo' => 'acceso','descripcion' => $textoError);
			$newResponse = $response->withJson( $error , 403); 
		}
		
		return $newResponse;
	}
	
	public function contadorLogin($request, $response, $next) {
		try
		{
			$count = file_get_contents("contadorLogin.txt");
			$count++;
			file_put_contents("contadorLogin.txt", $count);

			$token = apache_request_headers()["token"];
			$usuario = json_decode(MWparaAutentificar::VerificarToken($token));

			$file = fopen("Logins.txt", "a");
			$data = date("d/m/y h:i:s");
			$data .= " => ". $usuario->nombre . " ". $usuario->apellido ."\r\n";
			fwrite($file, $data);

			fclose($file);

			$newResponse = $next($request, $response);
		}
		catch (Exception $e) 
		{
			$textoError="error ".$e->getMessage();
			$error = array('tipo' => 'acceso','descripcion' => $textoError);
			$newResponse = $response->withJson( $error , 403); 
		}
		
		return $newResponse;
	}

	public static function VerificarToken($token) {
		try
		{
			$payload = AutentificadorJWT::ObtenerPayLoad($token);
			
			$response = json_encode($payload->data);
		} 
		catch (Exception $e)
		{
			$textoError = "error ".$e->getMessage();
			$error = array('tipo' => 'acceso','descripcion' => $textoError);
			$response = json_encode($error);
		}

		return $response;   
	}
}