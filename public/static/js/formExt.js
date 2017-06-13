/*****************************************************************
 form表单获取值封装类
 *****************************************************************/
(function($){
    formExt = new Object();

    /**
     * 获取form值
     * @param form form对象 如 $('#form_id')
     * 如：{Name:'摘取天上星',position:'IT技术'}
     * ps:注意将同名的放在一个数组里
     */
    formExt.obj=function(form) {
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

(function($){
    ajaxExt = new Object();
    ajaxExt.post=function(url, data, func) {
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
                alert('Ajax error!')
            }
        });
    }
    ajaxExt.get=function(url, func) {
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
(function($){
    window.AuthExt = new Object();
    AuthExt.login = function (func) {
            //token认证
            // ajaxExt.post('/auth/check', {}, function (data) {
            //if(!data.success){
            //如果参数过多，建议通过 object 方式传入
            console.log(11111)
            $.login({
                title: '登陆',
                text: '请输入用户名和密码',
                username: '',  // 默认用户名
                password: '',  // 默认密码
                onOK: function (username, password) {
                    //点击确认
                    //请求登录认证
                    ajaxExt.post('/auth/login', {username:username, password:password}, function (data) {
                        var result = data.result;
                        console.log(1);
                        if(!data.success){
                            console.log(2);
                            login();
                            $.toptip('账号密码错误', 'error');

                        }else {
                            $.cookie('jwt-token', data.result.token, { expires: 7, path: '/' });
                            console.log(func);
                            if(func != undefined){
                                func();
                            }
                            console.log(data)
                        }
                    })
                    console.log(username, password)
                },
                onCancel: function () {
                    //点击取消
                }
            });
            // }
            //});
    }
    AuthExt.check = function (func) {
        var token = $.cookie('jwt-token');
//            console.log(token);
        if(!token){
            AuthExt.login()
        }else {
            //loginSuccess();
        }
    }
})(jQuery);

