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
                if (!result.success) {
                    return $.toast(result.msg, "cancel");
                }
                $.toast("保存成功", function () {
                    func(result);
                });

                return true;
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
                $.toast("获取列表失败", 'cancel');
            }
        });
    }
})(jQuery);
