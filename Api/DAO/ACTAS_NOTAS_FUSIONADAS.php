<?php

include '../BD/conexion.php';

	function Fusionadas($id_alu_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS('$id_alu_moodle ');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'tutor'=> $row[0],                                 
							   'pidm_banner'=>$row[1]
							   ));
                  }
                 
            }
               echo json_encode($data);
	}
	
	function Buscar_Padre($id_curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_BUSCAR_PADRE('$id_curso');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'subsanacion_de'=> $row[0]
							   ));
                  }
                 
            }
               echo json_encode($data);
	}
	
	function Campus_Distinto($lista_cursix){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_CAMPUS_DISTINTO('$lista_cursix');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'nrc'=> $row[0],
								'camp'=> $row[1],
								'campus'=> $row[2]
							   ));
                  }
                 
            }
               echo json_encode($data);
	}
	
	function Curso_Obtuvo_Nota($lista_cursix){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_ID_CURSO_OBTUVO_NOTA('$lista_cursix');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'firstname'=> $row[0],
								'lastname'=> $row[1],
								'email'=> $row[2],
								'Notax'=> $row[3],
								'pidm_banner'=> $row[4],
								'nrc'=> $row[5],
								'bloque'=> $row[6],
								'periodo'=> $row[7],
								'camp'=> $row[8],
								'userid'=> $row[9],
								'status_sinfo'=> $row[10],
								'nombre_centro'=> $row[11],
								'id_cursox'=> $row[12]
							   ));
                  }
                 
            }
               echo json_encode($data);
	}
	
	function Lista_Curso($lista_cursix){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_LISTA_CURSO('$lista_cursix');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'fullname'=> $row[0],
								'id'=> $row[1]
							   ));
                  }
                 
            }
               echo json_encode($data);
	}
	
	function Lista_Curso_Relacionados($id_padre){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_LISTA_CURSOS_RELACIONADOS('$id_padre');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'id'=> $row[0],
								'fullname'=> $row[1],
								'periodo'=> $row[2]
							   ));
                  }
                 
            }
            echo json_encode($data);
	}
	
	function Nombre_Completo_Curso($id_curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_NOMBRE_COMPLETO_CURSO('$id_curso');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'fullname'=> $row[0]
							   ));
                  }
                 
            }
            echo json_encode($data);
	}
	
	function Nombre_Curso($lista_cursix){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_NOMBRE_CURSO('$lista_cursix');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'banner_subj_code'=> $row[0],
                               	'banner_crse_numb'=> $row[1],
                               	'nombre_curso'=> $row[2],
							   ));
                  }
                 
            }
            echo json_encode($data);
	}
	
	
	function Nombre_Tutor($id_curso_rex){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_NOMBRE_TUTOR('$id_curso_rex');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'tutor'=> $row[0],
                               	'pidm_banner'=> $row[1]
							   ));
                  }
                 
            }
            echo json_encode($data);
	}
	
	function Nrc_Distinto($lista_cursix){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_NRC_DISTINTO('$lista_cursix');") or die("Query fail: " . mysqli_error());
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
	
	function Si_Hijo($lista_cursix){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_SI_HIJO('$lista_cursix');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'es_hijo'=> $row[0]
							   ));
                  }
                 
            }
            echo json_encode($data);
	}
	
	function Si_Padre($id_curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NOTAS_FUSIONADAS_SI_PADRE('$id_curso');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'es_padre'=> $row[0]
							   ));
                  }
                 
            }
            echo json_encode($data);
	}
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'Fusionada':
			$id_alu_moodle = (strlen($_GET['id_alu_moodle'])>0)?$_GET['id_alu_moodle']:'';
            Fusionadas($id_alu_moodle);
        break;
		case 'BuscarPadre':
			$id_curso  = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:'';
            Buscar_Padre($ids);
        break;
		case 'CampusDistinto':
			$lista_cursix  = (strlen($_GET['lista_cursix'])>0)?$_GET['lista_cursix']:'';
            Campus_Distinto($lista_cursix );
        break;
		case 'CursoNota':
			$lista_cursix  = (strlen($_GET['lista_cursix'])>0)?$_GET['lista_cursix']:'';
            Curso_Obtuvo_Nota($lista_cursix );
        break;
		case 'ListaCurso':
			$lista_cursix = (strlen($_GET['lista_cursix'])>0)?$_GET['lista_cursix']:'';
            Lista_Curso($lista_cursix);
        break;
		case 'Curso_Relacionados':
			$id_padre = (strlen($_GET['id_padre'])>0)?$_GET['id_padre']:'';
            Lista_Curso_Relacionados($id_padre);
        break;
		case 'NombreCompleto':
			$id_curso = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:'';
            Nombre_Completo_Curso($id_curso);
        break;
		case 'NombreCurso':
			$lista_cursix = (strlen($_GET['lista_cursix'])>0)?$_GET['lista_cursix']:'';
            Nombre_Curso($lista_cursix);
        break;
		case 'NombreTutor':
			$id_curso_rex = (strlen($_GET['id_curso_rex'])>0)?$_GET['id_curso_rex']:'';
            Nombre_Tutor($id_curso_rex);
        break;
		case 'NrcDistinto':
			$lista_cursix = (strlen($_GET['lista_cursix'])>0)?$_GET['lista_cursix']:'';
            Nrc_Distinto($lista_cursix);
        break;
		case 'Hijo':
			$id_curso  = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:'';
            Si_Hijo($id_curso);
        break;
		case 'Padre':
			$id_curso  = (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:'';
			Si_Padre($id_curso);
		break;

    }
?>	