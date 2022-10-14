<? 
include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


if (isset($_POST['CmdAceptar'])){
	if ((empty($_POST['TxtNombre'])) or (empty($_POST['TxtDominio'])) or (empty($_POST['TxtFechaA']))){
		foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
		GLO_feedback(3);header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=False");
	}else{ 
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nom=mysql_real_escape_string(ltrim($_POST['TxtNombre']));
		if (empty($_POST['TxtFechaA'])){$fechaa="0000-00-00";}else{$fechaa=FechaMySql($_POST['TxtFechaA']);}	
		if (empty($_POST['TxtFechaB'])){$fechab="0000-00-00";}else{$fechab=FechaMySql($_POST['TxtFechaB']);}
		$sec=intval($_POST['CbSector']); 
		$serv=intval($_POST['CbServicio']); 
		$elem=intval($_POST['CbElem']); 
		$anio=intval($_POST['TxtAnio']); 
		$dom=mysql_real_escape_string($_POST['TxtDominio']);
		$mar=intval($_POST['CbMarca']); 
		$cat=intval($_POST['CbCateg']); 
		$cond=intval($_POST['CbCond']); 
		$fabr=intval($_POST['CbFabr']); 
		$mod=mysql_real_escape_string($_POST['TxtModelo']);
		$chas=mysql_real_escape_string($_POST['TxtChasis']);
		$mot=mysql_real_escape_string($_POST['TxtMotor']);
		$prop=mysql_real_escape_string($_POST['CbProp']); 
		$alq=intval($_POST['ChkAlq']); 
		$propio=intval($_POST['ChkProp']); 
		$leas=intval($_POST['ChkLeas']); 
		$af=intval($_POST['ChkAfe']); 
		$obs=mysql_real_escape_string($_POST['TxtObs']);
		$mart=intval($_POST['CbMarcaT']); 
		$rod=intval($_POST['CbRodado']); 
		$kmi=intval($_POST['TxtKmI']); 
		$taco=intval($_POST['ChkTaco']); 
		$ntaco=mysql_real_escape_string($_POST['TxtTaco']); 
		$cub=intval($_POST['TxtCub']); 
		$psa=intval($_POST['CbPSA']); 
		$pst=intval($_POST['CbPST']); 
		$psrcc=intval($_POST['CbPSRCC']); 
		$ipsa=intval($_POST['TxtPSA']); 
		$ipst=intval($_POST['TxtPST']); 
		$ipsrcc=intval($_POST['TxtPSRCC']); 
		$costo=GLO_GrabarImporte($_POST['TxtPrecio']);
		$costor=GLO_GrabarImporte($_POST['TxtPrecioR']);
		$mes=intval($_POST['TxtMes']); 
		$fadq=intval($_POST['CbFAdq']); 
		$id=intval($_POST['TxtNumero']);
		//graba valores si es perfil admin
		 if ($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2){$wup=",Precio=$costo,Meses=$mes,PrecioR=$costor,IdFormaA=$fadq";}
		 else{$wup="";} 
		$query="UPDATE unidades set Nombre='$nom',FechaAlta='$fechaa',FechaBaja='$fechab',IdElemento=$elem,Anio=$anio,Dominio='$dom',IdMarca=$mar,IdCateg=$cat,IdCond=$cond,IdFabr=$fabr,Modelo='$mod',Titular='$prop',Alquilado=$alq,Afectado=$af,Obs='$obs',IdSector=$sec,IdServicio=$serv,IdMarcaTaco=$mart,IdRodado=$rod,NroChasis='$chas',NroMotor='$mot',KmI=$kmi,Taco=$taco,NroTaco='$ntaco',Cub=$cub,IdPSA=$psa,IdPST=$pst,ItPSA=$ipsa,ItPST=$ipst,Propio=$propio,Leasing=$leas,IdPSRCC=$psrcc,ItPSRCC=$ipsrcc $wup Where Id=$id";
		$rs=mysql_query($query,$conn);
		if ($rs){GLO_feedback(1);}
		else{GLO_feedback(2);$_SESSION['GLO_msgE']=$_SESSION['GLO_msgE'].'. Verifique que Dominio y Nombre no esten repetidos'; } 
		mysql_close($conn); 
	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
		header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
}


//cubiertas
elseif (isset($_POST['CmdAddCub'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaCub.php?Id=".intval($_POST['TxtNumero']).'#A5');
}
elseif (isset($_POST['CmdBorrarFilaCub'])){
	$query="Delete From unidades_cubiertas Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A5');
}



elseif (isset($_POST['CmdAddC'])){
	header("Location:AltaComentario.php?Id=".intval($_POST['TxtNumero'])."&identidad=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaC'])){
	$query="Delete From unidadescomentarios Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A6');	
}




elseif (isset($_POST['CmdAddCon'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaCon.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaCon'])){
	$query="Delete From unidades_con Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A8');	
}


//vtos
elseif (isset($_POST['CmdAddVto'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaVto.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaVto'])){
	$query="Delete From unidadesvtos Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A4');
}


//unidades accesorias
elseif (isset($_POST['CmdAddUA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:AltaUniAcc.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaUA'])){
	$query="Delete From unidades_acc Where Id=".intval($_POST['TxtId']);
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A1');
}





//archivos adjuntos
elseif (isset($_POST['CmdAddA'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:ArchivoUnidad.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdBorrarFilaA'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);$id=intval($_POST['TxtId']);
	//busco path
	$query="SELECT Ruta From unidadesarchivos Where Id=$id";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){$archivo=$row['Ruta'];}else{$archivo="";}mysql_free_result($rs);
	//elimino
	$query="Delete From unidadesarchivos Where Id=$id";$rs=mysql_query($query,$conn);	
	if($rs){unlink('../Archivos/Adjuntos/'.$archivo) ;}
	mysql_close($conn); 	
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True".'#A7');
}
elseif (isset($_POST['CmdVerFile'])){
	GLO_OpenFile("unidadesarchivos",intval($_POST['TxtId']),"Adjuntos/","Ruta");
}



//foto form
elseif (isset($_POST['CmdArchivo'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}		
	header("Location:Archivo.php?Id=".intval($_POST['TxtNumero']));
}
elseif (isset($_POST['CmdVerFoto'])){
	GLO_OpenFile("unidades",intval($_POST['TxtNumero']),"Fotos/","Foto");
}
elseif (isset($_POST['CmdBorrarFoto'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="UPDATE unidades set Foto='' Where Id=".intval($_POST['TxtNumero']);
	$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2); } 
	mysql_close($conn); 
	foreach($_POST as $key => $value){$_SESSION[$key] = "";		}
	header("Location:Modificar.php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}








?>


