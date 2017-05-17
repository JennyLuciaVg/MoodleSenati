<?php

include '../BD/conexion.php';

	function Lista_Foros_ID($ID_CURSO,$ID_USER,$ID_FORO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_FOROS_ID('$ID_CURSO','$ID_USER','$ID_FORO');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(				
                        'id_foro'=> $row[0],
                        'discuss'=> $row[1],
                        'userid'=> $row[3],
                        'post'=> $row[4],
                        'rating'=> $row[5],
                        'peso_recurso'=> $row[6]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Tarea_Offline($id_userx,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GET_EVALUA_TAREA_OFFLINE('$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
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
	
	function Get_Table1($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GET_TABLE1('$ID_CURSO');") or die("Query fail: " . mysqli_error());
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
	
	function GET_ALL_CABECERA($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GETALL_CABECERA('$ID_CURSO');") or die("Query fail: " . mysqli_error());
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
	
	function Listar_Grupo_Profesor($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GETBYID_GRUPO_PROFESOR('$ID_CURSO');") or die("Query fail: " . mysqli_error());
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
	
	function Get_Table2($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GETTABLE2('$ID_CURSO');") or die("Query fail: " . mysqli_error());
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
	
	function GET_BYID_CURSO($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GETBYID_CURSO('$ID_CURSO');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0],
                        'subsanacion'=> $row[1],
                        'presencial'=> $row[3],
                        'induccion'=> $row[4],
                        'id_publico'=> $row[5],
                        'id_tarea_induccion'=> $row[6]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Quiz($ID_USUARIO,$ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_QUIZ('$ID_USUARIO','$ID_CURSO');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'nota_grade'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Verificar_Grupo($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_VERIFICAR_CURSO_GRUPO('$ID_CURSO');") or die("Query fail: " . mysqli_error());
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
	
	function Verificar_Ponderacion($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_VERIFICAR_PONDERACION('$ID_CURSO');") or die("Query fail: " . mysqli_error());
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
        case 'ListaForosID':
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			$ID_USER = (strlen($_GET['ID_USER'])>0)?$_GET['ID_USER']:''; 
			$ID_FORO = (strlen($_GET['ID_FORO'])>0)?$_GET['ID_FORO']:''; 
			Lista_Foros_ID($ID_CURSO,$ID_USER,$ID_FORO);
        break;
		case 'TareaOffline':
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:''; 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Tarea_Offline($id_userx,$id_cursox);
        break;
		case 'GetTable1':
			 $ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			 Get_Table1($ID_CURSO),
        break;
		case 'GetCabecera': 
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			GET_ALL_CABECERA($ID_CURSO);
        break;
		case 'ListaGrupoProfesor': 
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			 Listar_Grupo_Profesor($ID_CURSO);
        break;
		case 'GetTable2': 
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			Get_Table2($ID_CURSO);
        break;
		case 'GetByIdCurso': 
			 $ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			 GET_BYID_CURSO($ID_CURSO);
        break;
		case 'ListaQuiz': 
			$ID_USUARIO = (strlen($_GET['ID_USUARIO'])>0)?$_GET['ID_USUARIO']:''; 
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			Lista_Quiz($ID_USUARIO,$ID_CURSO)
        break;
		case 'VerificaGrupo':
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			Verificar_Grupo($ID_CURSO)
		break;
    }
?>	