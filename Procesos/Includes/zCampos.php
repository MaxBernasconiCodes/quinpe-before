<? include($_SESSION["NivelArbol"]."Codigo/Seguridad.php");


?>





<table width="780" border="0"  cellspacing="0" class="TablaBuscar TMT10" >
<tr> <td width="130" height="5"  ></td> <td width="130"></td><td width="130"></td><td width="130"></td><td width="130"></td><td width="130"></td></tr>
<tr>
    <td align="center"><i class="fa fa-file-alt iconsmallbt iconlgray"></i></td>
    <td align="center"><i class="fa fa-truck iconsmallbt iconlgray" ></i></td>
    <td align="center"><i class="fa fa-flask iconsmallbt iconlgray"></i></td>
    <td align="center"><i class="fa fa-warehouse iconsmallbt iconlgray"></i></td>
    <td align="center"><i class="fa fa-flask iconsmallbt iconlgray"></i></td>
    <td align="center"><i class="fa fa-truck iconsmallbt iconlgray"></i></td>
</tr>

<tr>
    <td align="center">Logistica</td>
    <td align="center">Barrera</td>
    <td align="center">Laboratorio</td>
    <td align="center">Planta</td>
    <td align="center">Laboratorio</td>
    <td align="center">Barrera</td>
</tr>

<tr>
    <td align="center" class="TGray">Pedido</td>
    <td align="center" class="TGray">Control ingreso</td>
    <td align="center" class="TGray">Control calidad</td>
    <td align="center" class="TGray">Alm/Form/Carga</td>
    <td align="center" class="TGray">Control calidad</td>
    <td align="center" class="TGray">Control salida</td>
</tr>

<tr>
    <td align="center"><? echo PROC_ColorEstado(4,intval($_SESSION['TxtNumero']),$conn);?></td><!-- Logistica -->
    <td align="center"><? echo PROC_ColorEstado(1,intval($_SESSION['TxtNumero']),$conn);?></td><!-- Barrera -->
    <td align="center"><? echo PROC_ColorEstado(2,intval($_SESSION['TxtNumero']),$conn);?></td><!-- Laboratorio -->
    <td align="center"><? echo PROC_ColorEstado(3,intval($_SESSION['TxtNumero']),$conn);?></td><!-- Planta -->
    <td align="center"><? echo PROC_ColorEstado(6,intval($_SESSION['TxtNumero']),$conn);?></td><!-- Laboratorio -->
    <td align="center"><? echo PROC_ColorEstado(10,intval($_SESSION['TxtNumero']),$conn);?></td><!-- Barrera -->
</tr>
</table>


