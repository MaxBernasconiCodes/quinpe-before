<? include("../Codigo/Seguridad.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



function MostrarTablaPIN($conn){

$query=$_SESSION['TxtQ1'];$query=str_replace("\\", "", $query);

if ( ($query!="")){	

	$rs=mysql_query($query,$conn);

	//Titulos de la tabla

	$tablaclientes='';

	$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" ><tr>';

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";  

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"." style='text-align:right;'> Pedido</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Fecha</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."380"." class="."TablaTituloDato"."> Proveedor</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato"."> Estado</td>";   

	$tablaclientes .='<td class="TablaTituloRight"></td>';  

	$tablaclientes .='</tr>';    

	$recuento=0;          

	//Datos

	while($row=mysql_fetch_array($rs)){ 

		if($row['Id']!=0){

			$estilo="";$link="";$clase="TablaDato";		

			//estado

			$colorest='';

			if($row['IdEstado']==3){$colorest=' style="font-weight:bold;color:#4CAF50"';}

			if($row['IdEstado']==4 or $row['IdEstado']==5){$colorest=' style="font-weight:bold;color:#f44336"';}

			if($row['IdEstado']==6){$colorest=' style="font-weight:bold;color:#00bcd4"';}

			//muestro

			$tablaclientes .='<tr '.$estilo.'>';  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".""."</td>";  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link.$colorest."> ".substr($row['Estado'],0,20)."</td>";  

			$tablaclientes .='<td class="TablaMostrarRight"></td>';  

			$tablaclientes .='</tr>'; 

			$recuento=$recuento+1;

		}

	}	

	//Cerrar tabla

	$tablaclientes .="</table>"; 

	$tablaclientes .="<p class="."recuento"." align="."right"."> $recuento registros</p>"; 

	echo $tablaclientes;

	mysql_free_result($rs);

}

}







function MostrarTablaCOT($conn){

$query=$_SESSION['TxtQ2'];$query=str_replace("\\", "", $query);

if ( ($query!="")){	

	$rs=mysql_query($query,$conn);

	//Titulos de la tabla

	$tablaclientes='';

	$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" ><tr>';

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Fecha</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."450"." class="."TablaTituloDato"."> Proveedor</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato"."> Estado</td>";   

	$tablaclientes .='<td class="TablaTituloRight"></td>';  

	$tablaclientes .='</tr>';    

	$recuento=0;          

	//Datos

	while($row=mysql_fetch_array($rs)){ 

		if($row['Id']!=0){

			$estilo="";$link="";$clase="TablaDato";		

			//estado

			$colorest='';

			if($row['IdEstado']==3){$colorest=' style="font-weight:bold;color:#4CAF50"';}

			if($row['IdEstado']==4){$colorest=' style="font-weight:bold;color:#f44336"';}

			if($row['IdEstado']==5){$colorest=' style="font-weight:bold;color:#00bcd4"';}

			//muestro

			$tablaclientes .='<tr '.$estilo.'>';  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Prov'],0,40)."</td>";  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link.$colorest."> ".substr($row['Estado'],0,20)."</td>";  

			$tablaclientes .='<td class="TablaMostrarRight"></td>';  

			$tablaclientes .='</tr>'; 

			$recuento=$recuento+1;

		}

	}	

	//Cerrar tabla

	$tablaclientes .="</table>"; 

	$tablaclientes .="<p class="."recuento"." align="."right"."> $recuento registros</p>"; 

	echo $tablaclientes;

	mysql_free_result($rs);

}

}



function MostrarTablaOCO($conn){

$query=$_SESSION['TxtQ3'];$query=str_replace("\\", "", $query);

if ( ($query!="")){	

	$rs=mysql_query($query,$conn);

	//Titulos de la tabla

	$tablaclientes='';

	$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" ><tr>';

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"." style='text-align:right;'> Orden</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Fecha</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."380"." class="."TablaTituloDato"."> Proveedor</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato"."> Estado</td>";   

	$tablaclientes .='<td class="TablaTituloRight"></td>';  

	$tablaclientes .='</tr>';    

	$recuento=0;          

	//Datos

	while($row=mysql_fetch_array($rs)){ 

		if($row['Id']!=0){

			$estilo="";$link="";$clase="TablaDato";		

			//estado

			$colorest='';

			if($row['IdEstado']==2){$colorest=' style="font-weight:bold;color:#4CAF50"';}

			if($row['IdEstado']==5){$colorest=' style="font-weight:bold;color:#00bcd4"';}

			if($row['IdEstado']==3 or $row['IdEstado']==6){$colorest=' style="font-weight:bold;color:#f44336"';}				

			//muestro

			$tablaclientes .='<tr '.$estilo.'>';  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Prov'],0,40)."</td>";  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link.$colorest."> ".substr($row['Estado'],0,20)."</td>";  

			$tablaclientes .='<td class="TablaMostrarRight"></td>';  

			$tablaclientes .='</tr>'; 

			$recuento=$recuento+1;

		}

	}	

	//Cerrar tabla

	$tablaclientes .="</table>"; 

	$tablaclientes .="<p class="."recuento"." align="."right"."> $recuento registros</p>"; 

	echo $tablaclientes;

	mysql_free_result($rs);

}

}







function MostrarTablaFAC($conn){

$query=$_SESSION['TxtQ4'];$query=str_replace("\\", "", $query);

if ( ($query!="")){	

	$rs=mysql_query($query,$conn);

	//Titulos de la tabla

	$tablaclientes='';

	$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" ><tr>';

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Factura</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Fecha</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."350"." class="."TablaTituloDato"."> Proveedor</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato"."> Estado</td>";   

	$tablaclientes .='<td class="TablaTituloRight"></td>';  

	$tablaclientes .='</tr>';    

	$recuento=0;          

	//Datos

	while($row=mysql_fetch_array($rs)){ 

		if($row['Id']!=0){

			$estilo="";$link="";$clase="TablaDato";		

			//estado

			$colorest='';

			if($row['IdEstado']==1){$colorest=' style="font-weight:bold;color:#f44336"';}

			if($row['IdEstado']==2){$colorest=' style="font-weight:bold;color:#4CAF50"';}

			$factura=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT).'-'.str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);

			//muestro

			$tablaclientes .='<tr '.$estilo.'>';  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".$factura."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Prov'],0,40)."</td>";  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link.$colorest."> ".substr($row['Estado'],0,20)."</td>";  

			$tablaclientes .='<td class="TablaMostrarRight"></td>';  

			$tablaclientes .='</tr>'; 

			$recuento=$recuento+1;

		}

	}	

	//Cerrar tabla

	$tablaclientes .="</table>"; 

	$tablaclientes .="<p class="."recuento"." align="."right"."> $recuento registros</p>"; 

	echo $tablaclientes;

	mysql_free_result($rs);

}

}







function MostrarTablaNC($conn){

$query=$_SESSION['TxtQ5'];$query=str_replace("\\", "", $query);

if ( ($query!="")){	

	$rs=mysql_query($query,$conn);

	//Titulos de la tabla

	$tablaclientes='';

	$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" ><tr>';

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Nota Cr&eacute;dito</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Fecha</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."490"." class="."TablaTituloDato"."> Proveedor</td>";   

	$tablaclientes .='<td class="TablaTituloRight"></td>';  

	$tablaclientes .='</tr>';    

	$recuento=0;          

	$estilo="";$link="";$clase="TablaDato";	

	while($row=mysql_fetch_array($rs)){ 

		if($row['Id']!=0){

			$nc=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT).'-'.str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);

			//muestro

			$tablaclientes .='<tr '.$estilo.'>';  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".$nc."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Prov'],0,40)."</td>";  

			$tablaclientes .='<td class="TablaMostrarRight"></td>';  

			$tablaclientes .='</tr>'; 

			$recuento=$recuento+1;

		}

	}	

	//Cerrar tabla

	$tablaclientes .="</table>"; 

	$tablaclientes .="<p class="."recuento"." align="."right"."> $recuento registros</p>"; 

	echo $tablaclientes;

	mysql_free_result($rs);

}

}





function MostrarTablaRI($conn){

$query=$_SESSION['TxtQ6'];$query=str_replace("\\", "", $query);

if ( ($query!="")){	

	$rs=mysql_query($query,$conn);

	//Titulos de la tabla

	$tablaclientes='';

	$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" ><tr>';

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Remito</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Fecha</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."490"." class="."TablaTituloDato"."> Proveedor</td>";   

	$tablaclientes .='<td class="TablaTituloRight"></td>';  

	$tablaclientes .='</tr>';    

	$recuento=0;          

	$estilo="";$link="";$clase="TablaDato";	

	while($row=mysql_fetch_array($rs)){ 

		if($row['Id']!=0){

			$rem=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT).'-'.str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);

			//muestro

			$tablaclientes .='<tr '.$estilo.'>';  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".$rem."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Prov'],0,40)."</td>";  

			$tablaclientes .='<td class="TablaMostrarRight"></td>';  

			$tablaclientes .='</tr>'; 

			$recuento=$recuento+1;

		}

	}	

	//Cerrar tabla

	$tablaclientes .="</table>"; 

	$tablaclientes .="<p class="."recuento"." align="."right"."> $recuento registros</p>"; 

	echo $tablaclientes;

	mysql_free_result($rs);

}

}





function MostrarTablaRE($conn){

$query=$_SESSION['TxtQ7'];$query=str_replace("\\", "", $query);

if ( ($query!="")){	

	$rs=mysql_query($query,$conn);

	//Titulos de la tabla

	$tablaclientes='';

	$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" ><tr>';

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"." style='text-align:right;'> Interno</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Remito</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> Fecha</td>";   

	$tablaclientes .='<td class="TablaTituloLeft"></td>';

	$tablaclientes .="<td "."width="."490"." class="."TablaTituloDato"."> Proveedor</td>";   

	$tablaclientes .='<td class="TablaTituloRight"></td>';  

	$tablaclientes .='</tr>';    

	$recuento=0;          

	$estilo="";$link="";$clase="TablaDato";	

	while($row=mysql_fetch_array($rs)){ 

		if($row['Id']!=0){

			$rem=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT).'-'.str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);

			//muestro

			$tablaclientes .='<tr '.$estilo.'>';  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".$rem."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".FormatoFecha($row['Fecha'])."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Prov'],0,40)."</td>";  

			$tablaclientes .='<td class="TablaMostrarRight"></td>';  

			$tablaclientes .='</tr>'; 

			$recuento=$recuento+1;

		}

	}	

	//Cerrar tabla

	$tablaclientes .="</table>"; 

	$tablaclientes .="<p class="."recuento"." align="."right"."> $recuento registros</p>"; 

	echo $tablaclientes;

	mysql_free_result($rs);

}

}















function ComboComprobantes(){

$combo="";

if( "1" == $_SESSION['CbComp']) { $combo .= " <option value="."'1'"." selected='selected'>"."Notas de Pedido"."</option>\n";}

else{$combo .= " <option value="."'1'"." >"."Notas de Pedido"."</option>\n";}

if( "2" == $_SESSION['CbComp']) { $combo .= " <option value="."'2'"." selected='selected'>"."Pedidos de Cotizaci&oacute;n"."</option>\n";}

else{$combo .= " <option value="."'2'"." >"."Pedidos de Cotizaci&oacute;n"."</option>\n";}

if( "3" == $_SESSION['CbComp']) { $combo .= " <option value="."'3'"." selected='selected'>"."Ordenes de Compra"."</option>\n";}

else{$combo .= " <option value="."'3'"." >"."Ordenes de Compra"."</option>\n";}

if( "4" == $_SESSION['CbComp']) { $combo .= " <option value="."'4'"." selected='selected'>"."Facturas de Compra"."</option>\n";}

else{$combo .= " <option value="."'4'"." >"."Facturas de Compra"."</option>\n";}

if( "5" == $_SESSION['CbComp']) { $combo .= " <option value="."'5'"." selected='selected'>"."Notas de Credito"."</option>\n";}

else{$combo .= " <option value="."'5'"." >"."Notas de Credito"."</option>\n";}

if( "6" == $_SESSION['CbComp']) { $combo .= " <option value="."'6'"." selected='selected'>"."Remitos de Ingreso"."</option>\n";}

else{$combo .= " <option value="."'6'"." >"."Remitos de Ingreso"."</option>\n";}

if( "7" == $_SESSION['CbComp']) { $combo .= " <option value="."'7'"." selected='selected'>"."Remitos de Egreso"."</option>\n";}

else{$combo .= " <option value="."'7'"." >"."Remitos de Egreso"."</option>\n";}



echo $combo;

}







?> 





<? include ("../Codigo/HeadFull.php");?>

<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >



<? GLO_bodyform('',0,0);?>

<? include ("../Codigo/BannerConMenuHV.php");?>





<form  name="Formulario" action="zTrazabilidad.php" method="post">

<?php GLO_tituloypath(950,600,'compras','TRAZABILIDAD','salir'); ?>





<table width="600" border="0"   cellspacing="0" class="Tabla" >

<tr> <td height="5" width="90"></td><td width="200"></td><td width="120"></td><td width="110"></td><td width="80"></td></tr>

<tr> 

<td height="18"  align="right">&nbsp;Comprobante:</td><td  >&nbsp;<select name="CbComp" class="campos" id="CbComp"  style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboComprobantes(); ?></select></td>

<td  align="right">&nbsp;N&uacute;mero interno:</td><td >&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="width:70px"></td>

<td   align="right" ><input name="CmdBuscar"  type="submit" class="botonbuscar"  title="Buscar" value="" onClick="document.Formulario.target='_self'">&nbsp;</td></tr>

</table>









<? GLO_mensajeerror(); ?>



<table  width="600" border="0" cellspacing="0" cellpadding="0"  align="center">

<tr><td  height=2 ></td></tr>

<tr  valign="bottom"><td  valign="bottom" ><input  name="TxtId"  type="hidden"  value="<? echo $_SESSION['TxtId']; ?>"><input  name="TxtQ1"  type="hidden"  value="<? echo $_SESSION['TxtQ1']; ?>"><input  name="TxtQ2"  type="hidden"  value="<? echo $_SESSION['TxtQ2']; ?>"><input  name="TxtQ3"  type="hidden"  value="<? echo $_SESSION['TxtQ3']; ?>"><input  name="TxtQ4"  type="hidden"  value="<? echo $_SESSION['TxtQ4']; ?>"><input  name="TxtQ5"  type="hidden"  value="<? echo $_SESSION['TxtQ5']; ?>"><input  name="TxtQ6"  type="hidden"  value="<? echo $_SESSION['TxtQ6']; ?>"><input  name="TxtQ7"  type="hidden"  value="<? echo $_SESSION['TxtQ7']; ?>"></td>	</tr>

<tr><td  height=3 ></td></tr>

<tr ><td height="18" ><i class="fa fa-file-alt iconsmallsp iconlgray"></i>&nbsp;<strong>Notas de Pedido:</strong></td></tr>

<tr valign="top"> 	<td  align="center" valign="top" > 	<?php MostrarTablaPIN($conn); ?>	</td>	</tr>

<tr><td  height=6 ></td></tr>

<tr ><td height="18" ><i class="fa fa-file-alt iconsmallsp iconlgray"></i>&nbsp;<strong>Pedidos de Cotizaci&oacute;n:</strong></td></tr>

<tr valign="top"> 	<td  align="center" valign="top" > 	<?php MostrarTablaCOT($conn); ?>	</td>	</tr>

<tr><td  height=6 ></td></tr>

<tr ><td height="18" ><i class="fa fa-file-alt iconsmallsp iconlgray"></i>&nbsp;<strong>Ordenes de Compra:</strong></td></tr>

<tr valign="top"> 	<td  align="center" valign="top" > 	<?php MostrarTablaOCO($conn); ?>	</td>	</tr>

<tr><td  height="6" ></td></tr>

<tr ><td height="18" ><i class="fa fa-file-alt iconsmallsp iconlgray"></i>&nbsp;<strong>Facturas de Compra:</strong></td></tr>

<tr valign="top"> 	<td  align="center" valign="top" > 	<?php MostrarTablaFAC($conn); ?>	</td>	</tr>

<tr><td  height="6" ></td></tr>

<tr ><td height="18" ><i class="fa fa-file-alt iconsmallsp iconlgray"></i>&nbsp;<strong>Notas de Cr&eacute;dito:</strong></td></tr>

<tr valign="top"> 	<td  align="center" valign="top" > 	<?php MostrarTablaNC($conn); ?>	</td>	</tr>

<tr><td  height="6" ></td></tr>

<tr ><td height="18" ><i class="fa fa-file-alt iconsmallsp iconlgray"></i>&nbsp;<strong>Remitos de Ingreso:</strong></td></tr>

<tr valign="top"> 	<td  align="center" valign="top" > 	<?php MostrarTablaRI($conn); ?>	</td>	</tr>

<tr><td  height="6" ></td></tr>

<tr ><td height="18" ><i class="fa fa-file-alt iconsmallsp iconlgray"></i>&nbsp;<strong>Remitos de Egreso:</strong></td></tr>

<tr valign="top"> 	<td  align="center" valign="top" > 	<?php MostrarTablaRE($conn); ?>	</td>	</tr>



<tr><td  height=3 ></td></tr>



</table>



<? GLO_cierratablaform(); ?>



<? mysql_close($conn);

$_SESSION['TxtId']=""; $_SESSION['TxtNroInterno']="";$_SESSION['CbComp']="";

$_SESSION['TxtQ1']="";$_SESSION['TxtQ2']="";$_SESSION['TxtQ3']="";$_SESSION['TxtQ4']="";$_SESSION['TxtQ5']="";$_SESSION['TxtQ6']="";$_SESSION['TxtQ7']="";

?>

		



<!-- Comentario-->

<table  width="750" border="0" cellspacing="0" cellpadding="0" >

<tr><td class="comentario">Seleccione el tipo y n&uacute;mero de <font class="comentario3">Comprobante</font> para realizar su seguimiento. </td></tr>

</table>

<!-- fin Comentario-->





<? include ("../Codigo/FooterConUsuario.php");?>