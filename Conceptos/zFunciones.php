<? 

if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2   and $_SESSION["IdPerfilUser"]!=3  and  $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}


function IT_tipoitem($var){
    $res='';
    switch ($var) {
        case 0:	$res='Producto';break;
        case 1:	$res='Servicio';break;
    }
    return $res;
}


function Cb_TipoItem($campo){
$combo="";
if( "0" == $_SESSION[$campo]) { $combo .= " <option value="."'0'"." selected='selected'>"."PRODUCTO"."</option>\n";}else{$combo .= " <option value="."'0'"." >"."PRODUCTO"."</option>\n";}
if( "1" == $_SESSION[$campo]) { $combo .= " <option value="."'1'"." selected='selected'>"."SERVICIO"."</option>\n";}else{$combo .= " <option value="."'1'"." >"."SERVICIO"."</option>\n";}
echo $combo;
}



?>