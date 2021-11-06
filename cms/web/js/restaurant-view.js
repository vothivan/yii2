app.controller('restaurant-view', function ($scope, $uibModal, fileDialog ) {
	$scope.images = images;

 
	$scope.inputDataImage = function() {
		$scope.loadingFile = true;
		fileDialog.openFile(function (files) {
			var uploads = new FormData();
			uploads.append("file", files[0]);
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
							var newImg = {
								name: '',
								url: frontendUrl + resp.data,
								thumb: frontendUrl + resp.thumb,
							};
							$scope.images = $scope.images.concat([newImg]);
						});
					}
					if(resp.message){
						bootbox.alert(resp.message);
					}
				}
			});
		});
	};

	$scope.removeBanner = function (k) {
        $scope.images.splice(k, 1);
    };

	$scope.update = function(){
		loading.show();
		var dataPost = angular.copy($scope.images);
		$.ajax({
			url: baseUrl + '/restaurant-view/update',
			data: {
				data: JSON.stringify(dataPost)
			},
			method: 'POST',
			success: function (resp) {
				loading.hide();
				if (resp.success) {
					$scope.$apply(function () {
						bootbox.alert('Cập nhật thành công!');
					});
				}
				if(resp.message){

				}
			}
		});
	};
});