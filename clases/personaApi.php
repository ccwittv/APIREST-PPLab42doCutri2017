<?php
require_once 'persona.php';
require_once 'IApiUsable.php';
//use Slim\Http\Request;
//use Slim\Http\Response;
//use Slim\Http\UploadedFile;

class personaApi extends persona implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
        $laPersona=persona::TraerUnaPersona($id);
        if(!$laPersona)
        {
            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->error="No esta La Persona";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500); 
        }else
        {
            $NuevaRespuesta = $response->withJson($laPersona, 200); 
        }     
        return $NuevaRespuesta;
    }
     public function TraerTodos($request, $response, $args) {
      	$todasLasPersonas=persona::TraerTodasLasPersona();
     	$newresponse = $response->withJson($todasLasPersonas, 200);  
    	return $newresponse;
    }
      public function CargarUno($request, $response, $args) {
     	
        $objDelaRespuesta= new stdclass();
        
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $nombre= $ArrayDeParametros['nombre'];
        $apellido= $ArrayDeParametros['apellido'];
        $mail= $ArrayDeParametros['mail'];
        $sexo= $ArrayDeParametros['sexo'];
        $foto= $ArrayDeParametros['foto'];
        $password= $ArrayDeParametros['password'];
        
        $mipersona = new persona();
        $mipersona->nombre=$nombre;
        $mipersona->apellido=$apellido;
        $mipersona->mail=$mail;
        $mipersona->sexo=$sexo;
        $mipersona->foto=$foto;
        $mipersona->password=$password;
        $mipersona->InsertarPersonaParametros();
        $archivos = $request->getUploadedFiles();
        $destino="../fotos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);
        if(isset($archivos['foto']))
        {
            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior)  ;
            //var_dump($nombreAnterior);
            $extension=array_reverse($extension);
            $archivos['foto']->moveTo($destino.$nombre.$apellido.".".$extension[0]);
        }       
        //$response->getBody()->write("se guardo el cd");
        $objDelaRespuesta->respuesta="Se guardo la Persona.";   
        return $response->withJson($objDelaRespuesta, 200);
    }
      public function BorrarUno($request, $response, $args) {
     
      /*if (isset($args['id'])
        {
         $id=$args['id'];
        } 
      else
        {
         $ArrayDeParametros = $request->getParsedBody();
         $id=$ArrayDeParametros['id'];
        }  */

      $id=$args['id'];

     	$persona= new persona();
     	$persona->id=$id;
     	$cantidadDeBorrados=$persona->BorrarPersona();

     	$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->cantidad=$cantidadDeBorrados;
	    if($cantidadDeBorrados>0)
	    	{
	    		 $objDelaRespuesta->resultado="algo borro!!!";
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="no Borro nada!!!";
	    	}
	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
    }
     
     public function ModificarUno($request, $response, $args) {
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);    	
	    $mipersona = new persona();
	    $mipersona->id=$ArrayDeParametros['id'];
	    $nombre= $ArrayDeParametros['nombre'];
        $apellido= $ArrayDeParametros['apellido'];
        $mail= $ArrayDeParametros['mail'];
        $sexo= $ArrayDeParametros['sexo'];
        $password= $ArrayDeParametros['password'];

	   	$resultado =$mipersona->ModificarPersonaParametros();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
        $objDelaRespuesta->tarea="modificar";
		return $response->withJson($objDelaRespuesta, 200);		
    }


}