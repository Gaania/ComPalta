<?php
//incluir mantener sesion
include '../back/sesion.php';

unset($_SESSION['usuario']);
session_destroy();
echo'<script> alert("La sesión se ha cerrado");history.go(-2);</script>';
exit;

