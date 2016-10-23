angular.module('admin')
    .controller('mapCtr',['$scope','$log', 'uiGmapGoogleMapApi',
        function($scope,$log, GoogleMapApi){
            var data_lat = $('.lat').attr('data-lt');
            var data_lng = $('.lng').attr('data-lng');
            $scope.view = true;

            var isview = $('.map_block').attr('data-view');


            if(isview == 'false'){
                isview = false;
                $scope.view = isview;
            }

            var events = {
                place_changed:function (searchBox) {
                    var place = searchBox.getPlace();
                    if (!place || place == 'undefined') {
                        console.log('no place data :(');
                        return;
                    }
                    $scope.lat = place.geometry.location.lat();
                    $scope.lng = place.geometry.location.lng();
                    // refresh the map
                    $scope.map = getMap(mapOptions,$scope.lat,$scope.lng,17);
                    setLatLng($scope.lat,$scope.lng);
                }
            };

            var mapOptions = {
                panControl    : false,
                zoomControl   : false,
                scaleControl  : false,
                mapTypeControl: false,
                icon: '/bundles/barekarg/img/marker.png'

            };

            if(data_lat && data_lng){
                $scope.map = getMap(mapOptions,data_lat,data_lng,17);
            }
            else {
                $scope.map = getMap(mapOptions,40.1687021,44.500723,12);
            }


            $scope.searchbox = {
                template:'searchbox.tpl.html',

                options:{
                    autocomplete:true,
                    types:['address']

                },
                events:events
            };

            function getMap(option,latitude,longitude,zoom){
                return {
                    center: { latitude: latitude, longitude: longitude},
                    zoom: zoom,
                    bounds: {},
                    options: option,
                    marker:  {
                        id: 0,
                        coords: {
                            latitude: latitude,
                            longitude: longitude
                        },
                        /* icon: {
                         url: '/bundles/barekarg/img/marker.png'
                         },*/
                        options: {
                            draggable: $scope.view,
                            icon: '/bundles/configadmin/img/marker.png'
                        },
                        events: {
                            dragend: function (marker, eventName, args) {
                                var e = args.coords;
                                var lat = e.latitude;
                                var lng = e.longitude;
                                setLatLng(lat,lng);
                            },
                            tilesloaded: function (map) {
                                $scope.$apply(function () {
                                    $scope.mapInstance = map;
                                });
                            }
                        }
                    },
                    events: {
                        click: function (maps, eventName, args) {
                            if($scope.view){
                                var e = args[0];
                                var lat = e.latLng.lat();
                                var lng = e.latLng.lng();
                                $scope.map.marker.coords = {
                                    latitude: lat,
                                    longitude: lng
                                };
                                maps.panTo(new google.maps.LatLng(lat, lng));
                                setLatLng(lat,lng);
                            }

                        }
                    }
                }
            }

            function setLatLng(lat,lng){
                $('.lat').val(lat);
                $('.lng').val(lng);
            }
            GoogleMapApi.then(function(maps) {
                maps.visualRefresh = true;
            });

}]);