<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php'); include("Includes/zFunciones.php");include("../Procesos/Includes/zFunciones.php") ;include("../CAM/Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(13);

//get
GLO_ValidaGET($_GET['id'],0,0);

//modificar propios y terceros vehiculo

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
if ($_GET['Flag1']=="True"){	
	$query="SELECT a1.*,a.IdCliente as IdCliP From procesosop_e1 a1,procesosop a where a1.Id<>0 and a1.IdPadre=a.Id and a1.Id=".intval($_GET['id']);	
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
        //generales
        $_SESSION['TxtNumero']=$row['Id'];
        $_SESSION['TxtNroEntidad']=$row['IdPadre'];//proceso
        $_SESSION['TxtFechaA']=GLO_FormatoFecha($row['Fecha']);
        $_SESSION['TxtHora']=GLO_FormatoHora($row['Hora']);
        $_SESSION['TxtObs']=$row['Obs'];
        $_SESSION['TxtTemp']=$row['Temp'];
        $_SESSION['CbOlf']=$row['Olf'];
        $_SESSION['TxtRto'] = $row['Rto'];
        $_SESSION['TxtMotivo'] = $row['Mot'];
        $_SESSION['CbCliente2'] = $row['IdCliP'];//cliente proceso
        //si es egreso puede tener pedido
        if($row['IdPedido']==0){$_SESSION['TxtNroPedido'] = '';}else{$_SESSION['TxtNroPedido'] =str_pad($row['IdPedido'], 6, "0", STR_PAD_LEFT);}
        //0:ingreso,1:salida
        if($row['Etapa']==0){$_SESSION['CbEtapa']=1;}else{$_SESSION['CbEtapa']=2;}
        //propio
        $_SESSION['CbTipo']=$row['Tipo'];
        $_SESSION['CbPersonal'] = $row['IdChofer'];
        $_SESSION['CbUnidad'] = $row['IdUnidad'];
        $_SESSION['CbUnidad2'] = $row['IdSemi'];
        $_SESSION['TxtKm'] = $row['Km'];if ($_SESSION['TxtKm']==0){$_SESSION['TxtKm'] ="";}
        $_SESSION['ChkRE'] = $row['Retorno'];
        //terceros
        $_SESSION['CbProv'] = $row['IdProv'];		
        $_SESSION['CbCliente'] = $row['IdCli'];
        $_SESSION['TxtChofer'] = $row['Chofer'];
        $_SESSION['TxtDoc']= $row['DNI'];
        $_SESSION['TxtDocCong']= $row['DNI'];//congelado
        $_SESSION['TxtSedronar'] = $row['Sedro'];
        $_SESSION['CbMarca'] = $row['IdMarca'];
        $_SESSION['CbCateg'] = $row['IdCateg'];
        $_SESSION['TxtModelo'] = $row['Modelo'];
        $_SESSION['TxtDominio'] = $row['Dominio'];
        $_SESSION['TxtDominioCong'] = $row['Dominio'];
        $_SESSION['CbMarca2'] = $row['IdMarca2'];
        $_SESSION['CbCateg2'] = $row['IdCateg2'];
        $_SESSION['TxtModelo2'] = $row['Modelo2'];
        $_SESSION['TxtDominio2'] = $row['Dominio2'];
        $_SESSION['TxtDominio2Cong'] = $row['Dominio2'];
        $_SESSION['Chk1'] = $row['Chk1'];//Certificado de analisis
        $_SESSION['Chk2'] = $row['Chk2'];//Hojas de seguridad de los productos
        //habilitaciones
        $_SESSION['ChkU1'] = $row['ChkU1'];$_SESSION['ChkU2'] = $row['ChkU2'];$_SESSION['ChkU3'] = $row['ChkU3'];
        $_SESSION['ChkS1'] = $row['ChkS1'];$_SESSION['ChkS2'] = $row['ChkS2'];$_SESSION['ChkS3'] = $row['ChkS3'];
        $_SESSION['ChkC1'] = $row['ChkC1'];$_SESSION['ChkC2'] = $row['ChkC2'];
        $_SESSION['TxtFechaU1'] =GLO_FormatoFecha($row['FU1']);$_SESSION['TxtFechaU2'] =GLO_FormatoFecha($row['FU2']);
        $_SESSION['TxtFechaU3'] =GLO_FormatoFecha($row['FU3']);
        $_SESSION['TxtFechaS1'] =GLO_FormatoFecha($row['FS1']);$_SESSION['TxtFechaS2'] =GLO_FormatoFecha($row['FS2']);
        $_SESSION['TxtFechaS3'] =GLO_FormatoFecha($row['FS3']);
        $_SESSION['TxtFechaC1'] =GLO_FormatoFecha($row['FC1']);$_SESSION['TxtFechaC2'] =GLO_FormatoFecha($row['FC2']);
	}mysql_free_result($rs);	
}

//seguridad refresh false
if(intval($_SESSION['TxtNumero'])==0){header("Location:ModificarVehiculo.php?id=".intval($_GET['id'])."&Flag1=True");}	

//ingreso/salida
if($_SESSION['CbEtapa']==1){$nometapa='INGRESO';}else{$nometapa='EGRESO';}


//valido si tiene items, solo puede modificar proceso si no tiene items
$query="SELECT Id FROM procesosop_e1_it Where IdPadre=".$_SESSION['TxtNumero']." LIMIT 1";
$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
if(mysql_num_rows($rs10)!=0){$tieneitems=1;}else{$tieneitems=0;}
mysql_free_result($rs10);



$_SESSION['TxtOriProcIt']=0;//para que vuelva


GLOF_Init(GLO_formfocus('',0),'BannerConMenuHV','zModificarVehiculo',1,'',0,0,0); 
GLO_tituloypath(0,760,'','BARRERA '.$nometapa,'salir');
GLO_mensajeerrorE();

include ("Includes/zCamposVehiculo.php");//encabezado comun a propios y terceros
?>

<table width="760" border="0"  cellspacing="0" class="Tabla TMT" >
<tr> <td width="110" height="5"  ></td> <td width="100"></td><td width="200"></td><td width="110"></td><td width="110"></td> <td width="140"></td></tr>

<tr> <td height="18"  align="right"  >Cliente Solicitud:</td><td colspan="2">&nbsp;<select name="CbCliente2"  class="campos" id="CbCliente2"  tabindex="1" style="width:250px" onKeyDown="enterxtab(event)"><? if (intval($_SESSION['TxtNroEntidad'])==0 and intval($_SESSION['CbEtapa'])==1){echo '<option value=""></option> ';GLO_ComboActivo("clientes","CbCliente2","Nombre","","",$conn);}else{ComboTablaRFROX("clientes","CbCliente2","Nombre","",$_SESSION['CbCliente2'],"",$conn);} ?></select></td><td align="right"  ><? if(intval($_SESSION['CbEtapa'])==2){ echo 'Pedido:';}?></td><td>
<? 
if(intval($_SESSION['CbEtapa'])==2){ echo '&nbsp;<input name="TxtNroPedido" type="text"  class="TextBoxRO" style="text-align:right;width:50px" readonly="true" value="'.$_SESSION['TxtNroPedido'].'">';}
//ingreso+propio muestra retorno
if( intval($_SESSION['CbEtapa'])==1 and intval($_SESSION['CbTipo'])==1 ){
	echo '<input name="ChkRE"  type="checkbox" class="check"  value="1"';if ($_SESSION['ChkRE'] =='1') echo 'checked'; 
	echo '>';GLO_CheckColor('Retorno',$_SESSION['ChkRE'],0);
}
?>
</td><td>
</td></tr>

<tr> <td height="18"  align="right"  >Solicitud:</td><td colspan="2">&nbsp;<?
//ingreso muestra
if(intval($_SESSION['CbEtapa'])==1){
	echo '<input  name="TxtNroEntidad" type="text"  readonly="true"  class="TextBoxRO TBold"   value="'.$_SESSION['TxtNroEntidad'].'" style="text-align:right;width:50px">&nbsp;';
}


//egreso selecciona
if(intval($_SESSION['CbEtapa'])==2){
	echo '<select name="TxtNroEntidad" style="width:250px" class="campos TBold" id="TxtNroEntidad"  tabindex="1">'; if(intval($_SESSION['TxtNroEntidad'])==0 or $tieneitems==0){echo '<option value=""></option>';GLO_CbComprobanteBQ("procesosop","TxtNroEntidad","a.Fecha DESC",6,"","and a.Estado=0",$conn);}else{GLO_CbComprobanteRO("procesosop","TxtNroEntidad","Id","",6,$_SESSION['TxtNroEntidad'],"",$conn);} echo '</select>&nbsp;';
}

//ingreso, si no tiene solicitud 
if(intval($_SESSION['CbEtapa'])==1 and intval($_SESSION['TxtNumero'])!=0 and intval($_SESSION['TxtNroEntidad'])==0){
	echo GLO_FAButton("CmdAltaSoli",'submit','100','self','Alta Solicitud','add','boton02');
}
//ingreso, si tiene solicitud y no tiene items
if(intval($_SESSION['CbEtapa'])==1 and intval($_SESSION['TxtNumero'])!=0 and intval($_SESSION['TxtNroEntidad'])!=0 and $tieneitems==0){
	echo GLO_FAButton("CmdBorrarSoli",'submit','110','self','Borrar Solicitud','trash','boton02').'&nbsp;&nbsp;';
}
//si tiene solicitud
if( intval($_SESSION['TxtNroEntidad'])!=0 ){
	echo GLO_FAButton("CmdVerSoli",'submit','','self','Ver Solicitud','lupa','iconbtn');
}


?>
</td><td align="right"  ></td><td>&nbsp;</td><td align="right"></td></tr>

</table>

<? 
//campos tercero/propio
if( intval($_SESSION['CbTipo'])==1){include ("Includes/zCamposVehiculoP.php");}//1 propio
if( intval($_SESSION['CbTipo'])==2){include ("Includes/zCamposVehiculoT.php");}//2 terceros

GLO_obsform(760,100,'Observaciones','TxtObs',2,0);

//guardar y egreso
echo '<table width="760" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td height="5" width="200" ></td><td width="360" ></td><td width="200"  ></td></tr>
<tr><td></td><td align="center">
<input name="CmdAceptar" type="submit" class="boton" value="Guardar" onClick="document.Formulario.target='."'_self'".'"></td><td align="right">';
//si es modificar ingreso muestra boton egreso, es un atajo para barrera
if( intval($_SESSION['CbEtapa'])==1 and intval($_SESSION['TxtNumero'])!=0 and $tieneitems==0){
	echo GLO_FAButton('CmdAltaEgreso','submit','80','self','Alta Egreso','','boton03');
} 	
echo '&nbsp;</td> </tr></table>'; 


GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtId',0);
GLO_Hidden('TxtDocCong',0);GLO_Hidden('TxtDominioCong',0);GLO_Hidden('TxtDominio2Cong',0);

//planilla y permisos
if(intval($_SESSION['TxtNumero'])!=0){
	echo '<table width="760" border="0"  cellpadding="0" cellspacing="0" class="TMT"><tr><td align="right">'; 

	//terceros
	if(intval($_SESSION['CbTipo'])==2){ 
		echo GLO_FAButton('CmdControlT','submit','80','self','Control','checklist','boton02');//checklist
		echo ' '.GLO_FAButton('CmdImprimirT','submit','80','blank','Imprimir','print','boton02');//permiso
	} 
	//propios
	if(intval($_SESSION['CbTipo'])==1){ 
		echo GLO_FAButton('CmdControlP','submit','80','self','Control','checklist','boton02');//checklist
		//permiso ingreso
		if( intval($_SESSION['CbEtapa'])==1 ){echo ' '.GLO_FAButton('CmdImprimirPI','submit','80','blank','Imprimir','print','boton02');}
		//permiso egreso
		//if( intval($_SESSION['CbEtapa'])==2 ){echo ' '.GLO_FAButton('CmdImprimirPE','submit','80','blank','Imprimir','print','boton02');}
	} 
	
	echo '</td> </tr></table>'; 
}



GLO_mensajeerror(); 

//si no es alta y tiene proceso
if(intval($_SESSION['TxtNumero'])!=0 and intval($_SESSION['TxtNroEntidad'])!=0){
	GLO_Ancla('A1'); PROC1_TablaItems($_SESSION['TxtNumero'],$conn);
}else{
	echo '<table  width="760" border="0" cellspacing="0" cellpadding="0" class="TMT5">';
	echo '<tr> <td class="TBlue" style="font-size:1.5rem;">Para agregar <font class="TBold">Items</font> es necesario generar una <font class="TBold">Solicitud</font> de Servicios</td> </tr>';
	echo '</table>';
    
    
}


GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(0,0);
echo 'Muestra el <font class="comentario2">Total</font> de productos si la <font class="comentario3">Unidad de Medida</font> coincide<br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>