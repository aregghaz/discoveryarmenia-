'use strict';

angular.module('basePath', [], ['$httpProvider', function ($httpProvider) {
    $httpProvider.interceptors.push(function() {
        return {
            'request': function(config) {
                if(config.url.indexOf(".html") === -1 &&
                    config.url.indexOf("app_dev.php") === -1){

                    config.url = '/app_dev.php' + config.url;
                }
                return config;
            },

            'response': function(response) {
                // same as above
                return response;
            }
        };
    });
}]);