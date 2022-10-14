<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");




function DES_ComboItemServicio($campo,$servicio,$conn){
	$query="SELECT si.Id, i.Nombre FROM itemscliente_serv si, items i where si.Id<>0 and si.IdItem=i.Id and si.IdPadre=$servicio Order by i.Nombre";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
        if( $row['Id'] == $_SESSION[$campo]) {
            $combo .= " <option value='".$row['Id']."' selected='"."selected"."'>".$row['Nombre']."</option>\n";
        }else{ $combo .= " <option value='".$row['Id']."'>".$row['Nombre']."</option>\n";   }
	}echo $combo;
}


function DES_ComboItemServicioRO($campo,$sel,$conn){ //construye el combo con un solo dato ($sel)
	$query="SELECT si.Id, i.Nombre FROM itemscliente_serv si, items i where si.Id<>0 and si.IdItem=i.Id and si.Id=$sel";$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
	  if( $row['Id'] == $_SESSION[$campo]) {
	   $combo .= " <option value='".$row['Id']."' selected='"."selected"; $combo .= "'>".$row['Nombre']."</option>\n";
	 }else{ $combo .= " <option value='".$row['Id']."'>".$row['Nombre']."</option>\n";   }}
	echo $combo;
}



GLO_tituloypath(0,730,'','ITEM PEDIDO '.str_pad($_SESSION['TxtNroEntidad'], 5, "0", STR_PAD_LEFT),'salir');


?>

<table width="730" border="0"  cellspacing="0" class="Tabla" >
<tr><td width="100" height="3"  ></td>  <td width="300"></td><td width="100"></td><td width="230"></td></tr>
<tr><td height="18"  align="right"  >Item:</td><td  valign="top" >&nbsp;<select name="CbItem" style="width:270px"   class="campos" id="CbItem" ><? if(intval($_SESSION['TxtNumero'])==0){echo '<option value=""></option>';DES_ComboItemServicio("CbItem",intval($_SESSION['CbServicio']),$conn);}else{ DES_ComboItemServicioRO("CbItem",$_SESSION['CbItem'],$conn);} ?></select><label class="MuestraError"> * </label></td><td   align="right"  >Estado:</td><td  valign="top" >&nbsp;<input name="TxtEstado" type="text"  class="TextBoxRO" style="font-weight:bold;width:100px;<? echo $colorfield;?>" readonly="true" value="<? echo $_SESSION['TxtEstado']; ?>"></tr>
</table>

<table width="730" border="0"  cellspacing="0" class="Tabla TMT" >
<tr><td width="100" height="3"  ></td>  <td width="300"></td><td width="100"></td><td width="230"></td></tr>
<tr><td height="18"  align="right"  >Cantidad:</td><td  valign="top" >&nbsp;<input name="TxtRes" type="text"  class="TextBox"  maxlength="14"  value="<? echo $_SESSION['TxtRes']; ?>" tabindex="1"  style="width:70px" onChange="this.value=validarNumeroP(this.value);"><label class="MuestraError"> * </label></td><td align="right">Bultos</td><td>&nbsp;<input name="TxtBultos" type="text"  class="TextBox"  maxlength="5"  value="<? echo $_SESSION['TxtBultos']; ?>" tabindex="2"  style="width:50px" onChange="this.value=validarEntero(this.value);" ></td></tr>

<tr><td height="18"  align="right"  >Unidad:</td><td  valign="top" >&nbsp;<select name="CbUnidad"  tabindex="1"  class="campos" id="CbUnidad"  style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("unidadesmedida","CbUnidad","Nombre","","",$conn); ?></select><label class="MuestraError"> * </label></td><td align="right">Destino:</td><td>&nbsp;<input name="TxtObs" type="text"  class="TextBox"  maxlength="30"  value="<? echo $_SESSION['TxtObs']; ?>" tabindex="2"  style="width:200px"></td></tr>

<tr><td height="18"  align="right"  >Envase:</td><td  valign="top" >&nbsp;<select name="CbEnv"  tabindex="1"  class="campos" id="CbEnv"  style="width:150px" onKeyDown="enterxtab(event)"><option value=""></option><? ComboTablaRFX("envases","CbEnv","Nombre","","",$conn); ?></select></td><td align="right"></td><td></td></tr>
<tr><td height="18"  align="right"  >Lote:</td><td  valign="top" >&nbsp;<input name="TxtVal" type="text"  class="TextBox"  maxlength="10"  value="<? echo $_SESSION['TxtVal']; ?>" tabindex="1"  style="width:150px"></td><td align="right"></td><td></td></tr>
</table>


<?
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_Hidden('CbEstado',0);GLO_Hidden('CbCliente',0);GLO_Hidden('CbServicio',0);
GLO_Hidden('TxtIdRtoE',0);GLO_Hidden('TxtIdRtoI',0);


?>