<? include("../Codigo/Seguridad.php");include("../Codigo/Funciones.php");include("../Codigo/Config.php");$_SESSION["NivelArbol"]="../";

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query="SELECT r.*,s.Nombre as Sector,p.Nombre,p.Apellido From co_autorizantes r,personal p,sector s where p.Id=r.IdPersonal and s.Id=r.IdSector and r.Id<>0 Order by r.FechaB,s.Nombre,p.Apellido,p.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .=GLO_inittabla(750,1,0,0);
$tablaclientes .="<td "."width="."200"." class="."TableShowT".">Sector</td>";   
$tablaclientes .="<td "."width="."400"." class="."TableShowT".">Nombre</td>";   
$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Tipo</td>"; 
$tablaclientes .='<td width="50" class="TableShowT TAC">Firma</td>';   
$tablaclientes .='</tr>';             
$recuento=0; $estilo=" style='cursor:pointer;' ";
while($row=mysql_fetch_array($rs)){ 	
	$link=" onclick="."location='ModificarAuto.php?Flag1=True&id=".$row['Id']."'";
	$fbaja= GLO_FormatoFecha($row['FechaB']);if ($fbaja==''){$clase="TableShowD";}else{$clase="TableShowD TGray";}
	if ($row['Tipo']==1){$tipo="PreAutorizante";}else{$tipo="Autorizante";}//1:pre, 2:auto
	if ($row['Ruta']==''){$firma="";}else{$firma='<i class="fas fa-check iconvsmall iconlgray"></i>';}//1:pre, 2:auto
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Sector'],0,20)."</td>"; 
	$tablaclientes .='<td class="'.$clase.'"'.$link."> ".substr($row['Apellido'].' '.$row['Nombre'],0,50)."</td>"; 
	$tablaclientes .='<td class="'.$clase.'"'.$link."> ".$tipo."</td>"; 
	$tablaclientes .='<td class="'.$clase.' TAC"'.$link."> ".$firma."</td>"; 
	$tablaclientes .='</tr>';
	$recuento=$recuento+1;
}	
$tablaclientes .=GLO_fintabla(1,0,$recuento);
echo $tablaclientes;	
mysql_free_result($rs);
}


GLOF_Init('','BannerConMenuHV','zAutorizantes',0,'MenuH',0,0,0);
GLO_tituloypath(0,750,'','AUTORIZANTES','basica');

GLO_mensajeerror();
GLO_Hidden('TxtId',0);
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(750,0);
echo 'Los <font class="comentario2">Autorizantes</font> tambi&eacute;n pueden actuar como <font class="comentario3">PreAutorizantes</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>