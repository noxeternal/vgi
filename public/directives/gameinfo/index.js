(function () {
  let app = angular.module('gameinfo', [])
  app.directive('gameInfo', function () {
    return {
      restrict: 'E',
      templateUrl: 'directives/gameinfo',
      scope: {
        model: '=ngModel',
        game: '=?'
      }
    }
  })
})()
