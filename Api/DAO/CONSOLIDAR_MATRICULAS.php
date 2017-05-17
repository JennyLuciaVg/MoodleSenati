<?php

include '../BD/conexion.php';

	function Buscar_Alumno($pidm_sinfo,$camp,$username){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_BUSCAR_ALUMNO('$pidm_sinfo','$camp','$username');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0]                 
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Insertar_Estudiantes($id_curso_moodle,$id_user_sv,$camp,$nrc,$periodo,$bloque){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_INSERTAR_ESTUDIANTES('$id_curso_moodle','$id_user_sv','$camp','$nrc','$periodo','$bloque');") or die("Query fail: " . mysqli_error());
	}
	
	function Insertar_Estudiantes_Automatico($pidm_sinfo,$apes,$nombres,$pidm_sinfo,$camp,$ciudad,$email){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_INSERTAR_ESTUDIANTES_AUTOMATICAMENTE('$pidm_sinfo','$apes','$nombres','$pidm_sinfo','$camp','$ciudad','$email');") or die("Query fail: " . mysqli_error());
	}
	
	function Lista_Campus($camp){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_LISTAR_CAMPUS('$camp');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'nombre_centro'=> $row[0]                 
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Datos_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_LISTAR_DATOS_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0],                    
                        'startdate'=> $row[1],                    
                        'periodo'=> $row[2],                    
                        'banner_subj_code'=> $row[3],                    
                        'banner_crse_numb'=> $row[4],                    
                        'materia_sinfo'=> $row[5],                    
                        'curso_sinfo'=> $row[6]                   
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Distintos_Bloque($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_LISTAR_DISTINTOS_BLOQUE('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'bloque'=> $row[0]                                 
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Distintos_NRC($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_LISTAR_DISTINTOS_NRC('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'nrc'=> $row[0]                                 
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Distintos_Pdim_Banner($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_LISTAR_DISTINTOS_PDIM_BANNER('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'pidm_banner'=> $row[0],                                 
                        'status_sinfo'=> $row[1]                                 
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Listar_Existe($id_curso_moodle,$id_user_sv){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_LISTAR_EXISTE('$id_curso_moodle','$id_user_sv');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'existe'=> $row[0]                                 
					));
                }  
            }
            echo json_encode($data);
	}

	function Nombre_Centro($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_LISTAR_NOMBRE_CENTRO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'camp'=> $row[0],                                 
                        'nombre_centro'=> $row[1],                                 
                        'alumnos'=> $row[2]                               
					));
                }  
            }
            echo json_encode($data);
	}
	
	function ListaPIDM($pidm_sinfo,$username){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_C_M_LISTAR_PIDM('$id_curso_moodle','$username');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0]                              
					));
                }  
            }
            echo json_encode($data);
	}
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'BuscarAlumno':
			$pidm_sinfo = (strlen($_GET['pidm_sinfo'])>0)?$_GET['pidm_sinfo']:''; 
			$camp = (strlen($_GET['camp'])>0)?$_GET['camp']:''; 
			$username = (strlen($_GET['username'])>0)?$_GET['username']:''; 
			Buscar_Alumno($pidm_sinfo,$camp,$username);
        break;
		case 'InsertarEstudiante':
			$id_curso_moodle = (strlen($_POST['id_curso_moodle'])>0)?$_POST['id_curso_moodle']:''; 
			$id_user_sv = (strlen($_POST['id_user_sv'])>0)?$_POST['id_user_sv']:''; 
			$camp = (strlen($_POST['camp'])>0)?$_POST['camp']:''; 
			$nrc = (strlen($_POST['nrc'])>0)?$_POST['nrc']:''; 
			$periodo = (strlen($_POST['periodo'])>0)?$_POST['periodo']:''; 
			$bloque = (strlen($_POST['bloque'])>0)?$_POST['bloque']:''; 
			Insertar_Estudiantes($id_curso_moodle,$id_user_sv,$camp,$nrc,$periodo,$bloque);
        break;
		case 'InsertarEAutomatico':
			$pidm_sinfo = (strlen($_POST['pidm_sinfo'])>0)?$_POST['pidm_sinfo']:'';
			$apes = (strlen($_POST['apes'])>0)?$_POST['apes']:'';
			$nombres = (strlen($_POST['nombres'])>0)?$_POST['nombres']:'';
			$pidm_sinfo = (strlen($_POST['pidm_sinfo'])>0)?$_POST['pidm_sinfo']:'';
			$camp = (strlen($_POST['camp'])>0)?$_POST['camp']:'';
			$ciudad = (strlen($_POST['ciudad'])>0)?$_POST['ciudad']:'';
			$email = (strlen($_POST['email'])>0)?$_POST['email']:'';
			Insertar_Estudiantes_Automatico($pidm_sinfo,$apes,$nombres,$pidm_sinfo,$camp,$ciudad,$email);
		break;
		 case 'ListaCampus':
			$camp = (strlen($_GET['camp'])>0)?$_GET['camp']:''; 
			Lista_Campus($camp);
        break;
		case 'ListaDatosCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Datos_Curso($id_curso_moodle);
        break;
		case 'ListaBloque':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Distintos_Bloque($id_curso_moodle);
        break;
		case 'ListaNrc':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Distintos_NRC($id_curso_moodle);
        break;
		case 'ListaDatosCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Distintos_Pdim_Banner($id_curso_moodle);
        break;
		case 'ListaExiste':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			$id_user_sv = (strlen($_GET['id_user_sv'])>0)?$_GET['id_user_sv']:''; 
			Listar_Existe($id_curso_moodle,$id_user_sv);
        break;
		case 'NombreCentro':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Nombre_Centro($id_curso_moodle);
        break;
		case 'NombreCentro':
			$pidm_sinfo = (strlen($_GET['pidm_sinfo'])>0)?$_GET['pidm_sinfo']:''; 
			$username = (strlen($_GET['username'])>0)?$_GET['username']:''; 
			ListaPIDM($pidm_sinfo,$username);
        break;
    }
?>	