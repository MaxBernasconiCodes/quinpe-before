<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);







$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



$query="SELECT p.*,o.IdEstado as IdEstadoO From pedidosrepreq p,pedidosrepord o where p.IdPR=o.Id and p.Id=".intval($_GET['id']); 

$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

if(mysql_num_rows($rs)!=0){

	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);

	$_SESSION['TxtNroEntidad'] = str_pad($row['IdPR'], 6, "0", STR_PAD_LEFT);

	$_SESSION['TxtIdEstadoO'] = $row['IdEstadoO'];

	$_SESSION['ChkPdte'] =$row['Pdtes'];

	$_SESSION['TxtFecha'] =GLO_FormatoFecha($row['FFin']);

}mysql_free_result($rs);



if (empty($_SESSION['TxtFecha'])) { $_SESSION['TxtFecha']=date("d-m-Y");}



GLOF_Init('','BannerPopUp','zFinalizarReq',0,'',0,0,0); 

GLO_tituloypath(0,600,'','FINALIZAR ACCION','salir');

?> 



<table width="600" border="0"   cellspacing="0" class="Tabla" >

<tr><td width="100" height="5"  ></td> <td width="200"></td><td width="50" height="3"  ></td> <td width="250"></td> </tr>

<tr><td height="18"  align="right"  >Finalizado:</td><td  valign="top">&nbsp;<input name="TxtFecha" id="TxtFecha"  tabindex="1"  type="text" <? if (intval($_SESSION['TxtIdEstadoO'])==8 or intval($_SESSION['TxtIdEstadoO'])==9){echo 'readonly="true"  class="TextBoxRO"'; }else {echo 'class="TextBox"';} ?>  style="width:70px;" maxlength="10"  onchange="this.value=validarFecha(this.value);" value="<? echo $_SESSION['TxtFecha']; ?>"   ><? if (intval($_SESSION['TxtIdEstadoO'])!=8  and intval($_SESSION['TxtIdEstadoO'])!=9){calendario("TxtFecha","../Codigo/","actual");} ?></td><td  align="right"  ></td><td  valign="top" ><input name="ChkPdte"  <? if ((intval($_SESSION['TxtIdEstadoO'])==8  or intval($_SESSION['TxtIdEstadoO'])==9) and ($_SESSION['ChkPdte'] =='0')){ echo 'disabled';} ?> type="checkbox"  class="check" value="1" <? if ($_SESSION['ChkPdte'] =='1') echo 'checked'; ?>>Pendientes</td></tr>

</table>



           

<?

GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtIdEstadoO',0);GLO_Hidden('TxtNumero',0);



GLO_botonesform(600,0,2);

GLO_mensajeerror(); 

GLO_cierratablaform();

mysql_close($conn); 



GLO_initcomment(600,0);

echo 'Complete la fecha para <font class="comentario2">Finalizar</font> la Accion';

GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");

?>