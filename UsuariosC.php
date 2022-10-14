<? include("Codigo/Seguridad.php") ;include("Codigo/Funciones.php") ;include("Codigo/Config.php") ;$_SESSION["NivelArbol"]="";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query="Select u.*,c.Nombre as RS from clientes_usr u,clientes c where u.Id<>0 and u.IdCliente=c.Id Order By u.FechaBaja,c.Nombre";
$rs=mysql_query($query,$conn);
//contenedora
$tablaclientes='';
$tablaclientes='';
$tablaclientes .=GLO_inittabla(700,1,0,0);
$tablaclientes .="<td "."width="."220"." class="."TableShowT"."> Razon Social</td>";  
$tablaclientes .="<td "."width="."210"." class="."TableShowT"."> Nombre</td>";  
$tablaclientes .="<td "."width="."240"." class="."TableShowT"."> Usuario </td>";   
$tablaclientes .="<td width="."30"." class="."TableShowT"."> </td>"; 
$tablaclientes .='</tr>';             
$recuento=0;
while($row=mysql_fetch_array($rs)){	
	GLO_LinkRowTablaInit($estilo,$link,"'".$row['Id']."'",0);
	$fbaja= GLO_FormatoFecha($row['FechaBaja']);
	if ($fbaja==''){$clase="TableShowD";}else{$clase="TableShowD TGray";}	
	//muestra
	$tablaclientes .='<tr '.$estilo.'>'; 
	$tablaclientes .='<td class="'.$clase.'"'.$link.'>'.substr($row['RS'],0,28)."</td>"; 
	$tablaclientes .='<td class="'.$clase.'"'.$link.'>'.substr($row['Apellido'].' '.$row['Nombre'],0,26)."</td>"; 
	$tablaclientes .='<td class="'.$clase.'"'.$link.'>'.substr($row['Usuario'],0,30)."</td>"; 
	$tablaclientes .='<td class="'.$clase.' TAC">';
	if ($fbaja==''){
		$tablaclientes .="<a href=\"UsuariosC/CambioClave.php?id=".$row['Id']."\">".'<i class="fa fa-key iconsmallbt iconlgray"></i>'."</a>"; 
	}
	$tablaclientes .="</td>";  
	$tablaclientes .='</tr>'; 
	$recuento=$recuento+1;
}mysql_free_result($rs);	
//Cerrar tabla
$tablaclientes .=GLO_fintabla(0,0,$recuento);
echo $tablaclientes;	
}


GLOF_Init('','BannerConMenuHV','UsuariosC/zUsuarios',0,'Usuarios/MenuH',0,0,0); 
GLO_tituloypath(0,700,'','USUARIOS CLIENTES','basica'); 

GLO_Hidden('TxtId',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(700,0);
echo 'Muestra en <font class="comentario3">gris</font> los Usuarios dados de <font class="comentario2">baja</font>';
GLO_endcomment();
include ("Codigo/FooterConUsuario.php");
?>