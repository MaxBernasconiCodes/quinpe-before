<? 
//seguridad includes
if(!isset($_SESSION)){include("../../Codigo/SeguridadIncludes.php");}
else{include($_SESSION["NivelArbol"]."Codigo/SeguridadIncludes.php");}
?>


<table width="750" border="0"  cellpadding="0" cellspacing="0" class="fondo" >
<tr> <td height="3" ></td></tr>
<!--talles-->
<tr ><td height="18" ><i class="fa fa-tag iconsmallsp iconlgray"></i> <strong>Talles:</strong></td></tr>
<tr> <td  align="center"><?php GLO_Ancla('A1');MostrarTablaTalles(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--habilit-->
<tr ><td height="18" ><i class="fa fa-id-card iconsmallsp iconlgray"></i> <strong>Habilitaciones:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A2');MostrarTablaVtos(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--lic-->
<tr ><td height="18" ><i class="fa fa-suitcase iconsmallsp iconlgray"></i> <strong>Licencias:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A4');MostrarTablaLic(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--cargas-->
<tr ><td height="18" ><i class="fa fa-home iconsmallsp iconlgray"></i> <strong>Cargas de familia:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A5');MostrarTablaCargasF(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--desemp-->
<tr ><td height="18" ><i class="fa fa-chart-line iconsmallsp iconlgray"></i> <strong>Desempe&ntilde;o:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A6');MostrarTablaDesemp(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--exp.interna-->
<tr ><td height="18" ><i class="fa fa-industry iconsmallsp iconlgray"></i> <strong>Experiencia Interna:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A7');MostrarTablaExpI(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--antec-->
<tr ><td height="18" ><i class="fa fa-inbox iconsmallsp iconlgray"></i> <strong>Antecedentes Laborales:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A8');MostrarTablaAntecedentes(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--info acad-->
<tr ><td height="18" ><i class="fa fa-graduation-cap iconsmallsp iconlgray"></i> <strong>Informacion Academica:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A9');MostrarTablaAcad(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--coment-->
<tr ><td height="18" ><i class="fa fa-comments iconsmallsp iconlgray"></i> <strong>Comentarios:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A10');MostrarTablaComentarios(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--asignaciones-->
<tr ><td height="18" ><i class="fa fa-pager iconsmallsp iconlgray"></i> <strong>Instrumentos asignados:</strong></td></tr>
<tr> <td  align="center" ><?php ASIG_MostrarAsignadosPersonal(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr> 
<!--archivos-->
<tr ><td height="18" ><i class="fa fa-paperclip iconsmallsp iconlgray"></i> <strong>Archivos adjuntos:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A11');MostrarTablaArchivos(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
<tr> <td height="25"></td></tr>
<!--telefonos-->
<tr ><td height="18" ><i class="fa fa-phone iconsmallsp iconlgray"></i> <strong>Tel&eacute;fonos:</strong></td></tr>
<tr> <td  align="center" ><?php GLO_Ancla('A12');MostrarTablaTelefonos(intval($_SESSION['TxtNumero']),$conn); ?>	</td></tr>
</table>

