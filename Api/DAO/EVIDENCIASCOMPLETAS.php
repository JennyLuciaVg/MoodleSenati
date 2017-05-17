<?php

include '../BD/conexion.php';

	function Lista_Curso($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_LISTA_CURSO('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0], 
                        'subsanacion'=> $row[1], 
                        'presencial'=> $row[2],
                        'induccion'=> $row[3],
                        'id_publico'=> $row[4],
                        'id_tarea_induccion'=> $row[5]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Grupo_Estudiantes($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_LISTA_GRUPO_ESTUDIANTES('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(				
                        'userid'=> $row[0], 
                        'firstname'=> $row[1], 
                        'lastname'=> $row[2],
                        'camp'=> $row[3],
                        'nombre_centro'=> $row[4],
                        'bloque'=> $row[5],
                        'status_sinfo'=> $row[6],
                        'email'=> $row[7],
                        'pidm_banner'=> $row[8],
                        'grupo'=> $row[9]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Grupos($id_cursox,$proxe_id){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_LISTA_GRUPOS('$id_cursox','$proxe_id');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0], 
                        'name'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Quizz($id_userx,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_LISTA_QUIZZ('$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'nota_grade'=> $row[1], 
                        'nota_maxima'=> $row[2], 
                        'peso_recurso'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Tarea($id_userx,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_LISTA_TAREA('$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'Grade'=> $row[1], 
                        'nota_maxima'=> $row[2], 
                        'peso_recurso'=> $row[3],
                        'numfiles'=> $row[4],
                        'id_link'=> $row[5],
                        'assignmenttype'=> $row[6],
                        'timemodified'=> $row[7],
                        'timemarked'=> $row[8]
					));
                }  
            }
            echo json_encode($data);
	}

	function Lista_Foros($id_cursox,$id_userx,$id_foro){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_LISTAS_FOROS('$id_cursox','$id_userx','$id_foro');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_foro'=> $row[0],
                        'discuss'=> $row[1], 
                        'userid'=> $row[2], 
                        'post'=> $row[3],
                        'rating'=> $row[4],
                        'peso_recurso'=> $row[5]
					));
                }  
            }
            echo json_encode($data);
	}

	function Lista_Foros_Distinct($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_LISTAR_FOROS_DISTINCT('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'scale'=> $row[1], 
                        'name'=> $row[2], 
                        'peso_Recurso'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}

	function Performing_SQL($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_PERFORMING_SQL('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'assignmenttype'=> $row[1], 
                        'peso_recurso'=> $row[2], 
                        'name'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}

	function Performing_SQL_Distinct($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_PERFORMING_SQL_DISTINCT('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'peso_recurso'=> $row[1], 
                        'name'=> $row[2]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Total_Grupos($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_TOTAL_GRUPOS('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'userid'=> $row[0],
                        'firstname'=> $row[1], 
                        'lastname'=> $row[2],
                        'tot_grupos'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Verificar_Grupo($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_VERIFICAR_GRUPO('$id_cursox');") or die("Query fail: " . mysqli_error());
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
	
	function Verificar_Ponderacion($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EVIDENCIAS_COMPLETAS_CERIFICAR_PONDERACION('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'tiene_pond'=> $row[0]
					));
                }  
            }
            echo json_encode($data);
	}
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListaCurso':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Lista_Curso($id_cursox);
        break;
		case 'ListaGrupoE':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Lista_Grupo_Estudiantes($id_cursox);
        break;
		case 'ListaGrupos':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			$proxe_id = (strlen($_GET['proxe_id'])>0)?$_GET['proxe_id']:''; 
			Lista_Grupos($id_cursox,$proxe_id);
        break;
		case 'ListaQuizz':
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:''; 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Lista_Quizz($id_userx,$id_cursox);
        break;
		case 'ListaTarea':
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:''; 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Lista_Tarea($id_userx,$id_cursox);
        break;
		case 'ListaForos':
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:''; 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			$id_foro = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:''; 
			Lista_Foros($id_userx,$id_cursox,$id_foro);
        break;
		case 'ListaForoDistinct':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Lista_Foros_Distinct($id_cursox);
        break;
		case 'PerformingSql':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Performing_SQL($id_cursox);
        break;
		case 'PerformingSqlD':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Performing_SQL_Distinct($id_cursox);
        break;
		case 'TotalGrupo':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Total_Grupos($id_cursox);
        break;
		case 'VerificarGrupo':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Verificar_Grupo($id_cursox);
		break;
		case 'VerificarPonderacion':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Verificar_Ponderacion($id_cursox);
		break;
    }
?>	