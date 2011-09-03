/*
 * maker.js
 * Copyright (c) 2011 Daniel Rodriguez, dan@tuitpix.com
 * MIT License [http://www.opensource.org/licenses/mit-license.php]
 */


var tuitpix = {
    canv: null,
    cont: null,
    contm: false,
    mdown: false,
    mouse: { x:0, y:0 },
    active: "gen",
    matrix: [],
    can: function (id) {
        for (var i = 0; i <= 1849; i++) this.matrix.push(0);
        // console.debug(this.matrix);
        this.canv = document.getElementById(id);
        this.cont = this.canv.getContext("2d");
    },
    setNext: function () {
    },
    setPrev: function () {
    },
}

tuitpix.clear = function () {
    this.cont.clearRect(0,0,this.canv.width,this.canv.height);
    this.matrix = Array();
    for (var i = 0; i <= 1849; i++) this.matrix.push(0);
}

tuitpix.tool = 0;
tuitpix.draw = function (M,json) {
    if (!M) return;
    if ($("#loading").css("display") !== "none") $("#loading").fadeOut(140);
    if (M == "json" && json) {
        for (j in json) tuitpix.draw(json[j],1);
    }
    else {
        for (m in M[1]) {
            var width = 7, height = 7;
            if (M[1][m].length) {
                var Mm = M[1][m];
                if (!json && this.looking) {
                    var e = Mm[0]/43,
                        e = parseInt(((e.toString()).split("."))[0]);
                    Mm[0] = (43*(e+1) - (Mm[0]-43*e))-1;
                } 
                width = Mm[1] * 7;
                var l = (!json && this.looking)? -1 : 1 ;
                if (Mm[2]) height = Mm[2] * 7;
                for (var x = 0; x < Mm[1]; x++) {
                    tuitpix.matrix[Mm[0] + x*l] = (this.tool)? undefined : M[0];
                    for (var y = 1; y < Mm[2]; y++) {
                        tuitpix.matrix[Mm[0] + x*l + 43 * y] = (this.tool)? undefined : M[0];
                    }
                }
                Mm = Mm[0];
            }
            else Mm = M[1][m];
            var posy = Mm/43,
                pyrn = Math.round(posy),
                posx = Mm - (43*pyrn);
            posx = ((posx < 0)? 43 + posx : posx ) * 7;
            posy = (pyrn - ((posy < pyrn)? 1 : 0)) * 7;
            if (this.looking) {
                posx = this.canv.width - posx;
                width *= -1;
            }
            if (!this.tool) {
                this.cont.fillStyle = M[0] || "#FF0000";
                this.cont.fillRect(posx, posy, width, height);
            }
            else {
                this.cont.clearRect(posx, posy, width, height);
            }
        }
    }
}

tuitpix.setTool = function (which) {
    var which = $(which);
    if (which.attr("class") === "inuse") return;
    var inuse = document.getElementsByClassName("inuse");
    $(inuse[0]).attr("class","");
    var id = which.attr("id");
    if (id === "img_brsh") {
        this.tool = 0;
        $(".color_maker").fadeIn(140);
    } else {
        this.tool = 1;
        $(".color_maker").fadeOut(140);
    }
    which.attr("class","inuse");
}

tuitpix.drawJSON = function () {
    this.clear();
    tuitpix.draw("json",$.parseJSON(prompt("( >°□°)> < Gimme your JSONs!")));
}

tuitpix.setActive = function (which) {
    if (!tuitpix.USER) {
        $.ajax({
            url: "js/on/maker.json",
            dataType: 'json',
            success: function(json) {
                tuitpix.draw("json",json);
            }
        });
        return;
    }
    var which = $(which);
    if ($("#loading").css("display") !== "none") setTimeout("tuitpix.setActive("+which+")",140);
    $("#left_menu .active").attr("class","");
    var id = ((which.attr("id")).split("_"))[1];
    this.active = id;
    tuitpix.setTool("#img_brsh");
    which.attr("class","active");
    this.clear();
    $("#loading").fadeIn(140);
    tuitpix.loading();
    if (LOAD !== null) LOAD = null;
    $.ajax({
        type: "POST",
        url: "s/load.php",
        data: "active="+this.active,
        success: function(json) {
            var json = (json)? ($.parseJSON(json))[0] : {};
            if (json[tuitpix.active]) {
                if (json["sex"] !== undefined) {
                    tuitpix.gender = !parseInt(json["sex"]);
                    tuitpix.setGender();
                }
                if (json["looking"] !== undefined) {
                    tuitpix.looking = parseInt(json["looking"]);
                    if (json["looking"] == "1") $("#maker").css("background-image","url(img/makerbg_left.png)");
                }
                var hex = tuitpix.decodeFromHex(json[tuitpix.active]);
                if (hex.length < 7) hex = "{[]}";
                tuitpix.draw("json",jsonParse(hex));
            } else {
                $.ajax({
                    type: "POST",
                    url: "s/load.php",
                    data: "active="+tuitpix.active+"&of=index",
                    success: function(json) {
                        var json = ($.parseJSON(json))[0],
                            hex = tuitpix.decodeFromHex(json[tuitpix.active]);
                        if (hex.length < 7) hex = "{[]}";
                        tuitpix.draw("json",jsonParse(hex));
                    }
                });
            }
        }
    });
}

tuitpix.gender = 0;
tuitpix.setGender = function () {
    if (this.gender) {
        $("#maker").css({ backgroundPosition: "0px 0px"})
        $("#img_girl").attr({
            id: "img_boy"
        });
        this.gender = 0;
    } else {
        $("#maker").css({ backgroundPosition: "-301px 0px"})
        $("#img_boy").attr({
            id: "img_girl"
        });
        this.gender = 1;
    }
}

tuitpix.color = null;
tuitpix.changeColor = function (newColor) {
    this.color = newColor;
};

tuitpix.RGBtoHex = function (R,G,B) {
    return this.toHex(R)+this.toHex(G)+this.toHex(B)
}
tuitpix.toHex = function (N) {
    if (N===null) return "00";
    N=parseInt(N); if (N===0 || isNaN(N)) return "00";
    N=Math.max(0,N); N=Math.min(N,255); N=Math.round(N);
    return "0123456789ABCDEF".charAt((N-N%16)/16)
         + "0123456789ABCDEF".charAt(N%16);
}

tuitpix.resetPalette = function () {
    var color = "#0A0A0A";
    tuitpix.color = color;
    $("#colors").attr("value", color).css({
        background: color,
        marginLeft: "0px",
        marginTop: "0px",
    });
}

tuitpix.GO = function (echo) {
    if (!tuitpix.USER && !echo) return;
    var fixd = {};
    for (m in this.matrix) {
        if (this.matrix[m]) {
            if (!fixd[this.matrix[m]]) fixd[this.matrix[m]] = [];
            var fxm = fixd[this.matrix[m]];
            (function (F) {
                if (!F) F = fxm;
                if (!isNaN(F[0])) {
                    for (f in F) arguments.callee(F[f]);
                }
                else {
                    var difx = (F)? Math.abs(F[0] + F[1] - 1 - m) : -1,
                        dify = (F)? Math.abs(F[0] - m) - 43 * (F[2]) : -1;
                    if (difx == 1 && F[2] == 1) {
                        fixd[tuitpix.matrix[m]][fixd[tuitpix.matrix[m]].length - 1][1] += 1;
                    } else
                    if (dify == 0 && F[1] == 1) {
                        fixd[tuitpix.matrix[m]][fixd[tuitpix.matrix[m]].length - 1][2] += 1;
                    } else {
                        fixd[tuitpix.matrix[m]].push([parseInt(m), 1, 1]);
                    }
                }
            })();
        }
    }
    var melt = function (F) {
        var xy = 0;
        while (xy < 2) {
            for (var f = 0; f < F.length; f++) {
                for (var ff = 0; ff < F.length; ff++) {
                    if (ff === f) continue;
                    if (xy == 0) {
                        var subs = F[f][0] + 43 * (F[f][2]) - F[ff][0],
                            x = (F[f][1] === F[ff][1]);
                        if (subs === 0 && x) {
                            F[f][2] += 1;
                            F.splice(ff,1);
                            return melt(F);
                        }
                    } else {
                        if (F[f][1] == 1 && !((F[f][0] + 1)%43)) continue;
                        var near = ((F[f][0] + F[f][1] - F[ff][0]) == 0),
                            y = (F[f][2] === F[ff][2]);
                        if (near && y) {
                            F[f][1] += 1;
                            F.splice(ff,1);
                            return melt(F);
                        }
                    }
                }
            }
            xy++;
        }
        return F;
    }
    for (f in fixd) fixd[f] = melt(fixd[f]);
    var json = "[";
    for (f in fixd) {
        json += " [ \""+f.toUpperCase()+"\", [";
        for (ff in fixd[f]) {
            json += " [";
            for (fff in fixd[f][ff]) {
                json += fixd[f][ff][fff]+",";
            }
            json = json.substring(0, json.length - 1);
            json += "],";
        }
        json = json.substring(0, json.length - 1);
        json += " ] ],\n ";
    }
    json = json.substring(0, json.length - 3);
    json+= "\n]";
    if (echo) return alert(json);
    var data = "";
    data+= this.active+"="+this.encodeToHex(json);
    $.ajax({
        type: "POST",
        url: "s/save.php",
        data: data,
        success: function(ajax) {
            //console.debug(ajax);
            if (!ajax) return;
            tuitpix.help("save");
        }
    });
}

tuitpix.mouse = function (button) {
    var mouse = tuitpix.mouse;
    if (!tuitpix.mouse.offset) tuitpix.mouse.offset = $("#maker").offset();
    if (!mouse.width) {
        tuitpix.mouse.width = $("#maker").css("width");
        tuitpix.mouse.width = parseInt(tuitpix.mouse.width.slice(0,tuitpix.mouse.width.length-2)) + tuitpix.mouse.offset.left + 7;
    }
    if (!mouse.height) {
        tuitpix.mouse.height = $("#maker").css("height");
        tuitpix.mouse.height = parseInt(tuitpix.mouse.height.slice(0,tuitpix.mouse.height.length-2)) + tuitpix.mouse.offset.top + 4;
    }
    mouse = tuitpix.mouse;
    var outRange = (mouse.x > mouse.width || mouse.x < mouse.offset.left || mouse.y > mouse.height || mouse.y < tuitpix.mouse.offset.top);
    if (outRange || !mouse.x || !mouse.y) return;
    if (tuitpix.color_maker_big) {
        $(".color_maker").animate({ width:"28px" }, 140, function() {
            $(".color_maker").css({
                fontSize:"0px",
            });
            tuitpix.color_maker_big = 0;
        });
    }
    mouse.x -= mouse.offset.left;
    mouse.y -= mouse.offset.top;
    if (button === 0 && !this.contm) {
        if (!this.color) this.color = $("#colors").attr("value");
        var brush = [this.color, []],
            pos   = parseInt(((mouse.x-7)/7).toString().split(".")[0]);
        pos += 43 *(parseInt((mouse.y/7).toString().split(".")[0]) - 1);
        brush[1].push([pos,1,1]);
        this.draw(brush);
    } else
    if (button === 2) {
        var color = tuitpix.cont.getImageData(mouse.x - 7, mouse.y - 7, 1, 1).data;
            color = tuitpix.RGBtoHex(color[0], color[1], color[2]);
        document.getElementById("colors").color.fromString("#"+color);
        tuitpix.color = "#"+color;
        $("#colors").attr("value", "#"+color);
        return false;
    }
};

window.onload = function () {
    
    tuitpix.can ("maker");
    $("#maker").css("background-image","url(img/makerbg.png)");
    tuitpix.setActive("#img_gen");
    
    $(".color_maker").click(function() {
        $(this).animate({ width:"63px" }, 140, function() {
            $(this).css({
                fontSize:"14px",
                position:"relative",
            });
            tuitpix.color_maker_big = 1;
        });
    });
    
    document.onmousemove = function (e) {
        var X = (document.all && event.clientX)? event.clientX +
            (document.documentElement.scrollLeft || document.body.scrollLeft) :
            (e.pageX)? e.pageX : null;
        var Y = (document.all && event.clientY)? event.clientY +
            (document.documentElement.scrollTop || document.body.scrollTop) :
            (e.pageY)? e.pageY : null;
        tuitpix.mouse.x = X;
        tuitpix.mouse.y = Y;
        if (tuitpix.mdown) tuitpix.mouse(0);
    };
    
    document.onclick = function (e) {
        if (e.button !== 0) return;
        tuitpix.mouse(e.button);        
    }

    document.onmousedown = function (e) {
        tuitpix.mdown = true;
    }
    document.onmouseup = function (e) {
        tuitpix.mdown = false;
    }
    
    document.oncontextmenu = function (e) {
        tuitpix.mouse(e.button);
        return false;
    }
    
    document.onkeypress = function (e) {
        if (e.charCode == 98 ) tuitpix.setTool("#img_brsh");
        else
        if (e.charCode == 101) tuitpix.setTool("#img_ersr");
    }
};