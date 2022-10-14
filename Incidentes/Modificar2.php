<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php'); 
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);
 
$_SESSION['TxtNroEntidad'] =intval($_GET['id']);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
if ($_GET['Flag1']=="True"){
	//traigo datos personal
	$query="SELECT p.Documento,p.Nombre,p.Apellido,p.Legajo,f.Nombre as Funcion From incidentes i,personal p,funcion f where i.Id<>0 and i.IdPersonal=p.Id and p.IdFuncion=f.Id and i.Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNombre']=$row['Apellido'].' '.$row['Nombre'];
		$_SESSION['TxtDNI']=$row['Documento'];
		$_SESSION['TxtPuesto']=$row['Funcion'];
		$_SESSION['TxtLegajo']=$row['Legajo'];
	}mysql_free_result($rs);	
	//traigo datos informe
	$query="SELECT a.*,l.CP,pr.Nombre as Prov From incidentes_amb a,incidentes i,localidades l,provincias pr where a.Id<>0 and a.IdP=i.Id  and a.IdLoc=l.Id and l.IdPcia=pr.Id and a.IdP=".intval($_GET['id']);	
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']=$row['Id'];
		$_SESSION['TxtNro']=$row['NroD'];
		//
		$_SESSION['TxtNombre2']=$row['TNom'];
		$_SESSION['TxtTel']=$row['TTel'];
		$_SESSION['TxtLic2']=$row['TLic'];
		$_SESSION['TxtVto2']=GLO_FormatoFecha($row['TVto']);
		$_SESSION['TxtCat2']=$row['TCat'];		
		$_SESSION['TxtPat']=$row['TPat'];
		$_SESSION['TxtPol']=$row['TPol'];
		$_SESSION['TxtAseg']=$row['TAseg'];
		$_SESSION['TxtEmpresa']=$row['TEmp'];
		$_SESSION['TxtModelo']=$row['TAuto'];
		//
		$_SESSION['TxtLic']=$row['CLic'];
		$_SESSION['TxtVto']=GLO_FormatoFecha($row['CVto']);
		$_SESSION['TxtCat']=$row['CCat'];
		//
		$_SESSION['TxtDir']=$row['Dir'];
		$_SESSION['CbLocalidad']=$row['IdLoc'];
		$_SESSION['TxtProvincia']=$row['Prov'];
		$_SESSION['TxtCP']=$row['CP'];
		$_SESSION['TxtEstado']=$row['Camino'];
		$_SESSION['TxtEstado2']=$row['Clima'];
		//
		$_SESSION['TxtS']=$row['S'];
		$_SESSION['TxtC']=$row['C'];
		$_SESSION['TxtP']=$row['P'];
		//
		$_SESSION['TxtDerrame']=$row['Derrame'];
		$_SESSION['TxtLugar']=$row['Lugar'];
		$_SESSION['TxtCantidad']=$row['Cant'];
		$_SESSION['TxtSup']=$row['Sup'];
		$_SESSION['TxtObs']=$row['RN'];
		$_SESSION['CbEstado']=$row['RC'];
		$_SESSION['CbPersonal']=$row['IdPR'];
	}mysql_free_result($rs);	
}

//html
GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaA','BannerPopUp','zModificar2',0,0,0,0);
include ("zCampos2.php");
//GLO_exportarform(750,1,0,0,0,0);
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>