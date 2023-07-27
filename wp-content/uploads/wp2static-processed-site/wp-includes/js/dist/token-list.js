(function(){"use strict";var __webpack_require__={};!function(){__webpack_require__.d=function(exports,definition){for(var key in definition){if(__webpack_require__.o(definition,key)&&!__webpack_require__.o(exports,key)){Object.defineProperty(exports,key,{enumerable:true,get:definition[key]});}}};}();!function(){__webpack_require__.o=function(obj,prop){return Object.prototype.hasOwnProperty.call(obj,prop);}}();var __webpack_exports__={};__webpack_require__.d(__webpack_exports__,{"default":function(){return TokenList;}});class TokenList{constructor(){let initialValue=arguments.length>0&&arguments[0]!==undefined?arguments[0]:'';this.value=initialValue;this._currentValue;this._valueAsArray;}
entries(){return this._valueAsArray.entries(...arguments);}
forEach(){return this._valueAsArray.forEach(...arguments);}
keys(){return this._valueAsArray.keys(...arguments);}
values(){return this._valueAsArray.values(...arguments);}
get value(){return this._currentValue;}
set value(value){value=String(value);this._valueAsArray=[...new Set(value.split(/\s+/g).filter(Boolean))];this._currentValue=this._valueAsArray.join(' ');}
get length(){return this._valueAsArray.length;}
toString(){return this.value;}*[Symbol.iterator](){return yield*this._valueAsArray;}
item(index){return this._valueAsArray[index];}
contains(item){return this._valueAsArray.indexOf(item)!==-1;}
add(){for(var _len=arguments.length,items=new Array(_len),_key=0;_key<_len;_key++){items[_key]=arguments[_key];}
this.value+=' '+items.join(' ');}
remove(){for(var _len2=arguments.length,items=new Array(_len2),_key2=0;_key2<_len2;_key2++){items[_key2]=arguments[_key2];}
this.value=this._valueAsArray.filter(val=>!items.includes(val)).join(' ');}
toggle(token,force){if(undefined===force){force=!this.contains(token);}
if(force){this.add(token);}else{this.remove(token);}
return force;}
replace(token,newToken){if(!this.contains(token)){return false;}
this.remove(token);this.add(newToken);return true;}
supports(){return true;}}
(window.wp=window.wp||{}).tokenList=__webpack_exports__["default"];})();