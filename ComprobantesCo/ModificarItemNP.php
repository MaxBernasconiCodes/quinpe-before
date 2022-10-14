<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=4  and  $_SESSION["IdPerfilUser"]!=7 and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and  $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['IdItem'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


//mostrar datos
if ($_GET['Flag1']=="True"){
	$query="SELECT c.*,np.Fecha,np.IdPerAuto,np.IdPerPAuto,np.IdUsr,np.IdPerSoli,e.Nombre as Estado From co_npedido_it c,co_npedido np,co_npedido_est e Where c.IdNP=np.Id and c.IdEstado=e.Id and c.Id=".intval($_GET['IdItem']);	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNroEntidad']=$row['IdNP'];	
		$_SESSION['TxtNumero']=$row['Id'];
		$_SESSION['CbItem'] =$row['IdArticulo'];
		$_SESSION['CbItem2'] =$row['IdItem'];
		$_SESSION['TxtCantidad'] =$row['Cant'];
		$_SESSION['TxtCantidadA'] =$row['CantAuto'];
		$_SESSION['CbProv'] =$row['IdProv'];
		$_SESSION['CbSoli'] =$row['IdPerSoli'];
		$_SESSION['TxtUsuario']=$row['IdUsr'];
		$_SESSION['CbAuto'] =$row['IdPerAuto'];
		$_SESSION['CbPAuto'] =$row['IdPerPAuto'];
		$_SESSION['TxtIdEstado']= NP_BuscarEstadoNPIId($row['Id'],$row['IdEstado'],$conn);
		$_SESSION['TxtEstado']=NP_BuscarEstadoNPI($row['Id'],$row['Estado'],$conn);	
		$_SESSION['TxtObs'] =$row['Obs'];
		//fechas estados
		$_SESSION['TxtFechaA']='';$_SESSION['TxtFechaB']='';$_SESSION['TxtFechaC']='';$_SESSION['TxtFechaD']='';
		$_SESSION['TxtFechaE']='';$_SESSION['TxtFechaF']='';$_SESSION['TxtFechaG']='';
		//Fecha NP(Abierto 1)
		$_SESSION['TxtFechaA']=GLO_FormatoFecha($row['Fecha']);
		//Fecha NPI(Preautorizado 2)
		if ($_SESSION['TxtIdEstado']>=2 and $_SESSION['TxtIdEstado']!=4){$_SESSION['TxtFechaB']=GLO_FormatoFecha($row['FechaPAuto']);}
		//Fecha NPI(Autorizado)	
		if ($_SESSION['TxtIdEstado']>=3 and $_SESSION['TxtIdEstado']!=5){$_SESSION['TxtFechaC']=GLO_FormatoFecha($row['FechaAuto']);}
		//Fecha OC(en proceso 6)	
		if ($_SESSION['TxtIdEstado']==6 or $_SESSION['TxtIdEstado']==7){$_SESSION['TxtFechaD']='';}
		//Fecha RI(comprado 7)
		if ($_SESSION['TxtIdEstado']==7){$_SESSION['TxtFechaE']='';}
		//Fecha Comprar(comprar 8)
		if ($_SESSION['TxtIdEstado']==8){$_SESSION['TxtFechaF']=GLO_FormatoFecha($row['FechaComprar']);}
		//Fecha RE(resuelto 9)
		if ($_SESSION['TxtIdEstado']==9){$_SESSION['TxtFechaG']='';}
	}mysql_free_result($rs);	

}



GLO_InitHTML($_SESSION["NivelArbol"],'TxtCantidad','BannerPopUpMH','zModificarItemNP',0,0,0,0); 
GLO_tituloypath(0,720,'compras','DETALLE COMPROBANTE','salir');
?> 



<table width="720" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="12" height="3"  ></td> <td width="160"></td><td width="185" ></td> <td width="100"></td><td width="155"></td> </tr>
<tr> <td height="18"  align="right"  >Cantidad:</td><td  valign="top">&nbsp;<input name="TxtCantidad" type="text"  class="TextBox" style="width:50px" maxlength="7"  tabindex="4"   value="<? echo $_SESSION['TxtCantidad']; ?>" onChange="this.value=validarNumeroP(this.value);"><label class="MuestraError"> * </label></td><td  align="right" colspan="3"><input name="TxtEstado" type="text"  class="TextBoxRO" style="width:140px <? echo NP_BuscarEstadoNPIColor2(intval($_SESSION['TxtIdEstado']));?>" readonly="true" value="<? echo $_SESSION['TxtEstado']; ?>">
<?

if(intval($_SESSION['TxtIdEstado'])<6){//no tiene OC ni tiene remito, ni revisado(EN PROCESO/COMPRADO/REVISADO/RESUELTO)

	//1.Abierto (preauto/rech(p) - preautorizante)

	if (($_SESSION["GLO_IdPersLog"]==$_SESSION['CbPAuto'] or $_SESSION["GLO_IdPersLog"]==$_SESSION['CbAuto'] or $_SESSION["IdPerfilUser"]==1) and $_SESSION['TxtIdEstado']==1){

	if($_SESSION['TxtCantidadA']>0){echo '<input name="CmdPAuto" type="submit" class="boton02"  value="Autorizar" style="color:#4CAF50; border-color:#4CAF50;width:70px" onClick="document.Formulario.target='."'_self'".'">';}

	echo '&nbsp;<input name="CmdRechPre" type="submit" class="boton02"  value="Rechazar" style="color:#f44336;border-color:#f44336;width:70px" onClick="document.Formulario.target='."'_self'".'">';}

	//2.Pre-Autorizado (auto/rech(a)/abrir - autorizante)

	if (($_SESSION["GLO_IdPersLog"]==$_SESSION['CbAuto'] or $_SESSION["IdPerfilUser"]==1) and $_SESSION['TxtIdEstado']==2){

	if($_SESSION['TxtCantidadA']>0){echo '<input name="CmdAuto" type="submit" class="boton02"  value="Autorizar" style="color:#4CAF50; border-color:#4CAF50;width:70px" onClick="document.Formulario.target='."'_self'".'">';}

	echo '&nbsp;<input name="CmdRechAuto" type="submit" class="boton02"  value="Rechazar" style="color:#f44336; border-color:#f44336;width:70px" onClick="document.Formulario.target='."'_self'".'">';

	echo '&nbsp;<input name="CmdAbrir" type="submit" class="boton02"  value="Anterior" style="color:#cc0099; border-color:#cc0099;width:70px" onClick="document.Formulario.target='."'_self'".'">';

	}

	//3.Autorizado (preauto - autorizante)

	if (($_SESSION["GLO_IdPersLog"]==$_SESSION['CbAuto'] or $_SESSION["IdPerfilUser"]==1) and $_SESSION['TxtIdEstado']==3){

	if($_SESSION['TxtNPAsociada']==0){//si esta asociado a PC u OC solo puede cerrarse

	echo '&nbsp;<input name="CmdPAutoAnt" type="submit" class="boton02"  value="Anterior" style="color:#cc0099; border-color:#cc0099;width:70px" onClick="document.Formulario.target='."'_self'".'">';

	}

	}

	//4.Rechazado(pre) (abrir - preautorizante)

	if (($_SESSION["GLO_IdPersLog"]==$_SESSION['CbPAuto'] or $_SESSION["GLO_IdPersLog"]==$_SESSION['CbAuto'] or $_SESSION["IdPerfilUser"]==1) and $_SESSION['TxtIdEstado']==4){

	if($_SESSION['TxtCantidadA']>0){echo '<input name="CmdPAuto" type="submit" class="boton02"  value="Autorizar" style="color:#4CAF50; border-color:#4CAF50;width:70px" onClick="document.Formulario.target='."'_self'".'">';}

	echo '&nbsp;<input name="CmdAbrir" type="submit" class="boton02"  value="Anterior" style="color:#cc0099; border-color:#cc0099;width:70px" onClick="document.Formulario.target='."'_self'".'">';

	}

	//5.Rechazado(auto) (pre-auto - autorizante)

	if (($_SESSION["GLO_IdPersLog"]==$_SESSION['CbAuto'] or $_SESSION["IdPerfilUser"]==1) and $_SESSION['TxtIdEstado']==5){

	echo '&nbsp;<input name="CmdPAutoAnt" type="submit" class="boton02"  value="Anterior" style="color:#cc0099; border-color:#cc0099;width:70px" onClick="document.Formulario.target='."'_self'".'">';}

}

?>

&nbsp;</td></tr>

<tr> <td height="18"  align="right"  >Cant.Autorizada:</td><td  valign="top" colspan="4">&nbsp;<input name="TxtCantidadA" type="text"  tabindex="4"  <? if($_SESSION["GLO_IdPersLog"]!=$_SESSION["CbPAuto"] and $_SESSION["CbAuto"]!=$_SESSION["GLO_IdPersLog"] and $_SESSION["IdPerfilUser"]!=1){echo'readonly="true" class="TextBoxRO"';}else{echo'class="TextBox"';} ?> style="width:50px" maxlength="7"  value="<? echo $_SESSION['TxtCantidadA']; ?>" onChange="this.value=validarNumeroP(this.value);"> <? if($_SESSION['TxtIdEstado']==1 and $_SESSION['TxtCantidadA']==0){echo '<label style="font-weight:bold;color:#f44336;">Completar!! </label> ';} ?></td></tr>
</table>

<table width="720" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="600"></td></tr>
<tr> <td height="18"  align="right"  >Art&iacute;culo o Equipo:</td><td  valign="top">&nbsp;<select name="CbItem"  class="campos" id="CbItem" style="width:460px" tabindex="4"  >
 <?   		
	$query="SELECT a.Id,a.Nombre,a.Modelo, m.Nombre as Marca,u.Abr FROM epparticulos a,unidadesmedida u,marcas m where a.Id<>0 and a.IdUnidad=u.Id and a.IdMarca=m.Id and a.Id=".intval($_SESSION['CbItem']);
	$rs=mysql_query($query,$conn);	
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		$combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], 6, "0", STR_PAD_LEFT).' '.substr($row['Nombre'],0,40).' ('.substr($row['Abr'],0,5).')'.' '.substr($row['Marca'],0,15).' '.substr($row['Modelo'],0,15)."</option>\n";
	}mysql_free_result($rs);
	echo $combo;		

?>
<tr> <td height="18"  align="right"  >Producto Laboratorio:</td><td  valign="top">&nbsp;<select name="CbItem2"  class="campos" id="CbItem2" style="width:460px" tabindex="4"  >
 <?   		
	$query="SELECT a.Id,a.Nombre,u.Abr  FROM items a,unidadesmedida u where a.Id<>0 and a.IdUnidad=u.Id and a.Id=".intval($_SESSION['CbItem2']);
	$rs=mysql_query($query,$conn);	
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
		$combo .= " <option value='".$row['Id']."'>".str_pad($row['Id'], 6, "0", STR_PAD_LEFT).' '.substr($row['Nombre'],0,50).' ('.substr($row['Abr'],0,5).')'."</option>\n";
	}mysql_free_result($rs);
	echo $combo;		

?>
</select></td></tr>
</table>

<table width="720" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="600"></td></tr>
<tr> <td height="18"  align="right"  >Proveedor:</td><td  valign="top">&nbsp;<select name="CbProv" style="width:300px" class="campos"  tabindex="4"  id="CbProv" ><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td></tr>
</table> 


<? 
GLO_obsform(720,120,'Observaciones','TxtObs',4,0); 

//alta si es solicitante o quien registro

if( intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['CbSoli']) or intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['TxtUsuario']) ){$essolioreg=1;}else{$essolioreg=0;}

//o  es perfil compras

if( $_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==11){$escompras=1;}else{$escompras=0;}

//o  es auto

if( intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['CbAuto']) ){$esauto=1;}else{$esauto=0;}

//o si es preauto 

if( intval($_SESSION["GLO_IdPersLog"])==intval($_SESSION['CbPAuto']) ){$espreauto=1;}else{$espreauto=0;}

//guardar cambios si esa abierto

if(intval($_SESSION['TxtIdEstado'])<2 and ( $essolioreg==1 or $escompras==1 or $esauto==1 or $espreauto==1)){GLO_botonesform("720",0,2);

}else{GLO_botonesform("720",1,2);}

GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('CbAuto',0);GLO_Hidden('CbPAuto',0);
GLO_Hidden('TxtIdEstado',0);GLO_Hidden('CbSoli',0);GLO_Hidden('TxtUsuario',0);
GLO_mensajeerror(); 

mysql_close($conn); 
GLO_cierratablaform();


GLO_initcomment(720,0);
echo 'Para poder <font class="comentario2">Pre-Autorizar</font> un Pedido es necesario grabar primero la <font class="comentario3">Cantidad Autorizada</font><br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");

?>