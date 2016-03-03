(function() {
  'use strict';

  /**
   * @ngdoc function
   * @name udbApp.controller:AppCtrl
   * @description
   * # AppCtrl
   * Controller of the udbApp
   */
  angular
    .module('udbApp')
    .controller('AppCtrl', AppController);

  AppController.$inject = ['$scope', '$rootScope', '$location'];

  function AppController($scope, $rootScope, $location) {
    $scope.showJobLog = false;

    function toggleJobLog() {
      $scope.showJobLog = !$scope.showJobLog;
    }

    $rootScope.$on('searchQueryChanged', function (event, searchQuery) {
      var searchParameters = {};

      if (searchQuery.queryString) {
        searchParameters.query = searchQuery.queryString;
      }

      $location.path('/search').search(searchParameters);
    });

    $scope.toggleJobLog = toggleJobLog;
  }
})();
