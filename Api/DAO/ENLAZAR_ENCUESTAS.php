<?php

include '../BD/conexion.php';

	function Lista_Nombre_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ENLAZAR_ENCUESTAS_NOMBRE_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Actualizar_Encuestas($id_tutor,$id_feedback){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ENLAZAR_ENCUESTAS_UPDATE('$id_tutor','$id_feedback');") or die("Query fail: " . mysqli_error());
	}
	
	function Lista_Encuestas($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTA_ENCUESTAS('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0], 
                        'course'=> $row[1], 
                        'name'=> $row[2], 
                        'intro'=> $row[3], 
                        'introformat'=> $row[4], 
                        'anonymous'=> $row[5], 
                        'email_notification'=> $row[6], 
                        'multiple_submit'=> $row[7], 
                        'autonumbering'=> $row[8], 
                        'site_after_submit'=> $row[9], 
                        'page_after_submit'=> $row[10], 
                        'pafe_after_submitformat'=> $row[11], 
                        'publish_stats'=> $row[12], 
                        'timeopen'=> $row[13], 
                        'timeclose'=> $row[14], 
                        'timemodified'=> $row[15], 
                        'completionsubmit'=> $row[16], 
                        'id_tutorial'=> $row[17], 
                        'firstname'=> $row[18], 
                        'lastname'=> $row[19]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Encuestras_Profesor($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call  SP_LISTA_ENCUESTAS_PROFESOR('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
			$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'userid'=> $row[0], 
                        'firstname'=> $row[1], 
                        'lastname'=> $row[2]                        
					));
                }  
            }
            echo json_encode($data);
	
	}
	


	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListaNombreCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Nombre_Curso($id_curso_moodle);
        break;
		case 'ActualizarEncuesta':
			$id_tutor = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			$id_feedback = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Actualizar_Encuestas($id_tutor,$id_feedback);
        break;
		case 'ListaEncuestas':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Encuestas($id_curso_moodle);
        break;
		case 'ListaEProfesor':
			$id_curso_moodle = (strlen($_GET['id_chat'])>0)?$_GET['id_chat']:''; 
			Encuestras_Profesor($id_curso_moodle);   
        break;
		
		
    }
?>	