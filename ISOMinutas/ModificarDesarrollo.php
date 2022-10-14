<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





if ($_GET['Flag1']=="True"){

	$query="SELECT m.* From iso_minutas_des m where m.Id=".intval($_GET['id']);

	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

	if(mysql_num_rows($rs)!=0){

		$_SESSION['TxtNumero'] = $row['Id'];

		$_SESSION['TxtNroEntidad'] = str_pad($row['IdMin'], 6, "0", STR_PAD_LEFT);

		$_SESSION['TxtNombre'] =  $row['Obs'];		

	}mysql_free_result($rs);

}



GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerPopUp','zModificarDesarrollo',0,0,0,0);



include("Includes/zCamposDES.php");

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>