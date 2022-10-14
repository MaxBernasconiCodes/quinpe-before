<? 
//seguridad includes
if(!isset($_SESSION)){include("../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



?>

<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >







                  

<table  border="0"  cellpadding="0" cellspacing="0"><tr> <td height="3"></td></tr></table>	





<!-- datos obs -->

<table width="730" border="0"   cellspacing="0" class="Tabla" >

<tr><td height="3"  width="190"></td><td width="350"></td><td width="190"></td></tr>

<tr> <td></td> <td height="19"  align="center" valign="middle" ><? if(intval($_SESSION['TxtIdOrden'])==0  and (intval($_SESSION['CbEstado'])==0 or intval($_SESSION['CbEstado'])==1 )){echo '<input name="CmdAceptar" type="submit" class="boton" tabindex="4"  value="Guardar" onClick="document.Formulario.target='."'_self'".'"> &nbsp; &nbsp;';} ?> <input  name="TxtId"   type="hidden"   value="<? echo $_SESSION['TxtId']; ?>"><input  name="TxtOriPage"   type="hidden"   value="<? echo $_SESSION['TxtOriPage']; ?>"></td> <td align="right">

<? 

//si es pagina modifica, no tiene orden asociada y el estado es solicitado

if ( (intval($_SESSION['TxtNumero'])!=0) and (intval($_SESSION['TxtIdOrden'])==0) and (intval($_SESSION['CbEstado'])==1) ){ 

	echo '<input name="CmdAltaOrden" type="submit" class="boton02" value="Alta Orden" onClick="document.Formulario.target='."'_self'".'">&nbsp;<input name="CmdRechazar" type="submit" class="boton02" value="Rechazar" onClick="document.Formulario.target='."'_self'".'">&nbsp;'; 

} 

//sacar rechazado

if ( (intval($_SESSION['TxtNumero'])!=0) and (intval($_SESSION['CbEstado'])==2) ){ 

	echo '<input name="CmdRestablecer" type="submit" class="boton02" value="Restablecer" onClick="document.Formulario.target='."'_self'".'">&nbsp;'; 

} 



?>

</td> </tr>

</table>







