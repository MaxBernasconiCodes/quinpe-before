<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
 
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

 
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
function MostrarTabla($conn){
$id=intval($_GET['Id']);
$query="SELECT a.*, ac.Nombre as Cambio, p.Nombre, p.Apellido,nc.Id as IdNC From iso_nc_auditoria a, iso_nc_audicambios ac, personal p,usuarios u,iso_nc nc where a.IdNC=nc.Id and a.IdCambio=ac.Id and a.IdUsuario=u.Usuario and u.IdPersonal=p.Id and a.IdNC=$id Order by Id";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .=GLO_inittabla(650,0,0,0);
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato"."> Fecha</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."60"." class="."TablaTituloDato"."> NC</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."150"." class="."TablaTituloDato"."> Cambio</td>";  
$tablaclientes .='<td class="TablaTituloLeft"></td>'; 
$tablaclientes .="<td "."width="."300"." class="."TablaTituloDato"."> Usuario</td>";  
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".FormatoFechaHora($row['Fecha'])."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".str_pad($row['IdNC'], 5, "0", STR_PAD_LEFT)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Cambio'],0,20)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Apellido'].' '.$row['Nombre'],0,30)."</td>"; 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}mysql_free_result($rs);	
$tablaclientes .=GLO_fintabla(0,0,0);
echo $tablaclientes;	
}


GLOF_Init('','BannerPopUp','',0,'',0,0,0); 
GLO_tituloypath(0,650,'','HISTORIAL','close'); 

MostrarTabla($conn);
GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>