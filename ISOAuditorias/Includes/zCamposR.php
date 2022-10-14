<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}


function ComboNC($conn){ 
$query="SELECT Id FROM iso_nc where Id<>0 order by Id DESC";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION['CbNC']){
   $combo .= '<option value="'.$row['Id'].'" selected="selected">'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</option>\n";
 }else{  $combo .= '<option value="'.$row['Id'].'">'.str_pad($row['Id'], 5, "0", STR_PAD_LEFT)."</option>\n";  }
}mysql_free_result($rs); 
echo $combo;
}

GLO_tituloypath(0,700,'','REQUERIMIENTO','salir');
?>

<table width="700" border="0"   cellspacing="0" class="Tabla" >
<tr> <td width="100" height="5"  ></td> <td width="600"></td> </tr>
<tr> <td height="18"  align="right"  >Requerimiento:</td><td  valign="top" >&nbsp;<select name="CbReq" style="width:550px" class="campos" id="CbReq" ><option value=""></option><? ComboISOReqRFX("CbReq",$conn); ?></select><label class="MuestraError"> * </label></td></tr>
<tr> <td height="18"  align="right"  >Requerimiento:</td><td  valign="top" >&nbsp;<select name="OptTipo" style="width:50px" class="campos" id="OptTipo" ><option value=""></option><? ComboTablaRFX("iso_audi_tipoh","OptTipo","Id","","",$conn);  ?></select></td></tr>
<tr> <td height="18"  align="right"  >No Conformidad:</td><td  valign="top" >&nbsp;<select name="CbNC" style="width:50px" class="campos" id="CbNC" ><option value=""></option><? ComboNC($conn);?></select></td></tr>
</table>

<?
GLO_obsform(700,100,'Observaciones','TxtObs',12,0);
GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);
GLO_botonesform("700",0,2);
GLO_mensajeerror();
?>