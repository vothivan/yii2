app.controller('news', function ($scope, $uibModal, $timeout, $q) {

	$scope.page = 0;
	$scope.activePage = 0;
	$scope.item = 100;
	$scope.pid = '';
	$scope.pname = '';
	$scope.categoryId = 0;
	$scope.totalPage = 0;
	$scope.totalItem = 0;
	$scope.categories = [{ 'id': 0, 'name': 'Chọn danh mục' }].concat(categories);;

	$scope.list = function () {
		$.ajax({
			url: baseUrl + '/news/list',
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
						$scope.news = resp.data.news;
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
			templateUrl: 'newsForm',
			controller: 'form_news',
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
			url: baseUrl + '/news/get?id=' + id,
			method: 'GET',
			success: function (resp) {
				loading.hide();
				if (resp.success) {
					$uibModal.open({
						animation: true,
						backdrop: 'static',
						templateUrl: 'newsForm',
						controller: 'form_news',
						size: 'lg',
						resolve: {
							params: function () {
								return {
									list: $scope.list,
									news: resp.data
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

	$scope.delete = function (id) {
        bootbox.confirm('Bạn chắc chắn muốn xóa bài viết này chứ?', function (confirmed) {
            if (confirmed) {
                loading.show();
                $.ajax({
                    url: baseUrl + '/news/remove?id=' + id,
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

app.controller('form_news', function ($scope, $uibModalInstance, $uibModal, fileDialog, params, $timeout, $q) {
	$scope.news = {};

	$scope.news.categoryId = 0;
	$scope.news.categories = [];
	$scope.categories = categories;
	$scope.categories = [{ 'id': 0, 'name': 'Chọn danh mục' }].concat($scope.categories);
	$scope.titleForm = 'Thêm mới';
	if(params.news && params.news.id){
		$scope.titleForm = 'Cập nhật';
		$scope.news = params.news;
		$scope.news.categories = JSON.parse($scope.news.categories);
		$scope.news.status = $scope.news.status*1
		$scope.news.categoryId = $scope.news.categoryId*1
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
						categoriesChecked: $scope.news.categories, 
					}
				}
			}
		}).result.then(function(result) {
			$scope.news.categories = result;
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
							$scope.news.image = resp.data;
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
		$scope.news.categories = JSON.stringify($scope.news.categories);
		$.ajax({
			url: baseUrl + '/news/save?id='+$scope.news.id,
			method: 'POST',
			data: {
				News: $scope.news,
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
		$scope.news.categories = JSON.parse($scope.news.categories);
	};
	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	};
});
