<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";include("Includes/zFunciones.php");

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



if (isset($_POST['CmdBuscar'])){

	foreach($_POST as $key => $value){$_SESSION[$key] = $value;}

	if(!(empty($_POST['TxtFechaDCP']))){$wfechad="and DATEDIFF(m.F1,'".FechaMySql($_POST['TxtFechaDCP'])."')>=0";}else{$wfechad='';}

	if(!(empty($_POST['TxtFechaHCP']))){$wfechah="and DATEDIFF(m.F1,'".FechaMySql($_POST['TxtFechaHCP'])."')<=0";}else{$wfechah='';}

	$yac=intval($_POST['CbYac']);if($yac!=0){$wyac="and m.IdYac=$yac";}else{$wyac='';}

	$est=intval($_POST['CbEstado']);if($est!=0){$west="and m.IdEstado=$est";}else{$west='';}

	//

	$_SESSION['TxtQISOPLAT']="SELECT m.*,y.Nombre as Yac,e.Nombre as Estado,p.Codigo,p.Fecha From plan_t m,plan p,yacimientos y,plan_e e where m.IdYac=y.Id and m.IdEstado=e.Id and m.IdP=p.Id $wfechad $wfechah $wyac $west Order by p.Fecha,p.Codigo,m.F1";

	header("Location:Seguimiento.php");

}



?>



