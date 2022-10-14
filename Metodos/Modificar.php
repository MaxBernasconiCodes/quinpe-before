<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);





$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



if ($_GET['Flag1']=="True"){

	$query="SELECT * From metodos where Id<>0 and Id=".intval($_GET['id']);

	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

	if(mysql_num_rows($rs)!=0){

		$_SESSION['TxtNumero'] = $row['Id'];

		$_SESSION['TxtNombre'] = $row['Nombre'];

	}mysql_free_result($rs);

}





GLOF_Init('TxtNombre','BannerConMenuHV','zModificar',0,'../CAM/MenuH',0,0,0); 



include ("zCampos.php");

GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"metodos_adj","600","Laboratorio/","Archivos adjuntos","paperclip",0,0,1);



mysql_close($conn); 

GLO_cierratablaform();

include ("../Codigo/FooterConUsuario.php");

?>