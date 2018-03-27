<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
 
<script type="text/javascript" src="../../../js/autocomplete/lib/jquery.js"></script>
<script type="text/javascript" src="../../../js/autocomplete/lib/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="../../../js/autocomplete/lib/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="../../../js/autocomplete/lib/thickbox-compressed.js"></script>
<script type="text/javascript" src="../../../js/autocomplete/jquery.autocomplete.js"></script>
<!--css -->
<link rel="stylesheet" type="text/css" href="../../../js/autocomplete/jquery.autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="../../../js/autocomplete/lib/thickbox.css"/>
 
 <script type="text/javascript">
 	$(document).ready(function(){
		$("#txtNome").autocomplete("ac.php", {
			width:310,
			selectFirst: false
		});
	});
 </script>
	
</head>
 
<body>
 
<input type="text" name="txtNome" id="txtNome" size="60" class="input_forms"/>
 
</body>
</html>