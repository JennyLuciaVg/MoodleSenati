<?php

include '../BD/conexion.php';

	function Verifica_Matriculado($id_curso_moodle,$id_usuario){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_IMPORTAR_MATRICULAS_ALUMNO_NO_MATRICULADO('$id_curso_moodle','$id_usuario');") or die("Query fail: " . mysqli_error());
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
	
	function Insertar_Estudiantes($id_curso_moodle,$id_usuario,$nrc,$periodico,$bloque,$camp){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_IMPORTAR_MATRICULAS_INSERTAR_ESTUDIANTES('$id_curso_moodle','$id_usuario','$nrc','$periodico','$bloque,$camp');") or die("Query fail: " . mysqli_error());
	}
	
	function Lista_Campus_Distinto($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_IMPORTAR_MATRICULAS_LISTA_CAMPUS_DISTINTO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'camp'=> $row[0],
                        'nombre_centro'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Curso_Presencial($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_IMPORTAR_MATRICULAS_LISTA_CURSO_PRESENCIAL('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'presencial_de'=> $row[0]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Obtiene_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_IMPORTAR_MATRICULAS_OBTIENE_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0],
                        'periodo'=> $row[1],
                        'camp_pres'=> $row[2],
                        'matriculas'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Listar_IDCurso($id_curso_fuente){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_IMPORTAR_MATRICULAS_IDCURSO('$id_curso_fuente');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'userid'=> $row[0],
                        'nrc'=> $row[1],
                        'bloque'=> $row[2],
                        'camp'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Listar_Enrol($id_campus,$id_curso_fuente){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_IMPORTAR_MATRICULAS_LISTAR_ENROL('($id_campus','$id_curso_fuente');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'userid'=> $row[0],
                        'nrc'=> $row[1],
                        'bloque'=> $row[2],
                        'camp'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'VerificaMatricula':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			$id_usuario = (strlen($_GET['id_usuario'])>0)?$_GET['id_usuario']:''; 
			Verifica_Matriculado($id_curso_moodle,$id_usuario);
        break;
		case 'InsertEstudiante':
			 $id_curso_moodle = (strlen($_POST['id_curso_moodle'])>0)?$_POST['id_curso_moodle']:''; 
			 $id_usuario = (strlen($_POST['id_usuario'])>0)?$_POST['id_usuario']:''; 
			 $nrc = (strlen($_POST['nrc'])>0)?$_POST['nrc']:''; 
			 $periodico = (strlen($_POST['periodico'])>0)?$_POST['periodico']:''; 
			 $bloque = (strlen($_POST['bloque'])>0)?$_POST['bloque']:''; 
			 $camp = (strlen($_POST['camp'])>0)?$_POST['camp']:''; 
			 Insertar_Estudiantes($id_curso_moodle,$id_usuario,$nrc,$periodico,$bloque,$camp);
        break;
		case 'ListaCampusDistinto': 
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Campus_Distinto($id_curso_moodle);
        break;
		case 'ListaCPresencial': 
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Curso_Presencial($id_curso_moodle);
        break;
		case 'ObtieneCurso': 
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Obtiene_Curso($id_curso_moodle);
        break;
		case 'ListarIDC': 
			$id_curso_fuente = (strlen($_GET['id_curso_fuente'])>0)?$_GET['id_curso_fuente']:''; 
			Listar_IDCurso($id_curso_fuente);
        break;
		case 'ListaEnrol': 
			$id_campus = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			$id_curso_fuente = (strlen($_GET['id_curso_fuente'])>0)?$_GET['id_curso_fuente']:''; 
			Listar_Enrol($id_campus,$id_curso_fuente);
        break;
    }
?>	