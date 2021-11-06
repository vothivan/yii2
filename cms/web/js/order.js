app.service('order', function ($uibModal) {

    this.logs = function (oid) {
        $uibModal.open({
            animation: true,
            backdrop: 'static',
            templateUrl: 'orderLogs',
            controller: 'orderLogs',
            size: 'lg',
            resolve: {
                params: function () {
                    return {
                        oid: oid
                    }
                }
            }
        });
    };

    this.get = function (id) {
        loading.show();
        $.ajax({
            url: baseUrl + '/order/get?oid=' + id,
            method: 'GET',
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    return resp.data;
                } else {
                    bootbox.alert(resp.message);
                }
            }
        });
    }

    this.getLog = function (id) {
        loading.show();
        $.ajax({
            url: baseUrl + '/order/getlog?oid=' + id,
            method: 'GET',
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    return resp.data;
                } else {
                    bootbox.alert(resp.message);
                }
            }
        });
    }
});

app.controller('order', function ($scope, $uibModal, order, $q, $timeout) {

    $scope.orders = [];
    $scope.count = [];
    $scope.oid = '';
    $scope.name = '';
    $scope.item = 100;
    $scope.totalPage = 0;
    $scope.page = 0;
    $scope.activePage = 0;
    $scope.totalItem = 0;

    
    $scope.list = function () {
        loading.show();
        url = baseUrl + '/order/list';

        $.ajax({
            url: url,
            data: {
                page: $scope.page,
                item: $scope.item,
                status: $scope.status,
                oid: $scope.oid,
                name: $scope.name
            },
            method: 'GET',
            success: function (resp) {
                if (resp.success) {
                    angular.forEach(resp.orders, function (v, k) {
                        angular.forEach(resp.orders[k].products, function (b, l) {
                            b.productData = JSON.parse(b.productData);
                        });
                    });
                    $scope.$apply(function () {
                        $scope.orders = resp.orders;
                        $scope.count = resp.count;
                        $scope.totalPage = resp.page_count;
                        $scope.totalItem = resp.page_item_count;
                        $scope.activePage =  resp.page;
                    });
                }
                loading.hide();
            }
        });
    };

    $scope.changestatus = function (id, status) {
        var m = 'Bạn muốn xác nhận đơn hàng này?';
        if(status == 4){
            m = 'Bạn chắc chắn muốn hủy đơn hàng này chứ?';
        }
        if(status == 3){
            m = 'Đơn hàng này đã hoàn thành?';
        }
        bootbox.confirm(m, function (confirmed) {
            if (confirmed) {
                loading.show();
                url = baseUrl + '/order/changestatus';
                $.ajax({
                    url: url,
                    data: {
                        id: id,
                        status: status,
                    },
                    method: 'POST',
                    success: function (resp) {
                        if (resp.success) {
                            $scope.$apply(function () {
                                $scope.list();
                            });
                        }
                        loading.hide();
                    }
                });
            }
        });
    };

    $scope.getStatusClass = function (st) {
        switch (st*1) {
            case 0:
                return 'box-warning';
                break;
            case 1:
                return 'box-info';
                break;
            case 2:
                return 'box-primary';
                break;
            case 3:
                return 'box-success';
                break;
            case 4:
                return 'box-danger';
                break;
            default:
                return 'box-default';
        }
    };

    $scope.btnShow = function (id) {
        $("#show-" + id).slideToggle("slow");
    };

    var today = new Date();

    $scope.thisMonth = function () {
        $scope.startDate = new Date(today.getFullYear(), today.getMonth(), 1);
        $scope.endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        $scope.list();
    };

    $scope.thisMonth();

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
