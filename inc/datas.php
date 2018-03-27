<?php 
// aqui converte data e hora no formato para o browser

date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');

function datetime_datatempo ($e) {
	$p  = explode (" ", $e);
	$d  = explode ("-", $p[0]);
	$s  = "$d[2]/$d[1]/$d[0] ";
	$s .= substr ($p[1], 0, 5);
	if ($e) return $s;
}

function datatempo_datetime ($e) {
	$p  = explode (" - ", $e);
	$d  = explode ("/", $p[0]);
	$s  = "$d[2]-$d[1]-$d[0] ";
	$s .= substr ($p[1], 0, 5);
	if ($e) return $s;
}

function mes_extenso ($mes)	{
	switch ($mes) {
		case  1: return "Janeiro";
		case  2: return "Fevereiro";
		case  3: return "Marco";
		case  4: return "Abril";
		case  5: return "Maio";
		case  6: return "Junho";
		case  7: return "Julho";
		case  8: return "Agosto";
		case  9: return "Setembro";
		case 10: return "Outubro";
		case 11: return "Novembro";
		case 12: return "Dezembro";
	}	
}

function mes_abreviado ($mes)	{
	switch ($mes) {
		case  1: return "JAN";
		case  2: return "FEV";
		case  3: return "MAR";
		case  4: return "ABR";
		case  5: return "MAI";
		case  6: return "JUN";
		case  7: return "JUL";
		case  8: return "AGO";
		case  9: return "SET";
		case 10: return "OUT";
		case 11: return "NOV";
		case 12: return "DEZ";
	}	
}

function date_data ($data) {
	$d = explode ("-", $data);
	if ($data) return "$d[2]/$d[1]/$d[0]";
}

function data_date ($data) {
	$d = explode ("/", $data);
	if ($data) return "$d[2]-$d[1]-$d[0]";
}
?>

