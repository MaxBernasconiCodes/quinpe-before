<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php'); include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);
 
 
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
if ($_GET['Flag1']=="True"){	
	$query="SELECT a.* From incidentes a where a.Id<>0 and a.Id=".intval($_GET['id']);	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']=$row['Id'];
		$_SESSION['TxtFechaA']=GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtHora']=GLO_FormatoHora($row['Hora']);
		$_SESSION['CbSector']=$row['IdSector'];		
		$_SESSION['CbYac']=$row['IdYac'];
		//estado  (id0=pdte)
		if($row['IdE']==0){$_SESSION['CbEstado']=1;}
		if($row['IdE']==1){$_SESSION['CbEstado']=2;}
		//
		$_SESSION['CbPersonal']=$row['IdPersonal'];//denunciante
		//
		$_SESSION['ChkC1']=$row['C1'];
		$_SESSION['ChkC2']=$row['C2'];
		$_SESSION['ChkC3']=$row['C3'];
		$_SESSION['ChkC4']=$row['C4'];
		$_SESSION['ChkC5']=$row['C5'];
		$_SESSION['Chk1']=$row['Tipo1'];
		$_SESSION['Chk2']=$row['Tipo2'];
		//
		$_SESSION['TxtObs']=$row['Obs'];
		$_SESSION['TxtObs1']=$row['Obs1'];
		$_SESSION['TxtObs2']=$row['Obs2'];
		$_SESSION['TxtObs3']=$row['Obs3'];
		$_SESSION['TxtObs4']=$row['Obs4'];
	}mysql_free_result($rs);	
}

//html
GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaA','BannerConMenuHV','zModificar',0,0,0,0);
include ("zCampos.php");
?>

<table width="750" border="0"  cellpadding="0" cellspacing="0" class="TablaFondo" >
<tr> <td height="3" ></td></tr>
<!--involucrados-->
<tr ><td height="18" ><i class="fa fa-users iconsmallsp iconlgray"></i> <strong>Personas involucradas:</strong></td></tr>
<tr> <td  align="center" ><?php INC_TablaInvolucrados($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="15" ></td></tr>
<!--medidas-->
<tr ><td height="18" ><i class="fa fa-tasks iconsmallsp iconlgray"></i> <strong>Medidas Correctivas/Preventivas:</strong></td></tr>
<tr> <td  align="center" ><?php INC_TablaMedidas($_SESSION['TxtNumero'],$conn); ?>	</td></tr>
<tr> <td height="15" ></td></tr>
<!--archivos-->
<tr ><td><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center"><?php GLO_TablaArchivos(intval($_SESSION['TxtNumero']),$conn,"incidentesarchivos",750,"Adjuntos/"); ?>	</td></tr>
</table> 

<?
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>