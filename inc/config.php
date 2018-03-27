<?php

ini_set("display_errors", 0 );
error_reporting(0); 

date_default_timezone_set("America/Cuiaba");
setlocale(LC_ALL, 'pt_BR');

/** O titulo do sistema*/
define('TITLE', 'AD - Assistência Digital');

/** O footer do sistema*/
define('FOOTER', '<p><span class="glyphicon glyphicon-copyright-mark"></span> 2016 <span class="glyphicon glyphicon-registration-mark"></span> AD - Assistência Digital. Em caso de dúvidas e/ou sugestões favor contactar o desenvolvedor.<p/><a href="tel:5565981752105"><i class="phoneno fa fa-whatsapp"></i> 55 (65) 98175-2105 Tim</a> (65) 99994-2105 vivo | <span class="glyphicon glyphicon-envelope"></span> <a href="mailto:alex@assistenciadigital.info">alex@assistenciadigital.info </a> | Page: <a href="http://www.assistenciadigital.info" target="_blank">http://www.assistenciadigital.info</a> | <a href="callto://+5565981752105"><i class="fa fa-skype"></i> bueno.alex</a>');

/** O nome do sistema*/
define('SYSNAME', 'AD - Assistência Digital');

/** caminho absoluto para a pasta do sistema **/
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** caminho no server para o sistema **/
if ( !defined('BASEURL') )
	define('BASEURL', '/financeiro/');

/** caminho no server para o menu do sistema **/
if ( !defined('BASEMENU') )
	define('BASEMENU', '/financeiro/inc/');

/** caminho no server para o menu do sistema **/
if ( !defined('VOLTAMENU') )
	define('VOLTAMENU', '/financeiro/inc/menu.php');

/** caminho no server para o imagens do sistema do sistema **/
if ( !defined('BASEIMG') )
	define('BASEIMG', '/financeiro/img/');

/** caminho do arquivo de banco de dados **/
if ( !defined('DBAPI') )
	define('DBAPI', ABSPATH . 'inc/database.php');
	
/** caminhos dos templates de header e footer **/
define('HEADER_TEMPLATE', ABSPATH . 'header.php');
define('HEADERBASIC_TEMPLATE', ABSPATH . 'header_basic.php');
define('FOOTER_TEMPLATE', ABSPATH . 'footer.php');
?>