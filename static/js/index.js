var Common = {};
Common.trim = function(s) {
    return s.replace(/(^\s*)|(\s*$)/g, "")
};
var validator = {
    errinput: 'errinput',
    errmsg: 'errmsg',
    errcls: 'no',
    yescls: 'yes',
    errorTip: 'errorTip',
    errorInput: 'errorInput',
    validTip: 'validTip',
    require: /[^(^\s*)|(\s*$)]/,
    email: /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
    domain: /^\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
    phone: /^((\(\d{2,3}\))|(\d{3}\-))?(\(0\d{2,3}\)|0\d{2,3}-)?[1-9]\d{6,7}(\-\d{1,4})?$/,
    mobile: /^1[345]\d{9}$|^18\d{9}$|^0\d{9,10}$/,
    url: /^http:\/\/[A-Za-z0-9]+\.[A-Za-z0-9]+[\/=\?%\-&_~`@[\]\':+!]*([^<>\"\"])*$/,
    idcard: "this.isIdCard(value)",
    money: /^\d+(\.\d+)?$/,
    number: /^\d+$/,
    zip: /^\d{6}$/,
    ip: /^[\d\.]{7,15}$/,
    qq: /^[1-9]\d{4,9}$/,
    integer: /^[-\+]?\d+$/,
    double: /^[-\+]?\d+(\.\d+)?$/,
    english: /^[A-Za-z]+$/,
    chinese: /^[\u0391-\uFFE5]+$/,
    enandcn: /^[\w\u0391-\uFFE5][\w\u0391-\uFFE5\-\.]+$/,
    username: /^[\w]+[\-\.\w]{2,}$/i,
    unsafe: /[<>\?\#\$\*\&;\\\/\[\]\{\}=\(\)\.\^%,]/,
    safestring: "this.isSafe(value)",
    filter: "this.doFilter(value)",
    limit: "this.checkLimit(value.length)",
    limitb: "this.checkLimit(this.LenB(value))",
    limitc: "this.checkLimit(value.length)",
    date: "this.isDate(value)",
    repeat: "this.checkRepeat(value)",
    range: "this.checkRange(value)",
    compare: "this.checkCompare(value)",
    custom: "this.Exec(value)",
    group: "this.mustChecked()",
    ajax: "this.doajax(errindex)",
    isIdCard: function(number) {
        var date, Ai;
        var verify = "10x98765432";
        var Wi = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
		var area = ['', '', '', '', '', '', '', '', '', '', '', '北京', '天津', '河北', '山西', '内蒙古', '', '', '', '', '', '辽宁', '吉林', '黑龙江', '', '', '', '', '', '', '', '上海', '江苏', '浙江', '安微', '福建', '江西', '山东', '', '', '', '河南', '湖北', '湖南', '广东', '广西', '海南', '', '', '', '重庆', '四川', '贵州', '云南', '西藏', '', '', '', '', '', '', '陕西', '甘肃', '青海', '宁夏', '新疆', '', '', '', '', '', '台湾', '', '', '', '', '', '', '', '', '', '香港', '澳门', '', '', '', '', '', '', '', '', '国外'];
        var re = number.match(/^(\d{2})\d{4}(((\d{2})(\d{2})(\d{2})(\d{3}))|((\d{4})(\d{2})(\d{2})(\d{3}[x\d])))$/i);
        if (re == null) return false;
        if (re[1] >= area.length || area[re[1]] == "") return false;
        if (re[2].length == 12) {
            Ai = number.substr(0, 17);
            date = [re[9], re[10], re[11]].join("-")
        } else {
            Ai = number.substr(0, 6) + "19" + number.substr(6);
            date = ["19" + re[4], re[5], re[6]].join("-")
        }
        if (!this.isDate(date, "ymd")) return false;
        var sum = 0;
        for (var i = 0; i <= 16; i++) {
            sum += Ai.charAt(i) * Wi[i]
        }
        Ai += verify.charAt(sum % 11);
        return (number.length == 15 || number.length == 18 && number == Ai)
    },
    isSafe: function(str) {
        return ! this.unsafe.test(str)
    },
    isDate: function(op) {
        var formatString = this['element'].attr('format');
        formatString = formatString || "ymd";
        var m, year, month, day;
        switch (formatString) {
        case "ymd":
            m = op.match(new RegExp("^((\\d{4})|(\\d{2}))([-./])(\\d{1,2})\\4(\\d{1,2})$"));
            if (m == null) return false;
            day = m[6];
            month = m[5] * 1;
            year = (m[2].length == 4) ? m[2] : GetFullYear(parseInt(m[3], 10));
            break;
        case "dmy":
            m = op.match(new RegExp("^(\\d{1,2})([-./])(\\d{1,2})\\2((\\d{4})|(\\d{2}))$"));
            if (m == null) return false;
            day = m[1];
            month = m[3] * 1;
            year = (m[5].length == 4) ? m[5] : GetFullYear(parseInt(m[6], 10));
            break;
        default:
            break
        }
        if (!parseInt(month)) return false;
        month = month == 0 ? 12 : month;
        var date = new Date(year, month - 1, day);
        return (typeof(date) == "object" && year == date.getFullYear() && month == (date.getMonth() + 1) && day == date.getDate());
        function GetFullYear(y) {
            return ((y < 30 ? "20": "19") + y) | 0
        }
    },
    doFilter: function(value) {
        var filter = this['element'].attr('accept');
        return new RegExp("^.+\.(?=EXT)(EXT)$".replace(/EXT/g, filter.split(/\s*,\s*/).join("|")), "gi").test(value)
    },
    checkLimit: function(len) {
        var minval = this['element'].attr('min') || Number.MIN_VALUE;
        var maxval = this['element'].attr('max') || Number.MAX_VALUE;
        return (minval <= len && len <= maxval)
    },
    LenB: function(str) {
        return str.replace(/[^\x00-\xff]/g, "**").length
    },
    checkRepeat: function(value) {
        var to = this['element'].attr('to');
        return value == jQuery('input[name="' + to + '"]').eq(0).val()
    },
    checkRange: function(value) {
        value = value | 0;
        var minval = this['element'].attr('min') || Number.MIN_VALUE;
        var maxval = this['element'].attr('max') || Number.MAX_VALUE;
        return (minval <= value && value <= maxval)
    },
    checkCompare: function(value) {
        var compareid = this['element'].attr('compare');
        if (!value) return false;
        return jQuery('#' + compareid).attr('value') == value
    },
    Exec: function(value) {
        var reg = this['element'].attr('regexp');
        return new RegExp(reg, "gi").test(value)
    },
    mustChecked: function() {
        var tagName = this['element'].attr('name');
        var f = this['element'].parents('form');
        var n = f.find('input[name="' + tagName + '"][checked]').length;
        var count = f.find('input[name="' + tagName + '"]').length;
        var minval = this['element'].attr('min') || 1;
        var maxval = this['element'].attr('max') || count;
        return (minval <= n && n <= maxval)
    },
    doajax: function(value) {
        var element = this['element'];
        var errindex = this['errindex'];
        var url = this['element'].attr('url');
        var vname = this['element'].attr('vname');
        var msgid = jQuery('#' + element.attr('msgid'));
        var val = this['element'].val();
        var str_errmsg = this['element'].attr('msg');
        var arr_errmsg;
        var errmsg;
        if (str_errmsg.indexOf('|') > -1) {
            arr_errmsg = str_errmsg.split('|');
            errmsg = arr_errmsg[errindex]
        } else {
            errmsg = ''
        }
        var type = this['element'].attr('type');
        var Charset = jQuery.browser.msie ? document.charset: document.characterSet;
        var methodtype = (Charset.toLowerCase() == 'utf-8') ? 'post': 'get';
        var method = this['element'].attr('method') || methodtype;
        var name = this['element'].attr('name');
        if (url == "" || url == undefined) {
            alert('Please specify url');
            return false
        } else if (vname == "" || vname == undefined) {
            alert('Please specify vname');
            return false
        }
        if (url.indexOf('?') > -1) {
            url = url + "&n=" + vname + "&v=" + escape(val)
        } else {
            url = url + '?n=' + vname + "&v=" + escape(val)
        }
        var s = $.ajax({
            type: method,
            url: url,
            data: {},
            cache: false,
            async: false,
            success: function(data) {
                data = data.replace(/(^\s*)|(\s*$)/g, "");
                data = eval('(' + data + ')');
                if (data.error != 0) {
                    errmsg = errmsg == "" ? data.data: errmsg;
                    (type != 'checkbox' && type != 'radio' && element.addClass(validator.errorInput));
                    if (!errmsg) return false;
                    if (msgid.length > 0) {
                        msgid.removeClass(validator.validTip).addClass(validator.errorTip).html(errmsg)
                    } else {
                        jQuery("<span class='" + validator.errorTip + "'></span>").html(errmsg).insertAfter(element)
                    }
                    return false
                } else if (data.error == 0) {
                    if (!errmsg) return true;
                    if (msgid.length > 0) {
                        msgid.removeClass(validator.errorTip).addClass(validator.validTip).html('')
                    } else {
                        jQuery("<span class='" + validator.validTip + "'></span>").insertAfter(element)
                    }
                    return true
                }
            }
        }).responseText;
        return (eval('(' + s.replace(/(^\s*)|(\s*$)/g, "") + ')').error == 0)
    }
};
validator.showErr = function(element, errindex) {
    var str_errmsg = element.attr('msg') || '';
    var arr_errmsg = str_errmsg.split('|');
    var errmsg = arr_errmsg[errindex] ? arr_errmsg[errindex] : arr_errmsg[0];
    var msgid = jQuery('#' + element.attr('msgid'));
    var type = element.attr('type');
    (type != 'checkbox' && type != 'radio' && element.addClass(this['errorinput']));
    if (!errmsg) return false;
    if (msgid.length > 0) {
        msgid.removeClass(this['validTip']).addClass(this['errorTip']).html(errmsg)
    } else {
        element.parent('*').find('.' + this['errorTip']).remove();
        jQuery("<span class='" + this['errorTip'] + "'></span>").html(errmsg).insertAfter(element)
    }
    return false
};
validator.removeErr = function(element) {
    element.removeClass(this['errorInput']);
    var msgid = jQuery('#' + element.attr('msgid'));
    if (msgid.length == 0) {
        element.parent('*').find('span .' + this['errorTip']).remove();
        element.parent('*').find('span .' + this['validTip']).remove()
    }
};
validator.checkajax = function(element, datatype, errindex) {
    var value = jQuery.trim(element.val());
    this['element'] = element;
    this['errindex'] = errindex;
    validator.removeErr(element);
    return eval(this[datatype])
};
validator.checkDatatype = function(element, datatype) {
    var value = jQuery.trim(element.val());
    this['element'] = element;
    validator.removeErr(element);
    switch (datatype) {
    case "idcard":
    case "date":
    case "repeat":
    case "range":
    case "compare":
    case "custom":
    case "group":
    case "limit":
    case "limitb":
    case "limitc":
    case "safestring":
    case "filter":
        return eval(this[datatype]);
        break;
    default:
        return this[datatype].test(value);
        break
    }
};
validator.check = function(obj, submit) {
    var datatype = obj.attr('datatype');
    var lastvalue = obj.attr('lastvalue');
    var value = jQuery.trim(obj.val());
    if (typeof(datatype) == "undefined") return true;
    if (obj.attr('require') != "true" && value == "") {
        obj.removeClass(validator.errorInput);
        return true
    }
    var isValid = true;
    var datatypes = datatype.split('|');
    if (($.inArray('repeat', datatypes) == -1) && ($.inArray('ajax', datatypes) != -1) && (submit == true || (lastvalue && lastvalue == value))) {
        var e = obj.parent('*').find('.' + validator.errorTip);
        var v = obj.parent('*').find('.' + validator.validTip);
        if (e.length > 0 || v.length > 0) {
            return (v.length > 0)
        }
    }
    jQuery.each(datatypes,
    function(index, type) {
        if (typeof(validator[type]) == "undefined") {
            isValid = false;
            return false
        }
        if (type == 'ajax') return isValid = validator.checkajax(obj, type, index);
        if (validator.checkDatatype(obj, type) == false) {
            obj.addClass(validator.errorInput);
            validator.showErr(obj, index);
            return isValid = false
        } else {
            validator.showErr(obj, index);
            obj.removeClass(validator.errorInput);
            var msgid = jQuery('#' + obj.attr('msgid'));
            if (msgid.length > 0) {
                msgid.removeClass(validator.errorTip).addClass(validator.validTip).html('')
            } else {
                obj.parent('*').find('.' + validator.errorTip + ',.' + validator.validTip).remove()
            }
        }
    });
    obj.attr('lastvalue', value);
    return isValid
};
jQuery.fn.validateForm = function(no, form) {
    var isValid = true;
    var errIndex = new Array();
    var n = 0;
    var emsg = '';
    var elements = jQuery(form).find(':input[require]');
    elements.each(function(i) {
        if (false == validator.check(jQuery(this), true)) {
            var m = jQuery(this).parent('*').find('.' + validator.errorTip).html();
            if (m) {
                emsg += (emsg == '') ? m: '\n' + m
            }
            isValid = false;
            errIndex[n++] = i
        }
    });
    if (isValid == false) {
        elements.eq(errIndex[0]).focus().select();
        return false
    }
    return true
};
jQuery.fn.checkForm = function(jform) {
    var jform = jQuery(jform);
    var elements = jform.find(':input[require]');
    elements.blur(function() {
        return validator.check(jQuery(this))
    });
    jform.submit(function() {
        return jQuery.fn.validateForm('', jform)
    })
};
jQuery.fn.extend({
    everyTime: function(interval, label, fn, times) {
        return this.each(function() {
            jQuery.timer.add(this, interval, label, fn, times)
        })
    },
    oneTime: function(interval, label, fn) {
        return this.each(function() {
            jQuery.timer.add(this, interval, label, fn, 1)
        })
    },
    stopTime: function(label, fn) {
        return this.each(function() {
            jQuery.timer.remove(this, label, fn)
        })
    }
});
jQuery.extend({
    timer: {
        global: [],
        guid: 1,
        dataKey: "jQuery.timer",
        regex: /^([0-9]+(?:\.[0-9]*)?)\s*(.*s)?$/,
        powers: {
            'ms': 1,
            'cs': 10,
            'ds': 100,
            's': 1000,
            'das': 10000,
            'hs': 100000,
            'ks': 1000000
        },
        timeParse: function(value) {
            if (value == undefined || value == null) return null;
            var result = this.regex.exec(jQuery.trim(value.toString()));
            if (result[2]) {
                var num = parseFloat(result[1]);
                var mult = this.powers[result[2]] || 1;
                return num * mult
            } else {
                return value
            }
        },
        add: function(element, interval, label, fn, times) {
            var counter = 0;
            if (jQuery.isFunction(label)) {
                if (!times) times = fn;
                fn = label;
                label = interval
            }
            interval = jQuery.timer.timeParse(interval);
            if (typeof interval != 'number' || isNaN(interval) || interval < 0) return;
            if (typeof times != 'number' || isNaN(times) || times < 0) times = 0;
            times = times || 0;
            var timers = jQuery.data(element, this.dataKey) || jQuery.data(element, this.dataKey, {});
            if (!timers[label]) timers[label] = {};
            fn.timerID = fn.timerID || this.guid++;
            var handler = function() {
                if ((++counter > times && times !== 0) || fn.call(element, counter) === false) jQuery.timer.remove(element, label, fn)
            };
            handler.timerID = fn.timerID;
            if (!timers[label][fn.timerID]) timers[label][fn.timerID] = window.setInterval(handler, interval);
            this.global.push(element)
        },
        remove: function(element, label, fn) {
            var timers = jQuery.data(element, this.dataKey),
            ret;
            if (timers) {
                if (!label) {
                    for (label in timers) this.remove(element, label, fn)
                } else if (timers[label]) {
                    if (fn) {
                        if (fn.timerID) {
                            window.clearInterval(timers[label][fn.timerID]);
                            delete timers[label][fn.timerID]
                        }
                    } else {
                        for (var fn in timers[label]) {
                            window.clearInterval(timers[label][fn]);
                            delete timers[label][fn]
                        }
                    }
                    for (ret in timers[label]) break;
                    if (!ret) {
                        ret = null;
                        delete timers[label]
                    }
                }
                for (ret in timers) break;
                if (!ret) jQuery.removeData(element, this.dataKey)
            }
        }
    }
});
jQuery(window).bind("unload",
function() {
    jQuery.each(jQuery.timer.global,
    function(index, item) {
        jQuery.timer.remove(item)
    })
});
(function($) {
    $.fn.ajaxSubmit = function(options) {
        if (!this.length) {
            log('ajaxSubmit: skipping submit process - no element selected');
            return this
        }
        if (typeof options == 'function') options = {
            success: options
        };
        var url = this.attr('action') || window.location.href;
        url = (url.match(/^([^#]+)/) || [])[1];
        url = url || '';
        options = $.extend({
            url: url,
            type: this.attr('method') || 'GET'
        },
        options || {});
        var veto = {};
        this.trigger('form-pre-serialize', [this, options, veto]);
        if (veto.veto) {
            log('ajaxSubmit: submit vetoed via form-pre-serialize trigger');
            return this
        }
        if (options.beforeSerialize && options.beforeSerialize(this, options) === false) {
            log('ajaxSubmit: submit aborted via beforeSerialize callback');
            return this
        }
        var a = this.formToArray(options.semantic);
        if (options.data) {
            options.extraData = options.data;
            for (var n in options.data) {
                if (options.data[n] instanceof Array) {
                    for (var k in options.data[n]) a.push({
                        name: n,
                        value: options.data[n][k]
                    })
                } else a.push({
                    name: n,
                    value: options.data[n]
                })
            }
        }
        if (options.beforeSubmit && options.beforeSubmit(a, this, options) === false) {
            log('ajaxSubmit: submit aborted via beforeSubmit callback');
            return this
        }
        this.trigger('form-submit-validate', [a, this, options, veto]);
        if (veto.veto) {
            log('ajaxSubmit: submit vetoed via form-submit-validate trigger');
            return this
        }
        var q = $.param(a);
        if (options.type.toUpperCase() == 'GET') {
            options.url += (options.url.indexOf('?') >= 0 ? '&': '?') + q;
            options.data = null
        } else options.data = q;
        var $form = this,
        callbacks = [];
        if (options.resetForm) callbacks.push(function() {
            $form.resetForm()
        });
        if (options.clearForm) callbacks.push(function() {
            $form.clearForm()
        });
        if (!options.dataType && options.target) {
            var oldSuccess = options.success ||
            function() {};
            callbacks.push(function(data) {
                $(options.target).html(data).each(oldSuccess, arguments)
            })
        } else if (options.success) callbacks.push(options.success);
        options.success = function(data, status) {
            for (var i = 0, max = callbacks.length; i < max; i++) callbacks[i].apply(options, [data, status, $form])
        };
        var files = $('input:file', this).fieldValue();
        var found = false;
        for (var j = 0; j < files.length; j++) if (files[j]) found = true;
        if (options.iframe || found) {
            if (options.closeKeepAlive) $.get(options.closeKeepAlive, fileUpload);
            else fileUpload()
        } else $.ajax(options);
        this.trigger('form-submit-notify', [this, options]);
        return this;
        function fileUpload() {
            var form = $form[0];
            if ($(':input[name=submit]', form).length) {
                alert('Error: Form elements must not be named "submit".');
                return
            }
            var opts = $.extend({},
            $.ajaxSettings, options);
            var s = $.extend(true, {},
            $.extend(true, {},
            $.ajaxSettings), opts);
            var id = 'jqFormIO' + (new Date().getTime());
            var $io = $('<iframe id="' + id + '" name="' + id + '" src="about:blank" />');
            var io = $io[0];
            $io.css({
                position: 'absolute',
                top: '-1000px',
                left: '-1000px'
            });
            var xhr = {
                aborted: 0,
                responseText: null,
                responseXML: null,
                status: 0,
                statusText: 'n/a',
                getAllResponseHeaders: function() {},
                getResponseHeader: function() {},
                setRequestHeader: function() {},
                abort: function() {
                    this.aborted = 1;
                    $io.attr('src', 'about:blank')
                }
            };
            var g = opts.global;
            if (g && !$.active++) $.event.trigger("ajaxStart");
            if (g) $.event.trigger("ajaxSend", [xhr, opts]);
            if (s.beforeSend && s.beforeSend(xhr, s) === false) {
                s.global && $.active--;
                return
            }
            if (xhr.aborted) return;
            var cbInvoked = 0;
            var timedOut = 0;
            var sub = form.clk;
            if (sub) {
                var n = sub.name;
                if (n && !sub.disabled) {
                    options.extraData = options.extraData || {};
                    options.extraData[n] = sub.value;
                    if (sub.type == "image") {
                        options.extraData[name + '.x'] = form.clk_x;
                        options.extraData[name + '.y'] = form.clk_y
                    }
                }
            }
            setTimeout(function() {
                var t = $form.attr('target'),
                a = $form.attr('action');
                form.setAttribute('target', id);
                if (form.getAttribute('method') != 'POST') form.setAttribute('method', 'POST');
                if (form.getAttribute('action') != opts.url) form.setAttribute('action', opts.url);
                if (!options.skipEncodingOverride) {
                    $form.attr({
                        encoding: 'multipart/form-data',
                        enctype: 'multipart/form-data'
                    })
                }
                if (opts.timeout) setTimeout(function() {
                    timedOut = true;
                    cb()
                },
                opts.timeout);
                var extraInputs = [];
                try {
                    if (options.extraData) for (var n in options.extraData) extraInputs.push($('<input type="hidden" name="' + n + '" value="' + options.extraData[n] + '" />').appendTo(form)[0]);
                    $io.appendTo('body');
                    io.attachEvent ? io.attachEvent('onload', cb) : io.addEventListener('load', cb, false);
                    form.submit()
                } finally {
                    form.setAttribute('action', a);
                    t ? form.setAttribute('target', t) : $form.removeAttr('target');
                    $(extraInputs).remove()
                }
            },
            10);
            var nullCheckFlag = 0;
            function cb() {
                if (cbInvoked++) return;
                io.detachEvent ? io.detachEvent('onload', cb) : io.removeEventListener('load', cb, false);
                var ok = true;
                try {
                    if (timedOut) throw 'timeout';
                    var data, doc;
                    doc = io.contentWindow ? io.contentWindow.document: io.contentDocument ? io.contentDocument: io.document;
                    if ((doc.body == null || doc.body.innerHTML == '') && !nullCheckFlag) {
                        nullCheckFlag = 1;
                        cbInvoked--;
                        setTimeout(cb, 100);
                        return
                    }
                    xhr.responseText = doc.body ? doc.body.innerHTML: null;
                    xhr.responseXML = doc.XMLDocument ? doc.XMLDocument: doc;
                    xhr.getResponseHeader = function(header) {
                        var headers = {
                            'content-type': opts.dataType
                        };
                        return headers[header]
                    };
                    if (opts.dataType == 'json' || opts.dataType == 'script') {
                        var ta = doc.getElementsByTagName('textarea')[0];
                        xhr.responseText = ta ? ta.value: xhr.responseText
                    } else if (opts.dataType == 'xml' && !xhr.responseXML && xhr.responseText != null) {
                        xhr.responseXML = toXml(xhr.responseText)
                    }
                    data = $.httpData(xhr, opts.dataType)
                } catch(e) {
                    ok = false;
                    $.handleError(opts, xhr, 'error', e)
                }
                if (ok) {
                    opts.success(data, 'success');
                    if (g) $.event.trigger("ajaxSuccess", [xhr, opts])
                }
                if (g) $.event.trigger("ajaxComplete", [xhr, opts]);
                if (g && !--$.active) $.event.trigger("ajaxStop");
                if (opts.complete) opts.complete(xhr, ok ? 'success': 'error');
                setTimeout(function() {
                    $io.remove();
                    xhr.responseXML = null
                },
                100)
            };
            function toXml(s, doc) {
                if (window.ActiveXObject) {
                    doc = new ActiveXObject('Microsoft.XMLDOM');
                    doc.async = 'false';
                    doc.loadXML(s)
                } else doc = (new DOMParser()).parseFromString(s, 'text/xml');
                return (doc && doc.documentElement && doc.documentElement.tagName != 'parsererror') ? doc: null
            }
        }
    };
    $.fn.ajaxForm = function(options) {
        return this.ajaxFormUnbind().bind('submit.form-plugin',
        function() {
            $(this).ajaxSubmit(options);
            return false
        }).each(function() {
            $(":submit,input:image", this).bind('click.form-plugin',
            function(e) {
                var form = this.form;
                form.clk = this;
                if (this.type == 'image') {
                    if (e.offsetX != undefined) {
                        form.clk_x = e.offsetX;
                        form.clk_y = e.offsetY
                    } else if (typeof $.fn.offset == 'function') {
                        var offset = $(this).offset();
                        form.clk_x = e.pageX - offset.left;
                        form.clk_y = e.pageY - offset.top
                    } else {
                        form.clk_x = e.pageX - this.offsetLeft;
                        form.clk_y = e.pageY - this.offsetTop
                    }
                }
                setTimeout(function() {
                    form.clk = form.clk_x = form.clk_y = null
                },
                10)
            })
        })
    };
    $.fn.ajaxFormUnbind = function() {
        this.unbind('submit.form-plugin');
        return this.each(function() {
            $(":submit,input:image", this).unbind('click.form-plugin')
        })
    };
    $.fn.formToArray = function(semantic) {
        var a = [];
        if (this.length == 0) return a;
        var form = this[0];
        var els = semantic ? form.getElementsByTagName('*') : form.elements;
        if (!els) return a;
        for (var i = 0, max = els.length; i < max; i++) {
            var el = els[i];
            var n = el.name;
            if (!n) continue;
            if (semantic && form.clk && el.type == "image") {
                if (!el.disabled && form.clk == el) a.push({
                    name: n + '.x',
                    value: form.clk_x
                },
                {
                    name: n + '.y',
                    value: form.clk_y
                });
                continue
            }
            var v = $.fieldValue(el, true);
            if (v && v.constructor == Array) {
                for (var j = 0, jmax = v.length; j < jmax; j++) a.push({
                    name: n,
                    value: v[j]
                })
            } else if (v !== null && typeof v != 'undefined') a.push({
                name: n,
                value: v
            })
        }
        if (!semantic && form.clk) {
            var inputs = form.getElementsByTagName("input");
            for (var i = 0, max = inputs.length; i < max; i++) {
                var input = inputs[i];
                var n = input.name;
                if (n && !input.disabled && input.type == "image" && form.clk == input) a.push({
                    name: n + '.x',
                    value: form.clk_x
                },
                {
                    name: n + '.y',
                    value: form.clk_y
                })
            }
        }
        return a
    };
    $.fn.formSerialize = function(semantic) {
        return $.param(this.formToArray(semantic))
    };
    $.fn.fieldSerialize = function(successful) {
        var a = [];
        this.each(function() {
            var n = this.name;
            if (!n) return;
            var v = $.fieldValue(this, successful);
            if (v && v.constructor == Array) {
                for (var i = 0, max = v.length; i < max; i++) a.push({
                    name: n,
                    value: v[i]
                })
            } else if (v !== null && typeof v != 'undefined') a.push({
                name: this.name,
                value: v
            })
        });
        return $.param(a)
    };
    $.fn.fieldValue = function(successful) {
        for (var val = [], i = 0, max = this.length; i < max; i++) {
            var el = this[i];
            var v = $.fieldValue(el, successful);
            if (v === null || typeof v == 'undefined' || (v.constructor == Array && !v.length)) continue;
            v.constructor == Array ? $.merge(val, v) : val.push(v)
        }
        return val
    };
    $.fieldValue = function(el, successful) {
        var n = el.name,
        t = el.type,
        tag = el.tagName.toLowerCase();
        if (typeof successful == 'undefined') successful = true;
        if (successful && (!n || el.disabled || t == 'reset' || t == 'button' || (t == 'checkbox' || t == 'radio') && !el.checked || (t == 'submit' || t == 'image') && el.form && el.form.clk != el || tag == 'select' && el.selectedIndex == -1)) return null;
        if (tag == 'select') {
            var index = el.selectedIndex;
            if (index < 0) return null;
            var a = [],
            ops = el.options;
            var one = (t == 'select-one');
            var max = (one ? index + 1 : ops.length);
            for (var i = (one ? index: 0); i < max; i++) {
                var op = ops[i];
                if (op.selected) {
                    var v = op.value;
                    if (!v) v = (op.attributes && op.attributes['value'] && !(op.attributes['value'].specified)) ? op.text: op.value;
                    if (one) return v;
                    a.push(v)
                }
            }
            return a
        }
        return el.value
    };
    $.fn.clearForm = function() {
        return this.each(function() {
            $('input,select,textarea', this).clearFields()
        })
    };
    $.fn.clearFields = $.fn.clearInputs = function() {
        return this.each(function() {
            var t = this.type,
            tag = this.tagName.toLowerCase();
            if (t == 'text' || t == 'password' || tag == 'textarea') this.value = '';
            else if (t == 'checkbox' || t == 'radio') this.checked = false;
            else if (tag == 'select') this.selectedIndex = -1
        })
    };
    $.fn.resetForm = function() {
        return this.each(function() {
            if (typeof this.reset == 'function' || (typeof this.reset == 'object' && !this.reset.nodeType)) this.reset()
        })
    };
    $.fn.enable = function(b) {
        if (b == undefined) b = true;
        return this.each(function() {
            this.disabled = !b
        })
    };
    $.fn.selected = function(select) {
        if (select == undefined) select = true;
        return this.each(function() {
            var t = this.type;
            if (t == 'checkbox' || t == 'radio') this.checked = select;
            else if (this.tagName.toLowerCase() == 'option') {
                var $sel = $(this).parent('select');
                if (select && $sel[0] && $sel[0].type == 'select-one') {
                    $sel.find('option').selected(false)
                }
                this.selected = select
            }
        })
    };
    function log() {
        if ($.fn.ajaxSubmit.debug && window.console && window.console.log) window.console.log('[jquery.form] ' + Array.prototype.join.call(arguments, ''))
    }
})(jQuery);
var X = {};
X.hook = function() {
    var pre_init_str = 'x_init_hook_';
    for (var h in window) {
        if (0 != h.indexOf(pre_init_str)) continue;
        var func = window[h];
        if (typeof func == 'function') {
            try {
                func()
            } catch(e) {}
        }
    }
};
X.get = function(u) {
    return X.ajax(u, 'GET')
};
X.post = function(u) {
    return X.ajax(u, 'POST')
};
X.ajax = function(u, method) {
    jQuery.ajax({
        url: u,
        type: method,
        dataType: "json",
        success: X.json
    });
    return false
};
X.json = function(r) {
    var type = r['data']['type'];
    var data = r['data']['data'];
    if (type == 'alert') {
        alert(data)
    } else if (type == 'eval') {
        eval(data)
    } else if (type == 'refresh') {
        window.location.reload()
    } else if (type == 'updater') {
        var id = data['id'];
        var inner = data['html'];
        jQuery('#' + id).html(inner)
    } else if (type == 'dialog') {
        X.boxShow(data, true)
    } else if (type == 'mix') {
        for (var x in data) {
            r['data'] = data[x];
            X.json(r)
        }
    } else if (type == 'setprice'){
    	var adult_price = data['adult_price'];
    	var child_price = data['child_price'];
    	var team_price_id = data['id'];
    	jQuery('#adult_price').html(adult_price + '元');
    	jQuery('#child_price').html(child_price + '元');
    	jQuery('#adult_num').keyup();
    	jQuery('#team_price_id').val(team_price_id);
    }else if (type == 'setlevel'){
    	var html='';
    	for(levelid in data)
    		html += '<option>'+data[levelid] +'</option>';
    	jQuery('#hotellevel').html(html);
    	jQuery('#hotellevel').change();
    }
};
X.getXY = function() {
    var x, y;
    if (document.body.scrollTop) {
        x = document.body.scrollLeft;
        y = document.body.scrollTop
    } else {
        x = document.documentElement.scrollLeft;
        y = document.documentElement.scrollTop
    }
    return {
        x: x,
        y: y
    }
};
X.boxMask = function(display) {
    var height = jQuery('body').height() + 'px';
    var width = jQuery(window).width() + 'px';
    jQuery('#pagemasker').css({
        'position': 'absolute',
        'z-index': '3000',
        'width': width,
        'height': height,
        'filter': 'alpha(opacity=0.5)',
        'opacity': 0.5,
        'top': 0,
        'left': 0,
        'background': '#CCC',
        'display': display
    });
    jQuery('#dialog').css('display', display)
};
X.boxShow = function(innerHTML, mask) {
    var dialog = jQuery('#dialog');
    dialog.html(innerHTML);
    if (mask) {
        X.boxMask('block')
    }
    var ew = dialog.get(0).scrollWidth;
    var ww = jQuery(window).width();
    var lt = (ww / 2 - ew / 2) + 'px';
    var wh = jQuery(window).height();
    var xy = X.getXY();
    var tp = (wh * 0.15 + xy.y) + 'px';
    dialog.css('background-color', '#FFF');
    dialog.css('left', lt);
    dialog.css('top', tp);
    dialog.css('z-index', 9999);
    dialog.css('display', 'block');
    return false
};
X.boxClose = function() {
    jQuery('#dialog').html('').css('z-index', -9999);
    X.boxMask('none');
    return false
};
X.location = function(url) {
    jQuery('#ifra_show').attr({
        src: url
    })
};
jQuery(document).ready(X.hook);
//var WEB_ROOT = WEB_ROOT || '';
//alert(WEB_ROOT);
var LOGINUID = LOGINUID || 0;
window.x_init_hook_validator = function() {
    jQuery('form.validator').each(function() {
        jQuery.fn.checkForm(this)
    });
    jQuery('a.needlogin').click(X.misc.needlogin)
};
window.x_init_hook_dealimage = function() {
    var teamside = jQuery('#team_partner_side_0').size() > 0;
    var m = teamside ? 650 : 410;
    if (teamside) {
        jQuery('#team_main_side').css('width', '650px');
        jQuery('.side #side-business img').each(function() {
            X.misc.scaleimage(this, m)
        })
    } else {
        jQuery('.side #side-business img').each(function() {
            X.misc.scaleimage(this, 195)
        })
    }
    jQuery('#deal-stuff img').each(function() {
        X.misc.scaleimage(this, m)
    });
    jQuery('div.sbox-content img').each(function() {
        X.misc.scaleimage(this, 195)
    })
};
window.x_init_hook_myaccount = function() {
    var ma = jQuery('#myaccount');
    var mm = jQuery('#myaccount-menu');
    ma.hover(function() {
        mm.show();
        ma.toggleClass('hover', true)
    },
    function() {
        var menuhide = function() {
            mm.hide();
            ma.toggleClass('hover', false)
        };
        menuout = setTimeout(menuhide, 100)
    });
    mm.hover(function() {
        clearTimeout(menuout)
    },
    function() {
        jQuery(this).hide();
        ma.toggleClass('hover', false)
    })
};
window.x_init_hook_click = function() {
    jQuery("div:not(#guides-city-change)").click(function() {
        jQuery('#guides-city-list').css('display', 'none')
    });
    jQuery('#guides-city-change').click(function() {
        return ! jQuery('#guides-city-list').toggle()
    });
    jQuery('#sysmsg-guide-close').click(function() {
        jQuery('#sysmsg-guide').remove();
        return ! X.get(WEB_ROOT + '/ajax/newbie.php')
    });
    jQuery('#sysmsg-error span.close').click(function() {
        return ! jQuery('#sysmsg-error').remove()
    });
    jQuery('#sysmsg-success span.close').click(function() {
        return ! jQuery('#sysmsg-success').remove()
    });
    jQuery('#deal-share-im').click(function() {
        return ! jQuery('#deal-share-im-c').toggle()
    });
    jQuery('a.ajaxlink').click(function() {
        if (jQuery(this).attr('no') == 'yes') return false;
        var link = jQuery(this).attr('href');
        var ask = jQuery(this).attr('ask');
        if (link.indexOf('/delete') > 0 && !confirm('亲，确定删除本条记录吗？')) {
            return false
        } else if (ask && !confirm(ask)) {
            return false
        }
        X.get(jQuery(this).attr('href'));
        return false
    });
    jQuery('a.remove').click(function() {
        var u = jQuery(this).attr('href');
        if (confirm('亲，确定删除该条记录吗？')) {
            X.get(u)
        }
        return false
    });
    jQuery('.remove-record').click(function() {
        return confirm('亲，确定删除该条记录吗？')
    });
    jQuery('a.delay').click(function() {
        var u = jQuery(this).attr('href');
        if (confirm('亲，确定要将此团购项目延期一天吗？')) {
            return ! X.get(u) && false
        }
        return false
    });
    jQuery('#cardcode-link').click(function() {
        jQuery('.cardcode .act').toggle()
    });
    jQuery('#cardcode-verify-id').click(X.misc.cardcode);
    jQuery('#consult-add-form div[name="commit"]').click(function() {
        jQuery('#consult-add-form').ajaxSubmit({
            'success': function() {
                X.team.consultation_again()
            }
        });
        return false
    });
    jQuery('#consult-add-more').click(X.team.consultation_again);
    jQuery('#express-zone-div input').click(function() {
        var v = jQuery(this).attr('value');
        if (v == 'express') {
            jQuery('#express-zone-express').css('display', 'block');
            jQuery('#express-zone-pickup').css('display', 'none');
            jQuery('#express-zone-coupon').css('display', 'none')
        } else if (v == 'pickup') {
            jQuery('#express-zone-pickup').css('display', 'block');
            jQuery('#express-zone-express').css('display', 'none');
            jQuery('#express-zone-coupon').css('display', 'none')
        } else if (v == 'coupon') {
            jQuery('#express-zone-coupon').css('display', 'block');
            jQuery('#express-zone-pickup').css('display', 'none');
            jQuery('#express-zone-express').css('display', 'none')
        } else if (v == 'voucher') {
            jQuery('#express-zone-coupon').css('display', 'none');
            jQuery('#express-zone-pickup').css('display', 'none');
            jQuery('#express-zone-express').css('display', 'none')
        }
    });
    jQuery('#mail-zone-div input').click(function() {
        var v = jQuery(this).attr('value');
        if (v == 'smtp') {
            jQuery('#mail-zone-smtp').css('display', 'block')
        } else {
            jQuery('#mail-zone-smtp').css('display', 'none')
        }
    });
    jQuery('#share-copy-text').click(function() {
        jQuery(this).select()
    });
    jQuery('#share-copy-button').click(function() {
        X.misc.copyToCB('share-copy-text')
    });
    jQuery('#verify-coupon-id').click(function() {
        X.get(WEB_ROOT + '/ajax/coupon.php?action=dialog')
    });
    jQuery('#deal-subscribe-form').submit(function() {
        var v = jQuery('#deal-subscribe-form-email').attr('value');
        return /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(v)
    });
    jQuery('#header-subscribe-form').submit(function() {
        var v = jQuery('#header-subscribe-email').attr('value');
        return /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(v)
    });
    jQuery('input[xtip$="."]').each(X.misc.inputblur);
    jQuery('input[xtip$="."]').focus(X.misc.inputclick);
    jQuery('input[xtip$="."]').blur(X.misc.inputblur)
};
window.x_init_hook_imagerotate = function() {
    var imgListCurr = 0;
    var imgListCount = jQuery('#img_list a').size();
    if (imgListCount < 2) return;
    var imagesRun = function() {
        var imgListNext = imgListCurr + 1;
        if (imgListCurr == imgListCount - 1) imgListNext = 0;
        imagesPlay(imgListNext);
        imgListCurr++;
        if (imgListCurr > imgListCount - 1) {
            imgListCurr = 0;
            imgListNext = imgListCurr + 1
        }
    };
    jQuery('#team_images').everyTime(3000, 'imagerotate', imagesRun);
    jQuery('#team_images li,#img_list a').hover(function() {
        jQuery('#team_images').stopTime('imagerotate')
    },
    function() {
        jQuery('#team_images').everyTime(3000, 'imagerotate', imagesRun)
    });
    jQuery('#img_list a').click(function() {
        var index = jQuery('#img_list a').index(this);
        if (imgListCurr != index) {
            imagesPlay(index);
            imgListCurr = index
        };
        return false
    });
    var imagesPlay = function(next) {
        jQuery('#team_images li').eq(imgListCurr).css({
            'opacity': '0.5'
        }).animate({
            'left': '-440px',
            'opacity': '1'
        },
        'slow',
        function() {
            jQuery(this).css({
                'left': '440px'
            })
        }).end().eq(next).animate({
            'left': '0px',
            'opacity': '1'
        },
        'slow',
        function() {
            jQuery('#img_list a').siblings('a').removeClass('active').end().eq(next).addClass('active')
        })
    }
};
window.x_init_hook_clock = function() {
    var a = parseInt(jQuery('div.deal-timeleft').attr('diff'));
    if (!a > 0) return;
    var b = (new Date()).getTime();
    var e = function() {
        var c = (new Date()).getTime();
        var ls = a + b - c;
        if (ls > 0) {
            var ld = parseInt(ls / 86400000);
            ls = ls % 86400000;
            var lh = parseInt(ls / 3600000);
            ls = ls % 3600000;
            var lm = parseInt(ls / 60000);
            var ls = parseInt(Math.round(ls % 60000) / 1000);
            if (ld > 0) {
                var html = '<li><span>' + ld + '</span>å¤©</li><li><span>' + lh + '</span>å°æ—¶</li><li><span>' + lm + '</span>åˆ†é’Ÿ</li>'
            } else {
                var html = '<li><span>' + lh + '</span>å°æ—¶</li><li><span>' + lm + '</span>åˆ†é’Ÿ</li><li><span>' + ls + '</span>ç§’</li>'
            }
            jQuery('ul#counter').html(html)
        } else {
            jQuery("ul#counter").stopTime('counter');
            jQuery('ul#counter').html('end');
            window.location.reload()
        }
    };
    jQuery("ul#counter").everyTime(996, 'counter', e)
};
window.x_init_hook_team = function() {
    jQuery('#team_lang').change(findlevel);
    function findlevel(){
    	var hotellevel = jQuery('#team_lang option:selected').val();
    	var html = '';
    	var levellist = hotellevel.split('|');
    	for(lid in levellist)
    	{
    		var levelinfo = levellist[lid].split(',');
    		html += '<option value='+levelinfo[1] +',' +levelinfo[2] +','+levelinfo[3]+'>' + levelinfo[0] + '</option>';
    	}
    	jQuery('#hotellevel').html(html);
    	jQuery('#hotellevel').change();
    	return false;
    }
    jQuery('#book_adult_num').bind('keyup', function()
    		{
    			var adult_num = jQuery('#book_adult_num').val();
    			adult_num = parseInt(adult_num);
    			adult_num = isNaN(adult_num)?0:adult_num;
    			jQuery('#book_adult_num').val(adult_num);
    			jQuery('#book_adult_num2').html(adult_num);
    			booktotal();
    		});
    function booktotal()
    {
    	var adult_num = parseInt(jQuery('#book_adult_num').val());
    	adult_num = isNaN(adult_num)?0:adult_num;
    	var book_gold = parseFloat(jQuery('#book_price').html());
    	book_gold = isNaN(book_gold)? 0:book_gold;
    	var book_total = adult_num * book_gold;
    	jQuery('#book_total').html(book_total);
    	jQuery('#pay_total').html(book_total);
    }
    jQuery('#book_child_num').bind('keyup', function(){
    	var child_num = parseInt(jQuery('#book_child_num').val());
    	child_num = isNaN(child_num)?0:child_num;
	    jQuery('#book_child_num').val(child_num);
	    });
    //jQuery('#team_lang').change();
    jQuery('#hotellevel').change(findprice);
    function findprice(){
    	var levelinfo = jQuery('#hotellevel option:selected').val().split(',');
    	jQuery('#adult_price').html(levelinfo[1]);
    	jQuery('#child_price').html(levelinfo[2]);
    	jQuery('#team_price_id').val(levelinfo[0]);
    	jQuery('#adult_num').keyup();
    	return false;
    }
    //jQuery('#hotellevel').change();
    $('input#booksubmit').bind("click", function(){
    	var book_child_num = parseInt($('#book_child_num').val());
    	var book_adult_num = parseInt($('#book_adult_num').val());
    	var buy_num = book_child_num + book_adult_num;
    	buy_num = isNaN(buy_num)?0 : buy_num;
    	if(buy_num <= 0){
    		alert("亲，订购数量小于1，不能提交哦！");
    		return false;
    	}
        var per_num = parseInt($('#per_number').val());
        per_num = isNaN(per_num)?1:per_num;
        if (per_num!=0 && per_num <buy_num)
        {
        	alert("亲，买得太多了，少买点吧~");
        	return false;
        }
    	$('form').submit();
    });
    $('input#buysubmit').bind("click", largerThanZero);
    function largerThanZero() {
        var child_num = parseInt($('#child_num').val());
        var adult_num = parseInt($('#adult_num').val());
        buy_num =  child_num + adult_num;
        buy_num = isNaN(buy_num)?0:buy_num;
        if (buy_num <= 0) {
            alert("亲，订购数量小于1，不能提交哦~");
            return false
        } 
        var per_num = parseInt($('#per_number').val());
        per_num = isNaN(per_num)?1:per_num;
        if (per_num!=0 && per_num <buy_num)
        {
        	alert("亲，买得太多了，少买点吧~");
        	return false;
        }
        $('form.validator').submit();
    }
    
    $('#adult_num').bind("keyup", function(){
    	var adult_num = parseInt($('#adult_num').val());
    	 adult_num = isNaN(adult_num) ? 0 : adult_num;
         $('#adult_num').val(adult_num);
         calculateCost();
    	
    });
    $('#child_num').bind("keyup",  function(){
    	var child_num = parseInt($('#child_num').val());
    	child_num = isNaN(child_num) ? 0 : child_num;
        $('#child_num').val(child_num);
        calculateCost();
   	
   });
    for (i = 0; i < $('#discountNum').val(); i++) {
        $('#discount' + i).bind("keyup", calculateCost)
    }
    calculateCost();
    function calculateCost() {
        var adult_num = parseInt($('#adult_num').val());
        var child_num = parseInt($('#child_num').val());
       
        var adult_price = parseFloat($('#adult_price').html());
        var child_price = parseFloat($('#child_price').html());
        
        var deal_buy_total = adult_num * adult_price + child_num * child_price;
        $('#deal-buy-total').html(deal_buy_total);
       $('#deal-buy-total-t').html(deal_buy_total);
    }
};

window.x_init_hook_order = function() {
    jQuery('form[id="order-pay-form"]').bind('submit',
    function() {
        X.get(WEB_ROOT + '/ajax/order.php?action=dialog&id=' + jQuery(this).attr('sid'))
    })
};
X.misc = {};
X.misc.copyToCB = function(tid) {
    var o = jQuery('#' + tid);
    o.select();
    var maintext = o.val();
    if (window.clipboardData) {
        if ((window.clipboardData.setData("Text", maintext))) {
            var tip = o.attr('tip');
            if (tip) alert(tip);
            return true
        }
    } else if (window.netscape) {
        netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
        if (!clip) return;
        var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
        if (!trans) return;
        trans.addDataFlavor('text/unicode');
        var str = new Object();
        var len = new Object();
        var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
        var copytext = maintext;
        str.data = copytext;
        trans.setTransferData("text/unicode", str, copytext.length * 2);
        var clipid = Components.interfaces.nsIClipboard;
        if (!clip) return false;
        clip.setData(trans, null, clipid.kGlobalClipboard);
        var tip = o.attr('tip');
        if (tip) alert(tip);
        return true
    }
    return false
};
X.misc.scaleimage = function(o, mw) {
    var w = jQuery(o).width();
    if (w > mw) jQuery(o).css('width', mw + 'px')
};
X.misc.inputblur = function() {
    var v = jQuery(this).attr('value');
    var t = jQuery(this).attr('xtip');
    if (v == t || !v) {
        jQuery(this).attr('value', t);
        jQuery(this).css('color', '#999')
    }
};
X.misc.inputclick = function() {
    var v = jQuery(this).attr('value');
    var t = jQuery(this).attr('xtip');
    if (v == t) {
        jQuery(this).attr('value', '')
    }
    jQuery(this).css('color', '#333')
};
X.misc.noticenext = function(tid, nid) {
    jQuery('#dialog_subscribe_count_id').html(nid);
    return X.get(WEB_ROOT + '/ajax/manage.php?action=noticesubscribe&id=' + tid + '&nid=' + nid)
};
X.misc.noticenextsms = function(tid, nid) {
    jQuery('#dialog_smssubscribe_count_id').html(nid);
    return X.get(WEB_ROOT + '/ajax/manage.php?action=noticesmssubscribe&id=' + tid + '&nid=' + nid)
};
X.misc.noticesms = function(tid, nid) {
    jQuery('#dialog_sms_count_id').html(nid);
    return X.get(WEB_ROOT + '/ajax/manage.php?action=noticesms&id=' + tid + '&nid=' + nid)
};
X.misc.needlogin = function() {
    return LOGINUID > 0 ? true: !X.get(WEB_ROOT + '/ajax/system.php?action=needlogin')
};
X.misc.cardcode = function() {
    var oid = jQuery('#cardcode-order-id').attr('value');
    var cid = jQuery('#cardcode-card-id').attr('value');
    if (oid && cid) return ! X.get(WEB_ROOT + '/ajax/order.php?action=cardcode&id=' + oid + '&cid=' + cid)
};
X.misc.smscount = function() {
    var l = jQuery('#sms-content-id').val().length;
    var s = Math.ceil(l / 70);
    jQuery('#span-sms-length-id').html(l);
    jQuery('#span-sms-split-id').html(s)
};
X.misc.locale = function() {
    return X.get(WEB_ROOT + '/ajax/system.php?action=locale')
};
X.team = {};
X.team.consultation_again = function() {
    jQuery('#consult-content').val('');
    jQuery('#consult-add-form').slideToggle(1000);
    jQuery('#consult-add-succ').toggle()
};
X.team.changetype = function(type) {
    var display = (type == 'goods') ? 'none': 'block';
    if (type == 'goods') jQuery('#team-create-per-number').val('0');
    if (type != 'seconds') {
        jQuery('#team-create-begin-time').val(jQuery('#team-create-begin-time').attr('xd'));
        jQuery('#team-create-end-time').val(jQuery('#team-create-end-time').attr('xd'));
        jQuery('#team-create-begin-time').attr('maxLength', 10);
        jQuery('#team-create-end-time').attr('maxLength', 10)
    } else {
        jQuery('#team-create-begin-time').val(jQuery('#team-create-begin-time').attr('xd') + ' ' + jQuery('#team-create-begin-time').attr('xt'));
        jQuery('#team-create-end-time').val(jQuery('#team-create-end-time').attr('xd') + ' ' + jQuery('#team-create-end-time').attr('xt'));
        jQuery('#team-create-begin-time').attr('maxLength', 19);
        jQuery('#team-create-end-time').attr('maxLength', 19)
    }
    jQuery('#field_city').css('display', display);
    jQuery('#field_num').css('display', display);
    jQuery('#field_notice').css('display', display);
    jQuery('#field_card').css('display', display);
    jQuery('#field_userreview').css('display', display);
    jQuery('#field_systemreview').css('display', display);
    jQuery('#field_limit').css('display', display)
};
X.coupon = {};
X.coupon.dialogquery = function() {
    var id = jQuery('#coupon-dialog-input-id').attr('value');
    if (id) return ! X.get(WEB_ROOT + '/ajax/coupon.php?action=query&id=' + encodeURIComponent(id))
};
X.coupon.dialogconsume = function() {
    var id = jQuery('#coupon-dialog-input-id').attr('value');
    var secret = jQuery('#coupon-dialog-input-secret').attr('value');
    if (id && secret) {
        var ask = jQuery('#coupon-dialog-consume').attr('ask');
        return confirm(ask) && !X.get(WEB_ROOT + '/ajax/coupon.php?action=consume&id=' + encodeURIComponent(id) + '&secret=' + encodeURIComponent(secret))
    }
};
X.coupon.dialoginputkeyup = function(o) {
    jQuery(o).attr('value', jQuery(o).attr('value').toUpperCase())
};
X.manage = {};
X.manage.loadtemplate = function(id) {
    window.location.href = WEB_ROOT + '/manage/system/template.php?id=' + id
};
X.manage.loadpage = function(id) {
    window.location.href = WEB_ROOT + '/manage/system/page.php?id=' + id
};
X.manage.usermoney = function() {
    var money = parseFloat(jQuery('#user-dialog-input-id').attr('value'));
    var uid = jQuery('#user-dialog-input-id').attr('uid');
    var ask = jQuery('#user-dialog-input-id').attr('ask');
    if (uid && money && (!ask || confirm(ask))) return ! X.get(WEB_ROOT + '/ajax/manage.php?action=usermoney&id=' + uid + '&money=' + encodeURIComponent(money))
};
X.manage.orderexpress = function() {
    var eid = parseInt(jQuery('#order-dialog-select-id').val());
    var nid = jQuery('#order-dialog-input-id').attr('value');
    var oid = jQuery('#dialog-order-id').attr('oid');
    if (oid) return ! X.get(WEB_ROOT + '/ajax/manage.php?action=orderexpress&id=' + oid + '&eid=' + eid + '&nid=' + encodeURIComponent(nid))
};
X.manage.orderrefund = function() {
    var rid = jQuery('#order-dialog-refund-id').val();
    var oid = jQuery('#dialog-order-id').attr('oid');
    if (oid && rid) return ! X.get(WEB_ROOT + '/ajax/manage.php?action=orderrefund&id=' + oid + '&rid=' + rid)
};
X.manage.ordercash = function() {
	var oid = jQuery('#dialog-order-id').attr('oid');
	if (oid) return ! X.get(WEB_ROOT + '/ajax/manage.php?action=ordercash&id=' + oid);
}
X.manage.orderpay = function() {
	var oid = jQuery('#dialog-order-id').attr('oid');
	if (oid) return ! X.get(WEB_ROOT + '/ajax/manage.php?action=orderpay&id=' + oid);
}
X.manage.bookpay = function() {
	var oid = jQuery('#dialog-order-id').attr('oid');
	if (oid) return ! X.get(WEB_ROOT + '/ajax/manage.php?action=bookpay&id=' + oid);
}
X.manage.teamcoupon = function(tid) {
    return ! X.get(WEB_ROOT + '/ajax/manage.php?action=teamcoupon&id=' + tid)
};
X.miscajax = function(script, action) {
    return ! X.get(WEB_ROOT + '/ajax/' + script + '.php?action=' + action)
};
X.misc.multirotate = function(img, list) {
    var imgListCurr = 0;
    var imgListCount = jQuery('#' + list + ' a').size();
    if (imgListCount < 2) return;
    var imagesRun = function() {
        var imgListNext = imgListCurr + 1;
        if (imgListCurr == imgListCount - 1) imgListNext = 0;
        imagesPlay(imgListNext);
        imgListCurr++;
        if (imgListCurr > imgListCount - 1) {
            imgListCurr = 0;
            imgListNext = imgListCurr + 1
        }
    };
    jQuery('#' + img).everyTime(3000, 'imagerotate', imagesRun);
    jQuery('#' + img + ' li,#' + list + ' a').hover(function() {
        jQuery('#' + img).stopTime('imagerotate')
    },
    function() {
        jQuery('#' + img).everyTime(3000, 'imagerotate', imagesRun)
    });
    jQuery('#' + list + ' a').click(function() {
        var index = jQuery('#' + list + ' a').index(this);
        if (imgListCurr != index) {
            imagesPlay(index);
            imgListCurr = index
        };
        return false
    });
    var imagesPlay = function(next) {
        jQuery('#' + img + ' li').eq(imgListCurr).css({
            'opacity': '0.5'
        }).animate({
            'left': '-440px',
            'opacity': '1'
        },
        'slow',
        function() {
            jQuery(this).css({
                'left': '440px'
            })
        }).end().eq(next).animate({
            'left': '0px',
            'opacity': '1'
        },
        'slow',
        function() {
            jQuery('#' + list + ' a').siblings('a').removeClass('active').end().eq(next).addClass('active')
        })
    }
};
X.misc.multiclock = function(timeleft, counter) {
    var a = parseInt(jQuery("#" + timeleft).attr('diff'));
    if (!a > 0) return;
    var b = (new Date()).getTime();
    var e = function() {
        var c = (new Date()).getTime();
        var ls = a + b - c;
        if (ls > 0) {
            var ld = parseInt(ls / 86400000);
            ls = ls % 86400000;
            var lh = parseInt(ls / 3600000);
            ls = ls % 3600000;
            var lm = parseInt(ls / 60000);
            var ls = parseInt(Math.round(ls % 60000) / 1000);
            if (ld > 0) {
                var html = '<li><span>' + ld + '</span>å¤©</li><li><span>' + lh + '</span>å°æ—¶</li><li><span>' + lm + '</span>åˆ†é’Ÿ</li>'
            } else {
                var html = '<li><span>' + lh + '</span>å°æ—¶</li><li><span>' + lm + '</span>åˆ†é’Ÿ</li><li><span>' + ls + '</span>ç§’</li>'
            }
            jQuery("ul#" + counter).html(html)
        } else {
            jQuery("ul#" + counter).stopTime('"+counter');
            jQuery("ul#" + counter).html('end');
            window.location.reload()
        }
    };
    jQuery("ul#" + counter).everyTime(996, counter, e)
};
X.misc.captcha = function(id) {
    var x = typeof(id) == 'string' ? jQuery('#' + id) : jQuery(id);
    x.attr('src', WEB_ROOT + '/captcha.php?' + Math.random())
};
if (typeof deconcept == "undefined") {
    var deconcept = new Object()
}
if (typeof deconcept.util == "undefined") {
    deconcept.util = new Object()
}
if (typeof deconcept.SWFObjectUtil == "undefined") {
    deconcept.SWFObjectUtil = new Object()
}
deconcept.SWFObject = function(_1, id, w, h, _5, c, _7, _8, _9, _a, _b) {
    if (!document.createElement || !document.getElementById) {
        return
    }
    this.DETECT_KEY = _b ? _b: "detectflash";
    this.skipDetect = true;
    this.params = new Object();
    this.variables = new Object();
    this.attributes = new Array();
    if (_1) {
        this.setAttribute("swf", _1)
    }
    if (id) {
        this.setAttribute("id", id)
    }
    if (w) {
        this.setAttribute("width", w)
    }
    if (h) {
        this.setAttribute("height", h)
    }
    if (_5) {
        this.setAttribute("version", new deconcept.PlayerVersion(_5.toString().split(".")))
    }
    this.installedVer = deconcept.SWFObjectUtil.getPlayerVersion(this.getAttribute("version"), _7);
    if (c) {
        this.addParam("bgcolor", c)
    } else {
        this.addParam("wmode", "transparent")
    }
    var q = _8 ? _8: "high";
    this.addParam("quality", q);
    this.setAttribute("useExpressInstall", _7);
    this.setAttribute("doExpressInstall", false);
    var _d = (_9) ? _9: window.location;
    this.setAttribute("xiRedirectUrl", _d);
    this.setAttribute("redirectUrl", "");
    if (_a) {
        this.setAttribute("redirectUrl", _a)
    }
};
deconcept.SWFObject.prototype = {
    setAttribute: function(_e, _f) {
        this.attributes[_e] = _f
    },
    getAttribute: function(_10) {
        return this.attributes[_10]
    },
    addParam: function(_11, _12) {
        this.params[_11] = _12
    },
    getParams: function() {
        return this.params
    },
    addVariable: function(_13, _14) {
        this.variables[_13] = _14
    },
    getVariable: function(_15) {
        return this.variables[_15]
    },
    getVariables: function() {
        return this.variables
    },
    getVariablePairs: function() {
        var _16 = new Array();
        var key;
        var _18 = this.getVariables();
        for (key in _18) {
            _16.push(key + "=" + _18[key])
        }
        return _16
    },
    getSWFHTML: function() {
        var _19 = "";
        if (navigator.plugins && navigator.mimeTypes && navigator.mimeTypes.length) {
            if (this.getAttribute("doExpressInstall")) {
                this.addVariable("MMplayerType", "PlugIn")
            }
            _19 = "<embed type=\"application/x-shockwave-flash\" src=\"" + this.getAttribute("swf") + "\" width=\"" + this.getAttribute("width") + "\" height=\"" + this.getAttribute("height") + "\"";
            _19 += " id=\"" + this.getAttribute("id") + "\" name=\"" + this.getAttribute("id") + "\" ";
            var _1a = this.getParams();
            for (var key in _1a) {
                _19 += [key] + "=\"" + _1a[key] + "\" "
            }
            var _1c = this.getVariablePairs().join("&");
            if (_1c.length > 0) {
                _19 += "flashvars=\"" + _1c + "\""
            }
            _19 += " pluginspage=\"http://www.macromedia.com/go/getflashplayer\"/>"
        } else {
            if (this.getAttribute("doExpressInstall")) {
                this.addVariable("MMplayerType", "ActiveX")
            }
            _19 = "<object id=\"" + this.getAttribute("id") + "\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"" + this.getAttribute("width") + "\" height=\"" + this.getAttribute("height") + "\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\">";
            _19 += "<param name=\"movie\" value=\"" + this.getAttribute("swf") + "\" />";
            var _1d = this.getParams();
            for (var key in _1d) {
                _19 += "<param name=\"" + key + "\" value=\"" + _1d[key] + "\" />"
            }
            var _1f = this.getVariablePairs().join("&");
            if (_1f.length > 0) {
                _19 += "<param name=\"flashvars\" value=\"" + _1f + "\" />"
            }
            _19 += "</object>"
        }
        return _19
    },
    write: function(_20) {
        if (this.getAttribute("useExpressInstall")) {
            var _21 = new deconcept.PlayerVersion([6, 0, 65]);
            if (this.installedVer.versionIsValid(_21) && !this.installedVer.versionIsValid(this.getAttribute("version"))) {
                this.setAttribute("doExpressInstall", true);
                this.addVariable("MMredirectURL", escape(this.getAttribute("xiRedirectUrl")));
                document.title = document.title.slice(0, 47) + " - Flash Player Installation";
                this.addVariable("MMdoctitle", document.title)
            }
        }
        if (this.skipDetect || this.getAttribute("doExpressInstall") || this.installedVer.versionIsValid(this.getAttribute("version"))) {
            var n = (typeof _20 == "string") ? document.getElementById(_20) : _20;
            n.innerHTML = this.getSWFHTML();
            return true
        } else {
            if (this.getAttribute("redirectUrl") != "") {
                document.location.replace(this.getAttribute("redirectUrl"))
            }
        }
        return false
    }
};
deconcept.SWFObjectUtil.getPlayerVersion = function(_23, _24) {
    var _25 = new deconcept.PlayerVersion([0, 0, 0]);
    if (navigator.plugins && navigator.mimeTypes.length) {
        var x = navigator.plugins["Shockwave Flash"];
        if (x && x.description) {
            _25 = new deconcept.PlayerVersion(x.description.replace(/([a-z]|[A-Z]|\s)+/, "").replace(/(\s+r|\s+b[0-9]+)/, ".").split("."))
        }
    } else {
        try {
            var axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
            for (var i = 15; i > 6; i--) {
                try {
                    axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash." + i);
                    _25 = new deconcept.PlayerVersion([i, 0, 0]);
                    break
                } catch(e) {}
            }
        } catch(e) {}
        if (_23 && _25.major > _23.major) {
            return _25
        }
        if (!_23 || ((_23.minor != 0 || _23.rev != 0) && _25.major == _23.major) || _25.major != 6 || _24) {
            try {
                _25 = new deconcept.PlayerVersion(axo.GetVariable("$version").split(" ")[1].split(","))
            } catch(e) {}
        }
    }
    return _25
};
deconcept.PlayerVersion = function(_29) {
    this.major = parseInt(_29[0]) != null ? parseInt(_29[0]) : 0;
    this.minor = parseInt(_29[1]) || 0;
    this.rev = parseInt(_29[2]) || 0
};
deconcept.PlayerVersion.prototype.versionIsValid = function(fv) {
    if (this.major < fv.major) {
        return false
    }
    if (this.major > fv.major) {
        return true
    }
    if (this.minor < fv.minor) {
        return false
    }
    if (this.minor > fv.minor) {
        return true
    }
    if (this.rev < fv.rev) {
        return false
    }
    return true
};
deconcept.util = {
    getRequestParameter: function(_2b) {
        var q = document.location.search || document.location.hash;
        if (q) {
            var _2d = q.indexOf(_2b + "=");
            var _2e = (q.indexOf("&", _2d) > -1) ? q.indexOf("&", _2d) : q.length;
            if (q.length > 1 && _2d > -1) {
                return q.substring(q.indexOf("=", _2d) + 1, _2e)
            }
        }
        return ""
    }
};
if (Array.prototype.push == null) {
    Array.prototype.push = function(_2f) {
        this[this.length] = _2f;
        return this.length
    }
}
var getQueryParamValue = deconcept.util.getRequestParameter;
var FlashObject = deconcept.SWFObject;
var SWFObject = deconcept.SWFObject;
var hexcase = 0;
var b64pad = "";
function hex_md5(s) {
    return rstr2hex(rstr_md5(str2rstr_utf8(s)))
}
function b64_md5(s) {
    return rstr2b64(rstr_md5(str2rstr_utf8(s)))
}
function any_md5(s, e) {
    return rstr2any(rstr_md5(str2rstr_utf8(s)), e)
}
function hex_hmac_md5(k, d) {
    return rstr2hex(rstr_hmac_md5(str2rstr_utf8(k), str2rstr_utf8(d)))
}
function b64_hmac_md5(k, d) {
    return rstr2b64(rstr_hmac_md5(str2rstr_utf8(k), str2rstr_utf8(d)))
}
function any_hmac_md5(k, d, e) {
    return rstr2any(rstr_hmac_md5(str2rstr_utf8(k), str2rstr_utf8(d)), e)
}
function md5_vm_test() {
    return hex_md5("abc").toLowerCase() == "900150983cd24fb0d6963f7d28e17f72"
}
function rstr_md5(s) {
    return binl2rstr(binl_md5(rstr2binl(s), s.length * 8))
}
function rstr_hmac_md5(key, data) {
    var bkey = rstr2binl(key);
    if (bkey.length > 16) bkey = binl_md5(bkey, key.length * 8);
    var ipad = Array(16),
    opad = Array(16);
    for (var i = 0; i < 16; i++) {
        ipad[i] = bkey[i] ^ 0x36363636;
        opad[i] = bkey[i] ^ 0x5C5C5C5C
    }
    var hash = binl_md5(ipad.concat(rstr2binl(data)), 512 + data.length * 8);
    return binl2rstr(binl_md5(opad.concat(hash), 512 + 128))
}
function rstr2hex(input) {
    try {
        hexcase
    } catch(e) {
        hexcase = 0
    }
    var hex_tab = hexcase ? "0123456789ABCDEF": "0123456789abcdef";
    var output = "";
    var x;
    for (var i = 0; i < input.length; i++) {
        x = input.charCodeAt(i);
        output += hex_tab.charAt((x >>> 4) & 0x0F) + hex_tab.charAt(x & 0x0F)
    }
    return output
}
function rstr2b64(input) {
    try {
        b64pad
    } catch(e) {
        b64pad = ''
    }
    var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    var output = "";
    var len = input.length;
    for (var i = 0; i < len; i += 3) {
        var triplet = (input.charCodeAt(i) << 16) | (i + 1 < len ? input.charCodeAt(i + 1) << 8 : 0) | (i + 2 < len ? input.charCodeAt(i + 2) : 0);
        for (var j = 0; j < 4; j++) {
            if (i * 8 + j * 6 > input.length * 8) output += b64pad;
            else output += tab.charAt((triplet >>> 6 * (3 - j)) & 0x3F)
        }
    }
    return output
}
function rstr2any(input, encoding) {
    var divisor = encoding.length;
    var i, j, q, x, quotient;
    var dividend = Array(Math.ceil(input.length / 2));
    for (i = 0; i < dividend.length; i++) {
        dividend[i] = (input.charCodeAt(i * 2) << 8) | input.charCodeAt(i * 2 + 1)
    }
    var full_length = Math.ceil(input.length * 8 / (Math.log(encoding.length) / Math.log(2)));
    var remainders = Array(full_length);
    for (j = 0; j < full_length; j++) {
        quotient = Array();
        x = 0;
        for (i = 0; i < dividend.length; i++) {
            x = (x << 16) + dividend[i];
            q = Math.floor(x / divisor);
            x -= q * divisor;
            if (quotient.length > 0 || q > 0) quotient[quotient.length] = q
        }
        remainders[j] = x;
        dividend = quotient
    }
    var output = "";
    for (i = remainders.length - 1; i >= 0; i--) output += encoding.charAt(remainders[i]);
    return output
}
function str2rstr_utf8(input) {
    var output = "";
    var i = -1;
    var x, y;
    while (++i < input.length) {
        x = input.charCodeAt(i);
        y = i + 1 < input.length ? input.charCodeAt(i + 1) : 0;
        if (0xD800 <= x && x <= 0xDBFF && 0xDC00 <= y && y <= 0xDFFF) {
            x = 0x10000 + ((x & 0x03FF) << 10) + (y & 0x03FF);
            i++
        }
        if (x <= 0x7F) output += String.fromCharCode(x);
        else if (x <= 0x7FF) output += String.fromCharCode(0xC0 | ((x >>> 6) & 0x1F), 0x80 | (x & 0x3F));
        else if (x <= 0xFFFF) output += String.fromCharCode(0xE0 | ((x >>> 12) & 0x0F), 0x80 | ((x >>> 6) & 0x3F), 0x80 | (x & 0x3F));
        else if (x <= 0x1FFFFF) output += String.fromCharCode(0xF0 | ((x >>> 18) & 0x07), 0x80 | ((x >>> 12) & 0x3F), 0x80 | ((x >>> 6) & 0x3F), 0x80 | (x & 0x3F))
    }
    return output
}
function str2rstr_utf16le(input) {
    var output = "";
    for (var i = 0; i < input.length; i++) output += String.fromCharCode(input.charCodeAt(i) & 0xFF, (input.charCodeAt(i) >>> 8) & 0xFF);
    return output
}
function str2rstr_utf16be(input) {
    var output = "";
    for (var i = 0; i < input.length; i++) output += String.fromCharCode((input.charCodeAt(i) >>> 8) & 0xFF, input.charCodeAt(i) & 0xFF);
    return output
}
function rstr2binl(input) {
    var output = Array(input.length >> 2);
    for (var i = 0; i < output.length; i++) output[i] = 0;
    for (var i = 0; i < input.length * 8; i += 8) output[i >> 5] |= (input.charCodeAt(i / 8) & 0xFF) << (i % 32);
    return output
}
function binl2rstr(input) {
    var output = "";
    for (var i = 0; i < input.length * 32; i += 8) output += String.fromCharCode((input[i >> 5] >>> (i % 32)) & 0xFF);
    return output
}
function binl_md5(x, len) {
    x[len >> 5] |= 0x80 << ((len) % 32);
    x[(((len + 64) >>> 9) << 4) + 14] = len;
    var a = 1732584193;
    var b = -271733879;
    var c = -1732584194;
    var d = 271733878;
    for (var i = 0; i < x.length; i += 16) {
        var olda = a;
        var oldb = b;
        var oldc = c;
        var oldd = d;
        a = md5_ff(a, b, c, d, x[i + 0], 7, -680876936);
        d = md5_ff(d, a, b, c, x[i + 1], 12, -389564586);
        c = md5_ff(c, d, a, b, x[i + 2], 17, 606105819);
        b = md5_ff(b, c, d, a, x[i + 3], 22, -1044525330);
        a = md5_ff(a, b, c, d, x[i + 4], 7, -176418897);
        d = md5_ff(d, a, b, c, x[i + 5], 12, 1200080426);
        c = md5_ff(c, d, a, b, x[i + 6], 17, -1473231341);
        b = md5_ff(b, c, d, a, x[i + 7], 22, -45705983);
        a = md5_ff(a, b, c, d, x[i + 8], 7, 1770035416);
        d = md5_ff(d, a, b, c, x[i + 9], 12, -1958414417);
        c = md5_ff(c, d, a, b, x[i + 10], 17, -42063);
        b = md5_ff(b, c, d, a, x[i + 11], 22, -1990404162);
        a = md5_ff(a, b, c, d, x[i + 12], 7, 1804603682);
        d = md5_ff(d, a, b, c, x[i + 13], 12, -40341101);
        c = md5_ff(c, d, a, b, x[i + 14], 17, -1502002290);
        b = md5_ff(b, c, d, a, x[i + 15], 22, 1236535329);
        a = md5_gg(a, b, c, d, x[i + 1], 5, -165796510);
        d = md5_gg(d, a, b, c, x[i + 6], 9, -1069501632);
        c = md5_gg(c, d, a, b, x[i + 11], 14, 643717713);
        b = md5_gg(b, c, d, a, x[i + 0], 20, -373897302);
        a = md5_gg(a, b, c, d, x[i + 5], 5, -701558691);
        d = md5_gg(d, a, b, c, x[i + 10], 9, 38016083);
        c = md5_gg(c, d, a, b, x[i + 15], 14, -660478335);
        b = md5_gg(b, c, d, a, x[i + 4], 20, -405537848);
        a = md5_gg(a, b, c, d, x[i + 9], 5, 568446438);
        d = md5_gg(d, a, b, c, x[i + 14], 9, -1019803690);
        c = md5_gg(c, d, a, b, x[i + 3], 14, -187363961);
        b = md5_gg(b, c, d, a, x[i + 8], 20, 1163531501);
        a = md5_gg(a, b, c, d, x[i + 13], 5, -1444681467);
        d = md5_gg(d, a, b, c, x[i + 2], 9, -51403784);
        c = md5_gg(c, d, a, b, x[i + 7], 14, 1735328473);
        b = md5_gg(b, c, d, a, x[i + 12], 20, -1926607734);
        a = md5_hh(a, b, c, d, x[i + 5], 4, -378558);
        d = md5_hh(d, a, b, c, x[i + 8], 11, -2022574463);
        c = md5_hh(c, d, a, b, x[i + 11], 16, 1839030562);
        b = md5_hh(b, c, d, a, x[i + 14], 23, -35309556);
        a = md5_hh(a, b, c, d, x[i + 1], 4, -1530992060);
        d = md5_hh(d, a, b, c, x[i + 4], 11, 1272893353);
        c = md5_hh(c, d, a, b, x[i + 7], 16, -155497632);
        b = md5_hh(b, c, d, a, x[i + 10], 23, -1094730640);
        a = md5_hh(a, b, c, d, x[i + 13], 4, 681279174);
        d = md5_hh(d, a, b, c, x[i + 0], 11, -358537222);
        c = md5_hh(c, d, a, b, x[i + 3], 16, -722521979);
        b = md5_hh(b, c, d, a, x[i + 6], 23, 76029189);
        a = md5_hh(a, b, c, d, x[i + 9], 4, -640364487);
        d = md5_hh(d, a, b, c, x[i + 12], 11, -421815835);
        c = md5_hh(c, d, a, b, x[i + 15], 16, 530742520);
        b = md5_hh(b, c, d, a, x[i + 2], 23, -995338651);
        a = md5_ii(a, b, c, d, x[i + 0], 6, -198630844);
        d = md5_ii(d, a, b, c, x[i + 7], 10, 1126891415);
        c = md5_ii(c, d, a, b, x[i + 14], 15, -1416354905);
        b = md5_ii(b, c, d, a, x[i + 5], 21, -57434055);
        a = md5_ii(a, b, c, d, x[i + 12], 6, 1700485571);
        d = md5_ii(d, a, b, c, x[i + 3], 10, -1894986606);
        c = md5_ii(c, d, a, b, x[i + 10], 15, -1051523);
        b = md5_ii(b, c, d, a, x[i + 1], 21, -2054922799);
        a = md5_ii(a, b, c, d, x[i + 8], 6, 1873313359);
        d = md5_ii(d, a, b, c, x[i + 15], 10, -30611744);
        c = md5_ii(c, d, a, b, x[i + 6], 15, -1560198380);
        b = md5_ii(b, c, d, a, x[i + 13], 21, 1309151649);
        a = md5_ii(a, b, c, d, x[i + 4], 6, -145523070);
        d = md5_ii(d, a, b, c, x[i + 11], 10, -1120210379);
        c = md5_ii(c, d, a, b, x[i + 2], 15, 718787259);
        b = md5_ii(b, c, d, a, x[i + 9], 21, -343485551);
        a = safe_add(a, olda);
        b = safe_add(b, oldb);
        c = safe_add(c, oldc);
        d = safe_add(d, oldd)
    }
    return Array(a, b, c, d)
}
function md5_cmn(q, a, b, x, s, t) {
    return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s), b)
}
function md5_ff(a, b, c, d, x, s, t) {
    return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t)
}
function md5_gg(a, b, c, d, x, s, t) {
    return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t)
}
function md5_hh(a, b, c, d, x, s, t) {
    return md5_cmn(b ^ c ^ d, a, b, x, s, t)
}
function md5_ii(a, b, c, d, x, s, t) {
    return md5_cmn(c ^ (b | (~d)), a, b, x, s, t)
}
function safe_add(x, y) {
    var lsw = (x & 0xFFFF) + (y & 0xFFFF);
    var msw = (x >> 16) + (y >> 16) + (lsw >> 16);
    return (msw << 16) | (lsw & 0xFFFF)
}
function bit_rol(num, cnt) {
    return (num << cnt) | (num >>> (32 - cnt))
}
