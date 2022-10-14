<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	if(intval($_POST['CbItem'])!=0){
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);//servicio
		$iditem=intval($_POST['CbItem']);
		$idcli=intval($_POST['TxtIdCliente']);
		//inserto item cliente
		$nroId=GLO_generoID("itemscliente_serv",$conn);
		$query="INSERT INTO itemscliente_serv (Id,IdItem,IdCliente,IdPadre) VALUES ($nroId,$iditem,$idcli,$ident)";
		$rs=mysql_query($query,$conn);
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 
	}else{GLO_feedback(3);$grabook=0;}
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarItem.php?Flag1=True&itemcliente=".$nroId);	
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaItem.php?Id=".intval($_POST['TxtNroEntidad']));
		}			
}



elseif ( isset($_POST['CmdCancelar']) or isset($_POST['CmdSalir']) ){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

?>