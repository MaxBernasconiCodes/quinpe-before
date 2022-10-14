<?php include("Seguridad.php") ;


function ObtenerLogoEmpresa(&$imagen,&$nombref,&$dir,&$web,&$nivelarbol){
$imagen=$nivelarbol."CSS/Imagenes/LogoEmpresa.jpg";	
}


//perfiles
function GLO_PerfilAcceso($tipo){
    switch ($tipo) {

        case 10://personal	
            if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and  $_SESSION["IdPerfilUser"]!=11){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
        break;

        case 11://legajo (solo rrhh(3) puede dar de alta y ver legajo)	
            if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
        break;

        case 12://unidades + accesorios
            if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=11 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
        break;
        
        case 13://barrera (perfil barrera(16) solo ve barrera, no el resto del circuito)
            if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2  and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14 and $_SESSION["IdPerfilUser"]!=16){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
        break;

        case 14://iso 
            if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=10 and $_SESSION["IdPerfilUser"]!=11 and  $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
        break;

        case 15://iso matriz legal (sgi externo limitado(15) solo ve matriz legal) 
            if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=3 and $_SESSION["IdPerfilUser"]!=4 and $_SESSION["IdPerfilUser"]!=7 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=10 and $_SESSION["IdPerfilUser"]!=11 and  $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
        break;

        case 16://iso programas
            if ($_SESSION["IdPerfilUser"]!=1 and $_SESSION["IdPerfilUser"]!=2 and $_SESSION["IdPerfilUser"]!=9 and $_SESSION["IdPerfilUser"]!=14){ header("Location:".$_SESSION["NivelArbol"]."Inicio.php");}
        break;
    }		
}


?>