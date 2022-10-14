<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){
	$query="SELECT * From c_oportunidades where Id<>0 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero']= str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['CbCliente'] =$row['IdCliente'];
		$_SESSION['CbPersonal'] =$row['IdPersonal'];
		$_SESSION['CbTipo'] = $row['IdTipo'];
		$_SESSION['CbTipoC'] = $row['IdTipoC'];		
		$_SESSION['CbEstado'] =$row['IdEstado'];
		$_SESSION['TxtFechaA'] =GLO_FormatoFecha($row['Fecha']);
		$_SESSION['TxtContacto'] =$row['Contacto'];
		$_SESSION['TxtRef'] =$row['Ref'];
		$_SESSION['TxtUbic'] =$row['Loc'];
		$_SESSION['TxtObs'] =$row['Obs'];
		//buscar cotizacion
		$query="Select Id From c_cotizaciones Where IdOp=".$row['Id']; $rs2=mysql_query($query,$conn);$row2=mysql_fetch_array($rs2);
		if(mysql_num_rows($rs2)!=0){$_SESSION['TxtIdCot']=str_pad($row2['Id'], 6, "0", STR_PAD_LEFT);}
		else{$_SESSION['TxtIdCot']='';}mysql_free_result($rs2);
					
	}
	mysql_free_result($rs);
}


GLOF_Init('TxtFechaA','BannerConMenuHV','zModificarOportunidad',0,'MenuH',0,0,0); 


include("Includes/zCamposOPO.php");  

GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"c_oportunidad_a","720","Comprobantes/","Archivos adjuntos","paperclip",0,0,1);

mysql_close($conn);
GLO_cierratablaform();

GLO_initcomment(720,0);
echo 'Con el boton <font class="comentario2">Cotizar</font> generara una <font class="comentario3">Cotizacion</font> nueva<br>';
echo 'No se puede modificar una <font class="comentario2">Oportunidad</font> que esta <font class="comentario3">Cotizada</font> <br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>