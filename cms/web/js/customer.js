app.controller('customer', function ($scope, $uibModal) {
    $scope.customer = {
        activated: '-1',
        email: '',
        name: '',
        phone: '',
        provinceId: 0,
        districtId: 0,
        isPos: 0,
        page: 0
    };
    $scope.getLocations = function () {
        $.ajax({
            url: baseUrl + '/customer/getlocations',
            method: 'GET',
            success: function (resp) {
                if (resp.success) {
                    $scope.$apply(function () {
                        $scope.provinces = resp.data.provinces;
                        $scope.districts = resp.data.districts;
                        $scope.provinces.splice(0, 0, {id: 0, name: 'Chọn tỉnh(thành phố)'});
                        $scope.districts.splice(0, 0, {id: 0, name: 'Chọn huyện(quận)'});
                    });
                }
            }
        });
    };
    $scope.changeProvince = function(){
        if($scope.customer.provinceId != 0){
            angular.forEach($scope.districts, function(value, key) {
                if($scope.districts[key].id != 0 && $scope.customer.provinceId != $scope.districts[key].provinceId)
                    $scope.districts[key].hidden = true;
                else
                    $scope.districts[key].hidden = false;
            });
            $scope.customer.districtId = 0;
        }
    };

    $scope.list = function () {
        loading.show();
        $.ajax({
            url: baseUrl + '/customer/list',
            data: {
                activated: $scope.customer.activated,
                email: $scope.customer.email,
                name: $scope.customer.name,
                phone: $scope.customer.phone,
                provinceId: $scope.customer.provinceId,
                districtId: $scope.customer.districtId,
                page: $scope.customer.page,
            },
            method: 'GET',
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    $scope.$apply(function () {
                        angular.forEach(resp.data.customers, function(value, key) {
                            angular.forEach(resp.data.provinces,function (value1,key1) {
                                if(resp.data.customers[key].provinceId == resp.data.provinces[key1].id) {
                                    resp.data.customers[key].provinceId = resp.data.provinces[key1].name;
                                }
                            });
                            angular.forEach(resp.data.districts,function (value1,key1) {
                                if(resp.data.customers[key].districtId == resp.data.districts[key1].id) {
                                    resp.data.customers[key].districtId = resp.data.districts[key1].name;
                                }
                            });
                        });
                        $scope.customers = resp.data.customers;
                        var pages = [];
                        for(var i=0; i<resp.data.pageCount; i++){
                            pages[i] = {};
                            pages[i].value = i;
                            pages[i].name = 'Trang ' + (i+1);
                            $scope.pages = pages;
                        }
                        $scope.page = resp.data.page;
                        $scope.total = resp.data.total;
                    });
                }
            }
        });
    };

    $scope.reset = function () {
        $scope.customer.name = '';
        $scope.customer.email = '';
        $scope.customer.phone = '';
        $scope.customer.activated = '-1';
        $scope.customer.provinceId = 0;
        $scope.customer.districtId = 0;
        $scope.customer.isPos = 0;
        $scope.customer.page = 0;
        $scope.list();
    };


    $scope.add = function () {
        $uibModal.open({
            animation: true,
            backdrop: 'static',
            templateUrl: 'customerForm',
            controller: 'addCustomer',
            size: 'lg',
            resolve: {
                params: function () {
                    return {
                        provinces: $scope.provinces,
                        districts: $scope.districts,
                        list: $scope.list
                    }
                }
            }
        });
    };

    $scope.edit = function (id) {
        loading.show();
        $.ajax({
            url: baseUrl + '/customer/get?id=' + id,
            method: 'GET',
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    $uibModal.open({
                        animation: true,
                        backdrop: 'static',
                        templateUrl: 'customerForm',
                        controller: 'editCustomer',
                        size: 'lg',
                        resolve: {
                            params: function () {
                                return {
                                    provinces: $scope.provinces,
                                    districts: $scope.districts,
                                    customer: resp.data,
                                    id: id,
                                    list: $scope.list
                                }
                            }
                        }
                    });
                } else {
                    bootbox.alert(resp.message);
                }
            }
        });
    };

    $scope.remove = function (id) {
        bootbox.confirm('Bạn chắc chắn muốn xóa khách hàng này chứ?', function (confirmed) {
            if (confirmed) {
                loading.show();
                $.ajax({
                    url: baseUrl + '/customer/remove?id=' + id,
                    method: 'GET',
                    success: function (resp) {
                        loading.hide();
                        if (resp.success) {
                            $scope.list();
                        } else {
                            bootbox.alert(resp.message);
                        }
                    }
                });
            }
        });
    };

    $scope.getLocations();
    $scope.list();
});

app.controller('addCustomer', function ($scope, $uibModalInstance, fileDialog, params) {
    $scope.customer = {
        password: '123456',
        phone: '',
        name: '',
        email: '',
        provinceId: 0,
        districtId: 0,
        address: '',
        activated: 1,
        isPos: 0,
    };
    $scope.districts = params.districts;
    $scope.provinces = params.provinces;
    $scope.formTitle = 'Thêm khách hàng mới';

    $scope.changeProvince = function(){
        if($scope.customer.provinceId != 0){
            angular.forEach($scope.districts, function(value, key) {
                if($scope.districts[key].id != 0 && $scope.customer.provinceId != $scope.districts[key].provinceId)
                    $scope.districts[key].hidden = true;
                else
                    $scope.districts[key].hidden = false;
            });
            $scope.customer.districtId = 0;
        }
    };

    $scope.ok = function () {
        loading.show();
        $.ajax({
            url: baseUrl + '/customer/add',
            data: utils.buildFormData('Customer', $scope.customer),
            method: 'POST',
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    $uibModalInstance.close();
                    params.list();
                } else {
                    $scope.$apply(function () {
                        $scope.errors = resp.data;
                        params.list;
                    });
                    if (resp.message) {
                        $uibModalInstance.close();
                        bootbox.alert(resp.message);
                    }
                }
            }
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('editCustomer', function ($scope, $uibModalInstance, fileDialog, params) {
    $scope.customer = params.customer;
    $scope.districts = params.districts;
    $scope.provinces = params.provinces;
    $scope.formTitle = 'Sửa thông tin khách hàng';

    $scope.changeProvince = function(){
        if($scope.customer.provinceId != 0){
            angular.forEach($scope.districts, function(value, key) {
                if($scope.districts[key].id != 0 && $scope.customer.provinceId != $scope.districts[key].provinceId)
                    $scope.districts[key].hidden = true;
                else
                    $scope.districts[key].hidden = false;
            });
            $scope.customer.districtId = 0;
        }
    };

    $scope.ok = function () {
        loading.show();
        delete $scope.customer.id;
        $.ajax({
            url: baseUrl + '/customer/edit?id=' + params.id,
            data: utils.buildFormData('Customer', $scope.customer),
            method: 'POST',
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    $uibModalInstance.close();
                    params.list();
                } else {
                    $scope.$apply(function () {
                        $scope.errors = resp.data;
                    });
                    if (resp.message) {
                        $uibModalInstance.close();
                        bootbox.alert(resp.message);
                    }
                }
            }
        });
    };
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});