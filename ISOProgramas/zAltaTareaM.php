<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(16);



if (isset($_POST['CmdGuardar'])){	
	//obtengo campos seleccionados 
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		include("Includes/zDatosTA.php");
		$idtipoe=intval($_POST['CbTipoE']);
		$aListaid=array_keys($_POST['campos']);
		//selecciono entidad
		foreach($aListaid as $iId) {
			$cli=0;$uni=0;$ctro=0;$per=0;$serv=0;
			switch ($idtipoe) {
				case 1:	$cli=intval($iId);break;//clientes
				case 2:	$uni=intval($iId);break;//unidades
				case 4:	$per=intval($iId);break;//personal
				case 5:	$serv=intval($iId);break;//servicio
			}
			//inserto
			$nroId=GLO_generoID("programas_t",$conn);
			$query="INSERT INTO programas_t (Id,IdP,Obs,Obs2,Obs3,IdCliente,IdUnidad,IdPersonal,IdServicio,Otro".$wqi1.") VALUES ($nroId,$ident,'','','',$cli,$uni,$per,$serv,''".$wqi2.")";$rs=mysql_query($query,$conn);
		}mysql_close($conn); 
 	}	
 	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}


elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}



?>

