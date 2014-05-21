var HotelListClient = Elong.Page.HotelListClient;
HotelListClient = Class.create();
Object.extend(HotelListClient.prototype, {
    name: "HotelListClient",
    initialize: function() {
        this.initializeDOM();
        this.initializeEvent();
        this.SearchRequestInfo = HotelListNewController.SearchRequestInfo;
        this.HotelRoomInfo = HotelListNewController.HotelRoomInfo != null ? 
        			HotelListNewController.HotelRoomInfo.HotelRoom: null;
        this.res = HotelListNewController.Resources;
        this.Language = HotelListNewController.Language;
        this.downloadRoomComplete = this.HotelRoomInfo != null;
        this.priceTemplate = new Template("<table cellspacing='0' cellpadding='0' border='0' 
        		class='sf_average'><thead><tr> <th>&nbsp;</th>#{Title}</tr></thead><tbody><tr>#{List}
        		</tr></tbody></table>");
        this.ruleTemplate = new Template("<div class='sf_voucher'>#{Rule}</div>");
        var a = "tt";
        this.flashTemplate = new Template("<embed height='400' width='705' base='.' menu='false' 
        		flashvars='source=h" + a + "p://data.elong.com/hotels/VirtualTour/#{hotelID}_#{lang}.xml?rad=#
        		{rad}' wmode='Window' quality='High' name='VT360' id='VT360' pluginspage='h" + a + 
        		"p://www.macromedia.com/go/getflashplayer' src='h" + a + 
        		"p://www.elong.com/hotels/Images/cmpdmdaplyr.swf?rad=#{rad}' type='application/x-shockwave-
        		flash'/>");
        this.HotelListUrl = new Template(HotelListNewController.UrlConfig.HotelListUrl);
        this.popupMapUrl = new Template(HotelListNewController.UrlConfig.PopupMapUrl);
        this.detailUrl = new Template(HotelListNewController.UrlConfig.Hotel_Detail);
        this.detailCommentUrl = new Template(HotelListNewController.UrlConfig.Hotel_DetailComment);
        this.render();
        this.HotSuggestAllWindowClient = null;
        this.GlobalData = {
            Type: "",
            Name: "",
            PropertiesId: 0,
            Lat: 0,
            Lng: 0
        };
        this.tempCityId = HotelListNewController.SearchRequestInfo.CityId;
    },
    initializeDOM: function() {
        this.allInOne = $("#allInOne");
        this.m_city = $("#m_city");
        this.searchBox = $("#searchBox");
        this.m_endDate = $("#m_endDate");
        this.m_preDate = $("#m_preDate");
        this.filterDiv = $("#filterDiv");
        this.pageOrderDiv = $("#pageOrderDiv");
        this.divListView = $("#divListView");
        this.pageDiv = $("#pageDiv");
        this.pageDivDown = $("#pageDivDown");
        this.advancedFilterDiv = $("#advancedFilterDiv");
        this.filterDivLeft = $("#filterDivLeft");
        this.priceBox = $("#priceBox");
        this.lowPrice = $("#lowPrice");
        this.highPrice = $("#highPrice");
        this.m_city = $("#m_city");
        this.h1 = $("#h1");
        this.m_search = $("#m_search");
        this.surePrice = $("#surePrice");
        this.CityName;
        this.CityNameCn;
        this.CityNameEn;
        this.hotelTemp = new Template($("#hotel").html());
        this.roomTemp = new Template($("#room").html());
        this.warmTipsTemp = new Template($("#warmTips").html());
        this.starLevelTemp = new Template($("#starLevel").html());
        this.elongStarLevelTemp = new Template($("#elongStarLevel").html());
        this.divSearch = $("#divSearch");
        this.isSelect = false;
        this.aioWind = null;
        this.li_pageDown = $("#li_pagedown");
        this.allInOneData = {
            Keywords: "",
            KeywordsType: "None",
            AreaId: "",
            AreaType: "0",
            BrandId: "0",
            StartLat: "0",
            StartLng: "0",
            PoiId: "0",
            Param: "",
            Accept: "-1"
        };
        this.RecentOrdersOfCityContainer = $("#RecentOrdersOfCityContainer");
        this.HistoryBrowseHotelContainer = $("#HistoryBrowseHotelContainer");
        this.HotHotelContainer = $("#HotHotelContainer");
        this.hotelList = $("#hotelList");
        this.span_total = $("#span_total");
        this.searchElement = this.getFormElement(this.searchBox);
        this.hrefMore = $("#hrefMore");
        this.bigpic = HotelListNewController.SearchRequestInfo.ListType == "Common" ? new Template

($("#divBigPic").html()) : null;
    },
    destroyDOM: function() {
        this.allInOne = null;
        this.searchBox = null;
        this.filterDiv = null;
        this.m_city = null;
        this.m_endDate = null;
        this.m_preDate = null;
        this.filterDivLeft = null;
        this.RecentOrdersOfCityContainer = null;
        this.HistoryBrowseHotelContainer = null;
        this.HotHotelContainer = null;
        this.hotelList = null;
    },
    initializeEvent: function() {
        this.searchBox.bind("click", this.OnClickdvSearchBox.bindAsEventListener(this));
        this.searchBox.bind("keydown", this.checkSearch.bindAsEventListener(this));
        this.filterDiv.bind("click", this.OnClickFilterDiv.bindAsEventListener(this));
        this.pageOrderDiv.bind("click", this.OnClickPageOrderDiv.bindAsEventListener(this));
        this.divListView.bind("click", this.OnClickListView.bindAsEventListener(this));
        this.advancedFilterDiv.bind("click", this.OnClickAdvancedFilterDiv.bindAsEventListener

(this));
        this.pageDiv.bind("click", this.OnClickPageDiv.bindAsEventListener(this));
        this.hotelList.bind("mouseover", this.OnMouseoverhotelList.bindAsEventListener(this));
        this.hotelList.bind("mouseout", this.OnMouseouthotelList.bindAsEventListener(this));
        this.hotelList.bind("click", this.OnClickhotelList.bindAsEventListener(this));
        this.pageDivDown.bind("click", this.OnClickPageDivDown.bindAsEventListener(this));
        this.hrefMore.bind("click", this.showMorewindow.bindAsEventListener(this));
        this.allInOne.bind("focus", this.onAllInOneFocus.bindAsEventListener(this));
        this.allInOne.bind("blur", this.onAllInOneBlur.bindAsEventListener(this));
        this.lowPrice.bind("keydown", this.OnOnlyNumber.bindAsEventListener(this));
        this.highPrice.bind("keydown", this.OnOnlyNumber.bindAsEventListener(this));
        FunctionExt.defer(this.onOutClick.bindAsEventListener(this), 100);
    },
    onOutClick: function() {
        $(document).bind("click",
        function(b) {
            var a = Event.element(b);
            if (this.priceBox != null && this.priceBox.find("*").index(a) == -1) {
                this.priceBox.removeClass("price_on");
            }
        }.bindAsEventListener(this));
    },
    IsTravelWeb: function() {
        return window.location.host.toLowerCase() == "travel.elong.com" || 
        	window.location.host.toLowerCase() == "travel.elong.net";
    },
    Search: function(e, a, c, d, f) {
        var g = "/isajax/HotelListNew/Search?viewpath=~/views/2011/HotelList.aspx?Language=" + 
        	HotelListNewController.Language + (HotelListNewController.CampaignId != "" ? "&campaign_id=" + 
        	HotelListNewController.CampaignId + "&": "");
        if (this.IsTravelWeb()) {
            g = "/HOTEL/isajax/HotelListNew/Search?viewpath=~/views/2011/HotelList.aspx?Language=" 
            	+ HotelListNewController.Language + (HotelListNewController.CampaignId != "" ? "&campaign_id=" + 
            	HotelListNewController.CampaignId + "&": "");
        }
        var b = e.Campaign_Id;
        e.Campaign_Id = null;
        elongAjax.callBack(g, e, a, c, d, f);
        e.Campaign_Id = b;
        this.CreateAndSaveSearchGuid();
        this.HotelSearchTrigger(e);
    },
    showMorewindow: function(c) {
        var b = Event.element(c);
        var d = HotelListNewController.Language;
        var a = HotelListNewController.SearchRequestInfo.CityId;
        if (a == "3201") {
            return;
        }
        if (this.HotSuggestAllWindowClient == null) {
            this.HotSuggestAllWindowClient = new HotSuggestAllWindow({
                eventElement: b,
                lang: d,
                cityId: a,
                url: HotelListNewController.UrlConfig.HotSuggestAllUrl,
                onSubmit: function(e) {
                    this.GlobalData = e;
                    this.SetSearchReqstInfo(HotelListNewController.SearchRequestInfo, 

this.GlobalData);
                    switch (e.Type) {
                    case 1:
                    case 2:
                    case 4:
                    case 99:
                        this.replaceLabel(this.GlobalData.Name, "aioPoiLabel");
                        break;
                    case 3:
                        this.replaceLabel(this.GlobalData.Name, "locationLabel");
                        break;
                    case 5:
                    case 9:
                        this.replaceLabel(this.GlobalData.Name, "brandLabel");
                        break;
                    }
                    this.AddLabeDesc(this.GlobalData);
                    this.getHotelList();
                    if (HotelListNewController.SearchRequestInfo.StartLat > 0 || 

HotelListNewController.SearchRequestInfo.StartLng > 0) {
                        this.swthOrderByDistinct("on");
                    } else {
                        this.swthOrderByDistinct("close");
                    }
                    $("#filterConditionHandler").show();
                }.bind(this)
            });
        } else {
            this.HotSuggestAllWindowClient.render();
        }
    },
    AddLabeDesc: function(a) {
        switch (a.Type) {
        case 1:
        case 2:
        case 4:
        case 99:
        case 3:
            this.filterDiv.find("#location_ul li").removeClass("on");
            var b = this.filterDiv.find("[areaid='" + a.PropertiesId + "']");
            if (b.length > 0) {
                b.parent().addClass("on");
                return;
            }
            break;
        case 5:
            this.filterDiv.find("#brand_ul li").removeClass("on");
            var c = this.filterDiv.find("[brandid='" + a.PropertiesId + "']");
            if (c.length > 0) {
                c.parent().addClass("on");
                return;
            }
            break;
        case 9:
            break;
        }
    },
    GetHotelIdLists: function() {
        var b = new StringBuilder();
        if (this.HotelRoomInfo == null) {
            return null;
        }
        for (var a = 0; a < this.HotelRoomInfo.length; a++) {
            if (a == 0) {
                b.append(this.HotelRoomInfo[a].HotelId);
            } else {
                b.append("," + this.HotelRoomInfo[a].HotelId);
            }
        }
        return b.toString();
    },
    LoadHotelListRecentOrder: function() {
        var a = this.GetHotelIdLists();
        if (a == null || a == "") {
            return;
        }
        HotelListNewController.GetHotelListNewOrderInfo(a, this.Language,
        function(b) {
            if (b) {
                if (b.length) {
                    this.ShowHotelListRecentOrder(b);
                }
            }
        }.bind(this), true, "GET");
    },
    ShowHotelListRecentOrder: function(d) {
        var a = $("#hotelList");
        for (var c = 0; c < d.length; c++) {
            var b = a.find("#RSInfo_" + d[c].HotelId);
            b.html(d[c].OrderDesc);
        }
    },
    OnClickhotelList: function(evt) {
        var element = Event.element(evt);
        var method = element.attr("method");
        switch (method) {
        case "showMap":
            var iframeSrc = this.popupMapUrl.eval({
                language: HotelListNewController.Language.toLowerCase(),
                city: this.searchElement.m_city.val(),
                title: element.attr("title"),
                lat: element.attr("lat"),
                lng: element.attr("lng")
            });
            var wind = new Dialog({
                title: this.res.Map,
                htmlContent: '<div id="t_map"><iframe  frameborder="0" scrolling="no"  src="' + 

iframeSrc + '" style="margin:0;padding:0;width: 625px; height: 460px;" ></iframe></div>',
                width: 650,
                height: 500,
                initEvent: function(windowElement) {}.bind(this)
            });
            wind.show();
            break;
        case "show360":
            var html = this.flashTemplate.eval({
                hotelID: element.attr("hotelid"),
                rad: Math.random(),
                lang: this.Language
            });
            var wind = new Dialog({
                title: this.res.pic360,
                htmlContent: html,
                width: 720,
                height: 465,
                initEvent: function(windowElement) {}.bind(this)
            });
            wind.show();
            break;
        case "RoomMore":
            var node = element.parents().parents()[0].children[0];
            if (element.hasClass("all-show")) {
                $(node).find("li").each(function(i) {
                    $(this)[0].style.display = "";
                });
                element.removeClass();
                element.addClass("all-hide");
                element.text(this.res.ShowAllRoom2);
            } else {
                $(node).find("li").each(function(i) {
                    if (i >= 3) {
                        $(this)[0].style.display = "none";
                    }
                });
                element.removeClass();
                element.addClass("all-show");
                element.text(this.res.ShowAllRoom1);
            }
            var roomnum = "";
            if (element.attr("hotelid") != "" && element.hasClass("all-hide")) {
                if (this.HotelRoomInfo == null) {
                    return;
                }
                for (var i = 0; i < this.HotelRoomInfo.length; i++) {
                    if (this.HotelRoomInfo[i].HotelId == element.attr("mainhotelid")) {
                        roomnum = this.HotelRoomInfo[i].HotelRoomSimpleList.length;
                    }
                }
                if (element.attr("roomnum") == roomnum) {
                    element.attr("roomnum", "100");
                    HotelListNewController.GetShadowHotelRoom

(HotelListNewController.SearchRequestInfo, element.attr("hotelid"),
                    function(res) {
                        if (res.success) {
                            if (res.value != null) {
                                var shadowRoomHtml = this.rendRoomHtml(res.value[0], 1, 

element.attr("mainhotelid"));
                                $(node).append(shadowRoomHtml);
                                this.HotelRoomInfo = Object.isNull(this.HotelRoomInfo) ? res.value

[0] : this.HotelRoomInfo.concat(res.value[0]);
                            }
                        }
                    }.bind(this), false, "POST");
                }
            }
            this.HotelDetailTrigger(element.attr("mainhotelid"));
            break;
        }
    },
    OnMouseouthotelList: function(b) {
        var a = Event.element(b);
        var c = a.attr("method");
        if (this.HotelRoomInfo == null) {
            return;
        }
        switch (c) {
        case "bigpic":
            a.parent().parent().find("div").fadeOut();
            a.parent().parent().find("div").html("");
            break;
        }
    },
    OnMouseoverhotelList: function(evt) {
        var element = Event.element(evt);
        var method = element.attr("method");
        if (this.HotelRoomInfo == null) {
            return;
        }
        switch (method) {
        case "avgPrice":
            var roomid = element.parent().parent().parent().attr("roomid");
            var rpid = element.parent().parent().parent().attr("rpid");
            var hotelid = element.parent().parent().parent().attr("hotelid");
            for (var i = 0; i < this.HotelRoomInfo.length; i++) {
                if (this.HotelRoomInfo[i].HotelId == hotelid) {
                    var HotelRoomSimpleList = this.HotelRoomInfo[i].HotelRoomSimpleList;
                    for (var j = 0; j < HotelRoomSimpleList.length; j++) {
                        if (HotelRoomSimpleList[j].RatePlanId == rpid && HotelRoomSimpleList

[j].RoomId == roomid) {
                            var dayPrice = HotelRoomSimpleList[j].DayPriceList;
                            var sbTitle = new StringBuilder();
                            var sbList = new StringBuilder();
                            for (var i = 0; i < dayPrice.length; i++) {
                                if (i < 7) {
                                    sbTitle.append(String.format("<th>{0}</th>", dayPrice

[i].Week));
                                }
                                if (i % 7 == 0) {
                                    sbList.append(String.format("<tr><td nowrap='' class='blk'>" + 

this.res.Js_Week + "</td>", 1 + i / 7));
                                }
                                var money = "#&yen;";
                                var spriceStr = dayPrice[i].SPrice.length > 0 ? String.format

("<p><del class='l_black'>{0}</del></p>", dayPrice[i].SPrice) : "";
                                sbList.append(String.format("<td>{2}{0}<div class='blk'>{1}

</div></td>", dayPrice[i].Price, this.Language == "CN" ? dayPrice[i].BreakFast: "", spriceStr));
                                if (i % 7 == 6 || i == dayPrice.length - 1) {
                                    sbList.append("</tr>");
                                }
                            }
                            var col = dayPrice.length >= 7 ? 7 : dayPrice.length;
                            if (this.tipWindow != null) {
                                this.tipWindow.close();
                            }
                            this.tipWindow = new TipWindow({
                                htmlContent: this.priceTemplate.eval({
                                    Title: sbTitle.toString(),
                                    List: sbList.toString()
                                }),
                                eventElement: element,
                                defer: true,
                                width: 90 + col * 70
                            });
                            return;
                        }
                    }
                }
            }
            break;
        case "coupon":
            var roomid = element.parent().parent().parent().attr("roomid");
            var rpid = element.parent().parent().parent().attr("rpid");
            var hotelid = element.parent().parent().parent().attr("hotelid");
            for (var i = 0; i < this.HotelRoomInfo.length; i++) {
                if (this.HotelRoomInfo[i].HotelId == hotelid) {
                    var HotelRoomSimpleList = this.HotelRoomInfo[i].HotelRoomSimpleList;
                    for (var j = 0; j < HotelRoomSimpleList.length; j++) {
                        if (HotelRoomSimpleList[j].RatePlanId == rpid && HotelRoomSimpleList

[j].RoomId == roomid) {
                            var rule = HotelRoomSimpleList[j].RuleDesc;
                            if (!String.isNullOrEmpty(rule)) {
                                var html = this.ruleTemplate.eval({
                                    Rule: rule
                                });
                                if (this.tipWindow != null) {
                                    this.tipWindow.close();
                                }
                                this.tipWindow = new TipWindow({
                                    htmlContent: html,
                                    eventElement: element,
                                    defer: true,
                                    width: 400
                                });
                            }
                        }
                    }
                }
            }
            break;
        case "simpCoupon":
            var hotelid = element.attr("hotelid");
            if (this.HotelRoomInfo == null) {
                return;
            }
            for (var i = 0; i < this.HotelRoomInfo.length; i++) {
                if (this.HotelRoomInfo[i].HotelId == hotelid) {
                    var HotelRoomSimple = this.HotelRoomInfo[i].HotelRoomSimpleList[0];
                    var rule = HotelRoomSimple.RuleDesc;
                    if (!String.isNullOrEmpty(rule)) {
                        var html = this.ruleTemplate.eval({
                            Rule: rule
                        });
                        if (this.tipWindow != null) {
                            this.tipWindow.close();
                        }
                        this.tipWindow = new TipWindow({
                            htmlContent: html,
                            eventElement: element,
                            defer: true,
                            width: 400
                        });
                    }
                }
            }
            break;
        case "bigpic":
            var imagehtml = '<div class="com_bigpic"> <div class="box"> <div class="cnt_dom"><img 

alt="' + element.attr("hotelname") + '" src="' + element.attr("bigpic") + '" /></div> </div> 

</div>';
            if (element.attr("bigpic") != "http://static.elong.com/images/hotels/") {
                element.parent().parent().append(imagehtml);
            }
            break;
        case "tipf":
            if (this.tipWindow != null) {
                this.tipWindow.close();
            }
            this.tipWindow = new TipWindow({
                htmlContent: element.parent().next(0).html(),
                eventElement: element,
                defer: true,
                width: 400
            });
            break;
        }
    },
    checkSearch: function(b) {
        var a = Event.element(b);
        var c = a.attr("method");
        if (b.keyCode == 13 && c != "allInOne") {
            this.m_search.trigger("click");
        }
    },
    OnClickdvSearchBox: function(c) {
        var b = Event.element(c);
        var d = b.attr("method");
        switch (d) {
        case "m_preDate":
            new CalendarWindow({
                eventElement:
                b,
                selectedDate: b.val(),
                language: this.Language,
                onSelected: function(g) {
                    b.val(g);
                    this.m_endDate.click();
                }.bind(this)
            });
            break;
        case "m_endDate":
            var a = validator.convertDate(this.m_preDate.val());
            a = new Date(a.setHours(24));
            new CalendarWindow({
                eventElement: b,
                selectedDate: validator.getDateString(a),
                enabledFrom: validator.getDateString(a),
                language: this.Language,
                onSelected: function(g) {
                    b.val(g);
                }.bind(this)
            });
            break;
        case "m_search":
            if (!this.searchValid()) {
                break;
            }
            this.writeHotelCookie();
            var e = this.allInOne.val();
            e = this.replaceCharCode(e);
            if (!Object.isNull(this.allInOne[0].Data)) {
                this.GlobalData = this.allInOne[0].Data;
            } else {
                this.GlobalData = {
                    Name: "",
                    Type: 99,
                    PropertiesId: 0,
                    Lat: 0,
                    Lng: 0
                };
            }
            if (e.trim() == HotelListNewController.Resources.AllInOne) {
                this.GlobalData.Name = "";
                this.GlobalData.Type = -1;
            } else {
                this.GlobalData.Name = e.trim();
            }
            if (!Object.isNull(this.allInOne[0].Data)) {
                if (this.allInOne[0].Data.Name != this.GlobalData.Name) {
                    this.allInOneData.Accept = "2";
                } else {
                    this.allInOneData.Accept = "1";
                }
            } else {
                this.allInOneData.Accept = "0";
            }
            var f = this.getSearchUrl();
            this.CreateAndSaveSearchGuid(null);
            this.showLoading();
            window.location.href = f;
            this.SearchDataCollect("hotellistsearchbutton");
            break;
        }
    },
    replaceCharCode: function(a) {
        return a.replace(/(!)/g, "").replace(/(~)/g, "").replace(/(@)/g, "").replace(/(#)/g, 

"").replace(/($)/g, "").replace(/(%)/g, "").replace(/(^)/g, "").replace(/(&)/g, "").replace(/

(\*)/g, "").replace(/(！)/g, "").replace(/(~)/g, "").replace(/(@)/g, "").replace(/(#)/g, 

"").replace(/(￥)/g, "").replace(/(%)/g, "").replace(/(……)/g, "").replace(/(&)/g, "").replace(/

(\*)/g, "");
    },
    writeHotelCookie: function() {
        Globals.cookie("ShHotel", "", {
            InDate: this.m_preDate.val(),
            OutDate: this.m_endDate.val(),
            CityID: HotelListNewController.SearchRequestInfo.CityId
        });
        if (!Object.isNull(HotelListNewController.CityNameCN)) {
            Globals.cookie("ShHotel", "", {
                CityNameCN: HotelListNewController.CityNameCN
            });
            Globals.cookie("ShHotel", "", {
                CityName: HotelListNewController.CityNameCN
            });
        }
        if (!Object.isNull(HotelListNewController.CityNameEN)) {
            Globals.cookie("ShHotel", "", {
                CityNameEN: HotelListNewController.CityNameEN
            });
        }
    },
    OnClickFilterDiv: function(b) {
        b.preventDefault();
        var a = Event.element(b);
        var f = a.html();
        var d = a.attr("method");
        switch (d) {
        case "location":
            this.replaceLabel(f, "locationLabel");
            this.clearRow($("#location_ul"));
            this.markRowColumn(a);
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            HotelListNewController.SearchRequestInfo.Keywords = "";
            HotelListNewController.SearchRequestInfo.HotelSort = "1";
            HotelListNewController.SearchRequestInfo.PoiId = "0";
            HotelListNewController.SearchRequestInfo.AreaType = 1;
            if (!String.isNullOrEmpty(a.attr("areaid"))) {
                HotelListNewController.SearchRequestInfo.AreaId = a.attr("areaid");
            } else {
                HotelListNewController.SearchRequestInfo.AreaId = "";
                HotelListNewController.SearchRequestInfo.StartLat = 0;
                HotelListNewController.SearchRequestInfo.StartLng = 0;
            }
            this.getHotelList();
            this.swthOrderByDistinct("close");
            if ($("#filterDivLeft li").length > 0) {
                $("#filterConditionHandler").show();
            }
            break;
        case "price":
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            this.lowPrice.attr("value", "");
            this.highPrice.attr("value", "");
            this.replaceLabel(f, "priceLabel");
            this.clearRow($("#price_ul"));
            this.markRowColumn(a);
            this.setPrice(a);
            this.getHotelList();
            if ($("#filterDivLeft li").length > 0) {
                $("#filterConditionHandler").show();
            }
            break;
        case "star":
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            this.replaceLabel(f, "starLabel");
            this.clearRow($("#star_ul"));
            this.markRowColumn(a);
            this.setStar(a);
            this.getHotelList();
            if ($("#filterDivLeft li").length > 0) {
                $("#filterConditionHandler").show();
            }
            break;
        case "brand":
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            HotelListNewController.SearchRequestInfo.HotelName = "";
            if (HotelListNewController.SearchRequestInfo.KeywordsType == "9" || 

HotelListNewController.SearchRequestInfo.KeywordsType == 9 || 

HotelListNewController.SearchRequestInfo.KeywordsType == "HotelName") {
                HotelListNewController.SearchRequestInfo.Keywords = "";
            }
            this.replaceLabel(f, "brandLabel");
            this.clearRow($("#brand_ul"));
            this.markRowColumn(a);
            HotelListNewController.SearchRequestInfo.BrandId = a.attr("brandid");
            this.getHotelList();
            if ($("#filterDivLeft li").length > 0) {
                $("#filterConditionHandler").show();
            }
            break;
        case "del":
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            a.parent().remove();
            var c = a.parent().attr("method").replace("Label", "");
            c = c.replace("aio", "").toLowerCase();
            this.setDel(c);
            if (c == "poi") {
                this.swthOrderByDistinct("close");
            }
            this.getHotelList();
            if (HotelListNewController.SearchRequestInfo.StartLat > 0 || 

HotelListNewController.SearchRequestInfo.StartLng > 0) {
                this.swthOrderByDistinct("on");
            } else {
                this.swthOrderByDistinct("close");
            }
            if ($("#filterDivLeft li").length <= 0) {
                $("#filterConditionHandler").hide();
            }
            break;
        case "delAll":
            if ($("#filterDivLeft:eq(0)").children().length == 0) {
                break;
            }
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            this.delAll();
            this.getHotelList();
            $("#filterConditionHandler").hide();
            if (HotelListNewController.SearchRequestInfo.StartLat > 0 || 

HotelListNewController.SearchRequestInfo.StartLng > 0) {
                this.swthOrderByDistinct("on");
            } else {
                this.swthOrderByDistinct("close");
            }
            break;
        case "lowPrice":
        case "highPrice":
            this.priceBox.addClass("price_on");
            break;
        case "surePrice":
            this.priceBox.removeClass("price_on");
            var e = this.checkMoney(this.lowPrice.val(), this.highPrice.val());
            if (e) {
                this.replaceLabel(this.lowPrice.val() + "-" + this.highPrice.val(), "priceLabel");
                this.clearRow($("#price_ul"));
                HotelListNewController.SearchRequestInfo.LowPrice = this.lowPrice.val();
                HotelListNewController.SearchRequestInfo.HighPrice = this.highPrice.val();
                HotelListNewController.SearchRequestInfo.PageIndex = 1;
                this.getHotelList();
                $("#filterConditionHandler").show();
            }
            break;
        }
    },
    OnClickPageOrderDiv: function(b) {
        var a = Event.element(b);
        var c = a.attr("method");
        switch (c) {
        case "order":
            if (a.attr("mark") == "distinct") {
                if ($(a).parent()[0].className == "disb") {
                    return;
                }
            }
            this.clearRow($("#order_ul"));
            this.markRowColumn(a);
            this.setHotelSort(a);
            this.getHotelList();
            break;
        }
    },
    OnClickListView: function() {},
    onAllInOneFocus: function() {
        if (this.allInOne.attr("value") == HotelListNewController.Resources.AllInOne) {
            this.allInOne.attr("value", "");
        }
    },
    onAllInOneBlur: function() {
        if (this.allInOne.attr("value") == "") {
            this.allInOne.attr("value", HotelListNewController.Resources.AllInOne);
        }
    },
    OnClickAdvancedFilterDiv: function(b) {
        var a = Event.element(b);
        var c = a.attr("method");
        switch (c) {
        case "bigbed":
            this.replaceLabel(a.next().text(), c + "Label");
            this.setAdvancedFilter(a);
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            this.getHotelList();
            if ($("#filterDivLeft li").length > 0) {
                $("#filterConditionHandler").show();
            } else {
                $("#filterConditionHandler").hide();
            }
            break;
        case "doublebed":
            this.replaceLabel(a.next().text(), c + "Label");
            this.setAdvancedFilter(a);
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            this.getHotelList();
            if ($("#filterDivLeft li").length > 0) {
                $("#filterConditionHandler").show();
            } else {
                $("#filterConditionHandler").hide();
            }
            break;
        case "coupon":
            this.replaceLabel(a.next().text(), c + "Label");
            this.setAdvancedFilter(a);
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            this.getHotelList();
            if ($("#filterDivLeft li").length > 0) {
                $("#filterConditionHandler").show();
            } else {
                $("#filterConditionHandler").hide();
            }
            break;
        case "cashback":
            this.replaceLabel(a.next().text(), c + "Label");
            this.setAdvancedFilter(a);
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            this.getHotelList();
            if ($("#filterDivLeft li").length > 0) {
                $("#filterConditionHandler").show();
            } else {
                $("#filterConditionHandler").hide();
            }
            break;
        case "noguarantee":
            this.replaceLabel(a.next().text(), c + "Label");
            this.setAdvancedFilter(a);
            HotelListNewController.SearchRequestInfo.PageIndex = 1;
            this.getHotelList();
            if ($("#filterDivLeft li").length > 0) {
                $("#filterConditionHandler").show();
            } else {
                $("#filterConditionHandler").hide();
            }
            break;
        }
    },
    OnClickPageDiv: function(b) {
        var a = Event.element(b);
        var c = a.attr("method");
        switch (c) {
        case "prev":
            if (HotelListNewController.SearchRequestInfo.PageIndex > 1) {
                HotelListNewController.SearchRequestInfo.PageIndex = 

HotelListNewController.SearchRequestInfo.PageIndex - 1;
                this.getHotelList();
                this.changePageCss();
            }
            break;
        case "next":
            if (HotelListNewController.SearchRequestInfo.PageIndex < 

HotelListNewController.PageInfo.PageCount) {
                HotelListNewController.SearchRequestInfo.PageIndex = 

HotelListNewController.SearchRequestInfo.PageIndex + 1;
                this.getHotelList();
                this.changePageCss();
            } else {}
            break;
        }
    },
    OnClickPageDivDown: function(b) {
        var a = Event.element(b);
        var c = a.parent().attr("method");
        switch (c) {
        case "prev":
            if (HotelListNewController.SearchRequestInfo.PageIndex > 1) {
                HotelListNewController.SearchRequestInfo.PageIndex = 

HotelListNewController.SearchRequestInfo.PageIndex - 1;
                this.getHotelList();
                this.changePageCss();
            }
            break;
        case "next":
            if (HotelListNewController.SearchRequestInfo.PageIndex < 

HotelListNewController.PageInfo.PageCount) {
                HotelListNewController.SearchRequestInfo.PageIndex = 

HotelListNewController.SearchRequestInfo.PageIndex + 1;
                this.getHotelList();
                this.changePageCss();
            }
            break;
        case "unWorkPage":
            HotelListNewController.SearchRequestInfo.PageIndex = parseInt(a.text());
            this.getHotelList();
            this.changePageCss();
            break;
        }
    },
    changePageCss: function() {
        var c = this.pageDivDown.find("ul");
        var b = c.children();
        for (var a = 2; a <= b.length - 2; a++) {
            c.find("li:nth-child(2)").remove();
        }
        if (HotelListNewController.PageInfo.TotalRow <= 1) {
            this.pageDivDown.attr("style", "display:none");
        } else {
            this.pageDivDown.attr("style", "display:");
            if (HotelListNewController.PageInfo.PageCount < 6) {
                for (var a = 1; a <= HotelListNewController.PageInfo.PageCount; a++) {
                    if (a == HotelListNewController.SearchRequestInfo.PageIndex) {
                        c.children(":last").prev().before('<li class="page_on">' + a + "</li>");
                    } else {
                        c.children(":last").prev().before('<li class="page_on" 

method="unWorkPage"><a href="#">' + a + "</a></li>");
                    }
                }
            } else {
                if (HotelListNewController.SearchRequestInfo.PageIndex < 4) {
                    for (var a = 1; a <= 5; a++) {
                        if (a == HotelListNewController.SearchRequestInfo.PageIndex) {
                            c.children(":last").prev().before('<li class="page_on">' + a + 

"</li>");
                        } else {
                            c.children(":last").prev().before('<li class="page_on" 

method="unWorkPage"><a href="#">' + a + "</a></li>");
                        }
                    }
                    c.children(":last").prev().before("<li>...</li>");
                } else {
                    if (HotelListNewController.SearchRequestInfo.PageIndex > 

HotelListNewController.PageInfo.PageCount - 3) {
                        c.children(":last").prev().before("<li>...</li>");
                        for (var a = HotelListNewController.PageInfo.PageCount - 4; a <= 

HotelListNewController.PageInfo.PageCount; a++) {
                            if (a == HotelListNewController.SearchRequestInfo.PageIndex) {
                                c.children(":last").prev().before('<li class="page_on">' + a + 

"</li>");
                            } else {
                                c.children(":last").prev().before('<li class="page_on" 

method="unWorkPage"><a href="#">' + a + "</a></li>");
                            }
                        }
                    } else {
                        c.children(":last").prev().before("<li>...</li>");
                        for (var a = HotelListNewController.SearchRequestInfo.PageIndex - 2; a <= 

HotelListNewController.SearchRequestInfo.PageIndex + 2; a++) {
                            if (a == HotelListNewController.SearchRequestInfo.PageIndex) {
                                c.children(":last").prev().before('<li class="page_on">' + a + 

"</li>");
                            } else {
                                c.children(":last").prev().before('<li class="page_on" 

method="unWorkPage"><a href="#">' + a + "</a></li>");
                            }
                        }
                        c.children(":last").prev().before("<li>...</li>");
                    }
                }
            }
            this.li_pageDown.html(String.format(HotelListNewController.Resources.PageCount, 

HotelListNewController.PageInfo.PageCount));
        }
    },
    OnOnlyNumber: function(a) {
        if (a.keyCode == 13) {
            this.surePrice.trigger("click");
            return true;
        }
        if (a.keyCode == 37 || a.keyCode == 39 || a.keyCode == 46) {
            return true;
        }
        if ((a.keyCode < 48 && a.keyCode >= 32) || (a.keyCode > 57 && a.keyCode < 96) || a.keyCode 

> 105) {
            return false;
        }
    },
    searchValid: function() {
        if (!validator.valid(this.m_city.val(), "notEmpty & nonSpecialSign")) {
            $error(this.m_city, HotelListNewController.Resources.InsertCity);
            return false;
        }
        if (!Object.isNull(this.m_city[0].City)) {
            this.tempCityId = this.m_city[0].City.CityId;
            this.CityNameCn = this.m_city[0].City.CityNameCn;
            this.CityNameEn = this.m_city[0].City.CityNameEn;
        } else {
            $error(this.m_city, HotelListNewController.Resources.NotExistCity);
            return false;
        }
        if (this.Language == "EN") {
            if (!validator.valid(this.m_preDate.val(), "notEmpty & dateEn")) {
                $error(this.m_preDate, HotelListNewController.Resources.NotPassInDate);
                return false;
            }
            if (!validator.valid(this.m_endDate.val(), "notEmpty & dateEn")) {
                $error(this.m_endDate, HotelListNewController.Resources.NotPassOutDate);
                return false;
            }
        } else {
            if (!validator.valid(this.m_preDate.val(), "notEmpty & date")) {
                $error(this.m_preDate, HotelListNewController.Resources.NotPassInDate);
                return false;
            }
            if (!validator.valid(this.m_endDate.val(), "notEmpty & date")) {
                $error(this.m_endDate, HotelListNewController.Resources.NotPassOutDate);
                return false;
            }
        }
        var g = new Date();
        var h = validator.reFormatDateString(g.getFullYear() + "-" + (g.getMonth() + 1) + "-" + 

g.getDate());
        var i = this.m_preDate.val();
        var f = this.m_endDate.val();
        var e = validator.reFormatDateString(i);
        var d = validator.reFormatDateString(f);
        if (e < h) {
            $error(this.m_preDate, HotelListNewController.Resources.InDateAfterNow);
            return false;
        }
        if (d < h) {
            $error(this.m_endDate, HotelListNewController.Resources.OutDateAfterNow);
            return false;
        }
        var c = validator.convertDate(e);
        c = new Date(c.setHours(24));
        if (!validator.valid(this.m_endDate.val(), "notEmpty & dateRange", validator.getDateString

(c), null)) {
            $error(this.m_endDate, HotelListNewController.Resources.OutDateAfterInDate);
            return false;
        }
        var a = this.daysBetween(e, validator.reFormatDateString(new Date().getFullYear() + "-" + 

(new Date().getMonth() + 1) + "-" + new Date().getDate()));
        var j = HotelListNewController.Tel;
        if (a > "180") {
            $error(this.m_preDate, String.format(HotelListNewController.Resources.Date180Msg, e, 

j));
            return false;
        }
        var b = this.daysBetween(e, d);
        if (b > "20") {
            $error(this.m_endDate, String.format(HotelListNewController.Resources.Date20Msg, "20", 

j));
            return false;
        }
        return true;
    },
    daysBetween: function(b, c) {
        var e = b.substring(5, b.lastIndexOf("-"));
        var d = b.substring(b.length, b.lastIndexOf("-") + 1);
        var f = b.substring(0, b.indexOf("-"));
        var h = c.substring(5, c.lastIndexOf("-"));
        var g = c.substring(c.length, c.lastIndexOf("-") + 1);
        var i = c.substring(0, c.indexOf("-"));
        var a = ((Date.parse(e + "/" + d + "/" + f) - Date.parse(h + "/" + g + "/" + i)) / 

86400000);
        return Math.abs(a);
    },
    CreateGuid: function() {
        var a = "";
        for (var b = 1; b <= 32; b++) {
            var c = Math.floor(Math.random() * 16).toString(16);
            a += c;
            if ((b == 8) || (b == 12) || (b == 16) || (b == 20)) {
                a += "-";
            }
        }
        return a;
    },
    CreateAndSaveSearchGuid: function(b) {
        var a = b;
        if (Object.isNull(b)) {
            a = this.CreateGuid();
        }
        Globals.cookie("TriggerSearchGUID", "", a, {
            expires: 1,
            path: "/",
            secure: false
        });
    },
    GetSearchGUID: function() {
        var a = Globals.cookie("TriggerSearchGUID");
        if (Object.isNull(a)) {
            a = this.CreateGuid();
            this.CreateAndSaveSearchGuid(a);
        }
        return a;
    },
    GetMachineGUID: function() {
        var a = Globals.cookie("CookieGuid");
        if (Object.isNull(a) || a == "" || a == undefined) {
            a = "";
        }
        return a;
    },
    GetStarEnumName: function(a) {
        var b = a;
        switch (a) {
        case - 1 : case "-1":
            b = "None";
            break;
        case 2:
        case "2":
            b = "TwoStar";
            break;
        case 3:
        case "3":
            b = "ThreeStar";
            break;
        case 4:
        case "4":
            b = "FourStars";
            break;
        case 5:
        case "5":
            b = "FiveStar";
            break;
        case 11:
        case "11":
            b = "Apartment";
        }
        return b;
    },
    HotelSearchTrigger: function(s) {
        try {
            var t = this.GetSearchGUID();
            var o = this.GetMachineGUID();
            if (String.isNullOrEmpty(o)) {
                return null;
            }
            var p = s.OrderFromId;
            var c = s.CardNo;
            var l = Object.isNull(s.HotelName) ? s.Keywords: s.HotelName;
            var n = this.GetStarEnumName(s.StarLevel);
            var k = s.Star == "TwoStar" ? "1": "0";
            var j = s.Star == "Apartment" ? "1": "0";
            var d = s.CheckInDate;
            var f = s.CheckOutDate;
            var r = s.LowPrice;
            var q = (s.HighPrice == 0 || s.HighPrice == "0") ? 9999 : s.HighPrice;
            var g = s.CityId;
            var a = (Object.isNull(s.AreaId) || s.AreaId == "0") ? "": s.AreaId;
            var b = a.length == 0 ? "0": (a.length == 4 ? "2": "1");
            var m = String.isNullOrEmpty(s.Keywords) ? "": s.Keywords;
            var i = String.isNullOrEmpty(s.GroupId) ? "0": s.GroupId;
            var u = "http://tj.elong.com/hotel/trigger/search.gif?

channel=hotel&app=trigger&SearchGUID=" + t + "&OrderFromId=" + p + "&CardNo=" + c + "&HotelName=" + 

encodeURIComponent(l) + "&HotelStarString=" + n + "&HotelIsEconomic=" + k + "&HotelIsApartment=" + 

j + "&CheckInDate=" + d + "&CheckOutDate=" + f + "&PriceRangeLow=" + r + "&PriceRangeHigh=" + q + 

"&CityId=" + g + "&AreaId=" + a + "&AreaIdType=" + b + "&HotelNear=" + encodeURIComponent(m) + 

"&Distance=5000&GroupId=" + i + "&HotelSort=" + s.HotelSort + "&ListType=Common&PageIndex=" + 

s.PageIndex + "&ApCardNo=" + s.ApCardNo + "&MachineGUID=" + o + "&rn=" + Math.random();
            $("#TriggerSearch").remove();
            $("<img src='" + u + "' id='TriggerSearch' width='1' height='1' />").appendTo

($("body"));
        } catch(h) {}
    },
    IsHotelTriggerClick: function(b) {
        var a = Event.element(b);
        var c = a.parents("div.list");
        if (c.length == 0 && String.isNullOrEmpty(c.attr("hotelid"))) {
            return false;
        }
        if (a.is("a.book_ok")) {
            return {
                HotelId: c.attr("hotelid"),
                LogTypeId: "0",
                RoomTypeId: a.parents("li[rmid]").attr("rmid"),
                RatePalnId: a.attr("rtid")
            };
        } else {
            if (a.is("a[mth='unfold']")) {
                return {
                    HotelId: c.attr("hotelid"),
                    LogTypeId: "2",
                    RoomTypeId: "0",
                    RatePalnId: "0"
                };
            }
        }
        return false;
    },
    HotelDetailTrigger: function(b) {
        try {
            var d = this.GetSearchGUID();
            var c = this.GetMachineGUID();
            if (String.isNullOrEmpty(c)) {
                return null;
            }
            var f = "http://tj.elong.com/hotel/trigger/detail.gif?

channel=hotel&app=trigger&SearchGUID=" + d + "&HotelId=" + b + "&CheckInDate=" + 

this.SearchRequestInfo.CheckInDate + "&CheckOutDate=" + this.SearchRequestInfo.CheckOutDate + 

"&LogTypeID=2" + logTypeId + "&RoomTypeID=0" + roomTypeId + "&RatePlanID=0" + ratePlanID + 

"&MachineGUID=" + c + "&OrderFromId=" + this.SearchRequestInfo.OrderFromId + "&CardNo=" + 

HotelListController.AjaxRequestInfo.CardNo + "&rn=" + Math.random();
            $("#TriggerSearch").remove();
            $("<img src='" + f + "' id='TriggerDetail' width='1' height='1' />").appendTo

($("body"));
        } catch(a) {}
    },
    getSearchUrl: function() {
        HotelListNewController.SearchRequestInfo.CityId = this.tempCityId;
        var url = this.HotelListUrl.eval({
            language: HotelListNewController.Language.toLowerCase(),
            cityid: this.tempCityId
        });
        var urlParams = this.SetSearchReqstInfo(HotelListNewController.SearchRequestInfo, 

this.GlobalData);
        if (urlParams != "") {
            url += (url.indexOf("?") != -1 ? "&": "?") + urlParams;
        }
        if (window.location.host == "big5.elong.com") {
            url = "http://big5.elong.com/gate/big5/hotel.elong.com" + url;
            url += url.indexOf("?") > 0 ? "&isbig5=true": "?isbig5=true";
        }
        return url;
    },
    setDel: function(a) {
        if (a.startsWith("aio")) {
            if (HotelListNewController.SearchRequestInfo.KeywordsType != "9" && 

HotelListNewController.SearchRequestInfo.KeywordsType != 9 && 

HotelListNewController.SearchRequestInfo.KeywordsType != "HotelName") {
                HotelListNewController.SearchRequestInfo.Keywords = "";
                HotelListNewController.SearchRequestInfo.KeywordsType = "0";
            }
            a = a.substring(3, a.Length);
        }
        switch (a) {
        case "location":
            if (HotelListNewController.SearchRequestInfo.KeywordsType != "9" && 

HotelListNewController.SearchRequestInfo.KeywordsType != 9 && 

HotelListNewController.SearchRequestInfo.KeywordsType != "HotelName") {
                HotelListNewController.SearchRequestInfo.Keywords = "";
                HotelListNewController.SearchRequestInfo.KeywordsType = "0";
            }
            HotelListNewController.SearchRequestInfo.AreaType = 0;
            HotelListNewController.SearchRequestInfo.AreaId = "";
            HotelListNewController.SearchRequestInfo.PoiId = "0";
            HotelListNewController.SearchRequestInfo.StartLat = "0";
            HotelListNewController.SearchRequestInfo.StartLng = "0";
            this.clearRow($("#" + a + "_ul"));
            this.markRowColumn($("#" + a + "first"));
            break;
        case "price":
            HotelListNewController.SearchRequestInfo.LowPrice = "0";
            HotelListNewController.SearchRequestInfo.HighPrice = "0";
            this.clearRow($("#" + a + "_ul"));
            this.markRowColumn($("#" + a + "first"));
            this.lowPrice.attr("value", "");
            this.highPrice.attr("value", "");
            break;
        case "star":
            HotelListNewController.SearchRequestInfo.StarLevel = "None";
            this.clearRow($("#" + a + "_ul"));
            this.markRowColumn($("#" + a + "first"));
            break;
        case "brand":
        case "hotelname":
            if (HotelListNewController.SearchRequestInfo.KeywordsType == "5" || 

HotelListNewController.SearchRequestInfo.KeywordsType == 5 || 

HotelListNewController.SearchRequestInfo.KeywordsType == "HotelBrand") {
                HotelListNewController.SearchRequestInfo.Keywords = "";
                HotelListNewController.SearchRequestInfo.KeywordsType = "0";
            }
            HotelListNewController.SearchRequestInfo.BrandId = "0";
            HotelListNewController.SearchRequestInfo.HotelName = "";
            if (HotelListNewController.SearchRequestInfo.KeywordsType == "9" || 

HotelListNewController.SearchRequestInfo.KeywordsType == 9 || 

HotelListNewController.SearchRequestInfo.KeywordsType == "HotelName") {
                HotelListNewController.SearchRequestInfo.Keywords = "";
                HotelListNewController.SearchRequestInfo.KeywordsType = "0";
            }
            if (a == "brand") {
                this.clearRow($("#" + a + "_ul"));
                this.markRowColumn($("#" + a + "first"));
            }
            break;
        case "bigbed":
            this.advancedFilterDiv.find('input[mark="bigbed"]').attr("checked", false);
            HotelListNewController.SearchRequestInfo.IsBigBed = false;
            break;
        case "doublebed":
            this.advancedFilterDiv.find('input[mark="doublebed"]').attr("checked", false);
            HotelListNewController.SearchRequestInfo.IsDoubleBed = false;
            break;
        case "coupon":
            this.advancedFilterDiv.find('input[mark="coupon"]').attr("checked", false);
            HotelListNewController.SearchRequestInfo.IsCoupon = false;
            break;
        case "cashback":
            this.advancedFilterDiv.find('input[mark="cashback"]').attr("checked", false);
            HotelListNewController.SearchRequestInfo.IsCashback = false;
            break;
        case "noguarantee":
            this.advancedFilterDiv.find('input[mark="noguarantee"]').attr("checked", false);
            HotelListNewController.SearchRequestInfo.IsNoGuarantee = false;
            break;
        case "poi":
            this.markRowColumn($("#locationfirst"));
            HotelListNewController.SearchRequestInfo.Keywords = "";
            HotelListNewController.SearchRequestInfo.AreaType = 0;
            HotelListNewController.SearchRequestInfo.AreaId = "";
            HotelListNewController.SearchRequestInfo.PoiId = "0";
            HotelListNewController.SearchRequestInfo.StartLat = "0";
            HotelListNewController.SearchRequestInfo.StartLng = "0";
            break;
        }
    },
    setAdvancedFilter: function(a) {
        var b = a.attr("checked") == true ? true: false;
        if (!Object.isNull(a.attr("mark"))) {
            switch (a.attr("mark")) {
            case "bigbed":
                HotelListNewController.SearchRequestInfo.IsBigBed = b;
                break;
            case "doublebed":
                HotelListNewController.SearchRequestInfo.IsDoubleBed = b;
                break;
            case "coupon":
                HotelListNewController.SearchRequestInfo.IsCoupon = b;
                break;
            case "cashback":
                HotelListNewController.SearchRequestInfo.IsCashback = b;
                break;
            case "noguarantee":
                HotelListNewController.SearchRequestInfo.IsNoGuarantee = b;
                break;
            }
        }
    },
    setHotelSort: function(a) {
        if (!Object.isNull(a.attr("mark"))) {
            switch (a.attr("mark")) {
            case "elong":
                HotelListNewController.SearchRequestInfo.HotelSort = 1;
                HotelListNewController.SearchRequestInfo.PageIndex = 1;
                break;
            case "popu":
                HotelListNewController.SearchRequestInfo.HotelSort = 5;
                HotelListNewController.SearchRequestInfo.PageIndex = 1;
                break;
            case "lowprice":
                HotelListNewController.SearchRequestInfo.HotelSort = 2;
                HotelListNewController.SearchRequestInfo.PageIndex = 1;
                break;
            case "distinct":
                HotelListNewController.SearchRequestInfo.HotelSort = 6;
                HotelListNewController.SearchRequestInfo.PageIndex = 1;
                break;
            }
        }
    },
    getHotelList: function() {
        var a = this.showLoading();
        this.Search(HotelListNewController.SearchRequestInfo,
        function(b) {
            if (!Object.isNull(a)) {
                a.close();
                a = null;
            }
            this.DrawHotelListPage(b, 0, "");
            this.divListView.find("a.map").attr("href", b.value.Url.MapUrl);
            this.divListView.find("a.simple").attr("href", b.value.Url.SimpleUrl);
            this.divListView.find("a.nor_list").attr("href", b.value.Url.CommonUrl);
        }.bind(this));
    },
    DrawHotelListPage: function(res, commendtype, commendhtml) {
        if (!Object.isNull(res) && res.success && !Object.isNull(res.value) && !Object.isNull

(res.value.H1)) {
            this.h1.html(res.value.H1);
        }
        if (!Object.isNull(res.value.PageUp)) {
            this.pageDiv.html(res.value.PageUp);
        }
        if (!Object.isNull(res) && res.success && !Object.isNull(res.value) && !Object.isNull

(res.value.PageInfo)) {
            var temp = "";
            if (this.Language != "EN") {
                temp = "家";
            }
            this.span_total.html('(<b class="orange">' + res.value.PageInfo.TotalRow + "</b>" + 

temp + ")");
            HotelListNewController.PageInfo = res.value.PageInfo;
            this.changePageCss();
            if (res.value.PageInfo.TotalRow > 1) {
                $("#mainFilterDiv").show();
            }
        }
        if (!Object.isNull(res) && res.success && !Object.isNull(res.value.HotelBasicInfoList)) {
            this.HotelRoomInfo = Object.isNull(this.HotelRoomInfo) ? res.value.HotelBasicInfoList: 

this.HotelRoomInfo.concat(res.value.HotelBasicInfoList);
            var ListType = "";
            if (commendtype == 1) {
                ListType = "1";
            } else {
                ListType = res.value.RequestInfo.ListType;
            }
            var hotel_html = "";
            for (var i = 0; i < res.value.HotelBasicInfoList.length; i++) {
                var hotelinfo = res.value.HotelBasicInfoList[i];
                var room_html = "";
                if (ListType == "1" && !Object.isNull(res.value.HotelBasicInfoList

[i].HotelRoomSimpleList) && res.value.HotelBasicInfoList[i].HotelRoomSimpleList.length > 0) {
                    room_html += this.rendRoomHtml(res.value.HotelBasicInfoList[i], 0, "");
                }
                var warmTips_html = "";
                if (!Object.isNull(res.value.HotelBasicInfoList[i].WarmTips)) {
                    warmTips_html = this.warmTipsTemp.eval({
                        WarmTips: res.value.HotelBasicInfoList[i].WarmTips
                    });
                }
                var starLevel_html = "";
                var star = "";
                var starTips = "";
                var StarLevel = res.value.HotelBasicInfoList[i].StarLevel;
                var strahotel1 = HotelListNewController.WebCategory == "Elong" ? 

this.res.StarHotel1: this.res.StarHotel1.replace("eLong", "").replace("艺龙", "");
                switch (StarLevel) {
                case 10:
                    star = this.res.Star1;
                    starTips = strahotel1.replace("{0}", star);
                    break;
                case 11:
                    star = this.res.Star5;
                    starTips = strahotel1.replace("{0}", star);
                    break;
                case - 1 : case 0:
                case 1:
                case 2:
                    star = this.res.Star1;
                    starTips = strahotel1.replace("{0}", this.res.Star1);
                    break;
                case 3:
                    star = res.value.HotelBasicInfoList[i].IsElongStar ? this.res.Star2: "3";
                    starTips = res.value.HotelBasicInfoList[i].IsElongStar ? strahotel1.replace

("{0}", this.res.Star2) : this.res.StarHotel.replace("{0}", "3");
                    break;
                case 4:
                    star = res.value.HotelBasicInfoList[i].IsElongStar ? this.res.Star3: "4";
                    starTips = res.value.HotelBasicInfoList[i].IsElongStar ? strahotel1.replace

("{0}", this.res.Star3) : this.res.StarHotel.replace("{0}", "4");
                    break;
                case 5:
                    star = res.value.HotelBasicInfoList[i].IsElongStar ? this.res.StarStar4: "5";
                    starTips = res.value.HotelBasicInfoList[i].IsElongStar ? strahotel1.replace

("{0}", this.res.Star4) : this.res.StarHotel.replace("{0}", "5");
                    break;
                }
                if (res.value.HotelBasicInfoList[i].IsElongStar || StarLevel < 3 || StarLevel > 6) 

{
                    starLevel_html = this.elongStarLevelTemp.eval({
                        StarLevel: star,
                        StarLevelTips: starTips
                    });
                } else {
                    starLevel_html = this.starLevelTemp.eval({
                        StarLevel: star,
                        StarLevelTips: starTips
                    });
                }
                var totalComment = "";
                var goodComment = "";
                var pnum = "";
                if (hotelinfo.RateComment != 0) {
                    totalComment = '<span class="right black">' + (this.Language == "CN" ? 

hotelinfo.TotalComment == 0 ? "": "来自" + hotelinfo.TotalComment + "条点评": 

hotelinfo.TotalComment == 0 ? "Rreviews coming soon": hotelinfo.TotalComment + " reviews") + 

"</span>";
                    goodComment = this.Language == "EN" ? '<span title="TripAdvisor Traveller 

Reviews" class=\'tripadvisorLOGO TL' + hotelinfo.GradeComment + " right'></span>": '<a href="' + 

this.detailCommentUrl.eval({
                        hotelid: hotelinfo.HotelId,
                        sort: "good",
                        pageindex: 1,
                        language: this.Language.toLowerCase()
                    }) + '" class="right percent" title="查看' + hotelinfo.HotelName + "评论\" 

style='display:" + (hotelinfo.RateComment == 0 ? "none": "") + ";'>" + hotelinfo.RateComment + '%

<span class="t12"> 好评</span></a>';
                    pnum = ListType == 3 ? "pl20": "";
                } else {
                    if (this.Language == "EN") {
                        totalComment = '<span class="right black">' + (this.Language == "CN" ? 

hotelinfo.TotalComment == 0 ? "": "来自" + hotelinfo.TotalComment + "条点评": 

hotelinfo.TotalComment == 0 ? "Rreviews coming soon": hotelinfo.TotalComment + " reviews") + 

"</span>";
                        goodComment = this.Language == "EN" ? '<span title="TripAdvisor Traveller 

Reviews" class=\'tripadvisorLOGO TL' + hotelinfo.GradeComment + " right'></span>": '<a href="' + 

this.detailCommentUrl.eval({
                            hotelid: hotelinfo.HotelId,
                            sort: "good",
                            pageindex: 1,
                            language: this.Language.toLowerCase()
                        }) + '" class="right percent" title="查看' + hotelinfo.HotelName + "评论\" 

style='display:" + (hotelinfo.RateComment == 0 ? "none": "") + ";'>" + hotelinfo.RateComment + '%

<span class="t12"> 好评</span></a>';
                        pnum = ListType == 3 ? "pl20": "";
                    }
                }
                var classMarketSimp = "";
                var marketInfoSimp = "";
                var classMarket = "";
                var marketInfo = "";
                if (ListType == 3) {
                    totalComment = '<a target="_blank" href="' + this.detailCommentUrl.eval({
                        hotelid: hotelinfo.HotelId,
                        sort: "index",
                        pageindex: 1,
                        language: this.Language.toLowerCase()
                    }) + '">' + (this.Language == "CN" ? hotelinfo.TotalComment == 0 ? "": "来自" + 

hotelinfo.TotalComment + "条点评": hotelinfo.TotalComment == 0 ? "Rreviews coming soon": 

hotelinfo.TotalComment + " reviews") + "</a>";
                    goodComment = this.Language == "EN" ? '<span title="TripAdvisor Traveller 

Reviews" class="tripadvisorLOGO TL' + hotelinfo.GradeComment + ' right"></span>': 

hotelinfo.RateComment == 0 ? "": '<span class="percent">' + hotelinfo.RateComment + "</span>%好评";
                    if (hotelinfo.HotelRoomSimpleList != null) {
                        var itemSimpRoom = hotelinfo.HotelRoomSimpleList[0];
                        if (itemSimpRoom != null) {
                            classMarket = itemSimpRoom.IsCoupon == true ? "icon_quan": 

itemSimpRoom.IsCashback == true ? "icon_fan": itemSimpRoom.IsPromotion ? "icon_sale_text": "";
                            marketInfo = itemSimpRoom.IsCoupon == true ? itemSimpRoom.CouponAmount: 

itemSimpRoom.IsCashback == true ? itemSimpRoom.CashbackAmount: "";
                        }
                    }
                }
                var areaurl = "";
                if (hotelinfo.Commerical != null && hotelinfo.Commerical.HotelAreaName != "") {
                    areaurl = this.HotelListUrl.eval({
                        language: this.Language.toLowerCase(),
                        cityid: this.tempCityId
                    });
                    if (HotelListNewController.WebCategory != "Elong") {
                        areaurl = areaurl + "&areaid=" + hotelinfo.Commerical.HotelAreaId + 

"&listtype=" + ListType;
                    } else {
                        areaurl = areaurl + "?areaid=" + hotelinfo.Commerical.HotelAreaId + 

"&listtype=" + ListType;
                    }
                }
                var gradeClass = "";
                if (hotelinfo.Grade == 5) {
                    gradeClass = "diamond";
                } else {
                    if (hotelinfo.Grade == 6) {
                        gradeClass = "crown";
                    }
                }
                var imgerror = "http://www.elongstatic.com/hotels/pic/no_pics_" + this.Language + 

".gif";
                hotel_html = hotel_html + this.hotelTemp.eval({
                    classMarket: classMarket,
                    marketInfoSimp: marketInfo,
                    SmallImage: hotelinfo.SmallImage,
                    HotelName: hotelinfo.HotelName,
                    RateComment: hotelinfo.RateComment,
                    StarLevel: starLevel_html,
                    gradeClass: '<span class="' + gradeClass + '"></span>',
                    TotalComment: totalComment,
                    Room: room_html,
                    imgbigpic: '<img alt="' + hotelinfo.HotelName + '" src="' + hotelinfo.BigImage 

+ '">',
                    Latitude: hotelinfo.Latitude,
                    Longitude: hotelinfo.Longitude,
                    Map: hotelinfo.Latitude == "0.000000000" ? "": this.res.Map,
                    comment: goodComment,
                    bigimage: hotelinfo.BigImage,
                    area: hotelinfo.Commerical != null && hotelinfo.Commerical.HotelAreaName != "" 

? "<span class='" + pnum + "'>" + this.res.area + '<a class="black" href="' + areaurl + '">' + 

(this.Language == "CN" ? hotelinfo.Commerical.HotelAreaNameCn: 

hotelinfo.Commerical.HotelAreaNameEn) + "</a></span>": "",
                    picInfo: hotelinfo.VirtualOut ? this.res.pic360: hotelinfo.ImageCout > 0 ? 

this.res.picpic: "",
                    detailUrl: '<a title="' + hotelinfo.HotelName + '" target="_blank" href="' + 

this.detailUrl.eval({
                        hotelid: hotelinfo.HotelId,
                        language: this.Language.toLowerCase()
                    }) + '">',
                    ImgEle: '<img method="bigpic"  bigpic="' + hotelinfo.BigImage + '" hotelname="' 

+ hotelinfo.HotelName + '" onerror="this.src=\'' + imgerror + '\'" src="' + hotelinfo.SmallImage + 

'" alt="' + hotelinfo.HotelName + '" title="' + hotelinfo.HotelName + (hotelinfo.VirtualOut ? 

this.res.pic360: hotelinfo.ImageCout > 0 ? this.res.picpic: "") + '" />',
                    aEnd: "</a>",
                    HotelID: hotelinfo.HotelId,
                    RoomMore: hotelinfo.HotelRoomSimpleList.length > 2 ? '<a method="RoomMore" 

href="#?" hotelid="' + hotelinfo.ShadowHotelId + '" class="all-show">' + this.res.ShowAllRoom1 + 

"</a>": "",
                    Distance: res.value.AttachRequestInfo != null && 

res.value.AttachRequestInfo.Poi != null ? String.format(this.res.distancefrom, 

res.value.AttachRequestInfo.Poi.PoiName, hotelinfo.Distance) : this.res.Address + 

hotelinfo.HotelAddres,
                    WarmTips: warmTips_html,
                    CompareCtripTitle: hotelinfo.CompareCtripTitle,
                    CompareCtripDesc: hotelinfo.CompareCtripDesc == null ? "": 

hotelinfo.CompareCtripDesc.replace("现金账户", "<a 

href='http://www.elong.com/member/aboutcash.html' target='_blank'>现金账户</a>"),
                    LowPrice: '<a title="' + (this.Language == "CN" ? "点击查看酒店详情": 

"Details") + '" class="right price" href="' + this.detailUrl.eval({
                        hotelid: hotelinfo.HotelId,
                        language: this.Language.toLowerCase()
                    }) + '">' + (this.Language == "CN" ? "": '<span class="l_black 

t12">From</span>') + hotelinfo.LowestPrice + (this.Language == "CN" ? '<span class="l_black t12"> 

起</span>': "") + "</a>",
                    UrlText: '<span class="right"><a target="_blank" class="view" href="' + 

this.detailUrl.eval({
                        hotelid: hotelinfo.HotelId,
                        language: this.Language.toLowerCase()
                    }) + '">' + this.res.SeekBtn + "</a></span>",
                    Address: this.res.Address + hotelinfo.HotelAddres
                });
            }
            var hotel = "";
            if (commendtype == 0) {
                $("#hotelList").empty();
            } else {
                hotel += $("#hotelList").html();
            }
            if (commendhtml != "") {
                hotel_html = commendhtml + hotel_html;
            }
            hotel_html = hotel + hotel_html;
            $("#hotelList").html(hotel_html);
            if (HotelListNewController.PageInfo.TotalRow > 1) {
                this.pageOrderDiv.show();
                this.advancedFilterDiv.show();
            }
        } else {
            if (commendtype == 0) {
                $("#hotelList").empty();
                var comhtml = '<div class="elist clx"><div class="s_bug"  id="hrfUpdateDate"><div 

class="lma">';
                comhtml += '<p class="t14">' + (this.Language == "CN" ? "对不起，未找到符合您搜索条

件的酒店。": "Sorry, there are no hotels available that match all of your search criteria.") + 

"</p>";
                if (this.language == "CN") {
                    comhtml += "<p>不用着急，您可以：</p>";
                }
                comhtml += '<p><a id="editDate" method="update" class="underline" href="#update">' 

+ (this.Language == "CN" ? "重新设置条件进行搜索": "Update the results") + "</a></p>";
                comhtml += '</div><div class="clear"></div></div></div>';
                $("#hotelList").html(comhtml);
                this.pageOrderDiv.hide();
                this.advancedFilterDiv.hide();
            }
        }
        this.editDate = $("#hotelList").find("#editDate");
        if (this.editDate != null) {
            this.editDate.bind("click", this.OnClickeditDate.bindAsEventListener(this));
        }
        FunctionExt.defer(this.LoadHotelListRecentOrder.bind(this), 200);
        this.SearchDataCollect("hotellistasyn");
    },
    rendRoomHtml: function(res, Num, mainhotelid) {
        var room_html = "";
        var intcount = 0;
        for (var j = 0; j < res.HotelRoomSimpleList.length; j++) {
            var item = res.HotelRoomSimpleList[j];
            var classMarket = item.IsCoupon == true ? "icon_quan": item.IsCashback == true ? 

"icon_fan": item.IsPromotion ? "icon_sale_text": "";
            var marketInfo = item.IsCoupon == true ? item.CouponAmount: item.IsCashback == true ? 

item.CashbackAmount: "";
            var roomdisplay = Num == 0 ? intcount > 1 ? "style='display:none;'": "": "";
            room_html = room_html + this.roomTemp.eval({
                RoomName: '<a target="_blank" href="' + this.detailUrl.eval({
                    hotelid: mainhotelid == "" ? res.HotelId: mainhotelid,
                    language: this.Language.toLowerCase()
                }) + (HotelListNewController.WebCategory == "Elong" ? "?roomid=": "&roomid=") + 

item.RoomId + '#room" title="' + item.OrderMsg + '">' + item.RoomName + "</a>",
                Bed: item.Bed,
                Breakfast: item.Breakfast,
                Net: item.Net,
                AvgPrice: "<i>" + item.MoneySymb + "</i>" + item.AvgPrice + "<span style='display:" 

+ (item.IsPrepay == true ? "": "none") + ";' class=\"icon_prepay\" title='" + (this.Language == 

"CN" ? "该房型需要您预先支付房费": "This room type requires a full payment upon booking.") + 

"'></span>",
                roomid: item.RoomId,
                hotelid: mainhotelid == "" ? res.HotelId: mainhotelid,
                rpid: item.RatePlanId,
                classCoupon: classMarket,
                Coupon: marketInfo,
                liRoom: "<li " + roomdisplay + " roomid=" + item.RoomId + " hotelid=" + res.HotelId 

+ " rpid=" + item.RatePlanId + ">",
                Detail: '<a target="_blank" href="' + this.detailUrl.eval({
                    hotelid: mainhotelid == "" ? res.HotelId: mainhotelid,
                    language: this.Language.toLowerCase()
                }) + (HotelListNewController.WebCategory == "Elong" ? "?roomid=": "&roomid=") + 

item.RoomId + '" title="' + item.OrderMsg + '">' + this.res.SeekBtn + "</a>",
                OrderMsg: item.OrderMsg
            });
            intcount = intcount + 1;
        }
        return room_html;
    },
    commendHotel: function(d, c, b) {
        var a = '<div class="elist clx"><div class="s_bug"  id="hrfUpdateDate"><div class="lma">';
        if (c == "Empty") {
            a += '<p class="t14">' + (this.Language == "CN" ? "对不起，未找到符合您搜索条件的酒店。

": "Sorry, there are no hotels available that match all of your search criteria.") + "</p>";
            if (this.language == "CN") {
                a += "<p>不用着急，您可以：</p>";
            }
            a += '<p><a id="editDate" method="update" class="underline" href="#update">' + 

(this.Language == "CN" ? "重新设置条件进行搜索": "Update the results") + "</a></p>";
            if (!Object.isNull(d.value.HotelBasicInfoList)) {
                a += this.Language == "CN" ? "以下是住客反馈比较好的" + 

HotelListNewController.SearchRequestInfo.CityName + "酒店：": "Here are the recommended hotels with 

rooms available.";
            }
        } else {
            if (c == null || c == "Normal") {
                if (!Object.isNull(d.value.HotelBasicInfoList)) {
                    a += "<br />&nbsp;";
                    a += this.Language == "CN" ? "以下是" + 

HotelListNewController.SearchRequestInfo.Keywords + "附近有空余房间的酒店：": "Here are the 

recommended hotels with rooms available.";
                    a += "<br />&nbsp;";
                }
            } else {
                if (c == "IsNotBook") {
                    a += '<p class="t14">对不起，<span class="red">' + 

HotelListNewController.SearchRequestInfo.Keywords + '</span>在 <span class="orange">' + 

HotelListNewController.SearchRequestInfo.CheckInDate.replace(" 0:00", "") + " 至 " + 

HotelListNewController.SearchRequestInfo.CheckOutDate.replace(" 0:00", "") + "</span> 期间期间暂时

不能预订。</p>";
                    if (!Object.isNull(d.value.HotelBasicInfoList)) {
                        a += "<p>不用着急，我们为您找到了" + 

HotelListNewController.SearchRequestInfo.Keywords + "附近可以预订的酒店：</p>";
                    }
                } else {
                    if (c == "Full") {
                        if (this.Language == "CN") {
                            a += '<p class="t14">对不起，<span class="red">' + 

HotelListNewController.SearchRequestInfo.Keywords + '</span>在 <span class="orange">' + 

HotelListNewController.SearchRequestInfo.CheckInDate.replace(" 0:00", "") + " 至 " + 

HotelListNewController.SearchRequestInfo.CheckOutDate.replace(" 0:00", "") + "</span> 期间部分日期

没有空余房间了。</p>";
                            a += "<p>不用着急，您可以：</p>";
                            a += '<p><a id="editDate" method="update" class="underline" 

href="#update">换一下住宿日期，看看' + HotelListNewController.SearchRequestInfo.Keywords + "是否有

空余房间</a></p>";
                        } else {
                            a += "<p>This hotel does not show rooms available during your chosen 

dates.</p>";
                            a += '<p><a id="editDate" method="update" class="underline" 

href="#update">You can try different dates to check room availability again.</a></p>';
                        }
                        if (!Object.isNull(d.value.HotelBasicInfoList)) {
                            a += this.Language == "CN" ? "查看附近有空余房间的酒店：": "Here are 

the nearby hotels with rooms available.";
                        }
                    }
                }
            }
        }
        a += '</div><div class="clear"></div></div></div>';
        this.DrawHotelListPage(d, 1, a);
    },
    OnClickeditDate: function(b) {
        var a = Event.element(b);
        var c = a.attr("method");
        switch (c) {
        case "update":
            new CalendarWindow({
                eventElement:
                this.searchElement.m_preDate,
                selectedDate: this.searchElement.m_preDate.val(),
                language: this.Language,
                onSelected: function(d) {
                    this.searchElement.m_preDate.val(d);
                    this.searchElement.m_preDate.click();
                }.bind(this)
            });
            break;
        }
    },
    setPrice: function(a) {
        if (!Object.isNull(a.attr("mark"))) {
            switch (a.attr("mark")) {
            case "all":
                HotelListNewController.SearchRequestInfo.LowPrice = "0";
                HotelListNewController.SearchRequestInfo.HighPrice = "0";
                break;
            case "150":
                HotelListNewController.SearchRequestInfo.LowPrice = "0";
                HotelListNewController.SearchRequestInfo.HighPrice = "150";
                break;
            case "150-300":
                HotelListNewController.SearchRequestInfo.LowPrice = "150";
                HotelListNewController.SearchRequestInfo.HighPrice = "300";
                break;
            case "300-600":
                HotelListNewController.SearchRequestInfo.LowPrice = "300";
                HotelListNewController.SearchRequestInfo.HighPrice = "600";
                break;
            case "600":
                HotelListNewController.SearchRequestInfo.LowPrice = "600";
                HotelListNewController.SearchRequestInfo.HighPrice = "0";
                break;
            }
        }
    },
    setStar: function(a) {
        if (!Object.isNull(a.attr("mark"))) {
            switch (a.attr("mark")) {
            case "all":
                HotelListNewController.SearchRequestInfo.StarLevel = "None";
                break;
            case "2":
                HotelListNewController.SearchRequestInfo.StarLevel = "2";
                break;
            case "3":
                HotelListNewController.SearchRequestInfo.StarLevel = "3";
                break;
            case "4":
                HotelListNewController.SearchRequestInfo.StarLevel = "4";
                break;
            case "5":
                HotelListNewController.SearchRequestInfo.StarLevel = "5";
                break;
            case "11":
                HotelListNewController.SearchRequestInfo.StarLevel = "11";
                break;
            }
        }
    },
    showLoading: function() {
        strCC = this.divSearch.html();
        var a = new Dialog({
            title: "",
            htmlContent: strCC,
            width: 480,
            initEvent: function(b) {}.bind(this)
        });
        a.show();
        return a;
    },
    checkMoney: function(b, a) {
        if (!validator.valid(b, "notEmpty") || !validator.valid(b, "money")) {
            return false;
        }
        if (!validator.valid(a, "notEmpty") || !validator.valid(a, "money")) {
            return false;
        }
        if (b > a) {
            return false;
        }
        return true;
    },
    clearRow: function(a) {
        a.children().each(function() {
            $(this).removeClass("on");
        });
        return false;
    },
    markRowColumn: function(b) {
        b.parent().addClass("on");
        return false;
    },
    replaceLabel: function(c, b) {
        switch (b) {
        case "locationLabel":
            if (c == HotelListNewController.Resources.All) {
                $("#filterDivLeft:eq(0) li").each(function() {
                    var d = $(this).attr("method");
                    if (!Object.isNull(d) && (d == "locationLabel" || d == b || $(this).attr

("method").toLowerCase() == ("aio" + b.toLowerCase()) || d == "aioPoiLabel")) {
                        $(this).remove();
                    }
                });
            } else {
                var a = false;
                $("#filterDivLeft:eq(0) li").each(function() {
                    var f = $(this).attr("method");
                    if (!Object.isNull(f) && (f == "locationLabel" || f == b || $(this).attr

("method").toLowerCase() == ("aio" + b.toLowerCase()) || f == "aioPoiLabel")) {
                        a = true;
                        $(this).replaceWith("<li method='locationLabel'>" + c + "<a title='" + 

HotelListNewController.Resources.DelThis + "' class='del' href='#?' method='del'></a></li>");
                    }
                    if (f == "aioPoiLabel") {
                        var g = $("#order_ul");
                        g.children().each(function() {
                            $(this).removeClass("on");
                        });
                        var d = g.find("[mark='distinct']").parent();
                        d.addClass("disb");
                        var e = g.find("[mark='elong']").parent();
                        e.addClass("on");
                    }
                });
                if (!a) {
                    $("#filterDivLeft:eq(0)").append('<li method="' + b + '">' + c + '<a href="#?" 

class="del" title="' + HotelListNewController.Resources.DelThis + '" method="del"></a></li>');
                }
            }
            break;
        case "aioPoiLabel":
            if (c == HotelListNewController.Resources.All) {
                $("#filterDivLeft:eq(0) li").each(function() {
                    var d = $(this).attr("method");
                    if (!Object.isNull(d) && (d == "locationLabel" || d == b || $(this).attr

("method").toLowerCase() == ("aio" + b.toLowerCase()) || d == "aioPoiLabel")) {
                        $(this).remove();
                    }
                });
            } else {
                var a = false;
                $("#filterDivLeft:eq(0) li").each(function() {
                    var f = $(this).attr("method");
                    if (!Object.isNull(f) && (f == "locationLabel" || f == "aioLocationLabel" || f 

== b || $(this).attr("method").toLowerCase() == ("aio" + b.toLowerCase()) || f == "aioPoiLabel")) {
                        a = true;
                        $(this).replaceWith("<li method='aioPoiLabel'>" + c + "<a title='" + 

HotelListNewController.Resources.DelThis + "' class='del' href='#?' method='del'></a></li>");
                    }
                    if (f == "aioPoiLabel") {
                        var g = $("#order_ul");
                        g.children().each(function() {
                            $(this).removeClass("on");
                        });
                        var d = g.find("[mark='distinct']").parent();
                        d.addClass("disb");
                        var e = g.find("[mark='elong']").parent();
                        e.addClass("on");
                    }
                });
                if (!a) {
                    $("#filterDivLeft:eq(0)").append('<li method="' + b + '">' + c + '<a href="#?" 

class="del" title="' + HotelListNewController.Resources.DelThis + '" method="del"></a></li>');
                }
            }
            break;
        case "priceLabel":
        case "starLabel":
            if (c == HotelListNewController.Resources.All) {
                $("#filterDivLeft:eq(0) li").each(function() {
                    if (!Object.isNull($(this).attr("method")) && $(this).attr("method") == b) {
                        $(this).remove();
                    }
                });
            } else {
                var a = false;
                $("#filterDivLeft:eq(0) li").each(function() {
                    var d = $(this).attr("method");
                    if (!Object.isNull(d) && (d == b || $(this).attr("method").toLowerCase() == 

("aio" + b.toLowerCase()))) {
                        a = true;
                        $(this).html(c + '<a title="' + HotelListNewController.Resources.DelThis + 

'" class="del" href="#?" method="del"></a>');
                    }
                });
                if (!a) {
                    $("#filterDivLeft:eq(0)").append('<li method="' + b + '">' + c + '<a href="#?" 

class="del" title="' + HotelListNewController.Resources.DelThis + '" method="del"></a></li>');
                }
            }
            break;
        case "bigbedLabel":
        case "doublebedLabel":
        case "couponLabel":
        case "cashbackLabel":
        case "noguaranteeLabel":
            var a = false;
            $("#filterDivLeft:eq(0) li").each(function() {
                if (!Object.isNull($(this).attr("method")) && $(this).attr("method") == b) {
                    a = true;
                    $(this).remove();
                }
            });
            if (!a) {
                $("#filterDivLeft:eq(0)").append('<li method="' + b + '">' + c + '<a href="#?" 

class="del" title="' + HotelListNewController.Resources.DelThis + '" method="del"></a></li>');
            }
            break;
        case "brandLabel":
            if (c == HotelListNewController.Resources.All) {
                $("#filterDivLeft:eq(0) li").each(function() {
                    if (!Object.isNull($(this).attr("method")) && $(this).attr("method") == b) {
                        $(this).remove();
                    }
                });
            } else {
                var a = false;
                $("#filterDivLeft:eq(0) li").each(function() {
                    var d = $(this).attr("method");
                    if (!Object.isNull(d) && (d == b || d == "aioHotelNameLabel" || $(this).attr

("method").toLowerCase() == ("aio" + b.toLowerCase()))) {
                        a = true;
                        $(this).replaceWith("<li method='brandLabel'>" + c + "<a title='" + 

HotelListNewController.Resources.DelThis + "' class='del' href='#?' method='del'></a></li>");
                    }
                });
                if (!a) {
                    $("#filterDivLeft:eq(0)").append('<li method="' + b + '">' + c + '<a href="#?" 

class="del" title="' + HotelListNewController.Resources.DelThis + '" method="del"></a></li>');
                }
            }
            break;
        }
        if ($("#filterDivLeft li").length <= 0) {
            $("#filterConditionHandler").hide();
        }
        return false;
    },
    swthOrderByDistinct: function(d) {
        var c = $("#order_ul");
        var a = c.find("[mark='distinct']").parent();
        c.children().each(function() {
            $(this).removeClass("on");
        });
        if (d == "on") {
            a.removeClass("disb");
            a.addClass("on");
        } else {
            a.removeClass("on");
            a.addClass("disb");
            var b = c.find("[mark='elong']").parent();
            b.addClass("on");
        }
    },
    delAll: function() {
        $("#mainFilterDiv:eq(0) ul").each(function() {
            for (var a = 0; a < $(this).children().length; a++) {
                $(this).children(":eq(" + a + ")").removeClass("on");
            }
            $(this).children(":eq(1)").addClass("on");
        });
        this.advancedFilterDiv.find(":checkbox").each(function() {
            $(this).attr("checked", false);
        });
        $("#filterDivLeft:eq(0)").empty();
        this.lowPrice.attr("value", "");
        this.highPrice.attr("value", "");
        HotelListNewController.SearchRequestInfo.Keywords = "";
        HotelListNewController.SearchRequestInfo.KeywordsType = "None";
        HotelListNewController.SearchRequestInfo.AreaId = "";
        HotelListNewController.SearchRequestInfo.AreaType = "0";
        HotelListNewController.SearchRequestInfo.PoiId = "0";
        HotelListNewController.SearchRequestInfo.LowPrice = "0";
        HotelListNewController.SearchRequestInfo.HighPrice = "0";
        HotelListNewController.SearchRequestInfo.StarLevel = "None";
        HotelListNewController.SearchRequestInfo.BrandId = "0";
        HotelListNewController.SearchRequestInfo.StartLat = "0";
        HotelListNewController.SearchRequestInfo.StartLng = "0";
        HotelListNewController.SearchRequestInfo.EndLat = "0";
        HotelListNewController.SearchRequestInfo.EndLng = "0";
        HotelListNewController.SearchRequestInfo.IsBigBed = false;
        HotelListNewController.SearchRequestInfo.IsDoubleBed = false;
        HotelListNewController.SearchRequestInfo.IsFreeBreakfast = false;
        HotelListNewController.SearchRequestInfo.IsFreeNet = false;
        HotelListNewController.SearchRequestInfo.IsCoupon = false;
        HotelListNewController.SearchRequestInfo.IsCashback = false;
        HotelListNewController.SearchRequestInfo.IsNoGuarantee = false;
        HotelListNewController.SearchRequestInfo.HotelName = "";
        return false;
    },
    initAllInOnedata: function() {
        this.allInOneData.AreaId = "",
        this.allInOneData.AreaType = "0",
        this.allInOneData.BrandId = "0",
        this.allInOneData.StartLat = "0",
        this.allInOneData.StartLng = "0",
        this.allInOneData.PoiId = "0",
        this.allInOneData.Param = "",
        this.allInOneData.Accept = "-1";
    },
    createAllInOneBox: function() {
        if (!Object.isNull(this.aioWind)) {
            this.aioWind = null;
        }
        var b = HotelListNewController.Language.toLowerCase() == "cn" ? 

"http://hotel.elong.com/keywordssuggest.html": "http://hotel.elong.net/keywordssuggest.html";
        var a = HotelListNewController.Language.toLowerCase() == "cn" ? 

"http://hotel.elong.com/hotsuggest.html": "http://hotel.elong.net/hotsuggest.html";
        this.aioWind = new AiOWindow({
            cityId: this.tempCityId,
            resultNextId: "m_preDate",
            lang: HotelListNewController.Language.toLowerCase(),
            searchUrl: b,
            hotUrl: a,
            eventElement: this.allInOne,
            onSelect: function(d, c) {
                if (!Object.isNull(c.Type) && !Object.isNull(c.Name)) {
                    this.isSelect = true;
                    this.GlobalData = c;
                }
            }.bind(this),
            isJsonp: "1",
            searchWidth: 245
        });
    },
    destroyEvent: function() {
        $(window).unload(this.dispose.bind(this));
    },
    OnClickhrfBrowse: function(a) {
        Globals.cookie("Elong.Hotel.Channel.HotelCookie", HotelListNewController.Language, "");
        $("#divBrowse").html("");
    },
    GetAllAsycHtmlData: function() {
        var c = HotelListNewController.SearchRequestInfo.CityId;
        var a = HotelListNewController.SearchRequestInfo.CheckInDate;
        var b = HotelListNewController.SearchRequestInfo.CheckOutDate;
        var d = HotelListNewController.Language;
        HotelListNewController.GetAsycHtmlData(c, a, b, d,
        function(e) {
            if (e.success) {
                $("#AsycHtmlContainer").html(e.value);
                this.RecentOrdersOfCityContainer.html($("#RecentOrdersOfCityHtml").html());
                this.HistoryBrowseHotelContainer.html($("#HistoryBrowseHotelHtml").html());
                this.hrfBrowse = $("#hrfBrowse");
                this.hrfBrowse.bind("click", this.OnClickhrfBrowse.bindAsEventListener(this));
                this.HotHotelContainer.html($("#HotHotelHtml").html());
            }
            if (HotelListNewController.CampaignId == "") {
                client.GetRealTimeData();
            }
        }.bind(this), false, "GET");
    },
    BrowserCityDataCollect: function() {
        try {
            var b = "http://tj.elong.com/hotel/realTimeBrowserData/realTimeCity.gif?

channel=hotel&cityID=" + HotelListNewController.SearchRequestInfo.CityId + "&rn=";
            $("#realTimeCity").remove();
            $("<img id='realTimeCity' width='1' height='1'/>").appendTo($("body"));
            $("#realTimeCity").attr("src", b);
        } catch(a) {}
    },
    SearchDataCollect: function(c) {
        try {
            var b;
            var f;
            var d;
            if (!Object.isNull(this.GlobalData) && !String.isNullOrEmpty(this.GlobalData.Name)) {
                f = encodeURIComponent(this.GlobalData.Name);
            } else {
                f = "";
            }
            if (!String.isNullOrEmpty(HotelListNewController.SearchRequestInfo.Keywords)) {
                d = encodeURIComponent(HotelListNewController.SearchRequestInfo.Keywords);
            } else {
                d = "";
            }
            if (c == "hotellistsearchbutton") {
                b = "http://tj.elong.com/hotel/seachdata/searchdata.gif?channel=hotel&App=" + c + 

"&QueryData=" + f + "&CityId=" + HotelListNewController.SearchRequestInfo.CityId + 

"&LowPrice=&HighPrice=&CheckInDate=" + Globals.cookie("ShHotel", "InDate") + "&CheckOutDate=" + 

Globals.cookie("ShHotel", "OutDate") + 

"&StarLevel=&AreaID=&RegionID=&CommercialID=&SearchArea=&HotelSort=&BrandID=&BrandName=&SearchResul

t=-1&SessionGuid=" + Globals.cookie("SessionGuid") + "&SuggestStatus=" + this.allInOneData.Accept + 

"&CardNo=&rn=";
            } else {
                b = "http://tj.elong.com/hotel/seachdata/searchdata.gif?channel=hotel&App=" + c + 

"&QueryData=" + d + "&CityId=" + HotelListNewController.SearchRequestInfo.CityId + "&LowPrice=" + 

HotelListNewController.SearchRequestInfo.LowPrice + "&HighPrice=" + 

HotelListNewController.SearchRequestInfo.HighPrice + "&CheckInDate=" + 

HotelListNewController.SearchRequestInfo.CheckInDate + "&CheckOutDate=" + 

HotelListNewController.SearchRequestInfo.CheckOutDate + "&StarLevel=" + 

HotelListNewController.SearchRequestInfo.StarLevel + "&AreaID=" + 

HotelListNewController.SearchRequestInfo.AreaId + 

"&RegionID=&CommercialID=&SearchArea=&HotelSort=1&BrandID=" + 

HotelListNewController.SearchRequestInfo.BrandId + "&BrandName=&SearchResult=-1&SessionGuid=" + 

Globals.cookie("SessionGuid") + "&SuggestStatus=" + this.allInOneData.Accept + "&CardNo=" + 

HotelListNewController.SearchRequestInfo.CardNo + "&rn=";
            }
            $("#SearchQueryData").remove();
            $("<img src='' id='SearchQueryData' width='1' height='1'/>").appendTo($("body"));
            $("#SearchQueryData").attr("src", b);
        } catch(a) {}
    },
    GetRealTimeData: function() {
        var a = HotelListNewController.SearchRequestInfo.CityId;
        HotelListNewController.GetRealTimeData(a,
        function(d) {
            if (d.success) {
                var c = d.value;
                if (c.TotalCount != "") {
                    $("#RealTimeBrowserData").append(c.TotalCount);
                    var b = new MsnTip();
                }
            }
        }.bind(this), false, "POST");
    },
    getFormElement: function(a, b) {
        var d = new Object();
        for (var c = 0; c < arguments.length; c++) {
            var e = arguments[c];
            e.find("input").each(function() {
                var f = $(this);
                if (!String.isNullOrEmpty(f.attr("method"))) {
                    d[f.attr("method")] = f;
                }
            });
            e.find("select").each(function() {
                var f = $(this);
                if (!String.isNullOrEmpty(f.attr("method"))) {
                    d[f.attr("method")] = f;
                }
            });
        }
        return d;
    },
    render: function() {
        if (this.Language.toLowerCase() == "cn") {
            this.m_city.val(HotelListNewController.CityNameCN);
            this.m_city.attr("cityid", HotelListNewController.SearchRequestInfo.CityId);
            this.m_city.attr("cityname", HotelListNewController.CityNameEN);
        } else {
            this.m_city.val(HotelListNewController.CityNameEN);
            this.m_city.attr("cityid", HotelListNewController.SearchRequestInfo.CityId);
            this.m_city.attr("cityname", HotelListNewController.CityNameEN);
        }
        this.writeHotelCookie();
        new CityWindow({
            eventElement: this.m_city,
            cityType: "hotel",
            lang: HotelListNewController.SearchRequestInfo.Language,
            resultNextId: "m_preDate",
            onSelect: function(b, a) {
                if (!Object.isNull(a.CityId)) {
                    this.CityName = HotelListNewController.SearchRequestInfo.Language.toLowerCase() 

== "cn" ? a.CityNameCn: a.CityNameEn;
                    this.CityNameCn = a.CityNameCn;
                    this.CityNameEn = a.CityNameEn;
                    this.tempCityId = a.CityId;
                    this.createAllInOneBox();
                    this.allInOne.attr("value", HotelListNewController.Resources.AllInOne);
                }
            }.bind(this)
        });
        this.GetAllAsycHtmlData();
        FunctionExt.defer(this.createAllInOneBox.bind(this), 350);
        this.CreateAndSaveSearchGuid(null);
        this.HotelSearchTrigger(this.SearchRequestInfo);
        this.GetHotelRoom();
        this.BrowserCityDataCollect();
    },
    GetHotelRoom: function() {
        if (Object.isNull(this.HotelRoomInfo) && !Object.isNull(HotelListNewController.CacheKey)) {
            HotelListNewController.GetHotelRoomJson(HotelListNewController.CacheKey,
            function(c) {
                if (c.success) {
                    this.HotelRoomInfo = c.value.HotelRoom;
                    HotelListNewController.CacheKey = null;
                    this.LoadHotelListRecentOrder();
                    var a = "";
                    var b = "";
                    if (HotelListNewController.PageInfo.TotalRow == 1) {
                        a = HotelListNewController.HotelId;
                        b = HotelListNewController.HotelName;
                    }
                    if ((HotelListNewController.PageInfo == null || 

HotelListNewController.PageInfo.TotalRow < 2) && HotelListNewController.SearchRequestInfo.ListType 

== "Common") {
                        if (HotelListNewController.HotelLat != "0.000000000") {
                            HotelListNewController.GetRecommendHotel

(HotelListNewController.SearchRequestInfo, HotelListNewController.HotelLat, 

HotelListNewController.HotelLng, a, b,
                            function(d) {
                                if (d.success) {
                                    this.commendHotel(d, HotelListNewController.HotelStatus, 

HotelListNewController.SearchRequestInfo.HotelName);
                                }
                            }.bind(this), false, "POST");
                        }
                    }
                }
            }.bind(this));
        }
    },
    SetSearchReqstInfo: function(b, a) {
        var c = "";
        HotelListNewController.SearchRequestInfo.PageIndex = 1;
        var d = this.allInOne.val();
        if (a.Name != "") {
            b.Keywords = a.Name;
            b.KeywordsType = a.Type;
            c += "q=" + encodeURIComponent(a.Name) + "&qt=" + a.Type;
        } else {
            b.Keywords = "";
            b.KeywordsType = "0";
        }
        switch (a.Type) {
        case 1:
        case 2:
        case 4:
        case 99:
            this.resetRequestInfo(b, a);
            b.PoiId = a.PropertiesId;
            HotelListNewController.SearchRequestInfo.HotelSort = 6;
            if (!Object.isNull(b.PoiId) && b.PoiId != "0") {
                c += (c == "" ? "": "&") + "PoiId=" + a.PropertiesId;
            }
            if (a.Lat != "" && a.Lng != "") {
                b.StartLat = a.Lat;
                b.StartLng = a.Lng;
                c += (c == "" ? "": "&") + "StartLat=" + a.Lat + "&StartLng=" + a.Lng;
            }
            c += (c == "" ? "": "&") + "hotelsort=6";
            break;
        case 3:
            b.StartLat = 0;
            b.StartLng = 0;
            this.resetRequestInfo(b, a);
            b.AreaId = a.PropertiesId;
            b.AreaType = "1";
            c += (c == "" ? "": "&") + "AreaId=" + a.PropertiesId + "&AreaType=1";
            break;
        case 5:
            this.resetRequestInfo(b, a);
            b.BrandId = a.PropertiesId;
            c += (c == "" ? "": "&") + "BrandId=" + a.PropertiesId;
            break;
        case 6:
            this.resetRequestInfo(b, a);
            b.AreaId = a.PropertiesId;
            b.AreaType = "2";
            c += (c == "" ? "": "&") + "AreaId=" + a.PropertiesId + "&AreaType=2";
            break;
        case 9:
            this.resetRequestInfo(b, a);
            break;
        case - 1 : break;
        }
        if (HotelListNewController.SearchRequestInfo.ListType != "Common" && 

HotelListNewController.SearchRequestInfo.ListType != 1 && 

HotelListNewController.SearchRequestInfo.ListType != "1") {
            c += (c == "" ? "": "&") + "ListType=" + 

HotelListNewController.SearchRequestInfo.ListType;
        }
        return c;
    },
    resetRequestInfo: function(b, a) {
        switch (a.Type) {
        case 1:
        case 2:
        case 4:
        case 99:
        case 3:
        case 6:
            b.HotelSort = "1";
            b.PoiId = "";
            b.AreaId = "";
            b.AreaType = "";
            break;
        case 5:
        case 9:
            b.HotelSort = "1";
            b.BrandId = "";
            b.HotelName = "";
            break;
        }
    },
    dispose: function() {
        this.destroyEvent();
        this.destroyDOM();
    }
});
var client = null;
$ready(function() {
    client = new HotelListClient();
});
var MsnTip = Elong.Page.MsnTip;
MsnTip = Class.create();
Object.extend(MsnTip.prototype, {
    name: "msnTip",
    html: "",
    options: {},
    initialize: function(a) {
        Object.extend(Object.extend(this, this.options), a);
        this.initializeDOM();
        this.initializeEvent();
        this.render();
    },
    initializeDOM: function() {
        this.windowElement = $("#RealTimeBrowserDataContainer");
        this.closeElement = $("#hrefRealTimeBrowserDataClose");
    },
    destroyDOM: function() {},
    initializeEvent: function() {
        $(window).bind("scroll", this.onWindowScroll.bindAsEventListener(this));
        $(window).bind("resize", this.onWindowResize.bindAsEventListener(this));
        this.closeElement.bind("click", this.HidTooltip.bindAsEventListener(this));
    },
    HidTooltip: function() {
        this.windowElement.fadeOut(500);
    },
    onWindowScroll: function() {
        var d = Globals.browserDimensions();
        var c = Globals.getScrollPosition();
        var b = d.height + c.y - this.windowElement.height() - 10;
        var a = $(document).height() - 10;
        if (b > a) {
            $("#RealTimeBrowserDataContainer")[0].style.top = a + "px";
        } else {
            $("#RealTimeBrowserDataContainer")[0].style.top = b + "px";
        }
    },
    onWindowResize: function() {
        var d = Globals.browserDimensions();
        var c = Globals.getScrollPosition();
        var b = d.height + c.y - this.windowElement.height() - 10;
        var a = $(document).height();
        if (b > a) {
            $("#RealTimeBrowserDataContainer")[0].style.top = (a - 10) + "px";
        } else {
            $("#RealTimeBrowserDataContainer")[0].style.top = b + "px";
        }
    },
    destroyEvent: function() {
        $(window).unbind("scroll", this.onWindowScroll);
        $(window).unbind("resize", this.onWindowResize);
    },
    render: function() {
        var e = Globals.browserDimensions();
        var c = e.width - this.windowElement.width() - 10;
        var d = Globals.getScrollPosition();
        var a = $(document).height();
        var b = e.height + d.y;
        this.windowElement[0].style.top = b + "px";
        this.ie6FilterIFrame = Globals.addIE6Filter(this.windowElement.width(), 

this.windowElement.height(), c, top);
        this.windowElement.show();
        this.windowElement.animate({
            top: b - this.windowElement.height() - 10
        },
        1000);
        this.showTimer = FunctionExt.defer(function() {
            $("#RealTimeBrowserDataContainer").fadeOut(1000);
            clearTimeout(this.showTimer);
            this.showTimer = null;
        },
        10000, this);
    },
    dispose: function() {
        this.destroyEvent();
    }
});