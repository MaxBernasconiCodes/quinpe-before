<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";require_once('../Codigo/calendar/classes/tc_calendar.php');
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=12){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);
$_SESSION['TxtNroEntidad']=$_GET['Id'];

if (empty($_SESSION['TxtFechaD'])){
	$hoy=date("d-m-Y"); list($d,$m,$a)=explode("-",$hoy);$primerdiames="01-".$m."-".$a;
	$_SESSION['TxtFechaD']=date("d-m-Y", strtotime("$primerdiames -12 month"));$_SESSION['TxtFechaH']=$hoy;
}

function MostrarTabla($conn){
	$query=$_SESSION['TxtQSTREIT'];$query=str_replace("\\", "", $query); 
	if ( $query!=""){	
		$rs=mysql_query($query,$conn);
		if(mysql_num_rows($rs)!=0){
			//informo LIMIT
			if(mysql_num_rows($rs)==2000){echo '<p class="MuestraError" align="center">La consulta permite mostrar hasta 2000 registros</p>';}
			//marco 			
			echo '<table width="1130"><tr><td>';	
			//guardar		
			echo '<table width="1130"><tr><td class="comentario">Seleccione el Item y luego grabe</td><td align="right">'.GLO_FAButton('CmdGuardar','submit','90','self','Agregar','save','boton02').'</td></tr></table>';
			//Titulos de la tabla
			echo '<table width="1130" class="TableShow" id="tshow"><tr>
			<td width="70" class="TableShowT"> Fecha</td>   
			<td width="50" class="TableShowT TAR"> OC</td>   
			<td width="55" class="TableShowT TAR"> Pedido</td>   
			<td width="100" class="TableShowT"> Destino</td>  
			<td width="370" class="TableShowT"> Art&iacute;culo o Producto</td> 
			<td width="200" class="TableShowT"> Obs.Item Pedido</td>   
			<td width="120" class="TableShowT"> Proveedor</td> 
			<td width="60" class="TableShowT" >Modifica Stock</td> 
			<td width="70" class="TableShowT TAC"> Cantidad</td> 	
			<td width="30" class="TableShowT"> </td> 
			<td width="30" class="TableShowT TAC"><input type="checkbox" name="ChkAll" onclick="CheckMasivoColor();"></td> 
			</tr>';             
			$recuento=0;  
			while($row=mysql_fetch_array($rs)){ 
				//articulo,producto u observaciones
				if($row['IdArticuloItem']>0){
					$textoart=str_pad($row['IdArticuloItem'], 6, "0", STR_PAD_LEFT).' '.$row['Articulo'];$abr=$row['Abr'];
				}else{
					$textoart=str_pad($row['IdProd'], 6, "0", STR_PAD_LEFT).' '.$row['Prod'];$abr=$row['Abr2'];
				}

				include("../ComprobantesCo/Includes/zDestinoNP.php");
				if($row['FS']==0){$fs='';}else{$fs='Modifica';}
				echo '<tr id="'.$row['IdItemNP'].'" > 
				<td class="TableShowD">'.FormatoFecha($row['Fecha']).'</td> 
				<td class="TableShowD TAR">'.$row['NroOC'].'</td> 
				<td class="TableShowD TAR">'.str_pad($row['IdNP'], 8, "0", STR_PAD_LEFT).'</td> 
				<td class="TableShowD">'.substr($destino,0,12).'</td> 
				<td class="TableShowD" title="'.$textoart.'">'.substr($textoart,0,45).'</td> 
				<td class="TableShowD" title="'.$row['ObsItem'].'">'.substr($row['ObsItem'],0,24).'</td> 
				<td class="TableShowD">'.substr($row['Prov'],0,15).'</td>  
				<td class="TableShowD TRed">'.$fs.'</td>
				<td class="TableShowD TAC">'.'<input  name="TxtCant['.$row['IdItemNP'].']"  type="text"  class="TextBox"  maxlength="7"  value="'.$row['CantAutoItem'].'" onChange="this.value=validarNumeroP(this.value);" style="text-align:right;width:50px">'.'</td> 
				<td class="TableShowD">'.substr($abr,0,5).'</td> 
				<td class="TableShowD TAC"><input type="checkbox" name="campos['.$row['IdNP'].'|'.$row['IdItemNP'].'|'.$row['IdArticuloItem'].'|'.$row['IdProd'].']" unchecked value=0 onclick="if (this.checked==1) {this.value=1;}else{this.value=0;}" onChange="CheckRow('.$row['IdItemNP'].',this.value);"></td> 
				</tr>';
				$recuento=$recuento+1;
			}
			//fin marco
			echo '</table><p class="comentario" align="right">'.$recuento.' registros</p></td></tr></table>';
		}mysql_free_result($rs);	
	}
}




GLO_InitHTML($_SESSION["NivelArbol"],'','BannerPopUpMH','zAltaItemRE',0,0,0,0);
GLO_tituloypath(0,700,"Modificar.php?id=".intval($_SESSION['TxtNroEntidad'])."&Flag1=True",'AGREGAR ITEMS OC A MOV EGRESO','linksalir');
include("Includes/zFiltrosItems.php");
GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtQSTREIT',0);
GLO_mensajeerror();
MostrarTabla($conn);
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(1130,0);
echo 'Solo mostrar&aacute; <font class="comentario3">Items de OC </font> que no se hayan asociado a ning&uacute;n Remito o Ajuste <font class="comentario2">Egreso</font>';
GLO_endcomment();
include ("../Codigo/FooterConUsuario.php");
?>