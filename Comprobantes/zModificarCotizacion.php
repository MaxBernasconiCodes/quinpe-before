<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['CbCliente'])) or (empty($_POST['TxtFechaA']))  or (empty($_POST['CbPersonal'])) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:ModificarCotizacion.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$fa=GLO_FechaMySql($_POST['TxtFechaA']);
		$per=intval($_POST['CbPersonal']);
		$tipo1=intval($_POST['CbTipo']); 
		$tipo2=intval($_POST['CbTipoC']); 
		$est=intval($_POST['CbEstado']); 
		$fp=GLO_FechaMySql($_POST['TxtFechaP']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$ref=mysql_real_escape_string($_POST['TxtRef']); 
		$con=mysql_real_escape_string($_POST['TxtContacto']); 
		$loc=mysql_real_escape_string($_POST['TxtUbic']);
		$id=intval($_POST['TxtNumero']);
		//
		$query="UPDATE c_cotizaciones set IdTipo=$tipo1,Fecha='$fa',IdEstado=$est,Obs='$obs',Ref='$ref',FechaPre='$fp',Contacto='$con',IdPersonal=$per,Loc='$loc',IdTipoC=$tipo2 Where Id=$id";	$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 
		//
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:ModificarCotizacion.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}

}


//archivos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ArchivoCO.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From c_coti_archivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From c_coti_archivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Comprobantes/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:ModificarCotizacion.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("c_coti_archivos",intval($_POST['TxtId']),"Comprobantes/","Ruta");
}

?>


