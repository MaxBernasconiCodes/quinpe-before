<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ;   $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ( empty($_POST['TxtNombre']) or  empty($_POST['CbUnidad'])  ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero']));
	}else{
		//grabar los datos en la tabla
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($_POST['TxtNombre']));	
		$inac=intval($_POST['ChkInactivo']); 
		$tipo=intval($_POST['CbTipo']); 
		$unidad=intval($_POST['CbUnidad']);
		//
		$query="UPDATE items set Nombre='$nombre',Inactivo=$inac,Tipo=$tipo,IdUnidad=$unidad Where Id=".intval($_POST['TxtNumero']);
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:../Conceptos.php");
	}		
	
}

//archivos
elseif (isset($_POST['CmdAddA1'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA1'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From items_adj Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From items_adj Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Laboratorio/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
elseif (isset($_POST['CmdVerFile1'])){
	GLO_OpenFile("items_adj",intval($_POST['TxtId']),"Laboratorio/","Ruta");
}

?>