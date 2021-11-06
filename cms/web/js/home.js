app.controller('home', function ($scope, $uibModal) {
    $scope.list = function () {
        $.ajax({
            url: baseUrl + '/home/list',
            data: {page: $scope.page},
            method: 'GET',
            success: function (resp) {
                if (resp.success) {
                    $scope.$apply(function () {
                        $scope.boxes = resp.data;
                        angular.forEach($scope.boxes, function (value, key) {
                            if ($scope.boxes[key].icon) {
                                var imageUrl = imboClient.getImageUrl($scope.boxes[key].icon);
                                $scope.boxes[key].icon = imageUrl.maxSize({
                                    width: 100,
                                    height: 100
                                }).compress({level: 100}).toString();
                                var imageUrl = imboClient.getImageUrl($scope.boxes[key].banner);
                                $scope.boxes[key].banner = imageUrl.maxSize({
                                    width: 100,
                                    height: 100
                                }).compress({level: 100}).toString();
                            }
                        });
                    });
                }
            }
        });
    };

    $scope.add = function () {
        $uibModal.open({
            animation: true,
            backdrop: 'static',
            templateUrl: 'boxForm',
            controller: 'addBox',
            size: 'lg',
            resolve: {
                params: function () {
                    return {
                        list: $scope.list
                    }
                }
            }
        });
    };

    $scope.edit = function (id) {
        loading.show();
        $.ajax({
            url: baseUrl + '/home/get?id=' + id,
            method: 'GET',
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    $uibModal.open({
                        animation: true,
                        backdrop: 'static',
                        templateUrl: 'boxForm',
                        controller: 'editBox',
                        size: 'lg',
                        resolve: {
                            params: function () {
                                return {
                                    list: $scope.list,
                                    box: resp.data,
                                    id: id
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
        bootbox.confirm('Bạn chắc chắn muốn xóa box này chứ?', function (confirmed) {
            if (confirmed) {
                loading.show();
                $.ajax({
                    url: baseUrl + '/home/remove?id=' + id,
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

    $scope.list();
});

app.controller('addBox', function ($scope, $uibModalInstance, fileDialog, params, $timeout, $q) {
    $scope.box = {
        position: 1,
        products: [],
        activated: 1
    };
    $scope.newProduct = {};
    $scope.formTitle = 'Thêm box mới';

    $scope.searchAsync = function (term) {
        var deferred = $q.defer();
        var result = [];
        var ids = [];
        if($scope.box.products){
            angular.forEach($scope.box.products, function(v, k){
                ids[k] = v.id;
            });
        }
        $timeout(function () {
            $.ajax({
                url: baseUrl + '/home/searchproduct',
                method: 'GET',
                data: {
                    param: term,
                    ids: JSON.stringify(ids)
                },
                success: function (resp) {
                    loading.hide();
                    if (resp.success) {
                        result = resp.data;
                        deferred.resolve(result);
                    } else {
                        bootbox.alert(resp.message);
                    }
                }
            });
        }, 300);
        return deferred.promise;
    };

    $scope.thumb = function (image) {
        var imageUrl = imboClient.getImageUrl(image);
        return imageUrl.maxSize({
            width: 80,
            height: 50
        }).compress({level: 100}).toString();
    };

    $scope.inputIcon = function () {
        fileDialog.openFile(function (files) {
            imboClient.addImage(files[0], {
                onComplete: function (err, imageIdentifier, res) {
                    if (err && res && res.headers && res.headers['X-Imbo-Error-Internalcode'] !== 200) {
                        return bootbox.alert(err);
                    } else if (err) {
                        return bootbox.alert(err);
                    }
                    $scope.$apply(function () {
                        $scope.iconLoading = 0;
                        var imageUrl = imboClient.getImageUrl(imageIdentifier);
                        $scope.thumbIcon = imageUrl.maxSize({
                            width: 50,
                            height: 50
                        }).compress({level: 100}).toString();
                        $scope.box.icon = imageIdentifier;
                    });
                },
                onProgress: function (e) {
                    if (!e.lengthComputable) {
                        return;
                    }
                    $scope.$apply(function () {
                        $scope.iconLoading = parseInt((e.loaded / e.total) * 100)
                        $scope.thumbIcon = '';
                    });
                }
            });
        }, false);
    };

    $scope.inputBanner = function () {
        fileDialog.openFile(function (files) {
            imboClient.addImage(files[0], {
                onComplete: function (err, imageIdentifier, res) {
                    if (err && res && res.headers && res.headers['X-Imbo-Error-Internalcode'] !== 200) {
                        return bootbox.alert(err);
                    } else if (err) {
                        return bootbox.alert(err);
                    }
                    $scope.$apply(function () {
                        $scope.bannerLoading = 0;
                        var imageUrl = imboClient.getImageUrl(imageIdentifier);
                        $scope.thumbBanner = imageUrl.maxSize({
                            width: 80,
                            height: 50
                        }).compress({level: 100}).toString();
                        $scope.box.banner = imageIdentifier;
                    });
                },
                onProgress: function (e) {
                    if (!e.lengthComputable) {
                        return;
                    }
                    $scope.$apply(function () {
                        $scope.bannerLoading = parseInt((e.loaded / e.total) * 100)
                        $scope.thumbBanner = '';
                    });
                }
            });
        }, false);
    };

    $scope.addProduct = function () {
        if (!$scope.newProduct.id) {
            $scope.newProduct.error = 'Bạn chưa chọn sản phẩm';
        } else {
            $scope.box.products.push($scope.newProduct);
            $scope.newProduct = null;
        }
    };

    $scope.removeProduct = function (name) {
        for (var i = 0; i < $scope.box.products.length; i++) {
            if ($scope.box.products[i].name == name) {
                $scope.box.products.splice(i, 1);
            }
        }
    };

    $scope.ok = function () {
        loading.show();
        $.ajax({
            url: baseUrl + '/home/add',
            data: utils.buildFormData('Homebox', $scope.box),
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

app.controller('editBox', function ($scope, $uibModalInstance, fileDialog, params, $timeout, $q) {
    $scope.box = params.box;
    $scope.newProduct = {};

    $scope.formTitle = 'Sửa box';
    if ($scope.box.products == '') {
        $scope.box.products = [];
    } else {
        $scope.box.products = JSON.parse($scope.box.products);
    }

    var imageUrl = imboClient.getImageUrl($scope.box.icon);
    $scope.thumbIcon = imageUrl.maxSize({width: 50, height: 50}).compress({level: 100}).toString();
    var imageUrl = imboClient.getImageUrl($scope.box.banner);
    $scope.thumbBanner = imageUrl.maxSize({width: 50, height: 50}).compress({level: 100}).toString();
    $scope.thumb = function (image) {
        var imageUrl = imboClient.getImageUrl(image);
        return imageUrl.maxSize({
            width: 80,
            height: 50
        }).compress({level: 100}).toString();
    };

    $scope.searchAsync = function (term) {
        var deferred = $q.defer();
        var result = [];
        var ids = [];
        if($scope.box.products){
            angular.forEach($scope.box.products, function(v, k){
                ids[k] = v.id;
            });
        }
        $timeout(function () {
            $.ajax({
                url: baseUrl + '/home/searchproduct',
                method: 'GET',
                data: {
                    param: term,
                    ids: JSON.stringify(ids)
                },
                success: function (resp) {
                    loading.hide();
                    if (resp.success) {
                        result = resp.data;
                        deferred.resolve(result);
                    } else {
                        bootbox.alert(resp.message);
                    }
                }
            });
        }, 300);
        return deferred.promise;
    };

    $scope.inputIcon = function () {
        fileDialog.openFile(function (files) {
            imboClient.addImage(files[0], {
                onComplete: function (err, imageIdentifier, res) {
                    if (err && res && res.headers && res.headers['X-Imbo-Error-Internalcode'] !== 200) {
                        return bootbox.alert(err);
                    } else if (err) {
                        return bootbox.alert(err);
                    }
                    $scope.$apply(function () {
                        $scope.iconLoading = 0;
                        var imageUrl = imboClient.getImageUrl(imageIdentifier);
                        $scope.thumbIcon = imageUrl.maxSize({
                            width: 50,
                            height: 50
                        }).compress({level: 100}).toString();
                        $scope.box.icon = imageIdentifier;
                    });
                },
                onProgress: function (e) {
                    if (!e.lengthComputable) {
                        return;
                    }
                    $scope.$apply(function () {
                        $scope.iconLoading = parseInt((e.loaded / e.total) * 100)
                        $scope.thumbIcon = '';
                    });
                }
            });
        }, false);
    };

    $scope.inputBanner = function () {
        fileDialog.openFile(function (files) {
            imboClient.addImage(files[0], {
                onComplete: function (err, imageIdentifier, res) {
                    if (err && res && res.headers && res.headers['X-Imbo-Error-Internalcode'] !== 200) {
                        return bootbox.alert(err);
                    } else if (err) {
                        return bootbox.alert(err);
                    }
                    $scope.$apply(function () {
                        $scope.bannerLoading = 0;
                        var imageUrl = imboClient.getImageUrl(imageIdentifier);
                        $scope.thumbBanner = imageUrl.maxSize({
                            width: 80,
                            height: 50
                        }).compress({level: 100}).toString();
                        $scope.box.banner = imageIdentifier;
                    });
                },
                onProgress: function (e) {
                    if (!e.lengthComputable) {
                        return;
                    }
                    $scope.$apply(function () {
                        $scope.bannerLoading = parseInt((e.loaded / e.total) * 100)
                        $scope.thumbBanner = '';
                    });
                }
            });
        }, false);
    };

    $scope.addProduct = function () {
        if (!$scope.newProduct.id) {
            $scope.newProduct.error = 'Bạn chưa chọn sản phẩm';
        } else {
            angular.forEach($scope.box.products, function(v, k){
                if(v.id == $scope.newProduct.id){
                    $scope.newProduct.error = 'Sản phẩm đã được chọn';
                }
            });
            if(!$scope.newProduct.error){
                $scope.box.products.push($scope.newProduct);
                $scope.newProduct = null;
            }
        }
    };

    $scope.removeProduct = function (name) {
        for (var i = 0; i < $scope.box.products.length; i++) {
            if ($scope.box.products[i].name == name) {
                $scope.box.products.splice(i, 1);
            }
        }
    };

    $scope.ok = function () {
        loading.show();
        $.ajax({
            url: baseUrl + '/home/edit?id=' + params.id,
            data: utils.buildFormData('Homebox', $scope.box),
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
