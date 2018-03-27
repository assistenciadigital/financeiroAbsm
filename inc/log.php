<?php
/**
* Função para salvar mensagens de LOG no MySQL
*
* @param string $mensagem - A mensagem a ser salva
*
* @return bool - Se a mensagem foi salva ou não (true/false)
*/
function salvaLog($mensagem, $usuario) {
$ip = $_SERVER['REMOTE_ADDR']; // Salva o IP do visitante
$hora = date('Y-m-d H:i:s'); // Salva a data e hora atual (formato MySQL)
$usuario= $usuario;
// Usamos o mysql_escape_string() para poder inserir a mensagem no banco
//   sem ter problemas com aspas e outros caracteres
$mensagem = mysql_escape_string($mensagem);
// Monta a query para inserir o log no sistema
$sql = "INSERT INTO `logs` VALUES (NULL, '".$hora."', '".$ip."', '".$usuario."','".$mensagem."')";
if (mysql_query($sql)) {
return true;
} else {
return false;
}
}