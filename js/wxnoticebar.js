var noticeBar;
var topMapBar;
function NoticeBlock(frame, topBar){
    var content=topMapBar.newel("div").attr({class: "hiddenBlock"});
    content.notice=function(set){
        content.empty();
         content.attr({class: "noticeBlock", id: "noticeBlock"});
         content.activated=true;
         content.newel("img").attr({class: "closeIcon", src: getIconURL("cancel")}).on("click", function(){
             content.close();
         });
         if(set.type)content.newel("img").attr({class: "mainIcon", src: getBigIconURL(set.type)});
         if(set.title)content.newel("h3").html(set.title);

         if(set.message)content.newel("p").attr({class: "message"}).html(set.message);
         if(set.item){
             var item=content.newel("div").attr({class: "innerItem"});
             ListItem(item, Location(item, set.item), set.item);
         }
         if(set.child)content.append(set.child);
         if(set.actions)content.actions=set.actions;

    }
    content.close=function(){
        content.empty();
        content.attr({class:"hiddenBlock"});
        if(content.actions)if(content.actions.close)content.actions.close();
        content.actions={};
        content.activated=false;
    }
    content.notices=new Array();
    content.init=function(data){
        topBar.empty();
        $.each(data, function(i, data){
            if(data.type=="hidden")return 0;
            topBar.newel("img").attr({src: getAnimatedIconURL(data.type), class: "noticeIcon"}).on('click', function(){
                content.notice({item: data});
            });
            if(!content.activated)content.notice({item: data});
        });
    }
    content.load=function(){
        WXData({action: "notices", callback:content.init});
    }
    return content;
}