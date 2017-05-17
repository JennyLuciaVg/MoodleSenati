<?php

include '../BD/conexion.php';

	function Listar_Detallados($YEARS){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTAR_Detallados('$YEARS');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(					
                        'id'=> $row[0],                 
                        'fullname'=> $row[1],                 
                        'startdate'=> $row[2],                 
                        'periodo'=> $row[3],                 
                        'subsanacion'=> $row[4],                 
                        'subsanacion_de'=> $row[5],                 
                        'Inscritos'=> $row[6],                 
                        'visible'=> $row[7],                 
                        'reti_sinfo'=> $row[8],                 
                        'total_grupox'=> $row[9],                 
                        'total_tutores'=> $row[10],                 
                        'pondera'=> $row[11],                 
                        'patron'=> $row[12],                 
                        'hacademica'=> $row[13],                 
                        'temas_foro'=> $row[14],                 
					));
                }  
            }
            echo json_encode($data);
	}
	
	function Listar_PRESENCIALES($ID_CURSO_SUBSA){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_LISTAR_PRESENCIALES('$ID_CURSO_SUBSA');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],                 
                        'fullname'=> $row[1],                 
                        'startdate'=> $row[2],                 
                        'periodo'=> $row[3],                 
                        'Inscritos'=> $row[4],                 
                        'reti_sinfo'=> $row[5],                 
                        'total_grupox'=> $row[6],                 
                        'total_tutores'=> $row[7],                 
                        'pondera'=> $row[8],                 
                        'temas_foro'=> $row[9],                 
					));
                }  
            }
            echo json_encode($data);
	}
	function Presenciales_Subsanacion($ID_CURSO_PADRE){               
		$con = new Conexion();
		$ca=$con->initConnection();
        $result = mysqli_query($ca, "call SP_PRESENCIALES_O_SUBSANACIONES('$ID_CURSO_PADRE');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                        array_push($data,array(
                        'id'=> $row[0],                    
                        'fullname'=> $row[1],                    
                        'startdate'=> $row[2],                    
                        'periodo'=> $row[3],                    
                        'subsanacion'=> $row[4],                    
                        'subsanacion_de'=> $row[5],                    
                        'presencial'=> $row[6],                   
                        'Inscritos'=> $row[7],                   
                        'reti_sinfo'=> $row[8],                   
                        'total_grupox'=> $row[9],                   
                        'total_tutores'=> $row[10],                   
                        'pondera'=> $row[11],                   
                        'hacademica'=> $row[12],                   
                        'temas_foro'=> $row[13]                   
					));
                }  
            }
            echo json_encode($data);
	}
	
	
	$action = (strlen($_GET['action'])>0)?$_GET['action']:'';

    switch ($action) {
        case 'ListarDetallados':
			$YEARS = (strlen($_GET['YEARS'])>0)?$_GET['YEARS']:''; 
			Listar_Detallados($YEARS);
        break;
		case 'ListarPresencial':
			$ID_CURSO_SUBSA= (strlen($_GET['ID_CURSO_SUBSA'])>0)?$_GET['ID_CURSO_SUBSA']:''; 
			Listar_PRESENCIALES($ID_CURSO_SUBSA);
		break;
		case 'PresenciSubsa':
			$ID_CURSO_PADRE = (strlen($_POST['ID_CURSO_PADRE'])>0)?$_POST['ID_CURSO_PADRE']:''; 
			Presenciales_Subsanacion($ID_CURSO_PADRE);
        break;
    }
?>	