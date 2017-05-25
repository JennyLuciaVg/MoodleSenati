<?PHP
    require_once("../config.php");
    require_once("lib.php");
// REPORTE DE RETIRADOS POR PERIODO


$ano_actual=date ("Y");
$periodo_listar=$ano_actual . "10";

	$titulo_pagina = "Reporte de Retirados por Periodo";
	$site = get_site();

	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");


    if (isadmin())
{

	$tip_ord=$_POST["tip_ord"];
	$colu_ord=$_POST["colu_ord"];

	if ($tip_ord=="")
	   {$tip_ord="ASC";}

	if ($colu_ord=="")
	   {$colu_ord="7";}


	$accion = $_POST["th_accion"];

	if ($accion=="ordenar")
	   {$periodo_listar=$_POST["sel_periodo"];}


	if ($accion=="listar_periodo")
	   {$periodo_listar=$_POST["sel_periodo"];}
	


$query1  ="Select userid as id_moodle, pidm_banner as pidm, lastname||', '||firstname as nombre, fullname as curso, course as id_curso, campus, nombre_centro ";
$query1 .="from mdl_user_students A ";
$query1 .="inner join mdl_user B on A.userid=B.id ";
$query1 .="inner join mdl_course C on A.course=C.id ";
$query1 .="inner join senati_centros D on campus=id_centro ";
$query1 .="Where A.periodo='". $periodo_listar ."' and status_sinfo='RET' ";
$query1 .="order by ". $colu_ord . " ". $tip_ord;

$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
	
?>
<BR />

<strong style="color:blue"><a href="cursos_admin_menu.php"><u>Administraci&oacute;n de Cursos</u></a> - Reporte de Retirados por Per&iacute;odo</strong><BR><BR>



<form name="thisform" id="thisform" method="post">

<strong>Seleccionar Per&iacute;odo :</strong>
<select name="sel_periodo">
<?PHP 

for ($i=$ano_actual;$i>2005;$i--)
    {
	$ata1="";
	$ata2="";
	
	if ($periodo_listar==$i ."10")
	   {$ata1="selected";}
	if ($periodo_listar==$i ."20")
	   {$ata2="selected";}   

	    	
?>
<option value="<?PHP echo $i ?>10" <?PHP echo $ata1 ?>><?PHP echo $i ?>10</option>	
<option value="<?PHP echo $i ?>20" <?PHP echo $ata2 ?>><?PHP echo $i ?>20</option>
<?PHP	
	}
?>	
</select>
&nbsp; <input type="button" value="Listar" onclick="listar_periodo();"/>
<BR />
<BR />
<strong>REPORTE DEL PERIODO : <?PHP echo $periodo_listar ?></strong>
<BR>
<table cellpadding="1" cellspacing="1" border="1" bordercolor="#999999">
<tr bgcolor="#999999">
<td height="23">&nbsp;<strong>N&deg;</strong>&nbsp;</td>

<td style="cursor:hand" onClick="ordenar(1);" title="Ordenar">&nbsp;<u style="color:white"><strong>Id Moodle</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(2);" title="Ordenar">&nbsp;<u style="color:white"><strong>PIDM SINFO</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(3);" title="Ordenar">&nbsp;<u style="color:white"><strong>Nombre</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(4);" title="Ordenar">&nbsp;<u style="color:white"><strong>Curso</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(5);" title="Ordenar">&nbsp;<u style="color:white"><strong>Id Curso</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(6);" title="Ordenar">&nbsp;<u style="color:white"><strong>Camp</strong></u>&nbsp;</td>
<td style="cursor:hand" onClick="ordenar(7);" title="Ordenar">&nbsp;<u style="color:white"><strong>Campus</strong></u>&nbsp;</td>
</tr>



<?PHP
$ct=0;
while($rox=pg_fetch_array($result1)) 
	{
	$ct++;
	echo "<tr>";
	echo "<td align=right>". $ct ."</td>";
	echo "<td align=center>". $rox["id_moodle"] ."</td>";
	echo "<td align=center>". $rox["pidm"] ."</td>";
	echo "<td>". $rox["nombre"] ."</td>";
	echo "<td>". $rox["curso"] ."</td>";
	echo "<td align=center>". $rox["id_curso"] ."</td>";
	echo "<td align=center>". $rox["campus"] ."</td>";
	echo "<td>". $rox["nombre_centro"] ."</td>";
	echo "</tr>";


	}

 ?> 
</table>

<input type="hidden" name="tip_ord" id="tip_ord" value="<?PHP echo $tip_ord ?>" />
<input type="hidden" name="colu_ord" id="colu_ord" value="<?PHP echo $colu_ord ?>" />
<input type="hidden" name="th_accion" id="th_accion" value="" />

<BR />

</form>
<BR>
<BR>

<?PHP
print_footer();
 ?>

<script language="javascript">
function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function listar_periodo(){
    obje("th_accion").value="listar_periodo";
	obje("thisform").submit();
}



function ordenar(nume){
    if (obje("colu_ord").value==nume)
       {
       if (obje("tip_ord").value=="ASC")
          {obje("tip_ord").value="DESC";}
       else   
		  {obje("tip_ord").value="ASC";}
       }
    else
     {obje("colu_ord").value=nume;
      obje("tip_ord").value="ASC";
     }
    obje("th_accion").value="ordenar";
    obje("thisform").submit();
}


</script>
<?PHP
}
else
{
echo "Debe ser administrador para entrar a esta pagina";
}
  ?>