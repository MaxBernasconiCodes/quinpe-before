<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php'); include("Includes/zFunciones.php");include("../Procesos/Includes/zFunciones.php") ;include("../CAM/Includes/zFunciones.php");
//perfiles
GLO_PerfilAcceso(13);

//get
GLO_ValidaGET($_GET['id'],0,0);

//modificar propios y terceros vehiculo

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
if ($_GET['Flag1']=="True"){	
	$query="SELECT a1.*,a.IdCliente as IdCliP From procesosop_e1 a1,procesosop a where a1.Id<>0 and a1.IdPadre=a.Id and a1.Id=".intval($_GET['id']);	
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		include ("Includes/zMostrar.php");
	}mysql_free_result($rs);	
}

//seguridad refresh false
if(intval($_SESSION['TxtNumero'])==0){header("Location:Modificar.php?id=".intval($_GET['id'])."&Flag1=True");}	

//ingreso/salida
if($_SESSION['CbEtapa']==1){$nometapa='INGRESO';}else{$nometapa='EGRESO';}


//valido si tiene items, solo puede modificar proceso si no tiene items
$query="SELECT Id FROM procesosop_e1_it Where IdPadre=".$_SESSION['TxtNumero']." LIMIT 1";
$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
if(mysql_num_rows($rs10)!=0){$tieneitems=1;}else{$tieneitems=0;}
mysql_free_result($rs10);



$_SESSION['TxtOriProcIt']=0;//para que vuelva


GLOF_Init(GLO_formfocus('',0),'BannerConMenuHV','zModificar',1,'',0,0,0); 

include ("Includes/zCampos.php");


GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(0,0);
echo 'Muestra el <font class="comentario2">Total</font> de productos si la <font class="comentario3">Unidad de Medida</font> coincide<br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>