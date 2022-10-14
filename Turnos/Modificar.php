<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
GLO_PerfilAcceso(10);
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$query="SELECT * From turnos where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
	$_SESSION['TxtNombre'] = $row['Nombre'];
	$_SESSION['TxtHs'] = $row['Horas'];
}mysql_free_result($rs);


GLOF_Init('TxtNombre','BannerPopUp','zModificar',0,'../Personal/MenuH',0,0,0); 

include("zCampos.php");

mysql_close($conn); 
GLO_cierratablaform();

GLO_initcomment(500,0);
echo 'Las <font class="comentario2">Horas</font> representan el Turno en Horas, dato utilizado en el modulo de <font class="comentario3">Incidentes</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>