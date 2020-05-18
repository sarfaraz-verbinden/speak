<?php
  include("./include/html_codes.php");
  require("include/mysqli_connect.php");
  $event_id_res=$common->get_eventid(trim($_GET['eid']));
  $event_id = $common->check_event_id($event_id_res);
  admin_way_top();
  admin_top_bar($event_id);
  admin_left_menu($event_id);

  $current_uid = uniqid();

  $_SESSION['current_uid'] = $current_uid;
  //echo $_SESSION['current_uid']; exit();
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
<link rel="stylesheet" href="css/event/css/croppie.css">
  <link href="css/custom_aby.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css" />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css'>
<style>
   .date-input {
                  background: url(images/campaign-mangment/calendar-with-a-clock-time-tools_blue.png) no-repeat;
                  background-position: 10px;
                  margin: 0;
                  padding-left: 38px;
              }
  .boxes.card-view {
    padding-bottom: 50px !important;
    max-height: 680px;
    overflow-y: scroll;
    overflow-x: hidden;
  }
.pt-10{
  padding-top: 10px;
}
.border-pink{
  border: 1px solid #7C5D99 !important;
}
.border-light-green{
  border: 1px solid #5FDBA7 !important;
}
.border-brown{
  border: 1px solid #A32857 !important;
}
.border-light-orange{
  border: 1px solid #FD6F61 !important;
}
.border-light-pink{
  border: 1px solid #EF6C8B !important;
}
.border-light-gray{
  border: 1px solid #8B8B8B !important;
}
.border-light-gray{
  border: 1px solid #8B8B8B !important;
}
ul.filter_by_type li span {
    display: inline-block;
    margin-left: 0px;
    position: relative;
    top: 0px;
    line-height: 8px;
    width: 8px;
    height: 8px;
    border-radius: 8px;
    left: -4px;
}
/*ul.filter_by_type li:nth-child(2)::before{
   color: #5FDBA7;
}
ul.filter_by_type li:nth-child(3)::before{
   color: #A32857;
}
ul.filter_by_type li:nth-child(4)::before{
   color: #FD6F61;
}
ul.filter_by_type li:nth-child(5)::before{
   color: #EF6C8B;
}
ul.filter_by_type li:nth-child(6)::before{
   color: #8B8B8B;
}*/
.search {
    position: absolute;
    right: 0;
}
.search .fa{
  position: absolute;
    left: 10px;
    top: 11px;
  color: rgba(0, 0, 0, 0.57);
}
.search input{
  padding-left: 29px;
  height: 35px;
    width: 200px;
    background: #f5f5f5;
    box-shadow: none;
    border: 1px solid rgba(0, 0, 0, 0.23);
}
.content-right {
    margin-right: 10px;
}
.main-content {
    display: flex;
}
.ul-italic{
  font-style: italic; 
  display: flex;
    justify-content: flex-start;
    padding-left: 0px;
  list-style-type: none;
}
.ul-italic li:before{
  content: "\2022";
    color: #000;
    font-weight: bold;
    display: inline-block;
    width: 14px;
    margin-left: 0px;
    font-size: 18px;
    position: relative;
    top: 2px;
    line-height: 8px;
}
.simple .tcontainer::after{
  top: 50px;  
}
.simple .timeling .content-left{
  top: 50px;  
}
select.btn.btn-success.exportAgenda option {
    background-color: #fff;
    color: gray;
}
.simple .timeling::after{
  margin-left: -4px;
}
.ul-italic li:nth-child(1)::before{
  display:  none;
}
.ul-italic li {
    font-size: 12px;
  padding-left: 10px;
}
.ul-italic li:nth-child(1) {
  padding-left:0px;
}
.simple .content-right {
    padding: 3px 15px;
}
.days-filterby{
  display: flex;
  justify-content: space-between;
}
.days-filterby .custom_ul li {
    background: url(images/filter-icons.png) no-repeat left top;
    padding-left: 17px;
    padding-top: 0px;
    background-size: 10px;
  list-style-type: none;
  background-position: left;
  font-size: 12px;
  margin-bottom: 5px;
}

ul.custom_ul, .filter_by_type {
    padding-left: 5px;
}

.filter_by_type li{
  font-size: 12px;
  list-style-type: none;
    padding-bottom: 4px;
}
.eventdate_save_btn {
   /** float: left; **/
    color: #0283a3;
    background-color: transparent;
    border: none;
    margin: 0px;
    padding: 0;
    line-height: 33px;
    margin-left: 5px;
}
 .speakerDashboard{
  background: #f5f5f5;
  box-shadow: none;
 }
 .actions{
   display: none;
 }
 .actions-btn{
   display: flex;
    justify-content: center;
      align-items: center;
  background: #f5f5f5;
  height: 60px;
  border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
 }
 .actions .actionBtn{
   width: 70px;
   border-right: none;
 }
 .actions .actionBtn:before{
  bottom: -7px; 
  width: 70px;
 }
 .viewing .nav-tabs>li>a{
  text-transform: uppercase;
  color: #000;
  font-family: 'segoeuisemb';
  min-width: 200px;
  text-align: center;
   border: 1px solid #007DB7;
   border-top-right-radius: 15px;
   border-top-left-radius: 15px;
   background: #f5f5f5;
   line-height: 20px;
 }
 .viewing .nav-tabs>li.active>a, .viewing .nav-tabs>li.active>a:focus, .viewing .nav-tabs>li.active>a:hover{
   background: #007DB7;
   color: #fff;
 }
 
 .viewing .nav-tabs>li>a:hover {
    border-bottom: 1px solid #0283a3;
}
 .viewing .nav-tabs{
  border-bottom: 1px solid rgba(2, 131, 163, 0.7803921568627451); 
 }
 /* The actual timeline (the vertical ruler) */
.timeling {
  position: relative;
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeling::after {
  content: '';
  position: absolute;
  width: 1px;
  background-color: #0283a3;
  top: 0;
  bottom: 0;
  left: 8%;
  margin-left: -3px;
}

/* Container around content */
.tcontainer {
  padding: 10px 10px 10px 30px;
  position: relative;
  background-color: inherit;
  width: 93%;
}

/* The circles on the timeline */
.tcontainer::after {
  content: '';
  position: absolute;
  width: 15px;
  height: 15px;
  right: -17px;
  background-color: white;
  border: 4px solid rgba(0, 0, 0, 0.7215686274509804);
  top: 77px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the left */
.left {
  left: 0;
}

/* Place the container to the right */
.right {
  left: 8%;
}

/* Add arrows to the left container (pointing right) */
.left::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  border-color: transparent transparent transparent white;
}

/* Add arrows to the right container (pointing left) */
.right::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: -80px;
  color:#000;
}

/* Fix the circle for containers on the right side */
.right::after {
  left: -10px;
}

/* The actual content */
.timeling .content-right {
  background-color: white;
  position: relative;
  border-radius: 10px;
  border: 1px solid #0283a3;
}
.timeling .table-responsive{
  padding: 15px 10px 0px;
}
.timeling .content-left {
    height: auto;
    position: absolute;
    top: 75px;
    z-index: 1;
    left: -75px;
  width: auto;
    color: #000;
}
.no_data {
  margin-top: 83px;
    font-size: 14px;
}
.timeling .table th, .timeling .table td{
  text-transform: uppercase;
} 
.timeling .table td{
  font-weight: 800;
} 
.timeling .table td:last-child{
  text-align: center;
  color: #0283a3;
  font-size: 18px;
}
.timeling .table{
  margin-bottom: 0;
}
.tcontainer.right:first-child {
    padding-top: 23px;
}
.timeling .table tr td:nth-child(3) {
    text-align: center;
}

.user-images img {
    height: 27px;
    width: 27px;
    border-radius: 50%;
}
.font-style-italic{
  font-style: italic;
  font-size: 12px;
}
/* Media queries - Responsive timeline on screens less than 600px wide */
@media only screen and (min-width: 1200px){
  .filterby {
    width: 20%;
    padding-left: 20px;
    border-left: 1px solid #ccc;
    margin-top: 50px;
  }
  .simple .timeling{
    padding-right: 15px;
    width: 100%;
  }
  
  .expanded.viewing .nav-tabs{
    width: 100%;
  }
  .simple.viewing .tcontainer{
    width: 97%;
  }
  .simple.viewing .responsive-tabs-container.accordion-xs{
    width: 75%;
  }
  .expanded .timeling .table tr th:nth-child(2) {
    min-width: 100px;
  }
   .expanded .timeling .table tr th:nth-child(3) {
    min-width: 120px;
  width: 120px;
  }

  .expanded .timeling .table tr th:nth-child(5) {
    min-width: 100px;
  }
  .expanded .timeling .table tr th:nth-child(6) {
    min-width: 100px;
  }
  .expanded .timeling .table tr th:nth-child(7) {
    min-width: 100px;
  }
}
@media only screen and (min-width:992px) and (max-width:1199px){
  .simple .timeling .content-left{
    font-size: 12px;
    left: -63px;
    top: 77px;
  }
  .expanded.viewing .nav-tabs{
    padding: 50px 0 0;
  }
  .simple.viewing .nav-tabs{
    padding: 150px 0 0;
  }
  .filterby {
    position: absolute;
    top: 0;
  }
  .filter_by_type li{
    display: inline-block;
  }
  .days-filterby .custom_ul li{
    display: inline-block;
        margin-right: 8px;
  }
  .days-filterby{
    display: block;
  }
}
@media only screen and (min-width:768px) and (max-width:991px){
  .expanded.viewing .nav-tabs{
    padding: 50px 0 0;
  }
  .simple.viewing .nav-tabs{
    padding: 150px 0 0;
  }
  .filterby {
    position: absolute;
    top: 0;
  }
  .filter_by_type li{
    display: inline-block;
  }
  .days-filterby .custom_ul li{
    display: inline-block;
        margin-right: 8px;
  }
  .days-filterby{
    display: block;
  }
  .viewing .nav-tabs>li>a{
    font-size: 12px !important;
    padding: 10px 5px;
  }
  .timeling .content-left{
    position: static;
    padding: 0 0 10px;  
  }
  .tcontainer{
    width: 97%;
  }
}
@media only screen and (max-width:767px){
  .simple.viewing .nav-tabs{
    padding: 150px 0 0;
  }
  .filterby {
    position: absolute;
    top: 5px;
  }
  .filter_by_type li{
    display: inline-block;
  }
  .days-filterby .custom_ul li{
    display: inline-block;
        margin-right: 8px;
  }
  .days-filterby{
    display: block;
  }
  .viewing .nav-tabs{
    padding: 50px 0 0;
  }
  .viewing .nav-tabs>li>a{
    font-size: 12px !important;
    padding: 10px 5px;
  }
  .timeling .content-left{
    position: static;
    padding: 0 0 10px;
    
  }
  .timeling .table-responsive{
    
    border: none !important;
  }
  .timeling::after{
    left: 5%;
  }
  .right {
    left: 5%;
  }
  .tcontainer{
    width: 97%;
  }
  .search {
    position: absolute;
    right: 0;
    left: 0;
    text-align: center;
  }
  .search .fa{
    position: relative;
    left: 25px;
    top: 1px;
  }
  .responsive-tabs-container.accordion-xs {
    padding: 45px 0 0;
  }
  .simple.viewing .responsive-tabs-container.accordion-xs{
    padding: 150px 0 0;
  }
    .actions-btn{
    display: flex;
    height: 120px;
    padding: 15px 0;
    flex-wrap: wrap;
    }
    .actions .actionBtn{
    margin: 0 0 15px;
    }
}

@media screen and (max-width: 575px) {
  /* Place the timelime to the left */
  .timeling::after {
  left: 15px;
  }
  
  /* Full-width containers */
  .tcontainer {
  width: 100%;
  padding-left: 35px;
  padding-right: 0px;
  }

  /* Make sure all circles are at the same spot */
  .left::after, .right::after {
  left: 5px;
  }
  
  /* Make all right containers behave like the left ones */
  .right {
  left: 0%;
  }
  .actions-btn{
  display: flex;
  height: 150px;
  padding: 15px 0;
  flex-wrap: wrap;
  }
  .actions .actionBtn{
  margin: 0 0 15px;
  }
}

.responsive-tabs-container[class*="accordion-"] .tab-pane {
  margin-bottom: 15px;
}
.responsive-tabs-container[class*="accordion-"] .accordion-link {
  display: none;
  margin-bottom: 10px;
  padding: 10px 15px;
  background-color: #f5f5f5;
  border-radius: 3px;
  border: 1px solid #0283a3;
  color: #000;
  font-weight: 800;
}
@media (max-width: 767px) {
  .responsive-tabs-container.accordion-xs .nav-tabs {
    display: none;
  }
  .responsive-tabs-container.accordion-xs .accordion-link {
    display: block;
  }
  .responsive-tabs-container.accordion-xs .accordion-link.active{
     background-color: #0283a3;
  color: #fff;  
  }
}
@media (min-width: 768px) and (max-width: 991px) {
  .responsive-tabs-container.accordion-sm .nav-tabs {
    display: none;
  }
  .responsive-tabs-container.accordion-sm .accordion-link {
    display: block;
  }
}
@media (min-width: 992px) and (max-width: 1199px) {
  .responsive-tabs-container.accordion-md .nav-tabs {
    display: none;
  }
  .responsive-tabs-container.accordion-md .accordion-link {
    display: block;
  }
}
@media (min-width: 1200px) {
  .responsive-tabs-container.accordion-lg .nav-tabs {
    display: none;
  }
  .responsive-tabs-container.accordion-lg .accordion-link {
    display: block;
  }
}

.btn-success{background-color: #0283A3 !important;
    border-color: #0283A3 !important; border-radius:0 !important;}
.btn1 {
  border: none;
  color: black;
  background-color: white;
  
  border-radius:0;
  box-shadow:none;
  font-size: 20px;
  font-weight: bold;
}

.upload-btn-wrapper input[type=file] {
  font-size: 100px;
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}
.date_save_btn{
      float: left;
    color: #0283a3;
    background-color: transparent;
    border: none;
    margin: 0px;
    padding: 0;
    line-height: 33px;
    margin-left: 5px;
}

.endtime_save_btn{
      float: left;
    color: #0283a3;
    background-color: transparent;
    border: none;
    margin: 0px;
    padding: 0;
    line-height: 33px;
    margin-left: 5px;
}
.input-group.timepicker {
    width: 74% !important;
    float: left;
}
.eventdate_save_btn{    float: left;
    color: #0283a3;
    background-color: transparent;
    border: none;
    margin: 0px;
    padding: 0;
    line-height: 33px;
    margin-left: 5px;
}
.actionBtn.download, .actionBtn.download:before {
  width: 51px;
}
.actionBtn.schedule, .actionBtn.schedule:before {
  width: 48px;
}
.customModal .modal-content {
  margin-top: 50px !important;
}
.multiselect-container.dropdown-menu {
  height: auto;
  width: 100%;
}
.multiselect-native-select button.multiselect, .multiselect.dropdown-toggle.btn.btn-default {
  background: #fff;
    font-size: 12px;
    color: #007DB7 !important;
}
.popupradio .radio-inline {
  padding-left: 0px;
}

.timeling .user-images {
    display: inline-block;
    padding: 3px;
}

/** lexington css**/

.lexington .timeling .content-right{
  display: inline-block;
    padding: 6px 21px;
  font-size: 17px;
}
.lexington h2{
    text-transform: capitalize;
}
.lexington h2 span{
  font-weight: bold;
}
.lexington .tcontainer.right:first-child{
  padding-top: 0px;
}
.lexington .tcontainer.right {
    padding-top: 30px !important;
    padding-bottom: 35px !important;
}
.lexington .tcontainer::after{
  top: 42px;
}
.lexington .timeling .content-left{
  top: 40px;
}
.lexington h2:first-child {
    margin-top: 0px;
  margin-bottom: 10px;
}
.lexington .timeling .content-left{
    left: -85px;
}
.lexington .timeling::after{
  left: 8%;
}
.lexington .right{
  left:8%;
}
.day-bottom{
  padding-bottom: 30px;
  width: 77%;
}
.filterby img {
    height: 18px;
    display: inline-block;
    margin-right: 5px;
}
.btn-success {
  background-color: #007DB7 !important;
}
.get-code {
  padding-left: 50px;
 background: url(images/social-media-planner/code.svg) center left no-repeat;
 background-size: 35px;
 background-position-x: 10px; 
 margin-right: 15px;
  
}
.export {
  padding-left: 40px;
    background: url(images/social-media-planner/export-white.svg) center left no-repeat;
    background-size: 16px;
    background-position-x: 10px;
    padding-right: 30px;
}
.public-sharing {
  padding-left: 38px;
    background: #A52858 url(images/social-media-planner/view-white.svg) center left no-repeat;
    background-size: 20px;
    background-position-x: 10px;
    margin-right: 15px;
    color: #fff !important;
    border-radius: 0px;
}
.pt-3 {
  margin-top: 30px;
}
.name-filter .form-control {
  float: left;
  width: auto;
  min-width: 300px;
}
.name-filter label {
  line-height: 35px;
  float: left;
  padding-right: 10px;
}
.speakerDashboard h2 {
  font-size: 28px;
  text-transform: none;
  margin-bottom: 0px;
  float: left;
  width: 100%;
}

.platform-check [type="checkbox"]:checked,
.platform-check [type="checkbox"]:not(:checked) {
    position: absolute;
    left: -9999px;
}
.platform-check [type="checkbox"]:checked + label,
.platform-check [type="checkbox"]:not(:checked) + label
{
    position: relative;
    padding-left: 28px;
    cursor: default !important;
    line-height: 20px;
    display: inline-block;
    color: #666;
}
.platform-check [type="checkbox"]:checked + label:before,
.platform-check [type="checkbox"]:not(:checked) + label:before {
    content: '';
    position: absolute;
    left: 50%;
    margin-left: -8px;
    top: 0;
    width: 15px;
    height: 15px;
    border: 2px solid #393B3C;
}
.platform-check [type="checkbox"]:checked + label:after,
.platform-check [type="checkbox"]:not(:checked) + label:after {
    content: '';
    width: 15px;
    height: 15px;
    background: url(images/social-media-planner/check.svg) center center no-repeat;
    position: absolute;
    top: 0;
    left: 50%;
    margin-left: -8px;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
    background-size: 9px;
}
.platform-check [type="checkbox"]:not(:checked) + label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
}
.platform-check [type="checkbox"]:checked + label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
}

.error {
  color: red;
  margin-left: 5px;
}

label.error {
  display: inline;
}

  .cpText, .cpTextMasterTxt, .cpTextApprovedTxt {
    position: absolute;
    padding: 3px 8px;
    background: #676969;
    color: #fff;
    border-radius: 5px;
    right: 300 !important;
    top: -26px;
    font-size: 10px;
    font-family: 'segoeuib';
}
label.checkbox {
  font-size: 13px;
  padding-left: 30px !important;
}
.cpText:before, .cpTextMasterTxt:before , .cpTextApprovedTxt:before{
    content: "";
    position: absolute;
    width: 0;
    height: 0;
    border: 0 solid transparent;
    border-right-width: 4px;
    border-left-width: 4px;
    border-top: 5px solid #676969;
    bottom: -5px;
    right: 310 !important;

  }
  .center-pagination {
    float: right;
  }
  .center-pagination>li>a, .center-pagination>li>span { margin: 0px;border:0px;background: transparent !important;color: #000;}
  .center-pagination>li.active>a{
    color: #007DB7 !important;
    font-family: 'segoeuib';
  }
  .center-pagination>li>a:hover {
    color: #007DB7 !important;
  }
  @media (min-width: 1254px){
    .name-filter {
      margin-bottom: -54px;
    }
    .export, .get-code, .public-sharing {
      margin-top: -30px;
    }
    .speakerDashboard h2 {
      margin-top: 55px;
    }
    .list-view .name-filter {
      margin-bottom: 0px;
      margin-top: -62px;
    }
    .list-view {
      padding-top: 30px;
    }
  }
  @media (max-width:991px){
    #bind_details .col-sm-12.col-md-12.pt-3 {
      display: table;
      margin: auto;
      text-align: center;
      width: auto;
      float: none;
    }
    #bind_details .content-tab-box .col-md-3 {
      width: 25%;
      float: left;
      text-align: center;
    }
    .card-box.table-responsive {
      padding: 0px !important;
      border:0px !important;
    }
  }
  @media (max-width:768px){
   .viewing .nav-tabs>li>a, .viewing .nav-tabs>li {
    width: 100% !important;
    border-radius: 0;
   }
   .viewing .nav-tabs>li.active>a, .viewing .nav-tabs>li.active>a:focus, .viewing .nav-tabs>li.active>a:hover {
    height: auto !important;
    line-height: 20px !important;
    margin-top: 8px !important;
   }
   .center-pagination {
    margin-bottom: 30px;
   }
   .viewing .nav-tabs {
    padding-top: 0px;
   }
}
 
</style>
   <div class="lds-css ng-scope" style="display: none;" id="loader_div"><div style="width:100%;height:100%" class="lds-double-ring"><div></div><div></div><div><div></div></div><div><div></div></div></div></div>
   <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper innerpageSec formPage" style="margin-top:0 !important;margin-bottom: -50px;">
   <!-- Content Header (Page header) -->
   <section class="content-header pad-5">
      
      <ol class="breadcrumb new-breadcrumb">
        <?php breadcrumb(); ?>
         <li><a><?php echo $event_url_structure; ?></a></li>
         <li class="active">Content Management</li>
         <!-- <li class="active">Untitled Template</li>-->
      </ol>
      <div class="clearfix"></div>
   </section>
   <div class="clearfix"></div>
    <div class="request-success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">Information request has been sent successfully!</div>
      <div class="delete-success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">A Social Media Calendar has been deleted successfully!</div>
      <div class="created-success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">A Social Media Calendar has been created successfully!</div>
      <div class="updated-success" style="text-align: center;color: green;font-size: 18px;padding: 19px;display:none">A Social Media Calendar has been updated successfully!</div>
   <!-- Main content -->
   <section class="content pad-5">
    <div class="speakerDashboard">
      <div class="row">
          <div class="col-xs-12 col-md-6 col-lg-6 text-left">
          <h3 class="font-sem-bold">Content Management</h3> 
       </div>

       <div class="col-xs-12 col-md-6 col-lg-6 text-right"> 
        <a class="btn btn-pink pull-right" href="create-social-media.php?eid=<?php echo base64_encode($event_id);?>:<?php echo base64_encode(rand(100,999));?>" style="margin-top: 10px;
          margin-right: 15px;"><img src="images/campaign-mangment/add-new.svg" style="width: 15px;margin-right: 5px;"> Create New</a>

         
          <select class="pull-right btn btn-success select-view" style="margin-top: 10px;margin-right: 15px;">
            <option value="card-view">Card View</option>
            <option value="list-view">List View</option>
          </select>
       
          
      </div>
         
      </div>

    
      <!-- Small boxes (Stat box) -->
      <div class="">
         <div class="container-fluid brdrHr">
    <hr>
  
  </div>
  
   <div class="clearfix"></div>
      <!-- Small boxes (Stat box) -->
      <div class="borderForm" id="cardv">
      <section>
        <form method="post" action="include/form_submits.php" id="form_create_speaker">
        <div class="card-box" style="padding-top:0;">
            <div class="clearfix"></div>
            <div class="box box-primary sp_opertunity" style="background:none; box-shadow:none; margin-bottom: 20px">
                <div class="card-box table-responsive" style="padding: 17px 0px; padding-top:0; min-height: 700px; ">
                    <div class="card-box table-responsive" style="padding: 17px; padding-top:0; min-height: 700px; ">
                        <div class="expanded viewing">
                            <!--  <div class="search">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <input type="text" name="search" placeholder="Search">
                </div> -->
                           
                              
                                      <ul class="nav nav-tabs">
                                          <li class="active"><a href="#tab1default" data-toggle="tab">Active</a></li>
                                          <li><a href="#tab2default" data-toggle="tab">DRAFT</a></li>
                                          <li><a href="#tab3default" data-toggle="tab">PAST</a></li>
                                          
                                      </ul>
                                  <div class="tab-content">
                                      <div class="tab-pane fade in active" id="tab1default">
                                          <div class="row">
                                             <div class="col-sm-12 col-md-12 pt-3">
                                                
                                              </div>
                                           </div>
                                      
                                        <div class="row boxes card-view">
                                          <div class="name-filter pull-left">
                                                  <div class="form-group">
                                                    <label class="text-uppercase">Campaign Name</label>
                                                    <select class="form-control" name="campaign_id" id="campaign_id">
                                                      <?php   
                                                        $all_campaign_array = $common->fetch_all_live_campaign_name($event_id); 
                                                       foreach($all_campaign_array as $all_campaign){
                                                            echo ' <option value="'.$all_campaign['id'].'">'.$all_campaign['campaign_name'].'</option>';
                                                       } ?>
                                                    </select>
                                                  </div>
                                                </div>
                                          <div id="bind_details">

                                          </div>
                                        <!--   <ul class="pagination center-pagination">
                                                        <li class="disabled"><a href="#">Previous</a></li>
                                                        <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                                                        <li><a href="#">2</a></li>
                                                        <li><a href="#">3</a></li>
                                                        <li><a href="#">Next</a></li>
                                                      </ul> -->
                                        </div>

                                      </div>

                                      <div class="tab-pane fade" id="tab2default">
                                          <div class="row">
                                             <div class="col-sm-12 col-md-12 pt-3">
                                                <div class="name-filter pull-left">
                                                  <div class="form-group">
                                                    <label class="text-uppercase">Campaign Name</label>
                                                    <select class="form-control" name="draft_campaign_id" id="draft_campaign_id">
                                                      <?php   
                                                        $all_campaign_array = $common->fetch_all_draft_campaign_name($event_id); 
                                                       foreach($all_campaign_array as $all_campaign){
                                                            echo ' <option value="'.$all_campaign['id'].'">'.$all_campaign['campaign_name'].'</option>';
                                                       } ?>
                                                    </select>
                                                  </div>
                                                </div>
                                              </div>
                                           </div>
                                      
                                          <div class="row boxes card-view">
                                            <div id="bind_details_draft">

                                            </div>
                                          </div>
                                      </div>



                                      <div class="tab-pane fade" id="tab3default">
                                        <div class="row">
                                             <div class="col-sm-12 col-md-12 pt-3">
                                                <div class="name-filter pull-left">
                                                  <div class="form-group">
                                                    <label class="text-uppercase">Campaign Name</label>
                                                    <select class="form-control" name="past_campaign_id" id="past_campaign_id">
                                                      <?php   
                                                        $all_campaign_array = $common->fetch_all_post_campaign_name($event_id); 
                                                       foreach($all_campaign_array as $all_campaign){
                                                            echo ' <option value="'.$all_campaign['id'].'">'.$all_campaign['campaign_name'].'</option>';
                                                       } ?>
                                                    </select>
                                                  </div>
                                                </div>
                                              </div>
                                           </div>
                                      
                                          <div class="row boxes card-view">
                                            <div id="bind_details_past">

                                            </div>
                                          </div>
                                      </div>
                                  </div>

                                  <style type="text/css">
                                    .platform-check label{
                                      position: static !important;
                                      padding-left: 0px !important;
                                      padding-top: 30px;
                                    }

                                    .platform-check input {
                                      /*visibility: hidden;*/
                                      position: relative;
                                    }
                                    
                                    table .platform-check label {
                                      padding-top: 0px;
                                      padding-right: 20px;

                                    }
                                    table .platform-check [type="checkbox"]:checked + label:before, table .platform-check  [type="checkbox"]:not(:checked) + label:before{
                                          margin-left: 16px;
                                          top: 5px;
                                          width: 12px;
                                          height: 12px;
                                    }
                                    table .platform-check [type="checkbox"]:checked + label:after, table .platform-check  [type="checkbox"]:not(:checked) + label:after {
                                          width: 12px;
                                          height: 12px;
                                          margin-left: 16px;
                                          background-size: 7px;
                                          top: 5px;
                                    }
                                    table .platform-check {
                                      position: relative;
                                      width: 16px;
                                    }
                                    .platform-check img {
                                      width: auto;
                                      float: none;
                                      display: table;
                                      margin: auto;

                                    }
                                    table .platform-check img {
                                      width: 21px;
                                    }
                                    .platform-check input {
                                      margin: auto;
                                      float: none;
                                      display: table;
                                    }
                                    .text-underline {
                                      text-decoration: underline;
                                    }
                                    .select-view {
                                      padding-left: 38px;
                                      background: url(images/campaign-mangment/view.svg) center left no-repeat;
                                      background-position: 13px;
                                      background-size: 20px;

                                    }
                                    .action-btn {
                                      display: table;
                                      margin:auto;
                                      width: 111px !important;
                                    }
                                    .action-btn a {
                                      color: #707070;
                                      font-size: 10px;
                                      text-align: center;
                                      padding: 0px 5px;
                                    }
                                    .action-btn img {
                                      width: auto;
                                      display: table;
                                      margin: auto;
                                      height: 16px;
                                      margin-bottom: 2px !important;
                                    }
                                  .list-view {
                                    margin-left: -30px;
                                    margin-right: -30px;
                                  }
                                  .list-view table tr {
                                    border-bottom: 10px solid #fff;
                                  }
                                  .list-view table th {
                                      background: #007db7;
                                      color: #fff;
                                      text-transform: uppercase;
                                      font-family: 'segoeuisemb';
                                      border-color: #fff;
                                      text-align: center;
                                      border-right: 1px solid #fff !important;
                                      padding-left: 15px !important;
                                      padding-right: 15px !important;
                                      padding-top: 15px !important;
                                      padding-bottom: 15px !important;
                                    }
                                    .list-view table td {
                                      text-align: center;
                                      padding-right: 0px;
                                      background: #E4EEF2;
                                      border-right: 1px solid #fff !important;
                                      font-size: 14px;
                                      padding: 15px !important;
                                    }
                                    .list-view table th:first-child, .list-view table td:first-child {
                                      text-align: left;
                                    }
                                    .content-tab-box {
                                      padding: 10px;
                                      border: 1px solid #007db7;
                                      border-radius: 15px;
                                      box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
                                      float: left;width: 100%;
                                      margin: 40px auto 20px;
                                  
                                    }
                                    .btn.btn-pink {
                                      background: #A52858;
                                      color: #fff;
                                      border-radius: 0px;
                                    }
                                    .content-tab-box .box-head {
                                      background: #007db7;
                                      color: #fff;
                                      font-size: 18px;
                                      text-align: left;
                                      padding:8px 60px;
                                      padding-left: 30px;
                                      width: auto;
                                      margin-right: -10px;
                                      margin-top: -10px;
                                      margin-left: -10px;
                                      border-radius: 15px 15px 0px 0px;
                                      margin-bottom: 15px;
                                      box-shadow: 0px 3px 3px rgba(0, 0, 0, 0.1);
                                      font-family: 'segoeuisemb';
                                      position: relative;
                                    }
                                    .actions-bt {
                                      position: absolute;
                                      right: 10px;
                                      top: 0px;
                                      height: 40px;
                                      line-height: 36px;
                                    }
                                    .actions-bt a {
                                      margin: 0px 5px;
                                    }
                                    .actions-bt a img {
                                      width: 15px;
                                    }
                                    .content-tab-box .discription {
                                      float: left;
                                      width: 100%;
                                      padding: 30px 15px 15px;

                                    }
                                    .tab-pane {
                                      padding: 0px 30px;
                                    }
                                     .content-tab-box .details {
                                      float: left;
                                      width: 100%;
                                      padding: 0px 15px;
                                      color: #000;
                                      
                                     }
                                     .content-tab-box .details p {
                                      position: relative;
                                      padding-left: 80px;
                                     }
                                     .borderForm .content-tab-box  label {
                                        width: 75px;
                                        position: absolute;
                                        left: 0px;
                                        top: 7px;
                                        text-transform: uppercase;
                                        font-size: 12px;
                                        text-align: right;
                                     }
                                     .borderForm .content-tab-box  input {
                                      height: 30px;
                                     }
                                    /* .borderForm .content-tab-box  label:after {
                                      position: absolute;
                                      width: 5px;
                                      top: 0px;
                                      bottom: 0px;
                                      content: ":";
                                      right: 0px;
                                     }*/
                                    .small-boxes {
                                      float: left;
                                      width: 48%;
                                      margin: 1%;
                                      border:2px solid #007DB7;
                                      text-align: center;
                                    }
                                    .innerpageSec.formPage .card-box .small-boxes h3 {
                                        margin-top: 15px;
                                        color: #000;
                                        padding: 0;
                                        font-size: 14px;
                                    }
                                    .innerpageSec.formPage .card-box .small-boxes h4 {
                                      color: #000;
                                      font-family: 'segoeuisemb';
                                      font-size: 12px;
                                    }
                                    .small-boxes-container {
                                      float: left;
                                      width: 100%;
                                    }
                                    .small-boxes-container video {
                                      display: table;
                                      margin: auto;
                                      height: 129px !important;
                                      width: auto !important;
                                    }
                                    .tab-content {
                                      border: solid 1px #007DB7;
                                      padding: 15px;
                                      /*border-radius: 0px 0px 15px 15px;*/
                                      border-top: 0px;
                                      background: #fff;
                                      padding-bottom: 10px;
                                    }
                                    .small-boxes-container img {
                                      margin: auto;
                                      height: 119px;
                                      padding: 5px;
                                      border: 1px solid #222;
                                      max-width: 100%;
                                      display: block;
                                      margin-top: 10px;
                                    }
                                    .viewing .nav-tabs>li>a {
                                          margin-top: 8px;
                                    }
                                    .viewing .nav-tabs>li.active>a, .viewing .nav-tabs>li.active>a:focus, .viewing .nav-tabs>li.active>a:hover {
                                      height: 50px;
                                      line-height: 32px;
                                      margin-top: 0;
                                      font-family: 'segoeuib';
                                    }
                                    .pull-right>.dropdown-menu#menu2 {
                                      width: 100%;
                                      min-width: 100%;
                                      border-radius: 0;
                                    }
                                  </style>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </form>
</section>
</div>

<!-------------------------- list view--------------------------------------- -->
  <div class="borderForm" style="display: none;" id="listv">
      <section>
        <div class="card-box" style="padding-top:0;">
            <div class="clearfix"></div>
            <div class="box box-primary sp_opertunity" style="background:none; box-shadow:none; margin-bottom: 20px">
                <div class="card-box table-responsive" style="padding: 17px 0px; padding-top:0; min-height: 700px; ">
                    <div class="card-box table-responsive" style="padding: 17px; padding-top:0; min-height: 700px; ">
                        <div class="expanded viewing">
                              
                                      <ul class="nav nav-tabs">
                                          <li class="active"><a href="#tab11default" data-toggle="tab">Active</a></li>
                                          <li><a href="#tab22default" data-toggle="tab">DRAFT</a></li>
                                          <li><a href="#tab33default" data-toggle="tab">PAST</a></li>
                                          
                                      </ul>
                                    <div class="tab-content">
                                      <div class="tab-pane fade in active" id="tab11default">
                                        <div class="row boxes list-view">
                                          <div class="row">
                                            <div class="col-sm-12 col-md-12 pt-3" id="lvheader">
                                              
                                            </div>
                                             <div class="col-sm-12 col-md-12 pt-3">
                                                <div class="name-filter pull-left">
                                                  <div class="form-group">
                                                    <label class="text-uppercase">Campaign Name</label>
                                                    <select class="form-control" name="alvcampaign_id" id="alvcampaign_id">
                                                      <?php   
                                                        $all_campaign_array = $common->fetch_all_live_campaign_name($event_id); 
                                                       foreach($all_campaign_array as $all_campaign){
                                                            echo ' <option value="'.$all_campaign['id'].'">'.$all_campaign['campaign_name'].'</option>';
                                                       } ?>
                                                    </select>
                                                  </div>
                                                </div>
                                              </div>
                                           </div>

                                          <div class="table">
                                            <table class="table table-bordered table-responsive dtTable" style="width: 100%;margin-top: 40px;" id="table_id">
                                            <thead>
                                              <tr>
                                                <th>Date</th>
                                                <th style="width: 120px;">Post</th>
                                                <th>Status</th>
                                                <th>Featured</th>
                                                <th>Graphic/Video</th>
                                                <th style="width: 72px;">Url</th>
                                                <th>Social Media</th>
                                                <th><div style="width: 100px;text-align: left;">Manage</div></th>
                                              </tr>
                                            </thead>
                                            <tbody id="active_posts_list_view">
                                              

                                            
                                            </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="tab-pane fade" id="tab22default">
                                       <div class="row boxes list-view">
                                          <div class="row">
                                            <div class="col-sm-12 col-md-12 pt-3" id="lvheader_draft">
                                              
                                            </div>
                                             <div class="col-sm-12 col-md-12 pt-3">
                                                <div class="name-filter pull-left">
                                                  <div class="form-group">
                                                    <label class="text-uppercase">Campaign Name</label>
                                                    <select class="form-control" name="lv_draft_campaign_id" id="lv_draft_campaign_id">
                                                      <?php   
                                                        $all_campaign_array = $common->fetch_all_draft_campaign_name($event_id); 
                                                       foreach($all_campaign_array as $all_campaign){
                                                            echo ' <option value="'.$all_campaign['id'].'">'.$all_campaign['campaign_name'].'</option>';
                                                       } ?>
                                                    </select>
                                                  </div>
                                                </div>
                                              </div>
                                           </div>

                                          <div class="table">
                                            <table class="table table-bordered table-responsive dtTable" style="width: 100%;margin-top: 40px;" id="table_id2">
                                            <thead>
                                              <tr>
                                                <th>Date</th>
                                                <th style="width: 120px;">Post</th>
                                                <th>Status</th>
                                                <th>Featured</th>
                                                <th>Graphic/Video</th>
                                                <th style="width: 72px;">Url</th>
                                                <th>Social Media</th>
                                                <th style="text-align: left;">Manage</th>
                                              </tr>
                                            </thead>
                                            <tbody id="draft_posts_list_view">
                                              

                                            
                                            </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>



                                      <div class="tab-pane fade" id="tab33default">
                                              <div class="row boxes list-view">
                                          <div class="row">
                                            <div class="col-sm-12 col-md-12 pt-3" id="lvheader_past">
                                              
                                            </div>
                                             <div class="col-sm-12 col-md-12 pt-3">
                                                <div class="name-filter pull-left">
                                                  <div class="form-group">
                                                    <label class="text-uppercase">Campaign Name</label>
                                                    <select class="form-control" name="lv_past_campaign_id" id="lv_past_campaign_id">
                                                      <?php   
                                                        $all_campaign_array = $common->fetch_all_post_campaign_name($event_id); 
                                                       foreach($all_campaign_array as $all_campaign){
                                                            echo ' <option value="'.$all_campaign['id'].'">'.$all_campaign['campaign_name'].'</option>';
                                                       } ?>
                                                    </select>
                                                  </div>
                                                </div>
                                              </div>
                                           </div>

                                          <div class="table">
                                            <table class="table table-bordered table-responsive dtTable" style="width: 100%;margin-top: 40px;" id="table_id3">
                                            <thead>
                                              <tr>
                                                <th>Date</th>
                                                <th style="width: 120px;">Post</th>
                                                <th>Status</th>
                                                <th>Featured</th>
                                                <th>Graphic/Video</th>
                                                <th style="width: 72px;">Url</th>
                                                <th>Social Media</th>
                                                <th>Manage</th>
                                              </tr>
                                            </thead>
                                            <tbody id="past_posts_list_view">
                                              

                                            
                                            </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                  </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
</section>
</div>

<!---------------------------------------------------------------- -->
      </div>
      </div>
   </section>
</div>
<?php version_footer(); ?>

<div class="modal fade information_modal darkHeaderModal" id="information_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 100% !important;border-radius: 0px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="images/cancel.png" width="20"></button>
        <h4 class="modal-title" id="myModalLabel">Request to Update Social Media Planner</h4>
      </div>

      <div class="modal-body">
        <h5 class="modalHd"><img src="images/tap.png" width="20"> Trigger: Request to Social Media Planner
    </h5>
        <hr class="shadowHr"> 
        <div class="form-group" id="doc_option_div">
        <div class="formbdy" style="padding-left: 0px;">
          <label >Select</label>
          <select  name="multiselect_all_doc_opt[]" class="form-control multiselect_all_doc_opt"   multiple="multiple" id="multiselect_all_doc_opt"  required>
                  <option value="is_post_info">Post Information</option>
                  <option value="is_fbpost" >Facebook Post</option>
                  <option value="is_instapost" >Instagram Post</option>
                  <option value="is_linpost" >Linkedin Post</option>
                  <option value="is_twitterpost" >Twitter Post</option>
             </select>
        </div>
      </div>
     
      <div class="form-group" id="info_option_div" style="" >
        <div class="formbdy" style="padding-left: 0px;">
          <label class="leftAbso"><img src="images/request.png" width="30">Send Email</label><br/><br/>
          <input type="text" style="width: 100%;" class="form-control required" placeholder="Email Address*" required name="email_addresses" id="email_addresses" />
          <p style="color:red;">Note: Email addresses must be comma separated.(eg:john@domain.com,johndoe@domain.com)</p>
        </div>
      </div>

        <div class="formbdy" style="padding-left: 0px;">
          <div class="form-group">
            <label><img src="images/message.png"> Notes</label>
            <textarea class="form-control" name="info_msg" id="info_msg" value="Please review your presentation details.If you have any changes,feel free to make the necessary changes. Thank you.">Please review your planner details.If you have any changes,feel free to make the necessary changes. Thank you.</textarea>
          </div>
          
        </div>
        <div class="sendBtn text-right"> 
          <input type="hidden" name="info_modal_postid" id="info_modal_postid" value="">
          <button type="button" id="info_submit" class="btn btn-success">Send</button>
        </div>
        </div>
    </div>
  </div>
</div>




<div class="modal fade customModal" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog" role="document" data-keyboard="false" data-backdrop="static">
    <div class="modal-content" style="width: 100% !important;border-radius: 0px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="images/cancel.png" width="20"></button>
        <h4 class="modal-title" id="myModalLabel">Preview</h4>
      </div>

      <input type="hidden" name="preview_ep_id" id="preview_ep_id" value="">

      <div class="modal-body">

    <div class="top-50" style="top:0px;">
    <div class="row">
      
      <div class="container-fluid">
        <h2 style="font-size: 20px;font-weight: 300;color: #000;text-transform: uppercase;margin-bottom: 15px;margin-top:30px;font-family:'segoeuisemb';"><?php echo $event_url_structure; ?> : PLAN YOUR SOCIAL MEDIA</h2>

        <div class="row">
          <div class="col-md-4">
           <h3 class="innerH3" style="margin-top: 20px;">Campaign Name</h3>
          <p class=""><span id="pview_campaign_name" style="width: 100%;display: block;"> </span></p> 
          </div>
          <div class="col-md-4">
            <h3 class="innerH3" style="margin-top: 20px;">Post Name</h3>
            <p class=""><span id="pview_post_name"> </span></p>
          </div>
          <div class="col-md-4">
             <h3 class="innerH3" style="margin-top: 20px;">Status</h3>
          <p class=""><span id="pview_status"> </span></p>
          </div>
        </div>
         <div class="row">
          <div class="col-md-4">
             <h3 class="innerH3" style="margin-top: 20px;">Target Date</h3>
          <p class=""><span id="pview_tdate"> </span></p>
          </div>
          <div class="col-md-4">
             <h3 class="innerH3" style="margin-top: 20px;">Target Url</h3>
          <p class=""><span id="pview_turl"> </span></p>
          </div>
        </div>
      </div>
         
        
        <div class="container-fluid">

        <h3 class="innerH3">Tag Influencers</h3>
        <div class="box box-shadow" style="min-height: 20px;">
          <p class="font-sem-bold"><span id="pview_influencers"> </span></p>
        </div>
        <h3 class="innerH3">Hashtags</h3>
        <div class="box box-shadow" style="min-height: 20px;margin-bottom: 10px;">
          <p class="font-sem-bold"><span id="pview_hashtags"> </span></p>
        </div>
        </div>

        <div class="container-fluid">
        <h6 style="font-size: 20px;font-weight: 300;color: #000;text-transform: uppercase;margin-bottom: 5px;margin-top:30px;font-family:'segoeuisemb';">Facebook Posts</h6>

        <div class="row">
          <div class="col-md-12">
           <h6 class="innerH3" style="margin-top: 20px;">Post Copy:</h6>
          <p class=""><span id="pview_postcopy" style="width: 100%;display: block;"> </span></p> 
          </div>
          <div class="col-md-12">
            <h6 class="innerH3" style="margin-top: 20px;">Target URL:</h6>
            <p class=""><span id="pview_fturl"> </span></p>
          </div>
          <div class="col-md-12">
             <h6 class="innerH3" style="margin-top: 20px;">Documents:</h6>
            <div id="preview_fb_download">
            
            </div>
          </div>
        </div>
      </div>
       <div class="container-fluid">
        <h6 style="font-size: 20px;font-weight: 300;color: #000;text-transform: uppercase;margin-bottom: 5px;margin-top:30px;font-family:'segoeuisemb';">Instagram Posts</h6>

        <div class="row">
          <div class="col-md-12">
           <h6 class="innerH3" style="margin-top: 20px;">Post Copy:</h6>
          <p class=""><span id="pview_ipostcopy" style="width: 100%;display: block;"> </span></p> 
          </div>
          <div class="col-md-12">
            <h6 class="innerH3" style="margin-top: 20px;">Target URL:</h6>
            <p class=""><span id="pview_iturl"> </span></p>
          </div>
          <div class="col-md-12">
             <h6 class="innerH3" style="margin-top: 20px;">Documents:</h6>
          <p class=""><span id="preview_insta_download"> </span></p>
          </div>
        </div>
      </div>
       <div class="container-fluid">
        <h6 style="font-size: 20px;font-weight: 300;color: #000;text-transform: uppercase;margin-bottom: 5px;margin-top:30px;font-family:'segoeuisemb';">Linkedin Posts</h6>

        <div class="row">
          <div class="col-md-12">
           <h6 class="innerH3" style="margin-top: 20px;">Post Copy:</h6>
          <p class=""><span id="pview_lpostcopy" style="width: 100%;display: block;"> </span></p> 
          </div>
          <div class="col-md-12">
            <h6 class="innerH3" style="margin-top: 20px;">Target URL:</h6>
            <p class=""><span id="pview_lturl"> </span></p>
          </div>
          <div class="col-md-12">
             <h6 class="innerH3" style="margin-top: 20px;">Documents:</h6>
          <p class=""><span id="preview_lin_download"> </span></p>
          </div>
        </div>
      </div>
       <div class="container-fluid">
        <h6 style="font-size: 20px;font-weight: 300;color: #000;text-transform: uppercase;margin-bottom: 5px;margin-top:30px;font-family:'segoeuisemb';">Twitter Posts</h6>

        <div class="row">
          <div class="col-md-12">
           <h6 class="innerH3" style="margin-top: 20px;">Post Copy:</h6>
          <p class=""><span id="pview_tpostcopy" style="width: 100%;display: block;"> </span></p> 
          </div>
          <div class="col-md-12">
            <h6 class="innerH3" style="margin-top: 20px;">Target URL:</h6>
            <p class=""><span id="pview_tturl"> </span></p>
          </div>
          <div class="col-md-12">
             <h6 class="innerH3" style="margin-top: 20px;">Documents:</h6>
          <p class=""><span id="preview_twi_download"> </span></p>
          </div>
        </div>
      </div>

      </div>
    </div>


<!-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script> -->
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
 <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js'></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<link rel="stylesheet" href="dist/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="dist/js/bootstrap-multiselect.js"></script>
<!--  -->
<script src="dist/js/adminlte.min.js"></script>
<script src="js/custom.js"></script>
<!--  -->
<script type="text/javascript">
  $(document).on('focus',".event_date", function(){
      $(".event_date").datepicker({ 
          format:'dd-M-yyyy',
          startDate: new Date(),
          autoclose: true
    }).datepicker();
 });
//   $(function () {
  // $(".event_date").datepicker({ 
  //       format:'dd-M-yyyy',
  //       startDate: new Date(),
  //       autoclose: true
  // }).datepicker();
// });

  $(document).ready( function () {
    $('.dtTable').DataTable();
} );

    $(".multiselect_all_doc_opt").multiselect({
      includeSelectAllOption: true,
      maxHeight: 400
      }); 
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $(".select-view").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue=='list-view'){
                $("#cardv").hide();
                $("#listv").show();
            } else{
                $("#listv").hide();
                $("#cardv").show();
            }
            // if(optionValue){
            //     $(".boxes").not("." + optionValue).hide();
            //     $("." + optionValue).show();
            // } else{
            //     $(".boxes").hide();
            // }
        });
    }).change();

//*********************cardview*******************************
    var campid=$('#campaign_id').val(); //get live posts on ready
    fetch_posts_live(campid);

    var draft_campid=$('#draft_campaign_id').val(); //get draft posts on ready
    fetch_posts_draft(draft_campid);

     var post_campid=$('#past_campaign_id').val(); //get draft posts on ready
      fetch_posts_past(post_campid);
      });



    $('#campaign_id').bind('change', function () { //on change of campaign
      var cid=$('#campaign_id').val();
      fetch_posts_live(cid);
    });

    $('#draft_campaign_id').bind('change', function () { //on change of draft campaign
    var dcid=$('#draft_campaign_id').val();
    fetch_posts_draft(dcid);
    });

    $('#past_campaign_id').bind('change', function () { //on change of past campaign
    var pcid=$('#past_campaign_id').val();
    fetch_posts_past(pcid);
    });

  //*********************listview*******************************
    var alvcampaign_id=$('#alvcampaign_id').val(); //get live posts on ready
    fetch_lvposts_live(alvcampaign_id);

    $('#alvcampaign_id').bind('change', function () { //on change of campaign
      var alvcid=$('#alvcampaign_id').val();
      fetch_lvposts_live(alvcid);
    });

    var lv_draft_campaign_id=$('#lv_draft_campaign_id').val(); //get draft posts on ready
    fetch_lvposts_draft(lv_draft_campaign_id);

    $('#lv_draft_campaign_id').bind('change', function () { //on change of campaign
      var draftlvcid=$('#lv_draft_campaign_id').val();
      fetch_lvposts_draft(draftlvcid);
    });

    var lv_past_campaign_id=$('#lv_past_campaign_id').val(); //get past posts on ready
    fetch_lvposts_past(lv_past_campaign_id);

    $('#lv_past_campaign_id').bind('change', function () { //on change of campaign
      var lv_past_cid=$('#lv_past_campaign_id').val();
      fetch_lvposts_past(lv_past_cid);
    });



  //****************************************************

  function fetch_posts_live(cid) //fetch live posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(cid!= null)
    {
      $.ajax({

               type: "POST",

               url: "active_contents.php",

               data: {
                   campaignid: cid,
                   event_id: event_id

               },

               success: function(html) {
                   $("#bind_details").html(html).show();
               }

           });
    }
    
  }

  function fetch_lvposts_live(lvcid) //fetch live posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(lvcid!= null)
    {
      $.ajax({

               type: "POST",

               url: "active_contents_listview.php",

               data: {
                   campaignid: lvcid,
                   event_id: event_id

               },

               success: function(html) {
                   fetch_lvposts_header(lvcid);
                   $('.dtTable').DataTable().destroy();
                   $("#active_posts_list_view").html(html).show();
                   $('.dtTable').DataTable();
               }

           });
    }
    
  }

  function fetch_lvposts_header(lvcid) //fetch live posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(lvcid!= null)
    {
      $.ajax({

               type: "POST",

               url: "listview_content_header.php",

               data: {
                   campaignid: lvcid,
                   event_id: event_id

               },

               success: function(html) {
                   $("#lvheader").html(html).show();
               }

           });
    }
    
  }


  function fetch_lv_draftposts_header(dlvcid) //fetch live posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(dlvcid!= null)
    {
      $.ajax({

               type: "POST",

               url: "listview_draft_content_header.php",

               data: {
                   campaignid: dlvcid,
                   event_id: event_id

               },

               success: function(html) {
                   $("#lvheader_draft").html(html).show();
               }

           });
    }
    
  }

  function fetch_lvpastposts_header(plvcid) //fetch live posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(plvcid!= null)
    {
      $.ajax({

               type: "POST",

               url: "listview_past_content_header.php",

               data: {
                   campaignid: plvcid,
                   event_id: event_id

               },

               success: function(html) {
                   $("#lvheader_past").html(html).show();
               }

           });
    }
    
  }


  function fetch_posts_draft(dcid) //fetch draft posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(dcid!= null)
    {
    $.ajax({

               type: "POST",

               url: "draft_contents.php",

               data: {
                   campaignid: dcid,
                   event_id: event_id

               },

               success: function(html) {
                   $("#bind_details_draft").html(html).show();
               }

           });
   }
  }

  function fetch_lvposts_draft(lvcid) //fetch live posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(lvcid!= null)
    {
      $.ajax({

               type: "POST",

               url: "draft_contents_listview.php",

               data: {
                   campaignid: lvcid,
                   event_id: event_id

               },

               success: function(html) {
                   fetch_lv_draftposts_header(lvcid);
                   $('.dtTable').DataTable().destroy();
                   $("#draft_posts_list_view").html(html).show();
                   $('.dtTable').DataTable();
               }

           });
    }
    
  }

  function fetch_lv_draft_posts_header(lvcid) //fetch live posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(lvcid!= null)
    {
      $.ajax({

               type: "POST",

               url: "listview_content_header.php",

               data: {
                   campaignid: lvcid,
                   event_id: event_id

               },

               success: function(html) {
                   $("#lvheader").html(html).show();
               }

           });
    }
    
  }

  function fetch_posts_past(pcid) //fetch past posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(pcid!= null)
    {
    $.ajax({

               type: "POST",

               url: "past_contents.php",

               data: {
                   campaignid: pcid,
                   event_id: event_id

               },

               success: function(html) {
                   $("#bind_details_past").html(html).show();
               }

           });
    }
  }

  function fetch_lvposts_past(lvcid) //fetch live posts
  {
    var event_id = "<?php echo $event_id; ?>";
    if(lvcid!= null)
    {
      $.ajax({

               type: "POST",

               url: "past_contents_listview.php",

               data: {
                   campaignid: lvcid,
                   event_id: event_id

               },

               success: function(html) {
                   fetch_lvpastposts_header(lvcid);
                   $('.dtTable').DataTable().destroy();
                   $("#past_posts_list_view").html(html).show();
                   $('.dtTable').DataTable();
               }

           });
    }
    
  }

  //*****Ajax calls for auto update******

    //post name change update call
  $(document).on('input','.post_name',function () {
  var id = $(this).attr('id');
          $.ajax({
                      type: "POST",
                      url: "api.php",
                      dataType: "json",
                      data: {"action": "update_postname", "rec_id":$(this).attr('id'),"postname":$(this).val() },
                      success: function(data){
                              $('.pname_success, .success_msg1').hide();
                              $('#pname_succcess_'+id).show();
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax   
  });

  $(document).on('input','.targeturl',function () { //target url auto save
  var id = $(this).attr('id');
          $.ajax({
                      type: "POST",
                      url: "api.php",
                      dataType: "json",
                      data: {"action": "update_target_url", "rec_id":$(this).attr('id'),"target_url":$(this).val() },
                      success: function(data){
                              $('.targeturl_success, .success_msg1').hide();
                              $('#targeturl_succcess_'+id).show();
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax   
  });

    $(document).on('input','.hashtag',function () { //hashtags auto save
    var id = $(this).attr('id');
            $.ajax({
                        type: "POST",
                        url: "api.php",
                        dataType: "json",
                        data: {"action": "update_hashtags", "rec_id":$(this).attr('id'),"hashtag":$(this).val() },
                        success: function(data){
                                $('.hashtag_success, .success_msg1').hide();
                                $('#hashtags_succcess_'+id).show();
                        },
                          error: function() {
                              swal({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: "Something went wrong! Please try again"
                                  });
                             }
                      }); // end of ajax   
    });

    $(document).on('change','.status_update',function () { //status update call
     var status_id = $(this).val();
     var rec_id = $(this).find('option[data-id]').data('id');

          $.ajax({
                      type: "POST",
                      url: "api.php",
                       dataType: "json",
                       data: {"action": "update_post_status", "rec_id":rec_id,"status_id":status_id},
                      success: function(data){
                              $('.cstatus_success, .success_msg1').hide();
                              $('#c_status_succcess_'+rec_id).show();
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax
    
  });

    $(document).on('change','input[name="fbcheck"]',function () {
       var rec_id = $(this).attr('id');
       var pid=rec_id.replace('check_','');
       var is_check=0;
       if($(this). is(":checked")){
          is_check=1;
        }else
        {
          is_check=0;
        }
          $.ajax({
                      type: "POST",
                      url: "api.php",
                       dataType: "json",
                       data: {"action": "update_fb_check", "rec_id":pid,"is_check":is_check},
                      success: function(data){
                              $('.fb_success, .success_msg1').hide();
                              $('#fb_succcess_'+pid).show();
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax 
   });

     $(document).on('change','input[name="instacheck"]',function () {
       var rec_id = $(this).attr('id');
       var pid=rec_id.replace('check1_','');
       var is_check=0;
       if($(this). is(":checked")){
          is_check=1;
        }else
        {
          is_check=0;
        }
          $.ajax({
                      type: "POST",
                      url: "api.php",
                       dataType: "json",
                       data: {"action": "update_insta_check", "rec_id":pid,"is_check":is_check},
                      success: function(data){
                              $('.insta_success, .success_msg1').hide();
                              $('#insta_succcess_'+pid).show();
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax 
   });

   $(document).on('change','input[name="lincheck"]',function () {
       var rec_id = $(this).attr('id');
       var pid=rec_id.replace('check2_','');
       var is_check=0;
       if($(this). is(":checked")){
          is_check=1;
        }else
        {
          is_check=0;
        }
          $.ajax({
                      type: "POST",
                      url: "api.php",
                       dataType: "json",
                       data: {"action": "update_lin_check", "rec_id":pid,"is_check":is_check},
                      success: function(data){
                              $('.lin_success, .success_msg1').hide();
                              $('#lin_succcess_'+pid).show();
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax 
   });

    $(document).on('change','input[name="twicheck"]',function () {
       var rec_id = $(this).attr('id');
       var pid=rec_id.replace('check3_','');
       var is_check=0;
       if($(this). is(":checked")){
          is_check=1;
        }else
        {
          is_check=0;
        }
          $.ajax({
                      type: "POST",
                      url: "api.php",
                       dataType: "json",
                       data: {"action": "update_twi_check", "rec_id":pid,"is_check":is_check},
                      success: function(data){
                              $('.twi_success, .success_msg1').hide();
                              $('#twi_succcess_'+pid).show();
                      },
                        error: function() {
                            swal({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: "Something went wrong! Please try again"
                                });
                           }
                    }); // end of ajax 
   });

   function Delete(pid)
    {
      var campid=$('#alvcampaign_id').val();
      var result = confirm("Are you sure you want to delete.");
            if (result) {  
                $.ajax({
                    type: "POST",
                    url: "api.php", //calling page from same directory 
                    data: {'action': 'delete_list_view', 'postid': pid},
                    success: function (response) {
                        if (response.trim() == 1 || response.trim() == '1') { // compare Response from server .
                           Swal.fire({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Deleted Successfully.',
                                    allowOutsideClick: false
                                  }).then(okay => {
                                       if (okay) {
                                           $(".dtTable tbody").empty();
                                             fetch_lvposts_live(campid);
                                      }
                                    });
                         
                        } else
                        {
                            alert("Something went wrong ,Please try again.");
                        }

                    }//Success function end here 

                });
              }
   
    }


    function Delete_draft(pid)
    {
      var campid=$('#lv_draft_campaign_id').val(); 
      var result = confirm("Are you sure you want to delete.");
            if (result) {  
                $.ajax({
                    type: "POST",
                    url: "api.php", //calling page from same directory 
                    data: {'action': 'delete_list_view', 'postid': pid},
                    success: function (response) {
                        if (response.trim() == 1 || response.trim() == '1') { // compare Response from server .
                           Swal.fire({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Deleted Successfully.',
                                    allowOutsideClick: false
                                  }).then(okay => {
                                       if (okay) {
                                           $(".dtTable tbody").empty();
                                             fetch_lvposts_draft(campid);
                                      }
                                    });
                         
                        } else
                        {
                            alert("Something went wrong ,Please try again.");
                        }

                    }//Success function end here 

                });
              }
   
    }

    function Delete_past(pid)
    {
      var campid=$('#lv_past_campaign_id').val();
      var result = confirm("Are you sure you want to delete.");
            if (result) {  
                $.ajax({
                    type: "POST",
                    url: "api.php", //calling page from same directory 
                    data: {'action': 'delete_list_view', 'postid': pid},
                    success: function (response) {
                        if (response.trim() == 1 || response.trim() == '1') { // compare Response from server .
                           Swal.fire({
                                    type: 'success',
                                    title: 'Success',
                                    text: 'Deleted Successfully.',
                                    allowOutsideClick: false
                                  }).then(okay => {
                                       if (okay) {
                                           $(".dtTable tbody").empty();
                                             fetch_lvposts_past(campid);
                                      }
                                    });
                         
                        } else
                        {
                            alert("Something went wrong ,Please try again.");
                        }

                    }//Success function end here 

                });
              }
   
    }


function Preview(ep_id){
$("#preview_ep_id").val(ep_id);

  $.ajax({
      type: "POST",
      url: "api.php",
      dataType: "json",
      data: {"action": "get_calendar_details_by_id", "ep_id":ep_id },
      success: function(data){

         fetch_fb_posts(ep_id);
         fetch_insta_posts(ep_id);      
         fetch_linkedin_posts(ep_id);
         fetch_twitter_posts(ep_id);      

        $("#pview_campaign_name").text(data[0].campaign_name);
        $("#pview_post_name").text(data[0].post_name);
        $("#pview_status").text(data[0].status_name);
        $("#pview_tdate").text(data[0].pview_tdate);
        $("#pview_turl").text(data[0].target_url);
        $("#pview_influencers").text(data[0].influencers);
        $("#pview_hashtags").text(data[0].hashtags);
        
 
      },
      error: function() { 
        swal({
            type: 'error',
            title: 'Oops...',
            text: "Something went wrong! Please try again"
          });
         }
    }); // end of ajax

}

function fetch_fb_posts(ep_id){
  $.ajax({
      type: "POST",
      url: "api.php",
      dataType: "json",
      data: {"action": "get_fb_details_by_id", "ep_id":ep_id },
      success: function(data){
        $("#pview_postcopy").text(data[0].post_copy);
        $("#pview_fturl").text(data[0].target_url);
        var doc_data = '';
        if($.trim(data[0].post_image) == '' || $.trim(data[0].post_image) == null || $.trim(data[0].post_image) == 'null'){
          doc_data += '';
        }else{
         doc_data += '<a href="images/social_media_planner_uploads/'+data[0].post_image+'" class="fileBtnBlue" download="">'+data[0].post_image+'</a>';
        }
        
       $("#preview_fb_download").html(doc_data);
      },
      error: function() { 
        swal({
            type: 'error',
            title: 'Oops...',
            text: "Something went wrong! Please try again"
          });
         }
    }); // end of ajax
}

function fetch_insta_posts(ep_id){
  $.ajax({
      type: "POST",
      url: "api.php",
      dataType: "json",
      data: {"action": "get_insta_details_by_id", "ep_id":ep_id },
      success: function(data){
        $("#pview_ipostcopy").text(data[0].post_copy);
        $("#pview_iturl").text(data[0].target_url);
         var doc_data = '';
        if($.trim(data[0].post_image) == '' || $.trim(data[0].post_image) == null || $.trim(data[0].post_image) == 'null'){
          doc_data += '';
        }else{
         doc_data += '<a href="images/social_media_planner_uploads/'+data[0].post_image+'" class="fileBtnBlue" download="">'+data[0].post_image+'</a>';
        }
       $("#preview_insta_download").html(doc_data);
      },
      error: function() { 
        swal({
            type: 'error',
            title: 'Oops...',
            text: "Something went wrong! Please try again"
          });
         }
    }); // end of ajax
}

function fetch_linkedin_posts(ep_id){
  $.ajax({
      type: "POST",
      url: "api.php",
      dataType: "json",
      data: {"action": "get_lin_details_by_id", "ep_id":ep_id },
      success: function(data){
        $("#pview_lpostcopy").text(data[0].post_copy);
        $("#pview_lturl").text(data[0].target_url);
         var doc_data = '';
        if($.trim(data[0].post_image) == '' || $.trim(data[0].post_image) == null || $.trim(data[0].post_image) == 'null'){
          doc_data += '';
        }else{
         doc_data += '<a href="images/social_media_planner_uploads/'+data[0].post_image+'" class="fileBtnBlue" download="">'+data[0].post_image+'</a>';
        }
       $("#preview_lin_download").html(doc_data);
      },
      error: function() { 
        swal({
            type: 'error',
            title: 'Oops...',
            text: "Something went wrong! Please try again"
          });
         }
    }); // end of ajax
}

function fetch_twitter_posts(ep_id){
  $.ajax({
      type: "POST",
      url: "api.php",
      dataType: "json",
      data: {"action": "get_twitter_details_by_id", "ep_id":ep_id },
      success: function(data){
        $("#pview_tpostcopy").text(data[0].post_copy);
        $("#pview_tturl").text(data[0].target_url);
         var doc_data = '';
        if($.trim(data[0].post_image) == '' || $.trim(data[0].post_image) == null || $.trim(data[0].post_image) == 'null'){
          doc_data += '';
        }else{
         doc_data += '<a href="images/social_media_planner_uploads/'+data[0].post_image+'" class="fileBtnBlue" download="">'+data[0].post_image+'</a>';
        }
       $("#preview_twi_download").html(doc_data);
      },
      error: function() { 
        swal({
            type: 'error',
            title: 'Oops...',
            text: "Something went wrong! Please try again"
          });
         }
    }); // end of ajax
}

function setrequestid(postid){
    $("#info_modal_postid").val(postid);     
     
}

//missing information submit
$(document).on('click','#info_submit',function () {
  var event_id = "<?php echo $event_id; ?>";
  var post_id = $( "#info_modal_postid" ).val();
  var email_address = $( "#email_addresses" ).val();
  var info_msg = $( "#info_msg" ).val();
  var selectinfo = $( "#multiselect_all_doc_opt" ).val();
  var campid=$('#alvcampaign_id').val();

   var go="success";
   $(".error").remove();
   if (selectinfo.length < 1) {
      $('#doc_option_div').after('<span class="error">This field is required</span>');
      go = "error";
    }
   if (email_address.length < 1) {
      $('#email_addresses').after('<span class="error">Email Address required</span>');
      go = "error";
    }
  

  if(go=="success")
  {
  $.ajax({
          type: "POST",
          url: "api.php", //calling page from same directory 
          data: {'action': 'social_media_planner_request_info', 'event_id': event_id,'postid': post_id,'email_address': email_address,'info_msg': info_msg,'selectinfo': selectinfo},
          success: function (response) {
              if (response.trim() == 1 || response.trim() == '1') { // compare Response from server .
               // $("#information_modal").hide();
                $('#information_modal').modal('hide');
                 Swal.fire({
                          type: 'success',
                          title: 'Success',
                          text: 'Email Sent Successfully.',
                          allowOutsideClick: false
                        }).then(okay => {
                             if (okay) {
                                 $(".dtTable tbody").empty();
                                   fetch_lvposts_live(campid);
                            }
                          });
               
              } else
              {
                  alert("Something went wrong ,Please try again.");
              }

          }//Success function end here 

      });
  }
 });

   function copyTxtApproved() {
          var copyText = document.getElementById("approved_spk_url_show");
          copyText.select();
          document.execCommand("copy");
          $('.cpTextApprovedTxt').fadeIn(400).delay(1000).fadeOut(400);
        }

  function copyTxtApproved2() {
          var copyText = document.getElementById("approved_spk_url_show2");
          copyText.select();
          document.execCommand("copy");
          $('.cpTextApprovedTxt').fadeIn(400).delay(1000).fadeOut(400);
        }

function copyTxtApproved3() {
          var copyText = document.getElementById("approved_spk_url_show3");
          copyText.select();
          document.execCommand("copy");
          $('.cpTextApprovedTxt').fadeIn(400).delay(1000).fadeOut(400);
        }


 function copyTxtApproved11() {
          var copyText = document.getElementById("approved_spk_url_show11");
          copyText.select();
          document.execCommand("copy");
          $('.cpTextApprovedTxt').fadeIn(400).delay(1000).fadeOut(400);
        }

  function copyTxtApproved22() {
          var copyText = document.getElementById("approved_spk_url_show22");
          copyText.select();
          document.execCommand("copy");
          $('.cpTextApprovedTxt').fadeIn(400).delay(1000).fadeOut(400);
        }

function copyTxtApproved33() {
          var copyText = document.getElementById("approved_spk_url_show33");
          copyText.select();
          document.execCommand("copy");
          $('.cpTextApprovedTxt').fadeIn(400).delay(1000).fadeOut(400);
        }


   $(document).on('change','.event_date',function () {
         var id = $(this).attr('id');
         if($(this).val()!='')
         {
            $.ajax({
                        type: "POST",
                        url: "api.php",
                        dataType: "json",
                        data: {"action": "update_targetdate", "rec_id":$(this).attr('id'),"tdate":$(this).val() },
                        success: function(data){
                                $('.targetd_success, .success_msg1').hide();
                                $('#targetd_succcess_'+id).show();
                        },
                          error: function() {
                              swal({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: "Something went wrong! Please try again"
                                  });
                             }
                      }); // end of ajax   
         }
  });
  
</script> 
   
