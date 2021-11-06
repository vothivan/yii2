// <<<<<<< HEAD
var app = angular.module('app', [
    'ui.bootstrap', 
    'textAngular', 
    'fileDialog', 
    'angularMoment', 
    'chart.js', 
    // 'as.sortable', 
    'ng-sortable',
    'colorpicker.module', 
    'toggle-switch', 
    'AxelSoft', 
    'ui.bootstrap.datetimepicker'
    ]);
// var app = angular.module('app', ['ui.bootstrap', 'textAngular', 'fileDialog', 'angularMoment', 'chart.js', 'as.sortable', 'colorpicker.module', 'toggle-switch', 'AxelSoft', 'ui.bootstrap.datetimepicker','angularSpectrumColorpicker','ui.bootstrap.dropdownToggle']);


app.config(function($provide){
    $provide.decorator('taOptions', ['taRegisterTool', '$delegate', function(taRegisterTool, taOptions){
        // $delegate is the taOptions we are decorating
        // register the tool with textAngular

        taRegisterTool('backgroundColor', {
            display: "<div spectrum-colorpicker ng-model='color' on-change='!!color && action(color)' format='\"hex\"' options='options'></div>",
            action: function (color) {
                var me = this;
                if (!this.$editor().wrapSelection) {
                    setTimeout(function () {
                        me.action(color);
                    }, 100)
                } else {
                    return this.$editor().wrapSelection('backColor', color);
                }
            },
            options: {
                replacerClassName: 'fa fa-paint-brush', showButtons: false
            },
            color: "#fff"
        });
        taRegisterTool('fontColor', {
            display:"<spectrum-colorpicker trigger-id='{{trigger}}' ng-model='color' on-change='!!color && action(color)' format='\"hex\"' options='options'></spectrum-colorpicker>",
            action: function (color) {
                var me = this;
                if (!this.$editor().wrapSelection) {
                    setTimeout(function () {
                        me.action(color);
                    }, 100)
                } else {
                    return this.$editor().wrapSelection('foreColor', color);
                }
            },
            options: {
                replacerClassName: 'fa fa-font', showButtons: false
            },
            color: "#000"
        });


        taRegisterTool('fontName', {
            display: "<span class='bar-btn-dropdown dropdown'>" +
            "<button class='btn btn-blue dropdown-toggle' type='button' ng-disabled='showHtml()' style='padding-top: 4px'><i class='fa fa-font'></i><i class='fa fa-caret-down'></i></button>" +
            "<ul class='dropdown-menu'><li ng-repeat='o in options'><button class='btn btn-blue checked-dropdown' style='font-family: {{o.css}}; width: 100%' type='button' ng-click='action($event, o.css)'><i ng-if='o.active' class='fa fa-check'></i>{{o.name}}</button></li></ul></span>",
            action: function (event, font) {
                //Ask if event is really an event.
                if (!!event.stopPropagation) {
                    //With this, you stop the event of textAngular.
                    event.stopPropagation();
                    //Then click in the body to close the dropdown.
                    $("body").trigger("click");
                }
                return this.$editor().wrapSelection('fontName', font);
            },
            options: [
                { name: 'Sans-Serif', css: 'Arial, Helvetica, sans-serif' },
                { name: 'Serif', css: "'times new roman', serif" },
                { name: 'Wide', css: "'arial black', sans-serif" },
                { name: 'Narrow', css: "'arial narrow', sans-serif" },
                { name: 'Comic Sans MS', css: "'comic sans ms', sans-serif" },
                { name: 'Courier New', css: "'courier new', monospace" },
                { name: 'Garamond', css: 'garamond, serif' },
                { name: 'Georgia', css: 'georgia, serif' },
                { name: 'Tahoma', css: 'tahoma, sans-serif' },
                { name: 'Trebuchet MS', css: "'trebuchet ms', sans-serif" },
                { name: "Helvetica", css: "'Helvetica Neue', Helvetica, Arial, sans-serif" },
                { name: 'Verdana', css: 'verdana, sans-serif' },
                { name: 'Proxima Nova', css: 'proxima_nova_rgregular' }
            ]
        });


        taRegisterTool('fontSize', {
            display: "<span class='bar-btn-dropdown dropdown'>" +
            "<button class='btn btn-blue dropdown-toggle' type='button' ng-disabled='showHtml()' style='padding-top: 4px'><i class='fa fa-text-height'></i><i class='fa fa-caret-down'></i></button>" +
            "<ul class='dropdown-menu'><li ng-repeat='o in options'><button class='btn btn-blue checked-dropdown' style='font-size: {{o.css}}; width: 100%' type='button' ng-click='action($event, o.value)'><i ng-if='o.active' class='fa fa-check'></i> {{o.name}}</button></li></ul>" +
            "</span>",
            action: function (event, size) {
                //Ask if event is really an event.
                if (!!event.stopPropagation) {
                    //With this, you stop the event of textAngular.
                    event.stopPropagation();
                    //Then click in the body to close the dropdown.
                    $("body").trigger("click");
                }
                return this.$editor().wrapSelection('fontSize', parseInt(size));
            },
            options: [
                { name: 'xx-small', css: 'xx-small', value: 1 },
                { name: 'x-small', css: 'x-small', value: 2 },
                { name: 'small', css: 'small', value: 3 },
                { name: 'medium', css: 'medium', value: 4 },
                { name: 'large', css: 'large', value: 5 },
                { name: 'x-large', css: 'x-large', value: 6 },
                { name: 'xx-large', css: 'xx-large', value: 7 }

            ]
        });


        // add the button to the default toolbar definition
        taOptions.toolbar[1].push('backgroundColor','fontColor','fontName','fontSize');
        return taOptions;
    }]);
});

app.service('location', function ($uibModal) {
    this.getPos = function () {
        $.ajax({
            url: baseUrl + '/warehouse/searchmerchant',
            method: 'GET',
            data: {
                param: term,
            },
            success: function (resp) {
                loading.hide();
                if (resp.success) {
                    resp.data.splice(0, 0, {id: 0, name: 'Chọn bưu điện tỉnh'});
                    result = resp.data;
                    deferred.resolve(result);
                } else {
                    bootbox.alert(resp.message);
                }
            }
        });
    }

});

$.ajaxSetup({
    dataType: 'json',
    error: function (xhr, status, error) {
        loading.hide();
        if (xhr.status == 403) {
            bootbox.alert('Bạn không có quyền thực hiện hành động này');
        } else {
            bootbox.alert(error);
        }
    }
});

var loading = {};

loading.show = function () {
    if ($('#loading').length <= 0) {
        $('body').append('<div id="loading" style="display:none;" class="loading"></div>');
    }
    $('#loading').show();
};

loading.hide = function () {
    $('#loading').hide();
};

yii.confirm = function (message, ok, cancel) {
    bootbox.confirm(
        {
            message: message,
            callback: function (confirmed) {
                if (confirmed) {
                    !ok || ok();
                } else {
                    !cancel || cancel();
                }
            }
        }
    );
    return false;
};

$(document).ready(function () {
    setInterval(function () {
        $.ajax({
            url: baseUrl + '/site/ping',
            method: 'GET',
            success: function (resp) {
            }
        });
    }, 60000);
});

















app.service('modal', function ($uibModal) {
    this.alert = function (message) {
        $uibModal.open({
            animation: true,
            templateUrl: 'alertModal',
            controller: 'alert',
            resolve: {
                params: function () {
                    return {
                        message: message
                    }
                }
            }
        });
    };

    this.alertHtml = function (message) {
        $uibModal.open({
            animation: true,
            templateUrl: 'alertHtmlModal',
            controller: 'alertHtml',
            resolve: {
                params: function () {
                    return {
                        message: message
                    }
                }
            }
        });
    };
});

app.controller('alert', function ($scope, $uibModalInstance, params) {
    $scope.message = params.message;
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});

app.controller('alertHtml', function ($scope, $uibModalInstance, params) {
    $scope.message = params.message;
    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };
});