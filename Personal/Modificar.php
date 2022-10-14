<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php");include("zFunciones.php");   $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");include("../Articulos/Includes/zFuncionesA.php");
//perfiles
GLO_PerfilAcceso(10);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
$query="SELECT * From personal where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtLegajo'] = str_pad($row['Legajo'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtNombre']=$row['Nombre'];
	$_SESSION['TxtApellido'] = $row['Apellido'];
	$_SESSION['CbDocumento'] = $row['TipoDocumento'];
	$_SESSION['TxtDoc']= $row['Documento'];
	$_SESSION['ChkExtranjero'] =$row['Extranjero'];
	$_SESSION['TxtDNITramite'] =$row['DNITramite'];
	$_SESSION['CbCUIT'] =$row['TipoIdentificacion'];
	$_SESSION['TxtCUIT']= $row['Identificacion'];
	$_SESSION['TxtNacionalidad']=  $row['Nacionalidad'];	
	$_SESSION['OptTipoG'] = $row['Sexo'];	
	$_SESSION['TxtLN']= $row['LugarNacimiento'];	
	$_SESSION['CbEC'] = $row['EstadoCivil'];	
	$_SESSION['CbLocalidad'] = $row['IdLocalidad'];
	$_SESSION['TxtDireccion']=  $row['Direccion'];
	$_SESSION['TxtProvincia']=  $row['Provincia'];
	$_SESSION['TxtCP']=  $row['CP'];
	$_SESSION['CbLocalidadL'] = $row['IdLocalidadL'];
	$_SESSION['TxtDireccionL']=  $row['DireccionL'];
	$_SESSION['TxtProvinciaL']=  $row['ProvinciaL'];
	$_SESSION['TxtCPL']=  $row['CPL'];
	$_SESSION['TxtEMail']= $row['EMail']; 
	$_SESSION['TxtFoto'] = $row['Foto'];
	$_SESSION['TxtFechaA'] = GLO_FormatoFecha($row['FechaAlta']);
	$_SESSION['TxtFechaB'] = GLO_FormatoFecha($row['FechaBaja']);
	$_SESSION['TxtFechaF'] = GLO_FormatoFecha($row['FinContrato']);
	$_SESSION['TxtCarga'] = $row['CargaFamiliar'];
	$_SESSION['TxtOSocial'] = $row['ObraSocial'];
	$_SESSION['TxtCatOS'] = $row['CategoriaOS'];
	$_SESSION['TxtConv'] = $row['Convenio'];
	$_SESSION['TxtTurno'] = $row['IdTurno'];
	$_SESSION['CbSector'] = $row['IdSector'];
	$_SESSION['TxtFuncion'] = $row['IdFuncion'];
	$_SESSION['CbCateg'] = $row['IdCateg'];
	$_SESSION['CbRS'] = $row['IdRS'];
	$_SESSION['CbART'] = $row['IdART'];
	$_SESSION['TxtObs'] = $row['Observaciones'];
	$_SESSION['CbEstudios'] =$row['IdEstudios'];
	$_SESSION['CbContrato'] =$row['IdContrato'];
	//fecha y edad
	$_SESSION['TxtFecha'] = FormatoFecha($row['FechaNacimiento']);
	if ($_SESSION['TxtFecha']=='00-00-0000'){$_SESSION['TxtFecha'] ="";$_SESSION['TxtEdad']= "";}	
	else{$_SESSION['TxtEdad']= edad($row['FechaNacimiento']).' a&ntilde;os';}
}mysql_free_result($rs);
} 

GLOF_Init('','BannerConMenuHV','zModificar',0,'MenuH',0,0,0); 
include ("zCampos.php");

if($_SESSION["IdPerfilUser"]==1 or $_SESSION["IdPerfilUser"]==2 or $_SESSION["IdPerfilUser"]==3){//solo rrhh ve legajo
	include ("Includes/zTablasP.php");
}

GLO_cierratablaform(); 
mysql_close($conn);
include ("../Codigo/FooterConUsuario.php");
?>