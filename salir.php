<?php 

// Boton de salir Y cierre de Cesion

session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit ();
?>
