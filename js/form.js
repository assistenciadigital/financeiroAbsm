// create the prototype on the String object
String.prototype.trim = function() {
 // skip leading and trailing whitespace
 // and return everything in between
	return this.replace(/^\s*(\b.*\b|)\s*$/, "$1");
}



// create the prototype on the String object
String.prototype.trimLeadingZeros = function(todos) { //true, false
    if (""+todos=="undefined") todos=false;

    //tirando os zeros do começo
    var i=0;
    while ((i < this.length- (todos?0:1) ) && (this.substring(i,i+1)=='0')) i++;
    valor = this.substring(i);
	return valor;
}

function stripCharsNotInBag(bag, campo) { //campo só deve ser passado se for para alterar seu valor
	//bag = "0123456789";

	var temp="";
	if (campo==null) temp=this;
	if (campo!=null) temp=campo.value;

	var result = "";
	for (i=0; i<temp.length; i++){
		character = temp.charAt(i);
		if (bag.indexOf(character) != -1)
			result += character;
	}
	if (campo!=null && campo.value!=result) {
		campo.value=result;
	}
	return result;
}

// create the prototype on the String object
String.prototype.stripCharsNotInBag = stripCharsNotInBag;

function stripNotNumber(num) {
	return num.stripCharsNotInBag("0123456789");
}


var BASE_DATE = new Date("1997","09","07")  // 1999-out-07
var MAX_DATE = new Date("2025","01","21")   // 2025-fev-21

function ValidaData (data) {
	dt = data.value;

	if (dt.length<10) {
		alert("Tamnho inválido, digitar no formato dd/mm/aaaa.");
		data.select();
		return false;
	}

	dia = dt.substring(0,2);
	mes = dt.substring(3,5);
	ano = dt.substring(6,10);

	// month argument must be in the range 1 - 12
	// javascript month range : 0- 11
	var tempDate = new Date(ano,mes-1,dia);
		
	if ( (ano == tempDate.getFullYear()) &&
	     (mes == (tempDate.getMonth()+1)) &&
	     (dia == tempDate.getDate()) ) {
		var tmp = new Date();
		var todayDate = new Date(tmp.getFullYear(), tmp.getMonth(), tmp.getDate());

	     	//return (tempDate >= BASE_DATE && tempDate<=MAX_DATE && tempDate>=todayDate)
	     	return (tempDate >= BASE_DATE && tempDate<=MAX_DATE)
	} else {
		alert("Data inválida, digitar no formato dd/mm/aaaa.");
		data.select();
		return false;
	}
}

function formataDataDigitada(campo) {
    // retira tudo que nao eh numerico
    var temp=campo.value;
    var valor="";

    valor=stripNotNumber(temp);

    if (valor.length>8) { valor=valor.substring(0,8); }

    var j=0;
    temp="";
    for (var tam=0;tam<valor.length;tam++) {
        if (j==0) {
            temp+=valor.substring(tam,tam+1);
            if ( (tam==1) && (valor.length>2) ) { j++; temp+="/"; }
        } else if (j==1) {
            temp+=valor.substring(tam,tam+1);
            if ( (tam==3) && (valor.length>4) ) { j++; temp+="/"; }
        } else if (j==2) {
            temp+=valor.substring(tam,tam+1);
        }
    }

    if (campo.value!=temp) {
        campo.value=temp;
    }
}


	
function FormataNumero(num,decimalNum,bolLeadingZero,bolParens,bolCommas)
/**********************************************************************
	IN:
		NUM - the number to format
		decimalNum - the number of decimal places to format the number to
		bolLeadingZero - true / false - display a leading zero for
										numbers between -1 and 1
		bolParens - true / false - use parenthesis around negative numbers
		bolCommas - put commas as number separators.

	RETVAL:
		The formatted number!
 **********************************************************************/
{
        if (isNaN(parseInt(num))) return "NaN";

	var tmpNum = num;
	var iSign = num < 0 ? -1 : 1;		// Get sign of number

	// Adjust number so only the specified number of numbers after
	// the decimal point are shown.
	tmpNum *= Math.pow(10,decimalNum);
	tmpNum = Math.round(Math.abs(tmpNum))
	tmpNum /= Math.pow(10,decimalNum);
	tmpNum *= iSign;					// Readjust for sign

	// Create a string object to do our formatting on
	var tmpNumStr = new String(tmpNum);

	// See if we need to strip out the leading zero or not.
	if (!bolLeadingZero && num < 1 && num > -1 && num != 0)
		if (num > 0)
			tmpNumStr = tmpNumStr.substring(1,tmpNumStr.length);
		else
			tmpNumStr = "-" + tmpNumStr.substring(2,tmpNumStr.length);

	tmpNumStr = tmpNumStr.replace(/\./g,",");


	// Complete all decimal places
	if (decimalNum>0) {
		var iStart = tmpNumStr.indexOf(",");
		if (iStart < 0) {
			tmpNumStr+=",";
			iStart = tmpNumStr.indexOf(",");
		}

		for (i=(decimalNum-(tmpNumStr.length-iStart)); i>=0 ; i--) {
			tmpNumStr+="0";
		}
	}


	// See if we need to put in the commas
	if (bolCommas && (num >= 1000 || num <= -1000)) {
		var iStart = tmpNumStr.indexOf(",");
		if (iStart < 0)
			iStart = tmpNumStr.length;

		iStart -= 3;
		while (iStart >= 1) {
			tmpNumStr = tmpNumStr.substring(0,iStart) + "." + tmpNumStr.substring(iStart,tmpNumStr.length)
			iStart -= 3;
		}
	}

	// See if we need to use parenthesis
	if (bolParens && num < 0)
		tmpNumStr = "(" + tmpNumStr.substring(1,tmpNumStr.length) + ")";

	return tmpNumStr;		// Return our formatted string!
}

function formataValorDigitado(campo, decimal) {
	var decimalNum=2;
	if (decimal!=null)
		decimalNum=decimal;

	var temp = FormataNumero(campo.value.stripCharsNotInBag("0123456789").trimLeadingZeros() / Math.pow(10,decimalNum), decimalNum, true, false, true);

    if (campo.value!=temp) {
        campo.value=temp;
    }
}	

function Valido(texto,valores)
{
  var valido = true;

  for (var i = 0;  i < texto.length;  i++)
  {
    var ch = texto.charAt(i);

    for (var j = 0;  j < valores.length;  j++)
      if (ch == valores.charAt(j))
        break;

    if (j == valores.length)
    {
      valido = false;
      break;
    }
  }
  return(valido);	
}


/**
 * Funcao que valida todos campos do formulario 
 */
function Consiste(theForm)
{
 if ((theForm.sacadoNome.value == "") || (theForm.sacadoNome.value.length < 3) || (theForm.sacadoNome.value.length > 40))
  {
    alert("Informar o campo Nome (pessoa ou empresa) com 3 a 40 caracteres");
    theForm.sacadoNome.focus();
    return (false);
  }

  if ((theForm.sacadoEndereco.value == "") || (theForm.sacadoEndereco.value.length < 3) || (theForm.sacadoEndereco.value.length > 40))
  {
    alert("Informar o campo Endereço com 3 a 40 caracteres");
    theForm.sacadoEndereco.focus();
    return (false);
  }

  if ((!Valido(theForm.sacadoCep.value,"0123456789-")) )//|| (theForm.sacadoCep.value.length < 9))
  {
    alert("Informar o campo Cep no formato 00000-000");
    theForm.sacadoCep.focus();
    return (false);
  }
  
    if ((theForm.sacadoCidade.value == "") || (theForm.sacadoCidade.value.length < 3) || (theForm.sacadoCidade.value.length > 20))
  {
    alert("Informar o campo Cidade com 3 a 20 caracteres");
    theForm.sacadoCidade.focus();
    return (false);
  }
  
  
  if ((theForm.sacadoEstado.value == "") || (theForm.sacadoEstado.value.length < 2))
  {
    alert("Informar o campo Estado");
    theForm.sacadoEstado.focus();
    return (false);
  }

  if   ((!Valido(theForm.valor.value,"0123456789.,")) || (theForm.valor.value == ",,") || (theForm.valor.value == ""))
  {
    alert("Informar o campo Valor do boleto no formato 1.000,00");
    theForm.valor.focus();
    return (false);
  }

  /*
  Se a data for 00/00/0000 é como "válida" 
  */
  if(theForm.dataVencimento.value != "00/00/0000" )
  {
	  if   ((!Valido(theForm.dataVencimento.value,"0123456789/")) || (theForm.dataVencimento.value.length < 10))
	  {
	    alert("Informar o campo Data de Vencimento no formato 00/00/0000");
	    theForm.dataVencimento.focus();
	    return (false);
	  }
	  else if (!ValidaData(theForm.dataVencimento)) {
		alert("Data inválida ou fora do limite permitido!")
		return false;
	  }
   }


 if ((!Valido(theForm.nossoNumero.value,"0123456789")) || (theForm.nossoNumero.value.length < 1))
  {
    alert("Informar o campo Nosso Número com no mínimo 1 caractere numérico.");
    theForm.nossoNumero.focus();
    return (false);
  }

/*
 if (theForm.numDocumento.value.length < 15)
  {
    alert("Informar o campo Número do Documento com 15 dígitos numéricos");
    theForm.numDocumento.focus();
    return (false);
  }
*/
 
 for (var i=1; i<=4; i++) {
 	if (eval("theForm.msgCompensacao"+i+".value.length") > 60)
 	 {
 	   alert("Informar o campo \"Mensagem da ficha de compensação "+i+"\" com no maximo 60 caracteres.");
 	   eval("theForm.msgCompensacao"+i+".focus()");
 	   return (false);
 	 }
 }


  return (true);
}



/**
 * Funcao que mascara o valor CEP. 
 * Valor retornado com separador "-"   
  * Ex.: 12345-678
 */

function MascaraCEP (keypress, valorCEP) {
	caracteres = '01234567890';
	separacoes = 1;
	separacao1 = '-';
	conjuntos = 2;
	conjunto1 = 5;
	conjunto2 = 3;
	if ( (caracteres.search(String.fromCharCode (keypress))!=-1) 
        && (valorCEP.value.length < (conjunto1 + conjunto2 + 1)) ){
		if (valorCEP.value.length == conjunto1) 
		   valorCEP.value = valorCEP.value + separacao1;
	}
	else {
		event.returnValue = false;
	}
}


// dado um objeto, verifica se este eh um numero
function verificaDigito(obj){
 	string = obj.value;

	if (!numero(string))
		obj.value = obj.value.substring(0, obj.value.length - 1);
	return;
}


// funcao que verifica se dado um string eh string numerico
function numero(string){
    if (!string) return false;
    var Chars = "0123456789";

    for (var i = 0; i < string.length; i++) {
       if (Chars.indexOf(string.charAt(i)) == -1)
          return false;
    }
    return true;
} 