/*!
* jQuery postMessage - v0.5 - 9/11/2009
* http://benalman.com/projects/jquery-postmessage-plugin/
*
* Copyright (c) 2009 "Cowboy" Ben Alman
* Dual licensed under the MIT and GPL licenses.
* http://benalman.com/about/license/
*
* Non-jQuery fork by Jeff Lee
*
* This fork consists of the following changes:
* 1. Basic code cleanup and restructuring, for legibility.
* 2. The `postMessage` and `receiveMessage` functions can be bound arbitrarily,
* in terms of both function names and object scope. Scope is specified by
* the the "this" context of NoJQueryPostMessageMixin();
* 3. I've removed the check for Opera 9.64, which used `$.browser`. There were
* at least three different GitHub users requesting the removal of this
* "Opera sniff" on the original project's Issues page, so I figured this
* would be a relatively safe change.
* 4. `postMessage` no longer uses `$.param` to serialize messages that are not
* strings. I actually prefer this structure anyway. `receiveMessage` does
* not implement a corresponding deserialization step, and as such it seems
* cleaner and more symmetric to leave both data serialization and
* deserialization to the client.
* 5. The use of `$.isFunction` is replaced by a functionally-identical check.
* 6. The `$:nomunge` YUI option is no longer necessary.
*/function NoJQueryPostMessageMixin(postBinding,receiveBinding){var setMessageCallback,unsetMessageCallback,currentMsgCallback,intervalId,lastHash,cacheBust=1;if(window.postMessage){if(window.addEventListener){setMessageCallback=function(callback){window.addEventListener('message',callback,false);}
unsetMessageCallback=function(callback){window.removeEventListener('message',callback,false);}}else{setMessageCallback=function(callback){window.attachEvent('onmessage',callback);}
unsetMessageCallback=function(callback){window.detachEvent('onmessage',callback);}}
this[postBinding]=function(message,targetUrl,target){if(!targetUrl){return;}
target.postMessage(message,targetUrl.replace(/([^:]+:\/\/[^\/]+).*/,'$1'));}
this[receiveBinding]=function(callback,sourceOrigin,delay){if(currentMsgCallback){unsetMessageCallback(currentMsgCallback);currentMsgCallback=null;}
if(!callback){return false;}
currentMsgCallback=setMessageCallback(function(e){switch(Object.prototype.toString.call(sourceOrigin)){case '[object String]':if(sourceOrigin!==e.origin){return false;}
break;case '[object Function]':if(sourceOrigin(e.origin)){return false;}
break;}
callback(e);});};}else{this[postBinding]=function(message,targetUrl,target){if(!targetUrl){return;}
target.location=targetUrl.replace(/#.*$/,'')+'#'+(+new Date)+(cacheBust++)+'&'+message;}
this[receiveBinding]=function(callback,sourceOrigin,delay){if(intervalId){clearInterval(intervalId);intervalId=null;}
if(callback){delay=typeof sourceOrigin==='number'?sourceOrigin:typeof delay==='number'?delay:100;intervalId=setInterval(function(){var hash=document.location.hash,re=/^#?\d+&/;if(hash!==lastHash&&re.test(hash)){lastHash=hash;callback({data:hash.replace(re,'')});}},delay);}};}
return this;}