<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php") ;


function ART_CbTipo($campo){
$combo="";
if( "2" == $_SESSION[$campo]) { $combo .= " <option value="."2"." selected='selected'>"."BIENES"."</option>\n";}else{$combo .= " <option value="."2"." >"."BIENES"."</option>\n";}
if( "3" == $_SESSION[$campo]) { $combo .= " <option value="."3"." selected='selected'>"."CONSUMIBLES"."</option>\n";}else{$combo .= " <option value="."3"." >"."CONSUMIBLES"."</option>\n";}
if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."1"." selected='selected'>"."EPP"."</option>\n";}else{$combo .= " <option value="."1"." >"."EPP"."</option>\n";}
if( "4" == $_SESSION[$campo]) { $combo .= " <option value="."4"." selected='selected'>"."MERCADERIA"."</option>\n";}else{$combo .= " <option value="."4"." >"."MERCADERIA"."</option>\n";}
echo $combo;
}

function ART_Tipo($tipo){	
	$res='';
	switch (intval($tipo)) {
	case 1:	$res='EPP';break;
	case 2:	$res='BIENES';break;
	case 3:	$res='CONSUMIBLES';break;
	case 4:	$res='MERCADERIA';break;
	}
	return $res;
}	
?>