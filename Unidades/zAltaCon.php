<? 

include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}







if (isset($_POST['CmdAceptar'])){ 

	if ( empty($_POST['CbProv']) or  empty($_POST['TxtFechaA']) or  empty($_POST['TxtFechaB']) or  empty($_POST['TxtNroCon']) ){

		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		

		GLO_feedback(3);header("Location:AltaCon.php?Id=".intval($_POST['TxtNroEntidad']));

	}else{

		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

		$ident=intval($_POST['TxtNroEntidad']);

		$prov=intval($_POST['CbProv']);

		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	

		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}	

		$con=intval($_POST['TxtNroCon']);

		$obs=mysql_real_escape_string($_POST['TxtObs']);

	  	//generoid

		$query="SELECT Max(Id) as UltimoId FROM unidades_con";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);

		//inserto

		$query="INSERT INTO unidades_con (Id,IdEntidad,FechaI,FechaF,IdProv,NroCon,Obs) VALUES ($nroId,$ident,'$fechaa','$fechab',$prov,$con,'$obs')";$rs=mysql_query($query,$conn);

		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 

		mysql_close($conn); 	

		//volver

		if($grabook==1){

			foreach($_POST as $key => $value){$_SESSION[$key] = "";}

			header("Location:ModificarCon.php?id=".$nroId."&Flag1=True");

		}else{

			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

			header("Location:AltaCon.php?Id=".intval($_POST['TxtNroEntidad']));

		}			

	}

}






elseif (isset($_POST['CmdSalir'])){

foreach($_POST as $key => $value){$_SESSION[$key] = "";}

header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True".'#A8');

}







?>



