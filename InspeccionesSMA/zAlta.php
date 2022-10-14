<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

if (isset($_POST['CmdAceptar'])){ 
	if ( empty($_POST['TxtFechaA']) or empty($_POST['CbCentro']) or empty($_POST['CbYac']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Alta.php");
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}
		$hora=$_POST['TxtHora'];if($hora==''){$hora='00:00';}	
		$centro=intval($_POST['CbCentro']); 
		$yac=intval($_POST['CbYac']); 
		$p1=intval($_POST['CbP1']); 
		$p2=intval($_POST['CbP2']); 
		$p3=intval($_POST['CbP3']); 
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		for ($i=1; $i < 9; $i= $i +1) {$opt='CbU'.$i;${'idu'.$i}=intval($_POST[$opt]);}
		for ($i=1; $i < 9; $i= $i +1) {$opt='CbEU'.$i;${'ideu'.$i}=intval($_POST[$opt]);}
		for ($i=1; $i < 13; $i= $i +1) {$opt='ChkI'.$i;${'insp'.$i}=intval($_POST[$opt]);}
		//$wq
		$wq1='';$wq2='';
		for ($i=1; $i < 9; $i= $i +1) {$wq1=$wq1.",IdU".$i;}
		for ($i=1; $i < 9; $i= $i +1) {$wq1=$wq1.",IdEU".$i;}
		for ($i=1; $i < 13; $i= $i +1) {$wq1=$wq1.",I".$i;}
		for ($i=1; $i < 9; $i= $i +1) {$wq2=$wq2.",".${'idu'.$i};}
		for ($i=1; $i < 9; $i= $i +1) {$wq2=$wq2.",".${'ideu'.$i};}
		for ($i=1; $i < 13; $i= $i +1) {$wq2=$wq2.",".${'insp'.$i};}
		//query
		$nroId=GLO_generoID('inspecciones',$conn);
		$query="INSERT INTO inspecciones (Id,Fecha,Hora,IdCentro,IdYac,IdP1,IdP2,IdP3,Obs,Foto".$wq1.") VALUES ($nroId,'$fechaa','$hora',$centro,$yac,$p1,$p2,$p3,'$obs',''".$wq2.")"; 
		$rs=mysql_query($query,$conn); 
		if ($rs){$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
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

