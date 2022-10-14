<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}



GLO_tituloypath(950,700,'sgi','DESARROLLO MINUTA','salir'); 



GLO_Hidden('TxtNumero',0);GLO_Hidden('TxtNroEntidad',0);

GLO_obsform(700,100,'Actividad','TxtNombre',5,0);

GLO_botonesform("700",0,2); 

GLO_mensajeerror();

?>