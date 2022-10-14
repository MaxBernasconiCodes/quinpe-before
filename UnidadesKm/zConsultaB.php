<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(12);


if (isset($_POST['CmdBuscar'])){
	//busca las unidades marcadas como RSV
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	//valida algun filtro
	if(empty($_POST['TxtFechaD']) and empty($_POST['TxtFechaH'])){
		$_SESSION['TxtQUNIKMB']='';$_SESSION['GLO_msgE']='Por favor seleccione Periodo';
	}else{
		$wbuscar='';
		if (!(empty($_POST['TxtFechaD']))){$wbuscar=$wbuscar." and DATEDIFF(u2.Fecha,'".FechaMySql($_POST['TxtFechaD'])."')>=0";}
		if (!(empty($_POST['TxtFechaH']))){$wbuscar=$wbuscar." and DATEDIFF(u2.Fecha,'".FechaMySql($_POST['TxtFechaH'])."')<=0";}
		$vbuscar=intval($_POST['CbMes']);if($vbuscar!=0){$wbuscar=$wbuscar." and MONTH(u2.Fecha)=$vbuscar";}
		//dominio
		if ( !(empty($_POST['TxtBusqueda'])) ){
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$texto=mysql_real_escape_string($_POST['TxtBusqueda']);
			$wbuscar=$wbuscar." and (REPLACE(TRIM(u2.Dominio),'-','')  Like '%".trim(strtoupper(str_replace('-','',str_replace(' ','',$texto))))."%')";
			mysql_close($conn); 
		}
		//
		$_SESSION['TxtQUNIKMB']="SELECT u2.* From unidadeskm u2 Where u2.Id<>0  $wbuscar Order by u2.Fecha,u2.Dominio";
	}
	//
	header("Location:ConsultaB.php");
}


elseif (isset($_POST['CmdGuardar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);	
		$aLista=array_keys($_POST['campos']);
		foreach($aLista as $idreg) {
			$query="Delete From unidadeskm Where Id=$idreg";$rs=mysql_query($query,$conn);
		}mysql_close($conn); 
		GLO_feedback(1);
	}else{$_SESSION['GLO_msgE']='Por favor seleccione algun registro';}
	header("Location:ConsultaB.php");
}


?>