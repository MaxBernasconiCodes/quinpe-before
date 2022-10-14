<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}




if (isset($_POST['CmdAceptar'])){
	if (empty($_POST['TxtFechaA']))	{	
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
		GLO_feedback(3);header("Location:AltaConT.php?Id=".intval($_POST['TxtNroEntidad']));
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$ident=intval($_POST['TxtNroEntidad']);//contrato
		$fechaa=FechaMySql($_POST['TxtFechaA']);
		$imp=GLO_GrabarImporte($_POST['TxtImporte']);
		$mon=intval($_POST['CbMoneda']);
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		//verifica fecha desde mayor
		$query="SELECT Max(FechaD) as Desde FROM unidades_cont Where IdEntidad=$ident";$rs=mysql_query($query,$conn);
		$row=mysql_fetch_array($rs);$fechadmayor='';if(mysql_num_rows($rs)!=0){$fechadmayor=FormatoFecha($row['Desde']);}
		mysql_free_result($rs);
		//si $fechaa > $fechadmayor agrega item, sino mensaje
		if(CompararFechas($fechaa,$fechadmayor)==1){		
			//Si hay otro cargado pone la fecha de baja al &uacute;ltimo
			$query="UPDATE unidades_cont set FechaH='$fechaa' Where FechaH='0000-00-00' and IdEntidad=$ident";
			$rs=mysql_query($query,$conn);				
			//generoid item 
			$query="SELECT Max(Id) as UltimoId FROM unidades_cont";	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
			if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
			//inserto item 
			$query="INSERT INTO unidades_cont (Id,IdEntidad,Importe,Moneda,FechaD,FechaH,Obs) VALUES ($nroId,$ident,$imp,$mon,'$fechaa','0000-00-00','$obs')";$rs=mysql_query($query,$conn);
			//vuelvo	
			mysql_close($conn); 
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:ModificarCon.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
		}else{
			//vuelvo
			mysql_close($conn); 
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
			GLO_feedback(10);header("Location:AltaConT.php?Id=".intval($_POST['TxtNroEntidad']));	
		}
	}	
}



elseif (isset($_POST['CmdCancelar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarCon.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}
elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ModificarCon.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
}

?> 
