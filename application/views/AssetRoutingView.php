<style>
    .map-frame {
    width: 100%;
    height: 100%;
    position: relative;
}

.map-content {
    z-index: 10;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #00000042;
    color: #222;
    height: 90px;
    padding: 5px;
}

.hgt100vh {
    height:100vh;
}

.form-row {
    margin-left: 6px;
    margin-top: 0;
    /*background: #fff;*/
    display: flex;
    width: 100%;
    padding: 4px 10px;
    border-radius: 5px;
}

.form-row form {
    width:100%;
}

.form-row .form-group {
    float: left;
    width: 14.2%;
    padding: 4px 10px 0px 10px;
    background: #fff;
    min-height: 66px;
    float: left;
}

.form-row .form-group label {
    font-weight: 500;
    color: #6f6f6f;
        font-size: 12px;
}

.form-row .form-group .form-control {
    border: none;
    border-bottom: 1px solid #b5b5b5;
    height: 28px;
    margin-bottom: 10px;
        padding: 0;
        font-size: 12px;
       
}

.form-row .form-group button {
    background: #d00000;
    color: #fff;
    padding: 8px 18px;
    margin-top: 0px;
    font-weight: 600;
    border-radius: 0;
    margin-left: 10px;
    border: none;
    margin-top: 10px; 
}


    #map {
        height: 100%;
    }
    
    .ui-autocomplete {
        list-style-type: none;
        margin: 0px;
        padding: 0px;
        max-height: 400px;
       overflow: auto;
        overflow-x: hidden;
    }
    .ui-menu-item {
        list-style-type: none !important;
        margin:0px;
        padding:0px;
        
        
    }
    
    .ui-helper-hidden-accessible {
        display: none;
    }
</style>
<div class="">
    <?php   if(count($userdetail)>0){}else{ ?><script>
         alert("No Record Found "); </script> 
             <?php }  ?> 
    
    <div class="row hgt100vh">

        <div class="map-frame">
            <div id="map"></div>

            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeubS8KjHiTu2TI7I5X_4IjGZCI0zeKGY&callback=initMap">
            </script>
            <script>
                var map;

                function initMap() {
                    <?php if(count($userdetail)>0){
                    foreach ($userdetail as $k => $ukey){ if($ukey['fse_lat']&&$ukey['fse_long']){  ?> 
                        var broadway_<?php echo $k ?> = {
                        info: '<span onclick=getdetail(<?php echo $ukey['id']; ?>)><strong><?php echo trim($ukey['fse_name']); ?></strong></span><br><?php echo trim($ukey['fse_address']);?><br><?php echo (isset($ukey['fse_type']))?$ukey['fse_type']:"";?>',
                        lat: <?php echo $ukey['fse_lat']; ?>,
                        long: <?php echo $ukey['fse_long']; ?>
                    };
                    <?php } } }  ?> 
                
                    var locations = [
                          <?php if(count($userdetail)>0){ foreach ($userdetail as $k => $ukey){ if($ukey['fse_lat']&&$ukey['fse_long']){ ?> 
                        [broadway_<?php echo $k ?>.info, broadway_<?php echo $k ?>.lat, broadway_<?php echo $k ?>.long, <?php echo $k ?>],
//                        [belmont.info, belmont.lat, belmont.long, 1],
//                        [sheridan.info, sheridan.lat, sheridan.long, 2],
                          <?php  } } } ?> 
                    ];

                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 13,
                        center: new google.maps.LatLng(41.976816, -87.659916),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    var infowindow = new google.maps.InfoWindow({});

                    var marker, i;
                    for (i = 0; i < locations.length; i++) {
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                            map: map
                        });

                        google.maps.event.addListener(marker, 'click', (function(marker, i) {
                            return function() {
                                infowindow.setContent(locations[i][0]);
                                infowindow.open(map, marker);
                            }
                        })(marker, i));
                    }

                }
            </script>
            <div class="map-content">
                <?php                 //var_dump($userdetail);?> 
                <div class="mapcenter">
                    <div class="form-row">
                        <form action="<?php echo base_url();?>AssetRoutingController/filter_ueser" method="POST" name="Filter_User_Location" id="Filter_User_Location">                  
                        <div class="form-group">
                            <label>Name of FSE:</label>
                            <input type="text" class="form-control"  id="name_fse" name="name_fse">
                            <div id="autocomplete-container" style=""></div>
                        </div>

                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>

                        <div class="form-group">
                            <label>Radius:</label>
                           <input type="text" class="form-control" id="Redius" name="Redius"> 
                        </div>

                <div class="form-group">
                     <label>Skill set:</label>
                      <select class="form-control" id="skill_set" name="skill_set">
                           <option value="">Select</option>
                           <?php foreach($skillset As $skill){ ?> 
                          <option value="<?php echo $skill['fse_type']; ?>"><?php echo $skill['fse_type']; ?></option>  
                         <?php  }?> 
                     </select>
                 </div>
                  
                            <div class="form-group">
                                <label>Status:</label>
                                <select class="form-control" id="Status" name="Status">
                                    <option value="">Select</option>
                                     <?php foreach($status As $Stat){ ?> 
                                    <option value="<?php echo $Stat['status_type']; ?>"><?php echo $Stat['status_type']; ?></option>
                                  <?php  }?>    
                                </select>

                            </div>


                        <div class="form-group">
                            <label>Priority:</label>


                <select class="form-control" id="Priority" name="Priority">
                  <option value="">Select</option>
                     <?php foreach($priority As $p){ ?> 
                  <option value="<?php echo $p['id']; ?>"><?php echo $p['priority_type']; ?></option>
                                  <?php  }?>   
                </select>

                        </div>
                             <?php $cunt=0;  if(count($userdetail)>0){
                    foreach ($userdetail as $k => $ukey){ if($ukey['fse_lat']&&$ukey['fse_long']&&$cunt!=1){ $cunt=1; ?> 
                            <input type="hidden" name="latitude" id="latitude" value="<?php echo $ukey['fse_lat']; ?>"> 
                            <input type="hidden" name="langitude" id="latitude" value="<?php echo $ukey['fse_long']; ?>"> 
                             <?php  } } } ?> 
                        <div class="form-group" style="">
                            <label></label>
                            <button type="submit" class="btn btn-default">Filter</button>
                        </div>
                          </form>
                    </div>
                </div>
                </div>
            
              <div class="rgt_col scrollbar" id="style-2"> 
                    <div id="usertask"> 
         <?php $this->load->view('usertasklist');?> 
                    </div>
                </div>
        </div>
        
        
        <script>
 
   function getdetail(id){
      var id =id; 
      var BASE_URL = "<?php echo base_url();?>";
     $.ajax({
            type:'POST',
            url:BASE_URL+'AssetRoutingController/shawtask',
            data:{'id':id},
            success:function(data){
                
                $('#usertask').html(data);
                $(".scrollbar").css('display','block');
                 $(".map-content").css('width','74.1%');
                
            }
        });
    }
   </script> 

    <script type="text/javascript">
                $(function () {
                    $("#name_fse").autocomplete({
                        source: function (request, response) {
                            $.ajax({
                                url: "<?php echo base_url(); ?>TaskController/getFse_autocomplete_c",
                                dataType: "json",
                                type: "POST",
                                data: request,
                                success: function (data) {
                                    response(data);
                                }
                            });
                        },
//                        focus: function (event, ui) {
//                            $("#name_fse").val(ui.item.label);
//                            return false;
//                        },
//                        select: function (event, ui) {
//                           // $('#fse_id').val(ui.item.key);
//                           // $("#name_fse").val(ui.item.label);
//                            return false;
//                        },
                        change: function (e, u) {
                            if (u.item == null) {
                                $(this).val("");
                                return false;
                            }
                        },

                        appendTo: '#autocomplete-container, .scrollbar',
                        minLength: 1
                    });
                });
            </script>
            <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>