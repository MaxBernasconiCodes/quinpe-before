<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("../Conceptos/zFunciones.php");
require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT * From servicios where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['CbCliente'] = $row['IdCliente'];
	$_SESSION['CbTipoC'] = $row['IdTipo'];
	$_SESSION['OptTipoI'] = $row['Interno'];
	$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaAlta']);
	$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaBaja']);
	$_SESSION['CbTipoContrato'] = $row['IdTipoContrato'];
}mysql_free_result($rs);



function TablaItems($idpadre,$conn){ 
$query="SELECT si.*, i.Nombre,i.Tipo From itemscliente_serv si, items i where si.IdItem=i.id and si.Id<>0 and si.IdPadre=$idpadre Order by i.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="700" class="TableShow" id="tshow" style="margin-top:5px;margin-bottom:10px;"><tr>';
$tablaclientes .='<td width="670" class="TableShowT" colspan="2"> <i class="fa fa-tag iconsmallsp iconlgray"></i> Items</td>';   
$tablaclientes .='<td width="30" class="TableShowT TAR">'.GLO_FAButton('CmdAddI','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='</tr>';             
$recuento=0; $estilo=" style='cursor:pointer;'";
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarItem.php?Flag1=True"."&itemcliente=".$row['Id']."'";
	$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
	$tablaclientes .="<td class="."TableShowD".$link.' width="600" >'.substr($row['Nombre'],0,40)."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link.' width="70" >'.IT_tipoitem($row['Tipo'])."</td>"; 
	$tablaclientes .='<td class="TableShowD TAR">'.GLO_rowbutton("CmdBorrarFilaI",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  
	$tablaclientes .='</tr>'; 
	$recuento=$recuento+1;
}mysql_free_result($rs);	
//Cerrar tabla
$tablaclientes .='</table>'; 
echo $tablaclientes;	
}


GLOF_Init('CbCliente','BannerConMenuHV','zModificar',0,'MenuH',0,0,0); 
include ("Includes/zCampos.php");


TablaItems($_SESSION['TxtNumero'],$conn);
GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"servicios_adj","700","Adjuntos/","Archivos adjuntos","paperclip",0,0,1);

mysql_close($conn);   
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>