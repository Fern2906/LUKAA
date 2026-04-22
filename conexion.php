<?php

#clase
class Conexion
{
    #Atributos
    private $host;    //localhost o IP
    private $db;      //nombre de la BD -> usuarios
    private $usuario; //usuario de la BD -> root
    private $pass;    //Contraseña del usuario de la BD -> ""
    private $charset; //utf8

    #Constructor
    public function __construct()
    {
        $this->host = 'localhost';
        $this->db = 'lukaa';
        $this->usuario = 'root';
        $this->pass = '';
        $this->charset = 'utf8';
    }

    #Método Conectar
    public function conectar()
    {
        #Conectar a la BD -> PDO
        $com = "mysql:host=".$this->host.";dbname=".$this->db.";charset=".$this->charset;
        $enlace = new PDO($com, $this->usuario, $this->pass);
        return $enlace;
    }      
}
?>
