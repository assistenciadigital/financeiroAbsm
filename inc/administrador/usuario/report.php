<?php
include '../../config.php';
include '../../datas.php'; 
include("../../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include("../../contadorVisitas.php");

$tabela = "usuario";
$pesquisarpor = (isset($_GET['pesquisarpor'])) ? $_GET['pesquisarpor'] : 'usuario_login';
$orderby = (isset($_GET['pesquisarpor'])) ? $_GET['pesquisarpor'] : 'usuario_login';
$consulta = (isset($_GET['consulta'])) ? $_GET['consulta'] : '*';

//CONECTA COM O MYSQL
$select = mysql_query("select *, date_format(`data`,'%d/%m/%Y %H:%i') as `data_formatada` from {$tabela} where {$pesquisarpor} like '%".$_GET['consulta']."%' order by {$orderby}, usuario_nome");
	$qtde_pesquisado = mysql_num_rows($select);
	$qtde_registro = mysql_num_rows(mysql_query("SELECT * from {$tabela}")); // Quantidade de registros pra paginação

//VERIFICA SE RETORNOU ALGUMA LINHA
if(!mysql_num_rows($select)) { echo "Não retornou registro(s)"; die; }

//fazemos a inclusão do arquivo com a classe FPDF
require('../../../fpdf/fpdf.php');

//criamos uma nova classe, que será uma extensão da classe FPDF
//para que possamos sobrescrever o método Header()
//com a formatação desejada
class PDF extends FPDF
{
   //Método Header que estiliza o cabeçalho da página
   function Header() {
      //Informa a fonte, seu estilo e seu tamanho     
      $this->SetFont('Courier','I',7);
	  $this->Cell(0,5,'Usuario Conectado: '.strtoupper($_SESSION['usuarioLogin']),0,0,'L');
	  $this->Cell(0,5,'Ultimo Acesso: '. datetime_datatempo($_SESSION['usuarioUltimoAcesso']).' | ENDERECO IP: '.$_SERVER['REMOTE_ADDR'],0,1,'R');
	  $this->SetFont('Arial','B',10);
      $this->Cell(0,5,'ESTOQUE FACIL - Versao: 01/2015',0,1,'C');
	  $this->Ln();
	  $this->SetFont('Courier','B',10);
	  $this->Cell(0,4,'RELACAO DE USUARIO',0,1,'C');
      $this->SetFont('Courier','',10);
	  $this->Cell(0,5,'Impresso em: '.date('d/m/Y H:i').' Por: '.strtoupper($_SESSION['usuarioLogin']),0,0,'L');
	  $this->Cell(0,4,'Pagina: '.$this->PageNo().' de: {nb}',0,1,'R');	  
	  //MONTA O CABEÇALHO DA TABELA
		$this->SetFont('Courier','B',8);
		$this->Cell(25, 4, "ID / Login", 1, 0, 'L');
		$this->Cell(65, 4, "NOME", 1, 0, 'L');
		$this->Cell( 4, 4, "S", 1, 0, 'C');
		$this->Cell(18, 4, "NASCIMENTO", 1, 0, 'C');
		$this->Cell(60, 4, "E-MAIL", 1, 0, 'C');
		$this->Cell(51, 4, "TELEFONE", 1, 0, 'C');
		$this->Cell(29, 4, "ULTIMA ALTERACAO", 1, 0, 'C');
		$this->Cell(25, 4, "USUARIO", 1, 1, 'L');
   }

   //Método Footer que estiliza o rodapé da página
   function Footer() {

      //posicionamos o rodapé a 1cm do fim da página
      $this->SetY(285);
      
      //Informamos a fonte, seu estilo e seu tamanho
      $this->SetFont('Courier','I',7);

      //Informamos o tamanho do box que vai receber o conteúdo do rodapé
      //e inserimos o número da página através da função PageNo()
      //além de informar se terá borda e o alinhamento do texto
  	  $this->Cell(0,0,'',1,1,'C');
	  $this->Cell(0,2,'Assistência Digital (65)9.8175-2105 tim (65)9.9994-2105 vivo (65)3625-4089 fixo | Todos os direitos reservados.',0,1,'C');
	  $this->Cell(0,2,'E-mail: alex@assistenciadigital.info | Acesse: http://www.assistenciadigital.info | Skype: bueno.alex',0,0,'C');
   }
}
//Criamos o objeto da classe PDF
$pdf=new PDF('L', 'mm', 'A4');

//Inserimos a página
$pdf->AddPage();
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

//apontamos a fonte que será utilizada no texto
$pdf->SetFont('Courier','',8);

//Aquí escribimos lo que deseamos mostrar...

$pdf->SetFont('Courier','',8);
if (mysql_num_rows ($select)) {
  while ($row = mysql_fetch_assoc($select)) {
		$pdf->Cell(25, 4, $row['usuario_login'], 1, 0, 'L');
		$pdf->Cell(65, 4, $row['usuario_nome'], 1, 0, 'L');
		$pdf->Cell( 4, 4, $row['usuario_sexo'], 1, 0, 'C');
		$pdf->Cell(18, 4, date_data($row['usuario_nascimento']), 1, 0, 'L');
		$pdf->Cell(60, 4, $row['usuario_email'], 1, 0, 'L');
		$pdf->Cell(51, 4, $row['usuario_telefone'].' '.$row['usuario_celular'], 1, 0, 'L');
		$pdf->Cell(29, 4, $row['data_formatada'], 1, 0, 'L');
		$pdf->Cell(25, 4, strtoupper($row['usuario_logado']), 1, 1, 'L');
  }
}

$pdf-> SetFont("Courier", 'B', 8);
$pdf-> Cell(0,4, number_format(($qtde_pesquisado), 0, ',', '.').' de '.number_format(($qtde_registro), 0, ',', '.')." Registro(s) para: ".$pesquisarpor." = ".$consulta.' Ordenado por: '.$orderby,1,0,'C');

mysql_close();
//limpamos o cache
ob_start ();
ob_clean();

$pdf->Output("usuario.pdf", "I");
?> 
<script>window.open('usuario.pdf'); </script>

