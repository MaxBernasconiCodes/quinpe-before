<? 

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14  ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,700,'','CERTIFICACION','salir');
?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >

<tr><td width="100" height="3"  ></td> <td width="110"></td> <td width="20"></td><td width="150"></td><td width="90" height="3"  ></td> <td width="230"></td> </tr>

<tr> <td height="18"  align="right"  >Equipo:</td><td  valign="top" colspan="3">&nbsp;<select name="CbInstrumento" style="width:220px"  tabindex="1" class="campos" id="CbInstrumento" ><option value=""></option> <? GLO_ComboEquipos("CbInstrumento",$conn); ?> </select><label class="MuestraError"> * </label></td>

<td height="18"  align="right"  >Certificaci&oacute;n:</td><td  valign="top" >&nbsp;<select name="CbTipoCertif" tabindex="2"  style="width:190px" class="campos" id="CbTipoCertif" ><option value=""></option> <? ComboTablaRFX("instrumentostipocertif","CbTipoCertif","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td></tr>

<tr><td height="18"  align="right"  >Fecha:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",1) ?></td><td height="18" ><label class="MuestraError"> * </label></td><td><input name="ChkInactivo"  class="check"  type="checkbox"  value="1" <? if ($_SESSION[ChkInactivo] =='1') echo 'checked'; ?>>Inactivo</td><td height="18"  align="right"  >Certificado:</td><td  valign="top" >&nbsp;<input name="TxtCertif" type="text"  class="TextBox" style="width:190px" maxlength="30"  tabindex="2"  value="<? echo $_SESSION[TxtCertif]; ?>"></td></tr>

<tr><td height="18"  align="right"  >Vencimiento:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",1) ?></td><td height="18" ></td><td ></td><td height="18"  align="right"  >Archivo:</td><td  valign="top" >&nbsp;<? 
//explorar
if (intval($_SESSION[TxtNumero])!=0 and $ver!=1){echo GLO_FAButton('CmdArchivoH','submit','','self','Explorar','folder','iconbtn').'&nbsp;&nbsp;';	}
//ver
if (intval($_SESSION[TxtNumero])!=0 and !(empty($_SESSION[TxtArchivo]))){echo  GLO_FAButton('CmdVerFile2','submit','','blank','Ver','lupa','iconbtn');}
//borrar
if (intval($_SESSION[TxtNumero])!=0 and !(empty($_SESSION[TxtArchivo])) and $ver!=1){echo ' &nbsp; '.GLO_FAButton('CmdBorrarArchivoH','submit','','self','Borrar','trash','iconbtn');}
?></td></tr>

</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtArchivo',0);
GLO_obsform(700,100,'Observaciones','TxtObs',2,0); 
?>