<? 

//perfiles
if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=3  and $_SESSION["IdPerfilUser"]!=11  and $_SESSION["IdPerfilUser"]!=12  and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14  ){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


GLO_tituloypath(0,700,'','CERTIFICACION','salir');
?>


<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="350"></td><td width="100"></td><td width="110"></td><td width="40"></td> </tr>
<tr> <td height="18"  align="right"  >Certificacion:</td><td>&nbsp;<input  name="TxtNumero" type="text"  readonly="true"  class="TextBoxRO"   value="<? echo $_SESSION['TxtNumero'];?>" style="text-align:right;width:50px"></td><td align="right">Fecha:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFechaA","../Codigo/","actual",2) ?></td><td><label class="MuestraError"> * </label></td></tr>

<tr> <td height="18"  align="right"  >Instrumento:</td><td>&nbsp;<select name="CbInstrumento" style="width:300px"  tabindex="1" class="campos" id="CbInstrumento" > <? if(intval($_SESSION['TxtNroEntidad'])!=0 or intval($_SESSION['TxtNumero'])!=0){ GLO_ComboEquiposRO("CbInstrumento",intval($_SESSION['CbInstrumento']),"epparticulos",$conn);}else{ echo '<option value=""></option>';GLO_ComboEquipos("CbInstrumento","epparticulos",$conn);} ?> </select><label class="MuestraError"> * </label></td><td align="right">Vencimiento:</td><td  valign="top">&nbsp;<? GLO_calendario("TxtFechaB","../Codigo/","actual",2) ?></td><td></td></tr>

<tr> <td height="18"  align="right"  >Tipo:</td><td>&nbsp;<select name="CbTipoCertif" tabindex="1"  style="width:300px" class="campos" id="CbTipoCertif" ><option value=""></option> <? ComboTablaRFX("instrumentostipocertif","CbTipoCertif","Nombre","","",$conn); ?> </select><label class="MuestraError"> * </label></td><td align="right"></td><td><input name="ChkInactivo"   type="checkbox" class="check" tabindex="2" value="1" <? if ($_SESSION['ChkInactivo'] =='1') echo 'checked'; ?>>Inactivo</td><td></td></tr>
</table>





<table width="700" border="0"   cellspacing="0" class="Tabla TMT" >
<tr> <td width="100" height="5"  ></td> <td width="350"></td><td width="100"></td><td width="150"></td> </tr>
<tr><td height="18"  align="right"  >Certificado:</td><td  valign="top">&nbsp;<input name="TxtCertif" type="text"  class="TextBox" style="width:300px" maxlength="30"  tabindex="3"  value="<? echo $_SESSION['TxtCertif']; ?>"></td><td align="right"  >Archivo:</td><td  valign="top" >&nbsp;<? 
if (intval($_SESSION['TxtNumero'])!=0){
	if($readonly==0){echo GLO_FAButton('CmdArchivoH','submit','','self','Explorar','folder','iconbtn').' &nbsp; ';}	
	if (!(empty($_SESSION['TxtArchivo']))){
		echo GLO_FAButton('CmdVerFile2','submit','','blank','Ver','lupa','iconbtn').' &nbsp; ';
		if($readonly==0){echo GLO_FAButton('CmdBorrarArchivoH','submit','','self','Borrar','trash','iconbtn');}
	}
}
?></td></tr>
</table>

<? 
GLO_Hidden('TxtId',0);GLO_Hidden('TxtNroEntidad',0);GLO_Hidden('TxtArchivo',0);
GLO_obs(700,100,'Observaciones','TxtObs',2,0,4); 

//guardar
if($readonly==0){
	GLO_botonesform("700",0,2);
	GLO_mensajeerror();
}


//adjuntos modificar
if (intval($_SESSION['TxtNumero'])!=0 and $readonly==0){
    echo '<table width="700" border="0"  cellpadding="0" cellspacing="0" class="fondo" >
	<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td><td align="right"></td></tr>
	<tr> <td  align="center"  colspan="2">';GLO_TablaArchivos($_SESSION['TxtNumero'],$conn,"instrumentosprog_a","700","Adjuntos/"); echo '</td></tr>
	</table>';
}


//adjuntos ver
if (intval($_SESSION['TxtNumero'])!=0 and $readonly==1){
	GLO_FAAdjuntarArchivos($_SESSION['TxtNumero'],$conn,"instrumentosprog_a","720","Adjuntos/","Archivos adjuntos","paperclip",1,1,1);
}	
?>