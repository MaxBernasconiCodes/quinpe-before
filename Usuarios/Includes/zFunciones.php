<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php") ;


function USR_ComboPuesto($tipo){ //$tipo 1:personal,2:tercerizado,3:proveedor
	$valor='';$nombre='';
	//
	if($tipo==1){$valor='PERSONAL';$nombre='PERSONAL';}
	//if($tipo==2){$valor='TERC';$nombre='TERCERIZADO';}//lo usa solo GOS
	if($tipo==3){$valor='PROVEEDOR';$nombre='PROVEEDOR';}
	//
	$combo="";
	if( $valor == $_SESSION['CbPuesto']) { $combo .= " <option value=".$valor." selected='selected'>".$nombre."</option>\n";}
	else{$combo .= " <option value=".$valor." >".$nombre."</option>\n";}
	echo $combo;
}
	

function USR_ComboPerfil($tipo,$conn){ //$tipo 1:personal,2:tercerizado,3:proveedor
	//tipo 0:solo personal, 1:prov+personal
	$whereperfil="";
	if($tipo==1){$whereperfil="";}//personal
	//if($tipo==2){$whereperfil="and Tipo=1 and Id IN(4)";}//tercerizado //lo usa solo GOS
	if($tipo==3){$whereperfil="and Tipo=1";}//proveedor
	//
	$query="SELECT * FROM perfiles where Inactivo=0 and Restringido=0 $whereperfil Order by Nombre";
	$rs=mysql_query($query,$conn);
	$combo="";
	while($row=mysql_fetch_array($rs)){ 
	  if( $row['Id'] == $_SESSION['CbPerfil']) {
	   $combo .= " <option value='".$row['Id']."' selected='"."selected";
	   $combo .= "'>".$row['Nombre']."</option>\n";
	 }else{ $combo .= " <option value='".$row['Id']."'>".$row['Nombre']."</option>\n";   }}
	echo $combo;mysql_free_result($rs);
	}
	

?>