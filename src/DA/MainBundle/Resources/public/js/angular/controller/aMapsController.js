angular.module('discover')
    .controller('aMapCtr',['$scope',
        'LocationCords',
        function($scope,LocationCords){

            var mapOptions = {
                panControl    : false,
                zoomControl   : false,
                scaleControl  : false,
                mapTypeControl: false

            };
            $scope.map = {
                center: { latitude: 40.0168261, longitude: 45.1967516},
                options: mapOptions

            };

            $scope.id = $('#singleID').attr('data-id');
            $scope.Markers = [];
            $scope.Location = function(){
                $scope.leaveStop = true;
                LocationCords.getLocation({LocationID:$scope.id},function(data){
                    angular.forEach(data, function(value, key) {
                        var coords = {latitude: value.latitude,
                            longitude: value.longitude,
                            icon: {
                                url: '/bundles/configadmin/img/marker.png'
                            }
                        };
                        $scope.map = {
                            center: { latitude: value.latitude, longitude: value.longitude},
                            options: mapOptions,
                            zoom: 14
                        };
                        coords['id'] = key;
                        $scope.Markers.push(coords);

                    });
                });

            };
            $scope.Location();

        }]);