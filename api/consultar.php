<?php

// http://localhost/sistema_php/api/consultar.php
  $conexion = new mysqli("a2nlmysql33plsk.secureserver.net:3306", "prueba1", "prueba123", "appecomerce") or die("not connected".mysqli_connect_error());

  $sql = "SELECT * FROM `tbl_direcciones`;";

  $result = mysqli_query($conexion, $sql);
  
  $restaurantes = array();
  while ($fila = mysqli_fetch_array($result)) {
    array_push($restaurantes, $fila);
  }
  
  echo json_encode($restaurantes);

  mysqli_free_result($result);
  mysqli_close($conexion);
  

?>
