<?php

include '../BD/conexion.php';

	function Actualizar_CursoEstado($ID_CURSOS,$ESTADO_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTUALIZAR_CURSO_ESTADO('$ID_CURSOS','$ESTADO_CURSO');") or die("Query fail: " . mysqli_error());
	
	}
	
	function Curso_Presenciales($periodo,$campus ){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVALUACIONES_CURSO_PRESENCIALES('$periodo','$campus');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0], 
                        'fullname'=> $row[1], 
                        'visible'=> $row[2],
                        'existe'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Campus(){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GETALL_CAMPUS();") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_centro'=> $row[0], 
                        'nombre_centro'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Datos($id_curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GETBYID_DATOS_QUIZ('$id_curso');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_course_modules'=> $row[0], 
                        'id_quiz'=> $row[1], 
                        'nombre_quiz'=> $row[2], 
                        'instance'=> $row[3], 
                        'module_section'=> $row[4], 
                        'module_visible'=> $row[5], 
                        'seccion_visible'=> $row[6], 
                        'password_quiz'=> $row[7], 
                        'subnet'=> $row[8]
					));
                }  
            }
            echo json_encode($data);
	}
	
	


	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ActualizarCEstado':
			$ID_CURSOS = (strlen($_POST['ID_CURSOS'])>0)?$_POST['ID_CURSOS']:''; 
			$ESTADO_CURSO = (strlen($_POST['ESTADO_CURSO'])>0)?$_POST['ESTADO_CURSO']:''; 
			Actualizar_CursoEstado($ID_CURSOS,$ESTADO_CURSO);
        break;
		case 'CursoPresencial':
			$periodo = (strlen($_GET['periodo'])>0)?$_GET['periodo']:''; 
			$campus = (strlen($_GET['campus'])>0)?$_GET['campus']:''; 
			Curso_Presenciales($periodo,$campus);
        break;
		case 'ListaCampus':
			Lista_Campus();
        break;
		case 'ListaDatos':
			$id_curso = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:''; 
			Lista_Datos($id_curso);   
        break;
		
		
    }
?>	