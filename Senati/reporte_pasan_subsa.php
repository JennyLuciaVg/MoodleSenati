<?PHP
    require_once("../config.php");
    require_once("lib.php");

	
	// PASAN A SUBSANACION
	// INCLUYE MATRICULA AUTOMATICA PARA SUBSANACION
	// SOLO SI ES CURSO CON PUBLICO = 3
	// NO ES INDUCCION
	// NO ES SUBSANACION
	// NO ES PRESENCIAL
	
	$site = get_site();
    $id=required_param('id');              // course id
	
	$id_cursox=$id;
    $id_usuario=$USER->id;
	
	//CHEQUEO SI VOY A MATRICULAR ALUMNOS
	
	$accion=$_POST["th_accion"];
	if ($accion=="matricular")
	{
	$cara="http://virtual.senati.edu.pe/course/view.php?id=" . $_POST["tx_id_curso_sub"];
	$reporte_matricula="<strong>ID Curso de Subsanaci&oacute;n : </strong><a href='". $cara ."'><u>". $_POST["tx_id_curso_sub"]. "</u></a><BR><BR><strong>ID Usuarios SV : </strong><BR><textarea cols=100 rows=6>";

	
	
		$total_alumnos=count($_POST["id_sv_alu"]);
		$id_curso_sub=$_POST["tx_id_curso_sub"];
		$matri_nuevas=0;
		$matri_actualizadas=0;
		for ($i=0; $i<$total_alumnos; $i++)
			{
			  $id_user_sv=$_POST["id_sv_alu"][$i];
  			  $camp=$_POST["camp"][$i];
			  $nrc=$_POST["nrc"][$i];
			  $bloque=$_POST["bloque"][$i];
  			  $periodo=$_POST["periodo"][$i];
			  
			  $reporte_matricula.=$id_user_sv . ",";
			  
			  $qexiste_t1='SELECT COALESCE((SELECT 1 FROM mdl_user_students WHERE course='. $id_curso_sub .' and userid='. $id_user_sv .' LIMIT 1),0) as "existe"';
			  $result_t1 = pg_query($qexiste_t1) or die('Query failed: ' . pg_last_error());
			  $row_t1=pg_fetch_array($result_t1);
			  $existe_matricula=$row_t1["existe"];
			  
					if ($camp=="")
						{$camp="NULL";}
					else
						{$camp="'".$camp."'";}
						
					if ($nrc=="")
					   {$nrc="NULL";}
					else
					   {$nrc="'".$nrc."'";}
				    
					if ($bloque=="")
			           {$bloque="NULL";}
			        else
			           {$bloque="'".$bloque."'";}
			  
			  if ($existe_matricula=="1")
			      {
				  ///HAGO UN UPDATE
				  $qmatri  = "Update mdl_user_students set camp=". $camp . ", nrc=". $nrc . ",periodo='". $periodo . "', bloque=". $bloque . " where course="; 
				  $qmatri .= $id_curso_sub. " and userid=". $id_user_sv;
				  $rmatri = pg_query($qmatri);
				  $matri_actualizadas++;
				  
				  }
			  else
			      {
				    ////// BUSCAR EL EMAIL DEL ALUMNO
					////// HAGO UN INSERT
					
					$qmatri  = "Insert into mdl_user_students (course,userid,camp,nrc,periodo,bloque,enrol) values (";
					$qmatri .= $id_curso_sub. "," . $id_user_sv . ",". $camp. "," . $nrc. ",'". $periodo ."',". $bloque . ",'manual')";
					$rmatri = pg_query($qmatri);	
				  
				  $matri_nuevas++;
				  }
			///TERMINA EL FOR
			
			} 
		$reporte_matricula.="</textarea>";			
	}
	
	
	
	//Verifico si tiene Ponderaciones
	$query1='SELECT COALESCE((Select 1 from senati_pesos_recursos where id_curso='. $id_cursox . ' LIMIT 1),0) as "tiene_pond"';
	$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
	$rox=pg_fetch_array($result1);
	if ($rox["tiene_pond"]=="0")
		 {$existe_ponderacion=false;}
	else
		 {$existe_ponderacion=true;}
	
	$query0 = 'SELECT fullname,subsanacion, induccion,id_publico,presencial FROM mdl_course where id='. $id_cursox;
	$result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
	$rox0=pg_fetch_array($result0);
	
	$nombre_curso=$rox0["fullname"];
	$subx=$rox0["subsanacion"];
	$indux=$rox0["induccion"];
	$presencialx=$rox0["presencial"];
	$id_publico=$rox0["id_publico"];
	
	//// PUEDO MATRICULAR A UN CURSO DE SUBSANACION SI
	//$id_publico=3
	//$presencialx<>"s"
	//$indux<>"s"
	//$subx<>"s"
	
	$matricular_subsanacion=false;
	
	if ($id_publico=="3" && $presencialx!="s" && $indux != "s" && $subx!="s")
	   {
	   $matricular_subsanacion=true;
	   }
	$matricular_subsanacion=true;
	
	if ($subx=="s")
	   {$es_susbanacion="SI";}
	else
	   {$es_susbanacion="NO";}
	   
	if ($indux=="s")
	   {$es_induccion="SI";}
	else
	   {$es_induccion="NO";}   
	
	


	$titulo_pagina = "Reporte de Alumnos que pasan a SUBSANACION";
	$enlace="<a href='view.php?id=". $id_cursox . "'>". $nombre_curso . "</a> &gt; " . $titulo_pagina; 
	print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");

///// asi saco el id de la instancia PARA EDITAR CALIFICACIONES EN TAREAS ////////////////

///Select id from mdl_course_modules where course=942 and module=1 and instance=1877 

// EL instance es el id de la tabla asignment 



	
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

<?PHP

$query  = "SELECT A.userid, firstname, lastname, A.camp,nombre_centro, A.bloque, nrc, B.pidm_banner,A.periodo ";
$query .= "From mdl_user_students A ";
$query .= "left join mdl_user B on A.userid=B.id ";
$query .= "left join senati_centros on id_centro=camp ";
$query .= "Where (status_sinfo is null or status_sinfo='') and A.course=". $id_cursox ." order by bloque,camp ";

$result = pg_query($query) or die('Query failed: ' . pg_last_error());
?>

<?PHP
if ($existe_ponderacion==false)
	 {
	  echo '<BR>Este Curso todavia NO TIENE PONDERACIONES. No se podr&aacute; generar el reporte.<BR>';
	 }
else
{	 
?>	
<STRONG style="color:blue">REPORTE DE ALUMNOS QUE PASAN A SUBSANACION (id curso=<?PHP echo $id_cursox?>)</STRONG>
<BR><BR>
<em style="color:red">(No se toman en cuenta a los retirados de SINFO)</em>
<BR><BR>
<?PHP

if ($es_susbanacion=="SI")
    {echo "<STRONG style='font-size:17px'>ESTE ES UN CURSO DE SUBSANACION Y NO TIENE VALIDEZ ESTE REPORTE.</STRONG><BR><BR>";}
	
if ($es_induccion=="SI")
    {echo "<STRONG style='font-size:17px'>ESTE ES UN CURSO DE INDUCCION Y NO TIENE VALIDEZ ESTE REPORTE.</STRONG><BR><BR>";}	

?>	

<em>Los criterios para pasar a SUBSANACION son : el % de evidencias entregadas debe ser mayor a 40% y la nota obtenida MAYOR a 4.</em><BR>
<em>Los Cursos de INDUCCION NO TIENEN SUBSANACION al igual que los mismos cursos de SUBSANACION.</em>

<form name="thisform" id="thisform" method="post">

<?PHP
if ($accion=="matricular")
	{
		echo "<BR>";
		echo "<HR>";
		echo "<BR><p><strong style'color:blue'>REPORTE DE MATRICULAS</strong><BR><BR>";
		
		echo "Alumnos: ". $total_alumnos. "<BR>";
		echo "Matriculas Nuevas: " . $matri_nuevas. "<BR>";
		echo "Matriculas Actualizadas: " . $matri_actualizadas. "<BR>";
		
		echo "<BR>";
		echo "<a href='groups.php?id=". $id_curso_sub ."'><u>Ir a la p&aacute;gina de Grupos</u></a>";
		echo "</p>";
		echo "<HR>";
		
		echo $reporte_matricula;
		echo "<HR>";
		
	}
?>


<TABLE border=1 cellspacing=1 cellpadding=1 bordercolor="gray" id="tabla_reporte" name="tabla_reporte">
<TR bgcolor=#dddddd height=23>
<td><STRONG style="color:blue">Id SINFO</strong></td>
<td><STRONG style="color:blue">Id SV</strong></td>
<td><STRONG style="color:blue">Apellidos, Nombres</strong></td>
<td><STRONG style="color:blue">Camp</strong></td>
<td><STRONG style="color:blue">Campus</strong></td>
<td><STRONG style="color:blue">NRC</strong></td>
<td><STRONG style="color:blue">Bloque</strong></td>
<?PHP

$total_evidencias=0;
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
   {$tipo_tarea="<BR><font color=red>(Tarea Offline)</font>";}
else
   {$tipo_tarea="";}

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
	{$total_evidencias++;}


if ($peso_recurso=="" || $peso_recurso=="0")
    {$peso_recurso="N/A";}
else
   {$peso_recurso=$peso_recurso . ' %';}	

$total_quiz++;
$nombre_quiz[$total_quiz]=$row5["name"];

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
	

if ($peso_recurso!="0" && $peso_recurso!="")
	{$total_evidencias++;}

	}
?>

<TD align=center><strong>Evid. Entregadas</strong></TD>
<TD align=center><strong>% Evid. Entregadas</strong></TD>
<TD align=center><strong>PROMEDIO</strong></TD>
<TD align=center><strong>ESTADO</strong></TD>

</TR>

<TR><TD align=center bgcolor=yellow colspan=7><strong style="font-size:15px">TOTAL EVIDENCIAS CALIFICABLES : <?PHP echo $total_evidencias ?></strong></TD>
<TD colspan=4>&nbsp;</TD>
</TR>

<?php
$c1=0;


while($row=pg_fetch_array($result)) 
	{
	
	$evidencias_entregadas=0;
	
	//Aca tengo que obtener la calificacion 
	$id_userx=$row["userid"];
	$c1++;
	

	
?>
<TR id='<?PHP echo "rowy".$c1 ?>'>
<td align=right><?php echo $row["pidm_banner"] ?></td>
<td align=right><?php echo $id_userx ?>
<INPUT type=hidden name="id_sv_alu[]" value="<?php echo $id_userx ?>">
</td>
<td><?php echo $row["lastname"].", ".$row["firstname"] ?></td>
<td><?php echo $row["camp"] ?>
<INPUT type=hidden name="camp[]" value="<?php echo $row["camp"] ?>">
</td>
<td><?php echo $row["nombre_centro"] ?></td>
<td><?php echo $row["nrc"] ?>
<INPUT type=hidden name="nrc[]" value="<?php echo $row["nrc"] ?>">
</td>
<td><?php echo $row["bloque"] ?>
<INPUT type=hidden name="bloque[]" value="<?php echo $row["bloque"] ?>">
<INPUT type=hidden name="periodo[]" value="<?php echo $row["periodo"] ?>">
</td>

<?PHP
//////////////////////////////////////////////   TAREAS O ASSIGNMENTS /////////////////////////////////
$nota_acumulada=0;

$suma_ponderada=0;
//$query3 = 'SELECT * FROM mdl_assignment A left Join mdl_assignment_submissions B on A.id=B.assignment left Join senati_pesos_recursos on id_recurso=B.assignment and tipo_recurso=1 where peso_recurso<>0 and id_curso='. $id_cursox . ' and userid='. $id_userx . ' order by A.id';
//$query3 = 'SELECT distinct(A.id), B.Grade, A.GRADE as "nota_maxima", peso_recurso, B.numfiles FROM mdl_assignment A left Join mdl_assignment_submissions B on A.id=B.assignment and userid='. $id_userx . ' left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 where peso_recurso<>0 and id_curso='. $id_cursox .' order by A.id';


// JUSCE 28 de SEPTIEMBRE no tiene MAX GRADE
/*$query3  ='SELECT distinct(A.id), B.Grade, A.GRADE as "nota_maxima", peso_recurso, B.numfiles, D.id as id_link, assignmenttype ';
$query3 .='FROM mdl_assignment A ';
$query3 .='left Join mdl_assignment_submissions B on A.id=B.assignment and userid='. $id_userx . ' ';  
$query3 .='left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 ';
$query3 .='left join mdl_course_modules D on D.course=id_curso and D.module=1 and D.instance=A.id ';
$query3 .='where peso_recurso<>0 and id_curso='. $id_cursox .' order by A.id';
*/

//JUSCE 28 de SPETIEMBRE 2012
$query3  ='SELECT distinct(A.id), max(B.Grade) as Grade, A.GRADE as "nota_maxima", peso_recurso, B.numfiles, D.id as id_link, assignmenttype ';
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

	$mesaf_tareas="";   
	///JUSCE CAMBIO ESTO   
	if (($numfiles >="1" && number_format($nota,1) =="0.0") || ($row3["grade"]=="" && $tipo_de_tarea=="offline"))
	  {
	  $mesaf_tareas="<a target=_blank href='". $linkix. "'><font color=blue><u>Falta calificar</u></font></a>";
	  $faraxi=true;
	  }
 
	if(($numfiles=="0" || $numfiles=="") && $tipo_de_tarea != "offline")
	  {
	  $mesaf_tareas="<font color=red>No envi&oacute; tarea</font>";
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
   }
?>
<td align=center><strong><?PHP echo $evidencias_entregadas ?></strong></td>

<?PHP 
if ($total_evidencias!="" && $total_evidencias!="0")
    {$porcentrega=100*$evidencias_entregadas/$total_evidencias;}
	
//if ($porcentrega>=40 && ($suma_ponderada>=400 && $suma_ponderada<1050))
//   {$mensajex="<font color=green>PASA A SUBSANACION</font>";}
//else
//   {
   
   if ($suma_ponderada>=1050)
       {$mensajex="<font color=blue>APROBADO</font>";}
   else
       {
	    if ($porcentrega>=40 && $suma_ponderada>=400)
	       {$mensajex="<font color=green>PASA A SUBSANACION</font>";}
	    else
	       {$mensajex="<font color=red>DESAPROBADO</font>";}
       }

$porcentrega_round=round($porcentrega, 1);
$nota_finax=$suma_ponderada/100;

if ($suma_ponderada>="1041" && $suma_ponderada<="1049") 
   {$suma_ponderada="1040";}

$nota_finay=number_format($suma_ponderada/100,1);

if ($es_induccion=="SI" && $mensajex=="<font color=green>PASA A SUBSANACION</font>")   
   {$mensajex="<font color=red>DESAPROBADO</font>";}   
   
if ($es_susbanacion=="SI" && $mensajex=="<font color=green>PASA A SUBSANACION</font>")   
   {$mensajex="<font color=red>DESAPROBADO</font>";}   
   
?>

<td align=center><strong><?PHP echo $porcentrega_round ?> %</strong></td>
<td align=center><strong><?PHP echo $nota_finay ?></strong></td>
<td align=center><strong><?PHP echo $mensajex ?></strong></td>
</TR>
<?PHP		  
}
echo "</TABLE>";
}

?>
<BR>

<?PHP

if ($matricular_subsanacion && isadmin())
   {
   
   /// Busco el curso de Subsanacion correspondiente
   $querysub="Select id from mdl_course where subsanacion_de=". $id_cursox;
   $resultsub = pg_query($querysub) or die('Query failed 724: ' . pg_last_error());
   $roxu=pg_fetch_array($resultsub);
   
   $id_curso_sub=$roxu["id"];
?>   
<p>
<input type=button onClick="limpiar_desaprobados();" value="Limpiar Desaprobados">
</p>
<table cellspacing=0 cellpadding=5 border=1 bordercolor=silver>
<TR>
<td colspan=3 bgcolor=#efefef><strong>MATRICULAR EN SUBSANACION</STRONG></TD>
</TR>
<TR>
<td align=right><strong>ID Curso Objetivo</strong></TD>
<TD><INPUT type=text value="<?PHP echo $id_curso_sub?>" id="tx_id_curso_sub" name="tx_id_curso_sub" maxlength=6 size=8 onkeypress="return numeros();"></TD>
<TD id="td_cursox">&nbsp;</TD>
</TR>

<TR>
<td>&nbsp;</TD>
<TD><INPUT type=button value="Validar Curso" onClick="validar_curso();"></TD>
<TD>&nbsp;</TD>
</TR>
<TR>
<td>&nbsp;</TD>
<TD>
<INPUT disabled id="bot_matricular" name="bot_matricular" type=button value="Matricular en Subsanaci&oacute;n" onClick="matricular_subsa();">
</TD>
<TD>&nbsp;</TD>
</TR>
</TABLE>

<div id="div_valida">
</div>
 
 
 <input type="hidden" name="th_accion" id="th_accion" value="">
</FORM>
<?PHP   
   }
?>

<!-- aca estaban las tablas finales -->

<?PHP
    print_footer($course);
?> 

<script language="javascript">

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function numeros()
	{
	// onkeypress="return numeros();" 
	// trans-browser compatibility
	// solo acepta numeros
	var e = event || evt;
	var charCode = e.which || e.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
	   return false;
	   return true;
	}

function trim(str)
	{
	if(!str || typeof str != "string")
	return "";
	return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
	}

function crea_xmlhttpPost(url) {
    var xmlHttpReq = false;
    var self = this;
    if (window.XMLHttpRequest) {
        self.xmlHttpReq = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) {
        self.xmlHttpReq = new ActiveXObject("Microsoft.XMLHTTP");
    }
    self.xmlHttpReq.open("POST", url, true);
	self.xmlHttpReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	return self.xmlHttpReq;
}

function validar_curso(){
	var id_curso=trim(obje("tx_id_curso_sub").value);
	window.status="Validando Curso ....";
	obje("td_cursox").innerHTML="<font color=green>Validando Curso</font>";
	url="reporte_pasan_subsa_ajax.php";
	var xmlo=crea_xmlhttpPost(url);
		 xmlo.onreadystatechange = function()
		  {
		   if (xmlo.readyState == 4)
			   {
			   update_valida(xmlo.responseText);
			   }
		  }
	qstr="id_curso=" + escape(id_curso);
	xmlo.send(qstr);
}

function update_valida(str){
	obje("div_valida").innerHTML=str;
	
	var nome_curso=obje("tx_nombre_curso").value;
	
if 	(obje("tx_repo_subsa").value=="OK")
    {
    obje("td_cursox").innerHTML="<font color=green>CURSO VALIDO : </font>" + nome_curso;
	obje("bot_matricular").disabled=false;
	window.status="Curso Valido.";
	}
else
    {
	obje("td_cursox").innerHTML="<font color=red>CURSO NO VALIDO </font>" + nome_curso;
	obje("bot_matricular").disabled=true;
	window.status="Curso NO Valido.";
	}
}

function matricular_subsa(){
	obje("th_accion").value="matricular";
	obje("thisform").submit();
}


function limpiar_desaprobados(){
//BORRO LOS APROBADOS O DESAPROBADOS
	objtabla_sinfo=document.getElementById("tabla_reporte");
	var cole_rows=objtabla_sinfo.rows;
	total_rows=cole_rows.length;
	
	// se debe ir de 0 a total_rows-1
	//rows[0].cells
	//tableObject.cells
	//itero rows
	// Hay 11 cells el ESTADO es [10]  el Proceso es el [8]
	var array_tr_id_borrar = new Array();
	var trb=-1;
	for (ir=2;ir<total_rows;ir++)
		{
		var cole_cells=objtabla_sinfo.rows[ir].cells;
		var estadox=cole_cells[10].innerText;
		if (estadox!="PASA A SUBSANACION")
		   {
		   trb++;
		   //digo que ese TR debe borrarse
		   array_tr_id_borrar[trb]=objtabla_sinfo.rows[ir].id;
           }
		}
	//BORRAR TRs
	//el asp me devuelve los TR con ID de esa manera puedo borrarlos
    //<TR id='rowy_" & ct & "'> ej <tr id="rowy_135">
	for (ix=0;ix<trb+1;ix++)
	    {
		var id_tr=array_tr_id_borrar[ix];
		var row_borrar = obje(id_tr);
		row_borrar.parentNode.removeChild(row_borrar);
		}
}

//// LIMPIO APROBADOS
	objtabla_sinfo=document.getElementById("tabla_reporte");
	var cole_rows=objtabla_sinfo.rows;
	total_rows=cole_rows.length;
	
	// se debe ir de 0 a total_rows-1
	//rows[0].cells
	//tableObject.cells
	//itero rows
	// Hay 11 cells el ESTADO es [10]  el Proceso es el [8]
	var array_tr_id_borrar = new Array();
	var trb=-1;
	for (ir=2;ir<total_rows;ir++)
		{
		var cole_cells=objtabla_sinfo.rows[ir].cells;
		var estadox=cole_cells[10].innerText;
		if (estadox=="APROBADO")
		   {
		   trb++;
		   //digo que ese TR debe borrarse
		   array_tr_id_borrar[trb]=objtabla_sinfo.rows[ir].id;
           }
		}
	//BORRAR TRs
	//el asp me devuelve los TR con ID de esa manera puedo borrarlos
    //<TR id='rowy_" & ct & "'> ej <tr id="rowy_135">
	for (ix=0;ix<trb+1;ix++)
	    {
		var id_tr=array_tr_id_borrar[ix];
		var row_borrar = obje(id_tr);
		row_borrar.parentNode.removeChild(row_borrar);
		}


		

</script>