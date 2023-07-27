"use strict";function UniteCreatorParamsEditor(){var t=this;var g_objWrapper,g_objTableBody,g_objEmptyParams,g_type;var g_objDialog=new UniteCreatorParamsDialog(),g_buttonAddParam;var g_buttonAddImageBase,g_objLastParam,g_objCatsWrapper;if(!g_ucAdmin)
var g_ucAdmin=new UniteAdminUC();this.events={UPDATE:"update",BULK:"bulk"};var g_temp={hasCats:false,isItemsType:false,funcOnUpdate:function(){}};function ______________GETTERS______________(){}
function getRowData(objRow){var data=objRow.data("paramdata");if(g_temp.hasCats==true){var catid=objRow.data("catid");if(catid)
data["__attr_catid__"]=catid;}
var objReturn={};jQuery.extend(objReturn,data);return(objReturn);}
function getParamsRows(){if(!g_objTableBody)
throw new Error("The params editor is not inited yet");var rows=g_objTableBody.find("tr");return(rows);}
function isParamDataExists(key,value){var rows=getParamsRows();for(var i=0;i<rows.length;i++){var objRow=jQuery(rows[i]);var objParam=getRowData(objRow);if(objParam[key]==value)
return(true);}
return(false);}
function isParamTypeExists(type){var isExists=isParamDataExists("type",type);return(isExists);}
function isParamNameExists(name){var isExists=isParamDataExists("name",name);return(isExists);}
function getDuplicateNewName(name){var newName=name+"_copy";var isExists=isParamNameExists(newName);if(isExists==false)
return(newName);var counter=1;do{counter++;newName=newName+counter;isExists=isParamNameExists(newName);}while(isExists==true);return(newName);}
function getParamsRow(rowIndex){var rows=getParamsRows();if(rowIndex>=rows.length)
throw new Error("Row with index: "+rowIndex+" not found");var objRow=jQuery(rows[rowIndex]);return(objRow);}
function getNumParams(){var rows=getParamsRows();return rows.length;}
function getTypeTitle(type){var typeTitle=type;if(g_uctext.hasOwnProperty(type))
typeTitle=g_uctext[type];return(typeTitle);}
this.getParamsData=function(paramsType,isAssoc){var rows=getParamsRows();var arrParams=[];jQuery.each(rows,function(index,row){var objRow=jQuery(row);var objParam=getRowData(objRow);if(paramsType=="control"){switch(objParam.type){case "uc_dropdown":case "uc_radioboolean":case "uc_checkbox":break;default:return(true);break;}}
arrParams.push(objParam);});if(isAssoc==true){var objParams={};jQuery.each(arrParams,function(index,param){var name=param.name;objParams[name]=param;});return(objParams);}else
return(arrParams);};this.getCatData=function(){return getCatsData();}
function getParamRowHtml(objParam){var typeTitle=getTypeTitle(objParam.type);var html="<tr>";var paramError=null;if(objParam.hasOwnProperty("param_error"))
paramError=objParam["param_error"];var textRowAdd="";var linkClass="";var linkTitle="";if(paramError){linkTitle="title='"+paramError+"'";linkClass=" unite-color-red";textRowAdd="class='unite-color-red' title='"+paramError+"'";}
var isAdminLabel=g_ucAdmin.getVal(objParam,"admin_label",false,g_ucAdmin.getvalopt.FORCE_BOOLEAN);var adminLabelClass=(isAdminLabel==true)?" label-active":"";html+=" <td><div class='uc-table-row-handle'></div><div class='uc-table-admin-label"+adminLabelClass+"' title='Admin Label'></div></td>";html+=" <td><a class='uc-button-edit-param"+linkClass+"' "+linkTitle+" href='javascript:void(0)'>"+objParam.title+"</a></td>";html+=" <td "+textRowAdd+">"+objParam.name+"</td>";html+=" <td "+textRowAdd+">"+typeTitle+"</td>";html+=" <td>"
switch(objParam.type){case "uc_checkbox":var checked="";if(objParam.is_checked=="true")
checked=" checked ";html+="<input type='checkbox' "+checked+" readonly>";html+="<span>"+objParam.text_near+"</span>";break;case "uc_dropdown":html+="<select>";var options=objParam.options;var defaultValue=objParam.default_value;if(typeof options=="object"){jQuery.each(options,function(name,value){var selected="";if(value==defaultValue)
selected="selected='selected'";html+="<option val='"+value+"' "+selected+">"+name+"</option>";});}
html+="</select>"
break;case "uc_radioboolean":var trueChecked=" checked";var falseChecked="";if(objParam.default_value==objParam.false_value){trueChecked="";falseChecked=" checked";}
html+="<label><input type='radio' "+trueChecked+" name="+objParam.name+"></input>"+objParam.true_name+"</label>";html+="<label><input type='radio' "+falseChecked+" name="+objParam.name+"></input>"+objParam.false_name+"</label>";break;case "uc_number":var unit=objParam.unit;if(unit=="other")
unit=objParam.unit_custom;html+="<input type='text' class='unite-input-number' readonly value='"+objParam.default_value+"'>&nbsp;"+unit;break;case "uc_colorpicker":html+="<input type='text' class='input-color unite-float-left' readonly value='"+objParam.default_value+"'>";html+="<div class='colorpicker-bar' style='background-color:"+objParam.default_value+"'></div>";break;case "uc_textarea":case "uc_editor":html+="<textarea readonly>"+objParam.default_value+"</textarea>";break;case "uc_image":html+="<input type='text' class='unite-input-image' readonly value=''>";html+="<a disabled readonly class='unite-button-secondary button-disabled'>"+g_uctext.choose_image+"</a>";break;case "uc_mp3":html+="<input type='text' class='unite-input-image' readonly value=''>";html+="<a disabled readonly class='unite-button-secondary button-disabled'>"+g_uctext.choose_audio+"</a>";break;default:var defaultValue="";if(objParam.hasOwnProperty("default_value"))
defaultValue=objParam.default_value;html+="<input type='text' readonly value='"+defaultValue+"'>";break;}
html+=" </td>"
var deleteClass="";if(paramError)
deleteClass=" unite-bold";html+=" <td>";html+="  <a href='javascript:void(0)' class='unite-button-secondary uc-button-delete-param "+deleteClass+"' title='"+g_uctext.delete_op+"' ><i class='far fa-trash-alt'></i></a>";html+="  <a href='javascript:void(0)' class='unite-button-secondary uc-button-duplicate-param' title='"+g_uctext.duplicate_op+"'><i class='far fa-clone'></i></a>";html+="  <a href='javascript:void(0)' class='unite-button-secondary uc-button-bulk-param' title='"+g_uctext.bulk+"'><i class='far fa-copy'></i></a>";html+=" </td>";html+="</tr>";return(html);}
function ______________CATS______________(){}
function getCurrentCat(){if(g_temp.hasCats==false)
return(null);var objCat=g_objCatsWrapper.find(".uc-attr-list-sections li.uc-active");if(objCat.length==0||objCat.length>1)
return(null);return(objCat);}
function getCurrentCatData(name){var objCat=getCurrentCat();var data=getCatData(objCat);if(name=="id")
return(data.id);if(name=="title")
return(data.title)
return(data);}
function getCatByID(catID){if(!catID)
return(null);var cat=jQuery("#"+catID);if(cat.length==0)
return(null);return(cat);}
function getCatData(objRow){var objTitle=objRow.find(".uc-attr-list__section-title");var title=objTitle.html();title=jQuery.trim(title);var data={};data["id"]=objRow.data("id");data["title"]=title;return(data);}
function getCatsData_tab(objCats,name){var objList=jQuery("#uc_attr_list_sections_"+name);var objlistItems=objList.children("li");var tab=objList.data("tab");jQuery.each(objlistItems,function(index,item){var objItem=jQuery(item);var data=getCatData(objItem);data.tab=tab;objCats.push(data);});return(objCats);}
function getCatsData(){if(g_temp.hasCats==false)
return(null);var objCats=[];objCats=getCatsData_tab(objCats,"content");objCats=getCatsData_tab(objCats,"style");return(objCats);}
function updateCatNumItems(objCat,numItems){if(!objCat)
return(false);var objNumItems=objCat.find(".uc-attr-list__section-numitems");g_ucAdmin.validateDomElement(objNumItems,"num items object of category");var html="("+numItems+")";objNumItems.html(html);}
function updateCurrentCatNumItems(){var numParams=getNumParams();var objCat=getCurrentCat();updateCatNumItems(objCat,numParams);}
function onCatAddSectionClick(){var objButton=jQuery(this);var tab=objButton.data("sectiontab");var listID="uc_attr_list_sections_"+tab;var objList=jQuery("#"+listID);g_ucAdmin.validateDomElement(objList,"list sections: "+listID);var dialogID="uc_dialog_attribute_category_addsection";var objDialog=jQuery("#"+dialogID);objDialog.data("tab",tab);var dialogOptions={};g_ucAdmin.openCommonDialog(objDialog,function(){var objError=objDialog.find(".uc-error-message");objError.html("").hide();var objInput=objDialog.find(".uc-section-title");objInput.val("").focus();},dialogOptions);}
function onDialogAddSectionClick(){var dialogID="uc_dialog_attribute_category_addsection";var objDialog=jQuery("#"+dialogID);var objInput=objDialog.find(".uc-section-title");var catTitle=objInput.val();var objError=objDialog.find(".uc-error-message");catTitle=jQuery.trim(catTitle);if(!catTitle){var textError=objError.data("error_empty");objError.show().html(textError);objInput.focus();return(false);}
objError.hide();var tab=objDialog.data("tab");addCatToTab(tab,catTitle);objDialog.dialog("close");}
function renameCategory(objCat,newTitle){g_ucAdmin.validateDomElement(objCat,"category");var objTitle=objCat.find(".uc-attr-list__section-title");objTitle.html(newTitle);}
function updateParamsVisibilityByCats(){if(g_temp.hasCats==false)
return(false);var currentCatID=getCurrentCatData("id");var objRows=getParamsRows();jQuery.each(objRows,function(index,row){var objRow=jQuery(row);var catID=objRow.data("catid");if(currentCatID==catID)
objRow.show();else
objRow.hide();});}
function addCatToTab(tab,catTitle,catID){var objCat=getCatByID(catID);if(objCat){renameCategory(objCat,catTitle);return(false);}
if(!catID)
var catID="cat_"+tab+"_"+g_ucAdmin.getRandomString(8);var html="<li id='"+catID+"' data-id='"+catID+"'>";html+="<span data-name=\"section_content_general\" class=\"uc-attr-list__section-title\">";html+=g_ucAdmin.htmlspecialchars(catTitle);html+="</span>";html+="<span class=\"uc-attr-list__section-numitems\"></span>";html+="</li>";var objCat=jQuery(html);var objList=jQuery("#uc_attr_list_sections_"+tab);g_ucAdmin.validateNotEmpty(objList,"list sections");objList.append(objCat);}
function addNewRowCatData(objRow){var catID=getCurrentCatData("id");objRow.data("catid",catID);}
function onCatClick(){var objCat=jQuery(this);if(objCat.hasClass("uc-active"))
return(true);var objActiveCat=g_objCatsWrapper.find(".uc-attr-list-sections li.uc-active");objActiveCat.removeClass("uc-active");objCat.addClass("uc-active");updateParamsVisibilityByCats();}
function initCatsEvents(){var objAddButtons=g_objCatsWrapper.find(".uc-attr-cats__button-add");objAddButtons.on("click",onCatAddSectionClick);var buttonAddSectionDialog=jQuery("#uc_dialog_attribute_category_button_addsection");buttonAddSectionDialog.on("click",onDialogAddSectionClick);var inputTitleDialog=jQuery("#uc_dialog_attribute_category_addsection .uc-section-title");g_ucAdmin.validateDomElement(inputTitleDialog,"dialog input");inputTitleDialog.doOnEnter(onDialogAddSectionClick);g_objCatsWrapper.on("click",".uc-attr-list-sections li",onCatClick);}
function initCatsFromData(arrParamsCats){if(!arrParamsCats)
return(false);if(jQuery.isArray(arrParamsCats)==false)
return(false);jQuery.each(arrParamsCats,function(index,objCat){var tab=g_ucAdmin.getVal(objCat,"tab");var title=g_ucAdmin.getVal(objCat,"title");var id=g_ucAdmin.getVal(objCat,"id");addCatToTab(tab,title,id);});}
function ______________ACTIONS______________(){}
function addParamRow(objParam,rowBefore){if(!rowBefore)
var rowBefore=null;var html=getParamRowHtml(objParam);var objRow=jQuery(html).data("paramdata",objParam);if(rowBefore){objRow.insertAfter(rowBefore);}else{g_objTableBody.append(objRow);g_objEmptyParams.hide();}
if(g_temp.hasCats==true){var currentCatID=getCurrentCatData("id");addNewRowCatData(objRow);var catID=g_ucAdmin.getVal(objParam,"__attr_catid__");if(catID){var objCat=getCatByID(catID);trace(objCat);}}
g_objLastParam=objParam;triggerEvent(t.events.UPDATE);}
function updateParamRow(rowIndex,objParam){if(typeof rowIndex=="object")
var objRow=rowIndex;else
var objRow=getParamsRow(rowIndex);var html=getParamRowHtml(objParam);var objNewRow=jQuery(html).data("paramdata",objParam);objRow.replaceWith(objNewRow);g_objLastParam=objParam;triggerEvent(t.events.UPDATE);}
function removeParamRow(objRow){objRow.remove();var numParams=getNumParams();if(numParams==0)
g_objEmptyParams.show();g_objLastParam=null;triggerEvent(t.events.UPDATE);}
function duplicateParamRow(objRow){var rowData=getRowData(objRow);var name=rowData.name;rowData.name=getDuplicateNewName(name);addParamRow(rowData,objRow);}
function ______________EVENTS______________(){}
function onUpdateInternal(){if(g_temp.hasCats==false)
return(true);updateCurrentCatNumItems();}
function triggerEvent(eventName,params){if(!params)
var params=null;g_objWrapper.trigger(eventName,params);}
this.onEvent=function(eventName,func){g_objWrapper.on(eventName,func);};function onDeleteParamClick(){var objRow=jQuery(this).parents("tr");removeParamRow(objRow);}
function onEditParamClick(){var objRow=jQuery(this).parents("tr");var paramData=getRowData(objRow);switch(paramData.type){case "uc_imagebase":alert("no edit yet, sorry. will be in the future working on it...");return(false);break;}
var rowIndex=objRow.index();g_objDialog.open(paramData,rowIndex,function(objParam,rowIndex){updateParamRow(rowIndex,objParam);},g_type);}
this.onAddParamButtonClick=function(data){if(!data)
var data=null;g_objDialog.open(data,null,function(objParam){addParamRow(objParam);},g_type);};function onDuplicateParamClick(){var objRow=jQuery(this).parents("tr");duplicateParamRow(objRow);}
function onBulkParamClick(){var objRow=jQuery(this).parents("tr");var paramData=getRowData(objRow);var data={};var rowIndex=objRow.index();data["param_type"]=g_type;data["param_position"]=rowIndex;data["param_data"]=paramData;triggerEvent(t.events.BULK,data);}
function initEvents(){g_objWrapper.on("click",".uc-button-delete-param",onDeleteParamClick);g_objWrapper.on("click",".uc-button-edit-param",onEditParamClick);g_objWrapper.on("click",".uc-button-duplicate-param",onDuplicateParamClick);g_objWrapper.on("click",".uc-button-bulk-param",onBulkParamClick);g_objTableBody.sortable({handle:".uc-table-row-handle"});g_buttonAddParam.on("click",function(){t.onAddParamButtonClick();});t.onEvent(t.events.UPDATE,function(){onUpdateInternal();g_temp.funcOnUpdate();});if(g_temp.hasCats==true)
initCatsEvents();}
function initParamsFromObject(arrParams){if(!arrParams)
return(false);jQuery.each(arrParams,function(index,objParam){addParamRow(objParam);});if(arrParams.length==0)
g_objEmptyParams.show();else
g_objEmptyParams.hide();}
function ______________ITEMS_TYPE______________(){}
function onAddImageBaseClick(){var isEnabled=g_ucAdmin.isButtonEnabled(g_buttonAddImageBase);if(isEnabled==false)
return(false);var isExists=isParamTypeExists("uc_imagebase");if(isExists==true)
return(false);var objParam={};objParam["type"]="uc_imagebase";objParam["name"]="imagebase_fields";objParam["title"]="Image Base Fields";addParamRow(objParam);}
function initItemsType(){g_buttonAddImageBase=g_objWrapper.find(".uc-button-add-imagebase");g_buttonAddImageBase.on("click",onAddImageBaseClick);t.onEvent(t.events.UPDATE,function(){var isImageBaseExists=isParamTypeExists("uc_imagebase");if(isImageBaseExists==true){g_ucAdmin.disableButton(g_buttonAddImageBase);}else{g_ucAdmin.enableButton(g_buttonAddImageBase);}});}
this.onUpdateEvent=function(func){g_temp.funcOnUpdate=func;}
this.getLastUpdatedParam=function(){return(g_objLastParam);}
this.init=function(objWrapper,objParams,objDialog,arrParamsCats){g_objWrapper=objWrapper;g_objCatsWrapper=g_objWrapper.find(".uc-attr-cats-wrapper");if(g_objCatsWrapper.length){g_temp.hasCats=true;initCatsFromData(arrParamsCats);}
else
g_objCatsWrapper=null;var type=objWrapper.data("type");if(type=="items")
g_temp.isItemsType=true;g_type=type;g_objTableBody=g_objWrapper.find(".uc-table-params tbody");g_objEmptyParams=g_objWrapper.find(".uc-text-empty-params");g_buttonAddParam=g_objWrapper.find(".uc-button-add-param");g_objDialog=objDialog;initEvents();if(g_temp.isItemsType==true)
initItemsType();initParamsFromObject(objParams);};}