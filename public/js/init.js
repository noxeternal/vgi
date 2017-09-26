let vgi = angular.module('videoGameInventory', ['forms', 'directives'])

vgi
  .factory('enumData', enumData)
  .controller('vgDisplay', vgDisplay)
