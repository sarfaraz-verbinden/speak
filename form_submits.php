<?php 
ini_set('max_execution_time', 300000000000);
error_reporting(0);
	include('common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();

	if(isset($_GET['action'])){
		$action=$_GET['action'];
	}
	else{
		$action=$_POST['action'];
	}
	session_start();
	$site_url = 	$_SESSION['site_url'];

	//var_dump($action); exit();

	// echo $site_url; exit();
	$session_user_id = 	$_SESSION['user_id'];
	$user_email = 	$_SESSION['user_email'];
	$id_user = $common->idUser();
	switch($action){
		
		case "create_event_presentation":

			//$timezone = mysqli_real_escape_string($connect, $_POST['timezone']);
			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$p_topic = mysqli_real_escape_string($connect, $_POST['p_topic']);
			$opportunity_type = mysqli_real_escape_string($connect, $_POST['opportunity_type']);
			$location = mysqli_real_escape_string($connect, $_POST['location']);
			$abstract = mysqli_real_escape_string($connect, $_POST['abstract']);			
			$start_time = mysqli_real_escape_string($connect, $_POST['start_time']);
			$end_time = mysqli_real_escape_string($connect, $_POST['end_time']);
			$topic_owner = mysqli_real_escape_string($connect, $_POST['topic_owner']);
			$bussiness_objective = mysqli_real_escape_string($connect, $_POST['bussiness_objective']);
			//$speakers_list = mysqli_real_escape_string($connect, $_POST['speakers_list']);
			$speakers_list = 0;
			$loggedin_userid = mysqli_real_escape_string($connect, $_POST['loggedin_userid']);
			$uid = mysqli_real_escape_string($connect, $_POST['uid']);	
			$event_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['event_date'])));

			$st = date("H:i:s", strtotime($start_time));
			$et = date("H:i:s", strtotime($end_time));	

			$final_startdate= $event_date. ' ' .$st;
			$final_enddate= $event_date. ' ' .$et;

			$user_tz_data = mysqli_query($connect,"SELECT timezone FROM all_events WHERE id = '$event_id' ");
		   	$res_user_tz_data = mysqli_fetch_array($user_tz_data);
		   	$timezone_fetched = $res_user_tz_data['timezone'];
		   	if($timezone_fetched!='')
		   	{
		   		$user_tz_name = mysqli_query($connect,"SELECT timezone FROM timezones WHERE id = '$timezone_fetched' ");
			   	$res_user_tz_name = mysqli_fetch_array($user_tz_name);
			   	$timezone = $res_user_tz_name['timezone'];
		   	}else
		   	{
		   		$user_tz_name = mysqli_query($connect,"SELECT timezone FROM timezones WHERE id = '5'");
			   	$res_user_tz_name = mysqli_fetch_array($user_tz_name);
			   	$timezone = $res_user_tz_name['timezone'];
		   	}

			date_default_timezone_set($timezone);
			$a = strtotime($final_startdate);
			date_default_timezone_set("UTC");
			$new_time= date("Y-m-d H:i:s", $a) ;
			$date1 = new DateTime($new_time);
			$date1->modify("-8 hours"); 
			$start_utc_to_pst= $date1->format("Y-m-d H:i:s");	

			date_default_timezone_set($timezone);
			$b = strtotime($final_enddate);
			date_default_timezone_set("UTC");
			$new_time_val= date("Y-m-d H:i:s", $b) ;
			$date2 = new DateTime($new_time_val);
			$date2->modify("-8 hours"); 
			$end_utc_to_pst= $date2->format("Y-m-d H:i:s");
	
			$insert_event_presentation = "INSERT INTO `event_presentation` (`tanent_id`,`event_id`, `user_id`, `presentation_topic`, `opportunity_type`, `location`,`abstract`, `start_time`, 
				`end_time`, `topic_owner`, `business_objective`, `speakers_id`,`event_date`,`event_start_pst`,`event_end_pst`,`timezone`) VALUES ('".$session_tanent_id."','".$event_id."', '".$loggedin_userid."', '".$p_topic."', '".$opportunity_type."', '".$location."', '".$abstract."', '".$start_time."', '".$end_time."', '".$topic_owner."', '".$bussiness_objective."', '".$speakers_list."','".$event_date."','".$start_utc_to_pst."','".$end_utc_to_pst."','".$timezone."')";
			mysqli_query($connect,$insert_event_presentation);

			$ep_id = mysqli_insert_id($connect);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Create Event Agenda','".$ep_id."','".$loggedin_userid."',now(),\"".$insert_event_presentation."\")");
			
			if($insert_event_presentation){
				
				$insert_note = mysqli_query($connect,"INSERT INTO event_documents (ep_id,event_id,file_name,tenant_id) select $ep_id,$event_id,filename,$session_tanent_id from dropzone where uid='".$uid."'");

				$insert_note = mysqli_query($connect,"INSERT INTO event_presentation_notes (notes,ep_id,event_id,created_by,created_at) select notes,$ep_id,$event_id,$loggedin_userid,now() from new_speaker_notes where uniqueid='".$uid."'");

				$insert_note1 = mysqli_query($connect,"INSERT INTO event_presentation_coloboration_notes (notes,ep_id,event_id,created_by,created_at) select notes,$ep_id,$event_id,$loggedin_userid,now() from new_coloboration_notes where uniqueid='".$uid."'");

				 $insert_speaker = mysqli_query($connect, "INSERT INTO `event_agenda_speakers` (`ep_id`,`speaker_id`,`speaker_name`, `email_id`, `company`,`phone`,`status`,`influencer_total_score`) 
				 select $ep_id,speaker_id,speaker_name,email_id,company,phone,`status`,influencer_total_score  from new_event_agenda_speakers WHERE token='".$uid."'"); 
			}

			// if( array_key_exists( 'create_presentation_save_exit', $_POST ) )
			//  {
			 	header('Location:../all_presentation.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
			// }else
			// {
			// 	header('Location:../new_presentation.php?created-success');
			// }
			
		break;

		case "edit_event_presentation":

		    //$timezone = mysqli_real_escape_string($connect, $_POST['timezone']);
			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$p_topic = mysqli_real_escape_string($connect, $_POST['p_topic']);
			$opportunity_type = mysqli_real_escape_string($connect, $_POST['opportunity_type']);
			$location = mysqli_real_escape_string($connect, $_POST['location']);
			$abstract = mysqli_real_escape_string($connect, $_POST['abstract']);			
			$start_time = mysqli_real_escape_string($connect, $_POST['start_time']);
			$end_time = mysqli_real_escape_string($connect, $_POST['end_time']);
			$topic_owner = mysqli_real_escape_string($connect, $_POST['topic_owner']);
			$bussiness_objective = mysqli_real_escape_string($connect, $_POST['bussiness_objective']);
			//$speakers_list = mysqli_real_escape_string($connect, $_POST['speakers_list']);
			$speakers_list = 0;
			$loggedin_userid = mysqli_real_escape_string($connect, $_POST['loggedin_userid']);	
			$uid = mysqli_real_escape_string($connect, $_POST['uid']);	
			$event_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['event_date'])));

			$st = date("H:i:s", strtotime($start_time));
			$et = date("H:i:s", strtotime($end_time));	

			$final_startdate= $event_date. ' ' .$st;
			$final_enddate= $event_date. ' ' .$et;

			$user_tz_data = mysqli_query($connect,"SELECT timezone FROM all_events WHERE id = '$event_id' ");
		   	$res_user_tz_data = mysqli_fetch_array($user_tz_data);
		   	$timezone_fetched = $res_user_tz_data['timezone'];
		   	if($timezone_fetched!='')
		   	{
		   		$user_tz_name = mysqli_query($connect,"SELECT timezone FROM timezones WHERE id = '$timezone_fetched' ");
			   	$res_user_tz_name = mysqli_fetch_array($user_tz_name);
			   	$timezone = $res_user_tz_name['timezone'];
		   	}else
		   	{
		   		$user_tz_name = mysqli_query($connect,"SELECT timezone FROM timezones WHERE id = '5'");
			   	$res_user_tz_name = mysqli_fetch_array($user_tz_name);
			   	$timezone = $res_user_tz_name['timezone'];
		   	}

			date_default_timezone_set($timezone);
			$a = strtotime($final_startdate);
			date_default_timezone_set("UTC");
			$new_time= date("Y-m-d H:i:s", $a) ;
			$date1 = new DateTime($new_time);
			$date1->modify("-8 hours"); 
			$start_utc_to_pst= $date1->format("Y-m-d H:i:s");	

			date_default_timezone_set($timezone);
			$b = strtotime($final_enddate);
			date_default_timezone_set("UTC");
			$new_time_val= date("Y-m-d H:i:s", $b) ;
			$date2 = new DateTime($new_time_val);
			$date2->modify("-8 hours"); 
			$end_utc_to_pst= $date2->format("Y-m-d H:i:s");


			$speakers_data = mysqli_query($connect,"select group_concat(speaker_id) as speakers_id from event_agenda_speakers where event_agenda_speakers.ep_id = '".$uid."' ");
			if(mysqli_num_rows($speakers_data) > 0)
       		{  
			   	$res = mysqli_fetch_array($speakers_data);
			   //	var_dump($speakers_list);exit(); 
			   	$speaker_list_res = $res['speakers_id'];
			   	if($speaker_list_res != "")
			   	{
			   		if(trim($speakers_list) != "" ){
			   			$speakers_list=$speaker_list_res . "," . $speakers_list;
			   		}else{
			   			$speakers_list=$speaker_list_res ;
			   		}
					
				}
			}

			$update_query="UPDATE event_presentation  SET presentation_topic='".$p_topic."',opportunity_type='".$opportunity_type."',location='".$location."', abstract='".$abstract."',start_time='".$start_time."',end_time='".$end_time."',topic_owner='".$topic_owner."',business_objective='".$bussiness_objective."',speakers_id='".$speakers_list."',event_date='".$event_date."',event_start_pst='".$start_utc_to_pst."',event_end_pst='".$end_utc_to_pst."',timezone='".$timezone."' WHERE ep_id=".$uid;

			mysqli_query($connect,$update_query); 

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Edit Event Agenda','".$uid."','".$loggedin_userid."',now(),\"".$update_query."\")");

			if( array_key_exists( 'edit_presentation_save_exit', $_POST ) )
			 {
			 	header('Location:../all_presentation.php?updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
			}else
			{
				header('Location:../edit_presentation.php?id='.base64_encode($uid).'&updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));	
			}

		break;

		case "create_status":
		   	$status = mysqli_real_escape_string($connect, $_POST['status']);
		   	$type = mysqli_real_escape_string($connect, $_GET['type']);
		   	$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
		   	
			$sql = "INSERT INTO all_status(status_name,last_edited_user_id,status_for,event_id) VALUES ('".$status."','".$id_user."','".$type."','".$event_id."')";
			mysqli_query($connect, $sql);
			$last_insert_id = mysqli_insert_id($connect);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','created new speaker status','".$last_insert_id."','".$id_user."',now(),\"".$sql."\")");

			header('Location:../email_status.php?type='.$type.'&created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;
		
		
	
		case "create_email_template":

			$event_id = mysqli_real_escape_string($connect, $_POST['ev_id']);
		   	$template_data = mysqli_real_escape_string($connect, $_POST['template_data']);
		   	$template_name = mysqli_real_escape_string($connect, $_POST['template_name']);
		   	$template_subject = mysqli_real_escape_string($connect, $_POST['template_subject']);
		   	$template_type = mysqli_real_escape_string($connect, implode(",",$_POST['template_type']));
		   	$status_id = mysqli_real_escape_string($connect, implode(",",$_POST['status_id']));
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);

			$sql = "INSERT INTO `all_email_templates` (`tanent_id`,`template_name`, `template_data`, `template_subject`, `status_id`, `created_by_user_id`,`template_type`, event_id) VALUES ('".$session_tanent_id."','".$template_name."', '".$template_data."', '".$template_subject."', '".$status_id."', '".$id_user."', '".$template_type."', '".$event_id."')";
			mysqli_query($connect, $sql);
			$last_insert_id = mysqli_insert_id($connect);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','created new template','".$last_insert_id."','".$id_user."',now(),\"".$sql."\")");

			header('Location:../email_template.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

       case "update-personal-user":

        	$logged_in_user= $_SESSION['user_id'];
			$session_tanent_id=  $common->get_tenant_id_from_userid($logged_in_user);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $fname = mysqli_real_escape_string($connect, $_POST['person_fname']);
            $lname = mysqli_real_escape_string($connect, $_POST['person_lname']);
            $work_phone_number = mysqli_real_escape_string($connect, $_POST['work_phone']);
            $phone_number = mysqli_real_escape_string($connect, $_POST['mobile_phone']);
            $linkedin_url = mysqli_real_escape_string($connect, $_POST['linkedinurl']);
            $job_title = mysqli_real_escape_string($connect, $_POST['job_title']);
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $organization_name = mysqli_real_escape_string($connect, $_POST['organization_name']);

            $d=strtotime("now");
            $updated_date = date("Y-m-d h:i:s", $d);

            $directoryName="../images/user_images/";
            $profile_pic = '';
            if($_POST['image_src']) {

                $file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
                $profile_pic=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
                list($type, $file) = explode(';', $file);
                list(, $file)      = explode(',', $file);
                file_put_contents($directoryName.$profile_pic , base64_decode($file));
                mysqli_query($connect, "UPDATE all_users  SET  profile_pic='".$profile_pic."' WHERE user_id=".$id);
            }


            $content = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000000">
			<div style="width:680px">
			  <p style="margin-top:0px;margin-bottom:15">Dear '.$name.', <br></p>
			  <p style="margin-top:0px;margin-bottom:15px">Your profile got updated!</p>
			  <p style="margin-top:0px;margin-bottom:15px">You can login to our website using your email address and password by visiting this URL:</p>
			  <p style="margin-top:0px;margin-bottom:15px"><a href="'.$site_url.'" target="_blank" >'.$site_url.'</a></p>
			  <p style="margin-top:0px;margin-bottom:15px"><br><br>Thanks,<br>
			Speaker Engage Team</p>
			</div>
			</div>';
            $common->sendEmail($email, $user_email, "Profile Updated - Speaker Engage", $content);

            $updateqry="UPDATE all_users  SET first_name='".$fname."',last_name='".$lname."', phone_number='".$phone_number."',confirmcode='y', work_phone_number='".$work_phone_number."', job_title='".$job_title."',organization_name='".$organization_name."',linkedin_url='".$linkedin_url."' WHERE user_id=".$id;

            mysqli_query($connect,$updateqry);

            mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','0','Update Profile','".$id."','".$logged_in_user."',now(),\"".$updateqry."\")");

            header('Location:../personal-settings.php?id='.base64_encode($id).'&updated-success');

            break;

			case "edit_email_template":

			$event_id = mysqli_real_escape_string($connect, $_POST['ev_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$loggedin_user_id = $_SESSION['user_id'];

		   	$template_data = mysqli_real_escape_string($connect, $_POST['template_data']);
		   	$template_name = mysqli_real_escape_string($connect, $_POST['template_name']);
		   	$template_subject = mysqli_real_escape_string($connect, $_POST['template_subject']);
		   	$template_type = mysqli_real_escape_string($connect, implode(",",$_POST['template_type']));
		   	$status_id = mysqli_real_escape_string($connect, implode(",",$_POST['status_id']));
		   	$id = mysqli_real_escape_string($connect, $_POST['template_id']);

		   	
		   	$check_temp_exist = mysqli_query($connect, "SELECT * FROM `all_email_templates` WHERE `event_id` = '".$event_id."' AND id = '".$id."' ");
		   	if(mysqli_num_rows($check_temp_exist)> 0){
		   		$sql = "UPDATE `all_email_templates` SET `template_name`='".$template_name."', `template_data`='".$template_data."', `template_subject`='".$template_subject."',`template_type`='".$template_type."',`status_id`='".$status_id."',`is_edited`='1' WHERE id=".$id;
		   	}else{

		   		$sql = "INSERT INTO `all_email_templates` (template_name,template_subject,template_data,status_id,template_type,created_by_user_id,event_id,is_edited,tanent_id) VALUES ('$template_name','$template_subject','$template_data','$status_id','$template_type','$loggedin_user_id','$event_id','1','$session_tanent_id') ";		   		
		   	}
			
			mysqli_query($connect, $sql);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Edited new template','".$id."','".$loggedin_user_id."',now(),\"".$sql."\")");
			
			header('Location:../email_template.php?edited-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

		
		case "send_email_notify":


			$template_data = $_POST['template_data'];			
				// var_dump($template_data); exit();
			if(strpos($template_data, $site_url)==false){				
				$template_data = str_replace("images/",$site_url."/images/",$_POST['template_data']);
			}
			
			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
		   	$template_subject =  $_POST['template_subject'];
		   	$template_id = mysqli_real_escape_string($connect, $_POST['template_id']);
		   	$speaker_id = mysqli_real_escape_string($connect, $_POST['speaker_id']);
		   	$speaker_manager_email = mysqli_real_escape_string($connect, trim($_POST['speaker_manager_email']));
		   //	$cc_mails = trim($_POST['cc_emails']);


		   	//********** check sendgrid api ***************8//
		   		/*$sg_response = $common->check_sendgrid_status('azure_b507cb73c99ce901258a90b5ee0dfed8@azure.com','Mailsent11!');
		   		$sg_response_decoded = json_decode($sg_response);
				// var_dump($sg_response_decoded); 
			 	$is_active = $sg_response_decoded[0]->active;
			 	if($is_active != '' && $is_active != null && $is_active =='true'){

			 		// trigger emails

			 		//echo $is_active;
			 	}else{
			 		header('Location:../notify.php?id='.base64_encode($speaker_id).'&mail-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

			 	}*/



		   	$loggedin_user_id = $_SESSION['user_id'];
		   	$loggedin_user_data = mysqli_query($connect,"SELECT first_name FROM all_users WHERE user_id = '$loggedin_user_id' ");
		   	$res_loggedin_user = mysqli_fetch_array($loggedin_user_data);
		   	$loggedin_user_name = $res_loggedin_user['first_name'];
			
			
			$speaker_sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM all_speakers WHERE id=".$speaker_id));	
			$arr = explode(" ",$speaker_sql['speaker_name']);
			$speaker_manager_arr = explode(" ",$speaker_sql['speaker_manager']);

			$spk_name = '';
			if($arr[0]=='' || $arr[0]==null || $arr[0]=='null' || $arr[0]==' ')
		   	{
		   		$spk_name ='';
		   	}else{
		   		$spk_name =$arr[0];
		   	}

		   	$speaker_manager = '';
			if($speaker_manager_arr[0]=='' || $speaker_manager_arr[0]==null || $speaker_manager_arr[0]=='null' || $speaker_manager_arr[0]==' ')
		   	{
		   		$speaker_manager ='';
		   	}else{
		   		$speaker_manager = $speaker_manager_arr[0];
		   	}

			$template_data1 = str_replace("[person-name]",$spk_name,$template_data);

			//format_manager email
				$formatted_manager_email = rtrim($speaker_manager_email,",");
				
				if($formatted_manager_email != '' ){
					// $template_data2 = str_replace("[person-name]",$speaker_manager,$template_data);
					$template_data2 = str_replace("[person-name]",'',$template_data);



					$email = $common->sendEmail($formatted_manager_email, $user_email, $template_subject, $template_data2,$loggedin_user_name);// send mail to speaker
				}

				$cc_mails = '';
				if($_POST['cc_emails'] != '' ){
					$cc_mails = trim($_POST['cc_emails']);
				}

			$insertqry="INSERT INTO all_logs(tanent_id,operation,table_id,table_name,other_column_name,other_column_value,created_by,sql_qry,cc_emails,email_subject,email_content,speaker_manager_email,event_id) VALUES ('".$session_tanent_id."','sent email to speaker','".$speaker_id."','all_speakers','template_id','".$template_id."','".$id_user."','','".$_POST['cc_emails']."','".mysqli_real_escape_string($connect,$template_subject)."','".mysqli_real_escape_string($connect, $template_data1)."','".$speaker_manager_email."','".$event_id."')";

			mysqli_query($connect,$insertqry);
			$last_insert_id = mysqli_insert_id($connect);

			$email = $common->sendEmail($speaker_sql['email_id'], $user_email, $template_subject, $template_data1."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name,$cc_mails);// send mail to speaker
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Notify-speaker','".$speaker_id."','".$loggedin_user_id."',now(),\"".$insertqry."\")");

			$calculate_template_usage_func = $common->calculate_template_usage($template_id,$event_id,1);
			$type_update = $common->calculate_speaker_type_count($event_id);
			// update email count
			$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_speakers` WHERE `id` = '".$speaker_id."' ");
			$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
			$spk_email_count = $res_spk_email_count['mail_sent_count'];
			$new_count = $spk_email_count+ 1;
			$update_spk_email_count = mysqli_query($connect,"UPDATE `all_speakers` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$speaker_id."' ");

			//*********** all_event_email_count
			$fetch_event_email_count = mysqli_query($connect,"SELECT speaker_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
			$res_email_count = mysqli_fetch_array($fetch_event_email_count);
			$total_email_count = $res_email_count['speaker_email_count'];
			$new_total_count = $total_email_count + 1;
			$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `speaker_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

			header('Location:../notify.php?id='.base64_encode($speaker_id).'&mail-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));


		break;
		
		case "send_sponsor_email_notify":
			$template_data = $_POST['template_data'];
			
			if(strpos($template_data, $site_url)==false){
				
				$template_data = str_replace("images/",$site_url."/images/",$_POST['template_data']);
			} 

		    // $event_id = $_SESSION['current_event_id'];
		    $event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']);
		    $session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
		   	$template_subject =  $_POST['template_subject'];
		   	$template_id = mysqli_real_escape_string($connect, $_POST['template_id']);
		   	$sponsor_id = mysqli_real_escape_string($connect, $_POST['sponsor_id']);
		   	$cc_mails = trim($_POST['cc_emails']);
		   	$cc_mails_all = '';

		   	$loggedin_user_id = $_SESSION['user_id'];
		   	$loggedin_user_data = mysqli_query($connect,"SELECT first_name FROM all_users WHERE user_id = '$loggedin_user_id' ");
		   	$res_loggedin_user = mysqli_fetch_array($loggedin_user_data);
		   	$loggedin_user_name = $res_loggedin_user['first_name'];	   
			
			
			$sponsor_sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM all_sponsors WHERE id=".$sponsor_id));	
			$arr = explode(" ",$sponsor_sql['sponsor_company_name']);
			$to_sponsor = $sponsor_sql['sponsor_contact_person'];
			$fname = explode(" ", $to_sponsor);
			$to_sponsor = $fname[0];

			if($to_sponsor=='' || $to_sponsor==null || $to_sponsor=='null' || $to_sponsor==' ')
			 {
			   $to_sponsor='';
			  }

			// $template_data = str_replace("[person-name]",$arr[0],$template_data);
			$template_data1 = str_replace("[person-name]",$to_sponsor,$template_data); 

			$include_ex_sponsor = mysqli_real_escape_string($connect, $_POST['include_ex_sponsor']);
			
			if($include_ex_sponsor=='yes')
			{
				$excutive_sp_email = mysqli_query($connect,"SELECT secondary1_sponsor_contact_email_address,secondary1_sponsor_contact_person FROM all_sponsors WHERE id = '$sponsor_id' ");
			   	$exsp_email = mysqli_fetch_array($excutive_sp_email);
			   	$executive_mail = $exsp_email['secondary1_sponsor_contact_email_address'];
			   	$cc_mails_all .= $executive_mail;			  	

			}
			
			

			//all cc emails

			if($cc_mails_all != '')
			{
				$cc_mails_all .=','.$cc_mails;

			}else{
				$cc_mails_all = $cc_mails;
			}


			mysqli_query($connect, "INSERT INTO all_logs(tanent_id,operation,table_id,table_name,other_column_name,other_column_value,created_by,sql_qry,cc_emails,email_subject,email_content,speaker_manager_email,event_id) VALUES ('".$session_tanent_id."','sent email to sponsor','".$sponsor_id."','all_sponsors','template_id','".$template_id."','".$id_user."','','".$_POST['cc_emails']."','".mysqli_real_escape_string($connect,$template_subject)."','".mysqli_real_escape_string($connect, $template_data1)."','','".$event_id."')");
			$last_insert_id = mysqli_insert_id($connect);
			// send mail to sponsor
			$email = $common->sendEmail($sponsor_sql['sponsor_contact_email_address'], $user_email, $template_subject, $template_data1."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name,$cc_mails_all);

			$calculate_template_usage_func = $common->calculate_template_usage($template_id,$event_id,2);
			$type_update = $common->calculate_sponsor_type_count($event_id);

			// update email count
			$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_sponsors` WHERE `id` = '".$sponsor_id."' ");
			$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
			$spk_email_count = $res_spk_email_count['mail_sent_count'];
			$new_count = $spk_email_count+ 1;
			$update_spk_email_count = mysqli_query($connect,"UPDATE `all_sponsors` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$sponsor_id."' ");

			//*********** all_event_email_count
			$fetch_event_email_count = mysqli_query($connect,"SELECT sponsor_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
			$res_email_count = mysqli_fetch_array($fetch_event_email_count);
			$total_email_count = $res_email_count['sponsor_email_count'];
			$new_total_count = $total_email_count + 1;
			$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `sponsor_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

			 header('Location:../sponsor-notify.php?id='.base64_encode($sponsor_id).'&mail-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)) );
		break;
		
		case "send_master_email_notify":
			$template_data = $_POST['template_data'];
			if(strpos($template_data, $site_url)==false){
				
				$template_data = str_replace("images/",$site_url."/images/",$_POST['template_data']);
			}

		    $event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
		   	$template_subject =  $_POST['template_subject'];
		   	$template_id = mysqli_real_escape_string($connect, $_POST['template_id']);
		   	$master_id = mysqli_real_escape_string($connect, $_POST['master_id']);
		   
			$cc_mails = trim($_POST['cc_emails']);
			
			$master_sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM all_masters WHERE id=".$master_id));		
			$arr = explode(" ",$master_sql['master_name']);
			$master_name = '';
			if($arr[0]=='' || $arr[0]==null || $arr[0]=='null' || $arr[0]==' ')
		   	{
		   		$master_name ='';
		   	}else{
		   		$master_name =$arr[0];
		   	}
			$template_data = str_replace("[person-name]",$master_name,$template_data);

			$loggedin_user_id = $_SESSION['user_id'];
		   	$loggedin_user_data = mysqli_query($connect,"SELECT first_name FROM all_users WHERE user_id = '$loggedin_user_id' ");
		   	$res_loggedin_user = mysqli_fetch_array($loggedin_user_data);
		   	$loggedin_user_name = $res_loggedin_user['first_name'];


			$insertqry= "INSERT INTO all_logs(tanent_id,operation,table_id,table_name,other_column_name,other_column_value,created_by,sql_qry,cc_emails,email_subject,email_content,speaker_manager_email,event_id) VALUES ('".$session_tanent_id."','sent email to master','".$master_id."','all_masters','template_id','".$template_id."','".$id_user."','','".$_POST['cc_emails']."','".mysqli_real_escape_string($connect,$template_subject)."','".mysqli_real_escape_string($connect, $template_data)."','','".$event_id."')";
			mysqli_query($connect,$insertqry);
			$last_insert_id = mysqli_insert_id($connect);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Notify-Master','".$master_id."','".$id_user."',now(),\"".$insertqry."\")");

			$email = $common->sendEmail($master_sql['email_id'], $user_email, $template_subject, $template_data."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name,$cc_mails);// send mail to master

			$calculate_template_usage_func = $common->calculate_template_usage($template_id,$event_id,3);
			$type_update = $common->calculate_master_type_count($event_id);

				// update email count
			$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_masters` WHERE `id` = '".$master_id."' ");
			$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
			$spk_email_count = $res_spk_email_count['mail_sent_count'];
			$new_count = $spk_email_count+ 1;
			$update_spk_email_count = mysqli_query($connect,"UPDATE `all_masters` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$master_id."' ");

			//*********** all_event_email_count
			$fetch_event_email_count = mysqli_query($connect,"SELECT master_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
			$res_email_count = mysqli_fetch_array($fetch_event_email_count);
			$total_email_count = $res_email_count['master_email_count'];
			$new_total_count = $total_email_count + 1;
			$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `master_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

			header('Location:../master-notify.php?id='.base64_encode($master_id).'&mail-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;
		
		
		case "bulk_send_email_notify":
			$template_data = $_POST['template_data'];
			$speakers_list_arr = $_POST['speakers_list'];
			$willing = $_POST['willing'];
			if(strpos($template_data, $site_url)==false){
				$template_data = str_replace("images/",$site_url."/images/",$_POST['template_data']);
			}

		    $event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
		    $session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
		   	$template_subject =  $_POST['template_subject'];
		   	$template_id = mysqli_real_escape_string($connect, $_POST['template_id']);
		   	$loggedin_user_id = $_SESSION['user_id'];
			
			$cc_emails_arr = explode(",",$_POST['cc_emails']);
			$template_data_real = $template_data;

			//loggedin user details
			$loggedin_user_id = $_SESSION['user_id'];
		   	$loggedin_user_data = mysqli_query($connect,"SELECT first_name FROM all_users WHERE user_id = '$loggedin_user_id' ");
		   	$res_loggedin_user = mysqli_fetch_array($loggedin_user_data);
		   	$loggedin_user_name = $res_loggedin_user['first_name'];
		   	
			foreach($speakers_list_arr as $speakers_list_id){
				$speaker_sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM all_speakers WHERE id=".$speakers_list_id));
				$speaker_id = $speaker_sql['id'];
				$arr = explode(" ",$speaker_sql['speaker_name']);
				$spk_fname = '';
					if($arr[0]=='' || $arr[0]==null || $arr[0]=='null' || $arr[0]==' ')
		   			{
		   				$spk_fname ='';
		   			}else{
		   				$spk_fname =$arr[0];
		   			}


				$template_data_final = str_replace("[person-name]",$spk_fname,$template_data_real);
				
				
				if($willing=="yes"){
					$speaker_manager_email = $speaker_sql['speaker_manager_email'];
					$speaker_manager_name = $speaker_sql['speaker_manager'];
					if($speaker_manager_name=='' || $speaker_manager_name==null || $speaker_manager_name=='null' || $speaker_manager_name==' ')
		   			{
		   				$speaker_manager_name ='';
		   			}else{
		   				$speaker_manager_name =$speaker_sql['speaker_manager'];
		   			}
		   			$template_data_mgr = str_replace("[person-name]",$speaker_manager_name,$template_data_real);
					$email1 = $common->sendEmail($speaker_manager_email, $user_email, $template_subject, $template_data_mgr,$loggedin_user_name);// Send mail to manager
				}

				$insertqry="INSERT INTO all_logs(tanent_id,operation,table_id,table_name,other_column_name,other_column_value,created_by,sql_qry,cc_emails,email_subject,email_content,speaker_manager_email,event_id) VALUES ('".$session_tanent_id."','sent email to speaker','".$speaker_id."','all_speakers','template_id','".$template_id."','".$id_user."','','".$_POST['cc_emails']."','".mysqli_real_escape_string($connect,$template_subject)."','".mysqli_real_escape_string($connect,$template_data_final)."','".$speaker_manager_email."','".$event_id."')";

				mysqli_query($connect,$insertqry);

				$last_insert_id = mysqli_insert_id($connect);
				// send mail to speaker
				$email = $common->sendEmail($speaker_sql['email_id'], $user_email, $template_subject, $template_data_final."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);

				

				// update email count
				$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_speakers` WHERE `id` = '".$speaker_id."' ");
				$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
				$spk_email_count = $res_spk_email_count['mail_sent_count'];
				$new_count = $spk_email_count+ 1;
				$update_spk_email_count = mysqli_query($connect,"UPDATE `all_speakers` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$speaker_id."' ");

				//*********** all_event_email_count
				$fetch_event_email_count = mysqli_query($connect,"SELECT speaker_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
				$res_email_count = mysqli_fetch_array($fetch_event_email_count);
				$total_email_count = $res_email_count['speaker_email_count'];
				$new_total_count = $total_email_count + 1;
				$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `speaker_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' "); 


				mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Bulk Notify-speaker','".$speaker_id."','".$loggedin_user_id."',now(),\"".$insertqry."\")");
			}
			
			foreach($cc_emails_arr as $cc_email){
				$em = trim($cc_email);
				if(!empty($em)){
					$template_data_final_cc = str_replace("[person-name]",'',$template_data_real);

					$common->sendEmail($em, $user_email, $template_subject, $template_data_final_cc,$loggedin_user_name);// Send mail to cc email ids					
				}
			}

			$calculate_template_usage_func = $common->calculate_template_usage($template_id,$event_id,1);
			$type_update = $common->calculate_speaker_type_count($event_id);
			
		  
		   header('Location:../bulk-notify.php?mail-succes&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;
		
		case "sponsor_bulk_send_email_notify":

			// $event_id = $_SESSION['current_event_id'];
			$event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']);
			 $session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$template_data = $_POST['template_data'];
			$sponsors_list_arr = $_POST['sponsors_list2'];
			$willing = $_POST['willing'];
			if(strpos($template_data, $site_url)==false){
				$template_data = str_replace("images/",$site_url."/images/",$_POST['template_data']);
			}
		     
		   	$template_subject =  $_POST['template_subject'];
		   	$template_id = mysqli_real_escape_string($connect, $_POST['template_id']);
			
			$cc_emails_arr = explode(",",$_POST['cc_emails']);
			$template_data_real = $template_data;

			// loggedin users details
			$loggedin_user_id = $_SESSION['user_id'];
		   	$loggedin_user_data = mysqli_query($connect,"SELECT first_name FROM all_users WHERE user_id = '$loggedin_user_id' ");
		   	$res_loggedin_user = mysqli_fetch_array($loggedin_user_data);
		   	$loggedin_user_name = $res_loggedin_user['first_name'];

		   	
			foreach($sponsors_list_arr as $sponsors_list_id){
				// ".$sponsors_list_id."

				$sponsor_sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM all_sponsors WHERE id='$sponsors_list_id' AND event_id = '".$event_id."' "  ));
				$sponsor_id = $sponsor_sql['id'];
				$arr = explode(" ",$sponsor_sql['sponsor_company_name']);
				$to_sponsor = $sponsor_sql['sponsor_contact_person'];
				$fname = explode(" ", $to_sponsor);
				$to_sponsor = $fname[0];

				if($to_sponsor=='' || $to_sponsor==null || $to_sponsor=='null' || $to_sponsor==' ')
			   	{
			   		$to_sponsor='';
			   	}
				// $template_data = str_replace("[person-name]",$arr[0],$template_data_real);
				$template_data_final = str_replace("[person-name]",$to_sponsor,$template_data_real);
				
				
				mysqli_query($connect, "INSERT INTO all_logs(tanent_id,operation,table_id,table_name,other_column_name,other_column_value,created_by,sql_qry,cc_emails,email_subject,email_content,speaker_manager_email,event_id) VALUES ('".$session_tanent_id."','sent email to sponsor','".$sponsor_id."','all_sponsors','template_id','".$template_id."','".$id_user."','','".$_POST['cc_emails']."','".mysqli_real_escape_string($connect,$template_subject)."','".mysqli_real_escape_string($connect,$template_data_final)."','','".$event_id."')");


				$last_insert_id = mysqli_insert_id($connect);
				
				$email = $common->sendEmail($sponsor_sql['sponsor_contact_email_address'], $user_email, $template_subject, $template_data_final."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name );// send mail to sponsor

				//-------------------------------------sending to executive sponsors---------------------------------------------------


				$include_ex_sponsor = mysqli_real_escape_string($connect, $_POST['include_ex_sponsor']);
			
				if($include_ex_sponsor=='yes')
				{
					$excutive_sp_email = mysqli_query($connect,"SELECT secondary1_sponsor_contact_email_address,secondary1_sponsor_contact_person FROM all_sponsors WHERE id = '$sponsor_id' ");
				   	$exsp_email = mysqli_fetch_array($excutive_sp_email);
				   	$executive_mail = $exsp_email['secondary1_sponsor_contact_email_address'];
				   	$executive_name = $exsp_email['secondary1_sponsor_contact_person'];
				   		if($executive_name=='' || $executive_name==null || $executive_name=='null' || $executive_name==' ')
			   			{
			   				$executive_name='';
			   			}
				   	$template_data_finalcc = str_replace("[person-name]",$executive_name,$template_data_real);

				   	if(!empty($executive_mail))
				   	{
				   		$common->sendEmail($executive_mail, $user_email, $template_subject, $template_data_finalcc,$loggedin_user_name);
				   	}	
				}

				// update email count
				$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_sponsors` WHERE `id` = '".$sponsor_id."' ");
				$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
				$spk_email_count = $res_spk_email_count['mail_sent_count'];
				$new_count = $spk_email_count+ 1;
				$update_spk_email_count = mysqli_query($connect,"UPDATE `all_sponsors` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$sponsor_id."' ");

				//*********** all_event_email_count
				$fetch_event_email_count = mysqli_query($connect,"SELECT sponsor_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
				$res_email_count = mysqli_fetch_array($fetch_event_email_count);
				$total_email_count = $res_email_count['sponsor_email_count'];
				$new_total_count = $total_email_count + 1;
				$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `sponsor_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

			}
			
			foreach($cc_emails_arr as $cc_email){
				$em = trim($cc_email);
				if(!empty($em)){

					$template_data_for_cc = str_replace("[person-name]",'',$template_data_real);


					$common->sendEmail($em, $user_email, $template_subject, $template_data_for_cc, $loggedin_user_name);// Send mail to cc email ids
				}
			}

			$calculate_template_usage_func = $common->calculate_template_usage($template_id,$event_id,2);
			$type_update = $common->calculate_sponsor_type_count($event_id);
			
		   header('Location:../sponsor-bulk-notify.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&mail-success');
		break;


		case "master_bulk_send_email_notify":

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
		    $session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);

			$template_data = $_POST['template_data'];
			$masters_list_arr = $_POST['masters_list'];
			$master_type_arr = $_POST['master_type'];

			$willing = $_POST['willing'];
			if(strpos($template_data, $site_url)==false){
				$template_data = str_replace("images/",$site_url."/images/",$_POST['template_data']);
			}
		     
		   	$template_subject =  $_POST['template_subject'];
		   	$template_id = mysqli_real_escape_string($connect, $_POST['template_id']);
			
			$cc_emails_arr = explode(",",$_POST['cc_emails']);
			$template_data_real = $template_data;

			// logged in user details			
			$loggedin_user_id = $_SESSION['user_id'];
		   	$loggedin_user_data = mysqli_query($connect,"SELECT first_name FROM all_users WHERE user_id = '$loggedin_user_id' ");
		   	$res_loggedin_user = mysqli_fetch_array($loggedin_user_data);
		   	$loggedin_user_name = $res_loggedin_user['first_name'];

			if(count($master_type_arr) > 0){

				foreach($master_type_arr as $masters_type){
					
				$master_type_sql = mysqli_query($connect, "SELECT * FROM all_masters WHERE master_type LIKE '%".$masters_type."%' AND event_id = '".$event_id."' ");					
					
					if(mysqli_num_rows($master_type_sql) > 0){

						while ($res_master = mysqli_fetch_array($master_type_sql)) {
							$master_id = $res_master['id'];
							$arr = explode(" ",$res_master['master_name']);
							$master_fname = '';
							if($arr[0]=='' ||$arr[0]==null || $arr[0]=='null' || $arr[0]==' ')
				   			{
				   				$master_fname ='';
				   			}else{
				   				$master_fname =$arr[0];
				   			}

							$template_data_final = str_replace("[person-name]",$master_fname,$template_data_real);


							$insertqry= "INSERT INTO all_logs(tanent_id,operation,table_id,table_name,other_column_name,other_column_value,created_by,sql_qry,cc_emails,email_subject,email_content,speaker_manager_email,event_id) VALUES ('".$session_tanent_id."','sent email to master','".$master_id."','all_masters','template_id','".$template_id."','".$id_user."','','".$_POST['cc_emails']."','".mysqli_real_escape_string($connect,$template_subject)."','".mysqli_real_escape_string($connect,$template_data_final)."','','".$event_id."')";
							mysqli_query($connect,$insertqry);

							$last_insert_id = mysqli_insert_id($connect);

							$email = $common->sendEmail($res_master['email_id'], $user_email, $template_subject, $template_data_final."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);

							mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Bulk Notify-Master','".$master_id."','".$id_user."',now(),\"".$insertqry."\")");

							// update email count
						$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_masters` WHERE `id` = '".$master_id."' ");
						$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
						$spk_email_count = $res_spk_email_count['mail_sent_count'];
						$new_count = $spk_email_count+ 1;
						$update_spk_email_count = mysqli_query($connect,"UPDATE `all_masters` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$master_id."' ");

						//*********** all_event_email_count
						$fetch_event_email_count = mysqli_query($connect,"SELECT master_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
						$res_email_count = mysqli_fetch_array($fetch_event_email_count);
						$total_email_count = $res_email_count['master_email_count'];
						$new_total_count = $total_email_count + 1;
						$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `master_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

						} //while
					} // end of if						
					
				} // end of foreach


			}else{
		   	
				foreach($masters_list_arr as $masters_list_id){
					$master_sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM all_masters WHERE id=".$masters_list_id));
					$master_id = $master_sql['id'];
					$arr = explode(" ",$master_sql['master_name']);
					$master_fname = '';
					if($arr[0]=='' || $arr[0]==null || $arr[0]=='null' || $arr[0]==' ')
		   			{
		   				$master_fname ='';
		   			}else{
		   				$master_fname =$arr[0];
		   			}

					$template_data_masterlist = str_replace("[person-name]",$master_fname,$template_data_real);					
					
					
					$insertqry="INSERT INTO all_logs(tanent_id,operation,table_id,table_name,other_column_name,other_column_value,created_by,sql_qry,cc_emails,email_subject,email_content,speaker_manager_email,event_id) VALUES ('".$session_tanent_id."','sent email to master','".$master_id."','all_masters','template_id','".$template_id."','".$id_user."','','".$_POST['cc_emails']."','".mysqli_real_escape_string($connect,$template_subject)."','".mysqli_real_escape_string($connect,$template_data_masterlist)."','','".$event_id."')";
					mysqli_query($connect,$insertqry);
					$last_insert_id = mysqli_insert_id($connect);
					
					// send mail to master
					$email = $common->sendEmail($master_sql['email_id'], $user_email, $template_subject, $template_data_masterlist."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);

					mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Bulk Notify-Master','".$master_id."','".$id_user."',now(),\"".$insertqry."\")");

					// update email count
						$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_masters` WHERE `id` = '".$master_id."' ");
						$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
						$spk_email_count = $res_spk_email_count['mail_sent_count'];
						$new_count = $spk_email_count+ 1;
						$update_spk_email_count = mysqli_query($connect,"UPDATE `all_masters` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$master_id."' ");

						//*********** all_event_email_count
						$fetch_event_email_count = mysqli_query($connect,"SELECT master_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
						$res_email_count = mysqli_fetch_array($fetch_event_email_count);
						$total_email_count = $res_email_count['master_email_count'];
						$new_total_count = $total_email_count + 1;
						$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `master_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");
				}
			
			}
			
			foreach($cc_emails_arr as $cc_email){
				$em = trim($cc_email);
				if(!empty($em)){
					$template_data_for_cc = str_replace("[person-name]",'',$template_data_real);
					$common->sendEmail($em, $user_email, $template_subject, $template_data_for_cc,$loggedin_user_name);// Send mail to cc email ids
				}
			}

			$calculate_template_usage_func = $common->calculate_template_usage($template_id,$event_id,3);
			$type_update = $common->calculate_master_type_count($event_id);

		   header('Location:../master-bulk-notify.php?mail-succes&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;
		

		
		
		case "profile_edit":

		$name = mysqli_real_escape_string($connect, $_POST['person_name']);
		$email = mysqli_real_escape_string($connect, $_POST['email']);
		$user_email = 	$_SESSION['user_email'] = $email;
		$gender = mysqli_real_escape_string($connect, $_POST['gender']);
		$phone_number = mysqli_real_escape_string($connect, $_POST['phone_number']);
		$birth_day = mysqli_real_escape_string($connect, $_POST['birth_day']);
		$role = mysqli_real_escape_string($connect, $_POST['role']);
		$organization_name = mysqli_real_escape_string($connect, $_POST['organization_name']);
		$id = mysqli_real_escape_string($connect, $_POST['id']);
		
		$password = mysqli_real_escape_string($connect, $_POST['password']);
		$password1 = mysqli_real_escape_string($connect, $_POST['password1']);
		if($password1 !== $password && !empty($password)){
			$enc_pwd = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 11]);
			mysqli_query($connect, "UPDATE all_users  SET password='".$enc_pwd."' WHERE user_id=".$id);
		}
		$d=strtotime("now");
		$updated_date = date("Y-m-d h:i:s", $d);
		
		 
		if (!isset($_FILES['image']['tmp_name'])) {
			$profile_pic = "";
		}
		else{
			$file=$_FILES['image']['tmp_name'];
			if($file){
				$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
				$image_name= addslashes($_FILES['image']['name']);
				$extension = pathinfo($image_name, PATHINFO_EXTENSION);
				$profileImage = time().".".$extension;
				$profile_pic = $profileImage;	
				move_uploaded_file($_FILES["image"]["tmp_name"],"../images/user_images/" . $profileImage);
				mysqli_query($connect, "UPDATE all_users  SET  profile_pic='".$profile_pic."' WHERE user_id=".$id);
			}
			
		
		}
		mysqli_query($connect, "UPDATE all_users  SET first_name='".$name."',gender='".$gender."',first_name='".$name."', phone_number='".$phone_number."',email='".$email."',confirmcode='y',organization_name='".$organization_name."' WHERE user_id=".$id);     
				header('Location:../edit-profile.php?id='.base64_encode($id).'&updated-success');
			break;
		
		
		case "speakers_upload":
		   	require "../spreadsheet-reader-master/php-excel-reader/excel_reader2.php";
			require "../spreadsheet-reader-master/SpreadsheetReader.php";
			
			$uploaddir = '../uploaded-files/';
			$uploadfile = $uploaddir . basename($_FILES['file']['name']);
			move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
			$Filepath       = $uploadfile;
			$Spreadsheet    = new SpreadsheetReader($Filepath);
			$Sheets         = $Spreadsheet -> Sheets();	

			$subsystem_arr = $component_arr = $sub_component_arr = $md_array=array();
			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$logged_in_user= $_SESSION['user_id'];
			$session_tanent_id =  $common->get_tenant_id_from_eventid($event_id);
			$ids_vals = 0;

			//*********************************************************
				// check total contact count 
				$total_contact = $common->get_total_contacts_count_by_tenantid($session_tanent_id);

				// fetch_user_details
				$fetch_user_details = mysqli_query($connect,"SELECT * FROM `all_users` WHERE `user_id` = '".$logged_in_user."' ");
				$res_user = mysqli_fetch_array($fetch_user_details);
				$subscription_id = $res_user['subscription_id'];				

				 $check_tenant_subs = mysqli_query($connect,"SELECT * FROM `all_tenants` WHERE `id` = '".$session_tanent_id."' ");  
		        $res_ten = mysqli_fetch_array($check_tenant_subs);
		        $tenant_created_at = date('Y-m-d',strtotime($res_ten['created_at']));

		        $now = time(); // or your date as well
	            $your_date = strtotime($tenant_created_at);
	            $datediff = $now - $your_date;
	            $final_date= round($datediff / (60 * 60 * 24));

		        if($final_date < 100){   
                if($subscription_id != ''){

                	$subs_details = $common->subscription_retrive_by_subscription_id($subscription_id);
				    $plan_id_fetched = $subs_details['subscription']->planId;

				    $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = '".$plan_id_fetched."' ");
				    $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);
					$contact_limit = $res_contact_limit['contact_limit'];


                }else{

                    //if not subscribed any plan and tenant in trial period
				    $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = 'essential' ");
				    $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);
					$contact_limit = $res_contact_limit['contact_limit'];

                }              

            }else{
            	    $subs_details = $common->subscription_retrive_by_subscription_id($subscription_id);
				    $plan_id_fetched = $subs_details['subscription']->planId;

				    $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = '".$plan_id_fetched."' ");
				    $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);
					$contact_limit = $res_contact_limit['contact_limit'];                   
            }
					
			 if($contact_limit > $total_contact){

			 	$remaining_limit = $contact_limit - $total_contact;

			 	$new_records_count = 0;
				 foreach ($Sheets as $Index => $Name)
				 {
					
					$Spreadsheet -> ChangeSheet($Index);							
					$f = 1;
					foreach ($Spreadsheet as $Key => $Row)
					{
						if($f>1){
							
							if(count($Row)==23){
								
								$filesop_c = $Row;
								$id = mysqli_real_escape_string($connect, $filesop_c[0]);
								$spk_email = mysqli_real_escape_string($connect, $filesop_c[2]);

								if( ($id == '' || $id == ' ') && $spk_email != ''){
									$new_records_count++;
								}							
							}else if(count($Row)==22){
								//******
							}
						}					
						$f++;
					}

				}	

				//var_dump($remaining_limit." || ".$new_records_count); exit();
				if($remaining_limit >= $new_records_count){

			// *************************************		
			

			mysqli_query($connect, "DELETE FROM all_speakers_upload_temp WHERE event_id=".$event_id."");

			foreach ($Sheets as $Index => $Name)
			{
				
				$Spreadsheet -> ChangeSheet($Index);
							
				$m = 1;
				foreach ($Spreadsheet as $Key => $Row)
				{
					if(count($Row)<22 ){
						header('Location:../all-speakers.php?count='.$m.'&upload_error');
					}
					elseif(count($Row)==22 ){
						if($m>1){ 

							$filesop = $Row;					
							$name = mysqli_real_escape_string($connect, $filesop[0]);
							$email = mysqli_real_escape_string($connect, $filesop[1]);
							$company = mysqli_real_escape_string($connect, $filesop[2]);
							$phone = mysqli_real_escape_string($connect, $filesop[3]);
							$speaker_type = mysqli_real_escape_string($connect, $filesop[4]);
							$status = mysqli_real_escape_string($connect, $filesop[5]);
							$influencer_type = mysqli_real_escape_string($connect, $filesop[6]);
							$title = mysqli_real_escape_string($connect, $filesop[7]);
							$address1 = mysqli_real_escape_string($connect, $filesop[8]);
							$address2 = mysqli_real_escape_string($connect, $filesop[9]);
							$city = mysqli_real_escape_string($connect, $filesop[10]);
							$state = mysqli_real_escape_string($connect, $filesop[11]);
							$country = mysqli_real_escape_string($connect, $filesop[12]);
							$zip = mysqli_real_escape_string($connect, $filesop[13]);						
							$speaker_manager = mysqli_real_escape_string($connect, $filesop[14]);
							$speaker_manager_email = mysqli_real_escape_string($connect, $filesop[15]);						
							$speaker_manager_phone = mysqli_real_escape_string($connect, $filesop[16]);
							$linkedin_url = mysqli_real_escape_string($connect, $filesop[17]);
							$twitter_handle = mysqli_real_escape_string($connect, $filesop[18]);
							$speaker_requests = mysqli_real_escape_string($connect, $filesop[19]);
							$presentation_title1 = mysqli_real_escape_string($connect, $filesop[20]);
							$acknowledgements = mysqli_real_escape_string($connect, $filesop[21]);						

						if($email !='' && $email !=' ' && $email !=null && $email !='null')
						{
							$speaker_types_value = '';
							$fetch_speaker_type = mysqli_query($connect,"SELECT group_concat(id) as speaker_type FROM all_speaker_types where find_in_set(LOWER(`speaker_type_name`),LOWER('".$speaker_type."')) AND event_id='".$event_id."'");
							if(mysqli_num_rows($fetch_speaker_type) > 0){
								$res_type = mysqli_fetch_array($fetch_speaker_type);
									$speaker_types_value = $res_type['speaker_type'];
							}	

							$status_value = '';
							$fetch_speaker_status = mysqli_query($connect,"SELECT group_concat(id) as speaker_status FROM all_status where status_for = 'speaker' AND event_id='".$event_id."' AND FIND_IN_SET(LOWER(`status_name`),LOWER('".$status."'))");
							if(mysqli_num_rows($fetch_speaker_status) > 0){
								$res_status = mysqli_fetch_array($fetch_speaker_status);
									$status_value = $res_status['speaker_status'];
							}	

							$speaker_requests_value = '';
							$fetch_speaker_requests = mysqli_query($connect,"SELECT group_concat(id) as speaker_request FROM speaker_requests where  FIND_IN_SET(LOWER(`request_name`),LOWER('".$speaker_requests."'))");
							if(mysqli_num_rows($fetch_speaker_requests) > 0){
								$res_req = mysqli_fetch_array($fetch_speaker_requests);
									$speaker_requests_value = $res_req['speaker_request'];
							}

							$query_sql_re = mysqli_query($connect,"SELECT count(*) as dup_count FROM all_speakers WHERE email_id='".$email."' and event_id='".$event_id."'");
				         	$query_res1 = mysqli_fetch_array($query_sql_re);
				         	$dupcount = $query_res1['dup_count'];

				         	$query_sql_re2 = mysqli_query($connect,"SELECT count(*) as dup_count2 FROM all_speakers_upload_temp WHERE email_id='".$email."' and event_id='".$event_id."'");
				         	$query_res2 = mysqli_fetch_array($query_sql_re2);
				         	$dupcount2= $query_res2['dup_count2'];	

				         	if($dupcount>0)
							{
								mysqli_query($connect, "INSERT INTO `all_speakers_upload_temp` (`tanent_id`,`speaker_ref_id`,`speaker_name`, `email_id`, `company`, `phone`,`speaker_type`,`status`,`title`,`address1`,`address2`,`city`,`state`,`country`,`zip`,`speaker_manager`,`speaker_manager_email`,`speaker_manager_phone`,`linkedin_url`,`linkedin_handle`,`speaker_requests`,`presentation_title1`,`acknowledgement`
								   ,`event_id`,`created_by`,`is_duplicate`)  VALUES ('".$session_tanent_id."','".$id."','".$name."', '".$email."', '".$company."', '".$phone."','".$speaker_types_value."', '".$status_value."', '".$title."', '".$address1."', '".$address2."', '".$city."', '".$state."','".$country."','".$zip."', '".$speaker_manager."', '".$speaker_manager_email."', '".$speaker_manager_phone."',  '".$twitter_handle."', '".$linkedin_url."', '".$speaker_requests_value."', '".$presentation_title1."', '".strtolower($acknowledgement)."', '".$event_id."', '".$logged_in_user."','1')");
								$speakerid = mysqli_insert_id($connect);
							
						 		$profile_complete = $common->get_speaker_info_missing_value_temp($speakerid);

							 	mysqli_query($connect, "UPDATE `all_speakers_upload_temp` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speakerid );		

							}else
							{
								if($dupcount2>0)
								{
									mysqli_query($connect, "INSERT INTO `all_speakers_upload_temp` (`tanent_id`,`speaker_ref_id`,`speaker_name`, `email_id`, `company`, `phone`,`speaker_type`,`status`,`title`,`address1`,`address2`,`city`,`state`,`country`,`zip`,`speaker_manager`,`speaker_manager_email`,`speaker_manager_phone`,`linkedin_url`,`linkedin_handle`,`speaker_requests`,`presentation_title1`,`acknowledgement`,`event_id`,`created_by`,`is_duplicate`)  VALUES ('".$session_tanent_id."','".$id."','".$name."', '".$email."', '".$company."', '".$phone."','".$speaker_types_value."', '".$status_value."', '".$title."', '".$address1."', '".$address2."', '".$city."', '".$state."','".$country."','".$zip."', '".$speaker_manager."', '".$speaker_manager_email."', '".$speaker_manager_phone."',  '".$twitter_handle."', '".$linkedin_url."', '".$speaker_requests_value."', '".$presentation_title1."', '".strtolower($acknowledgement)."', '".$event_id."', '".$logged_in_user."','1')");
										$speakerid = mysqli_insert_id($connect);
									
								 		$profile_complete = $common->get_speaker_info_missing_value_temp($speakerid);

									 	mysqli_query($connect, "UPDATE `all_speakers_upload_temp` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speakerid );	

										$ids_vals .=",".$id;	
								}else
								{
							
								mysqli_query($connect, "INSERT INTO `all_speakers_upload_temp` (`tanent_id`,`speaker_ref_id`,`speaker_name`, `email_id`, `company`, `phone`,`speaker_type`,`status`,`title`,`address1`,`address2`,`city`,`state`,`country`,`zip`,`speaker_manager`,`speaker_manager_email`,`speaker_manager_phone`,`linkedin_url`,`linkedin_handle`,`speaker_requests`,`presentation_title1`,`acknowledgement`
									   ,`event_id`,`created_by`)  VALUES ('".$session_tanent_id."','".$id."','".$name."', '".$email."', '".$company."', '".$phone."','".$speaker_types_value."', '".$status_value."', '".$title."', '".$address1."', '".$address2."', '".$city."', '".$state."','".$country."','".$zip."', '".$speaker_manager."', '".$speaker_manager_email."', '".$speaker_manager_phone."',  '".$twitter_handle."', '".$linkedin_url."', '".$speaker_requests_value."', '".$presentation_title1."', '".strtolower($acknowledgement)."', '".$event_id."', '".$logged_in_user."')");

									$speakerid = mysqli_insert_id($connect);
								
							 		$profile_complete = $common->get_speaker_info_missing_value_temp($speakerid);

								 	mysqli_query($connect, "UPDATE `all_speakers_upload_temp` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speakerid );	

									$ids_vals .=",".$id;	
								}
							}
							}		
							
						}
					
					}
					elseif(count($Row)==23 ){
						if($m>1){ 

						$filesop = $Row;  

						$id = mysqli_real_escape_string($connect, $filesop[0]);
						$name = mysqli_real_escape_string($connect, $filesop[1]);
						$email = mysqli_real_escape_string($connect, $filesop[2]);
						$company = mysqli_real_escape_string($connect, $filesop[3]);
						$phone = mysqli_real_escape_string($connect, $filesop[4]);
						$speaker_type = mysqli_real_escape_string($connect, $filesop[5]);
						$status = mysqli_real_escape_string($connect, $filesop[6]);
						$influencer_type = mysqli_real_escape_string($connect, $filesop[7]);
						$title = mysqli_real_escape_string($connect, $filesop[8]);
						$address1 = mysqli_real_escape_string($connect, $filesop[9]);
						$address2 = mysqli_real_escape_string($connect, $filesop[10]);
						$city = mysqli_real_escape_string($connect, $filesop[11]);
						$state = mysqli_real_escape_string($connect, $filesop[12]);
						$country = mysqli_real_escape_string($connect, $filesop[13]);
						$zip = mysqli_real_escape_string($connect, $filesop[14]);						
						$speaker_manager = mysqli_real_escape_string($connect, $filesop[15]);
						$speaker_manager_email = mysqli_real_escape_string($connect, $filesop[16]);						
						$speaker_manager_phone = mysqli_real_escape_string($connect, $filesop[17]);
						$linkedin_url = mysqli_real_escape_string($connect, $filesop[18]);
						$twitter_handle = mysqli_real_escape_string($connect, $filesop[19]);
						$speaker_requests = mysqli_real_escape_string($connect, $filesop[20]);
						$presentation_title1 = mysqli_real_escape_string($connect, $filesop[21]);
						$acknowledgements = mysqli_real_escape_string($connect, $filesop[22]);						

					if($email !='' && $email !=' ' && $email !=null && $email !='null')
					{
						$speaker_types_value = '';
						$fetch_speaker_type = mysqli_query($connect,"SELECT group_concat(id) as speaker_type FROM all_speaker_types where find_in_set(LOWER(`speaker_type_name`),LOWER('".$speaker_type."')) AND event_id='".$event_id."'");
						if(mysqli_num_rows($fetch_speaker_type) > 0){
							$res_type = mysqli_fetch_array($fetch_speaker_type);
								$speaker_types_value = $res_type['speaker_type'];
						}	

						$status_value = '';
						$fetch_speaker_status = mysqli_query($connect,"SELECT group_concat(id) as speaker_status FROM all_status where status_for = 'speaker' AND FIND_IN_SET(LOWER(`status_name`),LOWER('".$status."')) AND event_id='".$event_id."'");
						if(mysqli_num_rows($fetch_speaker_status) > 0){
							$res_status = mysqli_fetch_array($fetch_speaker_status);
								$status_value = $res_status['speaker_status'];
						}	

						$speaker_requests_value = '';
						$fetch_speaker_requests = mysqli_query($connect,"SELECT group_concat(id) as speaker_request FROM speaker_requests where  FIND_IN_SET(LOWER(`request_name`),LOWER('".$speaker_requests."'))");
						if(mysqli_num_rows($fetch_speaker_requests) > 0){
							$res_req = mysqli_fetch_array($fetch_speaker_requests);
								$speaker_requests_value = $res_req['speaker_request'];
						}	

						if($id == null || $id == '' || $id == ' ')
						{
							$id=0;
						}	

						 $query_sql_re = mysqli_query($connect,"SELECT count(*) as dup_count FROM all_speakers WHERE email_id='".$email."' and event_id='".$event_id."'");
				         $query_res1 = mysqli_fetch_array($query_sql_re);
				         $dupcount = $query_res1['dup_count'];

				         $query_sql_re2 = mysqli_query($connect,"SELECT count(*) as dup_count2 FROM all_speakers_upload_temp WHERE email_id='".$email."' and event_id='".$event_id."'");
				         $query_res2 = mysqli_fetch_array($query_sql_re2);
				         $dupcount2= $query_res2['dup_count2'];	

				         //var_dump("|| Logic ".$dupcount2); 		
						
						if($id!=0)
						{
							mysqli_query($connect, "INSERT INTO `all_speakers_upload_temp` (`tanent_id`,`speaker_ref_id`,`speaker_name`, `email_id`, `company`, `phone`,`speaker_type`,`status`,`title`,`address1`,`address2`,`city`,`state`,`country`,`zip`,`speaker_manager`,`speaker_manager_email`,`speaker_manager_phone`,`linkedin_url`,`linkedin_handle`,`speaker_requests`,`presentation_title1`,`acknowledgement`
								   ,`event_id`,`created_by`)  VALUES ('".$session_tanent_id."','".$id."','".$name."', '".$email."', '".$company."', '".$phone."','".$speaker_types_value."', '".$status_value."', '".$title."', '".$address1."', '".$address2."', '".$city."', '".$state."','".$country."','".$zip."', '".$speaker_manager."', '".$speaker_manager_email."', '".$speaker_manager_phone."',  '".$twitter_handle."', '".$linkedin_url."', '".$speaker_requests_value."', '".$presentation_title1."', '".strtolower($acknowledgement)."', '".$event_id."', '".$logged_in_user."')");

							$speakerid = mysqli_insert_id($connect);
							
						 	$profile_complete = $common->get_speaker_info_missing_value_temp($speakerid);

							 mysqli_query($connect, "UPDATE `all_speakers_upload_temp` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speakerid );	

							$ids_vals .=",".$id;	
						}else
						{
							
							if($dupcount>0)
							{
								mysqli_query($connect, "INSERT INTO `all_speakers_upload_temp` (`tanent_id`,`speaker_ref_id`,`speaker_name`, `email_id`, `company`, `phone`,`speaker_type`,`status`,`title`,`address1`,`address2`,`city`,`state`,`country`,`zip`,`speaker_manager`,`speaker_manager_email`,`speaker_manager_phone`,`linkedin_url`,`linkedin_handle`,`speaker_requests`,`presentation_title1`,`acknowledgement`
								   ,`event_id`,`created_by`,`is_duplicate`)  VALUES ('".$session_tanent_id."','".$id."','".$name."', '".$email."', '".$company."', '".$phone."','".$speaker_types_value."', '".$status_value."', '".$title."', '".$address1."', '".$address2."', '".$city."', '".$state."','".$country."','".$zip."', '".$speaker_manager."', '".$speaker_manager_email."', '".$speaker_manager_phone."',  '".$twitter_handle."', '".$linkedin_url."', '".$speaker_requests_value."', '".$presentation_title1."', '".strtolower($acknowledgement)."', '".$event_id."', '".$logged_in_user."','1')");
								$speakerid = mysqli_insert_id($connect);
							
						 		$profile_complete = $common->get_speaker_info_missing_value_temp($speakerid);

							 	mysqli_query($connect, "UPDATE `all_speakers_upload_temp` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speakerid );	

								$ids_vals .=",".$id;	

							}else
							{
								if($dupcount2>0)
								{

									mysqli_query($connect, "INSERT INTO `all_speakers_upload_temp` (`tanent_id`,`speaker_ref_id`,`speaker_name`, `email_id`, `company`, `phone`,`speaker_type`,`status`,`title`,`address1`,`address2`,`city`,`state`,`country`,`zip`,`speaker_manager`,`speaker_manager_email`,`speaker_manager_phone`,`linkedin_url`,`linkedin_handle`,`speaker_requests`,`presentation_title1`,`acknowledgement`,`event_id`,`created_by`,`is_duplicate`)  VALUES ('".$session_tanent_id."','".$id."','".$name."', '".$email."', '".$company."', '".$phone."','".$speaker_types_value."', '".$status_value."', '".$title."', '".$address1."', '".$address2."', '".$city."', '".$state."','".$country."','".$zip."', '".$speaker_manager."', '".$speaker_manager_email."', '".$speaker_manager_phone."',  '".$twitter_handle."', '".$linkedin_url."', '".$speaker_requests_value."', '".$presentation_title1."', '".strtolower($acknowledgement)."', '".$event_id."', '".$logged_in_user."','1')");
									$speakerid = mysqli_insert_id($connect);
								
							 		$profile_complete = $common->get_speaker_info_missing_value_temp($speakerid);

								 	mysqli_query($connect, "UPDATE `all_speakers_upload_temp` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speakerid );	

									$ids_vals .=",".$id;	
								}else
								{

									mysqli_query($connect, "INSERT INTO `all_speakers_upload_temp` (`tanent_id`,`speaker_ref_id`,`speaker_name`, `email_id`, `company`, `phone`,`speaker_type`,`status`,`title`,`address1`,`address2`,`city`,`state`,`country`,`zip`,`speaker_manager`,`speaker_manager_email`,`speaker_manager_phone`,`linkedin_url`,`linkedin_handle`,`speaker_requests`,`presentation_title1`,`acknowledgement`
									   ,`event_id`,`created_by`)  VALUES ('".$session_tanent_id."','".$id."','".$name."', '".$email."', '".$company."', '".$phone."','".$speaker_types_value."', '".$status_value."', '".$title."', '".$address1."', '".$address2."', '".$city."', '".$state."','".$country."','".$zip."', '".$speaker_manager."', '".$speaker_manager_email."', '".$speaker_manager_phone."',  '".$twitter_handle."', '".$linkedin_url."', '".$speaker_requests_value."', '".$presentation_title1."', '".strtolower($acknowledgement)."', '".$event_id."', '".$logged_in_user."')");

									$speakerid = mysqli_insert_id($connect);
								
							 		$profile_complete = $common->get_speaker_info_missing_value_temp($speakerid);

								 	mysqli_query($connect, "UPDATE `all_speakers_upload_temp` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speakerid );	

									$ids_vals .=",".$id;

								}

							}
						}
					}
						
					} 
					
					}
					$m++;
				}
			}

			
			@unlink($Filepath);   
			$insertqry="all-speakers";
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','upload speakers','".$m."','".$id_user."',now(),\"".$insertqry."\")");
				
			header('Location:../all-speakers.php?count='.($m - 1).'&upload_success&up='.base64_encode(1).'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

			}else{
					// contact limit exceed
				//2nd else
				header('Location:../all-speakers.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&upload_limit_exceed');
				}

			 }else{
			 	// contact limit exceed
			 	header('Location:../all-speakers.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&upload_limit_exceed');
			 }
		   
		break;
		
		
		case "sponsors_upload":
		
		   	require "../spreadsheet-reader-master/php-excel-reader/excel_reader2.php";
			require "../spreadsheet-reader-master/SpreadsheetReader.php";

			$event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']);
			$logged_in_user= $_SESSION['user_id'];
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);

			$uploaddir = '../uploaded-files/';
			$uploadfile = $uploaddir . basename($_FILES['file']['name']);
			move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
			$Filepath       = $uploadfile;
			$Spreadsheet    = new SpreadsheetReader($Filepath);
			$Sheets         = $Spreadsheet -> Sheets();

			//*********************************************************
				// check total contact count 
				$total_contact = $common->get_total_contacts_count_by_tenantid($session_tanent_id);

								// fetch_user_details
				$fetch_user_details = mysqli_query($connect,"SELECT * FROM `all_users` WHERE `user_id` = '".$logged_in_user."' ");
				$res_user = mysqli_fetch_array($fetch_user_details);
				$subscription_id = $res_user['subscription_id'];				

				 $check_tenant_subs = mysqli_query($connect,"SELECT * FROM `all_tenants` WHERE `id` = '".$session_tanent_id."' ");  
		        $res_ten = mysqli_fetch_array($check_tenant_subs);
		        $tenant_created_at = date('Y-m-d',strtotime($res_ten['created_at']));
		        $now = time(); // or your date as well
	            $your_date = strtotime($tenant_created_at);
	            $datediff = $now - $your_date;
	            $final_date= round($datediff / (60 * 60 * 24));

		        if($final_date < 100){   
                if($subscription_id != ''){

                	$subs_details = $common->subscription_retrive_by_subscription_id($subscription_id);
				    $plan_id_fetched = $subs_details['subscription']->planId;

				    $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = '".$plan_id_fetched."' ");
				    $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);
					$contact_limit = $res_contact_limit['contact_limit'];


                }else{

                    //if not subscribed any plan and tenant in trial period
				    $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = 'essential' ");
				    $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);
					$contact_limit = $res_contact_limit['contact_limit'];

                }              

            }else{
            	    $subs_details = $common->subscription_retrive_by_subscription_id($subscription_id);
				    $plan_id_fetched = $subs_details['subscription']->planId;

				    $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = '".$plan_id_fetched."' ");
				    $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);
					$contact_limit = $res_contact_limit['contact_limit'];                   
            }



////////////////////////////////////////////////////////////////////////////////////////////////

				// fetch_user_details
				/*$fetch_user_details = mysqli_query($connect,"SELECT * FROM `all_users` WHERE `user_id` = '".$logged_in_user."' ");
				$res_user = mysqli_fetch_array($fetch_user_details);

				$subscription_id = $res_user['subscription_id'];

				  $subs_details = $common->subscription_retrive_by_subscription_id($subscription_id);
				  $plan_id_fetched = $subs_details['subscription']->planId;


				  $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = '".$plan_id_fetched."' ");
				   $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);

					$contact_limit = $res_contact_limit['contact_limit'];*/
				
		 if($contact_limit > $total_contact){

		 	$remaining_limit = $contact_limit - $total_contact;

		 	$new_records_count = 0;
				 foreach ($Sheets as $Index => $Name)
				 {
					
					$Spreadsheet -> ChangeSheet($Index);							
					$f = 1;
					foreach ($Spreadsheet as $Key => $Row)
					{
						if($f>1){
							
							if(count($Row)==23){ 
								
								$filesop_c = $Row;
								$id = mysqli_real_escape_string($connect, $filesop_c[0]);
								$sponsor_email = mysqli_real_escape_string($connect, $filesop_c[4]);
								//if($id == '' || $id == ' '){
								if( ($id == '' || $id == ' ') && $sponsor_email != ''){
									$new_records_count++;
								}							
							}else if(count($Row)==22){
								//******
							}
						}					
						$f++;
					}
				}				

			if($remaining_limit >= $new_records_count){

			// *************************************
			
			$subsystem_arr = $component_arr = $sub_component_arr = $md_array=array();
			
			$ids_vals =0;

			mysqli_query($connect, "DELETE FROM all_sponsors_upload_temp WHERE event_id=".$event_id."");
			foreach ($Sheets as $Index => $Name)
			{
				
				$Spreadsheet -> ChangeSheet($Index);
							
				$m = 1;
				foreach ($Spreadsheet as $Key => $Row)
				{
						
					if(count($Row)<21 ){
						header('Location:../all-sponsors.php?count='.$m.'&upload_error');
					}
					else if(count($Row)==23 ){
						if($m>1){ 

						$filesop = $Row;                                
						$id = mysqli_real_escape_string($connect, $filesop[0]);
						$sponsor_company_name = mysqli_real_escape_string($connect, $filesop[1]);
						$sponsor_contact_person = mysqli_real_escape_string($connect, $filesop[2]);
						$sponsor_contact_number = mysqli_real_escape_string($connect, $filesop[3]);
						$sponsor_contact_email_address = mysqli_real_escape_string($connect, $filesop[4]);
						$sponsor_role = mysqli_real_escape_string($connect, $filesop[5]);
						$secondary1_sponsor_contact_person = mysqli_real_escape_string($connect, $filesop[6]);
						$secondary1_sponsor_contact_number = mysqli_real_escape_string($connect, $filesop[7]);
						$secondary1_sponsor_contact_email_address = mysqli_real_escape_string($connect, $filesop[8]);
						$secondary1_sponsor_role = mysqli_real_escape_string($connect, $filesop[9]);
						$secondary2_sponsor_contact_person = mysqli_real_escape_string($connect, $filesop[10]);
						$secondary2_sponsor_contact_number = mysqli_real_escape_string($connect, $filesop[11]);
						$secondary2_sponsor_contact_email_address = mysqli_real_escape_string($connect, $filesop[12]);
						$secondary2_sponsor_role = mysqli_real_escape_string($connect, $filesop[13]);
						$sponsor_bio = mysqli_real_escape_string($connect, $filesop[14]);
						$facebook_url = mysqli_real_escape_string($connect, $filesop[15]);
						$twitter_url = mysqli_real_escape_string($connect, $filesop[16]);
						$linkedin_url = mysqli_real_escape_string($connect, $filesop[17]);
						$instagram_url = mysqli_real_escape_string($connect, $filesop[18]);
						$address1 = mysqli_real_escape_string($connect, $filesop[19]);
						$address2 = mysqli_real_escape_string($connect, $filesop[20]);
						$city = mysqli_real_escape_string($connect, $filesop[21]);
						$state = mysqli_real_escape_string($connect, $filesop[22]);

					if($sponsor_contact_email_address != '' && $sponsor_contact_email_address != NULL && $sponsor_contact_email_address != 'null' && $sponsor_contact_email_address != ' ')
					{
						if(!empty($sponsor_contact_number)){
							$sponsor_contact_number =  preg_replace("/[^0-9]/", '', $sponsor_contact_number);
							$sponsor_contact_number = substr($sponsor_contact_number, 0, 3).'-'.substr($sponsor_contact_number, 3, 3).'-'.substr($sponsor_contact_number,6);
						}
						
						if(!empty($secondary1_sponsor_contact_number)){
							$secondary1_sponsor_contact_number = preg_replace("/[^0-9]/", '', $secondary1_sponsor_contact_number);
							$secondary1_sponsor_contact_number = substr($secondary1_sponsor_contact_number, 0, 3).'-'.substr($secondary1_sponsor_contact_number, 3, 3).'-'.substr($secondary1_sponsor_contact_number,6);
						}
						if(!empty($secondary2_sponsor_contact_number)){
							$secondary2_sponsor_contact_number = preg_replace("/[^0-9]/", '', $secondary2_sponsor_contact_number);
							$secondary2_sponsor_contact_number = substr($secondary2_sponsor_contact_number, 0, 3).'-'.substr($secondary2_sponsor_contact_number, 3, 3).'-'.substr($secondary2_sponsor_contact_number,6);
						}

						if($id == null || $id == '' || $id == ' ')
						{
							$id=0;
						}	

						$query_sql_re = mysqli_query($connect,"SELECT count(*) as dup_count FROM all_sponsors WHERE sponsor_contact_email_address='".$sponsor_contact_email_address."' and event_id='".$event_id."'");
				         $query_res1 = mysqli_fetch_array($query_sql_re);
				         $dupcount = $query_res1['dup_count'];	

				         $query_sql_re2 = mysqli_query($connect,"SELECT count(*) as dup_count2 FROM all_sponsors_upload_temp WHERE sponsor_contact_email_address='".$sponsor_contact_email_address."' and event_id='".$event_id."'");
				         $query_res2 = mysqli_fetch_array($query_sql_re2);
				         $dupcount2 = $query_res2['dup_count2'];	

				         if($id!=0)
						 {	
							mysqli_query($connect, "INSERT INTO `all_sponsors_upload_temp` (`tanent_id`,`sponsor_ref_id`,`sponsor_company_name`, `sponsor_type`, `sponsor_contact_person`, `sponsor_contact_number`, `sponsor_contact_email_address`,`sponsor_role`,`secondary1_sponsor_contact_person`, `secondary1_sponsor_contact_number`, `secondary1_sponsor_contact_email_address`, `secondary1_sponsor_role`,`secondary2_sponsor_contact_person`, `secondary2_sponsor_contact_number`, `secondary2_sponsor_contact_email_address`, `secondary2_sponsor_role`, `sponsor_bio`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `address1`,`address2`,`city`,`state`, `banner_image`,`event_id`,`created_by`) VALUES ('".$session_tanent_id."','".$id."','".$sponsor_company_name."', '', '".$sponsor_contact_person."', '".$sponsor_contact_number."', '".$sponsor_contact_email_address."','".$sponsor_role."', '".$secondary1_sponsor_contact_person."', '".$secondary1_sponsor_contact_number."', '".$secondary1_sponsor_contact_email_address."','".$secondary1_sponsor_role."', '".$secondary2_sponsor_contact_person."', '".$secondary2_sponsor_contact_number."', '".$secondary2_sponsor_contact_email_address."','".$secondary2_sponsor_role."', '".$sponsor_bio."', '".$facebook_url."', '".$twitter_url."', '".$linkedin_url."', '".$instagram_url."', '".$address1."', '".$address2."', '".$city."', '".$state."', '','".$event_id."','".$logged_in_user."')");
							$ids_vals .=",".mysqli_insert_id($connect);
						}else
						{
							
							if($dupcount>0)
							{
								mysqli_query($connect, "INSERT INTO `all_sponsors_upload_temp` (`tanent_id`,`sponsor_ref_id`,`sponsor_company_name`, `sponsor_type`, `sponsor_contact_person`, `sponsor_contact_number`, `sponsor_contact_email_address`,`sponsor_role`,`secondary1_sponsor_contact_person`, `secondary1_sponsor_contact_number`, `secondary1_sponsor_contact_email_address`, `secondary1_sponsor_role`,`secondary2_sponsor_contact_person`, `secondary2_sponsor_contact_number`, `secondary2_sponsor_contact_email_address`, `secondary2_sponsor_role`, `sponsor_bio`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `address1`,`address2`,`city`,`state`, `banner_image`,`event_id`,`created_by`,`is_duplicate`) VALUES ('".$session_tanent_id."','".$id."','".$sponsor_company_name."', '', '".$sponsor_contact_person."', '".$sponsor_contact_number."', '".$sponsor_contact_email_address."','".$sponsor_role."', '".$secondary1_sponsor_contact_person."', '".$secondary1_sponsor_contact_number."', '".$secondary1_sponsor_contact_email_address."','".$secondary1_sponsor_role."', '".$secondary2_sponsor_contact_person."', '".$secondary2_sponsor_contact_number."', '".$secondary2_sponsor_contact_email_address."','".$secondary2_sponsor_role."', '".$sponsor_bio."', '".$facebook_url."', '".$twitter_url."', '".$linkedin_url."', '".$instagram_url."', '".$address1."', '".$address2."', '".$city."', '".$state."', '','".$event_id."','".$logged_in_user."','1')");

									$ids_vals .=",".mysqli_insert_id($connect);
							}else
							{
								if($dupcount2>0)
								{
									mysqli_query($connect, "INSERT INTO `all_sponsors_upload_temp` (`tanent_id`,`sponsor_ref_id`,`sponsor_company_name`, `sponsor_type`, `sponsor_contact_person`, `sponsor_contact_number`, `sponsor_contact_email_address`,`sponsor_role`,`secondary1_sponsor_contact_person`, `secondary1_sponsor_contact_number`, `secondary1_sponsor_contact_email_address`, `secondary1_sponsor_role`,`secondary2_sponsor_contact_person`, `secondary2_sponsor_contact_number`, `secondary2_sponsor_contact_email_address`, `secondary2_sponsor_role`, `sponsor_bio`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `address1`,`address2`,`city`,`state`, `banner_image`,`event_id`,`created_by`,`is_duplicate`) VALUES ('".$session_tanent_id."','".$id."','".$sponsor_company_name."', '', '".$sponsor_contact_person."', '".$sponsor_contact_number."', '".$sponsor_contact_email_address."','".$sponsor_role."', '".$secondary1_sponsor_contact_person."', '".$secondary1_sponsor_contact_number."', '".$secondary1_sponsor_contact_email_address."','".$secondary1_sponsor_role."', '".$secondary2_sponsor_contact_person."', '".$secondary2_sponsor_contact_number."', '".$secondary2_sponsor_contact_email_address."','".$secondary2_sponsor_role."', '".$sponsor_bio."', '".$facebook_url."', '".$twitter_url."', '".$linkedin_url."', '".$instagram_url."', '".$address1."', '".$address2."', '".$city."', '".$state."', '','".$event_id."','".$logged_in_user."','1')");

									$ids_vals .=",".mysqli_insert_id($connect);
								
								}else
								{
									mysqli_query($connect, "INSERT INTO `all_sponsors_upload_temp` (`tanent_id`,`sponsor_ref_id`,`sponsor_company_name`, `sponsor_type`, `sponsor_contact_person`, `sponsor_contact_number`, `sponsor_contact_email_address`,`sponsor_role`,`secondary1_sponsor_contact_person`, `secondary1_sponsor_contact_number`, `secondary1_sponsor_contact_email_address`, `secondary1_sponsor_role`,`secondary2_sponsor_contact_person`, `secondary2_sponsor_contact_number`, `secondary2_sponsor_contact_email_address`, `secondary2_sponsor_role`, `sponsor_bio`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `address1`,`address2`,`city`,`state`, `banner_image`,`event_id`,`created_by`) VALUES ('".$session_tanent_id."','".$id."','".$sponsor_company_name."', '', '".$sponsor_contact_person."', '".$sponsor_contact_number."', '".$sponsor_contact_email_address."','".$sponsor_role."', '".$secondary1_sponsor_contact_person."', '".$secondary1_sponsor_contact_number."', '".$secondary1_sponsor_contact_email_address."','".$secondary1_sponsor_role."', '".$secondary2_sponsor_contact_person."', '".$secondary2_sponsor_contact_number."', '".$secondary2_sponsor_contact_email_address."','".$secondary2_sponsor_role."', '".$sponsor_bio."', '".$facebook_url."', '".$twitter_url."', '".$linkedin_url."', '".$instagram_url."', '".$address1."', '".$address2."', '".$city."', '".$state."', '','".$event_id."','".$logged_in_user."')");
								
									$ids_vals .=",".mysqli_insert_id($connect);	

								}

							}
					  }
					}
						
					}
					$m++;
					}else if(count($Row)==22 ){
						
						if($m>1){ 

						$filesop = $Row;                                
						$sponsor_company_name = mysqli_real_escape_string($connect, $filesop[0]);
						$sponsor_contact_person = mysqli_real_escape_string($connect, $filesop[1]);
						$sponsor_contact_number = mysqli_real_escape_string($connect, $filesop[2]);
						$sponsor_contact_email_address = mysqli_real_escape_string($connect, $filesop[3]);
						$sponsor_role = mysqli_real_escape_string($connect, $filesop[4]);
						$secondary1_sponsor_contact_person = mysqli_real_escape_string($connect, $filesop[5]);
						$secondary1_sponsor_contact_number = mysqli_real_escape_string($connect, $filesop[6]);
						$secondary1_sponsor_contact_email_address = mysqli_real_escape_string($connect, $filesop[7]);
						$secondary1_sponsor_role = mysqli_real_escape_string($connect, $filesop[8]);
						$secondary2_sponsor_contact_person = mysqli_real_escape_string($connect, $filesop[9]);
						$secondary2_sponsor_contact_number = mysqli_real_escape_string($connect, $filesop[10]);
						$secondary2_sponsor_contact_email_address = mysqli_real_escape_string($connect, $filesop[11]);
						$secondary2_sponsor_role = mysqli_real_escape_string($connect, $filesop[12]);
						$sponsor_bio = mysqli_real_escape_string($connect, $filesop[13]);
						$facebook_url = mysqli_real_escape_string($connect, $filesop[14]);
						$twitter_url = mysqli_real_escape_string($connect, $filesop[15]);
						$linkedin_url = mysqli_real_escape_string($connect, $filesop[16]);
						$instagram_url = mysqli_real_escape_string($connect, $filesop[17]);
						$address1 = mysqli_real_escape_string($connect, $filesop[18]);
						$address2 = mysqli_real_escape_string($connect, $filesop[19]);
						$city = mysqli_real_escape_string($connect, $filesop[20]);
						$state = mysqli_real_escape_string($connect, $filesop[21]);

						// check email address is not empty
						if($sponsor_contact_email_address != '' && $sponsor_contact_email_address != NULL && $sponsor_contact_email_address != 'null' && $sponsor_contact_email_address != ' ')
						{
						
							if(!empty($sponsor_contact_number)){
								$sponsor_contact_number =  preg_replace("/[^0-9]/", '', $sponsor_contact_number);
								$sponsor_contact_number = substr($sponsor_contact_number, 0, 3).'-'.substr($sponsor_contact_number, 3, 3).'-'.substr($sponsor_contact_number,6);
							}
							
							if(!empty($secondary1_sponsor_contact_number)){
								$secondary1_sponsor_contact_number = preg_replace("/[^0-9]/", '', $secondary1_sponsor_contact_number);
								$secondary1_sponsor_contact_number = substr($secondary1_sponsor_contact_number, 0, 3).'-'.substr($secondary1_sponsor_contact_number, 3, 3).'-'.substr($secondary1_sponsor_contact_number,6);
							}
							if(!empty($secondary2_sponsor_contact_number)){
								$secondary2_sponsor_contact_number = preg_replace("/[^0-9]/", '', $secondary2_sponsor_contact_number);
								$secondary2_sponsor_contact_number = substr($secondary2_sponsor_contact_number, 0, 3).'-'.substr($secondary2_sponsor_contact_number, 3, 3).'-'.substr($secondary2_sponsor_contact_number,6);
							}

							$query_sql_re = mysqli_query($connect,"SELECT count(*) as dup_count FROM all_sponsors WHERE sponsor_contact_email_address='".$sponsor_contact_email_address."' and event_id='".$event_id."'");
					         $query_res1 = mysqli_fetch_array($query_sql_re);
					         $dupcount = $query_res1['dup_count'];

							$query_sql_re2 = mysqli_query($connect,"SELECT count(*) as dup_count2 FROM all_sponsors_upload_temp WHERE sponsor_contact_email_address='".$sponsor_contact_email_address."' and event_id='".$event_id."'");
				         	$query_res2 = mysqli_fetch_array($query_sql_re2);
				         	$dupcount2 = $query_res2['dup_count2'];


				         	if($dupcount>0)
							{
								mysqli_query($connect, "INSERT INTO `all_sponsors_upload_temp` (`tanent_id`,`sponsor_ref_id`,`sponsor_company_name`, `sponsor_type`, `sponsor_contact_person`, `sponsor_contact_number`, `sponsor_contact_email_address`,`sponsor_role`,`secondary1_sponsor_contact_person`, `secondary1_sponsor_contact_number`, `secondary1_sponsor_contact_email_address`, `secondary1_sponsor_role`,`secondary2_sponsor_contact_person`, `secondary2_sponsor_contact_number`, `secondary2_sponsor_contact_email_address`, `secondary2_sponsor_role`, `sponsor_bio`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `address1`,`address2`,`city`,`state`, `banner_image`,`event_id`,`created_by`,`is_duplicate`) VALUES ('".$session_tanent_id."','".$id."','".$sponsor_company_name."', '', '".$sponsor_contact_person."', '".$sponsor_contact_number."', '".$sponsor_contact_email_address."','".$sponsor_role."', '".$secondary1_sponsor_contact_person."', '".$secondary1_sponsor_contact_number."', '".$secondary1_sponsor_contact_email_address."','".$secondary1_sponsor_role."', '".$secondary2_sponsor_contact_person."', '".$secondary2_sponsor_contact_number."', '".$secondary2_sponsor_contact_email_address."','".$secondary2_sponsor_role."', '".$sponsor_bio."', '".$facebook_url."', '".$twitter_url."', '".$linkedin_url."', '".$instagram_url."', '".$address1."', '".$address2."', '".$city."', '".$state."', '','".$event_id."','".$logged_in_user."','1')");

									$ids_vals .=",".mysqli_insert_id($connect);
							}else
							{
				         		if($dupcount2>0)
								{
									mysqli_query($connect, "INSERT INTO `all_sponsors_upload_temp` (`tanent_id`,`sponsor_ref_id`,`sponsor_company_name`, `sponsor_type`, `sponsor_contact_person`, `sponsor_contact_number`, `sponsor_contact_email_address`,`sponsor_role`,`secondary1_sponsor_contact_person`, `secondary1_sponsor_contact_number`, `secondary1_sponsor_contact_email_address`, `secondary1_sponsor_role`,`secondary2_sponsor_contact_person`, `secondary2_sponsor_contact_number`, `secondary2_sponsor_contact_email_address`, `secondary2_sponsor_role`, `sponsor_bio`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `address1`,`address2`,`city`,`state`, `banner_image`,`event_id`,`created_by`,`is_duplicate`) VALUES ('".$session_tanent_id."','".$id."','".$sponsor_company_name."', '', '".$sponsor_contact_person."', '".$sponsor_contact_number."', '".$sponsor_contact_email_address."','".$sponsor_role."', '".$secondary1_sponsor_contact_person."', '".$secondary1_sponsor_contact_number."', '".$secondary1_sponsor_contact_email_address."','".$secondary1_sponsor_role."', '".$secondary2_sponsor_contact_person."', '".$secondary2_sponsor_contact_number."', '".$secondary2_sponsor_contact_email_address."','".$secondary2_sponsor_role."', '".$sponsor_bio."', '".$facebook_url."', '".$twitter_url."', '".$linkedin_url."', '".$instagram_url."', '".$address1."', '".$address2."', '".$city."', '".$state."', '','".$event_id."','".$logged_in_user."','1')");

									$ids_vals .=",".mysqli_insert_id($connect);
								
								}else
								{
								mysqli_query($connect, "INSERT INTO `all_sponsors_upload_temp` (`tanent_id`,`sponsor_ref_id`,`sponsor_company_name`, `sponsor_type`, `sponsor_contact_person`, `sponsor_contact_number`, `sponsor_contact_email_address`,`sponsor_role`,`secondary1_sponsor_contact_person`, `secondary1_sponsor_contact_number`, `secondary1_sponsor_contact_email_address`, `secondary1_sponsor_role`,`secondary2_sponsor_contact_person`, `secondary2_sponsor_contact_number`, `secondary2_sponsor_contact_email_address`, `secondary2_sponsor_role`, `sponsor_bio`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `address1`,`address2`,`city`,`state`, `banner_image`,`event_id`,`created_by`) VALUES ('".$session_tanent_id."',0,'".$sponsor_company_name."', '', '".$sponsor_contact_person."', '".$sponsor_contact_number."', '".$sponsor_contact_email_address."','".$sponsor_role."', '".$secondary1_sponsor_contact_person."', '".$secondary1_sponsor_contact_number."', '".$secondary1_sponsor_contact_email_address."','".$secondary1_sponsor_role."', '".$secondary2_sponsor_contact_person."', '".$secondary2_sponsor_contact_number."', '".$secondary2_sponsor_contact_email_address."','".$secondary2_sponsor_role."', '".$sponsor_bio."', '".$facebook_url."', '".$twitter_url."', '".$linkedin_url."', '".$instagram_url."', '".$address1."', '".$address2."', '".$city."', '".$state."', '','".$event_id."','".$logged_in_user."')");
									$ids_vals .=",".mysqli_insert_id($connect);
								}
							}

						}
						
						
					}
					$m++;
						
					}
					
					
				}
			}
	
			@unlink($Filepath); 
			$insertqry="all-sponsors";
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','upload sponsor','".$m."','".$id_user."',now(),\"".$insertqry."\")");

			header('Location:../all-sponsors.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&count='.($m - 1).'&upload_success&up='.base64_encode(1));

			}else{
					// contact limit exceed
				//2nd else
				header('Location:../all-sponsors.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&upload_limit_exceed');
				}

			 }else{
			 	// contact limit exceed
			 	header('Location:../all-sponsors.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&upload_limit_exceed');
			 }

					
		break;
		
		
		case "masters_upload":
		   	require "../spreadsheet-reader-master/php-excel-reader/excel_reader2.php";
			require "../spreadsheet-reader-master/SpreadsheetReader.php";

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$logged_in_user= $_SESSION['user_id'];
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);

			
			$uploaddir = '../uploaded-files/';
			$uploadfile = $uploaddir . basename($_FILES['file']['name']);
			move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
			$Filepath       = $uploadfile;
			$Spreadsheet    = new SpreadsheetReader($Filepath);
			$Sheets         = $Spreadsheet -> Sheets();


			//*********************************************************
				// check total contact count 
				$total_contact = $common->get_total_contacts_count_by_tenantid($session_tanent_id);

								// fetch_user_details
				$fetch_user_details = mysqli_query($connect,"SELECT * FROM `all_users` WHERE `user_id` = '".$logged_in_user."' ");
				$res_user = mysqli_fetch_array($fetch_user_details);
				$subscription_id = $res_user['subscription_id'];				

				 $check_tenant_subs = mysqli_query($connect,"SELECT * FROM `all_tenants` WHERE `id` = '".$session_tanent_id."' ");  
		        $res_ten = mysqli_fetch_array($check_tenant_subs);
		        $tenant_created_at = date('Y-m-d',strtotime($res_ten['created_at']));

		        $now = time(); // or your date as well
	            $your_date = strtotime($tenant_created_at);
	            $datediff = $now - $your_date;
	            $final_date= round($datediff / (60 * 60 * 24));

		        if($final_date < 100){   
                if($subscription_id != ''){

                	$subs_details = $common->subscription_retrive_by_subscription_id($subscription_id);
				    $plan_id_fetched = $subs_details['subscription']->planId;

				    $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = '".$plan_id_fetched."' ");
				    $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);
					$contact_limit = $res_contact_limit['contact_limit'];


                }else{

                    //if not subscribed any plan and tenant in trial period
				    $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = 'essential' ");
				    $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);
					$contact_limit = $res_contact_limit['contact_limit'];

                }              

            }else{
            	    $subs_details = $common->subscription_retrive_by_subscription_id($subscription_id);
				    $plan_id_fetched = $subs_details['subscription']->planId;

				    $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = '".$plan_id_fetched."' ");
				    $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);
					$contact_limit = $res_contact_limit['contact_limit'];                   
            }

				// fetch_user_details
				/*$fetch_user_details = mysqli_query($connect,"SELECT * FROM `all_users` WHERE `user_id` = '".$logged_in_user."' ");
				$res_user = mysqli_fetch_array($fetch_user_details);

				$subscription_id = $res_user['subscription_id'];

				  $subs_details = $common->subscription_retrive_by_subscription_id($subscription_id);
				  $plan_id_fetched = $subs_details['subscription']->planId;


				  $fetch_contact_limit = mysqli_query($connect,"SELECT * FROM `subscription_plans_details` WHERE `plan_id` = '".$plan_id_fetched."' ");
				   $res_contact_limit = mysqli_fetch_array($fetch_contact_limit);

					$contact_limit = $res_contact_limit['contact_limit'];*/
					
			 if($contact_limit > $total_contact){

			 	$remaining_limit = $contact_limit - $total_contact;

			 	$new_records_count = 0;
				 foreach ($Sheets as $Index => $Name)
				 {
					
					$Spreadsheet -> ChangeSheet($Index);							
					$f = 1;
					foreach ($Spreadsheet as $Key => $Row)
					{
						if($f>0){
							
							if(count($Row)==8){
								//echo "Hii: 23";
								$filesop_c = $Row;
								$id = mysqli_real_escape_string($connect, $filesop_c[0]);
								$master_email = mysqli_real_escape_string($connect, $filesop_c[2]);
								//if($id == '' || $id == ' '){

								if( ($id == '' || $id == ' ') && $master_email != ''){
									$new_records_count++;
								}							
							}else if(count($Row)==7){
								//******
							}
						}					
						$f++;
					}

				}	

				//var_dump($remaining_limit ." || ".$new_records_count); exit();

				if($remaining_limit >= $new_records_count){

			// *************************************
			

			
			$subsystem_arr = $component_arr = $sub_component_arr = $md_array=array();
			$delete_temp_master = mysqli_query($connect,"DELETE FROM `all_masters_upload_temp` WHERE `event_id` = '".$event_id."' "); 
			
			$ids_vals = 0;
			foreach ($Sheets as $Index => $Name)
			{

				
				$Spreadsheet -> ChangeSheet($Index);
							
				$m = 1;
				foreach ($Spreadsheet as $Key => $Row)
				{	
					
					if(count($Row)<7){

						header('Location:../all-masters.php?count='.$m.'&upload_error');
					}
					else if(count($Row)== 7 ){
		
							if($m>1){ 							

							$filesop = $Row;                                
							$name = mysqli_real_escape_string($connect, $filesop[0]);						

							//$lastname = mysqli_real_escape_string($connect, $filesop[1]);
							$email = mysqli_real_escape_string($connect, $filesop[1]);
							$phone = mysqli_real_escape_string($connect, $filesop[2]);
							$company = mysqli_real_escape_string($connect, $filesop[3]);
							$job_title = mysqli_real_escape_string($connect, $filesop[4]);
							$linkedin_url = mysqli_real_escape_string($connect, $filesop[5]);
							$master_type = mysqli_real_escape_string($connect, trim(strtolower($filesop[6])));
							
						if($email !='' && $email !=' ' && $email !=null && $email !='null')
						{
								$master_types_value = '';
								$fetch_master_type = mysqli_query($connect,"SELECT group_concat(id) as master_type FROM all_master_types where event_id = '".$event_id."' AND find_in_set(LOWER(`master_type_name`),LOWER('".$master_type."'))");
								if(mysqli_num_rows($fetch_master_type) > 0){
									$res_type = mysqli_fetch_array($fetch_master_type);
										$master_types_value = $res_type['master_type'];
								}	

							$query_sql_re = mysqli_query($connect,"SELECT count(*) as dup_count FROM all_masters WHERE email_id='".$email."' and event_id='".$event_id."'");
					         $query_res1 = mysqli_fetch_array($query_sql_re);
					         $dupcount = $query_res1['dup_count'];

							$query_sql_re2 = mysqli_query($connect,"SELECT count(*) as dup_count2 FROM all_masters_upload_temp WHERE email_id='".$email."' and event_id='".$event_id."'");
				         	$query_res2 = mysqli_fetch_array($query_sql_re2);
				         	$dupcount2 = $query_res2['dup_count2'];				

							
				         	if($dupcount>0)
							{
								mysqli_query($connect, "INSERT INTO `all_masters_upload_temp` (`master_id`,`tanent_id`,`master_name`, `email_id`, `company`,`phone`,`job_title`,`linkedin_url`,`master_type`,`event_id`,is_approved,`created_by`,`is_duplicate`) VALUES (0,'".$session_tanent_id."','".$name."','".$email."', '".$company."', '".$phone."', '".$job_title."', '".$linkedin_url."', '".$master_types_value."' , '".$event_id."','0','".$logged_in_user."','1')");
								
							}else
							{
				         		if($dupcount2>0)
								{
									//mysqli_query($connect, "INSERT INTO `all_masters_upload_temp` (`master_id`,`tanent_id`,`master_name`, `email_id`, `company`,`phone`,`job_title`,`linkedin_url`,`master_type`,`event_id`,is_approved,`created_by`,`is_duplicate`) VALUES (0,'".$session_tanent_id."','".$name."','".$email."', '".$company."', '".$phone."', '".$job_title."', '".$linkedin_url."', '".$master_types_value."' , '".$event_id."','0','".$logged_in_user."','1')");	
								}else
								{
									mysqli_query($connect, "INSERT INTO `all_masters_upload_temp` (`master_id`,`tanent_id`,`master_name`, `email_id`, `company`,`phone`,`job_title`,`linkedin_url`,`master_type`,`event_id`,is_approved,`created_by`) VALUES (0,'".$session_tanent_id."','".$name."','".$email."', '".$company."', '".$phone."', '".$job_title."', '".$linkedin_url."', '".$master_types_value."' , '".$event_id."','0','".$logged_in_user."')");

								}
							}
						}					
							
						}
					
					}
					elseif(count($Row)== 8){
						// echo "Hii 9"; exit();
						if($m>1){ 

						$filesop = $Row;                                
						$id = $filesop[0];
						$name = mysqli_real_escape_string($connect, $filesop[1]);
						// $lastname = mysqli_real_escape_string($connect, $filesop[2]);
						$email = mysqli_real_escape_string($connect, $filesop[2]);
						$phone = mysqli_real_escape_string($connect, $filesop[3]);
						$company = mysqli_real_escape_string($connect, $filesop[4]);
						$job_title = mysqli_real_escape_string($connect, $filesop[5]);
						$linkedin_url = mysqli_real_escape_string($connect, $filesop[6]);
						$master_type = str_replace(", ","",$filesop[7]);						

					if($email !='' && $email !=' ' && $email !=null && $email !='null')
					{
						$master_types_value = '';
						$fetch_master_type = mysqli_query($connect,"SELECT group_concat(id) as master_type FROM all_master_types where (event_id = 'all' OR event_id = '".$event_id."' ) AND find_in_set(LOWER(`master_type_name`),LOWER('".$master_type."'))");
						if(mysqli_num_rows($fetch_master_type) > 0){
							$res_type = mysqli_fetch_array($fetch_master_type);
								$master_types_value = $res_type['master_type'];
						}

						if($id == null || $id == '' || $id == ' ')
						{
							$id=0;
						}

						$query_sql_re = mysqli_query($connect,"SELECT count(*) as dup_count FROM all_masters WHERE email_id='".$email."' and event_id='".$event_id."'");
				         $query_res1 = mysqli_fetch_array($query_sql_re);
				         $dupcount = $query_res1['dup_count'];

				         $query_sql_re2 = mysqli_query($connect,"SELECT count(*) as dup_count2 FROM all_masters_upload_temp WHERE email_id='".$email."' and event_id='".$event_id."'");
				         $query_res2 = mysqli_fetch_array($query_sql_re2);
				         $dupcount2 = $query_res2['dup_count2'];	
				           
				        if($id!=0)
						{
							mysqli_query($connect, "INSERT INTO `all_masters_upload_temp` (`master_id`,`tanent_id`,`master_name`, `email_id`, `company`,`job_title`,`linkedin_url` ,`phone`,`master_type`,`event_id`,`is_approved`,`created_by`) VALUES ('".$id."','".$session_tanent_id."','".$name."', '".$email."', '".$company."','".$job_title."','".$linkedin_url."', '".$phone."', '".$master_types_value."', '".$event_id."', '0','".$logged_in_user."')");
						}else
						{
							
							if($dupcount>0)
							{
								mysqli_query($connect, "INSERT INTO `all_masters_upload_temp` (`master_id`,`tanent_id`,`master_name`, `email_id`, `company`,`job_title`,`linkedin_url` ,`phone`,`master_type`,`event_id`,`is_approved`,`created_by`,`is_duplicate`) VALUES ('".$id."','".$session_tanent_id."','".$name."', '".$email."', '".$company."','".$job_title."','".$linkedin_url."', '".$phone."', '".$master_types_value."', '".$event_id."', '0','".$logged_in_user."','1')");

							}else
							{
								if($dupcount2>0)
								{
									// mysqli_query($connect, "INSERT INTO `all_masters_upload_temp` (`master_id`,`tanent_id`,`master_name`, `email_id`, `company`,`phone`,`job_title`,`linkedin_url`,`master_type`,`event_id`,is_approved,`created_by`,`is_duplicate`) VALUES ('".$id."','".$session_tanent_id."','".$name."','".$email."', '".$company."', '".$phone."', '".$job_title."', '".$linkedin_url."', '".$master_types_value."' , '".$event_id."','0','".$logged_in_user."','1')");	
								}else
								{
								mysqli_query($connect, "INSERT INTO `all_masters_upload_temp` (`master_id`,`tanent_id`,`master_name`, `email_id`, `company`,`job_title`,`linkedin_url` ,`phone`,`master_type`,`event_id`,`is_approved`,`created_by`) VALUES ('".$id."','".$session_tanent_id."','".$name."', '".$email."', '".$company."','".$job_title."','".$linkedin_url."', '".$phone."', '".$master_types_value."', '".$event_id."', '0','".$logged_in_user."')");
								}

							}
					  }
					}

																		
					}
					
					}
					$m++;
				}
			}
			
			@unlink($Filepath);  

			$insertqry="all-masters";
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','upload masters','".$m."','".$logged_in_user."',now(),\"".$insertqry."\")"); 

			header('Location:../all-masters.php?count='.($m - 1).'&upload_success&ev='.base64_encode($event_id).'&up='.base64_encode(1).'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

			}else{
					// contact limit exceed
				//2nd else
				header('Location:../all-masters.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&upload_limit_exceed');
				}

			 }else{
			 	// contact limit exceed
			 	header('Location:../all-masters.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&upload_limit_exceed');
			 }
		   
		break;



		case "sample_upload":
				require "../spreadsheet-reader-master/php-excel-reader/excel_reader2.php";
				require "../spreadsheet-reader-master/SpreadsheetReader.php";
				$event_id= $_SESSION['current_event_id'];

				$uploaddir = '../uploaded-files/';
				$uploadfile = $uploaddir . basename($_FILES['file']['name']);
				move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
				$Filepath       = $uploadfile;
				$Spreadsheet    = new SpreadsheetReader($Filepath);
				$Sheets         = $Spreadsheet -> Sheets();


				$data_array = array();


				$subsystem_arr = $component_arr = $sub_component_arr = $md_array=array();

				$ids_vals = 0;
				foreach ($Sheets as $Index => $Name)
				{
					$Spreadsheet -> ChangeSheet($Index);

					
						$flag = 0;
						$inner_array = array();
					$m = 1;
					foreach ($Spreadsheet as $Key => $Row)
					{
						
						//if(count($Row)== 7 ){
							if($m>1){
								$filesop = $Row;  

							  if($m > 1 && ($m % 2) ){
							  	$flag = 1;		  	

							  }else{
							  	$flag = 0;
							  }
										
									if($m % 2 == 0){
										for ( $col = 0; $col < 7; $col++ ){
											// var_dump($filesop[$col]);
											//   echo '<br/>';	

											  $inner_array['screen_name']= $filesop[0];	
											  $inner_array['show_1']= $filesop[1];
											  $inner_array['show_2']= $filesop[2];	  
											  $inner_array['show_3']= $filesop[3];
											  $inner_array['show_4']= $filesop[4];
											  $inner_array['show_5']= $filesop[5];
											  $inner_array['show_6']= $filesop[6];
										}
									}
									else{

										for ( $col = 0; $col < 7; $col++ ){									

											   $inner_array['show_1_movie']= $filesop[1];	
											   $inner_array['show_2_movie']= $filesop[2];
											   $inner_array['show_3_movie']= $filesop[3];
											   $inner_array['show_4_movie']= $filesop[4];
											   $inner_array['show_5_movie']= $filesop[5];
											   $inner_array['show_6_movie']= $filesop[6];
										}

										var_dump($inner_array); 

									}
									 // var_dump($inner_array); 	

									if($flag == 1){
										$data_array[] = $inner_array;

										$inner_array = array();
									}

									

									//echo "<h1><br/> iteration= ".$m." Flag = ".$flag."</h1><br/> -----------";
							}
					  $m++;
					} // end of for

					var_dump($data_array);
				}

		break;
		
		
		case "create_speaker":

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$logged_in_user= $_SESSION['user_id'];
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);

			$name = mysqli_real_escape_string($connect, $_POST['speaker_name']);
			$email = mysqli_real_escape_string($connect, $_POST['speaker_email_address']);
			$phone = mysqli_real_escape_string($connect, $_POST['phone_number']);
			$status = mysqli_real_escape_string($connect, $_POST['status']);			
			$topic_choosen = mysqli_real_escape_string($connect, $_POST['topic_chosen']);
			$uid = mysqli_real_escape_string($connect, $_POST['uid']);
			
			
			$time_slot_from = '';
			$time_slot_to = '';

			$speaker_type = mysqli_real_escape_string($connect, implode(",",$_POST['speaker_type']));
			$linkedin_handle = mysqli_real_escape_string($connect, $_POST['linkedin_handle']);
			if($linkedin_handle=="https://www.twitter.com") $linkedin_handle = "";
			$short_bio = mysqli_real_escape_string($connect, $_POST['short_bio']);
			$company = mysqli_real_escape_string($connect, $_POST['company_name']);
			$title = mysqli_real_escape_string($connect, $_POST['job_title']);
			$linkedin_url = mysqli_real_escape_string($connect, $_POST['Linkedin_url']);
			if($linkedin_url=="https://www.linkedin.com") $linkedin_url = "";
			$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
			$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
			$city = mysqli_real_escape_string($connect, $_POST['city']);
			$state = mysqli_real_escape_string($connect, $_POST['state']);
			$country = mysqli_real_escape_string($connect, $_POST['country']);
			$zipcode = mysqli_real_escape_string($connect, $_POST['zipcode']);
			$speaker_manager = mysqli_real_escape_string($connect, $_POST['speaker_manager_name']);
			$speaker_manager_phone = mysqli_real_escape_string($connect, $_POST['speaker_manager_phone']);
			$speaker_manager_email = mysqli_real_escape_string($connect, $_POST['speaker_manager_email']);
			$banner_image_txt = mysqli_real_escape_string($connect, $_POST['banner_image']);
			
			$your_quote = mysqli_real_escape_string($connect, $_POST['your_quote']);
			$facebook_url = mysqli_real_escape_string($connect, $_POST['Facebook_url']);
			if($facebook_url=="https://www.facebook.com/") $facebook_url = "";
			$instagram_url = mysqli_real_escape_string($connect, $_POST['instagram_url']);
			if($instagram_url=="https://www.instagram.com/") $instagram_url = "";
			//$events = mysqli_real_escape_string($connect, $_POST['events']);
			$title1 = mysqli_real_escape_string($connect, $_POST['title1']);
			$title2 = mysqli_real_escape_string($connect, $_POST['title2']);
			$title3 = mysqli_real_escape_string($connect, $_POST['title3']);
			$description1 = mysqli_real_escape_string($connect, $_POST['description1']);
			$description2 = mysqli_real_escape_string($connect, $_POST['description2']);
			$description3 = mysqli_real_escape_string($connect, $_POST['description3']);
			$media_sharing = mysqli_real_escape_string($connect, $_POST['media_sharing']);

			$speaker_expertise = mysqli_real_escape_string($connect, $_POST['expertise']);
			$events = mysqli_real_escape_string($connect, $_POST['promote_events']);
			if(isset($_POST['promote'])){
			$promote= mysqli_real_escape_string($connect,implode(",",$_POST['promote']));
			}else{
			$promote="";
			}

			$acknowledgements=$_POST['acknowledgements'];

			if(isset($_POST['participation'])){
			$participation= mysqli_real_escape_string($connect,implode(",",$_POST['participation']));
			}else{
			$participation="";
			}
			if(isset($_POST['speakerRequest'])){
			$speakerRequest= mysqli_real_escape_string($connect,implode(",",$_POST['speakerRequest']));
			}else{
			$speakerRequest="";
			}


			if($media_sharing == '' || $media_sharing == 'no'){
				$is_media_sharing = 0;
			}else{
				$is_media_sharing = 1;
			}
			$website_listing = mysqli_real_escape_string($connect, $_POST['website_listing']);
			if($website_listing == '' || $website_listing == 'no'){
				$is_website_listing = 0;
			}else{
				$is_website_listing = 1;
			}
			$speaker_coach = mysqli_real_escape_string($connect, $_POST['speaker_coach']);
			if($speaker_coach == '' || $speaker_coach == 'no'){
				$is_speaker_coach = 0;
			}else{
				$is_speaker_coach = 1;
			}
			$video_promotion = mysqli_real_escape_string($connect, $_POST['video_promotion']);
			if($video_promotion == '' || $video_promotion == 'no'){
				$is_video_promotion = 0;
			}else{
				$is_video_promotion = 1;
			}
			$orientation = mysqli_real_escape_string($connect, $_POST['orientation']);
			if($orientation == '' || $orientation == 'no'){
				$is_orientation = 0;
			}else{
					$is_orientation = 1;
			}
			$reception_invitation = mysqli_real_escape_string($connect, $_POST['reception_invitation']);
			if($reception_invitation == '' || $reception_invitation == 'no'){
				$is_reception_invitation = 0;
			}else{
				$is_reception_invitation = 1;
			}

			
			$data = $banner_image_txt;
				if($data){
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$data = base64_decode($data);
					$heading = preg_replace('/[^A-Za-z0-9\-]/', '', "speaker");
					$rand = rand().$i;
					$allFileNames .= $file_name = $heading.'_'.$rand.'.jpg';
					file_put_contents('../images/'.$file_name, $data);				
					
				}
			
			$directoryName="../images/";
			$profile_pic = '';
			if($_POST['image_src']) {
			$fname='';
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
			$profile_pic=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$profile_pic , base64_decode($file));

			} 

			$fetch_doc_names = mysqli_query($connect,"SELECT * FROM dropzone where uid = '$uid' ");
			$all_docs_names = '';
			if(mysqli_num_rows($fetch_doc_names) > 0 ){
				while ($res = mysqli_fetch_array($fetch_doc_names)) {
					$all_docs_names = $all_docs_names. $res['filename'].'~';
				}
			}

			$twitter_followers = mysqli_real_escape_string($connect, $_POST['twitter_followers']);
			$twitter_lastupdated = mysqli_real_escape_string($connect, $_POST['twitter_lastupdated']);
			$linkedin_connections = mysqli_real_escape_string($connect, $_POST['linkedin_connections']);
			$linkedin_lastupdated = mysqli_real_escape_string($connect, $_POST['linkedin_lastupdated']);
			$social_media_total_score =  0;
			if(!empty($twitter_followers)&&!empty($twitter_lastupdated)&&!empty($linkedin_connections)&&!empty($linkedin_lastupdated)){
				$social_media_total_score = (($twitter_followers)+ ($twitter_lastupdated)+ ($linkedin_connections)+ ($linkedin_lastupdated))/4; 				
			}

			$speaker_note = mysqli_real_escape_string($connect, trim($_POST['speaker_note']));
			$loggedin_userid = mysqli_real_escape_string($connect, $_POST['loggedin_userid']);	
			$website_name = mysqli_real_escape_string($connect, $_POST['web_name']);
			$website_url = mysqli_real_escape_string($connect, $_POST['web_url']);			
			
			$insert_speaker_qry =  "INSERT INTO `all_speakers` (`tanent_id`,`speaker_name`, `email_id`, `company`, `topic_choosen`, `time_slot_from`,`time_slot_to`, `linkedin_handle`, `short_bio`, `title`, `head_shot`, `linkedin_url`, `address1`,`address2`,`city`,`state`,  `speaker_manager`, `phone`,`speaker_manager_phone`, `speaker_manager_email`, `status`,`other_documents`,`speaker_type`, `willing_to_promote`,`willing_to_promote_yes`, `presentation_title1`, `presentation_description1`, `presentation_title2`, `presentation_description2`, `presentation_title3`, `presentation_description3`,`your_quote`,`facebook`, `instagram`, `twitter_followers`, `twitter_lastupdated`, `linkedin_connections`, `linkedin_lastupdated`, `social_media_total_score`, `is_social_media_sharing_complete`,`is_website_listing_complete`,`is_speaker_coach_assign`,`is_video_promotion_complete`,`is_orientation_attend`,`is_reception_invitation_accept`,event_id,`speaker_requests`,`speaker_expertise`,`acknowledgement`,`country`,`zip`,`website_name`,`website_url`) VALUES ('".$session_tanent_id."','".$name."', '".$email."', '".$company."', '".$topic_choosen."', '".$time_slot_from."', '".$time_slot_to."', '".$linkedin_handle."', '".$short_bio."', '".$title."', '".$profile_pic."', '".$linkedin_url."', '".$address1."', '".$address2."', '".$city."', '".$state."', '".$speaker_manager."', '".$phone."', '".$speaker_manager_phone."', '".$speaker_manager_email."', '".$status."','".$all_docs_names."','".$participation."','".$events."','".$promote."','".$title1."','".$description1."','".$title2."','".$description2."','".$title3."','".$description3."','".$your_quote."','".$facebook_url."','".$instagram_url."','".$twitter_followers."','".$twitter_lastupdated."','".$linkedin_connections."','".$linkedin_lastupdated."','".$social_media_total_score."','".$is_media_sharing."','".$is_website_listing."','".$is_speaker_coach."','".$is_video_promotion."','".$is_orientation."','".$is_reception_invitation."', '".$event_id."','".$speakerRequest."','".$speaker_expertise."', '".$acknowledgements."','".$country."','".$zipcode."','".$website_name."','".$website_url."')";

			$insert_speaker = mysqli_query($connect,$insert_speaker_qry);
			
			if($insert_speaker){
				$speakerid = mysqli_insert_id($connect);

				// update profile completeness
			 	$profile_complete = $common->get_speaker_info_missing_value($speakerid);

				 mysqli_query($connect, "UPDATE `all_speakers` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speakerid );

				
				$insert_note = mysqli_query($connect,"INSERT INTO speaker_notes (notes,speaker_id,created_by) select notes,$speakerid,created_by from new_speaker_notes where uniqueid='".$uid."'");

				$insert_documentation = mysqli_query($connect,"INSERT INTO `speaker_documents` ( speaker_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type,file_type,tenant_id,event_id) select $speakerid,document_title,file_name,file_extension,url,is_deleted,publish_externally,doc_type,file_type,$session_tanent_id,$event_id from new_speaker_documents where uniqueid='".$uid."'");

				//**** add log
				mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','create speaker','".$speakerid."','".$loggedin_userid."',now(),\"".$insert_speaker_qry."\")");

				$all_speakers_array = calculate_speaker_dashboard_count($event_id);
				$status_update = $common->calculate_speaker_status_count($event_id);
				$type_update = $common->calculate_speaker_type_count($event_id);

			}

			header('Location:../all-speakers.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

		break;
		
		case "create_master":

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$logged_in_user= $_SESSION['user_id'];

			$name = mysqli_real_escape_string($connect, $_POST['master_name']);
			//$lastname = mysqli_real_escape_string($connect, $_POST['master_lastname']);
			$email = mysqli_real_escape_string($connect, $_POST['master_email_address']);
			$phone = mysqli_real_escape_string($connect, $_POST['phone_number']);
			$master_type = mysqli_real_escape_string($connect, implode(",",$_POST['master_type']));
			$company = mysqli_real_escape_string($connect, $_POST['company_name']);
			$job_title = mysqli_real_escape_string($connect, $_POST['job_title']);
			$linkedin_url = mysqli_real_escape_string($connect, $_POST['linkedin_url']);
			$twitter_url = mysqli_real_escape_string($connect, $_POST['twitter_url']);

			$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
			$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
			$country = mysqli_real_escape_string($connect, $_POST['country']);
			$city = mysqli_real_escape_string($connect, $_POST['city']);
			$state = mysqli_real_escape_string($connect, $_POST['state']);
			$zip = mysqli_real_escape_string($connect, $_POST['zip']);
			
			$insert_qry="INSERT INTO `all_masters` (`tanent_id`,`master_name`,`master_lastname`, `email_id`, `company`,`phone`,`master_type`,`job_title`,`linkedin_url`, `event_id`,`twitter_url`,`is_approved`,`address1`,`address2`,`city`,`state`,`country`,`zip`) VALUES ('".$session_tanent_id."','".$name."','', '".$email."', '".$company."', '".$phone."', '".$master_type."', '".$job_title."', '".$linkedin_url."', '".$event_id."', '".$twitter_url."','1','".$address1."','".$address2."','".$city."','".$state."','".$country."','".$zip."')";

			mysqli_query($connect,$insert_qry);
			$last_insert_id = mysqli_insert_id($connect);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','create master','".$last_insert_id."','".$logged_in_user."',now(),\"".$insert_qry."\")");

			//updaing master counts
			$all_masters_count_sp = calculate_master_dashboard_count($event_id);
			$type_count_update = $common->calculate_master_type_count($event_id);


			header('Location:../all-masters.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

		break;

		
		case "edit_master":

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$logged_in_user= $_SESSION['user_id'];
			$name = mysqli_real_escape_string($connect, $_POST['master_name']);
			// $lastname = mysqli_real_escape_string($connect, $_POST['master_lastname']);
			$email = mysqli_real_escape_string($connect, $_POST['master_email_address']);
			$phone = mysqli_real_escape_string($connect, $_POST['phone_number']);
			$master_type = mysqli_real_escape_string($connect, implode(",",$_POST['master_type']));
			$company = mysqli_real_escape_string($connect, $_POST['company_name']);
			$job_title = mysqli_real_escape_string($connect, $_POST['job_title']);
			$linkedin_url = mysqli_real_escape_string($connect, $_POST['linkedin_url']);
			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$twitter_url = mysqli_real_escape_string($connect, $_POST['twitter_url']);

			$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
			$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
			$country = mysqli_real_escape_string($connect, $_POST['country']);
			$city = mysqli_real_escape_string($connect, $_POST['city']);
			$state = mysqli_real_escape_string($connect, $_POST['state']);
			$zip = mysqli_real_escape_string($connect, $_POST['zip']);
			
			$update_qry="UPDATE  `all_masters` SET `master_name`='".$name."', `email_id`='".$email."', `company`='".$company."',`phone`='".$phone."',`master_type`= '".$master_type."',`job_title` = '".$job_title."',`linkedin_url` = '".$linkedin_url."',`twitter_url` = '".$twitter_url."',`address1`= '".$address1."',`address2`= '".$address2."',`city`= '".$city."',`state`= '".$state."',`country`= '".$country."',`zip`= '".$zip."' WHERE id=".$id;
			mysqli_query($connect,$update_qry);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Edit master','".$id."','".$logged_in_user."',now(),\"".$update_qry."\")");

			//updaing master counts
			$all_masters_count_sp = calculate_master_dashboard_count($event_id);
			$type_count_update = $common->calculate_master_type_count($event_id);

			header('Location:../all-masters.php?updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

		break;
				
		
		case "edit_speaker":

			$name = mysqli_real_escape_string($connect, $_POST['speaker_name']);
			$email = mysqli_real_escape_string($connect, $_POST['speaker_email_address']);
			$phone = mysqli_real_escape_string($connect, $_POST['phone_number']);
			$topic_choosen = mysqli_real_escape_string($connect, $_POST['topic_chosen']);
			
			$status = mysqli_real_escape_string($connect, $_POST['status']);

			$uid = mysqli_real_escape_string($connect, $_POST['uid']);
			$updated_doc_names = mysqli_real_escape_string($connect, $_POST['updated_doc_names']);

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$logged_in_user= $_SESSION['user_id'];
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$time_slot_from = '';
			$time_slot_to ='';


			$linkedin_handle = mysqli_real_escape_string($connect, $_POST['linkedin_handle']);
			if($linkedin_handle=="https://www.twitter.com/") $linkedin_handle = "";
			$short_bio = mysqli_real_escape_string($connect, $_POST['short_bio']);
			$company = mysqli_real_escape_string($connect, $_POST['company_name']);
			$title = mysqli_real_escape_string($connect, $_POST['job_title']);
			$linkedin_url = mysqli_real_escape_string($connect, $_POST['Linkedin_url']);
			if($linkedin_url=="https://www.linkedin.com/") $linkedin_url = "";
			$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
			$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
			$city = mysqli_real_escape_string($connect, $_POST['city']);
			$state = mysqli_real_escape_string($connect, $_POST['state']);
			$country = mysqli_real_escape_string($connect, $_POST['country']);
			$zipcode = mysqli_real_escape_string($connect, $_POST['zipcode']);
			$speaker_manager = mysqli_real_escape_string($connect, $_POST['speaker_manager_name']);
			$speaker_manager_phone = mysqli_real_escape_string($connect, $_POST['speaker_manager_phone']);
			$speaker_manager_email = mysqli_real_escape_string($connect, $_POST['speaker_manager_email']);
			$banner_image_txt = mysqli_real_escape_string($connect, $_POST['banner_image']);
			$speaker_img = mysqli_real_escape_string($connect, $_POST['speaker_img']);
			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$speaker_type = mysqli_real_escape_string($connect, implode(",",$_POST['speaker_type']));
			$speaker_expertise = mysqli_real_escape_string($connect, $_POST['expertise']);
						
			$your_quote = mysqli_real_escape_string($connect, $_POST['your_quote']);
			$facebook_url = mysqli_real_escape_string($connect, $_POST['Facebook_url']);
			if($facebook_url=="https://www.facebook.com/") $facebook_url = "";
			$instagram_url = mysqli_real_escape_string($connect, $_POST['instagram_url']);
			if($instagram_url=="https://www.instagram.com/") $instagram_url = "";
			$events = mysqli_real_escape_string($connect, $_POST['promote_events']);
			$title1 = mysqli_real_escape_string($connect, $_POST['title1']);
			$title2 = mysqli_real_escape_string($connect, $_POST['title2']);
			$title3 = mysqli_real_escape_string($connect, $_POST['title3']);
			$description1 = mysqli_real_escape_string($connect, $_POST['description1']);
			$description2 = mysqli_real_escape_string($connect, $_POST['description2']);
			$description3 = mysqli_real_escape_string($connect, $_POST['description3']);
			if(isset($_POST['promote'])){
			$promote= mysqli_real_escape_string($connect,implode(",",$_POST['promote']));
			}else{
			$promote="";
			}

			$acknowledgements=$_POST['acknowledgements'];

			if(isset($_POST['participation'])){
			$participation= mysqli_real_escape_string($connect,implode(",",$_POST['participation']));
			}else{
			$participation="";
			}
			if(isset($_POST['speakerRequest'])){
			$speakerRequest= mysqli_real_escape_string($connect,implode(",",$_POST['speakerRequest']));
			}else{
			$speakerRequest="";
			}

			if($events == 'no')
			{
				$promote="";
			}

			$media_sharing = mysqli_real_escape_string($connect, $_POST['media_sharing']);
			if($media_sharing == '' || $media_sharing == 'no'){
				$is_media_sharing = 0;
			}else{
				$is_media_sharing = 1;
			}
			$website_listing = mysqli_real_escape_string($connect, $_POST['website_listing']);
			if($website_listing == '' || $website_listing == 'no'){
				$is_website_listing = 0;
			}else{
				$is_website_listing = 1;
			}
			$speaker_coach = mysqli_real_escape_string($connect, $_POST['speaker_coach']);
			if($speaker_coach == '' || $speaker_coach == 'no'){
				$is_speaker_coach = 0;
			}else{
				$is_speaker_coach = 1;
			}
			$video_promotion = mysqli_real_escape_string($connect, $_POST['video_promotion']);
			if($video_promotion == '' || $video_promotion == 'no'){
				$is_video_promotion = 0;
			}else{
				$is_video_promotion = 1;
			}
			$orientation = mysqli_real_escape_string($connect, $_POST['orientation']);
			if($orientation == '' || $orientation == 'no'){
				$is_orientation = 0;
			}else{
					$is_orientation = 1;
			}
			$reception_invitation = mysqli_real_escape_string($connect, $_POST['reception_invitation']);
			if($reception_invitation == '' || $reception_invitation == 'no'){
				$is_reception_invitation = 0;
			}else{
				$is_reception_invitation = 1;
			}

			$twitter_followers = mysqli_real_escape_string($connect, $_POST['twitter_followers']);
			$twitter_lastupdated = mysqli_real_escape_string($connect, $_POST['twitter_lastupdated']);
			$linkedin_connections = mysqli_real_escape_string($connect, $_POST['linkedin_connections']);
			$linkedin_lastupdated = mysqli_real_escape_string($connect, $_POST['linkedin_lastupdated']);
			$social_media_total_score =  0;
			if(!empty($twitter_followers)&&!empty($twitter_lastupdated)&&!empty($linkedin_connections)&&!empty($linkedin_lastupdated)){
				$social_media_total_score = (($twitter_followers)+ ($twitter_lastupdated)+ ($linkedin_connections)+ ($linkedin_lastupdated))/4; 				
			}

			$website_name = mysqli_real_escape_string($connect, $_POST['web_name']);
			$website_url = mysqli_real_escape_string($connect, $_POST['web_url']);

			$final_docs_name='';
			// `willing_to_promote_yes`='".$promote."',speaker_requests= '".$speakerRequest."',`speaker_type`='".$participation."'
			$update_qry= "UPDATE `all_speakers` SET `speaker_name`='".$name."', `email_id`='".$email."', `company`='".$company."', `topic_choosen`='".$topic_choosen."', `time_slot_from`='".$time_slot_from."',`time_slot_to`='".$time_slot_to."', `linkedin_handle`='".$linkedin_handle."', `short_bio`='".$short_bio."', `title`='".$title."',`linkedin_url`='".$linkedin_url."', `speaker_manager`='".$speaker_manager."', `phone`='".$phone."',`speaker_manager_phone`='".$speaker_manager_phone."', `speaker_manager_email`= '".$speaker_manager_email."', `address1`='".$address1."', `address2`='".$address2."', `city`='".$city."', `state`='".$state."',`other_documents`='".$final_docs_name."',`willing_to_promote`='".$events."', `presentation_title1`='".$title1."', `presentation_description1`='".$description1."', `presentation_title2`='".$title2."', `presentation_description2`='".$description2."', `presentation_title3`='".$title3."', `presentation_description3`='".$description3."',`your_quote`='".$your_quote."',`facebook`='".$facebook_url."', `instagram`='".$instagram_url."', `twitter_followers`='".$twitter_followers."', `twitter_lastupdated`='".$twitter_lastupdated."', `linkedin_connections`='".$linkedin_connections."', `linkedin_lastupdated`='".$linkedin_lastupdated."',social_media_total_score='".$social_media_total_score."', is_social_media_sharing_complete = '".$is_media_sharing."',is_website_listing_complete='".$is_website_listing."', is_speaker_coach_assign = '".$is_speaker_coach."', is_video_promotion_complete ='".$is_video_promotion."', is_orientation_attend = '".$is_orientation."', is_reception_invitation_accept ='".$is_reception_invitation."',speaker_expertise= '".$speaker_expertise."',acknowledgement='".$acknowledgements."',country= '".$country."',zip='".$zipcode."',website_name= '".$website_name."',website_url= '".$website_url."'  WHERE id=".$id;

			mysqli_query($connect,$update_qry);

			// update profile completeness
			 $profile_complete = $common->get_speaker_info_missing_value($id);
			 //var_dump($id." <> ".$profile_complete); exit();
			 mysqli_query($connect, "UPDATE `all_speakers` SET `profile_completeness`='".$profile_complete."' WHERE id=".$id );
			 mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','edit speaker','".$id."','".$logged_in_user."',now(),\"".$update_qry."\")");

			 $all_speakers_array = calculate_speaker_dashboard_count($event_id);
			 $status_update = $common->calculate_speaker_status_count($event_id);
			 $type_update = $common->calculate_speaker_type_count($event_id);
			
			header('Location:../all-speakers.php?updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

		break;
		
		
		case "create_speaker_type":
			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$speaker_type_name = mysqli_real_escape_string($connect, $_POST['speaker_type_name']);

			$result = array('rgb' => '', 'hex' => '');
		    foreach(array('r', 'b', 'g') as $col){
		        $rand = mt_rand(0, 255);
		        $result['r g b'][$col] = $rand;
		        $dechex = dechex($rand);
		        if(strlen($dechex) < 2){
		            $dechex = '0' . $dechex;
		        }
		        $result['hex'] .= $dechex;
		    }
		    $colourcode='#'.$result['hex'];

		    if($colourcode=='')
		    {
		    	$colourcode='#000000';	
		    }

			$sql = "INSERT INTO all_speaker_types(tanent_id,speaker_type_name,Isdefault,event_id,colour_code) VALUES ('".$session_tanent_id."','".$speaker_type_name."',0,'".$event_id."','".$colourcode."')";

			mysqli_query($connect, $sql);
			$last_insert_id = mysqli_insert_id($connect);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','created new speaker type','".$last_insert_id."','".$id_user."',now(),\"".$sql."\")");

			header('Location:../speaker_types.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;


		case "edit_speaker_type":
			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$speaker_type_name = mysqli_real_escape_string($connect, $_POST['speaker_type_name']);
			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$sql = "UPDATE all_speaker_types SET speaker_type_name='".$speaker_type_name."' WHERE id=".$id;
			mysqli_query($connect, $sql);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','update speaker type','".$id."','".$id_user."',now(),\"".$sql."\")");
			
			header('Location:../speaker_types.php?updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;
		
		case "create_master_type":

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$master_type_name = mysqli_real_escape_string($connect, $_POST['master_type_name']);
			$master_type_public = mysqli_real_escape_string($connect, $_POST['master_type_public']);
			$is_public = '';

			if($master_type_public == 'yes'){
				$is_public = '1';
			}else{
				$is_public = '0';
			}

			$sql = "INSERT INTO all_master_types(master_type_name,is_public,event_id) VALUES ('".$master_type_name."','".$is_public."','".$event_id."')";
			mysqli_query($connect, $sql);
			$last_insert_id = mysqli_insert_id($connect);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','created new master type','".$last_insert_id."','".$id_user."',now(),\"".$sql."\")");

			header('Location:../master_types.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

		case "edit_master_type":

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$master_type_name = mysqli_real_escape_string($connect, $_POST['master_type_name']);
			$master_type_public = mysqli_real_escape_string($connect, $_POST['master_type_public']);
			$is_public = '';

			if($master_type_public == 'yes'){
				$is_public = '1';
			}else{
				$is_public = '0';
			}

			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$sql = "UPDATE all_master_types SET master_type_name='".$master_type_name."',is_public = '".$is_public."' WHERE id=".$id;
			mysqli_query($connect, $sql);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','update master type','".$id."','".$id_user."',now(),\"".$sql."\")");
			
			header('Location:../master_types.php?updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;


		
		case "create_action_type":
			$event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$action_type_name = mysqli_real_escape_string($connect, $_POST['action_type_name']);
			$sql = "INSERT INTO all_action_types(action_type_name,event_id) VALUES ('".$action_type_name."','".$event_id."')";
			mysqli_query($connect, $sql);
			$last_insert_id = mysqli_insert_id($connect);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','created new action type','".$last_insert_id."','".$id_user."',now(),\"".$sql."\")");

			header('Location:../action_types.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

		
		case "create_resource_type":
			$event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$resource_type_name = mysqli_real_escape_string($connect, $_POST['resource_type_name']);
			$sql = "INSERT INTO all_resource_types (resource_type_name,event_id) VALUES ('".$resource_type_name."','".$event_id."')";
			mysqli_query($connect, $sql);
			$last_insert_id = mysqli_insert_id($connect);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','created new resource type','".$last_insert_id."','".$id_user."',now(),\"".$sql."\")");
			header('Location:../resource_types.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

		case "edit_action_type":
			$event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$action_type_name = mysqli_real_escape_string($connect, $_POST['action_type_name']);
			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$sql = "UPDATE all_action_types SET action_type_name='".$action_type_name."' WHERE id=".$id;
			mysqli_query($connect, $sql);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','update action type','".$id."','".$id_user."',now(),\"".$sql."\")");
			
			header('Location:../action_types.php?updated-succes&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

		case "edit_resource_type":
		    $event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
		   	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$resource_type_name = mysqli_real_escape_string($connect, $_POST['resource_type_name']);
			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$sql = "UPDATE all_resource_types SET resource_type_name='".$resource_type_name."' WHERE id=".$id;
			//echo $sql;exit();
			mysqli_query($connect, $sql);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','update resource type','".$id."','".$id_user."',now(),\"".$sql."\")");

			header('Location:../resource_types.php?updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

		
			case "create_sponsor_type":
			$event_id= mysqli_real_escape_string($connect, $_POST['current_event_id']);
		   	$sponsor_type_name = mysqli_real_escape_string($connect, $_POST['sponsor_type_name']);
		   	$sponsor_avail_units = mysqli_real_escape_string($connect, $_POST['sponsor_avail_units']);
		   	$sponsor_cost_per_unit = mysqli_real_escape_string($connect, $_POST['sponsor_cost_per_unit']);
		   	$benefits = mysqli_real_escape_string($connect, $_POST['benefits']);
		   	$total_cost=$sponsor_avail_units*$sponsor_cost_per_unit;

			$sql = "INSERT INTO all_sponsor_types(sponsor_type_name,event_id,available_units,cost_per_unit,total_unit_value,benefit) VALUES ('".$sponsor_type_name."','".$event_id."','".$sponsor_avail_units."','".$sponsor_cost_per_unit."','".$total_cost."','".$benefits."')";
			mysqli_query($connect, $sql);
			$last_insert_id =mysqli_insert_id($connect);

			$tenant_id = $common->get_tenant_id_from_eventid($event_id);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry,table_name) VALUES ('".$tenant_id."','".$event_id."','create sponsor type','".$last_insert_id."','".$id_user."',now(),\"".$sql."\",'all_sponsor_types')");	
			header('Location:../sponsor_types.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&created-success');
		break;
		
		
		case "edit_sponsor_type":
		   	$sponsor_type_name = mysqli_real_escape_string($connect, $_POST['sponsor_type_name']);
		   	$sponsor_avail_units = mysqli_real_escape_string($connect, $_POST['sponsor_avail_units']);
		   	$sponsor_cost_per_unit = mysqli_real_escape_string($connect, $_POST['sponsor_cost_per_unit']);
		   	$benefits = mysqli_real_escape_string($connect, $_POST['benefits']);
		   	$total_cost=$sponsor_avail_units*$sponsor_cost_per_unit;
		   	$id = mysqli_real_escape_string($connect, $_POST['id']);
		   	// $event_id= $_SESSION['current_event_id'];

		   	$event_id= mysqli_real_escape_string($connect, $_POST['current_event_id']);		   	

			$sql = "UPDATE all_sponsor_types SET sponsor_type_name='".$sponsor_type_name."',available_units='".$sponsor_avail_units."',cost_per_unit='".$sponsor_cost_per_unit."',total_unit_value='".$total_cost."',benefit='".$benefits."' WHERE id=".$id;
			mysqli_query($connect, $sql);

			$tenant_id = $common->get_tenant_id_from_eventid($event_id);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry,table_name) VALUES ('".$tenant_id."','".$event_id."','edit sponsor type','".$id."','".$id_user."',now(),\"".$sql."\",'all_sponsor_types')");			

			header('Location:../sponsor_types.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&updated-success');
		break;
		
		case "create_sponsor":

			// $event_id= $_SESSION['current_event_id'];
			$logged_in_user= $_SESSION['user_id'];

			$event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']);
			$sponsor_company_name = mysqli_real_escape_string($connect, $_POST['sponsor_company_name']);
			$sponsor_type = mysqli_real_escape_string($connect, implode(",",$_POST['sponsor_type_id']));
			//$sponsor_type='';
			$sponsor_contact_person = mysqli_real_escape_string($connect, $_POST['sponsor_contact_person']);
			$sponsor_contact_number = mysqli_real_escape_string($connect, $_POST['sponsor_contact_number']);
			$sponsor_status = mysqli_real_escape_string($connect, $_POST['sponsor_status']);
			$sponsor_contact_email_address = mysqli_real_escape_string($connect, $_POST['sponsor_contact_email_address']);
			$sponsor_role = mysqli_real_escape_string($connect, $_POST['sponsor_role']);
			$secondary1_sponsor_contact_person = mysqli_real_escape_string($connect, $_POST['secondary1_sponsor_contact_person']);
			$secondary1_sponsor_contact_number = mysqli_real_escape_string($connect, $_POST['secondary1_sponsor_contact_number']);
			$secondary1_sponsor_contact_email_address = mysqli_real_escape_string($connect, $_POST['secondary1_sponsor_contact_email_address']);
			$secondary1_sponsor_role = mysqli_real_escape_string($connect, $_POST['secondary1_sponsor_role']);
	
			$secondary2_sponsor_contact_person = '';
			$secondary2_sponsor_contact_number = '';
			$secondary2_sponsor_contact_email_address = '';
			$secondary2_sponsor_role = '';
			
			
			$sponsor_bio = mysqli_real_escape_string($connect, $_POST['sponsor_bio']);
			$facebook_url = mysqli_real_escape_string($connect, $_POST['facebook_url']);
			$twitter_url = mysqli_real_escape_string($connect, $_POST['twitter_url']);
			$linkedin_url = mysqli_real_escape_string($connect, $_POST['linkedin_url']);
			$instagram_url = mysqli_real_escape_string($connect, $_POST['instagram_url']);
			$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
			$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
			$city = mysqli_real_escape_string($connect, $_POST['city']);
			$state = mysqli_real_escape_string($connect, $_POST['state']);

			$uid = mysqli_real_escape_string($connect, $_POST['uid']);
			
			if($facebook_url=="https://www.facebook.com/") $facebook_url = "";
			if($twitter_url=="https://www.twitter.com/") $twitter_url = "";
			if($linkedin_url=="https://www.linkedin.com/") $linkedin_url = "";
			if($instagram_url=="https://www.instagram.com/") $instagram_url = "";
		

			$directoryName="../images/";
			$profile_pic = '';

			/*if($_POST['image_src']) {
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
			$profile_pic=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$profile_pic , base64_decode($file));
			} */
			if(basename( $_FILES["fileToUpload"]["name"])!= '') {
				
				$temp = explode(".", $_FILES["fileToUpload"]["name"]);
				$profile_pic = "sponsor_logo_".round(microtime(true)) . '.' . end($temp);
				move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $directoryName . $profile_pic);
			}
			//var_dump($profile_pic); exit();

				
			$all_docs_names = '';


			$company_url = mysqli_real_escape_string($connect, $_POST['company_url']);
			$country = mysqli_real_escape_string($connect, $_POST['country']);
			$zip_code = mysqli_real_escape_string($connect, $_POST['zip_code']);
			$social_media_reach = mysqli_real_escape_string($connect, $_POST['social_media_reach']);
			$email_reach = mysqli_real_escape_string($connect, $_POST['email_reach']);
			$other_contact_name = mysqli_real_escape_string($connect, $_POST['other_contact_name']);
			$other_contact_number = mysqli_real_escape_string($connect, $_POST['other_contact_number']);
			$other_contact_email_address = mysqli_real_escape_string($connect, $_POST['other_contact_email_address']);
			$other_role = mysqli_real_escape_string($connect, $_POST['other_role']);
			$potential_funding_ask = mysqli_real_escape_string($connect, $_POST['potential_funding_ask']);
			$committed_funding = mysqli_real_escape_string($connect, $_POST['committed_funding']);

			 if($_POST['estimated_time_to_close'] == ' ' || $_POST['estimated_time_to_close'] == '')
		        { 
		          $estimated_time_to_close = '';
		        }else
		        { 
		           $estimated_time_to_close = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['estimated_time_to_close'])));
		        }
		         if($_POST['date_to_close'] == ' ' || $_POST['date_to_close'] == '')
		        { 
		          $date_to_close = '';
		        }else
		        { 
		           $date_to_close =date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['date_to_close'])));
		        }
      
		        $tenant_id = $common->get_tenant_id_from_eventid($event_id);

			$sql = "INSERT INTO `all_sponsors` (`tanent_id`,`sponsor_company_name`, `sponsor_type`, `sponsor_contact_person`, `sponsor_contact_number`, `sponsor_contact_email_address`, `sponsor_role`,`secondary1_sponsor_contact_person`, `secondary1_sponsor_contact_number`, `secondary1_sponsor_contact_email_address`, `secondary1_sponsor_role`,`secondary2_sponsor_contact_person`, `secondary2_sponsor_contact_number`, `secondary2_sponsor_contact_email_address`, `secondary2_sponsor_role`, `sponsor_bio`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `address1`,`address2`,`city`,`state`, `banner_image`, `other_documents`,`status`,`event_id`,`company_url`,`country`,`zipcode`,`sponsor_logo`,`total_social_media_reach`,`total_email_reach`,`other_contact_name`,`other_contact_number`,`other_email_address`,`other_role`,`potential_funding_ask`,`committed_funding`,
				`estimated_time_to_close`,`close_date`) VALUES ('".$tenant_id."','".$sponsor_company_name."', '".$sponsor_type."', '".$sponsor_contact_person."', '".$sponsor_contact_number."', '".$sponsor_contact_email_address."','".$sponsor_role."', '".$secondary1_sponsor_contact_person."', '".$secondary1_sponsor_contact_number."', '".$secondary1_sponsor_contact_email_address."','".$secondary1_sponsor_role."', '".$secondary2_sponsor_contact_person."', '".$secondary2_sponsor_contact_number."', '".$secondary2_sponsor_contact_email_address."','".$secondary2_sponsor_role."', '".$sponsor_bio."', '".$facebook_url."', '".$twitter_url."', '".$linkedin_url."', '".$instagram_url."', '".$address1."', '".$address2."', '".$city."', '".$state."', '".$file_name."', '".$all_docs_names."','".$sponsor_status."','".$event_id."','".$company_url."','".$country."','".$zip_code."','".$profile_pic."','".$social_media_reach."','".$email_reach."','".$other_contact_name."','".$other_contact_number."','".$other_contact_email_address."','".$other_role."','".$potential_funding_ask."','".$committed_funding."','".$estimated_time_to_close."','".$date_to_close."')";
			$insert_speaker=mysqli_query($connect, $sql);

			if($insert_speaker){
				$sponsor_id = mysqli_insert_id($connect);

				$insert_note = mysqli_query($connect,"INSERT INTO sponsor_notes (notes,sponsor_id,created_by) select notes,$sponsor_id,created_by from new_sponsor_notes where uniqueid='".$uid."'");

				$insert_documentation = mysqli_query($connect,"INSERT INTO `sponsor_documents` ( sponsor_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type,tenant_id,event_id) 
					select $sponsor_id,document_title,file_name,file_extension,url,is_deleted,publish_externally,doc_type,$tenant_id,$event_id from new_sponsor_documents where uniqueid='".$uid."'");

				$insert_note = mysqli_query($connect,"INSERT INTO sponsor_sponsorship_type (sponsor_type,committed_unit,sponsorship_values,sponsor_id,created_by) select sponsor_type,committed_unit,sponsorship_values,$sponsor_id,created_by from new_sponsorship_type where uniqueid='".$uid."'"); 

				$all_speakers_array = calculate_sponsor_dashboard_count($event_id);
				$status_update = $common->calculate_sponsor_status_count($event_id);
				$type_update = $common->calculate_sponsor_type_count($event_id);
			} 

			
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$tenant_id."','".$event_id."','create sponsor','".$sponsor_id."','".$id_user."',now(),\"".$sql."\")");

			header('Location:../all-sponsors.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&created-success');

		break;
		
		case "edit_sponsor":

			$event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']);
			$sponsor_company_name = mysqli_real_escape_string($connect, $_POST['sponsor_company_name']);
			$sponsor_type = mysqli_real_escape_string($connect, implode(",",$_POST['sponsor_type_id']));
			$sponsor_contact_person = mysqli_real_escape_string($connect, $_POST['sponsor_contact_person']);
			$sponsor_contact_number = mysqli_real_escape_string($connect, $_POST['sponsor_contact_number']);
			$sponsor_contact_email_address = mysqli_real_escape_string($connect, $_POST['sponsor_contact_email_address']);
			$sponsor_status = mysqli_real_escape_string($connect, $_POST['sponsor_status']);
			$sponsor_role = mysqli_real_escape_string($connect, $_POST['sponsor_role']);
			$secondary1_sponsor_contact_person = mysqli_real_escape_string($connect, $_POST['secondary1_sponsor_contact_person']);
			$secondary1_sponsor_contact_number = mysqli_real_escape_string($connect, $_POST['secondary1_sponsor_contact_number']);
			$secondary1_sponsor_contact_email_address = mysqli_real_escape_string($connect, $_POST['secondary1_sponsor_contact_email_address']);
			$secondary1_sponsor_role = mysqli_real_escape_string($connect, $_POST['secondary1_sponsor_role']);

			$sponsor_bio = mysqli_real_escape_string($connect, $_POST['sponsor_bio']);
			$facebook_url = mysqli_real_escape_string($connect, $_POST['facebook_url']);
			$twitter_url = mysqli_real_escape_string($connect, $_POST['twitter_url']);
			$linkedin_url = mysqli_real_escape_string($connect, $_POST['linkedin_url']);
			$instagram_url = mysqli_real_escape_string($connect, $_POST['instagram_url']);
			$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
			$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
			$city = mysqli_real_escape_string($connect, $_POST['city']);
			$state = mysqli_real_escape_string($connect, $_POST['state']);
			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$uid = mysqli_real_escape_string($connect, $_POST['uid']);
			$updated_doc_names = mysqli_real_escape_string($connect, $_POST['updated_doc_names']);

			
			if($facebook_url=="https://www.facebook.com/") $facebook_url = "";
			if($twitter_url=="https://www.twitter.com/") $twitter_url = "";
			if($linkedin_url=="https://www.linkedin.com/") $linkedin_url = "";
			if($instagram_url=="https://www.instagram.com/") $instagram_url = "";
			
			$final_docs_name = '';
			$company_url = mysqli_real_escape_string($connect, $_POST['company_url']);
			$country = mysqli_real_escape_string($connect, $_POST['country']);
			$zip_code = mysqli_real_escape_string($connect, $_POST['zip_code']);
			$social_media_reach = mysqli_real_escape_string($connect, $_POST['social_media_reach']);
			$email_reach = mysqli_real_escape_string($connect, $_POST['email_reach']);
			$other_contact_name = mysqli_real_escape_string($connect, $_POST['other_contact_name']);
			$other_contact_number = mysqli_real_escape_string($connect, $_POST['other_contact_number']);
			$other_contact_email_address = mysqli_real_escape_string($connect, $_POST['other_contact_email_address']);
			$other_role = mysqli_real_escape_string($connect, $_POST['other_role']);
			$potential_funding_ask = mysqli_real_escape_string($connect, $_POST['potential_funding_ask']);
			$committed_funding = mysqli_real_escape_string($connect, $_POST['committed_funding']);
			 if($_POST['estimated_time_to_close'] == ' ' || $_POST['estimated_time_to_close'] == '')
		        { 
		          $estimated_time_to_close = '';
		        }else
		        { 
		           $estimated_time_to_close = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['estimated_time_to_close'])));
		        }
		         if($_POST['date_to_close'] == ' ' || $_POST['date_to_close'] == '')
		        { 
		          $date_to_close = '';
		        }else
		        { 
		           $date_to_close =date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['date_to_close'])));
		        }

		$sql = "UPDATE `all_sponsors` SET `sponsor_company_name`='".$sponsor_company_name."', `sponsor_type`='".$sponsor_type."', `sponsor_contact_person`='".$sponsor_contact_person."', `sponsor_contact_number`='".$sponsor_contact_number."', `sponsor_contact_email_address` = '".$sponsor_contact_email_address."', `sponsor_role`='".$sponsor_role."', `secondary1_sponsor_contact_person`='".$secondary1_sponsor_contact_person."', `secondary1_sponsor_contact_number`='".$secondary1_sponsor_contact_number."', `secondary1_sponsor_contact_email_address` = '".$secondary1_sponsor_contact_email_address."', `secondary1_sponsor_role`='".$secondary1_sponsor_role."', `sponsor_bio` = '".$sponsor_bio."', `facebook_url` = '".$facebook_url."', `twitter_url` ='".$twitter_url."', `linkedin_url` ='".$linkedin_url."', `instagram_url` ='".$instagram_url."', `address1`='".$address1."', `address2`='".$address2."', `city`='".$city."', `state`='".$state."', `other_documents`='".$final_docs_name."',status='".$sponsor_status."',`company_url`='".$company_url."',`country`='".$country."',`zipcode`='".$zip_code."',`total_social_media_reach`='".$social_media_reach."',`total_email_reach`='".$email_reach."',`other_contact_name`='".$other_contact_name."',`other_contact_number`='".$other_contact_number."',`other_email_address`='".$other_contact_email_address."',`other_role`='".$other_role."',`potential_funding_ask`='".$potential_funding_ask."',`committed_funding`='".$committed_funding."',`estimated_time_to_close`='".$estimated_time_to_close."',`close_date`='".$date_to_close."' WHERE id=".$id;
			mysqli_query($connect, $sql);
			//mysqli_query($connect, "INSERT INTO all_logs(operation,created_by,sql_qry) VALUES ('updated new sponsor','".$id_user."',\"".$sql."\")");

			$tenant_id = $common->get_tenant_id_from_eventid($event_id);

			$all_speakers_array = calculate_sponsor_dashboard_count($event_id);
			$status_update = $common->calculate_sponsor_status_count($event_id);
			$type_update = $common->calculate_sponsor_type_count($event_id);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$tenant_id."','".$event_id."','update sponsor','".$id."','".$id_user."',now(),\"".$sql."\")");


			header('Location:../all-sponsors.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&updated_success');

		break;
		
	case "create_user":

			$name = mysqli_real_escape_string($connect, $_POST['person_name']);
			$email = mysqli_real_escape_string($connect, $_POST['email']);
			//$gender = mysqli_real_escape_string($connect, $_POST['gender']);
			$phone_number = mysqli_real_escape_string($connect, $_POST['phone_number']);
			$birth_day = mysqli_real_escape_string($connect, $_POST['birth_day']);
			$roleid = mysqli_real_escape_string($connect, $_POST['role']);
			$organization_name = mysqli_real_escape_string($connect, $_POST['organization_name']);
			$passowrd_origin = mysqli_real_escape_string($connect, $_POST['password']);
			$event_arr = implode(',',$_POST['event_arr']);
			
			$roleidquery = mysqli_query($connect,"SELECT Rolename FROM all_role WHERE roleid=".$roleid);
            while($rowres = mysqli_fetch_array($roleidquery)){
                $Rolename = $rowres['Rolename'];
            }

			$enc_pwd = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 11]);
			$d=strtotime("now");
			$updated_date = date("Y-m-d h:i:s", $d);
			
			 
			if (!isset($_FILES['image']['tmp_name'])) {
				$profile_pic = "";
			}
			else{
				$file=$_FILES['image']['tmp_name'];
				if($file){
					$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
					$image_name= addslashes($_FILES['image']['name']);
					$extension = pathinfo($image_name, PATHINFO_EXTENSION);
					$profileImage = time().".".$extension;
					$profile_pic = $profileImage;	
					move_uploaded_file($_FILES["image"]["tmp_name"],"../images/user_images/" . $profileImage);
				}
			}
			
			$content = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000000">
			<div style="width:680px">
			  <p style="margin-top:0px;margin-bottom:15">Dear '.$name.', <br></p>
			  <p style="margin-top:0px;margin-bottom:15px">Welcome to Speaker Engage!</p>
			  <p style="margin-top:0px;margin-bottom:15px">You can login to our website using your email address and password by visiting this URL:</p>
			  <p style="margin-top:0px;margin-bottom:15px"><a href="'.$site_url.'" target="_blank" >'.$site_url.'</a></p>
			  <p style="margin-top:0px;margin-bottom:15px">User Name: '.$email.'</p>
			  <p style="margin-top:0px;margin-bottom:15px">Password: '.$passowrd_origin.'</p>
			  <p style="margin-top:0px;margin-bottom:15px"><br><br>Thanks,<br>
			Speaker Engage Team</p>
			</div>
			</div>';
			
			$common->sendEmail($email, $user_email, "Account Created - Speaker Engage", $content);
			
			mysqli_query($connect, "INSERT INTO  all_users( first_name,	phone_number, email, confirmcode, organization_name, password, role,roleid, profile_pic, event_id) VALUES ( '".$name."', '".$phone_number."', '".$email."', 'y', '".$organization_name."', '".$enc_pwd."', '".$Rolename."', '".$roleid."', '".$profile_pic."', '".$event_arr."')");   
			header('Location:../all-users.php?created-success');
		
		break;

		case "create_user_new":

			$name = mysqli_real_escape_string($connect, $_POST['person_name']);
			$email = mysqli_real_escape_string($connect, $_POST['email']);
			// $country_code = mysqli_real_escape_string($connect, $_POST['ccode']);
			// $middle_number = mysqli_real_escape_string($connect, $_POST['pmiddleno']);
			$phone_number = mysqli_real_escape_string($connect, $_POST['plastno']);
			$roleid = mysqli_real_escape_string($connect, $_POST['role']);
			$organization_name = mysqli_real_escape_string($connect, $_POST['organization_name']);
			//$passowrd_origin = mysqli_real_escape_string($connect, $_POST['myPassword']);
			$passowrd_origin = mysqli_real_escape_string($connect, $_POST['password']);
			$linkedin_url = mysqli_real_escape_string($connect, $_POST['linkedinurl']);
			$event_arr = implode(',',$_POST['event_arr']);

			$fetch_site_details = mysqli_query($connect,"SELECT * FROM site_details WHERE id = '2'");
			$res_site_url = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_url['value'];

			//$phone_number='+'.$country_code.' '.$middle_number.' '.$last_number;
			
			$roleidquery = mysqli_query($connect,"SELECT Rolename FROM all_role WHERE roleid=".$roleid);
            while($rowres = mysqli_fetch_array($roleidquery)){
                $Rolename = $rowres['Rolename'];
            }

			$enc_pwd = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 11]);
			$d=strtotime("now");
			$updated_date = date("Y-m-d h:i:s", $d);

			$directoryName="../images/user_images/";
			$profile_pic = '';
			if($_POST['image_src']) {

			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
			$profile_pic=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$profile_pic , base64_decode($file));

			} 
			/*
			$content = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000000">
			<div style="width:680px">
			  <p style="margin-top:0px;margin-bottom:15">Dear '.$name.', <br></p>
			  <p style="margin-top:0px;margin-bottom:15px">Welcome to Speaker Engage!</p>
			  <p style="margin-top:0px;margin-bottom:15px">You can login to our website using your email address and password by visiting this URL:</p>
			  <p style="margin-top:0px;margin-bottom:15px"><a href="'.$site_url.'" target="_blank" >'.$site_url.'</a></p>
			  <p style="margin-top:0px;margin-bottom:15px">User Name: '.$email.'</p>
			  <p style="margin-top:0px;margin-bottom:15px">Password: '.$passowrd_origin.'</p>
			  <p style="margin-top:0px;margin-bottom:15px"><br><br>Thanks,<br>
			Speaker Engage Team</p>
			</div>
			</div>';*/

			$content = '<table bgcolor="#F1F1F1" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table valign="center" cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
                    <tr valign="center">
                        <td valign="center" style="padding-top: 25px;padding-bottom: 20px;"><img src="'.$site_url.'/images/main-logo.png" width="150" alt="Speaker Engage" /></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" style="padding-top:40px; padding-bottom:40px;">

                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" width="600" align="center" border="0">
                                            <tr>
                                                <td>

                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 20px;font-size: 18px;">Dear '.$name.',</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 0px;font-size: 18px;">Welcome to Speaker Engage!</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">You can login to our website using your email address and password by visiting this URL: <a href="'.$site_url.'" target="_blank" >'.$site_url.'</a></p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">User Name: '.$email.'

																</p>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">Password: '.$passowrd_origin.'
																</p>
                                                            </td>
                                                        </tr>



                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">Happy Organizing!

																</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">The Speaker Engage Team

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="height: 20px;"></td>
                                                        </tr>

                                                    </table>
                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="#e2e2e2">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin: 0;"><small style="color: #8a8888;font-size: 12px;">Powered by <a href="https://www.speakerengage.com/" style="color: #8a8888;font-size: 12px;text-decoration: none;"> SpeakerEngage.com</a></small></p>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';
			
			$common->sendEmail($email, $user_email, "Account Created - Speaker Engage", $content);
			
			mysqli_query($connect, "INSERT INTO  all_users( first_name,	phone_number, email, confirmcode, organization_name, password, role,roleid, profile_pic, event_id,linkedin_url,countrycode,phone_middle_no,phone_last_no,is_logged_in) VALUES ( '".$name."', '".$phone_number."', '".$email."', 'y', '".$organization_name."', '".$enc_pwd."', '".$Rolename."', '".$roleid."', '".$profile_pic."', '".$event_arr."','".$linkedin_url."','".$country_code."','".$middle_number."','".$last_number."','1')");   
			header('Location:../all-users.php?created-success');
		
		break;
		
		case "edit_user":

		$name = mysqli_real_escape_string($connect, $_POST['person_name']);
		$email = mysqli_real_escape_string($connect, $_POST['email']);
		//$gender = mysqli_real_escape_string($connect, $_POST['gender']);
		$phone_number = mysqli_real_escape_string($connect, $_POST['phone_number']);
		$birth_day = mysqli_real_escape_string($connect, $_POST['birth_day']);
		$roleid = mysqli_real_escape_string($connect, $_POST['role']);
		$organization_name = mysqli_real_escape_string($connect, $_POST['organization_name']);
		$id = mysqli_real_escape_string($connect, $_POST['id']);
		$event_arr = implode(',',$_POST['event_arr']);

		$roleidquery = mysqli_query($connect,"SELECT Rolename FROM all_role WHERE roleid=".$roleid);
        while($rowres = mysqli_fetch_array($roleidquery)){
            $Rolename = $rowres['Rolename'];
        }

		
		$password = mysqli_real_escape_string($connect, $_POST['password']);
		$password1 = mysqli_real_escape_string($connect, $_POST['password1']);
		if($password1 !== $password && !empty($password)){
			$enc_pwd = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 11]);
			mysqli_query($connect, "UPDATE all_users  SET password='".$enc_pwd."' WHERE user_id=".$id);
		}
		$d=strtotime("now");
		$updated_date = date("Y-m-d h:i:s", $d);
		
		 
		if (!isset($_FILES['image']['tmp_name'])) {
			$profile_pic = "";
		}
		else{
			$file=$_FILES['image']['tmp_name'];
			if($file){
				$image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
				$image_name= addslashes($_FILES['image']['name']);
				$extension = pathinfo($image_name, PATHINFO_EXTENSION);
				$profileImage = time().".".$extension;
				$profile_pic = $profileImage;	
				move_uploaded_file($_FILES["image"]["tmp_name"],"../images/user_images/" . $profileImage);
				mysqli_query($connect, "UPDATE all_users  SET  profile_pic='".$profile_pic."' WHERE user_id=".$id);
			}
			
		
		}
		
		
		$content = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000000">
			<div style="width:680px">
			  <p style="margin-top:0px;margin-bottom:15">Dear '.$name.', <br></p>
			  <p style="margin-top:0px;margin-bottom:15px">Your profile got updated!</p>
			  <p style="margin-top:0px;margin-bottom:15px">You can login to our website using your email address and updated password by visiting this URL:</p>
			  <p style="margin-top:0px;margin-bottom:15px"><a href="'.$site_url.'" target="_blank" >'.$site_url.'</a></p>
			  <p style="margin-top:0px;margin-bottom:15px"><br><br>Thanks,<br>
			Speaker Engage Team</p>
			</div>
			</div>';
		$common->sendEmail($email, $user_email, "Profile Updated - Speaker Engage", $content);
			
		mysqli_query($connect, "UPDATE all_users  SET first_name='".$name."',first_name='".$name."', phone_number='".$phone_number."',email='".$email."',confirmcode='y',organization_name='".$organization_name."', event_id='".$event_arr."', role='".$Rolename."',roleid='".$roleid."' WHERE user_id=".$id);     
				header('Location:../all-users.php?id='.base64_encode($id).'&updated-success');
			break;


		case "edit_user_new":

			$name = mysqli_real_escape_string($connect, $_POST['person_name']);
			$email = mysqli_real_escape_string($connect, $_POST['email']);
			// $country_code = mysqli_real_escape_string($connect, $_POST['ccode']);
			// $middle_number = mysqli_real_escape_string($connect, $_POST['pmiddleno']);
			$phone_number = mysqli_real_escape_string($connect, $_POST['plastno']);
			$roleid = mysqli_real_escape_string($connect, $_POST['role']);
			$passowrd_origin = mysqli_real_escape_string($connect, $_POST['myPassword']);
			$linkedin_url = mysqli_real_escape_string($connect, $_POST['linkedinurl']);
			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$event_arr = implode(',',$_POST['event_arr']);
			$organization_name = mysqli_real_escape_string($connect, $_POST['organization_name']);
            $manage_notification = mysqli_real_escape_string($connect, implode(",",$_POST['manage_notification']));
            $logged_in_user= $_SESSION['user_id'];
			$session_tanent_id=  $common->get_tenant_id_from_userid($logged_in_user);

			//fetch_loggedin user roleid
			$loggedin_details = mysqli_query($connect,"SELECT * FROM all_users WHERE user_id=".$logged_in_user);
			$res_log_user = mysqli_fetch_array($loggedin_details);
			$loggedin_user_roleid = $res_log_user['roleid'];


            // $phone_number='+'.$country_code.' '.$middle_number.' '.$last_number;
			
			$roleidquery = mysqli_query($connect,"SELECT Rolename FROM all_role WHERE roleid=".$roleid);
            while($rowres = mysqli_fetch_array($roleidquery)){
                $Rolename = $rowres['Rolename'];
            }

			$password = mysqli_real_escape_string($connect, $_POST['password']);
			$password1 = mysqli_real_escape_string($connect, $_POST['password1']);
			if($password1 !== $password && !empty($password)){
				$enc_pwd = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 11]);
				mysqli_query($connect, "UPDATE all_users  SET password='".$enc_pwd."' WHERE user_id=".$id);
			}

			$d=strtotime("now");
			$updated_date = date("Y-m-d h:i:s", $d);

			$directoryName="../images/user_images/";
			$profile_pic = '';
			if($_POST['image_src']) {

			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
			$profile_pic=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$profile_pic , base64_decode($file));
			mysqli_query($connect, "UPDATE all_users  SET  profile_pic='".$profile_pic."' WHERE user_id=".$id);
			} 
		
		
		$content = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000000">
			<div style="width:680px">
			  <p style="margin-top:0px;margin-bottom:15">Dear '.$name.', <br></p>
			  <p style="margin-top:0px;margin-bottom:15px">Your profile got updated!</p>
			  <p style="margin-top:0px;margin-bottom:15px">You can login to our website using your email address and updated password by visiting this URL:</p>
			  <p style="margin-top:0px;margin-bottom:15px"><a href="'.$site_url.'" target="_blank" >'.$site_url.'</a></p>
			  <p style="margin-top:0px;margin-bottom:15px"><br><br>Thanks,<br>
			Speaker Engage Team</p>
			</div>
			</div>';
			$common->sendEmail($email, $user_email, "Profile Updated - Speaker Engage", $content);
			
			$update_qry= "UPDATE all_users  SET first_name='".$name."',email_notification='".$manage_notification."', phone_number='".$phone_number."',email='".$email."',confirmcode='y',organization_name='".$organization_name."', event_id='".$event_arr."', role='".$Rolename."',roleid='".$roleid."',linkedin_url='".$linkedin_url."',countrycode='".$country_code."',phone_middle_no='".$middle_number."',phone_last_no='".$last_number."' WHERE user_id=".$id;
			mysqli_query($connect,$update_qry);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','0','Edit user','".$id."','".$logged_in_user."',now(),\"".$update_qry."\")");
				if($loggedin_user_roleid == '1'){
					header('Location:../admin-user-management.php?id='.base64_encode($id).'&updated-success');
				}else{
					header('Location:../edit-user-management.php?id='.base64_encode($logged_in_user).'&updated-success' );
				}

				
			break;

		case "create_tenant":

			$tanent_name = mysqli_real_escape_string($connect, $_POST['tanent_name']);
			$tanent_url_structure = mysqli_real_escape_string($connect, $_POST['tanent_url_structure']);
			$tanent_email = mysqli_real_escape_string($connect, $_POST['tanent_email']);
			$tanent_password = mysqli_real_escape_string($connect, $_POST['tanent_password']);

			$tenant_logo_txt = mysqli_real_escape_string($connect, $_POST['tenant_logo']);
			
			$enc_pwd = password_hash($_POST["tanent_password"], PASSWORD_DEFAULT, ['cost' => 11]);			
			$privileges_select = mysqli_real_escape_string($connect, implode(",", $_POST['privileges_select'])); 

			$d=strtotime("now");
			$created_on = date("Y-m-d h:i:s", $d);	

			$data = $tenant_logo_txt;
				if($data){
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$data = base64_decode($data);
					$heading = preg_replace('/[^A-Za-z0-9\-]/', '', "tenant");
					$rand = rand().$i;
					$allFileNames .= $logo_pic = $heading.'_'.$rand.'.jpg';
					file_put_contents('../images/tanent_logos/'.$logo_pic, $data);
				}else{
					$logo_pic = '';
				}			
			
			$insert_tenant  = mysqli_query($connect, "INSERT INTO  all_tanents(name, url_structure, logo,email,password, registered_date,privilege) VALUES ('".$tanent_name."', '".$tanent_url_structure."', '".$logo_pic."', '".$tanent_email."', '".$enc_pwd."', '".$created_on."', '".$privileges_select."' )");  

			if($insert_tenant){
				$tanent_id = mysqli_insert_id($connect); //last_inserted_id

				$insert_user  = mysqli_query($connect, "INSERT INTO  all_users (tanent_id, email, first_name,password,confirmcode,registered_date, role, privilege) VALUES (".$tanent_id.", '".$tanent_email."', '".$tanent_name."',  '".$enc_pwd."', 'y','".$created_on."','tanent_admin','".$privileges_select."' )");
			} 
			
			header('Location:../all-tenants.php?created-success');		
		break;

		case "edit_tenant":

			$tanent_name = mysqli_real_escape_string($connect, $_POST['tanent_name']);
			$tanent_url_structure = mysqli_real_escape_string($connect, $_POST['tanent_url_structure']);
			$tanent_email = mysqli_real_escape_string($connect, $_POST['tanent_email']);
			//$tanent_password = mysqli_real_escape_string($connect, $_POST['tanent_password']);
			$privileges_select = mysqli_real_escape_string($connect, implode(",", $_POST['privileges_select'])); 

			$tenant_logo_txt =  trim($_POST['tenant_logo']);


			$tenant_id = mysqli_real_escape_string($connect, $_POST['tenant_id']);
			$password_sql = "";	
			if(!empty($_POST["tanent_password"])){

				$enc_pwd = password_hash($_POST["tanent_password"], PASSWORD_DEFAULT, ['cost' => 11]);
				$password_sql = ",password = '$enc_pwd'";
			}else{
				$password_sql = "";
			}

						
			

			$d=strtotime("now");
			$created_on = date("Y-m-d h:i:s", $d);	
			$logo_sql = "";

			$data = $tenant_logo_txt;
			$tenant_img = mysqli_real_escape_string($connect, $_POST['tenant_img']);

			//var_dump($tenant_img); exit();

			if(empty($tenant_img))
			{
				mysqli_query($connect, "UPDATE `all_tanents` SET `logo`='' WHERE id=".$tenant_id);
			}
				if(strpos($data,":image/png")!== false){
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$data = base64_decode($data);
					$heading = preg_replace('/[^A-Za-z0-9\-]/', '', "tenant");
					$rand = rand().$i;
					$allFileNames .= $file_name = $heading.'_'.$rand.'.jpg';
					file_put_contents('../images/tanent_logos/'.$file_name, $data);
					mysqli_query($connect, "UPDATE `all_tanents` SET `logo`='".$file_name."' WHERE id=".$tenant_id);
					
				}				

				$tenant_update_qry = "UPDATE all_tanents SET name = '$tanent_name',url_structure = '$tanent_url_structure',email = '$tanent_email', privilege = '$privileges_select' ".$password_sql." WHERE id = '$tenant_id' ";	 
				$update_tenant  = mysqli_query($connect, $tenant_update_qry);

			if($update_tenant){
				$tanent_id = mysqli_insert_id($connect); 

				$update_user_qry = "UPDATE all_users SET email = '$tanent_email', first_name = '$tanent_name', privilege = '$privileges_select' ".$password_sql." WHERE tanent_id = '$tenant_id'";

				mysqli_query($connect, $update_user_qry);

			} 
			
			header('Location:../all-tenants.php?updated-success');		
		break;

		case "update_action_attachment":
			$id = mysqli_real_escape_string($connect, $_POST['action_record_id']);

			//$attachment = $_POST['attachment_'.$id];
			$loggedin_user_id = $_SESSION['user_id'];

			if (!isset($_FILES['attachment_'.$id]['tmp_name'])) {
				$attachment_name = "";
			}
			else{
				$file=$_FILES['attachment_'.$id]['tmp_name'];
				if($file){
					$image= addslashes(file_get_contents($_FILES['attachment_'.$id]['tmp_name']));
					$image_name= addslashes($_FILES['attachment_'.$id]['name']);
					$extension = pathinfo($image_name, PATHINFO_EXTENSION);
					$profileImage = time().".".$extension;
					$attachment_name = $profileImage;	
					move_uploaded_file($_FILES['attachment_'.$id]["tmp_name"],"../images/action_tracker_uploads/" . $profileImage);
				}			
			}
			$update_action  = mysqli_query($connect, "UPDATE action_trackers SET `attachment`= '$attachment_name' WHERE id='$id' "); 
			if($update_action){
				header('Location:../action-trackers.php?updated-success');	
			}
		break;

		case "update_resource_attachment":
			$id = mysqli_real_escape_string($connect, $_POST['action_record_id']);

			//$attachment = $_POST['attachment_'.$id];
			$loggedin_user_id = $_SESSION['user_id'];

			if (!isset($_FILES['attachment_'.$id]['tmp_name'])) {
				$attachment_name = "";
			}
			else{
				$file=$_FILES['attachment_'.$id]['tmp_name'];
				if($file){
					$image= addslashes(file_get_contents($_FILES['attachment_'.$id]['tmp_name']));
					$image_name= addslashes($_FILES['attachment_'.$id]['name']);
					$extension = pathinfo($image_name, PATHINFO_EXTENSION);
					$profileImage = time().".".$extension;
					$attachment_name = $profileImage;	
					move_uploaded_file($_FILES['attachment_'.$id]["tmp_name"],"../images/resource_tracker_uploads/" . $profileImage);
				}			
			}
			$update_action  = mysqli_query($connect, "UPDATE resource_trackers SET `attachment`= '$attachment_name' WHERE id='$id' "); 
			if($update_action){
				header('Location:../resource-tracker.php?updated-success');	
			}
		break;


		case "assistance_form_submit":
			$asstance_topic = mysqli_real_escape_string($connect, $_POST['asstance_topic']);
			$assistance_description = mysqli_real_escape_string($connect, $_POST['assistance_description']);
			$event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$loggedin_user_id = $_SESSION['user_id'];
			// $user_data = $common->get_user_details_by_id($loggedin_user_id);
			// $user_name = $user_data['first_name'];
			$loggedin_user_data = mysqli_query($connect,"SELECT first_name,email FROM all_users WHERE user_id = '$loggedin_user_id' ");
		   	$res_loggedin_user = mysqli_fetch_array($loggedin_user_data);
		   	$loggedin_user_name = $res_loggedin_user['first_name'];
		   	$loggedin_user_email = $res_loggedin_user['email'];

		   	$insert_qry="INSERT INTO  assistance_trackers(category, assistance_query, created_by) VALUES ('".$asstance_topic."', '".$assistance_description."', '".$loggedin_user_id."')";

			$insert_assistance  = mysqli_query($connect,$insert_qry);  
			$inserted_last_id = mysqli_insert_id($connect);
			if($insert_assistance){
				$from_email=$loggedin_user_email;
				$email_text = "Hi Team,<br><br>
								We have received an assistance enquiry from ".$loggedin_user_email.". Below are the details:<br><br><b>Assistance required for: </b>".$asstance_topic." <br><br> <b>Detailed Message: </b> ".$assistance_description." ";

				
				$email = $common->sendEmail('support@speakerengage.com', $from_email, 'Speaker Engage Assistance Enquiry',$email_text,$loggedin_user_name);

				//$email2 = $common->sendEmail('chai@meylah.com', $from_email, 'Speaker Engage Assistance Enquiry',$email_text,$loggedin_user_name);

				mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Assistance Form Enquiry','".$inserted_last_id."','".$loggedin_user_id."',now(),\"".$insert_qry."\")");

				header('Location:../assistance-form.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&created-success');	
			}
		break;

		case "create_action_tracker":

			$event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);

			$action_name = mysqli_real_escape_string($connect, $_POST['action_name']);			
			$action_type = mysqli_real_escape_string($connect, $_POST['action_type']);			 
			$new_status = mysqli_real_escape_string($connect, $_POST['new_status']);			
			$assign_to = mysqli_real_escape_string($connect, $_POST['assign_to']);
			$loggedin_user_id = $_SESSION['user_id'];
			$uid = mysqli_real_escape_string($connect, $_POST['uid']);

			if($_POST['deadline'] == ' ' || $_POST['deadline'] == '')
		    { 
		       $deadline = '';
		    }else
		    { 
		      $deadline = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['deadline'])));
		    }

			$is_file_available = 0;	
			
			$insert_qry="INSERT INTO action_trackers(tenant_id,action,action_category,status,deadline,assign_to,created_by,event_id,is_file_available) VALUES ('$session_tanent_id','$action_name','$action_type','$new_status','$deadline','$assign_to','$loggedin_user_id','$event_id','$is_file_available')";

			$insert_action = mysqli_query($connect,$insert_qry);

		    $inserted_action_id = mysqli_insert_id($connect);
			if($insert_action){
					$fetch_uploaded_files = mysqli_query($connect, "SELECT * FROM `dropzone` WHERE `uid` = '".$uid."' " );
					$count_files = mysqli_num_rows($fetch_uploaded_files);
					if($count_files > 0){
						$file_names = array();
						$is_file_available = 1;
						while($res = mysqli_fetch_array($fetch_uploaded_files)){
							$file_names[] = $res['filename'];
							// insert into all_uploaded_files
							$insert_attachment =  mysqli_query($connect, "INSERT INTO `all_uploaded_files` (`action_id`,`file_name`,`uploaded_by`,`tenant_id`,`event_id`) VALUES ('".$inserted_action_id."','".$res['filename']."', '".$loggedin_user_id."', '".$session_tanent_id."', '".$event_id."')");
						}
					}

					$update_action = mysqli_query($connect,"UPDATE action_trackers SET `is_file_available` = '".$is_file_available."' WHERE `id` = '".$inserted_action_id."' ");

				mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','create action trackers','".$inserted_action_id."','".$loggedin_user_id."',now(),\"".$insert_qry."\")");

				header('Location:../action-trackers.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
			}		

		break;

		case "edit_action":

			$event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);

			$action_name = mysqli_real_escape_string($connect, $_POST['action_name']);			
			$action_type = mysqli_real_escape_string($connect, $_POST['action_type']);			 
			$new_status = mysqli_real_escape_string($connect, $_POST['new_status']);
			$assign_to = mysqli_real_escape_string($connect, $_POST['assign_to']);
			$loggedin_user_id = $_SESSION['user_id'];
			$uid = mysqli_real_escape_string($connect, $_POST['uid']);
			$action_id = mysqli_real_escape_string($connect, $_POST['id']);
			if($_POST['deadline'] == ' ' || $_POST['deadline'] == '')
		    { 
		       $deadline = '';
		    }else
		    { 
		      $deadline = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['deadline'])));
		    }

			$is_file_available = 0;	

			$fetch_uploaded_files = mysqli_query($connect, "SELECT * FROM `dropzone` WHERE `uid` = '".$uid."' " );
					$count_files = mysqli_num_rows($fetch_uploaded_files);
					if($count_files > 0){
						$file_names = array();
						
						while($res = mysqli_fetch_array($fetch_uploaded_files)){
							$file_names[] = $res['filename'];

							// delete previous files
							$delete_older_file = mysqli_query($connect, "DELETE FROM `all_uploaded_files` WHERE `action_id` = '$action_id' ");

							// insert into all_uploaded_files
							$insert_attachment =  mysqli_query($connect, "INSERT INTO `all_uploaded_files` (`action_id`,`file_name`,`uploaded_by`,`tenant_id`,`event_id`) VALUES ('".$action_id."','".$res['filename']."', '".$loggedin_user_id."','".$session_tanent_id."','".$event_id."')");
						}
					}

				$fetch_file_count = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM all_uploaded_files WHERE `action_id` = '$action_id' "));
				if($fetch_file_count > 0){  $is_file_available = 1;	}

			

			$update_action = "UPDATE `action_trackers` SET `action`='$action_name',`action_category`='$action_type',`status`='$new_status',  `deadline`='$deadline',`assign_to`='$assign_to',`is_file_available`='$is_file_available'   WHERE `id` = '$action_id' ";
			mysqli_query($connect,$update_action);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Edit action trackers','".$action_id."','".$loggedin_user_id."',now(),\"".$update_action."\")");

			if($update_action){
				header('Location:../action-trackers.php?updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
			}


		break;

		case "create_resource_tracker":

			$event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);

			$resource_name = mysqli_real_escape_string($connect, $_POST['resource_name']);
			$resource_type = mysqli_real_escape_string($connect, $_POST['resource_type_values']);	
			$resource_url = mysqli_real_escape_string($connect, $_POST['resource_url']);
			$resource_owner = mysqli_real_escape_string($connect, $_POST['resource_owner']);
			
			$loggedin_user_id = $_SESSION['user_id'];
			$uid = mysqli_real_escape_string($connect, $_POST['uid']);		
			$is_file_available = 0;	

			$insertqry="INSERT INTO resource_trackers(tenant_id,resource,resource_category,url,owner,created_by, event_id)VALUES('$session_tanent_id','$resource_name','$resource_type','$resource_url','$resource_owner','$loggedin_user_id','$event_id')";

			$insert_resource = mysqli_query($connect,$insertqry);
			$inserted_resource_id = mysqli_insert_id($connect);
			if($insert_resource){
					$fetch_uploaded_files = mysqli_query($connect, "SELECT * FROM `dropzone` WHERE `uid` = '".$uid."' " );

					$count_files = mysqli_num_rows($fetch_uploaded_files);
					if($count_files > 0){
						$file_names = array();
						$is_file_available = 1;
						while($res = mysqli_fetch_array($fetch_uploaded_files)){
							$file_names[] = $res['filename'];
							// insert into all_uploaded_files
							$insert_attachment =  mysqli_query($connect, "INSERT INTO `all_uploaded_files` (`resource_id`,`file_name`,`uploaded_by`,`tenant_id`,`event_id`) VALUES ('".$inserted_resource_id."','".$res['filename']."', '".$loggedin_user_id."', '".$session_tanent_id."', '".$event_id."')");

							
						}
					}

					$update_action = mysqli_query($connect,"UPDATE resource_trackers SET `is_file_available` = '".$is_file_available."' WHERE `id` = '".$inserted_resource_id."' ");

					mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','create resource tracker','".$inserted_resource_id."','".$loggedin_user_id."',now(),\"".$insertqry."\")");

				header('Location:../resource-tracker.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
			}
		break;

		case "edit_resource_tracker":
			$event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);

			$resource_name = mysqli_real_escape_string($connect, $_POST['resource_name']);
			$resource_type = mysqli_real_escape_string($connect, $_POST['resource_type_values']);	
			$resource_url = mysqli_real_escape_string($connect, $_POST['resource_url']);
			$resource_owner = mysqli_real_escape_string($connect, $_POST['resource_owner']);
			
			$loggedin_user_id = $_SESSION['user_id'];
			$uid = mysqli_real_escape_string($connect, $_POST['uid']);	
			$resource_id = mysqli_real_escape_string($connect, $_POST['id']);

			$is_file_available = 0;	

			$fetch_uploaded_files = mysqli_query($connect, "SELECT * FROM `dropzone` WHERE `uid` = '".$uid."' " );
					$count_files = mysqli_num_rows($fetch_uploaded_files);
					if($count_files > 0){
						$file_names = array();
						
						while($res = mysqli_fetch_array($fetch_uploaded_files)){
							$file_names[] = $res['filename'];

							// delete previous files
							$delete_older_file = mysqli_query($connect, "DELETE FROM `all_uploaded_files` WHERE `resource_id` = '$resource_id' ");

							// insert into all_uploaded_files
							$insert_attachment =  mysqli_query($connect, "INSERT INTO `all_uploaded_files` (`resource_id`,`file_name`,`uploaded_by`,`tenant_id`,`event_id`) VALUES ('".$resource_id."','".$res['filename']."', '".$loggedin_user_id."', '".$session_tanent_id."', '".$event_id."')");
						}
					}

				$fetch_file_count = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM all_uploaded_files WHERE `resource_id` = '$resource_id' "));
				if($fetch_file_count > 0){  $is_file_available = 1;	}


			$updateqry="UPDATE resource_trackers SET `resource`='$resource_name',`resource_category` = '$resource_type', `url`='$resource_url',`owner`='$resource_owner',`is_file_available`='$is_file_available'  WHERE `id` = '$resource_id' ";

			$update_resource = mysqli_query($connect,$updateqry);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Edit resource tracker','".$resource_id."','".$loggedin_user_id."',now(),\"".$updateqry."\")");

			if($update_resource){
				header('Location:../resource-tracker.php?updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
			}
		break;

	case "create_event_new":

			$event_name = mysqli_real_escape_string($connect, $_POST['event_name']);
			$event_start_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['event_start_date']) ));
			$event_end_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['event_end_date']) ));
			$event_location = mysqli_real_escape_string($connect, $_POST['event_location']);
			$country = mysqli_real_escape_string($connect, $_POST['country']);
			$city = mysqli_real_escape_string($connect, $_POST['city']);
			$state = mysqli_real_escape_string($connect, $_POST['state']);
			$zip = mysqli_real_escape_string($connect, $_POST['zip']);
			$eventbrite_url = mysqli_real_escape_string($connect, $_POST['eventbrite_url']);
			$event_description = mysqli_real_escape_string($connect, $_POST['event_description']);
			$acknowledgement = mysqli_real_escape_string($connect, $_POST['acknowledgement']);
			$event_application_url = mysqli_real_escape_string($connect, $_POST['event_application_url']);
			$created_by = mysqli_real_escape_string($connect, $_POST['loggedin_userid']);
			$session_tanent_id=  $common->get_tenant_id_from_userid($created_by);

			$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
			$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
			$thank_you_message = mysqli_real_escape_string($connect, $_POST['thank_you_message']);
			$timezone_selected = mysqli_real_escape_string($connect, $_POST['timezone']);

			$sql11 = "select event_id from all_users where user_id='".$created_by."'";
                 $res=mysqli_query($connect, $sql11);
                 while($row = $res->fetch_assoc()) {
                        $event_id=$row["event_id"];
                    }

			$directoryName="../images/event_images/";
			$event_image = '';
			if($_POST['image_src']) {

			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
			$event_image=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$event_image , base64_decode($file));

			} 

			$banner_image_txt = mysqli_real_escape_string($connect, $_POST['banner_image']);
			$data = $banner_image_txt;
				if($data){
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$data = base64_decode($data);
					$heading = preg_replace('/[^A-Za-z0-9\-]/', '', "event");
					$rand = rand().$i;
					$allFileNames .= $file_name = $heading.'_'.$rand.'.jpg';
					file_put_contents('../images/event_email_banner/'.$file_name, $data);				
					
				}

			$sql_query_log="INSERT INTO `all_events`(`tanent_id`,`event_name`,`event_start_date`, `event_end_date`, `event_location`,`city`,`state`,`zip`,`eventbrite_url`,`description`,`acknowledgement`,`url_structure`,`event_image`,`created_by`,`address1`,`address2`,`event_email_banner`,`country`,`thankyou_message`,`timezone`) VALUES ('".$session_tanent_id."','".$event_name."','".$event_start_date."', '".$event_end_date."', '".$event_location."', '".$city."', '".$state."', '".$zip."', '".$eventbrite_url."', '".$event_description."', '".$acknowledgement."', '".$event_application_url."', '".$event_image."', '".$created_by."', '".$address1."', '".$address2."','".$file_name."','".$country."','".$thank_you_message."','".$timezone_selected."')";
			
			mysqli_query($connect,$sql_query_log);

			$last_insert_id = mysqli_insert_id($connect);
			if($event_id!='')
			{
				$eid=$event_id . "," . $last_insert_id;
			}else
			{
				$eid=$last_insert_id;
			}

			$final_eventid=$eid;

			$update_event_id = mysqli_query($connect,"UPDATE `all_users` SET `event_id` = '".$final_eventid."' WHERE `user_id` = '".$created_by."' ");

			$insert_speaker_dashboard_count = mysqli_query($connect,"INSERT INTO `speaker_dashboard_count` (tanent_id,event_id) 
				VALUES ('".$session_tanent_id."','".$last_insert_id."')");

			$insert_sponsor_type = mysqli_query($connect,"INSERT INTO `all_sponsor_types` (tanent_id,sponsor_type_name,updated_date,default_flag,event_id,available_units,cost_per_unit,total_unit_value,is_edited) 
				select $session_tanent_id,sponsor_type_name, now(), default_flag, $last_insert_id, 0 as available_units, 0 as cost_per_unit,0 as total_unit_value,0 as total_unit_value from all_sponsor_types where default_flag=1 and event_id='all'");

			// insert default speaker types for speakers
			$insert_speaker_type = mysqli_query($connect,"INSERT INTO `all_speaker_types` (tanent_id,speaker_type_name,updated_date,Isdefault,event_id,colour_code) 
				select $session_tanent_id,speaker_type_name, now(), Isdefault, $last_insert_id,colour_code from all_speaker_types where Isdefault=1 and event_id='all'");
			// insert default speaker status for speakers
			$insert_speaker_status = mysqli_query($connect,"INSERT INTO `all_status` (tanent_id,status_name,status_for,last_edited_user_id,updated_date,default_flag,event_id) 
				select $session_tanent_id,status_name,'speaker',$created_by, now(), default_flag, $last_insert_id from all_status where default_flag=1 and event_id='all' and status_for='speaker'");



			//****** master dashboard counts
			$insert_master_dashboard_count = mysqli_query($connect,"INSERT INTO `master_dashboard_counts` (tanent_id,event_id) VALUES ('".$session_tanent_id."','".$last_insert_id."')");

			// insert default master types for masters
			$insert_master_type = mysqli_query($connect,"INSERT INTO `all_master_types` (tanent_id,master_type_name,updated_date,is_default,event_id) 
				select $session_tanent_id,master_type_name, now(), is_default, $last_insert_id from all_master_types where is_default=1 and event_id='all' ");

			// insert default sponsor status for sponsors
			$insert_sponsors_status = mysqli_query($connect,"INSERT INTO `all_status` (tanent_id,status_name,status_for,last_edited_user_id,updated_date,default_flag,event_id) 
				select $session_tanent_id,status_name,'sponsor',$created_by, now(), default_flag, $last_insert_id from all_status where default_flag=1 and event_id='all' and status_for='sponsor' ");

			// insert default social planner status 
			$insert_socialplanner_status = mysqli_query($connect,"INSERT INTO `all_social_media_planner_status` (tanent_id,status_name,updated_date,default_flag,event_id) 
				select $session_tanent_id,status_name, now(), 0, $last_insert_id from all_social_media_planner_status where default_flag=1 and event_id='0'");

			//****** sponsor dashboard counts
			$insert_sponsor_dashboard_count = mysqli_query($connect,"INSERT INTO `sponsor_dashboard_counts` (tanent_id,event_id) VALUES ('".$session_tanent_id."','".$last_insert_id."')");

			$insert_email_count = mysqli_query($connect,"INSERT INTO `all_event_email_count` (tanent_id,event_id) 
				VALUES ('".$session_tanent_id."','".$last_insert_id."')");

			//update all admin with new event_id

			$fetch_all_events = mysqli_query($connect,"SELECT group_concat(id) as all_events_ids FROM all_events where tanent_id = '".$session_tanent_id."'  ");
			if(mysqli_num_rows($fetch_all_events) > 0){
				while($res_tenant = mysqli_fetch_array($fetch_all_events)){
						$all_events_ids = $res_tenant['all_events_ids'];
				}
			}
			$update_users = mysqli_query($connect,"UPDATE all_users SET `event_id` = '".$all_events_ids."' WHERE `roleid`= '1' AND tanent_id = '".$session_tanent_id."' ");


			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$last_insert_id."','Create New Event','".$last_insert_id."','".$created_by."',now(),\"".$sql_query_log."\")");
			
			header('Location:../dashboard-event.php?created-success');

		break; 

		case "edit_event_new":

			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$event_name = mysqli_real_escape_string($connect, $_POST['event_name']);
			$event_start_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['event_start_date']) ));
			$event_end_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['event_end_date'])));
			$event_location = mysqli_real_escape_string($connect, $_POST['event_location']);
			$country = mysqli_real_escape_string($connect, $_POST['country']);
			$city = mysqli_real_escape_string($connect, $_POST['city']);
			$state = mysqli_real_escape_string($connect, $_POST['state']);
			$zip = mysqli_real_escape_string($connect, $_POST['zip']);
			$eventbrite_url = mysqli_real_escape_string($connect, $_POST['eventbrite_url']);
			$event_description = mysqli_real_escape_string($connect, $_POST['event_description']);
			$acknowledgement = mysqli_real_escape_string($connect, $_POST['acknowledgement']);
			$event_application_url = mysqli_real_escape_string($connect, $_POST['event_application_url']);
			$created_by = mysqli_real_escape_string($connect, $_POST['loggedin_userid']);
			$session_tanent_id=  $common->get_tenant_id_from_userid($created_by);

			$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
			$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
			$thank_you_message = mysqli_real_escape_string($connect, $_POST['thank_you_message']);
			$timezone_selected = mysqli_real_escape_string($connect, $_POST['timezone']);


			$block6_menu_file = mysqli_real_escape_string($connect, implode("~",$_POST['block6_menu_file']));
			$firstChar = mb_substr($block6_menu_file, 0, 1, "UTF-8");

			$block6_heading = preg_replace('/[^A-Za-z0-9\-]/', '', "event");
			if($block6_menu_file)
			$block6_menu_files = convertAndSaveImages(explode("~",$block6_menu_file),$block6_heading);
			$file_name=$block6_menu_files;
			$parts = explode(",", $block6_menu_files);
		    $event_image = $parts[0];
		    $email_image = $parts[1];

		    $directoryName="../images/event_images/";
			$event_image = '';
			if($_POST['image_src']) {

			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
			$event_image=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$event_image , base64_decode($file));
			$update_event_image = mysqli_query($connect,"UPDATE `all_events` SET `event_image` = '$event_image' WHERE `id` = '".$id."' ");
			} 

			$banner_image_txt = mysqli_real_escape_string($connect, $_POST['banner_image']);
			$data = $banner_image_txt;
				if($data){
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$data = base64_decode($data);
					$heading = preg_replace('/[^A-Za-z0-9\-]/', '', "event");
					$rand = rand().$i;
					$allFileNames .= $file_name = $heading.'_'.$rand.'.jpg';
					file_put_contents('../images/event_email_banner/'.$file_name, $data);	
					 $update_event_image = mysqli_query($connect,"UPDATE `all_events` SET `event_email_banner` = '$file_name' WHERE `id` = '".$id."' ");			
				}

				$sql_query_log = "UPDATE `all_events` SET `event_name` = '$event_name', `event_start_date`='$event_start_date', `event_end_date`='$event_end_date', `event_location`='$event_location', `city`='$city', `state`='$state', `zip`='$zip', `eventbrite_url`='$eventbrite_url', `description`='$event_description', `acknowledgement`='$acknowledgement', `address1`='$address1', `address2`='$address2',`country`='$country',`thankyou_message`='$thank_you_message',`url_structure`='$event_application_url',`timezone`='$timezone_selected' WHERE `id` = '$id' ";
		
				mysqli_query($connect,"UPDATE `all_events` SET `event_name` = '$event_name', `event_start_date`='$event_start_date', `event_end_date`='$event_end_date', `event_location`='$event_location', `city`='$city', `state`='$state', `zip`='$zip', `eventbrite_url`='$eventbrite_url', `description`='$event_description', `acknowledgement`='$acknowledgement', `address1`='$address1', `address2`='$address2',`country`='$country',`thankyou_message`='$thank_you_message',`url_structure`='$event_application_url',`timezone`='$timezone_selected' WHERE `id` = '$id' ");

				mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$id."','Edit Event','".$id."','".$created_by."',now(),\"".$sql_query_log."\")");
			
			header('Location:../dashboard-event.php?updated-success');

		break;


		case "edit_speaker_status":
			$speaker_type_name = mysqli_real_escape_string($connect, $_POST['speaker_status_name']);
			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			
			$sql = "UPDATE all_status SET status_name='".$speaker_type_name."' WHERE id=".$id;
			mysqli_query($connect, $sql);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','update speaker status','".$id."','".$id_user."',now(),\"".$sql."\")");

			header('Location:../email_status.php?type=speaker&updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

	case "information_form_submit":

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']); 
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$multiselect_all_section =  $_POST['multiselect_all_section'];			
			$schedule_option = mysqli_real_escape_string($connect, $_POST['schedule_option']);
			$info_modal_speakerid = mysqli_real_escape_string($connect, $_POST['info_modal_userid']);
			
			$info_manager_cc = mysqli_real_escape_string($connect, $_POST['info_manager_cc']);

			$info_msg = mysqli_real_escape_string($connect, $_POST['info_msg']);
			$info_msg = str_replace('\n', "\n", $info_msg);
			$info_msg = str_replace('\r', "\r", $info_msg);


			$token = md5(uniqid());
			$loggedin_user_id = $_SESSION['user_id'];			

			$is_headshot = 0;
			$is_bio = 0;
			$is_quote = 0;
			$is_address = 0;
			$is_manager = 0;
			$is_social = 0;
			$is_presentation = 0;
			$is_acknowledgement = 0;
			$is_schedule = 0;
			$schedule_datetime = '';
			$cc_to_manager = 0;



			if (in_array("is_headshot", $multiselect_all_section)){
				$is_headshot = 1;
		    }
			
			if (in_array("is_bio", $multiselect_all_section)){
				$is_bio = 1;
		    }

		    if (in_array("is_quote", $multiselect_all_section)){
				$is_quote = 1;
		    }

		    if (in_array("is_address", $multiselect_all_section)){
				$is_address = 1;
		    }

		    if (in_array("is_manager", $multiselect_all_section)){
				$is_manager = 1;
		    }

		    if (in_array("is_social", $multiselect_all_section)){
				$is_social = 1;
		    }

		    if (in_array("is_presentation", $multiselect_all_section)){
				$is_presentation = 1;
		    }

		    if (in_array("is_acknowledgement", $multiselect_all_section)){
				$is_acknowledgement = 1;
		    }
		    if($info_manager_cc == 'yes'){
		    	$cc_to_manager = 1;
		    }

		    if($schedule_option == 'send_later'){		
		    $is_schedule = 1;    	
		    	  
		    	//$schedule_datetime = mysqli_real_escape_string($connect, $_POST['schedule_datetime']);

		    	 $schedule_datetime = date("Y-m-d H:i",strtotime(mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));
		    }

		    //var_dump($schedule_datetime); exit();

		    $loggedin_userid = $_SESSION['user_id'];
		    // fetch loggedin user details
		    $user_details = $common->get_user_details_by_id($loggedin_userid); 
		     $loggedin_user_name = $user_details[0]['first_name'];

		     //loggedin_user_email 
		     $from_email = $user_details[0]['email']; 


		    // fetch_speaker details
		    $fetch_speaker_details = mysqli_query($connect,"SELECT * FROM `all_speakers` WHERE `id` = '$info_modal_speakerid' ");
			if(mysqli_num_rows($fetch_speaker_details) > 0){
				$res_sp = mysqli_fetch_array($fetch_speaker_details);
				$speaker_email = $res_sp['email_id'];
				$speaker_name = $res_sp['speaker_name'];
				$speaker_manager_email = $res_sp['speaker_manager_email'];
				$sp_event_id = $res_sp['event_id'];
			}

			$fetch_event_data = mysqli_query($connect, "SELECT * FROM `all_events` WHERE `id` = '$sp_event_id' ");
			if(mysqli_num_rows($fetch_event_data) > 0){
				$res_event = mysqli_fetch_array($fetch_event_data);
				$event_email_banner = $res_event['event_email_banner'];
			}

			$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
			$res_site_details = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_details['value'];

			//var_dump($res_site_details); exit();

			if($event_email_banner != null || $event_email_banner != '' ){

				$email_banner = $site_url.'/images/event_email_banner/'.$event_email_banner;
			}else{
				$email_banner = $site_url.'/images/NoPath.jpg';
			}


		    $insert_request = mysqli_query($connect, "INSERT INTO information_collect(headshot,bio,quote,address,speaker_manager,social_media,presentation_title,acknowledgement,sent_to_speaker_id,cc_to_manager,is_schedule,schedule_at,message,token) VALUES ('".$is_headshot."','".$is_bio."','".$is_quote."','".$is_address."','".$is_manager."','".$is_social."','".$is_presentation."','".$is_acknowledgement."','".$info_modal_speakerid."','".$cc_to_manager."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."') ");			

		    $sql =  "INSERT INTO information_collect(headshot,bio,quote,address,speaker_manager,social_media,presentation_title,acknowledgement,sent_to_speaker_id,cc_to_manager,is_schedule,schedule_at,message,token) VALUES ('".$is_headshot."','".$is_bio."','".$is_quote."','".$is_address."','".$is_manager."','".$is_social."','".$is_presentation."','".$is_acknowledgement."','".$info_modal_speakerid."','".$cc_to_manager."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."')";

		  if($schedule_option != 'send_later'){
		   mysqli_query($connect, "INSERT INTO all_logs(tanent_id,operation,table_name,created_by,sql_qry,table_id,event_id) VALUES ('".$session_tanent_id."','request missing information','information_collect','".$loggedin_user_id."',\"".$sql."\",'".$info_modal_speakerid."','".$event_id."')"); 
		     $last_insert_id = mysqli_insert_id($connect);
		 }


		    $dynamic_link = $site_url."/collect-profile-info.php?tk=".$token;

		    $email_body = '<table cellspacing="0" cellpadding="0" width="500" align="center" style="border: 1px solid #f1f1f1;">
					<tr>
						<td>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
								<tr>
									<td><img src="https://www.speakerengage.com/images/main-logo.png" width="100" alt="Speaker Engage" /></td>
								</tr>
							</table>
							<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><img src="'.$email_banner.'" width="500" alt="Speaker Engage" /></td>
								</tr>
							</table>

							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin-bottom: 0;margin-top: 10px;font-size: 14px;">Hi <span style="font-weight: 600;">'.$speaker_name.'</span>,</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;">'.$info_msg.'</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;padding-bottom:5px;">Simply click on the button to take action:</p></td>
								</tr>

								
							</table>
							<table cellpadding="5" cellspacing="0" width="150px" bgcolor="" style="margin-left: 5px;cursor:pointer;">
								<tr>
									<td align="center" width="150" height="40" bgcolor="#007DB7" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;cursor:pointer;">
								            <a href="'.$dynamic_link.'" style="color: #ffffff; font-size:16px; font-weight: bold; font-family:sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">
								                Take Action
								            </a>
								        </td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><h4 style="color: #007DB7;margin-bottom: 0px;margin-top: 10px;font-size: 16px;">We are here to help</h4></td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Please contact us if you have any questions at - '.$from_email.' </p>
									</td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Cheers,</p>
									</td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin: 0;font-size: 14px;"><small style="color: #9c9c9c;font-size: 12px;">Powered by SpeakerEngage.com</small></p></td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>';


				if($schedule_option == 'send_later'){
					//tbl_sendlatermaildetails 

					  	$timezonezone = mysqli_real_escape_string($connect, $_POST['timezone']);
					  	$schedule_datetime = date("Y-m-d H:i",strtotime( mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));

					    $date = new DateTime();
						$timeZone = $date->getTimezone();
						$servrtz=$timeZone->getName();
						$userTimezone = new DateTimeZone($timezonezone);

						
						$gmtTimezone = new DateTimeZone('GMT');
						//$myDateTime = new DateTime($scheduleddatetime1, $gmtTimezone);
						$myDateTime = new DateTime($schedule_datetime, $gmtTimezone);						
						$offset = $userTimezone->getOffset($myDateTime);					

						$myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');					
						$myDateTime->add($myInterval);
						$result = $myDateTime->format('Y-m-d H:i:s');
						$timestamp = strtotime($schedule_datetime) - ($offset);						
						$scheduledfinalDT = date("Y-m-d H:i:s", $timestamp);					


						 $insert_request = "INSERT INTO tbl_sendlatermaildetails(tanent_id,speaker_emailid,user_email,scheduleddatetime,template_sub,template_data,username,cc_mailaddress,emailtype,isSent,type,timezone,event_id,user_scheduledtime,speaker_id,template_id,user_id,speaker_manager_id) VALUES ('".$session_tanent_id."','".$speaker_email."','".$from_email."','".$scheduledfinalDT."','Collect missing profile information','".$email_body."','".$loggedin_user_name."','".$speaker_manager_email."','1','0','missing-info-collect','".$timezonezone."','".$sp_event_id."','".$schedule_datetime."','".$info_modal_speakerid."','0','".$loggedin_userid."','".$speaker_manager_email."') ";	
						mysqli_query($connect,$insert_request);

						 mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Scheduled Request info speaker','".$info_modal_speakerid."','".$loggedin_userid."',now(),\"".$insert_request."\")");	


				}else{

					//*** send now*********//
					// send email to speaker			   
					if($cc_to_manager == 1){
						$send_email = $common->sendEmail($speaker_email , $from_email, 'Request for Missing Information',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name,$speaker_manager_email);
					}else{
						$send_email = $common->sendEmail($speaker_email , $from_email, 'Request for Missing Information',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);
					}
					$calculate_template_usage_func = $common->calculate_template_usage(9998,$event_id,1);
					$type_update = $common->calculate_speaker_type_count($event_id);
					// update email count
					$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_speakers` WHERE `id` = '".$info_modal_speakerid."' ");
					$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
					$spk_email_count = $res_spk_email_count['mail_sent_count'];
					$new_count = $spk_email_count+ 1;
					$update_spk_email_count = mysqli_query($connect,"UPDATE `all_speakers` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$info_modal_speakerid."' ");

					//*********** all_event_email_count
					$fetch_event_email_count = mysqli_query($connect,"SELECT speaker_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
					$res_email_count = mysqli_fetch_array($fetch_event_email_count);
					$total_email_count = $res_email_count['speaker_email_count'];
					$new_total_count = $total_email_count + 1;
					$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `speaker_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");
				}



			header('Location:../all-speakers.php?request-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999))); 
		break;


		case "doc_form_submit":
			
			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$multiselect_all_doc_opt =  $_POST['multiselect_all_doc_opt'];			
			$schedule_option = mysqli_real_escape_string($connect, $_POST['schedule_option']);
			$info_modal_speakerid = mysqli_real_escape_string($connect, $_POST['info_modal_userid']);			
			$info_manager_cc = mysqli_real_escape_string($connect, $_POST['info_manager_cc']);

			$info_msg = mysqli_real_escape_string($connect, $_POST['info_msg']);
			$info_msg = str_replace('\n', "\n", $info_msg);
			$info_msg = str_replace('\r', "\r", $info_msg);

			//var_dump($info_manager_cc);exit();

			$token = md5(uniqid());
			$loggedin_user_id = $_SESSION['user_id'];			

			$is_powerpoint = 0;
			$is_video = 0;
			$is_offer = 0;
			$is_websiteurl = 0;	



			if (in_array("is_powerpoint", $multiselect_all_doc_opt)){
				$is_powerpoint = 1;
		    }
			
			if (in_array("is_video", $multiselect_all_doc_opt)){
				$is_video = 1;
		    }

		    if (in_array("is_offer", $multiselect_all_doc_opt)){
				$is_offer = 1;
		    }
		    if (in_array("is_websiteurl", $multiselect_all_doc_opt)){
				$is_websiteurl = 1;
		    }

		    if($info_manager_cc == 'yes'){
		    	$cc_to_manager = 1;
		    }

		    if($schedule_option == 'send_later'){		
		    $is_schedule = 1;    	
		    	$schedule_datetime = date("Y-m-d H:i",strtotime(mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));
		    }

		    $loggedin_userid = $_SESSION['user_id'];
		    // fetch loggedin user details
		    $user_details = $common->get_user_details_by_id($loggedin_userid); 
		     $loggedin_user_name = $user_details[0]['first_name'];

		     //loggedin_user_email 
		     $from_email = $user_details[0]['email']; 


		    // fetch_speaker details
		    $fetch_speaker_details = mysqli_query($connect,"SELECT * FROM `all_speakers` WHERE `id` = '$info_modal_speakerid' ");
			if(mysqli_num_rows($fetch_speaker_details) > 0){
				$res_sp = mysqli_fetch_array($fetch_speaker_details);
				$speaker_email = $res_sp['email_id'];
				$speaker_name = $res_sp['speaker_name'];
				$speaker_manager_email = $res_sp['speaker_manager_email'];
				$sp_event_id = $res_sp['event_id'];
			}

			$fetch_event_data = mysqli_query($connect, "SELECT * FROM `all_events` WHERE `id` = '$sp_event_id' ");
			if(mysqli_num_rows($fetch_event_data) > 0){
				$res_event = mysqli_fetch_array($fetch_event_data);
				$event_email_banner = $res_event['event_email_banner'];
			}

			$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
			$res_site_details = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_details['value'];

			//var_dump($res_site_details); exit();

			if($event_email_banner != null || $event_email_banner != '' ){

				$email_banner = $site_url.'/images/event_email_banner/'.$event_email_banner;
			}else{
				$email_banner = $site_url.'/images/NoPath.jpg';
			}


		    $insert_request = mysqli_query($connect, "INSERT INTO information_collect(powerpoint,doc_video,offers,website_url,sent_to_speaker_id,cc_to_manager,is_schedule,schedule_at,message,token) VALUES ('".$is_powerpoint."','".$is_video."','".$is_offer."','".$is_websiteurl."','".$info_modal_speakerid."','".$cc_to_manager."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."') ");			

		    $sql =  "INSERT INTO information_collect(powerpoint,doc_video,offers,website_url,sent_to_speaker_id,cc_to_manager,is_schedule,schedule_at,message,token) VALUES ('".$is_powerpoint."','".$is_video."','".$is_offer."','".$is_websiteurl."','".$info_modal_speakerid."','".$cc_to_manager."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."')";
		    if($schedule_option != 'send_later'){
		   		mysqli_query($connect, "INSERT INTO all_logs(tanent_id,operation,table_name,created_by,sql_qry,table_id,event_id) VALUES ('".$session_tanent_id."','request missing documents','document_collect','".$loggedin_user_id."',\"".$sql."\",'".$info_modal_speakerid."','".$event_id."')"); 
		    $last_insert_id = mysqli_insert_id($connect);
			}


		    $dynamic_link = $site_url."/collect-missing-documentation.php?tk=".$token;

		    $email_body = '<table cellspacing="0" cellpadding="0" width="500" align="center" style="border: 1px solid #f1f1f1;">
					<tr>
						<td>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
								<tr>
									<td><img src="https://www.speakerengage.com/images/main-logo.png" width="100" alt="Speaker Engage" /></td>
								</tr>
							</table>
							<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><img src="'.$email_banner.'" width="500" alt="Speaker Engage" /></td>
								</tr>
							</table>

							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin-bottom: 0;margin-top: 10px;font-size: 14px;">Hi <span style="font-weight: 600;">'.$speaker_name.'</span>,</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;">'.$info_msg.'</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;margin-bottom:5px;">Simply click on the button to take action:</p></td>
								</tr>


							</table>

							<table cellpadding="5" cellspacing="0" width="150px" bgcolor="" style="margin-left: 5px;cursor:pointer;">
								<tr>
									<td align="center" width="150" height="40" bgcolor="#007DB7" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;cursor:pointer;">
								            <a href="'.$dynamic_link.'" style="color: #ffffff; font-size:16px; font-weight: bold; font-family:sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">
								                Take Action
								            </a>
								        </td>
								</tr>
							</table>


							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><h4 style="color: #007DB7;margin-bottom: 0px;margin-top: 10px;font-size: 16px;">We are here to help</h4></td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Please contact us if you have any questions at - '.$from_email.' </p>
									</td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Cheers,</p>
									</td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin: 0;font-size: 14px;"><small style="color: #9c9c9c;font-size: 12px;">Powered by SpeakerEngage.com</small></p></td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>';


				if($schedule_option == 'send_later'){
					//tbl_sendlatermaildetails 

					  	$timezonezone = mysqli_real_escape_string($connect, $_POST['timezone']);
					  	$schedule_datetime = date("Y-m-d H:i",strtotime(mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));

					    $date = new DateTime();
						$timeZone = $date->getTimezone();
						$servrtz=$timeZone->getName();
						$userTimezone = new DateTimeZone($timezonezone);

						
						$gmtTimezone = new DateTimeZone('GMT');
						//$myDateTime = new DateTime($scheduleddatetime1, $gmtTimezone);
						$myDateTime = new DateTime($schedule_datetime, $gmtTimezone);						
						$offset = $userTimezone->getOffset($myDateTime);					

						$myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');					
						$myDateTime->add($myInterval);
						$result = $myDateTime->format('Y-m-d H:i:s');
						$timestamp = strtotime($schedule_datetime) - ($offset);						
						$scheduledfinalDT = date("Y-m-d H:i:s", $timestamp);					


						 $insert_request = "INSERT INTO tbl_sendlatermaildetails(tanent_id,speaker_emailid,user_email,scheduleddatetime,template_sub,template_data,username,cc_mailaddress,emailtype,isSent,type,timezone,event_id,user_scheduledtime,speaker_id,template_id,user_id,speaker_manager_id) VALUES ('".$session_tanent_id."','".$speaker_email."','".$from_email."','".$scheduledfinalDT."','Collect missing profile information','".$email_body."','".$loggedin_user_name."','".$speaker_manager_email."','1','0','missing-document-collect','".$timezonezone."','".$sp_event_id."','".$schedule_datetime."','".$info_modal_speakerid."','0','".$loggedin_userid."','".$speaker_manager_email."') ";	
						 mysqli_query($connect,$insert_request);	

						 mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Scheduled Request document speaker','".$info_modal_speakerid."','".$loggedin_userid."',now(),\"".$insert_request."\")");

				}else{

					//*** send now*********//
					// send email to speaker			   
					if($cc_to_manager == 1){
						$send_email = $common->sendEmail($speaker_email , $from_email, 'Request for Missing Document',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name,$speaker_manager_email);
					}else{
						$send_email = $common->sendEmail($speaker_email , $from_email, 'Request for Missing Document',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);
					}
					$calculate_template_usage_func = $common->calculate_template_usage(9999,$event_id,1);
					$type_update = $common->calculate_speaker_type_count($event_id);
					// update email count
					$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_speakers` WHERE `id` = '".$info_modal_speakerid."' ");
					$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
					$spk_email_count = $res_spk_email_count['mail_sent_count'];
					$new_count = $spk_email_count+ 1;
					$update_spk_email_count = mysqli_query($connect,"UPDATE `all_speakers` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$info_modal_speakerid."' ");

					//*********** all_event_email_count	
					$fetch_event_email_count = mysqli_query($connect,"SELECT speaker_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
					$res_email_count = mysqli_fetch_array($fetch_event_email_count);
					$total_email_count = $res_email_count['speaker_email_count'];
					$new_total_count = $total_email_count + 1;
					$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `speaker_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");
				}		    
			header('Location:../all-speakers.php?request-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999))); 
			
			break;

		case "collect-missing-info":

			$directoryName="../images/";

			$speaker_id = mysqli_real_escape_string($connect,$_POST['speaker_id']);
			$tk = trim($_POST['token']);

			$sp_name= mysqli_real_escape_string($connect,$_POST['sp_name']);
			$sp_email= mysqli_real_escape_string($connect,$_POST['sp_email']);			
			$your_bio= mysqli_real_escape_string($connect,$_POST['your_bio']);
			$your_quote= mysqli_real_escape_string($connect,$_POST['your_quote']);
			
			$speaker_manager_name= mysqli_real_escape_string($connect,$_POST['sp_manager_name']);
			$speaker_manager_email= mysqli_real_escape_string($connect,$_POST['speaker_manager_email']);
			$speaker_manager_phone= mysqli_real_escape_string($connect,$_POST['speaker_manager_phone']);

			$twitter_handle = mysqli_real_escape_string($connect,$_POST['twitter_handle']);
			$twitter_followers = mysqli_real_escape_string($connect, $_POST['twitter_followers']);
			$twitter_lastupdated = mysqli_real_escape_string($connect, $_POST['twitter_lastupdated']);

			$linkedin_handle = mysqli_real_escape_string($connect,$_POST['linkedin_url']);
			$linkedin_connections = mysqli_real_escape_string($connect, $_POST['linkedin_connections']);
			$linkedin_lastupdated = mysqli_real_escape_string($connect, $_POST['linkedin_lastupdated']);			
			
			$instagram_handle = mysqli_real_escape_string($connect,$_POST['instagram_url']);
			$facebook_handle = mysqli_real_escape_string($connect,$_POST['Facebook_url']);

			$title1= mysqli_real_escape_string($connect,$_POST['title1']);
			$description1= mysqli_real_escape_string($connect,$_POST['description1']);
			$title2= mysqli_real_escape_string($connect,$_POST['title2']);
			$description2= mysqli_real_escape_string($connect,$_POST['description2']);
			$title3= mysqli_real_escape_string($connect,$_POST['title3']);
			$description3= mysqli_real_escape_string($connect,$_POST['description3']);

			//******************************//
			$phone_number = mysqli_real_escape_string($connect,$_POST['phone_number']);
			$company_name = mysqli_real_escape_string($connect,$_POST['company_name']);
			$job_title = mysqli_real_escape_string($connect,$_POST['job_title']);
			$address1 = mysqli_real_escape_string($connect,$_POST['address1']);
			$address2 = mysqli_real_escape_string($connect,$_POST['address2']);
			$country = mysqli_real_escape_string($connect,$_POST['country']);
			$state = mysqli_real_escape_string($connect,$_POST['state']);
			$city = mysqli_real_escape_string($connect,$_POST['city']);
			$zip_code = mysqli_real_escape_string($connect,$_POST['zip_code']);


			$fetch_speaker_data = mysqli_query($connect,"SELECT * FROM all_speakers WHERE `id` = '".$speaker_id."' ");
			$res_spk = mysqli_fetch_array($fetch_speaker_data);
			$existing_score = $res_spk['social_media_total_score'];

			//$social_media_total_score =  0;
			if(!empty($twitter_followers) && !empty($twitter_lastupdated) && !empty($linkedin_connections) && !empty($linked_lastupdated)){
				$social_media_total_score = (($twitter_followers)+ ($twitter_lastupdated)+ ($linkedin_connections)+ ($linked_lastupdated))/4; 			
			}else{
				$social_media_total_score = $existing_score;
			}	


				$file_name = '';
				if($_POST['image_src']) {

				$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
				$file_name=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
				list($type, $file) = explode(';', $file);
				list(, $file)      = explode(',', $file);
				file_put_contents($directoryName.$file_name , base64_decode($file));

				$update_speaker_image = mysqli_query($connect,"UPDATE `all_speakers` SET head_shot = '".$file_name."' WHERE `id` = '$speaker_id'");

				}


			$update_date=Date('Y-m-d h:i:s');

			$update_speaker = "UPDATE `all_speakers` SET speaker_name = '".$sp_name."',email_id='".$sp_email."',short_bio='".$your_bio."', your_quote='".$your_quote."', linkedin_handle='".$twitter_handle."',twitter_followers='".$twitter_followers."',twitter_lastupdated='".$twitter_lastupdated."',linkedin_url='".$linkedin_handle."',linkedin_connections='".$linkedin_connections."',linkedin_lastupdated='".$linkedin_lastupdated."',instagram='".$instagram_handle."',facebook='".$facebook_handle."',speaker_manager = '".$speaker_manager_name."',speaker_manager_phone='".$speaker_manager_phone."',speaker_manager_email='".$speaker_manager_email."', presentation_title1='".$title1."',presentation_description1='".$description1."' , presentation_title2='".$title2."',presentation_description2='".$description2."' , presentation_title3='".$title3."',presentation_description3='".$description3."',social_media_total_score='".$social_media_total_score."',company = '".$company_name."',phone='".$phone_number."',title='".$job_title."',address1= '".$address1."',address2='".$address2."',country='".$country."',state='".$state."',city='".$city."',zip='".$zip_code."' WHERE `id` = '$speaker_id' ";

			if(mysqli_query($connect,$update_speaker) ){

				$profile_complete = $common->get_speaker_info_missing_value($speaker_id);


			 	mysqli_query($connect, "UPDATE `all_speakers` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speaker_id );

				//header('Location: ../collect-success.php?info-request-success');
				header('Location: ../collect-profile-info.php?tk='.$tk.'&info-collect-success');
			}
		
		 break;


		 case "ppt_upload":
		 $tk = trim($_POST['token']);

		 header('Location: ../collect-missing-documentation.php?tk'.$tk.'&info-collect-success');
		 	
	 	 break;

	 	case "create_status_sponsor":
		   	$status = mysqli_real_escape_string($connect, $_POST['status']);
		   	$type = mysqli_real_escape_string($connect, $_GET['type']);
		   	//$event_id = $_SESSION['current_event_id'];

		   	$event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']); 

			$sql = "INSERT INTO all_status(status_name,last_edited_user_id,status_for,event_id) VALUES ('".$status."','".$id_user."','".$type."','".$event_id."')";
			mysqli_query($connect, $sql);
			$tenant_id = $common->get_tenant_id_from_eventid($event_id); 
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,created_by,sql_qry,table_name) VALUES ('".$tenant_id."','".$event_id."','create sponsor status','".$id_user."',\"".$sql."\", 'all_status')");

			header('Location:../status_sponsor.php?type='.$type.'&created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

		case "edit_sponsor_status":
			$speaker_type_name = mysqli_real_escape_string($connect, $_POST['speaker_status_name']);
			$id = mysqli_real_escape_string($connect, $_POST['id']);
			$event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']);		

			$sql = "UPDATE all_status SET status_name='".$speaker_type_name."' WHERE id=".$id;
			mysqli_query($connect, $sql);

			$tenant_id = $common->get_tenant_id_from_eventid($event_id); 
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,created_by,sql_qry,table_name) VALUES ('".$tenant_id."','".$event_id."','update sponsor status','".$id_user."',\"".$sql."\", 'all_status')");
			header('Location:../status_sponsor.php?type=sponsor&updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

		case "information_form_submit_sponsor":

			//$multiselect_all_speakers = mysqli_real_escape_string($connect, implode("~", $_POST['multiselect_all_speakers']) );
			$event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$multiselect_all_section =  $_POST['multiselect_all_section'];			
			$schedule_option = mysqli_real_escape_string($connect, $_POST['schedule_option']);
			$info_modal_speakerid = mysqli_real_escape_string($connect, $_POST['info_modal_userid']);
			
			$info_manager_cc = mysqli_real_escape_string($connect, $_POST['info_manager_cc']);

			$info_msg = mysqli_real_escape_string($connect, $_POST['info_msg']);
			$info_msg = str_replace('\n', "\n", $info_msg);
			$info_msg = str_replace('\r', "\r", $info_msg);


			$token = md5(uniqid());
			$loggedin_user_id = $_SESSION['user_id'];			

			$is_headshot = 0;
			$is_bio = 0;
			$is_executive = 0;
			$is_address = 0;
			$is_manager = 0;
			$is_social = 0;
			$is_presentation = 0;
			$is_acknowledgement = 0;
			$is_schedule = 0;
			$schedule_datetime = '';
			$cc_to_manager = 0;



			if (in_array("is_headshot", $multiselect_all_section)){
				$is_headshot = 1;
		    }
			
			if (in_array("is_bio", $multiselect_all_section)){
				$is_bio = 1;
		    }

		    if (in_array("is_executive", $multiselect_all_section)){
				$is_executive = 1;
		    }

		    if (in_array("is_address", $multiselect_all_section)){
				$is_address = 1;
		    }

		    if (in_array("is_social", $multiselect_all_section)){
				$is_social = 1;
		    }

		    if (in_array("is_presentation", $multiselect_all_section)){
				$is_presentation = 1;
		    }

		 
		    if($info_manager_cc == 'yes'){
		    	$cc_to_manager = 1;
		    }

		    if($schedule_option == 'send_later'){		
		    $is_schedule = 1;    	
		    	//$schedule_datetime = mysqli_real_escape_string($connect, $_POST['schedule_datetime']);
		    	$schedule_datetime = date("Y-m-d H:i",strtotime(mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));
		    }

		    $loggedin_userid = $_SESSION['user_id'];
		    // fetch loggedin user details
		    $user_details = $common->get_user_details_by_id($loggedin_userid); 
		     $loggedin_user_name = $user_details[0]['first_name'];

		     //loggedin_user_email 
		     $from_email = $user_details[0]['email']; 


		    // fetch_speaker details
		    $fetch_sponsor_details = mysqli_query($connect,"SELECT * FROM `all_sponsors` WHERE `id` = '$info_modal_speakerid' ");
			if(mysqli_num_rows($fetch_sponsor_details) > 0){
				$res_sp = mysqli_fetch_array($fetch_sponsor_details);
				$sponsor_email = $res_sp['sponsor_contact_email_address'];
				$sponsor_name = $res_sp['sponsor_company_name'];
				$sponsor_ex_email = $res_sp['secondary1_sponsor_contact_email_address'];
				$sp_event_id = $res_sp['event_id'];
			}

			 if($info_manager_cc == 'yes'){
			 	$sponsor_ex_email=$sponsor_ex_email;
			 }else
			 {
			 	$sponsor_ex_email=='';
			 }

			$fetch_event_data = mysqli_query($connect, "SELECT * FROM `all_events` WHERE `id` = '$sp_event_id' ");
			if(mysqli_num_rows($fetch_event_data) > 0){
				$res_event = mysqli_fetch_array($fetch_event_data);
				$event_email_banner = $res_event['event_email_banner'];
			}

			$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
			$res_site_details = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_details['value'];

			//var_dump($res_site_details); exit();

			if($event_email_banner != null || $event_email_banner != '' ){

				$email_banner = $site_url.'/images/event_email_banner/'.$event_email_banner;
			}else{
				$email_banner = $site_url.'/images/NoPath.jpg';
			}


		    $insert_request = mysqli_query($connect, "INSERT INTO information_collect(headshot,bio,address,speaker_manager,social_media,presentation_title,sent_to_speaker_id,cc_to_manager,is_schedule,schedule_at,message,token) VALUES ('".$is_headshot."','".$is_bio."','".$is_address."','".$is_manager."','".$is_social."','".$is_presentation."','".$info_modal_speakerid."','".$cc_to_manager."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."') ");

		     $sql =  "INSERT INTO information_collect(headshot,bio,address,speaker_manager,social_media,presentation_title,sent_to_speaker_id,cc_to_manager,is_schedule,schedule_at,message,token) VALUES ('".$is_headshot."','".$is_bio."','".$is_address."','".$is_manager."','".$is_social."','".$is_presentation."','".$info_modal_speakerid."','".$cc_to_manager."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."')";	

		     if($schedule_option != 'send_later'){
		    mysqli_query($connect, "INSERT INTO all_logs(tanent_id,operation,table_name,created_by,sql_qry,table_id,event_id) VALUES ('".$session_tanent_id."','request missing information sponsor','information_collect_sponsor','".$loggedin_user_id."',\"".$sql."\",'".$info_modal_speakerid."','".$event_id."')"); 
		    $last_insert_id = mysqli_insert_id($connect);
			}

		    $dynamic_link = $site_url."/collect-profile-info-sponsor.php?tk=".$token;

		    $email_body = '<table cellspacing="0" cellpadding="0" width="500" align="center" style="border: 1px solid #f1f1f1;">
					<tr>
						<td>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
								<tr>
									<td><img src="https://www.speakerengage.com/images/main-logo.png" width="100" alt="Speaker Engage" /></td>
								</tr>
							</table>
							<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><img src="'.$email_banner.'" width="500" alt="Speaker Engage" /></td>
								</tr>
							</table>

							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin-bottom: 0;margin-top: 10px;font-size: 14px;">Hi <span style="font-weight: 600;">'.$sponsor_name.'</span>,</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;">'.$info_msg.'</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;padding-bottom:5px;">Simply click on the button to take action:</p></td>
								</tr>

								
							</table>
							<table cellpadding="5" cellspacing="0" width="150px" bgcolor="" style="margin-left: 5px;cursor:pointer;">
								<tr>
									<td align="center" width="150" height="40" bgcolor="#007DB7" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;cursor:pointer;">
								            <a href="'.$dynamic_link.'" style="color: #ffffff; font-size:16px; font-weight: bold; font-family:sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">
								                Take Action
								            </a>
								        </td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><h4 style="color: #007DB7;margin-bottom: 0px;margin-top: 10px;font-size: 16px;">We are here to help</h4></td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Please contact us if you have any questions at - '.$from_email.' </p>
									</td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Cheers,</p>
									</td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin: 0;font-size: 14px;"><small style="color: #9c9c9c;font-size: 12px;">Powered by SpeakerEngage.com</small></p></td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>';


				if($schedule_option == 'send_later'){
					//tbl_sendlatermaildetails 

					  	$timezonezone = mysqli_real_escape_string($connect, $_POST['timezone']);
					  	// $schedule_datetime = mysqli_real_escape_string($connect, $_POST['schedule_datetime']);
					  	$schedule_datetime = date("Y-m-d H:i",strtotime(mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));

					    $date = new DateTime();
						$timeZone = $date->getTimezone();
						$servrtz=$timeZone->getName();
						$userTimezone = new DateTimeZone($timezonezone);

						
						$gmtTimezone = new DateTimeZone('GMT');
						//$myDateTime = new DateTime($scheduleddatetime1, $gmtTimezone);
						$myDateTime = new DateTime($schedule_datetime, $gmtTimezone);						
						$offset = $userTimezone->getOffset($myDateTime);					

						$myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');					
						$myDateTime->add($myInterval);
						$result = $myDateTime->format('Y-m-d H:i:s');
						$timestamp = strtotime($schedule_datetime) - ($offset);						
						$scheduledfinalDT = date("Y-m-d H:i:s", $timestamp);					


						 $insert_request = mysqli_query($connect, "INSERT INTO tbl_sendlatermaildetails(speaker_emailid,user_email,scheduleddatetime,template_sub,template_data,username,cc_mailaddress,emailtype,isSent,type,timezone,event_id,user_scheduledtime,speaker_id,template_id,user_id,speaker_manager_id) VALUES ('".$sponsor_email."','".$from_email."','".$scheduledfinalDT."','Collect missing profile information sponsor','".$email_body."','".$loggedin_user_name."','".$sponsor_ex_email."','1','0','missing-info-collect-sponsor','".$timezonezone."','".$sp_event_id."','".$schedule_datetime."','".$info_modal_speakerid."','0','".$loggedin_userid."','".$sponsor_ex_email."') ");		


				}else{

					//*** send now*********//
					// send email to speaker			   
					if($cc_to_manager == 1){
						$send_email = $common->sendEmail($sponsor_email , $from_email, 'Request for Missing Information Sponsor',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name,$sponsor_ex_email);
					}else{
						$send_email = $common->sendEmail($sponsor_email , $from_email, 'Request for Missing Information Sponsor',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);
					}
					$calculate_template_usage_func = $common->calculate_template_usage(9998,$event_id,2);
					$type_update = $common->calculate_sponsor_type_count($event_id);
					// update email count
					$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_sponsors` WHERE `id` = '".$info_modal_speakerid."' ");
					$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
					$spk_email_count = $res_spk_email_count['mail_sent_count'];
					$new_count = $spk_email_count+ 1;
					$update_spk_email_count = mysqli_query($connect,"UPDATE `all_sponsors` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$info_modal_speakerid."' ");

					//*********** all_event_email_count
					$fetch_event_email_count = mysqli_query($connect,"SELECT sponsor_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
					$res_email_count = mysqli_fetch_array($fetch_event_email_count);
					$total_email_count = $res_email_count['sponsor_email_count'];
					$new_total_count = $total_email_count + 1;
					$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `sponsor_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

				}		    

			header('Location:../all-sponsors.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&request-success'); 
		break;

		case "collect-missing-info-sponsor":

			//$directoryName="../images/";

			$sponsor_id = mysqli_real_escape_string($connect,$_POST['sponsor_id']);
			$tk = trim($_POST['token']);

			$sp_name= mysqli_real_escape_string($connect,$_POST['sp_name']);
			$company_url= mysqli_real_escape_string($connect,$_POST['company_url']);			
			$your_bio= mysqli_real_escape_string($connect,$_POST['your_bio']);
			$address1= mysqli_real_escape_string($connect,$_POST['address1']);
			$address2= mysqli_real_escape_string($connect,$_POST['address2']);
			
			$country= mysqli_real_escape_string($connect,$_POST['country']);
			$state= mysqli_real_escape_string($connect,$_POST['state']);
			$zip_code= mysqli_real_escape_string($connect,$_POST['zip_code']);
			$city= mysqli_real_escape_string($connect,$_POST['city']);

			$twitter_handle = mysqli_real_escape_string($connect,$_POST['twitter_handle']);
			$linkedin_handle = mysqli_real_escape_string($connect,$_POST['linkedin_url']);
			$instagram_handle = mysqli_real_escape_string($connect,$_POST['instagram_url']);
			$facebook_handle = mysqli_real_escape_string($connect,$_POST['Facebook_url']);
			$total_sm_reach = mysqli_real_escape_string($connect,$_POST['total_sm_reach']);
			$total_email = mysqli_real_escape_string($connect,$_POST['total_email']);

			$primary_sp_name = mysqli_real_escape_string($connect,$_POST['primary_sp_name']);
			$primary_sp_number = mysqli_real_escape_string($connect,$_POST['primary_sp_number']);
			$primary_sp_mail = mysqli_real_escape_string($connect,$_POST['primary_sp_mail']);
			$primary_sp_role = mysqli_real_escape_string($connect,$_POST['primary_sp_role']);

			$other_sp_name = mysqli_real_escape_string($connect,$_POST['other_sp_name']);
			$other_sp_contact = mysqli_real_escape_string($connect,$_POST['other_sp_contact']);
			$other_sp_email = mysqli_real_escape_string($connect,$_POST['other_sp_email']);
			$other_sp_role = mysqli_real_escape_string($connect,$_POST['other_sp_role']);

			$sp_ex_name = mysqli_real_escape_string($connect,$_POST['sp_ex_name']);
			$sp_ex_contact = mysqli_real_escape_string($connect,$_POST['sp_ex_contact']);
			$ex_sp_mail = mysqli_real_escape_string($connect,$_POST['ex_sp_mail']);
			$ex_sp_role = mysqli_real_escape_string($connect,$_POST['ex_sp_role']);
		
				// $file_name = '';
				// if($_POST['image_src']) {

				// $file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
				// $file_name=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
				// list($type, $file) = explode(';', $file);
				// list(, $file)      = explode(',', $file);
				// file_put_contents($directoryName.$file_name , base64_decode($file));

				// $update_speaker_image = mysqli_query($connect,"UPDATE `all_sponsors` SET sponsor_logo = '".$file_name."' WHERE `id` = '$sponsor_id'");

				// }


			$update_date=Date('Y-m-d h:i:s');

			$sql = "UPDATE `all_sponsors` SET `sponsor_company_name`='".$sp_name."', `sponsor_contact_person`='".$primary_sp_name."', `sponsor_contact_number`='".$primary_sp_number."', `sponsor_contact_email_address` = '".$primary_sp_mail."', `sponsor_role`='".$primary_sp_role."', `secondary1_sponsor_contact_person`='".$sp_ex_name."', `secondary1_sponsor_contact_number`='".$sp_ex_contact."', `secondary1_sponsor_contact_email_address` = '".$ex_sp_mail."', `secondary1_sponsor_role`='".$ex_sp_role."', `sponsor_bio` = '".$your_bio."', `facebook_url` = '".$facebook_handle."', `twitter_url` ='".$twitter_handle."', `linkedin_url` ='".$linkedin_handle."', `instagram_url` ='".$instagram_handle."', `address1`='".$address1."', `address2`='".$address2."', `city`='".$city."', `state`='".$state."',`company_url`='".$company_url."',`country`='".$country."',`zipcode`='".$zip_code."',`total_social_media_reach`='".$total_sm_reach."',`total_email_reach`='".$total_email."',`other_contact_name`='".$other_sp_name."',`other_contact_number`='".$other_sp_contact."',`other_email_address`='".$other_sp_email."',`other_role`='".$other_sp_role."' WHERE id=".$sponsor_id;

				mysqli_query($connect,$sql);
				header('Location: ../collect-profile-info-sponsor.php?tk='.$tk.'&info-collect-success');
		
		 break;

		 case "doc_form_submit_sponsor":
			
			$event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$multiselect_all_doc_opt =  $_POST['multiselect_all_doc_opt'];			
			$schedule_option = mysqli_real_escape_string($connect, $_POST['schedule_option']);
			$info_modal_speakerid = mysqli_real_escape_string($connect, $_POST['info_modal_userid']);			
			$info_manager_cc = mysqli_real_escape_string($connect, $_POST['info_manager_cc']);

			$info_msg = mysqli_real_escape_string($connect, $_POST['info_msg']);
			$info_msg = str_replace('\n', "\n", $info_msg);
			$info_msg = str_replace('\r', "\r", $info_msg);

			//var_dump($info_manager_cc);exit();

			$token = md5(uniqid());
			$loggedin_user_id = $_SESSION['user_id'];			

			$is_powerpoint = 0;
			$is_video = 0;
			$is_offer = 0;
			$is_websiteurl = 0;	



			if (in_array("is_powerpoint", $multiselect_all_doc_opt)){
				$is_powerpoint = 1;
		    }
			
			if (in_array("is_video", $multiselect_all_doc_opt)){
				$is_video = 1;
		    }

		    if (in_array("is_offer", $multiselect_all_doc_opt)){
				$is_offer = 1;
		    }
		    if (in_array("is_websiteurl", $multiselect_all_doc_opt)){
				$is_websiteurl = 1;
		    }

		    if($info_manager_cc == 'yes'){
		    	$cc_to_manager = 1;
		    }

		    if($schedule_option == 'send_later'){		
		    $is_schedule = 1;  

		    	//$schedule_datetime = mysqli_real_escape_string($connect, $_POST['schedule_datetime']);
		    	$schedule_datetime = date("Y-m-d H:i",strtotime(mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));
		    }

		    $loggedin_userid = $_SESSION['user_id'];
		    // fetch loggedin user details
		    $user_details = $common->get_user_details_by_id($loggedin_userid); 
		     $loggedin_user_name = $user_details[0]['first_name'];

		     //loggedin_user_email 
		     $from_email = $user_details[0]['email']; 


		    // fetch_speaker details
		      $fetch_sponsor_details = mysqli_query($connect,"SELECT * FROM `all_sponsors` WHERE `id` = '$info_modal_speakerid' ");
			if(mysqli_num_rows($fetch_sponsor_details) > 0){
				$res_sp = mysqli_fetch_array($fetch_sponsor_details);
				$sponsor_email = $res_sp['sponsor_contact_email_address'];
				$sponsor_name = $res_sp['sponsor_company_name'];
				$sponsor_ex_email = $res_sp['secondary1_sponsor_contact_email_address'];
				$sp_event_id = $res_sp['event_id'];
			}

			if($info_manager_cc == 'yes'){
			 	$sponsor_ex_email=$sponsor_ex_email;
			 }else
			 {
			 	$sponsor_ex_email=='';
			 }


			$fetch_event_data = mysqli_query($connect, "SELECT * FROM `all_events` WHERE `id` = '$sp_event_id' ");
			if(mysqli_num_rows($fetch_event_data) > 0){
				$res_event = mysqli_fetch_array($fetch_event_data);
				$event_email_banner = $res_event['event_email_banner'];
			}

			$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
			$res_site_details = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_details['value'];

			//var_dump($res_site_details); exit();

			if($event_email_banner != null || $event_email_banner != '' ){

				$email_banner = $site_url.'/images/event_email_banner/'.$event_email_banner;
			}else{
				$email_banner = $site_url.'/images/NoPath.jpg';
			}


		    $insert_request = mysqli_query($connect, "INSERT INTO information_collect(powerpoint,doc_video,offers,website_url,sent_to_speaker_id,cc_to_manager,is_schedule,schedule_at,message,token) VALUES ('".$is_powerpoint."','".$is_video."','".$is_offer."','".$is_websiteurl."','".$info_modal_speakerid."','".$cc_to_manager."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."') ");			

		    $sql =  "INSERT INTO information_collect(powerpoint,doc_video,offers,website_url,sent_to_speaker_id,cc_to_manager,is_schedule,schedule_at,message,token) VALUES ('".$is_powerpoint."','".$is_video."','".$is_offer."','".$is_websiteurl."','".$info_modal_speakerid."','".$cc_to_manager."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."')";
		    
		    if($schedule_option != 'send_later'){
		   mysqli_query($connect, "INSERT INTO all_logs(tanent_id,operation,table_name,created_by,sql_qry,table_id,event_id) VALUES ('".$session_tanent_id."','request missing documents sponsor','document_collect_sponsor','".$loggedin_user_id."',\"".$sql."\",'".$info_modal_speakerid."','".$event_id."')"); 
		   
		    $last_insert_id = mysqli_insert_id($connect);
			}

		    $dynamic_link = $site_url."/collect-missing-documentation-sponsor.php?tk=".$token;

		    $email_body = '<table cellspacing="0" cellpadding="0" width="500" align="center" style="border: 1px solid #f1f1f1;">
					<tr>
						<td>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
								<tr>
									<td><img src="https://www.speakerengage.com/images/main-logo.png" width="100" alt="Speaker Engage" /></td>
								</tr>
							</table>
							<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><img src="'.$email_banner.'" width="500" alt="Speaker Engage" /></td>
								</tr>
							</table>

							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin-bottom: 0;margin-top: 10px;font-size: 14px;">Hi <span style="font-weight: 600;">'.$sponsor_name.'</span>,</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;">'.$info_msg.'</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;margin-bottom:5px;">Simply click on the button to take action:</p></td>
								</tr>


							</table>

							<table cellpadding="5" cellspacing="0" width="150px" bgcolor="" style="margin-left: 5px;cursor:pointer;">
								<tr>
									<td align="center" width="150" height="40" bgcolor="#007DB7" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;cursor:pointer;">
								            <a href="'.$dynamic_link.'" style="color: #ffffff; font-size:16px; font-weight: bold; font-family:sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">
								                Take Action
								            </a>
								        </td>
								</tr>
							</table>


							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><h4 style="color: #007DB7;margin-bottom: 0px;margin-top: 10px;font-size: 16px;">We are here to help</h4></td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Please contact us if you have any questions at - '.$from_email.' </p>
									</td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Cheers,</p>
									</td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin: 0;font-size: 14px;"><small style="color: #9c9c9c;font-size: 12px;">Powered by SpeakerEngage.com</small></p></td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>';


				if($schedule_option == 'send_later'){
					//tbl_sendlatermaildetails 

					  	$timezonezone = mysqli_real_escape_string($connect, $_POST['timezone']);
					  	
					  	//$schedule_datetime = mysqli_real_escape_string($connect, $_POST['schedule_datetime']);
					  	$schedule_datetime = date("Y-m-d H:i",strtotime(mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));

					    $date = new DateTime();
						$timeZone = $date->getTimezone();
						$servrtz=$timeZone->getName();
						$userTimezone = new DateTimeZone($timezonezone);

						
						$gmtTimezone = new DateTimeZone('GMT');
						//$myDateTime = new DateTime($scheduleddatetime1, $gmtTimezone);
						$myDateTime = new DateTime($schedule_datetime, $gmtTimezone);						
						$offset = $userTimezone->getOffset($myDateTime);					

						$myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');					
						$myDateTime->add($myInterval);
						$result = $myDateTime->format('Y-m-d H:i:s');
						$timestamp = strtotime($schedule_datetime) - ($offset);						
						$scheduledfinalDT = date("Y-m-d H:i:s", $timestamp);					


						 $insert_request = mysqli_query($connect, "INSERT INTO tbl_sendlatermaildetails(speaker_emailid,user_email,scheduleddatetime,template_sub,template_data,username,cc_mailaddress,emailtype,isSent,type,timezone,event_id,user_scheduledtime,speaker_id,template_id,user_id,speaker_manager_id) VALUES ('".$sponsor_email."','".$from_email."','".$scheduledfinalDT."','Collect missing profile information sponsor','".$email_body."','".$loggedin_user_name."','".$sponsor_ex_email."','1','0','missing-document-collect-sponsor','".$timezonezone."','".$sp_event_id."','".$schedule_datetime."','".$info_modal_speakerid."','0','".$loggedin_userid."','".$sponsor_ex_email."') ");		


				}else{

					//*** send now*********//
					// send email to speaker			   
					if($cc_to_manager == 1){
						$send_email = $common->sendEmail($sponsor_email , $from_email, 'Request for Missing Document Sponsor',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name,$sponsor_ex_email);
					}else{
						$send_email = $common->sendEmail($sponsor_email , $from_email, 'Request for Missing Document Sponsor',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);
					}
					$calculate_template_usage_func = $common->calculate_template_usage(9999,$event_id,2);
					$type_update = $common->calculate_sponsor_type_count($event_id);
					// update email count
					$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_sponsors` WHERE `id` = '".$info_modal_speakerid."' ");
					$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
					$spk_email_count = $res_spk_email_count['mail_sent_count'];
					$new_count = $spk_email_count+ 1;
					$update_spk_email_count = mysqli_query($connect,"UPDATE `all_sponsors` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$info_modal_speakerid."' ");

					//*********** all_event_email_count
					$fetch_event_email_count = mysqli_query($connect,"SELECT sponsor_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
					$res_email_count = mysqli_fetch_array($fetch_event_email_count);
					$total_email_count = $res_email_count['sponsor_email_count'];
					$new_total_count = $total_email_count + 1;
					$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `sponsor_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

				}		    

			header('Location:../all-sponsors.php?eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'&request-success'); 

			
			break;

		case "send_email_notify_EP":
			$template_data1 = $_POST['template_data'];			
			
			if(strpos($template_data, $site_url)==false){				
				$template_data1 = str_replace("images/",$site_url."/images/",$_POST['template_data']);
			}
			
			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
		   	$template_subject =  $_POST['template_subject'];
		   	$template_id = mysqli_real_escape_string($connect, $_POST['template_id']);
		   	$EP_id = mysqli_real_escape_string($connect, $_POST['EP_id']);
		   	$SP_id = mysqli_real_escape_string($connect, $_POST['SP_id']);
		   	$speaker_manager_email = mysqli_real_escape_string($connect, trim($_POST['speaker_manager_email']));
		   //	$cc_mails = trim($_POST['cc_emails']);

		   	$loggedin_user_id = $_SESSION['user_id'];
		   	$loggedin_user_data = mysqli_query($connect,"SELECT first_name FROM all_users WHERE user_id = '$loggedin_user_id' ");
		   	$res_loggedin_user = mysqli_fetch_array($loggedin_user_data);
		   	$loggedin_user_name = $res_loggedin_user['first_name'];
			
			 $spaekers_id_array = explode(",",$SP_id);

                foreach ($spaekers_id_array as $speaker_id) { 
                   	$speaker_sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM all_speakers WHERE id=".$speaker_id));	
					$arr = explode(" ",$speaker_sql['speaker_name']);
					$template_data = str_replace("[person-name]",$arr[0],$template_data1);

				$formatted_manager_email = rtrim($speaker_manager_email,",");
				
				if($formatted_manager_email != '' ){
					$cc_mails = $formatted_manager_email.",".trim($_POST['cc_emails']);
				}else{
					$cc_mails = trim($_POST['cc_emails']);
				}
			
			$insertqry="INSERT INTO all_logs(tanent_id,operation,table_id,table_name,other_column_name,other_column_value,created_by,sql_qry,cc_emails,email_subject,email_content,speaker_manager_email,event_id,event_presentation_id) VALUES ('".$session_tanent_id."','sent email to speaker Event Presentation','".$speaker_id."','all_speakers','template_id','".$template_id."','".$id_user."','','".$_POST['cc_emails']."','".mysqli_real_escape_string($connect,$template_subject)."','".mysqli_real_escape_string($connect, $template_data)."','".$speaker_manager_email."','".$event_id."','".$EP_id."')";
			mysqli_query($connect,$insertqry);

			$last_insert_id = mysqli_insert_id($connect);

			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Notify-Event Agenda','".$speaker_id."','".$loggedin_user_id."',now(),\"".$insertqry."\")");


			// send mail to speaker
			$email = $common->sendEmail($speaker_sql['email_id'], $user_email, $template_subject, $template_data."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name,$cc_mails);
			// update email count
				$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_speakers` WHERE `id` = '".$speaker_id."' ");
				$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
				$spk_email_count = $res_spk_email_count['mail_sent_count'];
				$new_count = $spk_email_count+ 1;
				$update_spk_email_count = mysqli_query($connect,"UPDATE `all_speakers` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$speaker_id."' ");

				//*********** all_event_email_count
				$fetch_event_email_count = mysqli_query($connect,"SELECT speaker_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
				$res_email_count = mysqli_fetch_array($fetch_event_email_count);
				$total_email_count = $res_email_count['speaker_email_count'];
				$new_total_count = $total_email_count + 1;
				$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `speaker_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

				$fetch_email_count_event_presentation = mysqli_query($connect,"SELECT total_email_sent FROM `event_presentation` WHERE `ep_id` = '".$EP_id."' ");
				$res_ep_email_count = mysqli_fetch_array($fetch_email_count_event_presentation);
				$ep_email_count = $res_ep_email_count['total_email_sent'];
				$new_ep_email_count = $ep_email_count+ 1;
				$update_spk_email_count = mysqli_query($connect,"UPDATE `event_presentation` SET `total_email_sent` = '".$new_ep_email_count."' WHERE `ep_id` = '".$EP_id."' ");
			 }

			 $calculate_template_usage_func = $common->calculate_template_usage($template_id,$event_id,1);
			 $calculate_speaker_type_count = $common->calculate_speaker_type_count($event_id);

			header('Location:../notify-event-presenation.php?id='.base64_encode($EP_id).'&mail-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));
		break;

		case "Request_EP_form_submit":

			$event_id = mysqli_real_escape_string($connect, $_POST['evt_id']); 
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$multiselect_all_section =  implode(',', $_POST['multiselect_all_section']);			
			$info_modal_epid = mysqli_real_escape_string($connect, $_POST['info_modal_epid']);
			
			$info_manager_cc = mysqli_real_escape_string($connect, $_POST['info_manager_cc']);

			$info_msg = mysqli_real_escape_string($connect, $_POST['info_msg']);
			$info_msg = str_replace('\n', "\n", $info_msg);
			$info_msg = str_replace('\r', "\r", $info_msg);
			$speakers_id_array = explode(",",$multiselect_all_section);

			//$token = md5($info_modal_epid);
			$token = $info_modal_epid;
			$loggedin_user_id = $_SESSION['user_id'];			

			$cc_to_manager = 0;

		    if($info_manager_cc == 'yes'){
		    	$cc_to_manager = 1;
		    }

		    // fetch loggedin user details
		    $user_details = $common->get_user_details_by_id($loggedin_userid); 
		     $loggedin_user_name = $user_details[0]['first_name'];

		     //loggedin_user_email 
		    // $from_email = $user_details[0]['email']; 
		     $from_email=$_SESSION['user_email'];

		      foreach ($speakers_id_array as $speaker_id) { 
		    // fetch_speaker details
		    $fetch_speaker_details = mysqli_query($connect,"SELECT * FROM `all_speakers` WHERE `id` = '$speaker_id' ");
			if(mysqli_num_rows($fetch_speaker_details) > 0){
				$res_sp = mysqli_fetch_array($fetch_speaker_details);
				$speaker_email = $res_sp['email_id'];
				$speaker_name = $res_sp['speaker_name'];
				$speaker_manager_email = $res_sp['speaker_manager_email'];
				$sp_event_id = $res_sp['event_id'];
			}

			$fetch_event_data = mysqli_query($connect, "SELECT * FROM `all_events` WHERE `id` = '$sp_event_id' ");
			if(mysqli_num_rows($fetch_event_data) > 0){
				$res_event = mysqli_fetch_array($fetch_event_data);
				$event_email_banner = $res_event['event_email_banner'];
			}

			$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
			$res_site_details = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_details['value'];

			//var_dump($res_site_details); exit();

			if($event_email_banner != null || $event_email_banner != '' ){

				$email_banner = $site_url.'/images/event_email_banner/'.$event_email_banner;
			}else{
				$email_banner = $site_url.'/images/NoPath.jpg';
			}
	

		    $sql =  "Send request for filling Event Presentation Details";

		   mysqli_query($connect, "INSERT INTO all_logs(tanent_id,operation,table_name,created_by,sql_qry,table_id,event_id,event_presentation_id) VALUES ('".$session_tanent_id."','Request for Update Agenda','information_collect_update_agenda','".$loggedin_user_id."',\"".$sql."\",'".$speaker_id."','".$event_id."','".$info_modal_epid."')"); 
		     $last_insert_id = mysqli_insert_id($connect);


		    $dynamic_link = $site_url."/collect-event-presentation-info.php?tk=".base64_encode($token)."&sp=". base64_encode($speaker_id);

		    $email_body = '<table cellspacing="0" cellpadding="0" width="500" align="center" style="border: 1px solid #f1f1f1;">
					<tr>
						<td>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
								<tr>
									<td><img src="https://www.speakerengage.com/images/main-logo.png" width="100" alt="Speaker Engage" /></td>
								</tr>
							</table>
							<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><img src="'.$email_banner.'" width="500" alt="Speaker Engage" /></td>
								</tr>
							</table>

							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin-bottom: 0;margin-top: 10px;font-size: 14px;">Hi <span style="font-weight: 600;">'.$speaker_name.'</span>,</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;">'.$info_msg.'</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;padding-bottom:5px;">Simply click on the button to take action:</p></td>
								</tr>

								
							</table>
							<table cellpadding="5" cellspacing="0" width="150px" bgcolor="" style="margin-left: 5px;cursor:pointer;">
								<tr>
									<td align="center" width="150" height="40" bgcolor="#007DB7" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;cursor:pointer;">
								            <a href="'.$dynamic_link.'" style="color: #ffffff; font-size:16px; font-weight: bold; font-family:sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">
								                Take Action
								            </a>
								        </td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><h4 style="color: #007DB7;margin-bottom: 0px;margin-top: 10px;font-size: 16px;">We are here to help</h4></td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Please contact us if you have any questions at - '.$from_email.' </p>
									</td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Cheers,</p>
									</td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin: 0;font-size: 14px;"><small style="color: #9c9c9c;font-size: 12px;">Powered by SpeakerEngage.com</small></p></td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>';

				  mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Missing Info-Event Agenda','".$speaker_id."','".$loggedin_user_id."',now(),\"".mysqli_real_escape_string($connect,$email_body)."\")");

					//*** send now*********//
					// send email to speaker			   
					if($cc_to_manager == 1){
						$send_email = $common->sendEmail($speaker_email , $from_email, 'Request to Update Agenda',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name,$speaker_manager_email);
					}else{
						$send_email = $common->sendEmail($speaker_email , $from_email, 'Request to Update Agenda',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);
					}	

					// update email count
				$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_speakers` WHERE `id` = '".$speaker_id."' ");
				$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
				$spk_email_count = $res_spk_email_count['mail_sent_count'];
				$new_count = $spk_email_count+ 1;
				$update_spk_email_count = mysqli_query($connect,"UPDATE `all_speakers` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$speaker_id."' ");



				//*********** all_event_email_count
				$fetch_event_email_count = mysqli_query($connect,"SELECT speaker_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
				$res_email_count = mysqli_fetch_array($fetch_event_email_count);
				$total_email_count = $res_email_count['speaker_email_count'];
				$new_total_count = $total_email_count + 1;
				$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `speaker_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");	


				$fetch_email_count_event_presentation = mysqli_query($connect,"SELECT total_email_sent FROM `event_presentation` WHERE `ep_id` = '".$info_modal_epid."' ");
				$res_ep_email_count = mysqli_fetch_array($fetch_email_count_event_presentation);
				$ep_email_count = $res_ep_email_count['total_email_sent'];
				$new_ep_email_count = $ep_email_count+ 1;
				$update_spk_email_count = mysqli_query($connect,"UPDATE `event_presentation` SET `total_email_sent` = '".$new_ep_email_count."' WHERE `ep_id` = '".$info_modal_epid."' ");    
			}
			header('Location:../all_presentation.php?request-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999))); 
		break;

		case "request_info_event_presentation":

			//$event_id = $_SESSION['current_event_id'];
			//$p_topic = mysqli_real_escape_string($connect, $_POST['p_topic']);
			//$opportunity_type = mysqli_real_escape_string($connect, $_POST['opportunity_type']);
			//$location = mysqli_real_escape_string($connect, $_POST['location']);
			$abstract = mysqli_real_escape_string($connect, $_POST['abstract']);			
			//$start_time = mysqli_real_escape_string($connect, $_POST['start_time']);
			//$end_time = mysqli_real_escape_string($connect, $_POST['end_time']);
			//$topic_owner = mysqli_real_escape_string($connect, $_POST['topic_owner']);
			$bussiness_objective = mysqli_real_escape_string($connect, $_POST['bussiness_objective']);
			$loggedin_userid = mysqli_real_escape_string($connect, $_POST['loggedin_userid']);	
			$uid = mysqli_real_escape_string($connect, $_POST['uid']);	
			//$event_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['event_date'])));
			$tk = trim($_POST['token']);

			$speakers_data = mysqli_query($connect,"select group_concat(speaker_id) as speakers_id from event_agenda_speakers where event_agenda_speakers.ep_id = '".$uid."' ");
			if(mysqli_num_rows($speakers_data) > 0)
       		{  
			   	$res = mysqli_fetch_array($speakers_data);
			   //	var_dump($speakers_list);exit(); 
			   	$speaker_list_res = $res['speakers_id'];
			   	if($speaker_list_res != "")
			   	{
			   		if(trim($speakers_list) != "" ){
			   			$speakers_list=$speaker_list_res . "," . $speakers_list;
			   		}else{
			   			$speakers_list=$speaker_list_res ;
			   		}
					
				}
			}

			mysqli_query($connect, "UPDATE event_presentation  SET abstract='".$abstract."',business_objective='".$bussiness_objective."' WHERE ep_id=".$uid); 
			// mysqli_query($connect, "UPDATE event_presentation  SET presentation_topic='".$p_topic."',opportunity_type='".$opportunity_type."',location='".$location."', abstract='".$abstract."',start_time='".$start_time."',end_time='".$end_time."',topic_owner='".$topic_owner."',business_objective='".$bussiness_objective."',event_date='".$event_date."' WHERE ep_id=".$uid); 
			header('Location: ../collect-event-presentation-info.php?tk='.base64_encode($tk).'&sp='. base64_encode($loggedin_userid).'&info-collect-success');
		break;

        case "admin_add_user":

            $name = mysqli_real_escape_string($connect, $_POST['person_name']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            // $country_code = mysqli_real_escape_string($connect, $_POST['ccode']);
            // $middle_number = mysqli_real_escape_string($connect, $_POST['pmiddleno']);
            $phone_number = mysqli_real_escape_string($connect, $_POST['plastno']);
            $roleid = mysqli_real_escape_string($connect, $_POST['role']);
            $organization_name = mysqli_real_escape_string($connect, $_POST['organization_name']);
            //$passowrd_origin = mysqli_real_escape_string($connect, $_POST['myPassword']);
            $passowrd_origin = mysqli_real_escape_string($connect, $_POST['password']);
            $linkedin_url = mysqli_real_escape_string($connect, $_POST['linkedinurl']);
            $event_arr = implode(',',$_POST['event_arr']);
            $manage_notification = mysqli_real_escape_string($connect, implode(",",$_POST['manage_notification']));

			$logged_in_user= $_SESSION['user_id'];
			$session_tanent_id=  $common->get_tenant_id_from_userid($logged_in_user);

			//****** fetch subscription details
			$fetch_user_details = mysqli_query($connect,"SELECT * FROM `all_users` WHERE `user_id` = '".$logged_in_user."' ");
			$res_user_d = mysqli_fetch_array($fetch_user_details);
			$subscription_id = $res_user_d['subscription_id'];
			$customer_id = $res_user_d['customer_id'];
			$subscription_status = $res_user_d['subscription_status'];


            $roleidquery = mysqli_query($connect,"SELECT Rolename FROM all_role WHERE roleid=".$roleid);
            while($rowres = mysqli_fetch_array($roleidquery)){
                $Rolename = $rowres['Rolename'];
            }

            $enc_pwd = password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 11]);
            $d=strtotime("now");
            $updated_date = date("Y-m-d h:i:s", $d);

            $directoryName="../images/user_images/";
            $profile_pic = '';
            if($_POST['image_src']) {

                $file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
                $profile_pic=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
                list($type, $file) = explode(';', $file);
                list(, $file)      = explode(',', $file);
                file_put_contents($directoryName.$profile_pic , base64_decode($file));

            }

         /*   $content = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000000">
			<div style="width:680px">
			  <p style="margin-top:0px;margin-bottom:15">Dear '.$name.', <br></p>
			  <p style="margin-top:0px;margin-bottom:15px">Welcome to Speaker Engage!</p>
			  <p style="margin-top:0px;margin-bottom:15px">You can login to our website using your email address and password by visiting this URL:</p>
			  <p style="margin-top:0px;margin-bottom:15px"><a href="'.$site_url.'" target="_blank" >'.$site_url.'</a></p>
			  <p style="margin-top:0px;margin-bottom:15px">User Name: '.$email.'</p>
			  <p style="margin-top:0px;margin-bottom:15px">Password: '.$passowrd_origin.'</p>
			  <p style="margin-top:0px;margin-bottom:15px"><br><br>Thanks,<br>
			Speaker Engage Team</p>
			</div>
			</div>';*/

			$content = '<table bgcolor="#F1F1F1" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table valign="center" cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
                    <tr valign="center">
                        <td valign="center" style="padding-top: 25px;padding-bottom: 20px;"><img src="'.$site_url.'/images/main-logo.png" width="150" alt="Speaker Engage" /></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" style="padding-top:40px; padding-bottom:40px;">

                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" width="600" align="center" border="0">
                                            <tr>
                                                <td>

                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 20px;font-size: 18px;">Dear '.$name.',</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 0px;font-size: 18px;">Welcome to Speaker Engage!</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">You can login to our website using your email address and password by visiting this URL: <a href="'.$site_url.'" target="_blank" >'.$site_url.'</a></p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">User Name: '.$email.'

																</p>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">Password: '.$passowrd_origin.'
																</p>
                                                            </td>
                                                        </tr>



                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">Happy Organizing!

																</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">The Speaker Engage Team

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="height: 20px;"></td>
                                                        </tr>

                                                    </table>
                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="#e2e2e2">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin: 0;"><small style="color: #8a8888;font-size: 12px;">Powered by <a href="https://www.speakerengage.com/" style="color: #8a8888;font-size: 12px;text-decoration: none;"> SpeakerEngage.com</a></small></p>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';
			

            

            $insert_qry="INSERT INTO  all_users(tanent_id,first_name, email_notification,phone_number, email, confirmcode, organization_name, password, role,roleid, profile_pic, event_id,linkedin_url,countrycode,phone_middle_no,phone_last_no,subscription_id,customer_id,subscription_status,is_logged_in) VALUES ('".$session_tanent_id."','".$name."','".$manage_notification."', '".$phone_number."', '".$email."', 'y', '".$organization_name."', '".$enc_pwd."', '".$Rolename."', '".$roleid."', '".$profile_pic."', '".$event_arr."','".$linkedin_url."','".$country_code."','".$middle_number."','".$last_number."','".$subscription_id."','".$customer_id."','".$subscription_status."','1')";
            mysqli_query($connect,$insert_qry);
			$last_insert_id = mysqli_insert_id($connect);
			$common->sendEmail($email, $user_email, "Account Created - Speaker Engage", $content);

            mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','0','Create user','".$last_insert_id."','".$logged_in_user."',now(),\"".$insert_qry."\")");

            header('Location:../admin-user-management.php?created-success');

            break;


    //*************************************//
		case "send_daily_update_notification2":

		$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
			$res_site_details = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_details['value'];

		$fetch_admins = mysqli_query($connect, "SELECT * FROM `all_users` WHERE `roleid` = 1 and `user_id` = '31' and email= 'anweshan.p@iverbinden.com' ");

		//$fetch_admins = mysqli_query($connect, "SELECT * FROM `all_users` WHERE `roleid` = 1 and `user_id` = '59' and email= 'prajnas.work@gmail.com' ");

		if(mysqli_num_rows($fetch_admins) > 0){

			while($res_ad = mysqli_fetch_array($fetch_admins)) {

				$user_id = $res_ad['user_id'];
				$admin_email = $res_ad['email'];
				$user_name = $res_ad['first_name'];


		$fetch_admin_details = mysqli_query($connect, "SELECT event_id FROM `all_users` WHERE `roleid` = 1 AND user_id = '".$user_id."' ");
		if(mysqli_num_rows($fetch_admin_details) > 0){

			while($res_admin = mysqli_fetch_array($fetch_admin_details)) {

				$events_array = explode(",",$res_admin['event_id']);
				if(count($events_array) > 0){				
				 
				foreach ($events_array as $event) {
					$event_id = $event;			

	
			//*****************fetch all counts
		$fetch_event_data = mysqli_query($connect, "SELECT * FROM `all_events` WHERE `id` = '".$event_id."' AND date(event_end_date) >= date(now())");
		//var_dump("SELECT * FROM `all_events` WHERE `id` = '".$event_id."' AND date(event_end_date) <= date(now())"); exit();

			if(mysqli_num_rows($fetch_event_data) > 0)
			{
				$res_event = mysqli_fetch_array($fetch_event_data);
				$event_name = $res_event['event_name'];
			

		  $today_date = date("d-M-Y");

		  // ****************  NEW Functions   **************************//
		  $total_campaign = $common->get_daily_email_campaign_daily_notification($event_id);
		  //var_dump($total_campaign); exit();

		  //************* Resource addded today
		   $total_resource_today = $common->get_all_resource_added_today_daily_notification($event_id);

		  // **************** End of NEW Functions   **************************//

		  $total_speaker = $common->get_count_all_total_speakers_daily_notification($event_id);
		   $newly_added_speaker  = $common->get_newly_added_speakers_daily_notification($event_id);
		  // $newly_deleted_speaker = $common->get_newly_deleted_speakers_daily_notification($event_id);


		  $total_sponsor = $common->get_count_all_total_sponsors_daily_notification($event_id);
		   $newly_added_sponsors = $common->get_newly_added_sponsors_daily_notification($event_id); 
		  // $newly_deleted_sponsors = $common->get_newly_deleted_sponsors_daily_notification($event_id); 

		  
		  $total_master = $common->get_count_all_total_masters_daily_notification($event_id);
		   $newly_added_master = $common->get_newly_added_masters_daily_notification($event_id); 
		  //  $newly_deleted_master = $common->get_newly_deleted_masters_daily_notification($event_id); 
		  // $total_mail_sent = $common->get_count_all_total_mail_sent($event_id);
		  // $today_mail_sent = $common->get_count_today_mail_sent($event_id);

		  //******** Action section

		  //$fetch_today_action = $common->get_action_of_the_day($event_id); 


		  

		    $resource_html = '';
		  if(count($total_resource_today) > 0){

		    foreach ($total_resource_today as $resource_today) {

		       $resource_html .= '<tr>
					     <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
					      '.$resource_today['resource'].'
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
					         '.$resource_today['category_name'].'
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;"><a href="'.$resource_today['url'].'">'.$resource_today['url'].'</a>
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
					          '.$resource_today['created_by_name'].'
					      </td>
					     
					</tr>';    
		    }
		  }else{
		  	$resource_html ='<tr align="left" ><td colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">No Resources has been added today!</td></tr>';
		  }



		  //**********  daily email template data binding **********//
		  $daily_campaign_html = '';
		  if(count($total_campaign) > 0){
		  	foreach ($total_campaign as $campaign) {
		  		$daily_campaign_html .= '<tr>
					<td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
					          '.$campaign['template_name'].'
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
					           '.$campaign['audience'].'
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
					        '.$campaign['template_used'].'
					      </td>    
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
					           '.$campaign['email_read'].'
					      </td>
					      
					</tr>';

		  	}

		  }else{
		  	$daily_campaign_html ='<tr align="left" ><td colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">No campaign has been sent today!</td></tr>';
		  }
		

		 $email_body = '<table cellspacing="0" cellpadding="0" width="700" align="center" style="border: 1px solid #f1f1f1;">
<tr>
<td>
<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: url('.$site_url.'/images/Banner_ab-01.jpg) center center no-repeat;background-size: cover;padding-top:10px; ">

<tr>
	<td align="center">
		<table cellpadding="5" cellspacing="0" width="100%";>
			<tr>
				<td style="width:20%;"><img src="'.$site_url.'/images/main-logo.png" width="180" alt="Speaker Engage" style="margin-top: 5px;margin-bottom:0px;"/>
				</td>
				<td style="width:70%;">
				   <h2 style="text-align: left;color: #fff;font-size: 36px;font-weight: 600;margin-top: 25px;margin-bottom: 0px;padding-left:45px;">
				     Hi '.$user_name.'!
				   </h2>
				</td>  
			</tr>   
		</table>   
	   <h3 style="text-align: center;color: #fff !important;font-size: 16px;font-weight: 400;margin-top: 10px;">Here is a quick summary of activities on your Speaker Engage for the last 24 hours!</h3>
	   <hr style="width: 200px;height: 1px;border: 0px;background:rgba(255, 255, 255, 0.7098039215686275);margin-top: 15px;opacity: 0.4;margin-bottom: 30px;" />
	</td>
<tr>
	<td style="padding:0px;">
		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="" style="background: rgba(0, 0, 0, 0.43);color: #fff;padding: 5px 0px;">
			<tr>
			<td align="left" style="padding: 10px;">
			          '.strtoupper($event_name).'</b>
			      </td>
			      <td align="right" style="padding: 10px;">
			          '.$today_date.'
			      </td>
			</tr>
		</table>
	</td>
</tr> 
</tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
 <tr>
<td align="left" colspan="6" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ffff;font-size: 22px;color: #b51d55;">

<table>
<tr>
<td valign="center" style="height: 40px;"><img src="'.$site_url.'/images/mail1.png" width="40" alt="Speaker Engage" style="margin-top: 5px;"/></td>
<td valign="center" style="height: 40px;">
<span style="font-weight: 600;padding-left: 10px;color: #db0566;font-size:24px;">Email Campaigns</span>
</td>
</tr>
</table>
         
     </td>
</tr>
 <tr>
   <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;">Email Subject</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;">Audience</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;"># Sent</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;"># Opened </th>
   
 </tr>
'.$daily_campaign_html.'

</table>


<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
<tr>
<td align="left" colspan="6" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ffff;font-size: 22px;color: #b51d55;padding-top: 10px;">

<table>
<tr>
<td valign="center" style="height: 40px;"><img src="'.$site_url.'/images/Asset2.png" width="30" alt="Speaker Engage" style="margin-top: 5px;"/></td>
<td valign="center" style="height: 40px;">
<span style="font-weight: 600;padding-left: 10px;color: #db0566;font-size:24px;">Contact Summary</span>
</td>
</tr>
</table>
         
     </td>
</tr>
<tr>
   <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;width: 33.33%;">Contact Type</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 33.33%;">Current Total</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 33.33%;">New</th>
 </tr>


<tr>
     <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
          Speakers
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
          '.$total_speaker.'
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: #222;">
           '.$newly_added_speaker.'
      </td>
     
</tr>

<tr>
     <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
      Sponsors
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
         '.$total_sponsor.'
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: #222;">
         '.$newly_added_sponsors.'
      </td>
     
</tr>

<tr>
     <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
      Masters
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
        '.$total_master.'
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: #222;">
         '.$newly_added_master.'
      </td>
     
</tr>


</table>


<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
 <tr>
<td align="left" colspan="6" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ffff;font-size: 22px;color: #b51d55;padding-top: 10px;">

<table>
<tr>
<td valign="center" style="height: 40px;"><img src="'.$site_url.'/images/Asset3.png" width="35" alt="Speaker Engage" style="margin-top: 5px;"/></td>
<td valign="center" style="height: 40px;">
<span style="font-weight: 600;padding-left: 10px;color: #db0566;font-size:24px;">Resources Added</span>
</td>
</tr>
</table>
         
     </td>
</tr>
 <tr>
   <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;">Resource Name</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;"> Resource Category</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;">URL</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;">Added By </th>
 </tr>

'.$resource_html.'

<tr>
	<td>
		<tr align="left">
			<td colspan="4" style="padding-top: 50px;padding-bottom: 45px;border-bottom: 1px solid #d7d8da;background: #fff;color:rgba(0, 0, 0, 0.66);text-align:center;">
				<a href="'.$site_url.'/login.php" style="background-color:#0281a2;padding:10px;color:#fff;text-decoration:none;border-radius:6px;font-size:14px;">Login to Speaker Engage</a>
			</td>
		</tr>
	</td>				
</tr>

<tr>
	<td>
		<tr align="left"><td colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color:rgba(0, 0, 0, 0.66);">Powered by SpeakerEngage.com</td>
		</tr>
	</td>						
</tr>
</table>
		';

		//var_dump($email_body); exit(); 
		//*******************
		

			$email_header = "Speaker Engage : Activity notification for ".$event_name;

		     mysqli_query($connect, "INSERT INTO all_crud_logs(event_id,operation,created_at) VALUES ('".$event_id."','daily update notification',now())");
		    //  $admin_email = "vinay@iverbinden.com"; 

		    $send_email = $common->sendEmail($admin_email , 'noreply@speakerengage.com', $email_header,$email_body,'Speaker Engage Team');

			} // fetch_event_data

		} //end of foreach

	} // end of if(count($events_array) > 0)



	} //end of while
		} //end of if(mysqli_num_rows($fetch_admin_details) > 0)


	} // first while
} //first if
				
		header('Location: ../trigger_daily_update_notification.php');
		 break;
        //*************************************//
		case "send_daily_update_notification":

		//var_dump($_SESSION); exit();

		$fetch_admins = mysqli_query($connect, "SELECT * FROM `all_users` WHERE `roleid` = 1 ");

		if(mysqli_num_rows($fetch_admins) > 0){

			while($res_ad = mysqli_fetch_array($fetch_admins)) {

				$user_id = $res_ad['user_id'];
				$admin_email = $res_ad['email'];


		$fetch_admin_details = mysqli_query($connect, "SELECT event_id FROM `all_users` WHERE `roleid` = 1 AND user_id = '".$user_id."' ");
		if(mysqli_num_rows($fetch_admin_details) > 0){

			while($res_admin = mysqli_fetch_array($fetch_admin_details)) {

				$events_array = explode(",",$res_admin['event_id']);
				if(count($events_array) > 0){				
				 
				foreach ($events_array as $event) {
					$event_id = $event;			

	

		//$event_id = $_SESSION['current_event_id'];
			//*****************fetch all counts
		$fetch_event_data = mysqli_query($connect, "SELECT * FROM `all_events` WHERE `id` = '".$event_id."' ");
			if(mysqli_num_rows($fetch_event_data) > 0){
				$res_event = mysqli_fetch_array($fetch_event_data);
				$event_name = $res_event['event_name'];
			}

		  $today_date = date("d-M-Y");

		  $total_speaker = $common->get_count_all_total_speakers_daily_notification($event_id);
		  $newly_added_speaker  = $common->get_newly_added_speakers_daily_notification($event_id);
		  $newly_deleted_speaker = $common->get_newly_deleted_speakers_daily_notification($event_id);


		  $newly_added_speaker_html = '';
		  $newly_deleted_speaker_html = '';

		  if($newly_added_speaker >= 0){
		    $newly_added_speaker_html = '<span style="color:green;">'.$newly_added_speaker.'</span>';
		  }else{
		    $newly_added_speaker_html = '<span style="color:red;">'.$newly_added_speaker.'</span>';
		  }

		  if($newly_deleted_speaker >= 0){
		    $newly_deleted_speaker_html = '<span style="color:green;">'.$newly_deleted_speaker.'</span>';
		  }else{
		    $newly_deleted_speaker_html = '<span style="color:red;">'.$newly_deleted_speaker.'</span>';
		  }


		  $total_sponsor = $common->get_count_all_total_sponsors_daily_notification($event_id);
		  $newly_added_sponsors = $common->get_newly_added_sponsors_daily_notification($event_id); 
		  $newly_deleted_sponsors = $common->get_newly_deleted_sponsors_daily_notification($event_id); 

		  $newly_added_sponsor_html = '';
		  $newly_deleted_sponsor_html = '';

		    if($newly_added_sponsors >= 0){
		    $newly_added_sponsor_html = '<span style="color:green;">'.$newly_added_sponsors.'</span>';
		  }else{
		    $newly_added_sponsor_html = '<span style="color:red;">'.$newly_added_sponsors.'</span>';
		  }

		   if($newly_deleted_sponsors >= 0){
		    $newly_deleted_sponsor_html = '<span style="color:green;">'.$newly_deleted_sponsors.'</span>';
		  }else{
		    $newly_deleted_sponsor_html = '<span style="color:red;">'.$newly_deleted_sponsors.'</span>';
		  }

		  $total_master = $common->get_count_all_total_masters_daily_notification($event_id);
		  $newly_added_master = $common->get_newly_added_masters_daily_notification($event_id); 
		   $newly_deleted_master = $common->get_newly_deleted_masters_daily_notification($event_id); 

		    $newly_added_master_html = '';
		    $newly_deleted_master_html = '';

		    if($newly_added_master >= 0){
		    $newly_added_master_html = '<span style="color:green;">'.$newly_added_master.'</span>';
		  }else{
		    $newly_added_master_html = '<span style="color:red;">'.$newly_added_master.'</span>';
		  }

		  if($newly_deleted_master >= 0){
		    $newly_deleted_master_html = '<span style="color:green;">'.$newly_deleted_master.'</span>';
		  }else{
		    $newly_deleted_master_html = '<span style="color:red;">'.$newly_deleted_master.'</span>';
		  }


		  $total_mail_sent = $common->get_count_all_total_mail_sent($event_id);
		  $today_mail_sent = $common->get_count_today_mail_sent($event_id); 



		  //******** Action section

		  $fetch_today_action = $common->get_action_of_the_day($event_id); 


		  //************* speaker details
		    $total_speaker_without_mobile = $common->get_total_count_speakers_with_no_mobile($event_id); 
		    $total_speaker_without_mobile_percentage = $common->get_total_percentage_speakers_with_no_mobile($event_id);

		    // $event_id = 50;
		    // var_dump($total_speaker_without_mobile_percentage); exit();
		    $total_speaker_without_mobile_percentage_html = '';

		    if($total_speaker_without_mobile_percentage >= 0 && $total_speaker_without_mobile_percentage <= 20){
		      $total_speaker_without_mobile_percentage_html = '<span style="color:green">'.$total_speaker_without_mobile_percentage.'</span>';
		    }else if($total_speaker_without_mobile_percentage > 20 && $total_speaker_without_mobile_percentage <= 40){
		      $total_speaker_without_mobile_percentage_html = '<span style="color:#d9c90f;">'.$total_speaker_without_mobile_percentage.'</span>';      
		    }else{
		      $total_speaker_without_mobile_percentage_html = '<span style="color:red;">'.$total_speaker_without_mobile_percentage.'</span>';
		    }


		    $total_speaker_without_linkedin = $common->get_total_count_speakers_with_no_linked_handles($event_id); 
		    $total_speaker_without_linkedin_percentage = $common->get_total_percentage_speakers_with_no_linked_handles($event_id);

		    $total_speaker_without_linkedin_percentage_html = '';
		    if($total_speaker_without_linkedin_percentage >= 0 && $total_speaker_without_linkedin_percentage <= 20){
		      $total_speaker_without_linkedin_percentage_html = '<span style="color:green">'.$total_speaker_without_linkedin_percentage.'</span>';
		    }else if($total_speaker_without_linkedin_percentage > 20 && $total_speaker_without_linkedin_percentage <= 40){
		      $total_speaker_without_linkedin_percentage_html = '<span style="color:#d9c90f;">'.$total_speaker_without_linkedin_percentage.'</span>';      
		    }else{
		      $total_speaker_without_linkedin_percentage_html = '<span style="color:red;">'.$total_speaker_without_linkedin_percentage.'</span>';
		    }

		    //*** bio 
		    $total_speaker_without_bio = $common->get_total_count_speakers_with_no_bio($event_id); 
		    $total_speaker_without_bio_percentage = $common->get_total_percentage_speakers_with_no_bio($event_id);

		    $total_speaker_without_bio_percentage_html = ''; 

		    if($total_speaker_without_bio_percentage >= 0 && $total_speaker_without_bio_percentage <= 20){
		      $total_speaker_without_bio_percentage_html = '<span style="color:green">'.$total_speaker_without_bio_percentage.'</span>';
		    }else if($total_speaker_without_bio_percentage > 20 && $total_speaker_without_bio_percentage <= 40){
		      $total_speaker_without_bio_percentage_html = '<span style="color:#d9c90f;">'.$total_speaker_without_bio_percentage.'</span>';      
		    }else{
		      $total_speaker_without_bio_percentage_html = '<span style="color:red;">'.$total_speaker_without_bio_percentage.'</span>';
		    }


		    //*** headshots 
		    $total_speaker_without_headshot = $common->get_total_count_speakers_with_no_headshot($event_id); 
		    $total_speaker_without_headshot_percentage = $common->get_total_percentage_speakers_with_no_headshot($event_id);

		    $total_speaker_without_headshot_percentage_html = ''; 

		    if($total_speaker_without_headshot_percentage >= 0 && $total_speaker_without_headshot_percentage <= 20){
		      $total_speaker_without_headshot_percentage_html = '<span style="color:green">'.$total_speaker_without_headshot_percentage.'</span>';
		    }else if($total_speaker_without_headshot_percentage > 20 && $total_speaker_without_headshot_percentage <= 40){
		      $total_speaker_without_headshot_percentage_html = '<span style="color:#d9c90f;">'.$total_speaker_without_headshot_percentage.'</span>';      
		    }else{
		      $total_speaker_without_headshot_percentage_html = '<span style="color:red;">'.$total_speaker_without_headshot_percentage.'</span>';
		    }


		    //********* Sponsor details
		    $total_sponsor_without_logo = $common->get_total_count_sponsors_with_no_logo($event_id);
		    $total_sponsor_without_logo_percentage = $common->get_total_percentage_sponsors_with_no_logo_handles($event_id);

		    $total_sponsor_without_logo_percentage_html = '';
		    if($total_sponsor_without_logo_percentage >= 0 && $total_sponsor_without_logo_percentage <= 20){
		      $total_sponsor_without_logo_percentage_html = '<span style="color:green">'.$total_sponsor_without_logo_percentage.'</span>';
		    }else if($total_sponsor_without_logo_percentage > 20 && $total_sponsor_without_logo_percentage <= 40){
		      $total_sponsor_without_logo_percentage_html = '<span style="color:#d9c90f;">'.$total_sponsor_without_logo_percentage.'</span>';      
		    }else{
		      $total_sponsor_without_logo_percentage_html = '<span style="color:red;">'.$total_sponsor_without_logo_percentage.'</span>';
		    }



		    $total_sponsor_without_contact = $common->get_total_count_sponsors_with_no_contact($event_id);
		    $total_sponsor_without_contact_percentage = $common->get_total_percentage_sponsors_with_no_contact($event_id);

		    $total_sponsor_without_contact_percentage_html = '';
		    if($total_sponsor_without_contact_percentage >= 0 && $total_sponsor_without_contact_percentage <= 20){
		      $total_sponsor_without_contact_percentage_html = '<span style="color:green">'.$total_sponsor_without_contact_percentage.'</span>';
		    }else if($total_sponsor_without_contact_percentage > 20 && $total_sponsor_without_contact_percentage <= 40){
		      $total_sponsor_without_contact_percentage_html = '<span style="color:#d9c90f;">'.$total_sponsor_without_contact_percentage.'</span>';      
		    }else{
		      $total_sponsor_without_contact_percentage_html = '<span style="color:red;">'.$total_sponsor_without_contact_percentage.'</span>';
		    }

		    //******* Master details

		    $total_master_without_company = $common->get_total_count_masters_with_no_company($event_id);
		    $total_master_without_company_percentage = $common->get_total_percentage_master_with_no_company($event_id);

		    $total_master_without_company_percentage_html = '';
		    if($total_master_without_company_percentage >= 0 && $total_master_without_company_percentage <= 20){
		      $total_master_without_company_percentage_html = '<span style="color:green">'.$total_master_without_company_percentage.'</span>';

		    }else if($total_master_without_company_percentage > 20 && $total_master_without_company_percentage <= 40){
		      $total_master_without_company_percentage_html = '<span style="color:#d9c90f;">'.$total_master_without_company_percentage.'</span>';  

		    }else{
		      $total_master_without_company_percentage_html = '<span style="color:red;">'.$total_master_without_company_percentage.'</span>';
		    }

		    
		    $total_master_without_linkedin = $common->get_total_count_masters_with_no_linked_handles($event_id);
		    $total_master_without_linkedin_percentage = $common->get_total_percentage_master_with_no_linked_handles($event_id);

		    $total_master_without_linkedin_percentage_html = '';
		    if($total_master_without_linkedin_percentage >= 0 && $total_master_without_linkedin_percentage <= 20){
		      $total_master_without_linkedin_percentage_html = '<span style="color:green">'.$total_master_without_linkedin_percentage.'</span>';

		    }else if($total_master_without_linkedin_percentage > 20 && $total_master_without_linkedin_percentage <= 40){
		      $total_master_without_linkedin_percentage_html = '<span style="color:#d9c90f;">'.$total_master_without_linkedin_percentage.'</span>';  

		    }else{
		      $total_master_without_linkedin_percentage_html = '<span style="color:red;">'.$total_master_without_linkedin_percentage.'</span>';
		    }

		    //*** phone number
		    $total_master_without_phone = $common->get_total_count_masters_with_no_phone($event_id);
		    $total_master_without_phone_percentage = $common->get_total_percentage_master_with_no_phone($event_id);

		    $total_master_without_phone_percentage_html = '';
		    if($total_master_without_phone_percentage >= 0 && $total_master_without_phone_percentage <= 20){
		      $total_master_without_phone_percentage_html = '<span style="color:green">'.$total_master_without_phone_percentage.'</span>';

		    }else if($total_master_without_phone_percentage > 20 && $total_master_without_phone_percentage <= 40){
		      $total_master_without_phone_percentage_html = '<span style="color:#d9c90f;">'.$total_master_without_phone_percentage.'</span>';  

		    }else{
		      $total_master_without_phone_percentage_html = '<span style="color:red;">'.$total_master_without_phone_percentage.'</span>';
		    }

		    
		    $action_html = '';
		  if(count($fetch_today_action) > 0){

		    foreach ($fetch_today_action as $action_today) {

		       $action_html .= '<tr>
		                    <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		                         '.$action_today['action'].'
		                     </td>
		                     <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		                          '.$action_today['assign_to'].'
		                     </td>
		                     <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		                        '.$action_today['action_category_name'].'
		                     </td>
		                     <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		                         '.$action_today['status'].'
		                     </td>
		              </tr>';    
		    }
		  }else{
		  	$action_html ='<tr align="left" ><td colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">No actions found for today!</td></tr>';
		  }

		 $email_body = '
		<table cellspacing="0" cellpadding="0" width="700" align="center" style="border: 1px solid #f1f1f1;">
		<tr>
		<td>
		<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: url(https://www.speakerengage.com/images/Banner_ab-01.jpg) center center no-repeat;background-size: cover ">
		<tr>
		<td ><img src="https://www.speakerengage.com/images/main-logo.png" width="150" alt="Speaker Engage" style="margin-top: 20px;margin-bottom: 30px;"/></td>
		</tr>
		<tr>
		  <td align="center">
		    <h2 style="text-align: center;color: #fff;font-size: 36px;font-weight: 600;margin-top: 0px;">
		      Your Daily Activity at Glance for
		    </h2>
		    <h3 style="text-align: center;color: #fff !important;font-size: 30px;font-weight: 600;margin-top: 0px;">'.$event_name.'</h3>
		    <hr style="width: 200px;height: 1px;border: 0px;background: #fff;margin-top: 15px;opacity: 0.4;margin-bottom: 50px;" />
		  </td>
		</tr>
		</table>

		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="" style="background: #222;color: #fff;">
		<tr>
		<td align="left" style="padding: 10px;">
		           Quick Summary for <b>'.$event_name.'</b>
		       </td>
		       <td align="right" style="padding: 10px;">
		           '.$today_date.'
		       </td>
		</tr>
		</table>

		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
		  <tr>
		    <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;width: 25%;">Metric</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 25%;">#Total</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 25%;">Newly Added</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 25%;">Deleted</th>
		  </tr>
		<tr>
			   <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Speakers
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		           '.$total_speaker.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		          '.$newly_added_speaker_html.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		          '.$newly_deleted_speaker_html.'
		       </td>
		</tr>
		<tr>
			   <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Sponsors
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		          '.$total_sponsor.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		        <span style="color: red;">   <?php echo $newly_added_sponsors; ?></span>
		        '.$newly_added_sponsor_html.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		        <span style="color: red;">   <?php echo $newly_added_sponsors; ?></span>
		        '.$newly_deleted_sponsor_html.'
		       </td>
		</tr>
		<tr>
			   <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Contacts
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		           '.$total_master.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: green">
		          '.$newly_added_master_html.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: green">
		          '.$newly_deleted_master_html.'
		       </td>
		</tr>

		<tr>
			   <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Email Sent
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		           '.$total_mail_sent.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: green">
		          '.$today_mail_sent.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: green"> --
		       </td>
		</tr>

		</table>

		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="" style="background: #222;color: #fff;">
		<tr>
		<td align="left" style="padding: 10px;">
		           Action for the Day
		       </td>
		</tr>
		</table>

		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
		  <tr>
		    <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;width: 20%;">Action</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 20%;">Assigned to</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 20%;">Category</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 20%;">Status</th>
		  </tr>
		  '.$action_html.' 

		</table>
		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="" style="background: #222;color: #fff;">
		<tr>
		<td align="left" style="padding: 10px;">
		           Need Your Attention
		       </td>
		</tr>
		</table>

		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
		  <tr>
		<td align="left" colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ffff;font-size: 22px;color: #b51d55;">
		           <img src="https://www.speakerengage.com/images/mic.png" width="25" alt="Speaker Engage" style="margin-bottom: 5px;margin-top: 5px;"/><span style="position: relative;top: 2px;left: 5px;">SPEAKERS</span>
		       </td>
		</tr>
		  <tr>
		    <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;width: 20%;">Critical Data</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 20%;">#Missing</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 20%;">% of Missing Data</th>
		  </tr>
		<tr>
		<td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Phone number
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		           '.$total_speaker_without_mobile.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		         '.$total_speaker_without_mobile_percentage_html.'
		       </td>       
		</tr>

		<tr>
		<td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           LinkedIn Handle
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		          '.$total_speaker_without_linkedin.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: red;">
		          '.$total_speaker_without_linkedin_percentage_html.'
		       </td>
		       
		</tr>

		<tr>
			<td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Bio
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		          '.$total_speaker_without_bio.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		          '.$total_speaker_without_bio_percentage_html.'
		       </td>		       
		</tr>

		<tr>
			<td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Headshots
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		          '.$total_speaker_without_headshot.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		          '.$total_speaker_without_headshot_percentage_html.'
		       </td>		       
		</tr>


		</table>


		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
		  <tr>
		    <td align="left" colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ffff;font-size: 22px;color: #b51d55;">
		           <img src="https://www.speakerengage.com/images/sponsor.png" width="30" alt="Speaker Engage" style="margin-bottom: 5px;margin-top: 5px;"/><span style="position: relative;top: 2px;left: 5px;">SPONSORS</span>
		       </td>
		  </tr>
		  <tr>
		    <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;width: 20%;">Critical Data</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 20%;">#Missing</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 20%;">% of Missing Data</th>
		  </tr>


		<tr>
		      <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Logos
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		           '.$total_sponsor_without_logo.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: #d6bb0b;">
		            '.$total_sponsor_without_logo_percentage_html.'
		       </td>
		       
		</tr>

		<tr>
		      <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Primary Contact
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		          '.$total_sponsor_without_contact.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: red;">
		          '.$total_sponsor_without_contact_percentage_html.'
		       </td>
		       
		</tr>


		</table>


		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
		  <tr>
		<td align="left" colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ffff;font-size: 22px;color: #b51d55;">
		           <img src="https://www.speakerengage.com/images/masters.png" width="25" alt="Speaker Engage" style="margin-bottom: 5px;margin-top: 5px;"/><span style="position: relative;top: 2px;left: 5px;">MASTERS</span>
		       </td>
		</tr>
		  <tr>
		    <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;width: 20%;">Critical Data</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 20%;">#Missing</th>
		    <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 20%;">% of Missing Data</th>
		  </tr>
		<tr>
		      <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Company Name
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		          '.$total_master_without_company.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           '.$total_master_without_company_percentage_html.'
		       </td>
		       
		</tr>

		<tr>
			   <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           LinkedIn Handle
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		           '.$total_master_without_linkedin.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		          '.$total_master_without_linkedin_percentage_html.'
		       </td>		       
		</tr>

		<tr>
			   <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		           Phone Number
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
		           '.$total_master_without_phone.'
		       </td>
		       <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
		          '.$total_master_without_phone_percentage_html.'
		       </td>		       
		</tr>


		</table>

		</td>
		</tr>
		</table>';

		 //echo $email_body; exit();

		//*******************
		$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
			$res_site_details = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_details['value'];

			$email_header = "Speaker Engage : Activity notification for ".$event_name;

		     mysqli_query($connect, "INSERT INTO all_crud_logs(event_id,operation,created_at) VALUES ('".$event_id."','daily update notification',now())");

		    $send_email = $common->sendEmail($admin_email , 'noreply@speakerengage.com', $email_header,$email_body,'Speaker Engage Team');

			// mysqli_query($connect, "INSERT INTO all_logs(operation,event_id) VALUES ('daily update notification','1')"); 
		 //     $last_insert_id = mysqli_insert_id($connect);

		 // $send_email = $common->sendEmail($admin_email , 'noreplay@speakerengage.com', 'Daily Update Notification',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",'Speaker Engage Team');

		} //end of foreach

	} // end of if(count($events_array) > 0)



	} //end of while
		} //end of if(mysqli_num_rows($fetch_admin_details) > 0)


	} // first while
} //first if
				
		header('Location: ../trigger_daily_update_notification.php');
		 break;


	 	case "create_new_password":

		   	$user_id = mysqli_real_escape_string($connect, $_POST['user_id']);

		   	$cpassword_temp = trim($_POST['cpassword']);
            $cpassword = mysqli_real_escape_string($connect, $cpassword_temp);

            $token_temp = trim($_POST['token']);
            $token = mysqli_real_escape_string($connect, $token_temp);

            $fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
				$res_site_details = mysqli_fetch_array($fetch_site_details);
				$site_url = $res_site_details['value'];

				$loggedin_user_data = mysqli_query($connect,"SELECT first_name,email FROM all_users WHERE user_id = '".$user_id."' ");
			   	$res_loggedin_user = mysqli_fetch_array($loggedin_user_data);
			   	$first_name = $res_loggedin_user['first_name'];	
			   	$email = $res_loggedin_user['email'];	

            $pass_eyncpt =  password_hash($cpassword, PASSWORD_DEFAULT, ['cost' => 11]);
		   	
			
			mysqli_query($connect, "UPDATE all_users SET `password` = '".$pass_eyncpt."' WHERE user_id = '".$user_id."' ");

			mysqli_query($connect, "UPDATE password_reset_info SET `is_used` = '1' WHERE token = '".$token."' ");		

			mysqli_query($connect, "INSERT INTO all_logs(operation,created_by) VALUES ('Password Reset','".$user_id."')");


			$content = '<table bgcolor="#F1F1F1" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table valign="center" cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
                    <tr valign="center">
                        <td valign="center" style="padding-top: 25px;padding-bottom: 20px;"><img src="'.$site_url.'/images/main-logo.png" width="150" alt="Speaker Engage" /></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" style="padding-top:40px; padding-bottom:40px;">

                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" width="600" align="center" border="0">
                                            <tr>
                                                <td>

                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 20px;font-size: 18px;">Hello '.$first_name.',</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 0px;font-size: 18px;">Your password has been reset. Click <a style="color: #007DB7;text-decoration: none;" href="'.$site_url.'/login.php">here</a> to login using your new password. </p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">If you did not change your password, contact us at:<a style="color: #007DB7;text-decoration: none;" href="mailto:support@speakerengage.com">support@speakerengage.com</a></p>
                                                            </td>
                                                        </tr>

                                                       
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 10px;font-size: 20px;color: #007DB7;font-weight: 600;">Get in Touch!</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">If there is anything you would like to know, write to us at <a style="color: #007DB7;text-decoration: none;" href="mailto:support@speakerengage.com">support@speakerengage.com</a> 

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">Happy Organizing!

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">The Speaker Engage Team

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="height: 20px;"></td>
                                                        </tr>

                                                    </table>
                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="#e2e2e2">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin: 0;"><small style="color: #8a8888;font-size: 12px;">Powered by <a href="https://www.speakerengage.com/" style="color: #8a8888;font-size: 12px;text-decoration: none;"> SpeakerEngage.com</a></small></p>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
';


	            	$common->sendEmail($email, 'noreply@speakerengage.com', "Speaker Engage: Yaay! Your password got reset successfully", $content,'Speaker Engage Team'); 




			header('Location:../password-status.php?tn='.$token);


	 	break;


        case "change_password":

            $user_id = mysqli_real_escape_string($connect, $_POST['user_id']);

            $cpassword_temp = trim($_POST['cpassword']);
            $cpassword = mysqli_real_escape_string($connect, $cpassword_temp);

            $pass_eyncpt =  password_hash($cpassword, PASSWORD_DEFAULT, ['cost' => 11]);


            mysqli_query($connect, "UPDATE all_users SET `password` = '".$pass_eyncpt."' WHERE user_id = '".$user_id."' ");

            mysqli_query($connect, "INSERT INTO password_reset_info (email_id,user_id,is_used,used_for) VALUES ('".$email."','".$user_id."','1','Password change') ");

            mysqli_query($connect, "INSERT INTO all_logs(operation,created_by) VALUES ('Password Change','".$user_id."')");
            
            session_destroy();

            header('Location:../login.php?new-pass');

            break;

            case "trigger_sign_up":
            	$email = mysqli_real_escape_string($connect, $_POST['email']);
				$f_name = mysqli_real_escape_string($connect, $_POST['fname']);
				$l_name = mysqli_real_escape_string($connect, $_POST['lname']);
			 
            	$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
				$res_site_details = mysqli_fetch_array($fetch_site_details);
				$site_url = $res_site_details['value'];
				$token = md5(uniqid());


				//****** insert user
				$insert_token = mysqli_query($connect,"INSERT INTO `password_reset_info` (`email_id`,`token`,`is_used`,`used_for`) VALUES('".$email."','".$token."',0,'signup verification') ");

				//$insert_user = mysqli_query($connect,"INSERT INTO `all_users` (`email`,`first_name`,`last_name`,`confirmcode`,`role`,`roleid`) VALUES('".$email."','".$f_name."','".$l_name."','n','admin','1') ");

				$insert_user = mysqli_query($connect,"INSERT INTO `pre_registered_users` (`email_id`,`first_name`,`last_name`,`is_used`,`token`) VALUES('".$email."','".$f_name."','".$l_name."','0','".$token."') ");

						$content = '<table bgcolor="#F1F1F1" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				        <tr>
				            <td>
				                <table valign="center" cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
				                    <tr valign="center">
				                        <td valign="center" style="padding-top: 25px;padding-bottom: 20px;"><img src="'.$site_url.'/images/main-logo.png" width="150" alt="Speaker Engage" /></td>
				                    </tr>
				                </table>
				            </td>
				        </tr>
				        <tr>
				            <td>
				                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
				                    <tr>
				                        <td valign="top" style="padding-top:40px; padding-bottom:40px;">

				                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
				                                <tr>
				                                    <td>
				                                        <table cellspacing="0" cellpadding="0" width="600" align="center" border="0">
				                                            <tr>
				                                                <td>

				                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
				                                                        <tr>
				                                                            <td style="padding-left: 20px;padding-right: 20px;">
				                                                                <p style="margin-bottom: 5px;margin-top: 20px;font-size: 18px;">Hello '.$f_name.',</p>
				                                                            </td>
				                                                        </tr>
				                                                        <tr>
				                                                            <td style="padding-left: 20px;padding-right: 20px;">
				                                                                <p style="margin-bottom: 5px;margin-top: 0px;font-size: 18px;">Congratulations! We are delighted to have you as a part of our community. Now you are well on your way to organizing events seamlessly. </p>
				                                                            </td>
				                                                        </tr>
				                                                        <tr>
				                                                            <td style="padding-left: 20px;padding-right: 20px;">
				                                                                <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">To get full and free access to Speaker Engage for <span style="font-weight: 600;color: #007db7">100</span> days, click on this link and verify your e-mail <a href="'.$site_url.'/user-create-password.php?tk='.$token.'" style="color: #007db7;text-decoration: none;">'.$site_url.'/verify_email</a></p>
				                                                            </td>
				                                                        </tr>

				                                                        <tr>
				                                                            <td style="padding-left: 20px;padding-right: 20px;">
				                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">Here’s wishing you the very best for all your events and we promise to help you to meet your event organization needs.</p>
				                                                            </td>
				                                                        </tr>

				                                                        <tr>
				                                                            <td style="padding-left: 20px;padding-right: 20px;">
				                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 20px;color: #007DB7;font-weight: 600;margin-top: 20px;">Get in Touch!</p>
				                                                            </td>
				                                                        </tr>

				                                                        <tr>
				                                                            <td style="padding-left: 20px;padding-right: 20px;">
				                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">If there is anything you would like to know, write to us at <a style="color: #007DB7;text-decoration: none;" href="mailto:support@speakerengage.com">support@speakerengage.com</a> 

																			</p>
				                                                            </td>
				                                                        </tr>

				                                                        <tr>
				                                                            <td style="padding-left: 20px;padding-right: 20px;">
				                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">Happy Organizing!

																		</p>
				                                                            </td>
				                                                        </tr>

				                                                        <tr>
				                                                            <td style="padding-left: 20px;padding-right: 20px;">
				                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">The Speaker Engage Team

																		</p>
				                                                            </td>
				                                                        </tr>

				                                                        <tr>
				                                                            <td style="height: 20px;"></td>
				                                                        </tr>

				                                                    </table>
				                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="#e2e2e2">
				                                                        <tr>
				                                                            <td style="padding-left: 20px;padding-right: 20px;">
				                                                                <p style="margin: 0;"><small style="color: #8a8888;font-size: 12px;">Powered by <a href="https://www.speakerengage.com/" style="color: #8a8888;font-size: 12px;text-decoration: none;"> SpeakerEngage.com</a></small></p>
				                                                            </td>
				                                                        </tr>
				                                                    </table>

				                                                </td>
				                                            </tr>
				                                        </table>
				                                    </td>
				                                </tr>
				                            </table>

				                        </td>
				                    </tr>
				                </table>
				            </td>
				        </tr>
				    </table>';



						// var_dump($content); exit(); 
	            $email_trigger = $common->sendEmail($email, 'noreply@speakerengage.com', "Speaker Engage: Congratulations! You are almost there", $content,'Speaker Engage Team');          		
				

				mysqli_query($connect, "INSERT INTO all_logs(operation,created_by) VALUES ('user signup verification','".$user_id."')");

				header('Location:../email-verify.php?em='.base64_encode($email));
            	
           	break;

           	case "user_create_password":
           		$passwd = mysqli_real_escape_string($connect, $_POST['password']);
           		$user_email = mysqli_real_escape_string($connect, $_POST['user_email']);
           		$access_token = mysqli_real_escape_string($connect, $_POST['token']);

           		$pass_eyncpt = password_hash($passwd, PASSWORD_DEFAULT, ['cost' => 11]);

           		// $update_user = mysqli_query($connect,"UPDATE all_users SET `password` = '".$pass_eyncpt."',`confirmcode` = 'y' WHERE `email` = '".$user_email."' ");

           		$update_user = mysqli_query($connect,"UPDATE pre_registered_users SET `password` = '".$pass_eyncpt."' WHERE `email_id` = '".$user_email."' AND `token`= '".$access_token."' ");

           		// $update_used_id = mysqli_query($connect,"UPDATE password_reset_info SET `is_used` = '1' WHERE `token` = '".$access_token."' ");

			 header('Location:../set-tenant-url.php?tk='.$access_token);
           	break;

           	case "users_upload":

            require "../spreadsheet-reader-master/php-excel-reader/excel_reader2.php";
            require "../spreadsheet-reader-master/SpreadsheetReader.php";

            $uploaddir = '../uploaded-files/';
            $uploadfile = $uploaddir . basename($_FILES['file']['name']);
            move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
            $Filepath       = $uploadfile;
            $Spreadsheet    = new SpreadsheetReader($Filepath);
            $Sheets         = implode('',$Spreadsheet -> Sheets());
            $Filepath       = '../uploaded-files/'.$Sheets;

            /*if (file_exists($Filepath)) {

                mysqli_query($connect, "INSERT INTO all_logs(operation,table_name,created_by) VALUES ('File exist','file location','".$id_user."' )");

            }else {


                mysqli_query($connect, "INSERT INTO all_logs(operation,table_name,created_by) VALUES ('No File','file location','" . $id_user . "' )");
            }*/

            $lines = explode( "\n", file_get_contents( $Filepath ) );

            $headers = str_getcsv( array_shift( $lines ) );

            array_pop($lines);

            //convert data to key value format

            $data = array();

            foreach ( $lines as $line ) {

                $row = array();
                foreach ( str_getcsv( $line ) as $key => $field )
                    $row[ $headers[ $key ] ] = $field;
                $row = array_filter( $row );
                $data[] = $row;
            }

            $select_email = mysqli_query($connect,"SELECT email FROM all_users");

            $existing_email = [];


            while($row = mysqli_fetch_array($select_email)) {

                array_push($existing_email, $row['email']);

            }


            //to count entries without email
            $no_email_count = 0;

            //to count successfull entries
            $temp_id = 0;

            foreach($data as $key => $value){

                //Extracting value to enter into DB
                $email = mysqli_real_escape_string($connect,@$value['email']);
                $first_name = mysqli_real_escape_string($connect,@$value['first_name']);
                $last_name = mysqli_real_escape_string($connect,@$value['last_name']);
                $gender = mysqli_real_escape_string($connect,@$value['gender']);
                $org = mysqli_real_escape_string($connect,@$value['organization_name']);
                $ph = mysqli_real_escape_string($connect,@$value['phone_number']);
                $w_ph = mysqli_real_escape_string($connect,@$value['work_phone_number']);
                $linkedin = mysqli_real_escape_string($connect,@$value['linkedin_ul']);
                $country_code = mysqli_real_escape_string($connect,@$value['country_code']);
                $ph_mid_no = mysqli_real_escape_string($connect,@$value['phone_middle_number']);
                $ph_last_no = mysqli_real_escape_string($connect,@$value['phone_last_number']);

//
//                //Customize gender to general form
//                if(strtolower($gender[0]) == 'm'){
//
//                    $gender = 'Male';
//
//                }elseif(strtolower($gender[0]) == 'f'){
//
//                        $gender = 'Female';
//
//                }else{
//
//                    $gender = 'Undefined';
//                }



                //check if email exists or not
                if(!empty($email)){

                    if(in_array($email,$existing_email)){


                        $update_field = "UPDATE all_users SET first_name='$first_name' , last_name = '$last_name' , phone_number = '$ph' , work_phone_number ='$w_ph' , linkedin_url='$linkedin' WHERE email = '$email'";

                        mysqli_query($connect,$update_field);

                    }

                    elseif(!in_array($email,$existing_email)){

                        $insert = "INSERT INTO all_users (confirmcode,email,first_name,last_name,gender,organization_name,phone_number,linkedin_url,countrycode,phone_middle_no,phone_last_no) VALUE ('y','$email','$first_name','$last_name','$gender','$org','$ph','$linkedin','$country_code','$ph_mid_no','$ph_last_no')";

                        mysqli_query($connect,$insert);

                    	array_push($existing_email, $email);


                        $temp_id++;

                    }else{

                        // header('Location:../all-sponsors.php?count=&general_doc_upload_error');
                    }
                }else{

                    $no_email_count++;

                }
            }


            //contact without email id
            if($no_email_count != 0){

                // header('Location:../all-sponsors.php?count='.$no_email_count.'&upload_error_no_email');

            }

            @unlink($Filepath);

            mysqli_query($connect, "INSERT INTO all_logs(operation,table_name,created_by) VALUES ('upload all users','all_users','".$id_user."' )");

            header('Location:../admin-user-management.php?count='.$temp_id.'&upload_success');

        break;

        case "update-admin-personal-settings":

        	$comm_pref = implode(',', $_POST['communication_preference']);

            $communication_preference = mysqli_real_escape_string($connect, $comm_pref);
            $reg_pref = mysqli_real_escape_string($connect, $_POST['regional_preference']);
            $time_zone = mysqli_real_escape_string($connect, $_POST['time_zone']);
            $id = mysqli_real_escape_string($connect, $_POST['id']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);

            mysqli_query($connect, "UPDATE all_users  SET communication_preference='".$communication_preference."',time_zone='".$time_zone."', regional_preference='".$reg_pref."',confirmcode='y' WHERE user_id=".$id);

            header('Location:../admin-personal-settings.php?id='.base64_encode($id).'&updated-success');

            break;

        case "tenant_name_update_url":

        		$url = $_POST['tenant_name'];

        		$email = mysqli_real_escape_string($connect, $_POST['email']);
            		
            	$token = mysqli_real_escape_string($connect, $_POST['tk']);


             	$url_test = preg_replace('/\s+/', '', $url);


	             if($url_test != ''){

	                $url_rmv_spc = str_replace(' ', '-', $url);

	                $url = ucfirst(mysqli_real_escape_string($connect, $url));            
	                
	                $url_rmv_spc = mysqli_real_escape_string($connect, $url_rmv_spc);


	                $result = mysqli_query($connect,"INSERT INTO all_tenants (tenant_name,tenant_url_structure,admin_creation,status) VALUES ('$url','$url_rmv_spc','0','in_trial')");	                

					 $ten_id = mysqli_insert_id($connect);


					 // fetch details from pre registered table
					 $fetch_pre_registered_details = mysqli_query($connect,"SELECT * FROM `pre_registered_users` WHERE `email_id` = '".$email."' AND `token` = '".$token."' ");
					 $res_pre_details = mysqli_fetch_array($fetch_pre_registered_details);

					 	$email_f = $res_pre_details['email_id'];
					 	$first_name_f = $res_pre_details['first_name'];
					 	$last_name_f = $res_pre_details['last_name'];
					 	$password_f = $res_pre_details['password'];

					 	$insert_users = mysqli_query($connect,"INSERT INTO `all_users` (email,first_name,last_name,password,confirmcode,role,roleid,tanent_id,subscription_status) VALUES('".$email_f."','".$first_name_f."','".$last_name_f."','".$password_f."','y','admin','1','".$ten_id."','in_trial')");					 	

					 	$created_by = mysqli_insert_id($connect);


					 	// update tenant tbl 
					 	$update_tenant_tbl = mysqli_query($connect,"UPDATE `all_tenants` SET `created_by` = '".$created_by."' WHERE `id` = '".$ten_id."' ");

					 

					$upd_pwd_res = mysqli_query($connect, "UPDATE password_reset_info SET tanent_id = '".$ten_id."',is_used='1' WHERE email_id = '".$email."' AND token = '".$token."' ");
				
					$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
				
					$res_site_details = mysqli_fetch_array($fetch_site_details);
				
					$site_url = $res_site_details['value'];

	$content = '<table bgcolor="#F1F1F1" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table valign="center" cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
                    <tr valign="center">
                        <td valign="center" style="padding-top: 25px;padding-bottom: 20px;"><img src="'.$site_url.'/images/main-logo.png" width="150" alt="Speaker Engage" /></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" style="padding-top:40px; padding-bottom:40px;">

                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" width="600" align="center" border="0">
                                            <tr>
                                                <td>

                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 20px;font-size: 18px;">Hello '.$first_name_f.' '.$last_name_f.',</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 0px;font-size: 18px;">Welcome to Speaker Engage! We are excited to have <span style="font-weight: 600;color: #007db7">'.$url.'</span> as part of our community of event organizers.</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">Say goodbye to all your organizational troubles. Now that you’re on Speaker Engage, organizing events will be a piece of cake.</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">We’re here to support your business in many ways, including online videos, articles and guides.</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">Let\'s start with these must-see resources</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <ul style="margin-top: 0px; margin-bottom: 0px;">
                                                                    <li style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">
                                                                        How to get started in Speaker Engage. Watch now
                                                                    </li>

                                                                    <li style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">
                                                                        Register for a training webinar led by a Speaker Engage Expert. Reserve Your Time
                                                                    </li>
                                                                    <li style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">
                                                                        Get answers with Self-Help. Visit our FAQ page.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 20px;color: #007DB7;font-weight: 600;margin-top: 20px;">Get in Touch!</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">If there is anything you would like to know, write to us at <a style="color: #007DB7;text-decoration: none;" href="mailto:support@speakerengage.com">support@speakerengage.com</a> 

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">Happy Organizing!

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">The Speaker Engage Team

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="height: 20px;"></td>
                                                        </tr>

                                                    </table>
                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="#e2e2e2">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin: 0;"><small style="color: #8a8888;font-size: 12px;">Powered by <a href="https://www.speakerengage.com/" style="color: #8a8888;font-size: 12px;text-decoration: none;"> SpeakerEngage.com</a></small></p>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';

$organization_name_confirmation_content = '
<table bgcolor="#F1F1F1" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table valign="center" cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
                    <tr valign="center">
                        <td valign="center" style="padding-top: 25px;padding-bottom: 20px;"><img src="'.$site_url.'/images/main-logo.png" width="150" alt="Speaker Engage" /></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" style="padding-top:40px; padding-bottom:40px;">

                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" width="600" align="center" border="0">
                                            <tr>
                                                <td>

                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 20px;font-size: 18px;">Hello '.$first_name_f.' '.$last_name_f.',</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 0px;font-size: 18px;">Congratulations on setting up your organization account!</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;"><span style="font-weight: 600;color: #007db7">'.$url.'</span> is available and reserved for your account. </p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;"><span style="font-weight: 600;color: #007db7">'.$url.'</span> will have full and free access to Speaker Engage for 100 days. Have fun!</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 20px;color: #007DB7;font-weight: 600;margin-top: 20px;">Get in Touch!</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">If there is anything you would like to know, write to us at <a style="color: #007DB7;text-decoration: none;" href="mailto:support@speakerengage.com">support@speakerengage.com</a> 

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">Happy Organizing!

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">The Speaker Engage Team

</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="height: 20px;"></td>
                                                        </tr>

                                                    </table>
                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="#e2e2e2">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin: 0;"><small style="color: #8a8888;font-size: 12px;">Powered by <a href="https://www.speakerengage.com/" style="color: #8a8888;font-size: 12px;text-decoration: none;"> SpeakerEngage.com</a></small></p>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
';


	            	$common->sendEmail($email, 'noreply@speakerengage.com', "Welcome to Speaker Engage", $content,'Speaker Engage Team'); 

	            	$common->sendEmail($email, 'noreply@speakerengage.com', "Speaker Engage: Congratulations! Your Organization got enrolled", $organization_name_confirmation_content,'Speaker Engage Team');  


	            	$new_cust_enrolled_content = "Hi Ram,<br/><br/>
	            	A new customer has been enrolled for free trial.<br/><br/>
	            	Please find the details below.<br/>
	            	Name: ".$first_name_f." ".$last_name_f."<br/>
	            	Email Address: ".$email_f .
	            	"<br/><br/>
	            	Thanks, <br/>
	            	Speaker Engage Team
	            	"; 

	            	$common->sendEmail('ramd@meylah.com', 'noreply@speakerengage.com', "Speaker Engage: A new customer is enrolled for Free Trial",$new_cust_enrolled_content,'Speaker Engage Team');     

				
	            	//unset($_SESSION['email_id_temp']);
	            	
	            	unset($_SESSION['tk_temp']);

	                header('Location:../set-tenant-url-success.php?tn='.base64_encode($url).'&ae='.base64_encode($email_f).'&ap='.base64_encode($password_f));

	            }else{


	                 header('Location: 404.php');exit();
	            }

            	
           	break;  

           case "schedule_modal_submit": 
			$event_id = mysqli_real_escape_string($connect, $_POST['event_id']); 
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$multiselect_all_section_schedule =  implode(',', $_POST['multiselect_all_section_schedule']);
			$subject_line = mysqli_real_escape_string($connect, $_POST['subject_line']);
			$info_modal_epid_schedule = mysqli_real_escape_string($connect, $_POST['info_modal_epid_schedule']);
			
			$info_manager_cc = mysqli_real_escape_string($connect, $_POST['schedule_cc']);

			$info_msg = mysqli_real_escape_string($connect, $_POST['template_data']);
			$info_msg = str_replace('\n', "\n", $info_msg);
			$info_msg = str_replace('\r', "\r", $info_msg);

			$speakers_id_array = explode(",",$multiselect_all_section_schedule);

			$loggedin_user_id = $_SESSION['user_id'];	

			if($info_manager_cc == 'yes'){
		    	$cc_to_manager = 1;
		    }


		 $fetch_user_details = mysqli_query($connect,"SELECT * FROM `team_credentials`");
			if(mysqli_num_rows($fetch_user_details) > 0){
			 $res_cred = mysqli_fetch_array($fetch_user_details);
			 $display_name=$res_cred['display_name'];
	         $client_id=$res_cred['client_id'];
	         $tenant_id=$res_cred['tenant_id'];
	         $obj_id=$res_cred['obj_id'];
	         $client_secret=$res_cred['client_secret'];
	         $resource=$res_cred['resource'];
	         $grant_type=$res_cred['grant_type'];
	         $user_id=$res_cred['user_id'];
			}

           $url = 'https://login.microsoftonline.com/'.$tenant_id.'/oauth2/token';

            $headers = array(
                "Content-Type: application/x-www-form-urlencoded"
            );
            
            $postfields = 'client_id='.$client_id.'&client_secret='.$client_secret.'&Resource='.$resource.'&grant_type='.$grant_type.'';

            $now=date('Y-m-d H:i:s');

             $sql_f = mysqli_query($connect,"select * from team_access_token");
              $number_of_users=mysqli_num_rows($sql_f);
              if($number_of_users>=1)
              {
                  $fetch_sql = mysqli_query($connect,"SELECT * from team_access_token order by id desc limit 1"); 
                  $res_sql = mysqli_fetch_array($fetch_sql);
                  $expires_on= $res_sql['expires_on'];
                  $previous_token=$res_sql["access_token"];

                  if($expires_on>$now)
                  {
                    $fetched_token=$previous_token;
                  }else
                  {
                     $curlSession = curl_init($url);
                    curl_setopt($curlSession, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curlSession, CURLOPT_POST, 1);
                    curl_setopt($curlSession, CURLOPT_POSTFIELDS, $postfields);
                    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, TRUE);
                 
                    $res_token = curl_exec($curlSession);
                    curl_close($curlSession);

                    $data = json_decode($res_token, true);
                    $fetched_token=$data["access_token"];
                    $expires_on=$data["expires_on"];
                    $expires_on_fetched=date('Y-m-d H:i:s', $expires_on);

                    mysqli_query($connect, "INSERT INTO team_access_token(access_token,expires_on,created_at) VALUES ('".$fetched_token."','".$expires_on_fetched."',now())");
                   
                  }
                 
              }else
              {

                $curlSession = curl_init($url);
                curl_setopt($curlSession, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curlSession, CURLOPT_POST, 1);
                curl_setopt($curlSession, CURLOPT_POSTFIELDS, $postfields);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, TRUE);
             
                $res_token = curl_exec($curlSession);
                curl_close($curlSession);

                $data = json_decode($res_token, true);
                $fetched_token=$data["access_token"];
                $expires_on=$data["expires_on"];
                $expires_on_fetched=date('Y-m-d H:i:s', $expires_on);

                mysqli_query($connect, "INSERT INTO team_access_token(access_token,expires_on,created_at) VALUES ('".$fetched_token."','".$expires_on_fetched."',now())");
              }


            $url_create_event = 'https://graph.microsoft.com/v1.0/users/'.$user_id.'/events';

            $rows_one = count($speakers_id_array);

            $j = 0;

            $content ='';
            $attached_links = '';
            $spk_manager_array = array();
            foreach ($speakers_id_array as $speaker_id) { 
			           $fetch_speaker_details = mysqli_query($connect,"SELECT * FROM `all_speakers` WHERE `id` = '$speaker_id' ");
						if(mysqli_num_rows($fetch_speaker_details) > 0){
							$res_sp = mysqli_fetch_array($fetch_speaker_details);
							$speaker_email = $res_sp['email_id'];
							$speaker_name = $res_sp['speaker_name'];
							$sp_event_id = $res_sp['event_id'];
							$speaker_manager_email = $res_sp['speaker_manager_email'];
							if($speaker_manager_email != '' && $speaker_manager_email != NULL){
								array_push($spk_manager_array,$speaker_manager_email);
							}
							
						}
               $j++;
                  if ($rows_one == $j) {
                        $attached_links .= '{
                                    "emailAddress": {
                                      "address": "'.$speaker_email.'",
                                      "name": "'.$speaker_name.'"
                                    },
                                    "type": "required"
                                  }';
                  } else {
                      $attached_links .= '{
                                "emailAddress": {
                                  "address": "'.$speaker_email.'",
                                  "name": "'.$speaker_name.'"
                                },
                                "type": "required"
                              },';
                  }
              }

              //************************
              if($cc_to_manager == 1){

              $f=0;
              $attached_links_mngr = '';
              // remove duplicate email ids from array
              $spk_manager_array_unique = array_unique($spk_manager_array);

               $count_spk_mgr = count($spk_manager_array_unique);
              foreach ($spk_manager_array_unique as $spk_manager_email) { 
	          
              $f++;
                  if ($count_spk_mgr == $f) {
                        $attached_links_mngr .= '{
                                    "emailAddress": {
                                      "address": "'.$spk_manager_email.'",
                                      "name": "'.$spk_manager_email.'"
                                    },
                                    "type": "required"
                                  }';
                  } else {
                      $attached_links_mngr .= '{
                                "emailAddress": {
                                  "address": "'.$spk_manager_email.'",
                                  "name": "'.$spk_manager_email.'"
                                },
                                "type": "required"
                              },';
                  }
              }

              $final_links = $attached_links.($attached_links_mngr != "" ? ',' : "").$attached_links_mngr;

          }else
          {
          	$final_links = $attached_links;
          }


          $content=$final_links;

          $fetch_event_details = mysqli_query($connect,"SELECT *  FROM event_presentation  WHERE ep_id='".$info_modal_epid_schedule."'");

				if(mysqli_num_rows($fetch_event_details) > 0){
					$res_sp = mysqli_fetch_array($fetch_event_details);
					$presentation_topic = $res_sp['presentation_topic'];
					$location = $res_sp['location'];
					$event_date = $res_sp['event_date'];
					$start_time = $res_sp['start_time'];
					$end_time = $res_sp['end_time'];
					$event_start_pst = $res_sp['event_start_pst'];
					$event_end_pst = $res_sp['event_end_pst'];
				}

				$st = date("H:i:s", strtotime($start_time));
				$et = date("H:i:s", strtotime($end_time));

				$start_date = $event_date.'T'.$st;
				$end_date = $event_date.'T'.$et;

          $data_json = '{
                      "subject": "You are invited at: '.$subject_line.'",
                      "body": {
                        "contentType": "HTML",
                        "content": "'.$info_msg.'"
                      },
                      "start": {
                          "dateTime": "'.$event_start_pst.'",
                          "timeZone": "Pacific Standard Time"
                      },
                      "end": {
                          "dateTime": "'.$event_end_pst.'",
                          "timeZone": "Pacific Standard Time"
                      },
                      "location":{
                          "displayName": "'.$location.'"
                      },
                      "attendees": [
                        '.$content.'
                      ]
                    }' ;

            $ch = curl_init($url_create_event);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                    "Authorization: Bearer ".$fetched_token)
            );

            $result = curl_exec($ch);
            curl_close($ch);
            $decoded = json_decode($result);
            $res_id=$decoded->id;

            $check_temp_exist = mysqli_query($connect, "SELECT * FROM `team_scheduled_response` WHERE `event_id` = '".$event_id."' AND ep_id = '".$info_modal_epid_schedule."' ");
                if(mysqli_num_rows($check_temp_exist)> 0){
                    $update_template_details = mysqli_query($connect, "UPDATE `team_scheduled_response` SET `response_id`='".$res_id."' WHERE `event_id` = '".$event_id."' AND ep_id = '".$info_modal_epid_schedule."'");
                }else{

                    $update_template_details = mysqli_query($connect, "INSERT INTO `team_scheduled_response` (ep_id,event_id,response_id,created_by) VALUES ('$info_modal_epid_schedule','$event_id','$res_id','$loggedin_user_id')");               
                }

             foreach ($speakers_id_array as $speaker_id) { 
	           $fetch_speaker_details = mysqli_query($connect,"SELECT * FROM `all_speakers` WHERE `id` = '$speaker_id' ");
				if(mysqli_num_rows($fetch_speaker_details) > 0){
					$res_sp = mysqli_fetch_array($fetch_speaker_details);
					$speaker_email = $res_sp['email_id'];
					
				}else
				{
					$speaker_email = '';
				}

				mysqli_query($connect, "INSERT INTO team_scheduled_email(ep_id,event_id,speaker_id,email_id,subject,body,start_datetime,end_datetime,location,response_id,is_sent,created_by) VALUES ('".$info_modal_epid_schedule."','".$event_id."','".$speaker_id."','".$speaker_email."','".$subject_line."','".$info_msg."','".$start_date."','".$end_date."','".$location."','".$res_id."','1','".$loggedin_user_id."')");

				// $fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_speakers` WHERE `id` = '".$speaker_id."' ");
				// $res_spk_email_count = mysqli_fetch_array($fetch_email_count);
				// $spk_email_count = $res_spk_email_count['mail_sent_count'];
				// $new_count = $spk_email_count+ 1;
				// $update_spk_email_count = mysqli_query($connect,"UPDATE `all_speakers` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$speaker_id."' ");

				//*********** all_event_email_count
				$fetch_event_email_count = mysqli_query($connect,"SELECT speaker_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
				$res_email_count = mysqli_fetch_array($fetch_event_email_count);
				$total_email_count = $res_email_count['speaker_email_count'];
				$new_total_count = $total_email_count + 1;
				$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `speaker_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

				$fetch_email_count_event_presentation = mysqli_query($connect,"SELECT total_email_sent,total_team_scheduled_email FROM `event_presentation` WHERE `ep_id` = '".$info_modal_epid_schedule."' ");
				$res_ep_email_count = mysqli_fetch_array($fetch_email_count_event_presentation);
				$ep_email_count = $res_ep_email_count['total_email_sent'];
				$ep_team_email_count = $res_ep_email_count['total_team_scheduled_email'];
				$new_ep_email_count = $ep_email_count+ 1;
				$new_ep_team_email_count = $ep_team_email_count+ 1;
				$update_spk_email_count = mysqli_query($connect,"UPDATE `event_presentation` SET `total_email_sent` = '".$new_ep_email_count."',`total_team_scheduled_email` = '".$new_ep_team_email_count."' WHERE `ep_id` = '".$info_modal_epid_schedule."' ");
             
              }
            
			header('Location:../all_presentation.php?schedule-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999))); 
		break;  


		 case "schedule_modal_update": 
			$event_id = mysqli_real_escape_string($connect, $_POST['up_event_id']); 
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$multiselect_all_section_schedule =  implode(',', $_POST['update_multiselect_all_section_schedule']);
			$subject_line = mysqli_real_escape_string($connect, $_POST['up_subject_line']);
			$info_modal_epid_schedule = mysqli_real_escape_string($connect, $_POST['up_info_modal_epid_schedule']);

			$info_msg = mysqli_real_escape_string($connect, $_POST['up_template_data']);
			$info_msg = str_replace('\n', "\n", $info_msg);
			$info_msg = str_replace('\r', "\r", $info_msg);

			$speakers_id_array = explode(",",$multiselect_all_section_schedule);

			$loggedin_user_id = $_SESSION['user_id'];	

		 $fetch_user_details = mysqli_query($connect,"SELECT * FROM `team_credentials`");
			if(mysqli_num_rows($fetch_user_details) > 0){
			 $res_cred = mysqli_fetch_array($fetch_user_details);
			 $display_name=$res_cred['display_name'];
	         $client_id=$res_cred['client_id'];
	         $tenant_id=$res_cred['tenant_id'];
	         $obj_id=$res_cred['obj_id'];
	         $client_secret=$res_cred['client_secret'];
	         $resource=$res_cred['resource'];
	         $grant_type=$res_cred['grant_type'];
	         $user_id=$res_cred['user_id'];
			}

           $url = 'https://login.microsoftonline.com/'.$tenant_id.'/oauth2/token';

            $headers = array(
                "Content-Type: application/x-www-form-urlencoded"
            );
            
            $postfields = 'client_id='.$client_id.'&client_secret='.$client_secret.'&Resource='.$resource.'&grant_type='.$grant_type.'';

            $now=date('Y-m-d H:i:s');

             $sql_f = mysqli_query($connect,"select * from team_access_token");
              $number_of_users=mysqli_num_rows($sql_f);
              if($number_of_users>=1)
              {
                  $fetch_sql = mysqli_query($connect,"SELECT * from team_access_token order by id desc limit 1"); 
                  $res_sql = mysqli_fetch_array($fetch_sql);
                  $expires_on= $res_sql['expires_on'];
                  $previous_token=$res_sql["access_token"];

                  if($expires_on>$now)
                  {
                    $fetched_token=$previous_token;
                  }else
                  {
                     $curlSession = curl_init($url);
                    curl_setopt($curlSession, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curlSession, CURLOPT_POST, 1);
                    curl_setopt($curlSession, CURLOPT_POSTFIELDS, $postfields);
                    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, TRUE);
                 
                    $res_token = curl_exec($curlSession);
                    curl_close($curlSession);

                    $data = json_decode($res_token, true);
                    $fetched_token=$data["access_token"];
                    $expires_on=$data["expires_on"];
                    $expires_on_fetched=date('Y-m-d H:i:s', $expires_on);

                    mysqli_query($connect, "INSERT INTO team_access_token(access_token,expires_on,created_at) VALUES ('".$fetched_token."','".$expires_on_fetched."',now())");
                   
                  }
                 
              }else
              {

                $curlSession = curl_init($url);
                curl_setopt($curlSession, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curlSession, CURLOPT_POST, 1);
                curl_setopt($curlSession, CURLOPT_POSTFIELDS, $postfields);
                curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, TRUE);
             
                $res_token = curl_exec($curlSession);
                curl_close($curlSession);

                $data = json_decode($res_token, true);
                $fetched_token=$data["access_token"];
                $expires_on=$data["expires_on"];
                $expires_on_fetched=date('Y-m-d H:i:s', $expires_on);

                mysqli_query($connect, "INSERT INTO team_access_token(access_token,expires_on,created_at) VALUES ('".$fetched_token."','".$expires_on_fetched."',now())");
              }

             $check_exist = mysqli_query($connect, "SELECT * FROM `team_scheduled_response` WHERE `event_id` = '".$event_id."' AND ep_id = '".$info_modal_epid_schedule."' ");
             $res_sql_qry = mysqli_fetch_array($check_exist);
             $response_id= $res_sql_qry['response_id'];


             $url_create_event = 'https://graph.microsoft.com/v1.0/users/'.$user_id.'/events/'.$response_id.'';

            $rows_one = count($speakers_id_array);

            $j = 0;

            $content ='';
            $attached_links = '';
            $spk_manager_array = array();
            foreach ($speakers_id_array as $speaker_id) { 
			           $fetch_speaker_details = mysqli_query($connect,"SELECT * FROM `all_speakers` WHERE `id` = '$speaker_id' ");
						if(mysqli_num_rows($fetch_speaker_details) > 0){
							$res_sp = mysqli_fetch_array($fetch_speaker_details);
							$speaker_email = $res_sp['email_id'];
							$speaker_name = $res_sp['speaker_name'];
							$sp_event_id = $res_sp['event_id'];
							$speaker_manager_email = $res_sp['speaker_manager_email'];
							if($speaker_manager_email != '' && $speaker_manager_email != NULL){
								array_push($spk_manager_array,$speaker_manager_email);
							}
							
						}
               $j++;
                  if ($rows_one == $j) {
                        $attached_links .= '{
                                    "emailAddress": {
                                      "address": "'.$speaker_email.'",
                                      "name": "'.$speaker_name.'"
                                    },
                                    "type": "required"
                                  }';
                  } else {
                      $attached_links .= '{
                                "emailAddress": {
                                  "address": "'.$speaker_email.'",
                                  "name": "'.$speaker_name.'"
                                },
                                "type": "required"
                              },';
                  }
              }


          	$final_links = $attached_links;
  


          $content=$final_links;

          $fetch_event_details = mysqli_query($connect,"SELECT *  FROM event_presentation  WHERE ep_id='".$info_modal_epid_schedule."'");

				if(mysqli_num_rows($fetch_event_details) > 0){
					$res_sp = mysqli_fetch_array($fetch_event_details);
					$presentation_topic = $res_sp['presentation_topic'];
					$location = $res_sp['location'];
					$event_date = $res_sp['event_date'];
					$start_time = $res_sp['start_time'];
					$end_time = $res_sp['end_time'];
					$event_start_pst = $res_sp['event_start_pst'];
					$event_end_pst = $res_sp['event_end_pst'];
				}

				$st = date("H:i:s", strtotime($start_time));
				$et = date("H:i:s", strtotime($end_time));

				$start_date = $event_date.'T'.$st;
				$end_date = $event_date.'T'.$et;

          $data_json = '{
                      "subject": "You are invited at: '.$subject_line.'",
                      "body": {
                        "contentType": "HTML",
                        "content": "'.$info_msg.'"
                      },
                      "start": {
                          "dateTime": "'.$event_start_pst.'",
                          "timeZone": "Pacific Standard Time"
                      },
                      "end": {
                          "dateTime": "'.$event_end_pst.'",
                          "timeZone": "Pacific Standard Time"
                      },
                      "location":{
                          "displayName": "'.$location.'"
                      },
                      "attendees": [
                        '.$content.'
                      ]
                    }' ;

      
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url_create_event);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
           curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                    "Authorization: Bearer ".$fetched_token)
            );
            $result = curl_exec($curl);
            curl_close($curl);

            $decoded = json_decode($result);
            $res_id=$decoded->id;

            if($res_id!='')
            {
            	$update_response = mysqli_query($connect,"UPDATE `team_scheduled_email` SET `response` = ''  WHERE `event_id` = '".$event_id."' AND ep_id = '".$info_modal_epid_schedule."' ");
            }

             foreach ($speakers_id_array as $speaker_id) { 
	           $fetch_speaker_details = mysqli_query($connect,"SELECT * FROM `all_speakers` WHERE `id` = '$speaker_id' ");
				if(mysqli_num_rows($fetch_speaker_details) > 0){
					$res_sp = mysqli_fetch_array($fetch_speaker_details);
					$speaker_email = $res_sp['email_id'];
					
				}else
				{
					$speaker_email = '';
				}

				$check_temp_exist = mysqli_query($connect, "SELECT * FROM `team_scheduled_email` WHERE `event_id` = '".$event_id."' AND ep_id = '".$info_modal_epid_schedule."' AND email_id='".$speaker_email."' ");

                if(mysqli_num_rows($check_temp_exist) < 1){

                  mysqli_query($connect, "INSERT INTO team_scheduled_email(speaker_id,ep_id,event_id,email_id,subject,body,start_datetime,end_datetime,location,response_id,is_sent,created_by) VALUES ('".$speaker_id."','".$info_modal_epid_schedule."','".$event_id."','".$speaker_email."','".$subject_line."','".$info_msg."','".$start_date."','".$end_date."','".$location."','".$res_id."','1','".$loggedin_user_id."')");

				// $fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_speakers` WHERE `id` = '".$speaker_id."' ");
				// $res_spk_email_count = mysqli_fetch_array($fetch_email_count);
				// $spk_email_count = $res_spk_email_count['mail_sent_count'];
				// $new_count = $spk_email_count+ 1;
				// $update_spk_email_count = mysqli_query($connect,"UPDATE `all_speakers` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$speaker_id."' ");

				//*********** all_event_email_count
				$fetch_event_email_count = mysqli_query($connect,"SELECT speaker_email_count FROM `all_event_email_count` WHERE `event_id` = '".$event_id."' ");
				$res_email_count = mysqli_fetch_array($fetch_event_email_count);
				$total_email_count = $res_email_count['speaker_email_count'];
				$new_total_count = $total_email_count + 1;
				$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `speaker_email_count` = '".$new_total_count."' WHERE `event_id` = '".$event_id."' ");

				$fetch_email_count_event_presentation = mysqli_query($connect,"SELECT total_email_sent,total_team_scheduled_email FROM `event_presentation` WHERE `ep_id` = '".$info_modal_epid_schedule."' ");
				$res_ep_email_count = mysqli_fetch_array($fetch_email_count_event_presentation);
				$ep_email_count = $res_ep_email_count['total_email_sent'];
				$ep_team_email_count = $res_ep_email_count['total_team_scheduled_email'];
				$new_ep_email_count = $ep_email_count+ 1;
				$new_ep_team_email_count = $ep_team_email_count+ 1;
				$update_spk_email_count = mysqli_query($connect,"UPDATE `event_presentation` SET `total_email_sent` = '".$new_ep_email_count."',`total_team_scheduled_email` = '".$new_ep_team_email_count."' WHERE `ep_id` = '".$info_modal_epid_schedule."' ");
                }


             
              }
            
			header('Location:../all_presentation.php?updated-team-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999))); 
		break;   


		
		case "information_form_submit_master":

			$event_id = mysqli_real_escape_string($connect, $_POST['current_event_id']);
			$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
			$multiselect_all_section =  $_POST['multiselect_all_section'];			
			$schedule_option = mysqli_real_escape_string($connect, $_POST['schedule_option']);
			$info_modal_master_id = mysqli_real_escape_string($connect, $_POST['info_modal_userid']);

			$info_msg = mysqli_real_escape_string($connect, $_POST['info_msg']);
			$info_msg = str_replace('\n', "\n", $info_msg);
			$info_msg = str_replace('\r', "\r", $info_msg);


			$token = md5(uniqid());
			$loggedin_user_id = $_SESSION['user_id'];			

			$is_personal_details = 0;
			$is_address = 0;
			$is_social_media_info = 0;
			$is_schedule = 0;
			$schedule_datetime = '';



			if (in_array("is_personal_details", $multiselect_all_section)){
				$is_personal_details = 1;
		    }
			
			if (in_array("is_address", $multiselect_all_section)){
				$is_address = 1;
		    }

		    if (in_array("is_social_media_info", $multiselect_all_section)){
				$is_social_media_info = 1;
		    }


		    if($schedule_option == 'send_later'){		
		    	$is_schedule = 1;    	
		    	//$schedule_datetime = mysqli_real_escape_string($connect, $_POST['schedule_datetime']);
		    	$schedule_datetime = date("Y-m-d H:i",strtotime(mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));
		    }

		    $loggedin_userid = $_SESSION['user_id'];
		    // fetch loggedin user details
		    $user_details = $common->get_user_details_by_id($loggedin_userid); 
		     $loggedin_user_name = $user_details[0]['first_name'];

		     //loggedin_user_email 
		     $from_email = $user_details[0]['email']; 


		    // fetch_speaker details
		    $fetch_sponsor_details = mysqli_query($connect,"SELECT * FROM `all_masters` WHERE `id` = '$info_modal_master_id' ");
			if(mysqli_num_rows($fetch_sponsor_details) > 0){
				$res_sp = mysqli_fetch_array($fetch_sponsor_details);
				$master_name = $res_sp['master_name'];
				$email_id = $res_sp['email_id'];
				$company = $res_sp['company'];
				$sp_event_id = $res_sp['event_id'];
			}


			$fetch_event_data = mysqli_query($connect, "SELECT * FROM `all_events` WHERE `id` = '$sp_event_id' ");
			if(mysqli_num_rows($fetch_event_data) > 0){
				$res_event = mysqli_fetch_array($fetch_event_data);
				$event_email_banner = $res_event['event_email_banner'];
			}

			$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
			$res_site_details = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_details['value'];

			if($event_email_banner != null || $event_email_banner != '' ){

				$email_banner = $site_url.'/images/event_email_banner/'.$event_email_banner;
			}else{
				$email_banner = $site_url.'/images/NoPath.jpg';
			}


		    $insert_request = mysqli_query($connect, "INSERT INTO information_collect(bio,address,social_media,sent_to_speaker_id,is_schedule,schedule_at,message,token) VALUES ('".$is_personal_details."','".$is_address."','".$is_social_media_info."','".$info_modal_master_id."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."') ");

		     $sql =  "INSERT INTO information_collect(bio,address,social_media,sent_to_speaker_id,is_schedule,schedule_at,message,token) VALUES ('".$is_personal_details."','".$is_address."','".$is_social_media_info."','".$info_modal_master_id."','".$is_schedule."','".$schedule_datetime."','".$info_msg."' ,'".$token."')";	

		     if($schedule_option != 'send_later'){
		    mysqli_query($connect, "INSERT INTO all_logs(tanent_id,operation,table_name,created_by,sql_qry,table_id,event_id) VALUES ('".$session_tanent_id."','request missing information master','information_collect_master','".$loggedin_user_id."',\"".$sql."\",'".$info_modal_master_id."','".$event_id."')"); 
		    $last_insert_id = mysqli_insert_id($connect);
			}

		    $dynamic_link = $site_url."/collect-profile-info-master.php?tk=".$token;

		    $email_body = '<table cellspacing="0" cellpadding="0" width="500" align="center" style="border: 1px solid #f1f1f1;">
					<tr>
						<td>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
								<tr>
									<td><img src="https://www.speakerengage.com/images/main-logo.png" width="100" alt="Speaker Engage" /></td>
								</tr>
							</table>
							<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><img src="'.$email_banner.'" width="500" alt="Speaker Engage" /></td>
								</tr>
							</table>

							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin-bottom: 0;margin-top: 10px;font-size: 14px;">Hi <span style="font-weight: 600;">'.$master_name.'</span>,</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;">'.$info_msg.'</p></td>
								</tr>
								<tr>
									<td><p style="margin: 0;font-size: 14px;padding-bottom:5px;">Simply click on the button to take action:</p></td>
								</tr>

								
							</table>
							<table cellpadding="5" cellspacing="0" width="150px" bgcolor="" style="margin-left: 5px;cursor:pointer;">
								<tr>
									<td align="center" width="150" height="40" bgcolor="#007DB7" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;cursor:pointer;">
								            <a href="'.$dynamic_link.'" style="color: #ffffff; font-size:16px; font-weight: bold; font-family:sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block">
								                Take Action
								            </a>
								        </td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><h4 style="color: #007DB7;margin-bottom: 0px;margin-top: 10px;font-size: 16px;">We are here to help</h4></td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Please contact us if you have any questions at - '.$from_email.' </p>
									</td>
								</tr>
								<tr>
									<td>
										<p style="margin: 0;font-size: 14px;">Cheers,</p>
									</td>
								</tr>
							</table>
							<table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
								<tr>
									<td><p style="margin: 0;font-size: 14px;"><small style="color: #9c9c9c;font-size: 12px;">Powered by SpeakerEngage.com</small></p></td>
								</tr>
							</table>
							
						</td>
					</tr>
				</table>';


				if($schedule_option == 'send_later'){
					//tbl_sendlatermaildetails 

					  	$timezonezone = mysqli_real_escape_string($connect, $_POST['timezone']);
					  	// $schedule_datetime = mysqli_real_escape_string($connect, $_POST['schedule_datetime']);
					  	$schedule_datetime = date("Y-m-d H:i",strtotime(mysqli_real_escape_string($connect, $_POST['schedule_datetime']) ));

					    $date = new DateTime();
						$timeZone = $date->getTimezone();
						$servrtz=$timeZone->getName();
						$userTimezone = new DateTimeZone($timezonezone);

						
						$gmtTimezone = new DateTimeZone('GMT');
						//$myDateTime = new DateTime($scheduleddatetime1, $gmtTimezone);
						$myDateTime = new DateTime($schedule_datetime, $gmtTimezone);						
						$offset = $userTimezone->getOffset($myDateTime);					

						$myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');					
						$myDateTime->add($myInterval);
						$result = $myDateTime->format('Y-m-d H:i:s');
						$timestamp = strtotime($schedule_datetime) - ($offset);						
						$scheduledfinalDT = date("Y-m-d H:i:s", $timestamp);			

						 $insert_request = mysqli_query($connect, "INSERT INTO tbl_sendlatermaildetails(speaker_emailid,user_email,scheduleddatetime,template_sub,template_data,username,emailtype,isSent,type,timezone,event_id,user_scheduledtime,speaker_id,template_id,user_id) VALUES ('".$email_id."','".$from_email."','".$scheduledfinalDT."','Collect missing profile information master','".$email_body."','".$loggedin_user_name."','1','0','missing-info-collect-master','".$timezonezone."','".$sp_event_id."','".$schedule_datetime."','".$info_modal_master_id."','0','".$loggedin_userid."') ");		


				}else{


						$send_email = $common->sendEmail($email_id , $from_email, 'Request for Missing Information Master',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);

					$calculate_template_usage_func = $common->calculate_template_usage(9998,$sp_event_id,3);
					$type_update = $common->calculate_master_type_count($sp_event_id);

						// update email count
					$fetch_email_count = mysqli_query($connect,"SELECT mail_sent_count FROM `all_masters` WHERE `id` = '".$info_modal_master_id."' ");
					$res_spk_email_count = mysqli_fetch_array($fetch_email_count);
					$spk_email_count = $res_spk_email_count['mail_sent_count'];
					$new_count = $spk_email_count+ 1;
					$update_spk_email_count = mysqli_query($connect,"UPDATE `all_masters` SET `mail_sent_count` = '".$new_count."' WHERE `id` = '".$info_modal_master_id."' ");

					//*********** all_event_email_count
					$fetch_event_email_count = mysqli_query($connect,"SELECT master_email_count FROM `all_event_email_count` WHERE `event_id` = '".$sp_event_id."' ");
					$res_email_count = mysqli_fetch_array($fetch_event_email_count);
					$total_email_count = $res_email_count['master_email_count'];
					$new_total_count = $total_email_count + 1;
					$update_email_count = mysqli_query($connect,"UPDATE `all_event_email_count` SET `master_email_count` = '".$new_total_count."' WHERE `event_id` = '".$sp_event_id."' ");

				}		    

			header('Location:../all-masters.php?eid='.base64_encode($sp_event_id).':'.base64_encode(rand(100,999)).'&request-success'); 
		break;  

		case "collect-missing-info-master":


			$master_id = mysqli_real_escape_string($connect,$_POST['master_id']);
			$tk = trim($_POST['token']);
			$name = mysqli_real_escape_string($connect, $_POST['master_name']);
			$phone = mysqli_real_escape_string($connect, $_POST['phone_number']);
			$company = mysqli_real_escape_string($connect, $_POST['company_name']);
			$job_title = mysqli_real_escape_string($connect, $_POST['job_title']);
			$linkedin_url = mysqli_real_escape_string($connect, $_POST['linkedin_url']);
			$twitter_url = mysqli_real_escape_string($connect, $_POST['twitter_handle']);
			$master_type = mysqli_real_escape_string($connect, implode(",",$_POST['master_type']));
			$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
			$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
			$country = mysqli_real_escape_string($connect, $_POST['country']);
			$city = mysqli_real_escape_string($connect, $_POST['city']);
			$state = mysqli_real_escape_string($connect, $_POST['state']);
			$zip = mysqli_real_escape_string($connect, $_POST['zip']);
		

			$update_qry="UPDATE  `all_masters` SET `master_name`='".$name."', `company`='".$company."',`phone`='".$phone."',`job_title` = '".$job_title."',`master_type`= '".$master_type."',`linkedin_url` = '".$linkedin_url."',`twitter_url` = '".$twitter_url."',`address1`= '".$address1."',`address2`= '".$address2."',`city`= '".$city."',`state`= '".$state."',`country`= '".$country."',`zip`= '".$zip."' WHERE id=".$master_id;

				mysqli_query($connect,$update_qry);
				header('Location: ../collect-profile-info-master.php?tk='.$tk.'&info-collect-success');
		
		 break;   

		 	 case "create_social_media_calendar":
		    $event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
		    $loggedin_userid = $_SESSION['user_id'];
		 	$session_tanent_id=  $common->get_tenant_id_from_userid($loggedin_userid);

			$campaign_id = mysqli_real_escape_string($connect, $_POST['campaign_id']);
			$target_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['target_date']) ));
			$post_name = mysqli_real_escape_string($connect, $_POST['post_name']);
			$is_public = mysqli_real_escape_string($connect, $_POST['is_public']);
			$campaign_status = mysqli_real_escape_string($connect, $_POST['campaign_status']);
			$influencers = mysqli_real_escape_string($connect, $_POST['influencers']);
			$fb_post_copy = mysqli_real_escape_string($connect, $_POST['fb_post_copy']);
			$fb_target_url = mysqli_real_escape_string($connect, $_POST['fb_target_url']);
			$fb_image = mysqli_real_escape_string($connect, $_POST['image_src']);
			$fb_video = mysqli_real_escape_string($connect, $_POST['fb_video']);
			$insta_post_copy = mysqli_real_escape_string($connect, $_POST['insta_post_copy']);
			$insta_target_url = mysqli_real_escape_string($connect, $_POST['insta_target_url']);
			$insta_img = mysqli_real_escape_string($connect, $_POST['image_src1']);
			$insta_video = mysqli_real_escape_string($connect, $_POST['insta_video']);
			$lin_post_copy = mysqli_real_escape_string($connect, $_POST['lin_post_copy']);
			$lin_target_url = mysqli_real_escape_string($connect, $_POST['lin_target_url']);
			$link_img = mysqli_real_escape_string($connect, $_POST['image_src2']);
			$lin_video = mysqli_real_escape_string($connect, $_POST['lin_video']);
			$twitter_post_copy = mysqli_real_escape_string($connect, $_POST['twitter_post_copy']);
			$twitter_target_url = mysqli_real_escape_string($connect, $_POST['twitter_target_url']);
			$twitter_img = mysqli_real_escape_string($connect, $_POST['image_src3']);
			$twi_video = mysqli_real_escape_string($connect, $_POST['twi_video']);
			$hashtags = mysqli_real_escape_string($connect, $_POST['hashtags']);
			$target_url = mysqli_real_escape_string($connect, $_POST['target_url']);

			if(isset($_POST['is_public'])){
			$is_public= '1';
			}else{
			$is_public="0";
			}

			if( array_key_exists( 'create_post', $_POST ) )
			 {
			 	$sql_query_log="INSERT INTO `social_media_calendar`(`tenant_id`,`event_id`,`campaign_id`,`post_name`, `target_date`,`target_url`, `influencers`,`status_id`,`hashtags`,`public_sharing`,`is_published`,`created_by`) VALUES ('".$session_tanent_id."','".$event_id."','".$campaign_id."', '".$post_name."', '".$target_date."','".$target_url."', '".$influencers."', '".$campaign_status."','".$hashtags."', '".$is_public."', '1', '".$loggedin_userid."')";
			
				mysqli_query($connect,$sql_query_log);

				$last_insert_id = mysqli_insert_id($connect);
			}else
			{
				$sql_query_log="INSERT INTO `social_media_calendar`(`tenant_id`,`event_id`,`campaign_id`,`post_name`, `target_date`,`target_url`, `influencers`,`status_id`,`hashtags`,`public_sharing`,`is_published`,`created_by`) VALUES ('".$session_tanent_id."','".$event_id."','".$campaign_id."', '".$post_name."', '".$target_date."','".$target_url."', '".$influencers."', '".$campaign_status."','".$hashtags."', '".$is_public."', '0', '".$loggedin_userid."')";
			
				mysqli_query($connect,$sql_query_log);

				$last_insert_id = mysqli_insert_id($connect);
			}

			$directoryName="../images/social_media_planner_uploads/";
			$event_image = '';
			if($_POST['image_src']) {
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
			$fb_img=preg_replace('/[^A-Za-z]/', '',$fname1).'fb_'.date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$fb_img , base64_decode($file));	

			$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$fb_post_copy."', '".$fb_target_url."', '".$fb_img."', 'Image','".$loggedin_userid."','1')");

			mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$last_insert_id );


			$is_fb = 1;
			}

			if($_POST['image_src1']) {
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src1']),ENT_QUOTES, 'UTF-8');
			$insta_img=preg_replace('/[^A-Za-z]/', '',$fname2).'insta_'.date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$insta_img , base64_decode($file));	

			$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$insta_post_copy."', '".$insta_target_url."', '".$insta_img."', 'Image','".$loggedin_userid."','2')");

			mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$last_insert_id );


			$is_insta = 1;
			} 

			if($_POST['image_src2']) {
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src2']),ENT_QUOTES, 'UTF-8');
			$lin_img=preg_replace('/[^A-Za-z]/', '',$fname3).'lin_'.date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$lin_img , base64_decode($file));	

			$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$lin_post_copy."', '".$lin_target_url."', '".$lin_img."', 'Image','".$loggedin_userid."','3')");

			mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$last_insert_id );

			$is_linkedin = 1;
			} 

			if($_POST['image_src3']) {
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src3']),ENT_QUOTES, 'UTF-8');
			$twi_img=preg_replace('/[^A-Za-z]/', '',$fname4).'twi_'.date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$twi_img , base64_decode($file));	

			$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$twitter_post_copy."', '".$twitter_target_url."', '".$twi_img."', 'Image','".$loggedin_userid."','4')");

			mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$last_insert_id );


			$is_twitter = 1;
			}  

			if(basename($_FILES["fb_video"]["name"])!= '') {
				$temp = explode(".", $_FILES["fb_video"]["name"]);
				$fb_video_name = "fb_".round(microtime(true)) . '.' . end($temp);
				if(move_uploaded_file($_FILES["fb_video"]["tmp_name"], $directoryName . $fb_video_name))
				{
					$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_video,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$fb_post_copy."', '".$fb_target_url."', '".$fb_video_name."', 'Video','".$loggedin_userid."','1')");

						mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$last_insert_id );
				}

			$is_fb = 1;
			}

			if(basename($_FILES["insta_video"]["name"])!= '') {
				$temp = explode(".", $_FILES["insta_video"]["name"]);
				$insta_video_name = "insta_".round(microtime(true)) . '.' . end($temp);
				if(move_uploaded_file($_FILES["insta_video"]["tmp_name"], $directoryName . $insta_video_name))
				{
					$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_video,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$insta_post_copy."', '".$insta_target_url."', '".$insta_video_name."', 'Video','".$loggedin_userid."','2')");

					mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$last_insert_id );
				}


			$is_insta = 1;
			}


			if(basename($_FILES["lin_video"]["name"])!= '') {
				$temp = explode(".", $_FILES["lin_video"]["name"]);
				$lin_video_name = "lin_".round(microtime(true)) . '.' . end($temp);
				if(move_uploaded_file($_FILES["lin_video"]["tmp_name"], $directoryName . $lin_video_name))
				{
					$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_video,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$lin_post_copy."', '".$lin_target_url."', '".$lin_video_name."', 'Video','".$loggedin_userid."','3')");

					mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$last_insert_id );
				}


			$is_linkedin = 1;
			}

			if(basename($_FILES["twi_video"]["name"])!= '') {
				$temp = explode(".", $_FILES["twi_video"]["name"]);
				$twi_video_name = "twi_".round(microtime(true)) . '.' . end($temp);
				if(move_uploaded_file($_FILES["twi_video"]["tmp_name"], $directoryName . $twi_video_name))
				{
					$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_video,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$twitter_post_copy."', '".$twitter_target_url."', '".$twi_video_name."', 'Video','".$loggedin_userid."','4')");

					mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$last_insert_id );
				}

				$is_twitter = 1;
			}

				 $check_temp_exist = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$last_insert_id."' AND post_type_id = '1' ");
                    if(!$check_temp_exist || mysqli_num_rows($check_temp_exist) > 0){
                        mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$fb_post_copy."',`target_url`='".$fb_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$last_insert_id."' AND post_type_id = '1'" );
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$last_insert_id );
                    }else{
                    	if($fb_post_copy!='')
                    	{
                    		$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$fb_post_copy."', '".$fb_target_url."','".$loggedin_userid."','1')");
                         	mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$last_insert_id );
                    	}
                        
                    }

            $check_temp_exist2 = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$last_insert_id."' AND post_type_id = '2' ");
                    if(!$check_temp_exist2 || mysqli_num_rows($check_temp_exist2) > 0){
                       mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$insta_post_copy."',`target_url`='".$insta_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$last_insert_id."' AND post_type_id = '2'" );
                       mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$last_insert_id );
                    }else{
                    	if($insta_post_copy!='')
                    	{
                        $insert_smp2 = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$insta_post_copy."', '".$insta_target_url."','".$loggedin_userid."','2')");
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$last_insert_id );
                    	}
						
                    }

             $check_temp_exist3 = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$last_insert_id."' AND post_type_id = '3' ");
                    if(!$check_temp_exist3 || mysqli_num_rows($check_temp_exist3) > 0){
                      mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$lin_post_copy."',`target_url`='".$lin_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$last_insert_id."' AND post_type_id = '3'" );
                      mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$last_insert_id );
                    }else{
                    	if($lin_post_copy!='')
                    	{
                        $insert_smp3 = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$lin_post_copy."', '".$lin_target_url."','".$loggedin_userid."','3')");
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$last_insert_id );
                    	}
						
                    }

             $check_temp_exist4 = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$last_insert_id."' AND post_type_id = '4' ");
                    if(!$check_temp_exist4 || mysqli_num_rows($check_temp_exist4) > 0){
                      mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$twitter_post_copy."',`target_url`='".$twitter_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$last_insert_id."' AND post_type_id = '4'" );
                      mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$last_insert_id );
                    }else{
                    	if($insta_post_copy!='')
                    	{
                        $insert_smp4 = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$insta_post_copy."', '".$insta_target_url."','".$loggedin_userid."','4')");
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$last_insert_id );
                         }
						
                    }

			
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$last_insert_id."','Create New calender','".$last_insert_id."','".$loggedin_userid."',now(),\"".$sql_query_log."\")");
			
			$folder_name = "social-pages";

			if($is_public == 1){

				$post_name_temp = preg_replace('#\s+#', '-', $post_name);

				if($is_fb == 1){
				if(file_exists("../".$folder_name."/".$post_name_temp."-facebook.php")){
					$del_f = (unlink("../".$folder_name."/".$post_name_temp."-facebook.php"));
				}

				$myfile = fopen("../".$folder_name."/".$post_name_temp."-facebook.php", "w");
				echo copy("../test-page-1.php","../".$folder_name."/".$post_name_temp."-facebook.php"); 
				$file = '../'.$folder_name.'/'.$post_name_temp.'-facebook.php';
				$oldMessage = 'xxx';
				$newtext = $last_insert_id;
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-facebook.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-facebook.php', $str);
				$oldMessage = 'yyy';
				$newtext = '1';
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-facebook.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-facebook.php', $str);
				}

				if($is_linkedin == 1){

				if(file_exists("../".$folder_name."/".$post_name_temp."-linkedin.php")){
					unlink("../".$folder_name."/".$post_name_temp."-linkedin.php");
				}

				$myfile = fopen("../".$folder_name."/".$post_name_temp."-linkedin.php", "w");
				echo copy("../test-page-1.php","../".$folder_name."/".$post_name_temp."-linkedin.php"); 
				$file = '../'.$folder_name."/".$post_name_temp.'-linkedin.php';
				$oldMessage = 'xxx';
				$newtext = $last_insert_id;
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-linkedin.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-linkedin.php', $str);
				$oldMessage = 'yyy';
				$newtext = '3';
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-linkedin.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-linkedin.php', $str);
				}

				if($is_twitter == 1){
				
				if(file_exists("../".$folder_name."/".$post_name_temp."-twitter.php")){
					$del_t = (unlink("../".$folder_name."/".$post_name_temp."-twitter.php"));
				}

				$myfile = fopen("../".$folder_name."/".$post_name_temp."-twitter.php", "w");
				echo copy("../test-page-1.php","../".$folder_name."/".$post_name_temp."-twitter.php"); 
				$file = '../'.$folder_name."/".$post_name_temp.'-twitter.php';
				$oldMessage = 'xxx';
				$newtext = $last_insert_id;
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-twitter.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-twitter.php', $str);
				$oldMessage = 'yyy';
				$newtext = '4';
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-twitter.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-twitter.php', $str);
				}

			}


			header('Location:../social-media-management.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

		break; 

		case "edit_social_media_calendar":
		    $event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
		    $loggedin_userid = $_SESSION['user_id'];
		 	$session_tanent_id=  $common->get_tenant_id_from_userid($loggedin_userid);
		 	$post_id = mysqli_real_escape_string($connect, $_POST['post_id']);
			$campaign_id = mysqli_real_escape_string($connect, $_POST['campaign_id']);
			$target_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['target_date']) ));
			$post_name = mysqli_real_escape_string($connect, $_POST['post_name']);
			$is_public = mysqli_real_escape_string($connect, $_POST['is_public']);
			$campaign_status = mysqli_real_escape_string($connect, $_POST['campaign_status']);
			$influencers = mysqli_real_escape_string($connect, $_POST['influencers']);
			$hashtags = mysqli_real_escape_string($connect, $_POST['hashtags']);
			$target_url = mysqli_real_escape_string($connect, $_POST['target_url']);
			$fb_post_copy = mysqli_real_escape_string($connect, $_POST['fb_post_copy']);
			$fb_target_url = mysqli_real_escape_string($connect, $_POST['fb_target_url']);
			$insta_post_copy = mysqli_real_escape_string($connect, $_POST['insta_post_copy']);
			$insta_target_url = mysqli_real_escape_string($connect, $_POST['insta_target_url']);
			$lin_post_copy = mysqli_real_escape_string($connect, $_POST['lin_post_copy']);
			$lin_target_url = mysqli_real_escape_string($connect, $_POST['lin_target_url']);
			$twitter_post_copy = mysqli_real_escape_string($connect, $_POST['twitter_post_copy']);
			$twitter_target_url = mysqli_real_escape_string($connect, $_POST['twitter_target_url']);

			if(isset($_POST['is_public'])){
			$is_public= '1';
			}else{
			$is_public="0";
			}

			if( array_key_exists( 'edit_post', $_POST ) )
			 {
			 	$update_qry= "UPDATE `social_media_calendar` SET `campaign_id`='".$campaign_id."', `post_name`='".$post_name."', `target_date`='".$target_date."', `target_url`='".$target_url."', `influencers`='".$influencers."',`status_id`='".$campaign_status."', `hashtags`='".$hashtags."', `public_sharing`='".$is_public."', `is_published`='1',`created_by`='".$loggedin_userid."'  WHERE id=".$post_id;
			 	mysqli_query($connect,$update_qry);
			}else
			{
				$update_qry= "UPDATE `social_media_calendar` SET `campaign_id`='".$campaign_id."', `post_name`='".$post_name."', `target_date`='".$target_date."', `target_url`='".$target_url."', `influencers`='".$influencers."',`status_id`='".$campaign_status."', `hashtags`='".$hashtags."', `public_sharing`='".$is_public."', `is_published`='0',`created_by`='".$loggedin_userid."'  WHERE id=".$post_id;
			 	mysqli_query($connect,$update_qry);
			}

			 $check_temp_exist = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '1' ");
                    if(!$check_temp_exist || mysqli_num_rows($check_temp_exist) > 0){
                    	mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$fb_post_copy."',`target_url`='".$fb_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '1'" );
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$post_id );
                    }else{
                    	if($fb_post_copy!='')
                    	{
                    		$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$post_id."', '".$fb_post_copy."', '".$fb_target_url."','".$loggedin_userid."','1')");
                         	mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$post_id );
                    	}
                        
                    }

            $check_temp_exist2 = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '2' ");
                    if(!$check_temp_exist2 || mysqli_num_rows($check_temp_exist2) > 0){
                      mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$insta_post_copy."',`target_url`='".$insta_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '2'" );
                       mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$post_id );
                    }else{
                    	if($insta_post_copy!='')
                    	{
                        $insert_smp2 = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$post_id."', '".$insta_post_copy."', '".$insta_target_url."','".$loggedin_userid."','2')");
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$post_id );
                    	}
						
                    }

             $check_temp_exist3 = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '3' ");
                    if(!$check_temp_exist3 || mysqli_num_rows($check_temp_exist3) > 0){
                      mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$lin_post_copy."',`target_url`='".$lin_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '3'" );
                      mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$post_id );
                    }else{
                    	if($lin_post_copy!='')
                    	{
                        $insert_smp3 = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$post_id."', '".$lin_post_copy."', '".$lin_target_url."','".$loggedin_userid."','3')");
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$post_id );
                    	}
						
                    }

             $check_temp_exist4 = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '4' ");
                    if(!$check_temp_exist4 || mysqli_num_rows($check_temp_exist4) > 0){
                      mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$twitter_post_copy."',`target_url`='".$twitter_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '4'" );
                      mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$post_id );
                    }else{
                    	if($insta_post_copy!='')
                    	{
                        $insert_smp4 = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$post_id."', '".$insta_post_copy."', '".$insta_target_url."','".$loggedin_userid."','4')");
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$post_id );
                         }
						
                    }
			
			
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$post_id."','Edit calender','".$post_id."','".$loggedin_userid."',now(),\"".$sql_query_log."\")");


			$folder_name = "social-pages";

			if($is_public == 1){

				$is_fb = 1;
				$is_linkedin = 1;
				$is_twitter = 1;
				$last_insert_id = $post_id;

				$post_name_temp = preg_replace('#\s+#', '-', $post_name);

				if($is_fb == 1){
				
				if(file_exists("../".$folder_name."/".$post_name_temp."-facebook.php")){
					$del_t = (unlink("../".$folder_name."/".$post_name_temp."-facebook.php"));
				}
				$myfile = fopen("../".$folder_name."/".$post_name_temp."-facebook.php", "w");
				echo copy("../test-page-1.php","../".$folder_name."/".$post_name_temp."-facebook.php"); 
				$file = '../'.$folder_name.'/'.$post_name_temp.'-facebook.php';
				$oldMessage = 'xxx';
				$newtext = $last_insert_id;
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-facebook.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-facebook.php', $str);
				$oldMessage = 'yyy';
				$newtext = '1';
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-facebook.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-facebook.php', $str);
				}

				if($is_linkedin == 1){


				if(file_exists("../".$folder_name."/".$post_name_temp."-linkedin.php")){
					$del_t = (unlink("../".$folder_name."/".$post_name_temp."-linkedin.php"));
				}
				
				$myfile = fopen("../".$folder_name."/".$post_name_temp."-linkedin.php", "w");
				echo copy("../test-page-1.php","../".$folder_name."/".$post_name_temp."-linkedin.php"); 
				$file = '../'.$folder_name."/".$post_name_temp.'-linkedin.php';
				$oldMessage = 'xxx';
				$newtext = $last_insert_id;
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-linkedin.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-linkedin.php', $str);
				$oldMessage = 'yyy';
				$newtext = '3';
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-linkedin.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-linkedin.php', $str);
				}

				if($is_twitter == 1){
				

				if(file_exists("../".$folder_name."/".$post_name_temp."-twitter.php")){
					$del_t = (unlink("../".$folder_name."/".$post_name_temp."-twitter.php"));
				}

				$myfile = fopen("../".$folder_name."/".$post_name_temp."-twitter.php", "w");
				echo copy("../test-page-1.php","../".$folder_name."/".$post_name_temp."-twitter.php"); 
				$file = '../'.$folder_name."/".$post_name_temp.'-twitter.php';
				$oldMessage = 'xxx';
				$newtext = $last_insert_id;
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-twitter.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-twitter.php', $str);
				$oldMessage = 'yyy';
				$newtext = '4';
				$str=file_get_contents("../".$folder_name."/".$post_name_temp.'-twitter.php');
				$str=str_replace($oldMessage, $newtext,$str);
				file_put_contents("../".$folder_name."/".$post_name_temp.'-twitter.php', $str);
				}

			}

			
			header('Location:../social-media-management.php?updated-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

		break; 

		case "clone_social_media_calendar":
		    $event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
		    $loggedin_userid = $_SESSION['user_id'];
		 	$session_tanent_id=  $common->get_tenant_id_from_userid($loggedin_userid);

		 	$post_id = mysqli_real_escape_string($connect, $_POST['post_id']);
			$campaign_id = mysqli_real_escape_string($connect, $_POST['campaign_id']);
			$target_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['target_date']) ));
			$post_name = mysqli_real_escape_string($connect, $_POST['post_name']);
			$is_public = mysqli_real_escape_string($connect, $_POST['is_public']);
			$campaign_status = mysqli_real_escape_string($connect, $_POST['campaign_status']);
			$influencers = mysqli_real_escape_string($connect, $_POST['influencers']);
			$fb_post_copy = mysqli_real_escape_string($connect, $_POST['fb_post_copy']);
			$fb_target_url = mysqli_real_escape_string($connect, $_POST['fb_target_url']);
			$fb_image = mysqli_real_escape_string($connect, $_POST['image_src']);
			$fb_video = mysqli_real_escape_string($connect, $_POST['fb_video']);
			$insta_post_copy = mysqli_real_escape_string($connect, $_POST['insta_post_copy']);
			$insta_target_url = mysqli_real_escape_string($connect, $_POST['insta_target_url']);
			$insta_img = mysqli_real_escape_string($connect, $_POST['image_src1']);
			$insta_video = mysqli_real_escape_string($connect, $_POST['insta_video']);
			$lin_post_copy = mysqli_real_escape_string($connect, $_POST['lin_post_copy']);
			$lin_target_url = mysqli_real_escape_string($connect, $_POST['lin_target_url']);
			$link_img = mysqli_real_escape_string($connect, $_POST['image_src2']);
			$lin_video = mysqli_real_escape_string($connect, $_POST['lin_video']);
			$twitter_post_copy = mysqli_real_escape_string($connect, $_POST['twitter_post_copy']);
			$twitter_target_url = mysqli_real_escape_string($connect, $_POST['twitter_target_url']);
			$twitter_img = mysqli_real_escape_string($connect, $_POST['image_src3']);
			$twi_video = mysqli_real_escape_string($connect, $_POST['twi_video']);
			$hashtags = mysqli_real_escape_string($connect, $_POST['hashtags']);
			$target_url = mysqli_real_escape_string($connect, $_POST['target_url']);

			if(isset($_POST['is_public'])){
			$is_public= '1';
			}else{
			$is_public="0";
			}

			if( array_key_exists( 'create_post', $_POST ) )
			 {
			 	$sql_query_log="INSERT INTO `social_media_calendar`(`tenant_id`,`event_id`,`campaign_id`,`post_name`, `target_date`,`target_url`, `influencers`,`status_id`,`hashtags`,`public_sharing`,`is_published`,`created_by`) VALUES ('".$session_tanent_id."','".$event_id."','".$campaign_id."', '".$post_name."', '".$target_date."','".$target_url."', '".$influencers."', '".$campaign_status."','".$hashtags."', '".$is_public."', '1', '".$loggedin_userid."')";
			
				mysqli_query($connect,$sql_query_log);

				$last_insert_id = mysqli_insert_id($connect);
			}else
			{
				$sql_query_log="INSERT INTO `social_media_calendar`(`tenant_id`,`event_id`,`campaign_id`,`post_name`, `target_date`,`target_url`, `influencers`,`status_id`,`hashtags`,`public_sharing`,`is_published`,`created_by`) VALUES ('".$session_tanent_id."','".$event_id."','".$campaign_id."', '".$post_name."', '".$target_date."','".$target_url."', '".$influencers."', '".$campaign_status."','".$hashtags."', '".$is_public."', '0', '".$loggedin_userid."')";
			
				mysqli_query($connect,$sql_query_log);

				$last_insert_id = mysqli_insert_id($connect);
			}

			$directoryName="../images/social_media_planner_uploads/";
			$event_image = '';
			if($_POST['image_src']) {
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src']),ENT_QUOTES, 'UTF-8');
			$fb_img=preg_replace('/[^A-Za-z]/', '',$fname1).'fb_'.date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$fb_img , base64_decode($file));	

			$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$fb_post_copy."', '".$fb_target_url."', '".$fb_img."', 'Image','".$loggedin_userid."','1')");

			mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$last_insert_id );
			}else
			{
					$check_temp_exist = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '1' ");
                    if(!$check_temp_exist || mysqli_num_rows($check_temp_exist) > 0){
                    	$insert_note = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) select event_id,campaign_id,$last_insert_id,post_copy,target_url,post_image,post_type,$loggedin_userid,'1' from social_media_posts WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '1'");
                        $rowid=mysqli_insert_id($connect);
                    }
			}

			if($_POST['image_src1']) {
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src1']),ENT_QUOTES, 'UTF-8');
			$insta_img=preg_replace('/[^A-Za-z]/', '',$fname2).'insta_'.date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$insta_img , base64_decode($file));	

			$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$insta_post_copy."', '".$insta_target_url."', '".$insta_img."', 'Image','".$loggedin_userid."','2')");

			mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$last_insert_id );
			}else
			{
					$check_temp_exist = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '2' ");
                    if(!$check_temp_exist || mysqli_num_rows($check_temp_exist) > 0){
                    	$insert_note = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) select event_id,campaign_id,$last_insert_id,post_copy,target_url,post_image,post_type,$loggedin_userid,'2' from social_media_posts WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '2'");
                        $rowid=mysqli_insert_id($connect);
                    }
			} 

			if($_POST['image_src2']) {
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src2']),ENT_QUOTES, 'UTF-8');
			$lin_img=preg_replace('/[^A-Za-z]/', '',$fname3).'lin_'.date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$lin_img , base64_decode($file));	

			$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$lin_post_copy."', '".$lin_target_url."', '".$lin_img."', 'Image','".$loggedin_userid."','3')");

			mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$last_insert_id );
			}else
			{
					$check_temp_exist = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '3' ");
                    if(!$check_temp_exist || mysqli_num_rows($check_temp_exist) > 0){
                    	$insert_note = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) select event_id,campaign_id,$last_insert_id,post_copy,target_url,post_image,post_type,$loggedin_userid,'3' from social_media_posts WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '3'");
                        $rowid=mysqli_insert_id($connect);
                    }
			}  

			if($_POST['image_src3']) {
			$file=htmlspecialchars(mysqli_real_escape_string($connect, $_POST['image_src3']),ENT_QUOTES, 'UTF-8');
			$twi_img=preg_replace('/[^A-Za-z]/', '',$fname4).'twi_'.date('YmdHis').".jpg";
			list($type, $file) = explode(';', $file);
			list(, $file)      = explode(',', $file);
			file_put_contents($directoryName.$twi_img , base64_decode($file));	

			$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$twitter_post_copy."', '".$twitter_target_url."', '".$twi_img."', 'Image','".$loggedin_userid."','4')");

			mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$last_insert_id );
			}else
			{
					$check_temp_exist = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '4' ");
                    if(!$check_temp_exist || mysqli_num_rows($check_temp_exist) > 0){
                    	$insert_note = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_image,post_type,uploaded_by,post_type_id) select event_id,campaign_id,$last_insert_id,post_copy,target_url,post_image,post_type,$loggedin_userid,'4' from social_media_posts WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '4'");
                        $rowid=mysqli_insert_id($connect);
                    }
			}  

			if(basename($_FILES["fb_video"]["name"])!= '') {
				$temp = explode(".", $_FILES["fb_video"]["name"]);
				$fb_video_name = "fb_".round(microtime(true)) . '.' . end($temp);
				if(move_uploaded_file($_FILES["fb_video"]["tmp_name"], $directoryName . $fb_video_name))
				{
					$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_video,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$fb_post_copy."', '".$fb_target_url."', '".$fb_video_name."', 'Video','".$loggedin_userid."','1')");

						mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$last_insert_id );
				}
			}

			if(basename($_FILES["insta_video"]["name"])!= '') {
				$temp = explode(".", $_FILES["insta_video"]["name"]);
				$insta_video_name = "insta_".round(microtime(true)) . '.' . end($temp);
				if(move_uploaded_file($_FILES["insta_video"]["tmp_name"], $directoryName . $insta_video_name))
				{
					$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_video,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$insta_post_copy."', '".$insta_target_url."', '".$insta_video_name."', 'Video','".$loggedin_userid."','2')");

					mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$last_insert_id );
				}
			}


			if(basename($_FILES["lin_video"]["name"])!= '') {
				$temp = explode(".", $_FILES["lin_video"]["name"]);
				$lin_video_name = "lin_".round(microtime(true)) . '.' . end($temp);
				if(move_uploaded_file($_FILES["lin_video"]["tmp_name"], $directoryName . $lin_video_name))
				{
					$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_video,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$lin_post_copy."', '".$lin_target_url."', '".$lin_video_name."', 'Video','".$loggedin_userid."','3')");

					mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$last_insert_id );
				}
			}

			if(basename($_FILES["twi_video"]["name"])!= '') {
				$temp = explode(".", $_FILES["twi_video"]["name"]);
				$twi_video_name = "twi_".round(microtime(true)) . '.' . end($temp);
				if(move_uploaded_file($_FILES["twi_video"]["tmp_name"], $directoryName . $twi_video_name))
				{
					$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,post_video,post_type,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$last_insert_id."', '".$twitter_post_copy."', '".$twitter_target_url."', '".$twi_video_name."', 'Video','".$loggedin_userid."','4')");

					mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$last_insert_id );
				}
			}

			
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$last_insert_id."','Create New calender','".$last_insert_id."','".$loggedin_userid."',now(),\"".$sql_query_log."\")");
			
			header('Location:../social-media-management.php?created-success&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)));

		break; 

		case "collect-missing-info-social-planner":
			$tk = trim($_POST['token']);
		    $event_id = mysqli_real_escape_string($connect, $_POST['event_id']);
		 	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
		 	$post_id = mysqli_real_escape_string($connect, $_POST['post_id']);
			$influencers = mysqli_real_escape_string($connect, $_POST['influencers']);
			$hashtags = mysqli_real_escape_string($connect, $_POST['hashtags']);
			$target_url = mysqli_real_escape_string($connect, $_POST['target_url']);
			$fb_post_copy = mysqli_real_escape_string($connect, $_POST['fb_post_copy']);
			$fb_target_url = mysqli_real_escape_string($connect, $_POST['fb_target_url']);
			$insta_post_copy = mysqli_real_escape_string($connect, $_POST['insta_post_copy']);
			$insta_target_url = mysqli_real_escape_string($connect, $_POST['insta_target_url']);
			$lin_post_copy = mysqli_real_escape_string($connect, $_POST['lin_post_copy']);
			$lin_target_url = mysqli_real_escape_string($connect, $_POST['lin_target_url']);
			$twitter_post_copy = mysqli_real_escape_string($connect, $_POST['twitter_post_copy']);
			$twitter_target_url = mysqli_real_escape_string($connect, $_POST['twitter_target_url']);


			$update_qry= "UPDATE `social_media_calendar` SET `target_url`='".$target_url."', `influencers`='".$influencers."', `hashtags`='".$hashtags."' WHERE id=".$post_id;
			 	mysqli_query($connect,$update_qry);
			
			 $check_temp_exist = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '1' ");
                    if(!$check_temp_exist || mysqli_num_rows($check_temp_exist) > 0){
                    	mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$fb_post_copy."',`target_url`='".$fb_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '1'" );
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$post_id );
                    }else{
                    	if($fb_post_copy!='')
                    	{
                    		$insert_smp = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$post_id."', '".$fb_post_copy."', '".$fb_target_url."','".$loggedin_userid."','1')");
                         	mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='1' WHERE id=".$post_id );
                    	}
                        
                    }

            $check_temp_exist2 = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '2' ");
                    if(!$check_temp_exist2 || mysqli_num_rows($check_temp_exist2) > 0){
                      mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$insta_post_copy."',`target_url`='".$insta_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '2'" );
                       mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$post_id );
                    }else{
                    	if($insta_post_copy!='')
                    	{
                        $insert_smp2 = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$post_id."', '".$insta_post_copy."', '".$insta_target_url."','".$loggedin_userid."','2')");
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='1' WHERE id=".$post_id );
                    	}
						
                    }

             $check_temp_exist3 = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '3' ");
                    if(!$check_temp_exist3 || mysqli_num_rows($check_temp_exist3) > 0){
                      mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$lin_post_copy."',`target_url`='".$lin_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '3'" );
                      mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$post_id );
                    }else{
                    	if($lin_post_copy!='')
                    	{
                        $insert_smp3 = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$post_id."', '".$lin_post_copy."', '".$lin_target_url."','".$loggedin_userid."','3')");
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='1' WHERE id=".$post_id );
                    	}
						
                    }

             $check_temp_exist4 = mysqli_query($connect, "SELECT * FROM `social_media_posts` WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '4' ");
                    if(!$check_temp_exist4 || mysqli_num_rows($check_temp_exist4) > 0){
                      mysqli_query($connect, "UPDATE `social_media_posts` SET `post_copy`='".$twitter_post_copy."',`target_url`='".$twitter_target_url."' WHERE `event_id` = '".$event_id."' AND post_id = '".$post_id."' AND post_type_id = '4'" );
                      mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$post_id );
                    }else{
                    	if($insta_post_copy!='')
                    	{
                        $insert_smp4 = mysqli_query($connect,"INSERT INTO social_media_posts (event_id,campaign_id,post_id,post_copy,target_url,uploaded_by,post_type_id) VALUES ('".$event_id."','".$campaign_id."', '".$post_id."', '".$insta_post_copy."', '".$insta_target_url."','".$loggedin_userid."','4')");
                        mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='1' WHERE id=".$post_id );
                         }
						
                    }
			
			
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,sql_qry) VALUES ('".$session_tanent_id."','".$post_id."','info-collect-social-media-planner','".$post_id."',\"".$sql_query_log."\")");
			
			header('Location: ../collect-info-social-planner.php?tk='.$tk.'&info-collect-success');

		break;
      

    }

?> 