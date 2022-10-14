<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("zFunciones.php");
//perfiles
GLO_PerfilAcceso(14);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	$query="SELECT c.* From iso_audi_progdes c Where  c.Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']=$row['Id'];
		$_SESSION['TxtNroEntidad']=$row['IdAudiP'];
		$_SESSION['CbDesvio'] =$row['IdDesvio'];
		$_SESSION['TxtDesc'] =$row['Obs'];
		$_SESSION['TxtAccion'] =$row['Accion'];	
	}mysql_free_result($rs);
}

?> 

<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
<? GLO_bodyform('',0,0);?>
<? include ("../Codigo/BannerPopUp.php");?>
<? GLO_formform('Formulario','zModificarDesvio.php',0,0,0); ?>

<? include ("Includes/zCamposD.php");?>

<? include ("../Codigo/FooterConUsuario.php");?>