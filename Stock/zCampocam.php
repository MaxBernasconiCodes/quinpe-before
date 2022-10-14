<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

?>


<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="90" height="3"  ></td> <td width="260"></td><td width="100"></td> <td width="70"></td><td width="180"></td>  </tr>
<tr><td align="right" >Propietario:</td><td>&nbsp;<select name="CbCliente"   class="campos" id="CbCliente"  style="width:200px" onKeyDown="enterxtab(event)"><? ComboTablaRFROX("clientes","CbCliente","Nombre","",$_SESSION['CbCliente'],"",$conn); ?></select></td><td align="right" >COA:</td><td>&nbsp;<input  name="TxtIdCAM" type="text"  readonly="true"  class="TextBoxRO"    value="<? echo $_SESSION['TxtIdCAM'];?>" style="text-align:right; width:50px"></td><td>Pedido logistica:&nbsp;<input  name="TxtNroPedido" type="text"  readonly="true"  class="TextBoxRO"    value="<? echo $_SESSION['TxtNroPedido'];?>" style="text-align:right; width:50px"></td></tr>
</table> 
