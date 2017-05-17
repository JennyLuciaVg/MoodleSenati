<?php

include '../BD/conexion.php';

	function SI_ES_TUTOR($grupitos){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_SI_ES_TUTOR('$grupitos');") or die("Query fail: " . mysqli_error());
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
                        'grupo'=> $row[9],
                        'id_grupo'=> $row[10]
                }  
            }
            echo json_encode($data);
	
	}
	
	function Curso_Tiene_Grupo($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_CURSO_TIENE_GRUPO('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(		
                        'existe'=> $row[0]
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Foro($id_cursox,$id_userx,$id_foro){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_FOROS('$id_cursox','$id_userx','$id_foro');") or die("Query fail: " . mysqli_error());
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
                }  
            }
            echo json_encode($data);
	
	}
	
	function Foros_Distinct($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_FOROS_DISTINCT('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];

			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(		
                        'id'=> $row[0],
                        'peso_recurso'=> $row[1],
                        'name'=> $row[2]
                }  
            }
            echo json_encode($data);
	
	}
	
	function Tutor_Grupo($id_cursox,$proxe_id){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_GRUPO('$id_cursox','$proxe_id');") or die("Query fail: " . mysqli_error());
		$data = [];

			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(		
                        'id'=> $row[0],
                        'name'=> $row[1]
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Grupo_Tutor($id_cursox,$id_usuario){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_LISTA_GRUPOS_TUTOR('$id_cursox','$id_usuario');") or die("Query fail: " . mysqli_error());
		$data = [];

			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(		
                        'id'=> $row[0]
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Tutor($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call  SP_NOTAS_TUTOR_LISTAR('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];

			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(		
                        'fullname'=> $row[0],
                        'subsanacion'=> $row[1],
                        'presencial'=> $row[2],
                        'induccion'=> $row[3],
                        'id_publico'=> $row[4]
                }  
            }
            echo json_encode($data);
	
	}

	function Tutor_Offline($id_userx,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_OFFLINE('$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
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
	
	function Lista_Tutor_Quiz($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_QUIZ('$id_cursox');") or die("Query fail: " . mysqli_error());
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
	
	function Quiz_Performing($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_QUIZ_PERFORMING('$id_cursox');") or die("Query fail: " . mysqli_error());
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

	function Quiz_Performing1($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_QUIZ_PERFORMING1('$id_cursox');") or die("Query fail: " . mysqli_error());
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
	
	function Tiene_Ponderaciones($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_TUTOR_TIENE_PONDERACIONES('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];	
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=tiene_pondrow[0]
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'SIESTUTOR':
			$grupitos = (strlen($_GET['grupitos'])>0)?$_GET['grupitos']:''; 
			SI_ES_TUTOR($grupitos);
        break;
		case 'CursoTieneGrupo':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Curso_Tiene_Grupo($id_cursox);
        break;
		case 'ListaForo':
			 $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			 $id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:''; 
			 $id_foro = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:''; 
			Lista_Foro($id_cursox,$id_userx,$id_foro);
        break;
		case 'ForoDistinct': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Foros_Distinct($id_cursox);
        break;
		case 'TutorGrupo': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			$proxe_id = (strlen($_GET['proxe_id'])>0)?$_GET['proxe_id']:''; 
			Tutor_Grupo($id_cursox,$proxe_id);
        break;
		case 'ListaGrupTutor': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			$id_usuario = (strlen($_GET['id_usuario'])>0)?$_GET['id_usuario']:''; 
			Lista_Grupo_Tutor($id_cursox,$id_usuario);
        break;
		case 'ListaTutor': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Lista_Tutor($id_cursox);
        break;
		case 'TutorOffline': 
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:''; 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Tutor_Offline($id_userx,$id_cursox);
        break;
		case 'ListaTutorQuiz': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Lista_Tutor_Quiz($id_cursox);
        break;
		case 'QuizP': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Quiz_Performing($id_cursox);
        break;
		case 'QuizP1': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Quiz_Performing1($id_cursox);
        break;
		case 'TienePondera': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Tiene_Ponderaciones($id_cursox);
        break;
    }
?>	