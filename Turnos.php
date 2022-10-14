<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");

//perfiles
GLO_PerfilAcceso(11);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



function MostrarTabla($conn){

//Ejecuta  consulta

$query="SELECT t.* From turnos t where t.Id<>0 Order by t.Nombre";$rs=mysql_query($query,$conn);

//Titulos de la tabla

$tablaclientes='';

$tablaclientes .=GLO_inittabla(500,0,0,0);

$tablaclientes .='<td class="TablaTituloLeft"></td>';

$tablaclientes .="<td "."width="."400"." class="."TablaTituloDato"."> Nombre</td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>';  

$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"." style='text-align:right;'> Horas </td>";   

$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

$tablaclientes .="<td width="."30"." class="."TablaTituloDato"."> </td>"; 

$tablaclientes .='<td class="TablaTituloRight"></td>';  

$tablaclientes .='</tr>';             

$recuento=0;

$estilo=" style='cursor:pointer;' "; 

while($row=mysql_fetch_array($rs)){ 	

	$link=" onclick="."location='Turnos/Modificar.php?id=".$row['Id']."'";

	$tablaclientes .='<tr '.$estilo.'>';  

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class="."TablaDato".$link."> ".substr($row['Nombre'],0,50)."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class="."TablaDato".$link." style='text-align:right;'> ".$row['Horas']."</td>"; 

	$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

	$tablaclientes .="<td class="."TablaDato"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0)."</td>";  

	$tablaclientes .='<td class="TablaMostrarRight"></td>';  

	$tablaclientes .='</tr>';

	$recuento=$recuento+1;

}	mysql_free_result($rs);

$tablaclientes .=GLO_fintabla(0,0,$recuento);

echo $tablaclientes;	

}







GLOF_Init('','BannerConMenuHV','Turnos/zConsulta',0,'Personal/MenuH',0,0,0); 

GLO_tituloypath(0,500,'','TURNOS','basica'); 



GLO_mensajeerror();

GLO_Hidden('TxtId',0);

MostrarTabla($conn);

mysql_close($conn); 

GLO_cierratablaform(); 

include ("Codigo/FooterConUsuario.php");

?>