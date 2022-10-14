<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdBuscar'])){
	$origen=1;//planta
	include("../Stock/Includes/zBuscarSTCod.php");
	$_SESSION['TxtQStockCAM']=$query;
	header("Location:Stock.php");
}



elseif (isset($_POST['CmdBorrarFila'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//verifico si tiene items
	$query="SELECT * From stockmov_items where IdMov=".intval($_POST['TxtId']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)==0){//no tiene:borro
		$query="Delete From stockmov Where Id=".intval($_POST['TxtId']);$rs2=mysql_query($query,$conn);
	}else{
		GLO_feedback(12);
	}mysql_free_result($rs);
	mysql_close($conn); 	
	header("Location:Stock.php");
}








?>