<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("Includes/zFuncionesCheck.php");
//perfiles
GLO_PerfilAcceso(13);

//get
GLO_ValidaGET($_GET['id'],0,0);

$_SESSION['TxtNroEntidad'] = intval($_GET['id']);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//valido que no complete checklist si no es de tercero
$query="SELECT Id From procesosop_e1 where Tipo=2 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){$existe=1;}else{$existe=0;}mysql_free_result($rs);
//valido si sale
if($existe==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


//traigo datos y verifico si existe la planilla
$existeplanilla=0;
$query="SELECT * From procesosop_e1_ct  where IdPadre=".intval($_GET['id']); $rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$opt='OptI'.$row['Item'];$txt='TxtOI'.$row['Item'];
	$_SESSION[$opt]=$row['Valor'];
	$_SESSION[$txt]=$row['Obs'];
	$existeplanilla=1;
}mysql_free_result($rs);



GLOF_Init('','BannerPopUpMH','zModificarControlT',0,'',0,0,0); 
GLO_tituloypath(0,850,'','PLANILLA DE CONTROL TERCEROS','salir');
?> 


<table width="850" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="50" height="3"  ></td><td width="370"></td><td width="60"></td><td width="60"></td><td width="60"></td><td width="350"></td></tr>
<tr class="TBold"><td class="TAC">&nbsp;Item</td><td >Detalle</td><td class="TAC">Bien/Si</td><td class="TAC">Mal/No</td><td class="TAC">N/C</td><td>Observaciones</td></tr>
<!--tabla opt-->
<?
$pad='style="padding:0 0 0.8rem 0;"';
for ($i=1; $i < 7; $i= $i +1) {
$opt='OptI'.$i;$txt='TxtOI'.$i;
echo '<tr><td  class="TAC TVT" '.$pad.'>&nbsp;'.$i.'</td>';
echo '<td class="TVT" '.$pad.'>';echo BAR_checkterceros($i); echo '</td>';
echo '<td class="TAC TVT" '.$pad.'><input name="'.$opt.'"  type="radio"  class="radiob"  value="1"'; if ($_SESSION[$opt] ==1){echo 'checked';} echo '></td>';
echo '<td  class="TAC TVT" '.$pad.'><input name="'.$opt.'"  type="radio"  class="radiob"  value="2"';if ($_SESSION[$opt] ==2){echo 'checked';} echo '></td>';
echo '<td  class="TAC TVT" '.$pad.'><input name="'.$opt.'"  type="radio"  class="radiob"  value="3"';if ($_SESSION[$opt] ==3){echo 'checked';} echo '></td>';
echo '<td class="TVT" '.$pad.'><input name="'.$txt.'" type="text"  class="TextBox" style="width:300px" maxlength="50"  value="'.$_SESSION[$txt].'" ></td></tr>';
}
?>
</table>

<table width="850" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td height="3"  width="200"></td><td width="350"></td><td width="200"></td></tr>
<tr> <td></td><td align="center" valign="middle" ><input name="CmdAceptar" type="submit" class="boton" tabindex="4"  value="Guardar" onClick="document.Formulario.target='_self'"></td><td align="right">
<? 
//borrar planilla
if($existeplanilla==1){ echo '<input name="CmdEliminar" type="submit" class="boton02" style="width:90px" value="Eliminar Planilla" onClick="document.Formulario.target='."'_self'".';return confirm('."'Eliminar'".');">';} 
?>
&nbsp;</td></tr>
</table>

           
<? 
//hidden
GLO_Hidden('TxtNroEntidad',0);

GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn); 
for ($i=1; $i < 7; $i= $i +1) {$opt='OptI'.$i;$_SESSION[$opt]="";}
for ($i=1; $i < 7; $i= $i +1) {$opt='TxtOI'.$i;$_SESSION[$opt]="";}
include ("../Codigo/FooterConUsuario.php");
?>