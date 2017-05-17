<?php

include '../BD/conexion.php';

	function Existe($id_curso_pres,$id_usuario){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_MATRICULA_PRESENCIALES_EXISTE('$id_curso_pres','$id_usuario');") or die("Query fail: " . mysqli_error());
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
	
	function Insertar_Estudiante($id_curso_pres,$id_usuario,$camp,$nrc,$periodo,$bloque){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_MATRICULA_PRESENCIALES_INSERT_ESTUDIANTE('$id_curso_pres','$id_usuario','$camp','$nrc','$periodo','$bloque');") or die("Query fail: " . mysqli_error());
	}
	
	function Listar_Curso_Periodo($periodo_seleccionado){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_MATRICULA_PRESENCIALES_LISTAR_CURSOS_PERIODO('$periodo_seleccionado');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_curso_pres'=> $row[0],
                        'fullname'=> $row[1],
                        'presencial_de'=> $row[2],
                        'camp_pres'=> $row[3],
                        'nombre_centro'=> $row[4],
                        'matriculas'=> $row[5]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Listar_Estudiante($id_curso_padre,$camp_importar){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_MATRICULA_PRESENCIALES_LISTAR_ESTUDIANTES('$id_curso_padre','$camp_importar');") or die("Query fail: " . mysqli_error());
		$data = [];	
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'userid'=> $row[0],
                        'camp'=> $row[1],
                        'nrc'=> $row[3],
                        'bloque'=> $row[4],
                     
					));
                }  
            }
            echo json_encode($data);
	}

	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'Existes':
			$id_curso_pres = (strlen($_GET['id_curso_pres'])>0)?$_GET['id_curso_pres']:''; 
			$id_usuario = (strlen($_GET['id_usuario'])>0)?$_GET['id_usuario']:''; 
			Existe($id_curso_pres,$id_usuario);
        break;
		case 'InsertEstudiante':
			$id_curso_pres = (strlen($_POST['id_curso_pres'])>0)?$_POST['id_curso_pres']:''; 
			$id_usuario = (strlen($_POST['id_usuario'])>0)?$_POST['id_usuario']:''; 
			$camp = (strlen($_POST['camp'])>0)?$_POST['camp']:''; 
			$nrc = (strlen($_POST['nrc'])>0)?$_POST['nrc']:''; 
			$periodo = (strlen($_POST['periodo'])>0)?$_POST['periodo']:''; 
			$bloque = (strlen($_POST['bloque'])>0)?$_POST['bloque']:''; 
			Insertar_Estudiante($id_curso_pres,$id_usuario,$camp,$nrc,$periodo,$bloque);
        break;
		case 'ListaCursoPeriodo':
			 $periodo_seleccionado = (strlen($_GET['periodo_seleccionado'])>0)?$_GET['periodo_seleccionado']:''; 
			Listar_Curso_Periodo($periodo_seleccionado);
        break;
		case 'ListaEstudiante': 
			$id_curso_padre = (strlen($_GET['id_curso_padre'])>0)?$_GET['id_curso_padre']:''; 
			$camp_importar = (strlen($_GET['camp_importar'])>0)?$_GET['camp_importar']:''; 
			Listar_Estudiante($id_curso_padre,$camp_importar);
        break;
		
		
		
    }
?>	