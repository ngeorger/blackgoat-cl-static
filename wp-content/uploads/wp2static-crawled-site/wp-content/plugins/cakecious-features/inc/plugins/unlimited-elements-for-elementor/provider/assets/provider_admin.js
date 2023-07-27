var g_dataProviderUC={pathSelectImages:null,pathSelectImagesBase:null,urlSelectImagesBase:null,objBrowserImages:null,objBrowserAudio:null};function UniteProviderAdminUC(){var t=this;var g_parent;var g_temp={keyUrlAssets:"[url_assets]/"};function openNewMediaDialog(title,onInsert,isMultiple,type){if(isMultiple==undefined)
isMultiple=false;var frame=wp.media({title:title,multiple:isMultiple,library:{type:type},button:{text:'Insert'}});frame.on('select',function(){var objSettings=frame.state().get('selection').first().toJSON();var selection=frame.state().get('selection');var arrImages=[];if(isMultiple==true){selection.map(function(attachment){var objImage=attachment.toJSON();var obj={};obj.url=objImage.url;obj.id=objImage.id;arrImages.push(obj);});onInsert(arrImages);}else{onInsert(objSettings.url,objSettings.id);}});frame.open();}
function openNewImageDialog(title,onInsert,isMultiple){openNewMediaDialog(title,onInsert,isMultiple,"image");}
function openAudioDialog(title,onInsert,isMultiple){openNewMediaDialog(title,onInsert,isMultiple,"audio");}
function openOldImageDialog(title,onInsert){var params="type=image&post_id=0&TB_iframe=true";params=encodeURI(params);tb_show(title,'media-upload.php?'+params);window.send_to_editor=function(html){tb_remove();var urlImage=jQuery(html).attr('src');if(!urlImage||urlImage==undefined||urlImage=="")
var urlImage=jQuery('img',html).attr('src');onInsert(urlImage,"");}}
this.openAddImageDialog=function(title,onInsert,isMultiple,source){if(source=="addon"){openAddonImageSelectDialog(title,onInsert);return(false);}
if(typeof wp!="undefined"&&typeof wp.media!="undefined")
openNewImageDialog(title,onInsert,isMultiple);else{openOldImageDialog(title,onInsert);}};this.openAddMp3Dialog=function(title,onInsert,isMultiple,source){if(typeof wp=="undefined"||typeof wp.media=="undefined"){trace("the audio select dialog could not be opened");return(false);}
if(source=="addon"){openAddonAudioSelectDialog(title,onInsert);return(false);}else{openAudioDialog(title,onInsert,isMultiple);}};this.getShortcode=function(alias){var shortcode="[uniteaddon "+alias+"]";if(alias=="")
shortcode="";return(shortcode);};this.clearSetting=function(type,objInput,dataname){switch(type){case "select_post_taxonomy":case "select_post_type":defaultValue=objInput.data(dataname);objInput.val(defaultValue);break;default:return(false);break;}
return(true);}
this.initSettingEvents=function(type,objInput){switch(type){case "select_post_taxonomy":initTaxonomyTypeSetting(objInput);break;case "select_post_type":initPostTypeSetting(objInput);break;}}
this.setSettingValue=function(type,objInput,value){switch(type){case "select_post_taxonomy":case "select_post_type":objInput.val(value);objInput.trigger("change");break;default:return(false);break;}
return(true);}
function initUpdatePlugin(){var objButton=jQuery("#uc_button_update_plugin");if(objButton.length==0)
return(false);objButton.click(function(){jQuery("#dialog_update_plugin").dialog({dialogClass:"unite-ui",minWidth:600,minHeight:400,modal:true,});});}
function initMediaSelectDialog(type){if(typeof UCAssetsManager=="undefined")
return(false);switch(type){case "image":var dialogID="#uc_dialog_image_select";var browserID="#uc_dialogimage_browser";g_dataProviderUC.objBrowserImages=new UCAssetsManager();var browser=g_dataProviderUC.objBrowserImages;var inputID="#uc_dialog_image_select_url";var buttonID="#uc_dialog_image_select_button";break;case "audio":var dialogID="#uc_dialog_audio_select";var browserID="#uc_dialogaudio_browser";g_dataProviderUC.objBrowserAudio=new UCAssetsManager();var browser=g_dataProviderUC.objBrowserAudio;var inputID="#uc_dialog_audio_select_url";var buttonID="#uc_dialog_audio_select_button";break;default:throw new Error("wrong type: "+type);break;}
var browserImagesWrapper=jQuery(browserID);if(browserImagesWrapper.length==0)
return(false);browser.init(browserImagesWrapper);browser.eventOnUpdateFilelist(function(){var path=browser.getActivePath();t.setPathSelectImages(path);});browser.eventOnSelectOperation(function(event,objItem){var urlRelative=objItem.file;if(g_dataProviderUC.pathSelectImagesBase){urlRelative=objItem.url.replace(g_dataProviderUC.pathSelectImagesBase+"/","");}
var objInput=jQuery(inputID);objItem.url_assets_relative=g_temp.keyUrlAssets+urlRelative;objInput.val(urlRelative);objInput.data("item",objItem).val(urlRelative);g_ucAdmin.enableButton(buttonID);});jQuery(buttonID).click(function(){if(g_ucAdmin.isButtonEnabled(buttonID)==false)
return(false);var objDialog=jQuery(dialogID);var objInput=jQuery(inputID);var objItem=objInput.data("item");if(!objItem)
throw new Error("please select some "+type);var funcOnInsert=objDialog.data("func_oninsert");if(typeof funcOnInsert!="function")
throw new Error("on insert should be a function");funcOnInsert(objItem);objDialog.dialog("close");});}
function openAddonMediaSelectDialog(title,onInsert,type){switch(type){case "image":var dialogID="#uc_dialog_image_select";var dialogName="image select";var inputID="#uc_dialog_image_select_url";var buttonID="#uc_dialog_image_select_button";var objBrowser=g_dataProviderUC.objBrowserImages;break;case "audio":var dialogID="#uc_dialog_audio_select";var dialogName="audio select";var inputID="#uc_dialog_audio_select_url";var buttonID="#uc_dialog_audio_select_button";var objBrowser=g_dataProviderUC.objBrowserAudio;break;default:throw new Error("Wrong dialog type:"+type);break;}
var objDialog=jQuery(dialogID);if(objDialog.length==0)
throw new Error("dialog "+dialogName+" not found!");objDialog.data("func_oninsert",onInsert);objDialog.data("obj_browser",objBrowser);objDialog.dialog({minWidth:900,minHeight:450,modal:true,title:title,open:function(){var objDialog=jQuery(this);var objBrowser=objDialog.data("obj_browser");var objInput=jQuery(inputID);objInput.data("url","").val("");g_ucAdmin.disableButton(buttonID);objBrowser.setCustomStartPath(g_dataProviderUC.pathSelectImagesBase);var loadPath=g_dataProviderUC.pathSelectImages;if(!loadPath)
loadPath=g_pathAssetsUC;objBrowser.loadPath(loadPath,true);}});}
function openAddonImageSelectDialog(title,onInsert){openAddonMediaSelectDialog(title,onInsert,"image");}
function openAddonAudioSelectDialog(title,onInsert){openAddonMediaSelectDialog(title,onInsert,"audio");}
this.urlAssetsToFull=function(url){if(!url)
return(url);if(!g_dataProviderUC.urlSelectImagesBase)
return(url);var key=g_temp.keyUrlAssets;if(url.indexOf(key)==-1)
return(url);url=url.replace(key,g_dataProviderUC.urlSelectImagesBase);return(url);}
this.setPathSelectImages=function(path,basePath,baseUrl){if(basePath!=null)
g_dataProviderUC.pathSelectImagesBase=basePath;g_dataProviderUC.urlSelectImagesBase=baseUrl;g_dataProviderUC.pathSelectImages=path;}
this.setParent=function(parent){g_parent=parent;}
function openActivateDialog(){g_parent.openCommonDialog("uc_dialog_activate_catalog",function(){jQuery("#uc_dialog_activate_catalog_text").focus();});}
function initActivateDialog(){var objButtonActivate=jQuery("#uc_button_activate_catalog");if(objButtonActivate.length==0)
return(false);objButtonActivate.click(openActivateDialog);jQuery("#uc_dialog_activate_catalog_action").click(function(){var code=jQuery("#uc_dialog_activate_catalog_text").val();var data={code:code};if(g_ucCatalogAddonType)
data["addontype"]=g_ucCatalogAddonType;g_parent.dialogAjaxRequest("uc_dialog_activate_catalog","activate_catalog_codecanyon",data);});}
this.init=function(){initUpdatePlugin();initMediaSelectDialog("image");initMediaSelectDialog("audio");initActivateDialog();}
function _______EDITORS_SETTING_____(){}
function initEditor_tinyMCE_GetOptions(objEditorsOptions){if(objEditorsOptions.length==0)
throw new Error("no active editors found for options gethering");for(key in objEditorsOptions){var options=objEditorsOptions[key];if(options!==null)
return(options);}
throw new Error("editors options not found");}
function onEditorChange(editor,objSettings){var objInput=editor.getElement();objInput=jQuery(objInput);objSettings.triggerKeyupEvent(objInput);}
function initEditor_tinyMCE(inputID,objSettings){var options=initEditor_tinyMCE_GetOptions(window.tinyMCEPreInit.mceInit);options=jQuery.extend({},options,{resize:"vertical",height:200,id:inputID,selector:"#"+inputID});options.setup=function(editor){editor.on('Change',function(event){onEditorChange(editor,objSettings);});editor.on('keyup',function(event){onEditorChange(editor,objSettings);});};window.tinyMCEPreInit.mceInit[inputID]=options;tinyMCE.init(options);var optionsQT=initEditor_tinyMCE_GetOptions(window.tinyMCEPreInit.qtInit);optionsQT=jQuery.extend({},optionsQT,{id:inputID});window.tinyMCEPreInit.qtInit[inputID]=optionsQT;quicktags(optionsQT);QTags._buttonsInit();window.wpActiveEditor=inputID;}
function initEditors_afterTimeout(objSettings,arrEditorNames,isForce){if(typeof window.tinyMCEPreInit=="undefined"&&arrEditorNames.length){throw new Error("Init "+arrEditorNames[0]+" editor error. no other editors found on page");}
var idPrefix=objSettings.getIDPrefix();jQuery(arrEditorNames).each(function(index,name){var inputID=idPrefix+name;inputID=inputID.replace("#","");if(isForce===true||window.tinyMCEPreInit.mceInit.hasOwnProperty(inputID)==false||window.tinyMCEPreInit.mceInit[inputID]==null)
initEditor_tinyMCE(inputID,objSettings);});}
function _______POST_TAXONOMY_____(){}
function initTaxonomyTypeSetting(selectPostType){if(selectPostType.length==0)
return(false);var objParent=selectPostType.parents(".unite_settings_wrapper");if(objParent.length==0)
objParent=selectPostType.parents(".wpb_edit_form_elements");if(objParent.length==0)
throw new Error("unable to find post list setting parent");var selectPostTaxonomy=objParent.find(".unite-setting-post-taxonomy");if(selectPostTaxonomy.length==0)
return(false);var dataPostTypes=selectPostType.data("arrposttypes");if(typeof dataPostTypes=="string"){dataPostTypes=g_parent.decodeContent(dataPostTypes);dataPostTypes=JSON.parse(dataPostTypes);}
selectPostType.change(function(){var postType=selectPostType.val();var selectedTax=selectPostTaxonomy.val();var objTax=g_parent.getVal(dataPostTypes,postType);if(!objTax)
return(true);var objOptions=selectPostTaxonomy.find("option");var firstVisibleOption=null;jQuery.each(objOptions,function(index,option){var objOption=jQuery(option);var optionTax=objOption.prop("value");var taxFound=objTax.hasOwnProperty(optionTax);if(taxFound==true&&firstVisibleOption==null)
firstVisibleOption=optionTax;if(taxFound==true)
objOption.show();else
objOption.hide();});var isCurrentTaxRelevant=objTax.hasOwnProperty(selectedTax);if(isCurrentTaxRelevant==false&&firstVisibleOption){selectPostTaxonomy.val(firstVisibleOption);}});selectPostType.trigger("change");}
function _______POST_LIST_____(){}
function initPostTypeSetting(selectPostType){if(selectPostType.length==0)
return(false);var objParent=selectPostType.parents(".unite_settings_wrapper");if(objParent.length==0)
objParent=selectPostType.parents(".wpb_edit_form_elements");if(objParent.length==0)
throw new Error("unable to find post list setting parent");var selectPostCategory=objParent.find(".unite-setting-post-category");if(selectPostCategory.length==0)
return(false);var dataPostTypes=selectPostType.data("arrposttypes");if(typeof dataPostTypes=="string"){dataPostTypes=g_parent.decodeContent(dataPostTypes);dataPostTypes=JSON.parse(dataPostTypes);}
selectPostType.change(function(){var arrPostTypes=selectPostType.val();if(jQuery.isArray(arrPostTypes)==false)
arrPostTypes=[arrPostTypes];selectPostCategory.html("");var selectedID=selectPostCategory.val();var isSomeCatSelected=false;var htmlOptions="";htmlOptions+="<option value=''>[All Categories]</option>"
for(var postType of arrPostTypes){var objPostType=g_parent.getVal(dataPostTypes,postType);if(!objPostType)
continue;var objCats=objPostType["cats"];if(!objCats)
continue;jQuery.each(objCats,function(catID,catText){var catShowText=g_parent.htmlspecialchars(catText);var selected="";if(selectedID==catID){selected=" selected='selected'";isSomeCatSelected=true;}
htmlOptions+="<option value='"+catID+"' "+selected+">"+catShowText+"</option>"});}
selectPostCategory.html(htmlOptions);if(isSomeCatSelected==false)
selectPostCategory.val("");});selectPostType.trigger("change");}
function _______END_POST_LISTS_____(){}
this.initEditors=function(objSettings,isForce){var arrEditorNames=objSettings.getFieldNamesByType("editor_tinymce")
if(arrEditorNames.length==0)
return(false);setTimeout(function(){initEditors_afterTimeout(objSettings,arrEditorNames,isForce);},50);}
this.destroyEditors=function(objSettings){var arrEditorNames=objSettings.getFieldNamesByType("editor_tinymce")
if(arrEditorNames.length==0)
return(false);var idPrefix=objSettings.getIDPrefix();jQuery.each(arrEditorNames,function(index,name){var editorID=idPrefix+name;editorID=editorID.replace("#","");var objEditor=tinyMCE.EditorManager.get(editorID);if(objEditor){try{if(tinymce.majorVersion==="4")
window.tinyMCE.execCommand("mceRemoveEditor",!0,editorID);else
window.tinyMCE.execCommand("mceRemoveControl",!0,editorID);}catch(e){}
window.tinyMCEPreInit.mceInit[editorID]=null;window.tinyMCEPreInit.qtInit[editorID]=null;}});}}