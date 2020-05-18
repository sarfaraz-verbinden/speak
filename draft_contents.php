   <?php  
              include('include/common_functions.php');
              $common = new commonFunctions();
              $connect = $common->connect(); 

               $campaignid = $_POST['campaignid'];
               $event_id = $_POST['event_id'];     

               $all_posts_array = $common->get_draft_posts_from_campaign_id($campaignid,$event_id);
               $campaign_array = $common->get_campaign_name($campaignid);
               foreach($campaign_array as $carray){
                  $campaign_name=$carray['campaign_name'];
                }

                if(!isset($_SESSION)){ session_start(); }
                $site_url =   $_SESSION['site_url'];

                $cpy_url_public =  '<iframe src="'. $site_url.'/public-sharing-social-media-public.php?cid='.base64_encode($campaignid).'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'" height="100%" width="100%" style="height: 100vh;" frameborder="0" > <p>Embed Code</p></iframe>';
                 // $cpy_url_public = $site_url.'/public-sharing-social-media-public.php?cid='.base64_encode($campaignid).'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999));
                  if(count($all_posts_array)){
                        echo '<div class="row">
                                            <div class="col-sm-12 col-md-12 pt-3">
                                              <a class="btn btn-success pull-right export" href="sp-draft-post-export.php?event_id='.$event_id.'&campid='.$campaignid.'">Export</a>
                                               <button type="button" class="btn btn-success pull-right get-code" onclick="copyTxtApproved2()" id="copy_url_master2"><span class="bg">Get Embeded Code</span><span class="cpTextApprovedTxt" style="display: none;">Link Copied!</span></button>
                                                  <div class="col-lg-12 form-group" style="position: absolute;opacity: 0;z-index: -1;">
                                                   <div style="float: left; width: 100%;">
                                                    <input  type="hidden" class="form-control required"  id="approved_spk_url2" />
                                                      <input style="width: 86%;float: left;" type="text" class="form-control required" id="approved_spk_url_show2" readonly="true" value="'.htmlspecialchars($cpy_url_public).'"  />
                                                   </div>
                                                </div>
                                             <a class="btn pull-right public-sharing" href="public-sharing-social-media.php?cid='.base64_encode($campaignid).'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'" target="_blank">Public Sharing</a>
                                            </div>
                                           
                                          </div>';

                                        }
              
                foreach($all_posts_array as $all_posts){
                  $status_name = $all_posts['status_id'];
                 //prepare status dropdown
                 $all_status_array = $common->fetch_all_social_media_status($event_id); 

                  $status_dropdown = "<select  name='status_update' id='status_update' class='form-control status_update'><option value=''>Select a status </option>"; 
                  foreach($all_status_array as $all_status){

                    $sel = "";
                   if ($all_status['id'] == $status_name) $sel = " selected ";
                   $status_dropdown = $status_dropdown .
                                        "<option data-id=".$all_posts['id']."  value=".$all_status['id']." ".$sel ."> ".$all_status['status_name']." </option> ";
                  } // end of foreach
                  $status_dropdown = $status_dropdown. "</select>";
                                echo '
                                            <div class="col-sm-12 col-md-4">
                                              <div class="content-tab-box">
                                                <div class="box-head">
                                                '.date("d-M-Y",strtotime($all_posts['target_date'])).'
                                                  <div class="actions-bt">
                                                    <a href="clone-social-media.php?pid='.base64_encode($all_posts['id']).'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'"><img src="images/campaign-mangment/duplicate.svg"></a>
                                                    <a href="edit-social-media.php?pid='.base64_encode($all_posts['id']).'&eid='.base64_encode($event_id).':'.base64_encode(rand(100,999)).'"><img src="images/campaign-mangment/edit.svg"></a>
                                                  </div>
                                                  
                                                </div>
                                                  <div class="small-boxes-container">';
                                                  if(!empty($all_posts['image_name']))
                                                  {
                                                    echo '<img src="images/social_media_planner_uploads/'.$all_posts['image_name'].'" class="w-100">';
                                                  }else 
                                                  if(!empty($all_posts['video_name']))
                                                  {
                                                    echo'<video width="230" controls="controls" preload="metadata">
                                                        <source src="images/social_media_planner_uploads/'.$all_posts['video_name'].'#t=0.1" type="video/mp4">
                                                      </video>';
                                                  } else
                                                  {
                                                    echo '<img src="images/social-media-planner/noimage.png" class="w-100">';
                                                  }
                                                    
                                                  echo '</div>
                                                  
                                                  <div class="details">
                                                    <p class="pt-3">
                                                      <label style="top: 16px;">Post Title</label>
                                                      <textarea class="form-control post_name" name="postname" id='.$all_posts['id'].'>'.$all_posts['post_name'].'</textarea>
                                                      <div style="color:green;display:none;text-align:center;margin:10px" id="pname_succcess_'.$all_posts['id'].'" class="pname_success success_msg1"><font >Updated Successfully!</font></div>
                                                    </p>
                                                    <p>
                                                      <label>Target url</label>
                                                      <input type="text" class="form-control targeturl" placeholder="target Url" name="target_url" id='.$all_posts['id'].' value='.$all_posts['target_url'].'>
                                                       <div style="color:green;display:none;text-align:center;margin:10px" id="targeturl_succcess_'.$all_posts['id'].'" class="targeturl_success success_msg1"><font >Updated Successfully!</font></div>
                                                    </p>';
                                                     if($all_posts['target_date'] == '0000-00-00' || $all_posts['target_date'] == ''){ $target_date = '';}else{ $target_date = date("d-M-Y",strtotime($all_posts['target_date']));}

                                                     echo '<p>
                                                      <label>Target Date</label>
                                                      <input type="text" class="form-control event_date date-input" placeholder="target Date" name="target_date" id='.$all_posts['id'].' value='.$target_date.'>
                                                       <div style="color:green;display:none;text-align:center;margin:10px" id="targetd_succcess_'.$all_posts['id'].'" class="targetd_success success_msg1"><font >Updated Successfully!</font></div>
                                                    </p>
                                                    <p>
                                                      <label>status</label>
                                                      '.$status_dropdown.'
                                                      <div style="color:green;display:none;text-align:center;margin:10px"  id="c_status_succcess_'.$all_posts['id'].'" class="cstatus_success success_msg1"><font >Updated Successfully!</font></div>
                                                    </p>
                                                    <p>
                                                      <label>Hashtags</label>
                                                       <input type="text" class="form-control hashtag" placeholder="Hashtags" name="hashtags" id='.$all_posts['id'].' value='.$all_posts['hashtags'].'>
                                                      <div style="color:green;display:none;text-align:center;margin:10px"  id="hashtags_succcess_'.$all_posts['id'].'" class="hashtag_success success_msg1"><font >Updated Successfully!</font></div>
                                                    </p>

                                                </div>
                                                <p class="font-sem-bold text-center text-underline">Platforms</p>
                                                <div class="row">
                                                  <div class="col-md-3">
                                                    <div class="platform-check">';
                                                    if($all_posts['is_fb']=='1')
                                                    {
                                                      echo '<input type="checkbox"  value="1" name="fbcheck" id="check_'.$all_posts['id'].'" checked disabled="disabled">';
                                                    }else
                                                    {
                                                       echo '<input type="checkbox" value="1" name="fbcheck" id="check_'.$all_posts['id'].'" disabled="disabled">';
                                                    }
                                                      
                                                      echo '<label for="check_'.$all_posts['id'].'"><img src="images/social-media-planner/facebook.svg"></label>
                                                       <div style="color:green;display:none;text-align:center;margin:10px"  id="fb_succcess_'.$all_posts['id'].'" class="fb_success success_msg1"><font >Updated Successfully!</font></div>
                                                    </div>
                                                    
                                                  </div>

                                                  <div class="col-md-3">
                                                    <div class="platform-check">';
                                                    if($all_posts['is_insta']=='1')
                                                    {
                                                      echo '<input type="checkbox"  value="1" name="instacheck" id="check1_'.$all_posts['id'].'" checked disabled="disabled">';
                                                    }else
                                                    {
                                                       echo '<input type="checkbox" value="1" name="instacheck" id="check1_'.$all_posts['id'].'" disabled="disabled">';
                                                    }
                                                      
                                                     echo '<label for="check1_'.$all_posts['id'].'"><img src="images/social-media-planner/instagram.svg"></label>
                                                     <div style="color:green;display:none;text-align:center;margin:10px"  id="insta_succcess_'.$all_posts['id'].'" class="insta_success success_msg1"><font >Updated Successfully!</font></div>
                                                    </div>
                                                    
                                                  </div>

                                                  <div class="col-md-3">
                                                    <div class="platform-check">';
                                                      if($all_posts['is_linkedin']=='1')
                                                      {
                                                        echo '<input type="checkbox"  value="1" name="lincheck" id="check2_'.$all_posts['id'].'" checked disabled="disabled">';
                                                      }else
                                                      {
                                                         echo '<input type="checkbox" value="1" name="lincheck" id="check2_'.$all_posts['id'].'" disabled="disabled">';
                                                      }
                                                      
                                                      echo '<label for="check2_'.$all_posts['id'].'"><img src="images/social-media-planner/linkedin.svg"></label>
                                                       <div style="color:green;display:none;text-align:center;margin:10px"  id="lin_succcess_'.$all_posts['id'].'" class="lin_success success_msg1"><font >Updated Successfully!</font></div>
                                                    </div>
                                                    
                                                  </div>

                                                  <div class="col-md-3">
                                                    <div class="platform-check">';
                                                    if($all_posts['is_twitter']=='1')
                                                      {
                                                        echo '<input type="checkbox"  value="1" name="twicheck" id="check3_'.$all_posts['id'].'" checked disabled="disabled">';
                                                      }else
                                                      {
                                                          echo '<input type="checkbox" value="1" name="twicheck" id="check3_'.$all_posts['id'].'" disabled="disabled">';
                                                      }
                                                      
                                                      echo '<label for="check3_'.$all_posts['id'].'"><img src="images/social-media-planner/twitter.svg"></label>
                                                      <div style="color:green;display:none;text-align:center;margin:10px"  id="twi_succcess_'.$all_posts['id'].'" class="twi_success success_msg1"><font >Updated Successfully!</font></div>
                                                    </div>
                                                    
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        ';
                           }

                            if(!count($all_posts_array)){
                              echo '<div class="no_data"><center>No Data Found</center></div>';
                           }

                           
                           ?>