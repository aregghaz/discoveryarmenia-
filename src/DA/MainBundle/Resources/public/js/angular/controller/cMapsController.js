angular.module('discover')
    .controller('cMapCtr',['$scope',
        function($scope){

            var mapOptions = {
                panControl    : false,
                zoomControl   : false,
                scaleControl  : false,
                mapTypeControl: false

            };
            $scope.map = {
                armenia:{
                    center: { latitude: 40.2032206, longitude: 44.5251201},
                    zoom: 17,
                    bounds: {},
                    options: mapOptions
                },
                france:{
                    center: { latitude: 47.7031995, longitude: 2.5442966},
                    zoom: 5,
                    bounds: {},
                    options: mapOptions
                }


            };

            $scope.Markers1 = [
                {
                    id: 0,
                    latitude: 40.2032206,
                    longitude: 44.5251201,
                    icon: {
                        url: '/bundles/configadmin/img/marker.png'
                    }
                }
            ];
            $scope.Markers2 = [
                {
                    id: 1,
                    latitude: 47.7031995,
                    longitude: 2.5442966,
                    icon: {
                        url: '/bundles/configadmin/img/marker.png'
                    }
                }
            ];

        }]);