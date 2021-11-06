app.controller('banner', function ($scope, $uibModal) {
    $scope.positions = [
        { 'id' : 0, 'name' : 'Chọn'},
        { 'id' : 1, 'name' : 'Banner Trái'},
        { 'id' : 2, 'name' : 'Banner Phải' },
        { 'id' : 3, 'name' : 'Banner Trên' },
        { 'id' : 4, 'name' : 'Banner Dưới 1' },
        { 'id' : 5, 'name' : 'Banner Dưới 2' },
        { 'id' : 6, 'name' : 'Banner Thực phẩm cao cấp' },
        { 'id' : 7, 'name' : 'Banner đồ dùng gia đình 1' },
        { 'id' : 8, 'name' : 'Banner đồ dùng gia đình 2' },
        { 'id' : 9, 'name' : 'Banner đồ dùng gia đình 3' },
        { 'id' : 10, 'name' : 'Banner đồ dùng gia đình 4' },
        { 'id' : 11, 'name' : 'Banner đồ dùng gia đình 5' },
        { 'id' : 12, 'name' : 'Banner đồ dùng gia đình 6' },
        // { 'id' : 13, 'name' : 'Banner menu danh mục trang chủ' },
        { 'id' : 14, 'name' : 'Banner bên trái slide 1 - postmart mall' },
        { 'id' : 15, 'name' : 'Banner bên trái slide 2 - postmart mall' },
    ];

    $scope.getPosition = function(position){        
        rs = $scope.positions.filter(function(e){
            return e.id == position;
        });
        if(rs.length == 0)
            return 'Không rõ';
        return rs[0].name;
    }

    $scope.list = function () {
        $.ajax({
            url: baseUrl + '/banner/list',
            data: {page: $scope.page},
            method: 'GET',
            success: function (resp) {
                if (resp.success) {
                    $scope.$apply(function () {
                        $scope.banners = resp.data;
                        angular.forEach($scope.banners, function (value, key) {
                            if ($scope.banners[key].image) {
                                var imageUrl = imboClient.getImageUrl($scope.banners[key].image);
                                $scope.banners[key].image = imageUrl.maxSize({
                                    width: 350,
                                    height: 350
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
            templateUrl: 'bannerForm',
            controller: 'editbanner',
            size: 'lg',
            resolve: {
                params: function () {
                    return {
                        list: $scope.list,
                        positions: $scope.positions
                    }
                }
            }
        });
    };

    $scope.edit = function (id) {
        loading.show();
        $.ajax({
            url: baseUrl + '/banner/get?id=' + id,
            method: 'GET',
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    $uibModal.open({
                        animation: true,
                        backdrop: 'static',
                        templateUrl: 'bannerForm',
                        controller: 'editbanner',
                        size: 'lg',
                        resolve: {
                            params: function () {
                                return {
                                    banner: resp.data,
                                    id: id,
                                    list: $scope.list,
                                    positions: $scope.positions
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
        bootbox.confirm('Bạn chắc chắn muốn xóa banner này chứ?', function (confirmed) {
            if (confirmed) {
                loading.show();
                $.ajax({
                    url: baseUrl + '/banner/remove?id=' + id,
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


app.controller('editbanner', function ($scope, $uibModalInstance, fileDialog, params) {
    $scope.banner = params.banner;
    $scope.positions = params.positions;

    $scope.formTitle = 'Thêm banner';
    if(params.id){
        $scope.formTitle = 'Sửa banner';
    }
    else{
        $scope.banner = {
            position: 0
        };
    }

    $scope.bannerThumb = function (image) {
        console.log(image);
        var imageUrl = imboClient.getImageUrl(image);
        return imageUrl.maxSize({
            width: 210,
            height: 210
        }).compress({level: 100}).toString();
    };

    $scope.inputImage = function () {
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
                            width: 350,
                            height: 350
                        }).compress({level: 100}).toString();
                        $scope.banner.image = imageIdentifier;
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

    $scope.ok = function () {
        loading.show();
        $scope.banner.banners = JSON.stringify($scope.banner.banners);
        $scope.banner.urls = JSON.stringify($scope.banner.urls);
        $.ajax({
            url: baseUrl + '/banner/edit?id=' + params.id,
            data: utils.buildFormData('Banner', $scope.banner),
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