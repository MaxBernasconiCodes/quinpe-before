<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



if ($_GET['Flag1']=="True"){
	$query="SELECT p.*,e.Nombre as Estado,pe.Nombre,pe.Apellido,p.IdPR From pedidosrep_hist p, pedidosrepord_est e,personal pe,usuarios u  where p.IdEstado=e.Id and u.Usuario=p.IdUsuario and pe.Id=u.IdPersonal and p.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdPR'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtEstado'] =$row['Estado'];
		$_SESSION['TxtUsuario'] =$row['Apellido'].' '.$row['Nombre'];
		$_SESSION['TxtFecha'] =GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtObs'] = $row['Obs'];
	}mysql_free_result($rs);
}



GLOF_Init('','BannerPopUp','zModificarEPR',0,'',0,0,0); 
GLO_tituloypath(0,600,'','ESTADO ORDEN','salir');
?> 

<table width="600" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="5"  ></td> <td width="500"></td></tr>
<tr><td height="18"  align="right"  >Fecha:</td><td>&nbsp;<? GLO_calendario("TxtFecha","../Codigo/","actual",1) ?></td></tr>
<tr> <td height="18"  align="right"  >Estado:</td><td>&nbsp;<input  name="TxtEstado" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtEstado'];?>" style="width:200px"></td></tr>
<tr> <td height="18"  align="right"  >Usuario:</td><td>&nbsp;<input  name="TxtUsuario" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtUsuario'];?>" style="width:450px"></td></tr>
<tr> <td height="18"  align="right"  >Observaciones:</td><td>&nbsp;<input name="TxtObs" type="text"  class="TextBox" style="width:450px" maxlength="200"  tabindex="3"  value="<? echo $_SESSION['TxtObs']; ?>"></td></tr>
</table>


<? 
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("600",0,2);
GLO_mensajeerror();           
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>