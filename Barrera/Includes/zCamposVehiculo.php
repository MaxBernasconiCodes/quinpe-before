<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}

//vehiculo propios y terceros 

?>

<table width="760" border="0"  cellspacing="0" class="Tabla" >
<tr> <td width="110" height="5"  ></td> <td width="100"></td><td width="200"></td><td width="110"></td> <td width="240"></td></tr>
<tr> <td height="18"  align="right"  >Fecha:</td><td >&nbsp;<?php  GLO_calendario("TxtFechaA","../Codigo/","actual",1); ?></td><td>&nbsp;<input name="TxtHora"   id="time" type="text"  class="TextBox"  style="width:50px" maxlength="5"  tabindex="1" value="<? echo $_SESSION['TxtHora']; ?>" onChange="this.value=validarHora(this.value);">&nbsp;<select name="CbEtapa" class="campos TBold <? if(intval($_SESSION['TxtNumero'])!=0){if(intval($_SESSION['CbEtapa'])==1){echo 'TBlue';}else{echo 'TGreen';} }?>" id="CbEtapa"  style="width:85px"  tabindex="2" onKeyDown="enterxtab(event)"><? if(intval($_SESSION['TxtNumero'])==0){echo PROC_CbTipoEtapa('CbEtapa',0);}else{echo PROC_CbTipoEtapa('CbEtapa',1);}?></select><label class="MuestraError"> * </label></td><td align="right"  >Propietario Camion:</td><td>&nbsp;<select name="CbTipo" class="campos" id="CbTipo"  style="width:90px"   onKeyDown="enterxtab(event)"><? echo PROC_CbTipoUnidad('CbTipo');?></select> <select name="CbTipo2" style="width:90px" class="campos"  id="CbTipo2" ><? echo PROC_CbTipoBarreraV("CbTipo2");?></select> <i class="fa fa-truck TGray iconsmall"></i></td></tr>
</table>