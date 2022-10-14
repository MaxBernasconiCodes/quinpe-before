<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
GLO_PerfilAcceso(14);


if (isset($_POST['CmdAceptar'])){ 
		//1.verifica campos requeridos
		if ((empty($_POST['TxtFecha'])) or empty($_POST['CbRespAccion1']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}	
			$_SESSION['GLO_msgE']='Por favor complete Fecha NC y Responsable Accion Correctiva';	
			header("Location:Alta.php");
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			include("Includes/zDatosU.php");			
			//query
			$nroId=GLO_generoID("iso_nc",$conn);
			$query="INSERT INTO iso_nc (Id,IdTipo,IdCliente,FechaEmision,IdSector,IdSector2,IdSector3,IdSector4,Emisor,IdNorma,IdNorma2,IdNorma3,IdRequisito,IdRequisito2,IdRequisito3,IdRequisito4,IdRequisito5,IdRequisito6,Descripcion,DesAI,FechaAI,IdRespAI,Causa,IdParticipante1,IdParticipante2,IdParticipante3,IdParticipante4,IdParticipante5,IdParticipante6,OtrosP,OtrosPMail,Accion,IdResponsable1,IdResponsable2,IdResponsable3,IdResponsable4,IdResponsable5,IdResponsable6,OtrosR,OtrosRMail,FechaPlazo,FechaCumpl,IdVerificador,FechaPrevista,FechaCierre,Observaciones,IdNCNueva,IdEstado,Aceptada,TipoH,RespDetExt) VALUES ($nroId,$tipo,$cli,'$fecha',$sec,$sec2,$sec3,$sec4,$resp,$norma1,$norma2,$norma3,$req1,$req2,$req3,$req4,$req5,$req6,'$des','$desai','$fechaai',$rai,'$causa',$pcausa1,$pcausa2,$pcausa3,$pcausa4,$pcausa5,$pcausa6,'$otrosp','$otrospm','$accion',$raccion1,$raccion2,$raccion3,$raccion4,$raccion5,$raccion6,'$otrosr','$otrosrm','$fechapl','$fechacpl',$verif,'$fechap','$fechac','$obs',$nueva,$estado,$acc,$tipoh,'$respext')"; 
			$rs=mysql_query($query,$conn);
			if ($rs){
				GLO_feedback(1);$grabook=1;
				//inserto auditoria
				$nroId2=GLO_generoID("iso_nc_auditoria",$conn);
				$idncaudi=$nroId;$fechaaudit=FechaMySqlHora(date("d-m-Y H:i:s"));$user=$_SESSION["login"];
				$query="INSERT INTO iso_nc_auditoria (Id,IdNC,IdUsuario,IdCambio,Fecha) VALUES ($nroId2,$idncaudi,'$user',1,'$fechaaudit')";$rs=mysql_query($query,$conn);		
			}else{GLO_feedback(2);$grabook=0; } 
			mysql_close($conn); 			
			//volver
			if($grabook==1){
				foreach($_POST as $key => $value){$_SESSION[$key] = "";}
				header("Location:Modificar.php?id=".$nroId."&Flag1=True");
			}else{
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
				header("Location:Alta.php");
			}			
		}//cierra 1.	
}//cierra cmd




elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../ISO_NC.php");
}

?>

