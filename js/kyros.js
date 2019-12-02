var selector=new Selector($("#selector"));
var itemList=new List($("#curList"));
var noticeBar=new Bar($("#noticeBar"));
var mainMenu=new Menu($("#mainMenu"));

var settings=new KyrosSettings();
settings.setFrame(noticeBar);

WxItem::setDialog(noticeBar);

selector.addItem(new People(), itemList);
selector.addItem(new Place(), itemList);
selector.addItem(new Meet(), itemList);
selector.addItem(new Task(), itemList);

mainMenu.addItem("settings", function(){settings.show()});
mainMenu.addItem("logout", function(){Logout()});

NoticeService;