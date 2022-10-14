<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
 
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
 
 
 
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
function MostrarTabla($conn){
$id=intval($_GET['Id']);
$query="SELECT a.*, ac.Nombre as Cambio, p.Nombre, p.Apellido,d.Id,d.Codigo From iso_doc_auditoria a, iso_doc_audicambios ac, personal p,usuarios u,iso_doc d where a.IdDoc=d.Id and a.IdCambio=ac.Id and a.IdUsuario=u.Usuario and u.IdPersonal=p.Id and a.IdDoc=$id Order by a.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .="<table width="."740"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato"."> Fecha</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Documento</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."150"." class="."TablaTituloDato"."> Cambio</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."250"." class="."TablaTituloDato"."> Usuario</td>";  
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".FormatoFechaHora($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".str_pad($row['Id'], 5, "0", STR_PAD_LEFT).' '.substr($row['Codigo'],0,15)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Cambio'],0,20)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</td>"; 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}	
$tablaclientes .="</table>";echo $tablaclientes;	
mysql_free_result($rs);

}


 ?>
<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
</head>



<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.forms['Formulario']['TxtFecha'].focus()">
<? include ("../Codigo/BannerPopUp.php");?>


<form name="Formulario" action="<?=$PHP_SELF?>" method="post" onKeyPress="if (event.which == 13 || event.keyCode == 13){return false;}">
<?php GLO_tituloypath(950,740,'sgi','AUDITORIA','close'); ?>

<table width="740" border="0"  cellpadding="0" cellspacing="0" class="fondo" >
<tr> <td width="740" height="5"  ></td> </tr>
<tr> <td  align="center" ><?php MostrarTabla($conn); ?></td></tr>
<tr><td height="18"  align="right"  >&nbsp;</td><td colspan="3" valign="top" > </td></tr>
<tr> <td height="5"></td></tr>
</table>

<? GLO_cierratablaform(); ?>
<? mysql_close($conn); ?>
	


<? include ("../Codigo/FooterConUsuario.php");?>




