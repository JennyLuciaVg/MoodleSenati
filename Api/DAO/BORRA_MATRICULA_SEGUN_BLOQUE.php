<?php

include '../BD/conexion.php';


	function Eliminar_Por_Bloque($id_curso_moodle,$bloque){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_B_M_B_ELIMINAR_ESTUDIANTES_POR_BLOQUE('$id_curso_moodle','$bloque');") or die("Query fail: " . mysqli_error());
	}
	
	function Lista_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_B_M_LISTA_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
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
	
	function Lista_Numero_Curso($id_curso_moodle,$bloque){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_B_M_B_LISTA_NUMERO_CURSO('$id_curso_moodle','$bloque');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'total'=> $row[0]                    
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'EliminarBloque':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			$bloque = (strlen($_GET['bloque'])>0)?$_GET['bloque']:''; 
			Eliminar_Por_Bloque($id_curso_moodle,$bloque);
        break;
		case 'ListaCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Curso($id_curso_moodle);
        break;
		case 'BorraCeroLista':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:'';
			$bloque = (strlen($_GET['bloque'])>0)?$_GET['bloque']:'';
			Lista_Numero_Curso($id_curso_moodle,$bloque);
		break;
    }
?>	