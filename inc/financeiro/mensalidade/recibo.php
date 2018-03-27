<?php
include '../../config.php';
include '../../datas.php'; 
include '../../funcoes.php'; 
include("../../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include("../../contadorVisitas.php");

$tabela = "financeiro_mensalidade";

$empresa = @mysql_fetch_assoc(mysql_query("SELECT * FROM empresa WHERE id = 1"));
$select = mysql_query("select m.id as mensalidade, m.competencia as competencia, Month(m.competencia) as mes, Year(m.competencia) as ano, m.valor as valor_mensalidade, m.vencimento as vencimento, m.usuario_login as usuario_mensalidade, m.data as data_mensalidade, r.valor as valor_recebimento, r.recebimento as recebimento, e.descricao as evento, r.usuario_login as usuario_recebimento, r.data as data_recebimento from financeiro_evento as e RIGHT JOIN (financeiro_mensalidade as m LEFT JOIN financeiro_recebimento as r ON m.id = r.mensalidade) ON e.id = m.evento where m.titular = '".$_GET['titular']."' and Year(competencia) = '".$_GET['porano']."' order by Month(m.competencia), evento, r.valor"); 
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
	  //CONECTA COM O MYSQL
	  $titular = @mysql_fetch_assoc(mysql_query("SELECT nome, cpf, mae FROM cliente WHERE cliente = '".$_GET['titular']."'"));
	  $mensalidade = @mysql_fetch_assoc(mysql_query("SELECT * FROM financeiro_mensalidade WHERE titular = '".$_GET['titular']."' AND Year(competencia) = '".$_GET['porano']."'"));
	  $total = @mysql_fetch_assoc(mysql_query("SELECT sum(r.valor) as valortotal FROM financeiro_mensalidade as m left join financeiro_recebimento as r on m.id = r.mensalidade WHERE titular = '".$_GET['titular']."' AND Year(competencia) = '".$_GET['porano']."'"));
	  $empresa = @mysql_fetch_assoc(mysql_query("SELECT * FROM empresa WHERE id = 1"));
	  
      //Informa a fonte, seu estilo e seu tamanho   
      $this->SetFont('Courier','I',7);
	  //$this->Cell(0,5,'Usuario Conectado: '.strtoupper($_SESSION['usuarioLogin']),0,0,'L');
	  //$this->Cell(0,5,'Ultimo Acesso: '. datetime_datatempo($_SESSION['usuarioUltimoAcesso']).' | ENDERECO IP: '.$_SERVER['REMOTE_ADDR'],0,1,'R');
	  $this->Cell(0,5,'Impresso em: '.date('d/m/Y H:i').' Por: '.strtoupper($_SESSION['usuarioLogin']),0,0,'L');
	  $this->Cell(0,4,'Pagina: '.$this->PageNo().' de: {nb}',0,1,'R');	  
	  $this->Image('../../../img/logo_absm.png', 10, 15, 35, 28);	
	  $this->Ln(2);
	  $this->SetFont('Times','B',10);
	  $this->SetX(46);
	  $this->MultiCell(0,5, $empresa['razao'], 0,'C',0);
	  $this->SetX(46);
	  $this->MultiCell(0,5, $empresa['fantasia'].' - CNPJ: '.$empresa['cpf_cnpj'], 0,'C',0);
	  $this->SetFont('Times','',10);
	  $this->SetX(46);
	  $this->MultiCell(0,5, $empresa['endereco'].', '.$empresa['bairro'], 0,'C',0);
	  $this->SetX(46);
	  $this->MultiCell(0,5, $empresa['cidade'].' / '.$empresa['uf'].' - CEP '.$empresa['cep'], 0,'C',0);
	  $this->SetFont('Times','',10);
	  $this->Ln(4);
	  $this->SetFont('Times','B',10);
	  $this->Cell(0,5, 'R E C I B O', 0, 0, 'C');
	  $this->Ln(8);
	  $this->SetFont('Times','',10);
	  $this->MultiCell(0,5,'RECEBEMOS DO(A) SR.(A) '.ucwords ($titular['nome']).', PORTADOR(A) DO CPF '.$titular['cpf'].', A IMPORTANCIA DE R$ '.number_format($total['valortotal'], 2, ',', '.').' ('.ucwords(trim(valor_extenso(number_format($total['valortotal'], 2, ',', '.')))).'), CORRESPONDENTES AO ANO DE '.$_GET['porano'].', REFERENTE A CONTRIBUICAO ASSOCIATIVA, CONFORME ABAIXO:',0,'J',0);
	  $this->Ln();
	  $this->SetFont('Times','B',10);
	  $this->Cell(45, 5, 'NOME ASSOCIADO(A):', 1, 0, 'L');
	  $this->Cell(0	, 5, $titular['nome'], 1, 1, 'L');
	  $this->SetFont('Times','',10);
	  $this->Cell(45, 5, 'CPF:', 1, 0, 'L');
	  $this->Cell(0, 5, $titular['cpf'], 1, 1, 'L');
	  $this->Cell(45, 5, 'NOME DA MAE:', 1, 0, 'L');
	  $this->Cell(0, 5, $titular['mae'], 1, 1, 'L');
	  $this->Cell(45, 5, 'ANO DE REFERENCIA:', 1, 0, 'L');
	  $this->Cell(0, 5, $_GET['porano'], 1, 1, 'L');  
	  $this->Ln();

	  //MONTA O CABEÇALHO DA TABELA
		$this->SetFont('Courier','B',9);
		$this->Cell( 0, 5, "PERIODO", 1, 1, 'C');
		$this->Cell( 15, 5, "MES", 1, 0, 'C');
		$this->Cell( 30, 5, "VALOR R$", 1, 0, 'R');
		$this->Cell(145, 5, "FORMA DE PAGAMENTO / DESCONTO", 1, 1, 'L');
	  
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
$pdf=new PDF('P', 'mm', 'A4');

//Inserimos a página
$pdf->AddPage();
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

//apontamos a fonte que será utilizada no texto
$pdf->SetFont('Courier','',$tamanho_fonte);

//Aquí escribimos lo que deseamos mostrar...

$pdf->SetFont('Times','',10);

if (mysql_num_rows ($select)) {
  while ($row = mysql_fetch_assoc($select)) {
		$somavalor = $somavalor + $row['valor_recebimento'];
		$pdf->Cell(15, 6, mes_abreviado($row['mes']), 1, 0, 'C');
		$pdf->Cell(30, 6, number_format($row['valor_recebimento'], 2, ',', '.'), 1, 0, 'R');
		$pdf->Cell(145, 6, $row['evento'], 1, 1, 'L');		
		  }
}

$pdf-> Cell(45, 5, 'VALOR TOTAL',1,0,'C');
$pdf-> Cell(0, 5, 'R$ '.number_format(($somavalor), 2, ',', '.').' ('.trim(valor_extenso(number_format(($somavalor)), 2, ',', '.')).')',1,1,'L');
$pdf-> Ln(5);
$pdf->SetFont('Times','',10);
$pdf-> Cell(0,6, 'Cuiaba/MT, '.date('d').' de '.mes_extenso(date('m')).' de '.date('Y'),0,0,'C');
$pdf-> Ln(15);
$pdf->SetFont('Times','',10);
$pdf-> Cell(0,4, $empresa['razao'], 0, 1, 'C');
$pdf-> Cell(0,4, $empresa['fantasia'].' - CNPJ: '.$empresa['cpf_cnpj'], 0, 1, 'C');
$pdf-> SetFont("Courier", '', $tamanho_fonte);
$pdf-> Cell(0,4, $empresa['endereco'].', '.$empresa['bairro'], 0, 1, 'C');
$pdf-> Cell(0,4, $empresa['cidade'].' / '.$empresa['uf'].' - CEP '.$empresa['cep'], 0, 0, 'C');

mysql_close();
//limpamos o cache
ob_start ();
ob_clean();

$pdf->Output("certidao.pdf", "I");
?> 
<script>window.open('certidao.pdf'); </script>