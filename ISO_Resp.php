<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query="SELECT r.*,a.Nombre as Accion,s.Nombre as Sector,p.Nombre,p.Apellido From iso_doc_resp r,iso_doc_acciones a,personal p,sector s where a.Id=r.IdAccion and p.Id=r.IdPersonal and s.Id=r.IdSector and r.Id<>0 Order by r.FechaB,s.Nombre,a.Id,p.Apellido,p.Nombre";
$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .=GLO_inittabla(650,0,0,0);
$tablaclientes .='<td class="TablaTituloLeft"></td>';
$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato".">Accion</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';  
$tablaclientes .="<td "."width="."390"." class="."TablaTituloDato".">Nombre</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';  
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Alta</td>";   
$tablaclientes .='<td class="TablaTituloLeft"></td>';  
$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Baja</td>";   
$tablaclientes .='<td class="TablaTituloRight"></td>';  
$tablaclientes .='</tr>';             
$recuento=0; 
while($row=mysql_fetch_array($rs)){ 
	$estilo=" style='cursor:pointer;' ";
	$link=" onclick="."location='ISOResp/Modificar.php?Flag1=True&id=".$row['Id']."'";
	$falta = FormatoFecha($row['FechaA']);if ($falta=='00-00-0000'){$falta="";}
	$fbaja= FormatoFecha($row['FechaB']);if ($fbaja=='00-00-0000'){$fbaja="";}
	if ($fbaja==''){$clase="TablaDato";}else{$clase="TablaDatoR2";}
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> "." ".substr($row['Accion'],0,20)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> "." ".substr($row['Apellido'].' '.$row['Nombre'],0,50)."</td>"; 
	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  
	$tablaclientes .="<td class=".$clase.$link."> ".$falta."</td>";  
	$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 
	$tablaclientes .="<td class=".$clase.$link."> ".$fbaja."</td>"; 
	$tablaclientes .='<td class="TablaMostrarRight"></td>';  
	$tablaclientes .='</tr>';
	$recuento=$recuento+1;
}mysql_free_result($rs);	
$tablaclientes .=GLO_fintabla(1,0,$recuento);
echo $tablaclientes;	
}

GLOF_Init('','BannerConMenuHV','ISOResp/zISO_Resp',0,'ISODoc/MenuH',0,0,0); 
GLO_tituloypath(0,650,'','RESPONSABLES DOCUMENTOS','basica');

GLO_Hidden('TxtId',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(650,0);
echo 'No puede haber mas de un <font class="comentario2">Responsable</font> vigente controlar y aprobar';
GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>