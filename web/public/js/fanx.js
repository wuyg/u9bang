/*全局Ajax函数*/
$.ajaxSetup({
    dataType: 'json',
    cache: false,
    //请求失败遇到异常触发
    error: function(xhr, status, e) {
        Fanx.Tip("error", xhr.responseText);
    },
});

$(document).ready(function(e) {
    (function() {
        $('<p id="back-top-tag"></p>').hide().insertBefore($('body').children()[0]);
        $('<p id="back-top"><a href="#back-top-tag" title="返回顶部"><span></span></a></p>').hide().appendTo('body');
        $(window).scroll(function() {
            if ($(this).scrollTop() > 100) {
                $('#back-top').fadeIn();
            } else {
                $('#back-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-top a').click(function() {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    })();
    $('[data-toggle="tooltip"]').tooltip();
});


var Fanx = $.Fanx = window.Fanx = {};
Fanx.ToBoolean = function(v) {
    if (v === true || v == "true" || v == "1")
        return true;
    return false;
};
Fanx.Error = function(message, options) {
    Fanx.Tip('error',message);
};
Fanx.Info = function(message, options) {
    Fanx.Tip('info',message);
};
Fanx.Warning = function(message, options) {
    Fanx.Tip('warning',message);
};
Fanx.Tip = function(type, message, options) {
    var class_name = "",
        title = "",
        time = "";
    options = options || {
        title: ""
    };
    if (type == "error") {
        class_name = "gritter-error";
        time = 50000;
    }
    if (type == "warning") {
        class_name = "gritter-warning";
        time = 5000;
    }
    if (type == "info") {
        class_name = "gritter-info";
        time = 3000;
    }
    if (type == "tip") {
        class_name = "gritter-success";
        time = 2000;
    }
    if (type == "success") {
        class_name = "gritter-success";
        time = 2000;
    }
    if ($.gritter) {
        $.gritter.add({
            title: title,
            text: message,
            time: time,
            class_name: class_name
        });
    }
};
Fanx.Loading = function(message, box) {
    if (!box) {
        box = $('#mainPage');
    }
    if (box.length <= 0) {
        box = $('body');
    }
    var el = box.find('#loading-overlay');
    if (el.length <= 0) {
        el = $('<div id="loading-overlay" style="display:none"><div><i class="icon-spinner icon-spin icon-4x white"></i><div></div>');
        box.append(el);
    }
    if (el.attr('status') != 0) {
        el.show();
    }
    el.attr('status', 0);
};
Fanx.Loaded = function(message) {
    $('#loading-overlay').hide(500).attr('status', 1);
};

Fanx.IsNull = function(obj) {
    if (obj == null || obj == undefined || obj === "null" || obj === "") return true;
    return false;
};
Fanx.IsNotNull = function(obj) {
    return !Fanx.IsNull(obj);
};
Fanx.ToUTCDate = function(date) {
    if (typeof(date) === "string") {
        var da = new Date(date);
        return Date.UTC(da.getUTCFullYear(), da.getMonth(), da.getDate());
    } else {
        return Date.UTC(date.getUTCFullYear(), date.getMonth(), date.getDate());
    }
};
Fanx.Run = function(bpName, param, callbackFN, opt) {
    opt = opt || {};
    opt.type = opt.type || "GET"; //GET,POST
    opt.async = opt.async || true;
    $.ajax({
        url: "/simple/fanx.run.php",
        data: {
            "From":"AJAX",
            "BPName": bpName,
            "Param": param
        },
        type: opt.type,
        async: opt.async,
        complete: function(xhr, status) {
            if (opt.Loading) {
                Fanx.Loaded('加载数据完毕');
            }
        },
        error: function(xhr, status, e) {
            if ($.isFunction(callbackFN)) {
                callbackFN(status,xhr.responseText, e);
            }else{
                Fanx.Error(xhr.responseText);
            }
        },
        beforeSend: function(xhr) {
            if (opt.Loading) {
                Fanx.Loading('正在加载数据');
            }
        }
    }).done(function(result, textStatus, jqXHR) {
        var e = {
            cancel: false
        };
         if ($.isFunction(callbackFN)) {
            if(result&&(result.su == 1 || result.su == "1")){
                callbackFN(result,null, e);
            }else if(result&&(result.su == 0 || result.su == "0")){
                callbackFN(result,result.msg||"未知错误", e);
            }else{
                 callbackFN(result,'result is null', e);
            }
        }
    });
};
Fanx.GetUrlParms = function(name, url) {
    if (name == null || name == undefined) {
        return "";
    }
    url = url || location.search.substring(1);
    var pairs = url.split("&");
    var args = {};
    for (var i = 0; i < pairs.length; i++) {
        var pos = pairs[i].indexOf('='); //查找name=value     
        if (pos == -1) continue; //如果没有找到就跳过     
        var argname = pairs[i].substring(0, pos); //提取name     
        var value = pairs[i].substring(pos + 1); //提取value     
        args[argname.toLowerCase()] = value; // unescape(value); //存为属性     
    }
    var returnValue = args[name.toLowerCase()];
    if (typeof(returnValue) == "undefined") {
        return "";
    } else {
        return returnValue;
    }
};
Fanx.SetParmsValue = function(parms, parmsValue, pushState) {
    var newUrlParms = "";
    var newUrlBase = location.href.substring(0, location.href.indexOf("?")); //截取查询字符串前面的url  
    var query = location.search.substring(1); //获取查询串
    var isfind = false;
    if (query) {
        var pairs = query.split("&"); //在逗号处断开
        for (var i = 0; i < pairs.length; i++) {
            var pos = pairs[i].indexOf('='); //查找name=value     
            if (pos == -1) continue; //如果没有找到就跳过     
            var argname = pairs[i].substring(0, pos); //提取name     
            var value = pairs[i].substring(pos + 1); //提取value  
            if (newUrlParms) {
                newUrlParms += "&";
            }
            //如果找到了要修改的参数  
            if (argname.toLowerCase().indexOf(parms.toLowerCase()) != -1) {
                newUrlParms = newUrlParms + (argname + "=" + parmsValue);
                isfind = true;
            } else {
                newUrlParms += (argname + "=" + value);
            }
        }
    }
    if (!isfind) {
        if (newUrlParms) {
            newUrlParms += "&";
        }
        newUrlParms += (parms + "=" + parmsValue);
    }
    if (history.replaceState) {
        var state = ({
            url: document.URL,
            title: document.title
        });
        if (pushState) {
            history.pushState(state, document.title, newUrlBase + "?" + newUrlParms);
        } else {
            history.replaceState(state, document.title, newUrlBase + "?" + newUrlParms);
        }
    } else {
        window.location = newUrlBase + "?" + newUrlParms;
    }
};
Fanx.HTMLTrip = function(html, len) {
    if (html) {
        html = html.replace(/<[^>].*?>/g, "");
    }
    if (len) {
        return html.length > len ? html.substr(0, len) : html;
    }
    return html;
};
/*友好bool类型的值显示*/
Fanx.FBool = function(boolValue) {
    if (boolValue == "1" || boolValue == "true" || boolValue == 1)
        return "是";
    else
        return "否";
};
/*友好时间显示*/
Fanx.FTime = function(time) {
    //获取time距离当前的秒      
    var ct = parseInt(((new Date()).getTime() - (new Date(time)).getTime()) / 1000);
    var lb = "前";

    if (ct < 0) {
        lb = "后";
        ct = Math.abs(ct);
    }
    if (ct == 0) {
        return "刚刚";
    }
    if (ct > 0 && ct < 60) {
        return ct + "秒" + lb;
    }
    if (ct >= 60 && ct < 3600) {
        return parseInt(ct / 60) + "分钟" + lb;
    }
    if (ct >= 3600 && ct < 86400)
        return parseInt(ct / 3600) + "小时" + lb;
    if (ct >= 86400 && ct < 2592000) { //86400 * 30  
        return parseInt(ct / 86400) + "天" + lb;
    }
    if (ct >= 2592000 && ct < 31104000) { //86400 * 30  
        return parseInt(ct / 2592000) + "月" + lb;
    }
    return parseInt(ct / 31104000) + "年" + lb;
};
Fanx.IsEmail = function(value) {
    var re = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+\.([a-zA-Z0-9_-])+$/
    if (re.test(value)) {
        return true;
    }
    return false;
};
Fanx.IsPhone = function(value) {
    var re = /^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/
    if (re.test(value)) {
        return true;
    }
    return false;
};