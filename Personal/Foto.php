<? include("../Codigo/Seguridad.php") ;include("../Codigo/Config.php") ; $_SESSION["NivelArbol"]="../";include("../Codigo/Funciones.php");



//perfiles
include("../Perfiles/Permisos/p1.php");

//get

GLO_ValidaGET($_GET['Id'],0,0);



$_SESSION['TxtNroEntFoto']=intval($_GET['Id']);



?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">   

<html>

<head>

<? include ("../Codigo/HeadFull.php");?>

<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >



<? GLO_bodyform('',0,0);?>

<? include ("../Codigo/BannerPopUp.php");?>





<form name="Formulario" >

<table width="100%" border="0"  cellpadding="0" cellspacing="0"  >

<tr> <td height="8"></td></tr>

<tr><td align="center">





<table width="400" border="0"  cellpadding="0" cellspacing="0"  >



<!-- First, include the JPEGCam JavaScript Library -->

<script type="text/javascript" src="webcam.js"></script>



<!-- Configure a few settings -->

<script language="JavaScript">

    webcam.set_api_url( 'zFoto.php' );

    webcam.set_quality( 90 ); // JPEG quality (1 - 100)

    webcam.set_shutter_sound( true ); // play shutter click sound

</script>



<!-- Next, write the movie to the page at 320x240 -->

<script language="JavaScript">

    document.write( webcam.get_html(320, 240) );

</script>







<!-- Buttons-->

<tr> <td height="10"></td></tr>

<tr ><td  colspan="2" align="right">

<input name="CmdImprimir" type="button"  class="botonfotoG" value="" onClick="take_snapshot();">

<input name="CmdCancelar"  type="button"   class="botonsalirG" value=""  onClick="window.history.back();">&nbsp; <input  name="TxtNroEntFoto"  type="hidden"  value="<? echo $_SESSION[TxtNroEntFoto]; ?>"></td></tr>

<tr> <td height="5"></td></tr>

</table>





</td></tr>

</table>

</Form>		



<!-- Code to handle the server response (see test.php) -->

<script language="JavaScript">

    webcam.set_hook( 'onComplete', 'my_completion_handler' );

    

    function take_snapshot() {

        // take snapshot and upload to server

        document.getElementById('upload_results').innerHTML = 'Procesando...';

        webcam.snap();

    }

    

    function my_completion_handler(msg) {

        // extract URL out of PHP output

        if (msg.match(/(http\:\/\/\S+)/)) {

            var image_url = RegExp.$1;

            // show JPEG image in page

            document.getElementById('upload_results').innerHTML = 

                '<h1>Captura Exitosa!</h1>' + 

                '<img src="' + image_url + '">';

            

            // reset camera for another shot

            webcam.reset();

        }

        else alert("PHP Error: " + msg);

    }

</script>

<div id="upload_results"  align="center"></div>

	



 

<? include ("../Codigo/FooterConUsuario.php");?>