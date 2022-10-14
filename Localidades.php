<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14  and $_SESSION["IdPerfilUser"]!=13 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



function MostrarTabla($conn){

//Ejecuta  consulta

$query="SELECT l.*, p.Nombre as NombrePcia From localidades l,provincias p where l.IdPcia=p.Id and l.Id<>0 Order by l.Nombre";

$rs=mysql_query($query,$conn);

//Titulos de la tabla

$tablaclientes='';

$tablaclientes .=GLO_inittabla(700,0,0,0);

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."340"." class="."TablaTituloDato"."> Nombre</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>';  

$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> CP </td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td "."width="."250"." class="."TablaTituloDato"."> Provincia</td>";  

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td width="."40"." class="."TablaTituloDato"."> </td>"; 

$tablaclientes .='<td class="TablaTituloRight"></td>';  

$tablaclientes .='</tr>';             

$recuento=0;

$estilo=" style='cursor:pointer;' "; 

while($row=mysql_fetch_array($rs)){ 	

	$link=" onclick="."location='Localidades/Modificar.php?id=".$row['Id']."'";

	$tablaclientes .='<tr '.$estilo.'>';  

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Nombre'],0,35)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['CP'],0,15)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['NombrePcia'],0,30)."</td>";  

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class="."TablaDato"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  

	$tablaclientes .='<td class="TablaMostrarRight"></td>';  

	$tablaclientes .='</tr>';

	$recuento=$recuento+1;

}	mysql_free_result($rs);

$tablaclientes .=GLO_fintabla(0,0,$recuento);

echo $tablaclientes;	

}







GLOF_Init('','BannerConMenuHV','Localidades/zConsulta',0,'',0,0,0); 

GLO_tituloypath(0,700,'','LOCALIDADES','basica'); 



GLO_mensajeerror();

GLO_Hidden('TxtId',0);

MostrarTabla($conn);

mysql_close($conn); 

GLO_cierratablaform(); 

include ("Codigo/FooterConUsuario.php");

?>