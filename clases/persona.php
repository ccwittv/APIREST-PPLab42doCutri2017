<?php
class persona
{
	public $id;
 	public $nombre;
  	public $apellido;
  	public $mail;
  	public $sexo;
    public $foto;
    public $password;

  	public function BorrarPersona()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from persona 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }

	public static function BorrarPersonaPorMail($año)
	 {

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from persona 				
				WHERE mail=:mail");	
				$consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);		
				$consulta->execute();
				return $consulta->rowCount();

	 }
	public function ModificarPersona()
	 {

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update persona
				set nombre='$this->nombre',
				apellido='$this->apellido',
				mail='$this->mail',
				sexo='$this->sexo',
				foto='$this->foto',
				password='$this->password'
				WHERE id='$this->id'");
			return $consulta->execute();

	 }
	
  
	 public function InsertarPersona()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into persona (nombre,apellido,mail,sexo,foto,password)values('$this->nombre','$this->apellido','$this->mail','$this->sexo','$this->foto','$this->password')");
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
				

	 }

	  public function ModificarPersonaParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update persona 
				set nombre=:nombre,
				apellido=:apellido,
				mail=:mail,
				sexo=:sexo,
				foto=:foto',
				password=:password
				WHERE id=:id");
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
			$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
			$consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
			$consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
			$consulta->bindValue(':sexo',$this->sexo, PDO::PARAM_STR);
			$consulta->bindValue(':foto',$this->foto, PDO::PARAM_STR);
			$consulta->bindValue(':password',$this->password, PDO::PARAM_STR);
			return $consulta->execute();
	 }

	 public function InsertarPersonaParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into persona (nombre,apellido,mail,sexo,foto,password)values(:nombre,:apellido,:mail,:sexo,:foto,:password)");
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
				$consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
				$consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
				$consulta->bindValue(':sexo',$this->sexo, PDO::PARAM_STR);
				$consulta->bindValue(':foto',$this->foto, PDO::PARAM_STR);
				$consulta->bindValue(':password',$this->password, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }
	 public function GuardarPersona()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarPersonaParametros();
	 		}else {
	 			$this->InsertarPersonaParametros();
	 		}

	 }


  	public static function TraerTodasLasPersona()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, apellido, mail, sexo, foto from persona");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "persona");		
	}

	public static function TraerUnaPersona($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, apellido, mail, sexo, foto, password from persona where id = $id");
			$consulta->execute();
			$personaBuscada= $consulta->fetchObject('persona');
			return $personaBuscada;				
			
	}

	public static function TraerUnaPersonaMailArray($id,$mail) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre, apellido, mail, sexo, foto, password from persona  WHERE id=? AND mail=?");
			$consulta->execute(array($id, $mail));
			$personaBuscada= $consulta->fetchObject('persona');
      		return $personaBuscada;				

			
	}

	public static function TraerUnaPersonaParamSexo($id,$sexo) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre, apellido, mail, sexo, foto, password from persona WHERE id=:id OR sexo=:sexo");
			$consulta->bindValue(':id', $id, PDO::PARAM_INT);
			$consulta->bindValue(':sexo', $sexo, PDO::PARAM_STR);
			$consulta->execute();
			$personaBuscada= $consulta->fetchObject('persona');
      		return $personaBuscada;				

			
	}
	
	public static function TraerUnaPersonaParamNombreApellidoArray($nombre,$apellido) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select nombre, apellido, mail, sexo, foto, password from persona  WHERE nombre=:nombre OR apellido=:apellido");
			$consulta->execute(array(':nombre'=> $nombre,':apellido'=> $apellido));
			$consulta->execute();
			$personaBuscada= $consulta->fetchObject('persona');
      		return $personaBuscada;				

			
	}

	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->nombre."  ".$this->apellido."  ".$this->mail." ".$this->sexo;
	}

}