<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);
//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



//se graba como 'AR' (archivos reg)+ Id iso_doc_reg
//codigo upload
if(isset($_POST['CmdAceptar'])) {
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$idreg=intval($_POST['TxtNumero']);$obs=mysql_real_escape_string($_POST['TxtDesA']);
    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {	
		$iddoc=intval($_POST['TxtIdDoc']);$fecha=FechaMySql(date("d-m-Y"));
		//file
		include($_SESSION["NivelArbol"]."IncludesNG/ArchivoCopy1.php");
		$nombrearchivo='AR'.$idreg.'.'.$extension2;
		$dirdestino='../Archivos/SGIDoc/Registros/';
		$query="Update iso_doc_reg Set Ruta='$nombrearchivo',FechaU='$fecha',Descripcion='$obs' Where Id=$idreg";
		include($_SESSION["NivelArbol"]."IncludesNG/ArchivoCopy2.php");
    }else{
	  	//grabo	descripcion
	  	$query="Update iso_doc_reg Set Descripcion='$obs' Where Id=$idreg";$rs=mysql_query($query,$conn);
	}
	mysql_close($conn); 
	//vuelvo
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Modificar.php?id=".intval($_POST['TxtIdDoc'])."&Flag1=True");
} 

if ( isset($_POST['CmdCancelar']) or isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}


?>

