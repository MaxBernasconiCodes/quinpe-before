<?php include("Seguridad.php") ;

////////// 1. TABLA BASICA //////////
function GLO_tablabasica($maxlength,$close,$ruta,$titulo,$banner,$footer,$accion){//$close=1 cerrar es windowsclose
	include ("HeadFull.php");
	echo '<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >';
	GLO_bodyform('TxtNombre',0,0);
	include ($banner.".php");
	echo '<form name="Formulario" action="'.$accion.'.php" method="post">';
	if($accion=='zAgregar'){GLO_tituloypath(0,600,'',$titulo,'close');}else{GLO_tituloypath(0,600,'',$titulo,'salir');}
	echo '<table width="600" border="0"  cellspacing="0" class="Tabla" >
	<tr> <td width="100" height="5"  ></td> <td width="500"></td></tr>
	<tr> <td height="3"><input  name="TxtNumero" type="hidden" value="'.$_SESSION['TxtNumero'].'"></td></tr>
	<tr><td height="18"  align="right"  >Nombre:</td><td valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:400px" tabindex="1" maxlength="'.$maxlength.'"  value="'; echo $_SESSION['TxtNombre']; echo '" onKeyUp="this.value=this.value.toUpperCase()"> <label class="MuestraError"> * </label></td></tr>
	</table>';
	GLO_guardar(600,2,0);
	GLO_mensajeerror();
	GLO_cierratablaform();          
	include ($footer.".php");
}

function GLO_datostablabasica($tabla,$campo){
//get (seguridad)
GLO_ValidaGET($campo,0,0);

include("Config.php");
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$query="SELECT * From $tabla where Id=$campo";$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);$_SESSION['TxtNombre'] = $row['Nombre'];}
mysql_free_result($rs);
mysql_close($conn);
}

function GLO_cambiotablabasica($tipo,$tabla,$pagina,$campo,$numero){
include("Config.php");
if (isset($_POST['CmdAceptar'])){
	if ((empty($campo))){
		foreach($_POST as $key => $value){	$_SESSION[$key] = $value;	}		
		GLO_feedback(3);		
	    if($tipo=='alta'){header("Location:Alta.php");}
		if($tipo=='agregar'){header("Location:Agregar.php");}
		if($tipo=='modificar'){header("Location:Modificar.php?id=".$numero);}
	}else{
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$nombre=mysql_real_escape_string(ltrim($campo));
		if($tipo=='modificar'){$query="UPDATE $tabla set Nombre='$nombre' Where Id=$numero";}
		else{$nroId=GLO_generoID($tabla,$conn);$query="INSERT INTO $tabla (Id,Nombre) VALUES ($nroId,'$nombre')";}
		$rs=mysql_query($query,$conn);
		if($tipo!='agregar'){if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} }
		mysql_close($conn); //cierro la conexion con la db
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}		
		if($tipo=='agregar'){echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";}
		else{
			if($tipo=='alta'){header("Location:Alta.php");}
			if($tipo=='modificar'){header("Location:../".$pagina.".php");}
		}
	}		
}


elseif (isset($_POST['CmdCancelar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../".$pagina.".php");
}

elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:../".$pagina.".php");
}

}


function GLO_consultatablabasica($tabla,$pagina,$volver,$numero){
include("Config.php");
if (isset($_POST['CmdAgregar'])){	header("Location:Alta.php");}

if (isset($_POST['CmdBorrarFila'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="Delete From $tabla Where Id<>0 and Id=$numero";$rs=mysql_query($query,$conn);
	if ($rs){GLO_feedback(1);}else{GLO_feedback(2);} 
	mysql_close($conn); 
	header("Location:../".$pagina.".php");
}

if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = '';}
	header("Location:../".$volver.".php");
}

if (isset($_POST['CmdExcel'])){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT * From $tabla where Id<>0 Order by Nombre";$rs=mysql_query($query,$conn);
	include("../Codigo/ExcelHeader.php");
	include("../Codigo/ExcelStyle.php");	
	echo "<th>Nombre</th>\n";
	echo "</tr>\n";				
	while($row=mysql_fetch_array($rs)){ 
		echo "<tr>\n";
		echo "<td>".GLO_textoExcel($row['Nombre'])."</td>\n";
		echo "</tr>\n";		
	}mysql_free_result($rs);	
	echo "</table>\n";
	mysql_close($conn); 	
}
	
}


function GLO_MostrarTablaBasica($conn,$tabla,$pagina,$sineliminar){
	$query="SELECT * From $tabla where Id<>0 Order by Nombre";$rs=mysql_query($query,$conn);
	$tablaclientes='';
	$tablaclientes .=GLO_inittabla(600,1,0,0);
	$tablaclientes .='<td width="570" class="TableShowT">Nombre</td>';   
	$tablaclientes .='<td width="30" class="TableShowT"></td>'; 
	$tablaclientes .='</tr>';             
	$recuento=0; $estilo=" style='cursor:pointer;'";
	while($row=mysql_fetch_array($rs)){ 	
		$link=" onclick="."location='".$pagina."/Modificar.php?id=".$row['Id']."'";
		$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
		$tablaclientes .='<td class="TableShowD"'.$link.'>'.substr($row['Nombre'],0,50)."</td>"; 
		$tablaclientes .='<td class="TableShowD TAC">';  
		if($sineliminar==0){	
		$tablaclientes .=GLO_rowbutton("CmdBorrarFila",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar '.substr($row['Nombre'],0,20),1,0,0);
		}
		$tablaclientes .=" </td></tr> ";
		$recuento++;
	}mysql_free_result($rs);	
	$tablaclientes .=GLO_fintabla(1,0,$recuento);
	echo $tablaclientes;	
}


function GLO_principaltablabasica($ruta,$titulo,$pagina,$banner,$footer,$tabla,$sineliminar){
include("Config.php");
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
include ("HeadFull.php");
echo'<link rel="STYLESHEET" type="text/css" href="CSS/Estilo.css" >';
GLO_bodyform('',0,0);
include ($banner.".php");
echo'<form  name="Formulario" action="'.$pagina.'/zConsulta.php" method="post">';
GLO_tituloypath(750,600,$ruta,$titulo,'basica');
GLO_mensajeerror();
GLO_MostrarTablaBasica($conn,$tabla,$pagina,$sineliminar);
echo '<input  name="TxtId"  type="hidden"  value="'.$_SESSION['TxtId'].'">'; 
GLO_cierratablaform();
mysql_close($conn);
include ($footer.".php");
}

function GLOF_principaltablabasica($menuh,$titulo,$pagina,$banner,$footer,$tabla,$sineliminar){
include("Config.php");
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
GLOF_Init('',$banner,$pagina.'/zConsulta',0,$menuh,0,0,0); 
GLO_tituloypath(0,600,'',$titulo,'basica');
GLO_mensajeerror();
GLO_MostrarTablaBasica($conn,$tabla,$pagina,$sineliminar);
GLO_Hidden('TxtId',0);
GLO_cierratablaform();
mysql_close($conn);
include ($footer.".php");
}

function GLOF_tablabasica($maxlength,$close,$menuh,$titulo,$banner,$footer,$accion){//$close=1 cerrar es windowsclose
GLOF_Init('TxtNombre',$banner,$accion,0,$menuh,0,0,0); 
if($accion=='zAgregar'){GLO_tituloypath(0,600,'',$titulo,'close');}else{GLO_tituloypath(0,600,'',$titulo,'salir');}
echo '<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:400px" maxlength="'.$maxlength.'"  value="'; echo $_SESSION['TxtNombre']; echo '" onKeyUp="this.value=this.value.toUpperCase()"> <label class="MuestraError"> * </label></td></tr>
</table>';
if($close==0){GLO_botonesform(600,0,2);}else{GLO_botonesform(600,0,1);}
GLO_mensajeerror();
GLO_Hidden('TxtNumero',0);
GLO_cierratablaform();          
include ($footer.".php");
}
function GLOF_tablabasicaMIN($maxlength,$close,$menuh,$titulo,$banner,$footer,$accion){//$close=1 cerrar es windowsclose
GLOF_Init('TxtNombre',$banner,$accion,0,$menuh,0,0,0); 
if($accion=='zAgregar'){GLO_tituloypath(0,600,'',$titulo,'close');}else{GLO_tituloypath(0,600,'',$titulo,'salir');}
echo '<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:400px" maxlength="'.$maxlength.'"  value="'; echo $_SESSION['TxtNombre']; echo '" onKeyUp="this.value=this.value.toLowerCase()"> <label class="MuestraError"> * </label></td></tr>
</table>';
if($close==0){GLO_botonesform(600,0,2);}else{GLO_botonesform(600,0,1);}
GLO_mensajeerror();
GLO_Hidden('TxtNumero',0);
GLO_cierratablaform();          
include ($footer.".php");
}
function GLOF_tablabasicaMM($maxlength,$close,$menuh,$titulo,$banner,$footer,$accion){//$close=1 cerrar es windowsclose
GLOF_Init('TxtNombre',$banner,$accion,0,$menuh,0,0,0); 
if($accion=='zAgregar'){GLO_tituloypath(0,600,'',$titulo,'close');}else{GLO_tituloypath(0,600,'',$titulo,'salir');}
echo '<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Nombre:</td><td valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:400px" maxlength="'.$maxlength.'"  value="'; echo $_SESSION['TxtNombre']; echo '"> <label class="MuestraError"> * </label></td></tr>
</table>';
if($close==0){GLO_botonesform(600,0,2);}else{GLO_botonesform(600,0,1);}
GLO_mensajeerror();
GLO_Hidden('TxtNumero',0);
GLO_cierratablaform();          
include ($footer.".php");
}
////////// FIN BASICA //////////





////////// 2. TELEFONOS //////////
function GLO_TablaTelefonos($idpadre,$conn,$tabla,$wt,$v1){ 
$idpadre=intval($idpadre);
$query="SELECT * From $tabla where Id<>0 and IdEntidad=$idpadre";$rs=mysql_query($query,$conn);
//calculos
$wd=$wt-300;$ld=($wd/100)*12;
//Titulos de la tabla
$tablaclientes="";
$tablaclientes .='<table width="'.$wt.'" class="TableShow" id="tshow"><tr>';
$tablaclientes .='<td width="60" class="TableShowT"> Area</td>';   
$tablaclientes .='<td width="130" class="TableShowT"> Numero</td>';   
$tablaclientes .='<td width="70" class="TableShowT"> Interno</td>';  
$tablaclientes .='<td width="'.$wd.'" class="TableShowT"> Observaciones</td>';  
$tablaclientes .='<td width="40" class="TableShowT TAR">'.GLO_FAButton('CmdAddT','submit','','self','Agregar','add','iconbtn').'</td>'; 
$tablaclientes .="</tr> ";             
while($row=mysql_fetch_array($rs)){ 
	GLO_LinkRowTablaInit($estilo,$link,$row['Id'],1);	
	$tablaclientes .='<tr '.$estilo.'>';  
	$tablaclientes .='<td class="TableShowD" '.$link.'>'.substr($row['CodigoArea'],0,10).'</td>'; 
	$tablaclientes .='<td class="TableShowD" '.$link.'>'.substr($row['NumeroTelefono'],0,25).'</td>';  
	$tablaclientes .='<td class="TableShowD" '.$link.'>'.substr($row['Interno'],0,10).'</td>';   
	$tablaclientes .='<td class="TableShowD" '.$link.'>'.substr($row['Observaciones'],0,$ld).'</td>'; 
	$tablaclientes .='<td  class="TableShowD TAR">'.GLO_rowbutton("CmdBorrarFilaT",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0).'</td>';	  
	$tablaclientes .="</tr> "; 
}mysql_free_result($rs);	
$tablaclientes .="</table>"; 
echo $tablaclientes;	
}
function GLO_adjuntartelefono($v1,$nombre,$pagina,$v2,$banner,$footer,$tabla,$nro,$identidad){
include("Config.php");
//cancelar
if (isset($_POST['CmdCancelar'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:".$pagina.".php?id=".$identidad."&Flag1=True");
}
if (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:".$pagina.".php?id=".$identidad."&Flag1=True");
}
//mostrar
$_SESSION['TxtNumero']=$nro;
$_SESSION['TxtNroEntidad']=str_pad($identidad, 6, "0", STR_PAD_LEFT);
$_SESSION['TxtCod'] ="";
$_SESSION['TxtTelefono'] ="";
$_SESSION['TxtInterno'] ="";
$_SESSION['TxtObs'] ="";
if($nombre=='modificar'){
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT * From $tabla where Id<>0 and Id=".$nro; $rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdEntidad'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtCod']=  $row['CodigoArea'];
		$_SESSION['TxtTelefono']= $row['NumeroTelefono'];
		$_SESSION['TxtInterno'] =  $row['Interno'];
		$_SESSION['TxtObs'] =  $row['Observaciones'];
	}mysql_free_result($rs);mysql_close($conn); 
}
//alta
if($nombre=='alta'){
	if (isset($_POST['CmdAceptar'])){
		if(empty($_POST['TxtTelefono'])){
			GLO_feedback(3);$grabook=0;
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$ident=intval($_POST['TxtNroEntidad']);
			$coda=mysql_real_escape_string($_POST['TxtCod']);
			$nrotel=mysql_real_escape_string($_POST['TxtTelefono']);
			$int=mysql_real_escape_string($_POST['TxtInterno']);
			$obs=mysql_real_escape_string($_POST['TxtObs']);
			//inserto
			$nroId=GLO_generoID($tabla,$conn);
			$query="INSERT INTO $tabla (Id,IdEntidad,CodigoArea,NumeroTelefono,Interno,Observaciones) VALUES ($nroId,$ident,'$coda','$nrotel','$int','$obs')";$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);$grabook=1;}else{GLO_feedback(2);$grabook=0; } 
			mysql_close($conn); 	
			//volver
			if($grabook==1){
				foreach($_POST as $key => $value){$_SESSION[$key] = "";}
				header("Location:".$pagina.".php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
			}else{
				foreach($_POST as $key => $value){$_SESSION[$key] = $value;}
				header("Location:AltaTelefono.php?Id=".intval($_POST['TxtNroEntidad'])."&identidad=".intval($_POST['TxtNroEntidad']));
			}
		}			
	}
}
//modificar
if($nombre=='modificar'){
	if (isset($_POST['CmdAceptar'])){
		if(empty($_POST['TxtTelefono'])){
			GLO_feedback(3);
		}else{
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$ident=mysql_real_escape_string($_POST['TxtNroEntidad']);
			$coda=mysql_real_escape_string($_POST['TxtCod']);
			$nrotel=mysql_real_escape_string($_POST['TxtTelefono']);
			$int=mysql_real_escape_string($_POST['TxtInterno']);
			$obs=mysql_real_escape_string($_POST['TxtObs']);
			//actualizo
			$query="UPDATE $tabla set CodigoArea='$coda',NumeroTelefono='$nrotel',Interno='$int',Observaciones='$obs'  Where Id=".intval($_POST['TxtNumero']);$rs=mysql_query($query,$conn);
			mysql_close($conn); 
		}	
		//limpiar datos del form anterior
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:".$pagina.".php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
}
//html	
GLOF_Init('TxtCod',$banner,$accion,0,'',0,0,0);   
GLO_tituloypath(0,700,'','TELEFONOS','salir');
echo '<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right"  >N&uacute;mero:</td><td>&nbsp;<input name="TxtCod" type="text"  class="TextBox" style="width:50px" maxlength="6"  value="'.$_SESSION['TxtCod'].'" onchange="this.value=validarEntero(this.value);">&nbsp;<input name="TxtTelefono" type="text"  class="TextBox" style="width:97px" maxlength="20"  value="'.$_SESSION['TxtTelefono'].'" onchange="this.value=validarEntero(this.value);"><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >Interno:</td><td>&nbsp;<input name="TxtInterno" type="text"  class="TextBox" style="width:150px" maxlength="10"  value="'.$_SESSION['TxtInterno'].'"></td></tr>
</table>';
GLO_obsform(700,100,'Observaciones','TxtObs',0,1); 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("700",0,2);
GLO_mensajeerror();                      
GLO_cierratablaform();
include ($footer.".php");
}
////////// FIN TELEFONOS ////////// 





////////// 3. ARCHIVOS /////////////
function GLO_adjuntararchivo($ruta,$subdir,$nombre,$pagina,$campo,$banner,$footer,$tabla,$nro){
//get (seguridad)
GLO_ValidaGET($nro,0,0);
include("Config.php");
$_SESSION['TxtNumero']=str_pad($nro, 6, "0", STR_PAD_LEFT);
//codigo upload
if(isset($_POST['CmdAceptar'])) {
	
    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {	
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$identidad=intval($_POST['TxtNumero']);
		$obs=mysql_real_escape_string($_POST['TxtDesA']);
		//obtengo file
		$extension= $_FILES['archivo']['name'];$extension = explode(".",$extension);
		$num = count($extension)-1;$extension2=$extension[$num];
	  	//generoid y nombre
		$nroId=GLO_generoID($tabla,$conn); 
		$nombrearchivo=$nombre.$nroId.'.'.$extension2;
		//copia e inserta
		$resultadocopy=copy($_FILES['archivo']['tmp_name'], '../Archivos/'.$subdir.$nombrearchivo);
		if($resultadocopy){ 
			$query="INSERT INTO $tabla (Id,IdEntidad,Descripcion,Ruta) VALUES ($nroId,$identidad,'$obs','$nombrearchivo')";
			$rs=mysql_query($query,$conn);
		}
		mysql_close($conn); 	  
    }
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:".$pagina.".php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
} 
//cancelar
elseif (isset($_POST['CmdSalir'])){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:".$pagina.".php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
//html	  
include ("HeadFull.php");
echo'<link rel="STYLESHEET" type="text/css" href="'.'../CSS/Estilo.css" >';
GLO_bodyform('',0,0);
include ($banner.".php");
echo'<form name="Formulario" action="" method="post" enctype="multipart/form-data">';
GLO_tituloypath(0,700,$ruta,'ARCHIVO','salir');
echo '<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right">Archivo:</td><td  valign="top" >&nbsp;<input name="archivo" id="archivo" type="file"  class="TextBox" style="width:300px;" maxlength="150"  value="'.$_SESSION['TxtLogoAdd'].'"></td></tr>
</table>';
GLO_Hidden('TxtNumero',0);
GLO_obsform(700,100,'Observaciones','TxtDesA',0,2);
GLO_botonesform(700,0,2);
GLO_cierratablaform();
GLO_initcomment(700,0);
echo 'Seleccione un <font class="comentario2">Archivo</font> y grabe los cambios';
GLO_endcomment();
include ($footer.".php");
}



function GLO_adjuntararchivoupdate($ruta,$subdir,$nombre,$pagina,$campo,$banner,$footer,$tabla,$nro){
include("Config.php");
$_SESSION['TxtNumero']=str_pad($nro, 6, "0", STR_PAD_LEFT);
//codigo upload
if(isset($_POST['CmdAceptar'])) {
    if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {	
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$identidad=intval($_POST['TxtNumero']);
		//obtengo file
		$extension= $_FILES['archivo']['name'];$extension = explode(".",$extension);
		$num = count($extension)-1;$extension2=$extension[$num];
		$nombrearchivo=$nombre.$identidad.'.'.$extension2;
		//copia e inserta
		$resultadocopy=copy($_FILES['archivo']['tmp_name'], '../Archivos/'.$subdir.$nombrearchivo);
		if($resultadocopy){  	
			$query="Update $tabla Set Ruta='$nombrearchivo' Where Id=$identidad";$rs=mysql_query($query,$conn); 
		}
		mysql_close($conn); 		  
    }
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:".$pagina.".php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
} 
//cancelar
if ( isset($_POST['CmdSalir']) ){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:".$pagina.".php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
}
//html	  
include ("HeadFull.php");
echo'<link rel="STYLESHEET" type="text/css" href="'.'../CSS/Estilo.css" >';
GLO_bodyform('',0,0);
include ($banner.".php");
echo'<form name="Formulario" action="" method="post" enctype="multipart/form-data">';
GLO_tituloypath(0,500,'','ARCHIVO','salir');
echo '<table width="500" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="3"  ></td> <td width="400"></td> </tr>
<tr> <td height="18"  align="right"  >Archivo:</td><td  valign="top" >&nbsp;<input name="archivo" id="archivo" type="file"  class="TextBox" style="width:300px;" maxlength="150"  value="'.$_SESSION['TxtLogoAdd'].'"></td></tr>
</table>';
GLO_Hidden('TxtNumero',0);
GLO_botonesform(500,0,2);
GLO_cierratablaform();
GLO_initcomment(500,0);
echo 'Seleccione un <font class="comentario2">Archivo</font> y grabe los cambios';
GLO_endcomment();
include ($footer.".php");
}

function GLO_fileupdate($v1,$subdir,$nombre,$pagina,$campo,$banner,$footer,$tabla,$nro){
	//GLO_adjuntararchivoupdate nuevo, permite elegir el nombre del campo a actualizar
	include("Config.php");
	$_SESSION['TxtNumero']=str_pad($nro, 6, "0", STR_PAD_LEFT);
	//codigo upload
	if(isset($_POST['CmdAceptar'])) {
		if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {	
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$identidad=intval($_POST['TxtNumero']);
			//obtengo file
			$extension= $_FILES['archivo']['name'];$extension = explode(".",$extension);
			$num = count($extension)-1;$extension2=$extension[$num];
			$nombrearchivo=$nombre.$identidad.'.'.$extension2;
			//copia e inserta
			$resultadocopy=copy($_FILES['archivo']['tmp_name'], '../Archivos/'.$subdir.$nombrearchivo);
			if($resultadocopy){  	
				$query="Update $tabla Set $campo='$nombrearchivo' Where Id=$identidad";$rs=mysql_query($query,$conn); 
			}
			mysql_close($conn); 		  
		}
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:".$pagina.".php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	} 
	//cancelar
	if ( isset($_POST['CmdSalir']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:".$pagina.".php?id=".intval($_POST['TxtNumero'])."&Flag1=True");
	}
	//html	  
	include ("HeadFull.php");
	echo'<link rel="STYLESHEET" type="text/css" href="'.'../CSS/Estilo.css" >';
	GLO_bodyform('',0,0);
	include ($banner.".php");
	echo'<form name="Formulario" action="" method="post" enctype="multipart/form-data">';
	GLO_tituloypath(0,500,'','ARCHIVO','salir');
	echo '<table width="500" border="0"   cellspacing="0" class="Tabla" >
	<tr> <td width="100" height="3"  ></td> <td width="400"></td> </tr>
	<tr> <td height="18"  align="right"  >Archivo:</td><td  valign="top" >&nbsp;<input name="archivo" id="archivo" type="file"  class="TextBox" style="width:300px;" maxlength="150"  value="'.$_SESSION['TxtLogoAdd'].'"></td></tr>
	</table>';
	GLO_Hidden('TxtNumero',0);
	GLO_botonesform(500,0,2);
	GLO_cierratablaform();
	GLO_initcomment(500,0);
	echo 'Seleccione un <font class="comentario2">Archivo</font> y grabe los cambios';
	GLO_endcomment();
	include ($footer.".php");
}
	

function GLO_TablaArchivos($idpadre,$conn,$tabla,$wt,$ruta){//GLO_MostrarTablaArchivos con Add en titulo
$idpadre=intval($idpadre);
$query="SELECT * From $tabla where IdEntidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);
//calculos
$wd=$wt-50;$ld=($wd/100)*12;
//Titulos de la tabla
$tablaclientes="";
$tablaclientes .="<table width=".$wt." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>";  
$tablaclientes .="<td "."width=".$wd." class="."TablaTituloDato"."> Descripcion</td>";  
$tablaclientes .="<td class="."TablaTituloLeft"."> </td>";  
$tablaclientes .="<td width="."50"." class="."TablaTituloDatoR".">".GLO_rowbutton("CmdAddA",0,"Agregar",'self','add','iconlgray','',0,0,0).'</td>'; 
$tablaclientes .="<td class="."TablaTituloRight"."> </td>";  
$tablaclientes .=" </tr> ";             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDato"." > ".substr($row['Descripcion'],0,$ld)."</td>"; 
	$tablaclientes .="<td class="."TablaMostrarLeft"."> </td>";  
	$tablaclientes .="<td  class="."TablaDatoR"." >"; 
	$tablaclientes .=GLO_rowbutton("CmdVerFile",$row['Id'],"Ver",'blank','lupa','iconlgray','',0,0,0);   
	$tablaclientes .='&nbsp;&nbsp;'.GLO_rowbutton("CmdBorrarFilaA",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td><td class="."TablaMostrarRight"."> </td></tr>";  
}mysql_free_result($rs);	
$tablaclientes .="</table>";
echo $tablaclientes;	
}



function GLO_VerTablaArchivos($idpadre,$conn,$tabla,$wt,$v1,$butt){//GLO_TablaArchivos con botones distintos
$idpadre=intval($idpadre);
$query="SELECT * From $tabla where IdEntidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);
//calculos
$wd=$wt-50;$ld=($wd/100)*12;
//Titulos de la tabla
$tablaclientes="";
$tablaclientes .='<table width="'.$wt.'" class="TableShow" id="tshow"><tr>';
$tablaclientes .='<td width="'.$wd.'" class="TableShowT"> Descripcion</td>';  
$tablaclientes .='<td width="50" class="TableShowT TAR">'.GLO_rowbutton("CmdAddA".$butt,0,"Agregar",'self','add','iconlgray','',0,0,0).'</td>'; 
$tablaclientes .='</tr>';             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .='<td  class="TableShowD">'.substr($row['Descripcion'],0,$ld)."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR" >'; 
	$tablaclientes .=GLO_rowbutton("CmdVerFile".$butt,$row['Id'],"Ver",'blank','lupa','iconlgray','',0,0,0);  
	$tablaclientes .='&nbsp;&nbsp;'.GLO_rowbutton("CmdBorrarFilaA".$butt,$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); 
	$tablaclientes .="</td></tr>";  
}mysql_free_result($rs);	
$tablaclientes .="</table>";
echo $tablaclientes;	
}



function GLO_FAAdjuntarArchivos($idpadre,$conn,$tabla,$wt,$ruta,$titulo,$icono,$add,$del,$butt){
$idpadre=intval($idpadre);
$query="SELECT * From $tabla where IdEntidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);
//calculos
$wd=$wt-50;$ld=($wd/100)*12;
//Titulos de la tabla
$tablaclientes='';
$tablaclientes='<table width="'.$wt.'" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3" ></td></tr><tr ><td height="18" ><i class="fa fa-'.$icono.' iconsmallsp iconlgray"></i>&nbsp;<strong>'.$titulo.':</strong></td></tr><tr> <td  align="center">';
$tablaclientes .='<table width="'.$wt.'" class="TableShow" id="tshow"><tr>';
$tablaclientes .="<td "."width=".$wd." class="."TableShowT"."> Descripcion</td>";  
$tablaclientes .='<td width="50" class="TableShowT TAR">'; 
if($add==0){$tablaclientes .=GLO_rowbutton("CmdAddA".$butt,0,"Agregar",'self','add','iconlgray','',0,0,0); }
$tablaclientes .="</td></tr> ";             
//Datos
while($row=mysql_fetch_array($rs)){
	$tablaclientes .=" <tr> ";  
	$tablaclientes .="<td  class="."TableShowD"." > ".substr($row['Descripcion'],0,$ld)."</td>"; 
	$tablaclientes .='<td  class="TableShowD TAR">'; 
	$tablaclientes .=GLO_rowbutton("CmdVerFile".$butt,$row['Id'],"Ver",'blank','lupa','iconlgray','',0,0,0);  
	if($del==0){$tablaclientes .='&nbsp;&nbsp;'.GLO_rowbutton("CmdBorrarFilaA".$butt,$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); } 
	$tablaclientes .="</td></tr>";  
}mysql_free_result($rs);	
$tablaclientes .='</table></td></tr><tr> <td height="10"></td></tr></table>';
echo $tablaclientes;	
}
function GLO_Archivos($idpadre,$conn,$tabla,$wt,$titulo,$icono,$add,$del,$butt,$tmt,$v1,$v2,$v3){//reemplaza a GLO_FAAdjuntarArchivos
	$idpadre=intval($idpadre);
	$query="SELECT * From $tabla where IdEntidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);
	//calculos
	$wd=$wt-50;$ld=($wd/100)*12;
	if($tmt!=''){$tmt='class="'.$tmt.'"';}
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes='<table width="'.$wt.'" border="0"  cellpadding="0" cellspacing="0" '.$tmt.'><tr> <td height="3" ></td></tr><tr ><td height="18" ><i class="fa fa-'.$icono.' iconsmallsp iconlgray"></i>&nbsp;<strong>'.$titulo.':</strong></td></tr><tr> <td  align="center">';
	$tablaclientes .='<table width="'.$wt.'" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width=".$wd." class="."TableShowT"."> Descripcion</td>";  
	$tablaclientes .='<td width="50" class="TableShowT TAR">'; 
	if($add==0){$tablaclientes .=GLO_rowbutton("CmdAddA".$butt,0,"Agregar",'self','add','iconlgray','',0,0,0); }
	$tablaclientes .="</td></tr> ";             
	//Datos
	while($row=mysql_fetch_array($rs)){
		$tablaclientes .=" <tr> ";  
		$tablaclientes .="<td  class="."TableShowD"." > ".substr($row['Descripcion'],0,$ld)."</td>"; 
		$tablaclientes .='<td  class="TableShowD TAR">'; 
		$tablaclientes .=GLO_rowbutton("CmdVerFile".$butt,$row['Id'],"Ver",'blank','lupa','iconlgray','',0,0,0);  
		if($del==0){$tablaclientes .='&nbsp;&nbsp;'.GLO_rowbutton("CmdBorrarFilaA".$butt,$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); } 
		$tablaclientes .="</td></tr>";  
	}mysql_free_result($rs);	
	$tablaclientes .='</table></td></tr><tr> <td height="10"></td></tr></table>';
	echo $tablaclientes;	
}
	




// files 202105
function GLO_files($idpadre,$conn,$tabla,$wt,$titulo,$icono,$add,$del,$upd,$butt){
	$idpadre=intval($idpadre);
	$query="SELECT * From $tabla where IdEntidad=$idpadre Order by Id";$rs=mysql_query($query,$conn);
	//calculos
	$wd=$wt-80;$ld=($wd/100)*12;
	//Titulos de la tabla
	$tablaclientes='';
	$tablaclientes='<table width="'.$wt.'" border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3" ></td></tr><tr ><td height="18" ><i class="fa fa-'.$icono.' iconsmallsp iconlgray"></i>&nbsp;<strong>'.$titulo.':</strong></td></tr><tr> <td  align="center">';
	$tablaclientes .='<table width="'.$wt.'" class="TableShow" id="tshow"><tr>';
	$tablaclientes .="<td "."width=".$wd." class="."TableShowT"."> Descripcion</td>";  
	$tablaclientes .='<td width="80" class="TableShowT TAR">'; 
	if($add==0){$tablaclientes .=GLO_rowbutton("CmdAddA".$butt,0,"Agregar",'self','add','iconlgray','',0,0,0); }
	$tablaclientes .="</td></tr> ";             
	//Datos
	while($row=mysql_fetch_array($rs)){
		$tablaclientes .=" <tr> ";  
		$tablaclientes .="<td  class="."TableShowD"." > ".substr($row['Descripcion'],0,$ld)."</td>"; 
		$tablaclientes .='<td  class="TableShowD TAR">'; 
		$tablaclientes .=GLO_rowbutton("CmdVerA".$butt,$row['Id'],"Ver",'blank','lupa','iconlgray','',0,0,0);  
		if($upd==0){$tablaclientes .='&nbsp;&nbsp;'.GLO_rowbutton("CmdUpdA".$butt,$row['Id'],"Actualizar",'self','folder','iconlgray','',0,0,0);}
		if($del==0){$tablaclientes .='&nbsp;&nbsp;'.GLO_rowbutton("CmdDelA".$butt,$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',0,0,0); } 
		$tablaclientes .="</td></tr>";  
	}mysql_free_result($rs);	
	$tablaclientes .='</table></td></tr><tr> <td height="10"></td></tr></table>';
	echo $tablaclientes;	
}
function GLO_filesu($subdir,$nombre,$pagina,$banner,$footer,$tabla,$nro,$nrop){
	include("Config.php");
	$_SESSION['TxtNumero']=str_pad($nro, 6, "0", STR_PAD_LEFT);//file
	$_SESSION['TxtNroEntidad']=str_pad($nrop, 6, "0", STR_PAD_LEFT);//padre
	//codigo upload
	if(isset($_POST['CmdAceptar'])) {
		$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
		$identidad=intval($_POST['TxtNumero']);
		$obs=mysql_real_escape_string($_POST['TxtDesA']);			
		if (is_uploaded_file($_FILES['archivo']['tmp_name'])) {				
			//obtengo file
			$extension= $_FILES['archivo']['name'];$extension = explode(".",$extension);
			$num = count($extension)-1;$extension2=$extension[$num];
			$nombrearchivo=$nombre.$identidad.'.'.$extension2;
			//copia e inserta
			$resultadocopy=copy($_FILES['archivo']['tmp_name'], '../Archivos/'.$subdir.$nombrearchivo);
			if($resultadocopy){ 	
				$query="Update $tabla Set Ruta='$nombrearchivo',Descripcion='$obs' Where Id=$identidad";
				$rs=mysql_query($query,$conn); 
			}else{GLO_feedback(35);}//el copy no funciono					  
		}else{//grabo solo descripcion			
			$query="Update $tabla Set Descripcion='$obs' Where Id=$identidad";$rs=mysql_query($query,$conn);
			if ($rs){GLO_feedback(1);}else{GLO_feedback(2);}
		}
		mysql_close($conn); 
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:".$pagina.".php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	} 
	//cancelar
	if (isset($_POST['CmdSalir']) ){
		foreach($_POST as $key => $value){$_SESSION[$key] = "";}
		header("Location:".$pagina.".php?id=".intval($_POST['TxtNroEntidad'])."&Flag1=True");
	}
		  
	//mostrar datos
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT Descripcion From $tabla Where Id=".intval($_SESSION['TxtNumero']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){	$_SESSION['TxtDesA'] =$row['Descripcion'];}mysql_free_result($rs);
	mysql_close($conn);
	//html
	include ("HeadFull.php");
	echo'<link rel="STYLESHEET" type="text/css" href="'.'../CSS/Estilo.css" >';
	GLO_bodyform('',0,0);
	include ($banner.".php");
	echo'<form name="Formulario" action="" method="post" enctype="multipart/form-data">';
	GLO_tituloypath(0,700,'','ARCHIVO','salir');
	echo '<table width="700" border="0"   cellspacing="0" class="Tabla" >
	<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
	<tr> <td height="18"  align="right">Archivo:</td><td  valign="top" >&nbsp;<input name="archivo" id="archivo" type="file"  class="TextBox" style="width:300px;" maxlength="150"  value="'.$_SESSION['TxtLogoAdd'].'"></td></tr>
	</table>';
	GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
	GLO_obsform(700,100,'Observaciones','TxtDesA',0,2);
	GLO_guardar(700,2,0);
	GLO_cierratablaform();
	GLO_initcomment(700,0);
	echo 'Si <font class="comentario3">no</font> selecciona <font class="comentario2">Archivo</font>, grabar&aacute; la <font class="comentario2">Descripci&oacute;n</font> y mantendr&aacute; el <font class="comentario3">Archivo</font> anterior';
	GLO_endcomment();
	include ($footer.".php");
}
	


//comentario
function GLO_adjuntarcomentario($ruta,$nombre,$pagina,$campo,$banner,$footer,$tabla,$nro,$identidad){
include("Config.php");
//php
if ( isset($_POST['CmdCancelar']) or isset($_POST['CmdSalir']) ){
	foreach($_POST as $key => $value){$_SESSION[$key] = "";}
	header("Location:".$pagina.".php?id=".$identidad."&Flag1=True");
}
//
$_SESSION['TxtNumero']=$nro;
$_SESSION['TxtNroEntidad']=str_pad($identidad, 6, "0", STR_PAD_LEFT);
$_SESSION['TxtObs'] ="";
if($nombre=='alta'){
	if (isset($_POST['CmdAceptar'])){
			//grabar los datos en la tabla
			$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
			$ident=intval($_POST['TxtNroEntidad']);	$obs=mysql_real_escape_string($_POST['TxtObs']);
			$fecha=FechaMySql(date("d-m-Y"));$user=$_SESSION["login"];
			//generoid
			$query="SELECT Max(Id) as UltimoId FROM $tabla";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
			if(mysql_num_rows($rs)==0){$nroId=1;}else{$nroId=$row['UltimoId']+1;}mysql_free_result($rs);
			//inserto
			$query="INSERT INTO $tabla (Id,IdEntidad,Comentario,IdUsuario,Fecha) VALUES ($nroId,$ident,'$obs','$user','$fecha')";
			$rs=mysql_query($query,$conn);
			mysql_close($conn); 	
			//limpiar datos del form anterior
			foreach($_POST as $key => $value){$_SESSION[$key] = "";}
			header("Location:".$pagina.".php?id=".$ident."&Flag1=True");
	}
}
if($nombre=='modificar'){
	//busco datos
	$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
	$query="SELECT * From $tabla where Id<>0 and Id=".intval($nro); 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		//busco nombre comentario
		$query= "Select p.Nombre,p.Apellido From personal p,usuarios u Where p.Id=u.IdPersonal and u.Usuario='".$row['IdUsuario']."'";
		$rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){$creadox=substr($row2['Apellido'].' '.$row2['Nombre'],0,25);} else{$creadox='';}
		mysql_free_result($rs2);
		$_SESSION['TxtUsuario']=  $creadox.' '.FormatoFecha($row['Fecha']);
		$_SESSION['TxtObs'] =  $row['Comentario'];}
	mysql_free_result($rs);mysql_close($conn); 
}
//html	  
include ("HeadFull.php");
echo'<link rel="STYLESHEET" type="text/css" href="'.'../CSS/Estilo.css" >';
GLO_bodyform('',0,0);
include ($banner.".php");
echo'<form name="Formulario" action="" method="post">';
GLO_tituloypath(0,600,$ruta,'COMENTARIOS','salir');
echo '<table width="600" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="500"></td> </tr>
<tr> <td   align="right"  valign="top" >&nbsp;Comentario:</td><td  valign="top" >&nbsp;<textarea name="TxtObs" style="width:450px;" rows="5" class="TextBox" >'.$_SESSION['TxtObs'].'</textarea></td></tr>
<tr> <td   align="right"  valign="top" >&nbsp;Usuario:</td><td  valign="top" >&nbsp;<input name="TxtUsuario"  type="text"  class="TextBoxRO" style="width:450px;"  readonly="true"  value="'.$_SESSION['TxtUsuario'].'"></td></tr>
</table>';
if($nombre=='alta'){GLO_botonesform("600",0,2);}else{GLO_botonesform("600",1,2);}
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_mensajeerror();                      
GLO_cierratablaform();
include ($footer.".php");
}




?>