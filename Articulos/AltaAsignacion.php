<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//si viene de articulos valida get
if(intval($_SESSION['TxtOriARTAsig'])==0){
    GLO_ValidaGET($_GET['Id'],0,0);
    $_SESSION['TxtNroEntidad']=$_GET['Id'];
    $_SESSION['CbInstrumento']=$_SESSION['TxtNroEntidad'];
}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if (empty($_SESSION['TxtFechaA'])){ $_SESSION['TxtFechaA']=date("d-m-Y");}


GLOF_Init('CbInstrumento','BannerPopUp','zAltaAsignacion',0,'',0,0,0); 
GLO_tituloypath(0,700,'','ASIGNACION  INSTRUMENTO','salir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
<tr> <td height="18"  align="right"  >Asignacion:</td><td>&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td></tr>

<tr> <td height="18"  align="right"  >Instrumento:</td><td>&nbsp;<select name="CbInstrumento" style="width:400px"  tabindex="1" class="campos" id="CbInstrumento" > <? if(intval($_SESSION['TxtNroEntidad'])!=0){ GLO_ComboEquiposRO("CbInstrumento",intval($_SESSION['CbInstrumento']),"epparticulos",$conn);}else{ echo '<option value=""></option>';GLO_ComboEquipos("CbInstrumento","epparticulos",$conn);} ?> </select><label class="MuestraError"> * </label></td></tr>
</table>

<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right"  >Personal:</td><td>&nbsp;<select name="CbPersonal" class="campos" id="CbPersonal" tabindex="1" style="width:400px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboPersonalRFX('CbPersonal',$conn); ?></select><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >Unidad:</td><td>&nbsp;<select name="CbUnidad" tabindex="1"  style="width:400px" class="campos" id="CbUnidad" ><? echo '<option value=""></option>';GLO_ComboActivoUni("unidades","CbUnidad","Dominio","","",$conn); ?> </select></td></tr>
<tr> <td height="18"  align="right"  >Sector:</td><td>&nbsp;<select name="CbSector" tabindex="1" style="width:400px" class="campos" id="CbSector" > <? echo '<option value=""></option>';ComboTablaRFX("sectorm","CbSector","Nombre","","",$conn); ?> </select></td></tr>
</table>



<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="100"></td><td width="480"></td> </tr>
<tr> <td height="18"  align="right"  >Entrega:</td><td>&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?></td><td><label class="MuestraError"> * </label> <input name="ChkReq"  tabindex="1"  class="check" type="checkbox"  value="1" <? if ($_SESSION['ChkReq'] =='1') echo 'checked'; ?>> <? GLO_CheckColor('Tiempo indefinido',$_SESSION['ChkReq'],0);?></td></tr>
<tr> <td height="18"  align="right"  >Devolucion pactada:</td><td>&nbsp;<? GLO_calendario("TxtFechaE","../Codigo/","actual",1) ?></td><td></td></tr>

</table>

<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="120" height="5"  ></td> <td width="580"></td> </tr>
<tr><td height="18"  align="right"  >Observaciones:</td><td  valign="top" >&nbsp;<input name="TxtObs" type="text" tabindex="2" class="TextBox" style="width:550px" maxlength="100"  value="<? echo $_SESSION['TxtObs']; ?>"></td></tr>
</table>

<?
GLO_Hidden('TxtNroEntidad',0);
GLO_guardar("700",3,0);
GLO_mensajeerror();

mysql_close($conn); 
GLO_cierratablaform(); 

GLO_initcomment(700,2);
echo 'Seleccione <font class="comentario3">Personal</font>, <font class="comentario3">Unidad</font> o <font class="comentario3">Sector</font>, solo uno de los dos';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>