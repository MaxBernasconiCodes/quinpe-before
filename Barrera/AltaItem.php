<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
require_once('../Codigo/calendar/classes/tc_calendar.php');include("../Procesos/Includes/zFunciones.php") ;include("Includes/zFunciones.php") ;
//perfiles
GLO_PerfilAcceso(13);


//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
if (empty($_SESSION['TxtFecha'])){ $_SESSION['TxtFecha']=date("d-m-Y");}
$_SESSION['TxtNroEntidad'] = str_pad($_GET['Id'], 6, "0", STR_PAD_LEFT);

//cliente proceso
$query="SELECT p.IdCliente,a.Rto,a.Etapa From procesosop_e1 a,procesosop p where a.Id<>0 and a.IdPadre=p.Id and a.Id=".intval($_GET['Id']);	
$rs=mysql_query($query,$conn);
while($row=mysql_fetch_array($rs)){	
    $_SESSION['CbCliente']=$row['IdCliente'];
    $_SESSION['TxtRto'] = $row['Rto'];
    //0:ingreso,1:salida
    if($row['Etapa']==0){$_SESSION['CbEtapa']=1;}else{$_SESSION['CbEtapa']=2;}
}mysql_free_result($rs);	

//ingreso/salida
if($_SESSION['CbEtapa']==1){$nometapa='INGRESO';}else{$nometapa='EGRESO';}
$retorno='';

GLO_InitHTML($_SESSION["NivelArbol"],'TxtNombre','BannerPopUpMH','zAltaItem',0,0,0,0);

include("Includes/zCamposItem.php");
GLO_guardar("730",3,0); 
GLO_mensajeerror();

GLO_cierratablaform();
mysql_close($conn); 
GLO_initcomment(730,0);
echo 'Permite seleccionar <font class="comentario2">Items</font> tipo <font class="comentario3">Producto</font><br>';
echo 'El <font class="comentario2">Cliente</font> de la Solicitud es el due&ntilde;o del <font class="comentario3">Producto</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>