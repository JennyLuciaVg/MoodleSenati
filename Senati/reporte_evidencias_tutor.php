<?PHP
    // REPORTE PARA CONOCER EL AVANCE DE LOS TUTORES
	// POR GRUPO
	// TAREAS Y FOROS
	// 14 MAYO 2014
	// FUNCIONA el 18 de MAYo SE CORRIGIO pues a VECES HAY TAREAS QUE SE QUEDAN REGISTRADAS DE ALUMNOS QUE SE DESMATRICULARON !!!!!!!!!!!!!!
	// SE DEBE VERIFICAR QUE LAS TAREAS ENVIADAS CORRESPONDEN A ALUMNOS QUE ESTAN REALMENTE MATRICULADOS !!!!!
	
	// reporte_evidencias_tutor.php
	// Hacerlo ahora con un parametro id tutores

    require_once("../config.php");
    require_once("lib.php");

	$site = get_site();
    $id=required_param('id');              // course id
	$id_cursox=$id;
    $id_usuario=$USER->id;
	
    $tipo_reporte="Reporte de Todos los Tutores";
	////////////// ESTO ES PARA SELECCIONAR SOLO EL TUTOR QUE NECESITEMOS ///////////////////////////////////////////////
	// Tipo de Reportes
	// 0 es para administradores
	$tutor_sel=trim($_POST["sel_tutores"]);
	
	/////////////////$tutor_sel me indica el ID SV del TUTOR
	$nombre_tutor_sel="";
	if($tutor_sel!="")
	{
			$qnomtut="select lastname||', '||firstname as nombre_tutor from mdl_user where id=". $tutor_sel;
			$rnomtut = pg_query($qnomtut) or die('Query failed 37: ' . pg_last_error());
			$roxnomtut=pg_fetch_array($rnomtut);
			$nombre_tutor_sel=$roxnomtut["nombre_tutor"];
			$tipo_reporte="Reporte del Tutor : " . $nombre_tutor_sel;
	}
	
	//////////////////// FIN DE TUTOR SELECCIONADO /////////////////////////////////////////////////////////////////////////////
	
	
	//Verifico si el curso tiene grupos ($tiene_grupos=="1" -> "Este curso tiene grupos")
	$qexist='SELECT COALESCE((Select 1 from mdl_groups A inner join mdl_groups_members on groupid=A.id where courseid='. $id_cursox . ' LIMIT 1),0) as "existe"';
	$result_existe = pg_query($qexist) or die('Query failed: ' . pg_last_error());
	$roxg=pg_fetch_array($result_existe);
	$tiene_grupos=$roxg["existe"];

	// Verifico si tiene Ponderaciones
	$query1='SELECT COALESCE((Select 1 from senati_pesos_recursos where id_curso='. $id_cursox . ' LIMIT 1),0) as "tiene_pond"';
	$result1 = pg_query($query1) or die('Query failed: ' . pg_last_error());
	$rox=pg_fetch_array($result1);
	if ($rox["tiene_pond"]=="0")
		 {$existe_ponderacion=false;}
	else
		 {$existe_ponderacion=true;}

	$query0 = 'SELECT fullname,subsanacion, presencial,induccion,id_publico FROM mdl_course where id='. $id_cursox;
	$result0 = pg_query($query0) or die('Query failed 36: ' . pg_last_error());
	$rox0=pg_fetch_array($result0);

	$permite_subsanacion=false;

	$nombre_curso=$rox0["fullname"];
	$subx=$rox0["subsanacion"];
	$indux=$rox0["induccion"];
	$id_publico=$rox0["id_publico"];
	$presencial=$rox0["presencial"];
	
	// ALUMNOS EN TOTAL Y RETIRADOS
	// TOTAL ALUMNOS VALIDOS
	
	$query01 = "Select count(*) as total from mdl_user_Students Where course=". $id_cursox." and status_sinfo is null" ;
	$result01 = pg_query($query01) or die('Query failed 52: ' . pg_last_error());
	$rox01=pg_fetch_array($result01);
	$total_alumnos_validos=$rox01["total"];
	
	$queryr = "Select count(*) as total from mdl_user_Students Where course=". $id_cursox." and status_sinfo is not null" ;
	$resultr = pg_query($queryr) or die('Query failed 61: ' . pg_last_error());
	$roxr=pg_fetch_array($resultr);
	
	$total_alumnos_retirados=$roxr["total"];
	
	/// 5 es trabajador de SENATI
	/// 3 es Alumno de SENATI (DUAL)
	$es_susbanacion="";
	$es_presencial="";
	$es_induccion="";
	$id_publico="0";
	
	$mensaje_head="ESTE ES UN CURSO REGULAR.";
	
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

	/////////// SI ES ADMIN ES Reporte de Evidencias si es tutor es MIS EVIDENCIAS
	$titulo_pagina = "Reporte de Evidencias por Tutor - Grupo";
	$enlace="<a href='view.php?id=". $id_cursox . "'>". $nombre_curso . "</a> &gt; " . $titulo_pagina;
	print_header("$site->shortname : ". $titulo_pagina, "X1", $enlace, "", "", true, "");

?>
<STRONG style="color:blue">Reporte de Evidencias por Tutor - Grupo - Bloque</STRONG>

<?PHP

echo "<p><font style='font-size:18px' color=green>". $mensaje_head . "</font></p>";

/// INICIO TAREAS
/// LISTADO DE TAREAS que no sean OFFLINE y QUE TENGAN PESO DIFERENTE A CERO
$query2  = "select A.id as id_tarea, A.name, D.section as unidad, A.assignmenttype as tipo_tarea, peso_recurso FROM mdl_assignment A ";
$query2 .= "left Join senati_pesos_recursos B on id_recurso=A.id and tipo_recurso=1 ";
$query2 .= "left join mdl_course_modules C on C.course=id_curso and C.module=1 and C.instance=A.id ";
$query2 .= "left join mdl_course_sections D on D.id=C.section ";
$query2 .= "where id_curso=". $id_cursox ." and peso_recurso<>0 and A.assignmenttype<>'offline' ";
$query2 .= "order by D.id, A.id ";
$result2 = pg_query($query2) or die('Query failed 107: ' . pg_last_error());
	// creo un array en PHP
	$tarea_idx = array();
	$tarea_namex = array();
	$tarea_unidadx = array();
	$tarea_tipox = array();
	$tarea_pesox = array();
	$ctar=0;
	while($row2=pg_fetch_array($result2))
		{
		$tarea_idx[$ctar]=$row2["id_tarea"];
		$tarea_namex[$ctar]=$row2["name"];
		$tarea_unidadx[$ctar]=$row2["unidad"];
		$tarea_tipox[$ctar]=$row2["tipo_tarea"];
		$tarea_pesox[$ctar]=$row2["peso_recurso"];
		$ctar++;
		}
	$total_tareas=$ctar;

/// FIN TAREAS

/// LISTADO DE FOROS DISCUSIONES
//$query27 = 'SELECT distinct(a.id), scale, peso_recurso FROM mdl_forum a left Join senati_pesos_recursos on id_recurso=a.id and tipo_recurso=3 where peso_recurso<>0 and course='. $id_cursox . ' and a.scale=20 order by a.id';
/*
//////////////////////////////////////////////   FOROS /////////////////////////////////
	$query9 = 'Select a.id as id_foro, b.id as discuss, c.userid, d.post, d.rating,peso_recurso from mdl_forum a ';
	$query9 .= 'left Join senati_pesos_recursos on id_recurso=A.id ';
	$query9 .= 'left join mdl_forum_discussions b on a.id=b.forum ';
	$query9 .= 'left join mdl_forum_posts c on c.discussion=b.id ';
	$query9 .= 'left join mdl_forum_ratings d on d.post=c.id  Where a.course='. $id_cursox . ' and a.scale=20 and c.userid=' . $id_userx .' and a.id='.$id_foro;
	// el rating es la nota 
	
	LAS DISCUSSIONES o TEMAS CORRESPONDEN A UN GRUPO EN ESPECIAL POR ESO ACA NO SE VA A USAR SOLO EN EL CALCULO
	DEBO PONER LA CANTIDAD DE ALUMNOS QUE HAN POSTEADO NO CANTIDAD DE POSTS
*/

/// ESTA ES SIMPLEMENTE LA LISTA DE FOROS CON SU UNIDAD
$query3  = "Select A.id as id_foro, A.name as nombre_foro, D.section as unidad, peso_recurso ";
$query3 .= "from mdl_forum A ";
$query3 .= "inner join mdl_course_modules C on C.instance=A.id and C.course=A.course ";
$query3 .= "inner join mdl_course_Sections D on D.id=C.section and D.course=A.course ";
$query3 .= "inner join senati_pesos_recursos E on E.id_recurso=A.id and tipo_recurso=3 ";
$query3 .= "Where C.module=5 and a.scale<>-1 and type='general' and	a.course=" . $id_cursox . " ";
$query3 .= "order by D.section, A.name ";
$result3 = pg_query($query3) or die('Query failed 158: ' . pg_last_error());
	// creo un array en PHP
	$foro_idx = array();
	$foro_namex = array();
	$foro_unidadx = array();
	$foro_pesox = array();
	$cfor=0;
	while($row3=pg_fetch_array($result3))
		{
		$foro_idx[$cfor]=$row3["id_foro"];
		$foro_namex[$cfor]=$row3["nombre_foro"];
		$foro_unidadx[$cfor]=$row3["unidad"];
		$foro_pesox[$cfor]=$row3["peso_recurso"];
		$cfor++;
		}
	$total_foros=$cfor;
/// FIN DE LISTADO DE FOROS DISCUSIONES


/// INICIO GRUPOS
/// ACA TENGO QUE ITERAR LOS GRUPOS TUTOR
/// ACA DEBO LISTAR TODOS LOS GRUPOS TUTOR DEL CURSO	
	
	$queryg  = "Select A.id as id_grupo, A.name as nombre_grupo, ";
	$queryg .= "(Select max(D.id)  ";
	$queryg .= "from mdl_groups_members B  ";
	$queryg .= "left join mdl_user_teachers C on C.course=A.courseid and C.userid=B.userid ";
	$queryg .= "left join mdl_user D on D.id=C.userid ";
	$queryg .= "where B.groupid=A.id) as id_tutor, E.id, E.lastname||', '||E.firstname as nombre_tutor ";
	//$queryg .= "where B.groupid=A.id) as id_tutor, E.id, E.lastname as nombre_tutor ";
	$queryg .= "from mdl_groups A ";
	$queryg .= "left join mdl_user E on E.id=(Select max(G.id) ";
	$queryg .= "						from mdl_groups_members H  ";
	$queryg .= "						left join mdl_user_teachers J on J.course=A.courseid and J.userid=H.userid ";
	$queryg .= "						left join mdl_user G on G.id=J.userid ";
	$queryg .= "						where H.groupid=A.id)";
	$queryg .= "Where A.courseid=". $id_cursox ." order by A.name";
	
	$resultg =pg_query($queryg) or die('Query failed 156: ' . pg_last_error());
	
	// creo un array en PHP de los grupos
	$grupo_idx = array();
	$grupo_namex = array();
	$grupo_tutorx = array();
	$grupo_id_tutorx = array();
	$cgru=0;
	while($rowg=pg_fetch_array($resultg))
		{
		$grupo_idx[$cgru]=$rowg["id_grupo"];
		$grupo_namex[$cgru]=$rowg["nombre_grupo"];
		$grupo_tutorx[$cgru]=$rowg["nombre_tutor"];
		$grupo_id_tutorx[$cgru]=$rowg["id_tutor"];
		$cgru++;
		}
	$total_grupos=$cgru;
////////////// FIN GRUPOS //////////////////////////////////
	
	// Puedo hace una lista de Tutores

//////////////////////////////// TUTORES Y LA CANTIDAD DE GRUPOS  //////////////////////////////////	
$query_tutores  = "SELECT A.userid, lastname||', '||firstname as nombre_tutor, ";
$query_tutores .= "(Select count(*) from mdl_groups C inner join mdl_groups_members D on D.groupid=C.id where C.courseid=A.course and D.userid=A.userid) as total_grupos "; 
$query_tutores .= "From mdl_user_teachers A ";
$query_tutores .= "left join mdl_user B on A.userid=B.id ";
$query_tutores .= "where A.course=" . $id_cursox;
$result_tutores=pg_query($query_tutores) or die('Query failed 235: ' . pg_last_error());

	$tutor_nombrex= array();
	$tutor_idx = array();
	$tutor_grupox = array(); ///total de grupos
	$ctut=0;
	while($rowtut=pg_fetch_array($result_tutores))
		{
			if($rowtut["total_grupos"]!="0")
			  {	 
				$tutor_nombrex[$ctut]=$rowtut["nombre_tutor"];
				$tutor_idx[$ctut]=$rowtut["userid"];
				$tutor_grupox[$ctut]=$rowtut["total_grupos"];
				$ctut++;
			  }
		}
	$total_tutores=$ctut;
////////////// FIN TUTORES Y CANTIDAD DE GRUPOS POR TUTOR //////////////////////////////////
?>

<form name="thisform" id="thisform" method="post">

<strong>REPORTE DE </strong> 

<select id="sel_tutores" name="sel_tutores">
<?PHP
echo "<OPTION value=''>Todos los Tutores</OPTION>\n";
for ($j=0;$j<$total_tutores; $j++)
	{
	$sela="";
	if ($tutor_sel==$tutor_idx[$j])
	   {$sela="selected";}
	echo "<OPTION value='".$tutor_idx[$j] ."' ". $sela .">". $tutor_nombrex[$j] ." (". $tutor_grupox[$j] ."  Grupos)</OPTION>\n";
	}
?>
</select>
&nbsp;
<INPUT type=submit value="Ver Evidencias del Tutor Indicado">
</form>

<BR>
<TABLE border=1 bordercolor=silver cellpadding=2 cellspacing=2>
<TR>
<TD align=right>Total Alumnos NO RETIRADOS</TD><TD align=right style="font-size:16px">&nbsp;<?PHP echo $total_alumnos_validos ?>&nbsp;</TD>
</TR>
<TR>
<TD align=right><font color=red>Total Alumnos RETIRADOS</font></TD><TD align=right style="font-size:16px">&nbsp;<?PHP echo $total_alumnos_retirados ?>&nbsp;</TD>
</TR>
<TR>
<TD align=right><font color=blue>Total Tareas&nbsp;</font></TD><TD align=right style="font-size:16px">&nbsp;<?PHP echo $total_tareas ?>&nbsp;</TD>
</TR>
<TR>
<TD align=right><font color=blue>Total Foros&nbsp;</font></TD><TD align=right style="font-size:16px">&nbsp;<?PHP echo $total_foros ?>&nbsp;</TD>
</TR>
<TR>
<TD align=right>Total Tutores&nbsp;</TD><TD align=right style="font-size:16px">&nbsp;<?PHP echo $total_tutores ?>&nbsp;</TD>
</TR>
<TR>
<TD align=right>Total Grupos&nbsp;</TD><TD align=right style="font-size:16px">&nbsp;<?PHP echo $total_grupos ?>&nbsp;</TD>
</TR>
</TABLE>


<?PHP
	echo "<BR><strong><font color=blue style='font-size:17px'>". $tipo_reporte . "</font></strong>";
?>

<BR>
<STRONG style="font-size:18px">TAREAS</STRONG>
<table border=1 bordercolor=silver cellpadding=2 cellspacing=2>
<TR>
<TD bgcolor=#dddddd align=center><strong>Id Tarea</strong></TD>
<TD bgcolor=#dddddd><strong>Nombre</strong></TD>
<TD bgcolor=#dddddd><strong>Enviaron Tarea</strong></TD>
<TD bgcolor=#dddddd><strong>No Enviaron Tarea</strong></TD>
<TD bgcolor=#dddddd><strong>TOTAL</strong></TD>
<TD bgcolor=#dddddd><strong>Unidad</strong></TD>
<TD bgcolor=#dddddd><strong>Peso</strong></TD>
</TR>

<?PHP
for ($j=0;$j<$total_tareas;$j++)
	{ 
	/// MUESTRO CADA TAREA
	$tarea_id=$tarea_idx[$j];
	$tarea_nombre=$tarea_namex[$j];
	$tarea_unidad=$tarea_unidadx[$j];
	$tarea_peso=$tarea_pesox[$j];
	
	// TENGO EL ID DEL GRUPO
	// NOMBRE DEL GRUPO
	// ID DEL TUTOR
	// NOMBRE DEL TUTOR
	// SOLO LEO LA LISTA DE ALUMNOS QUE ESTAN EN EL GRUPO mdl_groups_members (groupid, userid) y que no estan retirados es decir userid no esta en userid de mdl_user_students con status_sinfo ='RET'
    // Si el Reporte es Individual del TUTOR se debe filtrar este resultado
	// si $tutor_sel existe debo identificar los grupos a los que este tutor pertenece
	
	
	///////////// ESTO PUEDE SERVIR PARA TAREAS Y FOROS ///////////////////////////////////
	$grupos_del_tutor="";
	if ($tutor_sel!="")
	   {
		// identifico los groupid del tutor_sel
		// $grupo_idx = array();
		// $grupo_namex = array();
		// $grupo_tutorx = array();
		// $grupo_id_tutorx = array();
		// $total_grupos
		$conta=0;
		for ($j=0;$j<$total_grupos;$j++)
			{
				if ($grupo_id_tutorx[$j]==$tutor_sel)
				   {
					if ($conta==0)
					   {
					   $grupos_del_tutor=$grupo_idx[$j];
					   }
					else
					   {
					   $grupos_del_tutor .=",".$grupo_idx[$j];
					   }
					$conta++;   
				   }
			}
		// TENGO :  $grupos_del_tutor ////////////////////////////////////
	   }
	
	
	if ($tutor_sel!="")
		{
		$query_tte  ="Select count(*) as tte from mdl_assignment_submissions A where assignment=". $tarea_id; 
		$query_tte .=" and A.userid in ";
		$query_tte .=" ("; 
		$query_tte .="Select B.userid from mdl_user_students B ";
		$query_tte .="inner join mdl_user D on D.id=B.userid and D.deleted=0 ";
		$query_tte .="Where B.course=". $id_cursox ." and status_sinfo is null ";
		$query_tte .="and B.userid in (Select userid from mdl_groups_members where groupid in (". $grupos_del_tutor .")) ";
		$query_tte .=")";
		
		//// AVERIGUAR EL TOTAL DE ALUMNOS DE ESE TUTOR
		//// Total de Alumnos del Tutor
		$query_ttt  ="Select count(*) as total_alumnos_tutor from mdl_user_students B ";
		$query_ttt .="inner join mdl_user D on D.id=B.userid and D.deleted=0 ";
		$query_ttt .="Where B.course=". $id_cursox ." and status_sinfo is null ";
		$query_ttt .="and B.userid in (Select E.userid from mdl_groups_members E where groupid in (". $grupos_del_tutor ."))";
		
		$result_ttt =pg_query($query_ttt) or die('Query failed 386: ' . pg_last_error());
		$row_ttt=pg_fetch_array($result_ttt);
		$total_alumnos_tutor=$row_ttt["total_alumnos_tutor"];
		
		$result_tte =pg_query($query_tte) or die('Query failed 396: ' . pg_last_error());
		$row_tte=pg_fetch_array($result_tte);
		$total_tareas_enviadas=$row_tte["tte"];
		$total_tareas_no_enviadas=$total_alumnos_tutor-$total_tareas_enviadas;
		}
	else
	   {
		$query_tte  = "Select count(*) as tte from mdl_assignment_submissions A where assignment=". $tarea_id;
		$query_tte .= " and A.userid in (Select B.userid from mdl_user_students B inner join mdl_user D on D.id=B.userid and D.deleted=0 Where B.course=". $id_cursox." and status_sinfo is null)";
		$result_tte =pg_query($query_tte) or die('Query failed 396: ' . pg_last_error());
		
		$row_tte=pg_fetch_array($result_tte);
		$total_tareas_enviadas=$row_tte["tte"];
		$total_tareas_no_enviadas=$total_alumnos_validos-$total_tareas_enviadas;
	   }

	
	// ENLACE PARA CALIFICAR LA TAREA
	// http://virtual.senati.edu.pe/mod/assignment/submissions.php?id=62043&userid=38129&mode=single&offset=2
	
?>
<TR>
<TD align=center><?PHP echo $tarea_id ?></TD>
<TD ><strong><?PHP echo $tarea_nombre ?></strong>
<BR>
<!-- ACA SE PONE LA LISTA DE GRUPOS Y TUTORES ------------------------------------------------------------------->
	<table cellspacing=1 cellpadding=1 border=1 bordercolor=silver>
	<tr>
	<td bgcolor=#DDDDDD><strong>Tutor</strong></td>
	<td bgcolor=#DDDDDD><strong>Id Grupo</strong></td>
	<td bgcolor=#DDDDDD><strong>Grupo</strong></td>
	<td bgcolor=#DDDDDD><strong>Calificadas</strong></td>
	<td bgcolor=#DDDDDD><strong>NO Calificadas</strong></td>
	</TR>
<?PHP
$total_calix=0;
$total_no_calix=0;
for ($k=0;$k<$total_grupos;$k++)
	{

	$mostrar=true;
	if ($tutor_sel!="")
	   {
		if($grupo_id_tutorx[$k]!=$tutor_sel)
		  {
		   $mostrar=false;
		  }
	   }
	
	if ($mostrar)
	   {
		// Tareas Calificadas
			$qtar_cali  = "Select count(*) as tareas_calificadas from mdl_assignment_submissions A where assignment=". $tarea_id ." and grade<>-1 ";
			$qtar_cali .= "and A.userid in (Select B.userid from mdl_groups_members B inner join mdl_user D on D.id=B.userid inner join mdl_user_students E on E.userid=B.userid Where B.groupid=". $grupo_idx[$k] ;
			$qtar_cali .= "and E.course=". $id_cursox . " and  D.deleted=0) ";
			$qtar_cali .= "and A.userid not in (Select C.userid from mdl_user_Students C Where course=". $id_cursox ." and status_sinfo is not null)"; 
			$result_cali=pg_query($qtar_cali) or die('Query failed 269: ' . pg_last_error());
			$row_cali=pg_fetch_array($result_cali);
			$tareas_calificadas=$row_cali["tareas_calificadas"];
			
			// Tareas SIN CALIFICAR
			$qtar_nocali  = "Select count(*) as tareas_no_calificadas from mdl_assignment_submissions A where assignment=". $tarea_id ." and grade=-1 ";
			$qtar_nocali .= "and A.userid in (Select B.userid from mdl_groups_members B inner join mdl_user D on D.id=B.userid inner join mdl_user_students E on E.userid=B.userid Where B.groupid=". $grupo_idx[$k] ;
			$qtar_nocali .= "and E.course=". $id_cursox . " and D.deleted=0) ";
			$qtar_nocali .= "and A.userid not in (Select C.userid from mdl_user_Students C  Where course=". $id_cursox ." and status_sinfo is not null)"; 
			$result_nocali=pg_query($qtar_nocali) or die('Query failed 272: ' . pg_last_error());
			$row_nocali=pg_fetch_array($result_nocali);
			$tareas_no_calificadas=$row_nocali["tareas_no_calificadas"];
			
			$total_calix=$total_calix + $tareas_calificadas;
			$total_no_calix=$total_no_calix + $tareas_no_calificadas;
			
			//echo "<BR>" . $grupo_namex[$k] . " (". $grupo_idx[$k] .") - ". $grupo_tutorx[$k] . " : ". $tareas_calificadas . " Tareas Calificadas" . ", " . $tareas_no_calificadas . " Tareas NO Calificadas";
			/// tengo el $grupo_idx[$k]
			/// tengo el $grupo_id_tutorx[$k]
			/// tengo la $tarea_id
			/// ahora veo cuantas tienen grade =-1
			
			

			$estilo="";
			if($tareas_no_calificadas!="0")
				{
				$estilo="bgcolor=yellow";
				}	
			// EN LA PARTE DE TAREAS NO CALIFICADAS PONER UN ENLACE SI HAY AL MENOS UNA
?>				
			<TR>
			<td><?PHP echo $grupo_tutorx[$k] ?></td>
			<td align=center><?PHP echo $grupo_idx[$k] ?></td>
			<td><?PHP echo $grupo_namex[$k]?></td>
			<td align=center><?PHP echo $tareas_calificadas ?></td>
			<td align=center <?PHP echo $estilo ?>>
			<?PHP if ($tareas_no_calificadas!="0")
				{
			?>
			<a href="javascript:ver_tarea(<?PHP echo $grupo_id_tutorx[$k] ?>,<?PHP echo $tarea_id ?>,<?PHP echo $grupo_idx[$k] ?>)"><u><?PHP echo $tareas_no_calificadas ?></u></a>
			<?PHP
				}
				else
				{
			?>
			<?PHP echo $tareas_no_calificadas ?>
			<?PHP
				}
			?>
			</td>
			</TR>
<?PHP			
		}
	}
?>
	<TR>
	<TD colspan=3 align=right><strong>TOTALES*</strong></TD>
	<TD align=center><strong><?PHP echo $total_calix?></strong></TD>
	<TD align=center><strong><?PHP echo $total_no_calix?></strong></TD>
	</TR>
	</table>
</TD>
<TD align=center><?PHP echo $total_tareas_enviadas ?></TD>
<TD align=center><?PHP echo $total_tareas_no_enviadas ?></TD>
<TD align=center><?PHP echo $total_tareas_enviadas + $total_tareas_no_enviadas +1-1 ?></TD>
<TD align=center><?PHP echo $tarea_unidad ?></TD>
<TD align=right><?PHP echo $tarea_peso ?> %</TD>
</TR>
<?PHP	
    //// Cierra el for de tareas
   }
?>
</TABLE>
<strong><em>*La suma de los TOTALES debe ser igual a la cantidad indicada en la columna "Enviaron Tarea".</em></strong>
<BR>
<BR>
<STRONG style="font-size:18px">FOROS</STRONG>
<table border=1 bordercolor=silver cellpadding=2 cellspacing=2>
<TR>
<TD bgcolor=#dddddd align=center><strong>Id Foro</strong></TD>
<TD bgcolor=#dddddd><strong>Nombre</strong></TD>
<TD bgcolor=#dddddd><strong>Total Posts</strong></TD>
<TD bgcolor=#dddddd><strong>Unidad</strong></TD>
<TD bgcolor=#dddddd><strong>Peso</strong></TD>
</TR>
<?PHP
for ($j=0;$j<$total_foros;$j++)
	{ 
	
	$foro_id=$foro_idx[$j];
	$foro_nombre=$foro_namex[$j];
	$foro_unidad=$foro_unidadx[$j];
	$foro_peso=$foro_pesox[$j];
	
	/*
	$mostrar=true;
	if ($tutor_sel!="")
	   {
		if($grupo_id_tutorx[$k]!=$tutor_sel)
		  {
		   $mostrar=false;
		  }
	   }
	//// DEBO CALCULAR LA CANTIDAD TOTAL DE POSTS DE LOS GRUPOS DEL TUTOR
	*/   
	
	// Calculo cuantos POSTS
	if ($tutor_sel!="")
	{
		/// tengo el dato $grupos_del_tutor
		
		$qpostearon  = "Select count(DISTINCT(c.id)) as postearon ";
		$qpostearon .= "from mdl_forum a "; 
		$qpostearon .= "left join mdl_forum_discussions b on a.id=b.forum ";
		$qpostearon .= "left join mdl_forum_posts c on c.discussion=b.id ";
		$qpostearon .= "Where a.course=". $id_cursox ." and a.id=". $foro_id ." and c.parent<>0 ";
		$qpostearon .= "and c.userid in (select e.userid from mdl_user_students e inner join mdl_user f on f.id=e.userid and f.deleted=0 where e.course=a.course and status_sinfo is null) "; 
		$qpostearon .= "and c.userid in (Select userid from mdl_groups_members where groupid in (". $grupos_del_tutor .")) "; 
		$result_qpostearon=pg_query($qpostearon) or die('Query failed 538: ' . pg_last_error());
		
		$row_postearon=pg_fetch_array($result_qpostearon);
		$usuarios_postearon=$row_postearon["postearon"];
	}
	else
	{
		$qpostearon  = "Select count(DISTINCT(c.id)) as postearon ";
		$qpostearon .= "from mdl_forum a "; 
		$qpostearon .= "left join mdl_forum_discussions b on a.id=b.forum ";
		$qpostearon .= "left join mdl_forum_posts c on c.discussion=b.id ";
		$qpostearon .= "Where a.course=". $id_cursox ." and a.id=". $foro_id ." and c.parent<>0 ";
		$qpostearon .= "and c.userid in (select e.userid from mdl_user_students e inner join mdl_user f on f.id=e.userid and f.deleted=0 where e.course=a.course and status_sinfo is null)"; 
		$result_qpostearon=pg_query($qpostearon) or die('Query failed 538: ' . pg_last_error());
		
		$row_postearon=pg_fetch_array($result_qpostearon);
		$usuarios_postearon=$row_postearon["postearon"];
	}	

?>
<TR>
<TD align=center><?PHP echo $foro_id ?></TD>
<TD><strong><?PHP echo $foro_nombre ?></strong>
<!-- JUSTO ACA PONGO LA LISTA DE GRUPOS Y EL REPORTE


-->
<BR>
	<table cellspacing=1 cellpadding=1 border=1 bordercolor=silver>
		<tr>
		<td bgcolor=#DDDDDD><strong>Tutor</strong></td>
		<td bgcolor=#DDDDDD><strong>Id Grupo</strong></td>
		<td bgcolor=#DDDDDD><strong>Grupo</strong></td>
		<td bgcolor=#DDDDDD><strong>Posts Calificados</strong></td>
		<td bgcolor=#DDDDDD><strong>Posts NO Calificados</strong></td>
		</TR>
	<?PHP
	$total_caliy=0;
	$total_no_caliy=0;
	for ($k=0;$k<$total_grupos;$k++)
		{
			$mostrar=true;
			if ($tutor_sel!="")
			   {
				if($grupo_id_tutorx[$k]!=$tutor_sel)
				  {$mostrar=false;}
			   }
		    // TENGO LOS $grupos_del_tutor
		    // El problema en esta consulta o en la general es que es posible que un usuario haya posteado mas de una vez y que un post SI se haya calificado y otro NO
            if ($mostrar)
			{
			    // Muestro cuantos usuarios tuvieron post calificados en el grupo en cantidad de usuarios
				// USUARIOS CON FOROS CALIFICADOS
				$qpostearon_grupo_cali  = "Select count(DISTINCT(c.id)) as usuarios_calificados ";
				$qpostearon_grupo_cali .= "from mdl_forum a ";
				$qpostearon_grupo_cali .= "inner join mdl_forum_discussions b on a.id=b.forum ";
				$qpostearon_grupo_cali .= "inner join mdl_forum_posts c on c.discussion=b.id ";
				$qpostearon_grupo_cali .= "inner join mdl_forum_ratings d on d.post=c.id ";
				$qpostearon_grupo_cali .= "Where a.course=". $id_cursox ." and a.id=". $foro_id ." and c.parent<>0 and b.groupid=". $grupo_idx[$k] . " and rating is not null ";
				$qpostearon_grupo_cali .= "and c.userid in (select e.userid from mdl_user_students e inner join mdl_user f on f.id=e.userid and f.deleted=0 where e.course=a.course and status_sinfo is null)";
				$result_qpostearon_grupo_cali=pg_query($qpostearon_grupo_cali) or die('Query failed 584: ' . pg_last_error());
				$row_postearon_grupo_cali=pg_fetch_array($result_qpostearon_grupo_cali);
				$usuarios_calificados=$row_postearon_grupo_cali["usuarios_calificados"];
				
				//USUARIOS QUE POSTEARON PERO QUE NO FUERON CALIFICADOS
				$qpostearon_grupo_no_cali  = "Select count(DISTINCT(c.id)) as usuarios_no_calificados ";
				$qpostearon_grupo_no_cali .= "from mdl_forum a ";
				$qpostearon_grupo_no_cali .= "inner join mdl_forum_discussions b on a.id=b.forum ";
				$qpostearon_grupo_no_cali .= "inner join mdl_forum_posts c on c.discussion=b.id ";
				$qpostearon_grupo_no_cali .= "left join mdl_forum_ratings d on d.post=c.id ";
				$qpostearon_grupo_no_cali .= "Where a.course=". $id_cursox ." and a.id=". $foro_id ." and c.parent<>0 and b.groupid=". $grupo_idx[$k] . " and rating is null ";
				$qpostearon_grupo_no_cali .= "and c.userid in (select e.userid from mdl_user_students e inner join mdl_user f on f.id=e.userid and f.deleted=0 where e.course=a.course and status_sinfo is null)";
				$result_qpostearon_grupo_no_cali=pg_query($qpostearon_grupo_no_cali) or die('Query failed 598: ' . pg_last_error());
				$row_postearon_grupo_no_cali=pg_fetch_array($result_qpostearon_grupo_no_cali);
				$usuarios_no_calificados=$row_postearon_grupo_no_cali["usuarios_no_calificados"];

				//$total_no_caliy
			
			$estiloy="";
			if($usuarios_no_calificados!="0")
				{
				$estiloy="bgcolor=yellow";
				}
				
				$id_tutorx=$grupo_id_tutorx[$k];
				//$foro_id
				$id_grupox=$grupo_idx[$k];
				
				
?>
				<TR>
				<td><?PHP echo $grupo_tutorx[$k] ?></td>
				<td align=center><?PHP echo $grupo_idx[$k] ?></td>
				<td><?PHP echo $grupo_namex[$k] ?></td>				
				<td align=center><?PHP echo $usuarios_calificados ?></td>
				<!-- aqui enviar con un enlace a calificar los foros -->
				<td align=center <?PHP echo $estiloy ?>>
				<?PHP if ($usuarios_no_calificados!="0")
				{
				?>
				<a alt="Ver Foros NO Calificados" title="Ver Foros NO Calificados" href="javascript:ver_foros(<?PHP echo $id_tutorx?>,<?PHP echo $foro_id ?>,<?PHP echo $id_grupox ?>)">
				<u><?PHP echo $usuarios_no_calificados ?></u>
				</a>
				<?PHP
				}
				else
					{
					echo $usuarios_no_calificados;				
					}
				?>
				</td>
				</TR>
				
<?PHP				
				$total_caliy=$total_caliy+1-1+$usuarios_calificados;
				$total_no_caliy=$total_no_caliy+1-1+$usuarios_no_calificados;
			}
		}
	?>
	<TR>
	<TD colspan=3 align=right><strong>TOTALES**</strong></TD>
	<TD align=center><strong><?PHP echo $total_caliy?></strong></TD>
	<TD align=center ><strong><?PHP echo $total_no_caliy?></strong></TD>
	</TR>
	</TABLE>

</TD>
<TD align=center><?PHP echo $usuarios_postearon ?></TD>
<TD align=center><?PHP echo $foro_unidad ?></TD>
<TD align=right><?PHP echo $foro_peso ?> %</TD>
</TR>
<?PHP
    /// CIERRA el for de FOROS
	}
?>
	
</TABLE>
<em><strong>**La suma de los TOTALES debe ser igual a la cantidad indicada en la columna "Total Posts".</strong></em>


<BR><BR>
<font color=red>NOTA: EN TODOS LOS CALCULOS solo se toman en cuenta los Alumnos NO RETIRADOS</font>

<form name="forma_foros" id="forma_foros" method="post" action="reporte_evidencias_tutor_foro.php">
<INPUT TYPE=hidden name="id_curso" id="id_curso" value="<?PHP echo $id_cursox ?>">
<INPUT TYPE=hidden name="id_usuario" id="id_usuario" value="<?PHP echo $id_usuario?>">
<INPUT TYPE=hidden name="id_tutor" id="id_tutor" value="">
<INPUT TYPE=hidden name="id_foro" id="id_foro" value="">
<INPUT TYPE=hidden name="id_grupo" id="id_grupo" value="">
</form>

<form name="forma_tareas" id="forma_tareas" method="post" action="reporte_evidencias_tutor_tarea.php">
<INPUT TYPE=hidden name="id_cursot" id="id_cursot" value="<?PHP echo $id_cursox ?>">
<INPUT TYPE=hidden name="id_usuariot" id="id_usuariot" value="<?PHP echo $id_usuario?>">
<INPUT TYPE=hidden name="id_tutort" id="id_tutort" value="">
<INPUT TYPE=hidden name="id_tarea" id="id_tarea" value="">
<INPUT TYPE=hidden name="id_grupot" id="id_grupot" value="">
</form>


<?PHP	
    print_footer($course);
?>
<SCRIPT language="javascript">

function obje(ide){
	var obex=document.getElementById(ide);
	return obex;
}


function ver_foros(id_tutor,id_foro,id_grupo)
{
	obje("id_tutor").value=id_tutor;
	obje("id_foro").value=id_foro;
	obje("id_grupo").value=id_grupo;
	obje("forma_foros").submit();
}

function ver_tarea(id_tutor,id_tarea,id_grupo)
{
	obje("id_tutort").value=id_tutor;
	obje("id_tarea").value=id_tarea;
	obje("id_grupot").value=id_grupo;
	
	alert (id_tutor + "," + id_tarea + "," + id_grupo);
	//obje("forma_tareas").submit();
}

</SCRIPT>

