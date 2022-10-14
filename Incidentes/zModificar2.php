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
	$tnom=mysql_real_escape_string($_POST['TxtNombre2']);
	$ttel=mysql_real_escape_string($_POST['TxtTel']);
	$tlic=mysql_real_escape_string($_POST['TxtLic2']);
	$tvto=GLO_FechaMySql($_POST['TxtVto2']);
	$tcat=mysql_real_escape_string($_POST['TxtCat2']);
	$tpat=mysql_real_escape_string($_POST['TxtPat']);
	$tpol=mysql_real_escape_string($_POST['TxtPol']);
	$taseg=mysql_real_escape_string($_POST['TxtAseg']);
	$temp=mysql_real_escape_string($_POST['TxtEmpresa']);
	$tauto=mysql_real_escape_string($_POST['TxtModelo']);
	//
	$clic=mysql_real_escape_string($_POST['TxtLic']);
	$cvto=GLO_FechaMySql($_POST['TxtVto']);
	$ccat=mysql_real_escape_string($_POST['TxtCat']);
	//
	$dir=mysql_real_escape_string($_POST['TxtDir']);
	$idloc=intval($_POST['CbLocalidad']);
	$camino=mysql_real_escape_string($_POST['TxtEstado']);
	$clima=mysql_real_escape_string($_POST['TxtEstado2']);
	$s=intval($_POST['TxtS']);
	$c=mysql_real_escape_string($_POST['TxtC']);
	$p=mysql_real_escape_string($_POST['TxtP']);
	//
	$derrame=mysql_real_escape_string($_POST['TxtDerrame']);
	$lugar=mysql_real_escape_string($_POST['TxtLugar']);
	$cant=mysql_real_escape_string($_POST['TxtCantidad']);
	$sup=intval($_POST['TxtSup']);
	$rn=mysql_real_escape_string($_POST['TxtObs']);
	$rc=intval($_POST['CbEstado']);
	$idpr=intval($_POST['CbPersonal']);
	//verifico si existe
	$query="SELECT Id FROM incidentes_amb Where IdP=$idp";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)==0){$existe=0;}else{$existe=1;}mysql_free_result($rs);
	//insert o update
	if($existe==0){
		$nroId=GLO_generoID('incidentes_amb',$conn);
		$query="INSERT INTO incidentes_amb(Id,IdP,NroD,TNom,TTel,TLic,TVto,TCat,TPat,TPol,TAseg,TEmp,TAuto,CLic,CVto,CCat,Dir,IdLoc,Camino,Clima, S,C,P,Derrame,Lugar,Cant,Sup,RN,RC,IdPR) VALUES ($nroId,$idp,'$nrod','$tnom','$ttel','$tlic','$tvto','$tcat','$tpat','$tpol','$taseg','$temp','$tauto','$clic','$cvto','$ccat','$dir',$idloc,'$camino','$clima',$s,'$c','$p','$derrame','$lugar','$cant',$sup,'$rn',$rc,$idpr)"; 									
	}else{
		//update
		$query="Update incidentes_amb Set NroD='$nrod',TNom='$tnom',TTel='$ttel',TLic='$tlic',TVto='$tvto',TCat='$tcat',TPat='$tpat',TPol='$tpol',TAseg='$taseg',TEmp='$temp',TAuto='$tauto',CLic='$clic',CVto='$cvto',CCat='$ccat',Dir='$dir',IdLoc=$idloc,Camino='$camino',Clima='$clima', S=$s,C='$c',P='$p',Derrame='$derrame',Lugar='$lugar',Cant='$cant',Sup=$sup,RN='$rn',RC=$rc,IdPR=$idpr Where Id=$id";
	}
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	//limpiar datos del form anterior
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar2.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");		
}




elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:Modificar.php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");	
}

else {
include ("../IncludesNG/ElseComboLoc.php");
header("Location:Modificar2.php?id=".intval($_POST['TxtNroEntidad']));
}

?>