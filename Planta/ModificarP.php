<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("../Despacho/zFunciones.php");
include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

//mostrar campos
if ($_GET['Flag1']=="True"){
	$query="SELECT * From despacho where Id<>0 and Id=".intval($_GET['id']);$rs=mysql_query($query,$conn);
	while($row=mysql_fetch_array($rs)){include("../Despacho/Includes/zMostrar.php");}mysql_free_result($rs);
}

GLO_ValidaSESSION($_SESSION['TxtNumero'],0,$conn);
	
DES_Estado($_SESSION['CbEstado'],$colorrow,$colorfield,$estado);$_SESSION['TxtEstado'] =$estado;


function TablaRemitos($idpadre,$conn){
	$idpadre=intval($idpadre);
	$query="SELECT distinct s.*,d.Nombre as Deposito,t.Nombre as TipoM,o.Nombre as Origen From stockmov s,stockmov_items si,depositos d,stock_tipomov t,stockmov_origen o where s.IdDeposito=d.Id and s.IdTipoMov=t.Id and s.IdOrigen=o.Id and s.IdPedido=$idpadre Order by s.IdTipoMov DESC";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//Titulos de la tabla
		$tablaclientes='';
		$tablaclientes .='<table width="770" border="0" cellspacing="0" cellpadding="0" class="TMT20"><tr>';
		//titulos
		$tablaclientes .='<td class="recuento" ><label class="TBold">Remitos</label> <label>Productos cargados/formulados</label></td></tr></table>';
		//
		$tablaclientes .='<table width="800" class="TableShow TMT" id="tshow"><tr>';
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";   
		$tablaclientes .="<td "."width="."120"." class="."TableShowT"."> Tipo</td>";   
		$tablaclientes .="<td "."width="."80"." class="."TableShowT"."> Origen</td>";  
		$tablaclientes .="<td "."width="."50"." class="."TableShowT"." style='text-align:right;'> Movim.</td>";   
		$tablaclientes .="<td "."width="."250"." class="."TableShowT"."> Dep&oacute;sito</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Remito</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Items</td>"; 
		$tablaclientes .="<td "."width="."30"." class="."TableShowT"."> </td>";
		$tablaclientes .='</tr>';  
		$estilo=" style='cursor:pointer;'";$_SESSION['TxtOriOPEPla']=1;
		while($row=mysql_fetch_array($rs)){
			$link=" onclick="."location='Modificar.php?Flag1=True&id=".$row['Id']."'";
			//
			$compr="";if($row['Suc']>0 or $row['Nro']>0){$compr=$row['Tipo'].str_pad($row['Suc'], 4, "0", STR_PAD_LEFT)."-".str_pad($row['Nro'], 8, "0", STR_PAD_LEFT);}
			//valido si tiene items
			$tieneitems='Registrar Items!!';$class2='TRed';$tieneitemsflag=0;
			$query="SELECT count(Id) as Cant FROM stockmov_items Where IdMov=".$row['Id']." LIMIT 1";
			$rs10=mysql_query($query,$conn);$row10=mysql_fetch_array($rs10);
			if(mysql_num_rows($rs10)!=0){
				if($row10['Cant']>0){$tieneitems='Tiene '.$row10['Cant'].' Items';$class2='';$tieneitemsflag=1;}
			}			
			mysql_free_result($rs10);
			//
			$tablaclientes .='<tr '.$estilo.GLO_highlight($row['Id']).'>'; 
			$tablaclientes .="<td class="."TableShowD".$link." > ".FormatoFecha($row['Fecha'])."</td>";
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['TipoM'],0,14)."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Origen'],0,9)."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>";  
			$tablaclientes .="<td class="."TableShowD".$link."> ".substr($row['Deposito'],0,30)."</td>"; 
			$tablaclientes .="<td class="."TableShowD".$link."> ".$compr."</td>"; 
			$tablaclientes .='<td class="TableShowD '.$class2.'"'.$link."> ".$tieneitems."</td>"; 
			$tablaclientes .='<td class="TableShowD TAC">';
			//si no tiene items elimina
			if($tieneitemsflag==0 ){
				$tablaclientes .=GLO_rowbutton("CmdBorrarFilaRto",$row['Id'],"Eliminar",'self','trash','iconlgray','Eliminar',1,0,0);
			}
			$tablaclientes .="</td></tr>";  
		}	
		$tablaclientes .="</table>";echo $tablaclientes;	
	}mysql_free_result($rs);
}


GLOF_Init('','BannerConMenuHV','zModificarP',0,'MenuH',1,0,0); 
GLO_tituloypath(0,750,'InboxP.php','PEDIDO LOGISTICA','linksalir');

$esdespacho=3;//es planta
include("../Despacho/Includes/zCampos.php"); 

//pasos
echo '<table width="800" border="0"  cellspacing="0" class="TMT10"><tr> <td class="comentario">1. Acepte el Pedido<br>2. Seleccione el Deposito y genere el movimiento requerido<br>3. Complete los Remitos generados<br>4. Finalice el Pedido</td></tr></table>';


//si aceptado agrego remitos
//formulado
GLO_Ancla('A3');
if( DES_estipoplanta(intval($_SESSION['CbTipo']),2)==1){//formulado(2)
	echo '<table width="800" border="0"  cellspacing="0" class="TablaBuscar" > 
	<tr> <td width="100" height="3"></td> <td width="120"></td><td width="140"></td><td width="250"></td><td width="190"></td></tr>';
	//
	echo '<tr> <td height="18"  align="right" class="TRed">Deposito Egreso:</td><td>&nbsp;<select name="CbDep" class="campos" id="CbDep"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option>';echo ComboTablaRFX("depositos","CbDep","Nombre","","and Tipo=1",$conn);	echo '</select></td>';
	echo '<td align="right">Propietario producto:</td><td>&nbsp;<select name="CbPropietarioEF" class="campos" id="CbPropietarioEF"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option>';GLO_ComboActivo("clientes","CbPropietarioEF","Interno,Nombre","","",$conn); echo '</select></td>';
	echo '<td align="center">'.GLO_FAButton("CmdAltaRtoEIF",'submit','160','self','Movimientos Formulado','add','boton03').'</td></tr>';
	//
	echo '<tr> <td height="18" align="right"  class="TGreen">Deposito Ingreso:</td><td>&nbsp;<select name="CbDep2" class="campos" id="CbDep2"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option>';echo ComboTablaRFX("depositos","CbDep2","Nombre","","and Tipo=1",$conn);	echo '</select></td>';
	echo '<td align="right">Propietario producto:</td><td>&nbsp;<select name="CbPropietarioIF" class="campos" id="CbPropietarioIF"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option>';GLO_ComboActivo("clientes","CbPropietarioIF","Interno,Nombre","","",$conn); echo '</select></td><td></td></tr>';
	echo '</table>';
}

//carga
if( DES_estipoplanta(intval($_SESSION['CbTipo']),1)==1){//carga(1)
	echo '<table width="800" border="0"  cellspacing="0" class="TablaBuscar TMT10" > 
	<tr> <td width="100" height="3"></td> <td width="120"></td><td width="140"></td><td width="250"></td><td width="190"></td></tr>';
	echo '<tr> <td height="18"  align="right" class="TRed">Deposito Egreso:</td><td>&nbsp;<select name="CbDep3" class="campos" id="CbDep3"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option>';echo ComboTablaRFX("depositos","CbDep3","Nombre","","and Tipo=1",$conn);	echo '</select></td>';
	echo '<td align="right">Propietario producto:</td><td>&nbsp;<select name="CbPropietarioEC" class="campos" id="CbPropietarioEC"  style="width:200px" onKeyDown="enterxtab(event)"><option value=""></option>';GLO_ComboActivo("clientes","CbPropietarioEC","Interno,Nombre","","",$conn); echo '</select></td>';
	echo '<td align="center">'.GLO_FAButton("CmdAltaRtoEC",'submit','160','self','Egreso Stock','add','boton05').'</td></tr>';
	echo '</table>';
}
	


GLO_Ancla('A2');DES_TablaItems($_SESSION['TxtNumero'],1,$conn,0);
include("../Despacho/Includes/zCamposTablas.php"); 

//ver remitos
echo '<table width="800" border="0" cellspacing="0" cellpadding="0" ><tr><td>';
TablaRemitos($_SESSION['TxtNumero'],$conn);
echo '</td></tr></table>';


mysql_close($conn);
GLO_cierratablaform();

GLO_initcomment(0,0);
echo 'Puede grabar <font class="comentario2">Observaciones</font> del <font class="comentario3">Pedido</font><br>';
echo 'Permite agregar <font class="comentario2">Remitos</font>, si el Pedido esta <font class="comentario3">Aceptado</font><br>';
echo 'Muestra el <font class="comentario2">Total</font> de productos si la <font class="comentario3">Unidad de Medida</font> coincide<br>';
GLO_endcomment();


include ("../Codigo/FooterConUsuario.php");
?>