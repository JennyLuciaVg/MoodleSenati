<?php

include '../BD/conexion.php';

	function Lista_Chat($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ENLAZAR_CHAT_LISTA_CHAT('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'course'=> $row[1],
                        'name'=> $row[2],
                        'intro'=> $row[3],
                        'introformat'=> $row[4],
                        'keepdays'=> $row[5],
                        'studentlogs'=> $row[6],
                        'chattime'=> $row[7],
                        'schedule'=> $row[8],
                        'timemodified'=> $row[9],
                        'id_tutor'=> $row[10],
                        'firstname'=> $row[11],
                        'lastname'=> $row[12],
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Tutores($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ENLAZAR_CHAT_LISTA_TUTORES('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(userid, B.firstname, B.lastname
                        'userid'=> $row[0],
                        'firstname'=> $row[1],
                        'lastname'=> $row[2]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Nombre_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ENLAZAR_CHAT_NOMBRE_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
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
	
	function Lista_Curso($id_tutor,$id_chat){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ENLAZAR_CHAT_UPDATE('$id_tutor','$id_chat');") or die("Query fail: " . mysqli_error());
	}
	


	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListaChat':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Chat($id_curso_moodle);
        break;
		case 'ListaTutor':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			 Lista_Tutores($id_curso_moodle;
        break;
		case 'NombreCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Nombre_Curso($id_curso_moodle);
        break;
		case 'ListaCurso':
			$id_tutor = (strlen($_GET['id_tutor'])>0)?$_GET['id_tutor']:''; 
			$id_chat = (strlen($_GET['id_chat'])>0)?$_GET['id_chat']:''; 
			Lista_Curso($id_tutor,$id_chat);   
        break;
		
		
    }
?>	