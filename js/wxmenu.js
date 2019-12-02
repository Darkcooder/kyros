$(document).ready(initMenu)
function initMenu(){
    var menu=$("#mainMenu");
    $("#menuIcon").on("click", function(){
        menu.attr({class: "mainMenu"});
    } )
    menu.on("mouseleave", function(){
        menu.attr({class: "hidden"});
    })

    menu.add=function(name){
        settingItem=menu.newel("li").on("click", menu.select[name]);
        settingItem.newel("img").attr({src: getIconURL(name)});
        settingItem.newel("p").html(igText[name]);
    }

    menu.select={};


    menu.select.settings=function(){
         settings=new WxSettings();
    }
    menu.add("settings");



    menu.select.exit=function(){
         $("#login-form").submit();
    }
    menu.add("exit");
}

