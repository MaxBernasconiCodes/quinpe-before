<? include("Seguridad.php");?>

<!--fin contenedor-->  
</td></tr></table>
</td></tr>

<!--footer-->   
<tr><td class="footerUSR" colspan="2">
<? echo $_SESSION["NombreUsuario"];

if (intval($_SESSION["GLO_IdSistema"])!=0 ){echo '&nbsp; | &nbsp; ';}

if ($_SESSION["GLO_IdSistema"]==1 ){echo 'ADMINISTRACION &nbsp;';}
if ($_SESSION["GLO_IdSistema"]==3){echo 'MANTENIMIENTO &nbsp;';}
if ($_SESSION["GLO_IdSistema"]==4 ){echo 'OPERACIONES &nbsp;';}
if ($_SESSION["GLO_IdSistema"]==5 ){echo 'RRHH &nbsp;';}
if ($_SESSION["GLO_IdSistema"]==6 ){echo 'SMA &nbsp;';}
if ($_SESSION["GLO_IdSistema"]==7 ){echo 'SGI &nbsp;';}
if ($_SESSION["GLO_IdSistema"]==9 ){echo 'UNIDADES &nbsp;';}
if ($_SESSION["GLO_IdSistema"]==10 ){echo 'INDICADORES &nbsp;';}
?>
&nbsp;&nbsp;</td></tr>


<!--fin tabla-->  
</table>
</body>
</html>

<? include ($_SESSION["NivelArbol"]."Codigo/LimpiarSession.php");?>
