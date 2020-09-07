<?php
require_once "../modelos/Persona.php";

$persona = new Persona();

$idpersona = isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]) : ""; 
$tipo_doc = isset($_POST["tipo_doc"])? limpiarCadena($_POST["tipo_doc"]) : "";
$numero_doc = isset($_POST["numero_doc"])? limpiarCadena($_POST["numero_doc"]) : "";
$nombre = isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]) : "";
$apellido = isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]) : "";
$nacionalidad = isset($_POST["nacionalidad"])? limpiarCadena($_POST["nacionalidad"]) : "";
$pueblo_indigena = isset($_POST["pueblo_indigena"])? limpiarCadena($_POST["pueblo_indigena"]) : "";
$etnia = isset($_POST["etnia"])? limpiarCadena($_POST["etnia"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idpersona)) {  
            $rspta = $persona->insertar($tipo_doc, $numero_doc, $nombre, $apellido, $nacionalidad, $pueblo_indigena, $etnia);
            echo $rspta ? "Persona registrada" : "Persona NO pudo ser registra";
        } else { 
            $rspta = $persona->editar($idpersona, $tipo_doc, $numero_doc, $nombre, $apellido, $nacionalidad, $pueblo_indigena, $etnia);
            echo $rspta ? "Persona actualizada" : "Persona NO se pudo actualizar";
        }
    break;
    
    case 'mostrar':
        $rspta = $persona->mostrar($idpersona); 
        // Codificar el resultado utilizando JSON
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta = $persona->listar(); 
        // Vamos a declarar un array
        $data = Array();
        
        while ($reg = $rspta->fetch_object()) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')">
                       <i class="fa fa-pencil"></i></button>'.
                       ' <button class="btn btn-danger" onclick="desactivar('.$reg->idpersona.')">
                       <i class="fa fa-close"></i></button>',
                "1" => $reg->nombre,
                "2" => $reg->apellido,
                "3" => $reg->tipo_doc,
                "4" => $reg->numero_doc
            );
        }
        $results = array(
            "sEcho" => 1, // Informacion para el datatables
            "iTotalRecords" => count($data), // enviamos el total de registros al datatables
            "iTotalDisplayRecords" => count($data), // enviamos el total de registros a visualizar
            "aaData" => $data     // envio el array completo
        );
        echo json_encode($results);
    break;
  
    case 'desactivar':
        $rspta = $persona->desactivar($idpersona);
        echo $rspta ? "Persona eliminada" : "Persona no pudo ser eliminada";
    break;

    /*
    case 'selectCategoria':
        require_once "../modelos/Categoria.php";
        $categoria = new Categoria();
        
        $rspta = $categoria->select();

        while ($reg = $rspta->fetch_object()) {
            echo '<option value='.$reg->idcategoria.'>'.$reg->nombre.'</option>';
        }
        
    break;
    */
}

?>