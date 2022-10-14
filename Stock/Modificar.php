<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get (seguridad)
GLO_ValidaGET($_GET['id'],0,0);


$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT s.*,per.Nombre as NAudi,per.Apellido as AAudi,o.Nombre as Ori  From stockmov s,personal per,stockmov_origen o where per.Id=s.IdUser and s.IdOrigen=o.Id and s.Id=".intval($_GET['id']);
$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
	$_SESSION['TxtFechaA'] =FormatoFecha($row['Fecha']);
	$_SESSION['CbTipo'] = $row['IdTipoMov'];
	$_SESSION['CbDep'] = $row['IdDeposito'];
	$_SESSION['CbProveedor'] =$row['IdProveedor'];
	$_SESSION['TxtObs'] = $row['Obs'];
	$_SESSION['TxtTipo']=$row['Tipo'];
	$_SESSION['TxtSuc'] = str_pad($row['Suc'], 4, "0", STR_PAD_LEFT);
	$_SESSION['TxtNro'] = str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);
	$_SESSION['TxtNroOC']=$row['NroOC'];
	$_SESSION['TxtIdCAM'] = str_pad($row['IdCAM'], 5, "0", STR_PAD_LEFT);	
	$_SESSION['TxtUserA'] =$row['AAudi'].' '.$row['NAudi'];
	$_SESSION['CbCliente']=$row['IdCliente'];//cli propietario 
	$_SESSION['TxtNroPedido']=str_pad($row['IdPedido'], 5, "0", STR_PAD_LEFT);//id item pedido
	$_SESSION['TxtOrigen']=$row['Ori'];
	//
	$_SESSION['CbPersonal']=$row['IdPersonal'];
	$_SESSION['CbUnidad'] =$row['IdUnidad'];
	$_SESSION['CbInstrumento'] =$row['IdInstr'];
	$_SESSION['CbSector2'] =$row['IdSectorM'];	
}mysql_free_result($rs);



GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaA','BannerConMenuHV','zModificar',0,0,0,0);
include("MenuH.php");
GLO_tituloypath(950,700,'','MOVIMIENTO STOCK','salir'); 
?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="90" height="3"  ></td> <td width="260"></td><td width="100"></td> <td width="250"></td> </tr>
<tr>
<td height="18"  align="right"  >&nbsp;N&uacute;mero:</td><td  valign="top" >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"    value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right; width:50px"> <input  name="TxtId"   type="hidden"   value="<? echo $_SESSION['TxtId']; ?>"></td><td align="right">Fecha:</td><td>&nbsp;<input name="TxtFechaA" id="TxtFechaA"  type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaA']; ?>"   ><label class="MuestraError"> * </label><? calendario("TxtFechaA","../Codigo/","actual") ?></td></tr>
<tr><td height="18"  align="right"  >&nbsp;Tipo:</td><td  valign="top" >&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:200px" onKeyDown="enterxtab(event)" onChange="this.form.submit()" ><? ComboTablaRFROX("stock_tipomov","CbTipo","Nombre","",$_SESSION['CbTipo'],"",$conn); ?></select> <label class="MuestraError"> * </label></td><td align="right">Remito:</td><td>&nbsp;<input name="TxtTipo" type="text"  class="TextBox" maxlength="1" value="<? echo $_SESSION['TxtTipo']; ?>"  style="text-align:right;width:20px" onKeyUp="this.value=this.value.toUpperCase()"> <input name="TxtSuc" type="text"  class="TextBox" maxlength="4"  value="<? echo $_SESSION['TxtSuc']; ?>" onChange="this.value=validarEnteroCompletar(this.value,'0000',-4);" style="text-align:right;width:33px"> <input name="TxtNro" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtNro']; ?>" onChange="this.value=validarEnteroCompletar(this.value,'00000000',-8);" style="text-align:right;width:60px"></td></tr>
<tr><td align="right"  >&nbsp;Dep&oacute;sito:</td><td  valign="top" >&nbsp;<select name="CbDep" class="campos" id="CbDep"  style="width:200px" onKeyDown="enterxtab(event)"><? ComboTablaRFROX("depositos","CbDep","Nombre","",$_SESSION['CbDep'],"",$conn); ?></select> <label class="MuestraError"> * </label></td><td align="right"><? if($_SESSION['CbTipo']==4){echo 'Nro OC:';} //remito egreso ?></td><td>&nbsp;<? if($_SESSION['CbTipo']==4){echo '<input  name="TxtNroOC" type="text"  class="TextBox" style="width:65px;" value="'; echo $_SESSION['TxtNroOC']; echo '" >';} //remito egreso ?></td></tr>

<tr><td align="right"  >Origen:</td><td  valign="top" >&nbsp;<input  name="TxtOrigen" type="text"  readonly="true"  class="TextBoxRO"    value="<? echo $_SESSION['TxtOrigen'];?>" style="width:200px"> </td><td align="right"></td><td>&nbsp;</td></tr>

</table>



<? 
//remito ingreso no cam ni pedido
if($_SESSION['CbTipo']==3 and intval($_SESSION['TxtIdCAM'])==0  and intval($_SESSION['TxtNroPedido'])==0 )
{include ("zCampo.php");} //proveedor
//remito egreso 
if($_SESSION['CbTipo']==4){include ("zCampo1.php");}

//remito asociado a cam
include ("zCampocam.php"); //datos cam

GLO_obsform(700,90,'Observaciones','TxtObs',0,2);
?>
<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="90" height="5"  ></td> <td width="610"></td></tr>
<tr><td height="18"  align="right"  >Registr&oacute;:</td><td  valign="top">&nbsp;<input name="TxtUserA" type="text"  readonly="true"  class="TextBoxRO" style="width:300px" value="<? echo $_SESSION['TxtUserA']; ?>"  ></td></tr>
</table>

<?
//remito egreso exporta, rto asociado a cam o pedido no se modifica
if( intval($_SESSION['TxtIdCAM'])==0 or intval($_SESSION['TxtNroPedido'])==0 ){
	if($_SESSION['CbTipo']==4){GLO_guardarform(700,0,2,1,0);}else{GLO_guardarform(700,0,2,0,0);} 
}
GLO_mensajeerror();

//detalle
if(intval($_SESSION['TxtIdCAM'])!=0 or intval($_SESSION['TxtNroPedido'])!=0 ){
	//rto asociado a cam o pedido no se modifica
	STOCK_TablaDetallePlanta($_SESSION['TxtNumero'],1,intval($_SESSION['TxtIdCAM']),intval($_SESSION['TxtNroPedido']),$_SESSION['CbCliente'],$conn);}
else{
	if($_SESSION['CbTipo']==3){STOCK_TablaDetalleRI($_SESSION['TxtNumero'],$_SESSION['TxtIdCAM'],intval($_SESSION['TxtNroPedido']),$_SESSION['CbCliente'],$conn);}
	else{STOCK_TablaDetalle($_SESSION['TxtNumero'],$_SESSION['CbTipo'],$_SESSION['TxtIdCAM'],intval($_SESSION['TxtNroPedido']),$_SESSION['CbCliente'],$conn);} 
}


GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'Agregar o eliminar Art&iacute;culos en el <font class="comentario2">Detalle</font>, generar&aacute; cambios en el <font class="comentario3">Stock</font> del Dep&oacute;sito';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>