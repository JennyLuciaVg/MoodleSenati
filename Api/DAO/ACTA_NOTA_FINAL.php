<?php

include '../BD/conexion.php';

 	function GetData($ids){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_Prueba('$ids');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'auth'=> $row[0],                                 
							   'username'=>$row[1],
							   'firstname'=>$row[2],
							   'confirmed'=>$row[3],
							   'lastname'=>$row[4]
							   ));
                  }
                 
            }
               echo json_encode($data);
	}

	function Actualizar($nrcx,$bloquex,$camp,$valor_nota,$valor_estado,$pondera_a_usar,$id_usuario,$valor_id_alu,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTAS_FINAL_ACTUALIZAR('$nrcx','$bloquex','$camp','$valor_nota','$valor_estado','$pondera_a_usar','$id_usuario','$valor_id_alu,$id_cursox');") or die("Query fail: " . mysqli_error());    
	}
               
    function Buscador($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_BUSCA_SUBSA('$id_cursox');") or die("Query fail: " . mysqli_error());
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
  
	function Existe($id_cursox,$id_userx ){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_BUSCA_SUBSA('$id_cursox','$id_userx');") or die("Query fail: " . mysqli_error());
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

	function Final_Inicio_Curso($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_INICIO_CURSO('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'startdate'=> $row[0]
							   ));
                  }    
            }
            echo json_encode($data);
	}   
	
	function Foros($idcursox,$id_userx,$id_foro){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_FOROS('$id_cursox','$id_userx','$_id_foro');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'id_foro'=> $row[0],
								'userid'=> $row[0],
								'post'=> $row[0],
								'rating'=> $row[0]
							   ));
                  }    
            }
            echo json_encode($data);
	}   
	
	
	function Foros_Distinct($idcursox){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_FOROS_DISTINCT('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'id'=> $row[0],
								'scale, '=> $row[1],
								'peso_recurso'=> $row[2]
							   ));
                  }    
            }
            echo json_encode($data);
	}   
	
	function Insertar($valor_id_alu,$id_cursox,$valor_nota,$valor_estado,$pondera_a_usar,$id_usuario,$nrcx,$bloquex,$campx,$periodox){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_INSERTAR('$valor_id_alu','$id_cursox','$valor_nota','$valor_estado','$pondera_a_usar','$id_usuario','$nrcx','$bloquex','$campx,$periodox);") or die("Query fail: " . mysqli_error());	
	}   
	
	function ListaE($idcursox,$valor_id_alu){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_LISTA_ESTUDIANTES('$id_cursox','$valor_id_alu');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'nrc'=> $row[0],
								'bloque'=> $row[1],
								'periodo'=> $row[2],
								'camp'=> $row[3]
							   ));
                  }    
            }
            echo json_encode($data);
	}   
	
	function ListaN($idcursox){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_LISTA_NOTAS('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'userid'=> $row[0],
								'firstname'=> $row[1],
								'lastname'=> $row[2],
								'nota'=> $row[3],
								'estado'=> $row[4],
								'fecha_entrega'=> $row[5],
								'nota_final'=> $row[6],
								'ponderacion'=> $row[7]
							   ));
                  }    
            }
            echo json_encode($data);
	} 
	function ListaNo($idcursox){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_LISTA100_NOTA('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'userid'=> $row[0],
								'firstname'=> $row[1],
								'lastname'=> $row[2],
								'nota'=> $row[3],
								'estado'=> $row[4],
								'fecha_entrega'=> $row[5],
								'nota_final'=> $row[6],
								'ponderacion'=> $row[7]
							   ));
                  }    
            }
            echo json_encode($data);
	} 
	
	
	function Quiz($id_userx,$id_cursox){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_QUIZ('$id_cursox','$id_userx');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'Grade'=> $row[0],
								'nota_maxima'=> $row[1]
							   ));
                  }    
            }
            echo json_encode($data);
		
	}
	
	function Quiz_Distinct($id_cursox){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_QUIZ_DISTINCT('$id_cursox');") or die("Query fail: " . mysqli_error());
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
	
	function Tareas($id_userx,$id_cursox){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_TAREAS('$id_userx','$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'id'=> $row[0],
								'Grade'=> $row[1],
								'nota_maxima'=> $row[2],
								'peso_recurso'=> $row[3]
							   ));
                  }    
            }
            echo json_encode($data);
		
	}
	
	function Pesos_Recursos($id_cursox){
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_FINAL_TOTAL_PESOS_RECURSOS('$id_cursox');") or die("Query fail: " . mysqli_error());
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
        case 'listar':
			$ids = (strlen($_GET['ids'])>0)?$_GET['ids']:'';
            GetData($ids);
        break;
        case 'Update':
			 $nrcx = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			 $bloquex = (strlen($_POST['bloquex'])>0)?$_POST['bloquex']:'';
			 $camp = (strlen($_POST['camp'])>0)?$_POST['camp']:'';
			 $valor_nota = (strlen($_POST['valor_nota'])>0)?$_POST['valor_nota']:'';
			 $valor_estado = (strlen($_POST['valor_estado'])>0)?$_POST['valor_estado']:'';
			 $pondera_a_usar = (strlen($_POST['pondera_a_usar'])>0)?$_POST['pondera_a_usar']:'';
			 $id_usuario = (strlen($_POST['id_usuario'])>0)?$_POST['id_usuario']:'';
			 $valor_id_alu = (strlen($_POST['id_usuario'])>0)?$_POST['id_usuario']:'';
			 $id_cursox = (strlen($_POST['id_usuario'])>0)?$_POST['id_usuario']:'';
			 Actualizar($nrcx,$bloquex,$camp,$valor_nota,$valor_estado,$pondera_a_usar,$id_usuario,$valor_id_alu,$id_cursox);
            break;
        case 'Buscar':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$GET['id_cursox']:'';
			Buscador($id_cursox);
			 break;
		case 'Existes':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
			Existe($id_cursox,$id_userx);
			 break;
		case 'Inicio':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			Final_Inicio_Curso($id_cursox);
			 break;
		case 'Foro':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
			$id_foro = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:'';
			Foros($id_cursox,$id_userx,$id_foro);
		case 'Foro_Distinct':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			Foros_Distinct($id_cursox);	
			break;
		case 'Insert':
			$valor_id_alu = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			$id_cursox = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			$valor_nota = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			$valor_estado = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			$pondera_a_usar = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:''; 
			$id_usuario = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			$nrcx = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			$bloquex = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			$campx = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			$periodox = (strlen($_POST['nrcx'])>0)?$_POST['nrcx']:'';
			Insertar($valor_id_alu,$id_cursox,$valor_nota,$valor_estado,$pondera_a_usar,$id_usuario,$nrcx,$bloquex,$camp,$periodox);
			break;
		case 'ListaEstudiante':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			$valor_id_alu = (strlen($_GET['valor_id_alu'])>0)?$_GET['valor_id_alu']:'';
			ListaE($id_cursox,$valor_id_alu);
			break;
		case 'ListaNotas':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			ListaN($id_cursox);
			break;
		case 'ListaNo':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			ListaNo($id_cursox);
			break;
		case 'Quiz':
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			Quiz($id_userx,$id_cursox);
			break;
		case 'QuizD':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			Quiz_Distinct($id_cursox);
			break;
		case 'Tarea':
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:'';
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			Tareas($id_userx,$id_cursox);
			break;
		case 'Pesos':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
			Pesos_Recursos($id_cursox);
			break;
			
    }
                           
		
?>	