angular.module('discover')
    .controller('iMapCtr',['$scope','uiGmapGoogleMapApi',
        function($scope,uiGmapGoogleMapApi){

            var mapOptions = {
                panControl    : false,
                zoomControl   : false,
                scaleControl  : false,
                mapTypeControl: false

            };
                $scope.map = {
                center: { latitude: 40.0168261, longitude: 45.1967516},
                options: mapOptions,
                refresh: function () {
                    $scope.map.control.refresh();
                }

            };

            $scope.id = $('#singleID').attr('data-id');
            $scope.Markers = [];
            $scope.mapLoc = function() {
                $('.accommodation_box').each(function () {
                    var latitude = $(this).data('latitude');
                    var longitude = $(this).data('longitude');

                    var coords = {latitude: latitude,
                        longitude: longitude,
                        icon: {
                            url: '/bundles/configadmin/img/marker.png'
                        }
                    };
                    $scope.map = {
                        center: { latitude: latitude, longitude: longitude},
                        options: mapOptions,
                        zoom: 8
                    };
                    coords['id'] = $(this).index();
                    $scope.Markers.push(coords);

                });

            };
            $scope.mapLoc();

            uiGmapGoogleMapApi.then(function (maps) {
                setTimeout(function () {
                    google.maps.event.trigger(maps,'resize');
                }, 100);
            });
            //$scope.Location();

        }]);