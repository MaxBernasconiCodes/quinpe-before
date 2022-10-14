<? include("../Codigo/Seguridad.php") ; include("../Codigo/Config.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");include("zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar datos
$query="SELECT * From items where Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){
	$_SESSION['TxtNumero'] = str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
	$_SESSION['TxtNombre'] = $row['Nombre'];
	$_SESSION['CbTipo'] = $row['Tipo'];
	$_SESSION['ChkInactivo']=  $row['Inactivo'];
	$_SESSION['CbUnidad'] = $row['IdUnidad'];
}mysql_free_result($rs);


GLOF_Init('TxtNombre','BannerConMenuHV','zModificar',0,'../Servicios/MenuH',0,0,0); 
include ("zCampos.php");
GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"items_adj","600","Laboratorio/","Archivos adjuntos","paperclip",0,0,1);
mysql_close($conn);
GLO_cierratablaform(); 

GLO_initcomment(600,2);
echo 'La <font class="comentario3">Unidad de medida</font> se utiliza para registrar el <font class="comentario2">Stock</font><br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>