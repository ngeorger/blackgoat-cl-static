(function(){"use strict";var __webpack_require__={};!function(){__webpack_require__.n=function(module){var getter=module&&module.__esModule?function(){return module['default'];}:function(){return module;};__webpack_require__.d(getter,{a:getter});return getter;};}();!function(){__webpack_require__.d=function(exports,definition){for(var key in definition){if(__webpack_require__.o(definition,key)&&!__webpack_require__.o(exports,key)){Object.defineProperty(exports,key,{enumerable:true,get:definition[key]});}}};}();!function(){__webpack_require__.o=function(obj,prop){return Object.prototype.hasOwnProperty.call(obj,prop);}}();!function(){__webpack_require__.r=function(exports){if(typeof Symbol!=='undefined'&&Symbol.toStringTag){Object.defineProperty(exports,Symbol.toStringTag,{value:'Module'});}
Object.defineProperty(exports,'__esModule',{value:true});};}();var __webpack_exports__={};__webpack_require__.r(__webpack_exports__);__webpack_require__.d(__webpack_exports__,{"DotTip":function(){return dot_tip;},"store":function(){return store;}});var actions_namespaceObject={};__webpack_require__.r(actions_namespaceObject);__webpack_require__.d(actions_namespaceObject,{"disableTips":function(){return disableTips;},"dismissTip":function(){return dismissTip;},"enableTips":function(){return enableTips;},"triggerGuide":function(){return triggerGuide;}});var selectors_namespaceObject={};__webpack_require__.r(selectors_namespaceObject);__webpack_require__.d(selectors_namespaceObject,{"areTipsEnabled":function(){return selectors_areTipsEnabled;},"getAssociatedGuide":function(){return getAssociatedGuide;},"isTipVisible":function(){return isTipVisible;}});;var external_wp_deprecated_namespaceObject=window["wp"]["deprecated"];var external_wp_deprecated_default=__webpack_require__.n(external_wp_deprecated_namespaceObject);;var external_wp_data_namespaceObject=window["wp"]["data"];;function guides(){let state=arguments.length>0&&arguments[0]!==undefined?arguments[0]:[];let action=arguments.length>1?arguments[1]:undefined;switch(action.type){case 'TRIGGER_GUIDE':return[...state,action.tipIds];}
return state;}
function areTipsEnabled(){let state=arguments.length>0&&arguments[0]!==undefined?arguments[0]:true;let action=arguments.length>1?arguments[1]:undefined;switch(action.type){case 'DISABLE_TIPS':return false;case 'ENABLE_TIPS':return true;}
return state;}
function dismissedTips(){let state=arguments.length>0&&arguments[0]!==undefined?arguments[0]:{};let action=arguments.length>1?arguments[1]:undefined;switch(action.type){case 'DISMISS_TIP':return{...state,[action.id]:true};case 'ENABLE_TIPS':return{};}
return state;}
const preferences=(0,external_wp_data_namespaceObject.combineReducers)({areTipsEnabled,dismissedTips});var reducer=((0,external_wp_data_namespaceObject.combineReducers)({guides,preferences}));;function triggerGuide(tipIds){return{type:'TRIGGER_GUIDE',tipIds};}
function dismissTip(id){return{type:'DISMISS_TIP',id};}
function disableTips(){return{type:'DISABLE_TIPS'};}
function enableTips(){return{type:'ENABLE_TIPS'};};var LEAF_KEY={};function arrayOf(value){return[value];}
function isObjectLike(value){return!!value&&'object'===typeof value;}
function createCache(){var cache={clear:function(){cache.head=null;},};return cache;}
function isShallowEqual(a,b,fromIndex){var i;if(a.length!==b.length){return false;}
for(i=fromIndex;i<a.length;i++){if(a[i]!==b[i]){return false;}}
return true;}
function rememo(selector,getDependants){var rootCache;var normalizedGetDependants=getDependants?getDependants:arrayOf;function getCache(dependants){var caches=rootCache,isUniqueByDependants=true,i,dependant,map,cache;for(i=0;i<dependants.length;i++){dependant=dependants[i];if(!isObjectLike(dependant)){isUniqueByDependants=false;break;}
if(caches.has(dependant)){caches=caches.get(dependant);}else{map=new WeakMap();caches.set(dependant,map);caches=map;}}
if(!caches.has(LEAF_KEY)){cache=createCache();cache.isUniqueByDependants=isUniqueByDependants;caches.set(LEAF_KEY,cache);}
return caches.get(LEAF_KEY);}
function clear(){rootCache=new WeakMap();}
function callSelector(){var len=arguments.length,cache,node,i,args,dependants;args=new Array(len);for(i=0;i<len;i++){args[i]=arguments[i];}
dependants=normalizedGetDependants.apply(null,args);cache=getCache(dependants);if(!cache.isUniqueByDependants){if(cache.lastDependants&&!isShallowEqual(dependants,cache.lastDependants,0)){cache.clear();}
cache.lastDependants=dependants;}
node=cache.head;while(node){if(!isShallowEqual(node.args,args,1)){node=node.next;continue;}
if(node!==cache.head){(node.prev).next=node.next;if(node.next){node.next.prev=node.prev;}
node.next=cache.head;node.prev=null;(cache.head).prev=node;cache.head=node;}
return node.val;}
node=({val:selector.apply(null,args),});args[0]=null;node.args=args;if(cache.head){cache.head.prev=node;node.next=cache.head;}
cache.head=node;return node.val;}
callSelector.getDependants=normalizedGetDependants;callSelector.clear=clear;clear();return(callSelector);};const getAssociatedGuide=rememo((state,tipId)=>{for(const tipIds of state.guides){if(tipIds.includes(tipId)){const nonDismissedTips=tipIds.filter(tId=>!Object.keys(state.preferences.dismissedTips).includes(tId));const[currentTipId=null,nextTipId=null]=nonDismissedTips;return{tipIds,currentTipId,nextTipId};}}
return null;},state=>[state.guides,state.preferences.dismissedTips]);function isTipVisible(state,tipId){var _state$preferences$di;if(!state.preferences.areTipsEnabled){return false;}
if((_state$preferences$di=state.preferences.dismissedTips)!==null&&_state$preferences$di!==void 0&&_state$preferences$di.hasOwnProperty(tipId)){return false;}
const associatedGuide=getAssociatedGuide(state,tipId);if(associatedGuide&&associatedGuide.currentTipId!==tipId){return false;}
return true;}
function selectors_areTipsEnabled(state){return state.preferences.areTipsEnabled;};const STORE_NAME='core/nux';const store=(0,external_wp_data_namespaceObject.createReduxStore)(STORE_NAME,{reducer:reducer,actions:actions_namespaceObject,selectors:selectors_namespaceObject,persist:['preferences']});(0,external_wp_data_namespaceObject.registerStore)(STORE_NAME,{reducer:reducer,actions:actions_namespaceObject,selectors:selectors_namespaceObject,persist:['preferences']});;var external_wp_element_namespaceObject=window["wp"]["element"];;var external_wp_compose_namespaceObject=window["wp"]["compose"];;var external_wp_components_namespaceObject=window["wp"]["components"];;var external_wp_i18n_namespaceObject=window["wp"]["i18n"];;var external_wp_primitives_namespaceObject=window["wp"]["primitives"];;const close_close=(0,external_wp_element_namespaceObject.createElement)(external_wp_primitives_namespaceObject.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},(0,external_wp_element_namespaceObject.createElement)(external_wp_primitives_namespaceObject.Path,{d:"M13 11.8l6.1-6.3-1-1-6.1 6.2-6.1-6.2-1 1 6.1 6.3-6.5 6.7 1 1 6.5-6.6 6.5 6.6 1-1z"}));var library_close=(close_close);;function onClick(event){event.stopPropagation();}
function DotTip(_ref){let{position='middle right',children,isVisible,hasNextTip,onDismiss,onDisable}=_ref;const anchorParent=(0,external_wp_element_namespaceObject.useRef)(null);const onFocusOutsideCallback=(0,external_wp_element_namespaceObject.useCallback)(event=>{if(!anchorParent.current){return;}
if(anchorParent.current.contains(event.relatedTarget)){return;}
onDisable();},[onDisable,anchorParent]);if(!isVisible){return null;}
return(0,external_wp_element_namespaceObject.createElement)(external_wp_components_namespaceObject.Popover,{className:"nux-dot-tip",position:position,focusOnMount:true,role:"dialog","aria-label":(0,external_wp_i18n_namespaceObject.__)('Editor tips'),onClick:onClick,onFocusOutside:onFocusOutsideCallback},(0,external_wp_element_namespaceObject.createElement)("p",null,children),(0,external_wp_element_namespaceObject.createElement)("p",null,(0,external_wp_element_namespaceObject.createElement)(external_wp_components_namespaceObject.Button,{variant:"link",onClick:onDismiss},hasNextTip?(0,external_wp_i18n_namespaceObject.__)('See next tip'):(0,external_wp_i18n_namespaceObject.__)('Got it'))),(0,external_wp_element_namespaceObject.createElement)(external_wp_components_namespaceObject.Button,{className:"nux-dot-tip__disable",icon:library_close,label:(0,external_wp_i18n_namespaceObject.__)('Disable tips'),onClick:onDisable}));}
var dot_tip=((0,external_wp_compose_namespaceObject.compose)((0,external_wp_data_namespaceObject.withSelect)((select,_ref2)=>{let{tipId}=_ref2;const{isTipVisible,getAssociatedGuide}=select(store);const associatedGuide=getAssociatedGuide(tipId);return{isVisible:isTipVisible(tipId),hasNextTip:!!(associatedGuide&&associatedGuide.nextTipId)};}),(0,external_wp_data_namespaceObject.withDispatch)((dispatch,_ref3)=>{let{tipId}=_ref3;const{dismissTip,disableTips}=dispatch(store);return{onDismiss(){dismissTip(tipId);},onDisable(){disableTips();}};}))(DotTip));;external_wp_deprecated_default()('wp.nux',{since:'5.4',hint:'wp.components.Guide can be used to show a user guide.',version:'6.2'});(window.wp=window.wp||{}).nux=__webpack_exports__;})();