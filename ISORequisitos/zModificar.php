<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;   $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);

if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['TxtNombre'])) or (empty($_POST['TxtNro']))  or (empty($_POST['CbNorma'])) ){
		//obtener datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;}	
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}
	else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		$nror=mysql_real_escape_string($_POST['TxtNro']);
		$norma=intval($_POST['CbNorma']);
		$fechab=GLO_FechaMySql($_POST['TxtFechaB']);
	  	//update
		$query="UPDATE iso_nc_req set Nombre='$nombre',Nro='$nror',IdNorma=$norma,FechaBaja='$fechab' Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn);
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){	$_SESSION[$key] = "";		}
		header("Location:../ISO_Requisitos.php");
	}		
	
}





?>


