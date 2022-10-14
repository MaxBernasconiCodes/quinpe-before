<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php'); include("Includes/zFunciones.php") ;include("../Procesos/Includes/zFunciones.php") ;include("../CAM/Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(13);

//get
GLO_ValidaGET($_GET['id'],0,0);

//modificar persona propios y terceros 

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
if ($_GET['Flag1']=="True"){	
	$query="SELECT a1.* From procesosop_e2 a1 where a1.Id<>0 and a1.Id=".intval($_GET['id']);	
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		//generales
		$_SESSION['TxtNumero']=$row['Id'];
		$_SESSION['TxtNroEntidad']=$row['IdPadre'];//proceso
		$_SESSION['TxtFechaA']=GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtHora']=GLO_FormatoHora($row['Hora']);
		$_SESSION['TxtObs']=$row['Obs'];
		$_SESSION['TxtTemp']=$row['Temp'];
		$_SESSION['CbOlf']=$row['Olf'];
		//propio(1) tercero(2)
		$_SESSION['CbTipo']=$row['Tipo'];
		//0:ingreso,1:salida
		if($row['Etapa']==0){$_SESSION['CbEtapa']=1;}else{$_SESSION['CbEtapa']=2;}
		//propio		
		$_SESSION['CbPersonal'] = $row['IdChofer'];
		//terceros
		$_SESSION['CbProv'] = $row['IdProv'];		
		$_SESSION['CbCliente'] = $row['IdCli'];
		$_SESSION['TxtChofer'] = $row['Chofer'];
		$_SESSION['TxtDoc']= $row['DNI'];
		$_SESSION['TxtDocCong']= $row['DNI'];//congelado
	}mysql_free_result($rs);	
}

//ingreso/salida
if($_SESSION['CbEtapa']==1){$nometapa='INGRESO';}else{$nometapa='EGRESO';}


//html
GLOF_Init('TxtFechaA','BannerConMenuHV','zModificarPersona',1,'',0,0,0); 
GLO_tituloypath(0,760,'Consulta.php','BARRERA PERSONA '.$nometapa,'linksalir');

//campos tercero/propio persona
include ("Includes/zCamposPersona.php");//encabezado comun a propios y terceros
if( intval($_SESSION['CbTipo'])==1){include ("Includes/zCamposPersonaP.php");}//1 propio
if( intval($_SESSION['CbTipo'])==2){include ("Includes/zCamposPersonaT.php");}//2 terceros


echo '<table width="760" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td height="5" width="200" ></td><td width="360" ></td><td width="200"  ></td></tr>
<tr><td></td><td align="center">
<input name="CmdAceptar" type="submit" class="boton" tabindex="4" value="Guardar" onClick="document.Formulario.target='."'_self'".'"></td><td align="right">';
//si es modificar ingreso muestra boton egreso, es un atajo para barrera
if( intval($_SESSION['CbEtapa'])==1 and intval($_SESSION['TxtNumero'])!=0){
	echo GLO_FAButton('CmdAltaEgreso','submit','80','self','Alta Egreso','','boton03');
} 	
echo '&nbsp;</td> </tr></table>'; 


GLO_mensajeerror(); 

GLO_cierratablaform();
mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");
?>