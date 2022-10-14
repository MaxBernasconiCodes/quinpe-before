<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php"); include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['Id'],0,0);

//busco nombre
$_SESSION['TxtNumero']=intval($_GET['Id']);

//se graba como 'ANC' (archivos NC)+ Id archivo
if(isset($_POST['CmdAceptar'])) {
    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {	
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$identidad=intval($_POST['TxtNumero']);$obs=mysql_real_escape_string($_POST['TxtDesA']);
		$nroId=GLO_generoID("iso_nc_archivos",$conn);  
		//file
		include($_SESSION["NivelArbol"]."IncludesNG/ArchivoCopy1.php");
		$nombrearchivo='ANC'.$nroId.'.'.$extension2;
		$dirdestino='../Archivos/NC/';
		$query="INSERT INTO iso_nc_archivos (Id,IdNC,Descripcion,Ruta) VALUES ($nroId,$identidad,'$obs','$nombrearchivo')";
		include($_SESSION["NivelArbol"]."IncludesNG/ArchivoCopy2.php");
		mysql_close($conn); 		  
    }
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
} 

elseif (isset($_POST['CmdCancelar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

//html	  
include ("../Codigo/HeadFull.php");
echo'<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >';
GLO_bodyform('',0,0);
include ("../Codigo/BannerPopUp.php");
echo'<form name="Formulario" action="" method="post" enctype="multipart/form-data">';
GLO_tituloypath(0,700,'','ARCHIVO','salir');
echo '<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right">Archivo:</td><td  valign="top" >&nbsp;<input name="archivo" id="archivo" type="file"  class="TextBox" style="width:300px;" maxlength="150"  value="'.$_SESSION['TxtLogoAdd'].'"></td></tr>
</table>';
GLO_Hidden('TxtNumero',0);
GLO_obsform(700,100,'Observaciones','TxtDesA',0,2);
GLO_botonesform(700,0,2);
GLO_mensajeerror();                      
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>