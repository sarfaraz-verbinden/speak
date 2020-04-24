<?php 
	error_reporting(0);
	session_start();
	ini_set('max_execution_time', 0);
	include('common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();

	//Site Details 
	$site_details = '';
	$query_site_details = mysqli_query($connect, "SELECT * FROM site_details");
	while($row = mysqli_fetch_array($query_site_details)){
		$site_details .= $row['value'].'~';
	}

	$site_details_exp = explode("~", $site_details);
	$site_name = $site_details_exp[0]='Meylah Labs';
	$_SESSION['site_url'] = $site_url = $site_details_exp[1];
	
	$logo = $site_details_exp[2];
	$logo_small = $site_details_exp[3];
	$favicon = $site_details_exp[4];
	$apply_to_speak_url = $site_details_exp[5];

	//**********************************************************************//	

	


function admin_way_top(){
	$connect = $GLOBALS['connect'];
	$common = $GLOBALS['common'];
	$site_name = $GLOBALS['site_name'];
	$favicon = $GLOBALS['favicon'];
	error_reporting(0);
	if(!$common->CheckLogin())
	{
		$common->RedirectToURL("login.php");
		exit;
	}
	echo '<!DOCTYPE html>
	<html>
	<head>
	  <meta charset="utf-8"> 
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>Speaker Engage | Admin Portal</title>
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <!-- App Favicon -->
		<link rel="shortcut icon" href="images/favicon.ico">

		<!-- App Title -->
		<title>'.$site_name.' | Admin Portal</title>
	  <!-- Bootstrap 3.3.7 -->
	  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	 
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	  <!-- Ionicons -->
	  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	  <!-- DataTables -->
      <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	  <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />		
	  <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	  <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" />
	  <!-- Theme style -->
	  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	  <!-- AdminLTE Skins. Choose a skin from the css/skins
		   folder instead of downloading all of them to reduce the load. -->
	  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	  <!-- Morris chart -->
	  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
	  
	  <!-- Date Picker -->
	  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	  <!-- Daterange picker -->
	  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
	  

	  <!-- Google Font -->
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	  
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  
	  

	  <style>
	  .modal img#banner_image {
    max-width: 615px;
}
    .wrapper {
      overflow: hidden !important;
    }
	  @media (min-width: 768px){
	  .modal-content{ margin-top: 30px !important;width: 50% !important;margin: 0 auto !important; }
	  .custom-modal-text {padding:15px !important;}
	  }
	   .cropme img{ width:600px !important; }
	    .multiselect.dropdown-toggle.btn.btn-default{
			  text-align:left;
		  }
		  .btn-group .caret{
			  float: right;
    margin-top: 8px;
		  }
		  .mce-content-body a[href]{color:blue !important;}
		  .alert-cust{
			  background-color: #fcf8e3  !important;
				border-color: #faebcc  !important;
				    color: black !important;
		  }
		  .manage_users{
		  	min-width: 120px;
		  	width: 120px !important;
		  }
		  .navbar-custom-menu .fa-angle-down{
		  	padding-top:4px;
		  }
		  .help.dropdown-menu{background:rgba(0,0,0,0.8)}
		  .help.dropdown-menu>li>a{color:#fff !important; text-align:center; font-size:16px;font-family: segoeuisemb;}
		  .help.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .help.dropdown-menu>.active>a:hover{
		  	background:none !important; 
		  }
		  .help.dropdown-menu li{padding:0 25px; margin-bottom:15px;}
		  .navbar-custom-menu>.navbar-nav>li>.help.dropdown-menu{    border-radius: 0;}
		  .help.dropdown-menu>li>a:hover{background:none !important;border-bottom:solid 4px #0f85bb; }
	  </style>

	  <!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151981830-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag("js", new Date());

		  gtag("config", "UA-151981830-1");
		</script>
	</head>
';
}

	/*$id_user=$common->idUser();
	$fetch_user_details = mysqli_query($connect,"SELECT * FROM all_users WHERE user_id=".$id_user);
	$row_usr = mysqli_fetch_array($fetch_user_details);		
	$tanent_id_usr = $row_usr['tanent_id'];
	$subscription_id_usr = $row_usr['subscription_id'];
	$customer_id_usr = $row_usr['customer_id'];

	$check_tenant_subs = mysqli_query($connect,"SELECT * FROM `all_tenants` WHERE `id` = '".$tanent_id_usr."' ");
	$res_ten = mysqli_fetch_array($check_tenant_subs);
	$tenant_created_at = date('Y-m-d',strtotime($res_ten['created_at']));


	if(date("Y-m-d") - $tenant_created_at > 30){
		header("location:choose-package.php");
	}*/

function admin_top_bar($event_id=null){
	
	include('mysqli_connect.php');
	$logo_small = $GLOBALS['logo_small'];
	$common = $GLOBALS['common'];
	$current_url = $_SERVER['REQUEST_URI'];
	$id_user=$common->idUser();
	$profile_pic = "";
	
	$sql = mysqli_query($connect,"SELECT * FROM all_users WHERE user_id=".$id_user);
	$row = mysqli_fetch_array($sql);
		$profile_pic = $row['profile_pic'];
		$name = $row['first_name'];
		$role_name = $row['role'];
		$tanent_id_f= $row['tanent_id'];
		$subscription_id_f= $row['subscription_id'];
		$customer_id_f = $row['customer_id'];
		$registered_at_f = $row['registered_date'];
		//*****************************************************//
		 $reg_date = date_create($registered_at_f); 
		 $today_date = date_create(date('Y-m-d', time()));
		$diff=date_diff($reg_date,$today_date);
 		$day_diff = $diff->format("%a");
 		$days_left = (100-$day_diff);
 		//var_dump($subscription_id_f); exit();
 		if($days_left >= 0 && $subscription_id_f == ''){
 			$upgrade_btn = '<a href="plan-and-billing-info.php" style="background:#007DB7 !important;padding-top: 5px;padding-bottom: 5px;margin-top: 10px;" class="upgradebtn"><img src="images/icons/upgrade-icon.svg" class="img-responsive" style="float:left;margin-right: 8px;height: 16px;margin-top: 3px;">'.$days_left .' <span>days to Upgrade</span></a>';
 		}else{
 			//$upgrade_btn = '<a href="plan-and-billing-info.php" style="background:#007DB7 !important;padding-top: 5px;padding-bottom: 5px;margin-top: 10px;"><img src="images/icons/upgrade-icon.svg" class="img-responsive" style="float:left;margin-right: 8px;height: 16px;margin-top: 3px;">Upgrade</a>';

 		}


	

	if(empty($profile_pic)){
		$profile_pic = "user-default-icon.jpg";
	}
	$manage_user_menu = '';
	//var_dump($role_name); exit();
	

	if(strtolower($role_name) == 'admin'){
			$manage_user_menu = '<ul class="nav navbar-nav">
			 
          
          <!-- User Account: style can be found in dropdown.less -->
           <li class="dropdown user user-menu" style="">
            '.$upgrade_btn.'            
          </li>
          <li class="dropdown">
   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" ><img src="images/help.svg" /></a>
    <ul class="help dropdown-menu" role="menu">
       <li><a href="request-demo.php" >Request Demo</a></li>
       <li><a href="speaker-engage-tutorial.php" >Tutorials</a></li>
       <li><a href="../faqs/" target="_blank">FAQs</a></li>
    </ul>
</li>
          <li class="dropdown user user-menu">
            <a href="admin-user-management.php" class="myaccbtn" style="border-right: 1px solid rgba(255, 255, 255, 0.42);border-left: 1px solid rgba(255, 255, 255, 0.42);padding-top: 5px;padding-bottom: 5px;margin-top: 10px;"><img src="images/multiple-users-icon.svg" class="img-responsive" style="float:left;margin-right: 8px;height: 16px;margin-top: 3px;">My Account</a>
            
          </li>
          
        </ul>';

	}else{

		$manage_user_menu = '<ul class="nav navbar-nav">         
          <!-- User Account: style can be found in dropdown.less -->        
          <li class="dropdown">
		   <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" ><img src="images/help.svg" /></a>
		    <ul class="help dropdown-menu" role="menu">
		       <li><a href="request-demo.php">Request Demo</a></li>
		       <li><a href="speaker-engage-tutorial.php">Tutorials</a></li>
		       <li><a href="../faqs/">FAQs</a></li>
		    </ul>
		</li>
          
        </ul>';


	}
	
	 $event_sql = mysqli_query($connect,"SELECT event_name,tanent_id FROM all_events WHERE id=".$event_id);
	 $event_row = mysqli_fetch_array($event_sql);
	 $event_name = $event_row['event_name'];
	 $tenant_id = $event_row['tanent_id'];
	  if( strlen($event_name ) > 30 ) 
	  {
	    $event_name = substr($event_row['event_name'], 0, 30 ) . '...';
	  }

	  $fetch_tenant = mysqli_query($connect,"SELECT tenant_name FROM `all_tenants` WHERE `id` = '".$tenant_id."' ");
	  $res_tenant = mysqli_fetch_array($fetch_tenant);
	  $tenant_name = ucfirst($res_tenant['tenant_name']);

	   $fetch_tenant_new = mysqli_query($connect,"SELECT tenant_name FROM `all_tenants` WHERE `id` = '".$tanent_id_f."' ");
	  $res_tenant_new = mysqli_fetch_array($fetch_tenant_new);
	  $tenant_name_new = ucfirst($res_tenant_new['tenant_name']);
	  

	echo ' 
	<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
	<header class="main-header">
    <!-- Logo -->
    <h2 class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SE</b></span>
      <!-- logo for regular state and mobile devices -->';
      
      if((strpos($current_url, 'dashboard-event.php') == false) && (strpos($current_url,'create-event.php') == false) && (strpos($current_url,'all-users.php') == false) && (strpos($current_url, 'edit-event.php') == false) && (strpos($current_url,'create-user.php') == false) && (strpos($current_url, 'edit-user.php') == false) && (strpos($current_url, 'total_speakers.php') == false) && (strpos($current_url, 'total_sponsors.php') == false) && (strpos($current_url, 'all-contacts.php') == false) && (strpos($current_url, 'admin-user-management.php') == false) && (strpos($current_url, 'logon_history.php') == false) && (strpos($current_url, 'plan-and-billing-info.php') == false) && (strpos($current_url, 'admin-add-user.php') == false) && (strpos($current_url, 'edit-user-management.php') == false) && (strpos($current_url, 'personal-settings.php') == false) && (strpos($current_url, 'admin-personal-settings.php') == false) && (strpos($current_url, 'speaker-engage-landing.php') == false) && (strpos($current_url, 'request-demo.php') == false) && (strpos($current_url, 'speaker-engage-tutorial.php') == false) )
      {
      	//
      	echo '<span class="logo-lg">Organization Name: '.$tenant_name.' | '.$event_name.'</span>';
      }else
      {
      	echo '<span class="logo-lg">Organization Name: '.$tenant_name_new.'</span>';
      } 
      
    echo '</h2>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">'.$manage_user_menu.'


        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="./images/user_images/'.$profile_pic.'" class="user-image" alt="User Image">
              <span class="hidden-xs">'.$name.'</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="./images/user_images/'.$profile_pic.'" class="img-circle" alt="User Image">

                <p>
                  '.$name.'
                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="edit-user-management.php?id='.base64_encode($id_user).'" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>
  </header>
  ';

  		


}
function admin_top_bar_new(){
	
	include('mysqli_connect.php');
	$logo_small = $GLOBALS['logo_small'];
	$common = $GLOBALS['common'];
	$current_url = $_SERVER['REQUEST_URI'];
	$id_user=$common->idUser();
	$profile_pic = "";
	
	$sql = mysqli_query($connect,"SELECT * FROM all_users WHERE user_id=".$id_user);
	while($row = mysqli_fetch_array($sql)){
		$profile_pic = $row['profile_pic'];
		$name = $row['first_name'];
		$role_name = $row['role'];
	}
	if(empty($profile_pic)){
		$profile_pic = "user-default-icon.jpg";
	}
	$manage_user_menu = '';
	//var_dump($role_name); exit();
	

	if(strtolower($role_name) == 'admin'){
			$manage_user_menu = '<ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          
          <li class="dropdown user user-menu">
            <a href="all-users.php" style="border-right: 1px solid rgba(255, 255, 255, 0.42);padding-top: 5px;padding-bottom: 5px;margin-top: 10px;"><img src="images/multiple-users-icon.svg" class="img-responsive" style="float:left;margin-right: 8px;height: 16px;margin-top: 3px;">Multi User Access</a>
            
          </li>
          <li class="user user-menu">
            <a class="show_hide" style="position:relative;padding-top: 5px;padding-bottom: 5px;margin-top: 10px;position:relative;"><img src="images/notificationNewWhite.png" class="img-responsive" style="float:left;height: 16px;margin-top: 3px;">
            	<span class="font-sem-bold" style="background:#d6d717;height: 13px;width: 13px;border-radius:10px;font-size: 8px;position: absolute;color: #000;text-align: center;line-height: 13px;right: 5px;top: 3px;">11</span>
            </a>
            
          </li>
          
        </ul>';

	}
	//var_dump($manage_user_menu); exit();
	  $event_id1=$_SESSION['current_event_id'];
	 $event_sql = mysqli_query($connect,"SELECT event_name FROM all_events WHERE id=".$event_id1);
	 $event_row = mysqli_fetch_array($event_sql);
	 $event_name = $event_row['event_name'];
	  if( strlen($event_name ) > 30 ) 
	  {
	    $event_name = substr($event_row['event_name'], 0, 30 ) . '...';
	  }

	echo ' 
	<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
	<header class="main-header">
    <!-- Logo -->
    <h2 class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SE</b></span>
      <!-- logo for regular state and mobile devices -->';
      if((strpos($current_url, 'dashboard-event.php') == false) && (strpos($current_url,'create-event.php') == false) && (strpos($current_url,'all-users.php') == false) && (strpos($current_url, 'edit-event.php') == false) && (strpos($current_url,'create-user.php') == false) && (strpos($current_url, 'edit-user.php') == false) && (strpos($current_url, 'total_speakers.php') == false) && (strpos($current_url, 'total_sponsors.php') == false) && (strpos($current_url, 'all-contacts.php') == false))
      {
      	echo '<span class="logo-lg">Speaker Engage | '.$event_name.'</span>';
      }else
      {
      	echo '<span class="logo-lg">Speaker Engage</span>';
      }
      
    echo '</h2>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">'.$manage_user_menu.'


        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" style="padding-left:8px;" class="dropdown-toggle" data-toggle="dropdown">
              <img src="./images/user_images/'.$profile_pic.'" class="user-image" alt="User Image">
              <span class="hidden-xs">'.$name.'</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="./images/user_images/'.$profile_pic.'" class="img-circle" alt="User Image">

                <p>
                  '.$name.'
                </p>
              </li>
              <!-- Menu Body -->
             
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="edit-user-management.php?id='.base64_encode($id_user).'" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>
    </nav>
  </header>
  <div class="slidingDivcont" style="display: none;">
  <div class="slidingDiv">
	  <div class="notifhead blue-n-color font-sem-bold">Notification<a href="#" class="hide1 pull-right"><img src="images/cancel-black.png" width="15"></a></div>
	 

	  <div class="notifTab">
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">ALL</a></li>
		    <li role="presentation"><a href="#weekly" aria-controls="weekly" role="tab" data-toggle="tab">WEEKLY</a></li>
		    <li role="presentation"><a href="#monthly" aria-controls="monthly" role="tab" data-toggle="tab">MONTHLY</a></li>
		    <li role="presentation"><a href="#account" aria-controls="account" role="tab" data-toggle="tab">ACCOUNT</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
		    <div role="tabpanel" class="tab-pane active" id="all">
		    		<a href="#" class="show_hide2">
			    	<div class="media">
					  <div class="media-left">
					    <p class="bodertxt pink">WEEKLY</p>
					  </div>
					  <div class="media-body">
					    <p class="mb-1">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam.</p>
					    <p class="date">17/06/2019</p>
					  </div>
					</div>
					</a>

					<a href="#" class="show_hide2">
			    	<div class="media">
					  <div class="media-left">
					    <p class="bodertxt violet">MONTHLY</p>
					  </div>
					  <div class="media-body">
					    <p class="mb-1">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam.</p>
					    <p class="date">17/06/2019</p>
					  </div>
					</div>
					</a>

					<a href="#" class="show_hide2">
			    	<div class="media">
					  <div class="media-left">
					    <p class="bodertxt blue">ACCOUNT</p>
					  </div>
					  <div class="media-body">
					    <p class="mb-1">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam.</p>
					    <p class="date">17/06/2019</p>
					  </div>
					</div>
					</a>

		    </div>
		    <div role="tabpanel" class="tab-pane" id="weekly">
		    <a href="#" class="show_hide2">
		    	<div class="media">
				  <div class="media-left">
				    <p class="bodertxt pink">WEEKLY</p>
				  </div>
				  <div class="media-body">
				    <p class="mb-1">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam.</p>
				    <p class="date">17/06/2019</p>
				  </div>
				</div>
				</a>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="monthly">
		    		<a href="#" class="show_hide2">
			    	<div class="media">
					  <div class="media-left">
					    <p class="bodertxt violet">MONTHLY</p>
					  </div>
					  <div class="media-body">
					    <p class="mb-1">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam.</p>
					    <p class="date">17/06/2019</p>
					  </div>
					</div>
					</a>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="account">
		    	<a href="#" class="show_hide2">
			    	<div class="media">
					  <div class="media-left">
					    <p class="bodertxt blue">ACCOUNT</p>
					  </div>
					  <div class="media-body">
					    <p class="mb-1">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam.</p>
					    <p class="date">17/06/2019</p>
					  </div>
					</div>
					</a>
		    </div>
		  </div>
		</div>
	</div>
	<div class="show-content">
				<div class="contentBox">
				<a href="#" class="close-arrow show_hide2"><img src="images/arrow-pointing-to-right.png" width="30" /></a>
					<h3 class="blue-n-color">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum</h3>
					<p class="date">17/07/2019</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
					</p>
					<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.</p>
				</div>
	</div>
	</div>
  ';
}
function admin_left_menu($evt_id = NULL){
	include('mysqli_connect.php');
	$current_url = $_SERVER['REQUEST_URI'];
	$queryString = $_SERVER['QUERY_STRING'];
	 $apply_to_speak_url = $GLOBALS['apply_to_speak_url'];
	//$apply_to_speak_url = 'http://www.speakerengage.com/apply-to-speak-staging/';
	$userid=$_SESSION['user_id'];
	// $event_id=$_SESSION['current_event_id'];
	$event_id=$evt_id;
	$common = $GLOBALS['common'];
	$id_user=$common->idUser();
	$sql = mysqli_query($connect,"SELECT * FROM all_users WHERE user_id=".$id_user);
	while($row = mysqli_fetch_array($sql)){
		$privilege = explode(",",$row['privilege']);
		$role = strtolower($row['role']);
	}

	$event_sql = mysqli_query($connect,"SELECT * FROM all_events WHERE id=".$event_id);
	$event_row = mysqli_fetch_array($event_sql);
	$event_url_structure = $event_row['url_structure'];

	//tenant_name
	$fetch_tenant = mysqli_query($connect,"SELECT tenant_name from all_tenants where id in (select tanent_id from all_events where id = '".$event_id."')");
	$tenant_row = mysqli_fetch_array($fetch_tenant);
	$tenant_name = $tenant_row['tenant_name'];

	//var_dump($tenant_name);exit();



	$badge = "";
	$rows_cou = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM all_speakers WHERE status='' AND event_id= '".$event_id."' "));
	$badge = "<span class='fa badge' style='width:auto !important;margin-left: 5px;'>".$rows_cou."</span>";
	$master_count = "";
	$rows_master_count = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM all_masters WHERE is_approved=0 AND event_id= '".$event_id."' "));
	$master_count = "<span class='fa badge' style='width:auto !important;margin-left: 5px;'>".$rows_master_count."</span>";
	echo '<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class=""><a href="event-home.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'"><img src="../images/home-icon-silhouette.svg" style="height: 12px;position: relative;top: -2px;"> Event Home</a></li>';
		$userid=$_SESSION['user_id'];

                    $sql = mysqli_query($connect,"SELECT roleid FROM all_users WHERE user_id=".$userid);
                        while($row = mysqli_fetch_array($sql)){
                            $RoleID = $row['roleid'];
                        }

                     $query_menu = mysqli_query($connect,"SELECT distinct m1.menu_id,m1.menu,m1.url,m1.Menuicon,m1.has_submenu from mainmenus m1,role_assigned m2 where m1.menu_id=m2.MainMenuid and m2.roleid = '$RoleID' ORDER BY m1.menu_id ASC");                         

                    while($res_menu = mysqli_fetch_array($query_menu)) 
                    {
                        $menuId = $res_menu['menu_id'];

                        // $fetch_submenu = mysqli_query($connect,"SELECT t2.id,t2.sub_menu_name,t2.sub_menu_url,t2.sub_menuicon FROM mainmenus t1, sub_menus t2  WHERE t1.menu_id = t2.menu_id AND t2.menu_id = '$menuId'  ORDER BY t2.id ASC");

                        $fetch_submenu = mysqli_query($connect,"SELECT t2.id,t2.sub_menu_name,t2.sub_menu_url,t2.sub_menuicon FROM sub_menus t2, submenu_assigned t1 WHERE  t2.menu_id=t1.main_menu_id  AND t2.id=t1.submenu_id  AND t1.main_menu_id = '$menuId' AND t1.roleid='$RoleID' order by t2.submenu_order asc");

                        if(mysqli_num_rows($fetch_submenu) > 0)
                        {

                    ?>
                    <?php
			            	 if($res_menu['has_submenu'] > 0)
                        {
                        	
		                    echo '<li class="treeview '; if((strpos($current_url, $res_menu['url']) !== false) || ($current_url == 'dashboard.php' ) ) echo 'active';  
							echo '">';
							?>
					          <a href="<?php echo $res_menu['url'].'?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)); ?>">
					            <img src="../images/icons/<?php echo $res_menu['Menuicon'] ?>.png" class="" style="width: 23px;position: relative;top: -2px;" >
					            <span><?php echo $res_menu['menu'] ?></span>
					            <span class="pull-right-container">
					            	<?php
					            	 if($res_menu['has_submenu'] > 0)
		                        {
					              echo '<i class="fa fa-angle-right pull-right"></i>';
		                        }
		                        ?>
					            </span>
					          </a>
			    		<?php
		                        }else
		                        {
		                        	?>
		                        	<li>
		                        		<?php
		                        			$main_menu_url = '';

		                        			if($res_menu['url'] == 'assistance-form.php'){
												$target="";
												$main_menu_url = $res_menu['url'].'?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999));
											}else{
												$main_menu_url = $res_menu['url'];
											}

		                        		?>
							          <a href="<?php echo $main_menu_url; ?>">
							            <img src="../images/icons/email.png" style="width: 23px;position: relative;top: -2px;">
							            <span><?php echo $res_menu['menu'] ?></span>
							          </a>          
							        </li>
		                        <?php
		                        }
		                        ?>

          				<ul class="treeview-menu">
                        <?php

                          while($res_submenu = mysqli_fetch_array($fetch_submenu))
                          {
                         	
                             echo '<li class="'; if(strpos($current_url, $res_submenu['sub_menu_url']) !== false) echo 'active'; 
								echo '">';
									$sub_menu_url = '';
								if (strpos($res_submenu['sub_menu_url'], '/apply-to-speak/') !== false) {

									$target="_blank";
									$sub_menu_url = $res_submenu['sub_menu_url'].$tenant_name."/".$event_url_structure;
									//var_dump($sub_menu_url);exit();

								//  $sub_menu_url = $res_submenu['sub_menu_url'].$event_url_structure;
								}elseif (strpos($res_submenu['sub_menu_url'], 'master-signup.php')!== false ) {
									$target="_blank";
								  $sub_menu_url = $res_submenu['sub_menu_url'].'?pid='.$event_url_structure.'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999));
									
								}elseif(strpos($res_submenu['sub_menu_url'], 'email_status.php')!== false ){
									$target="";
									$sub_menu_url = $res_submenu['sub_menu_url'].'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999));
									}
								elseif(strpos($res_submenu['sub_menu_url'], 'status_sponsor.php')!== false ){
									$target="";
									$sub_menu_url = $res_submenu['sub_menu_url'].'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999));
								}
								else{
									$target="";
									$sub_menu_url = $res_submenu['sub_menu_url'].'?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999));
								}

								?>
								<a href="<?php echo $sub_menu_url; ?>" target="<?php echo $target; ?>"><img src="../images/icons/<?php echo $res_submenu['sub_menuicon']; ?>.png" style="width: 23px;position: relative;top: -2px;" >
									<?php
						            	 if($res_submenu['id'] == 5)
			                        {
						              echo  $res_submenu['sub_menu_name'] .$badge;
			                        }else if($res_submenu['id'] == 27)
			                        {
						              echo  $res_submenu['sub_menu_name'] .$master_count;
			                        }
			                        else
			                        {
			                        	echo  $res_submenu['sub_menu_name'];
			                        }
			                        ?>
									</a></li>
		                        <?php
		                          }

		                        ?>
		                        </ul>
		                        </li>
		                    <?php
		                        }else
		                        {

		                        ?>
	                         <li ><a href="<?php echo $res_menu['url'].'?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)); ?>"><?php echo $res_menu['name'] ?></a></li>
	                    	<?php
	                        } 
		}
		echo '
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
';
}


function management_left_menu(){
	include('mysqli_connect.php');
	$userid=$_SESSION['user_id'];
	$current_url = $_SERVER['REQUEST_URI'];



	$sql = mysqli_query($connect,"SELECT * FROM all_users WHERE user_id=".$userid);
	$row = mysqli_fetch_array($sql);
	$role = strtolower($row['role']);
	$roleid = $row['roleid'];

	echo '<div class="col-sm-2">
          <div class="box box-primary" style="border:none; height: 100vh; padding: 20px;">
        <div class="card-box " >
            <!-- required for floating -->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs tabs-left">
                <li class="';

                if($roleid == '1'){                

	                 if(strpos($current_url,"plan-and-billing-info.php") !== false){echo "active"; }
	           	 		echo '" ><a href="plan-and-billing-info.php" class="font-sem-bold">Plan & Billing Info</a></li>
	                <li class="';

	                if(strpos($current_url,"admin-user-management.php") !== false || strpos($current_url,"admin-add-user.php") !== false || strpos($current_url,"edit-user-management.php") !== false ){echo "active"; }

	          			echo '"><a href="admin-user-management.php" class="font-sem-bold">User Management</a></li>
	                <li class="';
            	}else{

            		if(strpos($current_url,"edit-user-management.php") !== false){echo "active"; }
	           	 		echo '" ><a href="edit-user-management.php?id='.base64_encode($userid).'" class="font-sem-bold">User Management</a></li>
	                <li class="';
            	}

                if(strpos($current_url,"logon_history.php") !== false){echo "active"; }
            echo '"><a href="logon_history.php" class="font-sem-bold">Login History</a></li>
              
            </ul>
        </div>
      </div>
      </div>';

      

}




function all_speaker_footer(){

echo '<!-- /.content-wrapper -->
	<style>
	.SumoSelect > .CaptionCont{
		border: 1px solid #d3d6df !important;
		border-radius: 0px !important;
	}
	#modal_content a{cursor:pointer;word-wrap: break-word !important;}
	.modal-content{ margin-top:5% !important; }
	</style>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon\'s Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<style>
.content-wrapper{
	    margin-top: -20px !important;
}
.ok, .cancel{ cursor:pointer; }
#modal_content .a{cursor:pointer;word-wrap: break-word;}
.mce-content-body a[href] {
    text-decoration: underline;color:blue !important;
}
.multiselect-container, .multiselect-native-select .btn-group,.dropdown-toggle{ width:100% !important; }
</style>


<!-- ./wrapper -->



<!-- jQuery 3 -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
 <!-- Bootstrap 3.3.7 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<script>




</script>

<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>

<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<!---- Editor ------------>


		
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>tinymce.init({ selector: ".editor",
		  height: 400,
		  theme: "modern",
		  convert_urls:true,
			relative_urls:false,
			remove_script_host:false,
		  plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern codesample"
		  ],
		  toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		  toolbar2: "print preview media | forecolor backcolor emoticons | codesample",
		  templates: [
			{ title: "Test template 1", content: "Test 1" },
			{ title: "Test template 2", content: "Test 2" }
		  ],
		init_instance_callback: function (editor) {
					editor.on("click", function (e) { 
						console.log(e.target.nodeName);
					  if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
					});
					editor.on("KeyDown", function (e) {
						if ((e.keyCode == 8 || e.keyCode == 46)) { // delete & backspace keys
							if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
						}
					});
				
			    },
		  content_css: [
			"//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
			"'.$_SESSION['site_url'].'/css/codepen.min.css",
			
		  ] });
		  function applyMCE() {
			   $(".editor").each(function(){
				   tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, $(this).attr("id"));
				tinyMCE.EditorManager.execCommand("mceFocus", false, $(this).attr("id"));                    
				tinyMCE.EditorManager.execCommand("mceAddEditor", true, $(this).attr("id"));
			   });
				
		}
		 
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "address");
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "additional_code");
		</script>
		<!---- Modal popup---->
		
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modalOpen" style="display:none">Open Modal</button>
		<div class="modal fade modal-md in" id="myModal" role="dialog" style="">
		  
		</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

<link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
<script>
	function initMultiSelect(){

      $(".multiselect").multiselect({
		includeSelectAllOption: true,
		maxHeight: 400
		});
    }
	function destroyMultiselect(){

      $(".multiselect").multiselect("destroy");
    }
	destroyMultiselect();
	initMultiSelect();
function fetch_status(){
		$.ajax({
			  type: "POST",
			  url: "ajaxCalls.php",
			  async:false,
			  data: {"template_type":$(\'#template_type\').val(),"action":"fetchStatusBasedonType"} ,
			  success: function(data) {
					
				$("#status_id").html(data);
				destroyMultiselect();
				initMultiSelect();
				
			  }
			});
	}
$(".jcrop-holder").click(function(e){ e.preventDefault(); });
</script>
<!-- DataTables ---->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript">
 
var j_dataTable = $.noConflict();
j_dataTable(document).ready(function() {
	var oTable = j_dataTable("#datatable").DataTable( {
        "order": [[ 0, "desc" ]]
    } );
});


</script>
</body>
</html>
';

}

function all_speaker_footer_abby(){

	/* <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Version 5.0.0
    </div>
    Copyright &copy; '.date('Y').'  Meylah Corporation. All rights reserved.
  </footer>*/

echo '<!-- /.content-wrapper -->
	<style>
	.SumoSelect > .CaptionCont{
		border: 1px solid #d3d6df !important;
		border-radius: 0px !important;
	}
	#modal_content a{cursor:pointer;word-wrap: break-word !important;}
	.modal-content{ margin-top:5% !important; }
	</style>
 

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon\'s Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<style>
.content-wrapper{
	    margin-top: -20px !important;
}
.ok, .cancel{ cursor:pointer; }
#modal_content .a{cursor:pointer;word-wrap: break-word;}
.mce-content-body a[href] {
    text-decoration: underline;color:blue !important;
}
.multiselect-container, .multiselect-native-select .btn-group,.dropdown-toggle{ width:100% !important; }
</style>


<!-- ./wrapper -->



<!-- jQuery 3 -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
 <!-- Bootstrap 3.3.7 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>

<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<!---- Editor ------------>


		
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>tinymce.init({ selector: ".editor",
		  height: 400,
		  theme: "modern",
		  convert_urls:true,
			relative_urls:false,
			remove_script_host:false,
		  plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern codesample"
		  ],
		  toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		  toolbar2: "print preview media | forecolor backcolor emoticons | codesample",
		  templates: [
			{ title: "Test template 1", content: "Test 1" },
			{ title: "Test template 2", content: "Test 2" }
		  ],
		init_instance_callback: function (editor) {
					editor.on("click", function (e) { 
						console.log(e.target.nodeName);
					  if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
					});
					editor.on("KeyDown", function (e) {
						if ((e.keyCode == 8 || e.keyCode == 46)) { // delete & backspace keys
							if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
						}
					});
				
			    },
		  content_css: [
			"//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
			"'.$_SESSION['site_url'].'/css/codepen.min.css",
			
		  ] });
		  function applyMCE() {
			   $(".editor").each(function(){
				   tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, $(this).attr("id"));
				tinyMCE.EditorManager.execCommand("mceFocus", false, $(this).attr("id"));                    
				tinyMCE.EditorManager.execCommand("mceAddEditor", true, $(this).attr("id"));
			   });
				
		}
		 
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "address");
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "additional_code");
		</script>
		<!---- Modal popup---->
		
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modalOpen" style="display:none">Open Modal</button>
		<div class="modal fade modal-md in darkHeaderModal" id="myModal" role="dialog" style="">
		  
		</div>


<link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
<script>
	function initMultiSelect(){

      $(".multiselect").multiselect({
		includeSelectAllOption: true,
		maxHeight: 400
		});
    }
	function destroyMultiselect(){

      $(".multiselect").multiselect("destroy");
    }
	destroyMultiselect();
	initMultiSelect();
function fetch_status(){
		$.ajax({
			  type: "POST",
			  url: "ajaxCalls.php",
			  async:false,
			  data: {"template_type":$(\'#template_type\').val(),"action":"fetchStatusBasedonType"} ,
			  success: function(data) {
					
				$("#status_id").html(data);
				destroyMultiselect();
				initMultiSelect();
				
			  }
			});
	}
$(".jcrop-holder").click(function(e){ e.preventDefault(); });
</script>
<!-- DataTables ---->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
	var oTable = $("#datatable").DataTable( {
        "order": [[ 0, "desc" ]]
    } );
});



</script>';

}

function admin_footer(){

	
	echo '<!-- /.content-wrapper -->
	<style>
	.SumoSelect > .CaptionCont{
		border: 1px solid #d3d6df !important;
		border-radius: 0px !important;
	}
	#modal_content a{cursor:pointer;word-wrap: break-word !important;}
	.modal-content{ margin-top:5% !important; }
	</style>
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon\'s Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<style>
.content-wrapper{
	    margin-top: -20px !important;
}
.ok, .cancel{ cursor:pointer; }
#modal_content .a{cursor:pointer;word-wrap: break-word;}
.mce-content-body a[href] {
    text-decoration: underline;color:blue !important;
}
.multiselect-container, .multiselect-native-select .btn-group,.dropdown-toggle{ width:100% !important; }
</style>


<!-- ./wrapper -->



<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<!---- Editor ------------>
		
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>tinymce.init({ selector: ".editor",
		  height: 400,
		  theme: "modern",
		  convert_urls:true,
			relative_urls:false,
			remove_script_host:false,
		  plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern codesample"
		  ],
		  toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		  toolbar2: "print preview media | forecolor backcolor emoticons | codesample",
		  templates: [
			{ title: "Test template 1", content: "Test 1" },
			{ title: "Test template 2", content: "Test 2" }
		  ],
		init_instance_callback: function (editor) {
					editor.on("click", function (e) { 
						console.log(e.target.nodeName);
					  if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
					});
					editor.on("KeyDown", function (e) {
						if ((e.keyCode == 8 || e.keyCode == 46)) { // delete & backspace keys
							if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
						}
					});
				
			    },
		  content_css: [
			"//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
			"'.$_SESSION['site_url'].'/css/codepen.min.css",
			
		  ] });
		  function applyMCE() {
			   $(".editor").each(function(){
				   tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, $(this).attr("id"));
				tinyMCE.EditorManager.execCommand("mceFocus", false, $(this).attr("id"));                    
				tinyMCE.EditorManager.execCommand("mceAddEditor", true, $(this).attr("id"));
			   });
				
		}
		 
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "address");
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "additional_code");
		</script>
		<!---- Modal popup---->
		
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modalOpen" style="display:none">Open Modal</button>
		<div class="modal fade modal-md in darkHeaderModal" id="myModal" role="dialog" style="">
		  
		</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="js/custom.js"></script>
<link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
<script>
	function initMultiSelect(){

      $(".multiselect").multiselect({
		includeSelectAllOption: true,
		maxHeight: 400
		});
    }
	function destroyMultiselect(){

      $(".multiselect").multiselect("destroy");
    }
	destroyMultiselect();
	initMultiSelect();
function fetch_status(){
		$.ajax({
			  type: "POST",
			  url: "ajaxCalls.php",
			  async:false,
			  data: {"template_type":$(\'#template_type\').val(),"action":"fetchStatusBasedonType"} ,
			  success: function(data) {
					
				$("#status_id").html(data);
				destroyMultiselect();
				initMultiSelect();
				
			  }
			});
	}
$(".jcrop-holder").click(function(e){ e.preventDefault(); });
</script>
<!-- DataTables ---->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript">
 
var j_dataTable = $.noConflict();
j_dataTable(document).ready(function() {
	var oTable = j_dataTable("#datatable").DataTable( {
        "order": [[ 0, "desc" ]]
    } );
});
</script>
</body>
</html>
';
}

function admin_footer_index(){

	/*<footer class="main-footer">
    <div class="pull-right hidden-xs">
      Version 5.0.0
    </div>
    Copyright &copy; '.date('Y').'  Meylah Corporation. All rights reserved.
  </footer>*/


	echo '<!-- /.content-wrapper -->
	<style>
	.SumoSelect > .CaptionCont{
		border: 1px solid #d3d6df !important;
		border-radius: 0px !important;
	}
	#modal_content a{cursor:pointer;word-wrap: break-word !important;}
	.modal-content{ margin-top:5% !important; }
	</style>
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon\'s Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<style>
.content-wrapper{
	    margin-top: -20px !important;
}
.ok, .cancel{ cursor:pointer; }
#modal_content .a{cursor:pointer;word-wrap: break-word;}
.mce-content-body a[href] {
    text-decoration: underline;color:blue !important;
}
.multiselect-container, .multiselect-native-select .btn-group,.dropdown-toggle{ width:100% !important; }
</style>


<!-- ./wrapper -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="js/custom.js"></script>
<link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
<script> $(".multiselect").multiselect({
	includeSelectAllOption: true,
	maxHeight: 400
	});

$(".jcrop-holder").click(function(e){ e.preventDefault(); });
</script>

<!-- DataTables ---->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript">
 
var j_dataTable = $.noConflict();
j_dataTable(document).ready(function() {
	var oTable = j_dataTable("#datatable").DataTable( {
        "order": [[ 0, "desc" ]]
    } );
});
</script>
<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<!---- Editor ------------>
		
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>tinymce.init({ selector: ".editor",
		  height: 400,
		  theme: "modern",
		  convert_urls:true,
			relative_urls:false,
			remove_script_host:false,
		  plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern codesample"
		  ],
		  toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		  toolbar2: "print preview media | forecolor backcolor emoticons | codesample",
		  templates: [
			{ title: "Test template 1", content: "Test 1" },
			{ title: "Test template 2", content: "Test 2" }
		  ],
		init_instance_callback: function (editor) {
					editor.on("click", function (e) { 
						console.log(e.target.nodeName);
					  if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
					});
					editor.on("KeyDown", function (e) {
						if ((e.keyCode == 8 || e.keyCode == 46)) { // delete & backspace keys
							if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
						}
					});
				
			    },
		  content_css: [
			"//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
			"'.$_SESSION['site_url'].'/css/codepen.min.css",
			
		  ] });
		  function applyMCE() {
			   $(".editor").each(function(){
				   tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, $(this).attr("id"));
				tinyMCE.EditorManager.execCommand("mceFocus", false, $(this).attr("id"));                    
				tinyMCE.EditorManager.execCommand("mceAddEditor", true, $(this).attr("id"));
			   });
				
		}
		 
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "address");
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "additional_code");
		</script>
		<!---- Modal popup---->
		
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modalOpen" style="display:none">Open Modal</button>
		<div class="modal fade modal-md in darkHeaderModal" id="myModal" role="dialog" style="">
		  
		</div>

</body>
</html>
';
}

function admin_footer_email_template(){
	echo '<!-- /.content-wrapper -->
	<style>
	.SumoSelect > .CaptionCont{
		border: 1px solid #d3d6df !important;
		border-radius: 0px !important;
	}
	#modal_content a{cursor:pointer;word-wrap: break-word !important;}
	.modal-content{ margin-top:5% !important; }
	</style>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Version 5.0.0
    </div>
    Copyright &copy; '.date('Y').'  Meylah Corporation. All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon\'s Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<style>
.content-wrapper{
	    margin-top: -20px !important;
}
.ok, .cancel{ cursor:pointer; }
#modal_content .a{cursor:pointer;word-wrap: break-word;}
.mce-content-body a[href] {
    text-decoration: underline;color:blue !important;
}
.multiselect-container, .multiselect-native-select .btn-group,.dropdown-toggle{ width:100% !important; }
</style>


<!-- ./wrapper -->



<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<!---- Editor ------------>
		
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>tinymce.init({ selector: ".editor",
		  height: 400,
		  theme: "modern",
		  convert_urls:true,
			relative_urls:false,
			remove_script_host:false,
		  plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern codesample"
		  ],
		  toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		  toolbar2: "print preview media | forecolor backcolor emoticons | codesample",
		  templates: [
			{ title: "Test template 1", content: "Test 1" },
			{ title: "Test template 2", content: "Test 2" }
		  ],
		   menu : {file : {title : "File" , items : "newdocument"}, edit : {title : "Edit" , items : "undo redo | cut copy paste pastetext | selectall"}, insert : {title : "Insert", items : "link media | template hr"}, format : {title : "Format", items : "bold italic underline strikethrough superscript subscript | formats | removeformat"}, table : {title : "Table" , items : "inserttable deletetable | cell row column"}, tools : {title : "Tools" , items : "spellchecker code"} },
		init_instance_callback: function (editor) {
					editor.on("click", function (e) { 
						console.log(e.target.nodeName);
					  if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
					});
					editor.on("KeyDown", function (e) {
						if ((e.keyCode == 8 || e.keyCode == 46)) { // delete & backspace keys
							if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
						}
					});
				
			    },
		  content_css: [
			"//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
			"'.$_SESSION['site_url'].'/css/codepen.min.css",
			
		  ] });
		  function applyMCE() {
			   $(".editor").each(function(){
				   tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, $(this).attr("id"));
				tinyMCE.EditorManager.execCommand("mceFocus", false, $(this).attr("id"));                    
				tinyMCE.EditorManager.execCommand("mceAddEditor", true, $(this).attr("id"));
			   });
				
		}
		 
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "address");
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "additional_code");
		</script>
		<!---- Modal popup---->
		
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modalOpen" style="display:none">Open Modal</button>
		<div class="modal fade modal-md in" id="myModal" role="dialog" style="">
		  
		</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="js/custom.js"></script>
<link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
<script> $(".multiselect").multiselect({
	includeSelectAllOption: true,
	maxHeight: 400
	});
	function initMultiSelect(){

      $(".multiselect").multiselect({
		includeSelectAllOption: true,
		maxHeight: 400
		});
    }
	function destroyMultiselect(){

      $(".multiselect").multiselect("destroy");
    }
	destroyMultiselect();
	initMultiSelect();
function fetch_status(){
		$.ajax({
			  type: "POST",
			  url: "ajaxCalls.php",
			  async:false,
			  data: {"template_type":$(\'#template_type\').val(),"action":"fetchStatusBasedonType"} ,
			  success: function(data) {
					
				$("#status_id").html(data);
				destroyMultiselect();
				initMultiSelect();
				
			  }
			});
	}

$(".jcrop-holder").click(function(e){ e.preventDefault(); });
</script>
</body>
</html>
';
}




function admin_footer_email_template1(){
	echo '<!-- /.content-wrapper -->
	<style>
	.SumoSelect > .CaptionCont{
		border: 1px solid #d3d6df !important;
		border-radius: 0px !important;
	}
	#modal_content a{cursor:pointer;word-wrap: break-word !important;}
	.modal-content{ margin-top:5% !important; }
	</style>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      Version 5.0.0
    </div>
    Copyright &copy; '.date('Y').'  Meylah Corporation. All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon\'s Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<style>
.content-wrapper{
	    margin-top: -20px !important;
}
.ok, .cancel{ cursor:pointer; }
#modal_content .a{cursor:pointer;word-wrap: break-word;}
.mce-content-body a[href] {
    text-decoration: underline;color:blue !important;
}
.multiselect-container, .multiselect-native-select .btn-group,.dropdown-toggle{ width:100% !important; }
</style>


<!-- ./wrapper -->



<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<!---- Editor ------------>
		
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>tinymce.init({ selector: ".editor",
		  height: 400,
		  theme: "modern",
		  convert_urls:true,
			relative_urls:false,
			remove_script_host:false,
		  plugins: "link",
		   default_link_target: "_blank",
		  plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern codesample"
		  ],
		  toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		  toolbar2: "print preview media | forecolor backcolor emoticons | codesample",
		  templates: [
			{ title: "Test template 1", content: "Test 1" },
			{ title: "Test template 2", content: "Test 2" }
		  ],
		init_instance_callback: function (editor) {
					editor.on("click", function (e) { 
						console.log(e.target.nodeName);
					  if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
					});
					editor.on("KeyDown", function (e) {
						if ((e.keyCode == 8 || e.keyCode == 46)) { // delete & backspace keys
							if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
						}
					});
				
			    },
		  content_css: [
			"//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
			"'.$_SESSION['site_url'].'/css/codepen.min.css",
			
		  ] });
		  function applyMCE() {
			   $(".editor").each(function(){
				   tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, $(this).attr("id"));
				tinyMCE.EditorManager.execCommand("mceFocus", false, $(this).attr("id"));                    
				tinyMCE.EditorManager.execCommand("mceAddEditor", true, $(this).attr("id"));
			   });
				
		}
		 
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "address");
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "additional_code");
		</script>
		<!---- Modal popup---->
		
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modalOpen" style="display:none">Open Modal</button>
		<div class="modal fade modal-md in" id="myModal" role="dialog" style="">
		  
		</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="js/custom.js"></script>
<link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
<script> $(".multiselect").multiselect({
	includeSelectAllOption: true,
	maxHeight: 400
	});
	function initMultiSelect(){

      $(".multiselect").multiselect({
		includeSelectAllOption: true,
		maxHeight: 400
		});
    }
	function destroyMultiselect(){

      $(".multiselect").multiselect("destroy");
    }
	destroyMultiselect();
	initMultiSelect();
function fetch_status(){
		$.ajax({
			  type: "POST",
			  url: "ajaxCalls.php",
			  async:false,
			  data: {"template_type":$(\'#template_type\').val(),"action":"fetchStatusBasedonType"} ,
			  success: function(data) {
					
				$("#status_id").html(data);
				destroyMultiselect();
				initMultiSelect();
				
			  }
			});
	}

$(".jcrop-holder").click(function(e){ e.preventDefault(); });
</script>
</body>
</html>
';
}


function admin_footer_speaker_page(){
	/*<footer class="main-footer">
    <div class="pull-right hidden-xs">
      Version 5.0.0
    </div>
   Copyright &copy; '.date('Y').'  Meylah Corporation. All rights reserved.
  </footer>*/
	echo '<!-- /.content-wrapper -->
	<style>
	.SumoSelect > .CaptionCont{
		border: 1px solid #d3d6df !important;
		border-radius: 0px !important;
	}
	#modal_content a{cursor:pointer;word-wrap: break-word !important;}
	.modal-content{ margin-top:5% !important; }
	</style>
  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon\'s Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<style>
.content-wrapper{
	    margin-top: -20px !important;
}
.ok, .cancel{ cursor:pointer; }
#modal_content .a{cursor:pointer;word-wrap: break-word;}
.mce-content-body a[href] {
    text-decoration: underline;color:blue !important;
}
.multiselect-container, .multiselect-native-select .btn-group,.dropdown-toggle{ width:100% !important; }
</style>


<!-- ./wrapper -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="js/custom.js"></script>
<link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
<script> $(".multiselect").multiselect({
	includeSelectAllOption: true,
	maxHeight: 400
	});

$(".jcrop-holder").click(function(e){ e.preventDefault(); });
</script>


<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<!---- Editor ------------>
		
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>tinymce.init({ selector: ".editor",
		  height: 400,
		  theme: "modern",
		  convert_urls:true,
			relative_urls:false,
			remove_script_host:false,
		  plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern codesample"
		  ],
		  toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		  toolbar2: "print preview media | forecolor backcolor emoticons | codesample",
		  templates: [
			{ title: "Test template 1", content: "Test 1" },
			{ title: "Test template 2", content: "Test 2" }
		  ],
		init_instance_callback: function (editor) {
					editor.on("click", function (e) { 
						console.log(e.target.nodeName);
					  if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
					});
					editor.on("KeyDown", function (e) {
						if ((e.keyCode == 8 || e.keyCode == 46)) { // delete & backspace keys
							if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
						}
					});
				
			    },
		  content_css: [
			"//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
			"'.$_SESSION['site_url'].'/css/codepen.min.css",
			
		  ] });
		  function applyMCE() {
			   $(".editor").each(function(){
				   tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, $(this).attr("id"));
				tinyMCE.EditorManager.execCommand("mceFocus", false, $(this).attr("id"));                    
				tinyMCE.EditorManager.execCommand("mceAddEditor", true, $(this).attr("id"));
			   });
				
		}
		 
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "address");
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "additional_code");
		</script>
		<!---- Modal popup---->
		
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modalOpen" style="display:none">Open Modal</button>
		<div class="modal fade modal-md in" id="myModal" role="dialog" style="">
		  
		</div>

</body>
</html>
';
}

function admin_footer_bulk_notify_page(){
	echo '<!-- /.content-wrapper -->
	<style>
	.SumoSelect > .CaptionCont{
		border: 1px solid #d3d6df !important;
		border-radius: 0px !important;
	}
	#modal_content a{cursor:pointer;word-wrap: break-word !important;}
	.modal-content{ margin-top:5% !important; }
	</style>
 

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon\'s Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar\'s background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<style>
.content-wrapper{
	    margin-top: -20px !important;
}
.ok, .cancel{ cursor:pointer; }
#modal_content .a{cursor:pointer;word-wrap: break-word;}
.mce-content-body a[href] {
    text-decoration: underline;color:blue !important;
}
.multiselect-container, .multiselect-native-select .btn-group,.dropdown-toggle{ width:100% !important; }
</style>


<!-- ./wrapper -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="js/custom.js"></script>

	
	<script>
	
$(".jcrop-holder").click(function(e){ e.preventDefault(); });
</script>


<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge(\'uibutton\', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<!---- Editor ------------>
		
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script>tinymce.init({ selector: ".editor",
		  height: 400,
		  theme: "modern",
		  convert_urls:true,
			relative_urls:false,
			remove_script_host:false,
		  plugins: [
			"advlist autolink lists link image charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern codesample"
		  ],
		  toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
		  toolbar2: "print preview media | forecolor backcolor emoticons | codesample",
		  templates: [
			{ title: "Test template 1", content: "Test 1" },
			{ title: "Test template 2", content: "Test 2" }
		  ],
		init_instance_callback: function (editor) {
					editor.on("click", function (e) { 
						console.log(e.target.nodeName);
					  if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
					});
					editor.on("KeyDown", function (e) {
						if ((e.keyCode == 8 || e.keyCode == 46)) { // delete & backspace keys
							if(e.target.nodeName=="IMG"){ $(".cropme").click(); return false;}
						}
					});
				
			    },
		  content_css: [
			"//fonts.googleapis.com/css?family=Lato:300,300i,400,400i",
			"'.$_SESSION['site_url'].'/css/codepen.min.css",
			
		  ] });
		  function applyMCE() {
			   $(".editor").each(function(){
				   tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, $(this).attr("id"));
				tinyMCE.EditorManager.execCommand("mceFocus", false, $(this).attr("id"));                    
				tinyMCE.EditorManager.execCommand("mceAddEditor", true, $(this).attr("id"));
			   });
				
		}
		 
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "address");
		 tinyMCE.EditorManager.execCommand("mceRemoveEditor", true, "additional_code");
		</script>
		<!---- Modal popup---->
		
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="modalOpen" style="display:none">Open Modal</button>
		<div class="modal fade modal-md in" id="myModal" role="dialog" style="">
		  
		</div>

</body>
</html>
';
}

function admin_signup_header(){
	
	echo '<!DOCTYPE html>
<html lang="en">
<head>
  <title>Speaker Engage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="images/favicon.ico">
   <link href="assets/css/bootstrap.min.css" rel="stylesheet">
   <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
   <link rel="stylesheet" href="css/custom1.css">
   <link rel="stylesheet" href="css/custom_aby.css">
	
</head>
<body>

<nav class="navbar navbar-inverse main-header border-radius-0">
  <div class="container-fluid">
    <div class="navbar-header">
		<a class="navbar-brand" href="#">
			<img src="images/main-logo.png" class="img-responsive center-block" width="145">
		</a>

    </div>
    	
  </div>
</nav>';
}

function admin_signup_footer(){
	echo '<div class="logFooter white-text container-fluid">
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
          <span>Copyright © 2019 <a href="#" class="white-text">Meylah Corporation</a>. All rights reserved.</span>
        </div>
  
        <div class="col-md-4 col-sm-4 col-xs-12 text-center">
          <a href="https://meylah.com/privacy.html" class="white-text">Privacy Policy</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="#" class="white-text">Patent Information</a>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 text-right poweredby">
            <span>Powered by <a target="_blank" href="https://www.speakerengage.com" class="white-text">SpeakerEngage.com</a></span>
          </div>
        </div>
	</div>';
}

function convertToHoursMins($time) {
	$arr = explode(":",$time);$res="";
	if($arr[0]!=="00"){ if($arr[0]=="01") $res.= $arr[0]." Hour"; else $res.= $arr[0]." Hours"; }
	if($arr[1]!=="00"){ $res.= $arr[1]." Minutes"; }
    if($time=="00") $res .="0 Hour";
	if(empty($time)){
		$res ="00 Hour 00 Minutes";
	}
   return $res;
}

function breadcrumb(){
	echo '<li><a href="dashboard-event.php"><i class="fa fa-dashboard"></i> Account Home</a></li>';

}

function version_footer(){
	echo '<footer class="main-footer">
	<div class="row">
		<div class="col-md-4 col-sm-4 col-xs-12">
			Copyright &copy; 2019  Meylah Corporation. All rights reserved.
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12">
		<center>
			<a href="termsofuse.php" style="color:#007DB7 ;" target="_blank" >Terms and Conditions</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
			<a href="privacypolicy.php" style="color:#007DB7 ;" target="_blank">Privacy Policy</a>
			</center>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-12 text-right">
			Version 5.0.0
		</div>
	</div>
    
  </footer>';

}

// function version_footer_public(){
// 	echo '<footer class="main-footer">
// 	<div class="row">
// 		<div class="col-md-4 col-sm-4 col-xs-12">
// 			Copyright &copy; 2019  Meylah Corporation. All rights reserved.
// 		</div>
// 		<div class="col-md-4 col-sm-4 col-xs-12">
// 		<center>
// 			<a href="termsofuse.php" style="color:#007DB7 ;" target="_blank" >Terms and Conditions</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
// 			<a href="privacypolicy.php" style="color:#007DB7 ;" target="_blank">Privacy Policy</a>
// 			</center>
// 		</div>
// 		<div class="col-md-4 col-sm-4 col-xs-12 text-right">
// 			powered by <a href="speakerengage.com" style="color:#007DB7 ;" target="_blank">speakerengage.com</a>
// 			</center>
// 		</div>
// 	</div>
    
//   </footer>';

// }



function tc_footer(){

	echo '<div class="col-md-12">
   <a href="termsofuse.php" class="pull-left font-sem-bold" style="margin-top: 20px;margin-right: 30px;text-decoration: underline !important; " target="_blank"> Terms and Conditions</a>
   <a href="privacypolicy.php" class="font-sem-bold" style="padding-right: 30px;padding-top: 20px !important;padding-bottom: 25px !important;text-decoration: underline !important;float: left;" target="_blank">Privacy Policy</a>
 </div>
 <div class="clearfix"></div>';
}

function landing_header(){

$current_url = $_SERVER[REQUEST_URI];

	echo '<section class="menu cid-rH30gZ0uKY" once="menu" id="menu02-m">
    


    <nav class="navbar navbar-dropdown navbar-expand-lg">
        <div class="navbar-brand">
            <span class="navbar-logo">
                <a href="../">
                    <img src="../assets/mainpage/assets/images/speaker-engage-248x92.png" alt="Speaker Engage" title="" style="height: 55px;">
                </a>
            </span>
            
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                 <li class="nav-item';
                                if (strpos($current_url,'') !== false){
                                    echo ' active';
                                }
                                else{
                                    echo '  ';
                                }   
                                echo' ">
                    <a class="nav-link link text-info display-4" href="../">
                        Home
                    </a>
                </li>
                <li class="nav-item ';
                                if (strpos($current_url,'/demo') !== false){
                                    echo ' active';
                                }
                                echo'">
                    <a class="nav-link link text-info display-4" href="../demo">
                        Demo
                    </a>
                </li>
                <li class="nav-item ';
                                if (strpos($current_url,'/pricing') !== false){
                                    echo ' active';
                                }  
                                echo'">
                    <a class="nav-link link text-info display-4" href="../pricing">
                        Pricing
                    </a>
                </li>
                <li class="nav-item ';
                                if (strpos($current_url,'/event-as-a-service') !== false){
                                    echo '  active';
                                }  
                                echo'">
                    <a class="nav-link link text-info display-4" href="../event-as-a-service">
                        Event Services
                    </a>
                </li>
                <li class="nav-item';
                                if (strpos($current_url,'/event-directory') !== false){
                                    echo '  active';
                                }  
                                echo'">
                    <a class="nav-link link text-info display-4" href="../event-directory">
                         Event Directory
                    </a>
                </li>
            </ul><div class="navbar-buttons px-2 mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="../login.php">
                    Login</a></div>
        </div>
    </nav>
</section>';
}
function support_header(){
	echo'<nav class="navbar navbar-expand-lg navbar-light  sub-header">
         <div class="container">
            
            <div class=" " id="navbarSupportedContent1">
               <ul class=" mr-auto">
                  <li class="nav-item ">
                     <a class="nav-link" href="index.php">Support Home</a>
                  </li>
                  <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     Browse by Category
                     </a>
                     <div class="dropdown-menu"  aria-labelledby="navbarDropdown1">
                        <a class="dropdown-item" href="speaker-engage-basic.php">Speaker Engage Basics </a>
                        <a class="dropdown-item" href="account-management.php">Account Management</a>
                        <a class="dropdown-item" href="dashboard.php">Dashboards</a>
                        <a class="dropdown-item" href="event-management.php">Event Management</a>
                        <a class="dropdown-item" href="speaker.php">Speaker Management</a>
                        <a class="dropdown-item" href="speaker-communication.php">Speaker Communication</a>
                        <a class="dropdown-item" href="sponsor-management.php">Sponsor Management</a>
                        <a class="dropdown-item" href="sponsor-communication.php">Sponsor Communication</a>
                        <a class="dropdown-item" href="master-management.php">Master Management</a>
                        <a class="dropdown-item" href="master-communication.php">Master Communication</a>
                        <a class="dropdown-item" href="notification-engine.php">Notification Engine</a>
                        <a class="dropdown-item" href="action-tracker.php">Action Tracker</a>
                        <a class="dropdown-item" href="resource-management.php">Resource Management</a>
                        <a class="dropdown-item" href="billing.php">Billing</a>
                     </div>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<a href="javascript:" id="return-to-top"><i class="fa fa-2x fa-angle-up" aria-hidden="true"></i></a>

      ';
}
function landing_footer(){

	echo '<section class="cid-rHfVaaAqES" id="footer03-4">

    <div class="container">
        <div class="media-container-row content text-white">
            <div class="col-12 col-md-6 col-lg-3">
                

                <p class="mbr-text align-left text1 mbr-fonts-style display-4">
                    Speaker Engage™ is a fully-integrated, cloud-based platform, designed by event organizers for event organizers who want to curate and delight speakers &amp; sponsors by removing the chaos from event execution.
                </p>

            </div>
            <div class="col-12 col-md-6 col-lg-3 mbr-fonts-style display-4">
                <h5 class="pb-3 align-left">
                    Contact Info
                </h5>


                <!-- <div class="item">
                    <div class="card-img"><span class="mbr-iconfont img1 mobi-mbri-map-pin mobi-mbri"></span>
                    </div>
                    <div class="card-box">
                        <h4 class="item-title align-left mbr-fonts-style display-4">3020 Issaquah-Pine Lake Road SE, PMB 540, Sammamish, WA 98074</h4>
                    </div>
                </div> -->

                <div class="item">
                    <div class="card-img"><span class="mbr-iconfont img1 mbri-letter"></span></div>
                    <div class="card-box">
                        <h4 class="item-title align-left mbr-fonts-style display-4">support@speakerengage.com</h4>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3 mbr-fonts-style display-7">
                <h5 class="pb-3 align-left"><a href="../privacypolicy.php" target="_blank">Privacy</a><br><br><a href="../termsofuse.php" target="_blank">Terms of Use</a><br><br><a href="../support" target="_blank">Support</a></h5>
                <p class="mbr-text align-left text2 mbr-fonts-style display-4" style="margin-bottom: 5px;">
                    Copyright © '.date(Y).' Meylah Corporation. <br>All Rights Reserved
                </p>
                
            </div>
        </div>   
  </div>
</section>
<p class="mbr-text align-left text2 mbr-fonts-style display-4 powerede-by">Speaker Engage is powered by <a href="https://meylah.com/" target="_blank"><img src="https://meylah.com/images/logo-gray.png" class="img-fluid" width="90"></a></p>';
}

function demo_walkthrough_header(){

	echo '<section class="menu cid-rH30gZ0uKY" once="menu" id="menu02-m">
    


    <nav class="navbar navbar-dropdown navbar-expand-lg">
        <div class="navbar-brand">
            <span class="navbar-logo">
                <a href="../../">
                    <img src="../../assets/mainpage/assets/images/speaker-engage-248x92.png" alt="Speaker Engage" title="" style="height: 55px;">
                </a>
            </span>
            
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown" data-app-modern-menu="true">
                <li class="nav-item">
                    <a class="nav-link link text-info display-4" href="../../">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link text-info display-4" href="../../demo">
                        Demo
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link text-info display-4" href="../../pricing">
                        Pricing
                    </a>
                </li>
            </ul>
           <div class="navbar-buttons px-2 mbr-section-btn"><a class="btn btn-sm btn-primary display-4" href="../../login.php">
                    Login</a></div>
        </div>
    </nav>
</section>';
}

function demo_walkthrough_footer(){

	echo '<section class="cid-rHfVaaAqES" id="footer03-4">

    <div class="container">
        <div class="media-container-row content text-white">
            <div class="col-12 col-md-6 col-lg-3">
                

                <p class="mbr-text align-left text1 mbr-fonts-style display-4">
                    Speaker Engage™ is a fully-integrated, cloud-based platform, designed by event organizers for event organizers who want to curate and delight speakers &amp; sponsors by removing the chaos from event execution.
                </p>

            </div>
            <div class="col-12 col-md-6 col-lg-3 mbr-fonts-style display-4">
                <h5 class="pb-3 align-left">
                    Contact Info
                </h5>


                <!-- <div class="item">
                    <div class="card-img"><span class="mbr-iconfont img1 mobi-mbri-map-pin mobi-mbri"></span>
                    </div>
                    <div class="card-box">
                        <h4 class="item-title align-left mbr-fonts-style display-4">3020 Issaquah-Pine Lake Road SE, PMB 540, Sammamish, WA 98074</h4>
                    </div>
                </div> -->

                <div class="item">
                    <div class="card-img"><span class="mbr-iconfont img1 mbri-letter"></span></div>
                    <div class="card-box">
                        <h4 class="item-title align-left mbr-fonts-style display-4">support@speakerengage.com</h4>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3 mbr-fonts-style display-7">
                <h5 class="pb-3 align-left"><a href="../../privacypolicy.php" target="_blank">Privacy</a><br><br><a href="../../termsofuse.php" target="_blank">Terms of Use</a><br><br><a href="../../faqs" target="_blank">FAQs</a></h5>
                <p class="mbr-text align-left text2 mbr-fonts-style display-4" style="margin-bottom: 5px;">
                    Copyright © 2019 Meylah Corporation. <br>All Rights Reserved
                </p>
                
            </div>
        </div>   
  </div>
</section>
<p class="mbr-text align-left text2 mbr-fonts-style display-4 powerede-by">Speaker Engage is powered by <a href="https://meylah.com/" target="_blank"><img src="https://meylah.com/images/logo-gray.png" class="img-fluid" width="90"></a></p>';
}



function version_footer_static(){
	echo '<div class="logFooter white-text container-fluid">
     <div class="">
        
     <div class="col-md-4   poweredby">
            <span>Copyright © 2019 <a href="http://meylah.com/" target="_blank" class="white-text">Meylah Corporation</a>. All rights reserved.</span>
         </div>
       <div class="col-md-4  text-center">
         <a href="privacypolicy.php" class="white-text" target="_blank">Privacy Policy</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="termsofuse.php" class="white-text" target="_blank">Terms and Conditions</a>
       </div>
       <div class="col-md-4 col-sm-4 col-xs-12 text-right">
     Version 5.0.0
   </div>
     
       </div>
</div>';

}

function admin_way_top_SA(){
	$connect = $GLOBALS['connect'];
	$common = $GLOBALS['common'];
	$site_name = $GLOBALS['site_name'];

	echo '<!DOCTYPE html>
	<html>
	<head>
	  <meta charset="utf-8"> 
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>Speaker Engage | Admin Portal</title>
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <!-- App Favicon -->
		<link rel="shortcut icon" href="images/favicon.ico">

		<!-- App Title -->
		<title>'.$site_name.' | Admin Portal</title>
	  <!-- Bootstrap 3.3.7 -->
	  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	 
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	  <!-- Ionicons -->
	  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	  <!-- DataTables -->
      <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	  <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />		
	  <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	  <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" />
	  <!-- Theme style -->
	  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	  <!-- AdminLTE Skins. Choose a skin from the css/skins
		   folder instead of downloading all of them to reduce the load. -->
	  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	  <!-- Morris chart -->
	  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
	  
	  <!-- Date Picker -->
	  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	  <!-- Daterange picker -->
	  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
	  

	  <!-- Google Font -->
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	  
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  
	  

	  <style>
	  .modal img#banner_image {
    max-width: 615px;
}
    .wrapper {
      overflow: hidden !important;
    }
	  @media (min-width: 768px){
	  .modal-content{ margin-top: 30px !important;width: 50% !important;margin: 0 auto !important; }
	  .custom-modal-text {padding:15px !important;}
	  }
	   .cropme img{ width:600px !important; }
	    .multiselect.dropdown-toggle.btn.btn-default{
			  text-align:left;
		  }
		  .btn-group .caret{
			  float: right;
    margin-top: 8px;
		  }
		  .mce-content-body a[href]{color:blue !important;}
		  .alert-cust{
			  background-color: #fcf8e3  !important;
				border-color: #faebcc  !important;
				    color: black !important;
		  }
		  .manage_users{
		  	min-width: 120px;
		  	width: 120px !important;
		  }
		  .navbar-custom-menu .fa-angle-down{
		  	padding-top:4px;
		  }
		  .help.dropdown-menu{background:rgba(0,0,0,0.8)}
		  .help.dropdown-menu>li>a{color:#fff !important; text-align:center; font-size:16px;font-family: segoeuisemb;}
		  .help.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .help.dropdown-menu>.active>a:hover{
		  	background:none !important; 
		  }
		  .help.dropdown-menu li{padding:0 25px; margin-bottom:15px;}
		  .navbar-custom-menu>.navbar-nav>li>.help.dropdown-menu{    border-radius: 0;}
		  .help.dropdown-menu>li>a:hover{background:none !important;border-bottom:solid 4px #0f85bb; }
	  </style>

	  <!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151981830-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag("js", new Date());

		  gtag("config", "UA-151981830-1");
		</script>
	</head>
';
}

function admin_way_top_public(){
	$connect = $GLOBALS['connect'];
	$common = $GLOBALS['common'];
	$site_name = $GLOBALS['site_name'];
	$favicon = $GLOBALS['favicon'];
	error_reporting(0);
	/*if(!$common->CheckLogin())
	{
		$common->RedirectToURL("login.php");
		exit;
	}*/
	echo '<!DOCTYPE html>
	<html>
	<head>
	  <meta charset="utf-8"> 
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>Speaker Engage | Admin Portal</title>
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <!-- App Favicon -->
		<link rel="shortcut icon" href="images/favicon.ico">

		<!-- App Title -->
		<title>'.$site_name.' | Admin Portal</title>
	  <!-- Bootstrap 3.3.7 -->
	  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	 
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	  <!-- Ionicons -->
	  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	  <!-- DataTables -->
      <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	  <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />		
	  <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	  <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css" />
	  <!-- Theme style -->
	  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	  <!-- AdminLTE Skins. Choose a skin from the css/skins
		   folder instead of downloading all of them to reduce the load. -->
	  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	  <!-- Morris chart -->
	  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
	  
	  <!-- Date Picker -->
	  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	  <!-- Daterange picker -->
	  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
	  

	  <!-- Google Font -->
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	  
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  
	  

	  <style>
	  .modal img#banner_image {
    max-width: 615px;
}
    .wrapper {
      overflow: hidden !important;
    }
	  @media (min-width: 768px){
	  .modal-content{ margin-top: 30px !important;width: 50% !important;margin: 0 auto !important; }
	  .custom-modal-text {padding:15px !important;}
	  }
	   .cropme img{ width:600px !important; }
	    .multiselect.dropdown-toggle.btn.btn-default{
			  text-align:left;
		  }
		  .btn-group .caret{
			  float: right;
    margin-top: 8px;
		  }
		  .mce-content-body a[href]{color:blue !important;}
		  .alert-cust{
			  background-color: #fcf8e3  !important;
				border-color: #faebcc  !important;
				    color: black !important;
		  }
		  .manage_users{
		  	min-width: 120px;
		  	width: 120px !important;
		  }
		  .navbar-custom-menu .fa-angle-down{
		  	padding-top:4px;
		  }
		  .help.dropdown-menu{background:rgba(0,0,0,0.8)}
		  .help.dropdown-menu>li>a{color:#fff !important; text-align:center; font-size:16px;font-family: segoeuisemb;}
		  .help.dropdown-menu>.active>a, .dropdown-menu>.active>a:focus, .help.dropdown-menu>.active>a:hover{
		  	background:none !important; 
		  }
		  .help.dropdown-menu li{padding:0 25px; margin-bottom:15px;}
		  .navbar-custom-menu>.navbar-nav>li>.help.dropdown-menu{    border-radius: 0;}
		  .help.dropdown-menu>li>a:hover{background:none !important;border-bottom:solid 4px #0f85bb; }
	  </style>

	  <!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151981830-1"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag("js", new Date());

		  gtag("config", "UA-151981830-1");
		</script>
	</head>
';
}

?>
