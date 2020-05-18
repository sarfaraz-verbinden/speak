<?php

//require("../includes/mysqli_connect.php");

header("Access-Control-Allow-Origin: *");
session_start();
error_reporting(1);

if(isset($_GET['action'])){
	$action=$_GET['action'];
}
else{
	$action=$_POST['action'];
}


switch($action){
	
	case "update_speaker_status":
	update_speaker_status();
	break;
	case "update_speaker_type":
	update_speaker_type();
	break;
	case "update_linkedin_url":
	update_linkedin_url();
	break;
	case "update_email_id":
	update_email_id();
	break;
	case "update_phone":
	update_phone();
	break;
	case "update_company":
	update_company();
	break;
	case "getSpeakersForBulkNotify":
	getSpeakersForBulkNotify();
	break;
	case "getSponsorsForBulkNotify":
	getSponsorsForBulkNotify();
	break;
	case "getSpeakersForBulkNotifyFromStatus":
	getSpeakersForBulkNotifyFromStatus();
	break;
	case "sponsor_update_contact_person":
	sponsor_update_contact_person();
	break;
	case "sponsor_update_email_id":
	sponsor_update_email_id();
	break;
	case "sponsor_update_phone":
	sponsor_update_phone();
	break;
	case "update_sponsor_status":
	update_sponsor_status();
	break;
	case "update_sponsor_type":
	update_sponsor_type();
	break;
	case "master_update_master_first_name":
	master_update_master_first_name();
	break;
	case "master_update_master_last_name":
	master_update_master_last_name();
	break;
	case "update_master_status":
	update_master_status();
	break;
	case "master_update_email_id":
	master_update_email_id();
	break;
	case "master_update_company":
	master_update_company();
	break;
	case "master_update_phone":
	master_update_phone();
	break;
	case "getSponsorsForBulkNotifyFromStatus":
	getSponsorsForBulkNotifyFromStatus();
	break;
	case "getSpeakersForBulkNotifyFromStatusAndType":
	getSpeakersForBulkNotifyFromStatusAndType();
	break;
	case "update_action_status":
	update_action_status();
	break;
	case "delete_action_attachment":
	delete_action_attachment();
	break;
	case "update_action_name":
	update_action_name();
	break;
	case "update_action_assign":
	update_action_assign();
	break;
	case "update_action_note":
	update_action_note();
	break;
	case "update_action_type":
	update_action_type();
	break;
	case "update_resource_name":
	update_resource_name();
	break;
	case "update_resource_type":
	update_resource_type();
	break;
	case "update_resource_description":
	update_resource_description();
	break;
	case "update_resource_url":
	update_resource_url();
	break;
	case "update_resource_owner":
	update_resource_owner();
	break;
	case "delete_resource_attachment":
	delete_resource_attachment();
	break;
	case "update_action_deadline":
	update_action_deadline();
	break;
	case "event_duplicate_check":
	event_duplicate_check();
	break;	

	case "event_duplicate_check_for_edit":
	event_duplicate_check_for_edit();
	break;

	case "check_duplicate_resource_type":
	check_duplicate_resource_type();
	break;
	case "check_duplicate_resource_type_for_edit":
	check_duplicate_resource_type_for_edit();
	break;
	

	case "get_speaker_details_by_id":
	get_speaker_details_by_id();
	break;
	case "insert_ppt_for_speaker":
	insert_ppt_for_speaker();
	break;
	case "delete_ppt_for_speaker":
	delete_ppt_for_speaker();
	break;
	case "insert_video_for_speaker":
	insert_video_for_speaker();
	break;
	case "insert_doc_website_data":
	insert_doc_website_data();
	break;
	case "insert_offer_for_speaker":
	insert_offer_for_speaker();
	break;
	case "insert_missing_speaker_data":
	insert_missing_speaker_data();
	break;
	case "get_attached_resources":
	get_attached_resources();
	break;
	case "create_master_public":
	create_master_public();
	break;
	case "insert_docs_for_speaker":
	insert_docs_for_speaker();
	break;
	case "edit_docs_for_speaker":
	edit_docs_for_speaker();
	break;
	case "insert_docs_for_new_speaker":
	insert_docs_for_new_speaker();
	break;
	case "update_preview_recent_communication_data":
	update_preview_recent_communication_data();
	break;
	case "fetch_notes_by_speakerid":
	fetch_notes_by_speakerid();
	break;
	case "fetch_docs_by_speakerid":
	fetch_docs_by_speakerid();
	break;
	// case "fetch_profile_completeness_by_speakerid":
	// fetch_profile_completeness_by_speakerid();
	// break;
	case "master_update_job_title":
	master_update_job_title();
	break;
	case "master_update_approve_status":
	master_update_approve_status();
	break;
	case "update_master_type":
	update_master_type();
	break;
	case "set_preview_perticipation_type_by_speakerid":
	set_preview_perticipation_type_by_speakerid();
	break;
	case "set_preview_requests_by_speakerid":
	set_preview_requests_by_speakerid();
	break;
	case "get_speaker_info_EP":
	get_speaker_info_EP();
	break;
	case "delete_EP_docs":
	delete_EP_docs();
	break;
	case "insert_EP_docs":
	insert_EP_docs();
	break;
	case "Get_EP_docs":
	Get_EP_docs();
	break;
	case "delete_speaker_info_EP":
	delete_speaker_info_EP();
	break;
	case "update_EP_ypet":
	update_EP_ypet();
	break;
	case "EP_update_starttime":
	EP_update_starttime();
	break;
	case "EP_update_endtime":
	EP_update_endtime();
	break;
	case "delete_Event_presentation":
	delete_Event_presentation();
	break;
	case "insert_docs_for_new_sponsor":
	insert_docs_for_new_sponsor();
	break;
	case "get_new_sponsor_documents":
	get_new_sponsor_documents();
	break;
	case "insert_docs_for_sponsor":
	insert_docs_for_sponsor();
	break;
	case "get_sponsor_documents":
	get_sponsor_documents();
	break;
	case "edit_docs_for_sponsor":
	edit_docs_for_sponsor();
	break;
	case "get_data_to_Edit_sponsor_fileinfo":
	get_data_to_Edit_sponsor_fileinfo();
	break;
	case "get_data_to_Edit_sponsorship":
	get_data_to_Edit_sponsorship();
	break;
	case "insert_speakers_from_speaker_popup":
	insert_speakers_from_speaker_popup();
	break;
	case "EP_update_enddate":
	EP_update_enddate();
	break;
	case "insert_master_from_master_popup":
	insert_master_from_master_popup();
	break;
	case "get_sponsor_details_by_id":
	get_sponsor_details_by_id();
	break;
	case "get_sponsor_preview_recent_communication_data":
	get_sponsor_preview_recent_communication_data();
	break;
	case "fetch_notes_by_sponsorid":
	fetch_notes_by_sponsorid();
	break;
	case "fetch_docs_by_sponsorid":
	fetch_docs_by_sponsorid();
	break;
	case "insert_sponsors_from_sponsor_popup":
	insert_sponsors_from_sponsor_popup();
	break;
	case "insert_ppt_for_sponsor":
	insert_ppt_for_sponsor();
	break;
	case "delete_ppt_for_sponsor":
	delete_ppt_for_sponsor();
	break;
	case "insert_video_for_sponsor":
	insert_video_for_sponsor();
	break;
	case "insert_offer_for_sponsor":
	insert_offer_for_sponsor();
	break;
	case "get_EP_details_by_id":
	get_EP_details_by_id();
	break;
	case "fetch_notes_by_ep_id":
	fetch_notes_by_ep_id();
	break;
	case "fetch_docs_by_ep_id":
	fetch_docs_by_ep_id();
	break;
	case "getSpeakersForEP_Multiselect":
	getSpeakersForEP_Multiselect();
	break;
	case "GetTotalSponsorship":
	GetTotalSponsorship();
	break;
	case "GetTotalSponsorship_new":
	GetTotalSponsorship_new();
	break;

	case "check_duplicate_template_name":
	check_duplicate_template_name();
	break;
	case "delete_speaker_info_EP_new":
	delete_speaker_info_EP_new();
	break;
	case "get_speaker_info_EP_new":
	get_speaker_info_EP_new();
	break;
	case "get_all_events_selected":
	get_all_events_selected();
	break;

	case "set_session_google_login":
	set_session_google_login();
	break;
	case "check_email_existance_signup":
	check_email_existance_signup();
	break;
	case "fetch_uploaded_masters_from_temp":
	fetch_uploaded_masters_from_temp();
	break;
	case "check_duplicate_sponsor_status":
	check_duplicate_sponsor_status();
	break;
	case "check_duplicate_sponsor_type_for_edit":
	check_duplicate_sponsor_type_for_edit();
	break;
	case "check_duplicate_sponsor_type":
	check_duplicate_sponsor_type();
	break;
	case "get_speaker_missing_perc":
	get_speaker_missing_perc();
	break;
	case "set_session_select_all":
	set_session_select_all();
	break;
	case "check_uncheck_call":
	check_uncheck_call();
	break;
	case "delete_multi_speaker":
	delete_multi_speaker();
	break;
	case "set_session_select_all_new_speakers":
	set_session_select_all_new_speakers();
	break;
	case "set_session_select_all_sponsors":
	set_session_select_all_sponsors();
	break;
	case "check_uncheck_call_sponsors":
	check_uncheck_call_sponsors();
	break;
	case "delete_multi_sponsors":
	delete_multi_sponsors();
	break;
	case "set_session_select_all_masters":
	set_session_select_all_masters();
	break;
	case "check_uncheck_call_masters":
	check_uncheck_call_masters();
	break;
	case "delete_multi_masters":
	delete_multi_masters();
	break;
	case "set_session_select_all_new_masters":
	set_session_select_all_new_masters();
	break;
	case "sponsor_logo_upload":
	sponsor_logo_upload();
	break;
	case "tenant_duplicate_check":
	tenant_duplicate_check();
	break;
	case "update_multi_speaker":
	update_multi_speaker();
	break;
	case "update_multi_master":
	update_multi_master();
	break;
	case "update_multi_sponsor":
	update_multi_sponsor();
	break;
	case "insert_save_time_plan":
	insert_save_time_plan();
	break;
	case "insert_get_in_touch":
	insert_get_in_touch();
	break;
	case "contact_us_enterprise_pricing":
	contact_us_enterprise_pricing();
	break;
	case "get_subject_by_epid":
	get_subject_by_epid();
	break;
	case "get_event_agenda_info":
	get_event_agenda_info();
	break;

	case "insert_email_templates_from_popup":
	insert_email_templates_from_popup();
	break;

	//****camapign management****
	case "update_postname":
	update_postname();
	break;
	case "update_target_url":
	update_target_url();
	break;
	case "update_hashtags":
	update_hashtags();
	break;
	case "update_post_status":
	update_post_status();
	break;
	case "update_fb_check":
	update_fb_check();
	break;
	case "update_insta_check":
	update_insta_check();
	break;
	case "update_lin_check":
	update_lin_check();
	break;
	case "update_twi_check":
	update_twi_check();
	break;
	case "delete_socialplanner_docs":
	delete_socialplanner_docs();
	break;
	case "delete_list_view":
	delete_list_view();
	break;
	case "get_calendar_details_by_id":
	get_calendar_details_by_id();
	break;
	case "get_fb_details_by_id":
	get_fb_details_by_id();
	break;
	case "get_insta_details_by_id":
	get_insta_details_by_id();
	break;
	case "get_lin_details_by_id":
	get_lin_details_by_id();
	break;
	case "get_twitter_details_by_id":
	get_twitter_details_by_id();
	break;
	case "social_media_planner_request_info":
	social_media_planner_request_info();
	break;
	case "update_targetdate":
	update_targetdate();
	break;

	

}


function update_speaker_status(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$status_id = trim(mysqli_real_escape_string($connect, $_POST['status_id']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );


	$update_status = mysqli_query($connect,"UPDATE `all_speakers` set `status` = '$status_id' where `id` = '$rec_id' ");

	$all_speakers_array = calculate_speaker_dashboard_count($event_id);
	$speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as status_id FROM all_status WHERE event_id = '".$event_id."' ");
            if(mysqli_num_rows($speakers_data1) > 0)
            {  
                $res1 = mysqli_fetch_array($speakers_data1);
                $row_id = $res1['status_id'];
                $status_ids_array1 = explode(",",$row_id);

                foreach ($status_ids_array1 as $statusid) { 
                if($statusid!=0)
                {

                    $query_sql_sp = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_speakers WHERE all_speakers.status='".$statusid."' and all_speakers.event_id='".$event_id."'");
                    $query_res_sp = mysqli_fetch_array($query_sql_sp);
                    $count_spk_res = mysqli_real_escape_string($connect,$query_res_sp['count_spk']);
                
                    $update_status_details = mysqli_query($connect, "UPDATE `all_status` SET `count_of_speaker_usage`='".$count_spk_res."'   WHERE id=".$statusid);

                }

             }
           }

           
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_speaker_type(){

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$speaker_type_value = trim(mysqli_real_escape_string($connect, $_POST['speaker_type_value']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );


	$update_status = mysqli_query($connect,"UPDATE `all_speakers` set `speaker_type` = '$speaker_type_value' where `id` = '$id' ");

	$all_speakers_array = calculate_speaker_dashboard_count($event_id);
	 $speakers_data2 = mysqli_query($connect,"SELECT group_concat(id) as type_id FROM all_speaker_types WHERE event_id = '".$event_id."' ");
            if(mysqli_num_rows($speakers_data2) > 0)
            {  
                $res2 = mysqli_fetch_array($speakers_data2);
                $row_id2 = $res2['type_id'];
                $status_ids_array2 = explode(",",$row_id2);

                foreach ($status_ids_array2 as $typeid2) { 
                if($typeid2!=0)
                {

                    $query_sql_sp2 = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_speakers WHERE find_in_set('".$typeid2."',all_speakers.speaker_type) and all_speakers.event_id='".$event_id."'");
                    $query_res_sp2 = mysqli_fetch_array($query_sql_sp2);
                    $count_spk_res2 = mysqli_real_escape_string($connect,$query_res_sp2['count_spk']);
                
                    $update_status_details2 = mysqli_query($connect, "UPDATE `all_speaker_types` SET `count_of_speaker_usage`='".$count_spk_res2."'   WHERE id=".$typeid2);

                }

             }
           }
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}
 
function update_master_type(){

	//require("include/mysqli_connect.php");
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();
	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$master_type_value = trim(mysqli_real_escape_string($connect, $_POST['master_type_value']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	
	$update_status = mysqli_query($connect,"UPDATE `all_masters` set `master_type` = '".$master_type_value."' where `id` = '$id' ");

	$type_update = $common->calculate_master_type_count($event_id);

	/*var_dump($update_status);
	var_dump("UPDATE `all_masters` set `master_type` = '".$master_type_value."' where `id` = '$id' ");
	 exit();*/
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array); 
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}


function update_action_status(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$status_id = trim(mysqli_real_escape_string($connect, $_POST['status_id']) );


	$update_status = mysqli_query($connect,"UPDATE `action_trackers` SET `status` = '$status_id' WHERE `id`=".$rec_id);
	 	// echo "UPDATE `action_trackers` set `status` = '$status_id' where `id` = '$rec_id'"; exit();
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function update_action_type(){

require("include/mysqli_connect.php");
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$type_id = trim(mysqli_real_escape_string($connect, $_POST['type_id']) );
	$update_type = mysqli_query($connect,"UPDATE `action_trackers` set `action_category`='$type_id' where `id` = '$rec_id' ");
	 
	 if($update_type){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function update_resource_type(){

require("include/mysqli_connect.php");
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$type_id = trim(mysqli_real_escape_string($connect, $_POST['type_id']) );
	$update_type = mysqli_query($connect,"UPDATE `resource_trackers` set `resource_category`='$type_id' where `id` = '$rec_id' ");
	 
	 if($update_type){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function update_resource_description(){

require("include/mysqli_connect.php");
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['id']) );
	$description = trim(mysqli_real_escape_string($connect, $_POST['description']) );
	$update_des = mysqli_query($connect,"UPDATE `resource_trackers` set `description`='$description' where `id` = '$rec_id' ");
	 
	 if($update_des){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}


function delete_action_attachment(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );

	$update_attachment = mysqli_query($connect,"UPDATE `action_trackers` set `attachment` = '' where `id` = '$rec_id' ");
	 
	 if($update_attachment){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function delete_resource_attachment(){
	require("include/mysqli_connect.php");
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );

	$update_attachment = mysqli_query($connect,"UPDATE `resource_trackers` set `attachment` = '' where `id` = '$rec_id' ");
	 
	 if($update_attachment){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	

		}
		

}

function update_action_name(){

	require("include/mysqli_connect.php");
	$event_id= trim(mysqli_real_escape_string($connect, $_POST['event_id']) );

	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['id']) );
	$action_name = trim(mysqli_real_escape_string($connect, $_POST['action_name']) );


	$duplicate_check = mysqli_query($connect,"SELECT * FROM `action_trackers` WHERE `action` = '$action_name' AND `event_id` = '$event_id' AND id != '".$id."' ");
	if(mysqli_num_rows($duplicate_check) > 0 ){

			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;
			$inner_array['message'] = 'Action name already exist';		
			$final_array[] = $inner_array;
			echo json_encode($final_array);

	}else{

		$update_action_name = mysqli_query($connect,"UPDATE `action_trackers` set `action` = '$action_name' where `id` = '$id' ");
	 
	 if($update_action_name){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;
			$inner_array['message'] = 'Updated successfully';		
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$inner_array['message'] = 'Something Went wrong! Please try again later';	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}
}

function update_resource_name(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$id = trim(mysqli_real_escape_string($connect, $_POST['id']) );
	$resource_name = trim(mysqli_real_escape_string($connect, $_POST['resource_name']) );

	$update_action_name = mysqli_query($connect,"UPDATE `resource_trackers` set `resource` = '$resource_name' where `id` = '$id' ");	 
	 if($update_action_name){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function update_resource_url(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$id = trim(mysqli_real_escape_string($connect, $_POST['id']) );
	$url = trim(mysqli_real_escape_string($connect, $_POST['url']) );

	$update_resource_url = mysqli_query($connect,"UPDATE `resource_trackers` set `url` = '$url' where `id` = '$id' ");	 
	 if($update_resource_url){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

//
function update_resource_owner(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$id = trim(mysqli_real_escape_string($connect, $_POST['id']) );
	$owner = trim(mysqli_real_escape_string($connect, $_POST['owner']) );

	$update_resource_owner = mysqli_query($connect,"UPDATE `resource_trackers` set `owner` = '$owner' where `id` = '$id' ");	 
	 if($update_resource_owner){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}




function update_action_assign(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['id']) );
	$assign_to = trim(mysqli_real_escape_string($connect, $_POST['assign_to']) );

	$update_action_assign = mysqli_query($connect,"UPDATE `action_trackers` set `assign_to` = '$assign_to' where `id` = '$id' ");
	 
	 if($update_action_assign){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}


function update_action_note(){
	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['id']) );
	$action_note = trim(mysqli_real_escape_string($connect, $_POST['action_note']) );

	$update_action_note = mysqli_query($connect,"UPDATE `action_trackers` set `note` = '$action_note' where `id` = '$id' ");
	 
	 if($update_action_note){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

}

function update_action_deadline(){

require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['id']) );
	$deadline = date("Y-m-d",strtotime(trim(mysqli_real_escape_string($connect, $_POST['deadline']))));

	$update_action_deadline = mysqli_query($connect,"UPDATE `action_trackers` set `deadline` = '$deadline' where `id` = '$id' ");
	 
	 if($update_action_deadline){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function event_duplicate_check(){

	require("include/mysqli_connect.php");
	$final_array = array();
	if(!isset($_SESSION)){ session_start(); }
    $user_id = $_SESSION['user_id'];
    $fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_users where user_id='".$user_id."' ");   
    $res_sql = mysqli_fetch_array($fetch_sql);
    $tanent_id= $res_sql['tanent_id'];

	$event_name = trim(mysqli_real_escape_string($connect, $_POST['event_name']) );	

	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_events WHERE LOWER(event_name) = '".strtolower($event_name)."' and tanent_id='".$tanent_id."' ");
	$res_count = mysqli_num_rows($check_duplicate);
	 
	 if($res_count > 0){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function check_duplicate_resource_type(){

	require("include/mysqli_connect.php");
	$final_array = array();
	// $event_id= $_SESSION['current_event_id'];
	
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );	
	$resource_name = trim(mysqli_real_escape_string($connect, $_POST['resource_name']) );	

	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_resource_types WHERE resource_type_name = '$resource_name' AND event_id = '".$event_id."' ");
	$res_count = mysqli_num_rows($check_duplicate);
	 
	 if($res_count > 0){  
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}


function check_duplicate_template_name(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$event_id= trim(mysqli_real_escape_string($connect, $_POST['event_id']) );

	$template_name = trim(mysqli_real_escape_string($connect, $_POST['template_name']) );	

	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_email_templates WHERE template_name = '$template_name' AND (event_id = '".$event_id."' OR event_id = 'all') ");

	$res_count = mysqli_num_rows($check_duplicate);
	 
	 if($res_count > 0){  
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function check_duplicate_resource_type_for_edit(){

	require("include/mysqli_connect.php");
	$final_array = array();
	// $event_id= $_SESSION['current_event_id'];
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );	
	$resource_name = trim(mysqli_real_escape_string($connect, $_POST['resource_name']) );	
	$resource_type_id = trim(mysqli_real_escape_string($connect, $_POST['resource_type_id']) );
	
	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_resource_types WHERE resource_type_name = '".$resource_name."' AND id != '".$resource_type_id."' AND event_id = '".$event_id."' ");
	$res_count = mysqli_num_rows($check_duplicate);
	 
	 if($res_count > 0){  
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function event_duplicate_check_for_edit(){

require("include/mysqli_connect.php");
	$final_array = array();
	if(!isset($_SESSION)){ session_start(); }
    $user_id = $_SESSION['user_id'];
    $fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_users where user_id='".$user_id."' ");   
    $res_sql = mysqli_fetch_array($fetch_sql);
    $tanent_id= $res_sql['tanent_id'];

	$event_name = trim(mysqli_real_escape_string($connect, $_POST['event_name']) );
	$id = trim(mysqli_real_escape_string($connect, $_POST['id']) );


	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_events WHERE event_name LIKE '%".$event_name."%' AND id != ".$id." and tanent_id='".$tanent_id."' ");
	$res_count = mysqli_num_rows($check_duplicate);
	 
	 if($res_count > 0){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}


function update_linkedin_url(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$linkedin_url = trim(mysqli_real_escape_string($connect, $_POST['linkedin_url']) );


	$update_status = mysqli_query($connect,"UPDATE `all_speakers` set `linkedin_url` = '$linkedin_url' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_email_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$email_id = trim(mysqli_real_escape_string($connect, $_POST['email_id']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );

	$check_duplicate = mysqli_query($connect,"SELECT * FROM `all_speakers` where `email_id` = '".$email_id."' AND `event_id`= '".$event_id."' AND  `id` != '".$id."' ");

	if(mysqli_num_rows($check_duplicate) > 0){
		$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;
			$inner_array['is_duplicate'] = true;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);

	}else{

	$update_status = mysqli_query($connect,"UPDATE `all_speakers` set `email_id` = '$email_id' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;
			$inner_array['is_duplicate'] = false;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$inner_array['is_duplicate'] = false;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 

	}
	
}

function update_phone(){

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$phone = trim(mysqli_real_escape_string($connect, $_POST['phone']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );

	$update_status = mysqli_query($connect,"UPDATE `all_speakers` set `phone` = '$phone' where `id` = '$id' ");

	$all_speakers_array = calculate_speaker_dashboard_count($event_id);
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function master_update_phone(){

	require("include/mysqli_connect.php");
	$final_array = array();
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$phone = trim(mysqli_real_escape_string($connect, $_POST['phone']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );

	$update_status = mysqli_query($connect,"UPDATE `all_masters` set `phone` = '$phone' where `id` = '$id' ");
	 
	 if($update_status){

	 		$all_masters_count_sp = calculate_master_dashboard_count($event_id);

	 		//var_dump("calculate_master_dashboard_count($event_id)");exit();
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function update_company(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$company = trim(mysqli_real_escape_string($connect, $_POST['company']) );


	$update_status = mysqli_query($connect,"UPDATE `all_speakers` set `company` = '$company' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function getSpeakersForBulkNotify(){

	require("include/mysqli_connect.php");

	$event_id=$_POST['event_id'];
	//var_dump($event_id);exit();
	$final_array = array();
	$speakes_options=array();
	$values_arr = $_POST['values'];
	if(!$values_arr){
		$speakers_list = mysqli_query($connect,"SELECT *  FROM`all_speakers` WHERE event_id = '".$event_id."' ORDER BY speaker_name ASC ");
			while($row = mysqli_fetch_array($speakers_list)){
				echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
			}
	}
	if(count($values_arr)){
		foreach($values_arr as $val){
			$speakers_list = mysqli_query($connect,"SELECT *  FROM`all_speakers` WHERE FIND_IN_SET('".$val."', speaker_type)>0 AND event_id = '".$event_id."' ");
			while($row = mysqli_fetch_array($speakers_list)){
				//echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
				array_push($speakes_options,$row['speaker_name']."_".$row['id']);
				
			}
		}
		$arr1 = array_unique($speakes_options);
		sort($arr1);
		foreach($arr1 as $speakes_option){
			$expl = explode("_",$speakes_option);
			echo "<option  value='".$expl[1]."' >".$expl[0]."</option>";
		}
	}else{
		$speakers_list = mysqli_query($connect,"SELECT *  FROM `all_speakers` WHERE event_id = '".$event_id."' ORDER BY speaker_name ASC ");
			while($row = mysqli_fetch_array($speakers_list)){
				echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
			}
	}
	
}

function getSponsorsForBulkNotify(){

	require("include/mysqli_connect.php");
	$event_id= $_POST['event_id'];
	$final_array = array();
	$speakes_options=array();
	$values_arr = $_POST['values'];
	if(!$values_arr){
		$sponsors_list = mysqli_query($connect,"SELECT *  FROM`all_sponsors` WHERE event_id = '".$event_id."' ORDER BY sponsor_company_name ASC ");
			while($row = mysqli_fetch_array($sponsors_list)){
				echo "<option  value='".$row['id']."' >".$row['sponsor_company_name']."</option>";
				
			}
	}
	if(count($values_arr)){
		foreach($values_arr as $val){
			$sponsors_list = mysqli_query($connect,"SELECT *  FROM`all_sponsors` WHERE event_id = '".$event_id."' and  FIND_IN_SET('".$val."', sponsor_type)>0 ");
			while($row = mysqli_fetch_array($sponsors_list)){
				//echo "<option  value='".$row['id']."' >".$row['sponsor_company_name']."</option>";
				
				array_push($speakes_options,$row['sponsor_company_name']."_".$row['id']);
				
			}
		}
		$arr1 = array_unique($speakes_options);
		sort($arr1);
		foreach($arr1 as $speakes_option){
			$expl = explode("_",$speakes_option);
			echo "<option  value='".$expl[1]."' >".$expl[0]."</option>";
		}
	}else{
		$sponsors_list = mysqli_query($connect,"SELECT *  FROM`all_sponsors` WHERE event_id = '".$event_id."' ORDER BY sponsor_company_name ASC ");
			while($row = mysqli_fetch_array($sponsors_list)){
				echo "<option  value='".$row['id']."' >".$row['sponsor_company_name']."</option>";
				
			}
	}	
}

function getSponsorsForBulkNotifyFromStatus(){

	require("include/mysqli_connect.php");
	$event_id= $_POST['event_id'];
	$final_array = array();
	$speakes_options=array();
	$values_arr = $_POST['values'];
	if(!$values_arr){
		$speakers_list = mysqli_query($connect,"SELECT *  FROM`all_sponsors` WHERE event_id = '".$event_id."' ORDER BY sponsor_company_name ASC ");
			while($row = mysqli_fetch_array($speakers_list)){
				echo "<option  value='".$row['id']."' >".$row['sponsor_company_name']."</option>";
				
			}
	}
	if(count($values_arr)){
		foreach($values_arr as $val){
			
			$speakers_list = mysqli_query($connect,"SELECT *  FROM `all_sponsors` WHERE  event_id = '".$event_id."' and FIND_IN_SET('".$val."',status)>0 ") ;
			while($row = mysqli_fetch_array($speakers_list)){
				//echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
				array_push($speakes_options,$row['sponsor_company_name']."_".$row['id']);
				
			}
		}
		$arr1 = array_unique($speakes_options);
		sort($arr1);
		foreach($arr1 as $speakes_option){
			$expl = explode("_",$speakes_option);
			echo "<option  value='".$expl[1]."' >".$expl[0]."</option>";
		}
	}else{
		$speakers_list = mysqli_query($connect,"SELECT *  FROM`all_sponsors` WHERE event_id = '".$event_id."' ORDER BY sponsor_company_name ASC ");
			while($row = mysqli_fetch_array($speakers_list)){
				echo "<option  value='".$row['id']."' >".$row['sponsor_company_name']."</option>";
				
			}
	}
	
}

function getSpeakersForBulkNotifyFromStatus(){

	require("include/mysqli_connect.php");

	$event_id= $_POST['event_id'];
	$final_array = array();
	$speakes_options=array();	
	$values_arr = $_POST['values'];
	//var_dump($values_arr); exit();

	if(!$values_arr){
		$speakers_list = mysqli_query($connect,"SELECT *  FROM `all_speakers` WHERE event_id = '".$event_id."' ORDER BY speaker_name ASC ");
			while($row = mysqli_fetch_array($speakers_list)){
				echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
			}
	}
	if(count($values_arr)){
		foreach($values_arr as $val){
			
			$speakers_list = mysqli_query($connect,"SELECT *  FROM `all_speakers` WHERE FIND_IN_SET('".$val."',status)>0 AND event_id = '".$event_id."' ");
			while($row = mysqli_fetch_array($speakers_list)){
				//echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
				array_push($speakes_options,$row['speaker_name']."_".$row['id']);
				
			}
		}
		$arr1 = array_unique($speakes_options);
		sort($arr1);
		foreach($arr1 as $speakes_option){
			$expl = explode("_",$speakes_option);
			echo "<option  value='".$expl[1]."' >".$expl[0]."</option>";
		}
	}else{
		$speakers_list = mysqli_query($connect,"SELECT *  FROM `all_speakers` WHERE event_id = '".$event_id."' ORDER BY speaker_name ASC ");
			while($row = mysqli_fetch_array($speakers_list)){
				echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
			}
	}
	
}

function getSpeakersForBulkNotifyFromStatusAndType(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$speakes_options=array();
	$values_arr = $_POST['values'];
	$event_id= $_SESSION['current_event_id'];
	if(!$values_arr){
		$speakers_list = mysqli_query($connect,"SELECT *  FROM`all_speakers` WHERE event_id = '".$event_id."' ORDER BY speaker_name ASC ");
			while($row = mysqli_fetch_array($speakers_list)){
				echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
			}
	}
	if(count($values_arr)){
		foreach($values_arr as $val){
			
			$speakers_list = mysqli_query($connect,"SELECT *  FROM `all_speakers` WHERE FIND_IN_SET('".$val."',status)>0 AND event_id = '".$event_id."'");
			while($row = mysqli_fetch_array($speakers_list)){
				//echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
				array_push($speakes_options,$row['speaker_name']."_".$row['id']);
				
			}
		}
		$arr1 = array_unique($speakes_options);
		sort($arr1);
		foreach($arr1 as $speakes_option){
			$expl = explode("_",$speakes_option);
			echo "<option  value='".$expl[1]."' >".$expl[0]."</option>";
		}
	}else{
		$speakers_list = mysqli_query($connect,"SELECT *  FROM`all_speakers` WHERE event_id = '".$event_id."' ORDER BY speaker_name ASC ");
			while($row = mysqli_fetch_array($speakers_list)){
				echo "<option  value='".$row['id']."' >".$row['speaker_name']."</option>";
				
			}
	}
	
}

function sponsor_update_contact_person(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$contact_person = trim(mysqli_real_escape_string($connect, $_POST['contact_person']) );


	$update_status = mysqli_query($connect,"UPDATE `all_sponsors` set `sponsor_contact_person` = '$contact_person' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function sponsor_update_email_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$email_id = trim(mysqli_real_escape_string($connect, $_POST['email_id']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );

	$check_duplicate = mysqli_query($connect,"SELECT * FROM `all_sponsors` where `sponsor_contact_email_address`= '".$email_id."' and `event_id`= '".$event_id."' AND  `id` != '".$id."' ");

	if(mysqli_num_rows($check_duplicate) > 0){
		$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;
			$inner_array['dup_check'] = true;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);

	}else{
		$update_status = mysqli_query($connect,"UPDATE `all_sponsors` set `sponsor_contact_email_address` = '$email_id' where `id` = '".$id."' ");	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;
			$inner_array['dup_check'] = false;		
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$inner_array['dup_check'] = false;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	}
}

function sponsor_update_phone(){

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$phone = trim(mysqli_real_escape_string($connect, $_POST['phone']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );


	$update_status = mysqli_query($connect,"UPDATE `all_sponsors` set `sponsor_contact_number` = '$phone' where `id` = '$id' ");
	 $all_speakers_array = calculate_sponsor_dashboard_count($event_id);
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_sponsor_status(){

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$status_id = trim(mysqli_real_escape_string($connect, $_POST['status_id']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );


	$update_status = mysqli_query($connect,"UPDATE `all_sponsors` set `status` = '$status_id' where `id` = '$rec_id' ");
	$all_speakers_array = calculate_sponsor_dashboard_count($event_id);
	
	$speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as status_id FROM all_status WHERE event_id = '".$event_id."' and status_for='sponsor' ");
            if(mysqli_num_rows($speakers_data1) > 0)
            {  
                $res1 = mysqli_fetch_array($speakers_data1);
                $row_id = $res1['status_id'];
                $status_ids_array1 = explode(",",$row_id);

                foreach ($status_ids_array1 as $statusid) { 
                if($statusid!=0)
                {

                    $query_sql_sp = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_sponsors WHERE all_sponsors.status='".$statusid."' and all_sponsors.event_id='".$event_id."'");
                    $query_res_sp = mysqli_fetch_array($query_sql_sp);
                    $count_spk_res = mysqli_real_escape_string($connect,$query_res_sp['count_spk']);
                
                    $update_status_details = mysqli_query($connect, "UPDATE `all_status` SET `count_of_speaker_usage`='".$count_spk_res."'   WHERE id=".$statusid);

                }

             }
           }
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_sponsor_type(){

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$sponsor_type_value = trim(mysqli_real_escape_string($connect, $_POST['sponsor_type_value']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );


	$update_status = mysqli_query($connect,"UPDATE `all_sponsors` set `sponsor_type` = '$sponsor_type_value' where `id` = '$id' ");
	$all_speakers_array = calculate_sponsor_dashboard_count($event_id);
	$speakers_data2 = mysqli_query($connect,"SELECT group_concat(id) as type_id FROM all_sponsor_types WHERE event_id = '".$event_id."' ");
            if(mysqli_num_rows($speakers_data2) > 0)
            {  
                $res2 = mysqli_fetch_array($speakers_data2);
                $row_id2 = $res2['type_id'];
                $status_ids_array2 = explode(",",$row_id2);

                foreach ($status_ids_array2 as $typeid) { 
                if($typeid!=0)
                {

                    $query_sql_sp2 = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_sponsors WHERE find_in_set('".$typeid."',all_sponsors.sponsor_type) and all_sponsors.event_id='".$event_id."'");
                    $query_res_sp2 = mysqli_fetch_array($query_sql_sp2);
                    $count_spk_res2 = mysqli_real_escape_string($connect,$query_res_sp2['count_spk']);
                
                    $update_status_details2 = mysqli_query($connect, "UPDATE `all_sponsor_types` SET `total_enrolled`='".$count_spk_res2."'   WHERE id=".$typeid);

                }

             }
           }
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function master_update_master_last_name(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$master_last_name = trim(mysqli_real_escape_string($connect, $_POST['master_last_name']) );


	$update_status = mysqli_query($connect,"UPDATE `all_masters` set `master_lastname` = '$master_last_name' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 	
}


function master_update_master_first_name(){
	require("include/mysqli_connect.php");
	$final_array = array();
	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$master_first_name = trim(mysqli_real_escape_string($connect, $_POST['master_first_name']) );


	$update_status = mysqli_query($connect,"UPDATE `all_masters` set `master_name` = '$master_first_name' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 	
}



function update_master_status(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$status_id = trim(mysqli_real_escape_string($connect, $_POST['status_id']) );


	$update_status = mysqli_query($connect,"UPDATE `all_masters` set `status` = '$status_id' where `id` = '$rec_id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function master_update_email_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$email_id = trim(mysqli_real_escape_string($connect, $_POST['email_id']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );

	$check_duplicate = mysqli_query($connect,"SELECT * FROM `all_masters` where `email_id` = '".$email_id."' AND `event_id`= '".$event_id."' AND  `id` != '".$id."' ");

	if(mysqli_num_rows($check_duplicate) > 0){
		$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;
			$inner_array['is_duplicate'] = true;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);

	}else{

	$update_status = mysqli_query($connect,"UPDATE `all_masters` set `email_id` = '$email_id' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;
			$inner_array['is_duplicate'] = false;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$inner_array['is_duplicate'] = false;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 

	}
	
}

function master_update_company(){

	require("include/mysqli_connect.php");
	$final_array = array();
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$company = trim(mysqli_real_escape_string($connect, $_POST['company']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );

	$update_status = mysqli_query($connect,"UPDATE `all_masters` set `company` = '$company' where `id` = '$id' ");
	 
	 if($update_status){
	 	$all_masters_count_sp = calculate_master_dashboard_count($event_id);
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function master_update_job_title(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$job_title = trim(mysqli_real_escape_string($connect, $_POST['job_title']) );

	$update_status = mysqli_query($connect,"UPDATE `all_masters` set `job_title` = '$job_title' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 	
}

function master_update_approve_status(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$status_val = trim(mysqli_real_escape_string($connect, $_POST['status_val']) );

	$update_status = mysqli_query($connect,"UPDATE `all_masters` set `is_approved` = '$status_val' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 	
}







function get_speaker_details_by_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['sp_id']) );

	$speaker_details = mysqli_query($connect,"SELECT *,(select country_name from countries where countries.country_id=country) as country_name,(select state_name from states where states.state_id=state) as state_name FROM `all_speakers` where `id` = '$id' ");
	 
	 if(mysqli_num_rows($speaker_details) > 0){
			$inner_array = array();
			$res = mysqli_fetch_array($speaker_details);
			$final_array[] = $res;
			//$final_array[] = $inner_array;
			//echo json_encode($final_array); 

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
}

function insert_ppt_for_speaker(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$speaker_id = mysqli_real_escape_string($connect, trim($_POST['speaker_id']) );
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$ppt_token = mysqli_real_escape_string($connect, trim($_POST['ppt_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$ppt_url = mysqli_real_escape_string($connect, trim($_POST['ppt_url']) );
	$doc_type = mysqli_real_escape_string($connect, trim($_POST['doc_type']) );

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$ppt_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
	}

	$insert_documentation = mysqli_query($connect,"INSERT INTO `speaker_documents` ( speaker_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type) VALUES ('".$speaker_id."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$ppt_url."','0','".$publish_externally."','".$doc_type."') ");
		 
	 if($insert_documentation){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Powerpoint has been uploaded successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function delete_ppt_for_speaker(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$speaker_id = mysqli_real_escape_string($connect, trim($_POST['speaker_id']) );
	$doc_id = mysqli_real_escape_string($connect, trim($_POST['doc_id']) );

	$delete_doc = mysqli_query($connect,"UPDATE `speaker_documents` SET `is_deleted` = '1' WHERE `id` = '$doc_id' AND speaker_id = '".$speaker_id."'  ");
		 
	 if($delete_doc){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Document has been deleted successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}

function insert_video_for_speaker(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$speaker_id = mysqli_real_escape_string($connect, trim($_POST['speaker_id']) );
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$video_token = mysqli_real_escape_string($connect, trim($_POST['video_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$vdo_url = mysqli_real_escape_string($connect, trim($_POST['vdo_url']) );
	$doc_type = mysqli_real_escape_string($connect, trim($_POST['doc_type']) );

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$video_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
	}

	$insert_documentation = mysqli_query($connect,"INSERT INTO `speaker_documents` ( speaker_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type) VALUES ('".$speaker_id."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$vdo_url."','0','".$publish_externally."','".$doc_type."') ");
		 
	 if($insert_documentation){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Video has been uploaded successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

}



function insert_doc_website_data(){

		require("include/mysqli_connect.php");
		$final_array = array();
		$speaker_id = mysqli_real_escape_string($connect, trim($_POST['speaker_id']) );
		$website_name = mysqli_real_escape_string($connect, trim($_POST['website_name']) );
		$website_url = mysqli_real_escape_string($connect, trim($_POST['website_url']) );
		

		$insert_speaker_website_data = mysqli_query($connect,"UPDATE `all_speakers` SET `website_name`='".$website_name."',`website_url`='".$website_url."' WHERE `id`= '$speaker_id' ");
			 
		 if($insert_speaker_website_data){
				$inner_array = array();
				$inner_array['status'] = 'success';
				$inner_array['message'] = 'Data has been updated successfully.';
				$final_array[] = $inner_array;

				echo json_encode($final_array);
			}
			else{
				$inner_array = array();
				$inner_array['status'] = 'failure';
				$inner_array['message'] = 'Something went wrong! Please try again.';

				$final_array[] = $inner_array;
				echo json_encode($final_array);	
			}

}


function insert_offer_for_speaker(){

		require("include/mysqli_connect.php");
		$final_array = array();
		$speaker_id = mysqli_real_escape_string($connect, trim($_POST['speaker_id']) );
		$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
		$offer_token = mysqli_real_escape_string($connect, trim($_POST['offer_token']) );
		$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
		$offer_url = mysqli_real_escape_string($connect, trim($_POST['offer_url']) );
		$doc_type = mysqli_real_escape_string($connect, trim($_POST['doc_type']) );

		$uploaded_file_name = '';
		$uploaded_file_extension = '';

		$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$offer_token' ORDER BY id DESC LIMIT 1 ");
		if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
			$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
			$uploaded_file_name = $res_file['filename'];
			$uploaded_file_extension = end(explode('.', $uploaded_file_name));
		}

		$insert_documentation = mysqli_query($connect,"INSERT INTO `speaker_documents` ( speaker_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type) VALUES ('".$speaker_id."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$offer_url."','0','".$publish_externally."','".$doc_type."') ");
			 
		 if($insert_documentation){
				$inner_array = array();
				$inner_array['status'] = 'success';
				$inner_array['message'] = 'Offer document has been uploaded successfully.';
				$final_array[] = $inner_array;

				echo json_encode($final_array);
			}
			else{
				$inner_array = array();
				$inner_array['status'] = 'failure';
				$inner_array['message'] = 'Something went wrong! Please try again.';

				$final_array[] = $inner_array;
				echo json_encode($final_array);	
			}
}


function insert_missing_speaker_data(){
		require("include/mysqli_connect.php");
			//var_dump("in"); exit();

			$directoryName="images/";

			$speaker_id = mysqli_real_escape_string($connect,$_POST['sp_id']);
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
			$facebook_handle = mysqli_real_escape_string($connect,$_POST['facebook_url']);

			$title1= mysqli_real_escape_string($connect,$_POST['title1']);
			$description1= mysqli_real_escape_string($connect,$_POST['description1']);
			$title2= mysqli_real_escape_string($connect,$_POST['title2']);
			$description2= mysqli_real_escape_string($connect,$_POST['description2']);
			$title3= mysqli_real_escape_string($connect,$_POST['title3']);
			$description3= mysqli_real_escape_string($connect,$_POST['description3']);

			//*****************************************//
			$phone_number = mysqli_real_escape_string($connect,$_POST['phone_number']);
			$company_name = mysqli_real_escape_string($connect,$_POST['company_name']);
			$job_title = mysqli_real_escape_string($connect,$_POST['job_title']);
			$address1 = mysqli_real_escape_string($connect,$_POST['address1']);
			$address2 = mysqli_real_escape_string($connect,$_POST['address2']);
			$country = mysqli_real_escape_string($connect,$_POST['country']);
			$state = mysqli_real_escape_string($connect,$_POST['state']);
			$city = mysqli_real_escape_string($connect,$_POST['city']);
			$zip_code = mysqli_real_escape_string($connect,$_POST['zip_code']);



			$image_src = trim($_POST['image_src']);
			if($image_src != ''){

				$file=htmlspecialchars( $_POST['image_src'],ENT_QUOTES, 'UTF-8');
				$file_name=preg_replace('/[^A-Za-z]/', '',$fname).date('YmdHis').".jpg";
				list($type, $file) = explode(';', $file);
				list(, $file)      = explode(',', $file);
				file_put_contents($directoryName.$file_name , base64_decode($file));
				$update_speaker_headshot = mysqli_query($connect,"UPDATE `all_speakers` SET head_shot = '".$file_name."' WHERE `id` = '$speaker_id' ");
			}


			$update_speaker = mysqli_query($connect,"UPDATE `all_speakers` SET speaker_name = '".$sp_name."',email_id='".$sp_email."',short_bio='".$your_bio."', your_quote='".$your_quote."', linkedin_handle='".$twitter_handle."',twitter_followers='".$twitter_followers."',twitter_lastupdated='".$twitter_lastupdated."',linkedin_url='".$linkedin_handle."',linkedin_connections='".$linkedin_connections."',linkedin_lastupdated='".$linkedin_lastupdated."',instagram='".$instagram_handle."',facebook='".$facebook_handle."',speaker_manager = '".$speaker_manager_name."',speaker_manager_phone='".$speaker_manager_phone."',speaker_manager_email='".$speaker_manager_email."', presentation_title1='".$title1."',presentation_description1='".$description1."' , presentation_title2='".$title2."',presentation_description2='".$description2."' , presentation_title3='".$title3."',presentation_description3='".$description3."',social_media_total_score='".$social_media_total_score."', company = '".$company_name."',phone='".$phone_number."',title='".$job_title."',address1= '".$address1."',address2='".$address2."',country='".$country."',state='".$state."',city='".$city."',zip='".$zip_code."'   WHERE `id` = '$speaker_id' ");

				if($update_speaker){
					$inner_array = array();
					$inner_array['status'] = 'success';
					$inner_array['message'] = 'Updated successfully.';
					$final_array[] = $inner_array;

					echo json_encode($final_array);
				}
				else{
					$inner_array = array();
					$inner_array['status'] = 'failure';
					$inner_array['message'] = 'Something went wrong! Please try again.';

					$final_array[] = $inner_array;
					echo json_encode($final_array);	
				}

				
}


function get_attached_resources(){

	require("include/mysqli_connect.php");
		$final_array = array();
		$resource_ids = mysqli_real_escape_string($connect, trim($_POST['resource_ids']) );
		$resource_ids_array = explode(",",$resource_ids);
		$attached_links = '<b>Attachment(s):</b><br />';


 		//**** fetch site url 
		$fetch_url_query = mysqli_query($connect,"SELECT value FROM site_details where id=2");
    	if(mysqli_num_rows($fetch_url_query) > 0)
        {            
            while($row1 = mysqli_fetch_array($fetch_url_query))
            {
                $site_url = $row1['value'];
            }
         }

		foreach ($resource_ids_array as $resource_id) { 
			//echo $resource_id; 
			$fetch_resource_details = mysqli_query($connect,"SELECT rt.*,auf.file_name as resource_attachment FROM resource_trackers rt left join all_uploaded_files auf on rt.id = auf.resource_id WHERE rt.id = '".$resource_id."' ");
			$res = mysqli_fetch_array($fetch_resource_details);

			if($res["is_file_available"] != 0){				
				$attached_links .= '<a href="'.$site_url.'/'.'images/resource_tracker_uploads/'.$res["resource_attachment"].'" download >'.$res['resource'].'</a><br />';
			}
			else{
				$attached_links .= '<a href="'.$res["url"].'" >'.$res['url'].'</a><br />';
				// $attached_links .= $res["url"].'<br />';
			}

					
		}
		echo $attached_links;		
}

function create_master_public(){

	// require("include/mysqli_connect.php");
	$final_array = array();

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();


	$first_name = mysqli_real_escape_string($connect,$_POST['first_name']);
	//$last_name= mysqli_real_escape_string($connect,$_POST['last_name']);
	$phone_number= mysqli_real_escape_string($connect,$_POST['phone_number']);
	$email_address= mysqli_real_escape_string($connect,$_POST['email_address']);			
	$job_title= mysqli_real_escape_string($connect,$_POST['job_title']);
	$company= mysqli_real_escape_string($connect,$_POST['company']);	
	$intersted= mysqli_real_escape_string($connect,$_POST['intersted']);
	$twitter= mysqli_real_escape_string($connect,$_POST['twitter']);
	$linked_in= mysqli_real_escape_string($connect,$_POST['linked_in']);
	$event_id= mysqli_real_escape_string($connect,$_POST['event_id']);

	$address1 = mysqli_real_escape_string($connect, $_POST['address1']);
	$address2 = mysqli_real_escape_string($connect, $_POST['address2']);
	$country = mysqli_real_escape_string($connect, $_POST['country']);
	$city = mysqli_real_escape_string($connect, $_POST['city']);
	$state = mysqli_real_escape_string($connect, $_POST['state']);
	$zip = mysqli_real_escape_string($connect, $_POST['zip']);

	$fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
     $res_sql = mysqli_fetch_array($fetch_sql);
     $session_tanent_id=$res_sql['tanent_id'];  

	$dup_check = mysqli_query($connect,"SELECT * FROM all_masters WHERE email_id = '".$email_address."' AND event_id = '".$event_id."' ");
	if(mysqli_num_rows($dup_check) > 0){

		$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Email address is already exist in the system.Please use different email address.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);

	}else{

		$insert_qry="INSERT INTO `all_masters` (tanent_id,master_name, master_lastname, phone,master_type, email_id, company, job_title, linkedin_url,event_id,twitter_url,is_approved,address1,address2,city,state,country,zip) VALUES ('".$session_tanent_id."','".$first_name."','','".$phone_number."','".$intersted."','".$email_address."','".$company."','".$job_title."','".$linked_in."','".$event_id."','".$twitter."', '0','".$address1."','".$address2."','".$city."','".$state."','".$country."','".$zip."') ";

		$insert_master = mysqli_query($connect,"INSERT INTO `all_masters` (tanent_id,master_name, master_lastname, phone,master_type, email_id, company, job_title, linkedin_url,event_id,twitter_url,is_approved,address1,address2,city,state,country,zip) VALUES ('".$session_tanent_id."','".$first_name."','','".$phone_number."','".$intersted."','".$email_address."','".$company."','".$job_title."','".$linked_in."','".$event_id."','".$twitter."', '0','".$address1."','".$address2."','".$city."','".$state."','".$country."','".$zip."') ");	 
		$last_insert_id = mysqli_insert_id($connect);
	 if($insert_master){
	 	
	 	$all_masters_count_sp = calculate_master_dashboard_count($event_id);

	 		//**** add log
	 	mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','create master from signup','".$last_insert_id."','0',now(),\"".$insert_qry."\")");


			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Request has been submitted successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}


}

function insert_docs_for_speaker(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$speaker_id = mysqli_real_escape_string($connect, trim($_POST['speaker_id']) );
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$ppt_token = mysqli_real_escape_string($connect, trim($_POST['uniq_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$ppt_url = mysqli_real_escape_string($connect, trim($_POST['file_url']) );
	$file_type = mysqli_real_escape_string($connect, trim($_POST['file_type']) );
	$event_id= mysqli_real_escape_string($connect,$_POST['event_id']);

	$fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
    $res_sql = mysqli_fetch_array($fetch_sql);
    $session_tanent_id=$res_sql['tanent_id'];  

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$ppt_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
	}
	if($uploaded_file_extension=='jpg' || $uploaded_file_extension=='png')
	{
		$doc_type = 'Image';
	}else
	if($uploaded_file_extension=='pdf')
	{
		$doc_type = 'PDF';
	}else
	if($uploaded_file_extension=='xlsx')
	{
		$doc_type = 'Excel';
	}else
	if($uploaded_file_extension=='docx')
	{
		$doc_type = 'TEXT';
	}else
	if($uploaded_file_extension=='pptx')
	{
		$doc_type = 'Power Point';
	}else
	{
		$doc_type = 'Docs';
	}
	
	$insert_documentation = mysqli_query($connect,"INSERT INTO `speaker_documents` ( speaker_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type,file_type,tenant_id,event_id) VALUES ('".$speaker_id."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$ppt_url."','0','".$publish_externally."','".$doc_type."','".$file_type."','".$session_tanent_id."','".$event_id."') ");
		 
	 // if($insert_documentation){
	 // 		$res=1;
		// 	return json_encode($res);
		// }
		// else{
		// 	$res=2;
		// 	return json_encode($res);	
		// }
		// return json_encode($res);	
	echo 1;
}


function edit_docs_for_speaker(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$speaker_id = mysqli_real_escape_string($connect, trim($_POST['speaker_id']) );
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$ppt_token = mysqli_real_escape_string($connect, trim($_POST['uniq_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$ppt_url = mysqli_real_escape_string($connect, trim($_POST['file_url']) );
	$file_type = mysqli_real_escape_string($connect, trim($_POST['file_type']) );
	$row_id = mysqli_real_escape_string($connect, trim($_POST['row_id']) );

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$ppt_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
		if($uploaded_file_extension=='jpg' || $uploaded_file_extension=='png')
		{
			$doc_type = 'Image';
		}else
		if($uploaded_file_extension=='pdf')
		{
			$doc_type = 'PDF';
		}else
		if($uploaded_file_extension=='xlsx')
		{
			$doc_type = 'Excel';
		}else
		if($uploaded_file_extension=='docx')
		{
			$doc_type = 'TEXT';
		}else
		if($uploaded_file_extension=='pptx')
		{
			$doc_type = 'Power Point';
		}else
		{
			$doc_type = 'Docs';
		}

		mysqli_query($connect, "UPDATE speaker_documents  SET file_name='".$uploaded_file_name."',file_extension='".$uploaded_file_extension."', doc_type='".$doc_type."' WHERE id=".$row_id);
	}
	
	
	mysqli_query($connect, "UPDATE speaker_documents  SET document_title='".$file_title."',publish_externally='".$publish_externally."',url='".$ppt_url."', is_deleted=0,file_type='".$file_type."' WHERE id=".$row_id); 
	echo 1;
}

function insert_docs_for_new_speaker(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$ppt_token = mysqli_real_escape_string($connect, trim($_POST['uniq_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$ppt_url = mysqli_real_escape_string($connect, trim($_POST['file_url']) );
	$file_type = mysqli_real_escape_string($connect, trim($_POST['file_type']) );

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$ppt_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
	}
	if($uploaded_file_extension=='jpg' || $uploaded_file_extension=='png')
	{
		$doc_type = 'Image';
	}else
	if($uploaded_file_extension=='pdf')
	{
		$doc_type = 'PDF';
	}else
	if($uploaded_file_extension=='xlsx')
	{
		$doc_type = 'Excel';
	}else
	if($uploaded_file_extension=='docx')
	{
		$doc_type = 'TEXT';
	}else
	if($uploaded_file_extension=='pptx')
	{
		$doc_type = 'Power Point';
	}else
	{
		$doc_type = 'Docs';
	}


	$insert_documentation = mysqli_query($connect,"INSERT INTO `new_speaker_documents` ( uniqueid, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type,file_type) VALUES ('".$ppt_token."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$ppt_url."','0','".$publish_externally."','".$doc_type."','".$file_type."') ");
		 
	 // if($insert_documentation){
	 // 		$res=1;
		// 	return json_encode($res);
		// }
		// else{
		// 	$res=2;
		// 	return json_encode($res);	
		// }
		// return json_encode($res);	
	echo 1;
}


function update_preview_recent_communication_data(){
	require("include/mysqli_connect.php");
	$final_array = array();

	$speaker_id = trim(mysqli_real_escape_string($connect, $_POST['speaker_id']) );
	$limit = trim(mysqli_real_escape_string($connect, $_POST['limit']) );
	$limit_sql = "";
        if($limit > 0 && $limit != null){
            $limit_sql = " LIMIT ".$limit;
        }        
        $fetch_all_email_templates = mysqli_query($connect,"SELECT *,date_format(date(all_logs.created_at), '%d-%b-%Y') as created_at,all_logs.id as idd FROM all_logs  LEFT JOIN all_email_templates ON all_email_templates.id=all_logs.other_column_value LEFT JOIN all_users ON all_users.user_id=all_logs.created_by  WHERE all_logs.operation='sent email to speaker' AND all_logs.table_id='".$speaker_id."' AND all_email_templates.template_name !='' ORDER BY all_logs.id DESC ".$limit_sql);        
        $inner_array = array();
        if(mysqli_num_rows($fetch_all_email_templates) > 0)
        {            
            while($row = mysqli_fetch_array($fetch_all_email_templates)){
                $inner_array[] = $row;
            }
            echo json_encode($inner_array);            
        }
        else{
              echo json_encode($inner_array);  
        }
}

function fetch_notes_by_speakerid(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$speaker_id = trim(mysqli_real_escape_string($connect, $_POST['speaker_id']) );		
	$fetch_notes = mysqli_query($connect,"SELECT sn.*,(select first_name from all_users where user_id = sn.created_by ) as created_by from speaker_notes sn where sn.speaker_id = '".$speaker_id."' ORDER BY sn.id DESC ");
	$res_array = array();
	if(mysqli_num_rows($fetch_notes) > 0){		
		while ($res = mysqli_fetch_array($fetch_notes)) { 
			$res_array[] = $res;
		}
	}
	 echo json_encode($res_array);
}

function fetch_docs_by_speakerid(){
	require("include/mysqli_connect.php");
	$final_array = array();
	$speaker_id = trim(mysqli_real_escape_string($connect, $_POST['speaker_id']) );		
	$fetch_docs = mysqli_query($connect,"SELECT * FROM speaker_documents where speaker_id = '".$speaker_id."' ORDER BY id DESC ");
	$res_array = array();
	if(mysqli_num_rows($fetch_docs) > 0){		
		while ($res = mysqli_fetch_array($fetch_docs)) { 
			$res_array[] = $res;
		}
	}
	 echo json_encode($res_array);
}

/*function fetch_profile_completeness_by_speakerid()
{
	 include('include/common_functions.php');
	 $common = new commonFunctions();
	 $speaker_id = trim($_POST['speaker_id']);

	$missing_percentage = $common->get_speaker_info_missing_value($speaker_id);
	 // var_dump($missing_percentage); exit();
	echo $missing_percentage;
     
}*/

function set_preview_perticipation_type_by_speakerid(){		
	require("include/mysqli_connect.php");
	$speaker_id = trim($_POST['speaker_id']);	
	$final_array = array();		
	$fetch_types = mysqli_query($connect,"SELECT speaker_type_name FROM all_speaker_types where FIND_IN_SET(all_speaker_types.id,(SELECT speaker_type FROM all_speakers WHERE id='".$speaker_id."')) ");
	$res_array = array();
	if(mysqli_num_rows($fetch_types) > 0){		
		while ($res = mysqli_fetch_array($fetch_types)) { 
			$res_array[] = $res;
		}
	}
	echo json_encode($res_array); 
}

function set_preview_requests_by_speakerid(){
	//var_dump("Arka"); exit();
	require("include/mysqli_connect.php");
	$speaker_id = trim($_POST['speaker_id']);	
	$final_array = array();		
	$fetch_requests = mysqli_query($connect,"SELECT request_name FROM speaker_requests where FIND_IN_SET(speaker_requests.id,(SELECT speaker_requests FROM all_speakers WHERE id=".$speaker_id.") ) ");
	$res_array = array();
	if(mysqli_num_rows($fetch_requests) > 0){		
		while ($res = mysqli_fetch_array($fetch_requests)) { 
			$res_array[] = $res;
		}
	}
	echo json_encode($res_array); 


}

function get_speaker_info_EP(){

	require("include/mysqli_connect.php");
		$final_array = array();
		$resource_ids = mysqli_real_escape_string($connect, trim($_POST['resource_ids']) );
		$delete_flag = mysqli_real_escape_string($connect, trim($_POST['delete_flag']) );
		$ep_id = mysqli_real_escape_string($connect, trim($_POST['ep_id']) );

		$resource_ids_array = explode(",",$resource_ids);

		$attached_links = '';

		foreach ($resource_ids_array as $resource_id) { 
			   $insert_speaker = mysqli_query($connect, "INSERT INTO `event_agenda_speakers` (`ep_id`,`speaker_id`,`speaker_name`, `email_id`, `company`,`phone`,`status`,`influencer_total_score`) 

             	select '$ep_id',id,speaker_name,email_id,company,phone,`status`,social_media_total_score from all_speakers WHERE `id` = '".$resource_id."'");

			//echo $resource_id; 
			$fetch_resource_details = mysqli_query($connect,"select id,speaker_id,speaker_name,email_id,company,phone,(select status_name from all_status where id=event_agenda_speakers.`status`) as status_name,influencer_total_score as influencer from event_agenda_speakers WHERE `speaker_id` = '".$resource_id."' and ep_id='".$ep_id."' ");
			$res = mysqli_fetch_array($fetch_resource_details);
				$social_media_total_score = $res['influencer'];
					if(empty($social_media_total_score)) $social_media_total_score = 0;

					$score_status = '';
						if($social_media_total_score > 8){
                      $score_status = 'Thought Leader';
                      $score_status_icon = 'images/icons/thought_leader.png';
                      
                    }elseif ($social_media_total_score > 5 && $social_media_total_score <= 8) {
                      $score_status = 'Influencer';
                      $score_status_icon = 'images/icons/influencer.png';
                    }elseif ($social_media_total_score > 2 && $social_media_total_score <= 5) {
                      $score_status = 'Connector';
                      $score_status_icon = 'images/icons/connector.png';
                    }else{
                      $score_status = 'Novice Speaker';
                      $score_status_icon = 'images/icons/novice_speaker.png';
                    }
             	if($delete_flag==1)
             	{
	 			$attached_links .= '<tr class="test"><td>'.$res['speaker_name'].'</td><td>'.$res['email_id'].'</td><td>'.$res['company'].'</td><td>'.$res['phone'].'</td><td>'.$res['status_name'].'</td><td><span title='.$score_status.' class="custom-tooltip"><img style="cursor:pointer;text-align:center;width: 24px;margin: auto;" src='.$score_status_icon.' ></span></td><td><a style="border-right:0px;border-right:0px;margin: auto;display: block;float: none;" class="actionBtn delete" onClick="confirmDeleteSpeaker('.$res['id'].')" ><img src="images/deleteNew.png" title="Delete"></a></td></tr>';	
	 			}else
	 			{
	 				$attached_links .= '<tr class="test"><td>'.$res['speaker_name'].'</td><td>'.$res['email_id'].'</td><td>'.$res['company'].'</td><td>'.$res['phone'].'</td><td>'.$res['status_name'].'</td><td><span title='.$score_status.' class="custom-tooltip"><img style="text-align:center;width: 24px;margin: auto;" src='.$score_status_icon.' ></span></td><td><a style="border-right:0px;border-right:0px;margin: auto;display: block;float: none;" class="actionBtn delete" onClick="confirmDeleteSpeaker('.$res['id'].')" ><img src="images/deleteNew.png" title="Delete"></a></td></tr>';		
	 			}
		}

		echo $attached_links;
		
}

function delete_EP_docs(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$ep_id = mysqli_real_escape_string($connect, trim($_POST['ep_id']) );
	$doc_id = mysqli_real_escape_string($connect, trim($_POST['doc_id']) );

	$delete_doc = mysqli_query($connect,"UPDATE `event_documents` SET `is_deleted` = '1' WHERE `id` = '".$doc_id."' AND ep_id = '".$ep_id."'  ");
		 
	 $query = "SELECT * FROM event_documents WHERE  ep_id ='".$ep_id."' AND is_deleted = 0 ORDER BY id DESC";

    $result = mysqli_query($connect,$query);
    if(mysqli_num_rows($result) > 0)
       {  
    while($row = mysqli_fetch_array($result)){
        $rid= $row['id'];
        $file_name = $row['file_name'];
        $return_arr[] = array("id" => $rid,
                            "file_name" => $file_name
                                        );
        }

    }else
    {
      $return_arr[] = array("id" => 0,
                            "file_name" => 0
                                        );
    }
    echo json_encode($return_arr);

	}

	function insert_EP_docs(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$event_id = mysqli_real_escape_string($connect, trim($_POST['event_id']) );
	$ppt_token = mysqli_real_escape_string($connect, trim($_POST['ppt_token']) );
	$ep_id = mysqli_real_escape_string($connect, trim($_POST['ep_id']) );

	$fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
    $res_sql = mysqli_fetch_array($fetch_sql);
    $session_tanent_id=$res_sql['tanent_id'];  

	 $query = "SELECT count(*) as cnt FROM dropzone WHERE uid = '".$ppt_token."'";

    $result = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($result)){
        $cnt= $row['cnt'];
    }

	if($cnt>0)
	{		
	$insert_documentation = mysqli_query($connect,"INSERT INTO `event_documents` ( ep_id, event_id, file_name,tenant_id) SELECT $ep_id,$event_id,filename,$session_tanent_id FROM `dropzone` where `uid` = '".$ppt_token."'");
		 
	 if($insert_documentation){
	 	$delete_file_dropzone = mysqli_query($connect,"DELETE FROM `dropzone` WHERE `uid` = '".$ppt_token."' "); 
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Document has been uploaded successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
	}else
	{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Please select document.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
	}
}

function Get_EP_docs(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$ep_id = mysqli_real_escape_string($connect, trim($_POST['ep_id']) );
		 
	 $query = "SELECT * FROM event_documents WHERE  ep_id ='".$ep_id."' AND is_deleted = 0 ORDER BY id DESC";

    $result = mysqli_query($connect,$query);
    if(mysqli_num_rows($result) > 0)
       {  
    while($row = mysqli_fetch_array($result)){
        $rid= $row['id'];
        $file_name = $row['file_name'];
        $return_arr[] = array("id" => $rid,
                            "file_name" => $file_name
                                        );
        }

    }else
    {
      $return_arr[] = array("id" => 0,
                            "file_name" => 0
                                        );
    }
    echo json_encode($return_arr);

	}

	function delete_speaker_info_EP(){

	require("include/mysqli_connect.php");
		$final_array = array();
		$ep_id = mysqli_real_escape_string($connect, trim($_POST['ep_id']) );
		$row_id = mysqli_real_escape_string($connect, trim($_POST['row_id']) );

		$attached_links = '';

			$speakers_data = mysqli_query($connect,"DELETE  FROM event_agenda_speakers WHERE id = '".$row_id."' ");

			$speakers_data1 = mysqli_query($connect,"SELECT group_concat(speaker_id) as speakers_id FROM event_agenda_speakers WHERE ep_id = '".$ep_id."' ");
			if(mysqli_num_rows($speakers_data1) > 0)
       		{  
			   	$res1 = mysqli_fetch_array($speakers_data1);
			   	$speaker_list_res1 = $res1['speakers_id'];
			   	$resource_ids_array1 = explode(",",$speaker_list_res1);

			   	foreach ($resource_ids_array1 as $resource_id) { 
			$fetch_resource_details = mysqli_query($connect,"select id,speaker_name,email_id,company,phone,(select status_name from all_status where id=event_agenda_speakers.`status`) as status_name,influencer_total_score as influencer from event_agenda_speakers WHERE `speaker_id` = '".$resource_id."' AND ep_id = '".$ep_id."'");
			$res = mysqli_fetch_array($fetch_resource_details);

			$social_media_total_score = $res['influencer'];
					if(empty($social_media_total_score)) $social_media_total_score = 0;

					$score_status = '';
						if($social_media_total_score > 8){
                      $score_status = 'Thought Leader';
                      $score_status_icon = 'images/icons/thought_leader.png';
                      
                    }elseif ($social_media_total_score > 5 && $social_media_total_score <= 8) {
                      $score_status = 'Influencer';
                      $score_status_icon = 'images/icons/influencer.png';
                    }elseif ($social_media_total_score > 2 && $social_media_total_score <= 5) {
                      $score_status = 'Connector';
                      $score_status_icon = 'images/icons/connector.png';
                    }else{
                      $score_status = 'Novice Speaker';
                      $score_status_icon = 'images/icons/novice_speaker.png';
                    }

			if($res!='')
			{
	 		$attached_links .= '<tr class="test"><td>'.$res['speaker_name'].'</td><td>'.$res['email_id'].'</td><td>'.$res['company'].'</td><td>'.$res['phone'].'</td><td>'.$res['status_name'].'</td><td><span title='.$score_status.' class="custom-tooltip"><img style="text-align:center;width: 24px;margin: auto;" src='.$score_status_icon.' ></span></td><td><a onClick="confirmDeleteSpeaker('.$res['id'].')" style="cursor:pointer;border-right:0px;border-right:0px;margin: auto;display: block;float: none;" class="actionBtn delete"><img src="images/deleteNew.png" title="Delete" id="img_del"/></a></td></tr>';	
				
			}else
			{
			$attached_links .= '';		
			}

		  }
		}

		echo $attached_links;
		
}

function update_EP_ypet(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$rec_id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$status_id = trim(mysqli_real_escape_string($connect, $_POST['status_id']) );


	$update_status = mysqli_query($connect,"UPDATE `event_presentation` set `opportunity_type` = '".$status_id."' where `ep_id` = '".$rec_id."' ");
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function EP_update_starttime(){

			require("include/mysqli_connect.php");
			$final_array = array();

			$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
			$start_time = trim(mysqli_real_escape_string($connect, $_POST['start_time']) );
			$timezone = trim(mysqli_real_escape_string($connect, $_POST['timezone']) );

			$fetch_sql = mysqli_query($connect,"SELECT event_date,end_time from event_presentation where ep_id='".$id."' ");  
			$res_sql = mysqli_fetch_array($fetch_sql);
			$event_date=$res_sql['event_date']; 
			$end_time=$res_sql['end_time'];  

			$st = date("H:i:s", strtotime($start_time));
			$et = date("H:i:s", strtotime($end_time));	

			$final_startdate= $event_date. ' ' .$st;
			$final_enddate= $event_date. ' ' .$et;

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


	$update_status = mysqli_query($connect,"UPDATE `event_presentation` set `start_time` = '".$start_time."',event_start_pst = '".$start_utc_to_pst."',event_end_pst = '".$end_utc_to_pst."' where `ep_id` = '".$id."'");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function EP_update_endtime(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$end_time = trim(mysqli_real_escape_string($connect, $_POST['end_time']) );
	$timezone = trim(mysqli_real_escape_string($connect, $_POST['timezone']) );

			$fetch_sql = mysqli_query($connect,"SELECT event_date,start_time from event_presentation where ep_id='".$id."' ");  
			$res_sql = mysqli_fetch_array($fetch_sql);
			$event_date=$res_sql['event_date']; 
			$start_time=$res_sql['start_time'];  

			$st = date("H:i:s", strtotime($start_time));
			$et = date("H:i:s", strtotime($end_time));	

			$final_startdate= $event_date. ' ' .$st;
			$final_enddate= $event_date. ' ' .$et;

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


	$update_status = mysqli_query($connect,"UPDATE `event_presentation` set `end_time` = '".$end_time."',event_start_pst = '".$start_utc_to_pst."',event_end_pst = '".$end_utc_to_pst."' where `ep_id` = '".$id."'");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function delete_Event_presentation(){

	require("include/mysqli_connect.php");
	$final_array = array();
	if(!isset($_SESSION)){ session_start(); }
	$logged_in_user= $_SESSION['user_id'];

	$ep_id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$session_tanent_id=  0;

	$delete_qry="DELETE from event_presentation where ep_id ='".$ep_id."'";
	$update_attachment = mysqli_query($connect,$delete_qry);
	
	mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','Delete Event Agenda','".$ep_id."','".$logged_in_user."',now(),\"".$delete_qry."\")");

	 if($update_attachment){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function insert_docs_for_new_sponsor(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$ppt_token = mysqli_real_escape_string($connect, trim($_POST['uniq_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$ppt_url = mysqli_real_escape_string($connect, trim($_POST['file_url']) );
	$file_type = mysqli_real_escape_string($connect, trim($_POST['file_type']) );

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$ppt_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
	}
	if($uploaded_file_extension=='jpg' || $uploaded_file_extension=='png')
	{
		$doc_type = 'Image';
	}else
	if($uploaded_file_extension=='pdf')
	{
		$doc_type = 'PDF';
	}else
	if($uploaded_file_extension=='xlsx')
	{
		$doc_type = 'Excel';
	}else
	if($uploaded_file_extension=='docx')
	{
		$doc_type = 'TEXT';
	}else
	if($uploaded_file_extension=='pptx')
	{
		$doc_type = 'Power Point';
	}else
	{
		$doc_type = 'Docs';
	}


	$insert_documentation = mysqli_query($connect,"INSERT INTO `new_sponsor_documents` ( uniqueid, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type,file_type) VALUES ('".$ppt_token."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$ppt_url."','0','".$publish_externally."','".$doc_type."','".$file_type."') ");
		 	
	echo 1;
}

function get_new_sponsor_documents(){

	require("include/mysqli_connect.php");

    $return_arr = array();
    $uniqueid= $_POST['uniq_token'];

    $query = "SELECT * FROM new_sponsor_documents where uniqueid='".$uniqueid."'";

    $result = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($result)){
        $rid= $row['id'];
        $filetitle= $row['document_title'];
        $file_name = $row['file_name'];
        $file_extension= $row['file_extension'];
        $url = $row['url'];
        $last_updated_at= $row['updated_at'];
        $publish_externally = $row['publish_externally'];
        $doc_type = $row['doc_type'];
        $file_type = $row['file_type'];
        $return_arr[] = array("id" => $rid,
                            "document_title" => $filetitle,
                            "file_name" => $file_name,
                            "file_extension" => $file_extension,
                            "url" => $url,
                            "updated_at" => date('d-M-Y H:i:s', strtotime($last_updated_at)),
                            "publish_externally" => $publish_externally,
                            "doc_type" => $doc_type,
                            "file_type" => $file_type
                                        );
        }
     echo json_encode($return_arr);
}

function insert_docs_for_sponsor(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$sponsor_id = mysqli_real_escape_string($connect, trim($_POST['sponsor_id']) );
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$ppt_token = mysqli_real_escape_string($connect, trim($_POST['uniq_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$ppt_url = mysqli_real_escape_string($connect, trim($_POST['file_url']) );
	$file_type = mysqli_real_escape_string($connect, trim($_POST['file_type']) );

	$event_id= mysqli_real_escape_string($connect,$_POST['event_id']);

	$fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
    $res_sql = mysqli_fetch_array($fetch_sql);
    $session_tanent_id=$res_sql['tanent_id'];  

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$ppt_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
	}
	if($uploaded_file_extension=='jpg' || $uploaded_file_extension=='png')
	{
		$doc_type = 'Image';
	}else
	if($uploaded_file_extension=='pdf')
	{
		$doc_type = 'PDF';
	}else
	if($uploaded_file_extension=='xlsx')
	{
		$doc_type = 'Excel';
	}else
	if($uploaded_file_extension=='docx')
	{
		$doc_type = 'TEXT';
	}else
	if($uploaded_file_extension=='pptx')
	{
		$doc_type = 'Power Point';
	}else
	{
		$doc_type = 'Docs';
	}
	
	$insert_documentation = mysqli_query($connect,"INSERT INTO `sponsor_documents` ( sponsor_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type,file_type,tenant_id,event_id) VALUES ('".$sponsor_id."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$ppt_url."','0','".$publish_externally."','".$doc_type."','".$file_type."','".$session_tanent_id."','".$event_id."') ");
		 
	echo 1;
}

function get_sponsor_documents(){

	require("include/mysqli_connect.php");

    $return_arr = array();
    $sponsor_id= $_POST['sponsor_id'];

    $query = "SELECT * FROM sponsor_documents where sponsor_id='".$sponsor_id."'";

    $result = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($result)){
        $rid= $row['id'];
        $filetitle= $row['document_title'];
        $file_name = $row['file_name'];
        $file_extension= $row['file_extension'];
        $url = $row['url'];
        $last_updated_at= $row['updated_at'];
        $publish_externally = $row['publish_externally'];
        $doc_type = $row['doc_type'];
        $file_type = $row['file_type'];
        $return_arr[] = array("id" => $rid,
                            "document_title" => $filetitle,
                            "file_name" => $file_name,
                            "file_extension" => $file_extension,
                            "url" => $url,
                            "updated_at" => date('d-M-Y H:i:s', strtotime($last_updated_at)),
                            "publish_externally" => $publish_externally,
                            "doc_type" => $doc_type,
                            "file_type" => $file_type
                                        );
        }
     echo json_encode($return_arr);
}

function edit_docs_for_sponsor(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$sponsor_id = mysqli_real_escape_string($connect, trim($_POST['sponsor_id']) );
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$ppt_token = mysqli_real_escape_string($connect, trim($_POST['uniq_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$ppt_url = mysqli_real_escape_string($connect, trim($_POST['file_url']) );
	$file_type = mysqli_real_escape_string($connect, trim($_POST['file_type']) );
	$row_id = mysqli_real_escape_string($connect, trim($_POST['row_id']) );

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$ppt_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
		if($uploaded_file_extension=='jpg' || $uploaded_file_extension=='png')
		{
			$doc_type = 'Image';
		}else
		if($uploaded_file_extension=='pdf')
		{
			$doc_type = 'PDF';
		}else
		if($uploaded_file_extension=='xlsx')
		{
			$doc_type = 'Excel';
		}else
		if($uploaded_file_extension=='docx')
		{
			$doc_type = 'TEXT';
		}else
		if($uploaded_file_extension=='pptx')
		{
			$doc_type = 'Power Point';
		}else
		{
			$doc_type = 'Docs';
		}

		mysqli_query($connect, "UPDATE sponsor_documents  SET file_name='".$uploaded_file_name."',file_extension='".$uploaded_file_extension."', doc_type='".$doc_type."' WHERE id=".$row_id);
	}
	
	
	mysqli_query($connect, "UPDATE sponsor_documents  SET document_title='".$file_title."',publish_externally='".$publish_externally."',url='".$ppt_url."', is_deleted=0,file_type='".$file_type."' WHERE id=".$row_id); 
	echo 1;
}

function get_data_to_Edit_sponsor_fileinfo(){

	require("include/mysqli_connect.php");

    $return_arr = array();
    $row_id= $_POST['row_id'];

    $query = "SELECT * FROM sponsor_documents where id='".$row_id."'";

    $result = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($result)){
        $rid= $row['id'];
        $filetitle= $row['document_title'];
        $file_name = $row['file_name'];
        $file_extension= $row['file_extension'];
        $url = $row['url'];
        $last_updated_at= $row['updated_at'];
        $publish_externally = $row['publish_externally'];
        $doc_type = $row['doc_type'];
        $file_type = $row['file_type'];
        $return_arr[] = array("id" => $rid,
                            "document_title" => $filetitle,
                            "file_name" => $file_name,
                            "file_extension" => $file_extension,
                            "url" => $url,
                            "updated_at" => date('d-M-Y H:i:s', strtotime($last_updated_at)),
                            "publish_externally" => $publish_externally,
                            "doc_type" => $doc_type,
                            "file_type" => $file_type,
                                        );
        }
     echo json_encode($return_arr);
}

function get_data_to_Edit_sponsorship(){

	require("include/mysqli_connect.php");

    $return_arr = array();
    $row_id= $_POST['row_id'];

    $query = "select st.*,(select amt.sponsor_type_name from all_sponsor_types amt,sponsor_sponsorship_type sst where amt.id=sst.sponsor_type and sst.id='".$row_id."') as sponsor_type_name,(select amt.id from all_sponsor_types amt,sponsor_sponsorship_type sst where amt.id=sst.sponsor_type and sst.id='".$row_id."') as sponsor_type_id  FROM sponsor_sponsorship_type st where id='".$row_id."'";

    $result = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($result)){
        $rid= $row['id'];
        $sponsor_type= $row['sponsor_type_name'];
        $committed_unit = $row['committed_unit'];
        $sponsorship_values= $row['sponsorship_values'];
        $sponsor_id = $row['sponsor_id'];
        $sponsor_type_id = $row['sponsor_type_id'];
        $return_arr[] = array("id" => $rid,
                            "sponsor_type" => $sponsor_type,
                            "committed_unit" => $committed_unit,
                            "sponsorship_values" => $sponsorship_values,
                            "sponsor_type_id"=>$sponsor_type_id
                 
                                        );
        }
     echo json_encode($return_arr);
}


function insert_speakers_from_speaker_popup(){

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	if(!isset($_SESSION)){ session_start(); }
	$event_id= mysqli_real_escape_string($connect, trim($_POST['event_id']) );
	$logged_in_user= $_SESSION['user_id'];
	$fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
    $res_sql = mysqli_fetch_array($fetch_sql);
    $session_tanent_id=$res_sql['tanent_id']; 

		$final_array = array();
		$resource_ids = mysqli_real_escape_string($connect, trim($_POST['resource_ids']) );
		$resource_ids_array = explode(",",$resource_ids);

		foreach ($resource_ids_array as $resource_id) { 

             $insert_speaker = "INSERT INTO `all_speakers` (`tanent_id`,`speaker_name`, `email_id`, `company`, `topic_choosen`, `time_slot_from`,`time_slot_to`, `linkedin_handle`, `short_bio`, `title`, `head_shot`, `linkedin_url`, `address1`,`address2`,`city`,`state`,  `speaker_manager`, `phone`,`speaker_manager_phone`, `speaker_manager_email`, `other_documents`, `willing_to_promote`,`willing_to_promote_yes`, `presentation_title1`, `presentation_description1`, `presentation_title2`, `presentation_description2`, `presentation_title3`, `presentation_description3`,`your_quote`,`facebook`, `instagram`, `twitter_followers`, `twitter_lastupdated`, `linkedin_connections`, `linkedin_lastupdated`, `social_media_total_score`, `is_social_media_sharing_complete`,`is_website_listing_complete`,`is_speaker_coach_assign`,`is_video_promotion_complete`,`is_orientation_attend`,`is_reception_invitation_accept`,event_id,`speaker_requests`,`speaker_expertise`,`acknowledgement`,`country`,`zip`) 

             	select $session_tanent_id,speaker_name,email_id,company,topic_choosen,time_slot_from,time_slot_to,linkedin_handle,short_bio,title,head_shot,linkedin_url,address1,address2,city,state,speaker_manager,phone,speaker_manager_phone,speaker_manager_email,other_documents,willing_to_promote,willing_to_promote_yes,presentation_title1,presentation_description1,presentation_title2,presentation_description2,presentation_title3,presentation_description3,your_quote,facebook,instagram,twitter_followers,twitter_lastupdated,linkedin_connections,linkedin_lastupdated,social_media_total_score,is_social_media_sharing_complete,is_website_listing_complete,is_speaker_coach_assign,is_video_promotion_complete,is_orientation_attend,is_reception_invitation_accept,$event_id,speaker_requests,speaker_expertise,acknowledgement,country,zip from all_speakers WHERE `id` = '".$resource_id."'";
             	mysqli_query($connect,$insert_speaker);


             if($insert_speaker){
				$speakerid = mysqli_insert_id($connect);
			 	$profile_complete = $common->get_speaker_info_missing_value($speakerid);

				 mysqli_query($connect, "UPDATE `all_speakers` SET `profile_completeness`='".$profile_complete."' WHERE id=".$speakerid );

				
				$insert_note = mysqli_query($connect,"INSERT INTO speaker_notes (notes,speaker_id,created_by) select notes,$speakerid,created_by from speaker_notes where speaker_id='".$resource_id."'");

				$insert_documentation = mysqli_query($connect,"INSERT INTO `speaker_documents` ( speaker_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type,file_type) select $speakerid,document_title,file_name,file_extension,url,is_deleted,publish_externally,doc_type,file_type from speaker_documents where speaker_id='".$resource_id."'");

				$all_speakers_array = calculate_speaker_dashboard_count($event_id);
				$status_update = $common->calculate_speaker_status_count($event_id);
			    $type_update = $common->calculate_speaker_type_count($event_id);

				//**** add log
				mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','create speaker from popup','".$speakerid."','".$logged_in_user."',now(),\"".$insert_speaker."\")");
			}

		}

		echo base64_encode($event_id).':'.base64_encode(rand(100,999));
		
}

function EP_update_enddate(){

			require("include/mysqli_connect.php");
			$final_array = array();

			$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
			$end_date = date("Y-m-d",strtotime(trim(mysqli_real_escape_string($connect, $_POST['end_date']))));
			$timezone = trim(mysqli_real_escape_string($connect, $_POST['timezone']) );

			$fetch_sql = mysqli_query($connect,"SELECT start_time,end_time from event_presentation where ep_id='".$id."' ");  
		    $res_sql = mysqli_fetch_array($fetch_sql);
		    $start_time=$res_sql['start_time']; 
		    $end_time=$res_sql['end_time'];  

			$st = date("H:i:s", strtotime($start_time));
			$et = date("H:i:s", strtotime($end_time));	

			$final_startdate= $end_date. ' ' .$st;
			$final_enddate= $end_date. ' ' .$et;

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

	$update_status = mysqli_query($connect,"UPDATE `event_presentation` set `event_date` = '".$end_date."',event_start_pst = '".$start_utc_to_pst."',event_end_pst = '".$end_utc_to_pst."' where `ep_id` = '".$id."'");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function insert_master_from_master_popup(){ 

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	if(!isset($_SESSION)){ session_start(); }
	$logged_in_user= $_SESSION['user_id'];
	$event_id= mysqli_real_escape_string($connect, trim($_POST['event_id']) );

	$fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
    $res_sql = mysqli_fetch_array($fetch_sql);
    $session_tanent_id=$res_sql['tanent_id'];  

		$final_array = array();
		$resource_ids = mysqli_real_escape_string($connect, trim($_POST['resource_ids']) );
	
		$resource_ids_array = explode(",",$resource_ids);

		foreach ($resource_ids_array as $resource_id) { 

             $insert_master = "INSERT INTO `all_masters` (`tanent_id`,`master_name`,`master_lastname`, `email_id`, `company`,`phone`,`job_title`,`linkedin_url`, `event_id`,`twitter_url`,`is_approved`)

             	select $session_tanent_id,master_name,master_lastname,email_id,company,phone,job_title,linkedin_url,$event_id,twitter_url,'1' from all_masters WHERE `id` = '".$resource_id."'";
 			mysqli_query($connect,$insert_master);

             //**** add log
             mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','create master from popup','".$resource_id."','".$logged_in_user."',now(),\"".$insert_master."\")");
		}
		//updaing master counts
		$all_masters_count_sp = calculate_master_dashboard_count($event_id);
		$total_master_type_count_update = $common->calculate_master_type_count($event_id); 

		echo base64_encode($event_id).':'.base64_encode(rand(100,999));
		
}

function get_sponsor_details_by_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['sp_id']) );

	$speaker_details = mysqli_query($connect,"SELECT *,date_format(estimated_time_to_close, '%d-%b-%Y') as estimated_timeto_close,date_format(close_date, '%d-%b-%Y') as closedate,(select country_name from countries where countries.country_id=country) as country_name,(select state_name from states where states.state_id=state) as state_name,(select status_name from all_status where id=all_sponsors.status) as status_name,(select group_concat(sponsor_type_name) from all_sponsor_types where find_in_set(id,all_sponsors.sponsor_type)) as sponsor_type FROM `all_sponsors` where `id` = '$id' ");
	 
	 if(mysqli_num_rows($speaker_details) > 0){
			$inner_array = array();
			$res = mysqli_fetch_array($speaker_details);
			$final_array[] = $res;
			//$final_array[] = $inner_array;
			//echo json_encode($final_array); 

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
}

function get_sponsor_preview_recent_communication_data(){
	require("include/mysqli_connect.php");
	$final_array = array();

	$sponsor_id = trim(mysqli_real_escape_string($connect, $_POST['sponsor_id']) );
	$limit = trim(mysqli_real_escape_string($connect, $_POST['limit']) );
	$limit_sql = "";
        if($limit > 0 && $limit != null){
            $limit_sql = " LIMIT ".$limit;
        }        
        $fetch_all_email_templates = mysqli_query($connect,"SELECT *,date_format(date(all_logs.created_at), '%d-%b-%Y') as createdat,all_logs.id as idd FROM all_logs  LEFT JOIN all_email_templates ON all_email_templates.id=all_logs.other_column_value LEFT JOIN all_users ON all_users.user_id=all_logs.created_by  WHERE all_logs.operation='sent email to sponsor' AND all_logs.table_id='".$sponsor_id."' AND all_email_templates.template_name !='' ORDER BY all_logs.id DESC ".$limit_sql);        
        $inner_array = array();
        if(mysqli_num_rows($fetch_all_email_templates) > 0)
        {            
            while($row = mysqli_fetch_array($fetch_all_email_templates)){
                $inner_array[] = $row;
            }
            echo json_encode($inner_array);            
        }
        else{
              echo json_encode($inner_array);  
        }
}
function fetch_notes_by_sponsorid(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$sponsor_id = trim(mysqli_real_escape_string($connect, $_POST['sponsor_id']) );		
	$fetch_notes = mysqli_query($connect,"SELECT sn.*,date_format(date(sn.created_at), '%d-%b-%Y') as createdat,(select first_name from all_users where user_id = sn.created_by ) as created_by from sponsor_notes sn where sn.sponsor_id = '".$sponsor_id."' ORDER BY sn.id DESC ");
	$res_array = array();
	if(mysqli_num_rows($fetch_notes) > 0){		
		while ($res = mysqli_fetch_array($fetch_notes)) { 
			$res_array[] = $res;
		}
	}
	 echo json_encode($res_array);
}

function fetch_docs_by_sponsorid(){
	require("include/mysqli_connect.php");
	$final_array = array();
	$sponsor_id = trim(mysqli_real_escape_string($connect, $_POST['sponsor_id']) );		
	$fetch_docs = mysqli_query($connect,"SELECT * FROM sponsor_documents where sponsor_id = '".$sponsor_id."' ORDER BY id DESC ");
	$res_array = array();
	if(mysqli_num_rows($fetch_docs) > 0){		
		while ($res = mysqli_fetch_array($fetch_docs)) { 
			$res_array[] = $res;
		}
	}
	 echo json_encode($res_array);
}


function insert_sponsors_from_sponsor_popup(){

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$res_array =array();
	if(!isset($_SESSION)){ session_start(); }
	//$event_id= $_SESSION['current_event_id'];
	$logged_in_user= $_SESSION['user_id'];

		$final_array = array();
		$resource_ids = mysqli_real_escape_string($connect, trim($_POST['resource_ids']) );
		$event_id = mysqli_real_escape_string($connect, trim($_POST['event_id']) );

		$fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
	    $res_sql = mysqli_fetch_array($fetch_sql);
	    $session_tanent_id=$res_sql['tanent_id'];  

		$resource_ids_array = explode(",",$resource_ids);

		foreach ($resource_ids_array as $resource_id) { 

             $insert_sponsor = mysqli_query($connect, "INSERT INTO `all_sponsors` (`tanent_id`,`sponsor_company_name`, `sponsor_contact_person`, `sponsor_contact_number`, `sponsor_contact_email_address`, `sponsor_role`,`secondary1_sponsor_contact_person`, `secondary1_sponsor_contact_number`, `secondary1_sponsor_contact_email_address`, `secondary1_sponsor_role`,`secondary2_sponsor_contact_person`, `secondary2_sponsor_contact_number`, `secondary2_sponsor_contact_email_address`, `secondary2_sponsor_role`, `sponsor_bio`, `facebook_url`, `twitter_url`, `linkedin_url`, `instagram_url`, `address1`,`address2`,`city`,`state`, `banner_image`, `other_documents`,`event_id`,`company_url`,`country`,`zipcode`,`sponsor_logo`,`total_social_media_reach`,`total_email_reach`,`other_contact_name`,`other_contact_number`,`other_email_address`,`other_role`,`potential_funding_ask`,`committed_funding`,
				`estimated_time_to_close`,`close_date`) 

             	select $session_tanent_id,sponsor_company_name, sponsor_contact_person, sponsor_contact_number, sponsor_contact_email_address, sponsor_role,secondary1_sponsor_contact_person, secondary1_sponsor_contact_number, secondary1_sponsor_contact_email_address, secondary1_sponsor_role,secondary2_sponsor_contact_person, secondary2_sponsor_contact_number, secondary2_sponsor_contact_email_address, secondary2_sponsor_role, sponsor_bio, facebook_url, twitter_url, linkedin_url, instagram_url, address1,address2,city,state, banner_image, other_documents,$event_id,company_url,country,zipcode,sponsor_logo,total_social_media_reach,total_email_reach,other_contact_name,other_contact_number,other_email_address,other_role,potential_funding_ask,committed_funding,estimated_time_to_close,close_date from all_sponsors WHERE `id` = '".$resource_id."'");

             if($insert_sponsor){
				$sponsorid = mysqli_insert_id($connect);
				
				$insert_note = mysqli_query($connect,"INSERT INTO sponsor_notes (notes,sponsor_id,created_by) select notes,$sponsorid,created_by from sponsor_notes where sponsor_id='".$resource_id."'");

				$insert_documentation = mysqli_query($connect,"INSERT INTO `sponsor_documents` ( sponsor_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type,file_type) select $sponsorid,document_title,file_name,file_extension,url,is_deleted,publish_externally,doc_type,file_type from sponsor_documents where sponsor_id='".$resource_id."'");

				
				//**** add log
				//$add_log = mysqli_query($connect, "INSERT INTO all_logs(operation,created_by,event_id) VALUES ('create sponsor','".$logged_in_user."','".$event_id."')");

				$tenant_id = $common->get_tenant_id_from_eventid($event_id);
			mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at) VALUES ('".$tenant_id."','".$event_id."','create sponsor from popup','".$sponsorid."','".$logged_in_user."',now())");

			}

		}

		$all_speakers_array = calculate_sponsor_dashboard_count($event_id);
		// $status_update = $common->calculate_sponsor_status_count($event_id);
		// $type_update = $common->calculate_sponsor_type_count($event_id);

		//echo 1;
	$res_array['status'] = 'success';
	$res_array['encoded_eventid'] = base64_encode($event_id).':'.base64_encode(rand(100,999));
	echo json_encode($res_array);
		
}

function insert_ppt_for_sponsor(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$sponsor_id = mysqli_real_escape_string($connect, trim($_POST['sponsor_id']) );
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$ppt_token = mysqli_real_escape_string($connect, trim($_POST['ppt_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$ppt_url = mysqli_real_escape_string($connect, trim($_POST['ppt_url']) );
	$doc_type = mysqli_real_escape_string($connect, trim($_POST['doc_type']) );

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$ppt_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
	}

	$insert_documentation = mysqli_query($connect,"INSERT INTO `sponsor_documents` ( sponsor_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type) VALUES ('".$sponsor_id."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$ppt_url."','0','".$publish_externally."','".$doc_type."') ");
		 
	 if($insert_documentation){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Powerpoint has been uploaded successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function delete_ppt_for_sponsor(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$sponsor_id = mysqli_real_escape_string($connect, trim($_POST['sponsor_id']) );
	$doc_id = mysqli_real_escape_string($connect, trim($_POST['doc_id']) );

	$delete_doc = mysqli_query($connect,"UPDATE `sponsor_documents` SET `is_deleted` = '1' WHERE `id` = '$doc_id' AND sponsor_id = '".$sponsor_id."'  ");
		 
	 if($delete_doc){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Document has been deleted successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}

	function insert_video_for_sponsor(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$sponsor_id = mysqli_real_escape_string($connect, trim($_POST['sponsor_id']) );
	$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
	$video_token = mysqli_real_escape_string($connect, trim($_POST['video_token']) );
	$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
	$vdo_url = mysqli_real_escape_string($connect, trim($_POST['vdo_url']) );
	$doc_type = mysqli_real_escape_string($connect, trim($_POST['doc_type']) );

	$uploaded_file_name = '';
	$uploaded_file_extension = '';

	$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$video_token' ORDER BY id DESC LIMIT 1 ");
	if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
		$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
		$uploaded_file_name = $res_file['filename'];
		$uploaded_file_extension = end(explode('.', $uploaded_file_name));
	}

	$insert_documentation = mysqli_query($connect,"INSERT INTO `sponsor_documents` ( sponsor_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type) VALUES ('".$sponsor_id."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$vdo_url."','0','".$publish_externally."','".$doc_type."') ");
		 
	 if($insert_documentation){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Video has been uploaded successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

}

function insert_offer_for_sponsor(){

		require("include/mysqli_connect.php");
		$final_array = array();
		$sponsor_id = mysqli_real_escape_string($connect, trim($_POST['sponsor_id']) );
		$publish_externally = mysqli_real_escape_string($connect, trim($_POST['publish_externally']) );
		$offer_token = mysqli_real_escape_string($connect, trim($_POST['offer_token']) );
		$file_title = mysqli_real_escape_string($connect, trim($_POST['file_title']) );
		$offer_url = mysqli_real_escape_string($connect, trim($_POST['offer_url']) );
		$doc_type = mysqli_real_escape_string($connect, trim($_POST['doc_type']) );

		$uploaded_file_name = '';
		$uploaded_file_extension = '';

		$fetch_uploaded_file_details =  mysqli_query($connect,"SELECT * FROM `dropzone` where `uid` = '$offer_token' ORDER BY id DESC LIMIT 1 ");
		if(mysqli_num_rows($fetch_uploaded_file_details) > 0){
			$res_file = mysqli_fetch_array($fetch_uploaded_file_details);
			$uploaded_file_name = $res_file['filename'];
			$uploaded_file_extension = end(explode('.', $uploaded_file_name));
		}

		$insert_documentation = mysqli_query($connect,"INSERT INTO `sponsor_documents` ( sponsor_id, document_title, file_name, file_extension, url, is_deleted, publish_externally,doc_type) VALUES ('".$sponsor_id."','".$file_title."','".$uploaded_file_name."','".$uploaded_file_extension."','".$offer_url."','0','".$publish_externally."','".$doc_type."') ");
			 
		 if($insert_documentation){
				$inner_array = array();
				$inner_array['status'] = 'success';
				$inner_array['message'] = 'Offer document has been uploaded successfully.';
				$final_array[] = $inner_array;

				echo json_encode($final_array);
			}
			else{
				$inner_array = array();
				$inner_array['status'] = 'failure';
				$inner_array['message'] = 'Something went wrong! Please try again.';

				$final_array[] = $inner_array;
				echo json_encode($final_array);	
			}
}

function get_EP_details_by_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );

	$speaker_details = mysqli_query($connect,"select ep.*,date_format(ep.event_date, '%d-%b-%Y') as eventdate,(select group_concat(speaker_name) from all_speakers als where als.id in (select speaker_id from event_agenda_speakers where ep_id='".$id."')) as speakerlist,(select speaker_type_name from all_speaker_types alst where find_in_set(alst.id,ep.opportunity_type)) as opportunity_type  from event_presentation ep where ep.ep_id='$id' ");
	 
	 if(mysqli_num_rows($speaker_details) > 0){
			$inner_array = array();
			$res = mysqli_fetch_array($speaker_details);
			$final_array[] = $res;
			//$final_array[] = $inner_array;
			//echo json_encode($final_array); 

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
}

function fetch_notes_by_ep_id(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$ep_id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );		
	$fetch_notes = mysqli_query($connect,"SELECT sn.*,ifnull((select first_name from all_users where user_id = sn.created_by),(select speaker_name from all_speakers where id=sn.created_by) ) as created_by,date_format(date(created_at), '%d-%b-%Y') as createdat from event_presentation_notes sn where sn.ep_id = '".$ep_id."' ORDER BY sn.id DESC ");
	$res_array = array();
	if(mysqli_num_rows($fetch_notes) > 0){		
		while ($res = mysqli_fetch_array($fetch_notes)) { 
			$res_array[] = $res;
		}
	}
	 echo json_encode($res_array);
}

function fetch_docs_by_ep_id(){
	require("include/mysqli_connect.php");
	$final_array = array();
	$ep_id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );		
	$fetch_docs = mysqli_query($connect,"SELECT * FROM event_documents where ep_id = '".$ep_id."' ORDER BY id DESC ");
	$res_array = array();
	if(mysqli_num_rows($fetch_docs) > 0){		
		while ($res = mysqli_fetch_array($fetch_docs)) { 
			$res_array[] = $res;
		}
	}
	 echo json_encode($res_array);
}

function getSpeakersForEP_Multiselect(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$speakes_options=array();
	$values_arr = $_POST['values'];

	$fetch_url_query = mysqli_query($connect,"select group_concat(speaker_id) as speakers_id from event_agenda_speakers where event_agenda_speakers.ep_id='".$values_arr."'");
        	if(mysqli_num_rows($fetch_url_query) > 0)
         	{            
			while($row1 = mysqli_fetch_array($fetch_url_query))
              	{
                  $speakers_id = $row1['speakers_id'];
                }
              }  

              $spaekers_id_array = explode(",",$speakers_id);

               foreach ($spaekers_id_array as $speaker_id) { 
                $fetch_all_speakers = mysqli_query($connect,"select id,email_id from all_speakers WHERE `id` = '".$speaker_id."'");
                              if(mysqli_num_rows($fetch_all_speakers) > 0)
                              {            
                                  while($row = mysqli_fetch_array($fetch_all_speakers)){
                                       echo "<option  value='".$row['id']."' >".$row['email_id']."</option>";
                                }  
                          }
               }
	
}

function GetTotalSponsorship(){

	require("include/mysqli_connect.php");

    $return_arr = array();
    $sponsor_id= $_POST['sponsor_id'];

    $query = "select sum(committed_unit) as committed_unit,sum(sponsorship_values) as sponsorship_values from sponsor_sponsorship_type where sponsor_id='".$sponsor_id."'";

    $result = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($result)){
        $committed_unit = $row['committed_unit'];
        $sponsorship_values= $row['sponsorship_values'];
        $return_arr[] = array(
                            "committed_unit" => $committed_unit,
                            "sponsorship_values" => $sponsorship_values
                                        );
        }
     echo json_encode($return_arr);
}

function GetTotalSponsorship_new(){

	require("include/mysqli_connect.php");

    $return_arr = array();
    $sponsor_id= $_POST['sponsor_id'];

    $query = "select sum(committed_unit) as committed_unit,sum(sponsorship_values) as sponsorship_values from new_sponsorship_type where uniqueid='".$sponsor_id."'";

    $result = mysqli_query($connect,$query);
    while($row = mysqli_fetch_array($result)){
        $committed_unit = $row['committed_unit'];
        $sponsorship_values= $row['sponsorship_values'];
        $return_arr[] = array(
                            "committed_unit" => $committed_unit,
                            "sponsorship_values" => $sponsorship_values
                                        );
        }
     echo json_encode($return_arr);
}

	function delete_speaker_info_EP_new(){

	require("include/mysqli_connect.php");
		$final_array = array();
		$row_id = mysqli_real_escape_string($connect, trim($_POST['row_id']) );
		$uniq_token = mysqli_real_escape_string($connect, trim($_POST['uniq_token']) );

		$attached_links = '';

		$speakers_data = mysqli_query($connect,"DELETE  FROM new_event_agenda_speakers WHERE id = '".$row_id."' ");
		
			$speakers_data1 = mysqli_query($connect,"SELECT group_concat(speaker_id) as speakers_id FROM new_event_agenda_speakers WHERE token = '".$uniq_token."' ");
			if(mysqli_num_rows($speakers_data1) > 0)
       		{  
			   	$res1 = mysqli_fetch_array($speakers_data1);
			   	$speaker_list_res1 = $res1['speakers_id'];
			   	$resource_ids_array1 = explode(",",$speaker_list_res1);

			   	foreach ($resource_ids_array1 as $resource_id) { 
			$fetch_resource_details = mysqli_query($connect,"select id,speaker_id,speaker_name,email_id,company,phone,(select status_name from all_status where id=new_event_agenda_speakers.`status`) as status_name,influencer_total_score as influencer from new_event_agenda_speakers WHERE `speaker_id` = '".$resource_id."' and token='".$uniq_token."' ");
			$res = mysqli_fetch_array($fetch_resource_details);

			$social_media_total_score = $res['influencer'];
					if(empty($social_media_total_score)) $social_media_total_score = 0;

					$score_status = '';
						if($social_media_total_score > 8){
                      $score_status = 'Thought Leader';
                      $score_status_icon = 'images/icons/thought_leader.png';
                      
                    }elseif ($social_media_total_score > 5 && $social_media_total_score <= 8) {
                      $score_status = 'Influencer';
                      $score_status_icon = 'images/icons/influencer.png';
                    }elseif ($social_media_total_score > 2 && $social_media_total_score <= 5) {
                      $score_status = 'Connector';
                      $score_status_icon = 'images/icons/connector.png';
                    }else{
                      $score_status = 'Novice Speaker';
                      $score_status_icon = 'images/icons/novice_speaker.png';
                    }

			if($res!='')
			{
	 		$attached_links .= '<tr class="test"><td>'.$res['speaker_name'].'</td><td>'.$res['email_id'].'</td><td>'.$res['company'].'</td><td>'.$res['phone'].'</td><td>'.$res['status_name'].'</td><td><span title='.$score_status.' class="custom-tooltip"><img style="text-align:center;width: 24px;margin: auto;" src='.$score_status_icon.' ></span></td><td><a onClick="confirmDeleteSpeaker('.$res['id'].')" style="cursor:pointer;border-right:0px;border-right:0px;margin: auto;display: block;float: none;" class="actionBtn delete"><img src="images/deleteNew.png" title="Delete" id="img_del"/></a></td></tr>';	
				
			}else
			{
			$attached_links .= '';		
			}

		  }
		}

		echo $attached_links;
		
}

function get_speaker_info_EP_new(){

	require("include/mysqli_connect.php");
		$final_array = array();
		$resource_ids = mysqli_real_escape_string($connect, trim($_POST['resource_ids']) );
		$delete_flag = mysqli_real_escape_string($connect, trim($_POST['delete_flag']) );
		$uniq_token = mysqli_real_escape_string($connect, trim($_POST['uniq_token']) );

		$resource_ids_array = explode(",",$resource_ids);

		$attached_links = '';

		foreach ($resource_ids_array as $resource_id) { 
			   $insert_speaker = mysqli_query($connect, "INSERT INTO `new_event_agenda_speakers` (`token`,`speaker_id`,`speaker_name`, `email_id`, `company`,`phone`,`status`,`influencer_total_score`) 

             	select '$uniq_token',id,speaker_name,email_id,company,phone,`status`,social_media_total_score from all_speakers WHERE `id` = '".$resource_id."'");

			//echo $resource_id; 
			$fetch_resource_details = mysqli_query($connect,"select id,speaker_id,speaker_name,email_id,company,phone,(select status_name from all_status where id=new_event_agenda_speakers.`status`) as status_name,influencer_total_score as influencer from new_event_agenda_speakers WHERE `speaker_id` = '".$resource_id."' and token='".$uniq_token."' ");
			$res = mysqli_fetch_array($fetch_resource_details);
				$social_media_total_score = $res['influencer'];
					if(empty($social_media_total_score)) $social_media_total_score = 0;

					$score_status = '';
						if($social_media_total_score > 8){
                      $score_status = 'Thought Leader';
                      $score_status_icon = 'images/icons/thought_leader.png';
                      
                    }elseif ($social_media_total_score > 5 && $social_media_total_score <= 8) {
                      $score_status = 'Influencer';
                      $score_status_icon = 'images/icons/influencer.png';
                    }elseif ($social_media_total_score > 2 && $social_media_total_score <= 5) {
                      $score_status = 'Connector';
                      $score_status_icon = 'images/icons/connector.png';
                    }else{
                      $score_status = 'Novice Speaker';
                      $score_status_icon = 'images/icons/novice_speaker.png';
                    }
             	if($delete_flag==1)
             	{
	 			$attached_links .= '<tr class="test"><td>'.$res['speaker_name'].'</td><td>'.$res['email_id'].'</td><td>'.$res['company'].'</td><td>'.$res['phone'].'</td><td>'.$res['status_name'].'</td><td><span title='.$score_status.' class="custom-tooltip"><img style="cursor:pointer;text-align:center;width: 24px;margin: auto;" src='.$score_status_icon.' ></span></td><td><a style="border-right:0px;border-right:0px;margin: auto;display: block;float: none;" class="actionBtn delete" onClick="confirmDeleteSpeaker('.$res['id'].')" ><img src="images/deleteNew.png" title="Delete"></a></td></tr>';	
	 			}else
	 			{
	 				$attached_links .= '<tr class="test"><td>'.$res['speaker_name'].'</td><td>'.$res['email_id'].'</td><td>'.$res['company'].'</td><td>'.$res['phone'].'</td><td>'.$res['status_name'].'</td><td><span title='.$score_status.' class="custom-tooltip"><img style="text-align:center;width: 24px;margin: auto;" src='.$score_status_icon.' ></span></td><td><a style="border-right:0px;border-right:0px;margin: auto;display: block;float: none;" class="actionBtn delete" onClick="confirmDeleteSpeaker('.$res['id'].')" ><img src="images/deleteNew.png" title="Delete"></a></td></tr>';		
	 			}
		}

		echo $attached_links;		
}

function get_all_events_selected(){
	require("include/mysqli_connect.php");
	//$role_id = $_SESSION['role_id'];
	$final_array = array();
	$speakes_options=array();
	$values_arr = $_POST['values'];
	$tenant_id = $_POST['tenant_id'];

		if($values_arr ==1 )
		{
		$event_list = mysqli_query($connect,"SELECT *  FROM`all_events` WHERE tanent_id='".$tenant_id."' ORDER BY id DESC ");
			while($row = mysqli_fetch_array($event_list)){
				echo "<option  value='".$row['id']."' selected>".$row['event_name']."</option>";				
			}
		}else
		{
			$event_list = mysqli_query($connect,"SELECT *  FROM`all_events` WHERE tanent_id='".$tenant_id."'  ORDER BY id DESC ");
			while($row = mysqli_fetch_array($event_list)){
				echo "<option  value='".$row['id']."' >".$row['event_name']."</option>";

		}
	}
	
}
	function fetch_uploaded_masters_from_temp(){

		require("include/mysqli_connect.php");
		//$role_id = $_SESSION['role_id'];
		$event_id = mysqli_real_escape_string($connect, $_POST['event_id']);		
		
		 //$final_array = array();
		 $inner_array = array();
		 $fetch_masters = mysqli_query($connect,"SELECT * FROM `all_masters_upload_temp` WHERE `event_id` = '".$event_id."' ");
        if(mysqli_num_rows($fetch_masters) > 0)
        {            
            while($row = mysqli_fetch_array($fetch_masters)){
                $inner_array[] = $row;
            }

            echo json_encode($inner_array);            
        }
        else{
              echo json_encode($inner_array);  
        }
	
	}

	function check_duplicate_sponsor_status(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$event_id= trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$status_name = trim(mysqli_real_escape_string($connect, $_POST['status_name']) );		

	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_status WHERE status_name = '".$status_name."' AND event_id = '".$event_id."' AND status_for = 'sponsor' ");
	$res_count = mysqli_num_rows($check_duplicate);
	 
	 if($res_count > 0){  
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function check_duplicate_sponsor_type_for_edit(){

	require("include/mysqli_connect.php");
	$final_array = array();
	
	$event_id= trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$sponsor_type_name = trim(mysqli_real_escape_string($connect, $_POST['sponsor_type_name']) );	
	$sponsor_type_id  = trim(mysqli_real_escape_string($connect, $_POST['sponsor_type_id']) );

	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_sponsor_types WHERE sponsor_type_name = '".$sponsor_type_name."' AND event_id = '".$event_id."' AND id != '".$sponsor_type_id."' ");
	$res_count = mysqli_num_rows($check_duplicate);	 
	 if($res_count > 0){  
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}


function check_duplicate_sponsor_type(){

	require("include/mysqli_connect.php");
	$final_array = array();
	
	$event_id= trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$sponsor_type_name = trim(mysqli_real_escape_string($connect, $_POST['sponsor_type_name']) );		

	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_sponsor_types WHERE sponsor_type_name = '".$sponsor_type_name."' AND event_id = '".$event_id."' ");
	$res_count = mysqli_num_rows($check_duplicate);
	 
	 if($res_count > 0){  
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}


function set_session_google_login(){

	 if(!isset($_SESSION)){ session_start(); }

	require("include/mysqli_connect.php");
	include('include/common_functions.php');
	$common = new commonFunctions();

	$client_id = $_POST['client_id'];
	$cname = $_POST['cname'];
	$cprofile_img = $_POST['cprofile_img'];
	$cemail = $_POST['cemail'];
	$res = '';
	$final_array = array();
			$ua = $common->getBrowser();
			$get_browser_name= $ua['name'];
	       $all_user_sql = mysqli_query($connect,"SELECT * FROM all_users WHERE email='".$cemail."' ");
             if(mysqli_num_rows($all_user_sql) > 0)
              {        
                 $get_user_info = mysqli_fetch_array($all_user_sql);
                 $user_id = $get_user_info['user_id'];
                 $role = $get_user_info['role'];
                 $u_email = $get_user_info['email'];
                 $subscription_id = $get_user_info['subscription_id'];
                 $customer_id = $get_user_info['customer_id'];
                 $first_login = $get_user_info['is_logged_in'];
                 $is_superadmin_f = $get_user_info['is_superadmin'];  
                 $tanent_id	=	$get_user_info['tanent_id'];

                  $fetch_url_query = mysqli_query($connect,"SELECT value FROM site_details where id=2");
                  if(mysqli_num_rows($fetch_url_query) > 0)
                      {            
                          while($row1 = mysqli_fetch_array($fetch_url_query))
                          {
                              $site_url = $row1['value'];
                          }
                       }    

                 $_SESSION['site_url']=$site_url;
                 $_SESSION['user_email']=$u_email;
                 $_SESSION['user_id']=$user_id;
                 $_SESSION['role']=$role;
                 $_SESSION['user_role']=$role;
                 $_SESSION['subscription_id']=$subscription_id;
                 $_SESSION['customer_id']=$customer_id;
                 $_SESSION['login_type']='Google';
                 $_SESSION[$common->GetLoginSessionVar()]=$u_email;
                 
                 $client_ip=$_SERVER['REMOTE_ADDR'];
                 $sql = "INSERT INTO all_login_logs(tanent_id,email_id,client_ip,created_at,login_status,login_type,browser_name,user_id) VALUES ('".$tanent_id."','".$u_email."','".$client_ip."',now(),'success','Google','".$get_browser_name."','".$user_id."')";
                  mysqli_query($connect, $sql);
                  /*$res='success';
			      echo $res;*/
			      $inner_array = array();
			      if($first_login == '1'){
			      	$inner_array['status'] = 'success';
					$inner_array['first_login'] = 'no';
					$inner_array['is_superadmin_f'] = $is_superadmin_f;
					$inner_array['splash_screen']= '';
					$inner_array['status_code'] = 200;	
					$final_array[] = $inner_array;
					echo json_encode($final_array);

			      }else{
			      	$update_first_loin = mysqli_query($connect,"UPDATE `all_users` set `is_logged_in` = '1' where `user_id` = '".$user_id."' ");

			      	$inner_array['status'] = 'success';
					$inner_array['first_login'] = 'yes';
					$inner_array['is_superadmin_f'] = $is_superadmin_f;
					$inner_array['splash_screen']= base64_encode('first_login');
					$inner_array['status_code'] = 200;	
					$final_array[] = $inner_array;
					echo json_encode($final_array);
			      }			      

              }else
              {
              	 $client_ip=$_SERVER['REMOTE_ADDR'];
                 $sql = "INSERT INTO all_login_logs(tanent_id,email_id,client_ip,created_at,login_status,login_type,browser_name,user_id) VALUES ('0','".$cemail."','".$client_ip."',now(),'failed','Google','".$get_browser_name."','0')";
                 mysqli_query($connect, $sql);

              	$inner_array = array();
	           	$inner_array['status'] = 'failed';
				$inner_array['first_login'] = 'no';
				$inner_array['is_superadmin_f'] = $is_superadmin_f;
				$inner_array['splash_screen']= '';
				$inner_array['status_code'] = 200;	
				$final_array[] = $inner_array;
				echo json_encode($final_array);
              }
}


function check_email_existance_signup(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$email= mysqli_real_escape_string($connect, trim($_POST['email']));
	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_users WHERE email = '".$email."' ");

	$res_count = mysqli_num_rows($check_duplicate);
	 
	 if($res_count > 0){  
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

}

function get_speaker_missing_perc(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$speakerid= mysqli_real_escape_string($connect, trim($_POST['speaker_id']));
	$profile_complete = $common->get_speaker_info_missing_value($speakerid);
	 echo json_encode($profile_complete);
}

function set_session_select_all(){
	require("include/mysqli_connect.php");
	 if(!isset($_SESSION)){ session_start(); }
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$selectall_flag = trim(mysqli_real_escape_string($connect, $_POST['selectall_flag']) );

	if($selectall_flag!=0)
	{
		mysqli_query($connect,"SET SESSION group_concat_max_len = 1000000");
		$speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as row_id FROM all_speakers WHERE event_id = '".$event_id."' AND status!='' ");
		$res1 = mysqli_fetch_array($speakers_data1);
		$id_f = $res1['row_id'];
		//$_SESSION['selected_ids']='';
		$_SESSION['select_all_flag'] = 1;
        $_SESSION['selected_ids'] = $id_f;

	}else
	{
		$_SESSION['select_all_flag'] = 0;
        $_SESSION['selected_ids'] = '';
	}
	
}

function check_uncheck_call(){
	require("include/mysqli_connect.php");
	 if(!isset($_SESSION)){ session_start(); }
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$is_checked = trim(mysqli_real_escape_string($connect, $_POST['is_checked']) );
	$spk_id = trim(mysqli_real_escape_string($connect, $_POST['spk_id']) );

	if($is_checked!=0)
	{

		if($_SESSION['selected_ids'] != '' && $_SESSION['selected_ids'] != '0' && $_SESSION['selected_ids'] != null){
			$get_ids=$_SESSION['selected_ids'].','.$spk_id;
		}else{
			$get_ids= $spk_id;
		}
		
        $_SESSION['selected_ids'] = $get_ids;
	}else
	{
		$get_ids=$_SESSION['selected_ids'];
		$get_arr=explode(',', $get_ids);
		 foreach (array_keys($get_arr, $spk_id) as $key) {
			unset($get_arr[$key]);
			}
        $_SESSION['selected_ids'] = implode(',', $get_arr);
        $_SESSION['select_all_flag'] =0;
	}
	
}

function delete_multi_speaker(){

	//require("include/mysqli_connect.php");
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	if(!isset($_SESSION)){ session_start(); }
    $user_id = $_SESSION['user_id'];
	$final_array = array();
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$selected_ids=$_SESSION['selected_ids'];
    $selected_ids_arr=explode(',', $_SESSION['selected_ids']);

    $fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
    $res_sql = mysqli_fetch_array($fetch_sql);
    $session_tanent_id=$res_sql['tanent_id'];


		foreach ($selected_ids_arr as $spk_id) { 
		  $sql="DELETE from all_speakers where id=".$spk_id;
		  $delete_doc = mysqli_query($connect,"DELETE from all_speakers where id=".$spk_id);

		  mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','delete speaker','".$spk_id."','".$user_id."',now(),\"".$sql."\")");
		 }

	 $all_speakers_array = calculate_speaker_dashboard_count($event_id);
	 $speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as status_id FROM all_status WHERE event_id = '".$event_id."' ");
            if(mysqli_num_rows($speakers_data1) > 0)
            {  
                $res1 = mysqli_fetch_array($speakers_data1);
                $row_id = $res1['status_id'];
                $status_ids_array1 = explode(",",$row_id);

                foreach ($status_ids_array1 as $statusid) { 
                if($statusid!=0)
                {

                    $query_sql_sp = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_speakers WHERE all_speakers.status='".$statusid."' and all_speakers.event_id='".$event_id."'");
                    $query_res_sp = mysqli_fetch_array($query_sql_sp);
                    $count_spk_res = mysqli_real_escape_string($connect,$query_res_sp['count_spk']);
                
                    $update_status_details = mysqli_query($connect, "UPDATE `all_status` SET `count_of_speaker_usage`='".$count_spk_res."'   WHERE id=".$statusid);

                }

             }
           }

            $speakers_data2 = mysqli_query($connect,"SELECT group_concat(id) as type_id FROM all_speaker_types WHERE event_id = '".$event_id."' ");
            if(mysqli_num_rows($speakers_data2) > 0)
            {  
                $res2 = mysqli_fetch_array($speakers_data2);
                $row_id2 = $res2['type_id'];
                $status_ids_array2 = explode(",",$row_id2);

                foreach ($status_ids_array2 as $typeid2) { 
                if($typeid2!=0)
                {

                    $query_sql_sp2 = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_speakers WHERE find_in_set('".$typeid2."',all_speakers.speaker_type) and all_speakers.event_id='".$event_id."'");
                    $query_res_sp2 = mysqli_fetch_array($query_sql_sp2);
                    $count_spk_res2 = mysqli_real_escape_string($connect,$query_res_sp2['count_spk']);
                
                    $update_status_details2 = mysqli_query($connect, "UPDATE `all_speaker_types` SET `count_of_speaker_usage`='".$count_spk_res2."'   WHERE id=".$typeid2);

                }

             }
           }

	$_SESSION['select_all_flag'] = '';
    $_SESSION['selected_ids'] = '';

	 if($delete_doc){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Speaker has been deleted successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}

	function set_session_select_all_new_speakers(){
	require("include/mysqli_connect.php");
	 if(!isset($_SESSION)){ session_start(); }
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$selectall_flag = trim(mysqli_real_escape_string($connect, $_POST['selectall_flag']) );

	if($selectall_flag!=0)
	{
		mysqli_query($connect,"SET SESSION group_concat_max_len = 1000000");
		$speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as row_id FROM all_speakers WHERE event_id = '".$event_id."' AND status='' ");
		$res1 = mysqli_fetch_array($speakers_data1);
		$id_f = $res1['row_id'];

		//var_dump($row_id); exit();
		$_SESSION['select_all_flag'] = 1;
        $_SESSION['selected_ids'] = $id_f;

	}else
	{
		$_SESSION['select_all_flag'] = 0;
        $_SESSION['selected_ids'] = '';
	}
	
}

function set_session_select_all_sponsors(){
	require("include/mysqli_connect.php");
	 if(!isset($_SESSION)){ session_start(); }
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$selectall_flag = trim(mysqli_real_escape_string($connect, $_POST['selectall_flag']) );

	if($selectall_flag!=0)
	{
		mysqli_query($connect,"SET SESSION group_concat_max_len = 1000000");
		$speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as row_id FROM all_sponsors WHERE event_id = '".$event_id."'");
		$res1 = mysqli_fetch_array($speakers_data1);
		$id_f = $res1['row_id'];

		//var_dump($row_id); exit();
		$_SESSION['select_all_flag_sponsor'] = 1;
        $_SESSION['selected_ids_sponsor'] = $id_f;

	}else
	{
		$_SESSION['select_all_flag_sponsor'] = 0;
        $_SESSION['selected_ids_sponsor'] = '';
	}
	
}

function check_uncheck_call_sponsors(){
	require("include/mysqli_connect.php");
	 if(!isset($_SESSION)){ session_start(); }
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$is_checked = trim(mysqli_real_escape_string($connect, $_POST['is_checked']) );
	$spk_id = trim(mysqli_real_escape_string($connect, $_POST['spk_id']) );

	if($is_checked!=0)
	{

		if($_SESSION['selected_ids_sponsor'] != '' && $_SESSION['selected_ids_sponsor'] != '0' && $_SESSION['selected_ids_sponsor'] != null){
			$get_ids=$_SESSION['selected_ids_sponsor'].','.$spk_id;
		}else{
			$get_ids= $spk_id;
		}
		
        $_SESSION['selected_ids_sponsor'] = $get_ids;
	}else
	{
		$get_ids=$_SESSION['selected_ids_sponsor'];
		$get_arr=explode(',', $get_ids);
		 foreach (array_keys($get_arr, $spk_id) as $key) {
			unset($get_arr[$key]);
			}
        $_SESSION['selected_ids_sponsor'] = implode(',', $get_arr);
        $_SESSION['select_all_flag'] =0;
	}
	
}

function delete_multi_sponsors(){

	//require("include/mysqli_connect.php");
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	 if(!isset($_SESSION)){ session_start(); }
	$user_id = $_SESSION['user_id'];
	$final_array = array();
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$selected_ids=$_SESSION['selected_ids_sponsor'];
    $selected_ids_arr=explode(',', $_SESSION['selected_ids_sponsor']);

    $fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
    $res_sql = mysqli_fetch_array($fetch_sql);
    $session_tanent_id=$res_sql['tanent_id'];

		foreach ($selected_ids_arr as $spk_id) { 
			$sql="DELETE from all_sponsors where id=".$spk_id;
		  $delete_doc = mysqli_query($connect,"DELETE from all_sponsors where id=".$spk_id);
		   mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','delete sponsor','".$spk_id."','".$user_id."',now(),\"".$sql."\")");
		 }

	$all_speakers_array = calculate_sponsor_dashboard_count($event_id);
	        $speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as status_id FROM all_status WHERE event_id = '".$event_id."' and status_for='sponsor' ");
            if(mysqli_num_rows($speakers_data1) > 0)
            {  
                $res1 = mysqli_fetch_array($speakers_data1);
                $row_id = $res1['status_id'];
                $status_ids_array1 = explode(",",$row_id);

                foreach ($status_ids_array1 as $statusid) { 
                if($statusid!=0)
                {

                    $query_sql_sp = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_sponsors WHERE all_sponsors.status='".$statusid."' and all_sponsors.event_id='".$event_id."'");
                    $query_res_sp = mysqli_fetch_array($query_sql_sp);
                    $count_spk_res = mysqli_real_escape_string($connect,$query_res_sp['count_spk']);
                
                    $update_status_details = mysqli_query($connect, "UPDATE `all_status` SET `count_of_speaker_usage`='".$count_spk_res."'   WHERE id=".$statusid);

                }

             }
           }

          $speakers_data2 = mysqli_query($connect,"SELECT group_concat(id) as type_id FROM all_sponsor_types WHERE event_id = '".$event_id."' ");
            if(mysqli_num_rows($speakers_data2) > 0)
            {  
                $res2 = mysqli_fetch_array($speakers_data2);
                $row_id2 = $res2['type_id'];
                $status_ids_array2 = explode(",",$row_id2);

                foreach ($status_ids_array2 as $typeid) { 
                if($typeid!=0)
                {

                    $query_sql_sp2 = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_sponsors WHERE find_in_set('".$typeid."',all_sponsors.sponsor_type) and all_sponsors.event_id='".$event_id."'");
                    $query_res_sp2 = mysqli_fetch_array($query_sql_sp2);
                    $count_spk_res2 = mysqli_real_escape_string($connect,$query_res_sp2['count_spk']);
                
                    $update_status_details2 = mysqli_query($connect, "UPDATE `all_sponsor_types` SET `total_enrolled`='".$count_spk_res2."'   WHERE id=".$typeid);

                }

             }
           }

	$_SESSION['select_all_flag_sponsor'] = '';
    $_SESSION['selected_ids_sponsor'] = '';

	 if($delete_doc){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Sponsor has been deleted successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}

 function set_session_select_all_masters(){
	require("include/mysqli_connect.php");
	 if(!isset($_SESSION)){ session_start(); }
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$selectall_flag = trim(mysqli_real_escape_string($connect, $_POST['selectall_flag']) );

	if($selectall_flag!=0)
	{
		mysqli_query($connect,"SET SESSION group_concat_max_len = 1000000");
		$speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as row_id FROM all_masters WHERE event_id = '".$event_id."' AND is_approved='1'");
		$res1 = mysqli_fetch_array($speakers_data1);
		$id_f = $res1['row_id'];

		//var_dump($row_id); exit();
		$_SESSION['select_all_flag_master'] = 1;
        $_SESSION['selected_ids_master'] = $id_f;

	}else
	{
		$_SESSION['select_all_flag_master'] = 0;
        $_SESSION['selected_ids_master'] = '';
	}
	
}

function check_uncheck_call_masters(){
	require("include/mysqli_connect.php");
	 if(!isset($_SESSION)){ session_start(); }
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$is_checked = trim(mysqli_real_escape_string($connect, $_POST['is_checked']) );
	$spk_id = trim(mysqli_real_escape_string($connect, $_POST['spk_id']) );

	if($is_checked!=0)
	{

		if($_SESSION['selected_ids_master'] != '' && $_SESSION['selected_ids_master'] != '0' && $_SESSION['selected_ids_master'] != null){
			$get_ids=$_SESSION['selected_ids_master'].','.$spk_id;
		}else{
			$get_ids= $spk_id;
		}
		
        $_SESSION['selected_ids_master'] = $get_ids;
	}else
	{
		$get_ids=$_SESSION['selected_ids_master'];
		$get_arr=explode(',', $get_ids);
		 foreach (array_keys($get_arr, $spk_id) as $key) {
			unset($get_arr[$key]);
			}
        $_SESSION['selected_ids_master'] = implode(',', $get_arr);
        $_SESSION['select_all_flag'] =0;
	}
	
}

function delete_multi_masters(){

	//require("include/mysqli_connect.php");
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	 if(!isset($_SESSION)){ session_start(); }
	$user_id = $_SESSION['user_id'];
	$final_array = array();
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$selected_ids=$_SESSION['selected_ids_master'];
    $selected_ids_arr=explode(',', $_SESSION['selected_ids_master']);

    $fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
    $res_sql = mysqli_fetch_array($fetch_sql);
    $session_tanent_id=$res_sql['tanent_id'];

		foreach ($selected_ids_arr as $spk_id) { 
			$sql="DELETE from all_masters where id=".$spk_id;
		  $delete_doc = mysqli_query($connect,"DELETE from all_masters where id=".$spk_id);
		   mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','delete master','".$spk_id."','".$user_id."',now(),\"".$sql."\")");
		 }

	$all_masters_count_sp = calculate_master_dashboard_count($event_id);
	//$total_master_type_count_update = $common->calculate_master_type_count($event_id); 
	$masters_data1 = mysqli_query($connect,"SELECT group_concat(id) as type_id FROM all_master_types WHERE event_id = '".$event_id."' ");
            if(mysqli_num_rows($masters_data1) > 0)
            {  
                $res1 = mysqli_fetch_array($masters_data1);
                $row_id = $res1['type_id'];
                $status_ids_array1 = explode(",",$row_id);

                foreach ($status_ids_array1 as $typeid) { 
                if($typeid!=0)
                {

                    $query_sql_sp = mysqli_query($connect,"SELECT count(*) as count_masters FROM all_masters WHERE find_in_set('".$typeid."',all_masters.master_type) and all_masters.event_id='".$event_id."'");
                    $query_res_sp = mysqli_fetch_array($query_sql_sp);
                    $count_master_res = mysqli_real_escape_string($connect,$query_res_sp['count_masters']);
                
                    $update_status_details = mysqli_query($connect, "UPDATE `all_master_types` SET `total_masters_enrolled`='".$count_master_res."'   WHERE id=".$typeid);

                }

             }
           }

	$_SESSION['select_all_flag_master'] = '';
    $_SESSION['selected_ids_master'] = '';

	 if($delete_doc){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Master has been deleted successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}

	function set_session_select_all_new_masters(){
	require("include/mysqli_connect.php");
	 if(!isset($_SESSION)){ session_start(); }
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$selectall_flag = trim(mysqli_real_escape_string($connect, $_POST['selectall_flag']) );

	if($selectall_flag!=0)
	{
		mysqli_query($connect,"SET SESSION group_concat_max_len = 1000000");
		$speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as row_id FROM all_masters WHERE event_id = '".$event_id."' AND is_approved='0'");
		$res1 = mysqli_fetch_array($speakers_data1);
		$id_f = $res1['row_id'];

		//var_dump($row_id); exit();
		$_SESSION['select_all_flag_master'] = 1;
        $_SESSION['selected_ids_master'] = $id_f;

	}else
	{
		$_SESSION['select_all_flag_master'] = 0;
        $_SESSION['selected_ids_master'] = '';
	}
	
}


function sponsor_logo_upload(){
	require("include/mysqli_connect.php");
	 $final_array = array();
	$sponsor_id = trim(mysqli_real_escape_string($connect, $_POST['sponsor_id']) );
	$sponsor_logo = trim(mysqli_real_escape_string($connect, $_POST['sponsor_logo']) );
	$new_img_name = "sponsor_logo_".time().".png";
	$directoryName="images/".$new_img_name;
	file_put_contents($directoryName, file_get_contents($sponsor_logo));

	$update_sponsor_logo = mysqli_query($connect,"UPDATE all_sponsors SET `sponsor_logo`= '".$new_img_name."' where id=".$sponsor_id);

	 if($update_sponsor_logo){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Logo uploaded successfully.';
			$inner_array['new_image'] = $new_img_name;
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['new_image'] = '';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function tenant_duplicate_check(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$tenant_name = trim(mysqli_real_escape_string($connect, $_POST['tenant_name']) );	

	$check_duplicate = mysqli_query($connect,"SELECT * FROM all_tenants WHERE tenant_name='".$tenant_name."'");
	$res_count = mysqli_num_rows($check_duplicate);

	 
	 if($res_count > 0){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = $res_count;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['count'] = 0;
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}
}

function update_multi_speaker(){

	//require("include/mysqli_connect.php");
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	if(!isset($_SESSION)){ session_start(); }
    $user_id = $_SESSION['user_id'];
	$final_array = array();
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$status_id = trim(mysqli_real_escape_string($connect, $_POST['status_id']) );
	$selected_ids=$_SESSION['selected_ids'];
    $selected_ids_arr=explode(',', $_SESSION['selected_ids']);

		foreach ($selected_ids_arr as $spk_id) { 
			$update_status = mysqli_query($connect,"UPDATE `all_speakers` set `status` = '$status_id' where `id` = '$spk_id' ");
		 }

	 $all_speakers_array = calculate_speaker_dashboard_count($event_id);
	 $speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as status_id FROM all_status WHERE event_id = '".$event_id."' ");
            if(mysqli_num_rows($speakers_data1) > 0)
            {  
                $res1 = mysqli_fetch_array($speakers_data1);
                $row_id = $res1['status_id'];
                $status_ids_array1 = explode(",",$row_id);

                foreach ($status_ids_array1 as $statusid) { 
                if($statusid!=0)
                {

                    $query_sql_sp = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_speakers WHERE all_speakers.status='".$statusid."' and all_speakers.event_id='".$event_id."'");
                    $query_res_sp = mysqli_fetch_array($query_sql_sp);
                    $count_spk_res = mysqli_real_escape_string($connect,$query_res_sp['count_spk']);
                
                    $update_status_details = mysqli_query($connect, "UPDATE `all_status` SET `count_of_speaker_usage`='".$count_spk_res."'   WHERE id=".$statusid);

                }

             }
           }

	$_SESSION['select_all_flag'] = '';
    $_SESSION['selected_ids'] = '';

	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Speaker Status has been Updated successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}

	function update_multi_master(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	 if(!isset($_SESSION)){ session_start(); }
	$user_id = $_SESSION['user_id'];
	$final_array = array();
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$status_id = trim(mysqli_real_escape_string($connect, $_POST['status_id']) );
	$selected_ids=$_SESSION['selected_ids_master'];
    $selected_ids_arr=explode(',', $_SESSION['selected_ids_master']);

		foreach ($selected_ids_arr as $spk_id) { 
			$update_status = mysqli_query($connect,"UPDATE `all_masters` set `is_approved` = '$status_id' where `id` = '$spk_id' ");
		 }

	$_SESSION['select_all_flag_master'] = '';
    $_SESSION['selected_ids_master'] = '';

	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Master Status has been Updated successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}

	function update_multi_sponsor(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	 if(!isset($_SESSION)){ session_start(); }
	$user_id = $_SESSION['user_id'];
	$final_array = array();
	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$status_id = trim(mysqli_real_escape_string($connect, $_POST['status_id']) );
	$selected_ids=$_SESSION['selected_ids_sponsor'];
    $selected_ids_arr=explode(',', $_SESSION['selected_ids_sponsor']);


		foreach ($selected_ids_arr as $spk_id) { 
			$update_status = mysqli_query($connect,"UPDATE `all_sponsors` set `status` = '$status_id' where `id` = '$spk_id' ");
		 }

			$all_speakers_array = calculate_sponsor_dashboard_count($event_id);
	        $speakers_data1 = mysqli_query($connect,"SELECT group_concat(id) as status_id FROM all_status WHERE event_id = '".$event_id."' and status_for='sponsor' ");
            if(mysqli_num_rows($speakers_data1) > 0)
            {  
                $res1 = mysqli_fetch_array($speakers_data1);
                $row_id = $res1['status_id'];
                $status_ids_array1 = explode(",",$row_id);

                foreach ($status_ids_array1 as $statusid) { 
                if($statusid!=0)
                {

                    $query_sql_sp = mysqli_query($connect,"SELECT count(*) as count_spk FROM all_sponsors WHERE all_sponsors.status='".$statusid."' and all_sponsors.event_id='".$event_id."'");
                    $query_res_sp = mysqli_fetch_array($query_sql_sp);
                    $count_spk_res = mysqli_real_escape_string($connect,$query_res_sp['count_spk']);
                
                    $update_status_details = mysqli_query($connect, "UPDATE `all_status` SET `count_of_speaker_usage`='".$count_spk_res."'   WHERE id=".$statusid);

                }

             }
           }

         
	$_SESSION['select_all_flag_sponsor'] = '';
    $_SESSION['selected_ids_sponsor'] = '';

	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['message'] = 'Sponsor Status has been Updated successfully.';
			$final_array[] = $inner_array;

			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failure';
			$inner_array['message'] = 'Something went wrong! Please try again.';

			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		}

	}

	function insert_save_time_plan(){
			include('include/common_functions.php');
			$common = new commonFunctions();
			$connect = $common->connect();
			$fetch_site_details = mysqli_query($connect,"SELECT * FROM site_details WHERE id = '2'");
			$res_site_url = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_url['value'];

			$user_name = mysqli_real_escape_string($connect,$_POST['user_name']);
			$company_name= mysqli_real_escape_string($connect,$_POST['company_name']);
			$email_id= mysqli_real_escape_string($connect,$_POST['email_id']);			
			$no_events_per_year= mysqli_real_escape_string($connect,$_POST['no_events_per_year']);
			$no_speakers_per_year= mysqli_real_escape_string($connect,$_POST['no_speakers_per_year']);
			$no_sponsors_per_year= mysqli_real_escape_string($connect,$_POST['no_sponsors_per_year']);
			$no_people= mysqli_real_escape_string($connect,$_POST['no_people']);
			$community_members= mysqli_real_escape_string($connect,$_POST['community_members']);
			$tools_selected = mysqli_real_escape_string($connect,$_POST['tools_selected']);

			if(empty($no_events_per_year)) $no_events_per_year = 0;
			if(empty($no_speakers_per_year)) $no_speakers_per_year = 0;
			if(empty($no_sponsors_per_year)) $no_sponsors_per_year = 0;
			if(empty($no_people)) $no_people = 0;
			if(empty($community_members)) $community_members = 0;

			$total_hours_saved_res=round((1.15*$no_events_per_year*$no_people)*(7*$no_speakers_per_year+2.5*$no_sponsors_per_year+0.02*$community_members),0);
			$total_hours_saved=number_format($total_hours_saved_res, 0);

			$insert_details = mysqli_query($connect,"INSERT INTO `save_time_plan` ( name, company, email_address, total_events_per_year, avg_speakers_per_event, avg_sponsors_per_event, no_people_in_team,community_members,tools_selected,total_hours_saved) VALUES ('".$user_name."','".$company_name."','".$email_id."','".$no_events_per_year."','".$no_speakers_per_year."','".$no_sponsors_per_year."','".$no_people."','".$community_members."','".$tools_selected."','".$total_hours_saved."') ");

			$last_insert_id = mysqli_insert_id($connect);


         	 $tdy=Date("Y-m-d H:i:s");
             $date = new DateTime($tdy);
             $date->modify("-8 hours"); // converting to PST
             $login_utc_to_pst= $date->format("Y-m-d H:i:s");

			$headers = array(
         		"Authorization: Bearer nc4ecxb911lpsz8bdcpjkeeu11",
         		"Content-Type: application/json"
         	);
         	// Connect to Smartsheet API to share sheet
         	$postfields = '{"toTop":true, "cells": [ {"columnId": 1403196867405700, "value": "'.$login_utc_to_pst.'"},{"columnId": 6913811706865540, "value": "'.$user_name.'"},{"columnId": 1284312172652420, "value": "'.$company_name.'"},{"columnId": 5787911800022916, "value": "'.$email_id.'"},{"columnId": 3536111986337668, "value": "'.$no_events_per_year.'"},{"columnId": 8039711613708164, "value": "'.$no_speakers_per_year.'"},{"columnId": 721362219231108, "value": "'.$no_sponsors_per_year.'"},{"columnId": 8594140352014212, "value": "'.$no_people.'"},{"columnId": 431366027405188, "value": "'.$community_members.'"},{"columnId": 2683165841090436, "value": "'.$total_hours_saved.'"},{"columnId": 4934965654775684, "value": "'.$tools_selected.'"} ]  }';
         	$curlSession = curl_init("https://api.smartsheet.com/2.0/sheets/7947204062144388/rows");
         	curl_setopt($curlSession, CURLOPT_HTTPHEADER, $headers);
         	curl_setopt($curlSession, CURLOPT_POST, 1);
         	curl_setopt($curlSession, CURLOPT_POSTFIELDS, $postfields);
         	curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, TRUE);
         
         	$shareResponseData = curl_exec($curlSession);

			 $content = '<table bgcolor="#F1F1F1" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <style type="text/css">@media only screen and (max-width: 640px){
        body body{width:auto!important;}
        body td[class=full], .full {width: 100%!important; clear: both; display: table;}
    }
    </style>
        <tr>
            <td style="background: #007DB7;">
                <table valign="center" cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: #007DB7;">
                    <tr valign="center">
                        <td valign="center" style="padding-top: 25px;padding-bottom: 20px;"><img src="'.$site_url.'/images/main-logo.png" width="150" alt="Speaker Engage" /></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="width: 30px;padding-top:40px; padding-bottom:40px;"></td>
                        <td valign="top" style="padding-top:40px; padding-bottom:40px;">

                            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0" width="850" align="center" border="0">
                                            <tr>
                                                <td>

                                                    <table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 20px;font-size: 18px;">Dear '.$user_name.',</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 0px;font-size: 18px;">Thank you for taking the time to learn about how many hours you could save by using Speaker Engage Solution.  We calculated the average time savings based on the information you provided.</p>
                                                            </td>
                                                        </tr>
                                                       
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;" valign="center">
                                                                <table cellpadding="5" cellspacing="0" width="100%" bgcolor="">
                                                                    <tr>
                                                                        <td style="border:1px solid #ddd;" valign="center" valign="top" class="full"  align="left">
                                                                <table cellpadding="5" cellspacing="0" bgcolor="" align="left" style="width: 100%;">
                                                                    <tr>
                                                                        <td style="padding-left: 20px;padding-right: 20px;width: 50%;">
                                                                            <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;padding-bottom: 10px;border-bottom: 1px solid #ddd;">Average # of events you host per year: <span style="color: #007DB7;font-weight: 600;">'.$no_events_per_year.'</span></p>

                                                                            <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;padding-bottom: 10px;border-bottom: 1px solid #ddd;">Average # of speakers per event: <span style="color: #007DB7;font-weight: 600;">'.$no_speakers_per_year.'</span></p>

                                                                            <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;padding-bottom: 10px;border-bottom: 1px solid #ddd;">Average # of sponsors per event: <span style="color: #007DB7;font-weight: 600;">'.$no_sponsors_per_year.'</span></p>

                                                                            <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;padding-bottom: 10px;border-bottom: 1px solid #ddd;">Average # of team members involved in executing the events: <span style="color: #007DB7;font-weight: 600;">'.$no_people.'</span></p>

                                                                            <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;padding-bottom: 10px;border-bottom: 1px solid #ddd;">Average # of community members attending this event: <span style="color: #007DB7;font-weight: 600;">'.$community_members.'</span></p>
                                                                            <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">Tools you use to execute your events: <span style="color: #007DB7;font-weight: 600;">'.$tools_selected.'</span></p>
                                                                        </td>
                                                                        
                                                                    </tr>
                                                                </table>   
                                                                </td> 
                                                                <td style="border:1px solid #ddd;width: 50%;border-left: 0px;" valign="center" valign="top" val class="full"  align="left">
                                                                <table cellpadding="5" cellspacing="0" width="50%" align="left" val class="full" bgcolor="" style="width: 100%;"  >

                                                                <tr>
	                                                            <td>
	                                                                <p style="padding-left:20px;padding-right:20px;font-size: 18px;margin-bottom:0px;">Based on the information you provided, you will save:</p>
	                                                            </td>
                                                        		</tr>
                                                                    <tr>
                                                                        <td style="padding-left: 20px;padding-right: 20px;width: 50%;">
                                                                            <h3 style="margin-bottom: 10px;margin-top: 0px;font-size: 28px;"><span style="color: #007DB7;font-weight: 600;">'.$total_hours_saved.'</span> hours per year</h3>
                                                                        </td>
                                                                    </tr>
                                                                </table>                                                               
                                                            </td> 
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                           
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 10px;margin-top: 10px;font-size: 18px;">If this is of interest to you, we would love to share a demo of Speaker Engage platform with you. You can schedule the demo here. <a href="https://www.speakerengage.com/demo/index.php" style="color: #007DB7;">Schedule Demo</a> </p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">We also offer a 30 days FREE trial option. You can sign up at <a href="https://www.speakerengage.com/login.php" style="color: #007DB7;">FREE Trial</a> </p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 10px;margin-top: 0px;font-size: 18px;">Learn more at: <a href="https://speakerengage.com" style="color: #007DB7;">https://speakerengage.com</a> </p>
                                                            </td>
                                                        </tr>

                                                        
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;font-size: 20px;color: #007DB7;font-weight: 600;margin-top: 10px;">Get in Touch!</p>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 0px;margin-top: 0px;font-size: 18px;">If there is anything you would like to know, write to us at <a style="text-decoration: none;color: #007DB7;" href="mailto:support@speakerengage.com">support@speakerengage.com</a> </p>
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
                                                    

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="background-color: #e2e2e2;">
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
                        <td style="width: 30px;padding-top:40px; padding-bottom:40px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';

			$from_email='noreply@speakerengage.com';

            $common->sendEmail($email_id, $from_email, "Saving Time with Speaker Engage", $content);

			 $update_content = mysqli_query($connect, "UPDATE `save_time_plan` SET `email_sent_content`='".$content."'   WHERE id=".$last_insert_id."");

				if($insert_details){
					$inner_array = array();
					$inner_array['status'] = 'success';
					$inner_array['message'] = 'Updated successfully.';
					$final_array[] = $inner_array;

					echo json_encode($final_array);
				}
				else{
					$inner_array = array();
					$inner_array['status'] = 'failure';
					$inner_array['message'] = 'Something went wrong! Please try again.';

					$final_array[] = $inner_array;
					echo json_encode($final_array);	
				}
			
}



function contact_us_enterprise_pricing(){
			include('include/common_functions.php');
			$common = new commonFunctions();
			$connect = $common->connect();
			$fetch_site_details = mysqli_query($connect,"SELECT * FROM site_details WHERE id = '2'");
			$res_site_url = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_url['value'];

			$contact_name = mysqli_real_escape_string($connect,$_POST['contact_name']);
			$to_email= mysqli_real_escape_string($connect,$_POST['contact_email']);
			$company_name= mysqli_real_escape_string($connect,$_POST['company_name']);
			$contact_message= mysqli_real_escape_string($connect,$_POST['contact_message']);			
			

			$tdy=Date("Y-m-d H:i:s");
             $date = new DateTime($tdy);
             $date->modify("-8 hours"); // converting to PST
             $login_utc_to_pst= $date->format("Y-m-d H:i:s");

             $randomNumber = round(rand(),4);

			$headers = array(
         		"Authorization: Bearer nc4ecxb911lpsz8bdcpjkeeu11",
         		"Content-Type: application/json"
         	);
         	// Connect to Smartsheet API to share sheet
         	$postfields = '{"toTop":true, "cells": [ {"columnId": 5099892398942084, "value": "ID-'.$randomNumber.'"},{"columnId": 2848092585256836, "value": "'.$login_utc_to_pst.'"},{"columnId": 7351692212627332, "value": "'.$contact_name.'"},{"columnId": 1722192678414212, "value": "'.$to_email.'"},{"columnId": 6225792305784708, "value": ""},{"columnId": 3973992492099460, "value": "'.$company_name.'"},{"columnId": 4235663374608260, "value": ""},{"columnId": 8739263001978756, "value": "'.$contact_message.'"},{"columnId": 928774142355332, "value": "Enterprise Plan"} ]  }';
         	$curlSession = curl_init("https://api.smartsheet.com/2.0/sheets/2300335680186244/rows");
         	curl_setopt($curlSession, CURLOPT_HTTPHEADER, $headers);
         	curl_setopt($curlSession, CURLOPT_POST, 1);
         	curl_setopt($curlSession, CURLOPT_POSTFIELDS, $postfields);
         	curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, TRUE);
         
         	$shareResponseData = curl_exec($curlSession);	

         	$curl_res_decode = json_decode($shareResponseData);

         	   $content='<table bgcolor="#F1F1F1" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
                                                                <p style="margin-bottom: 5px;margin-top: 20px;font-size: 18px;">Hello '.$contact_name.',</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding-left: 20px;padding-right: 20px;">
                                                                <p style="margin-bottom: 5px;margin-top: 0px;font-size: 18px;">Thank you very much for reaching out to us on the Enterprise Plan from Speaker Engage. One of our product experts will connect with you shortly.</p>
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

			/*$content = 'Hi '.$contact_name.'<br/>
			Thank you very much for reaching out to us on the Enterprise Plan from Speaker Engage. One of our product experts will connect with you shortly.<br/>
			Cheers,<br/>
			Speaker Engage Team';*/
			$from_email='support@speakerengage.com';
            $trigger_email = $common->sendEmail($to_email, $from_email, "Thank you! We will connect with you shortly.", $content);
			if($curl_res_decode->message == 'SUCCESS'){
				$inner_array = array();
				$inner_array['status'] = 'success';
				$inner_array['message'] = 'Updated successfully.';
				$final_array[] = $inner_array;

				echo json_encode($final_array);
			}
			else{
				$inner_array = array();
				$inner_array['status'] = 'failure';
				$inner_array['message'] = 'Something went wrong! Please try again.';

				$final_array[] = $inner_array;
				echo json_encode($final_array);	
			}
			
}


function insert_get_in_touch(){
			include('include/common_functions.php');
			$common = new commonFunctions();
			$connect = $common->connect();
			$fetch_site_details = mysqli_query($connect,"SELECT * FROM site_details WHERE id = '2'");
			$res_site_url = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_url['value'];

			$user_name = mysqli_real_escape_string($connect,$_POST['full_name']);
			$company_name= mysqli_real_escape_string($connect,$_POST['company_name']);
			$phone= mysqli_real_escape_string($connect,$_POST['phone']);			
			$email_address= mysqli_real_escape_string($connect,$_POST['email_address']);
			$no_of_event= mysqli_real_escape_string($connect,$_POST['no_of_event']);
			$message= mysqli_real_escape_string($connect,$_POST['message']);
			$source = isset($_POST['source']) ? $_POST['source'] : 'Speaker Engage';


			$insert_details = mysqli_query($connect,"INSERT INTO `get_in_touch_form` ( full_name, email_address, phone, company_name, events_in_year, message,source) VALUES ('".$user_name."','".$email_address."','".$phone."','".$company_name."','".$no_of_event."','".$message."','".$source."') ");

			$last_insert_id = mysqli_insert_id($connect);


         	 $tdy=Date("Y-m-d H:i:s");
             $date = new DateTime($tdy);
             $date->modify("-8 hours"); // converting to PST
             $login_utc_to_pst= $date->format("Y-m-d H:i:s");

             $randomNumber = round(rand(),4);

			$headers = array(
         		"Authorization: Bearer nc4ecxb911lpsz8bdcpjkeeu11",
         		"Content-Type: application/json"
         	);
         	// Connect to Smartsheet API to share sheet
         	$postfields = '{"toTop":true, "cells": [ {"columnId": 5099892398942084, "value": "ID-'.$randomNumber.'"},{"columnId": 2848092585256836, "value": "'.$login_utc_to_pst.'"},{"columnId": 7351692212627332, "value": "'.$user_name.'"},{"columnId": 1722192678414212, "value": "'.$email_address.'"},{"columnId": 6225792305784708, "value": "'.$phone.'"},{"columnId": 3973992492099460, "value": "'.$company_name.'"},{"columnId": 4235663374608260, "value": "'.$no_of_event.'"},{"columnId": 8739263001978756, "value": "'.$message.'"},{"columnId": 5019315071149956, "value": "'.$source.'"} ]  }';
         	$curlSession = curl_init("https://api.smartsheet.com/2.0/sheets/2300335680186244/rows");
         	curl_setopt($curlSession, CURLOPT_HTTPHEADER, $headers);
         	curl_setopt($curlSession, CURLOPT_POST, 1);
         	curl_setopt($curlSession, CURLOPT_POSTFIELDS, $postfields);
         	curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, TRUE);
         
         	$shareResponseData = curl_exec($curlSession);

			//  $content = '<div style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#000000">
			// <div style="width:680px">
			//   <p style="margin-top:0px;margin-bottom:15">Dear '.$user_name.', <br></p>
			//   <p style="margin-top:0px;margin-bottom:15px">We are so glad that you wanted to find out how many hours you could potential save by using Speaker Engage.  The information you shared was used to compute the average time savings while executing your events based on several factors of traditional event execution methods.</p>
			//   <p style="margin-top:0px;margin-bottom:15px">You shared the follwing informaton:</p>
			//   <p style="margin-top:0px;margin-bottom:15px"># of events hosted per year: '.$no_events_per_year.'</p>
			//   <p style="margin-top:0px;margin-bottom:15px">Average # of seakers per event: '.$no_speakers_per_year.'</p>
			//   <p style="margin-top:0px;margin-bottom:15px">Average number of sponsors per event: '.$no_sponsors_per_year.'</p>
			//   <p style="margin-top:0px;margin-bottom:15px">Number of team members involved in executing the events: '.$no_people.'</p>
			//   <p style="margin-top:0px;margin-bottom:15px">Number of community members (board members, contributors, volunteers): '.$community_members.'</p>
			//   <p style="margin-top:0px;margin-bottom:15px">You also shared that you use the following tools to execute your events: '.$tools_selected.'</p>
			//   <p style="margin-top:0px;margin-bottom:15px">Based on the information you provided, we believe that you can save '.$total_hours_saved.' hours per year.</p>
			//   <p style="margin-top:0px;margin-bottom:15px">If this is of interest to you, we would love to share a demo of Speaker Engage platform with you.  You can schedule the demo here.</p>
			//   <p style="margin-top:0px;margin-bottom:15px">We also offer a 30 days FREE trial option.  You can sign up at <a href="'.$site_url.'/login.php">"'.$site_url.'/login.php"</a></p>
			//   <p style="margin-top:0px;margin-bottom:15px"><br><br>Thanks,<br>
			// Speaker Engage Team</p>
			// </div>
			// </div>';

			// $from_email='noreply@speakerengage.com';

   //          $common->sendEmail($email_id, $from_email, "Speaker Engage: Save Time Plan", $content);

			//  $update_content = mysqli_query($connect, "UPDATE `save_time_plan` SET `email_sent_content`='".$content."'   WHERE id=".$last_insert_id."");

				if($insert_details){
					$inner_array = array();
					$inner_array['status'] = 'success';
					$inner_array['message'] = 'Updated successfully.';
					$final_array[] = $inner_array;

					echo json_encode($final_array);
				}
				else{
					$inner_array = array();
					$inner_array['status'] = 'failure';
					$inner_array['message'] = 'Something went wrong! Please try again.';

					$final_array[] = $inner_array;
					echo json_encode($final_array);	
				}

				
}

function get_subject_by_epid(){
	require("include/mysqli_connect.php");
	$final_array = array();

	$ep_id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );
    
        $fetch_all_email_templates = mysqli_query($connect,"SELECT *,(select event_name from all_events where id=event_presentation.event_id) as event_name,date_format(date(event_presentation.event_date), '%d-%b-%Y') as event_on  FROM event_presentation  WHERE ep_id='".$ep_id."'");        
        $inner_array = array();
        if(mysqli_num_rows($fetch_all_email_templates) > 0)
        {            
            while($row = mysqli_fetch_array($fetch_all_email_templates)){
                $inner_array[] = $row;
            }
            echo json_encode($inner_array);            
        }
        else{
              echo json_encode($inner_array);  
        }
 }

  function get_event_agenda_info(){
 	require("include/mysqli_connect.php");
	$id = mysqli_real_escape_string($connect,$_POST['ep_id']);
	
	$fetch_sql = mysqli_query($connect,"SELECT *,(select speaker_type_name from all_speaker_types  at where at.id=event_presentation.opportunity_type) as opportunity_type,(select event_name from all_events where id=event_presentation.event_id) as event_name,date_format(date(event_presentation.event_date), '%d-%b-%Y') as event_on  FROM event_presentation  WHERE ep_id='".$id."'"); 

     $res_sql = mysqli_fetch_array($fetch_sql);
     $date = $res_sql['event_date'];
     $event_date=date('l,F d, Y', strtotime($date));
     $location=$res_sql['location'];
     $presentation_topic=$res_sql['presentation_topic'];
     $abstract=$res_sql['abstract'];
     $opportunity_type=$res_sql['opportunity_type'];	

	$fetch_url_query = mysqli_query($connect,"select group_concat(speaker_id) as speaker_id from event_agenda_speakers where event_agenda_speakers.ep_id='".$id."'");
    if(mysqli_num_rows($fetch_url_query) > 0)
        {            
            while($row1 = mysqli_fetch_array($fetch_url_query))
            {
                $speakers_id = $row1['speaker_id'];
            }
         }  

	$resource_ids_array = explode(",",$speakers_id);

                        $attached_links = '';
                        foreach ($resource_ids_array as $resource_id) { 
							//echo $resource_id; 
							$fetch_resource_details = mysqli_query($connect,"select id,speaker_name,company,linkedin_url from all_speakers WHERE `id` = '".$resource_id."' ");
							$res = mysqli_fetch_array($fetch_resource_details);
							//$attached_links .= '<div class="speakerNamediv">'.$res['speaker_name'].'</div>';
							$attached_links .= '<li>'.$res['speaker_name'].', '.$res['company'].', '.$res['linkedin_url'].'</li>';

						}



	$content ='<p>We are excited to have you as a speaker. Please accept our invitation for your session. If you need any information, please contact us at:</p>
				<p>The details of your presentation would be as follows:</p>
				<p><b>Presentation Date:</b> '.$event_date.'</p>
				<p><b>Conference Location:</b> '.$location.'</p>
				<p><b>Proposed Topic/Category:</b> '.$presentation_topic.'</p>
				<p><b>Session Type:</b> '.$opportunity_type.'</p>
				<p><b>Speakers:</b></p>
				<ul>
				'.$attached_links.'
				</ul>
				<p><b>Presentation Format:</b> '.$abstract.'</p>';

		$content=$content;

		echo $content;

	
}

function insert_email_templates_from_popup(){

	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	if(!isset($_SESSION)){ session_start(); }
	$event_id= mysqli_real_escape_string($connect, trim($_POST['event_id']) );
	$logged_in_user= $_SESSION['user_id'];
	$fetch_sql = mysqli_query($connect,"SELECT tanent_id from all_events where id='".$event_id."' ");       
    $res_sql = mysqli_fetch_array($fetch_sql);
    $session_tanent_id=$res_sql['tanent_id']; 

		$final_array = array();
		$resource_ids = mysqli_real_escape_string($connect, trim($_POST['resource_ids']) );
		$resource_ids_array = explode(",",$resource_ids);

		foreach ($resource_ids_array as $resource_id) { 

             $insert_speaker = "INSERT INTO `all_email_templates` (`tanent_id`,`template_name`, `template_data`, `template_subject`,`created_by_user_id`,`template_type`,event_id) 

             	select $session_tanent_id,template_name,template_data,template_subject,$logged_in_user,template_type,$event_id from all_email_templates WHERE `id` = '".$resource_id."'";
             	mysqli_query($connect,$insert_speaker);


             if($insert_speaker){
				$template_id = mysqli_insert_id($connect);

				//**** add log
				mysqli_query($connect, "INSERT INTO all_crud_logs(tanent_id,event_id,operation,action_pk_id,created_by,created_at,sql_qry) VALUES ('".$session_tanent_id."','".$event_id."','create email template from popup','".$template_id."','".$logged_in_user."',now(),\"".$insert_speaker."\")");
			}

		}

		echo base64_encode($event_id).':'.base64_encode(rand(100,999));
		
}

function update_postname(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$postname = trim(mysqli_real_escape_string($connect, $_POST['postname']) );


	$update_status = mysqli_query($connect,"UPDATE `social_media_calendar` set `post_name` = '$postname' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_target_url(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$target_url = trim(mysqli_real_escape_string($connect, $_POST['target_url']) );


	$update_status = mysqli_query($connect,"UPDATE `social_media_calendar` set `target_url` = '$target_url' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_hashtags(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$hashtag = trim(mysqli_real_escape_string($connect, $_POST['hashtag']) );


	$update_status = mysqli_query($connect,"UPDATE `social_media_calendar` set `hashtags` = '$hashtag' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_post_status(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$status_id = trim(mysqli_real_escape_string($connect, $_POST['status_id']) );

	$update_status = mysqli_query($connect,"UPDATE `social_media_calendar` set `status_id` = '$status_id' where `id` = '$id' ");          
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}


function update_fb_check(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$is_check = trim(mysqli_real_escape_string($connect, $_POST['is_check']) );

	$update_status = mysqli_query($connect,"UPDATE `social_media_calendar` set `is_fb` = '$is_check' where `id` = '$id' ");          
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_insta_check(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$is_check = trim(mysqli_real_escape_string($connect, $_POST['is_check']) );

	$update_status = mysqli_query($connect,"UPDATE `social_media_calendar` set `is_insta` = '$is_check' where `id` = '$id' ");          
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_lin_check(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$is_check = trim(mysqli_real_escape_string($connect, $_POST['is_check']) );

	$update_status = mysqli_query($connect,"UPDATE `social_media_calendar` set `is_linkedin` = '$is_check' where `id` = '$id' ");          
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function update_twi_check(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$is_check = trim(mysqli_real_escape_string($connect, $_POST['is_check']) );

	$update_status = mysqli_query($connect,"UPDATE `social_media_calendar` set `is_twitter` = '$is_check' where `id` = '$id' ");          
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}

function delete_socialplanner_docs(){

	require("include/mysqli_connect.php");
	$final_array = array();
	$doc_id = mysqli_real_escape_string($connect, trim($_POST['doc_id']) );
	$ptype= mysqli_real_escape_string($connect, $_POST['ptype']);
	$post_id= mysqli_real_escape_string($connect, $_POST['post_id']);

	$delete_file_dropzone = mysqli_query($connect,"DELETE FROM `social_media_posts` WHERE `id` = '".$doc_id."' ");  
    if($delete_doc){
    	if($ptype=='1')
         {
           mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_fb`='0' WHERE id=".$post_id );   
         }else if($ptype=='2')
         {
            mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_insta`='0' WHERE id=".$post_id );  
         }else if($ptype=='3')
         {
            mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_linkedin`='0' WHERE id=".$post_id );  
         }else if($ptype=='4')
         {
            mysqli_query($connect, "UPDATE `social_media_calendar` SET `is_twitter`='0' WHERE id=".$post_id );  
         }

        $return_arr[] = array("id" => 1,
                            "file_name" => 1
                                        );
    }else
    {
      $return_arr[] = array("id" => 0,
                            "file_name" => 0
                                        );
    }
    echo json_encode($return_arr);
 }

 function delete_list_view(){
	require("include/mysqli_connect.php");
	$final_array = array();

	 $postid = trim(mysqli_real_escape_string($connect, $_POST['postid']) );

	 $sql1 = "delete  from social_media_calendar where id='".$postid."'";
	 $res=mysqli_query($connect, $sql1);
	 $response= '1';
	 
	 if (isset($res)) {
	     $response= '1';
	 }
	 else
	 {
	     $response= '2';
	 } 

	 echo $response;
}

function get_calendar_details_by_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );

	$speaker_details = mysqli_query($connect,"SELECT *,(select campaign_name from all_social_planner where id=social_media_calendar.campaign_id) as campaign_name,(select status_name from all_social_media_planner_status where id=social_media_calendar.status_id) as status_name,date_format(target_date, '%d-%b-%Y') as tdate FROM social_media_calendar WHERE id = '".$id."'");
	 
	 if(mysqli_num_rows($speaker_details) > 0){
			$inner_array = array();
			$res = mysqli_fetch_array($speaker_details);
			$final_array[] = $res;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
}

function get_fb_details_by_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );

	$speaker_details = mysqli_query($connect,"SELECT * FROM social_media_posts WHERE post_type_id='1' and post_id = '".$id."'");
	 
	 if(mysqli_num_rows($speaker_details) > 0){
			$inner_array = array();
			$res = mysqli_fetch_array($speaker_details);
			$final_array[] = $res;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
}

function get_insta_details_by_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );

	$speaker_details = mysqli_query($connect,"SELECT * FROM social_media_posts WHERE post_type_id='2' and post_id = '".$id."'");
	 
	 if(mysqli_num_rows($speaker_details) > 0){
			$inner_array = array();
			$res = mysqli_fetch_array($speaker_details);
			$final_array[] = $res;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
}

function get_lin_details_by_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );

	$speaker_details = mysqli_query($connect,"SELECT * FROM social_media_posts WHERE post_type_id='3' and post_id = '".$id."'");
	 
	 if(mysqli_num_rows($speaker_details) > 0){
			$inner_array = array();
			$res = mysqli_fetch_array($speaker_details);
			$final_array[] = $res;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
}

function get_twitter_details_by_id(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['ep_id']) );

	$speaker_details = mysqli_query($connect,"SELECT * FROM social_media_posts WHERE post_type_id='4' and post_id = '".$id."'");
	 
	 if(mysqli_num_rows($speaker_details) > 0){
			$inner_array = array();
			$res = mysqli_fetch_array($speaker_details);
			$final_array[] = $res;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
}

 function social_media_planner_request_info(){
	include('include/common_functions.php');
	$common = new commonFunctions();
	$connect = $common->connect();
	$final_array = array();

	$event_id = trim(mysqli_real_escape_string($connect, $_POST['event_id']) );
	$postid = trim(mysqli_real_escape_string($connect, $_POST['postid']) );
	$email_address = trim(mysqli_real_escape_string($connect, $_POST['email_address']) );
	$session_tanent_id=  $common->get_tenant_id_from_eventid($event_id);
	$info_msg = mysqli_real_escape_string($connect, $_POST['info_msg']);
	$info_msg = str_replace('\n', "\n", $info_msg);
	$info_msg = str_replace('\r', "\r", $info_msg);

	$token = md5(uniqid());	

	$is_post_info = 0;
	$is_fbpost = 0;
	$is_instapost = 0;
	$is_linpost = 0;
	$is_twitterpost = 0;

	if (strpos($_POST['selectinfo'], "is_post_info") !== false){
		$is_post_info = 1;
    }
	
	if (strpos($_POST['selectinfo'], "is_fbpost") !== false){
		$is_fbpost = 1;
    }

    if (strpos($_POST['selectinfo'], "is_instapost") !== false){
		$is_instapost = 1;
    }

    if (strpos($_POST['selectinfo'], "is_linpost") !== false){
		$is_linpost = 1;
    }

    if (strpos($_POST['selectinfo'], "is_twitterpost") !== false){
		$is_twitterpost = 1;
    }

    $loggedin_userid = $_SESSION['user_id'];
    // fetch loggedin user details
    $user_details = $common->get_user_details_by_id($loggedin_userid); 
     $loggedin_user_name = $user_details[0]['first_name'];

     //loggedin_user_email 
     $from_email = $user_details[0]['email']; 


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


    $insert_request = mysqli_query($connect, "INSERT INTO information_collect(headshot,bio,quote,address,speaker_manager,message,token,sent_to_speaker_id) VALUES ('".$is_post_info."','".$is_fbpost."','".$is_instapost."','".$is_linpost."','".$is_twitterpost."','".$info_msg."' ,'".$token."','".$postid."') ");

     $sql =  "INSERT INTO information_collect(headshot,bio,quote,address,speaker_manager,message,token,sent_to_speaker_id) VALUES ('".$is_post_info."','".$is_fbpost."','".$is_instapost."','".$is_linpost."','".$is_twitterpost."','".$info_msg."' ,'".$token."','".$postid."')";	

    mysqli_query($connect, "INSERT INTO all_logs(tanent_id,operation,table_name,created_by,sql_qry,table_id,event_id) VALUES ('".$session_tanent_id."','request missing information social planner','information_collect_social_planner','".$loggedin_userid."',\"".$sql."\",'".$postid."','".$event_id."')"); 
    $last_insert_id = mysqli_insert_id($connect);

    $dynamic_link = $site_url."/collect-info-social-planner.php?tk=".$token;

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
							<td><p style="margin-bottom: 0;margin-top: 10px;font-size: 14px;">Hi <span style="font-weight: 600;">There</span>,</p></td>
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


	$cc_emails_arr = explode(",",$_POST['email_address']);
		foreach($cc_emails_arr as $cc_email){
				$email_id = trim($cc_email);
				if(!empty($email_id)){
				$send_email = $common->sendEmail($email_id , $from_email, 'Request for Missing Information Social Planner',$email_body."<img src='".$site_url."/email_tracker.php?id=".$last_insert_id."' style='display:none' />",$loggedin_user_name);
				}
			}

	 echo 1;
}

function update_targetdate(){

	require("include/mysqli_connect.php");
	$final_array = array();

	$id = trim(mysqli_real_escape_string($connect, $_POST['rec_id']) );
	$target_date = date("Y-m-d",strtotime(mysqli_real_escape_string($connect, $_POST['tdate']) ));

	$update_status = mysqli_query($connect,"UPDATE `social_media_calendar` set `target_date` = '$target_date' where `id` = '$id' ");
	 
	 if($update_status){
			$inner_array = array();
			$inner_array['status'] = 'success';
			$inner_array['status_code'] = 200;	
			$final_array[] = $inner_array;
			echo json_encode($final_array);
		}
		else{
			$inner_array = array();
			$inner_array['status'] = 'failed';
			$inner_array['status_code'] = 400;
			$final_array[] = $inner_array;
			echo json_encode($final_array);	
		} 
	
}


?>