'use strict';

angular.module('discover')
    .factory('LocationCords', function ($resource) {
        return $resource("/api/location/:LocationID",{},{
            getLocation: {method: 'GET',isArray: true}
        });
    })
    .factory('ToursLocationCords', function ($resource) {
        return $resource("/api/location/tour/:ID",{},{
            getLocation: {method: 'GET',isArray: true}
        });
    });