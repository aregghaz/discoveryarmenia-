'use strict';

angular.module('discover')
    .factory('LocationCords', function ($resource) {
        return $resource("/api/location/:LocationID",{},{
            getLocation: {method: 'GET',isArray: true}
        });
    })
    .factory('DestinationCords', function ($resource) {
        return $resource("/destination/",{},{
            getLocation: {method: 'GET',isArray: true}
        });
    });