<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php'); include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);
 
 
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
if ($_GET['Flag1']=="True"){	
	$query="SELECT a.*,per.Nombre as NAudi,per.Apellido as AAudi From cam a,personal per where a.Id<>0 and per.Id=a.IdUser and a.Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']=str_pad($row['Id'], 5, "0", STR_PAD_LEFT);
		$_SESSION['TxtFechaA']=GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtFechaV']=GLO_FormatoFecha($row['FechaV']);
		$_SESSION['TxtFechaC']=GLO_FormatoFecha($row['LoteVto']);
		$_SESSION['CbProducto']=$row['IdProducto'];
		$_SESSION['CbCliente']=$row['IdCliente'];
		$_SESSION['CbEstado']=$row['IdE'];
		//
		$_SESSION['TxtLote']=$row['Lote'];
		$_SESSION['TxtRto']=$row['Rto'];
		$_SESSION['TxtNroOC']=$row['OC'];
		//
		$_SESSION['TxtObs1']=$row['Obs1'];
		$_SESSION['TxtObs2']=$row['Obs2'];
		$_SESSION['CbPersonal']=$row['IdPer'];
		$_SESSION['TxtUserA'] =$row['AAudi'].' '.$row['NAudi'];
		//
		$_SESSION['TxtIdPE1IT']=$row['IdPE1IT'];
		$_SESSION['TxtIdPE2IT']=$row['IdPE2IT'];
		$_SESSION['TxtOrigen']='';
		if($row['IdPE1IT']!=0){$_SESSION['TxtOrigen']='INGRESO';}//procesosop_e1
		if($row['IdPE2IT']!=0){$_SESSION['TxtOrigen']='FORMULADO';}	//stockmov_items


		//Busco rto planta asociado
		$_SESSION['TxtIdRto']=0;$procesomov='';
		$query="SELECT i.Id,p.IdPadre FROM stockmov_items i,stockmov s,despacho p Where i.IdMov=s.Id and s.IdPedido=p.Id and i.IdCAM=".$row['Id'];	$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
		if(mysql_num_rows($rs10)!=0){$_SESSION['TxtIdRto']=$row10['Id'];$procesomov=str_pad($row10['IdPadre'], 6, "0", STR_PAD_LEFT);}
		mysql_free_result($rs10);

		//Busco proceso
		$_SESSION['TxtIdPadre']='';
		//viene de ingreso barrera
		if($row['IdPE1IT']!=0){
			$query="SELECT a1.IdPadre FROM procesosop_e1 a1,procesosop_e1_it a2 Where a1.Id=a2.IdPadre and a2.Id=".$row['IdPE1IT'];
			$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
			if(mysql_num_rows($rs10)!=0){$_SESSION['TxtIdPadre']=$row10['IdPadre'];}
			mysql_free_result($rs10);
		}
		//viene de formulado
		if($row['IdPE2IT']!=0){
			$_SESSION['TxtIdPadre']=$procesomov;
		}

	}mysql_free_result($rs);	
}

//labels
if(intval($_SESSION['TxtIdRto'])!=0){$lblplanta='El producto ya ingres&oacute; a Planta';}else{$lblplanta='';}

//html
GLOF_Init('TxtFechaA','BannerConMenuHV','zModificar',0,'MenuH',0,0,0); 
GLO_tituloypath(0,750,'','CERTIFICADO ANALISIS','salir');

include ("zCampos.php");
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(750,0);
echo 'No puede cambiarse el <font class="comentario3">Estado</font> si el Producto ya ingres&oacute; a <font class="comentario2">Planta</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>