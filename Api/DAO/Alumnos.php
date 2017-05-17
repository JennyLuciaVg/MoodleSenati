<?php

include '../BD/conexion.php';


	function Listar_Tutores($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ALUMNOS_GRUPOS_TUTORES('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_grupo'=> $row[0],
                        'nombre_grupo'=> $row[1],
                        'grupo_numerico'=> $row[2],
                        'userid'=> $row[3],
                        'firstname'=> $row[4],
                        'lastname'=> $row[5],
                        'pidm_banner'=> $row[6]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Nombre_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ALUMNOS_NOMBRE_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
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
	
	function Tipo_Admin($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ALUMNOS_TIPO_ADMIN('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'alu_id_sv'=> $row[0],
                        'status_sinfo'=> $row[1],
                        'alu_pidm'=> $row[2],
                        'apellidos_alumno'=> $row[3],
                        'nombres_alumno'=> $row[4],
                        'email_alumno'=> $row[5],
                        'bloque'=> $row[6],
                        'nombre_grupo'=> $row[7],
                        'id_grupo'=> $row[8],
                        'id_tutor'=> $row[9],
                        'grupo_numerico'=> $row[10],
                        'id_tutor'=> $row[11]						
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Tipo_Tutor($id_usuario,$id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ALUMNOS_TIPO_TUTOR('$id_usuario','$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'alu_id_sv'=> $row[0],
                        'status_sinfo'=> $row[1],
                        'alu_pidm'=> $row[2],
                        'apellidos_alumno'=> $row[3],
                        'nombres_alumno'=> $row[4],
                        'email_alumno'=> $row[5],
                        'bloque'=> $row[6],
                        'nombre_grupo'=> $row[7],
                        'id_grupo'=> $row[8],
                        'id_tutor'=> $row[9],
                        'grupo_numerico'=> $row[10],
                        'id_tutor'=> $row[11]						
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Usuario_Actual($id_usuario){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ALUMNOS_USUARIO_ACTUAL('$id_usuario');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'firstname'=> $row[0],
                        'lastname'=> $row[1],
                        'pidm_banner'=> $row[2],
                        'id'=> $row[3]
                        				
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListarTutor':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''
			Listar_Tutores($id_curso_moodle);
        break;
		case 'NombreCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:'';
			Nombre_Curso($id_curso_moodle);
        break;
		case 'TipoAdmin':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:'';
			Tipo_Admin($id_curso_moodle);
		break;
		case '':
			$visiblex = (strlen($_POST['visiblex'])>0)?$_POST['visiblex']:'';
			$id_cursox = (strlen($_POST['id_cursox'])>0)?$_POST['id_cursox']:'';
            Tipo_Tutor($visiblex,$id_cursox);
		break;
		case 'UsuarioActual':
			$id_usuario = (strlen($_POST['id_usuario'])>0)?$_POST['id_usuario']:'';
            Usuario_Actual($id_usuario);
        break;
		
		
    }
?>	