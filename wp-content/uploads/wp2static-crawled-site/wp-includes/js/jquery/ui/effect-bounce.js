/*!
* jQuery UI Effects Bounce 1.13.2
* http://jqueryui.com
*
* Copyright jQuery Foundation and other contributors
* Released under the MIT license.
* http://jquery.org/license
*/(function(factory){"use strict";if(typeof define==="function"&&define.amd){define(["jquery","./effect"],factory);}else{factory(jQuery);}})(function($){"use strict";return $.effects.define("bounce",function(options,done){var upAnim,downAnim,refValue,element=$(this),mode=options.mode,hide=mode==="hide",show=mode==="show",direction=options.direction||"up",distance=options.distance,times=options.times||5,anims=times*2+(show||hide?1:0),speed=options.duration/anims,easing=options.easing,ref=(direction==="up"||direction==="down")?"top":"left",motion=(direction==="up"||direction==="left"),i=0,queuelen=element.queue().length;$.effects.createPlaceholder(element);refValue=element.css(ref);if(!distance){distance=element[ref==="top"?"outerHeight":"outerWidth"]()/3;}
if(show){downAnim={opacity:1};downAnim[ref]=refValue;element.css("opacity",0).css(ref,motion?-distance*2:distance*2).animate(downAnim,speed,easing);}
if(hide){distance=distance/Math.pow(2,times-1);}
downAnim={};downAnim[ref]=refValue;for(;i<times;i++){upAnim={};upAnim[ref]=(motion?"-=":"+=")+distance;element.animate(upAnim,speed,easing).animate(downAnim,speed,easing);distance=hide?distance*2:distance/2;}
if(hide){upAnim={opacity:0};upAnim[ref]=(motion?"-=":"+=")+distance;element.animate(upAnim,speed,easing);}
element.queue(done);$.effects.unshift(element,queuelen,anims+1);});});