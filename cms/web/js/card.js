app.controller('card', function ($scope, $uibModal, $timeout, $q) {

	$scope.page = 0;
	$scope.activePage = 0;
	$scope.item = 100;
	$scope.cid = '';
	$scope.cname = '';
	$scope.cardId = 0;
	$scope.cards =  [];
	$scope.totalPage = 0;
	$scope.totalItem = 0;

	$scope.list = function () {
		$.ajax({
			url: baseUrl + '/card/list',
			method: 'GET',
			data: {
				page: $scope.page,
				item: $scope.item,
				cid: $scope.cid,
				ccarrier: $scope.ccarrier,
				cprice: $scope.cprice,
				cname: $scope.cname,
			},
			success: function (resp) {
				if (resp.success) {
					$scope.$apply(function () {
						$scope.cards = resp.data.cards;
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
			templateUrl: 'cardForm',
			controller: 'form_card',
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
			url: baseUrl + '/card/get?id=' + id,
			method: 'GET',
			success: function (resp) {
				loading.hide();
				if (resp.success) {
					$uibModal.open({
						animation: true,
						backdrop: 'static',
						templateUrl: 'cardForm',
						controller: 'form_card',
						size: 'lg',
						resolve: {
							params: function () {
								return {
									list: $scope.list,
									card: resp.data
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

	$scope.delete = function (card) {
        bootbox.confirm('Bạn chắc chắn muốn xóa sản phẩm này chứ?', function (confirmed) {
            if (confirmed) {
                loading.show();
                $.ajax({
                    url: baseUrl + '/card/remove?id=' + card,
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

app.controller('form_card', function ($scope, $uibModalInstance, $uibModal, fileDialog, params, $timeout, $q) {
	$scope.card = {};
	$scope.titleForm = 'Thêm mới';
	if(params.card && params.card.id){
		$scope.titleForm = 'Cập nhật';
		$scope.card = params.card;
		
	}

	$scope.ok = function () {
		$scope.cards = JSON.stringify($scope.cards);
		$.ajax({
			url: baseUrl + '/card/save?id='+$scope.card.id,
			method: 'POST',
			data: {
				Card: $scope.card,
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
	};


	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	};
});

app.controller('cards', function ($scope, $uibModalInstance, $uibModal, fileDialog, params, $timeout, $q) {

	$scope.cards = cards;
	for (var i = 0; i < $scope.cards.length; i++) {
		$scope.cards[i].checked = 0;
		for (var j = 0; j < params.cardsChecked.length; j++) {
			if(params.cardsChecked[j] == $scope.cards[i].id){
				$scope.cards[i].checked = 1;
				continue;
			}
		}
	}

	$scope.ok = function() {
		var cids = [];
		for (var i = 0; i < $scope.cards.length; i++) {
			if($scope.cards[i].checked){
				cids = cids.concat($scope.cards[i].id);
			}
		}


		$uibModalInstance.close(cids);  
	};

	$scope.cancel = function() {
		$uibModalInstance.dismiss('cancel');
	};

});
