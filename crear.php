<?php

    // Conexion con los elementos php
    include("conexion.php");
    include("funciones.php");

    if ($_POST["operacion"] = "Crear") {
        $imagen = '';
        if ($_FILES["imagen_usuario"]["name"] != ''){
            $_imagen = subir_imagen();
        }
        $stmt = $conexion->prepare("INSERT INTO usuarios(nombre,
        apellidos, documento, direccion, telefono, imagen) VALUES (:nombre,
        :apellidos, :documento, :direccion, :telefono, :imagen)");

        $resultado = $stmt->execute(
            array(
                ':nombre'       => $_POST["nombre"],
                ':apellidos'    => $_POST["apellidos"],
                ':documento'    => $_POST["documento"],
                ':direccion'    => $_POST["direccion"],
                ':telefono'     => $_POST["telefono"],
                ':imagen'       => $imagen
            )
        );

        if(!empty($resultado)){
            echo 'Registro creado';
        }
    }
