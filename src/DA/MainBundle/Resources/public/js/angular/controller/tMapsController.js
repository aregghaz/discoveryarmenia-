angular.module('discover')
    .controller('tMapCtr',['$scope',
        'ToursLocationCords',
        function($scope,ToursLocationCords){

            var mapOptions = {
                panControl    : false,
                zoomControl   : false,
                scaleControl  : false,
                mapTypeControl: false

            };
            $scope.map = {
                center: { latitude: 40.0168261, longitude: 45.1967516},
                zoom: 7,
                bounds: {},
                options: mapOptions

            };

            $scope.id = $('#singleID').attr('data-id');
            $scope.Markers = [];
            $scope.Location = function(){
                $scope.leaveStop = true;
                ToursLocationCords.getLocation({ID:$scope.id},function(data){
                    angular.forEach(data[0].location, function(value, key) {
                        
                        var coords = {latitude: value.latitude,
                            longitude: value.longitude,
                            icon: {
                                url: '/bundles/configadmin/img/marker.png'
                            }
                        };

                        coords['id'] = key;
                        $scope.Markers.push(coords);

                    });
                });

            };
            $scope.Location();

        }]);