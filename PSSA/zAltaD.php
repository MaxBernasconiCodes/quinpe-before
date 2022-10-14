<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}




if (isset($_POST['CmdGuardar'])){	 
	$idpssa=intval($_POST['TxtNroEntidad']);
	 if(!empty($_POST['campos'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$aListaid=array_keys($_POST['campos']);
		foreach($aListaid as $iId) {
			$query="SELECT * From pssa_act where Id<>0 and Id=$iId"; $rs=mysql_query($query,$conn);
			while($row=mysql_fetch_array($rs)){
				$idtipo=$row['IdTipo'];
				$idfrec=$row['IdFrec'];
				$idresp=$row['IdResp'];
			}mysql_free_result($rs);
			//inserto 
			$nroId=GLO_generoID("pssa_items",$conn);
			$query="INSERT INTO pssa_items (Id,IdPssa,IdAct,IdTipo,IdFrec,IdResp,CE,Mes1,Mes2,Mes3,Mes4,Mes5,Mes6,Mes7,Mes8,Mes9,Mes10,Mes11,Mes12,Obs,Obj,Meta) VALUES ($nroId,$idpssa,$iId,$idtipo,$idfrec,$idresp,'',0,0,0,0,0,0,0,0,0,0,0,0,'',0,0)";
			$rs=mysql_query($query,$conn);
		}mysql_close($conn); 
 	}	
 	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaD.php?Id=".intval($_POST['TxtNroEntidad']));
}

elseif (isset($_POST['CmdSalir'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	
}


?>