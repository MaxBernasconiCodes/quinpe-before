<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





if ($_GET['Flag1']=="True"){

	$query="SELECT m.* From plan_t m where m.Id=".intval($_GET['id']);

	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

	if(mysql_num_rows($rs)!=0){

		$_SESSION['TxtNumero'] = $row['Id'];

		$_SESSION['TxtNroEntidad'] = str_pad($row['IdP'], 6, "0", STR_PAD_LEFT);

		$_SESSION['TxtObs'] =  $row['Obs'];	

		$_SESSION['TxtNombre'] =  $row['Nombre'];		

		$_SESSION['CbYac'] =  $row['IdYac'];	

		$_SESSION['OptTipo'] =  $row['Prio'];	

		$_SESSION['CbEstado'] =  $row['IdEstado'];

		$_SESSION['TxtFecha1'] = GLO_FormatoFecha($row['F1']);

		$_SESSION['TxtFecha2'] = GLO_FormatoFecha($row['F2']);

		$_SESSION['TxtFecha3'] = GLO_FormatoFecha($row['F3']);

		$_SESSION['TxtFecha4'] = GLO_FormatoFecha($row['F4']);

	}mysql_free_result($rs);

}





GLO_InitHTML($_SESSION["NivelArbol"],'TxtObs','BannerPopUp','zModificarTarea',0,0,0,0);

include("Includes/zCamposTA.php");

PL_TablaResp($_SESSION['TxtNumero'],$conn);

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>