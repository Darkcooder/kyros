var settings;
WxSettings=function(){
      noticeBar.close();
      WXData({actionType: "get", action: "myStatus", params: {}, callback: function(data){
           var form=new WXForm({title: igText.settings});
         noticeBar.notice({type: "settings", child: form});
         form.attr({class: "innerItem"});
         var values=[0, 10, 50, 200, 500, 2000, 5000, 20000, 50000, 200000, 1000000, 100000000];
         var chars=["невидим", "10м", "50м", "200м", "500м", "2км", "5км", "20км", "50км", "200км", "1000км", "без горизонта"];

         form.addSmartSlider({id: "liked", name: "Для избранных", action: "myStatus", params: {stat_type: "liked"}, values: values, chars: chars, value: data.isee_liked});
         form.addSmartSlider({id: "friends", name: "Для друзей", action: "myStatus", params: {stat_type: "friends"}, values: values, chars: chars, value: data.isee_friends});
         form.addSmartSlider({id: "public", name: "Для всех", action: "myStatus", params: {stat_type: "public"}, values: values, chars: chars, value: data.isee_public});
      }})




 }