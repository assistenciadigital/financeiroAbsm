/**
 * barcode.js
 * Funcao Javascript para mostrar as barras do barcode
 * @author      wlung
 * @since       18/06/2003
 * @version     1.0
 * (C) Opus Comunicação de Dados, 2003.
 */
 
var BAR_HEIGHT = "50";
var BAR_WIDTH = "1";

var BAR_BLACK  = "<img src='images/black.jpg' height='"+BAR_HEIGHT+"' width="+BAR_WIDTH+">";
var BAR_WHITE  = "<img src='images/white.jpg' height='"+BAR_HEIGHT+"' width="+BAR_WIDTH+">";
var BAR_3BLACK = "<img src='images/black.jpg' height='"+BAR_HEIGHT+"' width="+(BAR_WIDTH*3)+">";
var BAR_3WHITE = "<img src='images/white.jpg' height='"+BAR_HEIGHT+"' width="+(BAR_WIDTH*3)+">";

var BAR_START = BAR_BLACK + BAR_WHITE + BAR_BLACK + BAR_WHITE;
var BAR_END   = BAR_BLACK + BAR_BLACK + BAR_BLACK + BAR_WHITE + BAR_BLACK;

/* funcao que retorna a figura do codigo de barra */
function showBarcodeImage(codeBinImage){
	var codeBinLength = codeBinImage.length;
	var isBarBlack = false;
	var barcodeImage = "";

	barcodeImage = BAR_START;
	for (var i=0; i<codeBinLength; i++) {
		isBarBlack = !isBarBlack;
		if (codeBinImage.charAt(i)=='0') {
			barcodeImage += (isBarBlack)?BAR_BLACK:BAR_WHITE;
	    }
	    else {   // == 1
			barcodeImage += (isBarBlack)?BAR_3BLACK:BAR_3WHITE;
	    }
	}
	barcodeImage += BAR_END;
	return barcodeImage;
}

