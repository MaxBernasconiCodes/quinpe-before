<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(15);

if (isset($_POST['CmdAceptar'])){
		//verifica campos requeridos
		if ((empty($_POST['CbTipo'])) or (empty($_POST['TxtFechaA']))){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
		}else{ 
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			if (empty($_POST['TxtFechaA'])){$fecha="0000-00-00";}else{$fecha=FechaMySql($_POST['TxtFechaA']);}	
			if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}	
			if (empty($_POST['TxtFechaC'])){$fechac="0000-00-00";}else{$fechac=FechaMySql($_POST['TxtFechaC']);}	
			$tipo=intval($_POST['CbTipo']);
			$per=intval($_POST['CbPer']);
			$est=intval($_POST['CbEstado']);
			$req=mysql_real_escape_string($_POST['TxtReq']);
			$ident=mysql_real_escape_string($_POST['TxtIdent']);
			$resp=mysql_real_escape_string($_POST['TxtResp']);
			$obs=mysql_real_escape_string($_POST['TxtObs']);
			$ver=mysql_real_escape_string($_POST['TxtVerif']);
			$id=intval($_POST['TxtNumero']);
			
			$query="UPDATE iso_matriz set Fecha='$fecha',IdAlcance=$tipo,Req='$req',Ident='$ident',Detalle='$obs',IdPeriod=$per,FVto='$fechab',Resp='$resp',Reg='$ver',Eval=$est,FEval='$fechac' Where Id=$id";
			$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
			mysql_close($conn); 		
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
			header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");

		}		
}


elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("iso_matriz",intval($_POST['TxtNumero']),"SGIDoc/Anexos/","Ruta"); 
}


elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}




?>


