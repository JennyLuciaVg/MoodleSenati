<?PHP
    require_once("../config.php");
    require_once("lib.php");

	// NOTAS DE CURSOS CON EXAMENES PRESENCIALES PARA PASAR A CURSOS REGULARES

	$site = get_site();
    $id=required_param('id');              // course id
	
	$id_cursox=$id;
    $id_usuario=$USER->id;

	$accion=$_POST["th_accion"];
	
	if ($accion=="pasar notas")
		{
				/// FECHA ACTUAL PARA INGRESAR A LA BD		
				$ano_actual=date("Y");
				$mes_actual=date("n");
				$dia_actual=date("j");
				$hora_actual=date("H");
				$min_actual=date("i");
				
				$fecha_hora_actual=$dia_actual.'-'.$mes_actual.'-'.$ano_actual. ' ' . $hora_actual. ":".$min_actual;
				
				//ESTO ME DA LA HORA REAL QUE DEBO METER EN LA BD UNIX
				$fecha_hora_actual_integer = strtotime ($fecha_hora_actual);
		
		$notas_insert_01=0;
		$notas_update_01=0;
		$notas_insert_02=0;
		$notas_update_02=0;
		$ctx=0;
		
		$id_tarea_1=trim($_POST["id_tarea_1"]);
		$id_tarea_2=trim($_POST["id_tarea_2"]);
		
		$id_cursox=$_POST["th_cursox"];
		
		if (trim($id_tarea_01)!="")
		  {
		  /// Guardo en la BD o actualizo
		  $update_tarea_pres="update mdl_course set id_tarea1_pres=". $id_tarea_01 ." where id=".$id_cursox;
		  $result_utarea = pg_query($update_tarea_pres) or die('Query failed 47: ' . pg_last_error());
		  $rotarea=pg_fetch_array($result_utarea);
		  }
		  
		if (trim($id_tarea_02)!="")
		 {
		  /// Guardo en la BD o actualizo
		  $update_tarea_pres="update mdl_course set id_tarea2_pres=". $id_tarea_02 ." where id=".$id_cursox;
		  $result_utarea = pg_query($update_tarea_pres) or die('Query failed 55: ' . pg_last_error());
		  $rotarea=pg_fetch_array($result_utarea);
	     }
		

		$total_alumnos=count($_POST["id_sv_alu"]);
		$id_tarea_01=$id_tarea_1;
		$id_tarea_02=$id_tarea_2;

		for ($i=0; $i<$total_alumnos; $i++)
			{
			  $id_user_sv=$_POST["id_sv_alu"][$i];
  			  $nota_01=$_POST["quiz_01"][$i];
			  $nota_02=$_POST["quiz_02"][$i];
			  
			  $ctx++;
			  
			  // LOS QUE NO INTENTARON TIENEN XX Y LA NOTA NO SE PASA
			  if (trim($id_tarea_01)!="" && $nota_01 !="XX")
			      {
					  //TAREA_01 Chequeo si debo hacer un update o un insert
					  $qexiste_t1='SELECT COALESCE((SELECT 1 FROM mdl_assignment_submissions WHERE assignment='. $id_tarea_01 .' and userid='. $id_user_sv .' LIMIT 1),0) as "existe"';
					  $result_t1 = pg_query($qexiste_t1) or die('Query failed 68: ' . pg_last_error());
					  $row_t1=pg_fetch_array($result_t1);
					  $existe_tarea_01=$row_t1["existe"];
					  
					  if ($existe_tarea_01=="1")
						 {
						 //UPDATE
						 $sql_01="update mdl_assignment_submissions set grade=". $nota_01. ", timecreated=". $fecha_hora_actual_integer. ",timemodified=". $fecha_hora_actual_integer . ",timemarked=".$fecha_hora_actual_integer . " where userid=".  $id_user_sv. " and assignment=". $id_tarea_01;
						 $rsql_01 = pg_query($sql_01) or die('Query failed 76: ' . pg_last_error());
						 $row_sql_01=pg_fetch_array($rsql_01);
						 $notas_update_01++;
						 }
					  else
						 {
						 //INSERT
						 //$sql_01="insert into mdl_assignment_submissions(assignment,userid,grade,teacher,timecreated,timemodified,timemarked) values(". $id_tarea_01 .",". $id_user_sv .",". $nota_01 .",2,1333557811,1333557811,1333557811)";
						 
						 $sql_01="insert into mdl_assignment_submissions(assignment,userid,grade,teacher,timecreated,timemodified,timemarked) values(". $id_tarea_01 .",". $id_user_sv .",". $nota_01 .",2,". $fecha_hora_actual_integer.",".$fecha_hora_actual_integer.",". $fecha_hora_actual_integer.")";
						 
						 $rsql_01 = pg_query($sql_01) or die('Query failed 88: ' . pg_last_error());
						 $row_sql_01=pg_fetch_array($rsql_01);
						 $notas_insert_01++;
						 }
				 }
              
			  // LOS QUE NO INTENTARON TIENEN XX Y LA NOTA NO SE PASA
			  if (trim($id_tarea_02)!="" && $nota_02 !="XX")
				 {
					  //TAREA_02 Chequeo si debo hacer un update o un insert
					  $qexiste_t2='SELECT COALESCE((SELECT 1 FROM mdl_assignment_submissions WHERE assignment='. $id_tarea_02 .' and userid='. $id_user_sv .' LIMIT 1),0) as "existe"';
					  $result_t2 = pg_query($qexiste_t2) or die('Query failed 85: ' . pg_last_error());
					  $row_t2=pg_fetch_array($result_t2);
					  $existe_tarea_02=$row_t2["existe"];

					  if ($existe_tarea_02=="1")
						 {
						 //UPDATE
						 $sql_02="update mdl_assignment_submissions set grade=". $nota_02. ", timecreated=". $fecha_hora_actual_integer. ",timemodified=". $fecha_hora_actual_integer . ",timemarked=".$fecha_hora_actual_integer . " where userid=".  $id_user_sv. " and assignment=". $id_tarea_02;
						 //$sql_02="update mdl_assignment_submissions set grade=". $nota_02. " where userid=".  $id_user_sv. " and assignment=". $id_tarea_02;
						 $rsql_02=pg_query($sql_02) or die('Query failed 93: ' . pg_last_error());
						 $row_sql_02=pg_fetch_array($rsql_02);
						 $notas_update_02++;
						 }
					  else
						 {
						 //INSERT
						 //$sql_02="insert into mdl_assignment_submissions(assignment,userid,grade,teacher,timecreated,timemodified,timemarked) values(". $id_tarea_02 .",". $id_user_sv .",". $nota_02 .",2,1333557811,1333557811,1333557811)";
						 $sql_02="insert into mdl_assignment_submissions(assignment,userid,grade,teacher,timecreated,timemodified,timemarked) values(". $id_tarea_02 .",". $id_user_sv .",". $nota_02 .",2,". $fecha_hora_actual_integer.",".$fecha_hora_actual_integer.",". $fecha_hora_actual_integer.")";
						 
						 $rsql_02=pg_query($sql_02) or die('Query failed 75: ' . pg_last_error());
						 $row_sql_02=pg_fetch_array($rsql_02);
						 $notas_insert_02++;
						 }
				}	 
            //TERMINA EL FOR
			}
		}
	
	//Verifico si tiene Ponderaciones
	$query1='SELECT COALESCE((Select 1 from senati_pesos_recursos where id_curso='. $id_cursox . ' LIMIT 1),0) as "tiene_pond"';
	$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
	$rox=pg_fetch_array($result1);
	if ($rox["tiene_pond"]=="0")
		 {$existe_ponderacion=false;}
	else
		 {$existe_ponderacion=true;}
	
	$query0 = 'SELECT fullname,subsanacion, induccion, presencial,id_tarea1_pres,id_tarea2_pres, presencial_de FROM mdl_course where id='. $id_cursox;
	$result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
	$rox0=pg_fetch_array($result0);
	
	$nombre_curso=$rox0["fullname"];
	$subx=$rox0["subsanacion"];
	$indux=$rox0["induccion"];
	$presencialx=$rox0["presencial"];
	$presencial_dex=$rox0["presencial_de"];
	$id_tarea1_pres=$rox0["id_tarea1_pres"];
	$id_tarea2_pres=$rox0["id_tarea2_pres"];
	
	
	if ($subx=="s")
	   {$es_susbanacion="SI";}
	else
	   {$es_susbanacion="NO";}
	   
	if ($indux=="s")
	   {$es_induccion="SI";}
	else
	   {$es_induccion="NO";}   

	$titulo_pagina = "Notas de Cursos con Examenes Presenciales para pasar a Cursos Regulares";
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
$query .= 'Where status_Sinfo is null and A.course='. $id_cursox .' order by 7,lastname, bloque ';

$result = pg_query($query) or die('Query failed: ' . pg_last_error());

$existe_ponderacion=true;

?>

<?PHP
if ($existe_ponderacion==false)
	 {
	  // http://virtual.senati.edu.pe/grade/pondera01.php?id=1325
	  echo '<BR>Este Curso todavia <a href="../grade/pondera01.php?id='. $id_cursox.'">'. '<u>NO TIENE PONDERACIONES</u></a>. No se podr&aacute; generar el reporte.<BR>';
	 }
else
{	 
?>	


<?PHP

if ($es_susbanacion=="SI")
    {echo "<STRONG style='font-size:17px'>ESTE ES UN CURSO DE SUBSANACION</STRONG><BR><BR>";}
	
if ($es_induccion=="SI")
    {echo "<STRONG style='font-size:17px'>ESTE ES UN CURSO DE INDUCCION</STRONG><BR><BR>";}	

///////////////////// JUSCE 22 de NAYO 2012

$total_aprobados=0;
$total_desaprobados=0;
$total_pasan_a_subsa=0;
$total_ya_no_pasan_a_subsa=0;	

$total_aprobados_ret=0;
$total_desaprobados_ret=0;
$total_pasan_a_subsa_ret=0;
$total_ya_no_pasan_a_subsa_ret=0;	

/// 19 de Noviembre 2013

//////LISTA DE TUTORES

$queryx  = "Select lastname||', '||firstname as nombre, email from mdl_user_teachers A ";
$queryx .= "inner join mdl_user B on A.userid=B.id where course=". $id_cursox;
$resultx = pg_query($queryx) or die('Query failed 255: ' . pg_last_error());
$lista_tutores="";
$lista_emails="";
$ctz=0;
while($rox2=pg_fetch_array($resultx)) 
	{
	if ($ctz!=0)
		{$lista_tutores .=" / ". $rox2["nombre"];
		$lista_emails .=";". $rox2["email"];
		
		}
	else
		{$lista_tutores .=$rox2["nombre"];
		$lista_emails=$rox2["email"];
		}
	$ctz++;	
	}

?>
<strong>Notas de Examenes Presenciales a pasar a Tareas de Cursos Regulares</strong><BR>
<strong style="color:red">(Solo puede ser ejecutado por el ADMINISTRADOR DE SENATI VIRTUAL)</strong><BR>

<form name="thisform" id="thisform" method="post">

<strong>NOMBRE DEL CURSO : <?PHP echo $nombre_curso?></strong><BR>
<strong>ID DEL CURSO : <?PHP echo $id_cursox?></strong><BR>
<strong>PRESENCIAL DEL CURSO : <?PHP echo $presencial_dex?></strong>
<BR><BR>

<strong>TUTORES del PRESENCIAL:</strong> <?PHP echo $lista_tutores?><BR>
<strong>Emails :</strong> <?PHP echo $lista_emails?><BR>

<p>
<strong style="color:red">NOTA : NO SE TOMAN EN CUENTA LOS RETIRADOS</strong>
</p>


<? if (isadmin() && $presencialx =="s")
{
?>

<p>
<strong>ID TAREA 1:</strong>&nbsp;<INPUT type=text name="id_tarea_1" id="id_tarea_1" value="<?PHP echo $id_tarea1_pres?>" size=5><BR>
<strong>ID TAREA 2:</strong>&nbsp;<INPUT type=text name="id_tarea_2" id="id_tarea_2" value="<?PHP echo $id_tarea2_pres?>" size=5><BR>
</p>

<BR>
<input type=button onClick="pasar_notas();" value="Pasar Notas">&nbsp;<em><font color=blue>(SOLO PASARAN LAS NOTAS DE LOS QUE INTENTARON)</font></em>
<BR><BR>
<?PHP
    ///REPORTE  
	
	if ($accion=="pasar notas")
		{
		echo "<BR>";
		echo "<HR>";
		echo "<BR><p><strong>REPORTE DE PASE DE NOTAS</strong><BR><BR>";
		
		echo "Alumnos a pasar ". $total_alumnos. "<BR>";
		echo "UNIDAD 01<BR>";
		echo "Inserts : ". $notas_insert_01 . "<BR>";
		echo "Updates : ". $notas_update_01 . "<BR>";
		
		echo "<BR>UNIDAD 02<BR>";
		echo "Inserts : ". $notas_insert_02 . "<BR>";
		echo "Updates : ". $notas_update_02 . "<BR>";
		
		echo "<BR>Total : ". $ctx;
		echo "</p>";
		echo "<HR>";
		}
}

if ($presencialx !="s")
   {echo "<BR><BR><strong>Este NO ES UN CURSO PRESENCIAL - NO DEBE USAR ESTE MODULO</strong><BR><BR>";}

?>
<TABLE border=1 cellspacing=1 cellpadding=1 bordercolor="gray">
<TR bgcolor=#dddddd height=23>
<td><STRONG style="color:blue">Id SINFO</strong></td>
<td><STRONG style="color:blue">Id SV</strong></td>
<td><STRONG style="color:blue">Apellidos, Nombres</strong></td>
<td><STRONG style="color:blue">Status SINFO</strong></td>

<?PHP

//QUIZ SOLO SON CUESTIONARIOS (DEBEN SER DOS)
$query5 = "SELECT distinct(A.id), name  FROM mdl_quiz A where A.course=". $id_cursox . " order by A.id";
$result5 = pg_query($query5) or die('Query failed: ' . pg_last_error());

// Printing results in HTML
$c15=0;
$total_quiz=0;
while($row5=pg_fetch_array($result5)) 
	{
	$c15++;
	$total_evidencias++;
	$total_quiz++;
	$nombre_quiz[$total_quiz]=$row5["name"];

?>
<td style="color:blue;cursor:default" title="Cuestionario <?PHP echo $c15 ?>"><?php echo $row5["name"] ?>
</td>
<?PHP
}
?>
</TR>

<?php
$c1=0;

    $total_retirados=0;
while($row=pg_fetch_array($result)) 
	{
	
	$evidencias_entregadas=0;
	
	//Aca tengo que obtener la calificacion 
	$id_userx=$row["userid"];
	$c1++;
	$retiradox=false;
	if ($row["status_sinfo"]=="RET")
       {$total_retirados++;
	   $retiradox=true;
	   }

?>
<TR>
<td align=right><?php echo $row["pidm_banner"] ?></td>
<td align=right><?php echo $id_userx ?> <INPUT type="hidden" name="id_sv_alu[]" value="<?PHP echo $id_userx ?>" size=6></td>

<td><a href="http://virtual.senati.edu.pe/user/view.php?id=<?PHP echo $id_userx ?>&course=1" target=_blank><u><?php echo $row["lastname"].", ".$row["firstname"] ?></u></a></td>


<td align="center">&nbsp;<strong style="color:red"><?PHP echo $row["status_sinfo"] ?></strong>&nbsp;</td>

<?PHP

////////////////////////////////////// ACA COMIENZA EL CONTEO ///////////////////////////////////////////////////

//////////////////////////////////////////////   TAREAS O ASSIGNMENTS /////////////////////////////////
$nota_acumulada=0;

$suma_ponderada=0;
//$query3 = 'SELECT * FROM mdl_assignment A left Join mdl_assignment_submissions B on A.id=B.assignment left Join senati_pesos_recursos on id_recurso=B.assignment and tipo_recurso=1 where peso_recurso<>0 and id_curso='. $id_cursox . ' and userid='. $id_userx . ' order by A.id';
//$query3 = 'SELECT distinct(A.id), B.Grade, A.GRADE as "nota_maxima", peso_recurso, B.numfiles FROM mdl_assignment A left Join mdl_assignment_submissions B on A.id=B.assignment and userid='. $id_userx . ' left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 where peso_recurso<>0 and id_curso='. $id_cursox .' order by A.id';

$query3  ='SELECT distinct(A.id), B.Grade, A.GRADE as "nota_maxima", peso_recurso, B.numfiles, D.id as id_link, assignmenttype ';
$query3 .='FROM mdl_assignment A ';
$query3 .='left Join mdl_assignment_submissions B on A.id=B.assignment and userid='. $id_userx . ' ';  
$query3 .='left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 ';
$query3 .='left join mdl_course_modules D on D.course=id_curso and D.module=1 and D.instance=A.id ';
$query3 .='where peso_recurso<>0 and id_curso='. $id_cursox .' order by A.id';

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

	$mesaf_tareas="";   
	///JUSCE CAMBIO ESTO   
	if (($numfiles >="1" && number_format($nota,1) =="0.0") || ($row3["grade"]=="" && $tipo_de_tarea=="offline"))
	  {
	  $mesaf_tareas="<a target=_blank href='". $linkix. "'><font color=blue><u>Falta calificar</u></font></a>";
	  $faraxi=true;
	  }
 
	if($numfiles*1+1-1==0)
	  {
		  if ($tipo_de_tarea != "offline")
			  {
			  $mesaf_tareas="<font color=red>No envi&oacute; tarea</font>";
			  }
	  }
	$zxy=0; 
	if($mesaf_tareas=="")
	  {
	  $mesaf_tareas=number_format($nota,1);
	  $total_tarea_ok[$numero_de_tarea]++;
	  $zxy=1;  
	  }
	//ACA PUENTE SI SUBIO TAREA  
	if ($nota !="0")  
		{$mesaf_tareas=number_format($nota,1);
		if ($zxy==0)
	       {$total_tarea_ok[$numero_de_tarea]++;}
		}

	  if($mesaf_tareas=="<font color=red>No envi&oacute; tarea</font>")
	  	 {$total_tarea_no_envio[$numero_de_tarea]++;}


	  if($faraxi==true)
	     {$total_tarea_falta_calificar[$numero_de_tarea]++;}		 
	  
	  if ($mesaf_tareas!="<font color=red>No envi&oacute; tarea</font>")
		 {$evidencias_entregadas++;}

		 
		 
		 
?>
<td align=right nowrap><?php echo $mesaf_tareas ?></td>
<?PHP
  }
?>

<?PHP
//////////////////////////////////////////////   QUIZ /////////////////////////////////

//$query6 = "SELECT distinct(A.id), B.Grade, A.GRADE as nota_maxima, peso_recurso FROM mdl_quiz A left Join mdl_quiz_grades B on A.id=B.quiz and userid=". $id_userx . " left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=2 where (peso_recurso<>0 or UPPER(A.name) like 'SUBSA%') and A.course=". $id_cursox ." order by A.id";
//$query6 = "SELECT distinct(A.id), B.Grade, A.GRADE as nota_maxima, peso_recurso FROM mdl_quiz A left Join mdl_quiz_grades B on A.id=B.quiz and userid=". $id_userx . " left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=2 where UPPER(A.name) not like 'SUBSA%' and (peso_recurso<>0 or peso_recurso is not null) and A.course=". $id_cursox ." order by A.id";

$query6 = "SELECT distinct(A.id), ";
$query6 .= "(select max(B.grade) from mdl_quiz_grades B where A.id=B.quiz and userid=". $id_userx . ") as nota_grade, ";
$query6 .= "A.GRADE as nota_maxima ";
$query6 .= "FROM mdl_quiz A  ";
$query6 .= "where A.course=". $id_cursox;
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

	if ($nota_maxima > 0)
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
		}
	
    $intento_sino="nose";
	
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
	   $intento_sino="no";
	   $total_quiz_no_intento[$numero_de_quiz]++;
	   }
	else
	   {$mesaq=$s1. number_format($nota,1). $s2;
	   $total_quiz_ok[$numero_de_quiz]++;
	   }

$notar=round($nota,0);

	if($intento_sino=="no")
		{
		$notar="XX";
		}
	
?>
<td align=right><?php echo $mesaq  ?>&nbsp;
<INPUT type=hidden name="quiz_0<?PHP echo $numero_de_quiz ?>[]" value="<?PHP echo $notar?>" size=5>
</td>
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
	$numero_de_foro++;
	$c27++;
	$id_foro=$row27["id"];
	$nota_maxima=$row27["scale"];
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
			//$peso_rec=0;
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
				//$peso_rec=$row9["peso_recurso"];
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
			   {$evidencias_entregadas++;}
			   
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
				$mesa_foro="<a href='". $url_discuss. "' target=_blank><font color=blue><u>Falta calificar</u></font></a>";
				$total_foro_falta_calificar[$numero_de_foro]++;
				}
				
			if ($mesa_foro=="")
               {$mesa_foro=$nota_foro;
			   $total_foro_ok[$numero_de_foro]++;
			   }
?>
<td align=right nowrap><?php echo $mesa_foro ?></td>
<?PHP
   }
?>


<?PHP 
if ($total_evidencias!="" && $total_evidencias!="0")
    {$porcentrega=100*$evidencias_entregadas/$total_evidencias;}
	
if ($porcentrega>=40 && $suma_ponderada>=400 && $suma_ponderada<=1045)
   {$mensajex="<font color=green>PASA A SUBSANACION</font>";}
else
   {
   
   if ($suma_ponderada>1045)
       {$mensajex="<font color=blue>APROBADO</font>";}
   else
       {$mensajex="<font color=red>DESAPROBADO</font>";}
   }

$porcentrega_round=round($porcentrega, 1);

$nota_finax=$suma_ponderada/100;
$nota_finay=number_format($suma_ponderada/100,1);

if ($mensajex=="<font color=green>PASA A SUBSANACION</font>" && $nota_finay=="10.5")
   {$mensajex="<font color=blue>APROBADO</font>";}

if ($mensajex=="<font color=blue>APROBADO</font>" && $nota_finay=="10.4")
   {$nota_finay="10.5";}

if ($es_induccion=="SI" && $mensajex=="<font color=green>PASA A SUBSANACION</font>")   
   {$mensajex="<font color=red>DESAPROBADO</font>";}   
   
if ($es_susbanacion=="SI" && $mensajex=="<font color=green>PASA A SUBSANACION</font>")   
   {$mensajex="<font color=green>YA NO PASA A SUBSANACION</font>";}


//// ACA PONGO EL CONTEO !!!!!!!!!!!

if (strrpos($mensajex,">APROBADO<")>2)
   {$total_aprobados++;}

if (strrpos($mensajex,">DESAPROBADO<")>2)
   {$total_desaprobados++;}

if (strrpos($mensajex,">PASA A SUBSANACION<")>2)
   {$total_pasan_a_subsa++;}
   

if (strrpos($mensajex,">YA NO PASA A SUBSANACION<")>2)
   {$total_ya_no_pasan_a_subsa++;}
   

/////////////////////

if (strrpos($mensajex,">APROBADO<")>2 && $retiradox)
   {$total_aprobados_ret++;}

if (strrpos($mensajex,">DESAPROBADO<")>2 && $retiradox)
   {$total_desaprobados_ret++;}

if (strrpos($mensajex,">PASA A SUBSANACION<")>2  && $retiradox)
   {$total_pasan_a_subsa_ret++;}
   

if (strrpos($mensajex,">YA NO PASA A SUBSANACION<")>2  && $retiradox)
   {$total_ya_no_pasan_a_subsa_ret++;}
  
?>
</TR>
<?PHP		  
}
echo "</TABLE>";
}

?>
<BR><BR>

<input type="hidden" name="th_accion" id="th_accion" value="">
<input type="hidden" name="th_cursox" id="th_cursox" value="<?PHP echo $id_cursox ?>">


</FORM>
<!-- ACA NO CONSIDERA EN ALGUNOS CASOS -->

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


<?PHP
    print_footer($course);
?>
<script language="javascript">
function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function copiar_id_tareas(){
	var colet1=document.getElementsByName("id_tarea_01[]");
	var colet2=document.getElementsByName("id_tarea_02[]");
	var largot1=colet1.length;

	var primer_valor_t1=colet1[0].value;
	var primer_valor_t2=colet2[0].value;

	for (ir=1;ir<largot1;ir++)
			{
			colet1[ir].value=primer_valor_t1;
			colet2[ir].value=primer_valor_t2;
			}
}

function trim(str)
	{
	if(!str || typeof str != "string")
	return "";
	return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
	}

function pasar_notas(){
     if (trim(obje("id_tarea_2").value)!="" && trim(obje("id_tarea_1").value)!="")
	{
    obje("th_accion").value="pasar notas";
	obje("thisform").submit();
	}
	else
	{
	alert("Debe Colocar los ID TAREA");
	}
}

</script>