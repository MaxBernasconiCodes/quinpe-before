<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST[CmdAceptar])){ 
	//verifica campos requeridos
	if ((empty($_POST['CbProv'])) or (empty($_POST['CbEje'])) or (empty($_POST['CbAuto'])) or (empty($_POST['TxtFechaA'])) or empty($_POST['TxtNro']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:AltaOrden.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);	
		include("Includes/zDatosOC.php");	
		//generoid
		$query="SELECT Max(Id) as UltimoId FROM co_ocompra";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
		if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}	mysql_free_result($rs);
		//query
		$query="INSERT INTO co_ocompra (Id,Fecha,IdProv,IdEstado,Obs,IdPerEjec,IdPerAuto,Efe,Efe2,Che,Che2,CC,Fact1,Fact1Nro,Rem,RemNro,Nro,Tran,TranD) VALUES ($nroId,'$fa',$prov,1,'$obs',$eje,$auto,$efe,'$tefe',$che,'$tche',$cc,$f1,'$tf1',$rem,'$trem',$nrooc,$tran,$trand)";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
		mysql_close($conn); 			
		//volver
		if($grabook==1){
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarOrden.php?id=".$nroId."&Flag1=True");
		}else{
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			header("Location:AltaOrden.php");
		}			
	}		

}



elseif (isset($_POST[CmdItems])){
header("Location:ConsultaItems.php");
}


elseif (isset($_POST[CmdCancelar])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:Ordenes.php");
}



?>