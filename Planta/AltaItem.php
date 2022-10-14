<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get (seguridad)

GLO_ValidaGET($_GET['Id'],0,0);

$_SESSION['TxtNroEntidad']=intval($_GET['Id']);//idcomprobante

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT * From stockmov where Id=".intval($_GET['Id']); 	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){ 
    $_SESSION['TxtDep']=$row['IdDeposito']; $_SESSION['TxtTipo']=$row['IdTipoMov'];
    $_SESSION['TxtNroPedido']=str_pad($row['IdPedido'], 5, "0", STR_PAD_LEFT);//id item pedido
}
mysql_free_result($rs);


GLOF_Init('TxtCantidad','BannerPopUpMH','zAltaItem',0,'',0,0,0); 
GLO_tituloypath(0,720,'','DETALLE COMPROBANTE','salir');
?> 


<table width="720" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="120" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right"  >&nbsp;Cantidad:</td><td>&nbsp;<input name="TxtCantidad" type="text"  class="TextBox" style="width:50px" maxlength="7"  value="<? echo $_SESSION['TxtCantidad']; ?>" onChange="this.value=validarNumeroP(this.value);"><label class="MuestraError"> * </label> </td></tr>
<tr> <td height="18"  align="right"  >Art&iacute;culo o Equipo:</td><td>&nbsp;<? include ("../IncludesNG/BuscadorArticuloStock.php");?></td></tr>
<tr> <td ></td><td height="5" ></td></tr>
<tr> <td height="18"  align="right"  >Producto Laboratorio:</td><td>&nbsp;<? include ("../IncludesNG/BuscadorArticuloStockLAB.php");?></td></tr>
</table>

<? 

GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtDep',0);GLO_Hidden('TxtTipo',0);
GLO_Hidden('TxtNroPedido',0);
GLO_botonesform("720",0,2);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(720,0);
echo 'Seleccione <font class="comentario3">Art&iacute;culo</font> o <font class="comentario2">Producto</font><br>';
echo 'Podr&aacute; buscar el <font class="comentario2">Art&iacute;culo</font> por <font class="comentario3">C&oacute;digo</font> o <font class="comentario3">Nombre</font><br>';
echo 'Si el <font class="comentario3">Art&iacute;culo</font> no existe, puede agregarlo con el boton <font class="comentario2">Crear Art&iacute;culo</font><br>';
echo 'Solo muestra aquellos que modifican <font class="comentario2">Stock</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>