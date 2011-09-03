/*
 * env.tuitpix.js
 * Copyright (c) 2011 Daniel Rodriguez, dan@tuitpix.com
 * MIT License [http://www.opensource.org/licenses/mit-license.php]
 */
/*
 * tuitpix_other.js
 * Copyright (c) 2011 Daniel Rodriguez, dan@tuitpix.com
 * MIT License [http://www.opensource.org/licenses/mit-license.php]
 */

tuitpix.encodeToHex = function(str){
    var r="";
    var e=str.length;
    var c=0;
    var h;
    while(c<e){
        h=str.charCodeAt(c++).toString(16);
        while(h.length<3) h="0"+h;
        r+=h;
    }
    return r;
}
tuitpix.decodeFromHex = function(str){
    var r="";
    var e=str.length;
    var s;
    while(e>=0){
        s=e-3;
        r=String.fromCharCode("0x"+str.substring(s,e))+r;
        e=s;
    }
    return r;
}

/*
 * widgets.js
 * Copyright (c) 2011 Daniel Rodriguez, dan@tuitpix.com
 * MIT License [http://www.opensource.org/licenses/mit-license.php]
 */

tuitpix.widgets = {
    submenu: false,
    sublogin: false,
    help: false
}

/* MENU */
$("#menu").hover( function() {
    if (!tuitpix.widgets.submenu) $("#menu").css({ backgroundPosition: "0px 0px" });
}, function() {
    if (!tuitpix.widgets.submenu) $("#menu").css({ backgroundPosition: "0px -49px" });
});
$("#menu").click( function() {
    $("#menu").css({ backgroundPosition: "-49px 0px" });
    $("#submenu").fadeIn(140);
    tuitpix.widgets.submenu = true;
});

/* OUT OF WIDGETS */
$("body").mouseup( function() {
    if (tuitpix.widgets.submenu) {
        $("#menu").css({ backgroundPosition: "0px -49px" });
        $("#submenu").fadeOut(140);
        tuitpix.widgets.submenu = false;
    }
    if (tuitpix.widgets.help) {
        if (tuitpix._help.STOP) tuitpix._help.STOP = 0;
        $("#help").fadeOut(140);
        tuitpix.widgets.help = false;
        tuitpix._help.current = false;
    }
    if (!tuitpix.USER) tuitpix.help("tw_login");
});

/* SET TO TWITTER */
$('#img_totw').hover(
    function() {
        $('#img_totw').css({
            backgroundPosition: "-42px -245px"
        });
    },
    function() {
        $('#img_totw').css({
            backgroundPosition: "0px -245px"
        });
    }
);

/*
 * loading.js
 * Copyright (c) 2011 Daniel Rodriguez, dan@tuitpix.com
 * MIT License [http://www.opensource.org/licenses/mit-license.php]
 */

tuitpix._loading = {
    current: 0,
    map: [ "7px 7px", "0px 14px", "-7px 7px", "0px 0px"]
};

tuitpix.loading = function () {
    var div = $("#loading");
    div.animate({ backgroundPosition: "0px 0px" }, 0);
    if (div.css("display") !== "none") {
        div.animate({ backgroundPosition: this._loading.map[this._loading.current] }, 0,
            function () {
                setTimeout( function () {
                    tuitpix.loading();
                }, 140 );
            }
        );
    }
    this._loading.current = (this._loading.map.length == this._loading.current + 1) ? 0 : this._loading.current + 1;
};

tuitpix.loading();

/*
 * helper.js
 * Copyright (c) 2011 Daniel Rodriguez, dan@tuitpix.com
 * MIT License [http://www.opensource.org/licenses/mit-license.php]
 */

tuitpix._help = { current: "", renable: 0, STOP: 0, eng: {}, esp: {} };
tuitpix.help = function (id) {
    var about = id || "default";
    if (this._help.current == about || this._help.STOP) return;
    else this._help.current = about;
    $("#help_text").html("");
    if (this._help[this.LANG][about]) {
        $("#help_text").html(this._help[this.LANG][about]);
    } else {
        $.get("help/"+this.LANG+"_"+this.location+"_"+about+".html", function(data) {
            if (tuitpix.USER) {
                data = data.replace(/\[user\]/g, tuitpix.USER);
            }
            $("#help_text").html(data);
            tuitpix._help[tuitpix.LANG][about] = data;
        });
    }
    if (about == "save" || id == "default") {
        this._help.STOP = 1;
        setTimeout("tuitpix._help.STOP = 0", 7000);
    }
    if (id && id != "default") {
        if (id == "save" || id == "load") id = "img_save";
        var halfwindow = (document.body.offsetWidth || document.documentElement.offsetWidth || window.innerWidth)/2,
            offset = $("#"+id).offset();
        $('#help').css({
            left: Math.abs(offset.left/7)*7 + ((offset.left > halfwindow)? 56 : -210) + ((id == "tw_login")? -21 : 0),
            top: offset.top + ((id == "tw_login")? 7 : 0),
            width: "203px",
            height: "auto",
            textAlign:"center"
        })
    } else {
        var offset = ($("#avatar").offset())? $("#avatar").offset() : $("#maker").offset();
        $('#help').css({
            left: offset.left,
            top: offset.top,
            width:"315px",
            height:"315px",
            textAlign:"justify"
        })
    }
    $("#help").fadeIn(140);
    this.widgets.help = true;
    //tuitpix.alarm();
}

$(" #img_gen, #img_hair, #img_beard, #img_wear, #img_addon, #img_down, #img_save, #img_boy, #img_brsh, #img_ersr, #controls, #avatar, #maker, #header h1, #tw_save, #tw_login, #tw_logout ")
.mouseover( function() { tuitpix.help(this.id) } );

$('#flag_vzla').click( function () {
    if (tuitpix.LANG == "esp") return;
    $.get('s/lang.php',{ lang: "esp" });
    $("#flag_engl").attr("class","");
    $("#flag_vzla").attr("class","active");
    tuitpix.LANG = "esp";
});
$('#flag_engl').click( function () {
    if (tuitpix.LANG == "eng") return;
    $.get('s/lang.php',{ lang: "eng" });
    $("#flag_vzla").attr("class","");
    $("#flag_engl").attr("class","active");
    tuitpix.LANG = "eng";
});

$('#tw_login').click( function () {
    window.location = "?authorize=1&amp;force_write=1";
});
$('#tw_logout').click( function () {
    window.location = "?wipe=1";
});

tuitpix.LOAD = function (json, afterload) {
    if (json) {
        if (this.location == "index") {
            this.looking = (parseInt(json[1]))? true : false;
            var sex = parseInt(json[2]);
            for (s in this.set) {
                this.conf[s] = 0;
                if (json[s] === undefined) continue;
                if (s == "gen") {
                    var hex = this.decodeFromHex(json[s]);
                    if (hex.length < 7) hex = "[]";
                    this.set[s][sex][0] = jsonParse(hex);
                } else {
                    var hex = this.decodeFromHex(json[s]);
                    if (hex.length < 7) hex = "[]";
                    hex = jsonParse(hex);
                    this.set[s].unshift(["saved",[[hex],[hex]]]);
                }
            }
            this.Set();
            this.redraw();
            if (sex) this.setNext();
        }
        this.help("load");
        this.LOAD(0, 1);
    } else 
    if (afterload) {
        for (s in this.set) {
            if (s == "gen") continue;
            $.ajax({
                type: "POST",
                url: "s/load.php",
                data: "active="+s,
                success: function(json) {
                    var json = (json)? ($.parseJSON(json))[0] : {};
                    for (s in tuitpix.set) {
                        if (!json[s]) continue;
                        var hex = tuitpix.decodeFromHex(json[s]);
                        if (hex.length < 7) hex = "[]";
                        hex = jsonParse(hex);
                        tuitpix.set[s].push(["loaded",[[hex],[hex]]]);
                    }
                }
            });
        }
    }
}

tuitpix.SAVE = function (twitter) {
    var xhr = new XMLHttpRequest(),
        fileUpload = xhr.upload,
        self = this,
        boundary = 'multipartformboundary'+(new Date).getTime();
    fileUpload.addEventListener("load", function(ajax){
        if (!ajax) return;
        tuitpix.help("save",1);
    }, false);

    xhr.open("POST", "s/save.php", true);
    xhr.setRequestHeader('content-type', 'multipart/form-data; boundary='+ boundary);

    builder = '--'+boundary+'\r\nContent-Disposition: form-data; name="image"; filename="tuitpix.png"\r\nContent-Type: image/png\r\n\r\n'; 
    builder += (this.canv.toDataURL('image/png').split(","))[1];

    builder += '\r\n--'+boundary+'\r\nContent-Disposition: form-data; name="twitter"\r\n\r\n'+((twitter)? "1" : "0");

    builder += '\r\n--'+boundary+'\r\nContent-Disposition: form-data; name="looking"\r\n\r\n'+((this.looking)? "1" : "0");

    var set = this.set,
        conf = this.conf;
    var sex = 0;
    for (c in set) {
        var json = "[",
            obj = null;
        if (c == "gen") {
            builder += '\r\n--'+boundary+'\r\nContent-Disposition: form-data; name="sex"\r\n\r\n'+conf[c];
            sex = conf[c];
            obj = set[c][sex][0];
        } else {
            obj = set[c][this.cats[c]][1][sex][conf[c]];
        }
        if (obj.length) {
            for (o in obj) {
                if (!obj[o][0]) continue;
                json += "[\""+obj[o][0].toUpperCase()+"\",[";
                for (oo in obj[o][1]) {
                    json += "[";
                    for (ooo in obj[o][1][oo]) {
                        json += obj[o][1][oo][ooo]+",";
                    }
                    json = json.substring(0, json.length - 1);
                    json += "],";
                }
                json = json.substring(0, json.length - 1);
                json += "]],";
            }
        }
        else json += " ";
        json = json.substring(0, json.length - 1);
        json += "]";
        builder += '\r\n--'+boundary+'\r\nContent-Disposition: form-data; name="'+c+'"\r\n\r\n'+this.encodeToHex(json);
    }
    builder += '\r\n--'+boundary+'\r\nContent-Disposition: form-data; name="img"\r\n\r\n'+this.canv.toDataURL();

    builder += '\r\n--'+boundary+'--\r\n';
    xhr.send(builder);
}

