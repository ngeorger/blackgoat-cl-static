/*!
* jQuery UI Effects Size 1.13.2
* http://jqueryui.com
*
* Copyright jQuery Foundation and other contributors
* Released under the MIT license.
* http://jquery.org/license
*/(function(factory){"use strict";if(typeof define==="function"&&define.amd){define(["jquery","./effect"],factory);}else{factory(jQuery);}})(function($){"use strict";return $.effects.define("size",function(options,done){var baseline,factor,temp,element=$(this),cProps=["fontSize"],vProps=["borderTopWidth","borderBottomWidth","paddingTop","paddingBottom"],hProps=["borderLeftWidth","borderRightWidth","paddingLeft","paddingRight"],mode=options.mode,restore=mode!=="effect",scale=options.scale||"both",origin=options.origin||["middle","center"],position=element.css("position"),pos=element.position(),original=$.effects.scaledDimensions(element),from=options.from||original,to=options.to||$.effects.scaledDimensions(element,0);$.effects.createPlaceholder(element);if(mode==="show"){temp=from;from=to;to=temp;}
factor={from:{y:from.height/original.height,x:from.width/original.width},to:{y:to.height/original.height,x:to.width/original.width}};if(scale==="box"||scale==="both"){if(factor.from.y!==factor.to.y){from=$.effects.setTransition(element,vProps,factor.from.y,from);to=$.effects.setTransition(element,vProps,factor.to.y,to);}
if(factor.from.x!==factor.to.x){from=$.effects.setTransition(element,hProps,factor.from.x,from);to=$.effects.setTransition(element,hProps,factor.to.x,to);}}
if(scale==="content"||scale==="both"){if(factor.from.y!==factor.to.y){from=$.effects.setTransition(element,cProps,factor.from.y,from);to=$.effects.setTransition(element,cProps,factor.to.y,to);}}
if(origin){baseline=$.effects.getBaseline(origin,original);from.top=(original.outerHeight-from.outerHeight)*baseline.y+pos.top;from.left=(original.outerWidth-from.outerWidth)*baseline.x+pos.left;to.top=(original.outerHeight-to.outerHeight)*baseline.y+pos.top;to.left=(original.outerWidth-to.outerWidth)*baseline.x+pos.left;}
delete from.outerHeight;delete from.outerWidth;element.css(from);if(scale==="content"||scale==="both"){vProps=vProps.concat(["marginTop","marginBottom"]).concat(cProps);hProps=hProps.concat(["marginLeft","marginRight"]);element.find("*[width]").each(function(){var child=$(this),childOriginal=$.effects.scaledDimensions(child),childFrom={height:childOriginal.height*factor.from.y,width:childOriginal.width*factor.from.x,outerHeight:childOriginal.outerHeight*factor.from.y,outerWidth:childOriginal.outerWidth*factor.from.x},childTo={height:childOriginal.height*factor.to.y,width:childOriginal.width*factor.to.x,outerHeight:childOriginal.height*factor.to.y,outerWidth:childOriginal.width*factor.to.x};if(factor.from.y!==factor.to.y){childFrom=$.effects.setTransition(child,vProps,factor.from.y,childFrom);childTo=$.effects.setTransition(child,vProps,factor.to.y,childTo);}
if(factor.from.x!==factor.to.x){childFrom=$.effects.setTransition(child,hProps,factor.from.x,childFrom);childTo=$.effects.setTransition(child,hProps,factor.to.x,childTo);}
if(restore){$.effects.saveStyle(child);}
child.css(childFrom);child.animate(childTo,options.duration,options.easing,function(){if(restore){$.effects.restoreStyle(child);}});});}
element.animate(to,{queue:false,duration:options.duration,easing:options.easing,complete:function(){var offset=element.offset();if(to.opacity===0){element.css("opacity",from.opacity);}
if(!restore){element.css("position",position==="static"?"relative":position).offset(offset);$.effects.saveStyle(element);}
done();}});});});