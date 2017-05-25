<?PHP

    require_once("../config.php");
    require_once("lib.php");
    require_once("../conexion.php");

    if (isadmin())
{

	$titulo_pagina = "Historia Academica - Acta de Notas Oficial";
	$site = get_site();

	print_header("$site->shortname : ". $titulo_pagina, "X1", $titulo_pagina, "", "", true, "");

	$id_csen=$_POST["id_csen"];
	$nombre_csen=$_POST["nombre_csen"];
	$id_curso_moodle=$_POST["id_curso_moodle"];
	$fecha_inicio=$_POST["fecha_inicio"];
	$nombre_moodle=$_POST["nombre_moodle"];

    $query  = 'SELECT userid, firstname, B.pidm_banner, lastname, email , city, nota, estado, A.camp, A.carr, A.periodo, A.nrc, A.bloque From mdl_user_students A left join mdl_user B on userid=B.id ';
	$query .=' left join senati_actas_notas C on C.id_curso=A.course and B.id=id_alumno Where A.course=' . $id_curso_moodle . ' order by camp, nrc, periodo, carr, lastname';

	  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
	  // Printing results in HTML

///// Esadisticas por Campus-Carrera
	  $queryx  = "Select DISTINCT(A.camp||'-'||A.carr||'-'||estado), A.camp, A.carr, estado, materia_desc, nombre_centro, count(*) as total From mdl_user_students A ";
	  $queryx .= "left join mdl_user B on userid=B.id ";
	  $queryx .= "left join senati_actas_notas C on C.id_curso=A.course and B.id=id_alumno ";
	  $queryx .= "left join senati_materias D on D.materia_code=A.carr ";
	  $queryx .= "left join senati_centros E on E.id_centro=A.camp ";
	  $queryx .= "Where A.course=" . $id_curso_moodle ; 
	  $queryx .= "Group by A.camp||'-'||A.carr||'-'||estado, A.camp, A.carr, estado, materia_desc,nombre_centro ";
	  $resultx = pg_query($queryx) or die('Query failed: ' . pg_last_error());
	  
///// Esadisticas por Campus
	  $queryz  = "Select DISTINCT(A.camp||'-'||estado), A.camp, estado, nombre_centro, count(*) as total From mdl_user_students A ";
	  $queryz .= "left join mdl_user B on userid=B.id ";
	  $queryz .= "left join senati_actas_notas C on C.id_curso=A.course and B.id=id_alumno ";
	  $queryz .= "left join senati_centros E on E.id_centro=A.camp ";
	  $queryz .= "Where A.course=" . $id_curso_moodle ; 
	  $queryz .= "Group by A.camp||'-'||estado, A.camp, estado, nombre_centro";
	  
	  $resultz = pg_query($queryz) or die('Query failed: ' . pg_last_error());

?>
<BR />

<strong style="color:blue"><a href="historia_academica.php"><u>Historia Academica</u></a> - Acta de Notas Oficial</strong><BR><BR>

<table cellpadding="3" cellspacing="1" border="1" bordercolor="gray">
<tr><td align=right><strong>ID Curso SENATI</strong></td><td><?PHP echo $id_csen?></td></tr>
<tr><td align=right><strong>Nombre Curso SENATI</strong></td><td><u style="color:blue;cursor:hand;" onclick="thisform.submit();"><?PHP echo $nombre_csen?></u></td></tr>
<tr><td align=right><strong>ID Curso Moodle</strong></td><td><?PHP echo $id_curso_moodle?></td></tr>
<tr><td align=right><strong>Nombre Curso Moodle</strong></td><td><u style="color:blue;cursor:hand;" onclick="window.navigate('view.php?id=<?PHP echo $id_curso_moodle?>')"><?PHP echo $nombre_moodle?></u></td></tr>
<tr><td align=right><strong>Fecha de Inicio</strong></td><td><?PHP echo $fecha_inicio?></td></tr>
<tr><td align=right><strong>Tutor(es)</strong></td>
<td>
<?PHP

$sqx='SELECT userid, firstname, lastname From mdl_user_teachers A left join mdl_user B on userid=B.id Where course=' . $id_curso_moodle ;
$profes = pg_query($sqx) or die('Query failed: ' . pg_last_error());

while($rot=pg_fetch_array($profes)) 
	{
	$proxe =$rot["firstname"]. ', '. $rot["lastname"];
    $proxe_upper=strtoupper ($proxe);
    echo $proxe_upper;
    echo '<BR>';
	}
?>


</td>
</tr>

</table>
<BR>

<input type="button" value="Editar Acta" onclick="editar_acta();" /><BR /><BR>

<table cellpadding="2" cellspacing="2" border="1" bordercolor='gray'>
<TR bgcolor="#dddddd">
<td ><strong>N&deg;</strong></td>
<td align=right><strong>Id Moodle</strong></td>
<td align=center><strong>Id SINFO</strong></td>
<td><strong>Apellidos, Nombres</strong></td>
<td><strong>Camp</strong></td>
<td><strong>NRC</strong></td>
<td><strong>Periodo</strong></td>
<td><strong>Bloque</strong></td>
<td><strong>Carrera</strong></td>
<td><strong>NOTA</strong></td>
<td><strong>Estado</strong></td>
</TR>

<?PHP
$c1=0;
$total_ap=0;
$total_de=0;
$total_re=0;
$total_np=0;

while($row=pg_fetch_array($result)) 
	{
	$id_userx=$row["userid"];
	$c1++;
    $stax=$row["estado"];
    $statux="";
	$estilo="";
if ($stax=="AP")
   {$statux="Aprobado";
	$total_ap++;
    $estilo='style="color:blue"';}
if ($stax=="RE")
   {$statux="Retirado";
	$total_re++;}
if ($stax=="DE")
   {$statux="Desaprobado";
	$total_de++;}
if ($stax=="NP")
   {$statux="No particip&oacute;";
	$total_np++;}

?>
<TR>


<td align=right><?php echo $c1 ?>&nbsp;</td>
<td align=right><?php echo $row["userid"] ?>&nbsp;</td>
<td align=right><?php echo $row["pidm_banner"] ?></td>
<td><?PHP echo $row["lastname"].', '. $row["firstname"] ?>&nbsp;</td>
<td><?php echo $row["camp"] ?></td>
<td align=center><?php echo $row["nrc"] ?></td>
<td align=left><?php echo $row["periodo"] ?></td>
<td align=center><?php echo $row["bloque"] ?></td>
<td align=center><?php echo $row["carr"] ?></td>
<td align="right" <?PHP echo $estilo ?>><?php echo $row["nota"] ?>&nbsp;</td>
<td <?PHP echo $estilo ?>><?php echo $statux ?>&nbsp;</td>


</TR>
<?PHP
}

?>
</table>
<BR />

<table cellpadding="1" cellspacing="1" border="1">
<TR><TD align=right>Aprobados</TD><TD align=right>&nbsp;<?PHP echo $total_ap?></TD></TR>
<TR><TD align=right>Desaprobados</TD><TD align=right>&nbsp;<?PHP echo $total_de?></TD></TR>
<TR><TD align=right>Retirados</TD><TD align=right>&nbsp;<?PHP echo $total_re?></TD></TR>
<TR><TD align=right>No participaron</TD><TD align=right>&nbsp;<?PHP echo $total_np?></TD></TR>
<TR><TD align=right><strong>INSCRITOS</strong></TD><TD align=right>&nbsp;<strong><?PHP echo $c1?></strong></TD></TR>
</table>

<br><br>
<strong style="color:blue">Estad&iacute;sticas por Campus - Carrera</strong>
<table cellpadding="1" cellspacing="1" border="1" bordercolor="gray">
<TR bgcolor="#dddddd"><td><strong>Camp</strong></td><td><strong>Campus</strong></td><td><strong>Carr</strong></td><td><strong>Carrera</strong></td><td><strong>Estado</strong></td><td><strong>Alumnos</strong></td></tr>
<?PHP
$total2=0;
while($rof=pg_fetch_array($resultx)) 
{
$stax='';
if ($rof["estado"]=='AP'){$stax='Aprobado';}
if ($rof["estado"]=='DE'){$stax='Desaprobado';}
if ($rof["estado"]=='NP'){$stax='No Particip&oacute;';}
if ($rof["estado"]=='RE'){$stax='Retirado';}

$total2=$total2+1-1+$rof["total"];

   
echo '<tr>';
echo '<td align=center>&nbsp;'. $rof["camp"] . '&nbsp;</td><td>'.$rof["nombre_centro"]. '&nbsp;</td><td align=center>&nbsp;'. $rof["carr"]. '&nbsp;</td><td>'. $rof["materia_desc"]. '&nbsp;</td><td>' .   $stax . '&nbsp;</td><td align=right>'.$rof["total"]. '</td>';
echo '</tr>';
}
echo '<tr>';
echo '<td align=right colspan=5><strong>TOTAL</strong>&nbsp;</td><td align=right><strong>' . $total2 .'</strong></td>';
echo '</tr>';
echo '</table>';
?>

<br><br>
<strong style="color:blue">Estad&iacute;sticas por CAMPUS</strong>
<table cellpadding="1" cellspacing="1" border="1" bordercolor="gray">
<TR bgcolor="#dddddd"><td><strong>Camp</strong></td><td><strong>Campus</strong></td><td><strong>Estado</strong></td><td><strong>Alumnos</strong></td></tr>
<?PHP
$total3=0;
while($roj=pg_fetch_array($resultz)) 
{
$stax='';
if ($roj["estado"]=='AP'){$stax='Aprobado';}
if ($roj["estado"]=='DE'){$stax='Desaprobado';}
if ($roj["estado"]=='NP'){$stax='No Particip&oacute;';}
if ($roj["estado"]=='RE'){$stax='Retirado';}

$total3=$total3+1-1+$roj["total"];

   
echo '<tr>';
echo '<td align=center>&nbsp;'. $roj["camp"] . '&nbsp;</td><td>'.$roj["nombre_centro"]. '&nbsp;</td><td>' .   $stax . '&nbsp;</td><td align=right>'.$roj["total"]. '</td>';
echo '</tr>';
}
echo '<tr>';
echo '<td align=right colspan=3><strong>TOTAL</strong>&nbsp;</td><td align=right><strong>' . $total3 .'</strong></td>';
echo '</tr>';
echo '</table>';
?>



<form name="thisform" id="thisform" method="post" action="ha_cursos.php">
<input type=hidden name="id_csen" id="id_csen" value="<?PHP echo $id_csen?>"/>
<input type=hidden name="nombre_csen" id="nombre_csen" value="<?PHP echo $nombre_csen?>"/>
<input type=hidden name="id_curso_moodle" id="id_curso_moodle" value="<?PHP echo $id_curso_moodle?>"/>
<input type=hidden name="fecha_inicio" id="fecha_inicio" value="<?PHP echo $fecha_inicio?>"/>
<input type=hidden name="nombre_moodle" id="nombre_moodle" value="<?PHP echo $nombre_moodle?>"/>



</form>

<?PHP
print_footer();
?>
<script language="javascript">


function editar_acta() {
thisform.action="ha_cursos_acta_edicion.php";
thisform.submit();
}

function numeros(){
// solo acepta numeros
wek=window.event.keyCode;
if (wek<48 || wek>57){window.event.keyCode=0;}
}

function trim(str)
{
if(!str || typeof str != "string")
return "";
return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
}

</script>
<?PHP
}
else
{
echo "Debe ser administrador para entrar a esta página";
}
?>