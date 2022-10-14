<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
GLO_PerfilAcceso(14);

//get

GLO_ValidaGET($_GET['id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





if ($_GET['Flag1']=="True"){

	$query="SELECT m.*,s.Nombre as Sector From iso_minutas_as m,sector s where m.IdSector=s.Id and m.Id=".intval($_GET['id']);

	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

	if(mysql_num_rows($rs)!=0){

		$_SESSION['TxtNumero'] = $row['Id'];

		$_SESSION['TxtNroEntidad'] = str_pad($row['IdMin'], 6, "0", STR_PAD_LEFT);

		$_SESSION['TxtNombre'] =  $row['Nombre'];		

		$_SESSION['CbSector'] = $row['IdSector'];

		$_SESSION['CbPersonal'] = $row['IdPersonal'];	

	}mysql_free_result($rs);

}





GLO_InitHTML($_SESSION["NivelArbol"],'CbPersonal','BannerPopUp','zModificarAsistente',0,0,0,0);



include("Includes/zCamposAS.php");

GLO_cierratablaform();

mysql_close($conn); 



GLO_initcomment(600,0);

echo 'Complete <font class="comentario2">Otro</font> si el asistente no pertenece al <font class="comentario3">Personal</font>';

GLO_endcomment();



include ("../Codigo/FooterConUsuario.php");

?>