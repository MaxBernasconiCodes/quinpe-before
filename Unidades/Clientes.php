<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=13){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



function MostrarTabla($conn){

$query=$_SESSION[TxtQuery];$query=str_replace("\\", "", $query);

if (  ($query!="")){	

	$rs=mysql_query($query,$conn);

	if(mysql_num_rows($rs)!=0){	

		//Titulos de la tabla

		$tablaclientes='';

		$tablaclientes .=GLO_inittabla(950,0,0,0);

		$tablaclientes .='<td class="TablaTituloLeft"></td>';

		$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> N&uacute;mero</td>";   

		$tablaclientes .='<td class="TablaTituloLeft"></td>';

		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Nombre</td>";   

		$tablaclientes .='<td class="TablaTituloLeft"></td>';

		$tablaclientes .="<td "."width="."100"." class="."TablaTituloDato"."> Dominio</td>";   

		$tablaclientes .='<td class="TablaTituloLeft"></td>';  

		$tablaclientes .="<td "."width="."110"." class="."TablaTituloDato"."> Sector</td>"; 

		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

		$tablaclientes .="<td "."width="."120"." class="."TablaTituloDato"."> Servicio</td>"; 

		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

		$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato"."> Marca</td>"; 

		$tablaclientes .='<td class="TablaTituloLeft"></td>';

		$tablaclientes .="<td "."width="."200"." class="."TablaTituloDato"."> Cliente</td>";   

		$tablaclientes .='<td class="TablaTituloLeft"></td>';

		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Alta Habil</td>";  

		$tablaclientes .='<td class="TablaTituloLeft"></td>';

		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato".">Baja Habil</td>";   

		$tablaclientes .='<td class="TablaTituloRight"></td>';  

		$tablaclientes .='</tr>';    

		$recuento=0;          

		$estilo="";$link="";

		while($row=mysql_fetch_array($rs)){ 			

			$faltah = FormatoFecha($row['FechaA']);if ($faltah=='00-00-0000'){$faltah="";}

			$fbajah= FormatoFecha($row['FechaB']);if ($fbajah=='00-00-0000'){$fbajah="";}

			$fbaja= FormatoFecha($row['FechaBaja']);if ($fbaja=='00-00-0000'){$fbaja="";}

			if ($fbaja=='' or (strtotime(date("d-m-Y"))-strtotime($fbaja))<0){$clase="TablaDato";}else{$clase="TablaDatoR2";}	

			//muestro

			$tablaclientes .='<tr '.$estilo.'>';  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Id'], 6, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,12)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Dominio'],0,12)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Sector'],0,12)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Servicio'],0,12)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Marca'],0,12)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".str_pad($row['IdCliente'], 6, "0", STR_PAD_LEFT).' '.substr($row['Cliente'],0,15)."</td>";  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".$faltah."</td>";  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".$fbajah."</td>";  

			$tablaclientes .='<td class="TablaMostrarRight"></td>';  

			$tablaclientes .='</tr>'; 

			$recuento=$recuento+1;

		}	

		$tablaclientes .=GLO_fintabla(1,0,$recuento);

		echo $tablaclientes;	

	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}

	mysql_free_result($rs);

}

}



GLOF_Init('','BannerConMenuHV','zClientes',0,'MenuH',0,0,0); 

GLO_tituloypath(0,700,'../Unidades.php','HABILITACION EN CLIENTES','linksalir'); 

?>







<table width="700" border="0"   cellspacing="0" class="Tabla" >

<tr><td  height=3 width="80" ></td><td width="120"></td><td width="80"></td><td width="120"></td><td width="80"></td><td width="120"></td><td width="100"></td></tr>

<tr><td  align="right" >Nombre:</td><td >&nbsp;<input name="TxtBusquedaN" type="text" class="TextBox" style="width:100px" maxlength="20" onKeyDown="enterxtab(event)"> </td><td  align="right" >Dominio:</td><td>&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:100px" maxlength="20" onKeyDown="enterxtab(event)"></td><td  align="right" >Cliente:</td><td>&nbsp;<select name="CbCliente" style="width:100px" class="campos" id="CbCliente"  tabindex="1"><option value=""></option> <? GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); ?> </select></td><td><input name="ChkActivo"  type="checkbox"  class="check" value="1" <? if ($_SESSION[ChkActivo] =='1') echo 'checked'; ?>> Activos</td></tr>

<tr><td  align="right" >Servicio:</td><td>&nbsp;<select name="CbServ" class="campos" id="CbServ"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? CompletarComboServicioRFX("CbServ",$conn);  ?></select><td  align="right" >Sector:</td><td>&nbsp;<select name="CbSec" class="campos" id="CbSec"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("sector","CbSec","Nombre","","",$conn); ?></select></td><td  align="right" >Marca:</td><td>&nbsp;<select name="CbMarca" class="campos" id="CbMarca"  style="width:100px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("unidadesmarcas","CbMarca","Nombre","","",$conn); ?></select> </td><td  align="right"><? GLO_Search('CmdBuscar',0); ?>&nbsp;</td>	</tr>

</table>





<? 

GLO_mensajeerror();

GLO_Hidden('TxtQuery',0);

MostrarTabla($conn);

GLO_cierratablaform(); 

mysql_close($conn);

include ("../Codigo/FooterConUsuario.php");

?>