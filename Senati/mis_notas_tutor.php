<?PHP
    require_once("../config.php");
    require_once("lib.php");

	
	//// PARA LOS TUTORES
	
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
	
	$query0 = 'SELECT fullname,subsanacion, presencial, induccion,id_publico FROM mdl_course where id='. $id_cursox;
	$result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
	$rox0=pg_fetch_array($result0);
	
	$permite_subsanacion=false;
	

	$nombre_curso=$rox0["fullname"];
	$subx=$rox0["subsanacion"];
	$indux=$rox0["induccion"];
	$id_publico=$rox0["id_publico"];
	$presencial=$rox0["presencial"];
	
	/// 5 es trabajador de SENATI
	/// 3 es Alumno de SENATI (DUAL)
	
	//$id_usuario=$USER->id;
	
	if ($presencial=="s")
	   {$es_susbanacion="SI";
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

	$titulo_pagina = "Mis Notas - TUTOR";
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
/// esta es la lista de grupos del tutor especifico

$sql_grupos_user="Select A.id from mdl_groups A inner join mdl_groups_members B on B.groupid=A.id where A.courseid=". $id_cursox . " and B.userid=". $id_usuario;
$result_grupos = pg_query($sql_grupos_user) or die('Query failed: 113 ' . pg_last_error());

$grupitos="";

$cx=0;
while($roxos=pg_fetch_array($result_grupos)) 
{
if ($cx==0)
	{
	$grupitos=$roxos[id];
	}
else
	{
	$grupitos=$grupitos . "," . $roxos[id];
	}
$cx++;
}


if (isadmin())
	{
	$query  = 'SELECT A.userid, firstname, lastname, A.camp,nombre_centro, A.bloque, status_sinfo, email, B.pidm_banner, ';
	$query .= '(Select name from mdl_groups C ';
	$query .= 'inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid ';
	$query .= 'where C.courseid=A.course LIMIT 1) as grupo, ';
	$query .= '(Select H.id from mdl_groups H ';
	$query .= 'inner join mdl_groups_members G on G.groupid=H.id and G.userid=A.userid ';
	$query .= 'where H.courseid=A.course LIMIT 1) as id_grupo ';
	$query .= 'From mdl_user_students A  ';
	$query .= 'left join mdl_user B on A.userid=B.id ';
	$query .= 'left join senati_centros on id_centro=camp ';
	$query .= 'Where A.course='. $id_cursox .' order by 7,10,3,2';
	$result = pg_query($query) or die('Query failed: 145 ' . pg_last_error());
	}
else
{
// ES TUTOR
	$query  = 'Select * from ( ';
	$query .= 'SELECT A.userid, firstname, lastname, A.camp,nombre_centro, A.bloque, status_sinfo, email, B.pidm_banner, ';
	$query .= '(Select name from mdl_groups C ';
	$query .= 'inner join mdl_groups_members D on D.groupid=C.id and D.userid=A.userid ';
	$query .= 'where C.courseid=A.course LIMIT 1) as grupo, ';
	$query .= '(Select H.id from mdl_groups H ';
	$query .= 'inner join mdl_groups_members G on G.groupid=H.id and G.userid=A.userid ';
	$query .= 'where H.courseid=A.course LIMIT 1) as id_grupo ';
	$query .= 'From mdl_user_students A ';
	$query .= 'left join mdl_user B on A.userid=B.id ';
	$query .= 'left join senati_centros on id_centro=camp ';
	$query .= 'Where A.course='.$id_cursox . ') latam where id_grupo in ('.$grupitos. ') order by 7,10,3,2 ';
	$result = pg_query($query) or die('Query failed: 162 ' . pg_last_error());
}	
?>

<?PHP
if ($existe_ponderacion==false)
	 {
	  echo '<BR>Este Curso todavia NO TIENE PONDERACIONES. No se podr&aacute; generar el reporte.<BR>';
	 }
else
{	 
?>

<TABLE border=1 cellspacing=1 cellpadding=2 bordercolor="#b6dbed" style="display:none">
<TR bgcolor=#cccccc>
<TD><strong>Tutores del Curso</strong></TD>
<TD><strong>Grupos</strong></TD>
<TD><strong>Total Grupos</strong></TD>
</TR>
<?PHP

//$sqx  ='SELECT A.userid, firstname, lastname From mdl_user_teachers A left join mdl_user B on A.userid=B.id where A.course=' . $id_cursox;

$sqx  ='SELECT A.userid, firstname, lastname, ';
$sqx .='(Select count(*) from mdl_groups C inner join mdl_groups_members D on D.groupid=C.id where C.courseid=A.course and D.userid=A.userid) as tot_grupos ';
$sqx .='From mdl_user_teachers A ';
$sqx .='left join mdl_user B on A.userid=B.id ';
$sqx .='where A.course=' . $id_cursox . ' order by 4 desc,2 ';

$profes = pg_query($sqx) or die('Query failed: ' . pg_last_error());

$tutor_activo="";
while($rotutor=pg_fetch_array($profes)) 
	{
	$tox_grupos=$rotutor["tot_grupos"];
	$proxe_id=$rotutor["userid"];
	$proxe=$rotutor["lastname"]. ', '. $rotutor["firstname"];
    $proxe_upper=strtoupper($proxe);
	$estilacho="";
	if($proxe_id==$id_usuario)
	{
		$tutor_activo="<BR><strong>LISTA DEL TUTOR ". $proxe ."</STRONG><BR>";
		$estilacho="bgcolor=yellow";
	}
	
	
	echo "<TR>";
	echo "<TD ". $estilacho. ">". $proxe_upper . "</TD>";
	
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
			echo "<OPTION value='" . $id_grupo . "'>". $nom_grupo . " (". $id_grupo. ")</OPTION>";
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

<?PHP

//JUSCE 8 de JULIO 2012
//echo "<STRONG style='font-size:17px'><font color=green>". $mensaje_head ."</font></STRONG><BR><BR>";

///////////////////// JUSCE 9 de NAYO 2012

$total_aprobados=0;
$total_desaprobados=0;
$total_pasan_a_subsa=0;
$total_ya_no_pasan_a_subsa=0;	

$total_aprobados_ret=0;
$total_desaprobados_ret=0;
$total_pasan_a_subsa_ret=0;
$total_ya_no_pasan_a_subsa_ret=0;	
	
	

echo $tutor_activo;	
$cuenta=1;
?>	

<TABLE border=1 cellspacing=2 cellpadding=2 bordercolor="#b6dbed">
<TR bgcolor=#cccccc height=23>
<td><STRONG style="color:blue">N&deg;</strong></td>
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
while($row2=pg_fetch_array($result2)) 
	{

	$c4++;

	$id_asignacion=$row2["id"];
	$peso_recurso=$row2["peso_recurso"];

if ($peso_recurso!="0" && $peso_recurso!="")
    {$total_evidencias++;}
	


$total_tareas++;
$nombre_tarea[$total_tareas]=$row2["name"];

//JUSCE 3 ABRIL 2012

if ($row2["assignmenttype"]=="offline")
   {$tipo_tarea=" - <font color=red>(Tarea Offline)</font>";}
else
   {$tipo_tarea="";
   //JUSCE 18 de SEPTIEMBRE 2012
   $total_evidencias_reales++;
   }

   

?>
<td style="color:green;cursor:default" title="Tarea <?PHP echo $c4 ?>"><?php echo $row2["name"] ?>
<?PHP echo $tipo_tarea ?>
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
while($row5=pg_fetch_array($result5)) 
	{
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
<td style="color:blue;cursor:default" title="Cuestionario <?PHP echo $c15 ?>"><?php echo $row5["name"] ?></td>
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
while($row7=pg_fetch_array($result7)) 
	{
	$c7++;
	$id_foro=$row7["id"];
	$peso_recurso=$row7["peso_recurso"];
	$nombre_foro=$row7["name"];
	$total_foros++;
	$nombre_forox[$total_foros]=$nombre_foro;
	
?>

<td style="color:green;cursor:default" title="<?PHP echo $nombre_foro ?>" >
<?php echo "Foro ". $c7 ?>
<?PHP
if ($peso_recurso!="0" && $peso_recurso!="")
	{$total_evidencias++;
	$total_evidencias_reales++;
	}
?>

</td>
<?PHP
}
?>

<TD align=center><strong>Evidencias Entregadas</strong></TD>
<TD align=center><strong>% Evidencias Entregadas</strong></TD>
<TD align=center><strong>PROMEDIO PONDERADO</strong></TD>
<TD align=center><strong>ESTADO ACTUAL</strong></TD>

</TR>

<?php
$c1=0;

    $total_retirados=0;
while($row=pg_fetch_array($result)) 
	{
	
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

<td align=right><?php echo $cuenta ?></td>
<td align=right><?php echo $row["pidm_banner"] ?></td>
<td align=right><?php echo $id_userx ?></td>

<td><?PHP echo $nombre_alumno ?></td>
<td><?php echo $row["email"] ?></td>

<td align="center">&nbsp;<strong style="color:red"><?PHP echo $row["status_sinfo"] ?></strong>&nbsp;</td>
<td><?php echo $row["grupo"] 

//ACA DEBO PONER AL TUTOR TAMBIEN !!!!!!!!!!!!!!!!!!!!!!!!!!!!

 ?>
  
 </td>
<td><?php echo $row["nombre_centro"] ?></td>
<td><?php echo $row["bloque"] ?></td>

<?PHP
$cuenta++;

////////////////////////////////////// ACA COMIENZA EL CONTEO /////////////////////////////////
////////////////////////////////////// TAREAS O ASSIGNMENTS   /////////////////////////////////
/// ACA COMIENZO A CALCULAR NOTAS JUSCE
//  LISTA DE NOTAS

$lista_notas_ok="";
$lista_notas_bad="";
$nota_acumulada=0;
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
while($row3=pg_fetch_array($result3)) 
	{
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
	if (($numfiles >="1" && $fecha_marked==0) || ($row3["grade"]=="" && $tipo_de_tarea=="offline"))
	  {
	  $mesaf_tareas="<font color=blue>Falta calificar</font>";
	  $estilo_fondo="bgcolor=yellow";
	  $faraxi=true;
	  }

	//JUSCE 3 de JULIO 2012 Falta Recalificar
	
	
	
	
	if ($numfiles >="1" &&  $fecha_marked!=0 && $fecha_marked < $fecha_modified)
	   {
	   $mesaf_tareas=number_format($nota,1). "&nbsp;<font color=blue>Falta Recalificar</font>";
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
		  $evidencias_entregadas_reales++;
		 }

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
			while($row9=pg_fetch_array($result9)) 
				{
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
			   
			if($total_posts>="1" && $nota_foro=="0.0")
                {
				//// JUSCE 14 ABRIL COMO OBTENER LA PAGINA DONDE NO SE CALIFICO EL FORO 
				/// http://virtual.senati.edu.pe/mod/forum/discuss.php?d=9550
			    // $id_discuss es el 9550
				$url_discuss="../mod/forum/discuss.php?d=" . $id_discuss; 
				
				////////// JUSCE 12 Noviembre 2012
				
				$mesa_foro="<font color=blue>Falta Calificar</font>";
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









<?PHP
    print_footer($course);
?>