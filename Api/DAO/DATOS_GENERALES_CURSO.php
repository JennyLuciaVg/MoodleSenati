
<?php

include '../BD/conexion.php';

	function Actualizar_Curso($tx_curso_sinfo,$tx_materia_sinfo,$nome_curso,$visiblex,$periocolo,$camp_presencial,$patron_semilla,$tx_id_tarea_induccion,$fuente,$header,$nombre_corto,$id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_ACTUALIZAR_CURSO('$tx_curso_sinfo','$tx_materia_sinfo','$nome_curso','$visiblex','$periocolo','$camp_presencial','$patron_semilla','$tx_id_tarea_induccion','$fuente','$header','$nombre_corto','$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		
	}
	
	//function Actualizar_CursoPatron($patronx,$publicox,$presex,$subsax,$indux,$grupox,$subsanacion_de_post,$presencial_de_post,$id_curso_moodle){               
	function Actualizar_CursoPatron($patronx,$publicox,$presex,$subsax,$indux,$grupox,$subsanacion_de_post,$presencial_de_post,$id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();	
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_ACTUALIZAR_CURSO_PATRON('$patronx',$publicox,'$presex','$subsax','$indux','$grupox',$subsanacion_de_post,$presencial_de_post,$id_curso_moodle);") or die("Query fail: " . mysqli_error());
	}
	
	function Actualizar_TituloCerti($titulo_certi,$tx_curso_sinfo,$tx_materia_sinfo,$nome_curso,$visiblex,$periocolo,$camp_presencial,$patron_semilla,$tx_id_tarea_induccion,$fuente,$header,$nombre_corto,$id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_TITULO_CERTIFICADO('$titulo_certi','$tx_curso_sinfo','$tx_materia_sinfo','$nome_curso','$visiblex','$periocolo','$camp_presencial','$patron_semilla','$tx_id_tarea_induccion','$fuente','$header','$nombre_corto','$id_curso_moodle');") or die("Query fail: " . mysqli_error());
	}
	
	function Actualizar_RelaCursos($valor_id_cs,$id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_ACTUALIZAR_RELA_CURSOS('$valor_id_cs','$id_curso_moodle');") or die("Query fail: " . mysqli_error());
	}
	
	function Eliminar_Rela_Cursos($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_ELIMINAR_RELA_CURSOS('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
	}
	
	function Curso_Existe($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_EXISTE('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
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
	
	function Insert_Rela_Cursos($valor_id_cs,$id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_INSERT_RELA_CURSOS('$valor_id_cs','$id_curso_moodle');") or die("Query fail: " . mysqli_error());
	}
	
	function Lista_Centro($camp_pres){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_LISTA_CENTRO('$camp_pres');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'nombre_centro'=> $row[0]            
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Curso($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
		$result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_LISTA_CURSO('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0],            
                        'shortname'=> $row[1],            
                        'visible'=> $row[2],   					
                        'id_patron_semilla'=> $row[3],            
                        'periodo'=> $row[4],            
                        'induccion'=> $row[5],            
                        'subsanacion'=> $row[6],            
                        'presencial'=> $row[7],            
                        'id_publico'=> $row[8],            
                        'grupo'=> $row[9],            
                        'presencial_de'=> $row[10],            
                        'subsanacion_de'=> $row[11],            
                        'patron'=> $row[12],            
                        'camp_pres'=> $row[13],            
                        'materia_sinfo'=> $row[14],            
                        'curso_sinfo'=> $row[15],            
                        'id_tarea_induccion'=> $row[16],            
                        'font_titulo_certi'=> $row[17],            
                        'header_certi'=> $row[18],            
                        'titulo_certificado'=> $row[19]        
					));
                }  
            }
            echo json_encode($data);			
	}
	
	function Lista_Cursos(){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_LISTA_CURSOS();") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_curso'=> $row[0],            
                        'nombre_curso'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Rela_Cursos($id_curso_moodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_RELA_CURSOS('$id_curso_moodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id_course_moodle'=> $row[0],            
                        'id_curso_senati'=> $row[1],
                        'nrc'=> $row[2],
                        'periodo'=> $row[3],
                        'id_curso_patron'=> $row[4],
                        'es_patron'=> $row[5],
                        'nombre_curso'=> $row[6]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Tarea($id_tarea_induccion){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_LISTA_TAREA('$id_tarea_induccion');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'name'=> $row[0]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Lista_Patron_Semilla($id_patron_semilla){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_DATOS_GENERALES_CURSO_PATRON_SEMILLA('$id_patron_semilla');") or die("Query fail: " . mysqli_error());
		$data = array();
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                       $data[] = array('fullname'=> $row[0]);
					
                }  
            }
            echo json_encode($data);
	}
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';
	//echo $action;
	$x=(isset($_GET['x']))?$_GET['x']:''; 
	if ($x==""){
		
	} else{
		//print_r($x);
		$x = json_decode($_GET['x']);	
		
	}
	
	$y=(isset($_GET['y']))?$_GET['y']:''; 
	if ($y==""){
		
	} else{
		//print_r($x);
		$y = json_decode($_GET['y']);	
	}
	
	$f=(isset($_GET['f']))?$_GET['f']:''; 
	if ($f==""){
		
	} else{
		//print_r($x);
		$f = json_decode($_GET['f']);	
	}
	
	$w=(isset($_GET['w']))?$_GET['w']:''; 
	if ($w==""){
		//echo "0";
	} else{
		//print_r($w);
		//echo $_GET['w'];
		$w = json_decode($_GET['w']);	
	}
		// print_r($w);
		// $w = json_decode($_GET['w']);	

		
	//echo $_GET;
	//$xv = (count($_GET)>0)?$_GET:array();
	//print_r($xv);
    switch ($action) {
        case 'ActualizarCurso':
			$tx_curso_sinfo = (strlen($x->tx_curso_sinfo)>0)?$x->tx_curso_sinfo:''; 
			$tx_materia_sinfo = (strlen($x->tx_materia_sinfo)>0)?$x->tx_materia_sinfo:''; 
			$nome_curso = (strlen($x->nome_curso)>0)?$x->nome_curso:''; 
			$visiblex = (strlen($x->visiblex)>0)?$x->visiblex:''; 
			$periocolo = (strlen($x->periocolo)>0)?$x->periocolo:''; 
			$camp_presencial = (strlen($x->camp_presencial)>0)?$x->camp_presencial:''; 
			$patron_semilla = (strlen($x->patron_semilla)>0)?$x->patron_semilla:''; 
			$tx_id_tarea_induccion = (strlen($x->tx_id_tarea_induccion)>0)?$x->tx_id_tarea_induccion:''; 
			$fuente = (strlen($x->fuente)>0)?$x->fuente:''; 
			$header = (strlen($x->header)>0)?$x->header:''; 
			$nombre_corto = (strlen($x->nombre_corto)>0)?$x->nombre_corto:''; 
			$id_curso_moodle = (strlen($x->id_curso_moodle)>0)?$x->id_curso_moodle:''; 
			Actualizar_Curso($tx_curso_sinfo,$tx_materia_sinfo,$nome_curso,$visiblex,$periocolo,$camp_presencial,$patron_semilla,$tx_id_tarea_induccion,$fuente,$header,$nombre_corto,$id_curso_moodle);
        break;
		case 'ActualizarCursoPatron':	
			
			$patronx = (strlen($w->patronx)>0)?$w->patronx:''; 
			$publicox = (strlen($w->publicox)>0)?$w->publicox:''; 
			$presex = (strlen($w->presex)>0)?$w->presex:''; 
			$subsax = (strlen($w->subsax)>0)?$w->subsax:''; 
			$indux = (strlen($w->indux)>0)?$w->indux:''; 
			$grupox = (strlen($w->grupox)>0)?$w->grupox:''; 
			$subsanacion_de_post = (strlen($w->subsanacion_de_post)>0)?$w->subsanacion_de_post:''; 
			$presencial_de_post = (strlen($w->presencial_de_post)>0)?$w->presencial_de_post:''; 
			$id_curso_moodle = (strlen($w->id_curso_moodle)>0)?$w->id_curso_moodle:''; 
			Actualizar_CursoPatron($patronx,$publicox,$presex,$subsax,$indux,$grupox,$subsanacion_de_post,$presencial_de_post,$id_curso_moodle);
        break;
		case 'ActualizarTituloCerti':
			$titulo_certi = (strlen($y->titulo_certi)>0)?$y->titulo_certi:''; 
			$tx_curso_sinfo = (strlen($y->tx_curso_sinfo)>0)?$y->tx_curso_sinfo:''; 
			$tx_materia_sinfo = (strlen($y->tx_materia_sinfo)>0)?$y->tx_materia_sinfo:''; 
			$nome_curso = (strlen($y->nome_curso)>0)?$y->nome_curso:''; 
			$visiblex = (strlen($y->visiblex)>0)?$y->visiblex:''; 
			$periocolo = (strlen($y->periocolo)>0)?$y->periocolo:''; 
			$camp_presencial = (strlen($y->camp_presencia)>0)?$y->camp_presencial:''; 
			$patron_semilla = (strlen($y->patron_semilla)>0)?$y->patron_semilla:''; 
			$tx_id_tarea_induccion = (strlen($y->tx_id_tarea_induccion)>0)?$y->tx_id_tarea_induccion:''; 
			$fuente = (strlen($y->fuente)>0)?$y->fuente:''; 
			$header = (strlen($y->header)>0)?$y->header:''; 
			$nombre_corto = (strlen($y->nombre_corto)>0)?$y->nombre_cortos:'';
			$id_curso_moodle = (strlen($y->id_curso_moodle)>0)?$y->id_curso_moodle:''; 
			Actualizar_TituloCerti($titulo_certi,$tx_curso_sinfo,$tx_materia_sinfo,$nome_curso,$visiblex,$periocolo,$camp_presencial,$patron_semilla,$tx_id_tarea_induccion,$fuente,$header,$nombre_corto,$id_curso_moodle);
        break;
		case 'ActualizarRelaCurso':
			$valor_id_cs = (strlen($f->valor_id_cs)>0)?$f->valor_id_cs:''; 
			$id_curso_moodle = (strlen($f->id_curso_moodle)>0)?$f->id_curso_moodle:'';
			Actualizar_RelaCursos($valor_id_cs,$id_curso_moodle);
        break;
		case 'Eliminar_rela_cursos':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Eliminar_Rela_Cursos($id_curso_moodle);
        break;
		case 'CursoExiste':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Curso_Existe($id_curso_moodle);
        break;
		case 'InsertRelaCursos':
			$valor_id_cs = (strlen($f->valor_id_cs)>0)?$f->valor_id_cs:''; 
			$id_curso_moodle = (strlen($f->id_curso_moodle)>0)?$f->id_curso_moodle:'';
			Insert_Rela_Cursos($valor_id_cs,$id_curso_moodle);
        break;
		case 'ListaCentro':
			$camp_pres = (strlen($_GET['camp_pres'])>0)?$_GET['camp_pres']:''; 
			Lista_Centro($camp_pres);
        break;
		case 'ListarCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Curso($id_curso_moodle);
        break;
		case 'ListarCursos':
			Lista_Cursos();
        break;
		case 'ListaRelaCurso':
			$id_curso_moodle = (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:''; 
			Lista_Rela_Cursos($id_curso_moodle);
		break;
		case 'ListaTarea':
			$id_tarea_induccion = (strlen($_GET['id_tarea_induccion'])>0)?$_GET['id_tarea_induccion']:'';
			Lista_Tarea($id_tarea_induccion);
		break;
		case 'ListaPatronSemilla':
			$id_patron_semilla = (strlen($_GET['id_patron_semilla'])>0)?$_GET['id_patron_semilla']:'';
			Lista_Patron_Semilla($id_patron_semilla);
		break;
    }
?>	

