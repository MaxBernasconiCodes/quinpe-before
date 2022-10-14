<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("../Stock/Includes/zFunciones.php") ;include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//completa fecha por defecto
if (empty($_SESSION['TxtFechaDST'])){	
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaDST']=date("d-m-Y", strtotime("$primerdiames -0 month"));
	$_SESSION['TxtFechaHST']=$hoy;
}




GLOF_Init('','BannerConMenuHV','zStock',0,'MenuH',0,0,0); 
GLO_tituloypath(0,750,"Inbox.php",'MOVIMIENTOS DE STOCK','linksalir');
?>

<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr><td  height=3 width="80" ></td><td  width="100"></td><td width="120"></td><td width="60"></td><td width="100"></td><td width="70"></td><td width="70"></td><td width="50"></td><td width="70"></td><td width="30"></td></tr>
<tr><td  align="right">Fecha:</td><td width="100" >&nbsp;<?php GLO_calendario("TxtFechaDST","../Codigo/","actual",1);?></td><td width="140" > al&nbsp;<?php GLO_calendario("TxtFechaHST","../Codigo/","actual",1);?></td><td align="right">Dep&oacute;sito:</td><td>&nbsp;<select name="CbDeposito" class="campos" id="CbDeposito"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("depositos","CbDeposito","Nombre","","and Tipo=1",$conn); ?></select></td><td align="right">Remito:</td><td >&nbsp;<input name="TxtNro" type="text"  class="TextBox"  maxlength="8"  value="<? echo $_SESSION['TxtNro']; ?>"    style="text-align:right;width:50px" onChange="this.value=validarEntero(this.value);"></td><td align="right">COA:</td><td>&nbsp;<input  name="TxtIdCAM" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtIdCAM'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td></td></tr>

<tr><td  align="right">Propietario:</td><td  colspan="2">&nbsp;<select name="CbCliente" class="campos" id="CbCliente"  style="width:180px" onKeyDown="enterxtab(event)"><option value=""></option><? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?></select></td><td align="right">Tipo:</td><td>&nbsp;<select name="CbTipoMS" class="campos" id="CbTipoMS"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("stock_tipomov","CbTipoMS","Nombre","","",$conn); ?></select></td><td align="right">Nro.Mov:</td><td>&nbsp;<input  name="TxtNroInterno" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroInterno'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td align="right">Pedido:</td><td>&nbsp;<input  name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:50px"></td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>


<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtQStockCAM',0);
GLO_linkbutton(750,'Agregar','Alta.php','','','','');



GLO_mensajeerror(); 
STOCK_MostrarTabla($_SESSION['TxtQStockCAM'],1,$conn);
GLO_cierratablaform();
mysql_close($conn);

GLO_initcomment(0,0);
echo 'El <font class="comentario2">Cliente</font> es el asignado a la <font class="comentario3">Solicitud</font> asociada al <font class="comentario3">COA</font><br>';
echo 'No es posible eliminar <font class="comentario2">Comprobantes</font> con Items en su <font class="comentario3">Detalle</font><br>';
echo 'Verifique y elimine los <font class="comentario3">Items</font> individualmente antes de borrarlo, ya que generar&aacute; actualizaciones en el <font class="comentario2">Stock</font><br>';
echo 'Muestra los movimientos de <font class="comentario3">Depositos</font> tipo <font class="comentario2">Planta</font>';
GLO_endcomment();

PLA_verimagenplanta();//imagen planta

include ("../Codigo/FooterConUsuario.php");?>