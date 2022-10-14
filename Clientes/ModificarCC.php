<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=5 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);


if ($_GET['Flag1']=="True"){
	$query="SELECT c.*,l.Nombre as Loc,l.CP,p.Nombre as Pcia From clicentroscosto c,localidades l,provincias p where c.Id<>0 and c.Idloc=l.Id and l.IdPcia=p.Id and c.Id=".intval($_GET['id']); 
	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
	if(mysql_num_rows($rs)!=0){
		$_SESSION['TxtNumero'] = $row['Id'];
		$_SESSION['TxtNroEntidad'] = str_pad($row['IdCliente'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtNombre'] =  $row['Nombre'];
		$_SESSION['TxtObs'] =  $row['Obs'];
		$_SESSION['TxtCUIT'] =$row['CUIT'];
		$_SESSION['TxtDir'] =$row['Dir'];
		$_SESSION['CbLocalidad'] =$row['IdLoc'];
		$_SESSION['TxtProvincia'] =$row['Pcia'];
		$_SESSION['TxtCP'] =$row['CP'];
		$_SESSION['TxtDiv'] =$row['Lugar'];
		$_SESSION['TxtNroI'] =$row['NroImp'];
		$_SESSION['CbSector'] =$row['IdSector'];	
	}mysql_free_result($rs);
}


?> 


<? include ("../Codigo/HeadFull.php");?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >
<? GLO_bodyform('TxtNombre',0,0); ?>
<? include ("../Codigo/BannerPopUp.php");?>
<? GLO_formform('Formulario','zModificarCC.php',1,0,0);?>

<? include ("Includes/zCamposCC.php");?>   

<? include ("../Codigo/FooterConUsuario.php");?>