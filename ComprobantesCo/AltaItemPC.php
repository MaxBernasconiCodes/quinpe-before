<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');include("Includes/zFunciones.php");
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['Id'],0,0);

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

$_SESSION['TxtNroEntidad']=$_GET['Id'];//idcotiz
if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -12 month"));$_SESSION['TxtFechaH']=$hoy;
}
if (empty($_SESSION['TxtQCOPCIT'])){// trae por defecto filtro fecha
	$idcompr=intval($_SESSION['TxtNroEntidad']);
	if (!(empty($_SESSION['TxtFechaD']))){$wfechad="and DATEDIFF(np.Fecha,'".FechaMySql($_SESSION['TxtFechaD'])."')>=0";}else{$wfechad="";}
	if (!(empty($_SESSION['TxtFechaH']))){$wfechah="and DATEDIFF(np.Fecha,'".FechaMySql($_SESSION['TxtFechaH'])."')<=0";}else{$wfechah="";}
	//
	$_SESSION['TxtQCOPCIT']="SELECT np.*,npi.Id as IdItemNP,npi.Cant as CantItem,npi.CantAuto as CantAutoItem,npi.Obs as ObsItem,npi.INC,e.Nombre as Estado, a.Id as IdArticuloItem,a.Nombre as Articulo,um.Abr,p.Apellido as Prov,u.Nombre as Unidad,u.Dominio,p1.Nombre as NomS,p1.Apellido as ApeS,p3.Nombre as NomD,p3.Apellido as ApeD,sm.Nombre as SectorM,itr.Nombre as Equipo,il.Nombre as Prod,il.Id as IdProd,u2.Abr as Abr2 From co_npedido np,co_npedido_it npi,co_npedido_est e,epparticulos a,unidadesmedida um,proveedores p,unidades u,personal p1,personal p3,sectorm sm,epparticulos itr,items il,unidadesmedida u2 Where np.Id=npi.IdNP and e.Id=npi.IdEstado and npi.IdArticulo=a.Id and a.IdUnidad=um.Id and np.IdUnidad=u.Id and npi.IdProv=p.Id and np.IdPerSoli=p1.Id and np.IdPersonal=p3.Id and np.IdSectorM=sm.Id and np.IdInstr=itr.Id and npi.IdEstado=8 and npi.IdItem=il.Id and il.IdUnidad=u2.Id and (npi.NroOC='0' or npi.NroOC='') $wfechad $wfechah and npi.Id NOT IN(Select IdItemNP From co_pcotiz_it Where IdPCotiz=$idcompr)  Order by u.Nombre,p3.Apellido,np.Id LIMIT 2000";
}


function MostrarTabla($conn){//
$idcompr=$_SESSION['TxtNroEntidad'];$estcompr=0;
//busco datos cotiz
$query="SELECT IdEstado From co_pcotiz where Id<>0 and  Id=$idcompr";$rs=mysql_query($query,$conn);$row=mysql_fetch_array($rs);
if(mysql_num_rows($rs)!=0){ $estcompr=$row['IdEstado'];}mysql_free_result($rs);
//solo muestra pedidos en estado revisado(8), y si la cotiz tiene estado 0
//pedidos internos que no se hayan agregado a este pedido de cotizacion y a ninguna oc(excepto RECH3-ANUL6)
if ($estcompr==0){
	$query=$_SESSION['TxtQCOPCIT'];$query=str_replace("\\", "", $query); 
	if ( ($query!="")){		
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){
			$tablaclientes='';
			if(mysql_num_rows($rs)==2000){$tablaclientes= '<p class="MuestraError" align="center">La consulta permite mostrar hasta 2000 registros</p>';}
			//guardar		
			$tablaclientes .=GLO_inittabla(1160,0,0,0);
			$tablaclientes .="<td "."height="."3"."></td></tr><tr><td class="."recuento".">Seleccione el Item y luego grabe. </td><td align="."right".">".GLO_FAButton('CmdGuardar','submit','90','self','Agregar','save','boton02')."</td></tr><tr><td "."height="."3"."></td></tr></table>";
			//Titulos de la tabla
			$tablaclientes .='<table width="1160" class="TableShow" id="tshow"><tr>';
			$tablaclientes .='<td width="70" class="TableShowT"> Fecha</td>';   
			$tablaclientes .='<td width="60" class="TableShowT TAR"> Pedido</td>';   
			$tablaclientes .='<td width="100" class="TableShowT"> Destino</td>';  
			$tablaclientes .='<td width="60" class="TableShowT TAR"> Cant</td>'; 
			$tablaclientes .='<td width="30" class="TableShowT"> </td>'; 
			$tablaclientes .='<td width="340" class="TableShowT"> Art&iacute;culo o Producto</td>';   
			$tablaclientes .='<td width="200" class="TableShowT"> Obs.Item</td>'; 
			$tablaclientes .='<td width="100" class="TableShowT"> Proveedor</td>'; 
			$tablaclientes .='<td width="100" class="TableShowT"> Solicitante</td>'; 
			$tablaclientes .='<td width="100" class="TableShowT"> </td>'; 
			$tablaclientes .='<td width="30" class="TableShowT TAC"><input type="checkbox" name="ChkAll" onclick="CheckMasivoColor();"></td>'; 
			$tablaclientes .='</tr>';             
			$recuento=0;  
			while($row=mysql_fetch_array($rs)){ 
				$idNP=$row['Id'];$idItemNP=$row['IdItemNP'];
				include("Includes/zDestinoNP.php");
				//cotizado
				$listacotiz=CO_BuscarCOTIZ_T($row['IdItemNP'],$conn);
				if($listacotiz==''){
					$cotizado='';$botoncotiz='';
				}else{
					$botoncotiz='<button name="CmdVC" type="button"  class="iconbtn"  value=""  onclick="alert('."'".$listacotiz."'".');">'.GLO_IconSearch().'</button>';
					$cotizado='COTIZADO '.$botoncotiz;
				}
				//articulo,producto u observaciones
				$claseart="";
				if($row['IdArticuloItem']>0){
					$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
				}else{
					if($row['IdProd']>0){
						$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
					}else{$claseart=" TRed ";$textoart=$row['ObsItem'];$abr='';}	
				}
				//
				if(($_SESSION['ChkActivo']==1 and $cotizado=='') or $_SESSION['ChkActivo']!=1){
					$tablaclientes .='<tr id="'.$row['IdItemNP'].'" >'; 
					$tablaclientes .='<td class="TableShowD">'.FormatoFecha($row['Fecha']).'</td>'; 
					$tablaclientes .='<td class="TableShowD TAR">'.str_pad($row['Id'], 6, "0", STR_PAD_LEFT).'</td>'; 
					$tablaclientes .='<td class="TableShowD">'.substr($destino,0,12).'</td>'; 
					$tablaclientes .='<td class="TableShowD TAR">'.$row['CantAutoItem'].'</td>'; 
					$tablaclientes .='<td class="TableShowD">'.substr($abr,0,5).'</td>'; 
					$tablaclientes .='<td class="TableShowD'.$claseart.'" title="'.$textoart.'">'.substr($textoart,0,38).'</td>'; 
					$tablaclientes .='<td class="TableShowD" title="'.$row['ObsItem'].'">'.substr($row['ObsItem'],0,24).'</td>'; 
					$tablaclientes .='<td class="TableShowD">'.substr($row['Prov'],0,12).'</td>';  
					$tablaclientes .='<td class="TableShowD">'.substr($row['ApeS'].' '.$row['NomS'],0,12).'</td>'; 
					$tablaclientes .='<td class="TableShowD TRed">'.$cotizado.'</td>'; 
					$tablaclientes .='<td class="TableShowD TAC">'; 
					//solo adjunta si tiene articulo
					if($row['IdArticuloItem']>0 or $row['IdProd']>0){
						$tablaclientes .='<input type="checkbox" name="campos['.$idNP.'|'.$idItemNP.']" unchecked value=0 onclick="if (this.checked==1) {this.value=1;}else{this.value=0;};" onChange="CheckRow('.$row['IdItemNP'].',this.value);">'; 
					}
					$tablaclientes .='</td></tr>';
					$recuento=$recuento+1;
				}
			}
			$tablaclientes .=GLO_fintabla(0,0,$recuento);
			echo $tablaclientes;	
		}mysql_free_result($rs);	
	}
}else{echo '<p class="MuestraError" align="center">No es posible agregar Pedidos si la Cotizaci&oacute;n ya fue Enviada.</p>';}
}


//html
GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUpMH','zAltaItemPC',0,0,0,0); 
GLO_tituloypath(0,700,"ModificarCotizacion.php?id=".intval($_SESSION['TxtNroEntidad'])."&Flag1=True",'PEDIDOS','linksalir');
?>
<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr> <td height="5" width="70"></td><td width="100"></td><td width="120"></td><td width="70"></td><td width="100"></td><td width="80"></td><td width="120"></td><td width="30"></td></tr>
<tr> <td height="18"  align="right">Alta:</td><td>&nbsp;<? GLO_calendario("TxtFechaD","../Codigo/","actual",1) ?></td> <td> al&nbsp;<? GLO_calendario("TxtFechaH","../Codigo/","actual",1) ?></td><td align="right">Art&iacute;culo:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:80px" maxlength="30" onKeyDown="enterxtab(event)"></td>	<td  align="right">Pedido:</td><td>&nbsp;<input  name="TxtNroPedido" type="text"  class="TextBox"  align="right"   value="<? echo $_SESSION['TxtNroPedido'];?>" onChange="this.value=validarEntero(this.value);" style="text-align:right;width:60px"></td><td></td></tr>
<tr> <td height="18"  align="right">Solicitante:</td><td colspan="2">&nbsp;<select name="CbSoli" class="campos" id="CbSoli"  style="width:175px" onKeyDown="enterxtab(event)"><option value=""></option><? CO_PersonalSoliNP($conn); ?></select></td><td  align="right">Proveedor:</td><td>&nbsp;<select name="CbProv" class="campos" id="CbProv"  style="width:80px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboProveedorRFX("CbProv","",$conn); ?></select></td>	<td  align="right"></td><td><input name="ChkActivo"  type="checkbox"  value="1" <? if ($_SESSION['ChkActivo'] =='1') echo 'checked'; ?>> Sin Cotizar</td><td align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td></tr>
</table>

<?
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtId',0);GLO_Hidden('TxtQCOPCIT',0);
MostrarTabla($conn);
GLO_mensajeerror(); 
mysql_close($conn); 
GLO_cierratablaform();

GLO_initcomment(1160,0);
echo 'Los <font class="comentario2">Pedidos</font> deben estar en estado <font class="comentario3">Comprar</font> y la Cotizaci&oacute;n sin <font class="comentario2">Enviar</font><br>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>