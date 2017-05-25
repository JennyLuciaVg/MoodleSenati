create procedure x 
as
begin
		$query2  ="SELECT A.id, fullname,startdate, A.periodo,  ";
		$query2 .="(Select count(*) from mdl_user_students Z where Z.course=A.id) as Inscritos, visible, ";
		$query2 .="(Select count(*) from mdl_user_students W where W.course=A.id and status_sinfo='RET') as reti_sinfo, ";
		$query2 .="(Select count(*) from mdl_groups J where J.courseid=A.id) as total_grupox, ";
		$query2 .="(Select count(*) from mdl_user_teachers T where T.course=A.id) as total_tutores, ";
		$query2 .="(SELECT COALESCE((SELECT 1 FROM senati_pesos_recursos WHERE id_curso=A.id LIMIT 1),0)) as pondera, ";
		$query2 .="(SELECT COALESCE((SELECT 1 FROM senati_actas_notas WHERE id_curso=A.id LIMIT 1),0)) as hacademica, patron, ";
		$query2 .="(Select count(*) from mdl_forum_discussions P ";
		$query2 .="inner join mdl_forum_posts Q on Q.discussion=P.id ";
		$query2 .="inner join mdl_forum R on R.id=P.forum and P.course=R.course ";
		$query2 .="where R.course=A.id and Q.parent=0) as temas_foro ";
		$query2 .="FROM mdl_course A where (category<>39 and category<>43) and A.id<>1 and presencial_de is null and subsanacion_de is null ";
		$query2 .="and to_char(startdate::abstime, 'YYYY')='". $ano_listar . "' order by A.id desc";		  
		$result2 = pg_query($query2) or die('Query failed 55: ' . pg_last_error());
end		
create procedure consulta_cursos_por_anio()
as
begin

		// presenciales o subsanaciones
		$query5  ="SELECT A.id, fullname,startdate, A.periodo, subsanacion, subsanacion_de, presencial,";
		$query5 .="(Select count(*) from mdl_user_students Z where Z.course=A.id) as Inscritos, visible, ";
		$query5 .="(Select count(*) from mdl_user_students W where W.course=A.id and status_sinfo='RET') as reti_sinfo, ";
		$query5 .="(Select count(*) from mdl_groups J where J.courseid=A.id) as total_grupox, ";
		$query5 .="(Select count(*) from mdl_user_teachers T where T.course=A.id) as total_tutores, ";
		$query5 .="(SELECT COALESCE((SELECT 1 FROM senati_pesos_recursos WHERE id_curso=A.id LIMIT 1),0)) as pondera, ";
		$query5 .="(SELECT COALESCE((SELECT 1 FROM senati_actas_notas WHERE id_curso=A.id LIMIT 1),0)) as hacademica, ";
		$query5 .="(Select count(*) from mdl_forum_discussions P ";
		$query5 .="inner join mdl_forum_posts Q on Q.discussion=P.id ";
		$query5 .="inner join mdl_forum R on R.id=P.forum and P.course=R.course ";
		$query5 .="where R.course=A.id and Q.parent=0) as temas_foro ";
		$query5 .="FROM mdl_course A where presencial_de=". $id_curso_padre ." or subsanacion_de=". $id_curso_padre; 
		$query5 .=" order by subsanacion_de desc, A.id desc";		  
		$result5 = pg_query($query5) or die('Query failed 246: ' . pg_last_error());
end

		// PRESENCIALES 
		$query6  ="SELECT A.id, fullname,startdate, A.periodo,presencial, ";
		$query6 .="(Select count(*) from mdl_user_students Z where Z.course=A.id) as Inscritos, visible, ";
		$query6 .="(Select count(*) from mdl_user_students W where W.course=A.id and status_sinfo='RET') as reti_sinfo, ";
		$query6 .="(Select count(*) from mdl_groups J where J.courseid=A.id) as total_grupox, ";
		$query6 .="(Select count(*) from mdl_user_teachers T where T.course=A.id) as total_tutores, ";
		$query6 .="(SELECT COALESCE((SELECT 1 FROM senati_pesos_recursos WHERE id_curso=A.id LIMIT 1),0)) as pondera, ";
		$query6 .="(SELECT COALESCE((SELECT 1 FROM senati_actas_notas WHERE id_curso=A.id LIMIT 1),0)) as hacademica, ";
		$query6 .="(Select count(*) from mdl_forum_discussions P ";
		$query6 .="inner join mdl_forum_posts Q on Q.discussion=P.id ";
		$query6 .="inner join mdl_forum R on R.id=P.forum and P.course=R.course ";
		$query6 .="where R.course=A.id and Q.parent=0) as temas_foro ";
		$query6 .="FROM mdl_course A where presencial_de=". $id_curso_subsa; 
		$query6 .=" order by A.id desc";		  
		$result6 = pg_query($query6) or die('Query failed 350: ' . pg_last_error());
		