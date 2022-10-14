<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

//get

GLO_ValidaGET($_GET['id'],0,0);



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);





if ($_GET['Flag1']=="True"){

	//busco datos

	$query="SELECT r.*,p.IdOrden From pedidosrepreqsoli r,pedidosrep p where r.IdPR=p.Id and r.Id<>0 and r.Id=".intval($_GET['id']); 

	$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);

	if(mysql_num_rows($rs)!=0){

		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);

		$_SESSION['TxtNroEntidad'] = str_pad($row['IdPR'], 6, "0", STR_PAD_LEFT);

		$_SESSION['TxtFecha'] =GLO_FormatoFecha($row['Fecha']);

		$_SESSION['CbUrg'] =$row['Urg'];

		$_SESSION['TxtObs'] = $row['Obs'];

		$_SESSION['TxtIdOrden'] = $row['IdOrden'];

	}mysql_free_result($rs);

}





GLOF_Init('TxtObs','BannerPopUp','zModificarReqSoli',1,'',0,0,0); 



include ("zCamposReqSoli.php");

GLO_cierratablaform();

mysql_close($conn); 

include ("../Codigo/FooterConUsuario.php");

?>