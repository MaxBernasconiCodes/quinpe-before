<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query="SELECT s.* From unidadesmedida s where s.Id<>0  Order By s.Nombre";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .=GLO_inittabla(500,1,0,0);
$tablaclientes .="<td "."width="."420"." class="."TableShowT"."> Nombre</td>";   
$tablaclientes .="<td "."width="."50"." class="."TableShowT"."> Abr</td>";   
$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
$tablaclientes .='</tr>';             
$recuento=0;
while($row=mysql_fetch_array($rs)){ 	
	GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);
	$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
	$tablaclientes .="<td class="."TableShowD".$link."> "." ".$row['Nombre']."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> "." ".$row['Abr']."</td>"; 
	$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);
	$tablaclientes .="</td>";  
	$tablaclientes .='</tr>';
	$recuento=$recuento+1;
}mysql_free_result($rs);	
$tablaclientes .=GLO_fintabla(0,0,$recuento);
echo $tablaclientes;
}


GLOF_Init('','BannerConMenuHV','UnidadesMed/zConsulta',0,'',0,0,0); 
GLO_tituloypath(0,500,'','UNIDADES','basica');
GLO_mensajeerror();
GLO_Hidden('TxtId',0);
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 
include ("Codigo/FooterConUsuario.php");
?>