<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ;include("../Codigo/Funciones.php") ;$_SESSION["NivelArbol"]="../";include("../Procesos/Includes/zFunciones.php") ;include("Includes/zFunciones.php") ;
//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
//get
GLO_ValidaGET($_GET['id'],0,0); 

$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);

function MostrarTabla($idcam,$conn){
	//validaciones inbox planta
	$wbuscar='';
	$wbuscar=$wbuscar.PLA_whereinbox();
	//
	$query="Select a.*,cli.Nombre as Cliente,p.Nombre as Producto,a2.Cant,a2.CantI,u.Abr as Uni,e.Nombre as Env,u2.Abr as Abr2,a2.IdU as UniBar,p.IdUnidad as UniProd From cam a,clientes cli,items p,procesosop_e1_it a2,unidadesmedida u,envases e,unidadesmedida u2 Where a.Id<>0 and a.IdCliente=cli.Id and a.IdProducto=p.Id and a2.Id=a.IdPE1IT and a2.IdU=u.Id and a2.IdEnv=e.Id and p.IdUnidad=u2.Id $wbuscar and a.Id=$idcam";
	$rs=mysql_query($query,$conn);
	if(mysql_num_rows($rs)!=0){	
		//contenedora
		$tablaclientes='';		
		//cam		
		$tablaclientes .='<table width="1120" class="TableShow" id="tshow"><tr>';
		$tablaclientes .='<td width="50" class="TableShowT TAR">COA</td>';
		$tablaclientes .="<td "."width="."70"." class="."TableShowT"."> Fecha</td>";  
		$tablaclientes .="<td "."width="."100"." class="."TableShowT"."> Cliente</td>";  
		$tablaclientes .="<td "."width="."300"." class="."TableShowT"."> Producto</td>"; 
		$tablaclientes .='<td width="60" class="TableShowT TAR">Cantidad</td>';	
		$tablaclientes .='<td width="60" class="TableShowT TAR">Cantidad en Planta</td>';
		$tablaclientes .='<td width="60" class="TableShowT TAR">Cantidad Pendiente</td>';
		$tablaclientes .='<td width="50" class="TableShowT" > Unidad Barrera</td>'; 	
		$tablaclientes .='<td width="50" class="TableShowT" > Envase</td>'; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Lote</td>"; 
		$tablaclientes .="<td "."width="."100"." class="."TableShowT".">Remito</td>"; 
		$tablaclientes .="<td "."width="."50"." class="."TableShowT".">Factor</td>"; 
		$tablaclientes .='<td width="30" class="TableShowT" > Uni Stock</td>'; 
		$tablaclientes .="<td "."width="."40"." class="."TableShowT"."></td>";   
		$tablaclientes .='</tr>';    
		$clase="TableShowD";
		while($row=mysql_fetch_array($rs)){ 
			//cantidad rojo si es cero
			if($row['Cant']==0){$stylecant='TRed';}else{$stylecant='';}
			$cantpdte=$row['Cant']-$row['CantI'];
			//
			$tablaclientes .='<tr '.GLO_highlight($row['Id']).'>';
			$tablaclientes .='<td class="TableShowD TAR"'.'>'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.'>'.GLO_FormatoFecha($row['Fecha'])."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.'>'.substr($row['Cliente'],0,12)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.'>'.substr($row['Producto'],0,36)."</td>";
			$tablaclientes .='<td class="TableShowD TAR'.$stylecant.'"'.'>'.$row['Cant']."</td>"; 
			$tablaclientes .='<td class="TableShowD TAR'.'"'.'>'.$row['CantI']."</td>"; 
			$tablaclientes .='<td class="TableShowD TAR TBlue'.'"'.'>'.number_format($cantpdte,2, '.', '')."</td>"; 	
			$tablaclientes .='<td  class="TableShowD"'.'>'.substr($row['Uni'],0,6)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.'>'.substr($row['Env'],0,6)."</td>"; 		
			$tablaclientes .='<td  class="TableShowD"'.'>'.substr($row['Lote'],0,15)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.'>'.substr($row['Rto'],0,15)."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.'>';
			//muestra factor si no coinciden las unidades
			if($row['UniBar']!=$row['UniProd']){
				$tablaclientes .='<input name="TxtFactor"  type="text"  style="width:40px" maxlength="5" onChange="this.value=validarNumeroP(this.value);">'; 
			}
			$tablaclientes .='</td>';
			$tablaclientes .='<td  class="TableShowD"'.'>'.substr($row['Abr2'],0,5)."</td>";
			$tablaclientes .='<td class="TableShowD TAR" >';
			if($cantpdte>0){
				$tablaclientes .=GLO_rowbutton("CmdAddFila",$row['Id'],"Alta en Planta",'self','dep','iconlgray','Alta en Planta',1,0,0);
			} 
			$tablaclientes .='</td></tr>'; 
		}	
		$tablaclientes .='</table>';
		$tablaclientes .='<table  width="1120" border="0" cellspacing="0" cellpadding="0" class="TMT10"><tr> <td  height="3" ></td></tr><tr valign="top"> <td valign="top" >';
		//Titulos
		$tablaclientes .='<table width="1120" border="0" cellspacing="0" cellpadding="0" class="TMT10"><tr>';
		$tablaclientes .="<td class="."recuento".">Seleccione los dep&oacute;sitos y cantidades para poder ingresar el producto en Planta </td></td></tr></table>";		
		//depositos
		$tablaclientes .='<table width="350" class="TableShow TMT" id="tshow"><tr>';
		$tablaclientes .='<td width="100" class="TableShowT">Cantidad</td>';	
		$tablaclientes .='<td width="250" class="TableShowT" > Deposito</td>'; 	
		$tablaclientes .='</tr>';    
		$clase="TableShowD";
		for ($i=1; $i<6; $i=$i+1) {
			//depositos
			$combodep=ComboTablaRFXMasivo("depositos",0,"Nombre","","and Tipo=1",$conn);
			$cbdep='<select name="CbDeposito['.$i.']" style="width:230px" class="campos"><option value=""></option>'.$combodep.' </select>';
			//
			$tablaclientes .='<tr>';
			$tablaclientes .='<td  class="TableShowD"'.'>'.'<input name="TxtCant['.$i.']"  type="text"  style="width:80px" maxlength="14" onChange="this.value=validarNumeroP(this.value);">'."</td>"; 
			$tablaclientes .='<td  class="TableShowD"'.'>'.$cbdep."</td>"; 
			$tablaclientes .='</tr>';
		}
		$tablaclientes .='</table></td></tr></table>';
		echo $tablaclientes;	
	}	mysql_free_result($rs);
}

//html
GLOF_Init('','BannerConMenuHV','zInboxD',0,'MenuH',0,0,0); 
GLO_tituloypath(0,1120,'Inbox.php','DIVIDIR MATERIA PRIMA','linksalir');

GLO_Hidden('TxtId',0);
GLO_mensajeerror();
MostrarTabla(intval($_GET['id']),$conn);//pasa idcam
GLO_cierratablaform();
mysql_close($conn); 

GLO_initcomment(0,0);
echo 'Si no coincien las <font class="comentario3">Unidades de medida</font> debe aplicar el <font class="comentario2">Factor</font> de conversion<br>';
GLO_endcomment();

PLA_verimagenplanta();//imagen planta

include ("../Codigo/FooterConUsuario.php");
?>