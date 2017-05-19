<?php

include '../BD/conexion.php';

	function Ponderacion_Patron_Semilla($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PONDERACIONES_PATRON_SEMILLA('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_patron_semilla'=> $row[0]            
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Ponderacion_Performing_Forum(id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PONDERACIONES_PERFORMING_FORUM('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],            
                        'name'=> $row[1],            
                        'peso_recurso'=> $row[2],   					
                        'section'=> $row[3]      
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Ponderacion_Performing_Quiz($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PONDERACIONES_PERFORMING_QUIZ('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],            
                        'name'=> $row[1],            
                        'peso_recurso'=> $row[2],            
                        'section'=> $row[3]     
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Ponderacion_Performing_Tarea($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PONDERACIONES_PERFORMING_TAREA('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],            
                        'name'=> $row[1],            
                        'peso_recurso'=> $row[2],            
                        'section'=> $row[3]     
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	function Ponderacion_Total_ID_Foro($id_cursox,$valor_id_foro){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PONDERACIONES_TOTAL_ID_FORO('$id_cursox','$valor_id_foro');") or die("Query fail: " . mysqli_error());
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
	
	function Ponderacion_Total_ID_Tarea($id_cursox,$valor_id_assign){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PONDERACIONES_TOTAL_ID_TAREA('$id_cursox','$valor_id_assign');") or die("Query fail: " . mysqli_error());
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
	
	function TOTAL_INSERTAR_PESOS_RECURSOS($valor_id_assign,$valor_peso_assign,$id_cursox,$id_usuario){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PONDERACIONES_TOTAL_INSERTAR_PESOS_RECURSOS('$valor_id_assign','$valor_peso_assign','$id_cursox,$id_usuario');") or die("Query fail: " . mysqli_error());
	}
	
	function Total_Pesos_Recursos($id_cursox,$valor_id_quiz){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PONDERACIONES_TOTAL_PESOS_RECURSOS('$id_cursox','$valor_id_quiz');") or die("Query fail: " . mysqli_error());
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
	

	function Total_Pesos_Quiz($valor_peso,$id_usuario,$id_cursox,$tiporecurso,$valor_id_quiz){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PONDERACIONES_TOTAL_UPDATE_TAREA_PESO_QUIZ('$id_cursox','$valor_id_quiz');") or die("Query fail: " . mysqli_error());
	}
	
	

	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'PatronSemilla':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Ponderacion_Patron_Semilla($id_cursox);
        break;
		case 'PerformingForum':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Ponderacion_Performing_Forum(id_cursox);
        break;
		case 'PerformingQuiz':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Ponderacion_Performing_Quiz($id_cursox);
        break;
		case 'PerformingTarea':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Ponderacion_Performing_Tarea($id_cursox);
        break;
		case 'TotalForo':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			$valor_id_foro = (strlen($_GET['valor_id_foro'])>0)?$_GET['valor_id_foro']:''; 
			Ponderacion_Total_ID_Foro($id_cursox,$valor_id_foro);
        break;
		case 'TotalTarea':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			$valor_id_assign = (strlen($_GET['valor_id_assign'])>0)?$_GET['valor_id_assign']:''; 
			Ponderacion_Total_ID_Tarea($id_cursox,$valor_id_assign);
        break;
		case 'InsertarPesosRecursos':
			$valor_id_assign = (strlen($_POST['valor_id_assign'])>0)?$_POST['valor_id_assign']:''; 
			$valor_peso_assign = (strlen($_POST['valor_peso_assign'])>0)?$_POST['valor_peso_assign']:'';
			$id_cursox = (strlen($_POST['id_cursox'])>0)?$_POST['id_cursox']:'';
			$id_usuario = (strlen($_POST['id_usuario'])>0)?$_POST['id_usuario']:'';
			TOTAL_INSERTAR_PESOS_RECURSOS($valor_id_assign,$valor_peso_assign,$id_cursox,$id_usuario);
        break;
		case 'TotalRecursos':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			$valor_id_quiz = (strlen($_GET['valor_id_quiz'])>0)?$_GET['valor_id_quiz']:'';
			Total_Pesos_Recursos($id_cursox,$valor_id_quiz)
        break;
		case 'UpdatePesosRecursos':
			$valor_peso = (strlen($_GET['valor_peso'])>0)?$_GET['valor_peso']:'';
			$id_usuario = (strlen($_GET['id_usuario'])>0)?$_GET['id_usuario']:'';
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			$tiporecurso = (strlen($_GET['tiporecurso'])>0)?$_GET['tiporecurso']:'';
			$valor_id_quiz = (strlen($_GET['valor_id_quiz'])>0)?$_GET['valor_id_quiz']:'';
			Total_Pesos_Quiz($valor_peso,$id_usuario,$id_cursox,$tiporecurso,$valor_id_quiz)
		break;
    }
?>
