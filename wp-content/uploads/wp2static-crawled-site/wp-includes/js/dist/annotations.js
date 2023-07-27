(function(){"use strict";var __webpack_require__={};!function(){__webpack_require__.d=function(exports,definition){for(var key in definition){if(__webpack_require__.o(definition,key)&&!__webpack_require__.o(exports,key)){Object.defineProperty(exports,key,{enumerable:true,get:definition[key]});}}};}();!function(){__webpack_require__.o=function(obj,prop){return Object.prototype.hasOwnProperty.call(obj,prop);}}();!function(){__webpack_require__.r=function(exports){if(typeof Symbol!=='undefined'&&Symbol.toStringTag){Object.defineProperty(exports,Symbol.toStringTag,{value:'Module'});}
Object.defineProperty(exports,'__esModule',{value:true});};}();var __webpack_exports__={};__webpack_require__.r(__webpack_exports__);__webpack_require__.d(__webpack_exports__,{"store":function(){return store;}});var selectors_namespaceObject={};__webpack_require__.r(selectors_namespaceObject);__webpack_require__.d(selectors_namespaceObject,{"__experimentalGetAllAnnotationsForBlock":function(){return __experimentalGetAllAnnotationsForBlock;},"__experimentalGetAnnotations":function(){return __experimentalGetAnnotations;},"__experimentalGetAnnotationsForBlock":function(){return __experimentalGetAnnotationsForBlock;},"__experimentalGetAnnotationsForRichText":function(){return __experimentalGetAnnotationsForRichText;}});var actions_namespaceObject={};__webpack_require__.r(actions_namespaceObject);__webpack_require__.d(actions_namespaceObject,{"__experimentalAddAnnotation":function(){return __experimentalAddAnnotation;},"__experimentalRemoveAnnotation":function(){return __experimentalRemoveAnnotation;},"__experimentalRemoveAnnotationsBySource":function(){return __experimentalRemoveAnnotationsBySource;},"__experimentalUpdateAnnotationRange":function(){return __experimentalUpdateAnnotationRange;}});;var external_wp_richText_namespaceObject=window["wp"]["richText"];;var external_wp_i18n_namespaceObject=window["wp"]["i18n"];;const STORE_NAME='core/annotations';;const FORMAT_NAME='core/annotation';const ANNOTATION_ATTRIBUTE_PREFIX='annotation-text-';function applyAnnotations(record){let annotations=arguments.length>1&&arguments[1]!==undefined?arguments[1]:[];annotations.forEach(annotation=>{let{start,end}=annotation;if(start>record.text.length){start=record.text.length;}
if(end>record.text.length){end=record.text.length;}
const className=ANNOTATION_ATTRIBUTE_PREFIX+annotation.source;const id=ANNOTATION_ATTRIBUTE_PREFIX+annotation.id;record=(0,external_wp_richText_namespaceObject.applyFormat)(record,{type:FORMAT_NAME,attributes:{className,id}},start,end);});return record;}
function removeAnnotations(record){return removeFormat(record,'core/annotation',0,record.text.length);}
function retrieveAnnotationPositions(formats){const positions={};formats.forEach((characterFormats,i)=>{characterFormats=characterFormats||[];characterFormats=characterFormats.filter(format=>format.type===FORMAT_NAME);characterFormats.forEach(format=>{let{id}=format.attributes;id=id.replace(ANNOTATION_ATTRIBUTE_PREFIX,'');if(!positions.hasOwnProperty(id)){positions[id]={start:i};}
positions[id].end=i+1;});});return positions;}
function updateAnnotationsWithPositions(annotations,positions,_ref){let{removeAnnotation,updateAnnotationRange}=_ref;annotations.forEach(currentAnnotation=>{const position=positions[currentAnnotation.id];if(!position){removeAnnotation(currentAnnotation.id);return;}
const{start,end}=currentAnnotation;if(start!==position.start||end!==position.end){updateAnnotationRange(currentAnnotation.id,position.start,position.end);}});}
const annotation={name:FORMAT_NAME,title:(0,external_wp_i18n_namespaceObject.__)('Annotation'),tagName:'mark',className:'annotation-text',attributes:{className:'class',id:'id'},edit(){return null;},__experimentalGetPropsForEditableTreePreparation(select,_ref2){let{richTextIdentifier,blockClientId}=_ref2;return{annotations:select(STORE_NAME).__experimentalGetAnnotationsForRichText(blockClientId,richTextIdentifier)};},__experimentalCreatePrepareEditableTree(_ref3){let{annotations}=_ref3;return(formats,text)=>{if(annotations.length===0){return formats;}
let record={formats,text};record=applyAnnotations(record,annotations);return record.formats;};},__experimentalGetPropsForEditableTreeChangeHandler(dispatch){return{removeAnnotation:dispatch(STORE_NAME).__experimentalRemoveAnnotation,updateAnnotationRange:dispatch(STORE_NAME).__experimentalUpdateAnnotationRange};},__experimentalCreateOnChangeEditableValue(props){return formats=>{const positions=retrieveAnnotationPositions(formats);const{removeAnnotation,updateAnnotationRange,annotations}=props;updateAnnotationsWithPositions(annotations,positions,{removeAnnotation,updateAnnotationRange});};}};;const{name:format_name,...settings}=annotation;(0,external_wp_richText_namespaceObject.registerFormatType)(format_name,settings);;var external_wp_hooks_namespaceObject=window["wp"]["hooks"];;var external_wp_data_namespaceObject=window["wp"]["data"];;const addAnnotationClassName=OriginalComponent=>{return(0,external_wp_data_namespaceObject.withSelect)((select,_ref)=>{let{clientId,className}=_ref;const annotations=select(STORE_NAME).__experimentalGetAnnotationsForBlock(clientId);return{className:annotations.map(annotation=>{return 'is-annotated-by-'+annotation.source;}).concat(className).filter(Boolean).join(' ')};})(OriginalComponent);};(0,external_wp_hooks_namespaceObject.addFilter)('editor.BlockListBlock','core/annotations',addAnnotationClassName);;function filterWithReference(collection,predicate){const filteredCollection=collection.filter(predicate);return collection.length===filteredCollection.length?collection:filteredCollection;}
const mapValues=(obj,callback)=>Object.entries(obj).reduce((acc,_ref)=>{let[key,value]=_ref;return{...acc,[key]:callback(value)};},{});function isValidAnnotationRange(annotation){return typeof annotation.start==='number'&&typeof annotation.end==='number'&&annotation.start<=annotation.end;}
function annotations(){var _state$blockClientId;let state=arguments.length>0&&arguments[0]!==undefined?arguments[0]:{};let action=arguments.length>1?arguments[1]:undefined;switch(action.type){case 'ANNOTATION_ADD':const blockClientId=action.blockClientId;const newAnnotation={id:action.id,blockClientId,richTextIdentifier:action.richTextIdentifier,source:action.source,selector:action.selector,range:action.range};if(newAnnotation.selector==='range'&&!isValidAnnotationRange(newAnnotation.range)){return state;}
const previousAnnotationsForBlock=(_state$blockClientId=state===null||state===void 0?void 0:state[blockClientId])!==null&&_state$blockClientId!==void 0?_state$blockClientId:[];return{...state,[blockClientId]:[...previousAnnotationsForBlock,newAnnotation]};case 'ANNOTATION_REMOVE':return mapValues(state,annotationsForBlock=>{return filterWithReference(annotationsForBlock,annotation=>{return annotation.id!==action.annotationId;});});case 'ANNOTATION_UPDATE_RANGE':return mapValues(state,annotationsForBlock=>{let hasChangedRange=false;const newAnnotations=annotationsForBlock.map(annotation=>{if(annotation.id===action.annotationId){hasChangedRange=true;return{...annotation,range:{start:action.start,end:action.end}};}
return annotation;});return hasChangedRange?newAnnotations:annotationsForBlock;});case 'ANNOTATION_REMOVE_SOURCE':return mapValues(state,annotationsForBlock=>{return filterWithReference(annotationsForBlock,annotation=>{return annotation.source!==action.source;});});}
return state;}
var reducer=(annotations);;var LEAF_KEY={};function arrayOf(value){return[value];}
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
callSelector.getDependants=normalizedGetDependants;callSelector.clear=clear;clear();return(callSelector);};const EMPTY_ARRAY=[];const __experimentalGetAnnotationsForBlock=rememo((state,blockClientId)=>{var _state$blockClientId;return((_state$blockClientId=state===null||state===void 0?void 0:state[blockClientId])!==null&&_state$blockClientId!==void 0?_state$blockClientId:[]).filter(annotation=>{return annotation.selector==='block';});},(state,blockClientId)=>{var _state$blockClientId2;return[(_state$blockClientId2=state===null||state===void 0?void 0:state[blockClientId])!==null&&_state$blockClientId2!==void 0?_state$blockClientId2:EMPTY_ARRAY];});function __experimentalGetAllAnnotationsForBlock(state,blockClientId){var _state$blockClientId3;return(_state$blockClientId3=state===null||state===void 0?void 0:state[blockClientId])!==null&&_state$blockClientId3!==void 0?_state$blockClientId3:EMPTY_ARRAY;}
const __experimentalGetAnnotationsForRichText=rememo((state,blockClientId,richTextIdentifier)=>{var _state$blockClientId4;return((_state$blockClientId4=state===null||state===void 0?void 0:state[blockClientId])!==null&&_state$blockClientId4!==void 0?_state$blockClientId4:[]).filter(annotation=>{return annotation.selector==='range'&&richTextIdentifier===annotation.richTextIdentifier;}).map(annotation=>{const{range,...other}=annotation;return{...range,...other};});},(state,blockClientId)=>{var _state$blockClientId5;return[(_state$blockClientId5=state===null||state===void 0?void 0:state[blockClientId])!==null&&_state$blockClientId5!==void 0?_state$blockClientId5:EMPTY_ARRAY];});function __experimentalGetAnnotations(state){return Object.values(state).flat();};var getRandomValues;var rnds8=new Uint8Array(16);function rng(){if(!getRandomValues){getRandomValues=typeof crypto!=='undefined'&&crypto.getRandomValues&&crypto.getRandomValues.bind(crypto)||typeof msCrypto!=='undefined'&&typeof msCrypto.getRandomValues==='function'&&msCrypto.getRandomValues.bind(msCrypto);if(!getRandomValues){throw new Error('crypto.getRandomValues() not supported. See https://github.com/uuidjs/uuid#getrandomvalues-not-supported');}}
return getRandomValues(rnds8);};var regex=(/^(?:[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}|00000000-0000-0000-0000-000000000000)$/i);;function validate(uuid){return typeof uuid==='string'&&regex.test(uuid);}
var esm_browser_validate=(validate);;var byteToHex=[];for(var i=0;i<256;++i){byteToHex.push((i+0x100).toString(16).substr(1));}
function stringify(arr){var offset=arguments.length>1&&arguments[1]!==undefined?arguments[1]:0;var uuid=(byteToHex[arr[offset+0]]+byteToHex[arr[offset+1]]+byteToHex[arr[offset+2]]+byteToHex[arr[offset+3]]+'-'+byteToHex[arr[offset+4]]+byteToHex[arr[offset+5]]+'-'+byteToHex[arr[offset+6]]+byteToHex[arr[offset+7]]+'-'+byteToHex[arr[offset+8]]+byteToHex[arr[offset+9]]+'-'+byteToHex[arr[offset+10]]+byteToHex[arr[offset+11]]+byteToHex[arr[offset+12]]+byteToHex[arr[offset+13]]+byteToHex[arr[offset+14]]+byteToHex[arr[offset+15]]).toLowerCase();if(!esm_browser_validate(uuid)){throw TypeError('Stringified UUID is invalid');}
return uuid;}
var esm_browser_stringify=(stringify);;function v4(options,buf,offset){options=options||{};var rnds=options.random||(options.rng||rng)();rnds[6]=rnds[6]&0x0f|0x40;rnds[8]=rnds[8]&0x3f|0x80;if(buf){offset=offset||0;for(var i=0;i<16;++i){buf[offset+i]=rnds[i];}
return buf;}
return esm_browser_stringify(rnds);}
var esm_browser_v4=(v4);;function __experimentalAddAnnotation(_ref){let{blockClientId,richTextIdentifier=null,range=null,selector='range',source='default',id=esm_browser_v4()}=_ref;const action={type:'ANNOTATION_ADD',id,blockClientId,richTextIdentifier,source,selector};if(selector==='range'){action.range=range;}
return action;}
function __experimentalRemoveAnnotation(annotationId){return{type:'ANNOTATION_REMOVE',annotationId};}
function __experimentalUpdateAnnotationRange(annotationId,start,end){return{type:'ANNOTATION_UPDATE_RANGE',annotationId,start,end};}
function __experimentalRemoveAnnotationsBySource(source){return{type:'ANNOTATION_REMOVE_SOURCE',source};};const store=(0,external_wp_data_namespaceObject.createReduxStore)(STORE_NAME,{reducer:reducer,selectors:selectors_namespaceObject,actions:actions_namespaceObject});(0,external_wp_data_namespaceObject.register)(store);;(window.wp=window.wp||{}).annotations=__webpack_exports__;})();