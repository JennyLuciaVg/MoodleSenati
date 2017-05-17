<?php

include '../BD/conexion.php';

 	function GetCampus($camp,$periodo,$nombre_centro){               
		$con = new Conexion();
		$ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_JEFES_LISTA_CAMPUS
 		('$camp','$periodo','$nombre_centro');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	'camp'=> $row[0],     
                               	'periodo'=> $row[1], 
                               	'nombre_centro'=> $row[2]
                                
							   ));
                  }    
            }
               echo json_encode($data);
	}

      function GetEspecifico($camp,$periodo,$nombre_centro,$campus_repo){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_JEFES_LISTA_CAMPUS_ESPECIFICO
    ('$camp','$periodo','$nombre_centro','$campus_repo');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'camp'=> $row[0],     
                                'periodo'=> $row[1], 
                                'nombre_centro'=> $row[2]
                                
                 ));
                  }    
            }
               echo json_encode($data);
  }

     function GetCursos($id,$fullname,$periodo_vc,$camp_vc){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_JEFES_LISTA_CURSOS
    ('$id','$fullname','$periodo_vc','$camp_vc');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],     
                                'fullname'=> $row[1]
                               
                                
                 ));
                  }    
            }
               echo json_encode($data);
  }

      function GetCurso($id,$fullname,$alumnos,$periodo_vc,$camp_vc){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_JEFES_LISTA_CURSOS
    ('$id','$fullname','$alumnos','$periodo_vc','$camp_vc');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],     
                                'fullname'=> $row[1],
                                'alumnos'=> $row[2]

                                             
                 ));
                  }    
            }
               echo json_encode($data);
  }

       function GetListar($jefe_centro,$campus_repo,$usuario){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_JEFES_LISTAR
    ('$jefe_centro','$campus_repo','$usuario');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'jefe_centro'=> $row[0],     
                                'campus_repo'=> $row[1]
                                                         
                 ));
                  }    
            }
               echo json_encode($data);
  }
          function GetEstudiantes($camp,$nombre_centro,$nombre_zonal,$totalu,$periodo_select){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_REPORTES_JEFES_LISTAR
    ('$camp','$nombre_centro','$nombre_zonal','$totalu','$periodo_select');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'camp'=> $row[0],     
                                'nombre_centro'=> $row[1],
                                'nombre_zonal'=> $row[2],
                                'totalu'=> $row[3]
                                
                                                         
                 ));
                  }    
            }
               echo json_encode($data);
  }

       function GetCampu($id_centro,$periodo,$nombre_centro){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_LISTAR_CAMPUS
    ('$id_centro','$periodo','$nombre_centro');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id_centro'=> $row[0],     
                                'periodo'=> $row[1],
                                'nombre_centro'=> $row[2]
                                
                                
                                                         
                 ));
                  }    
            }
               echo json_encode($data);
  }



     function GetCampusRepo($id_centro,$periodo,$nombre_centro){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_LISTAR_CAMPUS_REPO
    ('$campus_repo','$periodo','$nombre_centro');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'camp'=> $row[0],     
                                'periodo'=> $row[1],
                                'nombre_centro'=> $row[2]
                                
                                
                                                         
                 ));
                  }    
            }
               echo json_encode($data);
  }


     function GetLeftEstudiantes($siglas,$nombre_curso,$camp,$nombre_centro,$total_alumnos,$periodo_select){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_LISTAR_INNER_LEFT_ESTUDIANTES
    ('$siglas','$nombre_curso','$camp','$nombre_centro','$total_alumnos','$periodo_select');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'siglas'=> $row[0],     
                                'nombre_curso'=> $row[1],
                                'camp'=> $row[2],
                                'nombre_centro'=> $row[3],
                                'total_alumnos'=> $row[4]
                                                   
                                                         
                 ));
                  }    
            }
               echo json_encode($data);
  }

      function GetDistinto($periodo){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_PERIODO_DISTINTO
    ('$periodo');") or die("Query fail: " . mysqli_error());
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


      function GetCentro($jefe_centro','$campus_repo','$usuario){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_VERIFICAR_JEFE_CENTRO
    ('$jefe_centro','$campus_repo','$usuario');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'jefe_centro'=> $row[0],
                                'campus_repo'=> $row[1]                       
                                              
                 ));
                  }    
            }
               echo json_encode($data);
  }


      function GetUser($idsv_buscado,$nom_buscado,$apes_buscado,$email,$campus,$nombre_centro,$pidm_buscado,$tipo_user,$publico,$dni_buscado){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_LISTAR_LEFT_USER
    ('$idsv_buscado','$nom_buscado','$apes_buscado,'$email','$campus','$nombre_centro','$pidm_buscado','$tipo_user','$publico','$dni_buscado');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'firstname'=> $row[1],
                                'lastname'=> $row[2],                       
                                'email'=> $row[3],
                                'campus'=> $row[4],
                                'pidm_banner'=> $row[5],
                                'tipo_user'=> $row[6],
                                'publico'=> $row[7],
                                'dni'=> $row[8]
                                              
                 ));
                  }    
            }
               echo json_encode($data);
  }


      function GetCentros($jefe_centro,$campus_repo,$usuario){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_LISTAR_LEFT_USER
    ('$jefe_centro','$campus_repo','$usuario');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'jefe_centro'=> $row[0],
                                'campus_repo'=> $row[1]
                 ));
                  }    
            }
               echo json_encode($data);
  }

    function GetEstudiante($id,$id_alumno,$courseid,$timestart,$timeend,$time,$timeaccess,$enrol,$nrc,$periodo,$camp,$bloque,$carr,$pidm,$semestre,$status_sinfo,$fullname,$nota,$estado{               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_LISTAR_LEFT_USER
    ('$id','$id_alumno','$courseid','$timestart','$timeend','$time','$timeaccess','$enrol','$nrc','$periodo','$camp','$bloque','$carr','$pidm','$semestre','$status_sinfo','$fullname','$nota,$estado');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'userid'=> $row[1],
                                'courseid'=> $row[1],
                                'timestart'=> $row[1],
                                'timeend'=> $row[1],
                                'time'=> $row[1],
                                'timeaccess'=> $row[1],
                                'enrol'=> $row[1],
                                'nrc'=> $row[1],
                                'periodo'=> $row[1],
                                'camp'=> $row[1],
                                'bloque'=> $row[1],
                                'carr'=> $row[1],
                                'pidm'=> $row[1],
                                'semestre'=> $row[1],
                                'status_sinfo'=> $row[1],
                                'fullname'=> $row[1],
                                'nota'=> $row[1],
                                'estado'=> $row[1]
                 ));
                  }    
            }
               echo json_encode($data);
  }

      function GetUsers($lastname,$firstname,$email,$nombre_centro,$campus,$pidm_banner,$id_alumno){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_LISTAR_LEFT_USER
    ('$lastname','$firstname','$email','$nombre_centro','$campus','$pidm_banner','id_alumno');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'lastname'=> $row[0],
                                'campus'=> $row[1],
                                'email'=> $row[2],
                                'nombre_centro'=> $row[3],
                                'campus'=> $row[4],
                                'pidm_banner'=> $row[5]
                 ));
                  }    
            }
               echo json_encode($data);
  }



            $action = (strlen($_GET['action'])>0)?$_GET['action']:'';

            switch ($action) {
              case 'list1':
              $camp = (strlen($_GET['camp'])>0)?$_GET['camp']:'';
              $periodo = (strlen($_GET['periodo'])>0)?$_GET['periodo']:'';
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
                   
              GetCampus($camp,$periodo,$nombre_centro);         
                # code...
                break;

              case 'list2':
              $camp = (strlen($_GET['camp'])>0)?$_GET['camp']:'';
              $periodo = (strlen($_GET['periodo'])>0)?$_GET['periodo']:'';
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
              $campus_repo = (strlen($_GET['campus_repo'])>0)?$_GET['campus_repo']:'';

              GetCampus($camp,$periodo,$nombre_centro,$campus_repo);         
                # code...
                break;


              case 'list3':
              $id = (strlen($_GET['$id'])>0)?$_GET['$id']:'';
              $fullname = (strlen($_GET['fullname'])>0)?$_GET['fullname']:'';
              $periodo_vc = (strlen($_GET['periodo_vc'])>0)?$_GET['periodo_vc']:'';
              $camp_vc = (strlen($_GET['camp_vc'])>0)?$_GET['camp_vc']:'';

               GetCursos($id,$fullname,$periodo_vc,$camp_vc);         
                # code...
                break;

              case 'list4':
              $id = (strlen($_GET['$id'])>0)?$_GET['$id']:'';
              $fullname = (strlen($_GET['fullname'])>0)?$_GET['fullname']:'';
              $alumnos = (strlen($_GET['alumnos'])>0)?$_GET['alumnos']:'';
              $periodo_vc = (strlen($_GET['periodo_vc'])>0)?$_GET['periodo_vc']:'';
              $camp_vc = (strlen($_GET['camp_vc'])>0)?$_GET['camp_vc']:'';

               GetCurso($id,$fullname,$alumnos,$periodo_vc,$camp_vc);         
                # code...
                break;

                case 'list5':
              $jefe_centro = (strlen($_GET['$jefe_centro'])>0)?$_GET['$jefe_centro']:'';
              $campus_repo = (strlen($_GET['campus_repo'])>0)?$_GET['campus_repo']:'';
              $usuario = (strlen($_GET['usuario'])>0)?$_GET['usuario']:'';
             

                GetListar($jefe_centro,$campus_repo,$usuario);         
                # code...
                break;

                case 'list6':
              $camp = (strlen($_GET['$camp'])>0)?$_GET['$camp']:'';
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
              
              $nombre_zonal = (strlen($_GET['nombre_zonal'])>0)?$_GET['nombre_zonal']:'';
              $totalu = (strlen($_GET['totalu'])>0)?$_GET['totalu']:'';
              $periodo_select = (strlen($_GET['periodo_select'])>0)?$_GET['periodo_select']:'';
             

                 GetEstudiantes($camp,$nombre_centro,$nombre_zonal,$totalu,$periodo_select);         
                # code...
                break;


              case 'list7':
              $id_centro = (strlen($_GET['$id_centro'])>0)?$_GET['$id_centro']:'';
              $periodo = (strlen($_GET['periodo'])>0)?$_GET['periodo']:'';
              
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';

               GetCampu($id_centro,$periodo,$nombre_centro);     
                # code...
                break;
               
              case 'list8'
              $id_centro = (strlen($_GET['$id_centro'])>0)?$_GET['$id_centro']:'';
              $periodo = (strlen($_GET['periodo'])>0)?$_GET['periodo']:'';
              
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';

               GetCampusRepo($id_centro,$periodo,$nombre_centro);     
                # code...
                break;


              case 'list9'
              $siglas = (strlen($_GET['$siglas'])>0)?$_GET['$siglas']:'';
              $nombre_curso = (strlen($_GET['nombre_curso'])>0)?$_GET['nombre_curso']:'';
              $camp = (strlen($_GET['camp'])>0)?$_GET['camp']:'';
              $nombre_centro = (strlen($_GET['nombre_centro'])>0)?$_GET['nombre_centro']:'';
              $total_alumnos = (strlen($_GET['total_alumnos'])>0)?$_GET['total_alumnos']:'';
              $periodo_select = (strlen($_GET['periodo_select'])>0)?$_GET['periodo_select']:'';

                GetLeftEstudiantes($siglas,$nombre_curso,$camp,$nombre_centro,$total_alumnos,$periodo_select);     
                # code...
                break;
               
               
                case 'list10'
              $periodo = (strlen($_GET['$periodo'])>0)?$_GET['$periodo']:'';

                GetDistinto($periodo);     
                # code...
                break;



                case 'list11'
              $jefe_centro = (strlen($_GET['$jefe_centro'])>0)?$_GET['$jefe_centro']:'';
              $periodo = (strlen($_GET['$campus_repo'])>0)?$_GET['$campus_repo']:'';
              $usuario = (strlen($_GET['$usuario'])>0)?$_GET['$usuario']:'';

                 GetCentro($jefe_centro','$campus_repo','$usuario);     
                # code...
                break;

               
                case 'list12'
              $idsv_buscado = (strlen($_GET['$idsv_buscado'])>0)?$_GET['$idsv_buscado']:'';
              $nom_buscado = (strlen($_GET['$nom_buscado'])>0)?$_GET['$nom_buscado']:'';
              $apes_buscado = (strlen($_GET['$apes_buscado'])>0)?$_GET['$apes_buscado']:'';
              $email = (strlen($_GET['$email'])>0)?$_GET['$email']:'';
              $campus = (strlen($_GET['$campus'])>0)?$_GET['$campus']:'';
              $nombre_centro = (strlen($_GET['$nombre_centro'])>0)?$_GET['$nombre_centro']:'';
              $pidm_buscado = (strlen($_GET['pidm_buscado'])>0)?$_GET['$pidm_buscado']:'';
              $tipo_user = (strlen($_GET['$tipo_user'])>0)?$_GET['$tipo_user']:'';
              $publicor = (strlen($_GET['$publico'])>0)?$_GET['$publico']:'';
              $dni_buscado = (strlen($_GET['$dni_buscado'])>0)?$_GET['$dni_buscado']:'';
                
               GetUser($idsv_buscado,$nom_buscado,$apes_buscado,$email,$campus,$nombre_centro,$pidm_buscado,$tipo_user,$publico,$dni_buscado);     
                # code...
                break;


              case 'list13'
              $jefe_centro = (strlen($_GET['$jefe_centro'])>0)?$_GET['$jefe_centro']:'';
              $campus_repo = (strlen($_GET['$campus_repo'])>0)?$_GET['$campus_repo']:'';
              $usuario = (strlen($_GET['$usuario'])>0)?$_GET['$usuario']:'';
              
                
               GetCentros($jefe_centro,$campus_repo,$usuario);     
                # code...
                break;


              case 'list14'
              $id = (strlen($_GET['$id'])>0)?$_GET['$id']:'';
              $id_alumno = (strlen($_GET['$id_alumno'])>0)?$_GET['$id_alumno']:'';
              $courseid = (strlen($_GET['$courseid'])>0)?$_GET['$courseid']:'';
              $timestart = (strlen($_GET['$timestart'])>0)?$_GET['$timestart']:'';
              $time = (strlen($_GET['$time'])>0)?$_GET['$time']:'';
              $timeaccess = (strlen($_GET['$timeaccess'])>0)?$_GET['$timeaccess']:'';
              $enrol = (strlen($_GET['$enrol'])>0)?$_GET['$enrol']:'';
              $nrc = (strlen($_GET['$nrc'])>0)?$_GET['$nrc']:'';
              $periodo = (strlen($_GET['$periodo'])>0)?$_GET['$periodo']:'';
              $camp = (strlen($_GET['$camp'])>0)?$_GET['$camp']:'';
              $bloque = (strlen($_GET['$bloque'])>0)?$_GET['$bloque']:'';
              $carr = (strlen($_GET['$carr'])>0)?$_GET['$carr']:'';
              $pidm = (strlen($_GET['$pidm'])>0)?$_GET['$ppidm']:'';
              $semestre = (strlen($_GET['$semestre'])>0)?$_GET['$semestre']:'';
              $status_sinfo = (strlen($_GET['$status_sinfo'])>0)?$_GET['$status_sinfo']:'';
              $fullname = (strlen($_GET['$fullname'])>0)?$_GET['$fullname']:'';
              $nota = (strlen($_GET['$nota'])>0)?$_GET['$nota']:'';
              $estado = (strlen($_GET['$estado'])>0)?$_GET['$estado']:'';
              
              
                
              GetEstudiante($id,$id_alumno,$courseid,$timestart,$timeend,$time,$timeaccess,$enrol,$nrc,$periodo,$camp,$bloque,$carr,$pidm,$semestre,$status_sinfo,$fullname,$nota,$estado);     
                # code...
                break;


                
              case 'list15'
              $lastname = (strlen($_GET['$lastname'])>0)?$_GET['$lastname']:'';
              $firstname = (strlen($_GET['$firstname'])>0)?$_GET['$firstname']:'';
              $email = (strlen($_GET['$email'])>0)?$_GET['$email']:'';
              $nombre_centro = (strlen($_GET['$nombre_centro'])>0)?$_GET['$nombre_centro']:'';
              $campus = (strlen($_GET['$campus'])>0)?$_GET['$campus']:'';
              $pidm_banner = (strlen($_GET['$pidm_banner'])>0)?$_GET['$pidm_banner']:'';
              $id_alumno = (strlen($_GET['$id_alumno'])>0)?$_GET['$id_alumno']:'';
              
              
                
              
                GetUsers($lastname,$firstname,$email,$nombre_centro,$campus,$pidm_banner,$id_alumno);     
                # code...
                break;






    }
                           
    
?>  