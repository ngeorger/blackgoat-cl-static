(function(){"use strict";var __webpack_require__={};!function(){__webpack_require__.d=function(exports,definition){for(var key in definition){if(__webpack_require__.o(definition,key)&&!__webpack_require__.o(exports,key)){Object.defineProperty(exports,key,{enumerable:true,get:definition[key]});}}};}();!function(){__webpack_require__.o=function(obj,prop){return Object.prototype.hasOwnProperty.call(obj,prop);}}();!function(){__webpack_require__.r=function(exports){if(typeof Symbol!=='undefined'&&Symbol.toStringTag){Object.defineProperty(exports,Symbol.toStringTag,{value:'Module'});}
Object.defineProperty(exports,'__esModule',{value:true});};}();var __webpack_exports__={};__webpack_require__.r(__webpack_exports__);__webpack_require__.d(__webpack_exports__,{"ALT":function(){return ALT;},"BACKSPACE":function(){return BACKSPACE;},"COMMAND":function(){return COMMAND;},"CTRL":function(){return CTRL;},"DELETE":function(){return DELETE;},"DOWN":function(){return DOWN;},"END":function(){return END;},"ENTER":function(){return ENTER;},"ESCAPE":function(){return ESCAPE;},"F10":function(){return F10;},"HOME":function(){return HOME;},"LEFT":function(){return LEFT;},"PAGEDOWN":function(){return PAGEDOWN;},"PAGEUP":function(){return PAGEUP;},"RIGHT":function(){return RIGHT;},"SHIFT":function(){return SHIFT;},"SPACE":function(){return SPACE;},"TAB":function(){return TAB;},"UP":function(){return UP;},"ZERO":function(){return ZERO;},"displayShortcut":function(){return displayShortcut;},"displayShortcutList":function(){return displayShortcutList;},"isAppleOS":function(){return isAppleOS;},"isKeyboardEvent":function(){return isKeyboardEvent;},"modifiers":function(){return modifiers;},"rawShortcut":function(){return rawShortcut;},"shortcutAriaLabel":function(){return shortcutAriaLabel;}});;/*! *****************************************************************************
Copyright (c) Microsoft Corporation.
Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted.
THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
PERFORMANCE OF THIS SOFTWARE.
***************************************************************************** */var extendStatics=function(d,b){extendStatics=Object.setPrototypeOf||({__proto__:[]}instanceof Array&&function(d,b){d.__proto__=b;})||function(d,b){for(var p in b)if(Object.prototype.hasOwnProperty.call(b,p))d[p]=b[p];};return extendStatics(d,b);};function __extends(d,b){if(typeof b!=="function"&&b!==null)
throw new TypeError("Class extends value "+String(b)+" is not a constructor or null");extendStatics(d,b);function __(){this.constructor=d;}
d.prototype=b===null?Object.create(b):(__.prototype=b.prototype,new __());}
var __assign=function(){__assign=Object.assign||function __assign(t){for(var s,i=1,n=arguments.length;i<n;i++){s=arguments[i];for(var p in s)if(Object.prototype.hasOwnProperty.call(s,p))t[p]=s[p];}
return t;}
return __assign.apply(this,arguments);}
function __rest(s,e){var t={};for(var p in s)if(Object.prototype.hasOwnProperty.call(s,p)&&e.indexOf(p)<0)
t[p]=s[p];if(s!=null&&typeof Object.getOwnPropertySymbols==="function")
for(var i=0,p=Object.getOwnPropertySymbols(s);i<p.length;i++){if(e.indexOf(p[i])<0&&Object.prototype.propertyIsEnumerable.call(s,p[i]))
t[p[i]]=s[p[i]];}
return t;}
function __decorate(decorators,target,key,desc){var c=arguments.length,r=c<3?target:desc===null?desc=Object.getOwnPropertyDescriptor(target,key):desc,d;if(typeof Reflect==="object"&&typeof Reflect.decorate==="function")r=Reflect.decorate(decorators,target,key,desc);else for(var i=decorators.length-1;i>=0;i--)if(d=decorators[i])r=(c<3?d(r):c>3?d(target,key,r):d(target,key))||r;return c>3&&r&&Object.defineProperty(target,key,r),r;}
function __param(paramIndex,decorator){return function(target,key){decorator(target,key,paramIndex);}}
function __metadata(metadataKey,metadataValue){if(typeof Reflect==="object"&&typeof Reflect.metadata==="function")return Reflect.metadata(metadataKey,metadataValue);}
function __awaiter(thisArg,_arguments,P,generator){function adopt(value){return value instanceof P?value:new P(function(resolve){resolve(value);});}
return new(P||(P=Promise))(function(resolve,reject){function fulfilled(value){try{step(generator.next(value));}catch(e){reject(e);}}
function rejected(value){try{step(generator["throw"](value));}catch(e){reject(e);}}
function step(result){result.done?resolve(result.value):adopt(result.value).then(fulfilled,rejected);}
step((generator=generator.apply(thisArg,_arguments||[])).next());});}
function __generator(thisArg,body){var _={label:0,sent:function(){if(t[0]&1)throw t[1];return t[1];},trys:[],ops:[]},f,y,t,g;return g={next:verb(0),"throw":verb(1),"return":verb(2)},typeof Symbol==="function"&&(g[Symbol.iterator]=function(){return this;}),g;function verb(n){return function(v){return step([n,v]);};}
function step(op){if(f)throw new TypeError("Generator is already executing.");while(_)try{if(f=1,y&&(t=op[0]&2?y["return"]:op[0]?y["throw"]||((t=y["return"])&&t.call(y),0):y.next)&&!(t=t.call(y,op[1])).done)return t;if(y=0,t)op=[op[0]&2,t.value];switch(op[0]){case 0:case 1:t=op;break;case 4:_.label++;return{value:op[1],done:false};case 5:_.label++;y=op[1];op=[0];continue;case 7:op=_.ops.pop();_.trys.pop();continue;default:if(!(t=_.trys,t=t.length>0&&t[t.length-1])&&(op[0]===6||op[0]===2)){_=0;continue;}
if(op[0]===3&&(!t||(op[1]>t[0]&&op[1]<t[3]))){_.label=op[1];break;}
if(op[0]===6&&_.label<t[1]){_.label=t[1];t=op;break;}
if(t&&_.label<t[2]){_.label=t[2];_.ops.push(op);break;}
if(t[2])_.ops.pop();_.trys.pop();continue;}
op=body.call(thisArg,_);}catch(e){op=[6,e];y=0;}finally{f=t=0;}
if(op[0]&5)throw op[1];return{value:op[0]?op[1]:void 0,done:true};}}
var __createBinding=Object.create?(function(o,m,k,k2){if(k2===undefined)k2=k;Object.defineProperty(o,k2,{enumerable:true,get:function(){return m[k];}});}):(function(o,m,k,k2){if(k2===undefined)k2=k;o[k2]=m[k];});function __exportStar(m,o){for(var p in m)if(p!=="default"&&!Object.prototype.hasOwnProperty.call(o,p))__createBinding(o,m,p);}
function __values(o){var s=typeof Symbol==="function"&&Symbol.iterator,m=s&&o[s],i=0;if(m)return m.call(o);if(o&&typeof o.length==="number")return{next:function(){if(o&&i>=o.length)o=void 0;return{value:o&&o[i++],done:!o};}};throw new TypeError(s?"Object is not iterable.":"Symbol.iterator is not defined.");}
function __read(o,n){var m=typeof Symbol==="function"&&o[Symbol.iterator];if(!m)return o;var i=m.call(o),r,ar=[],e;try{while((n===void 0||n-->0)&&!(r=i.next()).done)ar.push(r.value);}
catch(error){e={error:error};}
finally{try{if(r&&!r.done&&(m=i["return"]))m.call(i);}
finally{if(e)throw e.error;}}
return ar;}
function __spread(){for(var ar=[],i=0;i<arguments.length;i++)
ar=ar.concat(__read(arguments[i]));return ar;}
function __spreadArrays(){for(var s=0,i=0,il=arguments.length;i<il;i++)s+=arguments[i].length;for(var r=Array(s),k=0,i=0;i<il;i++)
for(var a=arguments[i],j=0,jl=a.length;j<jl;j++,k++)
r[k]=a[j];return r;}
function __spreadArray(to,from,pack){if(pack||arguments.length===2)for(var i=0,l=from.length,ar;i<l;i++){if(ar||!(i in from)){if(!ar)ar=Array.prototype.slice.call(from,0,i);ar[i]=from[i];}}
return to.concat(ar||Array.prototype.slice.call(from));}
function __await(v){return this instanceof __await?(this.v=v,this):new __await(v);}
function __asyncGenerator(thisArg,_arguments,generator){if(!Symbol.asyncIterator)throw new TypeError("Symbol.asyncIterator is not defined.");var g=generator.apply(thisArg,_arguments||[]),i,q=[];return i={},verb("next"),verb("throw"),verb("return"),i[Symbol.asyncIterator]=function(){return this;},i;function verb(n){if(g[n])i[n]=function(v){return new Promise(function(a,b){q.push([n,v,a,b])>1||resume(n,v);});};}
function resume(n,v){try{step(g[n](v));}catch(e){settle(q[0][3],e);}}
function step(r){r.value instanceof __await?Promise.resolve(r.value.v).then(fulfill,reject):settle(q[0][2],r);}
function fulfill(value){resume("next",value);}
function reject(value){resume("throw",value);}
function settle(f,v){if(f(v),q.shift(),q.length)resume(q[0][0],q[0][1]);}}
function __asyncDelegator(o){var i,p;return i={},verb("next"),verb("throw",function(e){throw e;}),verb("return"),i[Symbol.iterator]=function(){return this;},i;function verb(n,f){i[n]=o[n]?function(v){return(p=!p)?{value:__await(o[n](v)),done:n==="return"}:f?f(v):v;}:f;}}
function __asyncValues(o){if(!Symbol.asyncIterator)throw new TypeError("Symbol.asyncIterator is not defined.");var m=o[Symbol.asyncIterator],i;return m?m.call(o):(o=typeof __values==="function"?__values(o):o[Symbol.iterator](),i={},verb("next"),verb("throw"),verb("return"),i[Symbol.asyncIterator]=function(){return this;},i);function verb(n){i[n]=o[n]&&function(v){return new Promise(function(resolve,reject){v=o[n](v),settle(resolve,reject,v.done,v.value);});};}
function settle(resolve,reject,d,v){Promise.resolve(v).then(function(v){resolve({value:v,done:d});},reject);}}
function __makeTemplateObject(cooked,raw){if(Object.defineProperty){Object.defineProperty(cooked,"raw",{value:raw});}else{cooked.raw=raw;}
return cooked;};var __setModuleDefault=Object.create?(function(o,v){Object.defineProperty(o,"default",{enumerable:true,value:v});}):function(o,v){o["default"]=v;};function __importStar(mod){if(mod&&mod.__esModule)return mod;var result={};if(mod!=null)for(var k in mod)if(k!=="default"&&Object.prototype.hasOwnProperty.call(mod,k))__createBinding(result,mod,k);__setModuleDefault(result,mod);return result;}
function __importDefault(mod){return(mod&&mod.__esModule)?mod:{default:mod};}
function __classPrivateFieldGet(receiver,state,kind,f){if(kind==="a"&&!f)throw new TypeError("Private accessor was defined without a getter");if(typeof state==="function"?receiver!==state||!f:!state.has(receiver))throw new TypeError("Cannot read private member from an object whose class did not declare it");return kind==="m"?f:kind==="a"?f.call(receiver):f?f.value:state.get(receiver);}
function __classPrivateFieldSet(receiver,state,value,kind,f){if(kind==="m")throw new TypeError("Private method is not writable");if(kind==="a"&&!f)throw new TypeError("Private accessor was defined without a setter");if(typeof state==="function"?receiver!==state||!f:!state.has(receiver))throw new TypeError("Cannot write private member to an object whose class did not declare it");return(kind==="a"?f.call(receiver,value):f?f.value=value:state.set(receiver,value)),value;};var SUPPORTED_LOCALE={tr:{regexp:/\u0130|\u0049|\u0049\u0307/g,map:{İ:"\u0069",I:"\u0131",İ:"\u0069",},},az:{regexp:/\u0130/g,map:{İ:"\u0069",I:"\u0131",İ:"\u0069",},},lt:{regexp:/\u0049|\u004A|\u012E|\u00CC|\u00CD|\u0128/g,map:{I:"\u0069\u0307",J:"\u006A\u0307",Į:"\u012F\u0307",Ì:"\u0069\u0307\u0300",Í:"\u0069\u0307\u0301",Ĩ:"\u0069\u0307\u0303",},},};function localeLowerCase(str,locale){var lang=SUPPORTED_LOCALE[locale.toLowerCase()];if(lang)
return lowerCase(str.replace(lang.regexp,function(m){return lang.map[m];}));return lowerCase(str);}
function lowerCase(str){return str.toLowerCase();};var DEFAULT_SPLIT_REGEXP=[/([a-z0-9])([A-Z])/g,/([A-Z])([A-Z][a-z])/g];var DEFAULT_STRIP_REGEXP=/[^A-Z0-9]+/gi;function noCase(input,options){if(options===void 0){options={};}
var _a=options.splitRegexp,splitRegexp=_a===void 0?DEFAULT_SPLIT_REGEXP:_a,_b=options.stripRegexp,stripRegexp=_b===void 0?DEFAULT_STRIP_REGEXP:_b,_c=options.transform,transform=_c===void 0?lowerCase:_c,_d=options.delimiter,delimiter=_d===void 0?" ":_d;var result=replace(replace(input,splitRegexp,"$1\0$2"),stripRegexp,"\0");var start=0;var end=result.length;while(result.charAt(start)==="\0")
start++;while(result.charAt(end-1)==="\0")
end--;return result.slice(start,end).split("\0").map(transform).join(delimiter);}
function replace(input,re,value){if(re instanceof RegExp)
return input.replace(re,value);return re.reduce(function(input,re){return input.replace(re,value);},input);};function upperCaseFirst(input){return input.charAt(0).toUpperCase()+input.substr(1);};function capitalCaseTransform(input){return upperCaseFirst(input.toLowerCase());}
function capitalCase(input,options){if(options===void 0){options={};}
return noCase(input,__assign({delimiter:" ",transform:capitalCaseTransform},options));};var external_wp_i18n_namespaceObject=window["wp"]["i18n"];;function isAppleOS(){let _window=arguments.length>0&&arguments[0]!==undefined?arguments[0]:null;if(!_window){if(typeof window==='undefined'){return false;}
_window=window;}
const{platform}=_window.navigator;return platform.indexOf('Mac')!==-1||['iPad','iPhone'].includes(platform);};const BACKSPACE=8;const TAB=9;const ENTER=13;const ESCAPE=27;const SPACE=32;const PAGEUP=33;const PAGEDOWN=34;const END=35;const HOME=36;const LEFT=37;const UP=38;const RIGHT=39;const DOWN=40;const DELETE=46;const F10=121;const ALT='alt';const CTRL='ctrl';const COMMAND='meta';const SHIFT='shift';const ZERO=48;function mapValues(object,mapFn){return Object.fromEntries(Object.entries(object).map(_ref=>{let[key,value]=_ref;return[key,mapFn(value)];}));}
const modifiers={primary:_isApple=>_isApple()?[COMMAND]:[CTRL],primaryShift:_isApple=>_isApple()?[SHIFT,COMMAND]:[CTRL,SHIFT],primaryAlt:_isApple=>_isApple()?[ALT,COMMAND]:[CTRL,ALT],secondary:_isApple=>_isApple()?[SHIFT,ALT,COMMAND]:[CTRL,SHIFT,ALT],access:_isApple=>_isApple()?[CTRL,ALT]:[SHIFT,ALT],ctrl:()=>[CTRL],alt:()=>[ALT],ctrlShift:()=>[CTRL,SHIFT],shift:()=>[SHIFT],shiftAlt:()=>[SHIFT,ALT],undefined:()=>[]};const rawShortcut=mapValues(modifiers,(modifier)=>{return(function(character){let _isApple=arguments.length>1&&arguments[1]!==undefined?arguments[1]:isAppleOS;return[...modifier(_isApple),character.toLowerCase()].join('+');});});const displayShortcutList=mapValues(modifiers,(modifier)=>{return(function(character){let _isApple=arguments.length>1&&arguments[1]!==undefined?arguments[1]:isAppleOS;const isApple=_isApple();const replacementKeyMap={[ALT]:isApple?'⌥':'Alt',[CTRL]:isApple?'⌃':'Ctrl',[COMMAND]:'⌘',[SHIFT]:isApple?'⇧':'Shift'};const modifierKeys=modifier(_isApple).reduce((accumulator,key)=>{var _replacementKeyMap$ke;const replacementKey=(_replacementKeyMap$ke=replacementKeyMap[key])!==null&&_replacementKeyMap$ke!==void 0?_replacementKeyMap$ke:key;if(isApple){return[...accumulator,replacementKey];}
return[...accumulator,replacementKey,'+'];},[]);const capitalizedCharacter=capitalCase(character,{stripRegexp:/[^A-Z0-9~`,\.\\\-]/gi});return[...modifierKeys,capitalizedCharacter];});});const displayShortcut=mapValues(displayShortcutList,(shortcutList)=>{return(function(character){let _isApple=arguments.length>1&&arguments[1]!==undefined?arguments[1]:isAppleOS;return shortcutList(character,_isApple).join('');});});const shortcutAriaLabel=mapValues(modifiers,(modifier)=>{return(function(character){let _isApple=arguments.length>1&&arguments[1]!==undefined?arguments[1]:isAppleOS;const isApple=_isApple();const replacementKeyMap={[SHIFT]:'Shift',[COMMAND]:isApple?'Command':'Control',[CTRL]:'Control',[ALT]:isApple?'Option':'Alt',',':(0,external_wp_i18n_namespaceObject.__)('Comma'),'.':(0,external_wp_i18n_namespaceObject.__)('Period'),'`':(0,external_wp_i18n_namespaceObject.__)('Backtick'),'~':(0,external_wp_i18n_namespaceObject.__)('Tilde')};return[...modifier(_isApple),character].map(key=>{var _replacementKeyMap$ke2;return capitalCase((_replacementKeyMap$ke2=replacementKeyMap[key])!==null&&_replacementKeyMap$ke2!==void 0?_replacementKeyMap$ke2:key);}).join(isApple?' ':' + ');});});function getEventModifiers(event){return([ALT,CTRL,COMMAND,SHIFT].filter(key=>event[`${key}Key`]));}
const isKeyboardEvent=mapValues(modifiers,(getModifiers)=>{return(function(event,character){let _isApple=arguments.length>2&&arguments[2]!==undefined?arguments[2]:isAppleOS;const mods=getModifiers(_isApple);const eventMods=getEventModifiers(event);const replacementWithShiftKeyMap={Comma:',',Backslash:'\\',IntlRo:'\\',IntlYen:'\\'};const modsDiff=mods.filter(mod=>!eventMods.includes(mod));const eventModsDiff=eventMods.filter(mod=>!mods.includes(mod));if(modsDiff.length>0||eventModsDiff.length>0){return false;}
let key=event.key.toLowerCase();if(!character){return mods.includes(key);}
if(event.altKey&&character.length===1){key=String.fromCharCode(event.keyCode).toLowerCase();}
if(event.shiftKey&&character.length===1&&replacementWithShiftKeyMap[event.code]){key=replacementWithShiftKeyMap[event.code];}
if(character==='del'){character='delete';}
return key===character.toLowerCase();});});(window.wp=window.wp||{}).keycodes=__webpack_exports__;})();