<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php'); include("../Barrera/Includes/zFunciones.php") ;include("Includes/zFunciones.php") ;include("../Despacho/zFunciones.php");include("../CAM/Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);
  
$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
 
if ($_GET['Flag1']=="True"){	
	//proceso
	$query="SELECT a.* From procesosop a where a.Id<>0 and a.Id=".intval($_GET['id']);	$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNumero'] = str_pad($row['Id'], 6, "0", STR_PAD_LEFT);
		$_SESSION['TxtFechaA']=GLO_FormatoFecha($row['Fecha']);
		$_SESSION['CbCliente']=$row['IdCliente'];
		$_SESSION['CbEstado']=$row['Estado'];
	}mysql_free_result($rs);	
}



//html
GLOF_Init('','BannerConMenuHV','zModificar',0,'',0,0,0); 
GLO_tituloypath(0,780,'','SOLICITUD','salir');
?>

<table width="780" border="0"  cellspacing="0" class="TablaBuscar" >
<tr> <td width="100" height="5"  ></td> <td width="240"></td><td width="100"></td> <td width="290"></td><td width="40"></td></tr>
<tr> <td height="18"  align="right"  >Solicitud:</td><td >&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"> <?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td align="right"  >Cliente:</td><td>&nbsp;<select name="CbCliente"  tabindex="1"  class="campos" id="CbCliente"  style="width:250px" onKeyDown="enterxtab(event)"><? if (intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option> ';GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn);}else{ComboTablaRFROX("clientes","CbCliente","Nombre","",$_SESSION['CbCliente'],"",$conn);} ?></select><label class="MuestraError"> * </label></td><td align="right" >
<?	
if($_SESSION['CbEstado']==0){	
	echo GLO_FAButtonIcon('CmdCerrarP','submit','','self','Cerrar','unlock','iconlgray');			 					
}else{
	echo GLO_FAButtonIcon('CmdAbrirP','submit','','self','Abrir','lock','iconred');			 					
}
?>
 &nbsp; </td></tr>
</table> 


<?
GLO_Hidden('TxtId',0);
GLO_mensajeerror(); 

include ("Includes/zCampos.php");//circuito
include ("Includes/zCamposHR.php");//hoja de ruta

GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(780,0);
echo 'Las <font class="comentario3">Solicitudes</font> se dan de alta en <font class="comentario2">Logistica</font><br>';
echo 'Una vez que una <font class="comentario3">Solicitud</font> esta <font class="comentario2">Cerrada</font>, no puede tomarse desde <font class="comentario3">Barrera</font><br>';
echo 'No cerrar la <font class="comentario3">Solicitud</font> hasta que se registre el <font class="comentario2">Retorno</font> en <font class="comentario3">Barrera</font><br>';
GLO_endcomment();

include ("../Codigo/FooterConUsuario.php");
?>