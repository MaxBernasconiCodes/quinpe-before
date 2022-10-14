<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdAceptar'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	//datos
	$id=intval($_POST['TxtNumero']);
	$idp=intval($_POST['TxtNroEntidad']);
	//
	$nrod=mysql_real_escape_string($_POST['TxtNro']);
	$tpoe=mysql_real_escape_string($_POST['TxtTpoE']);
	$tpop=mysql_real_escape_string($_POST['TxtTpoP']);
	//
	$dir=mysql_real_escape_string($_POST['TxtDir']);
	$idloc=intval($_POST['CbLocalidad']);
	//
	$obs1=mysql_real_escape_string($_POST['TxtObs1']);
	$obs2=mysql_real_escape_string($_POST['TxtObs2']);
	$obs3=mysql_real_escape_string($_POST['TxtObs3']);
	$horas=floatval($_POST['TxtHs']);
	$dias=intval($_POST['TxtDias']);
	//
	$tn1=mysql_real_escape_string($_POST['TxtTN1']);
	$te1=mysql_real_escape_string($_POST['TxtTE1']);
	$tc1=mysql_real_escape_string($_POST['TxtTC1']);
	$tt1=mysql_real_escape_string($_POST['TxtTT1']);
	
	$tn2=mysql_real_escape_string($_POST['TxtTN2']);
	$te2=mysql_real_escape_string($_POST['TxtTE2']);
	$tc2=mysql_real_escape_string($_POST['TxtTC2']);
	$tt2=mysql_real_escape_string($_POST['TxtTT2']);

	$tn3=mysql_real_escape_string($_POST['TxtTN3']);
	$te3=mysql_real_escape_string($_POST['TxtTE3']);
	$tc3=mysql_real_escape_string($_POST['TxtTC3']);
	$tt3=mysql_real_escape_string($_POST['TxtTT3']);
	
	$tn4=mysql_real_escape_string($_POST['TxtTN4']);
	$te4=mysql_real_escape_string($_POST['TxtTE4']);
	$tc4=mysql_real_escape_string($_POST['TxtTC4']);
	$tt4=mysql_real_escape_string($_POST['TxtTT4']);
	//
	$tipo=intval($_POST['OptTipo']);
	//verifico si existe
	$query="SELECT Id FROM incidentes_acc Where IdP=$idp";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)==0){$existe=0;}else{$existe=1;}mysql_free_result($rs);
	//insert o update
	if($existe==0){
		$nroId=GLO_generoID('incidentes_acc',$conn);
		$query="INSERT INTO incidentes_acc(Id,IdP,NroD,TpoE,TpoP,Dir,IdLoc,Lesion,PriAux,AtMed,Horas,Dias,TN1,TE1,TC1,TT1,TN2,TE2,TC2,TT2,TN3,TE3,TC3,TT3,TN4,TE4,TC4,TT4,Tipo,Foto) VALUES ($nroId,$idp,'$nrod','$tpoe','$tpop','$dir',$idloc,'$obs1','$obs2','$obs3',$horas,$dias,'$tn1','$te1','$tc1','$tt1','$tn2','$te2','$tc2','$tt2','$tn3','$te3','$tc3','$tt3','$tn4','$te4','$tc4','$tt4',$tipo,'')"; 									
	}else{
		//update
		$query="Update incidentes_acc Set NroD='$nrod',TpoE='$tpoe',TpoP='$tpop',Dir='$dir',IdLoc=$idloc,Lesion='$obs1',PriAux='$obs2',AtMed='$obs3',Horas=$horas,Dias=$dias,TN1='$tn1',TE1='$te1',TC1='$tc1',TT1='$tt1',TN2='$tn2',TE2='$te2',TC2='$tc2',TT2='$tt2',TN3='$tn3',TE3='$te3',TC3='$tc3',TT3='$tt3',TN4='$tn4',TE4='$te4',TC4='$tc4',TT4='$tt4',Tipo=$tipo Where Id=$id";
	}
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar1.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");		
}

//foto 
elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:Foto.php?Id=".intval($_POST['TxtNumero'])."&IdP=".intval($_POST['TxtNroEntidad']));
}
elseif (isset($_POST['CmdVerFoto'])){
	GLO_OpenFile("incidentes_acc",intval($_POST['TxtNumero']),"SMA/","Foto");
}
elseif (isset($_POST['CmdBorrarFoto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="UPDATE incidentes_acc set Foto='' Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar1.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");		
}


elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	
}

else {
include ("../IncludesNG/ElseComboLoc.php");
header("Location:Modificar1.php?id=".intval($_POST['TxtNroEntidad']));
}

?>