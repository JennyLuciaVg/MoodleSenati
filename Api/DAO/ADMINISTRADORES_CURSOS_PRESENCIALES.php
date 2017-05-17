<?php

include '../BD/conexion.php';


	function Listar_Profesores(){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ADMIN_PRESENCIALES_LISTA_PROFESORES_CP();") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_user'=> $row[0],
                        'pidm_banner'=> $row[1],
                        'camp_user'=> $row[2],
                        'nombre_centro'=> $row[3],
                        'nombre_zonal'=> $row[4],
                        'firstname'=> $row[5],
                        'lastname'=> $row[6],
                        'email'=> $row[7]
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	function BUSCA_APELLIDO($lasts){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ADMIN_PRESENCIALES_BUSCA_APELLIDO('$lasts');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'pidm_banner'=> $row[1],
                        'firstname'=> $row[2],
                        'lastname'=> $row[3],
                        'campus'=> $row[4]
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	function BUSCA_PIDM($pidm){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ADMIN_PRESENCIALES_BUSCA_PIDM('$pidm');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'pidm_banner'=> $row[1],
                        'firstname'=> $row[2],
                        'lastname'=> $row[3],
                        'campus'=> $row[4]
						
					));
                }  
            }
            echo json_encode($data);
	}
	

	function Existe_Dupla($id_svx,$campx){ 
		echo ("entrando");              
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ADMIN_PRESENCIALES_EXISTE_DUPLA('$id_svx,$campx');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array('existe'=> $row[0]));
                }  
            }
            echo json_encode($data);
	}
	
	
	
	function GUARDAR($id_svx,$campx){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ADMIN_PRESENCIALES_GUARDAR('$id_svx','$campx');") or die("Query fail: " . mysqli_error());
	}
	
	function Listar_Centros(){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ADMIN_PRESENCIALES_LISTAR_CENTROS();") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_centro'=> $row[0],
                        'nombre_centro'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Listar_Cursos($camp_listar,$periodo_listar){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ADMIN_PRESENCIALES_LISTAR_CURSOS('$camp_listar','$periodo_listar');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'fullname'=> $row[1],
                        'visible'=> $row[2],
                        'existe'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Listar_Cursos_Modulos($id_curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ADMIN_PRESENCIALES_LISTAR_CURSOS_MODULOS('$id_curso');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_course_modules'=> $row[0],
                        'id_quiz'=> $row[1],
                        'nombre_quiz'=> $row[2],
                        'instance'=> $row[3],
                        'module_section'=> $row[4],
                        'module_visible'=> $row[5],
                        'seccion_visible'=> $row[6],
                        'password_quiz'=> $row[7],
                        'subnet'=> $row[8]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Actualizar_Presenciales($visiblex,$id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ADMIN_PRESENCIALES('$visiblex','$id_cursox');") or die("Query fail: " . mysqli_error());
	}
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListarCentros':
			Listar_Centros();
        break;
		case 'ListarCursos':
			$camp_listar = (strlen($_GET['camp_listar'])>0)?$_GET['camp_listar']:'';
			$periodo_listar = (strlen($_GET['periodo_listar'])>0)?$_GET['periodo_listar']:'';
			Listar_Cursos($camp_listar,$periodo_listar);
        break;
		case 'ListarCModulos':
			$id_curso = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:'';
			Listar_Cursos_Modulos($id_curso);
		break;
		case 'ActualizarCAdmin':
			$visiblex = (strlen($_POST['visiblex'])>0)?$_POST['visiblex']:'';
			$id_cursox = (strlen($_POST['id_cursox'])>0)?$_POST['id_cursox']:'';
            Actualizar_Presenciales($visiblex,$id_cursox);
        break;
		case 'ListaProfesores':
			Listar_Profesores();
		break;
		case 'BuscaApe':
			$lasts = (strlen($_GET['lasts'])>0)?$_GET['lasts']:'';
			BUSCA_APELLIDO($lasts);
		break;
		case 'BuscaPIDM':
			$pidm = (strlen($_GET['pidm'])>0)?$_GET['pidm']:'';
			BUSCA_PIDM($pidm);
		break;
		case 'ExisteDupla':
			$id_svx = (strlen($_GET['id_svx'])>0)?$_GET['id_svx']:'';
			$campx = (strlen($_GET['campx'])>0)?$_GET['campx']:'';
			Existe_Dupla($id_svx,$campx);
		break;
		case 'Guarda':
			$id_svx = (strlen($_GET['id_svx'])>0)?$_GET['id_svx']:'';
			$campx = (strlen($_GET['campx'])>0)?$_GET['campx']:'';
			GUARDAR($id_svx,$campx);
		break;
		
    }
?>	