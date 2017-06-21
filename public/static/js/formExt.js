/*****************************************************************
 form表单获取值封装类
 *****************************************************************/
(function ($) {
    window.formExt = new Object();
    formExt.obj = function (form) {
        var data = {};
        var form = $(form).serializeArray();
        $.each(form, function () {
            if (data[this.name] !== undefined) {
                if (!data[this.name].push) {
                    data[this.name] = [data[this.name]];
                }
                data[this.name].push(this.value || '');
            } else {
                data[this.name] = this.value || '';
            }
        });
        return data;
    }
})(jQuery);

(function ($) {
    window.ajaxExt = new Object();
    ajaxExt.post = function (url, data, func) {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            //contentType: false,
            //processData: false,
            success: function (result) {
                console.log("请求成功，JSON解析后的响应数据为:", result);
                func(result);
            },
            error: function (xhr, type) {
                //alert('Ajax error!')
                $.toast("操作失败，请稍后再试", 'cancel');
            }
        });
    }
    ajaxExt.get = function (url, func) {
        $.ajax({
            url: url,
            type: 'GET',
            //data: data,
            //contentType: false,
            //processData: false,
            success: function (result) {
                func(result);
            },
            error: function (xhr, type) {
                $.toast("获取数据失败", 'cancel');
            }
        });
    }
})(jQuery);
(function ($) {
    window.AuthExt = new Object();
    AuthExt.login = function () {
        console.log('登录判断')
        $.login({
            title: '登陆',
            //text: '请输入用户名和密码',
            username: '',  // 默认用户名
            password: '',  // 默认密码
            onOK: function (username, password) {
                //点击确认
                //请求登录认证
                ajaxExt.post('/auth/login', {username: username, password: password}, function (data) {
                    var result = data.result;
                    if (!data.success) {
                        AuthExt.login();
                        $.toptip('账号密码错误', 'error');
                    } else {
                        $.cookie('jwt-token', data.result.token, {expires: 7, path: '/'});
                        console.log(data)
                    }
                })
                console.log(username, password)
            },
            onCancel: function () {
                //点击取消
            }
        });
    }
    AuthExt.check = function () {
        console.log('登录验证');
        var token = $.cookie('jwt-token');
        if (!token) {
            AuthExt.login()
        } else {
            // if (func == undefined) {
            //
            // }else {
            //     func();
            // }
            return true;
        }
    }
})(jQuery);

