<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(15);

if (isset($_POST['CmdAceptar'])){ 
		//verifica campos requeridos
		if ((empty($_POST['CbTipo'])) or (empty($_POST['TxtFechaA']))){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
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

			//generoid
			$query="SELECT Max(Id) as UltimoId FROM iso_matriz";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
			if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
			//query
			$query="INSERT INTO iso_matriz (Id,Fecha,IdAlcance,Req,Ident,Detalle,IdPeriod,FVto,Resp,Reg,Eval,FEval,Ruta) VALUES ($nroId,'$fecha',$tipo,'$req','$ident','$obs',$per,'$fechab','$resp','$ver',$est,'$fechac','')"; 
			$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
			mysql_close($conn); 			
			//volver
			if($grabook==1){
				foreach($_POST as $key => $value){$_SESSION[$key] = "";}
				header("Location:Modificar.php?id=".$nroId."&Flag1=True");
			}else{
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
				header("Location:Alta.php");
			}			

		}		
}




?>

