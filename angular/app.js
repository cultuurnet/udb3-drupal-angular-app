(function(settings) {
  'use strict';

  var initInjector = angular.injector(['ng']);
  var $q = initInjector.get('$q');
  function settingResolverFactory($q) {
    return function(settingReference) {
      var settingValue = settings[settingReference];
      if (settingValue) {
        return $q.resolve(settingValue)
      } else {
        return $q.reject('No value found for setting with reference: ' + settingReference);
      }
    };
  }
  var promiseSetting = settingResolverFactory($q);

  /**
   * @ngdoc overview
   * @name udbApp
   * @description
   * # udbApp
   *
   * Main module of the application.
   */
  angular
    .module('udbApp', [
      'ngCookies',
      'ngSanitize',
      'udb.core',
      'udbApp.drupal-router',
      'udbApp.ga-tag-manager'
    ])
    .config(udbAppConfig)
    .run(function (udbApi) {
      udbApi.getMe();
    })
    .constant('appConfig', settings.appConfig)
    .constant('moment', moment)
    .constant('eventId', promiseSetting('eventId'))
    .constant('placeId', promiseSetting('placeId'))
    .constant('offerId', promiseSetting('offerId'));

  udbAppConfig.$inject = ['$sceDelegateProvider', '$translateProvider', 'uiSelectConfig', 'appConfig',
    'queryFieldTranslations', 'dutchTranslations'];

  function udbAppConfig($sceDelegateProvider, $translateProvider, uiSelectConfig, appConfig,
                        queryFieldTranslations, dutchTranslations) {

    $sceDelegateProvider.resourceUrlWhitelist([
      'self',
      appConfig.baseUrl + '**'
    ]);

    // Translation configuration
    var defaultTranslations = _.merge(dutchTranslations, queryFieldTranslations.nl);

    $translateProvider
      .translations('nl', defaultTranslations)
      .preferredLanguage('nl');
    // end of translation configuration

    uiSelectConfig.theme = 'bootstrap';
  }
})(drupalSettings.culturefeed_udb3_app);
