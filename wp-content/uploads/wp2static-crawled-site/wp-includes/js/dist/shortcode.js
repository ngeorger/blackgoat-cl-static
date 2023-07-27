(function(){var __webpack_modules__=({9756:(function(module){function memize(fn,options){var size=0;var head;var tail;options=options||{};function memoized(){var node=head,len=arguments.length,args,i;searchCache:while(node){if(node.args.length!==arguments.length){node=node.next;continue;}
for(i=0;i<len;i++){if(node.args[i]!==arguments[i]){node=node.next;continue searchCache;}}
if(node!==head){if(node===tail){tail=node.prev;}
(node.prev).next=node.next;if(node.next){node.next.prev=node.prev;}
node.next=head;node.prev=null;(head).prev=node;head=node;}
return node.val;}
args=new Array(len);for(i=0;i<len;i++){args[i]=arguments[i];}
node={args:args,val:fn.apply(null,args),};if(head){head.prev=node;node.next=head;}else{tail=node;}
if(size===(options).maxSize){tail=(tail).prev;(tail).next=null;}else{size++;}
head=node;return node.val;}
memoized.clear=function(){head=null;tail=null;size=0;};if(false){}
return memoized;}
module.exports=memize;})});var __webpack_module_cache__={};function __webpack_require__(moduleId){var cachedModule=__webpack_module_cache__[moduleId];if(cachedModule!==undefined){return cachedModule.exports;}
var module=__webpack_module_cache__[moduleId]={exports:{}};__webpack_modules__[moduleId](module,module.exports,__webpack_require__);return module.exports;}
!function(){__webpack_require__.n=function(module){var getter=module&&module.__esModule?function(){return module['default'];}:function(){return module;};__webpack_require__.d(getter,{a:getter});return getter;};}();!function(){__webpack_require__.d=function(exports,definition){for(var key in definition){if(__webpack_require__.o(definition,key)&&!__webpack_require__.o(exports,key)){Object.defineProperty(exports,key,{enumerable:true,get:definition[key]});}}};}();!function(){__webpack_require__.o=function(obj,prop){return Object.prototype.hasOwnProperty.call(obj,prop);}}();var __webpack_exports__={};!function(){"use strict";var memize__WEBPACK_IMPORTED_MODULE_0__=__webpack_require__(9756);var memize__WEBPACK_IMPORTED_MODULE_0___default=__webpack_require__.n(memize__WEBPACK_IMPORTED_MODULE_0__);function next(tag,text){let index=arguments.length>2&&arguments[2]!==undefined?arguments[2]:0;const re=regexp(tag);re.lastIndex=index;const match=re.exec(text);if(!match){return;}
if('['===match[1]&&']'===match[7]){return next(tag,text,re.lastIndex);}
const result={index:match.index,content:match[0],shortcode:fromMatch(match)};if(match[1]){result.content=result.content.slice(1);result.index++;}
if(match[7]){result.content=result.content.slice(0,-1);}
return result;}
function replace(tag,text,callback){return text.replace(regexp(tag),function(match,left,$3,attrs,slash,content,closing,right){if(left==='['&&right===']'){return match;}
const result=callback(fromMatch(arguments));return result||result===''?left+result+right:match;});}
function string(options){return new shortcode(options).string();}
function regexp(tag){return new RegExp('\\[(\\[?)('+tag+')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)','g');}
const attrs=memize__WEBPACK_IMPORTED_MODULE_0___default()(text=>{const named={};const numeric=[];const pattern=/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*'([^']*)'(?:\s|$)|([\w-]+)\s*=\s*([^\s'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|'([^']*)'(?:\s|$)|(\S+)(?:\s|$)/g;text=text.replace(/[\u00a0\u200b]/g,' ');let match;while(match=pattern.exec(text)){if(match[1]){named[match[1].toLowerCase()]=match[2];}else if(match[3]){named[match[3].toLowerCase()]=match[4];}else if(match[5]){named[match[5].toLowerCase()]=match[6];}else if(match[7]){numeric.push(match[7]);}else if(match[8]){numeric.push(match[8]);}else if(match[9]){numeric.push(match[9]);}}
return{named,numeric};});function fromMatch(match){let type;if(match[4]){type='self-closing';}else if(match[6]){type='closed';}else{type='single';}
return new shortcode({tag:match[2],attrs:match[3],type,content:match[5]});}
const shortcode=Object.assign(function(options){const{tag,attrs:attributes,type,content}=options||{};Object.assign(this,{tag,type,content});this.attrs={named:{},numeric:[]};if(!attributes){return;}
const attributeTypes=['named','numeric'];if(typeof attributes==='string'){this.attrs=attrs(attributes);}else if(attributes.length===attributeTypes.length&&attributeTypes.every((t,key)=>t===attributes[key])){this.attrs=attributes;}else{Object.entries(attributes).forEach(_ref=>{let[key,value]=_ref;this.set(key,value);});}},{next,replace,string,regexp,attrs,fromMatch});Object.assign(shortcode.prototype,{get(attr){return this.attrs[typeof attr==='number'?'numeric':'named'][attr];},set(attr,value){this.attrs[typeof attr==='number'?'numeric':'named'][attr]=value;return this;},string(){let text='['+this.tag;this.attrs.numeric.forEach(value=>{if(/\s/.test(value)){text+=' "'+value+'"';}else{text+=' '+value;}});Object.entries(this.attrs.named).forEach(_ref2=>{let[name,value]=_ref2;text+=' '+name+'="'+value+'"';});if('single'===this.type){return text+']';}else if('self-closing'===this.type){return text+' /]';}
text+=']';if(this.content){text+=this.content;}
return text+'[/'+this.tag+']';}});__webpack_exports__["default"]=(shortcode);}();(window.wp=window.wp||{}).shortcode=__webpack_exports__["default"];})();