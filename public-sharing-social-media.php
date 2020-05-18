<?php
  include("./include/html_codes.php");
  require("include/mysqli_connect.php");
  include('include/social_planner_pagination.php');
  $event_id_res=$common->get_eventid(trim($_GET['eid']));
  $event_id = $common->check_event_id($event_id_res);
  //admin_way_top();
 
  $campaign_id = base64_decode($_GET['cid']);
  $c_sql = mysqli_query($connect,"SELECT * FROM all_social_planner WHERE id=".$campaign_id);
  $c_row = mysqli_fetch_array($c_sql);
  $campaign_name = $c_row['campaign_name'];

  $fetch_url_query = mysqli_query($connect,"SELECT site_url FROM site_details where id=2");
    if(mysqli_num_rows($fetch_url_query) > 0)
        {            
            while($row1 = mysqli_fetch_array($fetch_url_query))
            {
                $site_url = $row1['site_url'];
            }
         }

       $event_sql = mysqli_query($connect,"SELECT * FROM all_events WHERE id=".$event_id);
       $event_row = mysqli_fetch_array($event_sql);
       $event_url_structure = $event_row['event_name'];
        if( strlen($event_url_structure ) > 40 ) 
        {
          $event_url_structure_short = substr($event_row['event_name'], 0, 40 ) . '...';
        }else{
          $event_url_structure_short = $event_row['event_name'];
        }  
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Speaker Engage</title>
<link href="css/event/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="css/event/css/custom.css">
  <link href="css/custom_aby.css" rel="stylesheet" type="text/css">

<div class="publi-sharing-banner">
  <h2 class="font-sem-bold"><?php echo $campaign_name; ?></h2>
</div>
<div class="container" style="margin: 60px auto; min-height: 450px;">
  <div class="row card-view">
    <?php
               $adjacents = "3";
                $limit = "20";
                $page = isset($_GET['page'])?$_GET['page']:0;
                $targetpage = "public-sharing-social-media.php?cid=".base64_encode($campaignid)."&eid=".base64_encode($event_id).':'.base64_encode(rand(100,999));
                 //***func to fetch pagination***
                $pagination = pagination_2($adjacents,$limit, $page, $targetpage,$campaign_id);       
                $pagination_array = explode("~",$pagination);
                $sql = $pagination_array[0];
              $all_posts_array = $common->fetch_posts_for_public_sharing($pagination_array[2],$limit,$campaign_id); 
              
              // var_dump($all_posts_array);

              foreach($all_posts_array as $all_posts){
                $post_id = $all_posts['id'];
                $post_name = $all_posts['post_name'];
                $post_copy = $all_posts['post_copy'];
                $fb_platform = $all_posts['fb_platform'];
                $insta_platform = $all_posts['insta_platform'];
                $lin_platform = $all_posts['lin_platform'];
                $twi_platform = $all_posts['twi_platform'];
                $image_name = $all_posts['image_name'];
                $video_name = $all_posts['video_name'];
                $share_count = $all_posts['share_ct'];
                $e_id = base64_encode($post_id);


                 if(strlen($post_copy) > 78){
                  $text_desc = substr($post_copy,0,75);
                  $text_desc = $text_desc.'...';
                }else{
                    $text_desc = $post_copy;
                }

                if(($share_count == Null) || ($share_count == '')){

                  $share_count = 0;
        }

                    echo '<div class="col-sm-6 col-md-3">
                    <div class="gray-box">
                    <div class="brdr-box">';
                    if(!empty($image_name))
                    {
                      echo '<img src="images/social_media_planner_uploads/'.$image_name.'" style="height:120px;display:table;margin:auto;">';
                    }else 
                    if(!empty($video_name))
                    {
                      echo'<video style="height:120px;display:table;margin:auto;" controls="controls" preload="metadata">
                          <source src="images/social_media_planner_uploads/'.$video_name.'#t=0.1" type="video/mp4">
                        </video>';
                    } else
                    {
                      echo '<img src="images/social-media-planner/noimage.png" style="height:120px;display:table;margin:auto;">';
                    }
                    
                    echo '
                    <div class="description">
                      <p>'.$post_name.'</p>
                    </div>
                    <div class="description">
                      <p>'.$text_desc.'</p>
                    </div>
                    <div class="icons">';
                    if($all_posts['is_fb']=='1' && (!empty($all_posts['fb_image_name']) || !empty($all_posts['fb_video_name'])))
                    {
                      echo '<a target="_blank" onclick="view_modal('.$post_id.','."'facebook'".',\''.$post_name.'\')" ><img src="images/social-media-planner/facebook.svg"></a>';
                    }
                    if($all_posts['is_linkedin']=='1' && (!empty($all_posts['lin_image_name']) || !empty($all_posts['lin_video_name'])))
                    {
                        echo '<a target="_blank" onclick="view_modal('.$post_id.','."'linkedin'".',\''.$post_name.'\')" ><img src="images/social-media-planner/linkedin.svg"></a>';                 

                    }
                    if($all_posts['is_twitter']=='1' && (!empty($all_posts['twi_image_name']) || !empty($all_posts['twi_video_name'])))
                    {
                   
                      echo '<a target="_blank" onclick="view_modal('.$post_id.','."'twitter'".',\''.$post_name.'\')" ><img src="images/social-media-planner/twitter.svg"></a>';
                    }

                    echo '</div>
                    <p class="text-right" id="share_'.$e_id.'">Total share: '.$share_count.'</p> </div></div>
                  </div>';
                   
                  
              } 
          ?>


  </div>
      <div class="pagination" style="float:right" id="pagination_div">
    <?php echo $pagination_array[1]; ?> 
  </div>
</div>

<div name="view_prod_details" id="myModal" class="view_post modal " style="display: none;">
   
  </div>
 

<style type="text/css">

  .publi-sharing-banner {
    /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#db0566+0,6d4485+50,0283a3+100 */
    background: #db0566; /* Old browsers */
    background: -moz-linear-gradient(left,  #db0566 0%, #6d4485 50%, #0283a3 100%); /* FF3.6-15 */
    background: -webkit-linear-gradient(left,  #db0566 0%,#6d4485 50%,#0283a3 100%); /* Chrome10-25,Safari5.1-6 */
    background: linear-gradient(to right,  #db0566 0%,#6d4485 50%,#0283a3 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#db0566', endColorstr='#0283a3',GradientType=1 ); /* IE6-9 */
    padding: 80px 15px;
    text-align: center;
  }
  .publi-sharing-banner h2 {
    color: #fff;
    margin: 0px;
  }
  .gray-box {
    padding: 10px;
    background-color: #F1F1F1;
    float: left;
    width: 100%;
    margin: 20px auto;
  }
  .w-100 {
    width: 100%
  }
  .brdr-box {
    border:1px solid #333;
    background-color: #fff;
    padding: 5px;
    float: left;
    width: 100%;
  }
  .brdr-box p {
    font-size: 18px;
    margin-top: 15px;
    color: #006469;
    margin-bottom: 10px;
    padding: 0px 5px;
    float: left;
    width: 100%;
  }
  .icons {
    float: right;
    text-align: right;
    padding: 20px 10px 5px;
  }
  .icons img {
    margin-left: 20px;
    float: right;
  }
  .view_post .modal-dialog, .view_post .modal-content{
    width: 100% !important; border-radius: 0;
  }
  .view_post  .modal-header {
    border-bottom: 0px !important;
    padding-bottom: 0px;
     padding: 10px 15px;
    border-bottom: 0px;
    background: rgba(0, 0, 0, 1);
    color: #fff;
  }

  .view_post  textarea, .view_post  input {
    width: 100%;
    border-radius: 3px;
    border:1px solid #ddd;
    padding: 5px 10px;
  }
  .view_post .img.img-thumbnail {
    max-height: 283px;
  }
  .pop_fb {
    background: #f2f1f1;
    margin-top: -8px;
  }
  .view_post label {
    font-family: 'segoeuisemb';
    color: #000;
  }
  .orange_bg {
    font-family: 'segoeuisemb';
    color: #fff;
    background-color: #ff8a00;
  }
  .col-xs-12.pad_0_mb {
    padding-right: 0px;
    padding-left: 0px;
  }
  @media only screen and (min-width : 768px) {
     
      .card-view {
          display: flex;
          flex-wrap: wrap;
      }
      .card-view > [class*='col-'] {
          display: flex;
          flex-direction: column;
      }

      
      .card-view {
          display: -webkit-box;
          display: -webkit-flex;
          display: -ms-flexbox;
          display: flex;
          -webkit-flex-wrap: wrap;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
      }

      .card-view > [class*='col-'] {
          display: -webkit-box;
          display: -webkit-flex;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-orient: vertical;
          -webkit-box-direction: normal;
          -webkit-flex-direction: column;
          -ms-flex-direction: column;
          flex-direction: column;
      }

  }
  button.close{background: #fff;
    border-radius: 17px;
    font-size: 16px !important;
    padding: 5px 5px;    margin-top: 8px !important;}

.pagination {
  margin: 0px;
}
.mstTable th form {
  float: right;
}
.paginate_button, .pagination a {
  padding: 0px 10px;
  color: #222 !important;
}
.paginate_button.current {
  font-weight: 600;
  color: #0283A3 !important;
}
</style>
 


<script src="js/jquery.js"></script> 
<script src="js/bootstrap.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/bootstrap-editable.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
 
<script type="text/javascript">
  
  function view_modal(ele_id,post_tag,pst_title){

  var i = ele_id;
  var p_tag = post_tag;
  
    $.ajax({
      url: 'ajax_v_req.php',
      type: 'POST',
      data: {"action":"fbPopUp","id":i,"p_tag":p_tag,"p_title":pst_title},
      async:true,
      success:function(data){
        $('#myModal').html(data).show() ;
      }
  });


  }


  function share_click(p_title,ele_id,page_name){

    var folder_name = "social-pages";
    var siteurl="<?php echo $site_url;?>";

    $.ajax({
      url: 'ajax_v_req.php',
      type: 'POST',
      data: {"action":"update_ct","id":ele_id},
      async:true,
      success:function(data){
          location.reload();
      }
    });

    if(page_name == 'twitter'){
      window.open("https://twitter.com/intent/tweet?url="+siteurl+"/"+folder_name+"/"+p_title+"-twitter.php");
    }


    if(page_name == 'linkedin'){
      window.open("http://www.linkedin.com/shareArticle?mini=true&url="+siteurl+"/"+folder_name+"/"+p_title+"-linkedin.php");
    }


    if(page_name == 'facebook'){
      window.open("https://www.facebook.com/sharer/sharer.php?u="+siteurl+"/"+folder_name+"/"+p_title+"-facebook.php");
    }

  }

  function closeDialog() { 
     $('#myModal').hide() ;
  } 



</script>
<?php version_footer(); ?>