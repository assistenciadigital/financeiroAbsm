<?php 
if (!isset($_SESSION)) session_start();

echo 'Usuario: '.$_SESSION['usuarioLogin'].'<br/>';
echo 'Cadastro: '.$_SESSION['usuarioCadastro'].'<br/>';
echo 'Compras: '.$_SESSION['usuarioCompras'].'<br/>';
echo 'Convenio: '.$_SESSION['usuarioConvenio'].'<br/>';
echo 'Estoque: '.$_SESSION['usuarioEstoque'].'<br/>';
echo 'Financeiro: '.$_SESSION['usuarioFinanceiro'].'<br/>';
echo 'Hospital: '.$_SESSION['usuarioHospital'].'<br/>';
echo 'Laboratorio: '.$_SESSION['usuarioLaboratorio'].'<br/>';
echo 'Painel: '.$_SESSION['usuarioPainel'].'<br/>';
echo 'Tabelas: '.$_SESSION['usuarioTabelas'].'<br/>';
echo 'Admin: '.$_SESSION['usuarioAdmin'].'<br/>';
echo 'Admin Painel: '.$_SESSION['usuarioAdminPainel'].'<br/>';


?>