<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['CbItem']) or empty($_POST['TxtRes']) or empty($_POST['CbUnidad']) ){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);header("Location:AltaItemS.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$itemserv=intval($_POST['CbItem']);//id itemscliente_serv 
		$ident=intval($_POST['TxtNroEntidad']);//despacho
		$uni=intval($_POST['CbUnidad']);//unidad medida
		$res=floatval($_POST['TxtRes']);//cant
		$env=intval($_POST['CbEnv']);//envase
		$val=mysql_real_escape_string($_POST['TxtVal']);//lote
		$bul=intval($_POST['TxtBultos']);//bultos
		$obs=mysql_real_escape_string($_POST['TxtObs']);//destino
		//busco el item (Id items)
		$query="SELECT IdItem FROM itemscliente_serv Where Id=$itemserv";
		$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
		if(mysql_num_rows($rs10)!=0){$item=$row10['IdItem'];}else{$item=0;}mysql_free_result($rs10);
		//inserto		
		$nroId=GLO_generoID("despacho_it",$conn);
		$query="INSERT INTO despacho_it (Id,IdPadre,IdItemServ,IdIC,IdU,Cant,IdEnv,CantI,Lote,Bultos,Destino) VALUES ($nroId,$ident,$itemserv,$item,$uni,$res,$env,0,'$val',$bul,'$obs')";$rs=mysql_query($query,$conn);
		mysql_close($conn); 	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A3');
	}
}


elseif ( isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A3');
}



?>

