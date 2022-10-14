<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Intranet</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<? //encabezados con path
echo '<link rel="icon" href="'.$_SESSION["NivelArbol"].'favicon.ico" type="image/x-icon" />';
echo '<link rel="shortcut icon" href="'.$_SESSION["NivelArbol"].'favicon.ico" type="image/x-icon" />';

echo '<link href="'.$_SESSION["NivelArbol"].'Codigo/calendar/calendar.css" rel="stylesheet" type="text/css" />';
echo '<script language="javascript" src="'.$_SESSION["NivelArbol"].'Codigo/calendar/calendar.js"></script>';
echo '<script type="text/javascript" src="'.$_SESSION["NivelArbol"].'Codigo/jquery/jquery.js"></script>';
echo '<script type="text/javascript" src="'.$_SESSION["NivelArbol"].'Codigo/jquery/maskedinput.js"></script>';

echo '<link rel="STYLESHEET" type="text/css" href="'.$_SESSION["NivelArbol"].'CSS/fontawesome/css/all.css">';	
echo '<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />';
echo '<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">';

//no guarda cache
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>



<script type="text/javascript">

/* hora */
$(document).ready(function() { $("input[type=text][id*=time]").mask("99:99");});
$(document).ready(function() { $("input[type=text][id*=date]").mask("99-99-9999");});


function validarEnteroCompletar(valor,ceros,cant){
	valor = parseInt(valor,10);
	if (isNaN(valor) ) {
		alert('Por favor ingresar un numero entero') 
		valor="";
	}else{
		valor=String(ceros + valor).slice(cant);		
	}
	return valor
}

function validarMoneda(valor){
	var re=/^(\d{1,3}.)*\d{1,3}(\,\d+)?$/;
	if (re.test(valor)) return valor
	else{
		alert('Por favor utilice el formato 1.000,00') 
		return ""
	}
}


function validarEntero(valor){
	valor = parseInt(valor,10);
	if (isNaN(valor)  ) {
		/* alert('Por favor ingresar un numero entero') */
		return ""
	}else{
		return valor
	}

}

function validarNumero(valor){
	if (isNaN(valor)  ) {
		/* alert('Por favor ingresar un numero') */
		return ""
	}else{
		return valor
	}
}

function validarNumeroP(valor){/* decimal positivo */
	if ( isNaN(valor) || valor<0 ) {
		/* alert('Por favor ingresar un numero') */
		return ""
	}else{
		return valor
	}
}

function validarNumeroR(valor){/* reemplaza la coma por el punto */
	valor = valor.replace(',','.');
	if (isNaN(valor) ) {
		return ""
	}else{
		return valor
	}
}


function OverRow(n,valor){	
		var elemento = document.getElementById(n);
		if(valor==1){elemento.style.fontWeight="bold";}else{elemento.style.fontWeight="normal";} 	
} 

/* funciones para seleccionar con color filas checked  */
function CheckRowShadow(n,valor){	
		var elemento = document.getElementById(n);
		if(valor==1){elemento.style.backgroundColor="#e9efef";elemento.style["boxShadow"] = "0 0 5px #999999";}
		else{elemento.style.backgroundColor="#ffffff";elemento.style["boxShadow"] = "none";} 	
} 

function CheckRow(n,valor){	
		var elemento = document.getElementById(n);
		if(valor==1){elemento.style.backgroundColor="#e9efef";}else{elemento.style.backgroundColor="#ffffff";} 	
} 
function CheckTableRow(n,valor){
	for (var i=1;i < document.getElementById(n).rows.length;i++){	
		var elemento = document.getElementById(n).rows[i];
		if(valor==1){elemento.style.backgroundColor="#e9efef";}else{elemento.style.backgroundColor="#ffffff";} 	
	}
} 
function CheckMasivoColor(){	
	for (var i=0;i < document.Formulario.elements.length;i++){
		var elemento = document.Formulario.elements[i];
		if (elemento.type == "checkbox" && elemento.id!="ro"){
			elemento.checked = document.Formulario.ChkAll.checked;
			if (elemento.checked==1) {elemento.value=1;}else{elemento.value=0;}
			
		}
	}
	CheckTableRow("tshow",document.Formulario.ChkAll.value);	
} 




/* para pagina con dos tablas primer tabla */
function CheckMasivoC1(){	
	for (var i=0;i < document.Formulario.elements.length;i++){
		var elemento = document.Formulario.elements[i];
		if (elemento.type == "checkbox" && elemento.id=="c1"){
			elemento.checked = document.Formulario.ChkAll1.checked;
			if (elemento.checked==1) {elemento.value=1;}else{elemento.value=0;}
			
		}
	}
} 
/* para pagina con dos tablas segunda tabla */
function CheckMasivoC2(){	
	for (var i=0;i < document.Formulario.elements.length;i++){
		var elemento = document.Formulario.elements[i];
		if (elemento.type == "checkbox" && elemento.id=="c2"){
			elemento.checked = document.Formulario.ChkAll2.checked;
			if (elemento.checked==1) {elemento.value=1;}else{elemento.value=0;}
			
		}
	}
} 


function CheckMasivo(){	
	for (var i=0;i < document.Formulario.elements.length;i++){
		var elemento = document.Formulario.elements[i];
		if (elemento.type == "checkbox"){elemento.checked = document.Formulario.ChkAll.checked;elemento.value = document.Formulario.ChkAll.value;}
	}
} 

function CheckMasivo2(){	
	for (var i=0;i < document.Formulario.elements.length;i++){
		var elemento = document.Formulario.elements[i];
		if (elemento.type == "checkbox"  && elemento.id == "5"){elemento.checked = document.Formulario.ChkAll.checked;elemento.value = document.Formulario.ChkAll.value;}
	}
} 

function CheckMasivo5(){	
	for (var i=0;i < document.Formulario.elements.length;i++){
		var elemento = document.Formulario.elements[i];
		if (elemento.type == "checkbox" && elemento.id!="ro"){
			elemento.checked = document.Formulario.ChkAll.checked;
			if (elemento.checked==1) {elemento.value=1;}else{elemento.value=0;};
		}
	}
} 




function enterxtab(e) {
	if (e.keyCode==13){e.keyCode=9}	
}


function validarFecha(Cadena){  
	Cadena = Cadena.replace(/\//g,'-');//reemplaza 'barra' por 'guion'
	if (Cadena!=""){
		 var Fecha= new String(Cadena)   
		 var RealFecha= new Date()  
	  
	  	if (Fecha.lastIndexOf("-")>0){
			 var Anio= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))   
			 var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))  
			 var Dia= new String(Fecha.substring(0,Fecha.indexOf("-"))) 
		 }else{		  
			 var Anio= new String(Fecha.substring(4)) 
			 var Mes= new String(Fecha.substring(2,4))
			 var Dia= new String(Fecha.substring(0,2))
		}

		 if (isNaN(Anio) || (Anio.length<4) || (parseFloat(Anio)<1900) || (Anio=='')){  
			 alert('Por favor ingresar formato ddmmyyyy')  
			 return ""  
		 }  
	 
		 if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12 || (Mes=='')){  
			 alert('Por favor ingresar formato ddmmyyyy')  
			 return ""  
		 }  
	
		 if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31  || (Anio=='')){  
			 alert('Por favor ingresar formato ddmmyyyy')  
			 return ""  
		 }  
		 if (Mes==4 || Mes==6 || Mes==9 || Mes==11) {  
			 if (Dia>30) {  
				 alert('Por favor ingresar formato ddmmyyyy')  
				 return ""  
			 }  
		 } 
		 if (Mes==2) {  
			 if (Dia > 29) {  
				 alert('Por favor ingresar formato ddmmyyyy')  
				 return ""  
			 } 
			 if ((Anio % 4 == 0) && ((Anio % 100 != 0) || (Anio % 400 == 0))){var Bisiesto=1;}else{var Bisiesto=0;}		
			 if (Dia == 29 && Bisiesto==0) {  
				 alert('Por favor ingresar formato ddmmyyyy')  
				 return ""  
			 } 
		 } 
		 	 
		 
		  
		return Dia + "-" + Mes + "-" + Anio
	}
	else{
		return ""
	}
 }  





function validarHora(Cadena){//hora:minutos  
	if (Cadena!=""){
		 var Hora= new String(Cadena) 
		 var hh= new String(Hora.substring(0,2)) 
		 var div= new String(Hora.substring(2,3))    
		 var mm= new String(Hora.substring(3,5))  

		 if (isNaN(hh) || isNaN(mm) || hh<0 || hh>23 || mm<0 || mm>59 || (div!=':')){  
			 alert('Por favor ingresar formato hh:mm')  
			 return ""  
		 }
		 return Cadena
	}
	else{
		return ""
	}
 } 
 


</script>