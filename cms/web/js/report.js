

app.controller('report_order', function ($scope, $uibModal, $timeout, $q) {
    $scope.data;
    $scope.startDate = startDate;
    $scope.endDate = endDate;


    $scope.dateOptions = {};

    $scope.open1 = function () {
        $scope.popup1.opened = true;
    };

    $scope.open2 = function () {
        $scope.popup2.opened = true;
    };

    $scope.popup1 = {
        opened: false
    };

    $scope.popup2 = {
        opened: false
    };
});
