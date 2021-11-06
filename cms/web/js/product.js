app.controller('product', function ($scope, $uibModal, $timeout, $q) {

	$scope.page = 0;
	$scope.activePage = 0;
	$scope.item = 100;
	$scope.pid = '';
	$scope.pname = '';
	$scope.categoryId = 0;
	$scope.totalPage = 0;
	$scope.totalItem = 0;
	$scope.categories = [{ 'id': 0, 'name': 'Chọn danh mục' }].concat(categories);

	$scope.list = function () {
		$.ajax({
			url: baseUrl + '/product/list',
			method: 'GET',
			data: {
				page: $scope.page,
				item: $scope.item,
				pid: $scope.pid,
				pname: $scope.pname,
				categoryId: $scope.categoryId,
			},
			success: function (resp) {
				if (resp.success) {
					$scope.$apply(function () {
						$scope.products = resp.data.products;
						$scope.totalPage = resp.page_count;
						$scope.totalItem = resp.page_item_count;
						$scope.activePage =  resp.page;
					});
				}
			}
		});
	};
	$scope.list();

	$scope.add = function () {
		$uibModal.open({
			animation: true,
			backdrop: 'static',
			templateUrl: 'productForm',
			controller: 'form_product',
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
			url: baseUrl + '/product/get?id=' + id,
			method: 'GET',
			success: function (resp) {
				loading.hide();
				if (resp.success) {
					$uibModal.open({
						animation: true,
						backdrop: 'static',
						templateUrl: 'productForm',
						controller: 'form_product',
						size: 'lg',
						resolve: {
							params: function () {
								return {
									list: $scope.list,
									product: resp.data
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

	$scope.delete = function (product) {
        bootbox.confirm('Bạn chắc chắn muốn xóa sản phẩm này chứ?', function (confirmed) {
            if (confirmed) {
                loading.show();
                $.ajax({
                    url: baseUrl + '/product/remove?id=' + product,
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

});



app.controller('form_product', function ($scope, $uibModalInstance, $uibModal, fileDialog, params, $timeout, $q) {
	$scope.product = {};

	$scope.product.categoryId = 0;
	$scope.product.categories = [];
	$scope.categories = categories;
	$scope.categories = [{ 'id': 0, 'name': 'Chọn danh mục' }].concat($scope.categories);
	$scope.titleForm = 'Thêm mới';
	if(params.product && params.product.id){
		$scope.titleForm = 'Cập nhật';
		$scope.product = params.product;
		$scope.product.categories = JSON.parse($scope.product.categories);
		$scope.product.status = $scope.product.status*1
		$scope.product.categoryId = $scope.product.categoryId*1
	}
	$scope.category = function () {
		$uibModal.open({
			animation: true,
			backdrop: 'static',
			templateUrl: 'categorieForm',
			controller: 'categories',
			size: 'lg',
			resolve: {
				params: function () {
					return {
						categoriesChecked: $scope.product.categories, 
					}
				}
			}
		}).result.then(function(result) {
			$scope.product.categories = result;
		});
	};


	$scope.upload = function() {
		$scope.loadingFile = true;
		fileDialog.openFile(function (files) {
			var uploads = new FormData();
			uploads.append("file", files[0]);
			uploads.append("minisize", true);
			uploads.append("width", 320);
			uploads.append("height", 270);
			uploads.append("resize", 2);
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
							$scope.product.image = resp.data;
							$scope.product.thumbnail = resp.thumb;
						});
					}
					if(resp.message){
						bootbox.alert(resp.message);
					}
				}
			});
		});
	}

	$scope.ok = function () {
		$scope.product.categories = JSON.stringify($scope.product.categories);
		$.ajax({
			url: baseUrl + '/product/save?id='+$scope.product.id,
			method: 'POST',
			data: {
				Product: $scope.product,
			},
			success: function (resp) {
				if (resp.success) {
					$scope.$apply(function () {
						$uibModalInstance.close();
						params.list();
					});
				}else{
					$scope.$apply(function () {
						$scope.errors = resp.data;
					});
				}
				if(resp.message){
					bootbox.alert(resp.message);
				}
			}
		});
		$scope.product.categories = JSON.parse($scope.product.categories);
	};


	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	};
});

app.controller('categories', function ($scope, $uibModalInstance, $uibModal, fileDialog, params, $timeout, $q) {

	$scope.categories = categories;
	for (var i = 0; i < $scope.categories.length; i++) {
		$scope.categories[i].checked = 0;
		for (var j = 0; j < params.categoriesChecked.length; j++) {
			if(params.categoriesChecked[j] == $scope.categories[i].id){
				$scope.categories[i].checked = 1;
				continue;
			}
		}
	}

	$scope.ok = function() {
		var cids = [];
		for (var i = 0; i < $scope.categories.length; i++) {
			if($scope.categories[i].checked){
				cids = cids.concat($scope.categories[i].id);
			}
		}


		$uibModalInstance.close(cids);  
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	};
});
