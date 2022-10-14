<? include("Codigo/Seguridad.php") ;include("Codigo/Funciones.php") ;include("Codigo/Config.php") ;$_SESSION["NivelArbol"]="";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($conn){
$query="select u.*,c.Nombre,c.Apellido,p.Nombre AS NombrePerfil from usuarios u,proveedores c,perfiles p where u.IdProveedor= c.Id and u.IdPerfil = p.Id and  u.Tipo='PROVEEDOR' and u.Usuario<>'admin' Order By u.FechaBaja,c.Apellido,c.Nombre";$rs=mysql_query($query,$conn);
//contenedora
$tablaclientes='';
$tablaclientes .=GLO_inittabla(750,1,0,0);
$tablaclientes .="<td "."width="."250"." class="."TableShowT"."> Nombre</td>";   
$tablaclientes .="<td "."width="."125"." class="."TableShowT"."> Usuario </td>";   
$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Puesto</td>";  
$tablaclientes .="<td "."width="."165"." class="."TableShowT"."> Perfil</td>";  
$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha Baja</td>";   
$tablaclientes .="<td width="."30"." class="."TableShowT"."> </td>"; 
$tablaclientes .='</tr>';             
$recuento=0;$estilo=" style='cursor:pointer;'";  
while($row=mysql_fetch_array($rs)){
	$link=" onclick="."location='UsuariosPR/Modificar.php?id=".$row['Usuario']."'";
	$fbaja= GLO_FormatoFecha($row['FechaBaja']);if ($fbaja==''){$clase="";}else{$clase=" TGray";}	
	//
	$tablaclientes .='<tr '.$estilo.'>'; 
	$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['Apellido']." ".$row['Nombre'],0,30)."</td>"; 
	$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['Usuario'],0,15)."</td>"; 
	$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['Puesto'],0,20)."</td>";  
	$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".substr($row['NombrePerfil'],0,25)."</td>";  
	$tablaclientes .='<td class="TableShowD'.$clase.'"'.$link."> ".$fbaja."</td>";  
	$tablaclientes .='<td class="TableShowD TAC">';
	if ($fbaja==''){
		$tablaclientes .='<a href="UsuariosPR/CambioClave.php?id='.$row['Usuario'].'" title="Clave"><i class="fa fa-key iconsmallbt iconlgray"></i></a>'; 
	}
	$tablaclientes .='</td></tr>'; 
	$recuento=$recuento+1;
}mysql_free_result($rs);	
$tablaclientes .=GLO_fintabla(0,0,0);
echo $tablaclientes;	
}


GLOF_Init('','BannerConMenuHV','',0,'Usuarios/MenuH',0,0,0); 
GLO_tituloypath(810,750,'Usuarios.php','USUARIOS PROVEEDORES','linksalir'); 
?>

<table  width="750" border="0" cellspacing="0" cellpadding="0" >
<tr><td  height=3 ></td></tr>
<tr><td align="right" valign="bottom" >
<input name="CmdAgregar" type="button" class="boton" value="Agregar" onClick="document.Formulario.target='_self';window.location.href='UsuariosPR/Alta.php'">
</td></tr></table>

<?
MostrarTabla($conn);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn); 
include ("Codigo/FooterConUsuario.php");
?>