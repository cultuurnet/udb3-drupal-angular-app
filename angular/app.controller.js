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

  AppController.$inject = ['$scope', 'appConfig'];

  function AppController($scope, appConfig) {

    $scope.searchQuery = '';
    $scope.showJobLog = false;
    $scope.startSearch = startSearch;

    function toggleJobLog() {
      $scope.showJobLog = !$scope.showJobLog;
    }

    /**
     * Start a search on drupal.
     */
    function startSearch() {
      window.location.href = '/udb3/search#?query=' + $scope.searchQuery;
    }

    $scope.toggleJobLog = toggleJobLog;
  }
})();
