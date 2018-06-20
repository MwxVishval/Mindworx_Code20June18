
jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?key=AIzaSyDbSoQMawAVbWOO52sO-opzsuXgje50YyQ&callback=initialize";
    document.body.appendChild(script);
});

function initialize() {
    // Change a few 'var variableName' to 'window.' This lets us set global variables from within our function
    window.directionsService = new google.maps.DirectionsService();
    window.directionsDisplay = new google.maps.DirectionsRenderer();
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
        
    // Multiple Markers (Start & end destination)
    window.markers = [
        ['', 18.520430,73.856744],
        ['', 19.095208,74.749592]
    ];
    
    // Render our directions on the map
    directionsDisplay.setMap(map);

    // Set the current route - default: walking
    calcRoute();
    
}

// Calculate our route between the markers & set/change the mode of travel
function calcRoute() {
    var selectedMode = 'DRIVING';
    var request = {
        // London Eye
        origin: new google.maps.LatLng(markers[0][1], markers[0][2]),
        // Palace of Westminster
        destination: new google.maps.LatLng(markers[1][1], markers[1][2]),
        // Set our mode of travel - default: walking
        travelMode: google.maps.TravelMode[selectedMode]
    };
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
    delete(map);
}


