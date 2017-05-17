<?php

include '../BD/conexion.php';

 	function GetPostearon($postearon,$id_cursox,$foro_id,$grupos_del_tutor){               
		$con = new Conexion();
		$ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_ALUMNOS_POSTEARON
 		('$postearon','$id_cursox','$foro_id','$grupos_del_tutor');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'postearon'=> $row[0]  
                               	
							   ));
                  }    
            }
               echo json_encode($data);
	}

  function GetGrupos($existe){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_CURSO_TIENE_GRUPOS
    ('$existe');") or die("Query fail: " . mysqli_error());
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

  function GetUnidad($id_foro,$nombre_foro,$unidad,peso_recurso,$id_cursox){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_FOROS_CON_UNIDAD
      ('$id_foro','$nombre_foro','$unidad','peso_recurso','$id_cursox');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'id_foro'=> $row[0],   
                                  'nombre_foro'=> $row[1],
                                  'unidad'=> $row[2], 
                                  'peso_recurso'=> $row[3] 
                                  
                                              

                   ));
                    }    
              }
                 echo json_encode($data);
    }


  function GetGrupo($id_grupo,$nombre_grupo,$id_tutor,$id,$nombre_tutor,$id_cursox){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_GRUPOS_TUTOR_GRUPO
      ('$id_grupo','$nombre_grupo','$id_tutor',$id,'$nombre_tutor','$id_cursox');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'id_grupo'=> $row[0],   
                                  'nombre_grupo'=> $row[1],
                                  'id_tutor'=> $row[2], 
                                  'id'=> $row[3], 
                                  'nombre_tutor'=> $row[4]
                                  
                                              
                   ));
                    }    
              }
                 echo json_encode($data);
    }

    function GetAutor($tte,$tarea_id,$id_cursox,$grupos_del_tutor){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_LISTA_GRUPOS_AUTOR
      ('$tte','$tarea_id','$id_cursox','$grupos_del_tutor');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'tte'=> $row[0            
                                              
                   ));
                    }    
              }
                 echo json_encode($data);
    }

     function GetCurso($fullname,$subsanacion,$presencial,$induccion,$id_publico,$id_cursox){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_NOMBRE_CURSO 
      ('$fullname','$subsanacion','$presencial','$induccion','$id_publico','$id_cursox');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'fullname'=> $row[0],   
                                  'subsanacion'=> $row[1], 
                                  'presencial'=> $row[2], 
                                  'induccion'=> $row[3], 
                                  'id_publico'=> $row[4]
                                                                     
                   ));
                    }    
              }
                 echo json_encode($data);
    }

     function GetTutor($nombre_tutor,$tutor_sel){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_NOMBRE_TUTOR
      ('$nombre_tutor','$tutor_sel');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'nombre_tutor'=> $row[0] 
                                  
                                                                     
                   ));
                    }    
              }
                 echo json_encode($data);
    }

     function GetCalificadas($tarea_calificadas,$tarea_ib,$grupo_idx,$id_cursox){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_TAREAS_CALIFICADAS
      ('$tarea_calificadas','$tarea_ib','$grupo_idx','$id_cursox');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'nombre_tutor'=> $row[0]  
                                  
                                                                     
                   ));
                    }    
              }
                 echo json_encode($data);
    }


     function GetOffline($id_tarea,$name,$unidad,$tipo_area,$peso_recurso,$id_cursox){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_TAREAS_OFFLINE
      ('$id_tarea','$name','$unidad','$tipo_area','$peso_recurso','$id_cursox');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'id_tarea'=> $row[0],
                                  'name'=> $row[1],
                                  'unidad'=> $row[2],   
                                  'tipo_area'=> $row[3],
                                  'peso_recurso'=> $row[4]
                                  
                                                                            
                   ));
                    }    
              }
                 echo json_encode($data);
    }

     function GetCalificar($tareas_no_calificadas,$tarea_id,$grupo_idx,$id_cursox){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_TAREAS_SIN_CALIFICAR
      ('$tareas_no_calificadas','$tarea_id','$grupo_idx','$id_cursox');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'tareas_no_calificadas'=> $row[0]
                                  
                                  
                                                                            
                   ));
                    }    
              }
                 echo json_encode($data);
    }      

      function GetPonderaciones($tiene_pond, $id_cursox){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_TIENE_PONDERACIONES
      ('$tiene_pond','$id_cursox');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'tiene_pond'=> $row[0]                   
                                                                            
                   ));
                    }    
              }
                 echo json_encode($data);
    } 


       function GetGroup($total_alumnos_tutor,$id_cursox,$grupos_del_tutor){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_TOTAL_ALUMNO_GRUPO
      ('$total_alumnos_tutor','$id_cursox','$grupos_del_tutor');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'total_alumnos_tutor'=> $row[0]                   
                                                                            
                   ));
                    }    
              }
                 echo json_encode($data);
    } 

     function GetValidos($total,$id_cursox){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_TOTAL_ALUMNOS_VALIDOS
      ('$total','$id_cursox');") or die("Query fail: " . mysqli_error());
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

     function GetGroups($userid,$nombre_tutor,$total_grupos,$id_cursox){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_TUTORES_CANTIDAD_GRUPOS
      ('$userid','$nombre_tutor','$total_grupos','$id_cursox');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'userid'=> $row[0],
                                  'nombre_tutor'=> $row[1],
                                  'total_grupos'=> $row[2]                   
                                                                            
                   ));
                    }    
              }
                 echo json_encode($data);
    }


      function GetCalificados($usuarios_calificados,$id_cursox,$foro_id,$grupo_idx){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_USUARIOS_NO_CALIFICADOS
      ('$usuarios_calificados','$id_cursox','$foro_id','$grupo_idx');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'usuarios_calificados'=> $row[0]
                                                     
                                                                            
                   ));
                    }    
              }
                 echo json_encode($data);
    }


      function GetNoCalificados($usuarios_no_calificados,$id_cursox,$foro_id,$grupo_idx){               
      $con = new Conexion();
      $ca=$con->initConnection();
      $result = mysqli_query($ca, "call SP_REPORTE_EVIDENCIAS_TUTORES_CANTIDAD_GRUPOS
      ('$usuarios_no_calificados','$id_cursox','$foro_id','$grupo_idx');") or die("Query fail: " . mysqli_error());
      $data = [];
        if (mysqli_num_rows($result)>0){
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                                 array_push($data,array(
                                  'usuarios_no_calificados'=> $row[0]
                                                     
                                                                            
                   ));
                    }    
              }
                 echo json_encode($data);
    }


            $action = (strlen($_GET['action'])>0)?$_GET['action']:'';

            switch ($action) {
              case 'list1':
              $postearon =  (strlen($_GET['postearon'])>0)?$_GET['postearon']:'';   
              $id_cursox =  (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              $foro_id =  (strlen($_GET['foro_id'])>0)?$_GET['foro_id']:'';
              $grupos_del_tutor =  (strlen($_GET['grupos_del_tutor'])>0)?$_GET['grupos_del_tutor']:'';
                                

              GetPostearon($postearon,$id_cursox,$foro_id,$grupos_del_tutor);         
                break;

              case 'list2':
              $existe = (strlen($_GET['existe'])>0)?$_GET['existe']:'';

              GetGrupos($existe);         
                break;

              case 'list3':
                $id_foro = (strlen($_GET['id_foro'])>0)?$_GET['id_foro']:'';   
                $nombre_foro = (strlen($_GET['nombre_foro'])>0)?$_GET['nombre_foro']:'';
                $unidad = (strlen($_GET['unidad'])>0)?$_GET['unidad']:'';
                $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';

                GetUnidad($id_foro,$nombre_foro,$unidad,peso_recurso,$id_cursox);        
                break;

                case 'list4':
                $id_grupo = (strlen($_GET['id_grupo'])>0)?$_GET['id_grupo']:'';   
                $nombre_grupo = (strlen($_GET['nombre_grupo'])>0)?$_GET['nombre_grupo']:'';
                $id_tutor = (strlen($_GET['id_tutor'])>0)?$_GET['id_tutor']:'';
                $id = (strlen($_GET['id'])>0)?$_GET['id']:'';
                $nombre_tutor = (strlen($_GET['nombre_tutor'])>0)?$_GET['nombre_tutor']:'';
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';

                GetGrupo($id_grupo,$nombre_grupo,$id_tutor,$id,$nombre_tutor,$id_cursox);        
                break;

                 case 'list5':
                $tte = (strlen($_GET['tte'])>0)?$_GET['tte']:'';   
                $tarea_id = (strlen($_GET['tarea_id'])>0)?$_GET['tarea_id']:'';
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
                $grupos_del_tutor = (strlen($_GET['grupos_del_tutor'])>0)?$_GET['grupos_del_tutor']:'';
              
                GetAutor($tte,$tarea_id,$id_cursox,$grupos_del_tutor);        
                break;



                case 'list6':
                $fullname = (strlen($_GET['fullname'])>0)?$_GET['fullname']:'';   
                $subsanacion = (strlen($_GET['subsanacion'])>0)?$_GET['subsanacion']:'';
                $induccion = (strlen($_GET['induccion'])>0)?$_GET['induccion']:'';
                $presencial = (strlen($_GET['presencial'])>0)?$_GET['presencial']:'';
                $id_publico = (strlen($_GET['id_publico'])>0)?$_GET['id_publico']:'';
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              
                 GetCurso($fullname,$subsanacion,$presencial,$induccion,$id_publico,$id_cursox);       
                break;


                 case 'list7':
                $nombre_tutor = (strlen($_GET['nombre_tutor'])>0)?$_GET['nombre_tutor']:'';   
                $tutor_sel = (strlen($_GET['tutor_sel'])>0)?$_GET['tutor_sel']:'';
                
              
                 GetTutor($nombre_tutor,$tutor_sel);       
                break;

                 case 'list8':
                $tarea_calificadas = (strlen($_GET['nombre_tutor'])>0)?$_GET['nombre_tutor']:'';   
                $tarea_ib = (strlen($_GET['tutor_sel'])>0)?$_GET['tutor_sel']:'';
                $grupo_idx = (strlen($_GET['grupo_idx'])>0)?$_GET['grupo_idx']:'';
                $id_cursox= (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              
                 GetCalificadas($tarea_calificadas,$tarea_ib,$grupo_idx,$id_cursox);      
                break;

                case 'list9':
                $id_tarea = (strlen($_GET['id_tarea'])>0)?$_GET['id_tarea']:''; 
                $name = (strlen($_GET['name'])>0)?$_GET['name']:'';
                $unidad = (strlen($_GET['unidad'])>0)?$_GET['unidad']:'';
                $tipo_area = (strlen($_GET['tipo_area'])>0)?$_GET['tipo_area']:'';
                $peso_recurso = (strlen($_GET['peso_recurso'])>0)?$_GET['peso_recurso']:'';
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              
                GetOffline($id_tarea,$name,$unidad,$tipo_area,$peso_recurso,$id_cursox);      
                break;

               
                 case 'list10':
                $tareas_no_calificadas = (strlen($_GET['tareas_no_calificadas'])>0)?$_GET['tareas_no_calificadas']:''; 
                $tarea_id = (strlen($_GET['tarea_id'])>0)?$_GET['tarea_id']:'';
                $grupo_idx = (strlen($_GET['grupo_idx'])>0)?$_GET['grupo_idx']:'';
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
               
              
                 GetCalificar($tareas_no_calificadas,$tarea_id,$grupo_idx,$id_cursox);      
                break;

                 case 'list11':
                $tiene_pond = (strlen($_GET['tiene_pond'])>0)?$_GET['tiene_pond']:''; 
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              
                 GetPonderaciones($tiene_pond, $id_cursox);      
                break;

                case 'list12':
                $total_alumnos_tutor = (strlen($_GET['total_alumnos_tutor'])>0)?$_GET['total_alumnos_tutor']:''; 
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
                $grupos_del_tutor = (strlen($_GET['grupos_del_tutor'])>0)?$_GET['grupos_del_tutor']:'';
              
                  GetGroup($total_alumnos_tutor,$id_cursox,$grupos_del_tutor);      
                break;

                case 'list13':
                $total = (strlen($_GET['total'])>0)?$_GET['total']:''; 
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
               
              
                  GetValidos($total,$id_cursox);      
                break;

                case 'list14':
                $userid = (strlen($_GET['userid'])>0)?$_GET['userid']:''; 
                $nombre_tutor = (strlen($_GET['nombre_tutor'])>0)?$_GET['nombre_tutor']:'';
                $total_grupos = (strlen($_GET['total_grupos'])>0)?$_GET['total_grupos']:''; 
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
              
                  GetGroups($userid,$nombre_tutor,$total_grupos,$id_cursox);      
                break;
                

                case 'list15':
                $usuarios_calificados = (strlen($_GET['usuarios_calificados'])>0)?$_GET['usuarios_calificados']:''; 
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
                $foro_id = (strlen($_GET['foro_id'])>0)?$_GET['foro_id']:''; 
                $grupo_idx = (strlen($_GET['grupo_idx'])>0)?$_GET['grupo_idx']:'';
              
                 GetCalificados($usuarios_calificados,$id_cursox,$foro_id,$grupo_idx);      
                break;

                case 'list16':
                $usuarios_no_calificados = (strlen($_GET['usuarios_no_calificados'])>0)?$_GET['usuarios_no_calificados']:''; 
                $id_cursox = (strlen($_GET['id_cursox'])>0)?$_GET['id_cursox']:'';
                $foro_id = (strlen($_GET['foro_id'])>0)?$_GET['foro_id']:''; 
                $grupo_idx = (strlen($_GET['grupo_idx'])>0)?$_GET['grupo_idx']:'';
              
                 GetNoCalificados($usuarios_no_calificados,$id_cursox,$foro_id,$grupo_idx);      
                break;

                
               

    }
                           
    
?>  