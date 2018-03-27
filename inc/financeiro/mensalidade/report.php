<?php
include '../../config.php';
include '../../datas.php'; 
include("../../seguranca.php"); // Inclui o arquivo com o sistema de segurança
protegePagina(); // Chama a função que protege a página
include("../../contadorVisitas.php");

//CONECTA COM O MYSQL

	$select = mysql_query("select m.id as mensalidade, m.competencia as competencia, Month(m.competencia) as mes, Year(m.competencia) as ano, m.valor as valor_mensalidade, m.vencimento as vencimento, m.usuario_login as usuario_mensalidade, m.data as data_mensalidade, r.valor as valor_recebimento, r.recebimento as recebimento, e.descricao as evento, r.usuario_login as usuario_recebimento, r.data as data_recebimento from financeiro_evento as e RIGHT JOIN (financeiro_mensalidade as m LEFT JOIN financeiro_recebimento as r ON m.id = r.mensalidade) ON e.id = m.evento where m.titular = '".$_GET['titular']."' and Year(m.competencia) = '".$_GET['porano']."' order by Month(m.competencia)"); 
	$qtde_pesquisado = mysql_num_rows($select);
	$qtde_registro = mysql_num_rows(mysql_query("select m.id as mensalidade, m.competencia as competencia, Month(m.competencia) as mes, Year(m.competencia) as ano, m.valor as valor_mensalidade, m.vencimento as vencimento, m.usuario_login as usuario_mensalidade, m.data as data_mensalidade, r.valor as valor_recebimento, r.recebimento as recebimento, e.descricao as evento,r.usuario_login as usuario_recebimento, r.data as data_recebimento from financeiro_mensalidade as m LEFT JOIN financeiro_recebimento as r ON r.mensalidade = m.id LEFT JOIN financeiro_evento as e on m.evento = e.id where m.titular = '".$_GET['titular']."' and Year(competencia) = '".$_GET['porano']."'")); // Quantidade de registros pra paginação

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
	  $titular = @mysql_fetch_assoc(mysql_query("SELECT nome, cpf, mae FROM cliente WHERE cliente = '".$_GET['titular']."'"));
      //Informa a fonte, seu estilo e seu tamanho     
      $this->SetFont('Courier','I',7);
	  $this->Cell(0,5,'Usuario Conectado: '.strtoupper($_SESSION['usuarioLogin']),0,0,'L');
	  $this->Cell(0,5,'Ultimo Acesso: '. datetime_datatempo($_SESSION['usuarioUltimoAcesso']).' | ENDERECO IP: '.$_SERVER['REMOTE_ADDR'],0,1,'R');
	  $this->SetFont('Arial','B',9);
      //$this->Cell(0,5,'ESTOQUE FACIL - Versao: 01/2015',0,1,'C');
	  //$this->Ln();
	  $this->SetFont('Courier','B',10);
	  $this->Cell(0,4,'RELACAO DE MENSALIDADE',0,1,'C');
	  $this->Cell(0	, 5, 'NOME ASSOCIADO(A): '.$titular['nome'], 0, 1, 'L');
	  $this->SetFont('Courier','',10);
	  $this->Cell(0	, 5, 'CPF..............: '.$titular['cpf'], 0, 1, 'L');
	  $this->Cell(0	, 5, 'NOME DA MAE......: '.$titular['mae'], 0, 1, 'L');
	  $this->Cell(0	, 5, 'ANO DE REFERENCIA: '.$_GET['porano'], 0, 1, 'L');
	  //$this->Ln();	  
      $this->SetFont('Courier','',8);
	  $this->Cell(0,5,'Impresso em: '.date('d/m/Y H:i').' Por: '.strtoupper($_SESSION['usuarioLogin']),0,0,'L');
	  $this->Cell(0,4,'Pagina: '.$this->PageNo().' de: {nb}',0,1,'R');	  
	  //MONTA O CABEÇALHO DA TABELA
	  $this->SetFont('Courier','B',8);
	  $this->Cell(20, 4, "COMPETENCIA", 1, 0, 'C');
	  $this->Cell(25, 4, "VALOR R$", 1, 0, 'R');
	  $this->Cell(20, 4, "VENCIMENTO", 1, 0, 'C');
	  $this->Cell(25, 4, "USUARIO", 1, 0, 'L');
	  $this->Cell(29, 4, "DATA", 1, 0, 'C');
	  $this->Cell(20, 4, "RECEBIMENTO", 1, 0, 'L');
	  $this->Cell(25, 4, "VALOR R$", 1, 0, 'R');
	  $this->Cell(59, 4, "EVENTO", 1, 0, 'L');
	  $this->Cell(25, 4, "USUARIO", 1, 0, 'L');
	  $this->Cell(29, 4, "DATA", 1, 1, 'C');
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

$selmes = mysql_query("select distinct Month(m.competencia) as mes, Year(m.competencia) as ano, sum(m.valor) as subtotal_mensalidade from financeiro_mensalidade as m where m.titular = '".$_GET['titular']."' and Year(competencia) = '".$_GET['porano']."' group by Month(m.competencia)"); 
if (mysql_num_rows ($selmes)) {
	while ($rowmes = mysql_fetch_assoc($selmes)) {
		$total_mensalidade = $total_mensalidade + $rowmes['subtotal_mensalidade'];
		$subtotal_mensalidade=0;
		$subtotal_recebimento=0;		
		$pdf-> SetFont("Courier", '', 8);
		$somames = mysql_query("select m.id as mensalidade, m.competencia as competencia, Month(m.competencia) as mes, Year(m.competencia) as ano, m.valor as valor_mensalidade, m.vencimento as vencimento, m.usuario_login as usuario_mensalidade, m.data as data_mensalidade, r.valor as valor_recebimento, r.recebimento as recebimento, e.descricao as evento, r.usuario_login as usuario_recebimento, r.data as data_recebimento from financeiro_evento as e RIGHT JOIN (financeiro_mensalidade as m LEFT JOIN financeiro_recebimento as r ON m.id = r.mensalidade) ON e.id = m.evento where Month(m.competencia) = '".$rowmes['mes']."' and m.titular = '".$_GET['titular']."' and Year(m.competencia) = '".$_GET['porano']."' order by Month(m.competencia)"); 
		if (mysql_num_rows ($somames)) {
			while ($row = mysql_fetch_assoc($somames)) {
				
				
				$total_recebimento = $total_recebimento + $row['valor_recebimento'];
				
				$pdf->Cell(20, 4, date_data($row['competencia']), 1, 0, 'C');//.'/'.$row['ano'], 1, 0, 'C');
				$pdf->Cell(25, 4, number_format($row['valor_mensalidade'], 2, ',', '.'), 1, 0, 'R');
				$pdf->Cell(20, 4, date_data($row['vencimento']), 1, 0, 'C');
				$pdf->Cell(25, 4, $row['usuario_mensalidade'], 1, 0, 'L');
				$pdf->Cell(29, 4, datetime_datatempo($row['data_mensalidade']), 1, 0, 'C');		
				$pdf->Cell(20, 4, date_data($row['recebimento']), 1, 0, 'C');
				$pdf->Cell(25, 4, number_format($row['valor_recebimento'], 2, ',', '.'), 1, 0, 'R');
				$pdf->Cell(59, 4, $row['evento'], 1, 0, 'L');
				$pdf->Cell(25, 4, $row['usuario_recebimento'], 1, 0, 'L');
				$pdf->Cell(29, 4, datetime_datatempo($row['data_recebimento']), 1, 1, 'C');
				$subtotal_mensalidade = $subtotal_mensalidade + $row['valor_mensalidade'];
				$subtotal_recebimento = $subtotal_recebimento + $row['valor_recebimento'];		

			}
		}
		$pdf-> SetFont("Courier", 'B', 8);
		$pdf->Cell(20, 4, 'Total: '.mes_abreviado($rowmes['mes']), 1, 0, 'C');
		$pdf->Cell(25, 4, number_format($subtotal_mensalidade, 2, ',', '.'), 1, 0, 'R');
		$pdf->Cell(94, 4, 'SubTotal R$', 1, 0, 'R');
		$pdf->Cell(25, 4, number_format($subtotal_recebimento, 2, ',', '.'), 1, 0, 'R');
		$pdf->Cell(113, 4, '', 1, 1, 'R');
		$pdf-> SetFont("Courier", '', 8);
	}
}
 
$pdf-> SetFont("Courier", 'B', 8);
$pdf-> Cell(20,4,'TOTAL R$',1,0,'R');
$pdf-> Cell(25, 4, number_format($total_mensalidade, 2, ',', '.'), 1, 0, 'R');
$pdf-> Cell(94,4,'TOTAL R$',1,0,'R');
$pdf-> Cell(25, 4, 'R$ '.number_format($total_recebimento, 2, ',', '.'), 1, 0, 'R');
$pdf-> Cell(59,4,'',1,0,'C');
$pdf-> Cell(25,4,'',1,0,'C');
$pdf-> Cell(29,4,'',1,1,'C');
$pdf-> Cell(0,4, number_format(($qtde_pesquisado), 0, ',', '.').' de '.number_format(($qtde_registro), 0, ',', '.')." Registro(s) para Ano ".$_GET[porano],1,0,'C');

mysql_close();
//limpamos o cache
ob_start ();
ob_clean();

$pdf->Output("evento.pdf", "I");
?> 
<script>window.open('evento.pdf'); </script>