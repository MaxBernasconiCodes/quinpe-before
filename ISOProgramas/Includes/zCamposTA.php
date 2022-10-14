<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

GLO_tituloypath(0,700,'','PROGRAMACION','salir'); 
?>

<table width="700" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="600"></td></tr>
<?
switch (intval($_SESSION['CbTipoE'])) {
case 1:	//clientes
	echo '<tr><td height="18"  align="right"  >Cliente:</td><td  valign="top" >&nbsp;<select name="CbCliente" style="width:400px" class="campos" id="CbCliente" ><option value=""></option>';GLO_ComboActivo("clientes","CbCliente","Nombre","","",$conn); echo '</select><label class="MuestraError"> * </label></td></tr>';
	break;
case 2:	//unidades
	echo '<tr><td height="18"  align="right"  >Unidad:</td><td  valign="top" >&nbsp;<select name="CbUnidad" style="width:400px" class="campos" id="CbUnidad" ><option value=""></option>';GLO_ComboActivo("unidades","CbUnidad","Nombre","","",$conn); echo '</select><label class="MuestraError"> * </label></td></tr>';
	break;
case 4:	//personal
	echo '<tr><td height="18"  align="right"  >Personal:</td><td  valign="top" >&nbsp;<select name="CbPersonal" style="width:400px" class="campos" id="CbPersonal" ><option value=""></option>';ComboPersonalRFX('CbPersonal',$conn); echo '</select><label class="MuestraError"> * </label></td></tr>';
	break;
case 5:	//servicios
	echo '<tr><td height="18"  align="right"  >Servicio:</td><td  valign="top" >&nbsp;<select name="CbServicio" style="width:400px" class="campos" id="CbServicio" ><option value=""></option>';GLO_ComboActivo("servicios","CbServicio","Nombre","","",$conn); echo '</select><label class="MuestraError"> * </label></td></tr>';
	break;
case 6:	//otros
	echo '<tr><td height="18"  align="right"  >Actividad:</td><td  valign="top" >&nbsp;<input name="TxtNombre" type="text" class="TextBox" style="width:550px" maxlength="100"  value="'.$_SESSION['TxtNombre'].'" ><label class="MuestraError"> * </label></td></tr>';
	break;
}
?>
<tr><td height="18"  align="right"  >Detalle 1:</td><td  valign="top" >&nbsp;<input name="TxtObs2" type="text" class="TextBox" style="width:550px" maxlength="100"  value="<? echo $_SESSION['TxtObs2']; ?>" ></td></tr>
<tr><td height="18"  align="right"  >Detalle 2:</td><td  valign="top" >&nbsp;<input name="TxtObs3" type="text" class="TextBox" style="width:550px" maxlength="100"  value="<? echo $_SESSION['TxtObs3']; ?>" ></td></tr>

</table>


<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('CbTipoE',0);
GLO_obsform(700,100,'Observaciones','TxtObs',6,0);
GLO_botonesform("700",0,2); 
GLO_mensajeerror();
?>