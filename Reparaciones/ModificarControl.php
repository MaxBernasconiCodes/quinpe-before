<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



if ($_GET['Flag1']=="True"){
	$query="SELECT o.* From pedidosrepord o  where o.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNroEntidad'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtIdSoli'] = $row['IdSoli'];
		$_SESSION['TxtIdEstadoO'] = $row['IdEstado'];
		$_SESSION['CbPersonalPL'] = $row['IdPersonalPL'];
		$_SESSION['ChkListoPL'] = $row['ListoPL'];
		//
		$_SESSION['TxtFecha6'] = GLO_FormatoFecha($row['FechaIT']);
		$_SESSION['TxtKm'] = $row['Km'];if ($_SESSION['TxtKm']==0){$_SESSION['TxtKm'] ="";}
		$_SESSION['TxtHs'] = $row['Hs'];if ($_SESSION['TxtHs']==0){$_SESSION['TxtHs'] ="";}
		//
		$_SESSION['TxtObsPL'] = $row['ObsPL'];
		for ($i=1; $i < 19; $i= $i +1) {$opt1='OptI'.$i;$opt2='I'.$i;$_SESSION[$opt1]=$row[$opt2];}

	}mysql_free_result($rs);
}




GLOF_Init('CbPersonalPL','BannerPopUp','zModificarControl',1,'',0,0,0); 
GLO_tituloypath(0,750,'','PLANILLA DE CONTROL','salir');
?> 


<table width="750" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td> <td width="200"></td> <td width="80"></td><td width="140"></td><td width="100"></td><td width="130"></td> </tr>
<tr><td height="18" align="right">Orden:</td><td >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td><td></td><td><input name="ChkListoPL"  type="radio"  class="radiob"  value="0" <? if ($_SESSION['ChkListoPL'] ==0) echo 'checked'; ?> >Planilla Incompleta</td><td><input name="ChkListoPL"  type="radio"  class="radiob"  value="1" <? if ($_SESSION['ChkListoPL'] ==1) echo 'checked'; ?> >Completa</td><td><input name="ChkListoPL"  type="radio"  class="radiob"  value="2" <? if ($_SESSION['ChkListoPL'] ==2) echo 'checked'; ?> >No Requerida</td></tr>
</table>


<!--taller-->
<table width="750" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td> <td width="200"></td> <td width="80"></td><td width="90"></td><td width="60"></td><td width="80"></td><td width="50" height="3"  ></td> <td width="90"></td> </tr>
<tr> <td height="18"    align="right">Responsable:</td><td >&nbsp;<select name="CbPersonalPL" style="width:170px" class="campos" tabindex="2"><option value=""></option><? ComboPersonalRFX("CbPersonalPL",$conn); ?></select></td><td align="right"  >F.Ingreso:</td><td >&nbsp;<? GLO_calendario("TxtFecha6","../Codigo/","actual",2) ?></td><td align="right">Km:</td><td >&nbsp;<input name="TxtKm" type="text"  tabindex="2"  class="TextBox" style="text-align:right;width:50px" maxlength="6"  value="<? echo $_SESSION['TxtKm']; ?>" onChange="this.value=validarEntero(this.value);" ></td><td align="right">Hs:</td><td>&nbsp;<input name="TxtHs" type="text"  tabindex="2"  class="TextBox" style="text-align:right;width:50px" maxlength="6"  value="<? echo $_SESSION['TxtHs']; ?>" onChange="this.value=validarNumero(this.value);" ></td></tr>
</table>
              


<? 
REP_TablaReqSoli($_SESSION['TxtNroEntidad'],$conn); //idorden 
$rowstyle='style="border-bottom:1px solid #dedede;"';
$rowstyle2='style="border-bottom:1px solid #dedede;border-right:1px solid #dedede;"';
?>



<!--tabla -->
<table width="750" border="0"  cellspacing="0" class="Tabla TMT5 TFWhite">
<tr><td width="25" height="3"  <? echo $rowstyle;?> ><td width="170"   <? echo $rowstyle;?>><strong>Item</strong></td> <td width="90" align="center"  <? echo $rowstyle;?>><strong>A Reparar</strong></td><td width="90"   <? echo $rowstyle2;?>></td><td width="90"   <? echo $rowstyle;?>></td><td width="170"  <? echo $rowstyle;?>><strong>Item</strong></td><td width="90" align="center" <? echo $rowstyle;?>><strong>A Reparar</strong></td><td width="25"   <? echo $rowstyle;?>></td></tr>
<tr ><td <? echo $rowstyle;?> ></td><td <? echo $rowstyle;?> >Sistema: Motor</td>
  <td align="center" <? echo $rowstyle;?> ><input name="OptI1"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI1'] ==1) echo 'checked'; ?> /></td>
  <td align="center" <? echo $rowstyle2;?> >&nbsp;</td><td align="center" <? echo $rowstyle;?> >&nbsp;</td> <td <? echo $rowstyle;?> >Sistema: Direcci&oacute;n</td><td align="center" <? echo $rowstyle;?> ><input name="OptI10"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI10'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle;?> >&nbsp;</td></tr>
<tr ><td <? echo $rowstyle;?> ></td><td <? echo $rowstyle;?> >Sistema: Admisi&oacute;n</td><td align="center" <? echo $rowstyle;?> ><input name="OptI2"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI2'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle2;?> >&nbsp;</td><td align="center" <? echo $rowstyle;?> >&nbsp;</td><td <? echo $rowstyle;?> >Sistema: Hidr&aacute;ulico</td><td align="center" <? echo $rowstyle;?> ><input name="OptI11"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI11'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle;?> >&nbsp;</td></tr>
<tr ><td <? echo $rowstyle;?> ></td><td <? echo $rowstyle;?> >Sistema: Tren delantero</td><td align="center" <? echo $rowstyle;?> ><input name="OptI3"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI3'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle2;?> >&nbsp;</td><td align="center" <? echo $rowstyle;?> >&nbsp;</td>  <td <? echo $rowstyle;?> >Sistema: Combustible</td><td align="center" <? echo $rowstyle;?> ><input name="OptI12"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI12'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle;?> >&nbsp;</td></tr>
<tr ><td <? echo $rowstyle;?> ></td><td <? echo $rowstyle;?> >Sistema: Diferencial</td><td align="center" <? echo $rowstyle;?> ><input name="OptI4"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI4'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle2;?> >&nbsp;</td><td align="center" <? echo $rowstyle;?> >&nbsp;</td><td <? echo $rowstyle;?> >Chapa y pintura</td><td align="center" <? echo $rowstyle;?> ><input name="OptI13"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI13'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle;?> >&nbsp;</td></tr>
<tr ><td <? echo $rowstyle;?> ></td><td <? echo $rowstyle;?> >Sistema: Enfriamiento</td><td align="center" <? echo $rowstyle;?> ><input name="OptI5"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI5'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle2;?> >&nbsp;</td><td align="center" <? echo $rowstyle;?> >&nbsp;</td><td <? echo $rowstyle;?> >Elementos de seguridad</td><td align="center" <? echo $rowstyle;?> ><input name="OptI14"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI14'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle;?> >&nbsp;</td></tr>
<tr ><td <? echo $rowstyle;?> ></td><td <? echo $rowstyle;?> >Sistema: Frenos</td><td align="center" <? echo $rowstyle;?> ><input name="OptI6"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI6'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle2;?> >&nbsp;</td><td align="center" <? echo $rowstyle;?> >&nbsp;</td><td <? echo $rowstyle;?> >Interior</td><td align="center" <? echo $rowstyle;?> ><input name="OptI15"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI15'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle;?> >&nbsp;</td></tr>
<tr ><td <? echo $rowstyle;?> ></td><td <? echo $rowstyle;?> >Sistema: Transmisi&oacute;n</td><td align="center" <? echo $rowstyle;?> ><input name="OptI7"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI7'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle2;?> >&nbsp;</td><td align="center" <? echo $rowstyle;?> >&nbsp;</td><td <? echo $rowstyle;?> >Cubiertas</td><td align="center" <? echo $rowstyle;?> ><input name="OptI16"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI16'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle;?> >&nbsp;</td></tr>
<tr ><td <? echo $rowstyle;?> ></td><td <? echo $rowstyle;?> >Sistema: El&eacute;ctrico</td><td align="center" <? echo $rowstyle;?> ><input name="OptI8"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI8'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle2;?> >&nbsp;</td><td align="center" <? echo $rowstyle;?> >&nbsp;</td><td <? echo $rowstyle;?> >Llantas</td><td align="center" <? echo $rowstyle;?> ><input name="OptI17"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI17'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle;?> >&nbsp;</td></tr>
<tr ><td <? echo $rowstyle;?> ></td><td <? echo $rowstyle;?> >Sistema: Suspensi&oacute;n</td><td align="center" <? echo $rowstyle;?> ><input name="OptI9"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI9'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle2;?> >&nbsp;</td><td align="center" <? echo $rowstyle;?> >&nbsp;</td> <td <? echo $rowstyle;?> >Auxilio</td><td align="center" <? echo $rowstyle;?> ><input name="OptI18"  type="checkbox"  class="check"   value="1"<? if ($_SESSION['OptI18'] ==1) echo 'checked'; ?> ></td> <td align="center" <? echo $rowstyle;?> >&nbsp;</td></tr>
</table>


<table width="750" border="0"   cellspacing="0" class="Tabla TMT5" >
<tr><td height="3"  ></td></tr>
<tr><td  valign="top"  align="center"><textarea  name="TxtObsPL" style="width:700px;" rows="3" class="TextBox"  tabindex="3" onKeyPress="event.cancelBubble=true;"><? echo $_SESSION['TxtObsPL']; ?></textarea></td></tr>
</table>



<?
//hidden
GLO_Hidden('TxtIdSoli',0);GLO_Hidden('TxtIdEstadoO',0);GLO_Hidden('TxtNroEntidad',0);

//si esta retirada o finalizada no puede modificar planilla
if (intval($_SESSION['TxtIdEstadoO'])!=7 and intval($_SESSION['TxtIdEstadoO'])!=8 and intval($_SESSION['TxtIdEstadoO'])!=9){
GLO_guardarform(750,0,2,1,0);}else{GLO_guardarform(750,1,2,1,0);}

GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn); 
for ($i=1; $i < 19; $i= $i +1) {$opt='OptI'.$i;$_SESSION[$opt]="";}

GLO_initcomment(750,0);
echo 'Al <font class="comentario2">Imprimir</font> genera una planilla en blanco a completar por el encargado de las <font class="comentario3">Tareas</font>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>