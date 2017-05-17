<?php

include '../BD/conexion.php';

	function Lista_Nota($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_OFICIAL('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(				
                        'userid'=> $row[0], 
                        'firstname'=> $row[1], 
                        'pidm_banner'=> $row[2],
                        'lastname'=> $row[2],
                        'email'=> $row[3],
                        'city'=> $row[4],
                        'nota'=> $row[5],
                        'estado'=> $row[6],
                        'camp'=> $row[7],
                        'carr'=> $row[8],
                        'periodo'=> $row[9],
                        'nrc'=> $row[10],
                        'bloque'=> $row[11]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Estadistica_Campus($Id_Curso_Modle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_OFICIAL_ESTADISTICAS_CAMPUS('$Id_Curso_Modle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'CE'=> $row[0],
                        'camp'=> $row[1],
                        'estado'=> $row[2],
                        'nombre_centro'=> $row[3],
                        'total'=> $row[4]
                        'total'=> $row[4]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Estadistica_Carrera($Id_Curso_Modle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_OFICIAL_ESTADISTICAS_CARRERA('$Id_Curso_Modle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'CE'=> $row[0],
                        'camp'=> $row[1],
                        'carr'=> $row[2],
                        'estado'=> $row[3],
                        'materia_desc'=> $row[4],
                        'nombre_centro'=> $row[5],
                        'total'=> $row[6],
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Profesor($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ACTAS_NOTA_OFICIAL_PROFESOR('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'userid'=> $row[0],
                        'firstname'=> $row[0],
                        'lastname'=> $row[1],
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Cursos($id_categoria){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTA_CURSOS('$id_categoria');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(					
                        'id_curso'=> $row[0],
                        'nombre_curso'=> $row[1],
                        'banner_subj_code'=> $row[2],
                        'banner_crse_numb'=> $row[3],
                        'id_categoria'=> $row[4],
                        'banner_cont_hr_low'=> $row[5],
                        'infor_web'=> $row[6],
                        'activo'=> $row[7],
                        'costo'=> $row[8],
                        'fecha_creacion'=> $row[9],
                        'materia_sinfo'=> $row[10],
                        'curso_sinfo'=> $row[11],
                        'tipo_curso_sinfo1'=> $row[12],
                        'tipo_curso_sinfo2'=> $row[13],
                        'siglas'=> $row[14],
                        'imagen'=> $row[15],
                        'ancho'=> $row[16],
                        'alto'=> $row[17],
                        'curso_de_pago'=> $row[18],
                        'resumen_web'=> $row[19],
                        'pagina_web'=> $row[20],
                        'id'=> $row[21],
                        'name'=> $row[22],
                        'idnumber'=> $row[23],
                        'description'=> $row[24],
                        'descriptionformat'=> $row[25],
                        'parent'=> $row[26],
                        'sortorder'=> $row[27],
                        'coursecount'=> $row[28],
                        'visible'=> $row[29],
                        'visibleold'=> $row[30],
                        'timemodified'=> $row[31],
                        'depth'=> $row[32],
                        'path'=> $row[33],
                        'theme'=> $row[34],
                        'TOTAL_DICTADOS'=> $row[35]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Cursos_Dictados($Id_Curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTA_CURSOS_DICTADOS('$Id_Curso');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0],
                        'id_curso_moodle'=> $row[1], 
                        'startdate'=> $row[2], 
                        'numsections'=> $row[3],
                        'Tiene_Certificado'=> $row[4]
					));
                }  
            }
            echo json_encode($data);
	}

	
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListaNota':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Nota($id_curso_moodle);
        break;
		case 'EstadisticaCampus':
			 $Id_Curso_Modle = (strlen($_GET['Id_Curso_Modle'])>0)?$_GET['Id_Curso_Modle']:''; 
			 Estadistica_Campus($Id_Curso_Modle);
        break;
		case 'EstadisticaCarrera': 
			$Id_Curso_Modle = (strlen($_GET['Id_Curso_Modle'])>0)?$_GET['Id_Curso_Modle']:''; 
			Estadistica_Carrera($Id_Curso_Modle);
        break;
		case 'ListaProfesor': 
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			 Lista_Profesor($id_curso_moodle);
        break;
		case 'ListaCursos': 
			$id_categoria = (strlen($_GET['id_categoria'])>0)?$_GET['id_categoria']:''; 
			Lista_Cursos($id_categoria);
        break;
		case 'ListaCDictados': 
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			Lista_Cursos_Dictados($Id_Curso);
        break;
		
    }
?>	