<?PHP
    require_once("../config.php");
    require_once("lib.php");

	$site = get_site();
    $id=required_param('id');              // course id
	
	$id_cursox=$id;
    $id_usuario=$USER->id;
	
	//Verifico si el curso tiene grupos ($tiene_grupos=="1" -> "Este curso tiene grupos")
	$qexist='SELECT COALESCE((Select 1 from mdl_groups A inner join mdl_groups_members on groupid=A.id where courseid='. $id_cursox . ' LIMIT 1),0) as "existe"';
	$result_existe = pg_query($qexist) or die('Query failed: ' . pg_last_error());
	$roxg=pg_fetch_array($result_existe);
	$tiene_grupos=$roxg["existe"];
	
	//Verifico si tiene Ponderaciones
	$query1='SELECT COALESCE((Select 1 from senati_pesos_recursos where id_curso='. $id_cursox . ' LIMIT 1),0) as "tiene_pond"';
	$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
	$rox=pg_fetch_array($result1);
	if ($rox["tiene_pond"]=="0")
		 {$existe_ponderacion=false;}
	else
		 {$existe_ponderacion=true;}
	
	$query0 = 'SELECT fullname,subsanacion, presencial, induccion,id_publico, id_tarea_induccion FROM mdl_course where id='. $id_cursox;
	$result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
	$rox0=pg_fetch_array($result0);
	
	$permite_subsanacion=false;
	

	$nombre_curso=$rox0["fullname"];
	$subx=$rox0["subsanacion"];
	$indux=$rox0["induccion"];
	$id_publico=$rox0["id_publico"];
	$presencial=$rox0["presencial"];
	$id_tarea_induccion=$rox0["id_tarea_induccion"];

	/// 5 es trabajador de SENATI
	/// 3 es Alumno de SENATI (DUAL)
	
	$es_susbanacion="";
	$es_presencial="";
	$es_induccion="";
	$id_publico="0";
	
	
	if ($presencial=="s")
	   {$es_presencial="SI";
	    $mensaje_head="ESTE ES UN CURSO PRESENCIAL.";
	   }
	
	
	if ($subx=="s")
	   {$es_susbanacion="SI";
	   $mensaje_head="ESTE ES UN CURSO DE SUBSANACION.";
	   }
	else
	   {$es_susbanacion="NO";}
	   
	if ($indux=="s")
	   {$es_induccion="SI";
	   $mensaje_head="ESTE ES UN CURSO DE INDUCCION.";
	   }
	else
	   {$es_induccion="NO";}   
	
    if ($id_publico=="5")
       {$mensaje_head="ESTE ES UN CURSO PARA TRABAJADORES DEL SENATI, LA NOTA APROBATORIA ES MAYOR O IGUAL A 13.";}

    if ($es_susbanacion!="s" && $presencial!="s" && $es_induccion=="NO" && $publico=="3")
	   {$permite_subsanacion=true;}

	$titulo_pagina = "Reporte de Evidencias Completas";
	$enlace="<a href='view.php?id=". $id_cursox . "'>". $nombre_curso . "</a> &gt; " . $titulo_pagina; 
	print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");

///// asi saco el id de la instancia PARA EDITAR CALIFICACIONES EN TAREAS ////////////////

///Select id from mdl_course_modules where course=942 and module=1 and instance=1877 

// EL instance es el id de la tabla asignment 

/// EL ENLACE SERIA : http://virtual.senati.edu.pe/mod/assignment/submissions.php?id=25893

	
$iz=1;
while ($iz<10)
	{
	$total_tarea_falta_calificar[$iz]=0;
	$total_tarea_no_envio[$iz]=0;
	$total_tarea_ok[$iz]=0;
	
	$total_quiz_no_intento[$iz]=0;
	$total_quiz_ok[$iz]=0;
	
	$total_foro_falta_calificar[$iz]=0;
	$total_foro_no_posteo[$iz]=0;
	$total_foro_ok[$iz]=0;
	$iz++;
	}	

// TABLA senati_pesos_recursos
// id_recurso id de mdl_quiz (id y COURSE) o de mdl_assignment (id y COURSE)
// tipo_recurso assignment o quiz
// peso_recurso
// id_curso
?>
<BR>
<?PHP

$query  = 'SELECT A.userid, firstname, lastname, A.camp,nombre_centro, A.bloque, status_sinfo, email, B.pidm_banner, ';
$query .= '(Select name from mdl_groups C ';
$query .= 'inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid ';
$query .= 'where C.courseid=A.course LIMIT 1) as grupo ';
$query .= 'From mdl_user_students A  ';
$query .= 'left join mdl_user B on A.userid=B.id ';
$query .= 'left join senati_centros on id_centro=camp  ';
$query .= 'Where A.course='. $id_cursox .' order by 7,10,lastname, bloque ';

$result = pg_query($query) or die('Query failed: ' . pg_last_error());
//lista_grupos_estudiantes
?>

<?PHP
if ($existe_ponderacion==false)
	 {
	  echo '<BR>Este Curso todavia NO TIENE PONDERACIONES. No se podr&aacute; generar el reporte.<BR>';
	 }
else
{	 
?>	

<TABLE border=1 cellspacing=1 cellpadding=2 bordercolor="gray">
<TR bgcolor=#dddddd>
<TD><strong>Tutores</strong></TD>
<TD><strong>Grupos</strong></TD>
<TD><strong>Total Grupos</strong></TD>
</TR>

<?PHP

//$sqx  ='SELECT A.userid, firstname, lastname From mdl_user_teachers A left join mdl_user B on A.userid=B.id where A.course=' . $id_cursox ;

$sqx  ='SELECT A.userid, firstname, lastname, ';
$sqx .='(Select count(*) from mdl_groups C inner join mdl_groups_members D on D.groupid=C.id where C.courseid=A.course and D.userid=A.userid) as tot_grupos ';
$sqx .='From mdl_user_teachers A ';
$sqx .='left join mdl_user B on A.userid=B.id ';
$sqx .='where A.course=' . $id_cursox . ' order by 4 desc,2 ';

$profes = pg_query($sqx) or die('Query failed: ' . pg_last_error());

while($rotutor=pg_fetch_array($profes)) 
	{
	$tox_grupos=$rotutor["tot_grupos"];
	$proxe_id=$rotutor["userid"];
	$proxe=$rotutor["lastname"]. ', '. $rotutor["firstname"];
    $proxe_upper=strtoupper($proxe);
	echo "<TR>";
	echo "<TD>". $proxe_upper . "</TD>";
	
	//aca selecciono los grupos del tutor
	if ($tiene_grupos=="1" && $tox_grupos !="0")
	    {
		echo "<TD><SELECT>";
		$sql_group ="Select A.id, A.name from mdl_groups A inner join mdl_groups_members B on B.groupid=A.id where A.courseid=". $id_cursox . " and B.userid=" .$proxe_id. " order by A.name";
		$res_grupos = pg_query($sql_group) or die('Query failed: ' . pg_last_error());
		while($rot_grupos=pg_fetch_array($res_grupos))
			{
			
			$nom_grupo=$rot_grupos["name"];
			$id_grupo=$rot_grupos["id"];
			echo "<OPTION value='" . $id_grupo . "'>". $nom_grupo . "</OPTION>";
			}	
		echo "</SELECT></TD>";
		echo "<TD align=right>" . $tox_grupos."</TD>";
		}
	else
		{
		echo "<TD>No Tiene</TD><TD align=right>0</TD>";
		}
	echo "</TR>";
	}
?>

</TABLE>
<BR>
<strong><font color=red>NOTA IMPORTANTE : En la Tabla abajo mostrada se puede identificar al Tutor del GRUPO usando la tabla de arriba.</font></strong>
<BR><BR>



<?PHP

//JUSCE 8 de JULIO 2012
echo "<STRONG style='font-size:17px'><font color=green>". $mensaje_head ."</font></STRONG><BR><BR>";


/// JUSCE 3 de Julio 2013
if (isadmin())
{

	/*$es_susbanacion="";
	$es_presencial="";
	$es_induccion="";
	$id_publico="5"; -> PERSONAL SENATI
	*/
	
	if ($id_publico=="5" && $es_induccion!="SI")
		{
		//CURSO PARA TRABAJADORES QUE NO SEA INDUCCION
		echo "<a target=_blank href='http://virtual.senati.edu.pe/grade/acta_notas_personal_senati.php?id=".$id_cursox."'><u>Pasar a Historia Academica (Trabajadores)</u></a><BR><BR>";
		}
	else if ($es_susbanacion=="SI")
		{
		//CURSO SUBSANACION
		echo "<a target=_blank href='http://virtual.senati.edu.pe/grade/acta_notas03.php?id=".$id_cursox."'><u>Pasar a Historia Academica (Subsanaci&oacute;n)</u></a><BR><BR>";
		}
	else 
		{
		// aca viene induccion, presencial o regular
		//CURSO PRESENCIAL O REGULAR
		echo "<a target=_blank href='http://virtual.senati.edu.pe/grade/acta_notas02.php?id=".$id_cursox."'><u>Pasar a Historia Academica (Regular, Presencial o Inducci&oacute;n)</u></a><BR><BR>";
		}	

}

///////////////////// JUSCE 9 de NAYO 2012

$total_aprobados=0;
$total_desaprobados=0;
$total_pasan_a_subsa=0;
$total_ya_no_pasan_a_subsa=0;	

$total_aprobados_ret=0;
$total_desaprobados_ret=0;
$total_pasan_a_subsa_ret=0;
$total_ya_no_pasan_a_subsa_ret=0;	
	
	
	
?>	

<em>Los criterios para pasar a SUBSANACION son : el % de evidencias entregadas debe ser mayor a 40% y la nota obtenida MAYOR a 4.</em><BR>
<em>Los Cursos de INDUCCION NO TIENEN SUBSANACION al igual que los mismos cursos de SUBSANACION, PRESENCIALES O TRABAJADORES.</em><BR>
<TABLE border=1 cellspacing=1 cellpadding=1 bordercolor="gray">
<TR bgcolor=#dddddd height=23>
<td><STRONG style="color:blue">Id SINFO</strong></td>
<td><STRONG style="color:blue">Id SV</strong></td>
<td><STRONG style="color:blue">Apellidos, Nombres</strong></td>
<td><STRONG style="color:blue">Email</strong></td>
<td><STRONG style="color:blue">Status SINFO</strong></td>
<td><STRONG style="color:blue">Grupo</strong></td>
<td><STRONG style="color:blue">Campus</strong></td>
<td><STRONG style="color:blue">Bloque</strong></td>
<?PHP

$total_evidencias=0;
$total_evidencias_reales=0;

// CREO LOS TDs
// TAREAS O ASSIGNMENTS

// Performing SQL query
$query2 = 'SELECT distinct(A.id),assignmenttype, peso_recurso,name FROM mdl_assignment A left Join senati_pesos_recursos on id_recurso=id and tipo_recurso=1 where peso_recurso<>0 and course='. $id_cursox . ' order by A.id';
$result2 = pg_query($query2) or die('Query failed: ' . pg_last_error());

$c4=0;
$total_tareas=0;
while($row2=pg_fetch_array($result2)) {

	$c4++;

	$id_asignacion=$row2["id"];
	$peso_recurso=$row2["peso_recurso"];
	
	if ($peso_recurso!="0" && $peso_recurso!="")
	    {$total_evidencias++;
	}

	
		
	$total_tareas++;
	$nombre_tarea[$total_tareas]=$row2["name"];

	//JUSCE 3 ABRIL 2012
	// JUSCE FEBRERO 24 del 2014, la tareas offlines son evidencias a considerar en el total de evidencias
	if ($row2["assignmenttype"]=="offline")
	   {$tipo_tarea="<BR><font color=red>(Tarea Offline)</font>";
	   if ($peso_recurso!="0" && $peso_recurso!="")
	    {$total_evidencias_reales++;}
	   }
	else
	   {$tipo_tarea="";
	   //JUSCE 18 de SEPTIEMBRE 2012
	   // JUSCE FEBRERO 24 del 2014, la tareas offlines son evidencias a considerar en el total de evidencias
	   if ($peso_recurso!="0" && $peso_recurso!="")
	    {$total_evidencias_reales++;}
	   }

	   
	   
	   
	/*
	Si no tiene nota es una evidencia no entregada
	Si tiene cero es una evidencia no entregada
	Si tiene nota yes <>0 es una evidencia entregada
	*/   
	   

	?>
	<td style="color:green;cursor:default" title="Tarea <?PHP echo $c4 ?>"><?php echo $row2["name"] ?>
	<?PHP echo $tipo_tarea ?>
	<BR>
	Peso : <?php echo $peso_recurso ?>%<BR>
	<font color=black style="font-size:11px">(id_tar=<?php echo $id_asignacion ?>)</font>
	</td>
<?PHP
}
?>


<?PHP

//QUIZ
// Performing SQL query
//$query5 = "SELECT distinct(A.id), peso_recurso, name  FROM mdl_quiz A left Join senati_pesos_recursos on id_recurso=id and tipo_recurso=2 where (peso_recurso<>0 or UPPER(A.name) like 'SUBSA%') and A.course=". $id_cursox . " order by A.id";
$query5 = "SELECT distinct(A.id), peso_recurso, name  FROM mdl_quiz A left Join senati_pesos_recursos on id_recurso=id and tipo_recurso=2 where UPPER(A.name) not like 'SUBSA%' and (peso_recurso<>0 or peso_recurso is not null) and A.course=". $id_cursox . " order by A.id";
$result5 = pg_query($query5) or die('Query failed: ' . pg_last_error());
// Printing results in HTML

$c15=0;
$total_quiz=0;
while($row5=pg_fetch_array($result5)) {
	$c15++;

	$peso_recurso=$row5["peso_recurso"];

	if ($peso_recurso!="0" && $peso_recurso!="")
		{$total_evidencias++;
		$total_evidencias_reales++;
		}


	if ($peso_recurso=="" || $peso_recurso=="0")
	    {$peso_recurso="N/A";}
	else
	   {$peso_recurso=$peso_recurso . ' %';}	

	$total_quiz++;
	$nombre_quiz[$total_quiz]=$row5["name"];

	?>
	<td style="color:blue;cursor:default" title="Cuestionario <?PHP echo $c15 ?>"><?php echo $row5["name"] ?>
	<BR>Peso : <?php echo $peso_recurso ?></td>
<?PHP
}
?>


<?PHP
//////////////////////////////////// FOROS ////////////////////////////////////////
$query7 = 'SELECT distinct(A.id), peso_recurso,name  FROM mdl_forum A left Join senati_pesos_recursos on id_recurso=a.id and tipo_recurso=3 where peso_recurso<>0 and course='. $id_cursox . ' and a.scale=20 order by A.id';
$result7 = pg_query($query7) or die('Query failed: ' . pg_last_error());
// Printing results in HTML

$c7=0;

$total_foros=0;
while($row7=pg_fetch_array($result7)) {
	$c7++;
	$id_foro=$row7["id"];
	$peso_recurso=$row7["peso_recurso"];
	$nombre_foro=$row7["name"];
	$total_foros++;
	$nombre_forox[$total_foros]=$nombre_foro;
	
	?>

	<td style="color:green;cursor:default" title="<?PHP echo $nombre_foro ?>" >
	<?php //echo "Foro ". $c7 ?>
	<?PHP echo $nombre_foro ?>
	<BR>
	<?PHP
	if ($peso_recurso!="0" && $peso_recurso!="")
		{$total_evidencias++;
		$total_evidencias_reales++;
		}
	?>

	Peso : <?php echo $peso_recurso ?>%</td>
<?PHP
}
?>

<TD align=center><strong>Evidencias Entregadas</strong></TD>
<TD align=center><strong>% Evidencias Entregadas</strong></TD>
<TD align=center><strong>PROMEDIO PONDERADO</strong></TD>
<TD align=center><strong>ESTADO ACTUAL</strong></TD>

</TR>

<TR><TD align=center bgcolor=yellow colspan=8><strong style="font-size:15px">TOTAL EVIDENCIAS ENTREGABLES : <?PHP echo $total_evidencias_reales ?></strong></TD></TR>

<?php
$c1=0;

    $total_retirados=0;
while($row=pg_fetch_array($result))	{
	
	$evidencias_entregadas=0;
	$evidencias_entregadas_reales=0;
	
	//Aca tengo que obtener la calificacion 
	$id_userx=$row["userid"];
	$c1++;
	$retiradox=false;
	if ($row["status_sinfo"]=="RET")
       {$total_retirados++;
	   $retiradox=true;
	   }
	   
	   
	$nombre_alumno=$row["lastname"].", ".$row["firstname"];
?>
<TR>
<td align=right><?php echo $row["pidm_banner"] ?></td>
<td align=right><?php echo $id_userx ?></td>

<td><a href="http://virtual.senati.edu.pe/user/view.php?id=<?PHP echo $id_userx ?>&course=1" target=_blank><u><?PHP echo $nombre_alumno ?></u></a></td>
<td><?php echo $row["email"] ?></td>

<td align="center">&nbsp;<strong style="color:red"><?PHP echo $row["status_sinfo"] ?></strong>&nbsp;</td>
<td><?php echo $row["grupo"]

//ACA DEBO PONER AL TUTOR TAMBIEN !!!!!!!!!!!!!!!!!!!!!!!!!!!!



 ?>
 
 </td>
<td><?php echo $row["nombre_centro"] ?></td>
<td><?php echo $row["bloque"] ?></td>

<?PHP

////////////////////////////////////// ACA COMIENZA EL CONTEO /////////////////////////////////
////////////////////////////////////// TAREAS O ASSIGNMENTS   /////////////////////////////////
/// ACA COMIENZO A CALCULAR NOTAS JUSCE
//  LISTA DE NOTAS

$lista_notas_ok="";
$lista_notas_bad="";
$nota_acumulada=0;//unused
$suma_ponderada=0;

//$query3 = 'SELECT * FROM mdl_assignment A left Join mdl_assignment_submissions B on A.id=B.assignment left Join senati_pesos_recursos on id_recurso=B.assignment and tipo_recurso=1 where peso_recurso<>0 and id_curso='. $id_cursox . ' and userid='. $id_userx . ' order by A.id';
//$query3 = 'SELECT distinct(A.id), B.Grade, A.GRADE as "nota_maxima", peso_recurso, B.numfiles FROM mdl_assignment A left Join mdl_assignment_submissions B on A.id=B.assignment and userid='. $id_userx . ' left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 where peso_recurso<>0 and id_curso='. $id_cursox .' order by A.id';

/*$query3  ='SELECT distinct(A.id), B.Grade, A.GRADE as "nota_maxima", peso_recurso, B.numfiles, D.id as id_link, assignmenttype,B.timemodified, B.timemarked ';
$query3 .='FROM mdl_assignment A ';
$query3 .='left Join mdl_assignment_submissions B on A.id=B.assignment and userid='. $id_userx . ' ';  
$query3 .='left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 ';
$query3 .='left join mdl_course_modules D on D.course=id_curso and D.module=1 and D.instance=A.id ';
$query3 .='where peso_recurso<>0 and id_curso='. $id_cursox . ' order by A.id';
*/


/* ESTE QUERY FUNKA BACAN

SELECT distinct(A.id), max(B.Grade) as Grade, A.GRADE as "nota_maxima", peso_recurso, B.numfiles, D.id as id_link, assignmenttype,max(B.timemodified) as timemodified , max(B.timemarked) as timemarked
FROM mdl_assignment A 
left Join mdl_assignment_submissions B on A.id=B.assignment and userid=44414
left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1
left join mdl_course_modules D on D.course=id_curso and D.module=1 and D.instance=A.id
where peso_recurso<>0 and id_curso=1430
group by A.id, A.grade, peso_recurso, B.numfiles, D.id, assignmenttype
order by A.id
*/

/// JUSCE 18 de SEPTIEMBRE 2012

$query3  ='SELECT distinct(A.id), max(B.Grade) as Grade, A.GRADE as "nota_maxima", peso_recurso, B.numfiles, D.id as id_link, assignmenttype, max(B.timemodified) as timemodified , max(B.timemarked) as timemarked ';
$query3 .='FROM mdl_assignment A ';
$query3 .='left Join mdl_assignment_submissions B on A.id=B.assignment and userid='. $id_userx . ' ';  
$query3 .='left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 ';
$query3 .='left join mdl_course_modules D on D.course=id_curso and D.module=1 and D.instance=A.id ';
$query3 .='where peso_recurso<>0 and id_curso='. $id_cursox . ' ';
$query3 .=' group by A.id, A.grade, peso_recurso, B.numfiles, D.id, assignmenttype order by A.id';

//DEBO SABER SI LA TAREA ES OFFLINE
// JUSCE 3 DE ABRIL 2012



$result3 = pg_query($query3) or die('Query failed: ' . pg_last_error());

// El grade de mdl_assignment es el MAXIMO DE NOTA
// El Grade de mdl_assignment_submissions es la NOTA

//DEBO OBTENER LA SUMA AL FINAL
$numero_de_tarea=0; 
while($row3=pg_fetch_array($result3)) {
	$numero_de_tarea++;
	$nota=$row3["grade"];
	$nota_maxima=$row3["nota_maxima"];
	$id_link=$row3["id_link"];
	$faraxi=false;
	$tipo_de_tarea=$row3["assignmenttype"];
	//offline, uploadsingle
			
	$linkix="http://virtual.senati.edu.pe/mod/assignment/submissions.php?id=". $id_link ."&userid=". $id_userx ."&mode=single&offset=2";

	//ACA SE SABE SI SUBIO ARCHIVOS
	//PERO DEBO SABER SI ES QUE LA TAREA ES OFFLINE PUES De SER ASI SE DEBE PONER FALTA CALIFICAR EN LUGAR DE NO ENVIO
	$numfiles=trim($row3["numfiles"]);
   
	if ($nota_maxima > 0)
	   {$nota=20*$nota/$nota_maxima;}
	else
	   {$nota=0;}

	if ($nota < 0)
	   {$nota=0;}

	if ($nota== 0 || $nota==-1 ||	$nota=='')
	   {$nota=0;}
	else
	   {$suma_ponderada=$suma_ponderada + $nota*$row3["peso_recurso"];}

	$estilo_fondo="";
	$mesaf_tareas="";   
	
	/*if ($nota=="0")
       {
		$mesaf_tareas="";
	   }
	 */  
	

	//JUSCE 3 de JULIO 2012 Falta Recalificar
	$fecha_marked=1+1*$row3["timemarked"]-1;
	$fecha_modified=1+1*$row3["timemodified"]-1;
	
	///JUSCE CAMBIO ESTO 3 de JULIO  
	//if (($numfiles >="1" && number_format($nota,1) =="0.0") || ($row3["grade"]=="" && $tipo_de_tarea=="offline"))
	//if (($numfiles >=1 && $fecha_marked==0) || ($row3["grade"]=="" && $tipo_de_tarea=="offline"))
	
	if (($numfiles >=1 && $fecha_marked==0) || ($row3["grade"]=="" && $tipo_de_tarea=="offline") || ($numfiles >=1 && $row3["grade"]=="-1"))
	  {
	  $mesaf_tareas="<a target=_blank href='". $linkix. "'><font color=blue><u>Falta calificar</u></font></a>";
	  $estilo_fondo="bgcolor=yellow";
	  $faraxi=true;
	  }

	//JUSCE 3 de JULIO 2012 Falta Recalificar
	
	
	
	
	if ($numfiles >="1" &&  $fecha_marked!=0 && $fecha_marked < $fecha_modified)
	   {
	   $mesaf_tareas=number_format($nota,1). "&nbsp;<a target=_blank href='". $linkix. "'><font color=blue><u>Falta Recalificar</u></font></a>";
	   $estilo_fondo="bgcolor=yellow";
	   $faraxi=true;
	   }
    //FIN JUSCE 3 de JULIO 2012 Falta Recalificar   
	  
 
	if($numfiles*1+1-1==0)
	  {
		  if ($tipo_de_tarea != "offline")
			  {
			  $mesaf_tareas="<font color=red>No envi&oacute; tarea</font>";
		  
			  }
	  }
	$zxy=0; 
	/// JUSCE 9 de ABRIL 2013
	//if (number_format($nota,1) != "0.0")
	/*if ($nota== "0")
       {
		$mesaf_tareas="";
	   }
	 */  
	/// FIN JUSCE 9 de ABRIL 2013   
	
	
	if($mesaf_tareas=="")
	  {
	  $mesaf_tareas=number_format($nota,1);
	  $total_tarea_ok[$numero_de_tarea]++;
	  $zxy=1;  
	  }
	//ACA PUENTE SI SUBIO TAREA CAMBIO JUSCE 3 de JULIO  
//	if ($nota !="0")  
	if ($nota !="0" && $mesaf_tareas=="")
		{$mesaf_tareas=number_format($nota,1);
		if ($zxy==0)
	       {$total_tarea_ok[$numero_de_tarea]++;}
		}

	  if($mesaf_tareas=="<font color=red>No envi&oacute; tarea</font>")
	  	 {$total_tarea_no_envio[$numero_de_tarea]++;}


	  if($faraxi==true)
	     {$total_tarea_falta_calificar[$numero_de_tarea]++;}
	  
	  /// 18 de SEPTIEMBRE 2012
	  if ($mesaf_tareas!="<font color=red>No envi&oacute; tarea</font>" && $tipo_de_tarea!="offline")
		 {$evidencias_entregadas++;
		  //$evidencias_entregadas_reales++;
		 }
		 
/////// JUSCE DEBO REVISAR LA NOTA DE LA TAREA 24 de FEBRERO 2014  ///////////////////////////////////////////////////		 
	
	// Si es offline y es mayor que cero se considera como que hizo la tarea SI es CERO o falta calificar es como que NO HIZO LA TAREA
	//$evidencias_entregadas_reales++;

	// PRIMERO VEO SI ES TAREA OFFLINE
	
	$nota_real=$row3["grade"]*1+1-1;
	
	if ($tipo_de_tarea=="offline")
	   {
		   if ($nota_real>0)
		   {$evidencias_entregadas_reales++;}
	   }
	else   
		{
		if ($numfiles*1+1-1 >=1)
		   {$evidencias_entregadas_reales++;}
		}

////// FIN 24 de FEBRERO /////////////////////////////////////////////////////////////////////////////////////////////////
	


	////JUSCE TAREAS  
	$lista_notas_ok=$lista_notas_ok . "," . $nota . "*" .$row3["peso_recurso"];
	$lista_notas_bad=$lista_notas_bad . "," . $nota . "*" .$row3["peso_recurso"];

	
	// 6 de Mayo 2013 si NO ENVIO TAREA PERO TIENE NOTA SE DEBE PONER LAS DOS COSAS	
	
    if (number_format($nota,1) != "0.0")
	   {
	   if ($mesaf_tareas=="<font color=red>No envi&oacute; tarea</font>")
		   {
		   $mesaf_tareas.="&nbsp;" . number_format($nota,1);
		   }
	   }
	 
	?>
	<td align=right nowrap <?PHP echo $estilo_fondo ?>><?php echo $mesaf_tareas ?></td>
<?PHP
}
?>

<?PHP
//////////////////////////////////////////////   QUIZ /////////////////////////////////

//$query6 = "SELECT distinct(A.id), B.Grade, A.GRADE as nota_maxima, peso_recurso FROM mdl_quiz A left Join mdl_quiz_grades B on A.id=B.quiz and userid=". $id_userx . " left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=2 where (peso_recurso<>0 or UPPER(A.name) like 'SUBSA%') and A.course=". $id_cursox ." order by A.id";
//$query6 = "SELECT distinct(A.id), B.Grade, A.GRADE as nota_maxima, peso_recurso FROM mdl_quiz A left Join mdl_quiz_grades B on A.id=B.quiz and userid=". $id_userx . " left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=2 where UPPER(A.name) not like 'SUBSA%' and (peso_recurso<>0 or peso_recurso is not null) and A.course=". $id_cursox ." order by A.id";

$query6 = "SELECT distinct(A.id), ";
$query6 .= "(select max(B.grade) from mdl_quiz_grades B where A.id=B.quiz and userid=". $id_userx . ") as nota_grade, ";
$query6 .= "A.GRADE as nota_maxima, peso_recurso  ";
$query6 .= "FROM mdl_quiz A  ";
$query6 .= "left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=2  ";
$query6 .= "where UPPER(A.name) not like 'SUBSA%' and (peso_recurso<>0 or peso_recurso is not null) ";
$query6 .= "and A.course=". $id_cursox;
$query6 .= " order by A.id  ";

$result6 = pg_query($query6) or die('Query failed: ' . pg_last_error());

//DEBO OBTENER LA SUMA AL FINAL 

// GRADE DE MDL_QUIZ es la nota maxima 
// GRADE DE MDL_GRADE es la nota 
$numero_de_quiz=0; 
while($row6=pg_fetch_array($result6)) 
	{
	
	$pesox=$row6["peso_recurso"];

	if ($pesox=="")
	   {$pesox=0;}

	$nota=$row6["nota_grade"];
	$nota_maxima=$row6["nota_maxima"];

	if ( $nota_maxima > 0)
	   {$nota=20*$nota/$nota_maxima;}
	else
	   {$nota=0;}

	if ( $nota < 0)
	   {$nota=0;}

	if ($nota== 0 || $nota==-1 ||	$nota=='')
		{$nota=0;}
	else
		{	
			$suma_ponderada=$suma_ponderada + $nota*$pesox;
			$evidencias_entregadas++;
			$evidencias_entregadas_reales++;
		}
	

	$numero_de_quiz++;		
	if (number_format($nota,1)=="0.0")
	   {
	   $s1="<font color=red>";
	   $s2="</font>";
	   }
	else
	   {
	   $s1="";
	   $s2="";
	   }
	if ($nota=="")
	   {$mesaq="<font color=red>No intent&oacute;</font>";
	   $total_quiz_no_intento[$numero_de_quiz]++;
	   }
	else
	   {$mesaq=$s1. number_format($nota,1). $s2;
	   $total_quiz_ok[$numero_de_quiz]++;
	   }


////JUSCE QUIZ  
	$lista_notas_ok=$lista_notas_ok . "," . $nota . "*" .$pesox;
	$lista_notas_bad=$lista_notas_bad . "," . $nota . "*" .$pesox;
	
	
?>
<td align=right><?php echo $mesaq  ?></td>
<?PHP
  }
?>

<?PHP
//////////////////////////////////// FOROS ////////////////////////////////////////
$query27 = 'SELECT distinct(a.id), scale, peso_recurso FROM mdl_forum a left Join senati_pesos_recursos on id_recurso=a.id and tipo_recurso=3 where peso_recurso<>0 and course='. $id_cursox . ' and a.scale=20 order by a.id';
$result27 = pg_query($query27) or die('Query failed: ' . pg_last_error());
// Printing results in HTML

$c27=0;
$numero_de_foro=0; 
while($row27=pg_fetch_array($result27)) 
	{
	$estilo_fondo="";
	$numero_de_foro++;
	$c27++;
	$id_foro=$row27["id"];
	$nota_maxima=$row27["scale"];
	
	///JUSCE ACA ESTO NO ESTABA ANTES del 22 MAYO 2012
	$peso_rec=$row27["peso_recurso"];

			//////////////////////////////////////////////   FOROS /////////////////////////////////
			$query9 = 'Select a.id as id_foro, b.id as discuss, c.userid, d.post, d.rating,peso_recurso from mdl_forum a ';
			$query9 .= 'left Join senati_pesos_recursos on id_recurso=A.id ';
			$query9 .= 'left join mdl_forum_discussions b on a.id=b.forum ';
			$query9 .= 'left join mdl_forum_posts c on c.discussion=b.id ';
			$query9 .= 'left join mdl_forum_ratings d on d.post=c.id  Where a.course='. $id_cursox . ' and a.scale=20 and c.userid=' . $id_userx .' and a.id='.$id_foro;
			
			$result9 = pg_query($query9) or die('Query failed: ' . pg_last_error());
			
			//DEBO OBTENER LA SUMA AL FINAL : CAMBIAR A NOTA MAS ALTA !!!!!!!!!!!!!!!!!!!!!!!!!!!!
			$nota_mas_alta=0;
			$tnf=0;
			$suma_nota_foro=0;
			///JUSCE ACA ESTO ESTABA ANTES del 22 MAYO 2012
			$pexo_recox=0;///ESTO ES SOLO PARA COMPARAR
			$total_posts=0;
			while($row9=pg_fetch_array($result9))  {
				$id_discuss=$row9["discuss"];
				$total_posts++;
				$notax=$row9["rating"];
				if ( $nota_maxima > 0)
				   {$notax=20*$notax/$nota_maxima;}
				else
				   {$notax=0;}
				
				if ($notax < 0)
				   {$notax=0;}
		
				if ($notax > $nota_mas_alta)
				   {$nota_mas_alta=$notax;}
		       
				$suma_nota_foro=$suma_nota_foro+1-1+$notax;
				///JUSCE ACA ESTO ESTABA ANTES del 22 MAYO 2012
				$pexo_recox=$row9["peso_recurso"];///ESTO ES SOLO PARA COMPARAR
				$tnf++;
			}	
			//////////// ACA DEBO OBTENER LA MAXIMA NOTA !!!!!!!!!!!!!!!!!!!!!!!!    
			    
			if ($tnf != 0)
			   {
			//$nota=$nota_mas_alta;
		   //$nota=$suma_nota_foro/$tnf;
			   if ($id_cursox > 523)
			   	   {$nota=$nota_mas_alta;}
			   else
					{$nota=$suma_nota_foro/$tnf;
					 /// esto es para promediar ANTES !!!!!!!!!!!! CURSOS DEL 2008 !!!!!!!!!
					}
			   	}
			else   
			   {$nota=0;}
			  
			if ($nota==0 || $nota==-1 || $nota=='')
			   {$nota=0;}
			else
				{
					$suma_ponderada=$suma_ponderada + $nota * $peso_rec;
					//$evidencias_entregadas++;
				}
			if ($total_posts !="0")
			   {$evidencias_entregadas++;
			   $evidencias_entregadas_reales++;
			   }
			   
			$nota_foro=number_format($nota,1);
			$mesa_foro="";
			
			if($total_posts=="" || $total_posts=="0")
			   {$mesa_foro="<font color=red>No poste&oacute;</font>";
			   $total_foro_no_posteo[$numero_de_foro]++;
			   }
			   
			if($total_posts>="1" && $nota_foro=="0.0"){
				//// JUSCE 14 ABRIL COMO OBTENER LA PAGINA DONDE NO SE CALIFICO EL FORO 
				/// http://virtual.senati.edu.pe/mod/forum/discuss.php?d=9550
			    // $id_discuss es el 9550
				$url_discuss="../mod/forum/discuss.php?d=" . $id_discuss; 
				
				////////// JUSCE 12 Noviembre 2012
				
				$mesa_foro="<a href='". $url_discuss. "' target=_blank title='". $nombre_alumno . "'><font color=blue><u>Falta Calificar</u></font></a>";
				$total_foro_falta_calificar[$numero_de_foro]++;
				$estilo_fondo="bgcolor=yellow";
			}
				
			if ($mesa_foro=="")
               {$mesa_foro=$nota_foro;
			   $total_foro_ok[$numero_de_foro]++;
			   }

////JUSCE FOROS  
	$lista_notas_ok=$lista_notas_ok . "," . $nota . "*" .$peso_rec;
	$lista_notas_bad=$lista_notas_bad . "," . $nota . "*" .$pexo_recox;
		   
?>
<td align=right nowrap <?PHP echo $estilo_fondo?>><?php echo $mesa_foro ?></td>
<?PHP
   }
?>
<td align=center><strong><?PHP echo $evidencias_entregadas_reales ?></strong></td>

<?PHP 

if ($total_evidencias_reales!="" && $total_evidencias_reales!="0")
    {$porcentrega=100*$evidencias_entregadas_reales/$total_evidencias_reales;}
	
if ($porcentrega>=40 && $suma_ponderada>=400 && $suma_ponderada<=1050 && $permite_subsanacion)
   {$mensajex="<font color=green>PASA A SUBSANACION</font>";}
else
   {
   if ($suma_ponderada>=1050)
       {$mensajex="<font color=blue>APROBADO</font>";}
   else
       {$mensajex="<font color=red>DESAPROBADO</font>";}
   }

if ($es_susbanacion=="SI")
  {
   if($suma_ponderada>=1050)
	   {$mensajex="<font color=blue>APROBADO</font>";}
   else
	   {$mensajex="<font color=red>DESAPROBADO</font>";}
  }
  
if ($presencial=="s")
  {
   if($suma_ponderada>=1050)
	   {$mensajex="<font color=blue>APROBADO</font>";}
   else
	   {$mensajex="<font color=red>DESAPROBADO</font>";}
  }


//ACA ES PARA TRABAJADORES
if ($id_publico=="5")
  {
   if( $suma_ponderada>=1300)
	   {$mensajex="<font color=blue>APROBADO</font>";}
   else
	   {$mensajex="<font color=red>DESAPROBADO</font>";}
  }

$porcentrega_round=round($porcentrega, 1);

$nota_finax=$suma_ponderada/100;

if ($suma_ponderada>="1041" && $suma_ponderada<="1049") 
   {$suma_ponderada="1040";}

$nota_finay=number_format($suma_ponderada/100,1);

if ($mensajex=="<font color=green>PASA A SUBSANACION</font>" && $nota_finay=="10.5")
   {$mensajex="<font color=blue>APROBADO</font>";}

if ($mensajex=="<font color=blue>APROBADO</font>" && $nota_finay=="10.4")
   {$nota_finay="10.5";}

   
if ($es_induccion=="SI" && $mensajex=="<font color=green>PASA A SUBSANACION</font>")   
   {$mensajex="<font color=red>DESAPROBADO</font>";}   
   
if ($es_susbanacion=="SI" && $mensajex=="<font color=green>PASA A SUBSANACION</font>")   
   {$mensajex="<font color=red>DESAPROBADO</font>";}   
   
//   {$mensajex="<font color=green>YA NO PASA A SUBSANACION</font>";}


   //// ACA PONGO EL CONTEO !!!!!!!!!!!
if (strrpos($mensajex,">APROBADO<")>2)
   {$total_aprobados++;}

if (strrpos($mensajex,">DESAPROBADO<")>2)
   {$total_desaprobados++;}

if (strrpos($mensajex,">PASA A SUBSANACION<")>2)
   {$total_pasan_a_subsa++;}
   

//if (strrpos($mensajex,">YA NO PASA A SUBSANACION<")>2)
//   {$total_ya_no_pasan_a_subsa++;}
   

/////////////////////

if (strrpos($mensajex,">APROBADO<")>2 && $retiradox)
   {$total_aprobados_ret++;}

if (strrpos($mensajex,">DESAPROBADO<")>2 && $retiradox)
   {$total_desaprobados_ret++;}

if (strrpos($mensajex,">PASA A SUBSANACION<")>2  && $retiradox)
   {$total_pasan_a_subsa_ret++;}
   

//if (strrpos($mensajex,">YA NO PASA A SUBSANACION<")>2  && $retiradox)
//   {$total_ya_no_pasan_a_subsa_ret++;}
   
?>

<td align=center><strong><?PHP echo $porcentrega_round ?> %</strong></td>
<td align=center><strong><?PHP echo $nota_finay ?></strong>
<?PHP
if ($id_usuario=="2")
	{
	$ax=1;
	//ACA PONGO EL CONTEO 1
	//echo "<BR>OK ";
	//echo $lista_notas_ok;
	//echo "<BR>BAD ";
	//echo $lista_notas_bad;
	}
?>
</td>
<td align=center><strong><?PHP echo $mensajex ?></strong></td>
</TR>
<?PHP		  
}
echo "</TABLE>";
}

?>
<BR><BR>


<!-- ACA NO CONSIDERA EN ALGUNOS CASOS -->

<TABLE border=1 cellspacing=1 cellpadding=3 bordercolor="gray">
<TR bgcolor=#dddddd>
<TD><strong>Tarea</strong></TD>
<TD><strong>Nombre Tarea</strong></TD>
<TD style="color:red">No enviaron tarea</TD>
<TD style="color:blue">Falta (Re)Calificar</TD>
<TD>Tienen Nota</TD>
<TD><strong>TOTAL</strong></TD>
</TR>
<?PHP
$ix=1;
while ($ix < $total_tareas+1)
	{
	$total=$total_tarea_no_envio[$ix]+ $total_tarea_falta_calificar[$ix]+$total_tarea_ok[$ix]+1-1;
	$estilacho="";
	if ($total_tarea_falta_calificar[$ix]!="0")
	   {$estilacho="bgcolor=yellow";}
	
	echo "<TR>";
	echo "<TD align=center>" .$ix . "</TD>";
	echo "<TD>". $nombre_tarea[$ix] . "</TD>";
	echo "<TD align=right>". $total_tarea_no_envio[$ix] . "</TD>";
	echo "<TD align=right ". $estilacho.">". $total_tarea_falta_calificar[$ix] . "</TD>";
	echo "<TD align=right>". $total_tarea_ok[$ix] . "</TD>";
	echo "<TD align=right>". $total . "</TD>";
	
	echo "</TR>";
	$ix++;
	}
?>
</TABLE>
<BR>

<TABLE border=1 cellspacing=1 cellpadding=3 bordercolor="gray">
<TR bgcolor=#dddddd>
<TD><strong>Cuestionario</strong></TD>
<TD><strong>Nombre Cuestionario</strong></TD>
<TD style="color:red">No intentaron</TD>
<TD>Tienen nota</TD>
<TD><strong>TOTAL</strong></TD>
</TR>
<?PHP
$ix=1;
while ($ix < $total_quiz+1)
	{
	$total=$total_quiz_no_intento[$ix]+$total_quiz_ok[$ix]+1-1;
	echo "<TR>";
	echo "<TD align=center>" .$ix . "</TD>";
	echo "<TD>". $nombre_quiz[$ix] . "</TD>";
	echo "<TD align=right>". $total_quiz_no_intento[$ix] . "</TD>";
	echo "<TD align=right>". $total_quiz_ok[$ix] . "</TD>";
	echo "<TD align=right>". $total . "</TD>";
	echo "</TR>";
	$ix++;
	}
?>
</TABLE>

<BR><BR>

<TABLE border=1 cellspacing=1 cellpadding=3 bordercolor="gray">
<TR bgcolor=#dddddd>
<TD><strong>Foro</strong></TD>
<TD><strong>Nombre Foro</strong></TD>
<TD style="color:red">No postearon</TD>
<TD style="color:blue">Falta Calificar</TD>
<TD>Tienen nota</TD>
<TD><strong>TOTAL</strong></TD>
</TR>
<?PHP
$ix=1;
while ($ix < $total_foros+1)
	{
	$total=$total_foro_no_posteo[$ix]+$total_foro_falta_calificar[$ix]+ $total_foro_ok[$ix] + 1-1;
	$estilacho="";
	
		if ($total_foro_falta_calificar[$ix]!="0")
	   {$estilacho="bgcolor=yellow";}
	
	echo "<TR>";
	echo "<TD align=center>" .$ix . "</TD>";
	echo "<TD>". $nombre_forox[$ix] . "</TD>";
	echo "<TD align=right>". $total_foro_no_posteo[$ix] . "</TD>";
	echo "<TD align=right ". $estilacho .">". $total_foro_falta_calificar[$ix] . "</TD>";
	echo "<TD align=right>". $total_foro_ok[$ix] . "</TD>";
	echo "<TD align=right>". $total . "</TD>";
	echo "</TR>";
	$ix++;
	}
?>
</TABLE>

<BR><BR>

<?PHP

$total_final=$total_aprobados+$total_desaprobados+$total_pasan_a_subsa+$total_ya_no_pasan_a_subsa;	
	
?>

<TABLE border=1 cellspacing=1 cellpadding=3 bordercolor="gray">
<TR>
<TD bgcolor="#dddddd"><strong>ESTADOS FINALES</strong></TD>
<TD bgcolor="#dddddd"><strong>TOTAL</strong></TD>
<TD bgcolor="#dddddd"><strong>RETIRADOS DE SINFO</strong></TD>
</TR>

<TR>
<TD align=right><strong><font color=blue>APROBADO</font></strong></TD>
<TD align=right><?PHP echo $total_aprobados?></TD>
<TD align=right><?PHP echo $total_aprobados_ret?></TD>
</TR>

<TR>
<TD align=right><strong><font color=red>DESAPROBADO</font></strong></TD>
<TD align=right><?PHP echo $total_desaprobados?></TD>
<TD align=right><?PHP echo $total_desaprobados_ret?></TD>
</TR>

<TR>
<TD align=right><strong><font color=green>PASA A SUBSANACION</font></strong></TD>
<TD align=right><?PHP echo $total_pasan_a_subsa?></TD>
<TD align=right><?PHP echo $total_pasan_a_subsa_ret?></TD>
</TR>

<!--TR>
<TD align=right><strong><font color=green>YA NO PASA A SUBSANACION</font></strong></TD>
<TD align=right><?PHP echo $total_ya_no_pasan_a_subsa?></TD>
<TD align=right><?PHP echo $total_ya_no_pasan_a_subsa_ret?></TD>
</TR-->
<TR>
<TD align=right><strong>TOTALES</strong></TD>
<TD align=right><strong><?PHP echo $total_final?></strong></TD>
<TD align=right><strong style="color:red"><?PHP echo $total_retirados?></strong></TD>
</TR>
</TABLE>

<?PHP 

if ($id_usuario=="2" && $es_induccion!="SI")
{
?>
<form name=forma_induccion id=forma_induccion method=post target=_blank action="inserta_notas_induccion.php">
<P>
<strong>Insertar/Actualizar Notas de Inducci&oacute;n</strong> (Extrae Notas del Curso de Inducci&oacute;n - el sistema lo busca)
<TABLE border=1 cellspacing=1 cellpadding=3 bordercolor="gray">
<tr>
<td>
<strong>ID_TAREA_INDUCCION</strong>
</td>
<td>


<input type=text value="<?PHP echo $id_tarea_induccion ?>" name=id_tarea_induccion id=id_tarea_induccion maxlength=5 size=5>
<input type=hidden value="<? echo $id_cursox?>" name=id_cursoy id=id_cursoy>
<input type=hidden value="<? echo $nombre_curso?>" name=nombre_cursoy id=nombre_cursoy>
</TD>
<td>
<INPUT type=submit value="Insertar o Actualizar Notas">
</td>
</TR>
</TABLE> 
</p>
</form>

<?PHP
}
?>

<?PHP
    print_footer($course);
?>