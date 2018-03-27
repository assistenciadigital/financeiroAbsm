<?php
// Log
include("log.php");

// Inclui o arquivo com o sistema de segurança
require_once("seguranca.php");

// Salva LOG no Banco de Dados
$usuario = $_SESSION['usuarioLogin'];
$mensagem= "Log Out";
salvaLog($mensagem, $usuario);
// Fim Salva LOG

session_start();
session_destroy();
header("Location: ../index.php"); exit;
?>