<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">

    <!-- Referencia de CSS -->
    <link href="css/estilos.css" rel="stylesheet" type="text/css">

    <title>Fase2 Pagina web!</title>
</head>

<body>

    <div class="container fondo">
        <h1>Hello, world! GG </h1>
        <h1 class="text-center">La wea punto.com</h1>
        <h1 class="text-center">Menu</h1>

        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <!-- Button trigger Crear -->
                    <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal"
                        data-bs-target="#modalUsuario" id="botonCrear">
                        <i class="bi bi-plus-circle-fill"></i> Crear
                    </button>
                </div>
            </div>
        </div>

        <!-- Saltos de linea -->
        <br />
        <br />

        <div class="table-responsive">
            <table id="datos_usuario" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <!-- Campos de empleados - Solo Diseño -->
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Documento de Identidad</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Imagen</th>
                        <th>Fecha Creación</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Envio de datos -->

                <form method="POST" id="formulario" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-body">
                            <!-- Nombre -->
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control">
                            <br />

                            <!-- Apellidos -->
                            <label for="apellidos">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control">
                            <br />

                            <!-- Documento de Identidad -->
                            <label for="documento">Documento de Identidad</label>
                            <input type="text" name="documento" id="documento" class="form-control">
                            <br />

                            <!-- Dirección -->
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" id="direccion" class="form-control">
                            <br />

                            <!-- Teléfono -->
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" class="form-control">
                            <br />

                            <!-- Foto -->
                            <label for="imagen">Ingrese una imagen</label>
                            <input type="file" name="imagen_usuario" id="imagen_usuario" class="form-control">
                            <span id="imagen-subida"></span>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id_usuario" id="id_usuario">
                            <input type="hidden" name="operacion" id="operacion">
                            <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Jquery JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- DataTable JS -->
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>


    <!-- Funcion de documento -->
    <script type="text/javascript">
    $(document).ready(function() {
        $("#botonCrear").click(function() {
            $("#formulario")[0].reset();
            $(".modal-title").text("Crear Usuario");
            $("#action").val("Crear");
            $("#operacion").val("Crear");
            $("#imagen_subida").html("");
        });

        var dataTable = $('#datos_usuario').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "obtener_registros.php",
                type: "POST"
            },
            "columnsDefs": [{
                "targets": [0, 3, 4],
                "orderable": false,
            }, ]
        });

        // Insercion de los datos
        $(document).on('submit', '#formulario', function(event) {
            event.preventDefault();
            var nombre = $('#nombre').val();
            var apellido = $('#apellidos').val();
            var documento = $('#documento').val();
            var direccion = $('#direccion').val();
            var telefono = $('#telefono').val();
            var extension = $('#imagen_usuario').val().split('.').pop().toLowerCase();
            // Validacion de imagen
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert("Formato de imagen invalido");
                    $('#imagen_usuario').val('');
                    return false;
                }
            }

            // Validacion de campos para que no queden vacios
            if (nombre != '' && apellido != '' && documento != '' && direcion != '' && telefono != '') {
                $.ajax({
                    url: "crear.php",
                    method: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        alert(data);
                        $('#formulario')[0].reset();
                        $('#modalUsuario').modal('hide');
                        dataTable.ajax.reload();
                    }
                });
            } else {
                alert("Todos los campos son obligatorios");
            }
        });

        //funcionalidad de editar
        $(document).on('click','.editar',function(){
            var id_usuario = $(this).attr("id");
            $.ajax({
                url:"obtener_registro.php",
                method:"POST",
                data:{id_usuario:id_usuario},
                dataType:"json",
                success:function(data)
                {
                    //console.log(data);
                    $('#modalUsuario').modal('show');
                    $('#nombre').val(data.nombre);
                    $('#apellidos').val(data.apellidos);
                    $('#telefono').val(data.telefono);
                    $('#email').val(data.email);
                    $('.modal-title').text("Editar Usuario");
                    $('#id_usuario').val(id_usuario);
                    $('#imagen_subida').html(data.imagen_usuario);
                    $('#action').val("Editar");
                    $('#operacion').val("Editar");

                },
                error:function(jqXHR, textStatus, errorThrowm){
                    console.log(texStatus, errorThrom);
                }
                    
            })
                
        });
    
    </script>

</body>

</html>