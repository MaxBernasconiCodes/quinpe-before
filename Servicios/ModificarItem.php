<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['itemcliente'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//tomo los get
$iditemcliente=intval($_GET['itemcliente']);


//busco datos item
$query="SELECT si.*,i.Nombre From itemscliente_serv si,items i where si.idItem=i.Id and si.Id<>0 and si.Id=$iditemcliente"; 
$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){
	$_SESSION['TxtNumero'] =$row['Id'];$_SESSION['CbItem'] =$row['Nombre'];$_SESSION['TxtNroEntidad']=$row['IdPadre'];
}mysql_free_result($rs);




function TablaLineaB($idpadre,$conn){ 
$query="SELECT sib.*,s2.Nombre From itemscliente_serv_b sib,serviciostipo s2 where sib.Id<>0 and sib.IdLB=s2.Id and sib.IdPadre=$idpadre Order by s2.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .='<table width="500" class="TableShow TMT" id="tshow"><tr>';
$tablaclientes .="<td "."width="."400"." class="."TableShowT"."> Linea B</td>";
$tablaclientes .="<td "."width="."60"." class="."TableShowT"."> Codigo</td>";     
$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddI','submit','','self','Agregar','add','iconbtn')." </td>"; 
$tablaclientes .='</tr>'; 
$estilo=" style='cursor:pointer;'";            
while($row=mysql_fetch_array($rs)){ 
	$link=" onclick="."location='ModificarLB.php?Flag1=True"."&itemcliente=".$row['Id']."'";
	$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
	$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Nombre'],0,40)."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".$row['Cod']."</td>"; 
	$tablaclientes .='<td class="TableShowD TAR">'.GLO_rowbutton("CmdBorrarFilaI",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  
	$tablaclientes .='</tr>'; 
}mysql_free_result($rs);	
//Cerrar tabla
$tablaclientes .='</table>'; 
echo $tablaclientes;	
}


GLOF_Init('','BannerPopUp','zModificarItem',0,'',0,0,0); 
GLO_tituloypath(0,500,'','ITEM','salir'); 

?> 


<table width="500" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="400"></td> </tr>
<tr> <td height="18"  align="right"  >Item:</td><td  valign="top" >&nbsp;<input name="CbItem" type="text"  class="TextBoxRO" readonly="true" style="width:350px"  value="<? echo $_SESSION['CbItem']; ?>" ></td></tr>
</table>



<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);
GLO_mensajeerror();
TablaLineaB($_SESSION['TxtNumero'],$conn);
mysql_close($conn); 
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>