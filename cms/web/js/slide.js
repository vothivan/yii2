app.controller('slide_postmart', function ($scope, $uibModal) {
    
    $scope.slides = [];
    $scope.list = function () {
        $.ajax({
            url: baseUrl + '/slide/list',
            data: {page: $scope.page,type: type},
            method: 'GET',
            success: function (resp) {
                if (resp.success) {
                    $scope.$apply(function () {
                        $scope.slides = resp.data;
                        angular.forEach($scope.slides, function (value, key) {
                            if ($scope.slides[key].image) {
                                var imageUrl = imboClient.getImageUrl($scope.slides[key].image);
                                $scope.slides[key].image = imageUrl.maxSize({
                                    width: 140,
                                    height: 120
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
            templateUrl: 'slideForm',
            controller: 'editslide',
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
            url: baseUrl + '/slide/get?id=' + id,
            method: 'GET',
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    $uibModal.open({
                        animation: true,
                        backdrop: 'static',
                        templateUrl: 'slideForm',
                        controller: 'editslide',
                        size: 'lg',
                        resolve: {
                            params: function () {
                                return {
                                    slide: resp.data,
                                    id: id,
                                    list: $scope.list,
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
        bootbox.confirm('Bạn chắc chắn muốn xóa slide này chứ?', function (confirmed) {
            if (confirmed) {
                loading.show();
                $.ajax({
                    url: baseUrl + '/slide/remove?id=' + id,
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


app.controller('editslide', function ($scope, $uibModalInstance, fileDialog, params) {
    $scope.slide = params.slide;
    $scope.formTitle = 'Thêm slide';
    if(params.id){
        $scope.formTitle = 'Sửa slide';
    }
    else{
        $scope.slide = {
            position: 0
        };
    }

    $scope.slideThumb = function (image) {
        console.log(image);
        var imageUrl = imboClient.getImageUrl(image);
        return imageUrl.maxSize({
            width: 140,
            height: 120
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
                        $scope.slide.image = imageIdentifier;
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
        $scope.slide.slides = JSON.stringify($scope.slide.slides);
        $scope.slide.urls = JSON.stringify($scope.slide.urls);
        $scope.slide.type = type;
        $.ajax({
            url: baseUrl + '/slide/edit?id=' + params.id,
            data: utils.buildFormData('Slide', $scope.slide),
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
