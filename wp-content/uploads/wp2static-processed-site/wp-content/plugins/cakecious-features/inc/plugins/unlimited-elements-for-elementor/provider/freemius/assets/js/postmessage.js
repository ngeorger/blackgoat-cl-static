(function($,undef){var global=this;global.FS=global.FS||{};global.FS.PostMessage=function()
{var
_is_child=false,_postman=new NoJQueryPostMessageMixin('postMessage','receiveMessage'),_callbacks={},_base_url,_parent_url=decodeURIComponent(document.location.hash.replace(/^#/,'')),_parent_subdomain=_parent_url.substring(0,_parent_url.indexOf('/',('https://'===_parent_url.substring(0,('https://').length))?8:7)),_init=function(){_postman.receiveMessage(function(e){var data=JSON.parse(e.data);if(_callbacks[data.type]){for(var i=0;i<_callbacks[data.type].length;i++){_callbacks[data.type][i](data.data);}}},_base_url);},_hasParent=(''!==_parent_url),$window=$(window),$html=$('html');return{init:function(url,iframes)
{_base_url=url;_init();FS.PostMessage.receiveOnce('forward',function(data){window.location=data.url;});iframes=iframes||[];if(iframes.length>0){$window.on('scroll',function(){for(var i=0;i<iframes.length;i++){FS.PostMessage.postScroll(iframes[i]);}});}},init_child:function()
{this.init(_parent_subdomain);_is_child=true;$(window).bind('load',function(){FS.PostMessage.postHeight();FS.PostMessage.post('loaded');});},hasParent:function()
{return _hasParent;},postHeight:function(diff,wrapper){diff=diff||0;wrapper=wrapper||'#wrap_section';this.post('height',{height:diff+$(wrapper).outerHeight(true)});},postScroll:function(iframe){this.post('scroll',{top:$window.scrollTop(),height:($window.height()-parseFloat($html.css('paddingTop'))-parseFloat($html.css('marginTop')))},iframe);},post:function(type,data,iframe)
{console.debug('PostMessage.post',type);if(iframe)
{_postman.postMessage(JSON.stringify({type:type,data:data}),iframe.src,iframe.contentWindow);}
else{_postman.postMessage(JSON.stringify({type:type,data:data}),_parent_url,window.parent);}},receive:function(type,callback)
{console.debug('PostMessage.receive',type);if(undef===_callbacks[type])
_callbacks[type]=[];_callbacks[type].push(callback);},receiveOnce:function(type,callback)
{if(this.is_set(type))
return;this.receive(type,callback);},is_set:function(type)
{return(undef!=_callbacks[type]);},parent_url:function()
{return _parent_url;},parent_subdomain:function()
{return _parent_subdomain;}};}();})(jQuery);