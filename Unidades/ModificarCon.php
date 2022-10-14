<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	//busco datos
	$query="SELECT p.* From unidades_con p where p.Id<>0 and p.Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbProv'] = $row['IdProv'];
		$_SESSION['TxtFechaA'] = FormatoFecha($row['FechaI']);if ($_SESSION['TxtFechaA']=='00-00-0000'){$_SESSION['TxtFechaA'] ="";}
		$_SESSION['TxtFechaB'] = FormatoFecha($row['FechaF']);if ($_SESSION['TxtFechaB']=='00-00-0000'){$_SESSION['TxtFechaB'] ="";}
	    $_SESSION['TxtNroCon'] = $row['NroCon'];	
		$_SESSION['TxtObs'] = $row['Obs'];
	}mysql_free_result($rs);
}


function MostrarTablaItems($idpadre,$conn){ 
$query="SELECT * From unidades_cont where Id<>0 and IdEntidad=$idpadre Order by Id Desc";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="700" border="0" cellspacing="0" cellpadding="0" ><tr>';
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Tarifa</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> Moneda</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Desde</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Hasta</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."360"." class="."TablaTituloDato"."> Observaciones</td>"; 
$tablaclientes .='<td class="TablaTituloLeft"></td>';  
$tablaclientes .="<td "."width="."40"." class="."TablaTituloDatoR".">".GLO_FAButton('CmdAddT','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>'; 
$estilo=" style='cursor:pointer;' ";            
while($row=mysql_fetch_array($rs)){ 
	if($row['Moneda']==0){$mon='Pesos';}else{$mon='Dolares';}	
	$link=" onclick="."location='ModificarConT.php?Flag1=True&item=".$row['Id']."'";
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
	$tablaclientes .="<td class="."TablaDato".$link."> ".GLO_MostrarImporte($row['Importe'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
	$tablaclientes .="<td class="."TablaDato".$link."> ".$mon."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".GLO_FormatoFecha($row['FechaD'])."</td>";
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".GLO_FormatoFecha($row['FechaH'])."</td>";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Obs'],0,45)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';    
	$tablaclientes .="<td class="."TablaDatoR"." >".GLO_rowbutton("CmdBorrarFilaT",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  
	$tablaclientes .='<td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>'; }	
//Cerrar tabla
$tablaclientes .="</table>"; 
echo $tablaclientes;	
mysql_free_result($rs);
}



?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.forms['Formulario']['CbTipo'].focus()">
<? include ("../Codigo/BannerPopUp.php");?>


<form name="Formulario" action="zModificarCon.php" method="post" onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}">
<? GLO_tituloypath(0,700,'','CONTRATOS','salir'); ?>



<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="150"></td><td width="450"></td></tr>
<tr><td height="18"  align="right"  >Proveedor:</td><td  valign="top" colspan="2">&nbsp;<select name="CbProv" style="width:550px" class="campos" id="CbProv"  tabindex="1" ><option value=""></option> <? ComboProveedorRFX("CbProv","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>
<tr><td height="18"  align="right"  >Inicio:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtFechaA" id="TxtFechaA"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"      ><label class="MuestraError"> * </label><?php  calendario("TxtFechaA","../Codigo/","actual"); ?></td></tr>
<tr><td height="18"  align="right"  >Fin:</td><td  valign="top" >&nbsp;<input name="TxtFechaB" id="TxtFechaB"   type="text" class="TextBox"  style="width:70px;" maxlength="10" tabindex="1" onChange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaB']; ?>"      ><label class="MuestraError"> * </label><?php  calendario("TxtFechaB","../Codigo/","actual"); ?></td><td></td></tr>
<tr><td height="18"  align="right"  >Contrato:</td><td  valign="top" colspan="2">&nbsp;<input name="TxtNroCon" type="text"  tabindex="1"  class="TextBox" style="text-align:right;width:70px" maxlength="10"  value="<? echo $_SESSION['TxtNroCon']; ?>" onChange="this.value=validarEntero(this.value);" ><label class="MuestraError"> * </label></td></tr>
</table>



<?
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_obsform(700,100,'Observaciones','TxtObs',2,0);
GLO_botonesform(700,0,2);
GLO_mensajeerror(); ?>            

<table width="700" border="0"  cellpadding="0" cellspacing="0" class="fondo" >
<tr> <td height="5" ></td></tr>
<tr ><td height="18" ><i class="fa fa-money-bill iconsmallsp iconlgray"></i> <strong>Tarifas:</strong></td><td align="right">&nbsp;</td></tr>
<tr> <td  align="center"  colspan="2"><?php MostrarTablaItems($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>

<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td><td align="right"></td></tr>
<tr> <td  align="center"  colspan="2"><?php GLO_TablaArchivos($_SESSION['TxtNumero'],$conn,"unidades_cona","700","Adjuntos/"); ?>	</td></tr>
</table>           

<? GLO_cierratablaform(); ?>

<? mysql_close($conn); 
?>			
				


<? include ("../Codigo/FooterConUsuario.php");?>