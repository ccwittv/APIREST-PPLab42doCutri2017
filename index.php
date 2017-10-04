<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require '/composer/vendor/autoload.php';
require_once '/clases/AccesoDatos.php';
require_once '/clases/personaApi.php';
//require_once '/clases/usuarioApi.php';
//require_once '/clases/loginApi.php';
//require_once '/clases/AutentificadorJWT.php';
require_once '/clases/MWparaCORS.php';
//require_once '/clases/MWparaAutentificar.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*

¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);



/*LLAMADA A METODOS DE INSTANCIA DE LA CLASE personaApi*/
$app->group('/persona', function () {
 
  $this->get('/', \personaApi::class . ':traerTodos');
 
  $this->get('/{id}', \personaApi::class . ':traerUno');

  $this->post('/', \personaApi::class . ':CargarUno');

  $this->delete('/', \personaApi::class . ':BorrarUno');

  $this->put('/', \pesonaApi::class . ':ModificarUno');
     
})->add(\MWparaCORS::class . ':HabilitarCORSTodos');


$app->run();