<?php

include '../BD/conexion.php';

 
 	function GetLista($id_moodle,$pidm,$nombre,$curso,$id_curso,$campus,$nombre_centro,$periodo_listar){               
		$con = new Conexion();
		$ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_RETIRADOS_LISTAR
 		function GetData('$id_moodle','$pidm','$nombre','$curso','$id_curso','$campus','$nombre_centro','$periodo_listar');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'id_moodle'=> $row[0],     
                               	'pidm'=> $row[1], 
                               	'nombre'=> $row[2],                             
                               	'curso'=> $row[3], 
                               	'id_curso'=> $row[4], 
                               	'campus'=> $row[5], 
                                '$nombre_centro'=> $row[6],
                                '$periodo_listar'=> $row[7]             	
							   ));
                  }    
            }
               echo json_encode($data);
	}

	                
            
            $action = (strlen($_GET['action'])>0)?$_GET['action']:'';

            switch ($action) {
            	case 'lista':
            	$id_moodle = (strlen($_GET['id_moodle'])>0)?$_GET['id_moodle']:'';
      			 	$pidm = (strlen($_GET['pidm'])>0)?$_GET['pidm']:'';
      			 	$nombre = (strlen($_GET['nombre'])>0)?$_GET['nombre']:'';
      				$curso = (strlen($_GET['curso'])>0)?$_GET['curso']:'';
      				$id_curso= (strlen($_GET['id_curso'])>0)?$_GET['id_curso']:'';
              $campus= (strlen($_GET['campus'])>0)?$_GET['campus']:'';
              $nombre_centro= (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
      				$periodo_listar = (strlen($_GET['periodo_listar'])>0)?$_GET['periodo_listar']:'';			 	

            	GetLista($id_moodle,$pidm,$nombre,$curso,$id_curso,$campus,$periodo_listar,$nombre_centro,$periodo_listar);          	
            		# code...
            		break;
    }
                           
		
?>	