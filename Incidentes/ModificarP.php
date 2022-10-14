<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	$query="SELECT m.* From incidentes_per m where m.Id=".intval($_GET['id']);
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdP'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre'] =  $row['Nombre'];		
		$_SESSION['TxtObs'] = $row['Obs'];
		$_SESSION['CbPersonal'] = $row['IdPersonal'];	
	}mysql_free_result($rs);
}


GLO_InitHTML($_SESSION["NivelArbol"],'CbPersonal','BannerPopUp','zModificarP',0,0,0,0);

include("Includes/zCamposP.php");
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(620,0);
echo 'Ingrese el nombre de la <font class="comentario3">Persona</font> donde corresponda, segun sea personal de la <font class="comentario2">Empresa</font> o <font class="comentario2">Externo</font>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>