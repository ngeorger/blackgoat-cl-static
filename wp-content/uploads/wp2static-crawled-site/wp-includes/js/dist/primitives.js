(function(){var __webpack_modules__=({4403:(function(module,exports){var __WEBPACK_AMD_DEFINE_ARRAY__,__WEBPACK_AMD_DEFINE_RESULT__;/*!
Copyright (c) 2018 Jed Watson.
Licensed under the MIT License (MIT), see
http://jedwatson.github.io/classnames
*/(function(){'use strict';var hasOwn={}.hasOwnProperty;var nativeCodeString='[native code]';function classNames(){var classes=[];for(var i=0;i<arguments.length;i++){var arg=arguments[i];if(!arg)continue;var argType=typeof arg;if(argType==='string'||argType==='number'){classes.push(arg);}else if(Array.isArray(arg)){if(arg.length){var inner=classNames.apply(null,arg);if(inner){classes.push(inner);}}}else if(argType==='object'){if(arg.toString!==Object.prototype.toString&&!arg.toString.toString().includes('[native code]')){classes.push(arg.toString());continue;}
for(var key in arg){if(hasOwn.call(arg,key)&&arg[key]){classes.push(key);}}}}
return classes.join(' ');}
if(true&&module.exports){classNames.default=classNames;module.exports=classNames;}else if(true){!(__WEBPACK_AMD_DEFINE_ARRAY__=[],__WEBPACK_AMD_DEFINE_RESULT__=(function(){return classNames;}).apply(exports,__WEBPACK_AMD_DEFINE_ARRAY__),__WEBPACK_AMD_DEFINE_RESULT__!==undefined&&(module.exports=__WEBPACK_AMD_DEFINE_RESULT__));}else{}}());})});var __webpack_module_cache__={};function __webpack_require__(moduleId){var cachedModule=__webpack_module_cache__[moduleId];if(cachedModule!==undefined){return cachedModule.exports;}
var module=__webpack_module_cache__[moduleId]={exports:{}};__webpack_modules__[moduleId](module,module.exports,__webpack_require__);return module.exports;}
!function(){__webpack_require__.n=function(module){var getter=module&&module.__esModule?function(){return module['default'];}:function(){return module;};__webpack_require__.d(getter,{a:getter});return getter;};}();!function(){__webpack_require__.d=function(exports,definition){for(var key in definition){if(__webpack_require__.o(definition,key)&&!__webpack_require__.o(exports,key)){Object.defineProperty(exports,key,{enumerable:true,get:definition[key]});}}};}();!function(){__webpack_require__.o=function(obj,prop){return Object.prototype.hasOwnProperty.call(obj,prop);}}();!function(){__webpack_require__.r=function(exports){if(typeof Symbol!=='undefined'&&Symbol.toStringTag){Object.defineProperty(exports,Symbol.toStringTag,{value:'Module'});}
Object.defineProperty(exports,'__esModule',{value:true});};}();var __webpack_exports__={};!function(){"use strict";__webpack_require__.r(__webpack_exports__);__webpack_require__.d(__webpack_exports__,{"BlockQuotation":function(){return BlockQuotation;},"Circle":function(){return Circle;},"Defs":function(){return Defs;},"G":function(){return G;},"HorizontalRule":function(){return HorizontalRule;},"Line":function(){return Line;},"LinearGradient":function(){return LinearGradient;},"Path":function(){return Path;},"Polygon":function(){return Polygon;},"RadialGradient":function(){return RadialGradient;},"Rect":function(){return Rect;},"SVG":function(){return SVG;},"Stop":function(){return Stop;},"View":function(){return View;}});var classnames=__webpack_require__(4403);var classnames_default=__webpack_require__.n(classnames);;var external_wp_element_namespaceObject=window["wp"]["element"];;const Circle=props=>(0,external_wp_element_namespaceObject.createElement)('circle',props);const G=props=>(0,external_wp_element_namespaceObject.createElement)('g',props);const Line=props=>(0,external_wp_element_namespaceObject.createElement)('line',props);const Path=props=>(0,external_wp_element_namespaceObject.createElement)('path',props);const Polygon=props=>(0,external_wp_element_namespaceObject.createElement)('polygon',props);const Rect=props=>(0,external_wp_element_namespaceObject.createElement)('rect',props);const Defs=props=>(0,external_wp_element_namespaceObject.createElement)('defs',props);const RadialGradient=props=>(0,external_wp_element_namespaceObject.createElement)('radialGradient',props);const LinearGradient=props=>(0,external_wp_element_namespaceObject.createElement)('linearGradient',props);const Stop=props=>(0,external_wp_element_namespaceObject.createElement)('stop',props);const SVG=_ref=>{let{className,isPressed,...props}=_ref;const appliedProps={...props,className:classnames_default()(className,{'is-pressed':isPressed})||undefined,'aria-hidden':true,focusable:false};return(0,external_wp_element_namespaceObject.createElement)("svg",appliedProps);};;const HorizontalRule='hr';;const BlockQuotation='blockquote';;const View='div';;}();(window.wp=window.wp||{}).primitives=__webpack_exports__;})();