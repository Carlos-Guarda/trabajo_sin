<?php
include "./connection.php";
include "./header.php";

echo $header_html;

if ($conn) {
  $qry = $conn->query('SELECT * FROM marcas');
  echo '<br>';
  echo '<div class="col-sm-2">&nbsp<a href="../index.php">Volver</a></div>';
  echo '<br>';
  echo '<form action="" method="post" enctype="multipart/form-data">';
  echo '<div class="row mb-3">';
  echo    '<label for="producto" class="col-sm-2 col-form-label">Producto:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<input type="text" class="form-control" id="producto" name="producto" autofocus required>';
  echo    '</div>';
  echo  '</div>';
  echo '<div class="row mb-3">';
  echo    '<label for="precio" class="col-sm-2 col-form-label">Precio:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<input type="number" class="form-control" id="precio" name="precio" required>';
  echo    '</div>';
  echo  '</div>';
  echo '<div class="row mb-3">';
  echo    '<label for="imagen" class="col-sm-2 col-form-label">Imagen:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<input type="file" accept="image/*" class="form-control" id="imagen" name="imagen" required>';
  echo    '</div>';
  echo  '</div>';
  echo '<div class="row mb-3">';
  echo    '<label for="descripcion" class="col-sm-2 col-form-label">Descripción:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<input type="text" class="form-control" id="descripcion" name="descripcion" required>';
  echo    '</div>';
  echo  '</div>';
  echo '<div class="row mb-3">';
  echo    '<label for="marca" class="col-sm-2 col-form-label">Marca:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<select class="form-select" name="marca" id="marca" required>';
  echo  '<option value="">--Escoge una marca--</option>';
  while ($result = mysqli_fetch_array($qry)) {
    echo '<option value="' . $result['idMARCA'] . '">' . $result['marca'] . '</option>';
  }
  echo '</select>';
  echo    '</div>';
  echo  '</div>';
  echo  '<button type="submit" class="btn btn-primary">Ingresar producto</button>';
  echo '</form>';
}

$producto = '';
$precio = '';
#$imagen = '';
$descripcion = '';
$marca = '';

if (!empty($_POST["producto"]) && !empty($_POST["precio"]) && !empty($_POST["descripcion"]) && !empty($_POST["marca"])) {
  /* echo '<script language="javascript">alert("Registro Exitoso!!");</script>'; */
  $GLOBALS['producto'] = $_POST["producto"];
  $GLOBALS['precio'] = $_POST["precio"];
  $filename = $_FILES["imagen"]["name"];
  $tempname = $_FILES["imagen"]["tmp_name"];
  $folder = "../img/" . $filename;
  $GLOBALS['descripcion'] = $_POST["descripcion"];
  $GLOBALS['marca'] = $_POST["marca"];

  $validar = $conn->query("SELECT producto FROM productos WHERE producto = '$producto'");

  if (mysqli_num_rows($validar) == 0) {
    $qry2 = $conn->query("INSERT INTO productos (producto, precio, imagen, descProducto, idMARCA) VALUES ('$producto','$precio','$filename','$descripcion','$marca')");
    if ($qry2) {
      move_uploaded_file($tempname, $folder);
      echo '<script language="javascript">alert("Registro Exitoso!!");</script>';
    }
  } else {
    echo
    '<script language="javascript">alert("ERROR AL REGISTRAR PRODUCTO. Producto ya existe. Intente nuevamente.");</script>';
  };
}










echo $footer_html;