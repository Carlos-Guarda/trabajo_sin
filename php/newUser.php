<?php
include "./connection.php";
include "./header.php";

echo $header_html;
if (!isset($_SESSION['user_id'])) {
  if ($conn) {
    $qry = $conn->query('SELECT * FROM ciudades');
    echo '
     <div class="col-sm-2 mt-1 mb-2"><a class="ms-2" href="./login.php">Volver</a></div>
     <h4 class="ms-2">Registrar usuario:</h4>
     <form action="" method="post" class="ms-2">
     <div class="row mb-3">
        <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="nombre" name="nombre" autofocus required>
        </div>
      </div>
     <div class="row mb-3">
        <label for="apellidos" class="col-sm-2 col-form-label">Apellido:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="apellidos" name="apellidos" required>
        </div>
      </div>
     <div class="row mb-3">
        <label for="nickname" class="col-sm-2 col-form-label">Nickname:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" id="nickname" name="nickname" required>
        </div>
      </div>
     <div class="row mb-3">
        <label for="ciudad" class="col-sm-2 col-form-label">Ciudad:</label>
        <div class="col-sm-4">
          <select class="form-select" name="ciudad" id="ciudad" required>
      <option value="">--Escoge una ciudad--</option>';
    while ($result = mysqli_fetch_array($qry)) {
      echo '<option value="' . $result['idCIUDAD'] . '">' . $result['ciudad'] . '</option>';
    }
    echo '</select>
        </div>
      </div>
     <div class="row mb-3">
        <label for="password" class="col-sm-2 col-form-label">Password:</label>
        <div class="col-sm-4">
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Ingresar usuario</button>
     </form>';
  }

  $nombre = '';
  $apellidos = '';
  $nickname = '';
  $idCiudad = '';
  $password = '';
  $idRol = 2;

  if (!empty($_POST["nombre"]) && !empty($_POST["apellidos"]) && !empty($_POST["nickname"]) && !empty($_POST["ciudad"]) && !empty($_POST["password"])) {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];
    $nickname = $_POST["nickname"];
    $idCiudad = $_POST["ciudad"];
    $password = $_POST["password"];

    $validar = $conn->query("SELECT nickname FROM usuarios WHERE nickname = '$nickname'");

    if (mysqli_num_rows($validar) == 0) {
      $qry2 = $conn->query("INSERT INTO usuarios(nombres, apellidos, nickname, idROL, idCIUDAD) VALUES ('$nombre','$apellidos','$nickname','$idRol','$idCiudad')");

      if ($qry2) {
        $qry3 = $conn->query("SELECT idUSUARIO FROM usuarios WHERE nickname = '$nickname'");
        while ($result = mysqli_fetch_array($qry3)) {
          $qry4 = $conn->query("INSERT INTO contrasenas (contrasena, idUSUARIO) VALUES('" . md5($password) . "','" . $result['idUSUARIO'] . "')");
          if ($qry4) {
            $qry5 = $conn->query("SELECT * FROM ciudades WHERE idCIUDAD = " . $idCiudad);
            $qry6 = $conn->query("SELECT * FROM usuarios WHERE nickname = '$nickname'");
            $city = mysqli_fetch_array($qry5);
            $usuario = mysqli_fetch_array($qry6);
            $_SESSION['user_id'] = $usuario['idUSUARIO'];
            $_SESSION['nickname'] = $nickname;
            $_SESSION['user_rol'] = $idRol;
            $_SESSION['nombres'] = $nombre;
            $_SESSION['apellidos'] = $apellidos;
            $_SESSION['idCiudad'] = $idCiudad;
            $_SESSION['ciudad'] = $city['ciudad'];
            echo '<script language="javascript">alert("Registro Exitoso!!");</script>';
            header("Location: ./login.php");
          }
        }
      }
    } else {
      echo
      '<script language="javascript">alert("ERROR AL REGISTRAR USUARIO. Usuario ya existe. Intente nuevamente.");</script>';
    };
  }
} else {
  header("Location: ./login.php");
}





echo $footer_html;
