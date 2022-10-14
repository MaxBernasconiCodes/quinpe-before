<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
	//valida cuit
	if (!(empty($_POST['TxtCUIT']))){
		$cuit_rearmado="";$cuit_validado=cuitValido($_POST['TxtCUIT'],$cuit_rearmado);
		$_POST['TxtCUIT']=$cuit_rearmado;
	}else {$cuit_validado=1;}
	if ($cuit_validado==0){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(4);header("Location:Alta.php");
	}else{
		//verifica campos requeridos
		if (empty($_POST['TxtNombre']) ){
			foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
			GLO_feedback(3);header("Location:Alta.php");
		}
		else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$cuit=mysql_real_escape_string($_POST['TxtCUIT']);
			$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
			$dir=mysql_real_escape_string($_POST['TxtDireccion']); 
			$idloc=intval($_POST['CbLocalidad']); 
			$pcia=mysql_real_escape_string($_POST['TxtProvincia']); 
			$cp=mysql_real_escape_string($_POST['TxtCP']); 
			$t1=mysql_real_escape_string(ltrim($_POST['TxtT1']));
			$t2=mysql_real_escape_string(ltrim($_POST['TxtT2']));
			$c1=mysql_real_escape_string(ltrim($_POST['TxtC1']));
			$c2=mysql_real_escape_string(ltrim($_POST['TxtC2']));
			$obs=mysql_real_escape_string($_POST['TxtObs']);
			//generoid
			$query="SELECT Max(Id) as UltimoId FROM polizasaseg";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
			if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
			//query
			$query="INSERT INTO polizasaseg (Id,Identificacion,Nombre,Direccion,IdLocalidad,Provincia,CP,Observaciones,T1,T2,C1,C2) VALUES ($nroId,'$cuit','$nom','$dir',$idloc,'$pcia','$cp','$obs','$t1','$t2','$c1','$c2')"; 
			$rs=mysql_query($query,$conn);
			if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
			mysql_close($conn); 			
			//volver
			if($grabook==1){
				foreach($_POST as $key => $value){$_SESSION[$key] = "";}
				header("Location:../PSAseguradoras.php");
			}else{
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
				header("Location:Alta.php");
			}			
		}		
	}
}






elseif (isset($_POST['CmdCancelar'])){
foreach($_POST as $key => $value){$_SESSION[$key] = "";}
header("Location:../PSAseguradoras.php");
}


else{
$Provincia="";
$CP="";
$valor=intval($_POST['CbLocalidad']);
if ($valor != ""){
	$query="SELECT p.*,l.CP  From provincias p, localidades l Where l.IdPcia=p.Id and l.Id= $valor";
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);	
	$row=mysql_fetch_array($rs);
	$Provincia=$row['Nombre'];	$CP=$row['CP'];	
	mysql_free_result($rs);	mysql_close($conn); 
}
//obtener datos del form anterior
foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
$_SESSION['TxtProvincia'] = $Provincia;$_SESSION['TxtCP'] = $CP;
header("Location:".$_SERVER['HTTP_REFERER']);

}

?>

