'use strict';

angular
    .module('discover',
        [
            "ngResource",
            "ngRoute",
            "basePath",
            "uiGmapgoogle-maps"
        ]).config(function(uiGmapGoogleMapApiProvider) {
    uiGmapGoogleMapApiProvider.configure({
        key: 'AIzaSyC3K6oKfeFdGZk7HLUhGz77gZroJZ2L-eM',
        //v: '3.X', //defaults to latest 3.X anyhow
        libraries: 'places' // Required for SearchBox.
    })
});