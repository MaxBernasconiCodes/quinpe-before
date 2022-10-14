<? include("../Codigo/Seguridad.php"); $_SESSION["NivelArbol"]="../";

?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >



<!--tema-->
<table width="850" border="0"  cellpadding="0" cellspacing="0"  >
<tr > <td height="20"  valign="bottom" class="titulomanual" >ORDENES</td> </tr><tr> 
<td  class="textomanual" >

Una vez que est&aacute; generada la solicitud se da de alta la orden, o bien, desde esta &uacute;ltima se puede generar una solicitud. <br><br>

En la orden se observan los <font class="comentario2">REQUERIMIENTOS</font> de la solicitud, se realiza el checklist mediante la <font class="comentario2">PLANILLA DE CONTROL</font> y se detallan las distintas <font class="comentario2">ACCIONES</font> a efectuar para su resoluci&oacute;n.<br><br>

Una vez generada la Orden se debe completar la <font class="comentario2">PLANILLA DE CONTROL</font>.<br>
De acuerdo a los requerimientos ingresados en la Solicitud, y mediante un checklist determina las acciones a realizar en la unidad.<br><br>

Una vez identificados los requerimientos de la unidad se generan las <font class="comentario2">ACCIONES</font> necesarias para resolverlos.<br>
identific&aacute;ndose las que se realizar&aacute;n dentro del taller o que requieren servicio de terceros.<br><br>

Dentro de cada Acci&oacute;n, se determinar&aacute;n las <font class="comentario2">TAREAS</font> e <font class="comentario2">INSUMOS</font> que cada reparaci&oacute;n necesite.<br><br>

Si todas las Acciones estan en estado Cumplido, la <font class="comentario3">Fecha a Retirar</font>  de la Orden es requerida.<br>
Si el estado de la orden es <font class="comentario3">Cerrada a Retirar</font>  o <font class="comentario3">Pendiente a Retirar</font> , muestra bot&oacute;n <font class="comentario3">Entregar</font>.<br>
Al hacer click en el bot&oacute;n <font class="comentario3">Entregar</font>, la Orden pasa a <font class="comentario3">Cerrada</font> o <font class="comentario3">Entregada con Pendientes</font>, y la Solicitud a <font class="comentario3">Retirada</font><br><br>


Para poder eliminar la asignaci&oacute;n de una Solicitud a una Orden, desde la Orden:<br>
-Borrar Entrega, si fue realizada <br>
-Eliminar las Acciones<br>
-Quitar check de Planilla de Control completa<br>
-Modificar la Solicitud asociada en la lista desplegable de la Orden. <br>

<br>
</td></tr>
</table>
<!--fin tema-->



