<?php

include '../BD/conexion.php';

 	function GetMatriculados($id_matricula){               
		$con = new Conexion();
		$ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_R_P_ELIMINA_ESTUDIANTES_MATRICULADOS
 		('$id_matricula');") or die("Query fail: " . mysqli_error());
		$data = [];
			if (mysqli_num_rows($result)>0){
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                               	
                                
							   ));
                  }    
            }
               echo json_encode($data);
	}


    function GetActa($existe_acta,$id_curso_moodle){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_R_P_EXISTE_ACTA
    ('$existe_acta','$id_curso_moodle');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'existe_acta'=> $row[0]                   
                 ));
                  }    
            }
               echo json_encode($data);
  }



       function GetCampus($fullname,$presencial_de,$id_curso_moodle){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_R_P_LISTA_CURSO_PRESENCIAL_CAMPUS
    ('$fullname','$presencial_de','$id_curso_moodle');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'fullname'=> $row[0],
                                'presencial_de'=> $row[1]                     
                 ));
                  }    
            }
               echo json_encode($data);
  }



 function GetEstudiante($id,$id_alumno,$courseid,$timestart,$timeend,$time,$timeaccess,$enrol,$nrc,$periodo,$camp,$bloque,$carr,$pidm,$semestre,$status_sinfo,$fullname,$nota,$estado,$id,$category,$sortorde,$password,$fullname,$shortname,$idnumber,$summary,$format,$showgrades,$modiinfo,$newsitems,$teacher,$student,$students,$guest,$startdate,$enrolperiod,$numsection,$marker,$maxbytes,$showreports,$visible,$hiddensections,$groupmode,$groupmodeforce,$lang,$theme,$cost,$currency,$timecreated,$timemodified,$metacourse,$requested,$restrictmodules,$expirynotify,$,$expirythreshold,$notifystudents,$enrollable,$enrolsstartdate,$enrolenddate,$enrol,$para_desa,$periodo,$patron,$id_senati_curso,$id_publico,$subsanacion,$induccion,$presencial,$grupo,$presencial_de,$subsanacion_de,$camp_pres,$siglas,$id_tarea1_pres,$id_tarea2_pres,$id_patron_semilla,$materia_sinfo,$curso_sinfo,$id_tarea_induccion,$font_titulo_certi,$header_certi,$titulo_certificado,$id,$auth,$confirmed,$policyagreed,$deleted,$username,$password,$idnumber,$firstname,$lastname,$email,$emailstop,$icq,$yahoo,$aim,$aim,$phone1,$phone2,$institution,$department,$address,$city,$country,$lang,$timezone,$firstaccess,$lastlogin,$currentlogin,$lastip,$secret,$picture,$url,$description,$mailformat,$maildigest,$maildisplay,$htmleditor,$autosubscribe,$trackforums,$timemodified,$pidm_banner,$campus,$pidm_ok,$carr,$tipo_user,$orden,$induccion,$activex,$aws,$dni,$jefe_centro,$campus_repo,$user_senatipe,$ustream_embed,$usuario_eti,$carre,$id_matricula){               
    $con = new Conexion();
    $ca=$con->initConnection();
    $result = mysqli_query($ca, "call SP_LISTAR_LEFT_USER
    ('$id','$id_alumno','$courseid','$timestart','$timeend','$time','$timeaccess','$enrol','$nrc','$periodo','$camp','$bloque','$carr','$pidm','$semestre','$status_sinfo','$fullname','$nota','$estado','$id','$category','$sortorde','$password','$fullname','$shortname','$idnumber','summary','$format','$showgrades','$modiinfo','$newsitems','$teacher','$student','$students','$guest','$startdate','$enrolperiod','$numsection','$marker','$maxbytes','$showreports','$visible','$hiddensections','$groupmode','$groupmodeforce','$lang','$theme','$cost','$currency','$timecreated','$timemodified','$metacourse','$requested','$restrictmodules','$expirynotify','$expirythreshold','$notifystudents','$enrollable','$enrolsstartdate','$enrolenddate','$enrol','$para_desa','$periodo','$patron','$id_senati_curso','$id_publico','$subsanacion','$induccion','$presencial','$grupo','$presencial_de','$subsanacion_de','$camp_pres','$siglas','$id_tarea1_pres','$id_tarea2_pres','$id_patron_semilla','$materia_sinfo','$curso_sinfo','$id_tarea_induccion','$font_titulo_certi','$header_certi','$titulo_certificado','$id,$auth','$confirmed','$policyagreed','$deleted','$username','$password','$idnumber','$firstname','$lastname','$email','$emailstop','$icq,$yahoo','$aim','$phone1','$phone2','$institution','$department','$address','$city','$country','$lang','$timezone','$firstaccess','$lastlogin','$currentlogin','$lastip','$secret','$picture','$url','$description','$mailformat','$maildigest','$maildisplay','$htmleditor','$autosubscribe','$trackforums','$timemodified','$pidm_banner','$campus','$pidm_ok','$carr','$tipo_user','$orden','$induccion','$activex','$aws','$dni','$jefe_centro','$campus_repo','$user_senatipe','$ustream_embed','$usuario_eti','$carre','$id_matricula');") or die("Query fail: " . mysqli_error());
    $data = [];
      if (mysqli_num_rows($result)>0){
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                               array_push($data,array(
                                'id'=> $row[0],
                                'userid'=> $row[1],
                                'courseid'=> $row[2],
                                'timestart'=> $row[3],
                                'timeend'=> $row[4],
                                'time'=> $row[5],
                                'timeaccess'=> $row[6],
                                'enrol'=> $row[7],
                                'nrc'=> $row[8],
                                'periodo'=> $row[9],
                                'camp'=> $row[10],
                                'bloque'=> $row[11],
                                'carr'=> $row[12],
                                'pidm'=> $row[13],
                                'semestre'=> $row[14],
                                'status_sinfo'=> $row[15],
                                'fullname'=> $row[16],
                                'nota'=> $row[17],
                                'id'=> $row[18],
                                'category'=> $row[19],
                                'sortorde'=> $row[20],
                                'password'=> $row[21],
                                'idnumber'=> $row[22],
                                'summary'=> $row[23],
                                'format'=> $row[24],
                                'showgrades'=> $row[25],
                                'modiinfo'=> $row[26],
                                'newsitems'=> $row[27],
                                'teacher'=> $row[28],
                                'student'=> $row[29],
                                'students'=> $row[30],
                                'guest'=> $row[31],
                                'startdate'=> $row[32],
                                'enrolperiod'=> $row[33],
                                'numsection'=> $row[34],
                                'marker'=> $row[35],
                                'maxbytes'=> $row[36],
                                'showreports'=> $row[37],
                                'visible'=> $row[38],
                                'hiddensections'=> $row[39],
                                'groupmode'=> $row[40],
                                'groupmodeforce'=> $row[41],
                                'lang'=> $row[42],
                                'theme'=> $row[43],
                                'cost'=> $row[44],
                                'currency'=> $row[45],
                                'timecreated'=> $row[46],
                                'timemodified'=> $row[47],
                                'metacourse'=> $row[48],
                                'requested'=> $row[49],
                                'restrictmodules'=> $row[50],
                                'expirynotify'=> $row[51],
                                'expirythreshold'=> $row[52],
                                'notifystudents'=> $row[53],
                                'enrollable'=> $row[54],
                                'enrolsstartdate'=> $row[55],
                                'enrolenddate'=> $row[56],
                                'enrol'=> $row[57],
                                'para_desa'=> $row[58],
                                'periodo'=> $row[59],
                                'id_senati_curso'=> $row[60],
                                'id_publico'=> $row[61],
                                'subsanacion'=> $row[62],
                                'induccion'=> $row[63],
                                'presencial'=> $row[64],
                                'grupo'=> $row[65],
                                'presencial_de'=> $row[66],
                                'subsanacion_de '=> $row[67],
                                'camp_pres'=> $row[68],
                                'siglas'=> $row[69],
                                'id_tarea1_pres'=> $row[70],
                                'id_tarea2_pres'=> $row[71],
                                'id_patron_semilla'=> $row[72],
                                'materia_sinfo'=> $row[73],
                                'curso_sinfo'=> $row[74],
                                'id_tarea_induccion'=> $row[75],
                                'font_titulo_certi'=> $row[76],
                                'header_certi'=> $row[77],
                                'titulo_certificado'=> $row[78],
                                'id'=> $row[79],
                                'auth'=> $row[80],
                                'confirmed'=> $row[81],
                                'policyagreed'=> $row[82],
                                'deleted'=> $row[83],
                                'username'=> $row[84],
                                'password'=> $row[85],
                                'idnumber'=> $row[86],
                                'firstname'=> $row[87],
                                'lastname'=> $row[88],
                                'email'=> $row[89],
                                'emailstop'=> $row[90],
                                'icq'=> $row[91],
                                'skype'=> $row[92],
                                'yahoo'=> $row[93],
                                'aim'=> $row[94],
                                'msn'=> $row[95],
                                'phone1'=> $row[96],
                                'phone2'=> $row[97],
                                'institution'=> $row[98],
                                'department'=> $row[99],
                                'address'=> $row[100],
                                'city'=> $row[101],
                                'country'=> $row[102],
                                'lang'=> $row[103],
                                'timezone'=> $row[104],
                                'firstaccess'=> $row[105],
                                'lastlogin'=> $row[106],
                                'currentlogin'=> $row[107],
                                'lastip'=> $row[108],
                                'secret'=> $row[109],
                                'picture'=> $row[110],
                                'url'=> $row[111],
                                'description'=> $row[112],
                                'mailformat'=> $row[113],
                                'maildigest'=> $row[114],
                                'maildisplay'=> $row[115],
                                'htmleditor'=> $row[116],
                                'autosubscribe'=> $row[117],
                                'trackforums'=> $row[118],
                                'timemodified'=> $row[119],
                                'pidm_banner'=> $row[120],
                                'campus'=> $row[121],
                                'pidm_ok'=> $row[122],
                                'carr'=> $row[123],
                                'tipo_user'=> $row[124],
                                'orden'=> $row[125],
                                'induccion'=> $row[126],
                                'activex'=> $row[127],
                                'aws'=> $row[128],
                                'dni'=> $row[129],
                                'jefe_centro'=> $row[130],
                                'campus_repo'=> $row[131],
                                'user_senatipe'=> $row[132],
                                'ustream_embed'=> $row[133],
                                'usuario_eti'=> $row[134],
                                'carre'=> $row[135],
                                'id_matricula'=> $row[136]


                 ));
                  }    
            }
               echo json_encode($data);
  }



   $action = (strlen($_GET['action'])>0)?$_GET['action']:'';

            switch ($action) {
              case 'list1':
              $id_matricula = (strlen($_GET['id_matricula'])>0)?$_GET['id_matricula']:'';
                   
              GetMatriculados($id_matricula);         
                # code...
                break;

              case 'list2':
              $existe_acta= (strlen($_GET['existe_acta'])>0)?$_GET['existe_acta']:'';
              $id_curso_moodle= (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:'';
                   
              GetActa($existe_acta,$id_curso_moodle);         
                # code...
                break;


              case 'list3':
              $fullname = (strlen($_GET['fullname'])>0)?$_GET['fullname']:'';
              $presencial_de = (strlen($_GET['subsanacion_de'])>0)?$_GET['subsanacion_de']:'';
              $id_curso_moodle= (strlen($_GET['id_curso_moodle'])>0)?$_GET['id_curso_moodle']:'';
                   
              GetCurso($fullname,$presencial_de,$id_curso_moodle);         
                # code...
                break;


                
              
             case 'list4'
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
              $id = (strlen($_GET['$id'])>0)?$_GET['$id']:'';
              $category = (strlen($_GET['$category'])>0)?$_GET['$category']:'';
              $sortorde = (strlen($_GET['$sortorde'])>0)?$_GET['$sortorde']:'';
              $password = (strlen($_GET['$password'])>0)?$_GET['$password']:'';
              $fullname = (strlen($_GET['$fullname'])>0)?$_GET['$fullname']:'';
              $shortname = (strlen($_GET['$shortname'])>0)?$_GET['$shortname']:'';
              $idnumber = (strlen($_GET['$idnumber'])>0)?$_GET['$idnumber']:'';
              $summary = (strlen($_GET['$summary'])>0)?$_GET['$summary']:'';
              $format = (strlen($_GET['$format'])>0)?$_GET['$format']:'';
              $showgrades = (strlen($_GET['$showgrades'])>0)?$_GET['$showgrades']:'';
              $modiinfo = (strlen($_GET['$modiinfo'])>0)?$_GET['$modiinfo']:'';
              $newsitems = (strlen($_GET['$newsitems'])>0)?$_GET['$newsitems']:'';
              $teacher = (strlen($_GET['$teacher'])>0)?$_GET['$teacher']:'';
              $student = (strlen($_GET['$student'])>0)?$_GET['$student']:'';
              $students = (strlen($_GET['$students'])>0)?$_GET['$students']:'';
              $guest = (strlen($_GET['$guest'])>0)?$_GET['$guest']:'';
              $startdate = (strlen($_GET['$startdate'])>0)?$_GET['$startdate']:'';
              $enrolperiod = (strlen($_GET['$enrolperiod'])>0)?$_GET['$enrolperiod']:'';
              $numsection = (strlen($_GET['$numsection'])>0)?$_GET['$numsection']:'';
              $marker = (strlen($_GET['$marker'])>0)?$_GET['$marker']:'';
              $maxbytes = (strlen($_GET['$maxbytes'])>0)?$_GET['$maxbytes']:'';
              $showreports = (strlen($_GET['$showreports'])>0)?$_GET['$showreports']:'';
              $visible = (strlen($_GET['$visible'])>0)?$_GET['$visible']:'';
              $hiddensections = (strlen($_GET['$hiddensections'])>0)?$_GET['$hiddensections']:'';
              $groupmode = (strlen($_GET['$groupmode'])>0)?$_GET['$groupmode']:'';
              $groupmodeforce = (strlen($_GET['$groupmodeforce'])>0)?$_GET['$groupmodeforce']:'';
              $lang = (strlen($_GET['$lang'])>0)?$_GET['$lang']:'';
              $theme = (strlen($_GET['$theme'])>0)?$_GET['$theme']:'';
              $cost = (strlen($_GET['$cost'])>0)?$_GET['$cost']:'';
              $currency = (strlen($_GET['$currency'])>0)?$_GET['$currency']:'';
              $timecreated = (strlen($_GET['$timecreated'])>0)?$_GET['$timecreated']:'';
              $timemodified = (strlen($_GET['$timemodified'])>0)?$_GET['$timemodified']:'';
              $metacourse = (strlen($_GET['$metacourse'])>0)?$_GET['$metacourse']:'';
              $restrictmodules = (strlen($_GET['$restrictmodules'])>0)?$_GET['$restrictmodules']:'';
              $expirynotify = (strlen($_GET['$expirynotify'])>0)?$_GET['$expirynotify']:'';
              $expirythreshold = (strlen($_GET['$expirythreshold'])>0)?$_GET['$expirythreshold']:'';
              $notifystudents = (strlen($_GET['$notifystudents'])>0)?$_GET['$notifystudents']:'';
              $enrollable = (strlen($_GET['$enrollable'])>0)?$_GET['$enrollable']:'';
              $enrolsstartdate = (strlen($_GET['$enrolsstartdate'])>0)?$_GET['$enrolsstartdate']:'';
              $enrolenddate = (strlen($_GET['$enrolenddate'])>0)?$_GET['$enrolenddate']:'';
              $enrol = (strlen($_GET['$enrol'])>0)?$_GET['$enrol']:'';
              $para_desa = (strlen($_GET['$para_desa'])>0)?$_GET['$para_desa']:'';
              $periodo = (strlen($_GET['$periodo'])>0)?$_GET['$periodo']:'';
              $patron = (strlen($_GET['$patron'])>0)?$_GET['$patron']:'';
              $id_senati_curso = (strlen($_GET['$id_senati_curso'])>0)?$_GET['$id_senati_curso']:'';
              $id_publico = (strlen($_GET['$id_publico'])>0)?$_GET['$id_publico']:'';
              $subsanacion = (strlen($_GET['$subsanacion'])>0)?$_GET['$subsanacion']:'';
              $induccion = (strlen($_GET['$induccion'])>0)?$_GET['$induccion']:'';
              $presencial = (strlen($_GET['$presencial'])>0)?$_GET['$presencial']:'';
              $grupo = (strlen($_GET['$grupo'])>0)?$_GET['$grupo']:'';
              $presencial_de = (strlen($_GET['$presencial_de'])>0)?$_GET['$presencial_de']:'';
              $subsanacion_de = (strlen($_GET['$subsanacion_de'])>0)?$_GET['$subsanacion_de']:'';
              $camp_pres = (strlen($_GET['$camp_pres'])>0)?$_GET['$camp_pres']:'';
              $siglas = (strlen($_GET['$siglas'])>0)?$_GET['$siglas']:'';
              $id_tarea1_pres = (strlen($_GET['$id_tarea1_pres'])>0)?$_GET['$id_tarea1_pres']:'';
              $id_tarea2_pres = (strlen($_GET['$id_tarea2_pres'])>0)?$_GET['$id_tarea2_pres']:'';
              $id_patron_semilla = (strlen($_GET['$id_patron_semilla'])>0)?$_GET['$id_patron_semilla']:'';
              $id_tarea1_pres = (strlen($_GET['$id_tarea1_pres'])>0)?$_GET['$id_tarea1_pres']:'';
              $id_tarea2_pres = (strlen($_GET['$id_tarea2_pres'])>0)?$_GET['$id_tarea2_pres']:'';
              $id_patron_semilla = (strlen($_GET['$id_patron_semilla'])>0)?$_GET['$id_patron_semilla']:'';
              $materia_sinfo = (strlen($_GET['$materia_sinfo'])>0)?$_GET['$materia_sinfo']:'';
              $curso_sinfo = (strlen($_GET['$curso_sinfo'])>0)?$_GET['$curso_sinfo']:'';
              $id_tarea_induccion = (strlen($_GET['$id_tarea_induccion'])>0)?$_GET['$id_tarea_induccion']:'';
              $font_titulo_certi = (strlen($_GET['$font_titulo_certi'])>0)?$_GET['$font_titulo_certi']:'';
              $header_certi = (strlen($_GET['$header_certi'])>0)?$_GET['$header_certi']:'';
              $titulo_certificado = (strlen($_GET['$titulo_certificado'])>0)?$_GET['$titulo_certificado']:'';
              $id = (strlen($_GET['$id'])>0)?$_GET['$id']:'';
              $auth = (strlen($_GET['$auth'])>0)?$_GET['$auth']:'';
              $confirmed = (strlen($_GET['$confirmed'])>0)?$_GET['$confirmed']:'';
              $policyagreed = (strlen($_GET['$policyagreed'])>0)?$_GET['$policyagreed']:'';
              $deleted = (strlen($_GET['$deleted'])>0)?$_GET['$deleted']:'';
              $username = (strlen($_GET['$username'])>0)?$_GET['$username']:'';
              $password = (strlen($_GET['$password'])>0)?$_GET['$password']:'';
              $idnumber = (strlen($_GET['$idnumber'])>0)?$_GET['$idnumber']:'';
              $firstname = (strlen($_GET['$firstname'])>0)?$_GET['$firstname']:'';
              $lastname = (strlen($_GET['$lastname'])>0)?$_GET['$lastname']:'';
              $email = (strlen($_GET['$email'])>0)?$_GET['$email']:'';
              $emailstop = (strlen($_GET['$emailstop'])>0)?$_GET['$emailstop']:'';
              $icq = (strlen($_GET['$icq'])>0)?$_GET['$icq']:'';
              $skype = (strlen($_GET['$skype'])>0)?$_GET['$skype']:'';
              $yahoo = (strlen($_GET['$yahoo'])>0)?$_GET['$yahoo']:'';
              $aim = (strlen($_GET['$aim'])>0)?$_GET['$aim']:'';
              $msn = (strlen($_GET['$msn'])>0)?$_GET['$msn']:'';
              $phone1 = (strlen($_GET['$phone1'])>0)?$_GET['$phone1']:'';
              $phone2 = (strlen($_GET['$phone2'])>0)?$_GET['$phone2']:'';
              $institution = (strlen($_GET['$institution'])>0)?$_GET['$institution']:'';
              $department = (strlen($_GET['$department'])>0)?$_GET['$department']:'';
              $address = (strlen($_GET['$address'])>0)?$_GET['$address']:'';
              $city = (strlen($_GET['$city'])>0)?$_GET['$city']:'';
              $country = (strlen($_GET['$country'])>0)?$_GET['$country']:'';
              $lang  = (strlen($_GET['$lang'])>0)?$_GET['$lang']:'';
              $timezone = (strlen($_GET['$timezone'])>0)?$_GET['$confirmed']:'';
              $firstaccess = (strlen($_GET['$firstaccess'])>0)?$_GET['$firstaccess']:'';
              $lastlogin = (strlen($_GET['$lastlogin'])>0)?$_GET['$lastlogin']:'';
              $currentlogin = (strlen($_GET['$currentlogin'])>0)?$_GET['$currentlogin']:'';
              $lastip = (strlen($_GET['$lastip'])>0)?$_GET['$lastip']:'';
              $secret = (strlen($_GET['$secret'])>0)?$_GET['$secret']:'';
              $picture = (strlen($_GET['$picture'])>0)?$_GET['$picture']:'';
              $url = (strlen($_GET['$url'])>0)?$_GET['$url']:'';
              $description = (strlen($_GET['$description'])>0)?$_GET['$description']:'';
              $mailformat = (strlen($_GET['$mailformat'])>0)?$_GET['$mailformat']:'';
              $maildigest = (strlen($_GET['$maildigest'])>0)?$_GET['$maildigest']:'';
              $maildisplay = (strlen($_GET['$maildisplay'])>0)?$_GET['$maildisplay']:'';
              $htmleditor = (strlen($_GET['$htmleditor'])>0)?$_GET['$htmleditor']:'';
              $autosubscribe = (strlen($_GET['$autosubscribe'])>0)?$_GET['$autosubscribe']:'';
              $trackforums = (strlen($_GET['$trackforums'])>0)?$_GET['$trackforums']:'';
              $timemodified = (strlen($_GET['$timemodified'])>0)?$_GET['$timemodified']:'';
              $pidm_banner = (strlen($_GET['$pidm_banner'])>0)?$_GET['$pidm_banner']:'';
              $campus = (strlen($_GET['$campus'])>0)?$_GET['$campus']:'';
              $pidm_ok = (strlen($_GET['$pidm_ok'])>0)?$_GET['$pidm_ok']:'';
              $carr = (strlen($_GET['$carr'])>0)?$_GET['$carr']:'';
              $tipo_user = (strlen($_GET['$tipo_user'])>0)?$_GET['$pidm_ok']:'';
              $orden = (strlen($_GET['$orden'])>0)?$_GET['$orden']:'';
              $induccion = (strlen($_GET['$induccion'])>0)?$_GET['$induccion']:'';
              $activex = (strlen($_GET['$activex'])>0)?$_GET['$activex']:'';
              $aws = (strlen($_GET['$aws'])>0)?$_GET['$aws']:'';
              $dni = (strlen($_GET['$dni'])>0)?$_GET['$dni']:'';
              $jefe_centro = (strlen($_GET['$jefe_centro'])>0)?$_GET['$jefe_centro']:'';
              $campus_repo = (strlen($_GET['$campus_repo'])>0)?$_GET['$campus_repo']:'';
              $user_senatipe = (strlen($_GET['$user_senatipe'])>0)?$_GET['$user_senatipe']:'';
              $ustream_embed = (strlen($_GET['$ustream_embed'])>0)?$_GET['$ustream_embed']:'';
              $usuario_eti = (strlen($_GET['$usuario_eti'])>0)?$_GET['$usuario_eti']:'';
              $carre = (strlen($_GET['$carre'])>0)?$_GET['$carre']:'';
              $id_matricula = (strlen($_GET['$id_matricula'])>0)?$_GET['$id_matricula']:'';

                   
              GetEstudiante($id,$id_alumno,$courseid,$timestart,$timeend,$time,$timeaccess,$enrol,$nrc,$periodo,$camp,$bloque,$carr,$pidm,$semestre,$status_sinfo,$fullname,$nota,$estado,$id,$category,$sortorde,$password,$fullname,$shortname,$idnumber,$summary,$format,$showgrades,$modiinfo,$newsitems,$teacher,$student,$students,$guest,$startdate,$enrolperiod,$numsection,$marker,$maxbytes,$showreports,$visible,$hiddensections,$groupmode,$groupmodeforce,$lang,$theme,$cost,$currency,$timecreated,$timemodified,$metacourse,$requested,$restrictmodules,$expirynotify,$,$expirythreshold,$notifystudents,$enrollable,$enrolsstartdate,$enrolenddate,$enrol,$para_desa,$periodo,$patron,$id_senati_curso,$id_publico,$subsanacion,$induccion,$presencial,$grupo,$presencial_de,$subsanacion_de,$camp_pres,$siglas,$id_tarea1_pres,$id_tarea2_pres,$id_patron_semilla,$materia_sinfo,$curso_sinfo,$id_tarea_induccion,$font_titulo_certi,$header_certi,$titulo_certificado,$id,$auth,$confirmed,$policyagreed,$deleted,$username,$password,$idnumber,$firstname,$lastname,$email,$emailstop,$icq,$yahoo,$aim,$aim,$phone1,$phone2,$institution,$department,$address,$city,$country,$lang,$timezone,$firstaccess,$lastlogin,$currentlogin,$lastip,$secret,$picture,$url,$description,$mailformat,$maildigest,$maildisplay,$htmleditor,$autosubscribe,$trackforums,$timemodified,$pidm_banner,$campus,$pidm_ok,$carr,$tipo_user,$orden,$induccion,$activex,$aws,$dni,$jefe_centro,$campus_repo,$user_senatipe,$ustream_embed,$usuario_eti,$carre,$id_matricula);         
                # code...
                break;







    }
                           
    
?>  