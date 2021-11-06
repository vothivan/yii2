app.controller('box', function ($scope, $uibModal) {
	$scope.list = function () {
		$.ajax({
			url: baseUrl + '/box/list',
			data: {page: $scope.page},
			method: 'GET',
			success: function (resp) {
				if (resp.success) {
					$scope.$apply(function () {
						$scope.boxs = resp.data.boxs;
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
			controller: 'box_form',
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

	$scope.edit = function (box) {
		$uibModal.open({
			animation: true,
			backdrop: 'static',
			templateUrl: 'boxForm',
			controller: 'box_form',
			size: 'lg',
			resolve: {
				params: function () {
					return {
						list: $scope.list,
						box: box
					}
				}
			}
		});
	};

	$scope.changeBanner = function (banner) {
		$uibModal.open({
			animation: true,
			backdrop: 'static',
			templateUrl: 'bannerForm',
			controller: 'banner_form',
			size: 'lg',
			resolve: {
				params: function () {
					return {
						banner: banner,
					}
				}
			}
		});
	};

	$scope.remove = function (p) {
		bootbox.confirm('Bạn chắc chắn muốn xóa sản phẩm này chứ?', function (confirmed) {
			if (confirmed) {
				loading.show();
				$.ajax({
					url: baseUrl + '/box/remove?id=' + p.id,
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


app.controller('box_form', function ($scope, $uibModal,$uibModalInstance, fileDialog, $timeout, $q, params) {
	
	$scope.box = {
		productId: '',
		endTime: '',
		position: '',
		status: 1,
	};
	$scope.titleForm = 'Thêm mới';

	if(params.box && params.box.id){
		$scope.titleForm = 'Cập nhật';
		$scope.box = params.box;
		$scope.box.status = $scope.box.status*1;
		$scope.box.endTime = $scope.box.endTime*1000;
	}

	$scope.ok = function(){
		var postdata = angular.copy($scope.box);
        if(postdata.endTime == null){
            bootbox.alert("Thời gian kết thúc chưa được chọn!");
            return;
        }
        postdata.endTime = typeof postdata.endTime === 'number' ? postdata.endTime / 1000 : parseInt(postdata.endTime.getTime() / 1000);

		loading.show();
		$.ajax({
			url: baseUrl + '/box/save?id='+$scope.box.id,
			method: 'POST',
			data: {
				BoxPromotion: postdata,
			},
			success: function (resp) {
				loading.hide();
				if (resp.success) {
					$scope.$apply(function () {
						$uibModalInstance.close();
						params.list();
					});
				} else {
					$scope.$apply(function () {
						$scope.errors = resp.data;
					});
				}
				if(resp.message){
					bootbox.alert(resp.message);
				}
			}
		});
	};

	$scope.endTime = function () {
        $scope.endTimePopup.opened = true;
    };
    $scope.endTimePopup = {
        opened: false
    };

	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	};
});



app.controller('banner_form', function ($scope, $uibModal,$uibModalInstance, fileDialog, $timeout, $q, params) {
	
	$scope.banner = params.banner;
	$scope.titleForm = 'Thay đổi';

	$scope.ok = function(){
		loading.show();
		$.ajax({
			url: baseUrl + '/banner/save?id='+$scope.banner.id,
			method: 'POST',
			data: {
				Banner: $scope.banner,
			},
			success: function (resp) {
				loading.hide();
				if (resp.success) {
					$scope.$apply(function () {
						location.reload();
					});
				} else {
					$scope.$apply(function () {
						$scope.errors = resp.data;
					});
				}
				if(resp.message){
					bootbox.alert(resp.message);
				}
			}
		});
	};

	$scope.upload = function() {
		$scope.loadingFile = true;
		fileDialog.openFile(function (files) {
			var uploads = new FormData();
			uploads.append("file", files[0]);
			$.ajax({
				url: frontendUrl + 'site/upload',
				data: uploads,
				method: 'POST',
				processData: false,
				contentType: false,
				success: function (resp) {
					$scope.loadingFile = false;
					if (resp.success) {
						$scope.$apply(function () {
							$scope.banner.image = resp.data;
						});
					}
					if(resp.message){
						bootbox.alert(resp.message);
					}
				}
			});
		});
	}

	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	};
});