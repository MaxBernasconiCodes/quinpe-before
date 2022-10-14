<? include("../Codigo/Seguridad.php");include("../Codigo/Config.php");include("../Codigo/Funciones.php");$_SESSION["NivelArbol"]="../";

//perfiles
include("../Perfiles/Permisos/p1.php");



$conn=mysql_connect($server,$dbuser,$dbpass);mysql_select_db($database);



function MostrarTabla($conn){

$query=$_SESSION[TxtQuery];$query=str_replace("\\", "", $query);

if (  ($query!="")){	

	$rs=mysql_query($query,$conn);

	if(mysql_num_rows($rs)!=0){	

		//Titulos de la tabla

		$tablaclientes='';

		$tablaclientes .="<table width="."950"." border="."0"." cellspacing="."0"." cellpadding="."0"." ><tr>";

		$tablaclientes .='<td class="TablaTituloLeft"></td>';

		$tablaclientes .="<td "."width="."50"." class="."TablaTituloDato"."> Legajo</td>";   

		$tablaclientes .='<td class="TablaTituloLeft"></td>';

		$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato"."> Apellido</td>";   

		$tablaclientes .='<td class="TablaTituloLeft"></td>';

		$tablaclientes .="<td "."width="."140"." class="."TablaTituloDato"."> Nombre</td>";   

		$tablaclientes .='<td class="TablaTituloLeft"></td>';  

		$tablaclientes .="<td "."width="."70"." class="."TablaTituloDato"."> Documento</td>"; 

		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

		$tablaclientes .="<td "."width="."80"." class="."TablaTituloDato"."> CUIT/CUIL</td>"; 

		$tablaclientes .='<td class="TablaTituloLeft"></td>'; 

		$tablaclientes .="<td "."width="."130"." class="."TablaTituloDato"."> Razon Social</td>"; 

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

			$tablaclientes .="<td class=".$clase.$link." style='text-align:right;'> ".str_pad($row['Legajo'], 6, "0", STR_PAD_LEFT)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Apellido'],0,12)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Nombre'],0,12)."</td>";  

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';  

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Documento'],0,14)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>'; 

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['Identificacion'],0,14)."</td>"; 

			$tablaclientes .='<td class="TablaMostrarLeft"></td>';    

			$tablaclientes .="<td class=".$clase.$link."> ".substr($row['RazonSocial'],0,20)."</td>"; 

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

		//Cerrar tabla

		$tablaclientes .="</table>"; 

		$tablaclientes .="<p class="."recuento"." align="."right"."> $recuento registros</p>"; 

		$tablaclientes .='<table align="right" ><tr> <td></td></tr><tr><td><input name="CmdExcel"  type="submit" class="botonexcel"  value="" ></td></tr></table>';

		echo $tablaclientes;	

	}else{echo '<p class="MuestraConf" align="center">No existen datos que cumplan esos criterios</p>';}

	mysql_free_result($rs);

}

}



GLOF_Init('TxtBusqueda','BannerConMenuHV','zClientes',0,'MenuH',0,0,0); 

GLO_tituloypath(960,890,'../Personal.php','HABILITACION EN CLIENTES','linksalir'); 

?>





<table width="890" border="0"  cellspacing="0" class="Tabla" >

<tr><td  height=3 width="70" ></td><td width="190"></td><td width="90"></td><td width="190"></td><td width="70"></td><td width="190"></td><td width="90"></td></tr>

<tr><td  align="right" >Personal:</td><td >&nbsp;<input name="TxtBusqueda" type="text" class="TextBox" style="width:160px" maxlength="20" onKeyDown="enterxtab(event)"> </td><td  align="right" >Raz&oacute;n Social:</td><td>&nbsp;<select name="CbRS" class="campos" id="CbRS"  style="width:160px" onkeydown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("parametrosrs","CbRS","Nombre","","",$conn); ?></select></td><td  align="right" >Cliente:</td><td>&nbsp;<select name="CbCliente" style="width:160px" class="campos" id="CbCliente"  tabindex="1"><option value=""></option> <? ComboTablaRFXActivo("clientes","CbCliente","Nombre","","",$conn); ?> </select></td>

<td><input name="ChkActivo"  type="checkbox"  value="1" <? if ($_SESSION[ChkActivo] =='1') echo 'checked'; ?>> Activos</td></tr>

<tr><td  align="right" >Servicio:</td><td>&nbsp;<select name="CbServicio" class="campos" id="CbServicio"  style="width:160px" onKeyDown="enterxtab(event)"><option value=""></option><? CompletarComboServicioRFX("CbServicio",$conn);  ?></select><td  align="right" >Sector:</td><td>&nbsp;<select name="CbSector" class="campos" id="CbSector"  style="width:160px" onkeydown="enterxtab(event)">

<option value=""></option><? ComboTablaRFX("sector","CbSector","Nombre","","",$conn); ?></select></td><td  align="right" >Funci&oacute;n:</td>

<td>&nbsp;<select name="CbFuncion" class="campos" id="CbFuncion"  style="width:160px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("funcion","CbFuncion","Nombre","","",$conn); ?></select> </td><td  align="right"><input name="CmdBuscar"  type="submit" class="botonbuscar"  title="Buscar" value="" onClick="document.Formulario.target='_self'">&nbsp;</td>	</tr>

</table>







<table  width="840" border="0" cellspacing="0" cellpadding="0" >

<tr><td  height=3 ></td></tr>

<tr  valign="bottom"><td align="left" valign="bottom" ><input  name="TxtQuery"  type="hidden"   value="<? echo $_SESSION[TxtQuery]; ?>"></td>	</tr>

</table>



<? GLO_mensajeerror(); ?>





<table  width="950" border="0" cellspacing="0" cellpadding="0" >

<tr valign="top"> 	<td  align="center" valign="top" > 	<?php MostrarTabla($conn); ?>	</td>	</tr>

</table>



<? GLO_cierratablaform(); ?>



<? mysql_close($conn); ?>

<? $_SESSION[TxtId]="";

$_SESSION[CbServicio]="";

$_SESSION[CbSector]="";

$_SESSION[CbFuncion]="";

$_SESSION[CbRS]="";

$_SESSION['CbOrden']="";

$_SESSION['ChkActivo']="";

$_SESSION['CbCliente']="";

$_SESSION['TxtQuery']="";

?>

		







<? include ("../Codigo/FooterConUsuario.php");?>