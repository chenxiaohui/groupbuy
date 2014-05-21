(function() {
    var T = this,
    O, ag = T.jQuery,
    X = T.$,
    W = T.jQuery = T.$ = function(a, b) {
        return new W.fn.init(a, b);
    },
    L = /^[^<]*(<(.|\s)+>)[^>]*$|^#([\w-]+)$/,
    N = /^.[^:#\[\.,]*$/;
    W.fn = W.prototype = {
        init: function(a, d) {
            a = a || document;
            if (a.nodeType) {
                this[0] = a;
                this.length = 1;
                this.context = a;
                return this;
            }
            if (typeof a === "string") {
                var c = L.exec(a);
                if (c && (c[1] || !d)) {
                    if (c[1]) {
                        a = W.clean([c[1]], d);
                    } else {
                        var e = document.getElementById(c[3]);
                        if (e && e.id != c[3]) {
                            return W().find(a);
                        }
                        var b = W(e || []);
                        b.context = document;
                        b.selector = a;
                        return b;
                    }
                } else {
                    return W(d).find(a);
                }
            } else {
                if (W.isFunction(a)) {
                    return W(document).ready(a);
                }
            }
            if (a.selector && a.context) {
                this.selector = a.selector;
                this.context = a.context;
            }
            return this.setArray(W.isArray(a) ? a: W.makeArray(a));
        },
        selector: "",
        jquery: "1.3.2",
        size: function() {
            return this.length;
        },
        get: function(a) {
            return a === O ? Array.prototype.slice.call(this) : this[a];
        },
        pushStack: function(b, d, a) {
            var c = W(b);
            c.prevObject = this;
            c.context = this.context;
            if (d === "find") {
                c.selector = this.selector + (this.selector ? " ": "") + a;
            } else {
                if (d) {
                    c.selector = this.selector + "." + d + "(" + a + ")";
                }
            }
            return c;
        },
        setArray: function(a) {
            this.length = 0;
            Array.prototype.push.apply(this, a);
            return this;
        },
        each: function(b, a) {
            return W.each(this, b, a);
        },
        index: function(a) {
            return W.inArray(a && a.jquery ? a[0] : a, this);
        },
        attr: function(b, d, c) {
            var a = b;
            if (typeof b === "string") {
                if (d === O) {
                    return this[0] && W[c || "attr"](this[0], b);
                } else {
                    a = {};
                    a[b] = d;
                }
            }
            return this.each(function(e) {
                for (b in a) {
                    W.attr(c ? this.style: this, b, W.prop(this, a[b], c, e, b));
                }
            });
        },
        css: function(a, b) {
            if ((a == "width" || a == "height") && parseFloat(b) < 0) {
                b = O;
            }
            return this.attr(a, b, "curCSS");
        },
        text: function(b) {
            if (typeof b !== "object" && b != null) {
                return this.empty().append((this[0] && this[0].ownerDocument || document).createTextNode(b));
            }
            var a = "";
            W.each(b || this,
            function() {
                W.each(this.childNodes,
                function() {
                    if (this.nodeType != 8) {
                        a += this.nodeType != 1 ? this.nodeValue: W.fn.text([this]);
                    }
                });
            });
            return a;
        },
        wrapAll: function(a) {
            if (this[0]) {
                var b = W(a, this[0].ownerDocument).clone();
                if (this[0].parentNode) {
                    b.insertBefore(this[0]);
                }
                b.map(function() {
                    var c = this;
                    while (c.firstChild) {
                        c = c.firstChild;
                    }
                    return c;
                }).append(this);
            }
            return this;
        },
        wrapInner: function(a) {
            return this.each(function() {
                W(this).contents().wrapAll(a);
            });
        },
        wrap: function(a) {
            return this.each(function() {
                W(this).wrapAll(a);
            });
        },
        append: function() {
            return this.domManip(arguments, true,
            function(a) {
                if (this.nodeType == 1) {
                    this.appendChild(a);
                }
            });
        },
        prepend: function() {
            return this.domManip(arguments, true,
            function(a) {
                if (this.nodeType == 1) {
                    this.insertBefore(a, this.firstChild);
                }
            });
        },
        before: function() {
            return this.domManip(arguments, false,
            function(a) {
                this.parentNode.insertBefore(a, this);
            });
        },
        after: function() {
            return this.domManip(arguments, false,
            function(a) {
                this.parentNode.insertBefore(a, this.nextSibling);
            });
        },
        end: function() {
            return this.prevObject || W([]);
        },
        push: [].push,
        sort: [].sort,
        splice: [].splice,
        find: function(a) {
            if (this.length === 1) {
                var b = this.pushStack([], "find", a);
                b.length = 0;
                W.find(a, this[0], b);
                return b;
            } else {
                return this.pushStack(W.unique(W.map(this,
                function(c) {
                    return W.find(a, c);
                })), "find", a);
            }
        },
        clone: function(c) {
            var a = this.map(function() {
                if (!W.support.noCloneEvent && !W.isXMLDoc(this)) {
                    var e = this.outerHTML;
                    if (!e) {
                        var f = this.ownerDocument.createElement("div");
                        f.appendChild(this.cloneNode(true));
                        e = f.innerHTML;
                    }
                    return W.clean([e.replace(/ jQuery\d+="(?:\d+|null)"/g, "").replace(/^\s*/, "")])[0];
                } else {
                    return this.cloneNode(true);
                }
            });
            if (c === true) {
                var d = this.find("*").andSelf(),
                b = 0;
                a.find("*").andSelf().each(function() {
                    if (this.nodeName !== d[b].nodeName) {
                        return;
                    }
                    var e = W.data(d[b], "events");
                    for (var g in e) {
                        for (var f in e[g]) {
                            W.event.add(this, g, e[g][f], e[g][f].data);
                        }
                    }
                    b++;
                });
            }
            return a;
        },
        filter: function(a) {
            return this.pushStack(W.isFunction(a) && W.grep(this,
            function(c, b) {
                return a.call(c, b);
            }) || W.multiFilter(a, W.grep(this,
            function(b) {
                return b.nodeType === 1;
            })), "filter", a);
        },
        closest: function(a) {
            var c = W.expr.match.POS.test(a) ? W(a) : null,
            b = 0;
            return this.map(function() {
                var d = this;
                while (d && d.ownerDocument) {
                    if (c ? c.index(d) > -1 : W(d).is(a)) {
                        W.data(d, "closest", b);
                        return d;
                    }
                    d = d.parentNode;
                    b++;
                }
            });
        },
        not: function(a) {
            if (typeof a === "string") {
                if (N.test(a)) {
                    return this.pushStack(W.multiFilter(a, this, true), "not", a);
                } else {
                    a = W.multiFilter(a, this);
                }
            }
            var b = a.length && a[a.length - 1] !== O && !a.nodeType;
            return this.filter(function() {
                return b ? W.inArray(this, a) < 0 : this != a;
            });
        },
        add: function(a) {
            return this.pushStack(W.unique(W.merge(this.get(), typeof a === "string" ? W(a) : W.makeArray(a))));
        },
        is: function(a) {
            return !! a && W.multiFilter(a, this).length > 0;
        },
        hasClass: function(a) {
            return !! a && this.is("." + a);
        },
        val: function(g) {
            if (g === O) {
                var a = this[0];
                if (a) {
                    if (W.nodeName(a, "option")) {
                        return (a.attributes.value || {}).specified ? a.value: a.text;
                    }
                    if (W.nodeName(a, "select")) {
                        var e = a.selectedIndex,
                        h = [],
                        i = a.options,
                        d = a.type == "select-one";
                        if (e < 0) {
                            return null;
                        }
                        for (var b = d ? e: 0, f = d ? e + 1 : i.length; b < f; b++) {
                            var c = i[b];
                            if (c.selected) {
                                g = W(c).val();
                                if (d) {
                                    return g;
                                }
                                h.push(g);
                            }
                        }
                        return h;
                    }
                    return (a.value || "").replace(/\r/g, "");
                }
                return O;
            }
            if (typeof g === "number") {
                g += "";
            }
            return this.each(function() {
                if (this.nodeType != 1) {
                    return;
                }
                if (W.isArray(g) && /radio|checkbox/.test(this.type)) {
                    this.checked = (W.inArray(this.value, g) >= 0 || W.inArray(this.name, g) >= 0);
                } else {
                    if (W.nodeName(this, "select")) {
                        var j = W.makeArray(g);
                        W("option", this).each(function() {
                            this.selected = (W.inArray(this.value, j) >= 0 || W.inArray(this.text, j) >= 0);
                        });
                        if (!j.length) {
                            this.selectedIndex = -1;
                        }
                    } else {
                        this.value = g;
                    }
                }
            });
        },
        html: function(a) {
            return a === O ? (this[0] ? this[0].innerHTML.replace(/ jQuery\d+="(?:\d+|null)"/g, "") : null) : this.empty().append(a);
        },
        replaceWith: function(a) {
            return this.after(a).remove();
        },
        eq: function(a) {
            return this.slice(a, +a + 1);
        },
        slice: function() {
            return this.pushStack(Array.prototype.slice.apply(this, arguments), "slice", Array.prototype.slice.call(arguments).join(","));
        },
        map: function(a) {
            return this.pushStack(W.map(this,
            function(c, b) {
                return a.call(c, b, c);
            }));
        },
        andSelf: function() {
            return this.add(this.prevObject);
        },
        domManip: function(f, i, h) {
            if (this[0]) {
                var e = (this[0].ownerDocument || this[0]).createDocumentFragment(),
                b = W.clean(f, (this[0].ownerDocument || this[0]), e),
                d = e.firstChild;
                if (d) {
                    for (var c = 0, a = this.length; c < a; c++) {
                        h.call(g(this[c], d), this.length > 1 || c > 0 ? e.cloneNode(true) : e);
                    }
                }
                if (b) {
                    W.each(b, ah);
                }
            }
            return this;
            function g(j, k) {
                return i && W.nodeName(j, "table") && W.nodeName(k, "tr") ? (j.getElementsByTagName("tbody")[0] || j.appendChild(j.ownerDocument.createElement("tbody"))) : j;
            }
        }
    };
    W.fn.init.prototype = W.fn;
    function ah(a, b) {
        if (b.src) {
            W.ajax({
                url: b.src,
                async: false,
                dataType: "script"
            });
        } else {
            W.globalEval(b.text || b.textContent || b.innerHTML || "");
        }
        if (b.parentNode) {
            b.parentNode.removeChild(b);
        }
    }
    function M() {
        return + new Date;
    }
    W.extend = W.fn.extend = function() {
        var f = arguments[0] || {},
        d = 1,
        e = arguments.length,
        a = false,
        c;
        if (typeof f === "boolean") {
            a = f;
            f = arguments[1] || {};
            d = 2;
        }
        if (typeof f !== "object" && !W.isFunction(f)) {
            f = {};
        }
        if (e == d) {
            f = this; --d;
        }
        for (; d < e; d++) {
            if ((c = arguments[d]) != null) {
                for (var b in c) {
                    var g = f[b],
                    h = c[b];
                    if (f === h) {
                        continue;
                    }
                    if (a && h && typeof h === "object" && !h.nodeType) {
                        f[b] = W.extend(a, g || (h.length != null ? [] : {}), h);
                    } else {
                        if (h !== O) {
                            f[b] = h;
                        }
                    }
                }
            }
        }
        return f;
    };
    var G = /z-?index|font-?weight|opacity|zoom|line-?height/i,
    Y = document.defaultView || {},
    aa = Object.prototype.toString;
    W.extend({
        noConflict: function(a) {
            T.$ = X;
            if (a) {
                T.jQuery = ag;
            }
            return W;
        },
        isFunction: function(a) {
            return aa.call(a) === "[object Function]";
        },
        isArray: function(a) {
            return aa.call(a) === "[object Array]";
        },
        isXMLDoc: function(a) {
            return a.nodeType === 9 && a.documentElement.nodeName !== "HTML" || !!a.ownerDocument && W.isXMLDoc(a.ownerDocument);
        },
        globalEval: function(c) {
            if (c && /\S/.test(c)) {
                var b = document.getElementsByTagName("head")[0] || document.documentElement,
                a = document.createElement("script");
                a.type = "text/javascript";
                if (W.support.scriptEval) {
                    a.appendChild(document.createTextNode(c));
                } else {
                    a.text = c;
                }
                b.insertBefore(a, b.firstChild);
                b.removeChild(a);
            }
        },
        nodeName: function(b, a) {
            return b.nodeName && b.nodeName.toUpperCase() == a.toUpperCase();
        },
        each: function(c, g, b) {
            var a, d = 0,
            e = c.length;
            if (b) {
                if (e === O) {
                    for (a in c) {
                        if (g.apply(c[a], b) === false) {
                            break;
                        }
                    }
                } else {
                    for (; d < e;) {
                        if (g.apply(c[d++], b) === false) {
                            break;
                        }
                    }
                }
            } else {
                if (e === O) {
                    for (a in c) {
                        if (g.call(c[a], a, c[a]) === false) {
                            break;
                        }
                    }
                } else {
                    for (var f = c[0]; d < e && g.call(f, d, f) !== false; f = c[++d]) {}
                }
            }
            return c;
        },
        prop: function(d, e, c, b, a) {
            if (W.isFunction(e)) {
                e = e.call(d, b);
            }
            return typeof e === "number" && c == "curCSS" && !G.test(a) ? e + "px": e;
        },
        className: {
            add: function(a, b) {
                W.each((b || "").split(/\s+/),
                function(c, d) {
                    if (a.nodeType == 1 && !W.className.has(a.className, d)) {
                        a.className += (a.className ? " ": "") + d;
                    }
                });
            },
            remove: function(a, b) {
                if (a.nodeType == 1) {
                    a.className = b !== O ? W.grep(a.className.split(/\s+/),
                    function(c) {
                        return ! W.className.has(b, c);
                    }).join(" ") : "";
                }
            },
            has: function(b, a) {
                return b && W.inArray(a, (b.className || b).toString().split(/\s+/)) > -1;
            }
        },
        swap: function(d, c, e) {
            var a = {};
            for (var b in c) {
                a[b] = d.style[b];
                d.style[b] = c[b];
            }
            e.call(d);
            for (var b in c) {
                d.style[b] = a[b];
            }
        },
        css: function(d, b, f, a) {
            if (b == "width" || b == "height") {
                var h, c = {
                    position: "absolute",
                    visibility: "hidden",
                    display: "block"
                },
                g = b == "width" ? ["Left", "Right"] : ["Top", "Bottom"];
                function e() {
                    h = b == "width" ? d.offsetWidth: d.offsetHeight;
                    if (a === "border") {
                        return;
                    }
                    W.each(g,
                    function() {
                        if (!a) {
                            h -= parseFloat(W.curCSS(d, "padding" + this, true)) || 0;
                        }
                        if (a === "margin") {
                            h += parseFloat(W.curCSS(d, "margin" + this, true)) || 0;
                        } else {
                            h -= parseFloat(W.curCSS(d, "border" + this + "Width", true)) || 0;
                        }
                    });
                }
                if (d.offsetWidth !== 0) {
                    e();
                } else {
                    W.swap(d, c, e);
                }
                return Math.max(0, Math.round(h));
            }
            return W.curCSS(d, b, f);
        },
        curCSS: function(e, b, c) {
            var h, a = e.style;
            if (b == "opacity" && !W.support.opacity) {
                h = W.attr(a, "opacity");
                return h == "" ? "1": h;
            }
            if (b.match(/float/i)) {
                b = ae;
            }
            if (!c && a && a[b]) {
                h = a[b];
            } else {
                if (Y.getComputedStyle) {
                    if (b.match(/float/i)) {
                        b = "float";
                    }
                    b = b.replace(/([A-Z])/g, "-$1").toLowerCase();
                    var i = Y.getComputedStyle(e, null);
                    if (i) {
                        h = i.getPropertyValue(b);
                    }
                    if (b == "opacity" && h == "") {
                        h = "1";
                    }
                } else {
                    if (e.currentStyle) {
                        var f = b.replace(/\-(\w)/g,
                        function(j, k) {
                            return k.toUpperCase();
                        });
                        h = e.currentStyle[b] || e.currentStyle[f];
                        if (!/^\d+(px)?$/i.test(h) && /^\d/.test(h)) {
                            var d = a.left,
                            g = e.runtimeStyle.left;
                            e.runtimeStyle.left = e.currentStyle.left;
                            a.left = h || 0;
                            h = a.pixelLeft + "px";
                            a.left = d;
                            e.runtimeStyle.left = g;
                        }
                    }
                }
            }
            return h;
        },
        clean: function(b, g, e) {
            g = g || document;
            if (typeof g.createElement === "undefined") {
                g = g.ownerDocument || g[0] && g[0].ownerDocument || document;
            }
            if (!e && b.length === 1 && typeof b[0] === "string") {
                var d = /^<(\w+)\s*\/?>$/.exec(b[0]);
                if (d) {
                    return [g.createElement(d[1])];
                }
            }
            var c = [],
            a = [],
            h = g.createElement("div");
            W.each(b,
            function(l, o) {
                if (typeof o === "number") {
                    o += "";
                }
                if (!o) {
                    return;
                }
                if (typeof o === "string") {
                    o = o.replace(/(<(\w+)[^>]*?)\/>/g,
                    function(q, r, p) {
                        return p.match(/^(abbr|br|col|img|input|link|meta|param|hr|area|embed)$/i) ? q: r + "></" + p + ">";
                    });
                    var k = o.replace(/^\s+/, "").substring(0, 10).toLowerCase();
                    var m = !k.indexOf("<opt") && [1, "<select multiple='multiple'>", "</select>"] || !k.indexOf("<leg") && [1, "<fieldset>", "</fieldset>"] || k.match(/^<(thead|tbody|tfoot|colg|cap)/) && [1, "<table>", "</table>"] || !k.indexOf("<tr") && [2, "<table><tbody>", "</tbody></table>"] || (!k.indexOf("<td") || !k.indexOf("<th")) && [3, "<table><tbody><tr>", "</tr></tbody></table>"] || !k.indexOf("<col") && [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"] || !W.support.htmlSerialize && [1, "div<div>", "</div>"] || [0, "", ""];
                    h.innerHTML = m[1] + o + m[2];
                    while (m[0]--) {
                        h = h.lastChild;
                    }
                    if (!W.support.tbody) {
                        var n = /<tbody/i.test(o),
                        j = !k.indexOf("<table") && !n ? h.firstChild && h.firstChild.childNodes: m[1] == "<table>" && !n ? h.childNodes: [];
                        for (var i = j.length - 1; i >= 0; --i) {
                            if (W.nodeName(j[i], "tbody") && !j[i].childNodes.length) {
                                j[i].parentNode.removeChild(j[i]);
                            }
                        }
                    }
                    if (!W.support.leadingWhitespace && /^\s/.test(o)) {
                        h.insertBefore(g.createTextNode(o.match(/^\s*/)[0]), h.firstChild);
                    }
                    o = W.makeArray(h.childNodes);
                }
                if (o.nodeType) {
                    c.push(o);
                } else {
                    c = W.merge(c, o);
                }
            });
            if (e) {
                for (var f = 0; c[f]; f++) {
                    if (W.nodeName(c[f], "script") && (!c[f].type || c[f].type.toLowerCase() === "text/javascript")) {
                        a.push(c[f].parentNode ? c[f].parentNode.removeChild(c[f]) : c[f]);
                    } else {
                        if (c[f].nodeType === 1) {
                            c.splice.apply(c, [f + 1, 0].concat(W.makeArray(c[f].getElementsByTagName("script"))));
                        }
                        e.appendChild(c[f]);
                    }
                }
                return a;
            }
            return c;
        },
        attr: function(f, c, g) {
            if (!f || f.nodeType == 3 || f.nodeType == 8) {
                return O;
            }
            var d = !W.isXMLDoc(f),
            h = g !== O;
            c = d && W.props[c] || c;
            if (f.tagName) {
                var b = /href|src|style/.test(c);
                if (c == "selected" && f.parentNode) {
                    f.parentNode.selectedIndex;
                }
                if (c in f && d && !b) {
                    if (h) {
                        if (c == "type" && W.nodeName(f, "input") && f.parentNode) {
                            throw "type property can't be changed";
                        }
                        f[c] = g;
                    }
                    if (W.nodeName(f, "form") && f.getAttributeNode(c)) {
                        return f.getAttributeNode(c).nodeValue;
                    }
                    if (c == "tabIndex") {
                        var e = f.getAttributeNode("tabIndex");
                        return e && e.specified ? e.value: f.nodeName.match(/(button|input|object|select|textarea)/i) ? 0 : f.nodeName.match(/^(a|area)$/i) && f.href ? 0 : O;
                    }
                    return f[c];
                }
                if (!W.support.style && d && c == "style") {
                    return W.attr(f.style, "cssText", g);
                }
                if (h) {
                    f.setAttribute(c, "" + g);
                }
                var a = !W.support.hrefNormalized && d && b ? f.getAttribute(c, 2) : f.getAttribute(c);
                return a === null ? O: a;
            }
            if (!W.support.opacity && c == "opacity") {
                if (h) {
                    f.zoom = 1;
                    f.filter = (f.filter || "").replace(/alpha\([^)]*\)/, "") + (parseInt(g) + "" == "NaN" ? "": "alpha(opacity=" + g * 100 + ")");
                }
                return f.filter && f.filter.indexOf("opacity=") >= 0 ? (parseFloat(f.filter.match(/opacity=([^)]*)/)[1]) / 100) + "": "";
            }
            c = c.replace(/-([a-z])/ig,
            function(i, j) {
                return j.toUpperCase();
            });
            if (h) {
                f[c] = g;
            }
            return f[c];
        },
        trim: function(a) {
            return (a || "").replace(/^\s+|\s+$/g, "");
        },
        makeArray: function(c) {
            var a = [];
            if (c != null) {
                var b = c.length;
                if (b == null || typeof c === "string" || W.isFunction(c) || c.setInterval) {
                    a[0] = c;
                } else {
                    while (b) {
                        a[--b] = c[b];
                    }
                }
            }
            return a;
        },
        inArray: function(c, d) {
            for (var a = 0, b = d.length; a < b; a++) {
                if (d[a] === c) {
                    return a;
                }
            }
            return - 1;
        },
        merge: function(d, a) {
            var b = 0,
            c, e = d.length;
            if (!W.support.getAll) {
                while ((c = a[b++]) != null) {
                    if (c.nodeType != 8) {
                        d[e++] = c;
                    }
                }
            } else {
                while ((c = a[b++]) != null) {
                    d[e++] = c;
                }
            }
            return d;
        },
        unique: function(g) {
            var b = [],
            a = {};
            try {
                for (var c = 0, d = g.length; c < d; c++) {
                    var f = W.data(g[c]);
                    if (!a[f]) {
                        a[f] = true;
                        b.push(g[c]);
                    }
                }
            } catch(e) {
                b = g;
            }
            return b;
        },
        grep: function(b, f, a) {
            var c = [];
            for (var d = 0, e = b.length; d < e; d++) {
                if (!a != !f(b[d], d)) {
                    c.push(b[d]);
                }
            }
            return c;
        },
        map: function(a, f) {
            var b = [];
            for (var c = 0, d = a.length; c < d; c++) {
                var e = f(a[c], c);
                if (e != null) {
                    b[b.length] = e;
                }
            }
            return b.concat.apply([], b);
        }
    });
    var J = navigator.userAgent.toLowerCase();
    W.browser = {
        version: (J.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/) || [0, "0"])[1],
        safari: /webkit/.test(J),
        opera: /opera/.test(J),
        msie: /msie/.test(J) && !/opera/.test(J),
        mozilla: /mozilla/.test(J) && !/(compatible|webkit)/.test(J)
    };
    W.each({
        parent: function(a) {
            return a.parentNode;
        },
        parents: function(a) {
            return W.dir(a, "parentNode");
        },
        next: function(a) {
            return W.nth(a, 2, "nextSibling");
        },
        prev: function(a) {
            return W.nth(a, 2, "previousSibling");
        },
        nextAll: function(a) {
            return W.dir(a, "nextSibling");
        },
        prevAll: function(a) {
            return W.dir(a, "previousSibling");
        },
        siblings: function(a) {
            return W.sibling(a.parentNode.firstChild, a);
        },
        children: function(a) {
            return W.sibling(a.firstChild);
        },
        contents: function(a) {
            return W.nodeName(a, "iframe") ? a.contentDocument || a.contentWindow.document: W.makeArray(a.childNodes);
        }
    },
    function(a, b) {
        W.fn[a] = function(c) {
            var d = W.map(this, b);
            if (c && typeof c == "string") {
                d = W.multiFilter(c, d);
            }
            return this.pushStack(W.unique(d), a, c);
        };
    });
    W.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    },
    function(a, b) {
        W.fn[a] = function(c) {
            var f = [],
            h = W(c);
            for (var g = 0, d = h.length; g < d; g++) {
                var e = (g > 0 ? this.clone(true) : this).get();
                W.fn[b].apply(W(h[g]), e);
                f = f.concat(e);
            }
            return this.pushStack(f, a, c);
        };
    });
    W.each({
        removeAttr: function(a) {
            W.attr(this, a, "");
            if (this.nodeType == 1) {
                this.removeAttribute(a);
            }
        },
        addClass: function(a) {
            W.className.add(this, a);
        },
        removeClass: function(a) {
            W.className.remove(this, a);
        },
        toggleClass: function(b, a) {
            if (typeof a !== "boolean") {
                a = !W.className.has(this, b);
            }
            W.className[a ? "add": "remove"](this, b);
        },
        remove: function(a) {
            if (!a || W.filter(a, [this]).length) {
                W("*", this).add([this]).each(function() {
                    W.event.remove(this);
                    W.removeData(this);
                });
                if (this.parentNode) {
                    this.parentNode.removeChild(this);
                }
            }
        },
        empty: function() {
            W(this).children().remove();
            while (this.firstChild) {
                this.removeChild(this.firstChild);
            }
        }
    },
    function(a, b) {
        W.fn[a] = function() {
            return this.each(b, arguments);
        };
    });
    function R(a, b) {
        return a[0] && parseInt(W.curCSS(a[0], b, true), 10) || 0;
    }
    var P = "jQuery" + M(),
    ad = 0,
    F = {};
    W.extend({
        cache: {},
        data: function(b, a, c) {
            b = b == T ? F: b;
            var d = b[P];
            if (!d) {
                d = b[P] = ++ad;
            }
            if (a && !W.cache[d]) {
                W.cache[d] = {};
            }
            if (c !== O) {
                W.cache[d][a] = c;
            }
            return a ? W.cache[d][a] : d;
        },
        removeData: function(b, a) {
            b = b == T ? F: b;
            var d = b[P];
            if (a) {
                if (W.cache[d]) {
                    delete W.cache[d][a];
                    a = "";
                    for (a in W.cache[d]) {
                        break;
                    }
                    if (!a) {
                        W.removeData(b);
                    }
                }
            } else {
                try {
                    delete b[P];
                } catch(c) {
                    if (b.removeAttribute) {
                        b.removeAttribute(P);
                    }
                }
                delete W.cache[d];
            }
        },
        queue: function(b, a, d) {
            if (b) {
                a = (a || "fx") + "queue";
                var c = W.data(b, a);
                if (!c || W.isArray(d)) {
                    c = W.data(b, a, W.makeArray(d));
                } else {
                    if (d) {
                        c.push(d);
                    }
                }
            }
            return c;
        },
        dequeue: function(d, c) {
            var a = W.queue(d, c),
            b = a.shift();
            if (!c || c === "fx") {
                b = a[0];
            }
            if (b !== O) {
                b.call(d);
            }
        }
    });
    W.fn.extend({
        data: function(a, c) {
            var d = a.split(".");
            d[1] = d[1] ? "." + d[1] : "";
            if (c === O) {
                var b = this.triggerHandler("getData" + d[1] + "!", [d[0]]);
                if (b === O && this.length) {
                    b = W.data(this[0], a);
                }
                return b === O && d[1] ? this.data(d[0]) : b;
            } else {
                return this.trigger("setData" + d[1] + "!", [d[0], c]).each(function() {
                    W.data(this, a, c);
                });
            }
        },
        removeData: function(a) {
            return this.each(function() {
                W.removeData(this, a);
            });
        },
        queue: function(a, b) {
            if (typeof a !== "string") {
                b = a;
                a = "fx";
            }
            if (b === O) {
                return W.queue(this[0], a);
            }
            return this.each(function() {
                var c = W.queue(this, a, b);
                if (a == "fx" && c.length == 1) {
                    c[0].call(this);
                }
            });
        },
        dequeue: function(a) {
            return this.each(function() {
                W.dequeue(this, a);
            });
        }
    });
    (function() {
        var n = /((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^[\]]*\]|['"][^'"]*['"]|[^[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?/g,
        h = 0,
        d = Object.prototype.toString;
        var b = function(D, z, q, r) {
            q = q || [];
            z = z || document;
            if (z.nodeType !== 1 && z.nodeType !== 9) {
                return [];
            }
            if (!D || typeof D !== "string") {
                return q;
            }
            var ai = [],
            B,
            u,
            x,
            y,
            s,
            A,
            C = true;
            n.lastIndex = 0;
            while ((B = n.exec(D)) !== null) {
                ai.push(B[1]);
                if (B[2]) {
                    A = RegExp.rightContext;
                    break;
                }
            }
            if (ai.length > 1 && i.exec(D)) {
                if (ai.length === 2 && e.relative[ai[0]]) {
                    u = f(ai[0] + ai[1], z);
                } else {
                    u = e.relative[ai[0]] ? [z] : b(ai.shift(), z);
                    while (ai.length) {
                        D = ai.shift();
                        if (e.relative[D]) {
                            D += ai.shift();
                        }
                        u = f(D, u);
                    }
                }
            } else {
                var t = r ? {
                    expr: ai.pop(),
                    set: a(r)
                }: b.find(ai.pop(), ai.length === 1 && z.parentNode ? z.parentNode: z, m(z));
                u = b.filter(t.expr, t.set);
                if (ai.length > 0) {
                    x = a(u);
                } else {
                    C = false;
                }
                while (ai.length) {
                    var w = ai.pop(),
                    v = w;
                    if (!e.relative[w]) {
                        w = "";
                    } else {
                        v = ai.pop();
                    }
                    if (v == null) {
                        v = z;
                    }
                    e.relative[w](x, v, m(z));
                }
            }
            if (!x) {
                x = u;
            }
            if (!x) {
                throw "Syntax error, unrecognized expression: " + (w || D);
            }
            if (d.call(x) === "[object Array]") {
                if (!C) {
                    q.push.apply(q, x);
                } else {
                    if (z.nodeType === 1) {
                        for (var p = 0; x[p] != null; p++) {
                            if (x[p] && (x[p] === true || x[p].nodeType === 1 && g(z, x[p]))) {
                                q.push(u[p]);
                            }
                        }
                    } else {
                        for (var p = 0; x[p] != null; p++) {
                            if (x[p] && x[p].nodeType === 1) {
                                q.push(u[p]);
                            }
                        }
                    }
                }
            } else {
                a(x, q);
            }
            if (A) {
                b(A, z, q, r);
                if (c) {
                    hasDuplicate = false;
                    q.sort(c);
                    if (hasDuplicate) {
                        for (var p = 1; p < q.length; p++) {
                            if (q[p] === q[p - 1]) {
                                q.splice(p--, 1);
                            }
                        }
                    }
                }
            }
            return q;
        };
        b.matches = function(p, q) {
            return b(p, null, null, q);
        };
        b.find = function(p, r, q) {
            var x, v;
            if (!p) {
                return [];
            }
            for (var u = 0, t = e.order.length; u < t; u++) {
                var w = e.order[u],
                v;
                if ((v = e.match[w].exec(p))) {
                    var s = RegExp.leftContext;
                    if (s.substr(s.length - 1) !== "\\") {
                        v[1] = (v[1] || "").replace(/\\/g, "");
                        x = e.find[w](v, r, q);
                        if (x != null) {
                            p = p.replace(e.match[w], "");
                            break;
                        }
                    }
                }
            }
            if (!x) {
                x = r.getElementsByTagName("*");
            }
            return {
                set: x,
                expr: p
            };
        };
        b.filter = function(s, r, v, B) {
            var A = s,
            x = [],
            p = r,
            D,
            y,
            ai = r && r[0] && m(r[0]);
            while (s && r.length) {
                for (var q in e.filter) {
                    if ((D = e.match[q].exec(s)) != null) {
                        var z = e.filter[q],
                        w,
                        u;
                        y = false;
                        if (p == x) {
                            x = [];
                        }
                        if (e.preFilter[q]) {
                            D = e.preFilter[q](D, p, v, x, B, ai);
                            if (!D) {
                                y = w = true;
                            } else {
                                if (D === true) {
                                    continue;
                                }
                            }
                        }
                        if (D) {
                            for (var C = 0;
                            (u = p[C]) != null; C++) {
                                if (u) {
                                    w = z(u, D, C, p);
                                    var t = B ^ !!w;
                                    if (v && w != null) {
                                        if (t) {
                                            y = true;
                                        } else {
                                            p[C] = false;
                                        }
                                    } else {
                                        if (t) {
                                            x.push(u);
                                            y = true;
                                        }
                                    }
                                }
                            }
                        }
                        if (w !== O) {
                            if (!v) {
                                p = x;
                            }
                            s = s.replace(e.match[q], "");
                            if (!y) {
                                return [];
                            }
                            break;
                        }
                    }
                }
                if (s == A) {
                    if (y == null) {
                        throw "Syntax error, unrecognized expression: " + s;
                    } else {
                        break;
                    }
                }
                A = s;
            }
            return p;
        };
        var e = b.selectors = {
            order: ["ID", "NAME", "TAG"],
            match: {
                ID: /#((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,
                CLASS: /\.((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,
                NAME: /\[name=['"]*((?:[\w\u00c0-\uFFFF_-]|\\.)+)['"]*\]/,
                ATTR: /\[\s*((?:[\w\u00c0-\uFFFF_-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,
                TAG: /^((?:[\w\u00c0-\uFFFF\*_-]|\\.)+)/,
                CHILD: /:(only|nth|last|first)-child(?:\((even|odd|[\dn+-]*)\))?/,
                POS: /:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^-]|$)/,
                PSEUDO: /:((?:[\w\u00c0-\uFFFF_-]|\\.)+)(?:\((['"]*)((?:\([^\)]+\)|[^\2\(\)]*)+)\2\))?/
            },
            attrMap: {
                "class": "className",
                "for": "htmlFor"
            },
            attrHandle: {
                href: function(p) {
                    return p.getAttribute("href");
                }
            },
            relative: {
                "+": function(p, r, x) {
                    var v = typeof r === "string",
                    q = v && !/\W/.test(r),
                    w = v && !q;
                    if (q && !x) {
                        r = r.toUpperCase();
                    }
                    for (var u = 0, t = p.length, s; u < t; u++) {
                        if ((s = p[u])) {
                            while ((s = s.previousSibling) && s.nodeType !== 1) {}
                            p[u] = w || s && s.nodeName === r ? s || false: s === r;
                        }
                    }
                    if (w) {
                        b.filter(r, p, true);
                    }
                },
                ">": function(w, r, p) {
                    var u = typeof r === "string";
                    if (u && !/\W/.test(r)) {
                        r = p ? r: r.toUpperCase();
                        for (var s = 0, q = w.length; s < q; s++) {
                            var v = w[s];
                            if (v) {
                                var t = v.parentNode;
                                w[s] = t.nodeName === r ? t: false;
                            }
                        }
                    } else {
                        for (var s = 0, q = w.length; s < q; s++) {
                            var v = w[s];
                            if (v) {
                                w[s] = u ? v.parentNode: v.parentNode === r;
                            }
                        }
                        if (u) {
                            b.filter(r, w, true);
                        }
                    }
                },
                "": function(s, q, u) {
                    var r = h++,
                    p = o;
                    if (!q.match(/\W/)) {
                        var t = q = u ? q: q.toUpperCase();
                        p = l;
                    }
                    p("parentNode", q, r, s, t, u);
                },
                "~": function(s, q, u) {
                    var r = h++,
                    p = o;
                    if (typeof q === "string" && !q.match(/\W/)) {
                        var t = q = u ? q: q.toUpperCase();
                        p = l;
                    }
                    p("previousSibling", q, r, s, t, u);
                }
            },
            find: {
                ID: function(q, r, s) {
                    if (typeof r.getElementById !== "undefined" && !s) {
                        var p = r.getElementById(q[1]);
                        return p ? [p] : [];
                    }
                },
                NAME: function(r, u, v) {
                    if (typeof u.getElementsByName !== "undefined") {
                        var q = [],
                        t = u.getElementsByName(r[1]);
                        for (var s = 0, p = t.length; s < p; s++) {
                            if (t[s].getAttribute("name") === r[1]) {
                                q.push(t[s]);
                            }
                        }
                        return q.length === 0 ? null: q;
                    }
                },
                TAG: function(p, q) {
                    return q.getElementsByTagName(p[1]);
                }
            },
            preFilter: {
                CLASS: function(t, r, s, q, w, p) {
                    t = " " + t[1].replace(/\\/g, "") + " ";
                    if (p) {
                        return t;
                    }
                    for (var u = 0, v;
                    (v = r[u]) != null; u++) {
                        if (v) {
                            if (w ^ (v.className && (" " + v.className + " ").indexOf(t) >= 0)) {
                                if (!s) {
                                    q.push(v);
                                }
                            } else {
                                if (s) {
                                    r[u] = false;
                                }
                            }
                        }
                    }
                    return false;
                },
                ID: function(p) {
                    return p[1].replace(/\\/g, "");
                },
                TAG: function(q, p) {
                    for (var r = 0; p[r] === false; r++) {}
                    return p[r] && m(p[r]) ? q[1] : q[1].toUpperCase();
                },
                CHILD: function(p) {
                    if (p[1] == "nth") {
                        var q = /(-?)(\d*)n((?:\+|-)?\d*)/.exec(p[2] == "even" && "2n" || p[2] == "odd" && "2n+1" || !/\D/.test(p[2]) && "0n+" + p[2] || p[2]);
                        p[2] = (q[1] + (q[2] || 1)) - 0;
                        p[3] = q[3] - 0;
                    }
                    p[0] = h++;
                    return p;
                },
                ATTR: function(t, q, r, p, u, v) {
                    var s = t[1].replace(/\\/g, "");
                    if (!v && e.attrMap[s]) {
                        t[1] = e.attrMap[s];
                    }
                    if (t[2] === "~=") {
                        t[4] = " " + t[4] + " ";
                    }
                    return t;
                },
                PSEUDO: function(t, q, r, p, u) {
                    if (t[1] === "not") {
                        if (t[3].match(n).length > 1 || /^\w/.test(t[3])) {
                            t[3] = b(t[3], null, null, q);
                        } else {
                            var s = b.filter(t[3], q, r, true ^ u);
                            if (!r) {
                                p.push.apply(p, s);
                            }
                            return false;
                        }
                    } else {
                        if (e.match.POS.test(t[0]) || e.match.CHILD.test(t[0])) {
                            return true;
                        }
                    }
                    return t;
                },
                POS: function(p) {
                    p.unshift(true);
                    return p;
                }
            },
            filters: {
                enabled: function(p) {
                    return p.disabled === false && p.type !== "hidden";
                },
                disabled: function(p) {
                    return p.disabled === true;
                },
                checked: function(p) {
                    return p.checked === true;
                },
                selected: function(p) {
                    p.parentNode.selectedIndex;
                    return p.selected === true;
                },
                parent: function(p) {
                    return !! p.firstChild;
                },
                empty: function(p) {
                    return ! p.firstChild;
                },
                has: function(r, q, p) {
                    return !! b(p[3], r).length;
                },
                header: function(p) {
                    return /h\d/i.test(p.nodeName);
                },
                text: function(p) {
                    return "text" === p.type;
                },
                radio: function(p) {
                    return "radio" === p.type;
                },
                checkbox: function(p) {
                    return "checkbox" === p.type;
                },
                file: function(p) {
                    return "file" === p.type;
                },
                password: function(p) {
                    return "password" === p.type;
                },
                submit: function(p) {
                    return "submit" === p.type;
                },
                image: function(p) {
                    return "image" === p.type;
                },
                reset: function(p) {
                    return "reset" === p.type;
                },
                button: function(p) {
                    return "button" === p.type || p.nodeName.toUpperCase() === "BUTTON";
                },
                input: function(p) {
                    return /input|select|textarea|button/i.test(p.nodeName);
                }
            },
            setFilters: {
                first: function(q, p) {
                    return p === 0;
                },
                last: function(r, q, p, s) {
                    return q === s.length - 1;
                },
                even: function(q, p) {
                    return p % 2 === 0;
                },
                odd: function(q, p) {
                    return p % 2 === 1;
                },
                lt: function(r, q, p) {
                    return q < p[3] - 0;
                },
                gt: function(r, q, p) {
                    return q > p[3] - 0;
                },
                nth: function(r, q, p) {
                    return p[3] - 0 == q;
                },
                eq: function(r, q, p) {
                    return p[3] - 0 == q;
                }
            },
            filter: {
                PSEUDO: function(w, s, t, p) {
                    var r = s[1],
                    u = e.filters[r];
                    if (u) {
                        return u(w, t, s, p);
                    } else {
                        if (r === "contains") {
                            return (w.textContent || w.innerText || "").indexOf(s[3]) >= 0;
                        } else {
                            if (r === "not") {
                                var v = s[3];
                                for (var t = 0, q = v.length; t < q; t++) {
                                    if (v[t] === w) {
                                        return false;
                                    }
                                }
                                return true;
                            }
                        }
                    }
                },
                CHILD: function(s, v) {
                    var y = v[1],
                    t = s;
                    switch (y) {
                    case "only":
                    case "first":
                        while (t = t.previousSibling) {
                            if (t.nodeType === 1) {
                                return false;
                            }
                        }
                        if (y == "first") {
                            return true;
                        }
                        t = s;
                    case "last":
                        while (t = t.nextSibling) {
                            if (t.nodeType === 1) {
                                return false;
                            }
                        }
                        return true;
                    case "nth":
                        var u = v[2],
                        r = v[3];
                        if (u == 1 && r == 0) {
                            return true;
                        }
                        var x = v[0],
                        q = s.parentNode;
                        if (q && (q.sizcache !== x || !s.nodeIndex)) {
                            var w = 0;
                            for (t = q.firstChild; t; t = t.nextSibling) {
                                if (t.nodeType === 1) {
                                    t.nodeIndex = ++w;
                                }
                            }
                            q.sizcache = x;
                        }
                        var p = s.nodeIndex - r;
                        if (u == 0) {
                            return p == 0;
                        } else {
                            return (p % u == 0 && p / u >= 0);
                        }
                    }
                },
                ID: function(q, p) {
                    return q.nodeType === 1 && q.getAttribute("id") === p;
                },
                TAG: function(q, p) {
                    return (p === "*" && q.nodeType === 1) || q.nodeName === p;
                },
                CLASS: function(q, p) {
                    return (" " + (q.className || q.getAttribute("class")) + " ").indexOf(p) > -1;
                },
                ATTR: function(u, s) {
                    var r = s[1],
                    p = e.attrHandle[r] ? e.attrHandle[r](u) : u[r] != null ? u[r] : u.getAttribute(r),
                    v = p + "",
                    t = s[2],
                    q = s[4];
                    return p == null ? t === "!=": t === "=" ? v === q: t === "*=" ? v.indexOf(q) >= 0 : t === "~=" ? (" " + v + " ").indexOf(q) >= 0 : !q ? v && p !== false: t === "!=" ? v != q: t === "^=" ? v.indexOf(q) === 0 : t === "$=" ? v.substr(v.length - q.length) === q: t === "|=" ? v === q || v.substr(0, q.length + 1) === q + "-": false;
                },
                POS: function(t, q, r, u) {
                    var p = q[2],
                    s = e.setFilters[p];
                    if (s) {
                        return s(t, r, q, u);
                    }
                }
            }
        };
        var i = e.match.POS;
        for (var k in e.match) {
            e.match[k] = RegExp(e.match[k].source + /(?![^\[]*\])(?![^\(]*\))/.source);
        }
        var a = function(q, p) {
            q = Array.prototype.slice.call(q);
            if (p) {
                p.push.apply(p, q);
                return p;
            }
            return q;
        };
        try {
            Array.prototype.slice.call(document.documentElement.childNodes);
        } catch(j) {
            a = function(t, s) {
                var q = s || [];
                if (d.call(t) === "[object Array]") {
                    Array.prototype.push.apply(q, t);
                } else {
                    if (typeof t.length === "number") {
                        for (var r = 0, p = t.length; r < p; r++) {
                            q.push(t[r]);
                        }
                    } else {
                        for (var r = 0; t[r]; r++) {
                            q.push(t[r]);
                        }
                    }
                }
                return q;
            };
        }
        var c;
        if (document.documentElement.compareDocumentPosition) {
            c = function(q, p) {
                var r = q.compareDocumentPosition(p) & 4 ? -1 : q === p ? 0 : 1;
                if (r === 0) {
                    hasDuplicate = true;
                }
                return r;
            };
        } else {
            if ("sourceIndex" in document.documentElement) {
                c = function(q, p) {
                    var r = q.sourceIndex - p.sourceIndex;
                    if (r === 0) {
                        hasDuplicate = true;
                    }
                    return r;
                };
            } else {
                if (document.createRange) {
                    c = function(s, q) {
                        var r = s.ownerDocument.createRange(),
                        p = q.ownerDocument.createRange();
                        r.selectNode(s);
                        r.collapse(true);
                        p.selectNode(q);
                        p.collapse(true);
                        var t = r.compareBoundaryPoints(Range.START_TO_END, p);
                        if (t === 0) {
                            hasDuplicate = true;
                        }
                        return t;
                    };
                }
            }
        } (function() {
            var q = document.createElement("form"),
            r = "script" + (new Date).getTime();
            q.innerHTML = "<input name='" + r + "'/>";
            var p = document.documentElement;
            p.insertBefore(q, p.firstChild);
            if ( !! document.getElementById(r)) {
                e.find.ID = function(t, u, v) {
                    if (typeof u.getElementById !== "undefined" && !v) {
                        var s = u.getElementById(t[1]);
                        return s ? s.id === t[1] || typeof s.getAttributeNode !== "undefined" && s.getAttributeNode("id").nodeValue === t[1] ? [s] : O: [];
                    }
                };
                e.filter.ID = function(u, s) {
                    var t = typeof u.getAttributeNode !== "undefined" && u.getAttributeNode("id");
                    return u.nodeType === 1 && t && t.nodeValue === s;
                };
            }
            p.removeChild(q);
        })();
        (function() {
            var p = document.createElement("div");
            p.appendChild(document.createComment(""));
            if (p.getElementsByTagName("*").length > 0) {
                e.find.TAG = function(q, u) {
                    var t = u.getElementsByTagName(q[1]);
                    if (q[1] === "*") {
                        var s = [];
                        for (var r = 0; t[r]; r++) {
                            if (t[r].nodeType === 1) {
                                s.push(t[r]);
                            }
                        }
                        t = s;
                    }
                    return t;
                };
            }
            p.innerHTML = "<a href='#'></a>";
            if (p.firstChild && typeof p.firstChild.getAttribute !== "undefined" && p.firstChild.getAttribute("href") !== "#") {
                e.attrHandle.href = function(q) {
                    return q.getAttribute("href", 2);
                };
            }
        })();
        if (document.querySelectorAll) { (function() {
                var p = b,
                q = document.createElement("div");
                q.innerHTML = "<p class='TEST'></p>";
                if (q.querySelectorAll && q.querySelectorAll(".TEST").length === 0) {
                    return;
                }
                b = function(u, t, r, s) {
                    t = t || document;
                    if (!s && t.nodeType === 9 && !m(t)) {
                        try {
                            return a(t.querySelectorAll(u), r);
                        } catch(v) {}
                    }
                    return p(u, t, r, s);
                };
                b.find = p.find;
                b.filter = p.filter;
                b.selectors = p.selectors;
                b.matches = p.matches;
            })();
        }
        if (document.getElementsByClassName && document.documentElement.getElementsByClassName) { (function() {
                var p = document.createElement("div");
                p.innerHTML = "<div class='test e'></div><div class='test'></div>";
                if (p.getElementsByClassName("e").length === 0) {
                    return;
                }
                p.lastChild.className = "e";
                if (p.getElementsByClassName("e").length === 1) {
                    return;
                }
                e.order.splice(1, 0, "CLASS");
                e.find.CLASS = function(q, r, s) {
                    if (typeof r.getElementsByClassName !== "undefined" && !s) {
                        return r.getElementsByClassName(q[1]);
                    }
                };
            })();
        }
        function l(u, z, y, s, p, r) {
            var q = u == "previousSibling" && !r;
            for (var w = 0, v = s.length; w < v; w++) {
                var t = s[w];
                if (t) {
                    if (q && t.nodeType === 1) {
                        t.sizcache = y;
                        t.sizset = w;
                    }
                    t = t[u];
                    var x = false;
                    while (t) {
                        if (t.sizcache === y) {
                            x = s[t.sizset];
                            break;
                        }
                        if (t.nodeType === 1 && !r) {
                            t.sizcache = y;
                            t.sizset = w;
                        }
                        if (t.nodeName === z) {
                            x = t;
                            break;
                        }
                        t = t[u];
                    }
                    s[w] = x;
                }
            }
        }
        function o(u, z, y, s, p, r) {
            var q = u == "previousSibling" && !r;
            for (var w = 0, v = s.length; w < v; w++) {
                var t = s[w];
                if (t) {
                    if (q && t.nodeType === 1) {
                        t.sizcache = y;
                        t.sizset = w;
                    }
                    t = t[u];
                    var x = false;
                    while (t) {
                        if (t.sizcache === y) {
                            x = s[t.sizset];
                            break;
                        }
                        if (t.nodeType === 1) {
                            if (!r) {
                                t.sizcache = y;
                                t.sizset = w;
                            }
                            if (typeof z !== "string") {
                                if (t === z) {
                                    x = true;
                                    break;
                                }
                            } else {
                                if (b.filter(z, [t]).length > 0) {
                                    x = t;
                                    break;
                                }
                            }
                        }
                        t = t[u];
                    }
                    s[w] = x;
                }
            }
        }
        var g = document.compareDocumentPosition ?
        function(q, p) {
            return q.compareDocumentPosition(p) & 16;
        }: function(q, p) {
            return q !== p && (q.contains ? q.contains(p) : true);
        };
        var m = function(p) {
            return p.nodeType === 9 && p.documentElement.nodeName !== "HTML" || !!p.ownerDocument && m(p.ownerDocument);
        };
        var f = function(q, p) {
            var t = [],
            u = "",
            v,
            s = p.nodeType ? [p] : p;
            while ((v = e.match.PSEUDO.exec(q))) {
                u += v[0];
                q = q.replace(e.match.PSEUDO, "");
            }
            q = e.relative[q] ? q + "*": q;
            for (var w = 0, r = s.length; w < r; w++) {
                b(q, s[w], t);
            }
            return b.filter(u, t);
        };
        W.find = b;
        W.filter = b.filter;
        W.expr = b.selectors;
        W.expr[":"] = W.expr.filters;
        b.selectors.filters.hidden = function(p) {
            return p.offsetWidth === 0 || p.offsetHeight === 0;
        };
        b.selectors.filters.visible = function(p) {
            return p.offsetWidth > 0 || p.offsetHeight > 0;
        };
        b.selectors.filters.animated = function(p) {
            return W.grep(W.timers,
            function(q) {
                return p === q.elem;
            }).length;
        };
        W.multiFilter = function(r, p, q) {
            if (q) {
                r = ":not(" + r + ")";
            }
            return b.matches(r, p);
        };
        W.dir = function(r, q) {
            var p = [],
            s = r[q];
            while (s && s != document) {
                if (s.nodeType == 1) {
                    p.push(s);
                }
                s = s[q];
            }
            return p;
        };
        W.nth = function(t, p, r, s) {
            p = p || 1;
            var q = 0;
            for (; t; t = t[r]) {
                if (t.nodeType == 1 && ++q == p) {
                    break;
                }
            }
            return t;
        };
        W.sibling = function(r, q) {
            var p = [];
            for (; r; r = r.nextSibling) {
                if (r.nodeType == 1 && r != q) {
                    p.push(r);
                }
            }
            return p;
        };
        return;
        T.Sizzle = b;
    })();
    W.event = {
        add: function(e, b, d, g) {
            if (e.nodeType == 3 || e.nodeType == 8) {
                return;
            }
            if (e.setInterval && e != T) {
                e = T;
            }
            if (!d.guid) {
                d.guid = this.guid++;
            }
            if (g !== O) {
                var c = d;
                d = this.proxy(c);
                d.data = g;
            }
            var a = W.data(e, "events") || W.data(e, "events", {}),
            f = W.data(e, "handle") || W.data(e, "handle",
            function() {
                return typeof W !== "undefined" && !W.event.triggered ? W.event.handle.apply(arguments.callee.elem, arguments) : O;
            });
            f.elem = e;
            W.each(b.split(/\s+/),
            function(i, j) {
                var k = j.split(".");
                j = k.shift();
                d.type = k.slice().sort().join(".");
                var h = a[j];
                if (W.event.specialAll[j]) {
                    W.event.specialAll[j].setup.call(e, g, k);
                }
                if (!h) {
                    h = a[j] = {};
                    if (!W.event.special[j] || W.event.special[j].setup.call(e, g, k) === false) {
                        if (e.addEventListener) {
                            e.addEventListener(j, f, false);
                        } else {
                            if (e.attachEvent) {
                                e.attachEvent("on" + j, f);
                            }
                        }
                    }
                }
                h[d.guid] = d;
                W.event.global[j] = true;
            });
            e = null;
        },
        guid: 1,
        global: {},
        remove: function(g, d, f) {
            if (g.nodeType == 3 || g.nodeType == 8) {
                return;
            }
            var c = W.data(g, "events"),
            b,
            a;
            if (c) {
                if (d === O || (typeof d === "string" && d.charAt(0) == ".")) {
                    for (var e in c) {
                        this.remove(g, e + (d || ""));
                    }
                } else {
                    if (d.type) {
                        f = d.handler;
                        d = d.type;
                    }
                    W.each(d.split(/\s+/),
                    function(i, k) {
                        var m = k.split(".");
                        k = m.shift();
                        var j = RegExp("(^|\\.)" + m.slice().sort().join(".*\\.") + "(\\.|$)");
                        if (c[k]) {
                            if (f) {
                                delete c[k][f.guid];
                            } else {
                                for (var l in c[k]) {
                                    if (j.test(c[k][l].type)) {
                                        delete c[k][l];
                                    }
                                }
                            }
                            if (W.event.specialAll[k]) {
                                W.event.specialAll[k].teardown.call(g, m);
                            }
                            for (b in c[k]) {
                                break;
                            }
                            if (!b) {
                                if (!W.event.special[k] || W.event.special[k].teardown.call(g, m) === false) {
                                    if (g.removeEventListener) {
                                        g.removeEventListener(k, W.data(g, "handle"), false);
                                    } else {
                                        if (g.detachEvent) {
                                            g.detachEvent("on" + k, W.data(g, "handle"));
                                        }
                                    }
                                }
                                b = null;
                                delete c[k];
                            }
                        }
                    });
                }
                for (b in c) {
                    break;
                }
                if (!b) {
                    var h = W.data(g, "handle");
                    if (h) {
                        h.elem = null;
                    }
                    W.removeData(g, "events");
                    W.removeData(g, "handle");
                }
            }
        },
        trigger: function(e, g, d, a) {
            var c = e.type || e;
            if (!a) {
                e = typeof e === "object" ? e[P] ? e: W.extend(W.Event(c), e) : W.Event(c);
                if (c.indexOf("!") >= 0) {
                    e.type = c = c.slice(0, -1);
                    e.exclusive = true;
                }
                if (!d) {
                    e.stopPropagation();
                    if (this.global[c]) {
                        W.each(W.cache,
                        function() {
                            if (this.events && this.events[c]) {
                                W.event.trigger(e, g, this.handle.elem);
                            }
                        });
                    }
                }
                if (!d || d.nodeType == 3 || d.nodeType == 8) {
                    return O;
                }
                e.result = O;
                e.target = d;
                g = W.makeArray(g);
                g.unshift(e);
            }
            e.currentTarget = d;
            var f = W.data(d, "handle");
            if (f) {
                f.apply(d, g);
            }
            if ((!d[c] || (W.nodeName(d, "a") && c == "click")) && d["on" + c] && d["on" + c].apply(d, g) === false) {
                e.result = false;
            }
            if (!a && d[c] && !e.isDefaultPrevented() && !(W.nodeName(d, "a") && c == "click")) {
                this.triggered = true;
                try {
                    d[c]();
                } catch(h) {}
            }
            this.triggered = false;
            if (!e.isPropagationStopped()) {
                var b = d.parentNode || d.ownerDocument;
                if (b) {
                    W.event.trigger(e, g, b, true);
                }
            }
        },
        handle: function(g) {
            var f, a;
            g = arguments[0] = W.event.fix(g || T.event);
            g.currentTarget = this;
            var h = g.type.split(".");
            g.type = h.shift();
            f = !h.length && !g.exclusive;
            var e = RegExp("(^|\\.)" + h.slice().sort().join(".*\\.") + "(\\.|$)");
            a = (W.data(this, "events") || {})[g.type];
            for (var c in a) {
                var d = a[c];
                if (f || e.test(d.type)) {
                    g.handler = d;
                    g.data = d.data;
                    var b = d.apply(this, arguments);
                    if (b !== O) {
                        g.result = b;
                        if (b === false) {
                            g.preventDefault();
                            g.stopPropagation();
                        }
                    }
                    if (g.isImmediatePropagationStopped()) {
                        break;
                    }
                }
            }
        },
        props: "altKey attrChange attrName bubbles button cancelable charCode clientX clientY ctrlKey currentTarget data detail eventPhase fromElement handler keyCode metaKey newValue originalTarget pageX pageY prevValue relatedNode relatedTarget screenX screenY shiftKey srcElement target toElement view wheelDelta which".split(" "),
        fix: function(d) {
            if (d[P]) {
                return d;
            }
            var b = d;
            d = W.Event(b);
            for (var c = this.props.length, f; c;) {
                f = this.props[--c];
                d[f] = b[f];
            }
            if (!d.target) {
                d.target = d.srcElement || document;
            }
            if (d.target.nodeType == 3) {
                d.target = d.target.parentNode;
            }
            if (!d.relatedTarget && d.fromElement) {
                d.relatedTarget = d.fromElement == d.target ? d.toElement: d.fromElement;
            }
            if (d.pageX == null && d.clientX != null) {
                var e = document.documentElement,
                a = document.body;
                d.pageX = d.clientX + (e && e.scrollLeft || a && a.scrollLeft || 0) - (e.clientLeft || 0);
                d.pageY = d.clientY + (e && e.scrollTop || a && a.scrollTop || 0) - (e.clientTop || 0);
            }
            if (!d.which && ((d.charCode || d.charCode === 0) ? d.charCode: d.keyCode)) {
                d.which = d.charCode || d.keyCode;
            }
            if (!d.metaKey && d.ctrlKey) {
                d.metaKey = d.ctrlKey;
            }
            if (!d.which && d.button) {
                d.which = (d.button & 1 ? 1 : (d.button & 2 ? 3 : (d.button & 4 ? 2 : 0)));
            }
            return d;
        },
        proxy: function(b, a) {
            a = a ||
            function() {
                return b.apply(this, arguments);
            };
            a.guid = b.guid = b.guid || a.guid || this.guid++;
            return a;
        },
        special: {
            ready: {
                setup: H,
                teardown: function() {}
            }
        },
        specialAll: {
            live: {
                setup: function(a, b) {
                    W.event.add(this, b[0], I);
                },
                teardown: function(c) {
                    if (c.length) {
                        var a = 0,
                        b = RegExp("(^|\\.)" + c[0] + "(\\.|$)");
                        W.each((W.data(this, "events").live || {}),
                        function() {
                            if (b.test(this.type)) {
                                a++;
                            }
                        });
                        if (a < 1) {
                            W.event.remove(this, c[0], I);
                        }
                    }
                }
            }
        }
    };
    W.Event = function(a) {
        if (!this.preventDefault) {
            return new W.Event(a);
        }
        if (a && a.type) {
            this.originalEvent = a;
            this.type = a.type;
        } else {
            this.type = a;
        }
        this.timeStamp = M();
        this[P] = true;
    };
    function S() {
        return false;
    }
    function ac() {
        return true;
    }
    W.Event.prototype = {
        preventDefault: function() {
            this.isDefaultPrevented = ac;
            var a = this.originalEvent;
            if (!a) {
                return;
            }
            if (a.preventDefault) {
                a.preventDefault();
            }
            a.returnValue = false;
        },
        stopPropagation: function() {
            this.isPropagationStopped = ac;
            var a = this.originalEvent;
            if (!a) {
                return;
            }
            if (a.stopPropagation) {
                a.stopPropagation();
            }
            a.cancelBubble = true;
        },
        stopImmediatePropagation: function() {
            this.isImmediatePropagationStopped = ac;
            this.stopPropagation();
        },
        isDefaultPrevented: S,
        isPropagationStopped: S,
        isImmediatePropagationStopped: S
    };
    var E = function(b) {
        var a = b.relatedTarget;
        while (a && a != this) {
            try {
                a = a.parentNode;
            } catch(c) {
                a = this;
            }
        }
        if (a != this) {
            b.type = b.data;
            W.event.handle.apply(this, arguments);
        }
    };
    W.each({
        mouseover: "mouseenter",
        mouseout: "mouseleave"
    },
    function(b, a) {
        W.event.special[a] = {
            setup: function() {
                W.event.add(this, b, E, a);
            },
            teardown: function() {
                W.event.remove(this, b, E);
            }
        };
    });
    W.fn.extend({
        bind: function(b, c, a) {
            return b == "unload" ? this.one(b, c, a) : this.each(function() {
                W.event.add(this, b, a || c, a && c);
            });
        },
        one: function(c, d, b) {
            var a = W.event.proxy(b || d,
            function(e) {
                W(this).unbind(e, a);
                return (b || d).apply(this, arguments);
            });
            return this.each(function() {
                W.event.add(this, c, a, b && d);
            });
        },
        unbind: function(b, a) {
            return this.each(function() {
                W.event.remove(this, b, a);
            });
        },
        trigger: function(a, b) {
            return this.each(function() {
                W.event.trigger(a, b, this);
            });
        },
        triggerHandler: function(a, c) {
            if (this[0]) {
                var b = W.Event(a);
                b.preventDefault();
                b.stopPropagation();
                W.event.trigger(b, c, this[0]);
                return b.result;
            }
        },
        toggle: function(c) {
            var a = arguments,
            b = 1;
            while (b < a.length) {
                W.event.proxy(c, a[b++]);
            }
            return this.click(W.event.proxy(c,
            function(d) {
                this.lastToggle = (this.lastToggle || 0) % b;
                d.preventDefault();
                return a[this.lastToggle++].apply(this, arguments) || false;
            }));
        },
        hover: function(a, b) {
            return this.mouseenter(a).mouseleave(b);
        },
        ready: function(a) {
            H();
            if (W.isReady) {
                a.call(document, W);
            } else {
                W.readyList.push(a);
            }
            return this;
        },
        live: function(c, b) {
            var a = W.event.proxy(b);
            a.guid += this.selector + c;
            W(document).bind(Q(c, this.selector), this.selector, a);
            return this;
        },
        die: function(b, a) {
            W(document).unbind(Q(b, this.selector), a ? {
                guid: a.guid + this.selector + b
            }: null);
            return this;
        }
    });
    function I(d) {
        var a = RegExp("(^|\\.)" + d.type + "(\\.|$)"),
        c = true,
        b = [];
        W.each(W.data(this, "events").live || [],
        function(e, f) {
            if (a.test(f.type)) {
                var g = W(d.target).closest(f.data)[0];
                if (g) {
                    b.push({
                        elem: g,
                        fn: f
                    });
                }
            }
        });
        b.sort(function(f, e) {
            return W.data(f.elem, "closest") - W.data(e.elem, "closest");
        });
        W.each(b,
        function() {
            if (this.fn.call(this.elem, d, this.fn.data) === false) {
                return (c = false);
            }
        });
        return c;
    }
    function Q(b, a) {
        return ["live", b, a.replace(/\./g, "`").replace(/ /g, "|")].join(".");
    }
    W.extend({
        isReady: false,
        readyList: [],
        ready: function() {
            if (!W.isReady) {
                W.isReady = true;
                if (W.readyList) {
                    W.each(W.readyList,
                    function() {
                        this.call(document, W);
                    });
                    W.readyList = null;
                }
                W(document).triggerHandler("ready");
            }
        }
    });
    var af = false;
    function H() {
        if (af) {
            return;
        }
        af = true;
        if (document.addEventListener) {
            document.addEventListener("DOMContentLoaded",
            function() {
                document.removeEventListener("DOMContentLoaded", arguments.callee, false);
                W.ready();
            },
            false);
        } else {
            if (document.attachEvent) {
                document.attachEvent("onreadystatechange",
                function() {
                    if (document.readyState === "complete") {
                        document.detachEvent("onreadystatechange", arguments.callee);
                        W.ready();
                    }
                });
                if (document.documentElement.doScroll && T == T.top) { (function() {
                        if (W.isReady) {
                            return;
                        }
                        try {
                            document.documentElement.doScroll("left");
                        } catch(a) {
                            setTimeout(arguments.callee, 0);
                            return;
                        }
                        W.ready();
                    })();
                }
            }
        }
        W.event.add(T, "load", W.ready);
    }
    W.each(("blur,focus,load,resize,scroll,unload,click,dblclick,mousedown,mouseup,mousemove,mouseover,mouseout,mouseenter,mouseleave,change,select,submit,keydown,keypress,keyup,error").split(","),
    function(b, a) {
        W.fn[a] = function(c) {
            return c ? this.bind(a, c) : this.trigger(a);
        };
    });
    W(T).bind("unload",
    function() {
        for (var a in W.cache) {
            if (a != 1 && W.cache[a].handle) {
                W.event.remove(W.cache[a].handle.elem);
            }
        }
    });
    (function() {
        W.support = {};
        var b = document.documentElement,
        c = document.createElement("script"),
        g = document.createElement("div"),
        f = "script" + (new Date).getTime();
        g.style.display = "none";
        g.innerHTML = '   <link/><table></table><a href="/a" style="color:red;float:left;opacity:.5;">a</a><select><option>text</option></select><object><param/></object>';
        var d = g.getElementsByTagName("*"),
        a = g.getElementsByTagName("a")[0];
        if (!d || !d.length || !a) {
            return;
        }
        W.support = {
            leadingWhitespace: g.firstChild.nodeType == 3,
            tbody: !g.getElementsByTagName("tbody").length,
            objectAll: !!g.getElementsByTagName("object")[0].getElementsByTagName("*").length,
            htmlSerialize: !!g.getElementsByTagName("link").length,
            style: /red/.test(a.getAttribute("style")),
            hrefNormalized: a.getAttribute("href") === "/a",
            opacity: a.style.opacity === "0.5",
            cssFloat: !!a.style.cssFloat,
            scriptEval: false,
            noCloneEvent: true,
            boxModel: null
        };
        c.type = "text/javascript";
        try {
            c.appendChild(document.createTextNode("window." + f + "=1;"));
        } catch(e) {}
        b.insertBefore(c, b.firstChild);
        if (T[f]) {
            W.support.scriptEval = true;
            delete T[f];
        }
        b.removeChild(c);
        if (g.attachEvent && g.fireEvent) {
            g.attachEvent("onclick",
            function() {
                W.support.noCloneEvent = false;
                g.detachEvent("onclick", arguments.callee);
            });
            g.cloneNode(true).fireEvent("onclick");
        }
        W(function() {
            var h = document.createElement("div");
            h.style.width = h.style.paddingLeft = "1px";
            document.body.appendChild(h);
            W.boxModel = W.support.boxModel = h.offsetWidth === 2;
            document.body.removeChild(h).style.display = "none";
        });
    })();
    var ae = W.support.cssFloat ? "cssFloat": "styleFloat";
    W.props = {
        "for": "htmlFor",
        "class": "className",
        "float": ae,
        cssFloat: ae,
        styleFloat: ae,
        readonly: "readOnly",
        maxlength: "maxLength",
        cellspacing: "cellSpacing",
        rowspan: "rowSpan",
        tabindex: "tabIndex"
    };
    W.fn.extend({
        _load: W.fn.load,
        load: function(c, f, g) {
            if (typeof c !== "string") {
                return this._load(c);
            }
            var e = c.indexOf(" ");
            if (e >= 0) {
                var a = c.slice(e, c.length);
                c = c.slice(0, e);
            }
            var d = "GET";
            if (f) {
                if (W.isFunction(f)) {
                    g = f;
                    f = null;
                } else {
                    if (typeof f === "object") {
                        f = W.param(f);
                        d = "POST";
                    }
                }
            }
            var b = this;
            W.ajax({
                url: c,
                type: d,
                dataType: "html",
                data: f,
                complete: function(i, h) {
                    if (h == "success" || h == "notmodified") {
                        b.html(a ? W("<div/>").append(i.responseText.replace(/<script(.|\s)*?\/script>/g, "")).find(a) : i.responseText);
                    }
                    if (g) {
                        b.each(g, [i.responseText, h, i]);
                    }
                }
            });
            return this;
        },
        serialize: function() {
            return W.param(this.serializeArray());
        },
        serializeArray: function() {
            return this.map(function() {
                return this.elements ? W.makeArray(this.elements) : this;
            }).filter(function() {
                return this.name && !this.disabled && (this.checked || /select|textarea/i.test(this.nodeName) || /text|hidden|password|search/i.test(this.type));
            }).map(function(a, b) {
                var c = W(this).val();
                return c == null ? null: W.isArray(c) ? W.map(c,
                function(e, d) {
                    return {
                        name: b.name,
                        value: e
                    };
                }) : {
                    name: b.name,
                    value: c
                };
            }).get();
        }
    });
    W.each("ajaxStart,ajaxStop,ajaxComplete,ajaxError,ajaxSuccess,ajaxSend".split(","),
    function(a, b) {
        W.fn[b] = function(c) {
            return this.bind(b, c);
        };
    });
    var Z = M();
    W.extend({
        get: function(a, c, d, b) {
            if (W.isFunction(c)) {
                d = c;
                c = null;
            }
            return W.ajax({
                type: "GET",
                url: a,
                data: c,
                success: d,
                dataType: b
            });
        },
        getScript: function(a, b) {
            return W.get(a, null, b, "script");
        },
        getJSON: function(a, b, c) {
            return W.get(a, b, c, "json");
        },
        post: function(a, c, d, b) {
            if (W.isFunction(c)) {
                d = c;
                c = {};
            }
            return W.ajax({
                type: "POST",
                url: a,
                data: c,
                success: d,
                dataType: b
            });
        },
        ajaxSetup: function(a) {
            W.extend(W.ajaxSettings, a);
        },
        ajaxSettings: {
            url: location.href,
            global: true,
            type: "GET",
            contentType: "application/x-www-form-urlencoded",
            processData: true,
            async: true,
            xhr: function() {
                return T.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
            },
            accepts: {
                xml: "application/xml, text/xml",
                html: "text/html",
                script: "text/javascript, application/javascript",
                json: "application/json, text/javascript",
                text: "text/plain",
                _default: "*/*"
            }
        },
        lastModified: {},
        ajax: function(i) {
            i = W.extend(true, i, W.extend(true, {},
            W.ajaxSettings, i));
            var s, b = /=\?(&|$)/g,
            n, r, c = i.type.toUpperCase();
            if (i.data && i.processData && typeof i.data !== "string") {
                i.data = W.param(i.data);
            }
            if (i.dataType == "jsonp") {
                if (c == "GET") {
                    if (!i.url.match(b)) {
                        i.url += (i.url.match(/\?/) ? "&": "?") + (i.jsonp || "callback") + "=?";
                    }
                } else {
                    if (!i.data || !i.data.match(b)) {
                        i.data = (i.data ? i.data + "&": "") + (i.jsonp || "callback") + "=?";
                    }
                }
                i.dataType = "json";
            }
            if (i.dataType == "json" && (i.data && i.data.match(b) || i.url.match(b))) {
                s = "jsonp" + Z++;
                if (i.data) {
                    i.data = (i.data + "").replace(b, "=" + s + "$1");
                }
                i.url = i.url.replace(b, "=" + s + "$1");
                i.dataType = "script";
                T[s] = function(t) {
                    r = t;
                    e();
                    h();
                    T[s] = O;
                    try {
                        delete T[s];
                    } catch(u) {}
                    if (d) {
                        d.removeChild(p);
                    }
                };
            }
            if (i.dataType == "script" && i.cache == null) {
                i.cache = false;
            }
            if (i.cache === false && c == "GET") {
                var a = M();
                var q = i.url.replace(/(\?|&)_=.*?(&|$)/, "$1_=" + a + "$2");
                i.url = q + ((q == i.url) ? (i.url.match(/\?/) ? "&": "?") + "_=" + a: "");
            }
            if (i.data && c == "GET") {
                i.url += (i.url.match(/\?/) ? "&": "?") + i.data;
                i.data = null;
            }
            if (i.global && !W.active++) {
                W.event.trigger("ajaxStart");
            }
            var m = /^(\w+:)?\/\/([^\/?#]+)/.exec(i.url);
            if (i.dataType == "script" && c == "GET" && m && (m[1] && m[1] != location.protocol || m[2] != location.host)) {
                var d = document.getElementsByTagName("head")[0];
                var p = document.createElement("script");
                p.src = i.url;
                if (i.scriptCharset) {
                    p.charset = i.scriptCharset;
                }
                if (!s) {
                    var k = false;
                    p.onload = p.onreadystatechange = function() {
                        if (!k && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
                            k = true;
                            e();
                            h();
                            p.onload = p.onreadystatechange = null;
                            d.removeChild(p);
                        }
                    };
                }
                d.appendChild(p);
                return O;
            }
            var g = false;
            var f = i.xhr();
            if (i.username) {
                f.open(c, i.url, i.async, i.username, i.password);
            } else {
                f.open(c, i.url, i.async);
            }
            try {
                if (i.data) {
                    f.setRequestHeader("Content-Type", i.contentType);
                }
                if (i.ifModified) {
                    f.setRequestHeader("If-Modified-Since", W.lastModified[i.url] || "Thu, 01 Jan 1970 00:00:00 GMT");
                }
                f.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                f.setRequestHeader("Accept", i.dataType && i.accepts[i.dataType] ? i.accepts[i.dataType] + ", */*": i.accepts._default);
            } catch(o) {}
            if (i.beforeSend && i.beforeSend(f, i) === false) {
                if (i.global && !--W.active) {
                    W.event.trigger("ajaxStop");
                }
                f.abort();
                return false;
            }
            if (i.global) {
                W.event.trigger("ajaxSend", [f, i]);
            }
            var j = function(t) {
                if (f.readyState == 0) {
                    if (l) {
                        clearInterval(l);
                        l = null;
                        if (i.global && !--W.active) {
                            W.event.trigger("ajaxStop");
                        }
                    }
                } else {
                    if (!g && f && (f.readyState == 4 || t == "timeout")) {
                        g = true;
                        if (l) {
                            clearInterval(l);
                            l = null;
                        }
                        n = t == "timeout" ? "timeout": !W.httpSuccess(f) ? "error": i.ifModified && W.httpNotModified(f, i.url) ? "notmodified": "success";
                        if (n == "success") {
                            try {
                                r = W.httpData(f, i.dataType, i);
                            } catch(v) {
                                n = "parsererror";
                            }
                        }
                        if (n == "success") {
                            var u;
                            try {
                                u = f.getResponseHeader("Last-Modified");
                            } catch(v) {}
                            if (i.ifModified && u) {
                                W.lastModified[i.url] = u;
                            }
                            if (!s) {
                                e();
                            }
                        } else {
                            W.handleError(i, f, n);
                        }
                        h();
                        if (t) {
                            f.abort();
                        }
                        if (i.async) {
                            f = null;
                        }
                    }
                }
            };
            if (i.async) {
                var l = setInterval(j, 13);
                if (i.timeout > 0) {
                    setTimeout(function() {
                        if (f && !g) {
                            j("timeout");
                        }
                    },
                    i.timeout);
                }
            }
            try {
                f.send(i.data);
            } catch(o) {
                W.handleError(i, f, null, o);
            }
            if (!i.async) {
                j();
            }
            function e() {
                if (i.success) {
                    i.success(r, n);
                }
                if (i.global) {
                    W.event.trigger("ajaxSuccess", [f, i]);
                }
            }
            function h() {
                if (i.complete) {
                    i.complete(f, n);
                }
                if (i.global) {
                    W.event.trigger("ajaxComplete", [f, i]);
                }
                if (i.global && !--W.active) {
                    W.event.trigger("ajaxStop");
                }
            }
            return f;
        },
        handleError: function(b, d, a, c) {
            if (b.error) {
                b.error(d, a, c);
            }
            if (b.global) {
                W.event.trigger("ajaxError", [d, b, c]);
            }
        },
        active: 0,
        httpSuccess: function(b) {
            try {
                return ! b.status && location.protocol == "file:" || (b.status >= 200 && b.status < 300) || b.status == 304 || b.status == 1223;
            } catch(a) {}
            return false;
        },
        httpNotModified: function(c, a) {
            try {
                var d = c.getResponseHeader("Last-Modified");
                return c.status == 304 || d == W.lastModified[a];
            } catch(b) {}
            return false;
        },
        httpData: function(f, d, c) {
            var b = f.getResponseHeader("content-type"),
            a = d == "xml" || !d && b && b.indexOf("xml") >= 0,
            e = a ? f.responseXML: f.responseText;
            if (a && e.documentElement.tagName == "parsererror") {
                throw "parsererror";
            }
            if (c && c.dataFilter) {
                e = c.dataFilter(e, d);
            }
            if (typeof e === "string") {
                if (d == "script") {
                    W.globalEval(e);
                }
                if (d == "json") {
                    e = T["eval"]("(" + e + ")");
                }
            }
            return e;
        },
        param: function(a) {
            var c = [];
            function d(e, f) {
                c[c.length] = encodeURIComponent(e) + "=" + encodeURIComponent(f);
            }
            if (W.isArray(a) || a.jquery) {
                W.each(a,
                function() {
                    d(this.name, this.value);
                });
            } else {
                for (var b in a) {
                    if (W.isArray(a[b])) {
                        W.each(a[b],
                        function() {
                            d(b, this);
                        });
                    } else {
                        d(b, W.isFunction(a[b]) ? a[b]() : a[b]);
                    }
                }
            }
            return c.join("&").replace(/%20/g, "+");
        }
    });
    var U = {},
    V, K = [["height", "marginTop", "marginBottom", "paddingTop", "paddingBottom"], ["width", "marginLeft", "marginRight", "paddingLeft", "paddingRight"], ["opacity"]];
    function ab(b, a) {
        var c = {};
        W.each(K.concat.apply([], K.slice(0, a)),
        function() {
            c[this] = b;
        });
        return c;
    }
    W.fn.extend({
        show: function(f, h) {
            if (f) {
                return this.animate(ab("show", 3), f, h);
            } else {
                for (var d = 0, b = this.length; d < b; d++) {
                    var a = W.data(this[d], "olddisplay");
                    this[d].style.display = a || "";
                    if (W.css(this[d], "display") === "none") {
                        var c = this[d].tagName,
                        g;
                        if (U[c]) {
                            g = U[c];
                        } else {
                            var e = W("<" + c + " />").appendTo("body");
                            g = e.css("display");
                            if (g === "none") {
                                g = "block";
                            }
                            e.remove();
                            U[c] = g;
                        }
                        W.data(this[d], "olddisplay", g);
                    }
                }
                for (var d = 0, b = this.length; d < b; d++) {
                    this[d].style.display = W.data(this[d], "olddisplay") || "";
                }
                return this;
            }
        },
        hide: function(d, e) {
            if (d) {
                return this.animate(ab("hide", 3), d, e);
            } else {
                for (var c = 0, b = this.length; c < b; c++) {
                    var a = W.data(this[c], "olddisplay");
                    if (!a && a !== "none") {
                        W.data(this[c], "olddisplay", W.css(this[c], "display"));
                    }
                }
                for (var c = 0, b = this.length; c < b; c++) {
                    this[c].style.display = "none";
                }
                return this;
            }
        },
        _toggle: W.fn.toggle,
        toggle: function(c, b) {
            var a = typeof c === "boolean";
            return W.isFunction(c) && W.isFunction(b) ? this._toggle.apply(this, arguments) : c == null || a ? this.each(function() {
                var d = a ? c: W(this).is(":hidden");
                W(this)[d ? "show": "hide"]();
            }) : this.animate(ab("toggle", 3), c, b);
        },
        fadeTo: function(a, c, b) {
            return this.animate({
                opacity: c
            },
            a, b);
        },
        animate: function(e, b, d, c) {
            var a = W.speed(b, d, c);
            return this[a.queue === false ? "each": "queue"](function() {
                var g = W.extend({},
                a),
                i,
                h = this.nodeType == 1 && W(this).is(":hidden"),
                f = this;
                for (i in e) {
                    if (e[i] == "hide" && h || e[i] == "show" && !h) {
                        return g.complete.call(this);
                    }
                    if ((i == "height" || i == "width") && this.style) {
                        g.display = W.css(this, "display");
                        g.overflow = this.style.overflow;
                    }
                }
                if (g.overflow != null) {
                    this.style.overflow = "hidden";
                }
                g.curAnim = W.extend({},
                e);
                W.each(e,
                function(k, o) {
                    var n = new W.fx(f, g, k);
                    if (/toggle|show|hide/.test(o)) {
                        n[o == "toggle" ? h ? "show": "hide": o](e);
                    } else {
                        var m = o.toString().match(/^([+-]=)?([\d+-.]+)(.*)$/),
                        p = n.cur(true) || 0;
                        if (m) {
                            var j = parseFloat(m[2]),
                            l = m[3] || "px";
                            if (l != "px") {
                                f.style[k] = (j || 1) + l;
                                p = ((j || 1) / n.cur(true)) * p;
                                f.style[k] = p + l;
                            }
                            if (m[1]) {
                                j = ((m[1] == "-=" ? -1 : 1) * j) + p;
                            }
                            n.custom(p, j, l);
                        } else {
                            n.custom(p, o, "");
                        }
                    }
                });
                return true;
            });
        },
        stop: function(b, a) {
            var c = W.timers;
            if (b) {
                this.queue([]);
            }
            this.each(function() {
                for (var d = c.length - 1; d >= 0; d--) {
                    if (c[d].elem == this) {
                        if (a) {
                            c[d](true);
                        }
                        c.splice(d, 1);
                    }
                }
            });
            if (!a) {
                this.dequeue();
            }
            return this;
        }
    });
    W.each({
        slideDown: ab("show", 1),
        slideUp: ab("hide", 1),
        slideToggle: ab("toggle", 1),
        fadeIn: {
            opacity: "show"
        },
        fadeOut: {
            opacity: "hide"
        }
    },
    function(a, b) {
        W.fn[a] = function(c, d) {
            return this.animate(b, c, d);
        };
    });
    W.extend({
        speed: function(c, d, b) {
            var a = typeof c === "object" ? c: {
                complete: b || !b && d || W.isFunction(c) && c,
                duration: c,
                easing: b && d || d && !W.isFunction(d) && d
            };
            a.duration = W.fx.off ? 0 : typeof a.duration === "number" ? a.duration: W.fx.speeds[a.duration] || W.fx.speeds._default;
            a.old = a.complete;
            a.complete = function() {
                if (a.queue !== false) {
                    W(this).dequeue();
                }
                if (W.isFunction(a.old)) {
                    a.old.call(this);
                }
            };
            return a;
        },
        easing: {
            linear: function(c, d, a, b) {
                return a + b * c;
            },
            swing: function(c, d, a, b) {
                return (( - Math.cos(c * Math.PI) / 2) + 0.5) * b + a;
            }
        },
        timers: [],
        fx: function(b, a, c) {
            this.options = a;
            this.elem = b;
            this.prop = c;
            if (!a.orig) {
                a.orig = {};
            }
        }
    });
    W.fx.prototype = {
        update: function() {
            if (this.options.step) {
                this.options.step.call(this.elem, this.now, this);
            } (W.fx.step[this.prop] || W.fx.step._default)(this);
            if ((this.prop == "height" || this.prop == "width") && this.elem.style) {
                this.elem.style.display = "block";
            }
        },
        cur: function(b) {
            if (this.elem[this.prop] != null && (!this.elem.style || this.elem.style[this.prop] == null)) {
                return this.elem[this.prop];
            }
            var a = parseFloat(W.css(this.elem, this.prop, b));
            return a && a > -10000 ? a: parseFloat(W.curCSS(this.elem, this.prop)) || 0;
        },
        custom: function(e, d, c) {
            this.startTime = M();
            this.start = e;
            this.end = d;
            this.unit = c || this.unit || "px";
            this.now = this.start;
            this.pos = this.state = 0;
            var a = this;
            function b(f) {
                return a.step(f);
            }
            b.elem = this.elem;
            if (b() && W.timers.push(b) && !V) {
                V = setInterval(function() {
                    var g = W.timers;
                    for (var f = 0; f < g.length; f++) {
                        if (!g[f]()) {
                            g.splice(f--, 1);
                        }
                    }
                    if (!g.length) {
                        clearInterval(V);
                        V = O;
                    }
                },
                13);
            }
        },
        show: function() {
            this.options.orig[this.prop] = W.attr(this.elem.style, this.prop);
            this.options.show = true;
            this.custom(this.prop == "width" || this.prop == "height" ? 1 : 0, this.cur());
            W(this.elem).show();
        },
        hide: function() {
            this.options.orig[this.prop] = W.attr(this.elem.style, this.prop);
            this.options.hide = true;
            this.custom(this.cur(), 0);
        },
        step: function(d) {
            var c = M();
            if (d || c >= this.options.duration + this.startTime) {
                this.now = this.end;
                this.pos = this.state = 1;
                this.update();
                this.options.curAnim[this.prop] = true;
                var a = true;
                for (var b in this.options.curAnim) {
                    if (this.options.curAnim[b] !== true) {
                        a = false;
                    }
                }
                if (a) {
                    if (this.options.display != null) {
                        this.elem.style.overflow = this.options.overflow;
                        this.elem.style.display = this.options.display;
                        if (W.css(this.elem, "display") == "none") {
                            this.elem.style.display = "block";
                        }
                    }
                    if (this.options.hide) {
                        W(this.elem).hide();
                    }
                    if (this.options.hide || this.options.show) {
                        for (var e in this.options.curAnim) {
                            W.attr(this.elem.style, e, this.options.orig[e]);
                        }
                    }
                    this.options.complete.call(this.elem);
                }
                return false;
            } else {
                var f = c - this.startTime;
                this.state = f / this.options.duration;
                this.pos = W.easing[this.options.easing || (W.easing.swing ? "swing": "linear")](this.state, f, 0, 1, this.options.duration);
                this.now = this.start + ((this.end - this.start) * this.pos);
                this.update();
            }
            return true;
        }
    };
    W.extend(W.fx, {
        speeds: {
            slow: 600,
            fast: 200,
            _default: 400
        },
        step: {
            opacity: function(a) {
                W.attr(a.elem.style, "opacity", a.now);
            },
            _default: function(a) {
                if (a.elem.style && a.elem.style[a.prop] != null) {
                    a.elem.style[a.prop] = a.now + a.unit;
                } else {
                    a.elem[a.prop] = a.now;
                }
            }
        }
    });
    if (document.documentElement.getBoundingClientRect) {
        W.fn.offset = function() {
            if (!this[0]) {
                return {
                    top: 0,
                    left: 0
                };
            }
            if (this[0] === this[0].ownerDocument.body) {
                return W.offset.bodyOffset(this[0]);
            }
            var c = this[0].getBoundingClientRect(),
            f = this[0].ownerDocument,
            b = f.body,
            a = f.documentElement,
            h = a.clientTop || b.clientTop || 0,
            g = a.clientLeft || b.clientLeft || 0,
            e = c.top + (self.pageYOffset || W.boxModel && a.scrollTop || b.scrollTop) - h,
            d = c.left + (self.pageXOffset || W.boxModel && a.scrollLeft || b.scrollLeft) - g;
            return {
                top: e,
                left: d
            };
        };
    } else {
        W.fn.offset = function() {
            if (!this[0]) {
                return {
                    top: 0,
                    left: 0
                };
            }
            if (this[0] === this[0].ownerDocument.body) {
                return W.offset.bodyOffset(this[0]);
            }
            W.offset.initialized || W.offset.initialize();
            var f = this[0],
            c = f.offsetParent,
            b = f,
            k = f.ownerDocument,
            i,
            d = k.documentElement,
            g = k.body,
            h = k.defaultView,
            a = h.getComputedStyle(f, null),
            j = f.offsetTop,
            e = f.offsetLeft;
            while ((f = f.parentNode) && f !== g && f !== d) {
                i = h.getComputedStyle(f, null);
                j -= f.scrollTop,
                e -= f.scrollLeft;
                if (f === c) {
                    j += f.offsetTop,
                    e += f.offsetLeft;
                    if (W.offset.doesNotAddBorder && !(W.offset.doesAddBorderForTableAndCells && /^t(able|d|h)$/i.test(f.tagName))) {
                        j += parseInt(i.borderTopWidth, 10) || 0,
                        e += parseInt(i.borderLeftWidth, 10) || 0;
                    }
                    b = c,
                    c = f.offsetParent;
                }
                if (W.offset.subtractsBorderForOverflowNotVisible && i.overflow !== "visible") {
                    j += parseInt(i.borderTopWidth, 10) || 0,
                    e += parseInt(i.borderLeftWidth, 10) || 0;
                }
                a = i;
            }
            if (a.position === "relative" || a.position === "static") {
                j += g.offsetTop,
                e += g.offsetLeft;
            }
            if (a.position === "fixed") {
                j += Math.max(d.scrollTop, g.scrollTop),
                e += Math.max(d.scrollLeft, g.scrollLeft);
            }
            return {
                top: j,
                left: e
            };
        };
    }
    W.offset = {
        initialize: function() {
            if (this.initialized) {
                return;
            }
            var h = document.body,
            b = document.createElement("div"),
            d,
            c,
            j,
            e,
            i,
            a,
            f = h.style.marginTop,
            g = '<div style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;"><div></div></div><table style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;" cellpadding="0" cellspacing="0"><tr><td></td></tr></table>';
            i = {
                position: "absolute",
                top: 0,
                left: 0,
                margin: 0,
                border: 0,
                width: "1px",
                height: "1px",
                visibility: "hidden"
            };
            for (a in i) {
                b.style[a] = i[a];
            }
            b.innerHTML = g;
            h.insertBefore(b, h.firstChild);
            d = b.firstChild,
            c = d.firstChild,
            e = d.nextSibling.firstChild.firstChild;
            this.doesNotAddBorder = (c.offsetTop !== 5);
            this.doesAddBorderForTableAndCells = (e.offsetTop === 5);
            d.style.overflow = "hidden",
            d.style.position = "relative";
            this.subtractsBorderForOverflowNotVisible = (c.offsetTop === -5);
            h.style.marginTop = "1px";
            this.doesNotIncludeMarginInBodyOffset = (h.offsetTop === 0);
            h.style.marginTop = f;
            h.removeChild(b);
            this.initialized = true;
        },
        bodyOffset: function(a) {
            W.offset.initialized || W.offset.initialize();
            var c = a.offsetTop,
            b = a.offsetLeft;
            if (W.offset.doesNotIncludeMarginInBodyOffset) {
                c += parseInt(W.curCSS(a, "marginTop", true), 10) || 0,
                b += parseInt(W.curCSS(a, "marginLeft", true), 10) || 0;
            }
            return {
                top: c,
                left: b
            };
        }
    };
    W.fn.extend({
        position: function() {
            var e = 0,
            d = 0,
            b;
            if (this[0]) {
                var c = this.offsetParent(),
                f = this.offset(),
                a = /^body|html$/i.test(c[0].tagName) ? {
                    top: 0,
                    left: 0
                }: c.offset();
                f.top -= R(this, "marginTop");
                f.left -= R(this, "marginLeft");
                a.top += R(c, "borderTopWidth");
                a.left += R(c, "borderLeftWidth");
                b = {
                    top: f.top - a.top,
                    left: f.left - a.left
                };
            }
            return b;
        },
        offsetParent: function() {
            var a = this[0].offsetParent || document.body;
            while (a && (!/^body|html$/i.test(a.tagName) && W.css(a, "position") == "static")) {
                a = a.offsetParent;
            }
            return W(a);
        }
    });
    W.each(["Left", "Top"],
    function(b, a) {
        var c = "scroll" + a;
        W.fn[c] = function(d) {
            if (!this[0]) {
                return null;
            }
            return d !== O ? this.each(function() {
                this == T || this == document ? T.scrollTo(!b ? d: W(T).scrollLeft(), b ? d: W(T).scrollTop()) : this[c] = d;
            }) : this[0] == T || this[0] == document ? self[b ? "pageYOffset": "pageXOffset"] || W.boxModel && document.documentElement[c] || document.body[c] : this[0][c];
        };
    });
    W.each(["Height", "Width"],
    function(e, c) {
        var a = e ? "Left": "Top",
        d = e ? "Right": "Bottom",
        b = c.toLowerCase();
        W.fn["inner" + c] = function() {
            return this[0] ? W.css(this[0], b, false, "padding") : null;
        };
        W.fn["outer" + c] = function(g) {
            return this[0] ? W.css(this[0], b, false, g ? "margin": "border") : null;
        };
        var f = c.toLowerCase();
        W.fn[f] = function(g) {
            return this[0] == T ? document.compatMode == "CSS1Compat" && document.documentElement["client" + c] || document.body["client" + c] : this[0] == document ? Math.max(document.documentElement["client" + c], document.body["scroll" + c], document.documentElement["scroll" + c], document.body["offset" + c], document.documentElement["offset" + c]) : g === O ? (this.length ? W.css(this[0], f) : null) : this.css(f, typeof g === "string" ? g: g + "px");
        };
    });
})();
Function.prototype.bind = function() {
    var a = this,
    b = Array.from(arguments),
    c = b.shift();
    return function() {
        if (typeof Array.from == "function") {
            return a.apply(c, b.concat(Array.from(arguments)));
        }
    };
};
Function.prototype.bindAsEventListener = function(c) {
    var a = this,
    b = Array.from(arguments),
    c = b.shift();
    return function(d) {
        if (typeof Array.from == "function") {
            return a.apply(c, [d || window.event].concat(b));
        }
    };
};
var Class = {
    create: function() {
        return function() {
            this.initialize.apply(this, arguments);
        };
    }
};
Object.extend = function(a, c) {
    for (var b in c) {
        a[b] = c[b];
    }
    return a;
};
Object.clone = function(b) {
    var c;
    if (Object.isNull(b)) {
        return null;
    }
    if (b.constructor == Object) {
        c = new b.constructor();
    } else {
        c = new b.constructor(b.valueOf());
    }
    for (var a in b) {
        if (c[a] != b[a]) {
            if (typeof(b[a]) == "object") {
                c[a] = Object.clone(b[a]);
            } else {
                c[a] = b[a];
            }
        }
    }
    c.toString = b.toString;
    c.valueOf = b.valueOf;
    return c;
};
Object.isNull = function(a) {
    return typeof(a) == "undefined" || a == null;
};
Array.from = function(b) {
    if (!b) {
        return [];
    }
    if (b.toArray) {
        return b.toArray();
    } else {
        var d = [];
        for (var a = 0, c = b.length; a < c; a++) {
            d.push(b[a]);
        }
        return d;
    }
};
Object.extend(String, {
    interpret: function(a) {
        return a == null ? "": String(a);
    },
    specialChar: {
        "\b": "\\b",
        "\t": "\\t",
        "\n": "\\n",
        "\f": "\\f",
        "\r": "\\r",
        "\\": "\\\\"
    }
});
Object.extend(String.prototype, {
    trim: function() {
        return this.replace(/(^[\s　]*)|([\s　]*$)/g, "");
    },
    lTrim: function() {
        return this.replace(/(^[\s　]*)/g, "");
    },
    rTrim: function() {
        return this.replace(/([\s　]*$)/g, "");
    },
    bytelength: function() {
        var a = this.match(/[^\x00-\xff]/ig);
        return this.length + (a == null ? 0 : a.length);
    },
    cut: function(a) {
        if (a > this.length) {
            return this;
        }
        return this.substring(0, a);
    },
    formatWithWBR: function() {
        var a = arguments,
        h = 10;
        if (a.length > 0) {
            var b = parseInt(a[0]);
            if (!isNaN(b) && b > 0) {
                h = b;
            }
        }
        var k = this,
        f = [],
        j = 0,
        g = 0,
        e;
        for (var d = 1, c = k.length; d < c; d++) {
            e = k.charAt(d);
            if (/\s/.test(e)) {
                g = d;
            } else {
                if ((d - g) == h) {
                    f.push(k.substring(j, d));
                    f.push("<wbr>");
                    j = g = d;
                }
            }
        }
        f.push(k.substr(j));
        return f.join("");
    },
    gsub: function(b, c) {
        var d = "",
        e = this,
        a;
        c = arguments.callee.prepareReplacement(c);
        while (e.length > 0) {
            if (a = e.match(b)) {
                d += e.slice(0, a.index);
                d += String.interpret(c(a));
                e = e.slice(a.index + a[0].length);
            } else {
                d += e,
                e = "";
            }
        }
        return d;
    },
    sub: function(b, c, a) {
        c = this.gsub.prepareReplacement(c);
        a = a === undefined ? 1 : a;
        return this.gsub(b,
        function(d) {
            if (--a < 0) {
                return d[0];
            }
            return c(d);
        });
    },
    scan: function(b, a) {
        this.gsub(b, a);
        return this;
    },
    truncate: function(a, b) {
        a = a || 30;
        b = b === undefined ? "...": b;
        return this.length > a ? this.slice(0, a - b.length) + b: this;
    },
    strip: function() {
        return this.replace(/^\s+/, "").replace(/\s+$/, "");
    },
    stripTags: function() {
        return this.replace(/<\/?[^>]+>/gi, "");
    },
    stripScripts: function() {
        return this.replace(new RegExp(Prototype.ScriptFragment, "img"), "");
    },
    extractScripts: function() {
        var a = new RegExp(Prototype.ScriptFragment, "img");
        var b = new RegExp(Prototype.ScriptFragment, "im");
        return (this.match(a) || []).map(function(c) {
            return (c.match(b) || ["", ""])[1];
        });
    },
    evalScripts: function() {
        return this.extractScripts().map(function(script) {
            return eval(script);
        });
    },
    escapeHTML: function() {
        var a = arguments.callee;
        a.text.data = this;
        return a.div.innerHTML;
    },
    unescapeHTML: function() {
        var a = document.createElement("div");
        a.innerHTML = this.stripTags();
        return a.childNodes[0] ? (a.childNodes.length > 1 ? $A(a.childNodes).inject("",
        function(b, c) {
            return b + c.nodeValue;
        }) : a.childNodes[0].nodeValue) : "";
    },
    toQueryParams: function(b) {
        var a = this.strip().match(/([^?#]*)(#.*)?$/);
        if (!a) {
            return {};
        }
        return a[1].split(b || "&").inject({},
        function(c, e) {
            if ((e = e.split("="))[0]) {
                var d = decodeURIComponent(e.shift());
                var f = e.length > 1 ? e.join("=") : e[0];
                if (f != undefined) {
                    f = decodeURIComponent(f);
                }
                if (d in c) {
                    if (c[d].constructor != Array) {
                        c[d] = [c[d]];
                    }
                    c[d].push(f);
                } else {
                    c[d] = f;
                }
            }
            return c;
        });
    },
    toArray: function() {
        return this.split("");
    },
    succ: function() {
        return this.slice(0, this.length - 1) + String.fromCharCode(this.charCodeAt(this.length - 1) + 1);
    },
    times: function(a) {
        var c = "";
        for (var b = 0; b < a; b++) {
            c += this;
        }
        return c;
    },
    camelize: function() {
        var d = this.split("-"),
        c = d.length;
        if (c == 1) {
            return d[0];
        }
        var a = this.charAt(0) == "-" ? d[0].charAt(0).toUpperCase() + d[0].substring(1) : d[0];
        for (var b = 1; b < c; b++) {
            a += d[b].charAt(0).toUpperCase() + d[b].substring(1);
        }
        return a;
    },
    capitalize: function() {
        return this.charAt(0).toUpperCase() + this.substring(1).toLowerCase();
    },
    underscore: function() {
        return this.gsub(/::/, "/").gsub(/([A-Z]+)([A-Z][a-z])/, "#{1}_#{2}").gsub(/([a-z\d])([A-Z])/, "#{1}_#{2}").gsub(/-/, "_").toLowerCase();
    },
    dasherize: function() {
        return this.gsub(/_/, "-");
    },
    inspect: function(b) {
        var a = this.gsub(/[\x00-\x1f\\]/,
        function(d) {
            var c = String.specialChar[d[0]];
            return c ? c: "\\u00" + d[0].charCodeAt().toPaddedString(2, 16);
        });
        if (b) {
            return '"' + a.replace(/"/g, '\\"') + '"';
        }
        return "'" + a.replace(/'/g, "\\'") + "'";
    },
    toJSON: function() {
        return this.inspect(true);
    },
    unfilterJSON: function(a) {
        return this.sub(a || Prototype.JSONFilter, "#{1}");
    },
    isJSON: function() {
        var a = this.replace(/\\./g, "@").replace(/"[^"\\\n\r]*"/g, "");
        return (/^[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]*$/).test(a);
    },
    evalJSON: function(sanitize) {
        var json = this.unfilterJSON();
        try {
            if (!sanitize || json.isJSON()) {
                return eval("(" + json + ")");
            }
        } catch(e) {}
        throw new SyntaxError("Badly formed JSON string: " + this.inspect());
    },
    include: function(a) {
        return this.indexOf(a) > -1;
    },
    startsWith: function(a) {
        return this.indexOf(a) === 0;
    },
    endsWith: function(b) {
        var a = this.length - b.length;
        return a >= 0 && this.lastIndexOf(b) === a;
    },
    empty: function() {
        return this.trim() == "";
    },
    blank: function() {
        return /^\s*$/.test(this);
    }
});
String.isNullOrEmpty = function(a) {
    return a == undefined || a == null || a.empty();
};
String.format = function() {
    var b = arguments,
    c = b.length;
    if (c == 0) {
        return "";
    }
    if (c == 1) {
        return b[0];
    }
    var d = /{(\d+)?}/g,
    a, e;
    if (b[1] instanceof Array) {
        a = b[1];
        e = b[0].replace(d,
        function(f, g) {
            return a[parseInt(g)];
        });
    } else {
        a = b;
        e = b[0].replace(d,
        function(f, g) {
            return a[parseInt(g) + 1];
        });
    }
    return e;
};
String.prototype.gsub.prepareReplacement = function(a) {
    if (typeof a == "function") {
        return a;
    }
    var b = new Template(a);
    return function(c) {
        return b.evaluate(c);
    };
};
var Template = Class.create();
Template.Pattern = /(^|.|\r|\n)(#\{(.*?)\})/;
Template.prototype = {
    initialize: function(b, a) {
        this.template = b.toString();
        this.pattern = a || Template.Pattern;
    },
    eval: function(a) {
        return this.template.gsub(this.pattern,
        function(c) {
            var b = c[1];
            if (b == "\\") {
                return c[2];
            }
            return b + String.interpret(a[c[3]]);
        });
    }
};
function StringBuilder() {
    this.strings = [];
}
StringBuilder.prototype.append = function(a) {
    this.strings.push(a);
};
StringBuilder.prototype.toString = function() {
    if (arguments.length == 0) {
        return this.strings.join("");
    } else {
        return this.strings.join(arguments[0]);
    }
};
StringBuilder.prototype.clear = function() {
    this.strings.clear();
};
StringBuilder.prototype.backspace = function() {
    this.strings.pop();
};
if (!window.Event) {
    var Event = new Object();
}
Object.extend(Event, {
    KEY_BACKSPACE: 8,
    KEY_TAB: 9,
    KEY_RETURN: 13,
    KEY_ESC: 27,
    KEY_LEFT: 37,
    KEY_UP: 38,
    KEY_RIGHT: 39,
    KEY_DOWN: 40,
    KEY_DELETE: 46,
    KEY_HOME: 36,
    KEY_END: 35,
    KEY_PAGEUP: 33,
    KEY_PAGEDOWN: 34,
    element: function(a) {
        return $(a.target || a.srcElement);
    },
    isLeftClick: function(a) {
        return (((a.which) && (a.which == 1)) || ((a.button) && (a.button == 1)));
    },
    pointerX: function(a) {
        return a.pageX || (a.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft));
    },
    pointerY: function(a) {
        return a.pageY || (a.clientY + (document.documentElement.scrollTop || document.body.scrollTop));
    },
    stop: function(a) {
        if (a.preventDefault) {
            a.preventDefault();
            a.stopPropagation();
        } else {
            a.returnValue = false;
            a.cancelBubble = true;
        }
    },
    findElement: function(b, c) {
        var a = Event.element(b);
        while (a.parentNode && (!a.tagName || (a.tagName.toUpperCase() != c.toUpperCase()))) {
            a = a.parentNode;
        }
        return a;
    },
    observers: false,
    _observeAndCache: function(a, b, c, d) {
        if (!this.observers) {
            this.observers = [];
        }
        if (a.addEventListener) {
            this.observers.push([a, b, c, d]);
            a.addEventListener(b, c, d);
        } else {
            if (a.attachEvent) {
                this.observers.push([a, b, c, d]);
                a.attachEvent("on" + b, c);
            }
        }
    },
    unloadCache: function() {
        if (!Event.observers) {
            return;
        }
        for (var a = 0, b = Event.observers.length; a < b; a++) {
            Event.stopObserving.apply(this, Event.observers[a]);
            Event.observers[a][0] = null;
        }
        Event.observers = false;
    },
    observe: function(a, b, c, d) {
        a = $(a);
        d = d || false;
        if (b == "keypress" && (Prototype.Browser.WebKit || a.attachEvent)) {
            b = "keydown";
        }
        Event._observeAndCache(a, b, c, d);
    },
    stopObserving: function(b, c, d, f) {
        b = $(b);
        f = f || false;
        if (c == "keypress" && (Prototype.Browser.WebKit || b.attachEvent)) {
            c = "keydown";
        }
        if (b.removeEventListener) {
            b.removeEventListener(c, d, f);
        } else {
            if (b.detachEvent) {
                try {
                    b.detachEvent("on" + c, d);
                } catch(a) {}
            }
        }
    }
});
var Globals = {
    ScriptContentFragment: "<script.*?>((\n|\r|.)*?)</script>",
    ScriptSrcFragment: '<script.*?src="([?=/.A-Za-z0-9_]*)".*?></script>',
    StyleContentFragment: "<style.*?>((\n|\r|.)*?)</style>",
    StyleHrefFragment: '<link.*?href="([/.A-Za-z0-9_]*)".*?></link>',
    addIE6Filter: function(width, height, left, top, zindex) {
        if ($.browser.msie && $.browser.version < 7) {
            var filterTemplate = new Template('<iframe style="position: absolute; z-index: #{zindex}; width:#{width}px;height:#{height}px; top: #{top}px; left: #{left}px;border:0px solid #000;filter:alpha(opacity=0);-moz-opacity:0"></iframe>');
            return $(filterTemplate.eval({
                width: width + 2,
                height: height + 2,
                left: left,
                top: top,
                zindex: Object.isNull(zindex) ? 1 : zindex
            })).appendTo($("#m_contentend"));
        }
    },
    closeIE6Fliter: function(a) {
        if (!Object.isNull(a)) {
            a.remove();
            a = null;
        }
    },
    registerSelectFixIE: function(d) {
        if (!$.browser.msie) {
            return;
        }
        var e = function(h) {
            var g = Event.element(h);
            var i = g.data("isOpen");
            if (!Object.isNull(i) || i) {
                return;
            }
            g.data("isOpen", true);
            var l = g.position();
            var k = g.width();
            var f = g.data("clone");
            if (f == null) {
                f = $("<select style='visibility:hidden'></select>").insertBefore(g);
                f.addClass(g[0].className);
                g.data("clone", f);
            }
            g.css("width", "auto");
            var j = g.width();
            if (k >= j) {
                g.css("width", k);
            }
            g.css("top", l.top + "px");
            g.css("left", l.left + "px");
            g.css("position", "absolute");
            g.css("z-index", "1000");
        };
        var a = function(g) {
            var f = Event.element(g);
            var h = f.data("isOpen");
            if (h) {
                var i = f.data("clone");
                f.css("position", "");
                f.css("width", i.css("width"));
                f.css("top", "");
                f.css("left", "");
                f.css("z-index", i.css("z-index"));
                f.data("isOpen", null);
                f.data("clone", null);
                i.remove();
            }
        };
        for (var b = 0; b < arguments.length; b++) {
            var c = arguments[b];
            c.bind("mousedown",
            function(f) {
                e(f);
            });
            c.bind("blur",
            function(f) {
                a(f);
            });
            c.bind("change",
            function(f) {
                a(f);
            });
        }
    },
    getScrollPosition: function() {
        var a = {
            x: 0,
            y: 0
        };
        if (typeof(window.pageYOffset) == "number") {
            a.x = window.pageXOffset;
            a.y = window.pageYOffset;
        } else {
            if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
                a.x = document.body.scrollLeft;
                a.y = document.body.scrollTop;
            } else {
                if (document.documentElement) {
                    a.x = document.documentElement.scrollLeft;
                    a.y = document.documentElement.scrollTop;
                }
            }
        }
        return a;
    },
    browserDimensions: function() {
        var a = {
            width: 0,
            height: 0
        };
        if ($.browser.msie) {
            a.height = document.documentElement.clientHeight;
            a.width = document.documentElement.clientWidth;
        } else {
            a.height = window.innerHeight;
            a.width = document.width || document.body.offsetWidth;
        }
        return a;
    },
    getParam: function(a) {
        var b = this._getParams();
        if (Object.isNull(b)) {
            return "";
        }
        return b[a];
    },
    _getParams: function() {
        var d = {};
        var g = document.location.search.substr(1).split("&");
        if (String.isNullOrEmpty(g)) {
            return null;
        }
        for (var c = 0, a = g.length; c < a; c++) {
            try {
                var f = g[c].split("=");
                if (f.length < 2) {
                    continue;
                }
                d[f[0]] = f[1].Trim();
            } catch(b) {}
        }
        return d;
    },
    copyToClipboard: function(i) {
        if (window.clipboardData) {
            window.clipboardData.clearData();
            window.clipboardData.setData("Text", i);
        } else {
            if ($.browser.opera) {
                window.location = i;
            } else {
                if ($.browser.mozilla) {
                    try {
                        netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                    } catch(d) {
                        alert("你的firefox安全限制限制您进行剪贴板操作，请在地址栏输入: about:config 将signed.applets.codebase_principal_support设置为true之后重试");
                        return false;
                    }
                    var a = Components.classes["@mozilla.org/widget/clipboard;1"].createInstance(Components.interfaces.nsIClipboard);
                    if (!a) {
                        return false;
                    }
                    var h = Components.classes["@mozilla.org/widget/transferable;1"].createInstance(Components.interfaces.nsITransferable);
                    if (!h) {
                        return false;
                    }
                    h.addDataFlavor("text/unicode");
                    var f = {};
                    var g = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
                    var c = i;
                    g.data = c;
                    h.setTransferData("text/unicode", g, c.length * 2);
                    var b = Components.interfaces.nsIClipboard;
                    if (!a) {
                        return false;
                    }
                    a.setData(h, null, b.kGlobalClipboard);
                }
            }
        }
        return true;
    },
    hideSelect: function() {
        if ($.browser.msie) {
            var c = document.getElementsByTagName("SELECT");
            for (var b = 0, a = c.length; b < a; b++) {
                c[b].style.visibility = "hidden";
            }
        }
    },
    showSelect: function() {
        if ($.browser.msie) {
            var c = document.getElementsByTagName("SELECT");
            for (var b = 0, a = c.length; b < a; b++) {
                c[b].style.visibility = "visible";
            }
        }
    },
    loadScript: function(f, a) {
        if (arguments.length <= 1) {
            a = true;
        }
        var c = document.getElementsByTagName("head")[0];
        var b = false;
        var e = document.createElement("script");
        if (a) {
            e.type = "text/javascript";
            e.src = f;
            f = e.src;
            var d = jQuery("script[src='" + f + "']", c);
            if (d && d.size() > 0) {
                b = true;
            }
        }
        if (!b) {
            c.appendChild(e);
        } else {
            e = null;
        }
    },
    loadCss: function(f, a) {
        if (arguments.length <= 1) {
            a = true;
        }
        var d = document.getElementsByTagName("head")[0];
        var c = false;
        if (a) {
            var e = jQuery("link[href='" + f + "']", d);
            if (e && e.size() > 0) {
                c = true;
            }
        }
        if (!c) {
            var b = document.createElement("link");
            b.type = "text/css";
            b.rel = "stylesheet";
            b.href = f;
            d.appendChild(b);
        }
    },
    cookie: function(name, subName, value, options) {
        if (typeof value != "undefined") {
            options = options || {};
            if (value === null) {
                value = "";
                options.expires = -1;
            }
            var expires = "";
            if (options.expires && (typeof options.expires == "number" || options.expires.toUTCString)) {
                var date;
                if (typeof options.expires == "number") {
                    date = new Date();
                    date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
                } else {
                    date = options.expires;
                }
                expires = "; expires=" + date.toUTCString();
            }
            var hostStr = window.location.host.split(".");
            var hostName = hostStr.length >= 2 ? String.format(";domain={0}.{1}", hostStr[hostStr.length - 2], hostStr[hostStr.length - 1]) : "";
            var path = options.path ? "; path=" + (options.path) : ";path=/";
            var domain = options.domain ? "; domain=" + (options.domain) : hostName;
            var secure = options.secure ? "; secure": "";
            var newCookies = new Array();
            if (typeof value == "object" && String.isNullOrEmpty(subName)) {
                for (var tempValue in value) {
                    eval("var obj = {" + String.format('"name":"{0}","value":"{1}"', tempValue, value[tempValue]) + "};");
                    newCookies.push(obj);
                }
            } else {
                if (!String.isNullOrEmpty(subName)) {
                    eval("var obj = {" + String.format('"name":"{0}","value":"{1}"', subName, value) + "};");
                    newCookies.push(obj);
                }
            }
            var nowCookies = String.isNullOrEmpty(this.cookie(name)) ? "": this.cookie(name);
            nowCookies = nowCookies.replace(/=.*?(&|$)/ig,
            function(word) {
                word = word.replace(/(=|&)/ig, "");
                return "=" + encodeURIComponent(word) + "&";
            });
            if (typeof value != "object" && String.isNullOrEmpty(subName)) {
                nowCookies = encodeURIComponent(value);
            } else {
                while (1) {
                    var newCookie = newCookies.pop();
                    if (newCookie == null || newCookie == "undefined") {
                        break;
                    }
                    var pattern = new RegExp(String.format("(^|&){0}=.*?(&|$)", newCookie.name), "gi");
                    if (pattern.test(nowCookies)) {
                        if (!nowCookies.startsWith(newCookie.name + "=")) {
                            nowCookies = nowCookies.replace(pattern, "&" + String.format("{0}={1}", newCookie.name, encodeURIComponent(newCookie.value) + "&"));
                        } else {
                            nowCookies = nowCookies.replace(pattern, String.format("{0}={1}", newCookie.name, encodeURIComponent(newCookie.value) + "&"));
                        }
                    } else {
                        if (!nowCookies.endsWith("&") && !String.isNullOrEmpty(nowCookies)) {
                            nowCookies += "&";
                        }
                        nowCookies += String.format("{0}={1}", newCookie.name, encodeURIComponent(newCookie.value));
                    }
                }
            }
            document.cookie = [name, "=", nowCookies, expires, path, domain, secure].join("");
        } else {
            var cookieValue = null;
            if (document.cookie && document.cookie != "") {
                var cookies = document.cookie.split(";");
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = jQuery.trim(cookies[i]);
                    if (cookie.substring(0, name.length + 1) == (name + "=")) {
                        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                        if (typeof subName != "undefined" && subName != null && subName != "") {
                            var subCookies = cookieValue.toString().split("&");
                            var tmpCookies = "";
                            for (var j = 0; j < subCookies.length; j++) {
                                var subCookie = jQuery.trim(subCookies[j]);
                                if (subCookie.substring(0, subName.length + 1) == (subName + "=")) {
                                    tmpCookies = decodeURIComponent(subCookie.substring(subName.length + 1));
                                    break;
                                }
                            }
                            cookieValue = tmpCookies;
                        }
                        break;
                    }
                }
            }
            return cookieValue;
        }
    },
    searchObj: function(patternField, patternValue, searchData) {
        var result = [];
        if (searchData) {
            var pat = patternField.split("|");
            for (var k = 0; k < pat.length; k++) {
                for (var i = 0; i < searchData.length; i++) {
                    var tempValue = null;
                    eval("tempValue = searchData[i]." + pat[k]);
                    patternValue = patternValue.replace(/[\s,\']+/g, "");
                    if (tempValue != null) {
                        tempValue = tempValue.replace(/[\s,\']+/g, "");
                        if (tempValue.toLowerCase() == encodeURIComponent(patternValue).toLowerCase() || tempValue.toLowerCase() == patternValue.toLowerCase()) {
                            result.push(searchData[i]);
                            continue;
                        }
                        if (decodeURIComponent(tempValue).indexOf("(") >= 0 || decodeURIComponent(tempValue).indexOf("（") >= 0) {
                            var tempLeft = decodeURIComponent(tempValue).replace(/\s+/g, "").replace(/[(,),（,）]/g, "|").split("|");
                            for (var j = 0; j < tempLeft.length; j++) {
                                if (!String.isNullOrEmpty(tempLeft[j]) && tempLeft[j].toLowerCase() == (patternValue).toLowerCase()) {
                                    break;
                                }
                            }
                            continue;
                        }
                    }
                }
            }
        } else {
            alert("Globals.searchObj方法没有检测到数据源参数：searchObj");
        }
        return result;
    }
};
(function($) {
    function toIntegersAtLease(n) {
        return n < 10 ? "0" + n: n;
    }
    Date.prototype.toJSON = function(date) {
        return this.getUTCFullYear() + "-" + toIntegersAtLease(this.getUTCMonth()) + "-" + toIntegersAtLease(this.getUTCDate());
    };
    var escapeable = /["\\\x00-\x1f\x7f-\x9f]/g;
    var meta = {
        "\b": "\\b",
        "\t": "\\t",
        "\n": "\\n",
        "\f": "\\f",
        "\r": "\\r",
        '"': '\\"',
        "\\": "\\\\"
    };
    $.quoteString = function(string) {
        if (escapeable.test(string)) {
            return '"' + string.replace(escapeable,
            function(a) {
                var c = meta[a];
                if (typeof c === "string") {
                    return c;
                }
                c = a.charCodeAt();
                return "\\u00" + Math.floor(c / 16).toString(16) + (c % 16).toString(16);
            }) + '"';
        }
        return '"' + string + '"';
    };
    $.toJSON = function(o, compact) {
        var type = typeof(o);
        if (type == "undefined") {
            return "undefined";
        } else {
            if (type == "number" || type == "boolean") {
                return o + "";
            } else {
                if (o === null) {
                    return "null";
                }
            }
        }
        if (type == "string") {
            return $.quoteString(o);
        }
        if (type == "object" && typeof o.toJSON == "function") {
            return o.toJSON(compact);
        }
        if (type != "function" && typeof(o.length) == "number") {
            var ret = [];
            for (var i = 0; i < o.length; i++) {
                ret.push($.toJSON(o[i], compact));
            }
            if (compact) {
                return "[" + ret.join(",") + "]";
            } else {
                return "[" + ret.join(", ") + "]";
            }
        }
        if (type == "function") {
            throw new TypeError("Unable to convert object of type 'function' to json.");
        }
        var ret = [];
        for (var k in o) {
            var name;
            type = typeof(k);
            if (type == "number") {
                name = '"' + k + '"';
            } else {
                if (type == "string") {
                    name = $.quoteString(k);
                } else {
                    continue;
                }
            }
            var val = $.toJSON(o[k], compact);
            if (typeof(val) != "string") {
                continue;
            }
            if (compact) {
                ret.push(name + ":" + val);
            } else {
                ret.push(name + ": " + val);
            }
        }
        return "{" + ret.join(", ") + "}";
    };
    $.compactJSON = function(o) {
        return $.toJSON(o, true);
    };
    $.evalJSON = function(src) {
        return eval("(" + src + ")");
    };
    $.secureEvalJSON = function(src) {
        var filtered = src;
        filtered = filtered.replace(/\\["\\\/bfnrtu]/g, "@");
        filtered = filtered.replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]");
        filtered = filtered.replace(/(?:^|:|,)(?:\s*\[)+/g, "");
        if (/^[\],:{}\s]*$/.test(filtered)) {
            return eval("(" + src + ")");
        } else {
            throw new SyntaxError("Error parsing JSON, source is not valid.");
        }
    };
})(Globals);
FunctionExt = {
    createCallback: function(b) {
        var a = arguments;
        var c = b;
        return function() {
            return c.apply(window, a);
        };
    },
    createDelegate: function(c, e, b, a) {
        var d = c;
        return function() {
            var g = b || arguments;
            if (a === true) {
                g = Array.prototype.slice.call(arguments, 0);
                g = g.concat(b);
            } else {
                if (typeof a == "number") {
                    g = Array.prototype.slice.call(arguments, 0);
                    var f = [a, 0].concat(b);
                    Array.prototype.splice.apply(g, f);
                }
            }
            return d.apply(e || window, g);
        };
    },
    defer: function(d, e, f, b, a) {
        var c = this.createDelegate(d, f, b, a);
        if (e) {
            return setTimeout(c, e);
        }
        c();
        return 0;
    }
};
var simpleAjax = {
    Max_Cache_Size: 10,
    cacheConent: {
        data: {},
        index: []
    },
    cache_key: null,
    callBack: function(h, a, c, e, f, d) {
        var b = true;
        if (!c || c == null) {
            b = false;
        }
        var g = {
            args: a,
            url: h,
            clientCallBack: c,
            method: f
        };
        this.cache_key = h + a;
        if (e) {
            if (!Object.isNull(this.cacheConent.data[this.cache_key])) {
                FunctionExt.defer(g.clientCallBack, 1, null, [this.cacheConent.data[this.cache_key]]);
                return;
            }
        }
        g.xmlhttp = jQuery.ajax({
            type: Object.isNull(f) ? "GET": f,
            url: h,
            cache: Object.isNull(e) ? false: e,
            data: a,
            requestObj: g,
            error: this.onError,
            complete: this.onComplete,
            dataType: Object.isNull(d) ? "json": d,
            timeout: 60000,
            success: function(i, k) {
                this.cacheConent.data[this.cache_key] = i;
                this.cacheConent.index.unshift(this.cache_key);
                if (this.cacheConent.index.length > this.Max_Cache_Size) {
                    var j = this.cacheConent.index.pop();
                    delete this.cacheConent.data[j];
                }
                FunctionExt.defer(g.clientCallBack, 1, null, [i]);
            }.bind(this)
        });
    },
    onError: function(c, b, a) {
        FunctionExt.defer(this.requestObj.clientCallBack, 1, null, [{
            success: false,
            status: b,
            value: c.responseText
        }]);
    },
    onComplete: function(b, a) {
        if (!Object.isNull(this.requestObj)) {
            this.requestObj = null;
            delete this.requestObj;
        }
    }
};
var elongAjax = {
    requestQueue: [],
    callBack: function(k, a, c, e, f, h, d) {
        h = Object.isNull(h) ? true: h;
        a = this.buildArgObject(Object.clone(a));
        var b = true;
        if (!c || c == null) {
            b = false;
        }
        var j = {
            args: a,
            url: k,
            clientCallBack: c,
            isPipeFrist: h,
            method: f,
            dequeue: this.dequeue.bind(this)
        };
        if (b) {
            if (h) {
                if (this.inQueue(j)) {
                    return;
                }
            } else {
                for (var g = this.requestQueue.length - 1; g >= 0; g--) {
                    if (j.url == this.requestQueue[g].url && !Object.isNull(this.requestQueue[g].xmlhttp)) {
                        this.requestQueue[g].xmlhttp.abort();
                        this.dequeue(this.requestQueue[g]);
                        break;
                    }
                }
            }
            this.requestQueue.push(j);
        }
        j.xmlhttp = jQuery.ajax({
            type: Object.isNull(f) ? "GET": f,
            url: k,
            cache: Object.isNull(e) ? false: e,
            data: a,
            requestObj: j,
            error: this.onError,
            success: this.onSuccess,
            complete: this.onComplete,
            dataType: Object.isNull(d) ? "json": d,
            timeout: 60000
        });
    },
    buildArgObject: function(d, f, e) {
        if (f == null) {
            f = d;
        }
        if (e == null) {
            e = "";
        }
        for (var b in d) {
            if ($.isFunction(d[b])) {
                d[b] = null;
                delete d[b];
                break;
            }
            if ($.isArray(d[b])) {
                for (var a = 0; a < d[b].length; a++) {
                    if (typeof(d[b][a]) == "object") {
                        this.buildArgObject(d[b][a], f, e + b + "[" + a + "].");
                    } else {
                        var c = e + b + "[" + a + "]";
                        f[c] = d[b][a];
                    }
                }
                d[b] = null;
                delete d[b];
            } else {
                if (typeof(d[b]) == "object") {
                    this.buildArgObject(d[b], f, e + b + ".");
                    d[b] = null;
                    delete d[b];
                } else {
                    var c = isNaN(parseInt(b, 10)) ? e + b: e.substr(0, e.length - 1);
                    f[c] = d[b];
                }
            }
        }
        return d;
    },
    toQueryString: function(a) {
        var e = "";
        if (a) {
            var d = [];
            for (var c = 0, b = a.length; c < b; c++) {
                d.push("&Ajax_CallBackArgument");
                d.push(c);
                d.push("=");
                d.push(encodeURIComponent(a[c]));
            }
            e = d.join("");
        }
        return e;
    },
    inQueue: function(d) {
        if (this.requestQueue.length > 0) {
            var e = this.requestQueue,
            c = null;
            for (var b = 0, a = e.length; b < a; b++) {
                c = e[b];
                if (c == d) {
                    return true;
                } else {
                    if (this.equal(c, d)) {
                        return true;
                    }
                }
            }
            return false;
        }
    },
    dequeue: function(e) {
        if (this.requestQueue.length > 0) {
            var f = this.requestQueue,
            d = null,
            c = -1;
            for (var b = 0, a = f.length; b < a; b++) {
                d = f[b];
                if (d == e) {
                    c = b;
                    break;
                } else {
                    if (this.equal(d, e)) {
                        c = b;
                        break;
                    }
                }
            }
            if (c >= 0) {
                f.splice(c, 1);
            }
        }
    },
    equal: function(a, b) {
        if (a.url == b.url && this.toQueryString(a.args) == this.toQueryString(b.args)) {
            return true;
        }
        return false;
    },
    onError: function(c, b, a) {
        FunctionExt.defer(this.requestObj.clientCallBack, 1, null, [{
            success: false,
            status: b,
            value: c.responseText
        }]);
    },
    onSuccess: function(a, b) {
        FunctionExt.defer(this.requestObj.clientCallBack, 1, null, [a]);
    },
    onComplete: function(b, a) {
        if (!Object.isNull(this.requestObj)) {
            this.requestObj.dequeue(this.requestObj);
            this.requestObj = null;
            delete this.requestObj;
        }
    },
    addOverlay: function(d) {
        if (Object.isNull(d)) {
            return;
        }
        var e = new Date().getTime();
        var c = "submitOverlay_" + e;
        var a = d.parentNode;
        var b = Element.extend(document.createElement("div"));
        b.id = c;
        b.className = "submiting";
        $("contentEnd").appendChild(b);
        Position.clone(d, b);
        d._overlay = b;
    },
    removeOverlay: function(a) {
        if (typeof a === "undefined" || a === null) {
            return;
        }
        if (a._overlay) {
            $("contentEnd").removeChild(a._overlay);
            a._overlay = null;
        }
    }
};
function $ready(a) {
    if (!Object.isNull(a)) {
        a();
    }
}
var Elong = {
    version: "0.1",
    author: "zhi.luo",
    renderAds: function() {
        var g = $("#m_adsContainer");
        if (g.length == 0) {
            return;
        }
        var f = /<script.*>(.|\n)*<\/script>/i;
        for (var e = 0; e < g.children().length; e++) {
            var c = g.children().eq(e);
            var b = c.attr("name");
            if (String.isNullOrEmpty(b) || $("#" + b).length == 0) {
                continue;
            }
            var d = c.html();
            c.find(":descendant").each(function() {
                if (!$(this).is("script")) {
                    $(this).remove();
                }
            });
            var a = d.replace(f, "");
            if (String.isNullOrEmpty(a)) {
                $("#" + b).hide();
            } else {
                $("#" + b).html(a);
            }
        }
    },
    recordSEOKeyWord: function() {
        var c = document.referrer;
        if (String.isNullOrEmpty(c)) {
            return;
        }
        c = c.toLowerCase();
        if (c.indexOf(".google.") > -1 || c.indexOf(".baidu.") > -1 || c.indexOf(".soso.") > -1 || c.indexOf(".sogou.") > -1 || c.indexOf(".youdao.") > -1 || c.indexOf(".bing.") > -1 || c.indexOf(".yahoo.") > -1) {
            var b = "TableName=RecordSEOKeyword&CookieGuid=" + Globals.cookie("CookieGuid") + "&SessionGuid=" + Globals.cookie("SessionGuid") + "&ReferUrl=" + encodeURIComponent(c) + "&LandingPage=" + encodeURIComponent(document.location);
            var a = document.createElement("img");
            a.setAttribute("src", "http://tj.elong.com/statistics.gif?" + b);
            $("#m_contentend").append(a);
        }
    },
    GetUserInfo: function(b) {
        var f = {
            actiondo: "GetMemberNameInfo",
            loginname: "",
            pwd: "",
            vcode: "",
            isrememberme: false
        };
        var c = "my.elong.com";
        var a = window.location.host.split(".");
        if (a.length >= 2) {
            c = String.format("my.{0}.{1}", a[a.length - 2], a[a.length - 1]);
        }
        var d = window.location.host.toLowerCase().indexOf(".net") >= 0 ? "en": "cn";
        var e = String.format("http://{0}/loginproxy_{1}.html", c, d);
        if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0 || window.location.host.toLowerCase().indexOf("travel.net") >= 0) {
            e = String.format("http://{0}/my/loginproxy_{1}.html", window.location.host, d);
        }
        elongAjax.callBack(e, f,
        function(g) {
            b(g);
        }.bind(this), false, "GET", null, "jsonp");
    },
    login: function(uid, pwd, vcode, callback, cardno, isEn, isrememberme) {
        var params = {
            actiondo: String.isNullOrEmpty(cardno) ? String.isNullOrEmpty(uid) && String.isNullOrEmpty(pwd) ? "nocardbooking": "login": "cardLogin",
            loginname: uid,
            pwd: pwd,
            vcode: vcode,
            cardno: cardno,
            isrememberme: isrememberme
        };
        var host = "my.elong.com";
        var arr = window.location.host.split(".");
        if (arr.length >= 2) {
            host = String.format("my.{0}.{1}", arr[arr.length - 2], arr[arr.length - 1]);
        }
        var language = window.location.host.toLowerCase().indexOf(".net") >= 0 ? "en": "cn";
        var loginUrl = String.format("http://{0}/loginproxy_{1}.html", host, language);
        if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0 || window.location.host.toLowerCase().indexOf("travel.net") >= 0) {
            loginUrl = String.format("http://{0}/my/loginproxy_{1}.html", window.location.host, language);
        }
        elongAjax.callBack(loginUrl, params,
        function(res) {
            if (res.MemberLoginCode == 102 && !Object.isNull(res.MemberCardList) && res.MemberCardList.length > 0) {
                var sb = new StringBuilder();
                var temp = !isEn ? new Template("<div>我们查找到了您的会员记录，请选择一张您常用的卡，我们将把订单记在此卡号下，可享受艺龙积分换礼品。</div><div  class='com_dialog-content com_widget-content'><div class='UserInfo'><table width='100%' border='0' cellspacing='0' cellpadding='0' class='n_table'><tr> <th width='49%'>艺龙卡号</th><th width='30%'>会员等级</th><th width='21%'>积分</th></tr>#{list}<tr><td colspan='3' class='tc'><input type='button'  mtd='ok' class='com_search75'  value='设为常用卡' />&nbsp;<a href='#?' class='' mtd='cancel'>取消</a></td></tr></table></div></div>") : new Template("<div>We find you have several accounts, please choose the one you want to use from below. </div><div  class='com_dialog-content com_widget-content'><div class='UserInfo'><table width='100%' border='0' cellspacing='0' cellpadding='0' class='n_table'><tr> <th width='49%'>Card</th><th width='30%'>Member Level</th><th width='21%'>Member Points</th></tr>#{list}<tr><td colspan='3' class='tc'><input type='button'  mtd='ok' class='com_search75'  value='Save' />&nbsp;<a href='#?' class='' mtd='cancel'>Cancel</a></td></tr></table></div></div>");
                for (var i = 0; i < res.CardNoList.length; i++) {
                    sb.append(String.format("<tr><td><input type='radio' value='{0}' name='cd'>{0}</td><td>{1}</td> <td>{2}</td></tr>", res.MemberCardList[i].CardNo, res.MemberCardList[i].Memlevel, res.MemberCardList[i].MemberPoints));
                }
                $("#header span[method='login'] input").show();
                $("#header span[method='login'] input").attr("disabled", true);
                $("#header span[method='wait']").hide();
                var wind = new Dialog({
                    title: !isEn ? "设置常用卡": "Set Default Card",
                    htmlContent: temp.eval({
                        list: sb.toString()
                    }),
                    width: 525,
                    closeEvent: function(window) {
                        $("#header span[method='login'] input").removeAttr("disabled");
                    },
                    initEvent: function(window) {
                        window.bind("click",
                        function(evt) {
                            var element = Event.element(evt);
                            var method = element.attr("mtd");
                            switch (method) {
                            case "ok":
                                if (window.find("input[checked]").length == 0) {
                                    return;
                                }
                                Elong.login(uid, pwd, vcode, callback, window.find("input[checked]").val(), isEn, isrememberme);
                                wind.close();
                                break;
                            case "cancel":
                                wind.close();
                                $("#header span[method='login'] input").removeAttr("disabled");
                                break;
                            }
                        }.bind(this));
                    }.bind(this)
                });
                wind.show();
            } else {
                res.SelectedCardNo = cardno;
                callback(res);
            }
        },
        false, "GET", null, "jsonp");
    },
    namespace: function() {
        var b = arguments,
        g = null,
        e, f, c;
        for (e = 0; e < b.length; e = e + 1) {
            c = b[e].split(".");
            g = Elong;
            for (f = (c[0] == "Elong") ? 1 : 0; f < c.length; f = f + 1) {
                g[c[f]] = g[c[f]] || {};
                g = g[c[f]];
            }
        }
        return g;
    }
};
Elong.namespace("Elong.Control", "Elong.Page", "Elong.Utility");
var ElongHeaderControl = Elong.Control.ElongHeaderControl;
ElongHeaderControl = Class.create();
Object.extend(ElongHeaderControl.prototype, {
    name: "ElongHeaderControl",
    CachePage: [{
        Url: "http://www.elong.com"
    },
    {
        Url: "http://www.elong.net"
    },
    {
        Url: "http://iflight.elong.com"
    },
    {
        Url: "http://iflight.elong.net"
    },
    {
        Url: "http://hotel.elong.com"
    },
    {
        Url: "http://hotel.elong.net"
    },
    {
        Url: "http://hotel.elong.com/index_cn.html"
    },
    {
        Url: "http://hotel.elong.net/index_en.html"
    },
    {
        Url: "http://iflight.elong.com/index_cn.html"
    },
    {
        Url: "http://iflight.elong.net/index_en.html"
    }],
    iFlightListCn: "http://iflight.elong.com/cn_list_",
    iFlightListEn: "http://iflight.elong.net/en_list_",
    initialize: function(a) {
        this.IFlightCn = "iflight.elong.com";
        this.IFlightEn = "iflight.elong.net";
        this.IFlightOnLineCn = "travel.elong.com/iflight";
        this.IFlightOnLineEn = "travel.elong.net/iflight";
        this.initializeDOM();
        this.initializeUserLoginInfo();
        this.initializeEvent();
        this.checkBig5();
        this.InitLanguage();
        this.GetLoginState();
        this.render();
    },
    CheckCahcePage: function() {
        var c = window.location.href.trim().toLowerCase();
        var b = false;
        if (c.indexOf(this.iFlightListCn) >= 0 || c.indexOf(this.iFlightListEn) >= 0) {
            return true;
        }
        for (var a = 0; a < this.CachePage.length; a++) {
            if (c == this.CachePage[a].Url || c == this.CachePage[a].Url + "/") {
                b = true;
                break;
            }
        }
        return b;
    },
    initializeDOM: function() {
        this.divLogin = $("#elongheader_login");
        this.elongheader_langs = $("#elongheader_langs");
        this.header = $("#header");
        this.divLang = this.header.find("div[method='divLang']");
        this.ulLang = this.header.find("ul[method='ulLang']");
        this.myAccount = this.header.find("div[method='myaccount']");
        this.myLogin = this.header.find("div[method='mylogin']");
        this.userName = this.myLogin.find("input[method='user']");
        this.pass = this.myLogin.find("input[method='pass']");
        this.realpass = this.myLogin.find("input[method='realpass']");
        this.bLogin = this.myLogin.find("input[method='login']");
        this.mcontent = $("#m_contentend");
    },
    initializeEvent: function() {
        this.divLogin.bind("click", this.onClickdivLogin.bindAsEventListener(this));
        this.elongheader_langs.bind("click", this.onClickelongheader_langs.bindAsEventListener(this));
        this.divLogin.bind("keydown", this.onKeyDowndivLogin.bindAsEventListener(this));
        this.divLogin.bind("mouseover", this.onMouseOverdivLogin.bindAsEventListener(this));
        this.header.bind("click", this.onheaderClick.bindAsEventListener(this));
        this.ulLang.bind("mouseover", this.ondivLangMouseOver.bindAsEventListener(this));
        this.divLang.bind("mouseover", this.ondivLangMouseOver.bindAsEventListener(this));
        this.divLang.bind("mouseout", this.ondivLangMouseOut.bindAsEventListener(this));
        this.divLang.find("a").bind("mouseover", this.ondivLangMouseOver.bindAsEventListener(this));
        this.divLang.find("a").bind("mouseout", this.ondivLangMouseOut.bindAsEventListener(this));
        this.myAccount.bind("mouseover", this.onmyAccountMouseOver.bindAsEventListener(this));
        this.myAccount.bind("mouseout", this.onmyAccountMouseOut.bindAsEventListener(this));
        this.myLogin.bind("mouseover", this.onmyLoginMouseOver.bindAsEventListener(this));
        this.myLogin.bind("mouseout", this.onmyLoginMouseOut.bindAsEventListener(this));
        this.userName.bind("mouseout", this.onuserNameMouseOut.bindAsEventListener(this));
        this.realpass.bind("mouseout", this.onrealpassMouseOut.bindAsEventListener(this));
        this.bLogin.bind("mouseover", this.onbLoginMouseOver.bindAsEventListener(this));
        this.bLogin.bind("mouseout", this.onbLoginMouseOut.bindAsEventListener(this));
        this.bLogin.bind("mousedown", this.onbLoginMouseDown.bindAsEventListener(this));
        this.myLogin.bind("keydown", this.onmyLoginKeyDown.bindAsEventListener(this));
    },
    onOutClick: function(a) {
        this.onOutClickHandler = function(c) {
            var b = Event.element(c);
            if (this.myLogin.find(":descendant").index(b) >= 0) {
                FunctionExt.defer(this.onOutClick.bindAsEventListener(this), 100);
            } else {
                this.myLogin.find("div[method='dvlogin']").addClass("none");
                this.myLogin.find("span[method='mylogin']").removeClass("on");
                $("#m_contentend").find("div[class='com_bug']").remove();
                this.tempErrorWindow = null;
                this.header.find("div[method='here']").hide();
                Globals.closeIE6Fliter(this.ie6FilterIFrame);
                $("#m_contentend iframe").remove();
            }
        }.bindAsEventListener(this);
        $(document).one("click", this.onOutClickHandler.bind(this));
    },
    onmyLoginKeyDown: function(b) {
        var a = Event.element(b);
        var c = a.attr("method");
        switch (c) {
        case "user":
            if (b.keyCode == 9 || b.keyCode == 13) {
                var d = this.myLogin.find("input[method='realpass']");
                if (d.val() == d.attr("default")) {
                    d.val("");
                }
                d.show();
                this.pass.hide();
                FunctionExt.defer(function() {
                    d.select();
                },
                100);
            }
            break;
        case "pass":
            var d = this.myLogin.find("input[method='realpass']");
            if (d.val() == d.attr("default")) {
                d.val("");
            }
            d.show();
            d.focus();
            this.pass.hide();
            break;
        case "realpass":
            if (b.keyCode == 13) {
                var e = this.myLogin.find("li[method='vcode']");
                if (e.attr("display") != "none") {
                    e.find("input").focus();
                } else {
                    this.bLogin.click();
                }
            }
        case "txtvcode":
            if (b.keyCode == 13) {
                this.bLogin.click();
            }
            break;
        }
    },
    IsIFlight: function() {
        var b = window.location.href.toLowerCase();
        var a = false;
        if ($("#nav_home").attr("class") == "action") {
            a = true;
        }
        if (b.indexOf(this.IFlightCn) != -1 || b.indexOf(this.IFlightEn) != -1 || b.indexOf(this.IFlightOnLineEn) != -1 || b.indexOf(this.IFlightOnLineCn) != -1 || b.indexOf("hotel.elong.com/index") != -1 || a || b.indexOf("hotel.elong.net/index") != -1 || b == "http://hotel.elong.com/" || b == "http://hotel.elong.net/" || (b.indexOf("hotelweb") > -1 && b.indexOf("ab.elong.com") > -1)) {
            return true;
        }
        return false;
    },
    GetRequest: function(f) {
        var e = window.location.href.toLowerCase();
        var d = e.indexOf("?");
        var g = e.substr(d + 1);
        var b = g.split("&");
        for (var c = 0; c < b.length; c++) {
            var a = b[c].split("=");
            if (a[0].toUpperCase() == f.toUpperCase()) {
                return a[1];
            }
        }
        return "";
    },
    GetUserLogin: function() {
        var params = {
            actiondo: "GetMemberNameInfo",
            loginname: "",
            pwd: "",
            vcode: "",
            isrememberme: false
        };
        var host = "my.elong.com";
        var arr = window.location.host.split(".");
        if (arr.length >= 2) {
            host = String.format("my.{0}.{1}", arr[arr.length - 2], arr[arr.length - 1]);
        }
        var language = window.location.host.toLowerCase().indexOf(".net") >= 0 ? "en": "cn";
        var loginUrl = String.format("http://{0}/loginproxy_{1}.html", host, language);
        if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0 || window.location.host.toLowerCase().indexOf("travel.net") >= 0) {
            loginUrl = String.format("http://{0}/my/loginproxy_{1}.html", window.location.host, language);
        }
        elongAjax.callBack(loginUrl, params,
        function(res) {
            if (!Object.isNull(res)) {
                if (res.isLogin == "true") {
                    var divUserLoginInfo = $("#divUserLoginInfo_elongheader");
                    var UserLoginInfo_Cn = new Template("<b>欢迎您, #{UserName}</b><span class='ml5 mr5'>[<a href='http://my.elong.com/logout_cn.html'>退出</a>]</span><a href='http://my.elong.com/index_cn.html'>我的帐户</a>|<a href='http://my.elong.com/index_cn.html'>订单管理</a>");
                    var UserLoginInfo_En = new Template(" <b>Welcome,#{UserName}</b> <span class='ml5 mr5'>[<a href='http://my.elong.net/logout_en.html' class='link'>Sign Out</a>]</span><a href='http://my.elong.net/index_en.html'>My Account</a>");
                    var UserLoginInfo_OnLine = new Template("<b>欢迎您, #{UserName}</b><span class='ml5 mr5'>[<a href='http://travel.elong.com/my/logout_cn.html?campaign_id=#{CampaignId}'>退出</a>]</span><a href='http://travel.elong.com/my/index_cn.html?campaign_id=#{CampaignId}'>我的帐户</a>|<a href='http://travel.elong.com/my/index_cn.html?campaign_id=#{CampaignId}'>订单管理</a>");
                    var UserLoginInfo_OnLineEn = new Template(" <b>Welcome,#{UserName}</b> <span class='ml5 mr5'>[<a href='http://travel.elong.net/my/logout_en.html?campaign_id=#{CampaignId}' class='link'>Sign Out</a>]</span><a href='http://travel.elong.net/my/index_en.html?campaign_id=#{CampaignId}'>My Account</a>");
                    var WebSiteType = "Cn";
                    var url = window.location.toString().toLowerCase();
                    var UserLoginInfo = "";
                    var CampaignId = "";
                    if (url.indexOf(this.IFlightCn) != -1 || url.indexOf("hotel.elong.com") != -1 || (url.indexOf("elong.com") > 0 && $("#nav_home").attr("class") == "action")) {
                        WebSiteType = "Cn";
                        UserLoginInfo = UserLoginInfo_Cn;
                    }
                    if (url.indexOf(this.IFlightEn) != -1 || (url.indexOf("elong.net") > 0)) {
                        WebSiteType = "En";
                        UserLoginInfo = UserLoginInfo_En;
                    }
                    if (url.indexOf(this.IFlightOnLineEn) != -1) {
                        WebSiteType = "OnLineEn";
                        UserLoginInfo = UserLoginInfo_OnLineEn;
                        CampaignId = this.GetRequest("campaign_id");
                    }
                    if (url.indexOf(this.IFlightOnLineCn) != -1) {
                        WebSiteType = "OnLineCn";
                        UserLoginInfo = UserLoginInfo_OnLine;
                        CampaignId = this.GetRequest("campaign_id");
                    }
                    var msg = res.MemberName;
                    if (!String.isNullOrEmpty(WebSiteType)) {
                        UserLoginInfo = UserLoginInfo.eval({
                            UserName: msg,
                            CampaignId: CampaignId
                        });
                    }
                    this.divLogin.html(UserLoginInfo);
                    this.divLogin.show();
                } else {
                    this.divLogin.show();
                }
            } else {
                this.divLogin.show();
            }
        }.bind(this), false, "GET", null, "jsonp");
    },
    initializeUserLoginInfo: function() {
        var b = this.divLogin.attr("NeedLogin");
        if (b != "true") {
            return;
        }
        var a = window.location.host;
        if (a.indexOf("travel") >= 0 || a.indexOf("elong.com") < 0) {
            this.GetUserLogin();
        }
    },
    destroyDOM: function() {
        this.divLogin = null;
        this.elongheader_langs = null;
    },
    destroyEvent: function() {
        this.divLogin.unbind("click");
        this.elongheader_langs.unbind("click");
        this.divLogin.unbind("keydown");
    },
    ShowLoginWindow: function() {
        var a = window.location.host.toLowerCase().indexOf(".net") >= 0 ? "en": "cn";
        if (a == "cn") {
            this.header.find("div[method='here']").html('<span class="close right" title="关闭" method="hereclose"></span>您需要登录才可查看帐户信息。');
        } else {
            this.header.find("div[method='here']").html('<span class="close right" title="Close" method="hereclose"></span>Please sign in here.');
        }
        this.header.find("div[method='here']").show();
        if (this.outTimer != null) {
            clearTimeout(this.outTimer);
            this.outTimer = null;
        }
        this.myAccount.find("div").addClass("none");
        this.myAccount.find("span").removeClass("on");
        FunctionExt.defer(function() {
            this.header.find("div[method='here']").attr("state", "0");
            this.myLogin.find("div[method='dvlogin']").removeClass("none");
            this.myLogin.find("span[method='mylogin']").addClass("on");
            $(document).unbind("click", this.onOutClick);
            $(document).one("click", this.onOutClick.bind(this));
            this.header.find("div[method='here']").show();
        }.bind(this), 100);
    },
    render: function() {},
    onheaderClick: function(d) {
        var c = Event.element(d);
        var n = c.attr("method");
        var l = window.location.host.toLowerCase().indexOf(".net") >= 0 ? "en": "cn";
        var s = this.header.find("div[method='uinfo']");
        switch (n) {
        case "fbill":
            if (Object.isNull(s[0])) {
                this.ShowLoginWindow();
            } else {
                var t = (l == "cn") ? "http://my.elong.com/FlightOrder_cn.html": " http://my.elong.net/FlightOrder_en.html";
                window.location.href = t;
            }
            break;
        case "hbill":
            if (Object.isNull(s[0])) {
                this.ShowLoginWindow();
            } else {
                var t = (l == "cn") ? "http://my.elong.com/HotelOrder_cn.html": " http://my.elong.net/HotelOrder_en.html";
                window.location.href = t;
            }
            break;
        case "cash":
            if (Object.isNull(s[0])) {
                this.ShowLoginWindow();
            } else {
                var t = "http://my.elong.com/Cash_cn.html";
                window.location.href = t;
            }
            break;
        case "coupon":
            if (Object.isNull(s[0])) {
                this.ShowLoginWindow();
            } else {
                var t = "http://my.elong.com/Coupon_cn.html";
                window.location.href = t;
            }
            break;
        case "point":
            if (Object.isNull(s[0])) {
                this.ShowLoginWindow();
            } else {
                var t = "http://my.elong.net/point_en.html";
                window.location.href = t;
            }
            break;
        case "olservice":
            var b = this.header.find("#channelMenu li[class='on']");
            if (Object.isNull(b[0]) || b.lenght == 0) {
                window.open("http://www.elong.com/chat.html?g=28632", "", "height=460,width=690,left=200,top=100,resizable=yes");
            } else {
                window.open("http://www.elong.com/chat.html?g=" + b.attr("sid"), "", "height=460,width=690,left=200,top=100,resizable=yes");
            }
            break;
        case "user":
            if (this.userName.val() == this.userName.attr("default")) {
                this.userName.val("");
            }
            break;
        case "pass":
            if (this.pass.val() == this.pass.attr("default")) {
                var p = this.myLogin.find("input[method='realpass']");
                this.pass.hide();
                p.val("");
                p.show();
                p.select();
            }
            break;
        case "hereclose":
            this.header.find("div[method='here']").hide();
            break;
        case "eng":
            var f = window.location.host.toLowerCase();
            var t = window.location.href.substring(f.length + 7).toLowerCase();
            switch (f.substring(0, f.indexOf(".elong"))) {
            case "hotel":
                window.location = "http://" + f.replace(/\.com/, ".net") + t.replace(/_cn/, "_en");
                return;
            case "flight":
                var e = t.replace(/_cn/, "_en").replace(/cn_/, "en_");
                window.location = "http://" + f.replace(/\.com/, ".net") + e;
                return;
            case "iflight":
                var e = t.replace(/_cn/, "_en").replace(/cn_/, "en_");
                window.location = "http://" + f.replace(/\.com/, ".net") + e;
                return;
            case "globalhotel":
                window.location = "http://globalhotel.elong.net";
                return;
            case "dianping":
                break;
            }
            if (t.indexOf("/iflight/") == 0) {
                var h = t.replace(/\/cn\//, "/en/").replace(/cn_/, "en_");
                window.location = "http://" + f.replace(/\.com/, ".net") + h;
                return;
            } else {
                if (t.indexOf("/square/") == 0) {
                    window.location = "http://" + f.replace(/\.com/, ".net") + t.replace(/\/cn\//, "/en/");
                    return;
                }
            }
            window.location = "http://www.elong.net";
            break;
        case "chg":
            var f = window.location.host.toLowerCase();
            var t = window.location.href.substring(f.length + 7).toLowerCase();
            switch (f.substring(0, f.indexOf(".elong"))) {
            case "hotel":
                window.location = "http://" + f.replace(/\.net/, ".com") + t.replace(/_en/, "_cn");
                return;
            case "flight":
                var e = t.replace(/_en/, "_cn").replace(/en_/, "cn_");
                window.location = "http://" + f.replace(/\.net/, ".com") + e;
                return;
            case "iflight":
                var e = t.replace(/_en/, "_cn").replace(/en_/, "cn_");
                window.location = "http://" + f.replace(/\.net/, ".com") + e;
                return;
            case "globalhotel":
                window.location = "http://globalhotel.elong.com";
                return;
            case "dianping":
                break;
            case "big5":
                if (window.location.href.length > 32) {
                    var g = "http";
                    var q = g + "://" + window.location.href.substr(32);
                    if (q.indexOf("#?")) {
                        q = q.replace("#?", "");
                    }
                    window.location = q;
                    return;
                }
                break;
            }
            if (t.indexOf("/iflight/") == 0) {
                var h = t.replace(/\/en\//, "/cn/").replace(/en_/, "cn_");
                window.location = "http://" + f.replace(/\.net/, ".com") + h;
                return;
            } else {
                if (t.indexOf("/square/") == 0) {
                    window.location = "http://" + f.replace(/\.net/, ".com") + t.replace(/\/en\//, "/cn/");
                    return;
                }
            }
            window.location = "http://www.elong.com";
            break;
        case "imgCode":
            var t = i ? String.format("http://my.elong.net/Validate.html?timespan={0}", new Date().getTime()) : String.format("http://my.elong.com/Validate.html?timespan={0}", new Date().getTime());
            if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0 || window.location.host.toLowerCase().indexOf("travel.net") >= 0) {
                t = i ? String.format("http://travel.elong.net/my/Validate.html?timespan={0}", new Date().getTime()) : String.format("http://travel.elong.com/my/Validate.html?timespan={0}", new Date().getTime());
            }
            this.myLogin.find("img").attr("src", t);
            break;
        case "forgotpass":
            var j = window.location.host.indexOf(".net") > 0 ? true: false;
            var u = (this.userName.val() == this.userName.attr("default")) ? "": this.userName.val().trim();
            var m = "";
            if (!Object.isNull(u) && u.trim() != "") {
                m = String.format("http://{0}/ForgetPass_{1}_{2}.html", j ? "my.elong.net": "my.elong.com", j ? "en": "cn", encodeURIComponent(u));
                if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
                    m = String.format("http://{0}/my/ForgetPass_{1}_{2}.html?campaign_id={3}", window.location.host, j ? "en": "cn", encodeURIComponent(u), this.GetRequest("campaign_id"));
                }
            } else {
                m = String.format("http://{0}/ForgetPass_{1}.html", j ? "my.elong.net": "my.elong.com", j ? "en": "cn");
                if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
                    m = String.format("http://{0}/my/ForgetPass_{1}.html?campaign_id={2}", window.location.host, j ? "en": "cn", this.GetRequest("campaign_id"));
                }
            }
            window.open(m, "_blank");
            break;
        case "login":
            var r = this.userName;
            var o = this.realpass;
            var v = this.myLogin.find("li[method='vcode']");
            var a = this.myLogin.find("input[method='login']");
            var i = window.location.host.indexOf("elong.net") > 0 ? true: false;
            var k = $("#inputRememberMe").attr("checked") ? true: false;
            if (this.userName.val() == this.userName.attr("default")) {
                $error(r, i ? "Please enter your login name.": "登录名不能为空。");
                return;
            }
            if (!validator.valid(r.val().trim(), "notEmpty & loginName")) {
                $error(r, i ? "Please enter your login name.": "登录名不能为空。");
                return;
            }
            if (!validator.valid(o.val(), "notEmpty")) {
                $error(this.pass, i ? "Please enter your password.": "密码不能为空。");
                return;
            }
            a.hide();
            this.myLogin.find("span[method='wait']").show();
            Elong.login(encodeURIComponent(r.val().trim()), o.val(), v.find("input").val(),
            function(w) {
                if (w.MemberLoginCode != 1 && w.IsShowVCode) {
                    this.myLogin.find("li[method='vcode']").show();
                    var y = i ? String.format("http://my.elong.net/Validate.html?timespan={0}", new Date().getTime()) : String.format("http://my.elong.com/Validate.html?timespan={0}", new Date().getTime());
                    if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0 || window.location.host.toLowerCase().indexOf("travel.net") >= 0) {
                        y = i ? String.format("http://travel.elong.net/my/Validate.html?timespan={0}", new Date().getTime()) : String.format("http://travel.elong.com/my/Validate.html?timespan={0}", new Date().getTime());
                    }
                    this.myLogin.find("img").attr("src", y);
                }
                switch (w.MemberLoginCode) {
                case 1:
                    var x = window.location.href;
                    while (x.indexOf("#?") != -1) {
                        x = x.replace("#?", "");
                    }
                    window.location = x;
                    return;
                case 100:
                    $error(r, i ? "Username or password does not match!": "用户名或密码不匹配！");
                    break;
                case 101:
                    $error(this.pass, i ? "You have entered an incorrect password.": "登录密码错误");
                    break;
                case 102:
                    break;
                case 103:
                    $error(r, i ? "This account has been cancelled or frozen.": "用户已经被冻结或取消");
                    break;
                case 104:
                    $error(v.find("input"), i ? "You have entered an incorrect verification code.": "验证码错误");
                    break;
                default:
                    $error(r, i ? "There is an unknown error.": "未知错误");
                    break;
                }
                a.show();
                this.myLogin.find("span[method='wait']").hide();
            }.bind(this), null, i, k);
            break;
        }
    },
    ondivLangMouseOut: function() {
        this.ulLang.hide();
        this.divLang.find("span[method='langtag']").removeClass("on");
    },
    ondivLangMouseOver: function() {
        this.ulLang.show();
        this.divLang.find("span[method='langtag']").addClass("on");
    },
    onmyAccountMouseOver: function() {
        this.myLogin.find("div[method='dvlogin']").addClass("none");
        this.myLogin.find("span[method='mylogin']").removeClass("on");
        this.myAccount.find("div").removeClass("none");
        this.myAccount.find("span").addClass("on");
    },
    onmyAccountMouseOut: function() {
        this.myAccount.find("div").addClass("none");
        this.myAccount.find("span").removeClass("on");
    },
    onmyLoginMouseOver: function() {
        if (this.outTimer != null) {
            clearTimeout(this.outTimer);
            this.outTimer = null;
        }
        this.myLogin.find("div[method='dvlogin']").removeClass("none");
        this.myLogin.find("span[method='mylogin']").addClass("on");
        var d = this.myLogin.find("div[method='dvlogin']");
        var b = this.myLogin.find("span[method='mylogin']");
        var c = b.offset().top + b.height() + 6;
        var a = b.offset().left;
        this.ie6FilterIFrame = Globals.addIE6Filter(d.width(), d.height(), a, c, 750);
        if (this.header.find("div[method='here']").attr("state") == "1") {
            this.header.find("div[method='here']").hide();
        }
        FunctionExt.defer(this.onOutClick.bindAsEventListener(this), 100);
    },
    onmyLoginMouseOut: function() {
        if (this.userName.val() == this.userName.attr("default") && this.pass.val() == this.pass.attr("default")) {
            this.outTimer = FunctionExt.defer(function() {
                this.myLogin.find("div[method='dvlogin']").addClass("none");
                this.myLogin.find("span[method='mylogin']").removeClass("on");
                $("#m_contentend").find("div[class='com_bug']").remove();
                this.tempErrorWindow = null;
                this.bLogin.show();
                this.myLogin.find("span[method='wait']").hide();
                this.header.find("div[method='here']").hide();
                Globals.closeIE6Fliter(this.ie6FilterIFrame);
                $("#m_contentend iframe").remove();
            }.bind(this), 1000, this);
        }
    },
    onuserNameMouseOut: function() {
        if (String.isNullOrEmpty(this.userName.val())) {
            this.userName.val(this.userName.attr("default"));
        }
    },
    onrealpassMouseOut: function() {
        var a = this.myLogin.find("input[method='realpass']");
        if (String.isNullOrEmpty(this.realpass.val())) {
            this.pass.show();
            a.hide();
        }
    },
    onbLoginMouseOver: function() {
        this.bLogin.removeClass("btn_on");
    },
    onbLoginMouseOut: function() {
        this.bLogin.removeClass("btn_on");
    },
    onbLoginMouseDown: function() {
        this.bLogin.addClass("btn_on");
    },
    InitLanguage: function() {
        var b = false;
        if (window.location.href.indexOf("big5.elong.com") > -1) {
            b = true;
        }
        var c = window.location.href;
        if (b) {
            c = c.substr(32);
            this.divLang.find("a[method='langtag']").text("繁體版");
            this.ulLang.find("li[method='libig5']").remove();
            this.ulLang.find("li[method!='libig5']").show();
        } else {
            var a = window.location.host.toLowerCase();
            if (a.indexOf("elong.net") != -1) {
                this.divLang.find("a[method='langtag']").text("English");
                this.ulLang.find("li[method='lien']").remove();
                this.ulLang.find("li[method!='lien']").show();
                c = "http://big5.elong.com/gate/big5/www.elong.com";
            } else {
                this.divLang.find("a[method='langtag']").text("简体版");
                this.ulLang.find("li[method='licn']").remove();
                this.ulLang.find("li[method!='licn']").show();
                c = "http://big5.elong.com/gate/big5/" + c.substr(7);
            }
            this.ulLang.find("li[method='libig5'] a").attr("href", c);
        }
    },
    GetLoginState: function() {
        var params = {
            actiondo: "GetMemberNameInfo",
            loginname: "",
            pwd: "",
            vcode: "",
            isrememberme: false
        };
        var checkhost = window.location.host;
        if (checkhost.indexOf("travel") >= 0 || checkhost.indexOf("elong") < 0) {
            return;
        }
        if (!this.CheckCahcePage()) {
            return;
        }
        var host = "my.elong.com";
        var arr = window.location.host.split(".");
        if (arr.length >= 2) {
            host = String.format("my.{0}.{1}", arr[arr.length - 2], arr[arr.length - 1]);
        }
        var language = window.location.host.toLowerCase().indexOf(".net") >= 0 ? "en": "cn";
        var loginUrl = String.format("http://{0}/loginproxy_{1}.html", host, language);
        if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0 || window.location.host.toLowerCase().indexOf("travel.net") >= 0) {
            loginUrl = String.format("http://{0}/my/loginproxy_{1}.html", window.location.host, language);
        }
        elongAjax.callBack(loginUrl, params,
        function(res) {
            if (!Object.isNull(res)) {
                if (res.isLogin == "true") {
                    var divUserLoginInfo = $("#header div[method='dvAccount']");
                    divUserLoginInfo.find("div[method='reg']").remove();
                    divUserLoginInfo.find("div[method='mylogin']").remove();
                    divUserLoginInfo.find("div[method='uinfo']").remove();
                    var UserLoginInfo_Cn = new Template(' <div class="box" method="uinfo"><span class="name normal"><span class="pr15">欢迎您，#{UserName}</span><a href="http://my.elong.com/logout_cn.html" title="安全退出艺龙帐户">退出</a></span></div>');
                    var UserLoginInfo_En = new Template(' <div class="box en" method="uinfo"><span class="name normal"><span class="pr15">Welcome，#{UserName}</span><a href="http://my.elong.net/logout_en.html" title="Sign Out">Sign Out</a></span></div>');
                    var UserLoginInfo_OnLine = new Template("<b>欢迎您, #{UserName}</b><span class='ml5 mr5'>[<a href='http://travel.elong.com/my/logout_cn.html?campaign_id=#{CampaignId}'>退出</a>]</span><a href='http://travel.elong.com/my/index_cn.html?campaign_id=#{CampaignId}'>我的帐户</a>|<a href='http://travel.elong.com/my/index_cn.html?campaign_id=#{CampaignId}'>订单管理</a>");
                    var UserLoginInfo_OnLineEn = new Template(" <b>Welcome,#{UserName}</b> <span class='ml5 mr5'>[<a href='http://travel.elong.net/my/logout_en.html?campaign_id=#{CampaignId}' class='link'>Sign Out</a>]</span><a href='http://travel.elong.net/my/index_en.html?campaign_id=#{CampaignId}'>My Account</a>");
                    var WebSiteType = "Cn";
                    var url = window.location.toString().toLowerCase();
                    var UserLoginInfo = "";
                    var CampaignId = "";
                    if (url.indexOf("elong.com") != -1 && url.indexOf("travel") < 0) {
                        WebSiteType = "Cn";
                        UserLoginInfo = UserLoginInfo_Cn;
                    }
                    if (url.indexOf("elong.net") != -1 && url.indexOf("travel") < 0) {
                        WebSiteType = "En";
                        UserLoginInfo = UserLoginInfo_En;
                    }
                    if (url.indexOf("travel.elong.net") != -1) {
                        WebSiteType = "OnLineEn";
                        UserLoginInfo = UserLoginInfo_OnLineEn;
                        CampaignId = this.GetRequest("campaign_id");
                    }
                    if (url.indexOf("travel.elong.com") != -1 || url.indexOf("elong") < 0) {
                        WebSiteType = "OnLineCn";
                        UserLoginInfo = UserLoginInfo_OnLine;
                        CampaignId = this.GetRequest("campaign_id");
                    }
                    var msg = res.MemberName;
                    if (!String.isNullOrEmpty(WebSiteType)) {
                        UserLoginInfo = UserLoginInfo.eval({
                            UserName: msg,
                            CampaignId: CampaignId
                        });
                    }
                    $(UserLoginInfo).appendTo(divUserLoginInfo);
                } else {
                    var divUserLoginInfo = $("#header div[method='dvAccount']");
                    divUserLoginInfo.find("div[method='uinfo']").remove();
                    divUserLoginInfo.find("div[method='reg']").show();
                    divUserLoginInfo.find("div[method='mylogin']").show();
                }
            } else {
                this.divLogin.show();
            }
        }.bind(this), false, "GET", null, "jsonp");
    },
    checkBig5: function() {
        var b = false;
        if (window.location.href.indexOf("big5.elong.com") > -1) {
            b = true;
        }
        if (this.elongheader_langs.length <= 0) {
            return;
        }
        var c = window.location.href;
        if (b) {
            c = c.substr(32);
            this.elongheader_langs[0].innerHTML += '<a href="#?" mth="chg" id="mimg_bg_cn"   ></a>';
        } else {
            var a = window.location.host.toLowerCase();
            if (a.indexOf("elong.net") != -1) {
                c = "http://big5.elong.com/gate/big5/www.elong.com";
            } else {
                c = "http://big5.elong.com/gate/big5/" + c.substr(7);
            }
            this.elongheader_langs[0].innerHTML += '<a href="' + c + '" id="mimg_bg_big5"   ></a>';
        }
    },
    onClickelongheader_langs: function(b) {
        var a = Event.element(b);
        var g = a.attr("mth");
        switch (g) {
        case "eng":
            var d = window.location.host.toLowerCase();
            var i = window.location.href.substring(d.length + 7).toLowerCase();
            switch (d.substring(0, d.indexOf(".elong"))) {
            case "hotel":
                window.location = "http://" + d.replace(/\.com/, ".net") + i.replace(/_cn/, "_en");
                return;
            case "flight":
                var c = i.replace(/_cn/, "_en").replace(/cn_/, "en_");
                window.location = "http://" + d.replace(/\.com/, ".net") + c;
                return;
            case "iflight":
                var c = i.replace(/_cn/, "_en").replace(/cn_/, "en_");
                window.location = "http://" + d.replace(/\.com/, ".net") + c;
                return;
            case "globalhotel":
                window.location = "http://globalhotel.elong.net";
                return;
            case "dianping":
                break;
            }
            if (i.indexOf("/iflight/") == 0) {
                var f = i.replace(/\/cn\//, "/en/").replace(/cn_/, "en_");
                window.location = "http://" + d.replace(/\.com/, ".net") + f;
                return;
            } else {
                if (i.indexOf("/square/") == 0) {
                    window.location = "http://" + d.replace(/\.com/, ".net") + i.replace(/\/cn\//, "/en/");
                    return;
                }
            }
            window.location = "http://www.elong.net";
            break;
        case "chg":
            var d = window.location.host.toLowerCase();
            var i = window.location.href.substring(d.length + 7).toLowerCase();
            switch (d.substring(0, d.indexOf(".elong"))) {
            case "hotel":
                window.location = "http://" + d.replace(/\.net/, ".com") + i.replace(/_en/, "_cn");
                return;
            case "flight":
                var c = i.replace(/_en/, "_cn").replace(/en_/, "cn_");
                window.location = "http://" + d.replace(/\.net/, ".com") + c;
                return;
            case "iflight":
                var c = i.replace(/_en/, "_cn").replace(/en_/, "cn_");
                window.location = "http://" + d.replace(/\.net/, ".com") + c;
                return;
            case "globalhotel":
                window.location = "http://globalhotel.elong.com";
                return;
            case "dianping":
                break;
            case "big5":
                if (window.location.href.length > 32) {
                    var e = "http";
                    var h = e + "://" + window.location.href.substr(32);
                    if (h.indexOf("#?")) {
                        h = h.replace("#?", "");
                    }
                    window.location = h;
                    return;
                }
                break;
            }
            if (i.indexOf("/iflight/") == 0) {
                var f = i.replace(/\/en\//, "/cn/").replace(/en_/, "cn_");
                window.location = "http://" + d.replace(/\.net/, ".com") + f;
                return;
            } else {
                if (i.indexOf("/square/") == 0) {
                    window.location = "http://" + d.replace(/\.net/, ".com") + i.replace(/\/en\//, "/cn/");
                    return;
                }
            }
            window.location = "http://www.elong.com";
            break;
        }
    },
    onKeyDowndivLogin: function(a) {
        if (a.keyCode == 13) {
            this.divLogin.find("input[mth='login']").click();
            return false;
        }
    },
    onMouseOverdivLogin: function(c) {
        var b = Event.element(c);
        var d = b.attr("mth");
        switch (d) {
        case "user":
            var a = this.divLogin.find("div[mth='elongheader_Reminder']:hidden");
            if (a.length > 0) {
                a.show();
                FunctionExt.defer(function() {
                    a.fadeOut("slow");
                }.bind(this), 3000);
            }
            break;
        }
    },
    onClickdivLogin: function(d) {
        var c = Event.element(d);
        var i = c.attr("mth");
        if (c.attr("mth") != "user") {
            this.divLogin.find("div[mth='elongheader_Reminder']:visible").fadeOut("slow");
        }
        if (c.attr("mth") != "otherMem") {
            this.divLogin.find("ul[mth='divOtherMem']:visible").hide();
        }
        switch (i) {
        case "findPwd":
            var f = window.location.host.indexOf(".net") > 0 ? true: false;
            var m = this.divLogin.find("input.user").val().trim();
            var h = "";
            if (!Object.isNull(m) && m.trim() != "") {
                h = String.format("http://{0}/ForgetPass_{1}_{2}.html", f ? "my.elong.net": "my.elong.com", f ? "en": "cn", encodeURIComponent(m));
                if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
                    h = String.format("http://{0}/my/ForgetPass_{1}_{2}.html?campaign_id={3}", window.location.host, f ? "en": "cn", encodeURIComponent(m), this.GetRequest("campaign_id"));
                }
            } else {
                h = String.format("http://{0}/ForgetPass_{1}.html", f ? "my.elong.net": "my.elong.com", f ? "en": "cn");
                if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
                    h = String.format("http://{0}/my/ForgetPass_{1}.html?campaign_id={2}", window.location.host, f ? "en": "cn", this.GetRequest("campaign_id"));
                }
            }
            window.open(h, "_blank");
            break;
        case "user":
            var b = this.divLogin.find("div[mth='elongheader_Reminder']:hidden");
            if (b.length > 0) {
                b.show();
                FunctionExt.defer(function() {
                    b.fadeOut("slow");
                }.bind(this), 3000);
            }
            break;
        case "otherMem":
            this.divLogin.find("ul[mth='divOtherMem']").show();
            FunctionExt.defer(function() {
                this.divLogin.find("ul[mth='divOtherMem']").hide();
            }.bind(this), 6000);
            break;
        case "imgCode":
            var l = e ? String.format("http://my.elong.net/Validate.html?timespan={0}", new Date().getTime()) : String.format("http://my.elong.com/Validate.html?timespan={0}", new Date().getTime());
            if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0 || window.location.host.toLowerCase().indexOf("travel.net") >= 0) {
                l = e ? String.format("http://travel.elong.net/my/Validate.html?timespan={0}", new Date().getTime()) : String.format("http://travel.elong.com/my/Validate.html?timespan={0}", new Date().getTime());
            }
            this.divLogin.find("img").attr("src", l);
            break;
        case "login":
            var k = this.divLogin.find("input.user");
            var j = this.divLogin.find("input.password");
            var n = this.divLogin.find("input.Code");
            var a = this.divLogin.find("input[mth='login']");
            var e = window.location.host.indexOf("elong.net") > 0 ? true: false;
            var g = $("#inputRememberMe").attr("checked") ? true: false;
            if (!validator.valid(k.val().trim(), "notEmpty & loginName")) {
                $error(k, e ? "Please enter your login name.": "登录名不能为空。");
                return;
            }
            if (!validator.valid(j.val(), "notEmpty")) {
                $error(j, e ? "Please enter your password.": "密码不能为空。");
                return;
            }
            a[0].className = "Login_loding";
            a.attr("disabled", "disabled");
            Elong.login(encodeURIComponent(k.val().trim()), j.val(), n.val(),
            function(o) {
                if (o.MemberLoginCode != 1 && o.IsShowVCode) {
                    this.divLogin.find("span:hidden").show();
                    var q = e ? String.format("http://my.elong.net/Validate.html?timespan={0}", new Date().getTime()) : String.format("http://my.elong.com/Validate.html?timespan={0}", new Date().getTime());
                    if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0 || window.location.host.toLowerCase().indexOf("travel.net") >= 0) {
                        q = e ? String.format("http://travel.elong.net/my/Validate.html?timespan={0}", new Date().getTime()) : String.format("http://travel.elong.com/my/Validate.html?timespan={0}", new Date().getTime());
                    }
                    this.divLogin.find("img").attr("src", q);
                    $("span[mth='servicehelp']").hide();
                    $("a[mth='servicehelp']").hide();
                }
                switch (o.MemberLoginCode) {
                case 1:
                    var p = window.location.href;
                    while (p.indexOf("#?") != -1) {
                        p = p.replace("#?", "");
                    }
                    window.location = p;
                    return;
                case 100:
                    $error(k, e ? "Username or password does not match!": "用户名或密码不匹配！");
                    break;
                case 101:
                    $error(j, e ? "You have entered an incorrect password.": "登录密码错误");
                    break;
                case 102:
                    break;
                case 103:
                    $error(k, e ? "This account has been cancelled or frozen.": "用户已经被冻结或取消");
                    break;
                case 104:
                    $error(n, e ? "You have entered an incorrect verification code.": "验证码错误");
                    break;
                default:
                    $error(k, e ? "There is an unknown error.": "未知错误");
                    break;
                }
                a[0].className = "Login";
                a.removeAttr("disabled");
            }.bind(this), null, e, g);
            break;
        }
    },
    dispose: function() {
        this.destroyEvent();
        this.destroyDOM();
    }
});
var smallLoginDialog = Elong.smallLoginDialog;
smallLoginDialog = Class.create();
Object.extend(smallLoginDialog.prototype, {
    name: "loginDialog",
    m_Container_cn: new Template("<div id='SmallLonginContain'><div  class='com_dialog-content com_widget-content'><div class='package_login' ><div id='smallDialog_login'><dl class='bdr'><dt class='t14 bold pb15'> 已是艺龙会员 </dt><dd class='errorBox none'></dd><dd>用户名 / 卡号 / 手机号 / 邮箱：</dd><dd><input type='text' class='w207'  method='uid'/></dd><dd class='mt10'>密码：</dd><dd><input type='password' class='w134' method='psw'/><a href='#?' method='forgetpwd'>忘记密码？</a></dd><dl style='display:none; margin:0; padding:0;' id='valCode'><dd class='mt20'>验证码：<input class='w40' type='text' method='Code'><img  class='middle mr5' method='imgRefresh' /><a href='#?' method='refreshCode'>刷新验证码？</a></dd></dl><dd class='pt10' method='remberDiv'><input name='' type='checkbox' value=''  method='remberMe'/> 下次自动登录<span class='l_black'>(保存2个月)</span></dd><dd class='mt20'><input type='button' value='登录' onfocus='this.blur()'  class='search_bt' method='login'></dd><dd class='mt15' method='QQDiv'><span class='ltenpayIcon'></span><a href='#{TenyPayLogin}'>QQ/财付通会员登录</a></dd></dl><dl class='noMember' id='RegDiv'><dt class='t14 bold'> 不是艺龙会员？ </dt><dd class='tc mt20 pt20'><a href='#?' method='reg' class='t14 bold ml10'>注册新帐户</a><br /><br /><span id='showNoCard'><input type='button' value='直接预订'  method='nocardbooking' onfocus='this.blur()'  class='btn_book'></span></dd></dl><div class='clear'></div></div><div class='loadingBox '  id='loading' style='display:none;'>登录中...<div class='loading'></div></div></div></div></div>"),
    m_Container_en: new Template("<div id='SmallLonginContain'><div  class='com_dialog-content com_widget-content'><div class='package_login' ><div id='smallDialog_login'><dl class='bdr'><dt class='t14 bold pb15'> Already a registered user  </dt><dd class='errorBox none'></dd><dd>User name / Card number / Email:</dd><dd><input type='text' class='w207'  method='uid'/></dd><dd class='mt10'>Password:</dd><dd><input type='password' class='w134' method='psw'/><a href='#?' #{findPsd} method='forgetpwd'>Forgot your password?</a></dd><dl style='display:none; margin:0; padding:0;' id='valCode'><dd class='mt20'>verification code:<input class='w40' type='text' method='Code'><img  class='middle mr5' method='imgRefresh' /><a href='#?' method='refreshCode'>refresh the codes?</a></dd></dl><dd class='pt10'  method='remberDiv'><input name='' type='checkbox' value=''  method='remberMe'/> Login automatically next time<span class='l_black'>(save two months)</span></dd><dd class='mt20'><input type='button' value='Sign&nbsp;in' onfocus='this.blur()'  class='search_bt' method='login'></dd></dl><dl class='noMember' id='RegDiv'><dt class='t14 bold'> New user?  </dt><dd class='tc mt20 pt20'><a href='#?'  method='reg' class='t14 bold ml10'>Sign up now</a> <br /><br /><span id='showNoCard'><input type='button' value='Book as guest'  method='nocardbooking' onfocus='this.blur()'  class='btn_book'></span></dd></dl><div class='clear'></div></div><div class='loadingBox '  id='loading' style='display:none;'>Loading...<div class='loading'></div></div></div></div></div>"),
    loginEmpty_cn: "登录名不能为空",
    loginEmpty_en: "Please enter your login name.",
    passwordEmpty_cn: "密码不能为空",
    passwordEmpty_en: "Please enter your password.",
    loginError_100_cn: "用户名或密码不匹配！",
    loginError_100_en: "Username or password does not match!",
    loginError_101_cn: "登录密码错误",
    loginError_101_en: "You have entered an incorrect password.",
    loginError_103_cn: "用户已经被冻结或取消",
    loginError_103_en: "This account has been cancelled or frozen.",
    loginError_104_cn: "验证码错误",
    loginError_104_en: "You have entered an incorrect verification code.",
    loginDefaultError_cn: "未知错误",
    loginDefaultError_en: "There is an unknown error.",
    diaglog: null,
    validateUrl: null,
    isRememberMe: false,
    options: {
        isShowNoCardButton: true,
        language: "cn",
        isRemember: false,
        nexturl: null,
        campaign_id: null,
        RegShow: true,
        title: "登录",
        width: 550,
        callback: null
    },
    initialize: function(options) {
        Object.extend(Object.extend(this, this.options), options);
        this.options.title = this.language.toLowerCase() == "cn" ? "登录": "Login";
        var m_TenyPayLogin = String.format("http://www.elong.com/redirect/bdlogin.aspx?islogin=1&bdfrom=503&Iswindow=0&nextUrl=http://my.elong.com/index_cn.html?bdfrom=503");
        if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
            this.validateUrl = String.format("http://{0}/my/Validate.html?timespan={1}", window.location.host, new Date().getTime());
            m_TenyPayLogin = String.format("http://www.elong.com/redirect/bdlogin.aspx?islogin=1&bdfrom=503&Iswindow=0&nextUrl=http://my.elong.com/index_cn.html?bdfrom=503");
        }
        this.diaglog = new Dialog(Object.extend(this.options, {
            htmlContent: this.language.toLowerCase() == "cn" ? this.m_Container_cn.eval({
                TenyPayLogin: m_TenyPayLogin
            }) : this.m_Container_en.eval({
                findPsd: ""
            }),
            initEvent: function(window) {
                this.initializeDOM();
                if (this.isRemember) {
                    this.RememberInput.attr("checked", true);
                    this.isRememberMe = true;
                    Elong.GetUserInfo(function(res) {
                        if (!Object.isNull(res)) {
                            if (res.isLogin == "true") {
                                if (res.Mobile.trim() != "-1") {
                                    this.UserIdText.attr("value", res.Mobile);
                                    this.UserIdText.attr("readonly", true);
                                } else {
                                    if (res.Email.trim() != "-1") {
                                        this.UserIdText.attr("value", res.Email);
                                        this.UserIdText.attr("readonly", true);
                                    } else {
                                        this.UserIdText.attr("value", res.CardNo);
                                        this.UserIdText.attr("readonly", true);
                                    }
                                }
                            }
                        }
                    }.bind(this));
                }
                if (!this.RegShow) {
                    this.RegDiv.hide();
                } else {
                    this.RegDiv.show();
                }
                if (!this.isShowNoCardButton) {
                    this.showNocard.hide();
                } else {
                    this.showNocard.show();
                }
                if (!String.isNullOrEmpty(this.campaign_id)) {
                    this.SmallLonginContain.find("dd[method='remberDiv']").hide();
                    this.SmallLonginContain.find("dd[method='QQDiv']").hide();
                } else {
                    this.SmallLonginContain.find("dd[method='remberDiv']").show();
                    this.SmallLonginContain.find("dd[method='QQDiv']").show();
                }
                window.bind("keydown",
                function(evt) {
                    if (evt.keyCode == 13) {
                        this.login();
                        return false;
                    }
                }.bind(this));
                window.bind("click",
                function(evt) {
                    var element = Event.element(evt);
                    var method = element.attr("method");
                    switch (method) {
                    case "forgetpwd":
                        var userName = this.UserIdText.val();
                        var m_ForgetPwdUrl = "";
                        if (!Object.isNull(userName) && userName.trim() != "") {
                            m_ForgetPwdUrl = String.format("http://{0}/ForgetPass_{1}_{2}.html", this.language.toLowerCase() == "cn" ? "my.elong.com": "my.elong.net", this.language.toLowerCase() == "cn" ? "cn": "en", encodeURIComponent(userName));
                            if (document.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
                                m_ForgetPwdUrl = String.format("http://{0}/my/ForgetPass_{1}_{2}.html?Campaign_id={3}", document.location.host, this.language.toLowerCase() == "cn" ? "cn": "en", encodeURIComponent(userName), this.campaign_id);
                            }
                        } else {
                            m_ForgetPwdUrl = String.format("http://{0}/ForgetPass_{1}.html", this.language.toLowerCase() == "cn" ? "my.elong.com": "my.elong.net", this.language.toLowerCase() == "cn" ? "cn": "en");
                            if (document.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
                                m_ForgetPwdUrl = String.format("http://{0}/my/ForgetPass_{1}.html?Campaign_id={3}", document.location.host, this.language.toLowerCase() == "cn" ? "cn": "en", this.campaign_id);
                            }
                        }
                        document.location.href = m_ForgetPwdUrl;
                        break;
                    case "login":
                        this.login();
                        break;
                    case "nocardbooking":
                        this.NoCardBooking();
                        break;
                    case "reg":
                        this.RegClick();
                        break;
                    case "Code":
                        break;
                    case "imgRefresh":
                        var imgSrc = String.format("http://{0}/Validate.html?timespan={1}", this.language.toLowerCase() == "cn" ? "my.elong.com": "my.elong.net", new Date().getTime());
                        if (document.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
                            imgSrc = String.format("http://{0}/my/Validate.html?timespan={1}", document.location.host, new Date().getTime());
                        }
                        this.SmallLonginContain.find("img").attr("src", imgSrc);
                        break;
                    case "refreshCode":
                        var refreshUrl = String.format("http://{0}/Validate.html?timespan={1}", this.language.toLowerCase() == "cn" ? "my.elong.com": "my.elong.net", new Date().getTime());
                        if (document.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
                            refreshUrl = String.format("http://{0}/my/Validate.html?timespan={1}", document.location.host, new Date().getTime());
                        }
                        this.SmallLonginContain.find("img").attr("src", refreshUrl);
                        break;
                    case "remberMe":
                        if (element.attr("checked") == true) {
                            this.isRememberMe = true;
                        } else {
                            this.isRememberMe = false;
                        }
                        break;
                    case "close":
                        this.dispose();
                        break;
                    }
                }.bind(this));
            }.bind(this)
        }));
        this.render();
    },
    RegClick: function() {
        var a = String.format("http://{0}/register_{1}.html", "my.elong.com", this.language.toLowerCase() == "cn" ? "cn": "en");
        if (window.location.host.toLowerCase().indexOf("travel.elong") >= 0) {
            a = String.format("http://{0}/my/register_{1}.html?Campaign_id={2}", window.location.host, this.language.toLowerCase() == "cn" ? "cn": "en", this.campaign_id);
        }
        if (!Object.isNull(this.nexturl)) {
            if (a.indexOf("?") >= 0) {
                a = String.format(a + "&nexturl={0}", this.nexturl);
            } else {
                a = String.format(a + "?nexturl={0}", this.nexturl);
            }
        }
        document.location.href = a;
    },
    login: function() {
        if (!validator.valid(this.uid.val().trim(), "notEmpty & loginName")) {
            $error(this.uid, this.language.toLowerCase() == "cn" ? this.loginEmpty_cn: this.loginEmpty_en);
            return;
        }
        if (!validator.valid(this.pwd.val(), "notEmpty")) {
            $error(this.pwd, this.language.toLowerCase() == "cn" ? this.passwordEmpty_cn: this.passwordEmpty_en);
            return;
        }
        this.showLoading();
        Elong.login(encodeURIComponent(this.uid.val().trim()), this.pwd.val(), this.vcode.val(),
        function(a) {
            if (a.MemberLoginCode != 1 && a.IsShowVCode) {
                this.valCodeDiv.show();
                var b = String.format("http://{0}/Validate.html?timespan={1}", this.language.toLowerCase() == "cn" ? "my.elong.com": "my.elong.net", new Date().getTime());
                this.SmallLonginContain.find("img").attr("src", b);
            } else {
                this.valCodeDiv.hide();
            }
            switch (a.MemberLoginCode) {
            case 1:
                $("div[class^='com_dialog-titlebar']").remove();
                $("div[class^='com_dialog-content']").remove();
                $("div[class^='com_dialog com_widget com_widget-content com_corner-all com_draggable']").remove();
                Object.isNull(this.callback) ? window.location.href = this.nexturl: this.callback(a.MemberLoginCode);
                return;
            case 100:
                this.hideLoading();
                $error(this.uid, this.language.toLowerCase() == "cn" ? this.loginError_100_cn: this.loginError_100_en);
                break;
            case 101:
                this.hideLoading();
                $error(this.pwd, this.language.toLowerCase() == "cn" ? this.loginError_101_cn: this.loginError_101_en);
                break;
            case 102:
                break;
            case 103:
                this.hideLoading();
                $error(this.uid, this.language.toLowerCase() == "cn" ? this.loginError_103_cn: this.loginError_103_en);
                break;
            case 104:
                this.hideLoading();
                $error(this.vcode, this.language.toLowerCase() == "cn" ? this.loginError_104_cn: this.loginError_104_en);
                break;
            default:
                this.hideLoading();
                $error(this.uid, this.language.toLowerCase() == "cn" ? this.loginDefaultError_cn: this.loginDefaultError_en);
                break;
            }
        }.bind(this), null, this.language.toLowerCase() == "cn" ? false: true, this.isRememberMe);
        this.dispose();
    },
    NoCardBooking: function() {
        this.showLoading();
        Elong.login("", "", "",
        function(b) {
            var a = false;
            switch (b.MemberLoginCode) {
            case 2:
                $("div[class^='com_dialog-titlebar']").remove();
                $("div[class^='com_dialog-content']").remove();
                $("div[class^='com_dialog com_widget com_widget-content com_corner-all com_draggable']").remove();
                Object.isNull(this.callback) ? window.location.href = this.nexturl: this.callback(b.MemberLoginCode);
                return;
            default:
                this.hideLoading();
                break;
            }
        }.bind(this), null, this.language.toLowerCase() == "cn" ? false: true, false);
        this.dispose();
    },
    showLoading: function() {
        this.btnLogin.attr("disabled", "disabled");
        this.smallDialog_login.hide();
        this.loading.show();
    },
    hideLoading: function() {
        this.smallDialog_login.show();
        this.loading.hide();
        this.btnLogin.removeAttr("disabled");
    },
    initializeDOM: function() {
        this.SmallLonginContain = $("#SmallLonginContain");
        this.smallDialog_login = $("#smallDialog_login");
        this.showNocard = $("#showNoCard");
        this.RegDiv = $("#RegDiv");
        this.uid = $("#SmallLonginContain").find("input[method='uid']");
        this.pwd = $("#SmallLonginContain").find("input[method='psw']");
        this.vcode = $("#SmallLonginContain").find("input[method='Code']");
        this.btnLogin = $("#SmallLonginContain").find("input[method='login']");
        this.loading = $("#loading");
        this.valCodeDiv = $("#valCode");
        this.RememberInput = $("#SmallLonginContain").find("input[method='remberMe']");
        this.UserIdText = $("#SmallLonginContain").find("input[method='uid']");
    },
    destroyDOM: function() {},
    initializeEvent: function() {},
    destroyEvent: function() {},
    render: function() {
        this.diaglog.show();
    },
    dispose: function() {
        this.diaglog = null;
    }
});
$(document).ready(function() {
    Elong.renderAds();
    Elong.recordSEOKeyWord();
    var a = new ElongHeaderControl();
});
function $loginDialog(f, e, d, g, b, a, h) {
    var c = new smallLoginDialog({
        isShowNoCardButton: Object.isNull(e) ? true: e,
        language: f,
        isRemember: Object.isNull(d) ? false: d,
        nexturl: g,
        campaign_id: String.isNullOrEmpty(b) ? null: b,
        callback: a,
        RegShow: Object.isNull(h) ? true: h
    });
}
var ValidatorClass = Elong.Utility.ValidatorClass = Class.create();
Object.extend(ValidatorClass.prototype, {
    name: "ValidatorClass",
    initialize: function() {},
    validType: {
        notEmpty: null,
        email: /^\w+((-\w+)|(\.\w+))*\@{1}\w+((-\w+)|(\.\w+))*\.{1}\w{2,4}(\.{0,1}\w{2,4}){0,4}$/,
        textRange: 20,
        loginName: /[^@]+@{1}[^@\.]+\.+[^@]+|[0-9a-zA-Z\u4e00-\u9fa5]*/,
        passengerName: /^[a-zA-Z]{1,20}\/[a-zA-Z]{1,20}((| )[a-zA-Z]{1,20}){0,20}$/,
        nickName: /^([a-zA-Z]|[\u4e00-\u9fa5]|\/| )+$/,
        enString: /^[a-zA-Z]+$/,
        cnString: /^[\u4e00-\u9fa5]+$/,
        nonSpecialSign: /^[^~!@#$%^&*！￥…\s，。]*$/,
        date: null,
        dateEn: null,
        dateRange: null,
        fileName: /^[a-z]:(\\[^\\\/:\*\?"><|]+)*\\?$/i,
        directoryName: /^[a-z]:(\\[^\\\/:\*\?"><|]+)+$/i,
        picFileName: /\.(jpg)|(jpeg)|(png)|(gif)$/i,
        attachFileName: /\.(doc)|(xls)|(txt)|(zip)|(rar)$/i,
        number: /^\d+$/,
        zipCode: /^\d{6}$/,
        idCard: null,
        year: /^[1-2][0-9]{3}$/,
        integer: /^-?[0-9]{1,9}$/,
        real: /^-?[0-9]{1,28}(\.[0-9]*)?$/,
        phone: /^\d{3,4}-\d{7,8}((\s|;)+\d{3,4}-\d{7,8})*$/,
        mobile: /^1[0-9]{10}$/,
        money: /^[0-9]{1,11}(\.[0-9]{1,2})?$/
    },
    valid: function(g, f, c) {
        if (arguments.length < 2) {
            alert("validator.valid()缺少参数");
        }
        var d = true;
        var a = f.trim().split("&");
        for (var b = 0; b < a.length; b++) {
            if (!d) {
                return false;
            }
            var e = a[b].trim();
            switch (e) {
            case "notEmpty":
                d = !String.isNullOrEmpty(g);
                break;
            case "textRange":
                if (arguments.length < 4) {
                    return false;
                }
                d = this.validateTextLength(g, arguments[2], arguments[3]);
                break;
            case "idCard":
                d = this.validateIDCard(g);
                break;
            case "date":
                d = this.validateDate(g);
                break;
            case "dateEn":
                d = this.validateDate(this.reFormatDateString(g));
                break;
            case "dateRange":
                if (arguments.length < 4 && !this.validateDate(g)) {
                    return false;
                }
                d = this.validateDateRange(g, arguments[2], arguments[3]);
                break;
            default:
                d = this.regularValidate(g, this.validType[e]);
                break;
            }
        }
        return d;
    },
    validateIDCard: function(h) {
        h = h.toString();
        if (h.length == 18) {
            var d, e, f;
            if (!this.valid(h.substr(0, 17), "number")) {
                return false;
            }
            d = parseInt(h.substr(0, 1)) * 7 + parseInt(h.substr(1, 1)) * 9 + parseInt(h.substr(2, 1)) * 10;
            d = d + parseInt(h.substr(3, 1)) * 5 + parseInt(h.substr(4, 1)) * 8 + parseInt(h.substr(5, 1)) * 4;
            d = d + parseInt(h.substr(6, 1)) * 2 + parseInt(h.substr(7, 1)) * 1 + parseInt(h.substr(8, 1)) * 6;
            d = d + parseInt(h.substr(9, 1)) * 3 + parseInt(h.substr(10, 1)) * 7 + parseInt(h.substr(11, 1)) * 9;
            d = d + parseInt(h.substr(12, 1)) * 10 + parseInt(h.substr(13, 1)) * 5 + parseInt(h.substr(14, 1)) * 8;
            d = d + parseInt(h.substr(15, 1)) * 4 + parseInt(h.substr(16, 1)) * 2;
            e = d % 11;
            if (e == 2) {
                f = h.substr(17, 1).toUpperCase();
            } else {
                f = parseInt(h.substr(17, 1));
            }
            switch (e) {
            case 0:
                if (f != 1) {
                    return false;
                }
                break;
            case 1:
                if (f != 0) {
                    return false;
                }
                break;
            case 2:
                if (f != "X") {
                    return false;
                }
                break;
            case 3:
                if (f != 9) {
                    return false;
                }
                break;
            case 4:
                if (f != 8) {
                    return false;
                }
                break;
            case 5:
                if (f != 7) {
                    return false;
                }
                break;
            case 6:
                if (f != 6) {
                    return false;
                }
                break;
            case 7:
                if (f != 5) {
                    return false;
                }
                break;
            case 8:
                if (f != 4) {
                    return false;
                }
                break;
            case 9:
                if (f != 3) {
                    return false;
                }
                break;
            case 10:
                if (f != 2) {
                    return false;
                }
            }
        } else {
            if (!this.valid(h, "number")) {
                return false;
            }
        }
        switch (h.length) {
        case 15:
            var g = "19" + h.substr(6, 2) + "-" + h.substr(8, 2) + "-" + h.substr(10, 2);
            return this.valid(g, "date");
        case 18:
            var i = h.substr(6, 4) + "-" + h.substr(10, 2) + "-" + h.substr(12, 2);
            return this.valid(i, "date");
        }
        return false;
    },
    validateTextLength: function(d, c, b) {
        var a = d.trim().bytelength();
        if (Object.isNull(c)) {
            c = 0;
        }
        if (Object.isNull(b)) {
            b = 9999999;
        }
        return (a >= c) && (a <= b);
    },
    validateDateRange: function(c, b, a) {
        if (Object.isNull(b)) {
            b = "0001-01-01";
        }
        if (Object.isNull(a)) {
            a = "9999-12-31";
        }
        return this.reFormatDateString(c) >= this.reFormatDateString(b) && this.reFormatDateString(c) <= this.reFormatDateString(a);
    },
    regularValidate: function(b, a) {
        a.lastIndex = -1;
        if (b.length > 0) {
            return a.test(b);
        }
        return true;
    },
    validateDate: function(g) {
        if (!this.regularValidate(g, /^\d{4}-\d{1,2}-\d{1,2}$/)) {
            return false;
        }
        var c = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        var b = new Array(3);
        var h, d, a;
        var e = true;
        var f = g;
        if (f.length != 0) {
            b = f.split("-");
            if (b.length != 3 || b[1].length > 2 || b[2].length > 2 || b[1].length < 1 || b[2].length < 1) {
                e = false;
            }
            h = parseInt(b[0], 10);
            d = parseInt(b[1], 10);
            a = parseInt(b[2], 10);
            if (isNaN(h) || isNaN(d) || isNaN(a)) {
                e = false;
            }
            if (h < 1900 || h > 2100) {
                e = false;
            }
            if (((h % 4 == 0) && (h % 100 != 0)) || (h % 400 == 0)) {
                c[1] = 29;
            }
            if (d < 1 || d > 12 || a < 1 || a > c[d - 1]) {
                e = false;
            }
        } else {
            e = false;
        }
        return e;
    },
    reFormatDateString: function(b) {
        var a = new Array(3);
        var e, d, c;
        if (b.length == 0) {
            return "";
        }
        if (b.indexOf("-") > -1) {
            a = b.split("-");
            if (a.length != 3) {
                return "";
            }
            e = a[0];
            d = a[1];
            c = a[2];
        } else {
            a = b.split("/");
            if (a.length != 3) {
                return "";
            }
            e = a[2];
            d = a[0];
            c = a[1];
        }
        if (e.length <= 2) {
            e = "19" + e;
        }
        if (d.length == 1) {
            d = "0" + d;
        }
        if (c.length == 1) {
            c = "0" + c;
        }
        return e + "-" + d + "-" + c;
    },
    reFormatDateStringEn: function(b) {
        var a = new Array(3);
        var e, d, c;
        if (b.length == 0) {
            return "";
        }
        if (b.indexOf("-") > -1) {
            a = b.split("-");
            if (a.length != 3) {
                return "";
            }
            e = a[0];
            d = a[1];
            c = a[2];
        }
        if (e.length <= 2) {
            e = "20" + e;
        }
        if (d.length == 1) {
            d = "0" + d;
        }
        if (c.length == 1) {
            c = "0" + c;
        }
        return d + "/" + c + "/" + e;
    },
    getTodayString: function() {
        var a = new Date();
        return this.getDateString(a);
    },
    getDateString: function(a) {
        var d = a.getMonth() + 1;
        var b = a.getDate();
        var e = d > 9 ? d.toString() : "0" + d.toString();
        var c = b > 9 ? b.toString() : "0" + b.toString();
        var f = a.getFullYear().toString() + "-" + e + "-" + c;
        return f;
    },
    convertDate: function(b) {
        if (b.length == 0) {
            return null;
        }
        var e = this.reFormatDateString(b);
        var f, d, c;
        if (e.indexOf("-") > -1) {
            var a = e.split("-");
            if (a.length != 3) {
                return null;
            }
            f = a[0];
            d = a[1];
            c = a[2];
        }
        return new Date(f, parseInt(d, 10) - 1, c);
    }
});
var validator = new ValidatorClass();
var TipWindow = Elong.Control.TipWindow;
TipWindow = Class.create();
Object.extend(TipWindow.prototype, {
    name: "TipWindow",
    template: new Template('<div class="com_way" style="display:none; position: absolute; z-index: 2010;width: #{width}px;#{height}"><div m="z" class="z" style="width: #{twidth}px;"></div><div m="bj" class="bj"></div><div class="clear"></div><div class="bk" style="width: #{cwidth}px;#{cheight}"><div class="bk_1" style="width: #{bwidth}px; #{bheight}">#{content}</div></div><div m="nz" class="none" style="width: #{twidth}px;"></div><div m="nbj" class="none"></div><div class="clear"></div></div>'),
    options: {
        htmlContent: "",
        eventElement: null,
        buildHtmlContent: null,
        width: 381,
        height: 0,
        defer: false,
        autoClose: true,
        floatType: null,
        initEvent: function() {}
    },
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        this.eventElement.bind("mouseout", this.onMouseOutElement.bindAsEventListener(this));
        if (this.defer) {
            this.showTimer = FunctionExt.defer(function() {
                if (!Object.isNull(this.buildHtmlContent)) {
                    this.buildHtmlContent(this);
                } else {
                    this.show();
                }
                clearTimeout(this.showTimer);
                this.showTimer = null;
            },
            300, this);
        } else {
            if (!Object.isNull(this.buildHtmlContent)) {
                this.buildHtmlContent(this);
            } else {
                this.show();
            }
        }
    },
    show: function() {
        this.initializeDOM();
        this.initializeEvent();
        this.render();
        this.initEvent(this.windowElement);
    },
    initializeDOM: function() {
        this.contentEndRegion = $("#m_contentend");
        var content = this.template.eval({
            width: this.width,
            height: this.height == 0 ? "": String.format("height:{0}px;", this.height),
            twidth: this.width - 29,
            cwidth: this.width - 2,
            cheight: this.height == 0 ? "": String.format("height:{0}px;", this.height - 8),
            bwidth: this.width - 32,
            bheight: this.height == 0 ? "": String.format("height:{0}px;", this.height - 36),
            content: this.htmlContent
        });
        this.windowElement = $(content).appendTo(this.contentEndRegion);
    },
    destroyDOM: function() {
        this.htmlContent = "";
        this.windowElement = null;
        this.eventElement = null;
        this.contentEndRegion = null;
    },
    initializeEvent: function() {
        this.windowElement.bind("mouseout", this.onMouseOutRegion.bindAsEventListener(this));
        this.windowElement.bind("mouseover", this.onMouseOverRegion.bindAsEventListener(this));
        FunctionExt.defer(this.onOutClick.bindAsEventListener(this), 100);
    },
    destroyEvent: function() {
        $(document).unbind("click", this.onOutClickHandler);
        this.windowElement.unbind("mouseout");
        this.windowElement.unbind("mouseover");
        this.eventElement.unbind("mouseout");
    },
    onMouseOutElement: function() {
        if (this.showTimer != null) {
            clearTimeout(this.showTimer);
            this.showTimer = null;
            this.eventElement.unbind("mouseout");
        }
        this.setOutTimer();
    },
    onMouseOverRegion: function(a) {
        if (this.outTimer != null) {
            clearTimeout(this.outTimer);
            this.outTimer = null;
        }
    },
    onMouseOutRegion: function(a) {
        this.setOutTimer();
    },
    setOutTimer: function() {
        this.outTimer = FunctionExt.defer(function() {
            if (this.autoClose) {
                this.close();
            }
        }.bind(this), 2000, this);
    },
    onOutClick: function() {
        this.onOutClickHandler = function(b) {
            var a = Event.element(b);
            if (a.index(this.eventElement) == 0) {
                $(document).one("click", this.onOutClickHandler);
            } else {
                if (this.windowElement.find(":descendant").index(a) == -1) {
                    if (this.autoClose) {
                        this.close();
                    }
                }
            }
        }.bindAsEventListener(this);
        $(document).one("click", this.onOutClickHandler);
    },
    render: function() {
        var c, a;
        var b = this.getWindowZone(this.eventElement, this.windowElement);
        b = Object.isNull(this.floatType) ? b: this.floatType;
        switch (b) {
        case "leftTop":
            c = this.eventElement.offset().top - this.windowElement.height();
            a = this.eventElement.offset().left - this.width + this.eventElement.width() / 2 + 24;
            this.windowElement.find("div[m='z']").attr("class", "none");
            this.windowElement.find("div[m='bj']").attr("class", "none");
            this.windowElement.find("div[m='nz']").attr("class", "z_br");
            this.windowElement.find("div[m='nbj']").attr("class", "bj_br");
            this.windowElement.find("div.bk").attr("class", "bk_top");
            this.windowElement.find("div.bk_1").attr("class", "bk_top_1");
            break;
        case "leftBottom":
            c = this.eventElement.offset().top + this.eventElement.height() + 3;
            a = this.eventElement.offset().left - this.width + this.eventElement.width() / 2 + 24;
            break;
        case "rightTop":
            c = this.eventElement.offset().top - this.windowElement.height();
            a = this.eventElement.offset().left + this.eventElement.outerWidth() / 2 - 24;
            this.windowElement.find("div[m='z']").attr("class", "none");
            this.windowElement.find("div[m='bj']").attr("class", "none");
            this.windowElement.find("div[m='nz']").attr("class", "z_bl");
            this.windowElement.find("div[m='nbj']").attr("class", "bj_bl");
            this.windowElement.find("div.bk").attr("class", "bk_top");
            this.windowElement.find("div.bk_1").attr("class", "bk_top_1");
            break;
        case "rightBottom":
            c = this.eventElement.offset().top + this.eventElement.height() + 3;
            a = this.eventElement.offset().left + this.eventElement.outerWidth() / 2 - 24;
            this.windowElement.find("div[m='z']").attr("class", "z_tl");
            this.windowElement.find("div[m='bj']").attr("class", "bj_tl");
            this.windowElement.find("div[m='nz']").attr("class", "none");
            this.windowElement.find("div[m='nbj']").attr("class", "none");
            break;
        }
        this.windowElement[0].style.top = c + "px";
        this.windowElement[0].style.left = a + "px";
        this.ie6FilterIFrame = Globals.addIE6Filter(this.windowElement.width() + 10, this.windowElement.height(), a, c);
        this.windowElement.fadeIn("normal");
    },
    getWindowZone: function(b, e) {
        var f = {
            leftTop: "leftTop",
            leftBottom: "leftBottom",
            rightTop: "rightTop",
            rightBottom: "rightBottom"
        };
        var d = Globals.getScrollPosition();
        var a = Globals.browserDimensions();
        var c = true;
        if (a.width - (b.offset().left - d.x) < e.width() && b.offset().left - d.x > e.width()) {
            c = false;
        }
        if (c) {
            if (a.height - (b.offset().top - d.y) > e.height()) {
                return f.rightBottom;
            } else {
                if (b.offset().top - d.y > e.height()) {
                    return f.rightTop;
                } else {
                    return f.rightBottom;
                }
            }
        } else {
            if (a.height - (b.offset().top - d.y) > e.height()) {
                return f.leftBottom;
            } else {
                if (b.offset().top - d.y > e.height()) {
                    return f.leftTop;
                } else {
                    return f.leftBottom;
                }
            }
        }
    },
    close: function() {
        this.dispose();
    },
    dispose: function() {
        if (this.windowElement) {
            this.windowElement.fadeOut("normal");
            FunctionExt.defer(function() {
                if (this.windowElement) {
                    Globals.closeIE6Fliter(this.ie6FilterIFrame);
                    this.windowElement.remove();
                    this.destroyEvent();
                    this.destroyDOM();
                }
            }.bind(this), 500);
        }
    }
});
var ErrorTipWindow = Elong.Control.ErrorTipWindow;
ErrorTipWindow = Class.create();
Object.extend(ErrorTipWindow.prototype, {
    name: "ErrorTipWindow",
    templateRegion: '<div style="display:none; position: absolute; z-index: 5000; " class="com_bug"><div class="w">{0}</div></div>',
    options: {
        errorMsg: "",
        align: "right",
        eventElement: null
    },
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        this.align = String.isNullOrEmpty(this.align) ? "right": this.align;
        this.initializeDOM();
        this.initializeEvent();
        this.render();
    },
    initializeDOM: function() {
        this.contentEndRegion = $("#m_contentend");
        this.windowElement = $(String.format(this.templateRegion, this.errorMsg)).appendTo(this.contentEndRegion);
    },
    destroyDOM: function() {
        this.errorMsg = "";
        this.windowElement = null;
        this.eventElement = null;
        this.contentEndRegion = null;
    },
    initializeEvent: function() {
        FunctionExt.defer(this.onOutClick.bindAsEventListener(this), 100);
    },
    destroyEvent: function() {
        $(document).unbind("click", this.onOutClickHandler);
        this.windowElement.unbind("mouseout");
        this.windowElement.unbind("mouseover");
    },
    onOutClick: function() {
        this.onOutClickHandler = function(b) {
            var a = Event.element(b);
            if (this.windowElement.find(":descendant").index(a) == -1) {
                this.dispose();
            } else {
                $(document).one("click", this.onOutClickHandler);
            }
        }.bindAsEventListener(this);
        $(document).one("click", this.onOutClickHandler);
    },
    onMouseOverRegion: function(b) {
        var a = Event.element(b);
        if (this.outTimer != null) {
            clearTimeout(this.outTimer);
            this.outTimer = null;
        }
    },
    onMouseOutRegion: function(b) {
        var a = Event.element(b);
        this.outTimer = FunctionExt.defer(function() {
            this.dispose();
        },
        10, this);
    },
    render: function() {
        var b = this.eventElement.offset().top + this.eventElement.height() - 17;
        var a = this.eventElement.offset().left + this.eventElement.width() + 5;
        this.windowElement[0].style.top = b + "px";
        if (this.align.toLowerCase() == "right") {
            this.windowElement[0].style.left = a + "px";
        } else {
            a = this.eventElement.offset().left - this.windowElement.width() - 5;
            this.windowElement[0].style.left = a + "px";
        }
        this.ie6FilterIFrame = Globals.addIE6Filter(this.windowElement.width(), this.windowElement.height(), a, b);
        this.windowElement.show();
        this.scrollToCenter(this.eventElement);
        this.eventElement.addClass("com_ErrorBox");
        if (this.eventElement.is("input")) {
            this.eventElement.select();
        }
    },
    scrollToCenter: function(b) {
        var c = Globals.getScrollPosition();
        var a = Globals.browserDimensions();
        if (b.offset().top < c.y) {
            window.scrollTo(c.x, b.offset().top - a.height / 2);
        }
    },
    dispose: function() {
        if (this.windowElement) {
            this.windowElement.hide();
            this.eventElement.removeClass("com_ErrorBox");
            FunctionExt.defer(function() {
                if (this.windowElement) {
                    Globals.closeIE6Fliter(this.ie6FilterIFrame);
                    this.windowElement.remove();
                    this.destroyEvent();
                    this.destroyDOM();
                }
            }.bind(this), 500);
        }
    }
});
function $error(b, c, a) {
    if (Object.isNull(this.tempErrorWindow) || Object.isNull(this.tempErrorWindow.windowElement)) {
        this.tempErrorWindow = new ErrorTipWindow({
            errorMsg: c,
            align: a,
            eventElement: b
        });
    } else {
        b.addClass("com_ErrorBox");
        b.one("click",
        function(d) {
            FunctionExt.defer(function() {
                if (Object.isNull(c)) {
                    return;
                }
                if (Object.isNull(this.tempErrorWindow) || Object.isNull(this.tempErrorWindow.windowElement)) {
                    this.tempErrorWindow = new ErrorTipWindow({
                        errorMsg: c,
                        align: a,
                        eventElement: b
                    });
                }
            }.bind(this), 600);
        }.bind(this));
    }
}
var CityPad = Elong.Control.CityPad;
CityPad = Class.create();
Object.extend(CityPad.prototype, {
    name: "CityPad",
    timeout: null,
    errtimeout: null,
    selectCity: null,
    KeyCode: {
        Left: 37,
        Up: 38,
        Right: 39,
        Down: 40,
        Del: 46,
        Tab: 9,
        Return: 13,
        Esc: 27,
        Command: 188,
        PageUp: 33,
        PageDown: 34,
        BackSpace: 8,
        Tab: 9
    },
    m_Container: new Template('<div style="width:#{HotWidth}px;display:block " class="com_hotresults"><div style="width:100%;"><div class="ac_title">#{HotTitle}</div><ul method="hotTab" class="AbcSearch clx">#{HotTab}</ul><ul method="hotData" class="popcitylist#{Language}" style="overflow: auto; max-height: 260px;">#{HotData}</ul></div><div class="clear"></div><div class="com_cbox_b com_cbox_lt"></div><div class="com_cbox_b com_cbox_rt"></div><div class="com_cbox_b com_cbox_lb"></div><div class="com_cbox_b com_cbox_rb"></div><div class="clear"></div></div>'),
    m_Result: new Template('<div style="width: 230px;position:relative;" class="com_results"><div style="width: 100%;"><div class="ac_title">#{ResultTitleHtml}</div><ul method="cityData" style="overflow: auto; max-height: 260px;">#{ResultDataHtml}</ul></div><div class="clear"></div><div class="com_cbox_b com_cbox_lt"></div><div class="com_cbox_b com_cbox_rt"></div><div class="com_cbox_b com_cbox_lb"></div><div class="com_cbox_b com_cbox_rb"></div><div class="clear"></div></div>'),
    m_ResultTitleCn: '<span class="l_black">{0}, 按照拼音排序 <a method="close" class="ac_close" href="#?" title="关闭"></a></span>',
    m_ResultTitleEn: '  <span class="l_black">{0}, sort by spelling <a method="close" class="ac_close" href="#?" title="close"></a></span>',
    m_TitleCn: '<span>拼音支持首字母输入, 或<span style="font-family: simsun;">&nbsp;←↑↓→&nbsp;</span>选择</span><a class="ac_close" href="#?" method="close"  title="关闭"></a>',
    m_TitleEn: '<span>Please enter or select from below</span><a class="ac_close" href="#?"   method="close" title="close"></a>',
    m_Error: new Template('<div class="com_error" style="width: 230px;position:relative;"><div style="width:100%;"><ul><li>#{Error}</li></ul></div><div class="clear"></div><div class="com_cbox_b com_cbox_lt"></div><div class="com_cbox_b com_cbox_rt"></div><div class="com_cbox_b com_cbox_lb"></div><div class="com_cbox_b com_cbox_rb"></div><div class="clear"></div></div>'),
    m_ErrorCn: '对不起，找不到<span class="ml5">{0}</span>',
    m_ErrorEn: "No matches!",
    options: {
        eventElement: null,
        lang: "cn",
        cityType: "",
        hotType: "",
        onSelect: null,
        onClose: null,
        hotWidth: 340,
        hotHeight: 138,
        hotData: null,
        cityData: null,
        colLen: 4,
        maxLen: 10,
        enableSearch: true,
        isJsonp: 0,
        resultNextId: "",
        searchField: "",
        searchType: "",
        searchUrl: "http://hotel.elong.com/city/"
    },
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        this.prepareData();
        if (this.lang == "en" && this.hotWidth < 425) {
            this.hotWidth = 425;
        }
        this.eventElement.attr("datacheck", "");
        this.eventElement.unbind("click");
        this.eventElement.unbind("keyup");
        this.eventElement.unbind("keydown");
        this.eventElement.bind("click", this.onInputClick.bindAsEventListener(this));
        this.eventElement.bind("keyup", this.onInputKeyUp.bindAsEventListener(this));
        this.eventElement.bind("keydown", this.onInputKeyDown.bindAsEventListener(this));
    },
    getSelect: function() {
        return this.selectCity;
    },
    prepareData: function() {
        if (!String.isNullOrEmpty(this.cityType)) {
            if (this.eventElement != null) {
                var c = {
                    CityId: this.eventElement.attr("CityId"),
                    CityThreeSign: this.eventElement.attr("CityThreeSign"),
                    CityNameCn: (this.lang.toLowerCase() == "cn") ? this.eventElement.val() : this.eventElement.attr("CityName"),
                    CityNameEn: (this.lang.toLowerCase() == "en") ? this.eventElement.val() : this.eventElement.attr("CityName")
                };
                this.eventElement[0]["City"] = c;
            }
            var b = false,
            a = false;
            b = !((typeof CityHot) == "undefined");
            if (b) {
                var e = !String.isNullOrEmpty(this.hotType) ? this.hotType: this.cityType;
                for (var d = 0; d < CityHot.length; d++) {
                    if (CityHot[d].CityType == e) {
                        this.hotData = CityHot[d].TabList;
                    }
                }
            }
        }
    },
    destroyDOM: function() {
        this.windowElement = null;
        this.contentEndRegion = null;
        this.options = null;
    },
    initializeEvent: function() {
        if (this.windowElement) {
            this.windowElement.bind("click", this.onClickRegion.bindAsEventListener(this));
            this.windowElement.bind("mouseout", this.onMouseOutRegion.bindAsEventListener(this));
            this.windowElement.bind("mouseover", this.onMouseOverRegion.bindAsEventListener(this));
            FunctionExt.defer(this.onOutClick.bindAsEventListener(this), 100);
        }
    },
    destroyEvent: function() {
        this.windowElement.unbind("click");
        this.windowElement.unbind("mouseout");
        this.windowElement.unbind("mouseover");
    },
    buildHotDataHtml: function(a, d) {
        if (this.ie6FilterIFrame != null) {
            Globals.closeIE6Fliter(this.ie6FilterIFrame);
        }
        if (this.hotData.length > 0) {
            var b = new StringBuilder();
            for (var c = 0; c < this.hotData[d].CityList.length; c++) {
                var e = (c % 2 == 0) ? "ac_even": "ac_odd";
                var f = this.lang.toLowerCase() == "cn" ? decodeURIComponent(this.hotData[d].CityList[c].CityNameCn) : this.hotData[d].CityList[c].CityNameEn;
                b.append('<li method="liHotData" data="' + d + "|" + c + '"  title="' + f + '" class="' + e + " " + (c == 0 ? "ac_over": "") + '">' + f + "</li>");
            }
            a.html(b.toString());
            FunctionExt.defer(this.onOutClick.bindAsEventListener(this), 100);
        }
    },
    buildHtml: function(keyword) {
        var temp = encodeURIComponent(keyword.replace(/[\s,\']+/g, "").toLowerCase());
        var url = this.searchUrl;
        if (this.isJsonp == 0) {
            var appPath = "";
            var host = window.location.host;
            if (host.toLowerCase().indexOf("travel.elong") > -1 || host.toLowerCase().indexOf("elong") < 0) {
                var path = window.location.pathname;
                var pathtemp = path.split("/");
                if (pathtemp.length > 1) {
                    appPath = "/" + pathtemp[1];
                }
            }
            url = appPath + "/city/" + this.cityType + "/" + this.maxLen + ".html";
        } else {
            if (this.isJsonp == 99) {
                url = "http://h.elong.com/city/" + this.cityType + "/" + this.maxLen + ".html";
            } else {
                url += this.cityType + "/" + this.maxLen + ".html";
            }
        }
        elongAjax.callBack(url, {
            keyword: temp
        },
        function(data) {
            this.eventElement.attr("CityId", "");
            this.eventElement.attr("CityThreeSign", "");
            var m_Title = this.lang.toLowerCase() == "cn" ? String.format(this.m_ResultTitleCn, keyword) : String.format(this.m_ResultTitleEn, keyword);
            this.contentEndRegion = $("#m_contentend");
            this.contentEndRegion.html("");
            this.windowElement = $('<div  style="display:none; position: absolute; z-index: 2000;"></div>').appendTo(this.contentEndRegion);
            this.cityData = data || [];
            this.selectCity = this.cityData[0];
            this.eventElement[0]["City"] = this.cityData[0];
            this.windowElement.html(this.m_Result.eval({
                ResultTitleHtml: m_Title,
                ResultDataHtml: ""
            }));
            if (this.ie6FilterIFrame != null) {
                Globals.closeIE6Fliter(this.ie6FilterIFrame);
            }
            var ulCity = this.windowElement.find("ul[method='cityData']");
            for (var i = 0; i < this.cityData.length; i++) {
                var m_CityData = this.lang.toLowerCase() == "cn" ? decodeURIComponent(this.cityData[i].CityNameCn) : this.cityData[i].CityNameEn;
                var liclass = (i % 2 == 0) ? "ac_even": "ac_odd";
                var tempHtml = "";
                if (String.isNullOrEmpty(this.searchField) && this.searchType != this.cityData[i].CityType) {
                    tempHtml = '<li method="liData" data="' + i + '" title="' + m_CityData + '" ><span method="spanData">' + this.cityData[i].CityNameEn + "</span>" + (this.lang.toLowerCase() == "cn" ? m_CityData: "") + "</li>";
                } else {
                    if (this.searchType == this.cityData[i].CityType) {
                        tempHtml = '<li method="liData" data="' + i + '" title="' + m_CityData + '" ><span method="spanData">' + this.cityData[i][this.searchField].replace(/_/g, ",") + "</span>" + (this.lang.toLowerCase() == "cn" ? m_CityData: "") + "</li>";
                    } else {
                        tempHtml = '<li method="liData" data="' + i + '" title="' + m_CityData + '" ><span method="spanData">' + this.cityData[i].CityNameEn + "</span>" + (this.lang.toLowerCase() == "cn" ? m_CityData: "") + "</li>";
                    }
                }
                $(tempHtml).appendTo(ulCity);
            }
            if (this.cityData.length > 0) {
                this.windowElement.find("ul[method='cityData'] li:first").addClass("ac_over");
            } else {
                var m_ErrorTitle = this.lang.toLowerCase() == "cn" ? String.format(this.m_ErrorCn, keyword) : String.format(this.m_ErrorEn, keyword);
                this.windowElement.html(this.m_Error.eval({
                    Error: m_ErrorTitle
                }));
            }
            this.windowElement.attr("winstyle", "data");
            this.initializeEvent();
            this.render();
        }.bind(this), true, "GET", false, "jsonp");
    },
    buildHotHtml: function() {
        this.reloadData();
        var m_Title = this.lang.toLowerCase() == "cn" ? this.m_TitleCn: this.m_TitleEn;
        if (this.windowElement) {
            this.windowElement.remove();
        }
        this.contentEndRegion = $("#m_contentend");
        this.windowElement = $('<div style="display:none; position: absolute; z-index: 2000;"></div>').appendTo(this.contentEndRegion);
        var hotTabSb = new StringBuilder();
        var hotDataSb = new StringBuilder();
        var defaultTab = 0,
        defaultIndex = 0;
        if (!String.isNullOrEmpty(this.eventElement.attr("datacheck"))) {
            var pos = this.eventElement.attr("datacheck").split("|");
            if (pos.length == 2) {
                defaultTab = pos[0];
                defaultIndex = pos[1];
            } else {
                for (var i = 0; i < this.hotData.length; i++) {
                    for (var j = 0; j < this.hotData[i].CityList.length; j++) {
                        if (this.hotData[i].CityList[j].CityId == this.cityData[pos[0]].CityId) {
                            defaultTab = i;
                            defaultIndex = j;
                            break;
                        }
                    }
                }
            }
        }
        if (this.hotData != null) {
            for (var i = 0; i < this.hotData.length; i++) {
                var m_hotTab = this.lang.toLowerCase() == "cn" ? decodeURIComponent(this.hotData[i].Name) : this.hotData[i].NameEn;
                hotTabSb.append('<li method="liHotTab" index="' + i + '" ' + (i == defaultTab ? 'class="action"': "") + ">" + m_hotTab + "</li>");
            }
            for (var j = 0; j < this.hotData[defaultTab].CityList.length; j++) {
                var m_CityData = this.lang.toLowerCase() == "cn" ? decodeURIComponent(this.hotData[defaultTab].CityList[j].CityNameCn) : this.hotData[defaultTab].CityList[j].CityNameEn;
                var liclass = (j % 2 == 0) ? "ac_even": "ac_odd";
                hotDataSb.append('<li method="liHotData" data="' + defaultTab + "|" + j + '" title="' + m_CityData + '" class="' + liclass + (j == defaultIndex ? " ac_over": "") + '">' + m_CityData + "</li>");
            }
            this.windowElement.html(this.m_Container.eval({
                Language: (this.lang.toLowerCase() == "cn") ? "": "_en",
                HotTitle: m_Title,
                HotTab: hotTabSb.toString(),
                HotData: hotDataSb.toString(),
                HotWidth: this.hotWidth
            }));
        }
        this.windowElement.attr("winstyle", "hot");
    },
    reloadData: function() {
        if (this.windowElement) {
            this.windowElement.remove();
            if (this.ie6FilterIFrame != null) {
                Globals.closeIE6Fliter(this.ie6FilterIFrame);
            }
        }
        if (!String.isNullOrEmpty(this.cityType)) {
            var b = false,
            a = false;
            b = !((typeof CityHot) == "undefined");
            if (b) {
                var c = String.isNullOrEmpty(this.hotType) ? this.cityType: this.hotType;
                for (var d = 0; d < CityHot.length; d++) {
                    if (CityHot[d].CityType == c) {
                        this.hotData = CityHot[d].TabList;
                    }
                }
            }
        }
    },
    onInputClick: function(a) {
        if (!Object.isNull(this.hotData) && this.windowElement == null) {
            this.buildHotHtml();
            this.initializeEvent();
            this.render();
            this.eventElement.select();
        }
    },
    onInputKeyUp: function(b) {
        if (!this.enableSearch) {
            return;
        }
        var a = Event.element(b);
        if (this.windowElement && this.windowElement.attr("winstyle") == "data") {
            var d = this.windowElement.find("ul[method='cityData']");
            var c = this.windowElement.find("ul[method='cityData'] li[class*='ac_over']");
            switch (b.keyCode) {
            case this.KeyCode.Up:
                c.removeClass("ac_over");
                if (c.prev("li").length > 0) {
                    c.prev("li").addClass("ac_over");
                } else {
                    this.windowElement.find("ul[method='cityData'] li:last").addClass("ac_over");
                }
                d.scrollTop((c.offset().top - d.offset().top) < d.height() - 30 && (c.offset().top - d.offset().top) > 0 ? (c.offset().top - d.offset().top) : c.offset().top);
                break;
            case this.KeyCode.Down:
                c.removeClass("ac_over");
                if (c.next("li").length > 0) {
                    c.next("li").addClass("ac_over");
                } else {
                    this.windowElement.find("ul[method='cityData'] li:first").addClass("ac_over");
                }
                d.scrollTop((c.offset().top - d.offset().top) > d.height() - 30 ? 0 : (c.offset().top - d.offset().top));
                break;
            case this.KeyCode.Return:
                var c = this.windowElement.find("ul[method='cityData'] li[class*='ac_over']");
                this.selectData(c);
                return;
            default:
                clearTimeout(this.timeout);
                this.timeout = setTimeout(function() {
                    this.reBuildData(a);
                }.bind(this), this.delay);
            }
        } else {
            switch (b.keyCode) {
            case this.KeyCode.Up:
            case this.KeyCode.Down:
            case this.KeyCode.Left:
            case this.KeyCode.Right:
            case this.KeyCode.Return:
                break;
            default:
                clearTimeout(this.timeout);
                this.timeout = setTimeout(function() {
                    this.reBuildData(a);
                }.bind(this), this.delay);
            }
        }
        b.stopPropagation();
    },
    reBuildData: function(b) {
        var a = b;
        if (!String.isNullOrEmpty(this.cityType)) {
            if (String.isNullOrEmpty(a.val())) {
                this.buildHotHtml();
                this.initializeEvent();
                this.render();
            } else {
                this.buildHtml(a.val());
            }
        }
    },
    onInputKeyDown: function(a) {
        if (this.windowElement && this.windowElement.attr("winstyle") == "hot") {
            var e = this.windowElement.find("ul[method='hotData'] li[class*='ac_over']");
            var f = this.colLen - 1;
            switch (a.keyCode) {
            case this.KeyCode.Right:
                e.removeClass("ac_over");
                if (e.next("li").length > 0) {
                    e.next("li").addClass("ac_over");
                } else {
                    this.windowElement.find("ul[method='hotData'] li:first").addClass("ac_over");
                }
                break;
            case this.KeyCode.Left:
                e.removeClass("ac_over");
                if (e.prev("li").length > 0) {
                    e.prev("li").addClass("ac_over");
                } else {
                    this.windowElement.find("ul[method='hotData'] li:last").addClass("ac_over");
                }
                break;
            case this.KeyCode.Down:
                var c = e.nextAll(":eq(" + f + ")");
                if (c.length == 0) {
                    var b = e.prevAll("li").length % this.colLen;
                    c = this.windowElement.find("ul[method='hotData'] li:eq(" + b + ")");
                }
                c.addClass("ac_over");
                e.removeClass("ac_over");
                break;
            case this.KeyCode.Up:
                var d = e.prevAll(":eq(" + f + ")");
                if (d.length == 0) {
                    var b = e.prevAll("li").length + Math.floor(this.windowElement.find("ul[method='hotData'] li").length / this.colLen) * this.colLen;
                    d = this.windowElement.find("ul[method='hotData'] li:eq(" + b + ")");
                }
                d.addClass("ac_over");
                e.removeClass("ac_over");
                break;
            case this.KeyCode.Return:
                var e = this.windowElement.find("ul[method='hotData'] li[class*='ac_over']");
                this.selectData(e);
                return;
            default:
                break;
            }
            this.eventElement.focus();
        }
        a.stopPropagation();
    },
    onOutClick: function() {
        $(document).one("click",
        function(b) {
            var a = Event.element(b);
            if (this.windowElement != null && this.windowElement.find("*").index(a) == -1 && this.eventElement[0] != a[0] && (a.attr("method") != "liHotTab")) {
                this.dispose();
            }
        }.bindAsEventListener(this));
    },
    selectData: function(a) {
        if (!String.isNullOrEmpty(a.attr("data"))) {
            var d;
            if (this.windowElement.attr("winstyle") == "hot") {
                var c = a.attr("data").split("|");
                var b = this.lang.toLowerCase() == "cn" ? decodeURIComponent(this.hotData[c[0]].CityList[c[1]].CityNameCn) : this.hotData[c[0]].CityList[c[1]].CityNameEn;
                this.eventElement.val(b);
                this.eventElement.attr("datacheck", a.attr("data"));
                d = this.hotData[c[0]].CityList[c[1]];
            } else {
                var c = a.attr("data");
                var b = this.lang.toLowerCase() == "cn" ? decodeURIComponent(this.cityData[c].CityNameCn) : this.cityData[c].CityNameEn;
                this.eventElement.val(b);
                this.eventElement.attr("datacheck", c);
                d = this.cityData[c];
            }
            this.selectCity = d;
            this.eventElement[0]["City"] = d;
            this.eventElement.attr("CityId", d.CityId);
            this.eventElement.attr("CityThreeSign", d.CityThreeSign);
            if (this.onSelect) {
                this.onSelect(this.eventElement, d);
            }
            if (!String.isNullOrEmpty(this.resultNextId)) {
                $("#" + this.resultNextId).focus();
            }
            this.dispose();
        }
    },
    onClickRegion: function(b) {
        var a = Event.element(b);
        var c = a.attr("method");
        switch (c) {
        case "liHotTab":
            this.windowElement.find("ul[method='hotTab'] li").removeClass("action");
            a.addClass("action");
            this.buildHotDataHtml(this.windowElement.find("ul[method='hotData']"), a.attr("index"));
            this.render();
            this.eventElement.focus();
            return;
        case "liHotData":
            this.selectData(a);
            return;
        case "liData":
        case "spanData":
            this.selectData((c == "liData") ? a: a.parent());
            return;
        case "close":
            this.dispose();
            return;
        default:
            this.dispose();
            return;
        }
    },
    onMouseOverRegion: function(b) {
        var a = Event.element(b);
        if (this.outTimer != null) {
            clearTimeout(this.outTimer);
            this.outTimer = null;
        }
        if (a.is("li") || a.parent().is("li")) {
            var c = a.is("li") ? a: a.parent();
            c.addClass("ac_over");
        }
    },
    onMouseOutRegion: function(b) {
        var a = Event.element(b);
        var d = a.attr("method");
        if (a.is("li") || a.parent().is("li")) {
            var c = a.is("li") ? a: a.parent();
            c.removeClass("ac_over");
        }
    },
    render: function() {
        if (this.windowElement) {
            var d = this.eventElement.offset().top + this.eventElement.height() + 6;
            var b = this.eventElement.offset().left;
            var c = Globals.getScrollPosition();
            var a = Globals.browserDimensions();
            if (a.width - (this.eventElement.offset().left - c.x) > this.windowElement.width()) {
                this.windowElement[0].style.top = d + "px";
                this.windowElement[0].style.left = b + "px";
            } else {
                this.windowElement[0].style.top = d + "px";
                b = b - this.windowElement.width() + this.eventElement.width();
                this.windowElement[0].style.left = b + "px";
            }
            this.ie6FilterIFrame = Globals.addIE6Filter(this.windowElement.width(), this.windowElement.height(), b, d, 1999);
            this.windowElement.show();
        }
    },
    dispose: function() {
        if (this.windowElement) {
            this.windowElement.hide();
            FunctionExt.defer(function() {
                if (this.windowElement) {
                    Globals.closeIE6Fliter(this.ie6FilterIFrame);
                    if (this.windowElement.attr("winstyle") == "data") {
                        if (this.onClose != null) {
                            this.onClose(this.eventElement, this.windowElement);
                        }
                    }
                    this.windowElement.remove();
                    this.destroyEvent();
                    this.destroyDOM();
                }
            }.bind(this), 500);
        }
    }
});
var CityWindow = Elong.Control.CityWindow;
CityWindow = Class.create();
Object.extend(CityWindow.prototype, {
    name: "CityWindow",
    city: null,
    options: {
        eventElement: null,
        lang: "cn",
        resultNextId: "",
        cityType: "",
        hotType: "",
        onSelect: null,
        onClose: null,
        hotWidth: 340,
        hotHeight: 138,
        delay: 50,
        maxLen: 10,
        enableSearch: true,
        isJsonp: 0,
        searchField: "",
        searchType: "",
        searchUrl: "http://hotel.elong.com/city/"
    },
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        this.city = new CityPad(a);
    },
    getSelect: function() {
        return this.city.getSelect();
    }
});
var CalendarHelper = Elong.Control.CanlendarHelper;
CalendarHelper = Class.create();
Object.extend(CalendarHelper.prototype, {
    FestivalDate: {
        yd: "2012-01-01",
        cx: "2012-01-22",
        cj: "2012-01-22",
        yx: "2012-02-06",
        qm: "2012-04-04",
        wy: "2012-05-01",
        dw: "2012-06-23",
        zq: "2011-09-12",
        gq: "2011-10-01"
    },
    TodayClassName: {
        jt: "jt",
        mt: "mt",
        ht: "ht"
    },
    WeekClassName: new Array("Sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "Saturday"),
    initialize: function(a) {},
    getDayCount: function(d, c) {
        var a = 0;
        var b = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if (c == 0) {
            a = 31;
        } else {
            if (c == 2) {
                if ((d % 400 == 0) || (d % 4 == 0 && d % 100 > 0)) {
                    a = 29;
                } else {
                    a = 28;
                }
            } else {
                a = b[c - 1];
            }
        }
        return a;
    },
    validateDateRange: function(c, b, a) {
        if (Object.isNull(b)) {
            b = "0001-01-01";
        }
        if (Object.isNull(a)) {
            a = "9999-12-31";
        }
        return this.reFormatDateString(c) >= this.reFormatDateString(b) && this.reFormatDateString(c) <= this.reFormatDateString(a);
    },
    reFormatDateString: function(b, d) {
        var a = new Array(3);
        var f, e, c;
        if (b.length == 0) {
            return "";
        }
        if (b.indexOf("-") > -1) {
            a = b.split("-");
            if (a.length != 3) {
                return "";
            }
            f = a[0];
            e = a[1];
            c = a[2];
        } else {
            a = b.split("/");
            if (a.length != 3) {
                return "";
            }
            f = a[2];
            e = a[0];
            c = a[1];
        }
        if (f.length <= 2) {
            f = "19" + f;
        }
        if (e.length == 1) {
            e = "0" + e;
        }
        if (c.length == 1) {
            c = "0" + c;
        }
        return Object.isNull(d) || d ? f + "-" + e + "-" + c: e + "/" + c + "/" + f;
    },
    getTodayString: function() {
        var a = new Date();
        return this.getDateString(a);
    },
    getDateString: function(a) {
        var d = a.getMonth() + 1;
        var b = a.getDate();
        var e = d > 9 ? d.toString() : "0" + d.toString();
        var c = b > 9 ? b.toString() : "0" + b.toString();
        var f = a.getFullYear().toString() + "-" + e + "-" + c;
        return f;
    },
    validateDate: function(g) {
        var c = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        var b = new Array(3);
        var h, d, a;
        var e = true;
        var f = g;
        if (f.length != 0) {
            b = f.split("-");
            if (b.length != 3 || b[1].length > 2 || b[2].length > 2 || b[1].length < 1 || b[2].length < 1) {
                e = false;
            }
            h = parseInt(b[0], 10);
            d = parseInt(b[1], 10);
            a = parseInt(b[2], 10);
            if (isNaN(h) || isNaN(d) || isNaN(a)) {
                e = false;
            }
            if (h < 1900 || h > 2100) {
                e = false;
            }
            if (((h % 4 == 0) && (h % 100 != 0)) || (h % 400 == 0)) {
                c[1] = 29;
            }
            if (d < 1 || d > 12 || a < 1 || a > c[d - 1]) {
                e = false;
            }
        }
        return e;
    },
    getFestivalClassName: function(b) {
        var a = "";
        for (var c in this.FestivalDate) {
            if (b == this.FestivalDate[c]) {
                a = c;
            }
        }
        return a;
    },
    addElementClass: function(g, b) {
        var a = "";
        for (var j in this.FestivalDate) {
            if (this.FestivalDate[j] == b) {
                a = j;
            }
        }
        if (a == "") {
            var c = new Date();
            var d = new Date();
            var e = new Date();
            d.setFullYear(c.getFullYear(), c.getMonth(), c.getDate() + 1);
            e.setFullYear(c.getFullYear(), c.getMonth(), c.getDate() + 1);
            switch (b) {
            case this.getDateString(c):
                a = this.TodayClassName.jt;
                break;
            case this.getDateString(d):
                a = this.TodayClassName.mt;
                break;
            case this.getDateString(e):
                a = this.TodayClassName.ht;
                break;
            }
        }
        if (a == "") {
            var f = validator.convertDate(b).getDay();
            a = this.WeekClassName[f];
        }
        var l = "";
        var k = g.attr("class");
        for (var j in this.FestivalDate) {
            if (k.indexOf(j) > -1) {
                l = j;
            }
        }
        for (var j in this.TodayClassName) {
            if (k.indexOf(j) > -1) {
                l = j;
            }
        }
        for (var h = 0; h < this.WeekClassName.length; h++) {
            if (k.indexOf(this.WeekClassName[h]) > -1) {
                l = this.WeekClassName[h];
            }
        }
        if (l != "") {
            k = k.replace(l, "");
        }
        g.attr("class", k + " " + a);
    }
});
var SingleCalendar = Elong.Control.SingleCalendar;
SingleCalendar = Class.create();
Object.extend(SingleCalendar.prototype, {
    popRegion: new Template('<div class="com_cbox com_select_YM"><div class="calendar_year" align="center"><div class="year"><a class="mf_lr_t cu_n" href="#?"  method="btnPre" title="上一月">&nbsp;</a></div>#{MonthSPAN}<div class="month_1"><a class="mf_rr_a" href="#?" method="btnNext" title="下一月">&nbsp;</a></div></div><div class="date_box">#{MonthHTML}</div><div class="clear"></div><div class="com_cbox_b com_cbox_lt"></div><div class="com_cbox_b com_cbox_rt"></div><div class="com_cbox_b com_cbox_lb"></div><div class="com_cbox_b com_cbox_rb"></div><div class="clear"></div></div>'),
    weakHTML_cn: '<tr class="family"><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th class="or">六</th><th class="or">日</th></tr>',
    weakHTML_en: '<tr class="family"><th class="or">S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th class="or">S</th></tr>',
    monthSPAN_cn: '<span><select method="selMonth"><option value="1">一月</option><option value="2">二月</option><option value="3">三月</option><option value="4">四月</option><option value="5">五月</option><option value="6">六月</option><option value="7">七月</option><option value="8">八月</option><option value="9">九月</option><option value="10">十月</option><option value="11">十一月</option><option value="12">十二月</option></select></span><span><select method="selYear"></select></span>',
    monthSPAN_en: '<span><select method="selMonth"><option value="1">Jan</option><option value="2">Feb</option><option value="3">Mar</option><option value="4">Apr</option><option value="5">May</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Aug</option><option value="9">Sep</option><option value="10">Oct</option><option value="11">Nov</option><option value="12">Dec</option></select></span><span><select method="selYear"></select></span>',
    options: {
        eventElement: null,
        selectedDate: null,
        language: "cn",
        enabledFrom: null,
        enabledTo: null,
        onSelected: null,
        winStyle: "s",
        windowElement: null,
        startMonth: 1,
        startYear: 1990,
        yearOrder: "a"
    },
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        this.weakHTML = this.language.toLowerCase() == "cn" ? this.weakHTML_cn: this.weakHTML_en;
        this.helper = new CalendarHelper();
    },
    refreshMonth: function(year, month) {
        var spanHTML = this.language.toLowerCase() == "cn" ? this.monthSPAN_cn: this.monthSPAN_en;
        var contentHTML = this.popRegion.eval({
            MonthSPAN: spanHTML,
            MonthHTML: this.getDateHTML(year, month)
        });
        this.windowElement.html(contentHTML);
        var selMonth = this.windowElement.find("select[method='selMonth']");
        var selYear = this.windowElement.find("select[method='selYear']");
        if (selMonth != null) {
            selMonth.val(month);
            selMonth.bind("change", this.onSelectChange.bindAsEventListener(this));
        }
        if (selYear != null) {
            var selBeginYear = this.startYear - 100;
            var selEndYear = parseInt(this.startYear) + 10;
            if (!Object.isNull(this.enabledFrom) && !String.isNullOrEmpty(this.enabledFrom)) {
                var enableFromDay = this.helper.reFormatDateString(this.enabledFrom, true);
                selBeginYear = parseInt(enableFromDay.substring(0, 4));
            }
            if (!Object.isNull(this.enabledTo) && !String.isNullOrEmpty(this.enabledTo)) {
                var enableToDay = this.helper.reFormatDateString(this.enabledTo, true);
                selEndYear = parseInt(enableToDay.substring(0, 4));
            }
            switch (this.yearOrder.toLowerCase()) {
            case "a":
                for (var i = selBeginYear; i <= selEndYear; i++) {
                    selYear.append('<option value="' + i + '">' + i + "</option>");
                }
                break;
            case "d":
                for (var i = selEndYear; i >= selBeginYear; i--) {
                    selYear.append('<option value="' + i + '">' + i + "</option>");
                }
                break;
            }
            selYear.val(year);
            selYear.bind("change", this.onSelectChange.bindAsEventListener(this));
        }
    },
    onSelectChange: function(a) {
        var b = this.windowElement.find("select[method='selMonth']");
        var c = this.windowElement.find("select[method='selYear']");
        this.refreshMonth(c.val(), b.val());
    },
    getDateHTML: function(w, v) {
        var s = '<td onmouseover="$(this).toggleClass(\'hover\')" onmouseout="$(this).toggleClass(\'hover\')" class="{1}">{0}</td>';
        var h = '<td class="Close">{0}</td>';
        var n = '<td onmouseover="$(this).toggleClass(\'hover\')" onmouseout="$(this).toggleClass(\'hover\')" class="{1}">{0}</td>';
        var f = new StringBuilder();
        f.append(String.format('<table date="{0}-{1}-" width="140" height="115" cellspacing="0" cellpadding="0">', w, v));
        f.append(this.weakHTML);
        var g = this.helper.getDayCount(w, v);
        var m = new Date(w, v - 1, 1);
        var a = m.getDay();
        var u = "";
        var t = 1;
        var c = g + a;
        if (this.language.toLowerCase() == "cn" && a == 0) {
            c = c + 7;
        }
        var q = 1;
        for (var o = 0; o < c; o++) {
            if (this.language.toLowerCase() == "cn") {
                if (o % 7 == 1) {
                    f.append("<tr>");
                }
            } else {
                if (o % 7 == 0) {
                    f.append("<tr>");
                }
            }
            if (this.isDisabledDay(w, v, q)) {
                u = h;
            } else {
                if ((this.language.toLowerCase() == "cn" && (o % 7 == 1 || (o + 1) % 7 == 1)) || (this.language.toLowerCase() == "en" && (o % 7 == 0 || (o + 1) % 7 == 0))) {
                    u = n;
                } else {
                    u = s;
                }
            }
            var b = "";
            var p = false;
            var e = this.helper.reFormatDateString(w + "-" + v + "-" + q);
            if (e == this.helper.reFormatDateString(this.selectedDate, true)) {
                b = "selected";
            }
            if (e == this.helper.getTodayString()) {
                b = "newdate";
            }
            if (o % 7 == 6 || o % 7 == 0) {
                b = "bold or";
            }
            if (this.language.toLowerCase() == "cn") {
                var l = this.helper.getFestivalClassName(e);
                if (l != "") {
                    b = l;
                    p = true;
                }
            }
            if (o < a || (this.language.toLowerCase() == "cn" && a == 0 && o < 7)) {
                f.append(String.format(u, "", ""));
            } else {
                if (this.language.toLowerCase() == "cn" && p && !this.isDisabledDay(w, v, q)) {
                    f.append(String.format(u, "&nbsp;", b));
                } else {
                    f.append(String.format(u, q, b));
                }
                q++;
            }
            if (this.language.toLowerCase() == "cn") {
                if (o % 7 == 0) {
                    f.append("</tr>");
                }
            } else {
                if (o % 7 == 6) {
                    f.append("</tr>");
                }
            }
        }
        var r = new Date(w, v - 1, g);
        var k = r.getDay();
        var d = 6 - k;
        for (var o = 0; o < d; o++) {
            if ((o + 1) % 7 != 0) {
                f.append(String.format(s, "", ""));
            } else {
                f.append(String.format(n, "", ""));
            }
        }
        f.append("</tr></table>");
        return f.toString();
    },
    isDisabledDay: function(d, c, b) {
        if (Object.isNull(this.enabledFrom)) {
            this.enabledFrom = this.helper.getTodayString();
        }
        var a = d + "-" + c + "-" + b;
        return ! this.helper.validateDateRange(a, this.enabledFrom, this.enabledTo);
    },
    onClickRegion: function(a) {
        var b = this.windowElement.find("select[method='selYear']").val();
        switch (a) {
        case "btnPre":
            if (this.startMonth == 1) {
                b--;
            }
            if (this.startMonth == 1) {
                this.startMonth += 12;
            }
            this.startMonth -= 1;
            this.refreshMonth(b, this.startMonth);
            break;
        case "btnNext":
            if (this.startMonth == 12) {
                b++;
            }
            if (this.startMonth == 12) {
                this.startMonth -= 12;
            }
            this.startMonth += 1;
            this.refreshMonth(b, this.startMonth);
            break;
        }
    }
});
var DoubleCalendar = Elong.Control.DoubleCalendar;
DoubleCalendar = Class.create();
Object.extend(DoubleCalendar.prototype, {
    popRegion: new Template('<div class="com_cbox" >  <div class="calendar_year"><div class="year"><a method="btnPre" href="#?" title="上一月" class="mf_lr_t cu_n">&nbsp;</a></div>#{MonthSPAN}	<div class="month_1"><a  method="btnNext" title="下一月" href="#?" class="mf_rr_a cu_n">&nbsp;</a></div></div>  <div class="date_box">	#{MonthHTML}	<div class="hr"></div>	#{nextMonthHTML}  </div>  <div class="clear"></div>  <div class="com_cbox_b com_cbox_lt"></div>  <div class="com_cbox_b com_cbox_rt"></div>  <div class="com_cbox_b com_cbox_lb"></div>  <div class="com_cbox_b com_cbox_rb"></div><div class="clear"></div></div>'),
    weakHTML_cn: '<tr class="family"><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th class="or">六</th><th class="or">日</th></tr>',
    weakHTML_en: '<tr class="family"><th class="or">S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th class="or">S</th></tr>',
    monthSPAN_cn: '<span class="h">{0}年{1}月</span><span class="m">{2}年{3}月</span>',
    monthSPAN_en: '<span class="h">{0}.{1}</span><span class="m">{2}.{3}</span>',
    options: {
        eventElement: null,
        selectedDate: null,
        language: "cn",
        enabledFrom: null,
        enabledTo: null,
        onSelected: null,
        winStyle: "d",
        windowElement: null,
        startMonth: 1,
        startYear: 1990,
        yearOrder: "a"
    },
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        this.weakHTML = this.language.toLowerCase() == "cn" ? this.weakHTML_cn: this.weakHTML_en;
        this.helper = new CalendarHelper();
    },
    refreshMonth: function(year, month) {
        var nextYear = month == 12 ? year + 1 : year;
        var nextMonth = month == 12 ? 1 : month + 1;
        var spanHTML = this.language.toLowerCase() == "cn" ? this.monthSPAN_cn: this.monthSPAN_en;
        spanHTML = String.format(spanHTML, year, month, nextYear, nextMonth);
        var contentHTML = this.popRegion.eval({
            MonthSPAN: spanHTML,
            MonthHTML: this.getDateHTML(year, month),
            nextMonthHTML: this.getDateHTML(nextYear, nextMonth)
        });
        this.windowElement.html(contentHTML);
    },
    getDateHTML: function(w, v) {
        var s = '<td onmouseover="$(this).toggleClass(\'hover\')" onmouseout="$(this).toggleClass(\'hover\')" class="{1}">{0}</td>';
        var h = '<td class="Close">{0}</td>';
        var n = '<td onmouseover="$(this).toggleClass(\'hover\')" onmouseout="$(this).toggleClass(\'hover\')" class="{1}">{0}</td>';
        var f = new StringBuilder();
        f.append(String.format('<table date="{0}-{1}-" width="180" height="115" cellspacing="0" cellpadding="0">', w, v));
        f.append(this.weakHTML);
        var g = this.helper.getDayCount(w, v);
        var m = new Date(w, v - 1, 1);
        var a = m.getDay();
        var u = "";
        var t = 1;
        var c = g + a;
        if (this.language.toLowerCase() == "cn" && a == 0) {
            c = c + 7;
        }
        var q = 1;
        for (var o = 0; o < c; o++) {
            if (this.language.toLowerCase() == "cn") {
                if (o % 7 == 1) {
                    f.append("<tr>");
                }
            } else {
                if (o % 7 == 0) {
                    f.append("<tr>");
                }
            }
            if (this.isDisabledDay(w, v, q)) {
                u = h;
            } else {
                if ((this.language.toLowerCase() == "cn" && (o % 7 == 1 || (o + 1) % 7 == 1)) || (this.language.toLowerCase() == "en" && (o % 7 == 0 || (o + 1) % 7 == 0))) {
                    u = n;
                } else {
                    u = s;
                }
            }
            var b = "";
            var p = false;
            var e = this.helper.reFormatDateString(w + "-" + v + "-" + q);
            if (e == this.selectedDate) {
                b = "selected";
            }
            if (e == this.helper.getTodayString()) {
                b = "newdate";
            }
            if (o % 7 == 6 || o % 7 == 0) {
                b = "bold or";
            }
            if (this.language.toLowerCase() == "cn") {
                var l = this.helper.getFestivalClassName(e);
                if (l != "") {
                    b = l;
                    p = true;
                }
            }
            if (o < a || (this.language.toLowerCase() == "cn" && a == 0 && o < 7)) {
                f.append(String.format(u, "", ""));
            } else {
                if (this.language.toLowerCase() == "cn" && p && !this.isDisabledDay(w, v, q)) {
                    f.append(String.format(u, "&nbsp;", b));
                } else {
                    f.append(String.format(u, q, b));
                }
                q++;
            }
            if (this.language.toLowerCase() == "cn") {
                if (o % 7 == 0) {
                    f.append("</tr>");
                }
            } else {
                if (o % 7 == 6) {
                    f.append("</tr>");
                }
            }
        }
        var r = new Date(w, v - 1, g);
        var k = r.getDay();
        var d = 6 - k;
        for (var o = 0; o < d; o++) {
            if ((o + 1) % 7 != 0) {
                f.append(String.format(s, "", ""));
            } else {
                f.append(String.format(n, "", ""));
            }
        }
        f.append("</tr></table>");
        return f.toString();
    },
    isDisabledDay: function(d, c, b) {
        if (Object.isNull(this.enabledFrom)) {
            this.enabledFrom = this.helper.getTodayString();
        }
        var a = d + "-" + c + "-" + b;
        return ! this.helper.validateDateRange(a, this.enabledFrom, this.enabledTo);
    },
    onClickRegion: function(a) {
        switch (a) {
        case "btnPre":
            if (this.startMonth < 3) {
                this.startYear--;
            }
            if (this.startMonth < 3) {
                this.startMonth += 12;
            }
            this.startMonth -= 2;
            this.refreshMonth(this.startYear, this.startMonth);
            return;
        case "btnNext":
            if (this.startMonth > 10) {
                this.startYear++;
            }
            if (this.startMonth > 10) {
                this.startMonth -= 12;
            }
            this.startMonth += 2;
            this.refreshMonth(this.startYear, this.startMonth);
            return;
        }
    }
});
var Calendar = Elong.Control.Calendar;
Calendar = Class.create();
Object.extend(Calendar.prototype, {
    options: {
        eventElement: null,
        selectedDate: null,
        language: "cn",
        enabledFrom: null,
        enabledTo: null,
        onSelected: null,
        winStyle: "d",
        windowElement: null,
        yearOrder: "a"
    },
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        switch (this.winStyle.toLowerCase()) {
        case "d":
            this.prototype = new DoubleCalendar(a);
            break;
        case "s":
            this.prototype = new SingleCalendar(a);
            break;
        default:
            this.prototype = new DoubleCalendar(a);
        }
    }
});
var CalendarWindow = Elong.Control.CalendarWindow;
CalendarWindow = Class.create();
Object.extend(CalendarWindow.prototype, {
    name: "CalendarWindow",
    options: {
        eventElement: null,
        selectedDate: null,
        language: "cn",
        enabledFrom: null,
        enabledTo: null,
        onSelected: null,
        winStyle: "d",
        yearOrder: "a"
    },
    initialize: function(b) {
        Object.extend(Object.extend(this, this.options), b);
        this.helper = new CalendarHelper();
        this.initializeDOM();
        this.initializeEvent();
        var a = new Date();
        if (Object.isNull(this.selectedDate) || String.isNullOrEmpty(this.selectedDate) || !this.helper.validateDate(this.helper.reFormatDateString(this.selectedDate, true))) {
            this.selectedDate = this.helper.getTodayString();
        } else {
            this.selectedDate = this.helper.reFormatDateString(this.selectedDate);
        }
        this.startYear = parseInt(this.selectedDate.split("-")[0], 10) || a.getFullYear();
        this.startMonth = parseInt(this.selectedDate.split("-")[1], 10) || a.getMonth() + 1;
        this.calendar = new Calendar($.extend(b, {
            windowElement: this.windowElement,
            startYear: this.startYear,
            startMonth: this.startMonth
        }));
        this.calendar.prototype.refreshMonth(this.startYear, this.startMonth);
        this.render();
    },
    initializeDOM: function() {
        this.contentEndRegion = $("#m_contentend");
        this.windowElement = $('<div style="display:none; position: absolute; z-index: 20000;"></div>').appendTo(this.contentEndRegion);
    },
    destroyDOM: function() {
        this.windowElement = null;
        this.contentEndRegion = null;
        this.options = null;
    },
    initializeEvent: function() {
        this.windowElement.bind("click", this.onClickRegion.bindAsEventListener(this));
        FunctionExt.defer(this.onOutClick.bindAsEventListener(this), 100);
    },
    destroyEvent: function() {
        this.windowElement.unbind("click");
    },
    onOutClick: function() {
        $(document).bind("click",
        function(b) {
            var a = Event.element(b);
            if (this.windowElement != null) {
                if (this.windowElement.find("*").index(a) == -1 && (a.attr("method") != "btnPre" && a.attr("method") != "selMonth" && a.attr("method") != "selYear" && a.attr("method") != "btnNext")) {
                    this.dispose();
                }
            }
        }.bindAsEventListener(this));
    },
    onClickRegion: function(c) {
        var b = Event.element(c);
        var f = b.attr("method");
        this.calendar.prototype.onClickRegion(f);
        if (b.is("td") && !b.hasClass("Close") && (parseInt(b.text(), 10) > 0 || b.attr("class") != "hover")) {
            if (!Object.isNull(this.onSelected)) {
                var a = b.parents("table").attr("date") + b.text();
                var d = false;
                for (var e in this.helper.FestivalDate) {
                    if (b.attr("class").substring(0, 2) == e) {
                        d = true;
                    }
                }
                if (d) {
                    a = this.helper.FestivalDate[b.attr("class").substring(0, 2)];
                }
                this.onSelected(this.helper.reFormatDateString(a, this.language.toLowerCase() == "cn"));
            }
            this.dispose();
        }
    },
    render: function() {
        var d = this.eventElement.offset().top + this.eventElement.height() + 6;
        var b = this.eventElement.offset().left;
        var c = Globals.getScrollPosition();
        var a = Globals.browserDimensions();
        if (a.width - (this.eventElement.offset().left - c.x) > this.windowElement.width()) {
            this.windowElement[0].style.top = d + "px";
            this.windowElement[0].style.left = b + "px";
        } else {
            this.windowElement[0].style.top = d + "px";
            b = b - this.windowElement.width() + this.eventElement.width();
            this.windowElement[0].style.left = b + "px";
        }
        this.ie6FilterIFrame = Globals.addIE6Filter(this.windowElement.width(), this.windowElement.height(), b, d, 1999);
        this.windowElement.show();
    },
    dispose: function() {
        if (this.windowElement) {
            this.windowElement.fadeOut("normal");
            FunctionExt.defer(function() {
                if (this.windowElement) {
                    Globals.closeIE6Fliter(this.ie6FilterIFrame);
                    this.windowElement.remove();
                    this.destroyEvent();
                    this.destroyDOM();
                }
            }.bind(this), 500);
        }
    }
});
var Dialog = Elong.Control.Dialog;
Dialog = Class.create();
Object.extend(Dialog.prototype, {
    name: "Dialog",
    windowTemplate: new Template('<div class="com_dialog com_widget com_widget-content com_corner-all com_draggable" style="#{width};#{height};">#{titleRegion}<div class="com_dialog-content com_widget-content">#{content}</div></div>'),
    titleTemplate: '<div class="com_dialog-titlebar com_widget-header com_corner-all com_helper-clearfix"><span class="com_dialog-title">{0}</span><a class="com_dialog-titlebar-close com_corner-all" href="#?" method="close">	<span class="com_icon com_icon-closethick">close</span></a></div>',
    options: {
        title: "对话框",
        htmlContent: "",
        initEvent: null,
        width: 380,
        height: 0,
        closeEvent: null
    },
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        this.initializeDOM();
        this.window = new LightBox(this.windowElement, this.overlayer);
        if ($.browser.msie && $.browser.version <= 6) {
            this.window.Fixed = false;
        }
        if (this.windowElement.find("div.com_dialog-titlebar:eq(0)").length > 0) {
            this.drag = new Drag(this.windowElement, this.windowElement.find("div.com_dialog-titlebar:eq(0)"));
        }
        this.overLay = this.window.OverLay;
        this.overLay.Color = "#cccccc";
        this.windowElement.find("[method='close']").bind("click",
        function(b) {
            this.close();
            if (this.closeEvent != null) {
                this.closeEvent(this.windowElement);
            }
        }.bindAsEventListener(this));
        this.initEvent(this.windowElement);
    },
    initializeDOM: function() {
        this.contentEndRegion = $("#m_contentend");
        var content = this.windowTemplate.eval({
            titleRegion: String.isNullOrEmpty(this.title) ? "<div></div>": String.format(this.titleTemplate, this.title),
            content: this.htmlContent,
            width: "width:" + this.width + "px",
            height: this.height > 0 ? "height:" + this.height + "px": ""
        });
        this.windowElement = $(content).appendTo(this.contentEndRegion);
        this.overlayer = $("<div></div>").appendTo(this.contentEndRegion);
    },
    destroyDOM: function() {
        this.htmlContent = "";
        this.windowElement.remove();
        this.overlayer.remove();
        this.windowElement = null;
        this.contentEndRegion = null;
    },
    show: function() {
        this.window.Show();
    },
    close: function() {
        this.window.Close();
        this.destroyDOM();
    }
});
var OverLay = Class.create();
OverLay.prototype = {
    initialize: function(b, a) {
        this.Lay = b.get(0);
        this._size = function() {};
        this.SetOptions(a);
        this.Color = this.options.Color;
        this.Opacity = parseInt(this.options.Opacity);
        this.zIndex = parseInt(this.options.zIndex);
        this.Set();
    },
    SetOptions: function(a) {
        this.options = {
            Color: "#fff",
            Opacity: 50,
            zIndex: 1000
        };
        Object.extend(this.options, a || {});
    },
    Set: function() {
        this.Lay.style.display = "none";
        this.Lay.style.zIndex = this.zIndex;
        this.Lay.style.left = this.Lay.style.top = 0;
        if (this.isIE6()) {
            this.Lay.style.position = "absolute";
            this._size = function() {
                this.Lay.style.width = Math.max(document.documentElement.scrollWidth, document.documentElement.clientWidth) + "px";
                this.Lay.style.height = Math.max(document.documentElement.scrollHeight, document.documentElement.clientHeight) + "px";
            }.bind(this);
            this.Lay.innerHTML = '<iframe style="position:absolute;top:0;left:0;width:100%;height:100%;filter:alpha(opacity=0);"></iframe>';
        } else {
            this.Lay.style.position = "fixed";
            this.Lay.style.width = this.Lay.style.height = "100%";
        }
    },
    Show: function() {
        this.Lay.style.backgroundColor = this.Color;
        if ($.browser.msie) {
            this.Lay.style.filter = "alpha(opacity:" + this.Opacity + ")";
        } else {
            this.Lay.style.opacity = this.Opacity / 100;
        }
        if (this.isIE6()) {
            this._size();
            window.attachEvent("onresize", this._size);
        }
        this.Lay.style.display = "block";
    },
    isIE6: function() {
        return $.browser.msie && $.browser.version == 6;
    },
    Close: function() {
        this.Lay.style.display = "none";
        if (this.isIE6()) {
            window.detachEvent("onresize", this._size);
        }
    }
};
var LightBox = Class.create();
LightBox.prototype = {
    initialize: function(a, c, b) {
        this.Box = a.get(0);
        this.OverLay = new OverLay(c, b);
        this.SetOptions(b);
        this.Fixed = !!this.options.Fixed;
        this.Over = !!this.options.Over;
        this.Center = !!this.options.Center;
        this.onShow = this.options.onShow;
        this.Box.style.zIndex = this.OverLay.zIndex + 1;
        this.Box.style.display = "none";
        if (this.isIE6()) {
            this._top = this._left = 0;
            this._select = [];
        }
    },
    SetOptions: function(a) {
        this.options = {
            Fixed: true,
            Over: true,
            Center: true,
            onShow: function() {}
        };
        Object.extend(this.options, a || {});
    },
    _fixed: function() {
        var b = document.documentElement.scrollTop - this._top + this.Box.offsetTop,
        a = document.documentElement.scrollLeft - this._left + this.Box.offsetLeft;
        if (this.Center) {
            b += this.Box.offsetHeight / 2;
            a += this.Box.offsetWidth / 2;
        }
        this.Box.style.top = b + "px";
        this.Box.style.left = a + "px";
        this._top = document.documentElement.scrollTop;
        this._left = document.documentElement.scrollLeft;
    },
    Show: function(c) {
        if (this.Fixed) {
            if (this.isIE6()) {
                this.Box.style.position = "absolute";
                this._top = document.documentElement.scrollTop;
                this._left = document.documentElement.scrollLeft;
                window.attachEvent("onscroll", this._fixed.bind(this));
            } else {
                this.Box.style.position = "fixed";
            }
        } else {
            this.Box.style.position = "absolute";
        }
        if (this.Over) {
            this.OverLay.Show();
        } else {
            if (this.isIE6()) {
                this._select = [];
                var d = this;
                Each(document.getElementsByTagName("select"),
                function(e) {
                    if (d.Box.contains ? !d.Box.contains(e) : !(d.Box.compareDocumentPosition(e) & 16)) {
                        e.style.visibility = "hidden";
                        d._select.push(e);
                    }
                });
            }
        }
        this.Box.style.display = "block";
        if (this.Center) {
            this.Box.style.top = this.Box.style.left = "50%";
            var b = -this.Box.offsetHeight / 2,
            a = -this.Box.offsetWidth / 2;
            if (!this.Fixed || this.isIE6()) {
                b += document.documentElement.scrollTop;
                a += document.documentElement.scrollLeft;
            }
            this.Box.style.marginTop = b + "px";
            this.Box.style.marginLeft = a + "px";
        }
        this.onShow();
    },
    isIE6: function() {
        return $.browser.msie && $.browser.version == 6;
    },
    Close: function() {
        this.Box.style.display = "none";
        this.OverLay.Close();
    }
};
function addEventHandler(b, c, a) {
    if (b.addEventListener) {
        b.addEventListener(c, a, false);
    } else {
        if (b.attachEvent) {
            b.attachEvent("on" + c, a);
        } else {
            b["on" + c] = a;
        }
    }
}
function removeEventHandler(b, c, a) {
    if (b.removeEventListener) {
        b.removeEventListener(c, a, false);
    } else {
        if (b.detachEvent) {
            b.detachEvent("on" + c, a);
        } else {
            b["on" + c] = null;
        }
    }
}
if (!$.browser.msie) {
    HTMLElement.prototype.__defineGetter__("currentStyle",
    function() {
        return this.ownerDocument.defaultView.getComputedStyle(this, null);
    });
}
var Drag = Class.create();
Drag.prototype = {
    initialize: function(b, a, c) {
        var d = this;
        this._obj = b.get(0);
        this.Drag = a.get(0);
        this._x = this._y = 0;
        this._fM = function(f) {
            d.Move(window.event || f);
        };
        this._fS = function() {
            d.Stop();
        };
        this.SetOptions(c);
        this.Limit = !!this.options.Limit;
        this.mxLeft = parseInt(this.options.mxLeft);
        this.mxRight = parseInt(this.options.mxRight);
        this.mxTop = parseInt(this.options.mxTop);
        this.mxBottom = parseInt(this.options.mxBottom);
        this.mxContainer = this.options.mxContainer;
        this.onMove = this.options.onMove;
        this.Lock = !!this.options.Lock;
        this._obj.style.position = "absolute";
        addEventHandler(this.Drag, "mousedown",
        function(f) {
            d.Start(window.event || f);
        });
    },
    SetOptions: function(a) {
        this.options = {
            Limit: true,
            mxLeft: 0,
            mxRight: 0,
            mxTop: 0,
            mxBottom: 0,
            mxContainer: document.documentElement,
            onMove: function() {},
            Lock: false
        };
        Object.extend(this.options, a || {});
    },
    Start: function(a) {
        if (this.Lock) {
            return;
        }
        this._x = a.clientX - this._obj.offsetLeft;
        this._y = a.clientY - this._obj.offsetTop;
        addEventHandler(document, "mousemove", this._fM);
        addEventHandler(document, "mouseup", this._fS);
        if ($.browser.msie) {
            addEventHandler(this.Drag, "losecapture", this._fS);
            this.Drag.setCapture();
        } else {
            addEventHandler(window, "blur", this._fS);
        }
    },
    Move: function(e) {
        if (this.Lock) {
            this.Stop();
            return;
        }
        window.getSelection && window.getSelection().removeAllRanges();
        var b = e.clientX - this._x,
        d = e.clientY - this._y;
        if (this.Limit) {
            if ( !! this.mxContainer) {
                this.mxLeft = this.mxTop = 0;
                this.mxRight = this.mxContainer.clientWidth;
                this.mxBottom = this.mxContainer.clientHeight;
            }
            var c = b + this._obj.offsetWidth - this.mxRight,
            a = d + this._obj.offsetHeight - this.mxBottom;
            if (c > 0) {
                b -= c;
            }
            if (a > 0) {
                d -= a;
            }
            if (this.mxLeft > b) {
                b = this.mxLeft;
            }
            if (this.mxTop > d) {
                d = this.mxTop;
            }
        }
        this._obj.style.left = b - (parseInt(this._obj.currentStyle.marginLeft) || 0) + "px";
        this._obj.style.top = d - (parseInt(this._obj.currentStyle.marginTop) || 0) + "px";
        this.onMove();
    },
    Stop: function() {
        removeEventHandler(document, "mousemove", this._fM);
        removeEventHandler(document, "mouseup", this._fS);
        if ($.browser.msie) {
            removeEventHandler(this.Drag, "losecapture", this._fS);
            this.Drag.releaseCapture();
        } else {
            removeEventHandler(window, "blur", this._fS);
        }
    }
};
var SelectDropListWindow = Elong.Control.SelectDropListWindow;
SelectDropListWindow = Class.create();
Object.extend(SelectDropListWindow.prototype, {
    name: "SelectDropListWindow",
    popRegion: '<div class="com_cbox_p" style="display:none; position: absolute; z-index: 10;"><ul></ul><div class="com_cbox_b com_cbox_lt"></div><div class="com_cbox_b com_cbox_rt"></div><div class="com_cbox_b com_cbox_lb"></div><div class="com_cbox_b com_cbox_rb"></div><div class="clear"></div></div>',
    listTemplate: new Template('<li class="li_q" method="select" value="#{Value}">#{Name}</li>'),
    options: {
        eventElement: null,
        data: null,
        onSelected: null,
        fieldName: "Name",
        singleColumn: false
    },
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        if (Object.isNull(this.data) || this.data.length == 0) {
            return;
        }
        this.initializeDOM();
        this.initializeEvent();
        this.render();
    },
    initializeDOM: function() {
        this.contentEndRegion = $("#m_contentend");
        this.windowElement = $(this.popRegion).appendTo(this.contentEndRegion);
        if (this.singleColumn) {
            this.windowElement.addClass("com_cbox_p1");
        }
    },
    destroyDOM: function() {
        this.data = null;
        this.windowElement = null;
        this.contentEndRegion = null;
    },
    initializeEvent: function() {
        this.windowElement.bind("click", this.onClickRegion.bindAsEventListener(this));
        this.windowElement.bind("mouseout", this.onMouseOutRegion.bindAsEventListener(this));
        this.windowElement.bind("mouseover", this.onMouseOverRegion.bindAsEventListener(this));
        FunctionExt.defer(this.onOutClick.bindAsEventListener(this), 100);
    },
    destroyEvent: function() {
        this.windowElement.unbind("click");
        $(document).unbind("click", this.onOutClickHandler);
        this.windowElement.unbind("mouseout");
        this.windowElement.unbind("mouseover");
    },
    onOutClick: function() {
        this.onOutClickHandler = function(b) {
            var a = Event.element(b);
            if (this.windowElement.find(":descendant").index(a) == -1) {
                this.dispose();
            }
        }.bindAsEventListener(this);
        $(document).one("click", this.onOutClickHandler);
    },
    onClickRegion: function(b) {
        var a = Event.element(b);
        var c = a.attr("method");
        switch (c) {
        case "select":
            if (!Object.isNull(this.onSelected)) {
                this.onSelected(a.attr("value"));
            }
            this.dispose();
            break;
        case "close":
            this.dispose();
            break;
        }
    },
    onMouseOverRegion: function(b) {
        var a = Event.element(b);
        if (this.outTimer != null) {
            clearTimeout(this.outTimer);
            this.outTimer = null;
        }
        if (a.is("li") && !a.hasClass("hr_w")) {
            a.addClass("li_cur");
        }
    },
    onMouseOutRegion: function(b) {
        var a = Event.element(b);
        this.outTimer = FunctionExt.defer(function() {
            this.dispose();
        },
        0.01, this);
        if (a.is("li")) {
            a.removeClass("li_cur");
        }
    },
    render: function() {
        var region = this.windowElement.find("ul");
        var sb = new StringBuilder();
        for (var i = 0; i < this.data.length; i++) {
            if (Object.isNull(this.data[i])) {
                continue;
            }
            sb.append(this.listTemplate.eval({
                Name: this.data[i][this.fieldName],
                Value: i
            }));
            if (!this.singleColumn && i % 3 == 2 && i != this.data.length - 1) {
                sb.append('<li class="clear hr_w"></li>');
            }
        }
        region.html(sb.toString());
        var top = this.eventElement.offset().top + this.eventElement.height() + 6;
        var left = this.eventElement.offset().left;
        this.windowElement[0].style.top = top + "px";
        this.windowElement[0].style.left = left + "px";
        this.ie6FilterIFrame = Globals.addIE6Filter(this.windowElement.width(), this.windowElement.height(), left, top);
        this.windowElement.show();
    },
    dispose: function() {
        if (this.windowElement) {
            this.windowElement.fadeOut("normal");
            FunctionExt.defer(function() {
                if (this.windowElement) {
                    Globals.closeIE6Fliter(this.ie6FilterIFrame);
                    this.windowElement.remove();
                    this.destroyEvent();
                    this.destroyDOM();
                }
            }.bind(this), 500);
        }
    }
});