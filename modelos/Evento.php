<?php

// Incluimos inicialmente la conexion a la base de datos
require "../config/Conexion.php";

class Evento {
    
    // Implementamos nuestro constructor
    public function __construct(){
    }  

    // Implementamos un metodo para insertar registros
    public function insertar($tipo_doc, $numero_doc, $nombre, $apellido, $nacionalidad, $pueblo_indigena, $etnia) 
    {
        $sql = "INSERT INTO personas (tipo_doc, numero_doc, nombre, apellido, nacionalidad, pueblo_indigena, etnia)
                VALUES ('$tipo_doc', '$numero_doc', '$nombre', '$apellido', '$nacionalidad', '$pueblo_indigena', '$etnia')";
        return ejecutarConsulta($sql);       
    } 

    // Implementamos un metodo para editar registros
    public function editar($idpersona, $tipo_doc, $numero_doc, $nombre, $apellido, $nacionalidad, $pueblo_indigena, $etnia) 
    {
        $sql = "UPDATE personas SET idpersona='$idpersona', tipo_doc='$tipo_doc', numero_doc='$numero_doc', nombre='$nombre', 
                apellido='$apellido', nacionalidad='$nacionalidad', pueblo_indigena='$pueblo_indigena', etnia='$etnia'
                WHERE idpersona='$idpersona'"; 
        return ejecutarConsulta($sql);       
    } 

    // Implementamos un metodo para mostrar los datos de un registro a modificar
    public function mostrar($idpersona) 
    {
        $sql = "SELECT * FROM personas WHERE idpersona='$idpersona'";
        return ejecutarConsultaSimpleFila($sql);       
    } 

    // Implementamos un metodo para listar los registros
    public function listar() 
    {
        $sql = "SELECT idpersona, nombre, apellido, tipo_doc, numero_doc
                FROM personas";
        return ejecutarConsulta($sql);        
    }
}


?>