<?php

include("conexion.php");
include("funciones.php");

if (isset($_POST["id_usuario"])){
    $salida = array();
    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = '".$_POST["id_usuario"].
    "' LIMIT 1");
    $stmt ->execute();
    $resultado = $stmt ->fetchALL();
    foreach($resultado as $fila){
        $salida["Nombre"] = $fila["Nombre"];
        $salida["Apellidos"] = $fila["Apellidos"];
        $salida["Documento de identidad"] = $fila["Documento de identidad"];
        $salida["Direccion"] = $fila["Direccion"];
        $salida["Telefono"] = $fila["Telefono"];
        if ($fila["imagen"] != "" ){
            $salida["imagen_usuario"] = '<img src="img/'. $fila["imagen"] . ' "
            class="img-thumbnail"width="100" height="50" /><input type= "hidden"
            name="imagen_usuario_oculta" value=" '.$fila ["imagen"].'"';            
        }else{
            $salida["imagen_usuario"] ='<input type= "hidden"
            name="imagen_usuario_oculta" value=" '.$fila ["imagen"].'"';
        }

    }

    echo json_encode($salida);
}