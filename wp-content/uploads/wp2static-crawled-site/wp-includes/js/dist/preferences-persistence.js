(function(){"use strict";var __webpack_require__={};!function(){__webpack_require__.n=function(module){var getter=module&&module.__esModule?function(){return module['default'];}:function(){return module;};__webpack_require__.d(getter,{a:getter});return getter;};}();!function(){__webpack_require__.d=function(exports,definition){for(var key in definition){if(__webpack_require__.o(definition,key)&&!__webpack_require__.o(exports,key)){Object.defineProperty(exports,key,{enumerable:true,get:definition[key]});}}};}();!function(){__webpack_require__.o=function(obj,prop){return Object.prototype.hasOwnProperty.call(obj,prop);}}();!function(){__webpack_require__.r=function(exports){if(typeof Symbol!=='undefined'&&Symbol.toStringTag){Object.defineProperty(exports,Symbol.toStringTag,{value:'Module'});}
Object.defineProperty(exports,'__esModule',{value:true});};}();var __webpack_exports__={};__webpack_require__.r(__webpack_exports__);__webpack_require__.d(__webpack_exports__,{"__unstableCreatePersistenceLayer":function(){return __unstableCreatePersistenceLayer;},"create":function(){return create;}});;var external_wp_apiFetch_namespaceObject=window["wp"]["apiFetch"];var external_wp_apiFetch_default=__webpack_require__.n(external_wp_apiFetch_namespaceObject);;function debounceAsync(func,delayMS){let timeoutId;let activePromise;return async function debounced(){for(var _len=arguments.length,args=new Array(_len),_key=0;_key<_len;_key++){args[_key]=arguments[_key];}
if(!activePromise&&!timeoutId){return new Promise((resolve,reject)=>{activePromise=func(...args).then(function(){resolve(...arguments);}).catch(error=>{reject(error);}).finally(()=>{activePromise=null;});});}
if(activePromise){await activePromise;}
if(timeoutId){clearTimeout(timeoutId);timeoutId=null;}
return new Promise((resolve,reject)=>{timeoutId=setTimeout(()=>{activePromise=func(...args).then(function(){resolve(...arguments);}).catch(error=>{reject(error);}).finally(()=>{activePromise=null;timeoutId=null;});},delayMS);});};};const EMPTY_OBJECT={};const localStorage=window.localStorage;function create(){let{preloadedData,localStorageRestoreKey='WP_PREFERENCES_RESTORE_DATA',requestDebounceMS=2500}=arguments.length>0&&arguments[0]!==undefined?arguments[0]:{};let cache=preloadedData;const debouncedApiFetch=debounceAsync((external_wp_apiFetch_default()),requestDebounceMS);async function get(){var _user$meta;if(cache){return cache;}
const user=await external_wp_apiFetch_default()({path:'/wp/v2/users/me?context=edit'});const serverData=user===null||user===void 0?void 0:(_user$meta=user.meta)===null||_user$meta===void 0?void 0:_user$meta.persisted_preferences;const localData=JSON.parse(localStorage.getItem(localStorageRestoreKey));const serverTimestamp=Date.parse(serverData===null||serverData===void 0?void 0:serverData._modified)||0;const localTimestamp=Date.parse(localData===null||localData===void 0?void 0:localData._modified)||0;if(serverData&&serverTimestamp>=localTimestamp){cache=serverData;}else if(localData){cache=localData;}else{cache=EMPTY_OBJECT;}
return cache;}
function set(newData){const dataWithTimestamp={...newData,_modified:new Date().toISOString()};cache=dataWithTimestamp;localStorage.setItem(localStorageRestoreKey,JSON.stringify(dataWithTimestamp));debouncedApiFetch({path:'/wp/v2/users/me',method:'PUT',keepalive:true,data:{meta:{persisted_preferences:dataWithTimestamp}}}).catch(()=>{});}
return{get,set};};function moveFeaturePreferences(state,sourceStoreName){var _state$interfaceStore,_state$interfaceStore2,_state$interfaceStore3,_state$sourceStoreNam,_state$sourceStoreNam2,_state$preferencesSto;const preferencesStoreName='core/preferences';const interfaceStoreName='core/interface';const interfaceFeatures=state===null||state===void 0?void 0:(_state$interfaceStore=state[interfaceStoreName])===null||_state$interfaceStore===void 0?void 0:(_state$interfaceStore2=_state$interfaceStore.preferences)===null||_state$interfaceStore2===void 0?void 0:(_state$interfaceStore3=_state$interfaceStore2.features)===null||_state$interfaceStore3===void 0?void 0:_state$interfaceStore3[sourceStoreName];const sourceFeatures=state===null||state===void 0?void 0:(_state$sourceStoreNam=state[sourceStoreName])===null||_state$sourceStoreNam===void 0?void 0:(_state$sourceStoreNam2=_state$sourceStoreNam.preferences)===null||_state$sourceStoreNam2===void 0?void 0:_state$sourceStoreNam2.features;const featuresToMigrate=interfaceFeatures?interfaceFeatures:sourceFeatures;if(!featuresToMigrate){return state;}
const existingPreferences=state===null||state===void 0?void 0:(_state$preferencesSto=state[preferencesStoreName])===null||_state$preferencesSto===void 0?void 0:_state$preferencesSto.preferences;if(existingPreferences!==null&&existingPreferences!==void 0&&existingPreferences[sourceStoreName]){return state;}
let updatedInterfaceState;if(interfaceFeatures){var _state$interfaceStore4,_state$interfaceStore5;const otherInterfaceState=state===null||state===void 0?void 0:state[interfaceStoreName];const otherInterfaceScopes=state===null||state===void 0?void 0:(_state$interfaceStore4=state[interfaceStoreName])===null||_state$interfaceStore4===void 0?void 0:(_state$interfaceStore5=_state$interfaceStore4.preferences)===null||_state$interfaceStore5===void 0?void 0:_state$interfaceStore5.features;updatedInterfaceState={[interfaceStoreName]:{...otherInterfaceState,preferences:{features:{...otherInterfaceScopes,[sourceStoreName]:undefined}}}};}
let updatedSourceState;if(sourceFeatures){var _state$sourceStoreNam3;const otherSourceState=state===null||state===void 0?void 0:state[sourceStoreName];const sourcePreferences=state===null||state===void 0?void 0:(_state$sourceStoreNam3=state[sourceStoreName])===null||_state$sourceStoreNam3===void 0?void 0:_state$sourceStoreNam3.preferences;updatedSourceState={[sourceStoreName]:{...otherSourceState,preferences:{...sourcePreferences,features:undefined}}};}
return{...state,[preferencesStoreName]:{preferences:{...existingPreferences,[sourceStoreName]:featuresToMigrate}},...updatedInterfaceState,...updatedSourceState};};function moveThirdPartyFeaturePreferencesToPreferences(state){var _state$interfaceStore,_state$interfaceStore2;const interfaceStoreName='core/interface';const preferencesStoreName='core/preferences';const interfaceScopes=state===null||state===void 0?void 0:(_state$interfaceStore=state[interfaceStoreName])===null||_state$interfaceStore===void 0?void 0:(_state$interfaceStore2=_state$interfaceStore.preferences)===null||_state$interfaceStore2===void 0?void 0:_state$interfaceStore2.features;const interfaceScopeKeys=interfaceScopes?Object.keys(interfaceScopes):[];if(!(interfaceScopeKeys!==null&&interfaceScopeKeys!==void 0&&interfaceScopeKeys.length)){return state;}
return interfaceScopeKeys.reduce(function(convertedState,scope){var _convertedState$prefe,_convertedState$prefe2,_convertedState$prefe3,_convertedState$inter,_convertedState$inter2;if(scope.startsWith('core')){return convertedState;}
const featuresToMigrate=interfaceScopes===null||interfaceScopes===void 0?void 0:interfaceScopes[scope];if(!featuresToMigrate){return convertedState;}
const existingMigratedData=convertedState===null||convertedState===void 0?void 0:(_convertedState$prefe=convertedState[preferencesStoreName])===null||_convertedState$prefe===void 0?void 0:(_convertedState$prefe2=_convertedState$prefe.preferences)===null||_convertedState$prefe2===void 0?void 0:_convertedState$prefe2[scope];if(existingMigratedData){return convertedState;}
const otherPreferencesScopes=convertedState===null||convertedState===void 0?void 0:(_convertedState$prefe3=convertedState[preferencesStoreName])===null||_convertedState$prefe3===void 0?void 0:_convertedState$prefe3.preferences;const otherInterfaceState=convertedState===null||convertedState===void 0?void 0:convertedState[interfaceStoreName];const otherInterfaceScopes=convertedState===null||convertedState===void 0?void 0:(_convertedState$inter=convertedState[interfaceStoreName])===null||_convertedState$inter===void 0?void 0:(_convertedState$inter2=_convertedState$inter.preferences)===null||_convertedState$inter2===void 0?void 0:_convertedState$inter2.features;return{...convertedState,[preferencesStoreName]:{preferences:{...otherPreferencesScopes,[scope]:featuresToMigrate}},[interfaceStoreName]:{...otherInterfaceState,preferences:{features:{...otherInterfaceScopes,[scope]:undefined}}}};},state);};const identity=arg=>arg;function moveIndividualPreferenceToPreferences(state,_ref,key){var _state$sourceStoreNam,_state$sourceStoreNam2,_state$preferencesSto,_state$preferencesSto2,_state$preferencesSto3,_state$preferencesSto4,_state$preferencesSto5,_state$preferencesSto6,_state$sourceStoreNam3;let{from:sourceStoreName,to:scope}=_ref;let convert=arguments.length>3&&arguments[3]!==undefined?arguments[3]:identity;const preferencesStoreName='core/preferences';const sourcePreference=state===null||state===void 0?void 0:(_state$sourceStoreNam=state[sourceStoreName])===null||_state$sourceStoreNam===void 0?void 0:(_state$sourceStoreNam2=_state$sourceStoreNam.preferences)===null||_state$sourceStoreNam2===void 0?void 0:_state$sourceStoreNam2[key];if(sourcePreference===undefined){return state;}
const targetPreference=state===null||state===void 0?void 0:(_state$preferencesSto=state[preferencesStoreName])===null||_state$preferencesSto===void 0?void 0:(_state$preferencesSto2=_state$preferencesSto.preferences)===null||_state$preferencesSto2===void 0?void 0:(_state$preferencesSto3=_state$preferencesSto2[scope])===null||_state$preferencesSto3===void 0?void 0:_state$preferencesSto3[key];if(targetPreference){return state;}
const otherScopes=state===null||state===void 0?void 0:(_state$preferencesSto4=state[preferencesStoreName])===null||_state$preferencesSto4===void 0?void 0:_state$preferencesSto4.preferences;const otherPreferences=state===null||state===void 0?void 0:(_state$preferencesSto5=state[preferencesStoreName])===null||_state$preferencesSto5===void 0?void 0:(_state$preferencesSto6=_state$preferencesSto5.preferences)===null||_state$preferencesSto6===void 0?void 0:_state$preferencesSto6[scope];const otherSourceState=state===null||state===void 0?void 0:state[sourceStoreName];const allSourcePreferences=state===null||state===void 0?void 0:(_state$sourceStoreNam3=state[sourceStoreName])===null||_state$sourceStoreNam3===void 0?void 0:_state$sourceStoreNam3.preferences;const convertedPreferences=convert({[key]:sourcePreference});return{...state,[preferencesStoreName]:{preferences:{...otherScopes,[scope]:{...otherPreferences,...convertedPreferences}}},[sourceStoreName]:{...otherSourceState,preferences:{...allSourcePreferences,[key]:undefined}}};};function moveInterfaceEnableItems(state){var _state$interfaceStore,_state$preferencesSto,_state$preferencesSto2,_sourceEnableItems$si,_sourceEnableItems$si2,_sourceEnableItems$mu,_sourceEnableItems$mu2;const interfaceStoreName='core/interface';const preferencesStoreName='core/preferences';const sourceEnableItems=state===null||state===void 0?void 0:(_state$interfaceStore=state[interfaceStoreName])===null||_state$interfaceStore===void 0?void 0:_state$interfaceStore.enableItems;if(!sourceEnableItems){return state;}
const allPreferences=(_state$preferencesSto=state===null||state===void 0?void 0:(_state$preferencesSto2=state[preferencesStoreName])===null||_state$preferencesSto2===void 0?void 0:_state$preferencesSto2.preferences)!==null&&_state$preferencesSto!==void 0?_state$preferencesSto:{};const sourceComplementaryAreas=(_sourceEnableItems$si=sourceEnableItems===null||sourceEnableItems===void 0?void 0:(_sourceEnableItems$si2=sourceEnableItems.singleEnableItems)===null||_sourceEnableItems$si2===void 0?void 0:_sourceEnableItems$si2.complementaryArea)!==null&&_sourceEnableItems$si!==void 0?_sourceEnableItems$si:{};const preferencesWithConvertedComplementaryAreas=Object.keys(sourceComplementaryAreas).reduce((accumulator,scope)=>{var _accumulator$scope;const data=sourceComplementaryAreas[scope];if(accumulator!==null&&accumulator!==void 0&&(_accumulator$scope=accumulator[scope])!==null&&_accumulator$scope!==void 0&&_accumulator$scope.complementaryArea){return accumulator;}
return{...accumulator,[scope]:{...accumulator[scope],complementaryArea:data}};},allPreferences);const sourcePinnedItems=(_sourceEnableItems$mu=sourceEnableItems===null||sourceEnableItems===void 0?void 0:(_sourceEnableItems$mu2=sourceEnableItems.multipleEnableItems)===null||_sourceEnableItems$mu2===void 0?void 0:_sourceEnableItems$mu2.pinnedItems)!==null&&_sourceEnableItems$mu!==void 0?_sourceEnableItems$mu:{};const allConvertedData=Object.keys(sourcePinnedItems).reduce((accumulator,scope)=>{var _accumulator$scope2;const data=sourcePinnedItems[scope];if(accumulator!==null&&accumulator!==void 0&&(_accumulator$scope2=accumulator[scope])!==null&&_accumulator$scope2!==void 0&&_accumulator$scope2.pinnedItems){return accumulator;}
return{...accumulator,[scope]:{...accumulator[scope],pinnedItems:data}};},preferencesWithConvertedComplementaryAreas);const otherInterfaceItems=state[interfaceStoreName];return{...state,[preferencesStoreName]:{preferences:allConvertedData},[interfaceStoreName]:{...otherInterfaceItems,enableItems:undefined}};};function convertEditPostPanels(preferences){var _preferences$panels;const panels=(_preferences$panels=preferences===null||preferences===void 0?void 0:preferences.panels)!==null&&_preferences$panels!==void 0?_preferences$panels:{};return Object.keys(panels).reduce((convertedData,panelName)=>{const panel=panels[panelName];if((panel===null||panel===void 0?void 0:panel.enabled)===false){convertedData.inactivePanels.push(panelName);}
if((panel===null||panel===void 0?void 0:panel.opened)===true){convertedData.openPanels.push(panelName);}
return convertedData;},{inactivePanels:[],openPanels:[]});};function getLegacyData(userId){const key=`WP_DATA_USER_${userId}`;const unparsedData=window.localStorage.getItem(key);return JSON.parse(unparsedData);}
function convertLegacyData(data){var _data,_data$corePreference;if(!data){return;}
data=moveFeaturePreferences(data,'core/edit-widgets');data=moveFeaturePreferences(data,'core/customize-widgets');data=moveFeaturePreferences(data,'core/edit-post');data=moveFeaturePreferences(data,'core/edit-site');data=moveThirdPartyFeaturePreferencesToPreferences(data);data=moveInterfaceEnableItems(data);data=moveIndividualPreferenceToPreferences(data,{from:'core/edit-post',to:'core/edit-post'},'hiddenBlockTypes');data=moveIndividualPreferenceToPreferences(data,{from:'core/edit-post',to:'core/edit-post'},'editorMode');data=moveIndividualPreferenceToPreferences(data,{from:'core/edit-post',to:'core/edit-post'},'preferredStyleVariations');data=moveIndividualPreferenceToPreferences(data,{from:'core/edit-post',to:'core/edit-post'},'panels',convertEditPostPanels);data=moveIndividualPreferenceToPreferences(data,{from:'core/editor',to:'core/edit-post'},'isPublishSidebarEnabled');data=moveIndividualPreferenceToPreferences(data,{from:'core/edit-site',to:'core/edit-site'},'editorMode');return(_data=data)===null||_data===void 0?void 0:(_data$corePreference=_data['core/preferences'])===null||_data$corePreference===void 0?void 0:_data$corePreference.preferences;}
function convertLegacyLocalStorageData(userId){const data=getLegacyData(userId);return convertLegacyData(data);};function convertComplementaryAreas(state){return Object.keys(state).reduce((stateAccumulator,scope)=>{const scopeData=state[scope];if(scopeData!==null&&scopeData!==void 0&&scopeData.complementaryArea){const updatedScopeData={...scopeData};delete updatedScopeData.complementaryArea;updatedScopeData.isComplementaryAreaVisible=true;stateAccumulator[scope]=updatedScopeData;return stateAccumulator;}
return stateAccumulator;},state);};function convertPreferencesPackageData(data){return convertComplementaryAreas(data);};function __unstableCreatePersistenceLayer(serverData,userId){const localStorageRestoreKey=`WP_PREFERENCES_USER_${userId}`;const localData=JSON.parse(window.localStorage.getItem(localStorageRestoreKey));const serverModified=Date.parse(serverData&&serverData._modified)||0;const localModified=Date.parse(localData&&localData._modified)||0;let preloadedData;if(serverData&&serverModified>=localModified){preloadedData=convertPreferencesPackageData(serverData);}else if(localData){preloadedData=convertPreferencesPackageData(localData);}else{preloadedData=convertLegacyLocalStorageData(userId);}
return create({preloadedData,localStorageRestoreKey});}
(window.wp=window.wp||{}).preferencesPersistence=__webpack_exports__;})();