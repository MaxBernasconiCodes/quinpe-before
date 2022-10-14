<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



?>



<table width="750" border="0"   cellspacing="0" class="Tabla TMT" >

<tr><td width="100" height="3"  ></td> <td width="100"></td> <td width="70"></td><td width="120"></td><td width="100"  ></td> <td width="260"></td> </tr>

<tr> <td height="18"  align="right"  >Nro.Solicitud:</td><td  colspan="3">&nbsp;<select name="CbSoli" style="width:250px" class="campos" id="CbSoli" > <? ComboSolicitudes($conn) ?> </select></td><td height="18"  align="right"  >Fecha Solicitud:</td><td  valign="top" >&nbsp;<input name="TxtFechaS" id="TxtFechaS"  type="text" readonly="true"  class="TextBoxRO" style="width:70px;" value="<? echo $_SESSION['TxtFechaS']; ?>"   ></td></tr>

<tr>  <td height="18"  align="right"  >Tipo:</td><td  valign="top" colspan="3">&nbsp;<input  name="TxtTipoS" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtTipoS'];?>" style="width:250px"></td>

<td height="18"  align="right"  >Fecha Sug.Ingr.:</td><td  valign="top" >&nbsp;<input name="TxtFechaSI" id="TxtFechaSI"  type="text" readonly="true"  class="TextBoxRO" style="width:70px;" value="<? echo $_SESSION['TxtFechaSI']; ?>"   ></td></tr>

<tr>  <td height="18"  align="right"  >Solicitante:</td><td  valign="top" colspan="3">&nbsp;<input  name="TxtSoliS" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtSoliS'];?>" style="width:250px"></td><td height="18"  align="right"  >Estado:</td><td  valign="top" >&nbsp;<input  name="TxtEstadoS" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtEstadoS'];?>" style="width:230px"></td></tr>

</table>







<!-- taller -->

<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >

<tr><td width="100" height="3"  ></td> <td width="150"></td> <td width="150"></td><td width="70"></td><td width="140"></td><td width="120" ></td> <td width="20" ></td></tr>

<tr>  <td height="18"  align="right"  >F.Ingresar:</td><td  valign="top" >&nbsp;<input name="TxtFecha3" id="TxtFecha3"  tabindex="3"  type="text" class="TextBox"  style="width:70px;" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha3']; ?>"   > <? calendario("TxtFecha3","../Codigo/","actual") ?></td><td  valign="top">F.L&iacute;mite:&nbsp;<input name="TxtFecha5" id="TxtFecha5"  tabindex="3"  type="text" readonly="true"  class="TextBoxRO"  style="width:70px;"  value="<? echo $_SESSION['TxtFecha5']; ?>"   ></td><td align="right"  >F.Retirar:</td><td height="18"  >&nbsp;<input name="TxtFecha4" id="TxtFecha4"  tabindex="3"  type="text" class="TextBox"  style="width:70px;<? if($_SESSION['TxtIdAccCumpl']==1 and $_SESSION['TxtFecha4']==''){ echo 'background-color:#f44336;color:#FFFFFF';} ?>" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha4']; ?>"   > <? calendario("TxtFecha4","../Codigo/","actual") ?></td><td align="right"><? 

//si la orden esta cerrada a retirar o pdte a retirar boton Entregar

if ( (intval($_SESSION['TxtNumero'])!=0)  and (intval($_SESSION['CbSoli'])!=0)   and (intval($_SESSION['TxtIdEstadoO'])==5 or intval($_SESSION['TxtIdEstadoO'])==6)){ echo '<input name="CmdEntregar" type="submit" class="boton02" value="Entregar" onClick="document.Formulario.target='."'_self'".'">';} 

//si la orden esta cerrada o entregada c/pdtes boton Borrar Entrega

if ( (intval($_SESSION['TxtNumero'])!=0)  and (intval($_SESSION['CbSoli'])!=0)   and (intval($_SESSION['TxtIdEstadoO'])==8 or intval($_SESSION['TxtIdEstadoO'])==9)){ echo '<input name="CmdBEntregar" type="submit" class="boton02"  style="width:90px" value="Borrar Entrega" onClick="document.Formulario.target='."'_self'".'">';} 

?></td><td></td><td></td></tr>

</table>



<? GLO_obsform(750,100,'Comentarios','TxtObs',1,0);?>

