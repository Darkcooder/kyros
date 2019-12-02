function WXForm(set){
     this.form=$(document.createElement("form"));
     if(set.title)this.form.newel("h3").html(set.title);
     this.form.fields={};
     this.form.addString=function(stringSet){
          this.form.fields[stringSet.id]=this.form.newel("input").attr({placeholder: stringSet.name });
          this.form.fields[stringSet.id].id=stringSet.id;
          return this.form.fields[stringSet.id]
     }.bind(this)

     this.form.addHidden=function(hiddenSet){
         this.form.fields[hiddenSet.id]=this.form.newel("input").attr({type: "hidden", value: hiddenSet.value});
         this.form.fields[hiddenSet.id].id=hiddenSet.id;
         return this.form.fields[hiddenSet.id];
     }.bind(this)

     this.form.addSlider=function(sliderSet){
         this.form.fields[sliderSet.id]=this.form.newel("div").attr({class: "inner-slider"});
         var amount=this.form.fields[sliderSet.id].newel("p");

         if(!sliderSet.callback)sliderSet.callback=function(event, ui){};
         var slider=this.form.fields[sliderSet.id].newel("div");
         var value=0;
         $.each(sliderSet.values, function(i, _value){
             if(_value<=sliderSet.value)value=i;
         });
         amount.html(sliderSet.name+": "+sliderSet.chars[value]);

         //slider.slider();
         slider.slider({
             value: value,
             min: 0,
             max: sliderSet.values.length-1,
             step: 1,
             slide: function(event, ui){
                 amount.html(sliderSet.name+": "+sliderSet.chars[ui.value]);
                 sliderSet.callback(event, sliderSet.values[ui.value]);

             }
         });
         this.form.fields[sliderSet.id].amount=amount;
         this.form.fields[sliderSet.id].slider=slider;
         return this.form.fields[sliderSet.id];
     }.bind(this)

     this.form.addSmartSlider=function(set){

         set.callback=function(event, value){
             var params={};
             if(set.params)params=set.params;
             if(!set.actionType)set.actionType="set";
             params[set.id]=value;
             WXData({actionType: set.actionType, action: set.action, params: params, callback: function(){}});

         }
         return this.form.addSlider(set);
     }.bind(this)

     this.form.addActions=function(actions){
          var actbar=this.form.newel("div").attr({class: "ActionsBlock"});
          $.each(actions, function(i, action){
              var p=actbar.newel("p");
              var img=actbar.newel("img").attr({class: "link"});
              if(action.id)img.attr({src:getIconURL(action.id)});
              if(!action.callback)action.callback=function(){};
              if(action.action&&action.actionType)img.on("click", function(){this.form.makeAction(action.actionType, action.action, action.callback)}.bind(this));
              else action.callback();
              if(action.name)p.html(action.name);
              img.on("mouseover", function(){p.attr({class: "visible"})});
              img.on("mouseleave", function(){p.attr({class: ""})});
          }.bind(this))
     }.bind(this)
     this.form.makeAction=function(actionType, action, callback){
        var params={};
        $.each(this.form.fields, function(i, field){
            params[field.id]=encodeURIComponent(field[0].value);
        });
        WXData({actionType: actionType, action: action, params: params, callback: callback})
     }.bind(this)
     return this.form;
}