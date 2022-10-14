<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php'); 
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);
 
$_SESSION['TxtNroEntidad'] =intval($_GET['id']);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

if ($_GET['Flag1']=="True"){
	//traigo datos personal
	$query="SELECT i.Fecha,i.Hora,i.IdPersonal,p.Documento,p.Nombre,p.Apellido,p.Legajo,p.Direccion,f.Nombre as Funcion,l.Nombre as Loc,l.CP,pr.Nombre as Prov,s.Nombre as Sector,y.Nombre as Yac,t.Nombre as Diag,t.Horas as Turno,cat.Nombre as CatF From incidentes i,personal p,funcion f,localidades l,provincias pr,sector s,yacimientos y,turnos t,categorias cat  where i.Id<>0 and i.IdPersonal=p.Id and p.IdFuncion=f.Id and p.IdLocalidad=l.Id and l.IdPcia=pr.Id and i.IdSector=s.Id and i.IdYac=y.Id and p.IdTurno=t.Id and p.IdCateg=cat.Id and i.Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNombre']=$row['Apellido'].' '.$row['Nombre'];
		$_SESSION['TxtDNI']=$row['Documento'];
		$_SESSION['TxtPuesto']=$row['Funcion'];
		$_SESSION['TxtLegajo']=$row['Legajo'];		
		$_SESSION['TxtDir2']=$row['Direccion'];
		$_SESSION['TxtLocalidad2']=$row['Loc'];
		$_SESSION['TxtProvincia2']=$row['Prov'];
		$_SESSION['TxtCP2']=$row['CP'];
		$_SESSION['TxtTurno']=$row['Turno'];
		$_SESSION['TxtDiag']=$row['Diag'];
		$_SESSION['TxtCat']=$row['CatF'];
		//
		$_SESSION['TxtSector']=$row['Sector'];
		$_SESSION['TxtFecha']=GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtHora']=GLO_FormatoHora($row['Hora']);
		$_SESSION['TxtLugar']=$row['Yac'];
		$idpersonal=$row['IdPersonal'];
	}mysql_free_result($rs);
	//telefono personal
	$query="SELECT * From personaltelefonos where Id<>0 and IdEntidad=$idpersonal";$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtTel']=GLO_ListaTexto($_SESSION['TxtTel'],$row['CodigoArea'].' '.$row['NumeroTelefono']);
	}mysql_free_result($rs);
	//traigo datos informe
	$query="SELECT a.*,l.CP,pr.Nombre as Prov From incidentes_acc a,incidentes i,localidades l,provincias pr where a.Id<>0 and a.IdP=i.Id  and a.IdLoc=l.Id and l.IdPcia=pr.Id and a.IdP=".intval($_GET['id']);	
	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']=$row['Id'];
		$_SESSION['TxtNro']=$row['NroD'];
		//
		$_SESSION['TxtTpoE']=$row['TpoE'];
		$_SESSION['TxtTpoP']=$row['TpoP'];
		//
		$_SESSION['TxtDir']=$row['Dir'];
		$_SESSION['CbLocalidad']=$row['IdLoc'];
		//
		$_SESSION['TxtObs1']=$row['Lesion'];
		$_SESSION['TxtObs2']=$row['PriAux'];
		$_SESSION['TxtObs3']=$row['AtMed'];
		$_SESSION['TxtHs']=$row['Horas'];
		$_SESSION['TxtDias']=$row['Dias'];
		$_SESSION['TxtFoto']=$row['Foto'];
		//
		$_SESSION['TxtTN1']=$row['TN1'];
		$_SESSION['TxtTE1']=$row['TE1'];
		$_SESSION['TxtTC1']=$row['TC1'];
		$_SESSION['TxtTT1']=$row['TT1'];
		$_SESSION['TxtTN2']=$row['TN2'];
		$_SESSION['TxtTE2']=$row['TE2'];
		$_SESSION['TxtTC2']=$row['TC2'];
		$_SESSION['TxtTT2']=$row['TT2'];
		$_SESSION['TxtTN3']=$row['TN3'];
		$_SESSION['TxtTE3']=$row['TE3'];
		$_SESSION['TxtTC3']=$row['TC3'];
		$_SESSION['TxtTT3']=$row['TT3'];
		$_SESSION['TxtTN4']=$row['TN4'];
		$_SESSION['TxtTE4']=$row['TE4'];
		$_SESSION['TxtTC4']=$row['TC4'];
		$_SESSION['TxtTT4']=$row['TT4'];
		//
		$_SESSION['OptTipo']=$row['Tipo'];
	}mysql_free_result($rs);	
}


//html
GLO_InitHTML($_SESSION["NivelArbol"],'TxtFechaA','BannerPopUp','zModificar1',0,0,0,0);
include ("zCampos1.php");
//GLO_exportarform(750,1,0,0,0,0);
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>