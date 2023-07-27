function UniteCreatorElementorEditorAdmin(){var t=this;var g_arrPreviews;var g_handle=null;var g_objSettingsPanel;var g_objAddonParams,g_objAddonParamsItems,g_lastAddonName;var g_numRepeaterItems=0;var g_windowFront,g_searchDataID,g_searchData;var g_temp={};function rawurldecode(str){return decodeURIComponent(str+'');}
function utf8_decode(str_data){var tmp_arr=[],i=0,ac=0,c1=0,c2=0,c3=0;str_data+='';while(i<str_data.length){c1=str_data.charCodeAt(i);if(c1<128){tmp_arr[ac++]=String.fromCharCode(c1);i++;}else if(c1>191&&c1<224){c2=str_data.charCodeAt(i+1);tmp_arr[ac++]=String.fromCharCode(((c1&31)<<6)|(c2&63));i+=2;}else{c2=str_data.charCodeAt(i+1);c3=str_data.charCodeAt(i+2);tmp_arr[ac++]=String.fromCharCode(((c1&15)<<12)|((c2&63)<<6)|(c3&63));i+=3;}}
return tmp_arr.join('');}
function base64_decode(data){var b64="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";var o1,o2,o3,h1,h2,h3,h4,bits,i=0,ac=0,dec="",tmp_arr=[];if(!data){return data;}
data+='';do{h1=b64.indexOf(data.charAt(i++));h2=b64.indexOf(data.charAt(i++));h3=b64.indexOf(data.charAt(i++));h4=b64.indexOf(data.charAt(i++));bits=h1<<18|h2<<12|h3<<6|h4;o1=bits>>16&0xff;o2=bits>>8&0xff;o3=bits&0xff;if(h3==64){tmp_arr[ac++]=String.fromCharCode(o1);}else if(h4==64){tmp_arr[ac++]=String.fromCharCode(o1,o2);}else{tmp_arr[ac++]=String.fromCharCode(o1,o2,o3);}}while(i<data.length);dec=tmp_arr.join('');dec=utf8_decode(dec);return dec;}
function trace(str){console.log(str);}
function a________AUDIO_CONTROL_________(){}
function onChooseAudioClick(){var objButton=jQuery(this);var objInput=objButton.siblings("input[type='text']");var objText=objButton.siblings(".uc-audio-control-text");var frame=wp.media({title:"Select Audio File",multiple:false,library:{type:"audio"},button:{text:'Choose'}});frame.on('select',function(){var objSettings=frame.state().get('selection').first().toJSON();var urlFile=objSettings.url;objInput.val(urlFile);objInput.trigger("input");});frame.open();}
function getObjElementorPanel(){var objPanel=jQuery("#elementor-panel");return(objPanel);}
function initAudioControl(){var objPanel=getObjElementorPanel();objPanel.on("click",".uc-button-choose-audio",onChooseAudioClick);}
function getVal(obj,name,defaultValue){if(!defaultValue)
var defaultValue="";var val="";if(!obj||typeof obj!="object")
val=defaultValue;else if(obj.hasOwnProperty(name)==false){val=defaultValue;}else{val=obj[name];}
return(val);}
function htmlspecialchars(string){if(!string)
return(string);return string.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#039;");};function a________POST_TYPE_SELECT_________(){}
function changePostTaxonomySelect(selectPostType,dataPostTypes){var objPanel=getObjElementorPanel();var prefix=selectPostType.data("settingprefix");var selectPostTaxonomy=objPanel.find("select[data-setting='"+prefix+"_taxonomy']");var postType=selectPostType.val();var selectedTax=selectPostTaxonomy.val();var objTax=getVal(dataPostTypes,postType);if(!objTax)
return(true);var objOptions=selectPostTaxonomy.find("option");var firstVisibleOption=null;jQuery.each(objOptions,function(index,option){var objOption=jQuery(option);var optionTax=objOption.prop("value");var taxFound=objTax.hasOwnProperty(optionTax);if(taxFound==true&&firstVisibleOption==null)
firstVisibleOption=optionTax;if(taxFound==true)
objOption.show();else
objOption.hide();});var isCurrentTaxRelevant=objTax.hasOwnProperty(selectedTax);if(isCurrentTaxRelevant==false&&firstVisibleOption){selectPostTaxonomy.val(firstVisibleOption).trigger("change");}}
function onPostTypeSelectChange(){var selectPostType=jQuery(this);var dataPostTypes=selectPostType.data("arrposttypes");if(typeof dataPostTypes=="string"){dataPostTypes=t.decodeContent(dataPostTypes);dataPostTypes=JSON.parse(dataPostTypes);}
var settingType=selectPostType.data("settingtype");if(settingType=="select_post_taxonomy"){changePostTaxonomySelect(selectPostType,dataPostTypes);return(false);}
var objPanel=getObjElementorPanel();var prefix=selectPostType.data("settingprefix");var objSelectPostCategory=objPanel.find("select[data-setting='"+prefix+"_category']");var arrPostTypes=selectPostType.val();if(jQuery.isArray(arrPostTypes)==false)
arrPostTypes=[arrPostTypes];var selectedCatID=objSelectPostCategory.select2("val");var options=[];for(var postType of arrPostTypes){var objPostType=getVal(dataPostTypes,postType);if(!objPostType)
continue;var objCats=objPostType["cats"];jQuery.each(objCats,function(catID,catText){var catShowText=htmlspecialchars(catText);options.push({text:catShowText,id:catID});});}
objSelectPostCategory.empty().select2({data:options,placeholder:"All Terms"});if(selectedCatID)
objSelectPostCategory.val(selectedCatID).trigger("change");}
function initPostTypeSelectControl(){var objPanel=getObjElementorPanel();objPanel.on("change",".unite-setting-post-type",onPostTypeSelectChange);}
function postSelectOnLoad(){var objPanel=getObjElementorPanel();var objSetting=jQuery(".unite-setting-post-type");if(objSetting.length==0)
return(true);var isInited=objSetting.data("isinited");if(isInited==true)
return(true);objSetting.data("isinited",true);setTimeout(function(){objSetting.trigger("change");},500);}
function a________CONSOLIDATION_________(){}
this.decodeContent=function(value){return rawurldecode(base64_decode(value));}
function hideAllControls(){var objWrapper=jQuery("#elementor-controls");var objControls=objWrapper.find(".elementor-control").not(".elementor-control-type-section.elementor-control-section_general").not(".elementor-control-uc_addon_name");objControls.hide();}
function showControlsByNames(arrNames){var objWrapper=jQuery("#elementor-controls");jQuery(arrNames).each(function(index,name){objWrapper.find(".elementor-control-"+name).show();});}
function showRepeaterFields(){var objRepeater=jQuery(".elementor-control-uc_items.elementor-control-type-repeater");if(objRepeater.length==0)
return(false);if(typeof g_objAddonParamsItems=="undefined")
return(false);if(!g_objAddonParamsItems)
return(false);if(!g_objAddonParamsItems.length)
return(false);if(g_objAddonParamsItems.hasOwnProperty(g_lastAddonName)==false)
return(false);var arrItemControls=g_objAddonParamsItems[g_lastAddonName];objRepeater.find(".elementor-control").hide();jQuery.each(arrItemControls,function(index,controlName){var objControl=objRepeater.find(".elementor-control.elementor-control-"+controlName);objControl.show();});}
function hideAllItemsControls(){var objSection=jQuery(".elementor-control.elementor-control-section_uc_items_consolidation");if(objSection.length)
objSection.hide();}
function showActiveControls(){var objAddonSelector=jQuery(this);var addonName=objAddonSelector.val();g_lastAddonName=addonName;var arrParamNames=g_objAddonParams[addonName];hideAllControls();showControlsByNames(arrParamNames);}
function showActiveItemsControls(){if(!g_lastAddonName)
return(false);if(g_objAddonParamsItems.hasOwnProperty(g_lastAddonName)==false)
return(false);var objSection=jQuery(".elementor-control.elementor-control-section_uc_items_consolidation");objSection.show();showRepeaterFields();}
function initAddonsSelector(){var objAddonSelector=g_objSettingsPanel.find(".uc-addon-selector");if(objAddonSelector.length==0)
return(false);var isInited=objAddonSelector.data("isinited");if(isInited===true)
return(false);objAddonSelector.data("isinited",true);var meta=objAddonSelector.data("meta");var jsonMeta=t.decodeContent(meta);var objMeta=jQuery.parseJSON(jsonMeta);g_objAddonParams=objMeta["addon_params"];g_objAddonParamsItems=objMeta["addon_params_items"];objAddonSelector.change(showActiveControls);objAddonSelector.trigger("change");}
function indicateInitControl(sectionType){switch(sectionType){case "style":var selector=".elementor-control.elementor-control-type-section.elementor-control-uc_section_styles_indicator";break;case "items":var selector=".elementor-control.elementor-control-section_uc_items_consolidation";break;default:trace("section type not found: "+sectionType);break;}
if(!g_lastAddonName)
return(false);var objWrapper=jQuery("#elementor-controls");var objControl=objWrapper.find(selector);if(objControl.length==0)
return(false);var isInited=objControl.data("uc_isinited");if(isInited==true){return(false);}
objControl.data("uc_isinited",true);return(true);}
function initStyleControls(){var isFound=indicateInitControl("style");if(isFound==false)
return(false);var arrParamNames=g_objAddonParams[g_lastAddonName];hideAllControls();showControlsByNames(arrParamNames);return(true);}
function initItemsControls(){var isFound=indicateInitControl("items");if(isFound==false)
return(false);var arrParamNames=g_objAddonParams[g_lastAddonName];hideAllItemsControls();showActiveItemsControls();return(true);}
function onSettingsPanelInit(){initAddonsSelector();var isInited=initStyleControls();if(isInited==false)
initItemsControls();postSelectOnLoad();}
function onRepeaterItemClick(){setTimeout(function(){showRepeaterFields();},500);}
function initEvents(){g_objSettingsPanel.bind("DOMSubtreeModified",function(){if(g_handle)
clearTimeout(g_handle);g_handle=setTimeout(onSettingsPanelInit,50);});jQuery(document).on("mousedown",".elementor-control-uc_items .elementor-repeater-row-item-title",onRepeaterItemClick);}
function a________LOAD_INCLUDES_________(){}
function getVal(obj,name,defaultValue,opt){if(!defaultValue)
var defaultValue="";var val="";if(!obj||typeof obj!="object")
val=defaultValue;else if(obj.hasOwnProperty(name)==false){val=defaultValue;}else{val=obj[name];}
return(val);}
function loadDOMIncludeFile(type,url,data){var replaceID=getVal(data,"replaceID");var name=getVal(data,"name");var onload=getVal(data,"onload");var iframeWindow=getVal(data,"iframe");var noRand=getVal(data,"norand");if(!noRand){var rand=Math.floor((Math.random()*100000)+1);if(url.indexOf("?")==-1)
url+="?rand="+rand;else
url+="&rand="+rand;}
if(replaceID)
jQuery("#"+replaceID).remove();var objWindow=window;if(iframeWindow)
objWindow=iframeWindow;switch(type){case "js":var tag=objWindow.document.createElement('script');tag.src=url;if(typeof onload=="function"){tag.onload=function(){onload(jQuery(this),replaceID);};}
var firstScriptTag=objWindow.document.getElementsByTagName('script')[0];firstScriptTag.parentNode.insertBefore(tag,firstScriptTag);tag=jQuery(tag);if(name)
tag.attr("name",name);break;case "css":var objHead=jQuery(objWindow).find("head");objHead.append("<link>");var tag=objHead.children(":last");var attributes={rel:"stylesheet",type:"text/css",href:url};if(name)
attributes.name=name;if(typeof onload=="function"){attributes.onload=function(){onload(jQuery(this),replaceID);};}
tag.attr(attributes);break;default:throw Error("Undefined include type: "+type);break;}
if(replaceID)
tag.attr({id:replaceID});return(tag);};function putIncludes(windowIframe,objIncludes,funcOnLoaded){var isLoadOneByOne=true;var handlePrefix="uc_include_";var arrHandles={};jQuery.each(objIncludes,function(event,objInclude){var handle=handlePrefix+objInclude.type+"_"+objInclude.handle;if(!(objInclude.type=="js"&&objInclude.handle=="jquery"))
arrHandles[handle]=objInclude;});var isAllFilesLoaded=false;function checkAllFilesLoaded(){if(isAllFilesLoaded==true)
return(false);if(!jQuery.isEmptyObject(arrHandles))
return(false);isAllFilesLoaded=true;if(!funcOnLoaded)
return(false);funcOnLoaded();}
function onJsFileLoaded(){for(var index in arrHandles){var objInclude=arrHandles[index];if(objInclude.type=="js"){loadIncludeFile(objInclude);return(false);}}}
function loadIncludeFile(objInclude){var url=objInclude.url;var handle=handlePrefix+objInclude.type+"_"+objInclude.handle;var type=objInclude.type;if(objInclude.handle=="jquery"){checkAllFilesLoaded();if(isLoadOneByOne)
onJsFileLoaded();return(true);}
var data={replaceID:handle,name:"uc_include_file",iframe:windowIframe};data.onload=function(obj,handle){var objDomInclude=jQuery(obj);objDomInclude.data("isloaded",true);if(arrHandles.hasOwnProperty(handle)==true){delete arrHandles[handle];checkAllFilesLoaded();}
if(isLoadOneByOne){var tagName=objDomInclude.prop("tagName").toLowerCase();if(tagName=="script")
onJsFileLoaded();}};var objDomInclude=jQuery("#"+handle);if(objDomInclude.length==0){objDomInclude=loadDOMIncludeFile(type,url,data);}
else{var isLoaded=objDomInclude.data("isloaded");if(isLoaded==true){if(arrHandles.hasOwnProperty(handle)==true)
delete arrHandles[handle];if(isLoadOneByOne){var tagName=objDomInclude.prop("tagName").toLowerCase();if(tagName=="script")
onJsFileLoaded();}}else{var timeoutHandle=setInterval(function(){var isLoaded=objDomInclude.data("isloaded");if(isLoaded==true){clearInterval(timeoutHandle);if(arrHandles.hasOwnProperty(handle)==true)
delete arrHandles[handle];checkAllFilesLoaded();if(isLoadOneByOne){var tagName=objDomInclude.prop("tagName").toLowerCase();if(tagName=="script")
onJsFileLoaded();}}},100);}}}
if(isLoadOneByOne==false){jQuery.each(objIncludes,function(event,objInclude){loadIncludeFile(objInclude);});}else{var isFirstJS=true;jQuery.each(objIncludes,function(event,objInclude){if(objInclude.type=="css")
loadIncludeFile(objInclude);else{if(isFirstJS==true){loadIncludeFile(objInclude);isFirstJS=false;}}});}
checkAllFilesLoaded();}
this.ucLoadJSAndRun=function(iframeWindow,jsonIncludes,funcRun){var objIncludes=jQuery.parseJSON(jsonIncludes);if(!objIncludes||objIncludes.length==0){funcRun();return(false);}
putIncludes(iframeWindow,objIncludes,function(){funcRun();});}
this.init=function(){g_objSettingsPanel=jQuery("#elementor-panel");initAudioControl();initPostTypeSelectControl();initEvents();}
function searchElementorData(data,id){if(id==window.ucLastElementorModelID){var objSettings=getVal(window.ucLastElementorModel,"settings");var objSettingsAttributes=getVal(objSettings,"attributes");return(objSettingsAttributes);}
if(id){g_searchDataID=id;g_searchData=null;}
if(!g_searchDataID)
return(false);if(!data)
return(false);var isArray=jQuery.isArray(data);if(isArray==false)
return(false);jQuery.each(data,function(index,item){var elType=getVal(item,"elType");var elID=getVal(item,"id");var elements=getVal(item,"elements");if(g_searchDataID==elID){g_searchData=getVal(item,"settings");return(false);}
if(elType!="widget"&&jQuery.isArray(elements)&&elements.length>0){searchElementorData(elements);return(true);}});var settingsOutput={};if(g_searchData&&jQuery.isArray(g_searchData)==false)
settingsOutput=jQuery.extend({},g_searchData);return(settingsOutput);}
function getSettingsFromElementor(id){var data=elementor.config.data;var objSettings=searchElementorData(data,id);return(objSettings);}
function onFrontElementReady(element){var objElement=jQuery(element);var type=objElement.data("element_type");if(type!="section")
return(true);var id=objElement.data("id");}
function onElementorSectionPanelChange(event,model){window.ucLastElementorModelID=model.id;window.ucLastElementorModel=model.attributes;}
this.initFrontEndInteraction=function(windowFront,elementorFrontend){if(typeof elementorFrontend.hooks=="undefined"){setTimeout(function(){t.initFrontEndInteraction(windowFront,elementorFrontend);},300);return(false);}
g_windowFront=windowFront;elementor.hooks.addAction("panel/open_editor/section",onElementorSectionPanelChange);elementorFrontend.hooks.addAction('frontend/element_ready/global',onFrontElementReady);}}
var g_objUCElementorEditorAdmin=new UniteCreatorElementorEditorAdmin();jQuery(document).ready(function(){g_objUCElementorEditorAdmin.init();});