			
			
				SELECT COALESCE((SELECT 1 FROM mdl_assignment_submissions WHERE assignment='. $id_tarea .' and userid='. $id_user_sv .' LIMIT 1),0) as "existe"';
				
  					  IF ($existe_tarea=="1")
						 //UPDATE
						 $sql_01="update mdl_assignment_submissions set grade=". $notaq. " where userid=".  $id_user_sv. " and assignment=". $id_tarea;
					  ELSE
						 //INSERT
						 insert into mdl_assignment_submissions(assignment,userid,grade,teacher,timecreated,timemodified,timemarked) values(". $id_tarea .",". $id_user_sv .",". $notaq .",2,1333557811,1333557811,1333557811)";
						 
						 
						 
						
						SELECT B.existe
							FROM mdl_assignment_submissions
							INNER JOIN(
									select count(1) existe,assignment,userid
										FROM mdl_assignment_submissions B
										group by assignment,userid)
									as B on assignment=@id_tarea and userid=@id_user_sv 	
							WHERE IIF ( B.existe='1',update mdl_assignment_submissions set grade=@notaq where userid=@id_user_sv and assignment=@id_tarea, 
										 insert into mdl_assignment_submissions(assignment,userid,grade,teacher,timecreated,timemodified,timemarked) values(@id_tarea,@id_user_sv,@notaq ,2,1333557811,1333557811,1333557811)	