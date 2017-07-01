/*****************************************************************
 form表单获取值封装类
 *****************************************************************/
(function ($) {
    window.formExt = {};
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
    window.ajaxExt = {};
    ajaxExt.post = function (url, data, func) {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            //contentType: false,
            //processData: false,
            headers: {
                'Authorization': 'Bearer ' + AuthExt.getToken()
            },
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
    ajaxExt.get = function (url, func, options) {
        $.ajax({
            url: url,
            type: 'GET',
            //data: data,
            //contentType: false,
            //processData: false,
            headers: {
                'Authorization': 'Bearer ' + AuthExt.getToken()
            },
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
    window.AuthExt = {};
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
                var publicKey = '-----BEGIN PUBLIC KEY-----\
                MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDFZSmcK+TfwxWUQoXUJm9p/uhb\
                fpEn83wg1B78lzdAwfSgGwaP7MTBVYxDCYLDVaTZd6uLdvyE5K9BmbJKRkyILUVH\
                oyna/pqsLjnz+tLo0AVd1zhzhnfWYyB03b8bPZXHUYWmafzt8kEZzKWWdCx7uC4P\
                WKJQVJwVxXSw/U2qhwIDAQAB\
                -----END PUBLIC KEY-----';
                // Encrypt with the public key...
                var encrypt = new JSEncrypt();
                encrypt.setPublicKey(publicKey);
                password = encrypt.encrypt(password);
                ajaxExt.post('/auth/login', {username: username, password: password}, function (data) {
                    var result = data.result;
                    if (!data.success) {
                        AuthExt.login();
                        $.toptip('账号密码错误', 'error');
                    } else {
                        AuthExt.setAuth(result);
                        console.log(data)
                    }
                })
                console.log(username, password)
            },
            onCancel: function () {
                //点击取消
                location.hash = '';
            }
        });
    }
    AuthExt.check = function () {
        console.log('登录验证');
        var token = AuthExt.getToken();
        if (!token) {
            AuthExt.login()
        } else {
            return true;
        }
    }
    AuthExt.setAuth = function (result) {
        console.log('setAuth', result);
        // $.cookie('token', result.token, {expires: 7, path: '/'});
        setLocalStorage('token', result.token);
    }
    AuthExt.setToken = function (token) {

    }
    AuthExt.getToken = function () {
        // var token = $.cookie('token');
        var token = getLocalStorage('token');
        console.log('getToken', token);
        return token;
    }
})(jQuery);
(function ($) {
    window.config = {
        name: 'Ant Design Admin',
        prefix: 'antdAdmin',
        footerText: 'Ant Design Admin 版权所有 © 2016 由 zuiidea 支持',
        logoSrc: 'https://t.alipayobjects.com/images/rmsweb/T1B9hfXcdvXXXXXXXX.svg',
        logoText: 'Antd Admin',
        needLogin: true
    };
    window.StorageExt = {};
    StorageExt.put = function (name, defaultValue) {
        var key = config.prefix + name
        global[key] = localStorage.getItem(key)
            ? JSON.parse(localStorage.getItem(key))
            : defaultValue;

        !localStorage.getItem(key) && localStorage.setItem(key, JSON.stringify(global[key]))
        Watch.watch(global[key], function () {
            localStorage.setItem(key, JSON.stringify(global[key]))
        })
        return key
    }
    // Operation LocalStorage
    window.setLocalStorage = function(key, vaule) {
        return localStorage.setItem(key, JSON.stringify(vaule));
    }

    window.getLocalStorage = function(key) {
        return JSON.parse(localStorage.getItem(key));
    }

    window.clearLocalStorage = function(key) {
        return localStorage.clear();
    }

})(jQuery);
(function ($) {
    window.addEventListener('storage', function(e) {
        console.log('storage change', e);
        // document.querySelector('.my-key').textContent = e.key;
        // document.querySelector('.my-old').textContent = e.oldValue;
        // document.querySelector('.my-new').textContent = e.newValue;
        // document.querySelector('.my-url').textContent = e.url;
        // document.querySelector('.my-storage').textContent = e.storageArea;
    });
})(jQuery)

