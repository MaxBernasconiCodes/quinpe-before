<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../"; 
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGETCLOSE($_GET['Id'],0,0);
GLO_ValidaGETCLOSE($_GET['IdD'],0,0);
 
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
function MostrarTabla($conn){
$id=intval($_GET['Id']);//producto
$iddep=intval($_GET['IdD']);//deposito
$idcliprop=intval($_GET['IdP']);//propietario
$query="SELECT s.*,d.Nombre as Deposito,t.Nombre as TipoM,a.Nombre as Articulo,i.Cantidad,i.IdItem,i.Id as IdIST,c.Nombre as Cliente From stockmov s,depositos d,stock_tipomov t,stockmov_items i,items a,clientes c where s.IdDeposito=d.Id and s.IdTipoMov=t.Id and i.IdMov=s.Id and i.IdItem=a.Id and s.IdCliente=c.Id and i.IdItem=$id and s.IdDeposito=$iddep and s.IdCliente=$idcliprop Order by s.Fecha,s.Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .=GLO_inittabla(760,1,0,0);
$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
$tablaclientes .="<td "."width="."120"." class="."TableShowT"."> Tipo</td>";   
$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Movim.</td>";   
$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Ingreso</td>";   
$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Egreso</td>"; 
$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'>Art&iacute;culo</td>"; 
$tablaclientes .="<td "."width="."200"." class="."TableShowT"."> Descripci&oacute;n</td>"; 
$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Dep&oacute;sito</td>"; 
$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Propietario</td>";
$tablaclientes .='</tr>';  
$recuento=0;$suma=0;$link='';$clase="TableShowD"; 
while($row=mysql_fetch_array($rs)){
	$ingreso="";$egreso="";	
	if($row['IdTipoMov']==1 or $row['IdTipoMov']==3){
		$ingreso=$row['Cantidad'];$suma=$suma+$row['Cantidad'];
	}else{
		$egreso=$row['Cantidad'];$suma=$suma-$row['Cantidad'];
	}	
	//muestro
	$tablaclientes .='<tr '.GLO_highlight($row['IdIST']).'>';  
	$tablaclientes .="<td class=".$clase.$link." > ".FormatoFecha($row['Fecha'])."</td>";
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['TipoM'],0,14)."</td>"; 
	$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";  
	$tablaclientes .='<td class="TableShowD TAR TBlue">'.$ingreso."</td>"; 
	$tablaclientes .='<td class="TableShowD TAR TRed">'.$egreso."</td>"; 
	$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['IdItem'], 6, "0", STR_PAD_LEFT)."</td>";  
	$tablaclientes .="<td class=".$clase.$link.' title="'.$row['Articulo'].'">'.substr($row['Articulo'],0,24)."</td>"; 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Deposito'],0,8)."</td>"; 
	$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Cliente'],0,12)."</td>"; 
	$tablaclientes .='</tr>'; 
	$recuento++;
}mysql_free_result($rs);	
$tablaclientes .=GLO_fintablaConSuma(0,0,$recuento,$suma,'total');
echo $tablaclientes;	
}


GLOF_Init('','BannerPopUp','',0,'',0,0,0); 
GLO_tituloypath(0,760,'','MOVIMIENTOS ARTICULO '.str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT),'close'); 

MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);

GLO_initcomment(760,0);
echo 'Muestra los movimientos del <font class="comentario2">Art&iacute;culo</font>, <font class="comentario3">Dep&oacute;sito</font> y <font class="comentario3">Cliente</font> seleccionados';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>