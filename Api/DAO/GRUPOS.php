<?php

include '../BD/conexion.php';

	function Bloque_Alumno($ID_CURSO,$ID_USUARIO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_CAMPUS_BLOQUE_ALUMNO('$ID_CURSO','$ID_USUARIO');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(				
                        'camp'=> $row[0], 
                        'bloque'=> $row[1], 
                        'nrc'=> $row[2]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Lista_Curso($Id_Curso){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PERIODO_CURSO('$Id_Curso');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'periodo'=> $row[0]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Miembros_Grupo($ID_GRUPO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_CUANTOS_MIEMBROS_GRUPO('$ID_GRUPO');") or die("Query fail: " . mysqli_error());
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
	
	function Estadisticas_Grupo($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_ESTADISTICAS_GRUPO('$ID_CURSO');") or die("Query fail: " . mysqli_error());
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
	
	function Lista_PeriodoCurso($periodo_curso,$ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GET_PERIODOCURSO('$periodo_curso','$ID_CURSO');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'nrc'=> $row[0],
                        'nombre_tutor'=> $row[1], 
                        'camp'=> $row[2], 
                        'Total'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}

	function Distinct_Camp_Distinc($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GETBYID_DISTINCT_CAMP_DISTINC('$ID_CURSO');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(					
                        'camp'=> $row[0],
                        'nombre_centro'=> $row[1], 
                        'Total'=> $row[2]
					));
                }  
            }
            echo json_encode($data);
	}

	function Distinct_Camp_Distinc_Bloque($ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GETBYID_DISTINCT_CAMP_DISTINC_BLOQUE('$ID_CURSO');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(					
                        'bloque'=> $row[0],
                        'Total'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function NRC_GRUPO($id_grupo,$ID_CURSO){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_NRC_GRUPO('$id_grupo','$ID_CURSO');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(					
                        'nrc'=> $row[0],
                        'camp'=> $row[1],
                        'total'=> $row[2],
                        'bloque'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'BloqueAlumno':
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			$ID_USUARIO = (strlen($_GET['ID_USUARIO'])>0)?$_GET['ID_USUARIO']:''; 
			Bloque_Alumno($ID_CURSO,$ID_USUARIO);
        break;
		case 'ListaCurso':
			 $Id_Curso = (strlen($_GET['Id_Curso'])>0)?$_GET['Id_Curso']:''; 
			 Lista_Curso($Id_Curso);
        break;
		case 'MiembrosGrupo': 
			$ID_GRUPO = (strlen($_GET['ID_GRUPO'])>0)?$_GET['ID_GRUPO']:''; 
			Miembros_Grupo($ID_GRUPO);
        break;
		case 'EstadisticaGrupo': 
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			Estadisticas_Grupo($ID_CURSO);
        break;
		case 'ListPerioCurso': 
			$periodo_curso = (strlen($_GET['periodo_curso'])>0)?$_GET['periodo_curso']:''; 
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			Lista_PeriodoCurso($periodo_curso,$ID_CURSO);
        break;
		case 'DistinctCampDistinct': 
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			Distinct_Camp_Distinc($ID_CURSO);
        break;
		case 'DistinctCampDistinctB':
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			Distinct_Camp_Distinc_Bloque($ID_CURSO)
        break;
		case 'NrcGrupo':
			$id_grupo = (strlen($_GET['id_grupo'])>0)?$_GET['id_grupo']:''; 
			$ID_CURSO = (strlen($_GET['ID_CURSO'])>0)?$_GET['ID_CURSO']:''; 
			NRC_GRUPO($id_grupo,$ID_CURSO);
        break;
		
		
    }
?>	