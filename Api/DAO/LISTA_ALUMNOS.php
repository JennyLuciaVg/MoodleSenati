<?php

include '../BD/conexion.php';

	function Listado_Alumnos($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTADO_ALUMNOS('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(						
                        'userid'=> $row[0],
                        'firstname'=> $row[1],
                        'lastname'=> $row[2],
                        'nombre_centro'=> $row[3],
                        'bloque'=> $row[4],
                        'nrc'=> $row[5],
                        'email'=> $row[6],
                        'estado'=> $row[7],
                        'nota'=> $row[8],
                        'pidm_banner'=> $row[9],
                        'camp'=> $row[10],
                        'carr'=> $row[11],
                        'city'=> $row[12],
                        'semestre'=> $row[13],
                        'username'=> $row[14],
                        'accesos'=> $row[15],
                        'accesos'=> $row[16],
                        'nombre_grupo'=> $row[17],
                        'id_grupo'=> $row[18],
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Grupos($groupid){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTADO_ALUMNOS_LISTA_GRUPOS('$groupid');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'userid'=> $row[0],
                        'lastname'=> $row[1],
                        'firstname'=> $row[2]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Total_Grupos($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTADO_ALUMNOS_LISTA_TOTAL_GRUPOS('$id_cursox');") or die("Query fail: " . mysqli_error());
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
	
	function Lista_Tipo_Aprobados($id_cursox,$tipo){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTADO_ALUMNOS_LISTA_TIPO_APROBADOS('$id_cursox','$tipo');") or die("Query fail: " . mysqli_error());
		$data = [];	
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'userid'=> $row[0],
                        'firstname'=> $row[1],
                        'lastname'=> $row[2],
                        'email'=> $row[3],
                        'nombre_centro'=> $row[4],
                        'nota'=> $row[5],
                        'estado'=> $row[6],
                        'pidm_banner'=> $row[7],
                        'camp'=> $row[8],
                        'nrc'=> $row[9],
                        'bloque'=> $row[10],
                        'carr'=> $row[11],
                        'city'=> $row[12],
                        'semestre'=> $row[13],
                        'status_sinfo'=> $row[14],
                        'username'=> $row[15],
                        'accesos'=> $row[16],
                        'accesos'=> $row[17],
                        'nombre_grupo'=> $row[18],
                        'id_grupo'=> $row[19]
                     
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Alumnos_Periodo($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call  SP_LISTADO_ALUMNOS_PERIODO('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0],
                        'periodo'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Total_Alumnos($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTADO_ALUMNOS_TOTAL_ALUMNOS('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'groupid'=> $row[0],
                        'name'=> $row[1],
                        'alumnos'=> $row[2]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Actualizar_Notas($valor_nota,$valor_estado,$usuario_id,$valor_id_alu,$d_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTUALIZAR_NOTAS('$valor_nota','$valor_estado','$usuario_id','$valor_id_alu','$d_curso_moodle');") or die("Query fail: " . mysqli_error());
	}
	
	function Existe($id_curso_moodle,$id_userx){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_EXISTE('$id_curso_moodle','$id_userx');") or die("Query fail: " . mysqli_error());
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
	
	function Insertar_Notas($valor_id_alu,$id_curso_moodle,$valor_nota,$valor_estado,$usuario_id){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_INSERTAR_NOTAS('$valor_id_alu','$id_curso_moodle','$valor_nota','$valor_estado','$usuario_id');") or die("Query fail: " . mysqli_error());
		
	}
	
	function Listar_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTAR_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'startdate'=> $row[0],
                        'fullname'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Listar_Estudiantes($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTAR_ESTUDIANTES('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(						
                        'userid'=> $row[0],
                        'username'=> $row[1],
                        'firstname'=> $row[2],
                        'lastname'=> $row[3],
                        'email'=> $row[4],
                        'city'=> $row[5],
                        'nrc'=> $row[6],
                        'Nota'=> $row[7],
                        'Estado'=> $row[8],
                        'pidm_banner'=> $row[9]
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	function Actualizar_User($email_alux,$city_alux,$id_alux){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTUALIZAR_USER('$email_alux','$city_alux','$id_alux');") or die("Query fail: " . mysqli_error());
	}
	
	function Actualizar_City($email_alux,$city_alux,$pidm_banner){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTUALIZAR_CITY('$email_alux','$city_alux','$pidm_banner');") or die("Query fail: " . mysqli_error());
	}
	
	function Nombre_Curso($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_COURSE('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0],
                        'periodo'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	
	function Listar_Estudiante($id_cursox){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTAR_ESTUDIANTES('$id_cursox');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(						
                        'userid'=> $row[0],
                        'firstname'=> $row[1],
                        'lastname'=> $row[2],
                        'email'=> $row[3],
                        'pidm_banner'=> $row[4],
                        'username'=> $row[5],
                        'city'=> $row[6],
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListaAlumn':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Listado_Alumnos($id_cursox);
        break;
		case 'ListaGrupos':
			$groupid = (strlen($_GET['groupid'])>0)?$_GET['groupid']:''; 
			Lista_Grupos($groupid);
        break;
		case 'ListaTotalGrupos':
			 $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Lista_Total_Grupos($id_cursox);
        break;
		case 'TipoAprobados': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			$tipo = (strlen($_GET['tipo'])>0)?$_GET['tipo']:''; 
			Lista_Tipo_Aprobados($id_cursox,$tipo);
        break;
		case 'AlumnosPeriodo': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Alumnos_Periodo($id_cursox);
        break;
		case 'TotalAlumnos': 
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Total_Alumnos($id_cursox);
        break;
		case 'ActualizarNota': 
			 $valor_nota = (strlen($_POST['valor_nota'])>0)?$_POST['valor_nota']:''; 
			 $valor_estado = (strlen($_POST['valor_estado'])>0)?$_POST['valor_estado']:''; 
			 $usuario_id = (strlen($_POST['usuario_id'])>0)?$_POST['usuario_id']:''; 
			 $valor_id_alu = (strlen($_POST['valor_id_alu'])>0)?$_POST['valor_id_alu']:''; 
			 $d_curso_moodle = (strlen($_POST['d_curso_moodle'])>0)?$_POST['d_curso_moodle']:''; 
			 Actualizar_Notas($valor_nota,$valor_estado,$usuario_id,$valor_id_alu,$d_curso_moodle);
        break;
		case 'Existes': 
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			$id_userx = (strlen($_GET['id_userx'])>0)?$_GET['id_userx']:''; 
			Existe($id_curso_moodle,$id_userx);
        break;
		case 'InsertNotas':
			$valor_id_alu = (strlen($_POST['valor_id_alu'])>0)?$_POST['valor_id_alu']:''; 
			$id_curso_moodle = (strlen($_POST['id_curso_moodle'])>0)?$_POST['id_curso_moodle']:''; 
			$valor_nota = (strlen($_POST['valor_nota'])>0)?$_POST['valor_nota']:''; 
			$valor_estado = (strlen($_POST['valor_estado'])>0)?$_POST['valor_estado']:''; 
			$usuario_id = (strlen($_POST['usuario_id'])>0)?$_POST['usuario_id']:''; 
			Insertar_Notas($valor_id_alu,$id_curso_moodle,$valor_nota,$valor_estado,$usuario_id);
		break;
		case 'ListaCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Listar_Curso($id_curso_moodle);
		break;
		case 'ListaEstudiante':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Listar_Estudiantes($id_curso_moodle);
		break;
		case 'ActualizarUser':
			$email_alux = (strlen($_POST['email_alux'])>0)?$_POST['email_alux']:''; 
			$city_alux = (strlen($_POST['city_alux'])>0)?$_POST['city_alux']:''; 
			$id_alux = (strlen($_POST['id_alux'])>0)?$_POST['id_alux']:''; 
			Actualizar_User($email_alux,$city_alux,$id_alux);
		break;
		case 'ActualizarCity':
			$email_alux = (strlen($_POST['email_alux'])>0)?$_POST['email_alux']:''; 
			$city_alux = (strlen($_POST['city_alux'])>0)?$_POST['city_alux']:''; 
			$pidm_banner = (strlen($_POST['pidm_banner'])>0)?$_POST['pidm_banner']:''; 
			Actualizar_City($email_alux,$city_alux,$pidm_banner);
		break;
		case 'NombreCurso':
			$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
			Nombre_Curso($id_cursox);
		break;
		case 'P':
		$id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:''; 
		Listar_Estudiante($id_cursox);
		break;
    }
?>	