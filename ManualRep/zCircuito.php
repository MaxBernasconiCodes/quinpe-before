<? include("../Codigo/Seguridad.php"); $_SESSION["NivelArbol"]="../";

?>
<link rel="STYLESHEET" type="text/css" href="../CSS/Estilo.css" >



<!--tema-->
<table width="850" border="0"  cellpadding="0" cellspacing="0"  >
<tr > <td height="20"  valign="bottom" class="titulomanual" >CIRCUITO REPARACIONES</td> </tr>
<tr> <td  class="textomanual" >
<strong>Estados Solicitud</strong><br>
1. SOLICITADA: Se di&oacute; de alta, pero no tiene Orden asociada a&uacute;n<br>
2. ACEPTADA: Ya fue asignada a una Orden<br>
3. RECHAZADA: La Solicitud fue rechazada y gener&oacute; Orden en estado FINALIZADA SIN ACCION<br>
4. A RETIRAR: La Orden asociada est&aacute; en estado CERRADA Y A RETIRAR o  PENDIENTE Y A RETIRAR<br>
5. RETIRADA: La Orden asociada est&aacute; en estado CERRADA o ENTREGADA CON PENDIENTES<br>
<br>
<strong>Estados Orden</strong><br>
1. EMITIDA: Se di&oacute; de alta, pero no tiene Acciones ni se complet&oacute; la Planilla de Control<br>
2. EN EJECUCION: La Planilla de Control est&aacute; incompleta, y tiene Acciones cargadas <br>
3. CONTROLADO: La Planilla de Control est&aacute; completa, y no tiene Acciones cargadas  <br>
4. CONTROLADO Y EN EJECUCION: La Planilla de Control est&aacute; completa, y tiene Acciones cargadas <br>
5. CERRADA Y A RETIRAR: La Planilla de Control est&aacute; completa, y todas las Acciones est&aacute;n cumplidas <br>
6. PENDIENTE Y A RETIRAR: La Planilla de Control est&aacute; completa, y todas las Acciones est&aacute;n cumplidas excepto alguna pendiente  <br>
7. FINALIZADA SIN ACCION: Orden en blanco generada al rechazar una Solicitud <br>
8. CERRADA: Orden CERRADA Y A RETIRAR en la que se hizo click en  el bot&oacute;n Entregar<br>
9. ENTREGADA CON PENDIENTES: Orden PENDIENTE Y A RETIRAR en la que se hizo click en  el bot&oacute;n Entregar <br>
<br>
<strong>Estados Acci&oacute;n:</strong><br>
1. GENERADA: Dada de alta interna, sin finalizar, sin insumos con PSI cargado<br>
2. EN ESPERA REPUESTO/INSUMO: Interna, tiene insumos con PSI cargado, sin finalizar<br>
3. EN EJECUCION: Interna, todos los insumos tienen PSI y MIM cargado, sin finalizar<br>
4. EN ESPERA TURNO SERVICIO EXTERNO: Dada de alta externa, sin finalizar<br>
5. EN SERVICIO EXTERNO: Dada de alta externa, sin finalizar, con Tarea con check Ingres&oacute; a servicio externo<br>
6. CUMPLIDA: Finalizada sin pendientes<br>
7. CUMPLIDA CON PENDIENTES: Finalizada con pendientes<br>
<br>
</td></tr>
</table>
<!--fin tema-->



