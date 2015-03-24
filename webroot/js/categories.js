/**
 * Categories Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, modalStack)} Controller
 */
NetCommonsApp.controller('Categories',
    function($scope) {

      $scope.categoryList = {};
      $scope.validationErrors = {};

      $scope.init = function(categoryList, validationErrors) {
        $scope.categoryList = categoryList;
        $scope.validationErrors = validationErrors;
      };

      $scope.addCategory = function() {
        var addCategory = {Category: {id: '', name: ''}};
        $scope.categoryList.push(addCategory);
      };

      $scope.deleteCategory = function(index) {
        $scope.categoryList.splice(index, 1);
      };

      $scope.sortCategory = function(moveType, index) {
        var destIndex = (moveType === 'up') ? index - 1 : index + 1;
        if (angular.isUndefined($scope.categoryList[destIndex])) {
          return false;
        }

        var destCategory = angular.copy($scope.categoryList[destIndex]);
        var targetCategory = angular.copy($scope.categoryList[index]);
        $scope.categoryList[index] = destCategory;
        $scope.categoryList[destIndex] = targetCategory;
      };

    });
