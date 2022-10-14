<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){	
	$query="SELECT * From pssa_act where Id<>0 and Id=".intval($_GET['id']); $rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre']= $row['Nombre'];
		$_SESSION['CbTipo']=$row['IdTipo'];
		$_SESSION['CbFrec']=  $row['IdFrec'];
		$_SESSION['CbResp']=  $row['IdResp'];
	}	mysql_free_result($rs);
}


GLOF_Init('TxtNombre','BannerConMenuHV','zModificar',0,'',0,0,0); 

include ("Includes/zCampos.php");
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>