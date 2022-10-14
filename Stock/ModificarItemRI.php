<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get (seguridad)
GLO_ValidaGET($_GET['IdItem'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar datos
if ($_GET['Flag1']=="True"){
	//solo items no asociados a cam ni pedidos
	$query="SELECT s.*, a.Nombre,a.Modelo, m.Nombre as Marca,np.Id as IdNP,il.Nombre as Prod,u.Abr as Abr,u2.Abr as Abr2 From stockmov_items s, epparticulos a,marcas m,co_npedido np,co_npedido_it npi,items il,unidadesmedida u,unidadesmedida u2 where s.IdItemNP=npi.Id and np.Id=npi.IdNP and s.IdArticulo=a.Id and s.IdItem=il.Id and a.IdMarca=m.Id and s.IdNP=np.Id and a.IdUnidad=u.Id and il.IdUnidad=u2.Id and s.IdCAM=0 and s.IdPedido=0 and s.Id=".intval($_GET['IdItem']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){
		$_SESSION['TxtNroEntidad']=str_pad(intval($row['IdMov']), 6, "0", STR_PAD_LEFT);	
		$_SESSION['TxtNumero']=$row['Id'];
		$_SESSION['TxtCantidad'] =$row['Cantidad'];
		$_SESSION['TxtCantidadInicial'] =$row['Cantidad'];
		$_SESSION['TxtIdArticulo'] =$row['IdArticulo'];
		if($row['IdArticulo']!=0){
			$_SESSION['TxtArticulo']=str_pad($row['IdArticulo'], 6, "0", STR_PAD_LEFT).' '.$row['Nombre'].' ('.substr($row['Abr'],0,5).')';
		}else{$_SESSION['TxtArticulo']='';}
		
		$_SESSION['TxtIdItem'] =$row['IdItem'];
		if($row['IdItem']!=0){
			$_SESSION['TxtItem'] =str_pad($row['IdItem'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'].' ('.substr($row['Abr2'],0,5).')';
		}else{$_SESSION['TxtItem']='';}
		//buscar pendiente
		$pdte=0;
		$query="SELECT npi.CantAuto From co_npedido_it npi Where npi.Id=".$row['IdItemNP'];
		$rs2=mysql_query($query,$conn);	while($row2=mysql_fetch_array($rs2)){$pdte=$row2['CantAuto']-$row['Cantidad'];}mysql_free_result($rs2);
		if($pdte>0){$pdte=number_format($pdte,2, '.', '');}else{$pdte='';}
		$_SESSION['TxtCantidadP']=$pdte;
	}mysql_free_result($rs);
}

//valida que no traiga id 0
GLO_ValidaSESSION($_SESSION['TxtNumero'],0,$conn);

GLOF_Init('TxtCantidad','BannerPopUpMH','zModificarItemRI',0,'',0,0,0); 
GLO_tituloypath(0,720,'','DETALLE COMPROBANTE','salir');
?> 


<table width="720" border="0"   cellspacing="0" class="Tabla" >
<tr><td width="120" height="3"  ></td> <td width="260"></td><td width="95" height="3"  ></td> <td width="100"></td><td width="145"></td> </tr>
<tr> <td height="18"  align="right"  >Cantidad:</td><td  valign="top"> &nbsp; <input name="TxtCantidad" type="text"  class="TextBox" style="width:50px;text-align:right" maxlength="7"  tabindex="4"   value="<? echo $_SESSION['TxtCantidad']; ?>" onChange="this.value=validarNumeroP(this.value);"><label class="MuestraError"> * </label></td><td height="18"  align="right"  >Cant.Pendiente:</td><td  valign="top" colspan="2"> &nbsp; <input name="TxtCantidadP" type="text"  tabindex="4"  readonly="true" class="TextBoxRO" style="width:50px;text-align:right;font-weight:bold;color:#f44336;" maxlength="7"  value="<? echo $_SESSION['TxtCantidadP']; ?>" ></td></tr>
<tr> <td height="18"  align="right"  >Art&iacute;culo o Equipo:</td><td  valign="top" colspan="4">&nbsp; <input name="TxtArticulo" type="text"  tabindex="4"  readonly="true" class="TextBoxRO" style="width:500px"   value="<? echo $_SESSION['TxtArticulo']; ?>" ></td></tr>
<tr> <td height="18"  align="right"  >Producto Laboratorio:</td><td  valign="top" colspan="4">&nbsp; <input name="TxtItem" type="text"  tabindex="4"  readonly="true" class="TextBoxRO" style="width:500px"   value="<? echo $_SESSION['TxtItem']; ?>" ></td></tr>
</table> 

<? 
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtCantidadInicial',0);
GLO_Hidden('TxtIdArticulo',0);GLO_Hidden('TxtIdItem',0);
GLO_botonesform("720",0,2);
GLO_mensajeerror();
GLO_cierratablaform();
mysql_close($conn); 
include ("../Codigo/FooterConUsuario.php");
?>