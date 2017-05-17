<?php

include '../BD/conexion.php';

 	function Actualizar_Modulo($modulo_visible,$modulo){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_ACTUALIZAR_MODULO('$modulo_visible','$modulo');") or die("Query fail: " . mysqli_error());
	}
	
	function Actualizar_Secciones($seccion_visible,$seccion){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_ACTUALIZAR_SECCIONES('$seccion_visible','$seccion');") or die("Query fail: " . mysqli_error());
	}
	
	function Contar_Modulos($unidad,$idcmoodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_CONTAR_MODULOS('$unidad','$idcmoodle');") or die("Query fail: " . mysqli_error());
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
	
	function Actu_Unidades($idcursomoodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_GET_ACTU_UNIDADES('$idcursomoodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'fullname'=> $row[0],
                        'startdate'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Modulos($unidad,$idcmoodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_GET_MODULOS('$unidad','$idcmoodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'name'=> $row[1],
                        'visible'=> $row[2],
                        'module'=> $row[3],
                        'instance'=> $row[4]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function GetTable1($idcmoodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_GET_TABLE1('$idcmoodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],
                        'section'=> $row[1],
                        'visible'=> $row[2],
                        'summary'=> $row[3]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function SeccionBorrar($id_section_borrar){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_SECCIONES_BORRAR('$id_section_borrar');") or die("Query fail: " . mysqli_error());
	}
	
	function Sequency($id_section,$idcmoodle){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_SEQUENCY('$id_section','$idcmoodle');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'sequence'=> $row[0]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function VerificaTabla($tablax,$instance){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_VERIFICA_TABLA_M_o_F('$tablax','$instance');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'nombre'=> $row[0],
                        'id_tutor'=> $row[1]
					));
                }  
            }
            echo json_encode($data);
	}
	
	function TipoModulo($instancia,$name_module){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_VERIFICA_TIPO_MODULO('$instancia','$name_module');") or die("Query fail: " . mysqli_error());
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
	
	function TipoMLabel($instancia){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_UNIDADES_M_VERIFICA_TIPO_MODULO_LABEL('$instancia');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'name'=> $row[0],
                        'content'=> $row[0]						
					));
                }  
            }
            echo json_encode($data);
	}
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ActualizarModulo':
			$modulo_visible = (strlen($_POST['modulo_visible'])>0)?$_POST['modulo_visible']:'';
			$modulo = (strlen($_POST['modulo'])>0)?$_POST['modulo']:'';
			Actualizar_Modulo($id_alu_moodle);
        break;
		case 'ActualizarSeccion':
			$seccion_visible = (strlen($_GET['seccion_visible'])>0)?$_GET['seccion_visible']:'';
			$seccion = (strlen($_GET['seccion'])>0)?$_GET['seccion']:'';
            Actualizar_Secciones($ids);
        break;
		case 'ContarModulo':
			$unidad = (strlen($_GET['unidad'])>0)?$_GET['unidad']:'';
			$idcmoodle = (strlen($_GET['idcmoodle'])>0)?$_GET['idcmoodle']:'';
            Contar_Modulos($unidad,$idcmoodle);
        break;
		case 'Unidades':
			$idcursomoodle = (strlen($_GET['idcursomoodle'])>0)?$_GET['idcursomoodle']:'';
            Actu_Unidades($idcursomoodle);
        break;
		case 'Modulo':
			$unidad = (strlen($_GET['unidad'])>0)?$_GET['unidad']:'';
			$idcmoodle = (strlen($_GET['idcmoodle'])>0)?$_GET['idcmoodle']:'';
            Modulos($unidad,$idcmoodle);
        break;
		case 'Table1':
			$idcmoodle = (strlen($_GET['idcmoodle'])>0)?$_GET['idcmoodle']:'';
            GetTable1($idcmoodle);
        break;
		case 'SeccionBorra':
			$id_section_borrar = (strlen($_GET['id_section_borrar'])>0)?$_GET['id_section_borrar']:'';
            SeccionBorrar($id_section_borrar);
        break;
		case 'Secuencia':
			$id_section = (strlen($_GET['id_section'])>0)?$_GET['id_section']:'';
			$idcmoodle = (strlen($_GET['idcmoodle'])>0)?$_GET['idcmoodle']:'';
            Sequency($id_section,$idcmoodle);
        break;
		case 'Verifica':
			$tablax = (strlen($_GET['tablax'])>0)?$_GET['tablax']:'';
			$instance = (strlen($_GET['instance'])>0)?$_GET['instance']:'';
            VerificaTabla($tablax,$instance);
        break;
		case 'TipoModulos':
			$instancia = (strlen($_GET['instancia'])>0)?$_GET['instancia']:'';
			$name_module = (strlen($_GET['name_module'])>0)?$_GET['name_module']:'';
            TipoModulo($instancia,$name_module);
        break;
		case 'TipoLabel':
			$instancia = (strlen($_GET['instancia'])>0)?$_GET['instancia']:'';
            TipoMLabel($instancia);
        break;
    }
?>	