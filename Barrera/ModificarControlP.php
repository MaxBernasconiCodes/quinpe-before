<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
include("Includes/zFuncionesCheck.php");
//perfiles
GLO_PerfilAcceso(13);

//get
GLO_ValidaGET($_GET['id'],0,0);

$_SESSION['TxtNroEntidad'] = intval($_GET['id']);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//valido que no complete checklist si no es de propio
$query="SELECT Id From procesosop_e1 where Tipo=1 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
$row=mysql_fetch_array($rs);if(mysql_num_rows($rs)!=0){$existe=1;}else{$existe=0;}mysql_free_result($rs);
//valido si sale
if($existe==0){header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


//traigo datos y verifico si existe la planilla
$existeplanilla=0;
$query="SELECT * From procesosop_e1_cp  where IdPadre=".intval($_GET['id']); $rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$opt='OptI'.$row['Item'];$txt='TxtOI'.$row['Item'];
	$_SESSION[$opt]=$row['Valor'];
	$existeplanilla=1;
}mysql_free_result($rs);


GLOF_Init('','BannerPopUpMH','zModificarControlP',0,'',0,0,0); 
GLO_tituloypath(0,900,'','PLANILLA DE CONTROL PROPIOS','salir');
?> 


<table width="900" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="20" height="3"  ></td><td width="190"></td><td width="30"></td><td width="30"></td><td width="30"></td><td width="20"></td><td width="190"></td><td width="30"></td><td width="30"></td><td width="30"></td><td width="20"></td><td width="190"></td><td width="30"></td><td width="30"></td><td width="30"></td></tr>
<tr class="TBold"><td class="TAC"></td><td ></td><td class="TAC">Si</td><td class="TAC">No</td><td class="TAC">F/R</td><td class="TAC TBL"></td><td ></td><td class="TAC">Si</td><td class="TAC">No</td><td class="TAC">F/R</td><td class="TAC TBL"></td><td ></td><td class="TAC">Si</td><td class="TAC">No</td><td class="TAC">F/R</td></tr>
<!--tabla opt-->
<?

function opcionescheckpropio($i){
	//
	$pad='style="padding:0 0 0.8rem 0;"';
	if($i>23){$borde=' TBL';}else{$borde='';}
	$opt='OptI'.$i;
	//
	echo '<td  class="TAC TVT'.$borde.'" '.$pad.'>&nbsp;'.$i.'</td>';
	echo '<td class="TVT" '.$pad.'>';echo BAR_checkpropios($i); echo '</td>';
	//
	echo '<td class="TAC TVT" '.$pad.'>';
	if($i<69){echo '<input name="'.$opt.'"  type="radio"  class="radiob"  value="1"'; if ($_SESSION[$opt] ==1){echo 'checked';}echo '>';}
	echo '</td><td  class="TAC TVT" '.$pad.'>';
	if($i<69){echo '<input name="'.$opt.'"  type="radio"  class="radiob"  value="2"';if ($_SESSION[$opt] ==2){echo 'checked';} echo '>';}
	echo '</td><td  class="TAC TVT" '.$pad.'>';
	if($i<69){echo '<input name="'.$opt.'"  type="radio"  class="radiob"  value="3"';if ($_SESSION[$opt] ==3){echo 'checked';} echo '>';}
	echo '</td>';
}


for ($i1=1; $i1 < 24; $i1= $i1 +1) {	
	echo '<tr>';
	//primer columna
	opcionescheckpropio($i1);
	//segunda columna
	$i2=$i1+23;opcionescheckpropio($i2);
	//tercer columna
	$i3=$i1+46;opcionescheckpropio($i3);
	//
	echo '<tr>';
}


?>
</table>

<table width="900" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td height="3"  width="200"></td><td width="500"></td><td width="200"></td></tr>
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
for ($i=1; $i < 69; $i= $i +1) {$opt='OptI'.$i;$_SESSION[$opt]="";}
include ("../Codigo/FooterConUsuario.php");
?>