(function(){"use strict";var __webpack_require__={};!function(){__webpack_require__.d=function(exports,definition){for(var key in definition){if(__webpack_require__.o(definition,key)&&!__webpack_require__.o(exports,key)){Object.defineProperty(exports,key,{enumerable:true,get:definition[key]});}}};}();!function(){__webpack_require__.o=function(obj,prop){return Object.prototype.hasOwnProperty.call(obj,prop);}}();!function(){__webpack_require__.r=function(exports){if(typeof Symbol!=='undefined'&&Symbol.toStringTag){Object.defineProperty(exports,Symbol.toStringTag,{value:'Module'});}
Object.defineProperty(exports,'__esModule',{value:true});};}();var __webpack_exports__={};__webpack_require__.r(__webpack_exports__);__webpack_require__.d(__webpack_exports__,{"createBlobURL":function(){return createBlobURL;},"getBlobByURL":function(){return getBlobByURL;},"getBlobTypeByURL":function(){return getBlobTypeByURL;},"isBlobURL":function(){return isBlobURL;},"revokeBlobURL":function(){return revokeBlobURL;}});const cache={};function createBlobURL(file){const url=window.URL.createObjectURL(file);cache[url]=file;return url;}
function getBlobByURL(url){return cache[url];}
function getBlobTypeByURL(url){var _getBlobByURL;return(_getBlobByURL=getBlobByURL(url))===null||_getBlobByURL===void 0?void 0:_getBlobByURL.type.split('/')[0];}
function revokeBlobURL(url){if(cache[url]){window.URL.revokeObjectURL(url);}
delete cache[url];}
function isBlobURL(url){if(!url||!url.indexOf){return false;}
return url.indexOf('blob:')===0;}
(window.wp=window.wp||{}).blob=__webpack_exports__;})();