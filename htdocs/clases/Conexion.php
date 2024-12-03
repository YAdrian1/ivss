<?php 

	class conectar{
		private $servidor="localhost";
		private $usuario="root";
		private $password="171256ad";
		private $bd="ivss";

		public function conexion(){
			$conexion=mysqli_connect($this->servidor,
									 $this->usuario,
									 $this->password,
									 $this->bd);
			return $conexion;
		}
	}


 ?>