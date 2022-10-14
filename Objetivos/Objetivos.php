<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php");  include("../Codigo/Funciones.php"); $_SESSION["NivelArbol"]="../";
 

 function MostrarTabla(){	
	//clases
	$clasediv='<td width="20" ></td>';
	$clasedivh='<tr><td height="20" ></td></tr>';
    $claselink='<td width="200" class="TableShowD TAC TBN" valign="top" style="text-align:center;cursor:pointer;color:#FFFFFF;background:#f4b400;font-size:1.8rem;vertical-align:middle;height:70px" ';
	//
    $tablaclientes='';
	$tablaclientes .='<table width="420" class="TableShow TBN TMT10" id="tshow">';
    $tablaclientes .='<tr>';
    $tablaclientes .=$claselink." onclick="."location='1.php'>".'Vision y Mision <br> <i class="fas fa-globe-americas TMT5" ></i></td>';
    $tablaclientes .=$clasediv;	
    $tablaclientes .=$claselink." onclick="."location='2.php'>".'Valores <br> <i class="fas fa-handshake TMT5" ></i></td>';	
	$tablaclientes .='</tr>'.$clasedivh;
	//
	$tablaclientes .='<tr>';
    $tablaclientes .=$claselink." onclick="."location='3.php'>".'Objetivos <br> <i class="fas fa-clipboard-list TMT5" ></i></td>';
    $tablaclientes .=$clasediv;	
    $tablaclientes .=$claselink." onclick="."location='4.php'>".'Estrategia <br> <i class="fas fa-chart-line TMT5" ></i></td>';
	$tablaclientes .='</tr>'.$clasedivh;
	//
	$tablaclientes .=GLO_fintabla(0,0,0);
	echo $tablaclientes;

}


GLOF_Init('','BannerConMenuHV','',0,'',0,0,0); 
GLO_tituloypath(0,410,'../Inicio.php','','linksalir'); 

MostrarTabla(); 

GLO_cierratablaform(); 
include ("../Codigo/FooterConUsuario.php");
?>