/*!
* jQuery UI Effects Drop 1.13.2
* http://jqueryui.com
*
* Copyright jQuery Foundation and other contributors
* Released under the MIT license.
* http://jquery.org/license
*/(function(factory){"use strict";if(typeof define==="function"&&define.amd){define(["jquery","./effect"],factory);}else{factory(jQuery);}})(function($){"use strict";return $.effects.define("drop","hide",function(options,done){var distance,element=$(this),mode=options.mode,show=mode==="show",direction=options.direction||"left",ref=(direction==="up"||direction==="down")?"top":"left",motion=(direction==="up"||direction==="left")?"-=":"+=",oppositeMotion=(motion==="+=")?"-=":"+=",animation={opacity:0};$.effects.createPlaceholder(element);distance=options.distance||element[ref==="top"?"outerHeight":"outerWidth"](true)/2;animation[ref]=motion+distance;if(show){element.css(animation);animation[ref]=oppositeMotion+distance;animation.opacity=1;}
element.animate(animation,{queue:false,duration:options.duration,easing:options.easing,complete:done});});});