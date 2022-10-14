<? include("Codigo/Seguridad.php") ;include("Codigo/Config.php") ;include("Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="";require_once('Codigo/calendar/classes/tc_calendar.php');include("Stock/Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and  $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaDST'])){	
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaDST']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$_SESSION['TxtFechaHST']=$hoy;
}


GLOF_Init('TxtNroInterno','BannerConMenuHV','Stock/zStock',0,'Stock/MenuH',0,0,0); 
GLO_tituloypath(0,720,"Inicio.php",'MOVIMIENTOS DE STOCK','linksalir');
?>

<table width="720" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="80" ></td><td  width="100"></td><td width="130"></td><td width="70"></td><td width="100"></td><td width="70"></td><td width="70"></td><td width="100"></td></tr>
<tr><td  align="right">Fecha:</td><td width="100" >&nbsp;<input name="TxtFechaDST"  id="TxtFechaDST" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaDST']; ?>"   ><?php calendario("TxtFechaDST","Codigo/","actual");?></td><td width="140" > al&nbsp;<input name="TxtFechaHST"  id="TxtFechaHST" type="text" class="TextBox"  style="width:65px" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFechaHST']; ?>"   ><?php calendario("TxtFechaHST","Codigo/","actual");?></td><td align="right">Dep&oacute;sito:</td><td>&nbsp;<select name="CbDeposito" class="campos" id="CbDeposito"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("depositos","CbDeposito","Nombre","","",$conn); ?></select></td><td align="right">Remito:</td><td >&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtNro']; ?>"    style="text-align:right;width:50px" onChange="this.value=validarEntero(this.value);"></td><td></td></tr>

<tr><td  align="right">Proveedor:</td><td  colspan="2">&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td><td align="right">Tipo:</td><td>&nbsp;<select name="CbTipoMS" class="campos" id="CbTipoMS"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("stock_tipomov","CbTipoMS","Nombre","","",$conn); ?></select></td><td align="right">Nro.Mov:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td  align="right"></td></tr>

<tr><td  align="right">Propietario:</td><td  colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td align="right"></td><td>&nbsp;</td><td align="right"></td><td>&nbsp;</td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>

</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQStock',0);
GLO_linkbutton(720,'Agregar','Stock/Alta.php','','','','');
GLO_mensajeerror(); 
STOCK_MostrarTabla($_SESSION['TxtQStock'],0,$conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'No es posible eliminar <font class="comentario3">Comprobantes</font> asociados a un <font class="comentario2">COA</font>. Solo puede hacerse desde el menu <font class="comentario3">Operaciones</font> <br>';
echo 'No es posible eliminar <font class="comentario2">Comprobantes</font> con Art&iacute;culos en su <font class="comentario3">Detalle</font>.<br>';
echo 'Verifique y elimine los <font class="comentario3">Items</font> individualmente antes de borrarlo, ya que generar&aacute; actualizaciones en el <font class="comentario2">Stock</font>.';
GLO_endcomment();

include ("Codigo/FooterConUsuario.php");?>