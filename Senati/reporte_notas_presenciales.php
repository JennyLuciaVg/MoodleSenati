<?PHP
    require_once("../config.php");
    require_once("lib.php");

    if (isadmin())
{	
	
	// SOLO NOTAS FINALES PRESENCIALES ESTO ES PARA PASAR EL PROMEDIO QUE VA A UNA SOLA TAREA
	// 21 de JUNIO 2013
	// PARA MIGRAR AL CURSO REGULAR LE DEBO DAR EL ID DE LA TAREA
	
	$site = get_site();
    $id_cursox=$_GET["id"];
	
	if($id_cursox=="")
	  {$id_cursox=$_POST["id_curso"];}

    $id_usuario=$USER->id;
	$accion=$_POST["tx_accion"];

	///////////////////////////// SALVAR 
	
	if ($accion=="salvar")
		{
			//matricular a los alumnos
			//th_nota[]
			//th_id_sv[]
			$id_tarea=$_POST["tx_tarea"];
			
			/// $id_tarea y $id_cursox
			
			// Pongo en la BD en que tarea va a ir
			$update_tarea_pres="update mdl_course set id_tarea1_pres=". $id_tarea ." where id=".$id_cursox;
		    $result_utarea = pg_query($update_tarea_pres) or die('Query failed 34: ' . pg_last_error());
		    $rotarea=pg_fetch_array($result_utarea);
			
			$notas_update=0;
 		    $notas_insert=0;
			if (trim($id_tarea)!="")
				{
				$numero_notas = count($_POST["th_id_sv"]);
				for ($i=0; $i<$numero_notas; $i++)
					{
					$id_user_sv=$_POST["th_id_sv"][$i];
					$notaq=$_POST["th_nota"][$i];
					
					//TAREA Chequeo si debo hacer un update o un insert
					  $qexiste_t1='SELECT COALESCE((SELECT 1 FROM mdl_assignment_submissions WHERE assignment='. $id_tarea .' and userid='. $id_user_sv .' LIMIT 1),0) as "existe"';
					  $result_t1 = pg_query($qexiste_t1) or die('Query failed 37: ' . pg_last_error());
					  $row_t1=pg_fetch_array($result_t1);
					  $existe_tarea=$row_t1["existe"];
					  
  					  if ($existe_tarea=="1")
						 {
						 //UPDATE
						 $sql_01="update mdl_assignment_submissions set grade=". $notaq. " where userid=".  $id_user_sv. " and assignment=". $id_tarea;
						 $rsql_01 = pg_query($sql_01) or die('Query failed 46: ' . pg_last_error());
						 $row_sql_01=pg_fetch_array($rsql_01);
						 $notas_update++;
						 }
					  else
						 {
						 //INSERT
						 $sql_01="insert into mdl_assignment_submissions(assignment,userid,grade,teacher,timecreated,timemodified,timemarked) values(". $id_tarea .",". $id_user_sv .",". $notaq .",2,1333557811,1333557811,1333557811)";
						 $rsql_01 = pg_query($sql_01) or die('Query failed 54: ' . pg_last_error());
						 $row_sql_01=pg_fetch_array($rsql_01);
						 $notas_insert++;
						 }
					} // fin del for
				//fin del if	
				}
		// fin del accion=salvar		
		}

	//Verifico si tiene Ponderaciones
	$query1='SELECT COALESCE((Select 1 from senati_pesos_recursos where id_curso='. $id_cursox . ' LIMIT 1),0) as "tiene_pond"';
	$result1 = pg_query($query1) or die('Query failed 38: ' . pg_last_error());

	$rox=pg_fetch_array($result1);
	
	if ($rox["tiene_pond"]=="0")
		 {$existe_ponderacion=false;}
	else
		 {$existe_ponderacion=true;}
	
	$query0 = 'SELECT fullname,presencial FROM mdl_course where id='. $id_cursox;
	$result0 = pg_query($query0) or die('Query failed: ' . pg_last_error());
	$rox0=pg_fetch_array($result0);
	
	$nombre_curso=$rox0["fullname"];
	$presencialx=$rox0["presencial"];  //////////// DEBE SER 's'
	
	$titulo_pagina = "Reporte de NOTAS FINALES PRESENCIALES";
	$enlace="<a href='view.php?id=". $id_cursox . "'>". $nombre_curso . "</a> &gt; " . $titulo_pagina; 
	print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");

///// asi saco el id de la instancia PARA EDITAR CALIFICACIONES EN TAREAS ////////////////
///// Select id from mdl_course_modules where course=942 and module=1 and instance=1877 
///// El instance es el id de la tabla asignment 


// TABLA senati_pesos_recursos
// id_recurso id de mdl_quiz (id y COURSE) o de mdl_assignment (id y COURSE)
// tipo_recurso assignment o quiz
// peso_recurso
// id_curso

$query  = "SELECT A.userid, firstname, lastname, A.camp,nombre_centro, A.bloque, nrc, B.pidm_banner,status_sinfo ";
$query .= "From mdl_user_students A ";
$query .= "left join mdl_user B on A.userid=B.id ";
$query .= "left join senati_centros on id_centro=camp ";
$query .= "Where A.course=". $id_cursox ." order by status_sinfo, bloque,camp ";
$result = pg_query($query) or die('Query failed: ' . pg_last_error());

// Leo a que tarea va a ir la nota (si es que existe ese dato
//id_tarea1_pres

$q_leo_tarea="select id_tarea1_pres from mdl_course where id=".$id_cursox;
$r_leo_tarea = pg_query($q_leo_tarea) or die('Query failed 119: ' . pg_last_error());
$rox_tareax=pg_fetch_array($r_leo_tarea);

$id_tarea_target=$rox_tareax["id_tarea1_pres"];

?>

<?PHP
if ($existe_ponderacion==false || $presencialx!="s")
	 {
	 if ($existe_ponderacion==false)
	    {echo '<BR>Este Curso todavia NO TIENE PONDERACIONES. No se podr&aacute; generar el reporte.<BR>';}
	 
	 if ($presencialx!="s")
	    {echo '<BR>Este Curso NO ES PRESENCIAL. No se podr&aacute; generar el reporte.<BR>';}
     }	 
else
{	 
?>	
<STRONG style="color:blue">REPORTE DE NOTAS FINALES PRESENCIALES (id curso=<?PHP echo $id_cursox?>)</STRONG>
<BR><BR>
<?PHP

echo $numero_notas;

if($presencialx!="s")
   {echo "<font>ESTE NO ES UN CURSO PRESENCIAL, no puede utilizar este modulo.</font>";}
   
if ($accion=="salvar")
	{
	echo "<UL>";
	echo "<LI>NOTAS ACTUALIZADAS : " . $notas_update . "</LI>";
	echo "<LI>NOTAS INSERTADAS : " . $notas_insert . "</LI>";
	echo "</UL>";
	} 
?>	
<form method=post name=thisform id=thisform>
<TABLE border=1 cellspacing=1 cellpadding=1 bordercolor="gray" id="tabla_reporte" name="tabla_reporte">
<TR bgcolor=#dddddd height=23>
<td><STRONG style="color:blue">Id SINFO</strong></td>
<td><STRONG style="color:blue">Id SV</strong></td>
<td><STRONG style="color:blue">Apellidos, Nombres</strong></td>
<td><STRONG style="color:blue">Status SINFO</strong></td>
<td><STRONG style="color:blue">Camp</strong></td>
<td><STRONG style="color:blue">Campus</strong></td>
<td><STRONG style="color:blue">NRC</strong></td>
<td><STRONG style="color:blue">Bloque</strong></td>
<?PHP
$total_evidencias=0;
// CREO LOS TDs
// TAREAS O ASSIGNMENTS

//QUIZ
// Performing SQL query
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
		$nombre_quiz=$row5["name"];
		
		echo "<TD align=center><strong>*". $nombre_quiz ."*</strong></TD>";
	}
?>

<TD align=center><strong>PROMEDIO REAL</strong></TD>
<TD align=center><strong>PROMEDIO ENTERO</strong></TD>
<TD align=center><strong>ESTADO</strong></TD>

</TR>



<?php
$c1=0;

///// ALUMNOS
while($row=pg_fetch_array($result)) 
	{
	
	$evidencias_entregadas=0;
	
	//Aca tengo que obtener la calificacion 
	$id_userx=$row["userid"];
	$c1++;

?>
<TR id='<?PHP echo "rowy".$c1 ?>'>
<td align=right><?php echo $row["pidm_banner"] ?></td>
<td align=right><?php echo $id_userx ?></td>
<td><?php echo $row["lastname"].", ".$row["firstname"] ?></td>
<td align=center><strong><font color=red><?php echo $row["status_sinfo"] ?></font></strong></td>
<td><?php echo $row["camp"] ?></td>
<td><?php echo $row["nombre_centro"] ?></td>
<td><?php echo $row["nrc"] ?></td>
<td><?php echo $row["bloque"] ?></td>

<?PHP
$nota_acumulada=0;
$suma_ponderada=0;
//////////////////////////////////////////////   QUIZ /////////////////////////////////
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
	   }
	else
	   {$mesaq=$s1. number_format($nota,1). $s2;}
	   
	///// ACA PONGO EL TD CON LA NOTA
      echo "<TD>".$row6["nota_grade"] . "</TD>";	
	   
	   
    }

if ($suma_ponderada>=1050)
   {$mensajex="<font color=blue>APROBADO</font>";}
else
   {$mensajex="<font color=red>DESAPROBADO</font>";}
   

$nota_finax=$suma_ponderada/100;
$nota_finay=number_format($suma_ponderada/100,1);

$nota_entero=round($nota_finax);

?>
<td align=center><strong><?PHP echo $nota_finay ?></strong></td>
<td align=center><strong><?PHP echo $nota_entero ?></strong></td>
<td align=center><strong><?PHP echo $mensajex ?></strong>
<input type="hidden" name="th_nota[]" value="<?PHP echo $nota_entero ?>">
<input type="hidden" name="th_id_sv[]" value="<?PHP echo $id_userx ?>">
</td>
</TR>
<?PHP		  
}
echo "</TABLE>";
}
?>
<p>
<strong>MIGRAR LA NOTA A UNA TAREA<STRONG><BR>

ID TAREA&nbsp;<input type="text" maxlength=6 size=6 id="tx_tarea" name="tx_tarea" value="<?PHP echo $id_tarea_target ?>">

<?PHP

///////////////////// JUSCE PRESENCIAL 8 NOVIEMBRE 2012

if($presencialx=="s")
	{
	echo '<input type="submit" value="MIGRAR NOTAS">';
	}
?>

<BR><BR>
<input type="hidden" id="tx_accion" name="tx_accion" value="salvar">
<input type="hidden" id="id_curso" name="id_curso" value="<?PHP echo $id_cursox ?>">

</p>
</form>
<BR><BR>
<?PHP
    print_footer($course);
?>

<script language="javascript">
function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}

function migrar(){
	obje("tx_accion")="salvar";
	obje("thisform").submit();
}
</script>

<?PHP
}
else
{
echo "Solo para Administradores";
}
?>