<?php
include "./connection.php";
include "./header.php";

echo $header_html;

if ($conn) {
  $qry = $conn->query('SELECT * FROM ciudades');
  $qry2 = $conn->query('SELECT * FROM locales');
  echo '<br>';
  echo '<div class="col-sm-2">&nbsp<a href="../index.php">Volver</a></div>';
  echo '<br>';
  echo '<form action="" method="post" enctype="multipart/form-data">';
  echo '<div class="row mb-3">';
  echo    '<label for="local" class="col-sm-2 col-form-label">Local:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<input type="text" class="form-control" id="local" name="local" autofocus required>';
  echo    '</div>';
  echo  '</div>';
  echo '<div class="row mb-3">';
  echo    '<label for="ciudad" class="col-sm-2 col-form-label">Ciudad:</label>';
  echo    '<div class="col-sm-4">';
  echo      '<select class="form-select" name="ciudad" id="ciudad" required>';
  echo  '<option value="">--Escoge una ciudad--</option>';
  while ($result = mysqli_fetch_array($qry)) {
    echo '<option value="' . $result['idCIUDAD'] . '">' . $result['ciudad'] . '</option>';
  }
  echo '</select>';
  echo    '</div>';
  echo  '</div>';
  echo  '<button type="submit" class="btn btn-primary">Ingresar local</button>';
  echo '</form>';

  echo "<div class='container mt-5'>
          <div class='row'>
            <div class='col-sm-8'>
              <h3>Locales</h3>
            </div>
          </div>
          <div class='row'>
            <div class='col-sm-2'>&nbsp;</div>
            <div class='col-sm-8'>
              <table class='table'>
                <thead>
                  <tr>
                    <td>idLOCAL</td>
                    <td>Local</td>
                    <td>idCIUDAD</td>
                  </tr>
                </thead>
              <tbody>";

  while ($result2 = mysqli_fetch_array($qry2)) {
    $qry3 = $conn->query("SELECT * FROM ciudades WHERE idCIUDAD =" . $result2['idCIUDAD']);
    if (mysqli_num_rows($qry3) == 1) {
      while ($result3 = mysqli_fetch_array($qry3)) {
        echo '<tr>';
        echo '<td>';
        echo $result2['idLOCAL'];
        echo '</td>';
        echo '<td>';
        echo $result2['local'];
        echo '</td>';
        echo '<td>';
        echo $result3['ciudad'];
        echo '</td>';
        echo '<td>';
        echo '<a href="./deleteLocal.php?id=' . $result2['idLOCAL'] . '">Eliminar<a/>';
        echo '</td>';
      }
    }
  }
}

$local = '';
$ciudad = '';

if (!empty($_POST["local"]) && !empty($_POST["ciudad"])) {
  $GLOBALS['local'] = $_POST["local"];
  $GLOBALS['ciudad'] = $_POST["ciudad"];

  $validar = $conn->query("SELECT * FROM locales WHERE local = '$local'");

  if (mysqli_num_rows($validar) == 0) {
    $qry2 = $conn->query("INSERT INTO locales (local, idCIUDAD) VALUES ('$local','$ciudad')");
    if ($qry2) {
      header("Location: ./newLocal.php");
    }
  } else {
    echo
    '<script language="javascript">alert("ERROR AL REGISTRAR LOCAL. Local ya existe. Intente nuevamente.");</script>';
  };
}

echo $footer_html;
