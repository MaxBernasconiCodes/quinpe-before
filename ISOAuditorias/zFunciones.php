<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");



function ISOAUDI_CbEstadoAuditoria(){//prog:1,cumpl:2,3:anul
$combo="";
if( "1" == $_SESSION['CbEstado']) { $combo .= " <option value="."'1'"." selected='selected'>"."PROGRAMADA"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."PROGRAMADA"."</option>\n";}
if( "2" == $_SESSION['CbEstado']) { $combo .= " <option value="."'2'"." selected='selected'>"."CUMPLIDA"."</option>\n";}else{$combo .= " <option value="."'2'"." >"."CUMPLIDA"."</option>\n";}
if( "3" == $_SESSION['CbEstado']) { $combo .= " <option value="."'3'"." selected='selected'>"."ANULADA"."</option>\n";}else{$combo .= " <option value="."'3'"." >"."ANULADA"."</option>\n";}
echo $combo;
}

function ISOAUDI_CbDesvios($nombre,$tabla,$conn){ 
$query="SELECT * FROM $tabla where Id<>0 Order by Nro";$rs=mysql_query($query,$conn);
$combo="";
while($row=mysql_fetch_array($rs)){ 
  if( $row['Id'] == $_SESSION[$nombre]) {
   $combo .= " <option value='".$row['Id']."' selected='"."selected". "'>".substr($row['Nro'].'  '.$row['Nombre'],0,50)."</option>\n";
 }else{$combo .= " <option value='".$row['Id']."'>".substr($row['Nro'].'  '.$row['Nombre'],0,50)."</option>\n";}} 
echo $combo;mysql_free_result($rs);
}


?>