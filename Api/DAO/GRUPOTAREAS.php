<?php

include '../BD/conexion.php';

	function Actualizar_Tareas($datax,$id_tarea,$id_nume_grupo){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GRUPO_TAREA_ACTUALIZAR_TAREAS('$datax','$id_tarea','$id_nume_grupo');") or die("Query fail: " . mysqli_error());
	}
	
	function Tarea_Emisor($id_curso_importar){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GRUPO_TAREA_EMISOR('$id_curso_importar');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(				
                        'numero_grupo'=> $row[0], 
                        'unidad'=> $row[1], 
                        'contenido'=> $row[2]
					));
                }  
            }
            echo json_encode($data);
	
	}
	
	function Tarea_Existe($id_tarea,$id_nume_grupo){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GRUPO_TAREA_EXISTE('$id_tarea','$id_nume_grupo');") or die("Query fail: " . mysqli_error());
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
	
	function Insertar_Tarea($id_tarea,$id_nume_grupo,$id_module,$unidadx){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GRUPO_TAREA_INSERTAR_TAREAS('$id_tarea','$id_nume_grupo','$id_module','$unidadx');") or die("Query fail: " . mysqli_error());
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
	
	function Lista_Modulo($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GRUPO_TAREA_LISTA_MODULOS('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(					
                        'name'=> $row[0],
                        'id_tarea'=> $row[1], 
                        'id_module'=> $row[2], 
                        'unidad'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Tarea_Grupo($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GRUPO_TAREA_LISTA_TAREAS_GRUPO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_tarea'=> $row[0],
                        'name'=> $row[1], 
                        'numero_grupo'=> $row[2], 
                        'unidad'=> $row[3],
                        'contenido'=> $row[4]
					));
                }  
            }
            echo json_encode($data);
	}

	function Grupo_Receptor($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_GRUPO_RECEPTOR('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(					
                        'id_tarea'=> $row[0],
                        'recurso'=> $row[1], 
                        'unidad'=> $row[2]
					));
                }  
            }
            echo json_encode($data);
	}

	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ActualizarTarea':
			$datax = (strlen($_POST['datax'])>0)?$_POST['datax']:''; 
			$id_tarea = (strlen($_POST['id_tarea'])>0)?$_POST['id_tarea']:''; 
			$id_nume_grupo = (strlen($_POST['id_nume_grupo'])>0)?$_POST['id_nume_grupo']:''; 
			Actualizar_Tareas($datax,$id_tarea,$id_nume_grupo);
        break;
		case 'TareaEmisor':
			$id_curso_importar = (strlen($_GET['id_curso_importar'])>0)?$_GET['id_curso_importar']:''; 
			Tarea_Emisor($id_curso_importar);
        break;
		case 'Existe':
			$id_tarea = (strlen($_GET['id_tarea'])>0)?$_GET['id_tarea']:''; 
			$id_nume_grupo = (strlen($_GET['id_nume_grupo'])>0)?$_GET['id_nume_grupo']:''; 
			Tarea_Existe($id_tarea,$id_nume_grupo);
        break;
		case 'InsertarTarea':
			$id_tarea = (strlen($_POST['id_tarea'])>0)?$_POST['id_tarea']:''; 
			$id_nume_grupo = (strlen($_POST['id_nume_grupo'])>0)?$_POST['id_nume_grupo']:''; 
			$id_module = (strlen($_POST['id_module'])>0)?$_POST['id_module']:''; 
			$unidadx = (strlen($_POST['unidadx'])>0)?$_POST['unidadx']:''; 
			Insertar_Tarea($id_tarea,$id_nume_grupo,$id_module,$unidadx);
        break;
		case 'ListaModulo':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Modulo($id_curso_moodle);
        break;
		case 'TareaGrupo':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Tarea_Grupo($id_curso_moodle);
        break;
		case 'ListaForoDistinct':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Grupo_Receptor($id_curso_moodle)
        break;
		
    }
?>	