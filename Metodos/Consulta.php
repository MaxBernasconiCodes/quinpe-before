<? include("../Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="../";include("../Codigo/Config.php");include("../Codigo/Funciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



function MostrarTabla($conn){

$query="SELECT * From metodos where Id<>0 Order by Nombre";$rs=mysql_query($query,$conn);

//Titulos de la tabla

$tablaclientes='';

$tablaclientes .=GLO_inittabla(500,1,0,0);

$tablaclientes .="<td "."width="."470"." class="."TableShowT".">Nombre</td>";   

$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 

$tablaclientes .='</tr>';             

$recuento=0; $estilo=" style='cursor:pointer;' ";

while($row=mysql_fetch_array($rs)){ 	

	$link=" onclick="."location='Modificar.php?Flag1=True&id=".$row['Id']."'";

	$tablaclientes .='<tr '.$estilo.'>';  

	$tablaclientes .="<td class="."TableShowD".$link.">".substr($row['Nombre'],0,40)."</td>"; 

	$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>".GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0). "</td>";  

	$tablaclientes .='</tr>';

	$recuento=$recuento+1;

}mysql_free_result($rs);	

$tablaclientes .=GLO_fintabla(0,0,$recuento);

echo $tablaclientes;	

}





GLOF_Init('','BannerConMenuHV','zConsulta',0,'../CAM/MenuH',0,0,0); 

GLO_tituloypath(0,500,'','METODOS PRUEBA','basica');



GLO_mensajeerror();

GLO_Hidden('TxtId',0);

MostrarTabla($conn); 

mysql_close($conn); 

GLO_cierratablaform();

include ("../Codigo/FooterConUsuario.php");

?>