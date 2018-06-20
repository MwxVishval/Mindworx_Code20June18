<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>Directions service</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
    </head>
    <body>
        <?php //var_dump($showmap['taskallcationfse'][0]['fse_lat']); 
        
         $address1='';
          $address='';
        if(isset($showmap['taskallcationfse'][0]['fse_lat'])&&isset($showmap['taskallcationfse'][0]['fse_lat'])){
        $lat = (float) $showmap['taskallcationfse'][0]['fse_lat'];
        $lng = (float) $showmap['taskallcationfse'][0]['fse_long'];
        $address = getaddress($lat,$lng); 
        }
        if(isset($showmap['tasklocation'][0]['task_location']))
        {
        $locationarray = explode(',', $showmap['tasklocation'][0]['task_location']);
        $lati =  str_replace("(","",$locationarray[0]);
        $lang =  str_replace(")","",$locationarray[1]);
        $lat2 = (float) $lati;
        $lng2 = (float) $lang;
        $address1 = getaddress($lat2,$lng2);
        
        } 
        function getaddress($lat, $lng) {
            $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($lat) . ',' . trim($lng) . '&sensor=false';
            $json = @file_get_contents($url);
            $data = json_decode($json);
          // var_dump($data->results);
            $status = $data->status;
            if ($status == "OK") {
              if(isset($data->results[0]->address_components[3]->short_name)&&isset($data->results[0]->address_components[5]->short_name))
                 return $data->results[0]->address_components[3]->short_name.','.$data->results[0]->address_components[5]->short_name;
            } else {
                return '';
            }
        }
        ?>
        <div id="map" style="height: 300px;"></div>
        <select id="start">
            <option value="<?php echo ($address)?$address:'chicago, il';?> "><?php echo ($address)?$address:'chicago, il';?></option>
        </select>
        <select id="end">
            <option value="<?php echo ($address1)?$address1:'st louis, mo';?>"><?php echo ($address1)?$address1:'st louis, mo';?></option>
        </select>
        <script>
            function initMap() {
                var directionsService = new google.maps.DirectionsService;
                var directionsDisplay = new google.maps.DirectionsRenderer;
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 7,
                    center: {lat: 41.85, lng: -87.65}
                });
                directionsDisplay.setMap(map);

                var onChangeHandler = function () {
                    calculateAndDisplayRoute(directionsService, directionsDisplay);
                };
                 onChangeHandler(); 
                document.getElementById('start').addEventListener('change', onChangeHandler);
                document.getElementById('end').addEventListener('change', onChangeHandler);
            }

            function calculateAndDisplayRoute(directionsService, directionsDisplay) {
                directionsService.route({
                    origin:  document.getElementById('start').value,
                    destination:  document.getElementById('end').value,
                    travelMode: 'DRIVING'
                }, function (response, status) {
                    if (status === 'OK') {
                        directionsDisplay.setDirections(response);
                    } else {
                        window.alert('Directions request failed due to ' + status);
                    }
                });
            }
            
            
        </script>
        
         <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbSoQMawAVbWOO52sO-opzsuXgje50YyQ&callback=initMap">
        </script>
    
      </body>
</html>