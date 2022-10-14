<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php"); include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);
GLO_ValidaGET($_GET['IdP'],0,0);

//busco nombre
$_SESSION['TxtNumero']=intval($_GET['Id']);
$_SESSION['TxtNroEntidad']=intval($_GET['IdP']);


//codigo upload
if(isset($_POST['CmdAceptar'])) {
    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {	
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$id=intval($_POST['TxtNumero']);
		//file
		include($_SESSION["NivelArbol"]."IncludesNG/ArchivoCopy1.php");
		$nombrearchivo='FotoINC'.$id.'.'.$extension2;
		$dirdestino='../Archivos/SMA/';
		$query="UPDATE incidentes_acc set Foto='$nombrearchivo' Where Id=$id";
		include($_SESSION["NivelArbol"]."IncludesNG/ArchivoCopy2.php");
		mysql_close($conn); 		  
    }
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar1.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");		
} 

	  

elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar1.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");		
}

?>

	  
<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
<? GLO_bodyform('',0,0); ?>
<? include ("../Codigo/BannerPopUp.php");?>
<form name="Formulario" action="<?=$PHP_SELF?>" method="post" enctype="multipart/form-data">
<?php GLO_tituloypath(0,400,'','FOTO','salir'); ?>

<table width="400" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="3"  ></td> <td width="300"></td> </tr>
<tr> <td height="18"  align="right"  >&nbsp;Archivo:</td><td  valign="top" > &nbsp; <input name="archivo" id="archivo" type="file"  class="TextBox" style="width:250px;" maxlength="150"  value="<? echo $_SESSION['TxtLogoAdd']; ?>"></td></tr>
</table>
              
<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_guardar(400,1,0);
GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>?>