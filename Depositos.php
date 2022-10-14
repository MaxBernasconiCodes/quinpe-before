<? include("Codigo/Seguridad.php") ;$_SESSION["NivelArbol"]="";include("Codigo/Config.php");include("Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=4  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query="SELECT d.* From depositos d where d.Id<>0  Order By d.Nombre";$rs=mysql_query($query,$conn);
//Titulos de la tabla
$tablaclientes='';
$tablaclientes .=GLO_inittabla(500,1,0,0);
$tablaclientes .="<td "."width="."370"." class="."TableShowT"."> Nombre</td>";   
$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Tipo</td>";   
$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>"; 
$tablaclientes .='</tr>';             
$recuento=0;
while($row=mysql_fetch_array($rs)){ 	
    GLO_LinkRowTablaInit($estilo,$link,$row['Id'],0);
    if($row['Tipo']==1){$tipo='Planta';}else{$tipo='';}
    //
	$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>';
	$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Nombre'],0,40)."</td>"; 
	$tablaclientes .="<td class="."TableShowD".$link."> ".$tipo."</td>"; 
	$tablaclientes .="<td class="."TableShowD"." style='text-align:center;'>"; 
	$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);
	$tablaclientes .="</td>";  
	$tablaclientes .='</tr>';
	$recuento=$recuento+1;
}mysql_free_result($rs);	
$tablaclientes .=GLO_fintabla(0,0,$recuento);
echo $tablaclientes;
}


GLOF_Init('','BannerConMenuHV','Depositos/zConsulta',0,'',0,0,0); 
GLO_tituloypath(0,500,'','DEPOSITOS','basica');
GLO_mensajeerror();
GLO_Hidden('TxtId',0);
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(500,0);
echo 'Los depositos tipo <font class="comentario2">Planta</font> son los considerados en <font class="comentario3">Operaciones</font><br>';
GLO_endcomment();

include ("Codigo/FooterConUsuario.php");

?>