/*
 * tuitpix.js
 * Copyright (c) 2011 Daniel Rodriguez, dan@tuitpix.com
 * MIT License [http://www.opensource.org/licenses/mit-license.php]
 */

var tuitpix = {
    canv: null,
    cont: null,
    contm: false,
    _skin: 0,
    skins: [
        [ "#DAC49E", "#AF9D7E", "#9E8860" ],
        [ "#AD8B62", "#806748", "#231e1b" ],
        [ "#CDA57B", "#B8946E", "#3E2115" ],
        [ "#EEC9A2", "#C9A988", "#B87A38" ],
        [ "#3C332B", "#302C28", "#212121" ]
    ],
    peep: {
        gen: [],
        wear: [], 
        hair: [],
        beard: [],
        addon: []
    },
    mouse: { x:0, y:0 },
    can: function (id) {
        this.canv = document.getElementById(id);
        this.cont = this.canv.getContext("2d");
    },
    active: "gen",
    conf: { gen: 0, hair: 0, beard: 0, wear: 0, addon: 0 },
    cats: { hair: 0, beard: 0, wear: 0, addon: 0 },
    set: null,
    Set: function (set,LOAD) {
        if (set) this.set = set;
        for (i in this.peep) {
            if (!this.set || !this.set[i]) continue;
            if (i === "gen") this.peep[i] = this.set[i][this.conf[i]][0];
            else {
                if (this.set[i][this.cats[i]].length <= 1) {
                    $("#loading").fadeIn();
                    this.loading();
                    return $.getJSON("js/on/"+i+"_"+this.set[i][this.cats[i]][0]+".json",
                        function(json) {
                            $("#loading").fadeOut();
                            tuitpix._help.current = "";
                            tuitpix.help("controls");
                            tuitpix.set[i][tuitpix.cats[i]][1] = json;
                            return tuitpix.Set(0,LOAD);
                        }
                    );
                } else {
                    this._help.current = "";
                    this.help("controls");
                    var setconf = this.set[i][this.cats[i]][1][this.conf.gen];
                    this.peep[i] = (setconf[this.conf[i]])? setconf[this.conf[i]] : setconf[setconf.length-1];
                }
            }
        }
        this.redraw();
        if (LOAD) return tuitpix.LOAD(LOAD);
    },
    setNext: function () {
        var div = $("#loading");
        if (!this.set[this.active] || (div && div.css("display") !== "none")) return;
        var set = (this.active === "gen")? this.set[this.active] : this.set[this.active][this.cats[this.active]][1][this.conf["gen"]],
            conf = this.conf[this.active];
        if (!set) return;
        this.conf[this.active] = (set[conf + 1])? conf + 1 : 0;
        this.Set();
        this.resetPalette();
    },
    setPrev: function () {
        var div = $("#loading");
        if (!this.set[this.active] || (div && div.css("display") !== "none")) return;
        var set = (this.active === "gen")? this.set[this.active] : this.set[this.active][this.cats[this.active]][1][this.conf["gen"]],
            conf = this.conf[this.active];
        if (!set) return;
        this.conf[this.active] = (set[conf - 1])? conf - 1 : set.length -1;
        this.Set();
        this.resetPalette();
    },
    setCat: function (v) {
        var div = $("#loading");
        if (div && div.css("display") !== "none") return;
        if (v > 0) this.cats[this.active] = (this.cats[this.active]+v == this.set[this.active].length)? 0 : this.cats[this.active] + v;
        if (v < 0) this.cats[this.active] = (this.cats[this.active] == 0)? this.set[this.active].length-1 : this.cats[this.active] + v;
        this.Set();
    },
    looking: null,
    look: function (where) {
        this.looking = where;
        this.resetPalette();
        this.redraw();
    },
    setSkin: function(v) {
        if (v > 0) this._skin = (this._skin+v == this.skins.length)? 0 : this._skin + v;
        if (v < 0) this._skin = (this._skin == 0)? this.skins.length-1 : this._skin + v;
        for (i in this.skins[0]) {
            this.active= (i < 2)? "gen" : "hair";
            this.color = (i < 2)? this.set["gen"][this.conf["gen"]][0][i][0] : this.set["hair"][this.cats["hair"]][1][this.conf["gen"]][0][0][0];
            this.changeColor(this.skins[this._skin][i]);
        }
        this.active = "gen";
        this.resetPalette();
    }
}

tuitpix.redraw = function () {
    this.clear();
    this.draw();
}
tuitpix.clear = function (M) {
    this.cont.clearRect(0,0,this.canv.width,this.canv.height);
}
tuitpix.draw = function (M) {
    if (!M) {
        for (p in this.peep) this.draw(this.peep[p]);
    }
    else if (typeof(M[0]) !== "string") {
        for (m in M) this.draw(M[m]);
    } else {
        for (m in M[1]) {
            var width = 7, height = 7;
            if (M[1][m].length) {
                Mm = M[1][m];
                width = Mm[1] * 7;
                if (Mm[2]) height = Mm[2] * 7;
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
            this.cont.fillStyle = M[0] || "#FF0000";
            this.cont.fillRect(posx, posy, width, height);
        }
    }
}

tuitpix.color = null;
tuitpix.changeColor = function (newColor,url) {
    if (!newColor || !this.color) return;
    var newColor = newColor.toUpperCase(),
        set = this.set,
        a = this.active,
        c = this.cats[a],
        f = this.conf[a];
    if (a == "gen") {
    for (s in set[a]) for (ss in set[a][s][0])
        if (set[a][s][0][ss][0] === this.color) this.set[a][s][0][ss][0] = newColor;
    } else {
    for (s in set[a][c][1]) for (ss in set[a][c][1][s][f])
        if (set[a][c][1][s][f][ss][0] === this.color) this.set[a][c][1][s][f][ss][0] = newColor;
    }
    if (url) return;
    this.Set();
    this.draw();
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
    this.color = color;
    $("#colors").attr("value", color).css({
        background: color,
        marginLeft: "0px",
        marginTop: "0px",
    });
}

tuitpix.setControls = function (which) {
    var which = $(which);
    if (which.attr("class") === "active") return;
    $("#left_menu .active").attr("class","");
    var id = which.attr("id"),
        offset = $("#"+id).offset();
    $("#controls #main, #controls #sub").css({ marginTop: offset.top - 63 });
    if (id === "img_gen") {
        $("#controls #subsub").fadeIn(140);
        $("#controls #sub #arrow_left").attr("onClick","tuitpix.look(true)");
        $("#controls #sub #arrow_right").attr("onClick","tuitpix.look(false)");
    } else {
        $("#controls #subsub").fadeOut(0);
        $("#controls #sub #arrow_left").attr("onClick","tuitpix.setCat(-1)");
        $("#controls #sub #arrow_right").attr("onClick","tuitpix.setCat(1)");
    }
    id = (id.split("_"))[1];
    this.active = id;
    which.attr("class","active");
    /* the arrows */
}

tuitpix.READY = function () {
    window.open(this.canv.toDataURL('image/png'));
}


window.onload = function () {
    
    tuitpix.can("avatar");
    
    $.ajax({
        url: "js/on/_tuitpix.json",
        dataType: 'json',
        success: function(json) {
            $("#loading").fadeOut();
            tuitpix.Set(json || "[]",LOAD);
            return;
        }
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
    };
    
    document.oncontextmenu = function (e) {
        if(e.button !== 2) return;
        var mouse = tuitpix.mouse,
            offset = $("#avatar").offset(),
            width = $("#avatar").css("width"),
            width = parseInt(width.slice(0,width.length-2)) + offset.left,
            height = $("#avatar").css("height");
            height = parseInt(height.slice(0,height.length-2)) + offset.top;
        var outRange = (mouse.x > width || mouse.x < offset.left || mouse.y > height || mouse.y < offset.top);
        if (outRange) return;
        mouse.x -= offset.left;
        mouse.y -= offset.top;
        // done
        var color = tuitpix.cont.getImageData(mouse.x - 7, mouse.y - 7, 1, 1).data;
            color = tuitpix.RGBtoHex(color[0], color[1], color[2]);
        document.getElementById("colors").color.fromString(color);
        tuitpix.color = "#"+color;
        $("#colors").attr("value", color).css({
            marginLeft: mouse.x,
            marginTop: mouse.y,
        }).focus();
        return false;
    }
};
