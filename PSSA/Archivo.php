<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php"); include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$_SESSION['TxtNumero']=str_pad(intval($_GET['Id']), 6, "0", STR_PAD_LEFT);

//codigo upload
if(isset($_POST['CmdAceptar'])) {
    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {	
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$identidad=intval($_POST['TxtNumero']);
		$obs=mysql_real_escape_string($_POST['TxtDesA']);
		$tipo=intval($_POST['CbTipo']);
		$nroId=GLO_generoID('pssa_archivos',$conn);
		//file
		include($_SESSION["NivelArbol"]."IncludesNG/ArchivoCopy1.php");
		$nombrearchivo='PSSA'.$nroId.'.'.$extension2;
		$dirdestino='../Archivos/Adjuntos/';
		$query="INSERT INTO pssa_archivos (Id,IdEntidad,Descripcion,Ruta,IdTipo) VALUES ($nroId,$identidad,'$obs','$nombrearchivo',$tipo)";
		include($_SESSION["NivelArbol"]."IncludesNG/ArchivoCopy2.php");
		mysql_close($conn); 		  
    }
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
} 

//cancelar
elseif ( isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}

//html	
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);  
include ("../Codigo/HeadFull.php");
echo'<link rel="STYLESHEET" type="text/css" href="'.'../CSS/Estilo.css" >';
GLO_bodyform('',0,0);
include ("../Codigo/BannerPopUp.php");
echo'<form name="Formulario" action="" method="post" enctype="multipart/form-data">';
GLO_tituloypath(750,700,'','ARCHIVO','salir');
echo '<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="3"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right"  >Archivo:</td><td  valign="top" >&nbsp;<input name="archivo" id="archivo" type="file"  class="TextBox" style="width:300px;" maxlength="150"  value="'.$_SESSION['TxtLogoAdd'].'"></td></tr>
<tr> <td height="18"  align="right"  >Tipo:</td><td  valign="top" >&nbsp;<select name="CbTipo" style="width:300px" class="campos"   id="CbTipo" ><option value=""></option>'; echo ComboTablaRFX("pssa_tipoarch","CbTipo","Nombre","","",$conn); echo '</select></td></tr>
</table>';
GLO_Hidden('TxtNumero',0);
GLO_obsform(700,100,'Observaciones','TxtDesA',0,2);
GLO_botonesform(700,0,2);
GLO_mensajeerror();  
mysql_close($conn); 	                    
GLO_cierratablaform();
include ("../Codigo/FooterConUsuario.php");
?>