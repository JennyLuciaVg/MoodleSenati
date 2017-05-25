<?PHP
    require_once("../config.php");
    require_once("lib.php");
	
	// FTP Can't establish connection --> 173.243.114.18:21 @ Sat Sep 22 20:48:16 2012   (

	// SE DECIDIO NO USAR PONDERACION 15 en CURSOS DE SUBSANACION
    //require_once("../conexion.php");
	// FUNCIONA CON CHROME 9 de SEPTIEMBRE 2012
	

    $id       = required_param('id');              // course id
    $download = optional_param('download');
    $user     = optional_param('user', -1);
    $group    = optional_param('group', -1);
    $action   = optional_param('action', 'grades');
    
    $id_usuario=$USER->id;
    
    $datos_salvados="no";

    if (!$course = get_record('course', 'id', $id)) {
        error('No course ID');
    }

    require_login($course->id);
    print_header($course->shortname.': Acta de Notas Final', $course->fullname, grade_nav($course, $action));
    
$id_cursox=$course->id;

$total_desaprobados=0;
$total_aprobados=0;
$total_np=0;

//fecha de inicio
//$fecha_inicio_curso=date("d-m-Y",$fecha_curso);
$query_fecha="Select startdate from mdl_course where id=".  $id_cursox ;
$resultado = pg_query($query_fecha) or die('Query failed: ' . pg_last_error());	
$roxy=pg_fetch_array($resultado);

$fecha_curso=$roxy["startdate"];
$fecha_inicio_curso=date("d-m-Y",$fecha_curso);					 

// si pulse Pasar a HA
// INPUTS :
// total_alu
/*id_alu_xx id_alumno
nota_pasar_xx Nota
sta_pasar_xx Estado
th_accion_xx S o nada (salvar o no)
accion_es_xx editar o insertar
tarea_mig es salvar o nada
course_id es el id del curso (para prevenir que cambien el URL
*/
//print_r($_POST); 
$tarea=$_POST["tarea_mig"]; // Solo cuando se pulsa el boton salvar

$registros_actualizados=0;
$mensaje="";

if ($tarea=="salvar")
   {
	$total_alu=$_POST["total_alu"]; 
	$id_cursox=$_POST["course_id"]; 
	$pondera_a_usar=$_POST["sel_pondera"]; 
	
	if ($id_cursox=="")
	   {$id_cursox=$course->id;}
	   
	for ($i=1; $i<$total_alu+1; $i++)
			{

			  $ob_id_alu="id_alu_" . $i;
			  $ob_nota_pasar="nota_pasar_" . $i;
			  $ob_sta_pasar="sta_pasar_" . $i;
			  $ob_th_accion="th_accion_" . $i;
			  $ob_accion_es="accion_es_" . $i;
			  
			  $valor_id_alu=$_POST[$ob_id_alu];
			  $valor_nota=trim($_POST[$ob_nota_pasar]);
			  $valor_estado=trim($_POST[$ob_sta_pasar]);
			  $valor_th_accion=trim($_POST[$ob_th_accion]); // S o nada
			  $valor_accion_es=trim($_POST[$ob_accion_es]); //editar o insertar
			  
			  if ($valor_nota=="0")
				   {$valor_nota="NULL";}
			  else
				   {
				   if ($pondera_a_usar!="20")
				       {
					   $nota_ponderadax=$valor_nota*($pondera_a_usar/20);
					   $valor_nota=number_format($nota_ponderadax,1);
      				   if ($valor_nota*100 < 1050)
			       		  {$valor_estado="DE";}
				       else
				          {$valor_estado="AP";}
				       }
				   $valor_nota="'". $valor_nota ."'";
				      
				   }
		  
			  if ($valor_th_accion=='S')
			  	 {
 						  ///ACA DEBO LEER EL NRC PERIODO Y CAMP DE mdl_user_students
						  $sqlee_matricula="Select nrc, bloque, periodo, camp from mdl_user_students where userid=". $valor_id_alu . " and course=". $id_cursox;
						  $result_lee_matricula = pg_query($sqlee_matricula) or die('Query failed 111: ' . pg_last_error());	
						  $rolee=pg_fetch_array($result_lee_matricula);
						  
						  $nrcx=$rolee["nrc"];
						  $campx=$rolee["camp"];
						  $periodox=$rolee["periodo"];
						  $bloquex=$rolee["bloque"];
						  
						  if (trim($nrcx)=="")
						     {$nrcx="NULL";}
						  else
						     {$nrcx="'". $nrcx. "'";}
						
						if (trim($bloquex)=="")
						     {$bloquex="NULL";}
						  else
						     {$bloquex="'". $bloquex. "'";}						
							 
						  if (trim($campx)=="")
						     {$campx="NULL";}
						  else
  						     {$campx="'". $campx. "'";}
							 
						  if (trim($periodox)=="")
						     {$periodox="NULL";}
						  else
  						     {$periodox="'". trim($periodox). "'";}
				 
				 
				 echo " valor " .$valor_accion_es;
					 if ($valor_accion_es=="editar")
						 {
						  $sqele="Update senati_actas_notas set nrc=". $nrcx.", bloque=" . $bloquex . ", camp=". $campx .", nota=". $valor_nota . ", estado='". $valor_estado . "', fecha_actividad=now(), ponderacion=". $pondera_a_usar . ", id_usuario=". $id_usuario . " where id_alumno=". $valor_id_alu. " and id_curso=". $id_cursox ."; COMMIT;";
						 }
					 if ($valor_accion_es=="insertar")
						 {

						 
						  $sqele="Insert into senati_actas_notas (id_alumno, id_curso, nota, fecha_actividad, estado, ponderacion, id_usuario,nrc,bloque,camp,periodo) Values (". $valor_id_alu. ",". $id_cursox . "," . $valor_nota . ", now(),'" . $valor_estado . "'," . $pondera_a_usar. ",". $id_usuario .",".$nrcx. ",". $bloquex .",". $campx.",". $periodox .")";
	                      //echo 	$sqele;				  
						 }
					 $resultado = pg_query($sqele) or die('Query failed 134: ' . pg_last_error());	
					 $roma=pg_fetch_array($resultado);
	 				$registros_actualizados++;  
	 
			     }
		   }
 
		if ($registros_actualizados==0)
            {$mensaje="No se pas&oacute; ninguna nota";}
		if ($registros_actualizados==1)
            {$mensaje="Se pas&oacute; 1 nota";}
		if ($registros_actualizados > 1)
            {$mensaje="Se pasaron ". $registros_actualizados . " notas ";}
		   	  
   }




// DEBO REVISAR SI EL DATO ES NUEVO o YA EXISTE Y SOLO HAY QUE ACTUALIZARLO
// TABLA senati_pesos_recursos
// id_recurso id de mdl_quiz (id y COURSE) o de mdl_assignment (id y COURSE)
// tipo_recurso assignment o quiz
// peso_recurso
// id_curso
?>

<BR>
<strong>ACTA DE NOTAS FINAL</strong>
<BR><strong>Curso :</strong> <strong style="color:blue"><?PHP echo $course->fullname?></strong>&nbsp;<BR>
<strong>Fecha de Inicio (D/M/A): </strong><strong style="color:blue"><?PHP echo $fecha_inicio_curso?></strong>&nbsp;<BR>
<strong>ID del CURSO : </strong><strong style="color:blue"><?PHP echo $course->id ?></strong><BR>
<em>(Las primeras notas mostradas son el resultado de un proceso de c&aacute;lculo deben generarse solo al finalizar el curso).</em><BR>
<em>(Las columnas 8 y 9 muestran las notas en HISTORIA ACADEMICA que es la <strong>instancia superior</strong> del registro de notas).</em><BR>
<em>(Los checks en <font style="background-color:yellow">amarillo</font> indican que esa nota es candidata para pasar a Historia Academica).</em><BR>
<em>(Las notas/estados de Historia Academica en <font style="background-color:silver">gris</font> indican que esa nota fue modificada directamente por un administrador).</em><BR>
<em>(Los Alumnos que tiene Promedio Final Ponderado igual a cero, no pueden tener nota de Subsanaci&oacute;n (sombreada en <font style="background-color:cyan">celeste</font>), si la tuviesen esta no ser&aacute; tomada en cuenta y se considerar&aacute; como cero.)</em><BR><BR>
<strong style="color:red">NOTA : ESTE PROCESO SOLO LO PUEDE HACER EL ADMINISTRADOR DE SENATI VIRTUAL.</strong>
<BR><BR>

<?PHP 
echo "mensaje " .$mensaje;
if ($mensaje != "")
	{
	echo "<strong style='color:red'>". $mensaje . ".</strong><BR/><BR/>";
	}

    
$query1 = 'SELECT count(*) as total FROM senati_pesos_recursos where id_curso='. $id_cursox;
$result1 = pg_query($query1) or die('Query failed 179: ' . pg_last_error());
$px=-1;
$existe_ponderacion=false;
while($rox=pg_fetch_array($result1)) 
	{
  $px=$rox["total"];
  }
if ($px==0)
	 {$existe_ponderacion=false;}
else
	 {$existe_ponderacion=true;}
 

// ESTO ES PARA 1000 NOTAS
$query  = "SELECT A.userid, firstname, lastname, nota, estado, fecha_entrega, k.nota_final, ponderacion ";
$query .= "From mdl_user_students A left join mdl_user B on A.userid=B.id left Join senati_actas_notas on ";
$query .= "id_alumno=A.userid and id_curso=A.course left join senati_entrega_certif K on K.userid=B.id ";
$query .= "and courseid=A.course Where A.userid not in (Select id_alumno from senati_actas_notas where id_curso=" . $id_cursox . ") "; 
$query .= " and A.course=" . $id_cursox . " order by lastname LIMIT 1000";

//ESTO ES PARA TODOS

$query  = "SELECT A.userid, firstname, lastname, nota, estado, fecha_entrega, k.nota_final, ponderacion ";
$query .= "From mdl_user_students A left join mdl_user B on A.userid=B.id left Join senati_actas_notas on ";
$query .= "id_alumno=A.userid and id_curso=A.course left join senati_entrega_certif K on K.userid=B.id ";
$query .= "and courseid=A.course Where A.course=" . $id_cursox . " order by lastname";


$result = pg_query($query) or die('Query failed 195: ' . pg_last_error());

//Tengo que averiguar si este curso tiene un cuestionario de subsanación !!!!!!!!!!!!!!!!!!!!!!!
// JUSCE ESTO YA NO SE CUANDO SE USO 22 de MAYO 2012


$querysub="select count(*) as total From mdl_quiz where UPPER(name) like 'SUBSA%' and course=". $id_cursox ; 
$resultsub = pg_query($querysub) or die('Query failed 200: ' . pg_last_error());
$rowsub=pg_fetch_array($resultsub);
$tienesub=$rowsub["total"];
//var_dump($tienesub == "0");
//var_dump($tienesub != "0");
//var_dump($tienesub != 0);
//if ($tienesub){
//echo" holaa";
//}else{
//echo "nooo";
//}
?>


<?PHP
if ($existe_ponderacion==false)
	 {
	  echo '<BR><font color=red>Este Curso todavia NO TIENE PONDERACIONES. No se podr&aacute; generar el acta de notas.</font><BR>';
	 }
else
{	 
?>	

<FORM name="thisform" id="thisform" method="post">
<TABLE border="1" cellspacing="1" cellpadding="1">
<TR bgcolor=#dddddd height=23>
<td><STRONG style="color:blue">N&deg;</strong></td>
<td align="center"><STRONG style="color:blue">&nbsp;Id User&nbsp;<BR />Moodle</strong></td>
<td><STRONG style="color:blue">Apellidos, Nombres</strong></td>
<TD align="center">&nbsp;Promedio Final<BR>Ponderado&nbsp;</TD>
<TD align="center">Estado PFP</TD>
<TD align="center">&nbsp;Promedio en Modo<BR>Subsanaci&oacute;n<BR>(&lt; 15)<BR></TD>
<?PHP 
if ($tienesub) {
?>
<td align="center"><STRONG style="color:blue">Nota de<BR />&nbsp;Subsanaci&oacute;n&nbsp;</strong></td>
<td align="center"><STRONG style="color:blue">Estado<BR />&nbsp;Subsanaci&oacute;n&nbsp;</strong></td>
<td width=1% align="center"><STRONG style="color:green">&nbsp;Nota a Pasar&nbsp;</strong></td>
<td width=1% align="center"><STRONG style="color:green">&nbsp;Estado a Pasar&nbsp;</strong></td>
<?PHP
}
?>


<TD align="center"><strong>Pasar a<BR>&nbsp;Historia Acad&eacute;mica&nbsp;</strong><BR />
<a href="javascript:sel_tona();"><u style="color:blue" id="sel_tona">Seleccionar Todos</u></a>
</TD>
<TD align="center">Nota en<BR>Historia Acad&eacute;mica</TD>
<TD align="center">Estado en<BR>Historia Acad&eacute;mica</TD>
<TD align="center">Ponderaci&oacute;n<BR />Utilizada en HA</TD>
<TD align="center">Fecha de Entrega<BR />del Certificado</TD>
<TD align="center">Nota en<BR />Certificado</TD>
</TR>	
<?php

$c1=0;
while($row=pg_fetch_array($result)) 
	{
	$ponderacion_utilizada_ha=$row["ponderacion"];
//Aca tengo que obtener la calificacion 

$id_userx=$row["userid"];

$sqw='SELECT COALESCE((SELECT 1 FROM senati_actas_notas WHERE id_curso='. $id_cursox .' and id_alumno='. $id_userx . ' LIMIT 1),0) as "existe"';
$resa = pg_query($sqw) or die('Query failed: ' . pg_last_error());
while($ron=pg_fetch_array($resa)) 
	{
	$existe =$ron["existe"];
	}
// si es 1 existe si es 0 no existe

if ($existe=="1")
   {$accion_es="editar";}
if ($existe=="0")
   {$accion_es="insertar";}




$c1++;

?>
<TR>
<td align=right><?php echo $c1 ?></td>
<td align=right><?PHP echo $id_userx?>&nbsp;</td>
<td><?PHP echo $row["lastname"] ?>, <?PHP echo $row["firstname"] ?></td>


<?PHP
///ACA COMIENZO A CALCULAR NOTAS JUSCE

//LISTA DE NOTAS

$lista_notas="";
//////////////////////////////////////////////   TAREAS O ASSIGNMENTS /////////////////////////////////
$suma_ponderada=0;
//$query3 = 'SELECT * FROM mdl_assignment A left Join mdl_assignment_submissions B on A.id=B.assignment left Join senati_pesos_recursos on id_recurso=B.assignment and tipo_recurso=1 where peso_recurso<>0 and id_curso='. $id_cursox . ' and userid='. $id_userx . ' order by A.id';
$query3 = 'SELECT distinct(A.id), max(B.Grade) as Grade, A.GRADE as "nota_maxima", peso_recurso FROM mdl_assignment A ';
$query3 .= 'left Join mdl_assignment_submissions B on A.id=B.assignment and userid='. $id_userx . ' ';
$query3 .= 'left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 where peso_recurso<>0 and id_curso='. $id_cursox .' ';
$query3 .=' group by A.id, A.grade, peso_recurso order by A.id';

/* ANTERIOR
$query3 = 'SELECT distinct(A.id), B.Grade, A.GRADE as "nota_maxima", peso_recurso FROM mdl_assignment A ';
$query3 .= 'left Join mdl_assignment_submissions B on A.id=B.assignment and userid='. $id_userx . ' ';
$query3 .= 'left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=1 where peso_recurso<>0 and id_curso='. $id_cursox .' ';
$query3 .= 'order by A.id';
*/


$result3 = pg_query($query3) or die('Query failed: ' . pg_last_error());

// El grade de mdl_assignment es el MAXIMO DE NOTA
// El Grade de mdl_assignment_submissions es la NOTA

//DEBO OBTENER LA SUMA AL FINAL 
while($row3=pg_fetch_array($result3)) 
	{
	$nota=$row3["grade"];
	$nota_maxima=$row3["nota_maxima"];

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
		$suma_ponderada=$suma_ponderada + $nota*$row3["peso_recurso"];
		}
	////JUSCE TAREAS  
	$lista_notas=$lista_notas . "," . $nota . "*" .$row3["peso_recurso"];	
	
	}

?>
<?PHP
//////////////////////////////////////////////   QUIZ /////////////////////////////////

$query6  = 'SELECT distinct(A.id), ';
$query6 .= '(select max(B.grade) from mdl_quiz_grades B where A.id=B.quiz and userid='. $id_userx . ') as nota_grade, ';
$query6 .= 'A.GRADE as "nota_maxima", peso_recurso  ';
$query6 .= 'FROM mdl_quiz A left Join senati_pesos_recursos on id_recurso=A.id and tipo_recurso=2 where peso_recurso<>0 and id_curso='. $id_cursox .' order by A.id';

$result6 = pg_query($query6) or die('Query failed: ' . pg_last_error());

//DEBO OBTENER LA SUMA AL FINAL 

// GRADE DE MDL_QUIZ es la nota maxima 
// GRADE DE MDL_GRADE es la nota 



while($row6=pg_fetch_array($result6)) 
	{


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
			$suma_ponderada=$suma_ponderada + $nota*$row6["peso_recurso"];
		}
		
	////JUSCE QUIZ
	$lista_notas=$lista_notas . "," . $nota . "*". $row6["peso_recurso"];
  }
?>
<?PHP
//////////////////////////////////// FOROS ////////////////////////////////////////
$query27 = 'SELECT distinct(a.id), scale, peso_recurso FROM mdl_forum a left Join senati_pesos_recursos on id_recurso=a.id and tipo_recurso=3 where peso_recurso<>0 and course='. $id_cursox . ' and a.scale=20 order by a.id';
$result27 = pg_query($query27) or die('Query failed: ' . pg_last_error());
// Printing results in HTML


$c27=0;
while($row27=pg_fetch_array($result27)) 
	{
	$c27++;
	$id_foro=$row27["id"];
	$nota_maxima=$row27["scale"];
	$peso_rec=$row27["peso_recurso"];
	
			//////////////////////////////////////////////   FOROS /////////////////////////////////
			$query9 = 'Select a.id as id_foro, c.userid, d.post, d.rating from mdl_forum a left join mdl_forum_discussions b on a.id=b.forum left join mdl_forum_posts c on c.discussion=b.id left join mdl_forum_ratings d on d.post=c.id  Where a.course='. $id_cursox . ' and a.scale=20 and c.userid=' . $id_userx .' and a.id='.$id_foro;
			$result9 = pg_query($query9) or die('Query failed: ' . pg_last_error());
			
			//DEBO OBTENER LA SUMA AL FINAL  : CAMBIAR A NOTA MAS ALTA !!!!!!!!!!!!!!!!!!!!!!!!!!!!
			$tnf=0;
			$suma_nota_foro=0;
			$nota_mas_alta=0;
	
			while($row9=pg_fetch_array($result9)) 
				{
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
	
				$tnf++;
			    }	
			if ($tnf != 0)
			   {
			   
   			   if ($id_cursox > 523)
			   	   {$nota=$nota_mas_alta;}
			   else
				   {$nota=$suma_nota_foro/$tnf;
					 /// esto es para promediar ANTES !!!!!!!!!!!! CURSOS DEL 2008 !!!!!!!!!
				   }
			   }
			else   
			   {$nota=0;}
			  
			if ($nota== 0 || $nota==-1 ||	$nota=='')
			   {$nota=0;}
			else
				{
					$suma_ponderada=$suma_ponderada + $nota * $peso_rec;
				}
				
	////JUSCE FOROS 
	$lista_notas=$lista_notas . "," . $nota. "*". $peso_rec;
   }
?>
<?PHP
	$estilo="";

    $stat_pasar="";

if ($suma_ponderada >= 1050)
   {$estatus="Aprobado";
    $stat_pasar="AP";
	$estilo='style="color:blue"';
   	$total_aprobados++;
   	}
else
   {
    if($suma_ponderada==0)
       {$total_np++;
	   $stat_pasar="NP";
        $estatus="No particip&oacute;";
       }
     else
      {
	   $stat_pasar="DE";  
		$estatus="Desaprobado";
		$total_desaprobados++;
       }
   	}

$nota_final=0.1*(int)($suma_ponderada/10);  
//$nota_final=$suma_ponderada;  

$estilo_ha='style="color:red"';

$staxi=$row["estado"];
$salida="";
if ($staxi=="AP")
    {
	$estilo_ha='style="color:blue"';
	$salida="Aprobado";}
	
if ($staxi=="DE")
    {$salida="Desaprobado";}
	
if ($staxi=="RE")
    {$salida="Desaprobado";}	

if ($staxi=="NP")
    {$salida="No particip&oacute;";}
	
$notay=$row["nota"];
if (trim($notay)=="")
    {$notay="0";}
	
//ESTA ES LA NOTA DEL PFP	
$nota_pfp=trim($nota_final);

$nota_subsanacion_mil=$nota_pfp*100;

$nota_modo_subsa=$nota_pfp;

//ACA PONGO LA NOTA EN MODO SUBSANACION


if ($suma_ponderada >=1050)
   {$nota_modo_subsa= 1050 + 9*($nota_subsanacion_mil-1050)/19;
    $nota_modo_subsa=$nota_modo_subsa/100;
	//$nota_modo_subsa=number_format($nota_modo_subsa,1);
    }	

   
if ($estatus=="Aprobado" && $nota_final=="10.4")
   {$nota_final="10.5";}
?>
<td align=right>&nbsp;<strong <?PHP echo $estilo?>><?php echo $nota_final ?></strong>
</td>
<td <?PHP echo $estilo?> >&nbsp;<?php echo $estatus ?></td>
<td align=right>&nbsp;<strong><?php echo number_format($nota_modo_subsa,1) ?></strong></td>

<?PHP 

if ($tienesub !="0") {
/// NOTA DE SUBSANACION
//////////////////////////////////////////////   QUIZ /////////////////////////////////

$query16 = "SELECT B.Grade, A.GRADE as nota_maxima FROM mdl_quiz A left Join mdl_quiz_grades B on A.id=B.quiz and userid=". $id_userx . " where UPPER(A.name) like 'SUBSA%' and A.course=". $id_cursox;
$result16 = pg_query($query16) or die('Query failed: ' . pg_last_error());

//DEBO OBTENER LA SUMA AL FINAL 
// GRADE DE MDL_QUIZ es la nota maxima 
// GRADE DE MDL_GRADE es la nota 

$notasubsanacion=0;
$estadosubsanacion="DE";
$statussubsanacion="Desaprobado";


$row16=pg_fetch_array($result16); 

$nota=$row16["grade"];
$nota_maxima=$row16["nota_maxima"];

if ($nota_maxima > 0)
   {$nota=20*$nota/$nota_maxima;}
else
   {$nota=0;}

if ( $nota < 0)
   {$nota=0;}


if ($nota== 0 || $nota==-1 ||	$nota=='')
	{$nota=0;}

$notax=$nota * 100;	


if ($notax >= 1050)
   {$estatus_sub="Aprobado";
    $stat_pasar_sub="AP";
   	}
else
   {
    $stat_pasar_sub="DE";
    $estatus_sub="Desaprobado";
   	}

/// FIN NOTA DE SUBSANACION

$notasubsanacion=trim($nota);
$estadosubsanacion=$stat_pasar_sub;
$statussubsanacion=$estatus_sub;

$cola_sub='';
$no_debio_subsanar=false;
if ($nota_pfp=="0" && $notasubsanacion > 0)
   {
	  $cola_sub="bgcolor=cyan";
	  $no_debio_subsanar=true;
   }

if ($notasubsanacion > $nota_final)
    {$nota_a_pasar=trim($notasubsanacion);
	 $estado_a_pasar=$stat_pasar_sub;
	 $estado_texto=$estatus_sub;
	}
else
    {$nota_a_pasar=trim($nota_final);
	 $estado_a_pasar=$stat_pasar;
 	 $estado_texto=$estatus;
	}

///////////////////////(<?PHP echo $estado_a_pasar

$nota_final=$nota_a_pasar;
$stat_pasar=$estado_a_pasar;


if ($no_debio_subsanar)
	 	{
	 	$nota_a_pasar="0";
	 	$estado_texto="No particip&oacute;";
	 	}

if($stat_pasar_sub=="AP" && $nota_a_pasar=="10.4")
  {$nota_a_pasar="10.5";}

  
  if ($statussubsanacion=="Aprobado" && $notasubsanacion=="10.4")
     {$notasubsanacion="10.5";}
		
?>

<td <?PHP echo $cola_sub ?> align=right><strong><font color='blue'><?PHP echo $notasubsanacion ?></font></strong></td>
<td <?PHP echo $cola_sub ?> nowrap><font color='blue'>&nbsp;<?PHP echo $statussubsanacion?>&nbsp;</font></td>
<td align="right"><STRONG style="color:green"><?PHP echo $nota_a_pasar?></strong></td>
<td nowrap>&nbsp;<FONT color=green><?PHP echo $estado_texto?> </font></td>

<?PHP
}
else
{
/// NO HAY SUBSANACION
$nota_a_pasar=trim($nota_pfp);
}
/// ACA TENGO QUE VER SI HAY DIFERENCIAS Y PROPONER PASAR LAS NOTAS
$nota_ha=trim($row["nota"]);
$cola_pasar='';

if ($nota_ha != $nota_a_pasar && $nota_ha < $nota_a_pasar)
	{
	$cola_pasar='bgcolor=yellow';
	}

if ($nota_a_pasar=="0" && $nota_ha=="")
	{
	$cola_pasar='';
	}
	

//el color de fondo para las Nota de Historia Academica
$cola_ha='';

$nota_hax=$nota_ha;

if ($nota_hax=="")
   {$nota_hax="0";}
   
if ($tienesub !="0")
 {
 if ($nota_pfp != $nota_hax && $notasubsanacion != $nota_hax)
     {$cola_ha='bgcolor=silver';}
 }
else
{
if ($nota_pfp != $nota_hax)
     {$cola_ha='bgcolor=silver';}
 }

if ($tienesub !="0")
 {
 	if ($no_debio_subsanar)
		 	{
		 	$nota_final="0";
		 	$stat_pasar="NP";	
		 	}
 }	
?>

<td align="center" <?PHP echo $cola_pasar?>>
<input type="hidden" name="id_alu_<?PHP echo $c1?>" size=4 value="<?PHP echo $id_userx?>">
<input type="hidden" name="nota_pasar_<?PHP echo $c1?>" size=4 value="<?PHP echo $nota_final?>">
<input type="hidden" name="sta_pasar_<?PHP echo $c1?>" size=4 value="<?PHP echo $stat_pasar?>">
<input type="hidden" name="accion_es_<?PHP echo $c1?>" size=4 value="<?PHP echo $accion_es?>">
<input type="checkbox" name="chknota" onClick="chequear(this,th_accion_<?PHP echo $c1?>);"/>
<input type="hidden" name="th_accion_<?PHP echo $c1?>" class="th_check" size=4 value=""/>
</td>
<td <?PHP echo $estilo_ha?> <?PHP echo $cola_ha?> align=right>&nbsp;<strong><?PHP echo $nota_ha?></strong></td>
<td <?PHP echo $estilo_ha?> <?PHP echo $cola_ha?>>&nbsp;<?php echo $salida ?></td>
<td align="center">&nbsp;<?php echo $ponderacion_utilizada_ha ?></td>
<TD align="center">&nbsp;<?php echo $row["fecha_entrega"] ?>&nbsp;</TD>
<TD align="right"><strong><?php echo $row["nota_final"] ?></strong>&nbsp;</TD>
</TR>
<?PHP		  
	}
echo "</TABLE>";


//Porcentajes

//number_format($nota_ponderadax,1);

$total_aprobados_porc=0;
$total_desaprobados_porc=0;
$total_np_porc=0;
$total_no_aprobados=0;
$total_no_aprobados_porc=0;



if ($c1!="0" && $c1!="")
	{
	$total_aprobados_porc=number_format(100*$total_aprobados/$c1,1);
	$total_desaprobados_porc=number_format(100*$total_desaprobados/$c1,1);
	
	$total_np_porc=number_format(100*$total_np/$c1,1);
	$total_no_aprobados=$total_desaprobados+1-1+$total_np;
	$total_no_aprobados_porc=number_format(100*$total_no_aprobados/$c1,1);
	}
?>

<BR><BR>

<input type="text" style="display:none" name="total_alu" size=4 value="<?PHP echo $c1?>">
<input type="hidden" name="tarea_mig" id="tarea_mig" value="">
<input type="hidden" name="course_id" id="course_id" value="<?PHP echo $id_cursox?>" />



<!--strong style="color:red">IMPORTANTE : SOLO USAR PONDERACION 15 en CURSOS DE SUBSANACION</strong>
<BR /><BR />
<strong>PONDERACION A UTILIZAR : </strong>
<SELECT id="sel_pondera" name="sel_pondera">
<option value="20">20</option>
<option value="15">15</option>
</SELECT-->

<input type="hidden" name="sel_pondera" value="20">
<?PHP 
$disax="";
if ($id_usuario!="2")
   {$disax="disabled";}

?>

<input style="width:320px" <?PHP echo $disax ?> type="button" onclick="salvar();" value="Pasar Notas Seleccionadas a Historia Academica"> (Solo el administrador de SENATI VIRTUAL puede pasar notas)
</FORM>
<BR />

<strong>DEL PROMEDIO FINAL PONDERADO</strong><BR><BR>
<TABLE border=1 cellspacing=1 cellpadding=3 bordercolor=gray>
<TR>
<td bgcolor="#efefef" colspan=3><strong>DETALLES</strong></td>
</TR>

<TR>
<td align=right>Aprobados&nbsp;</td><td align=right>&nbsp;<?PHP echo $total_aprobados?></td>
<td align=right>&nbsp;<?PHP echo $total_aprobados_porc?> %</td>
</TR>
<TR>
<td align=right>Desaprobados&nbsp;</td><td align=right>&nbsp;<?PHP echo $total_desaprobados?></td>
<td align=right>&nbsp;<?PHP echo $total_desaprobados_porc?> %</td>
</tr>

<TR>
<td align=right>No participaron&nbsp;</td><td align=right>&nbsp;<?PHP echo $total_np?></td>
<td align=right>&nbsp;<?PHP echo $total_np_porc?> %</td>
</tr>
<TR>
<td align=right><strong>TOTAL</strong>&nbsp;</td><td align=right>&nbsp;<strong><font color=blue><?PHP echo $c1?></font></strong></td>
<td align=right>&nbsp;100 %</td>
</tr>

</table>
<P>
<TABLE border=1 cellspacing=1 cellpadding=3 bordercolor=gray>
<TR>
<td bgcolor="#efefef" colspan=3><strong>RESUMEN</strong></td>
</TR>
<TR>
<td align=right>Aprobados&nbsp;</td><td align=right>&nbsp;<?PHP echo $total_aprobados?></td>
<td align=right>&nbsp;<?PHP echo $total_aprobados_porc?> %</td>
</TR>
<TR>
<td align=right>El Resto&nbsp;</td><td align=right>&nbsp;<?PHP echo $total_no_aprobados?></td>
<td align=right>&nbsp;<?PHP echo $total_no_aprobados_porc?> %</td>
</tr>
<td align=right><strong>TOTAL</strong>&nbsp;</td><td align=right>&nbsp;<strong><font color=blue><?PHP echo $c1?></font></strong></td>
<td align=right>&nbsp;100 %</td>
</tr>

</table>
</p>
<?PHP
}
?>
<BR />
<a href="index.php?id=<?PHP echo $id_cursox?>"><u>Regresar a Calificaciones</u></a>

<BR>
<BR>
<?PHP
    print_footer($course);
?> 
<script language="javascript">

function salvar(){
thisform.tarea_mig.value="salvar";
thisform.submit();
}

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}


function chequear(objez,objeth) {
// objez es el mismo checkbox
// objeth es el input box al costado
if (objez.checked)
   {
   objeth.value="S";
   }
else
   {
   objeth.value="";
   }
}

function trim(str)
{
if(!str || typeof str != "string")
return "";
return str.replace(/^[\s]+/,'').replace(/[\s]+$/,'').replace(/[\s]{2,}/,' ');
}

function sel_tona(){
	var selt=obje("sel_tona");
	
	if (selt.innerText=="Seleccionar Todos")
	   {
	   selt.innerText="Seleccionar Ninguno";
	   var v1=true;
	   var v2="S";
	   }
	else
	   {
	   selt.innerText="Seleccionar Todos";
   	   var v1=false;
	   var v2="";
	   }
	var cole=document.getElementsByName("chknota");
	var radios=document.getElementsByClassName('th_check')
	
	lex=cole.length;
	
	 for (ix=0;ix<lex;ix++)
	     {
		 cole.item(ix).checked=v1;
		 radios.item(ix).value=v2;
		 }

}

</script>


