(function(settings) {
  'use strict';

  /**
   * @ngdoc overview
   * @name udbApp.drupal-router
   * @description
   *  This module takes into account Drupal specific routing
   *
   */
  angular
    .module('udbApp.drupal-router', [
      'udbApp'
    ])
    .config(function ($locationProvider) {

      $locationProvider.html5Mode({
        enabled: true,
        requireBase: true
      });
    })
    .run(function (locationChangeInterceptor, searchRedirector) {
      locationChangeInterceptor.ignore('/search');
    })
    .factory('locationChangeInterceptor', locationChangeInterceptor)
    .factory('searchRedirector', searchRedirector)
    .constant('udb3BaseUrl', settings.appConfig.udb3BaseUrl);

  locationChangeInterceptor.$inject = ['$rootScope', '$window', 'udb3BaseUrl'];
  function locationChangeInterceptor($rootScope, $window, udb3BaseUrl) {
    var service = {
      ignoredPaths: []
    };

    /**
     * Add one or more paths to the ignore list.
     *
     * @param {string|string[]}  paths
     *  One or multiple paths to ignore
     */
    service.ignore = function (paths) {
      if (!_.isArray(paths)) {
        paths = [paths];
      }

      service.ignoredPaths = _.union(service.ignoredPaths, paths)
    };

    /**
     * Check if a path matches a url.
     *
     * @param {string} url
     * @param {string} path
     *
     * @return {boolean}
     */
    function pathMatches (url, path) {
      return (url.indexOf(udb3BaseUrl + path) !== -1)
    }

    function redirectOnLocationChange(event, newUrl, oldUrl) {
      if (newUrl && oldUrl) {
        var ignored = _.find(service.ignoredPaths, function (path) {
          return pathMatches(oldUrl, path) && pathMatches(newUrl, path);
        });
      }

      if (!ignored && oldUrl && newUrl !== oldUrl) {
        event.preventDefault();
        $window.location.href = newUrl;
      }
    }

    $rootScope.$on('$locationChangeStart', redirectOnLocationChange);
    return service;
  }

  searchRedirector.$inject = ['$rootScope', '$location'];
  function searchRedirector($rootScope, $location) {
    $rootScope.$on('searchQueryChanged', function (event, searchQuery) {
      var searchParameters = {};

      if (searchQuery.queryString) {
        searchParameters.query = searchQuery.queryString;
      }

      $location.path('/search').search(searchParameters);
    });

    return {};
  }
})(drupalSettings.culturefeed_udb3_app);
