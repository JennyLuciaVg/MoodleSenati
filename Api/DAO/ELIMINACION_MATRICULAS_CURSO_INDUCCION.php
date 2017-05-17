<?php

include '../BD/conexion.php';

	function Eliminar_Matricula_Estudiante($id_matrix){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_E_M_C_I_ELIMINAR_MATRICULA_ESTUDIANTE('$id_matrix');") or die("Query fail: " . mysqli_error());
	}
	
	function Existe($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_E_M_C_I_EXISTE('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'existe_acta'=> $row[0]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Alumnos_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_E_M_C_I_LISTA_ALUMNOS_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_matricula'=> $row[0],            
                        'userid'=> $row[1],            
                        'lastname'=> $row[2],            
                        'firstname'=> $row[4],     
                        'pidm_banner'=> $row[5],     
                        'bloque'=> $row[6],     
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_E_M_C_I_LISTAR_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0],            
                        'induccion'=> $row[1],            
                        'presencial_de'=> $row[2],            
                        'subsanacion_de'=> $row[3]     
					));
                }  
            }
            echo json_encode($data);
	}
	


	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'EliminarME':
			$id_matrix = (strlen($_GET['id_matrix'])>0)?$_GET['id_matrix']:''; 
			Eliminar_Matricula_Estudiante($id_matrix);
        break;
		case 'Existes':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			 Existe($id_curso_moodle);
        break;
		case 'AlumnoCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			 Lista_Alumnos_Curso($id_curso_moodle);
        break;
		case 'Lista_Curso':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Lista_Curso($id_cursox);
        break;
		
		
    }
?>	