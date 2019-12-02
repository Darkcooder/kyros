<?php
defined('_JEXEC') or die('Restricted access');
?>

<h3 id="header"></h3>
<div id="socialFriends" class="control_blocks"></div>
<script type="text/javascript" language="javaScript">
    var ajax_url='<?php echo $this->ajaxWay?>';

    var  socialFriends={__proto__: igFrame,
        makeMain: function(frame){
            var list = IgList(frame);
            IgListSearch(list);
            return list;
        },
        makeBlock: function(i, data, main){
            var item = IgListItem(main, data);
            item.add=function(id){$.post(ajax_url, {action: "addFriend", id: id}, socialFriends.update.bind(socialFriends))};
            item.remove=function(id){$.post(ajax_url, {action: "removeFriend", id: id}, socialFriends.update.bind(socialFriends))};
            return item;
        }
    }
    $("#header").html(igText.title);
    socialFriends.update();
</script>