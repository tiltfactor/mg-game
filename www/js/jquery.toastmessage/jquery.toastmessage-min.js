(function(c){var b={inEffect:{opacity:"show"},inEffectDuration:600,stayTime:9900,text:"",sticky:false,type:"notice",position:"top-right",closeText:"",close:null,background:null,color:null};
var a={init:function(d){if(d){c.extend(b,d)
}},showToast:function(f){var g={};
c.extend(g,b,f);
var j,e,d,i,h;
j=(!c(".toast-container").length)?c("<div></div>").addClass("toast-container").addClass("toast-position-"+g.position).appendTo("body"):c(".toast-container");
e=c("<div></div>").addClass("toast-item-wrapper");
    var g_color = "";
    if (g.color !== null) {
        g_color = 'style="color: ' + g.color + ';"'
    }
d=c("<div></div>").hide().addClass("toast-item toast-type-"+g.type).appendTo(j).html(c("<p " + g_color + ">").append(g.text)).animate(g.inEffect,g.inEffectDuration).wrap(e);
    if (g.background !== null) {
        c(".toast-item").css('cssText', 'background-color: ' + g.background + ' !important;');
    }
i=c("<div></div>").addClass("toast-item-close").prependTo(d).html(g.closeText).click(function(){c().toastmessage("removeToast",d,g)
});
h=c("<div></div>").addClass("toast-item-image").addClass("toast-item-image-"+g.type).prependTo(d);
if(navigator.userAgent.match(/MSIE 6/i)){j.css({top:document.documentElement.scrollTop})
}if(!g.sticky){setTimeout(function(){c().toastmessage("removeToast",d,g)
},g.stayTime)
}return d
},showNoticeToast:function(e){var d={text:e,type:"notice"};
return c().toastmessage("showToast",d)
},showSuccessToast:function(e){var d={text:e,type:"success"};
return c().toastmessage("showToast",d)
},showErrorToast:function(e){var d={text:e,type:"error"};
return c().toastmessage("showToast",d)
},showWarningToast:function(e){var d={text:e,type:"warning"};
return c().toastmessage("showToast",d)
},removeToast: function(e,d){
        e.fadeIn('slow').stop(true).animate({'bottom': '94%', opacity:"0"}, 900, function() {
            e.parent().animate({height:"0px"}, 300, function(){
                e.closest(".toast-container").remove()
            })
        });
        if(d&&d.close!==null){d.close()}
    }
};
c.fn.toastmessage=function(d){if(a[d]){return a[d].apply(this,Array.prototype.slice.call(arguments,1))
}else{if(typeof d==="object"||!d){return a.init.apply(this,arguments)
}else{c.error("Method "+d+" does not exist on jQuery.toastmessage")
}}}
})(jQuery);