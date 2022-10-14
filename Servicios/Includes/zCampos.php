<? if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,700,'../Servicios.php','SERVICIO','linksalir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="90" height="5"  ></td> <td width="370"></td><td width="100" height="5"  ></td> <td width="140"></td> </tr>
<tr><td height="21"  align="right"  >&nbsp;Cliente:</td><td  valign="top" >&nbsp;<select name="CbCliente"  style="width:300px" tabindex="1" class="campos" id="CbCliente" > <? if (intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option> ';GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn);}else{ComboTablaRFROX("clientes","CbCliente","Nombre","",$_SESSION['CbCliente'],"",$conn);} ?> </select> <label class="MuestraError"> * </label></td><td height="18"  align="right"  >Contrataci&oacute;n:</td><td  valign="top" >&nbsp;<select name="CbTipoContrato"  style="width:90px" tabindex="2"  class="campos" id="CbTipoContrato" ><option value=""></option> <? ComboTablaRFX("serviciostipocontrato","CbTipoContrato","Nombre","","",$conn) ?> </select></td></tr>

<tr><td height="21"  align="right"  >Linea A:</td><td  valign="top" >&nbsp;<select name="CbTipoC"  style="width:300px" class="campos" tabindex="1"  id="CbTipoC" ><? if (intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option> ';ComboTablaRFX("serviciostipo1","CbTipoC","Nombre","","",$conn);}else{ComboTablaRFROX("serviciostipo1","CbTipoC","Nombre","",$_SESSION['CbTipoC'],"",$conn);} ?> </select> <label class="MuestraError"> * </label></td><td height="21"  align="right"  >Baja Servicio:</td><td  valign="top" >&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",2) ?></td></tr>

<tr><td height="21"  align="right"  >Interno:</td><td  valign="top" >&nbsp;<input name="OptTipoI"  type="radio"  class="radiob" tabindex="1"    value="S"<? if ($_SESSION['OptTipoI'] =='S') echo 'checked'; ?> >Si   <input name="OptTipoI"  type="radio"  class="radiob"  tabindex="1"  value="N"<? if ($_SESSION['OptTipoI'] =='N') echo 'checked'; ?> >No </td><td height="21"  align="right"  >&nbsp;</td><td  valign="top" ></td></tr>
</table> 




<?
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNumero',0);
GLO_botonesform(700,0,2);
GLO_mensajeerror(); 
?>
