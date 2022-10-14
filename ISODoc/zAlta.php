<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);
//si no tiene cargados responsables
if (intval($_SESSION["GLO_IdPersCON"])==0 or intval($_SESSION["GLO_IdPersAPR"])==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


//FlagOrig:id documento version original
//FlagRev:si es la vs original es 0, sino es el id del documento anterior
//Origen:1 Externo, 2 Interno

if (isset($_POST['CmdAceptar'])){ 
		//1.verifica campos requeridos 
		if ((empty($_POST['TxtCod'])) or ($_POST['TxtVs']=='') or (empty($_POST['CbTipo'])) or (empty($_POST['CbSector'])) or (empty($_POST['CbPers1']) and empty($_POST['CbProv1'])) or (empty($_POST['TxtNombre']))  or (empty($_POST['TxtFecha1']))){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
		}else{
			//verifico que no exista el c&oacute;digo
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$cod=mysql_real_escape_string($_POST['TxtCod']);
			$query="SELECT Id FROM iso_doc Where Codigo='$cod'";
			$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
			if(mysql_num_rows($rs)==0){$existe='N';}else{$existe='S';}  
			mysql_free_result($rs);
			mysql_close($conn); 
			if($existe=='S'){
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}						
				GLO_feedback(14);header("Location:Alta.php");
			}else{
				//post
				$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
				$cod=mysql_real_escape_string($_POST['TxtCod']);
				$vs=intval($_POST['TxtVs']);
				$tipo=intval($_POST['CbTipo']);
				$sec=intval($_POST['CbSector']);
				$nor=0;
				$req=0;
				$ori=intval($_POST['CbOrigen']);
				$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
				$com1=mysql_real_escape_string($_POST['TxtCom1']);
				$res1=intval($_POST['CbPers1']);
				$res1pr=intval($_POST['CbProv1']);
				$res2=intval($_POST['TxtIdPers2']);
				$res3=intval($_POST['TxtIdPers3']);
				$ed=0;			
				$fv='0000-00-00';
				
				//fecha creacion
				//verifica que no sea vac&iacute;a
				if (empty($_POST['TxtFecha1'])){$f1=date("d-m-Y");}else{$f1=$_POST['TxtFecha1'];}
				//verifica fechacreacion>hoy le asigna hoy
				if((strtotime($f1)-strtotime(date("d-m-Y"))>0)){$f1=date("d-m-Y");}
				//formato base
				$f1=FechaMySql($f1);			
				//query
				$nroId=GLO_generoID('iso_doc',$conn);
				$query="INSERT INTO iso_doc (Id,Codigo,Nombre,Version,IdSector,IdTipoDoc,IdNorma,IdReq,Origen,Ruta,FechaCRE,FechaCON,FechaAPR,FechaEXP,IdPersCRE,IdProvCRE,IdPersCON,IdPersAPR,ComentCRE,ComentCON,ComentAPR,IdEstado,FlagOrig,FlagRev,Editable) VALUES ($nroId,'$cod','$nom',$vs,$sec,$tipo,$nor,$req,$ori,'','$f1','$fv','$fv','$fv',$res1,$res1pr,$res2,$res3,'$com1','','',0,$nroId,0,$ed)"; 
				//echo $query;
				$rs=mysql_query($query,$conn);
				if ($rs){	GLO_feedback(1);$grabook=1;ISODOC_grabaauditoria($nroId,1,$conn);	}else{GLO_feedback(2);$grabook=0; } 
				//cierro conx	
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
}







?>

