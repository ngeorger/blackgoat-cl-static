"use strict";function UniteCreatorAdmin_ObjectsList(){var t=this;var g_providerAdmin=new UniteProviderAdminUC();var g_tableObjects;var g_selectedCatID=-1,g_openedLayout=-1,g_selectedSort="";var g_searchText,g_oldCatTitle="",g_canRename=true;var g_isDeleteInProcess=false;var g_options={enable_categories:false};if(!g_ucAdmin)
var g_ucAdmin=new UniteAdminUC();function initGlobalSettingsDialog(){var settingsWrapper=jQuery("#uc_layout_general_settings");g_settingsGlobal=new UniteSettingsUC();g_settingsGlobal.init(settingsWrapper);jQuery("#uc_layouts_global_settings").on("click",function(){var dialogOptions={minWidth:750};g_ucAdmin.openCommonDialog("#uc_dialog_layout_global_settings",null,dialogOptions);});jQuery("#uc_dialog_layout_global_settings_action").on("click",function(){var settingsData=g_settingsGlobal.getSettingsValues();var data={settings_values:settingsData};g_ucAdmin.dialogAjaxRequest("uc_dialog_layout_global_settings","update_global_layout_settings",data);});}
function runActionDelete(objectID){var actionDelete=g_options["action_delete"];var data={id:objectID};g_ucAdmin.ajaxRequest(actionDelete,data);}
function onActionButtonClick(){var objButton=jQuery(this);var action=objButton.data("action");var objLoader=objButton.siblings(".uc-loader-"+action);var textConfirm=g_tableObjects.data("text-confirm-"+action);if(textConfirm){if(confirm(textConfirm)==false)
return(false);}
if(objLoader){objButton.hide();objLoader.show();}
var objectID=objButton.data("id");switch(action){case "delete":runActionDelete(objectID);break;default:throw new Error("No action: "+action);break;}}
function onDuplicateClick(){var objButton=jQuery(this);var objLoader=objButton.siblings(".uc-loader-duplicate");objButton.hide();objLoader.show();var layoutID=objButton.data("layoutid");var data={layout_id:layoutID};g_ucAdmin.ajaxRequest("duplicate_layout",data);}
this.onExportClick=function(){var objButton=jQuery(this);var layoutID=objButton.data("layoutid");var params="id="+layoutID;var urlExport=g_ucAdmin.getUrlAjax("export_layout",params);location.href=urlExport;}
function ___________IMPORT_DIALOG_____________(){}
function openImportLayoutDialog(){jQuery("#dialog_import_layouts_file").val("");var options={minWidth:700,minHeight:190};g_ucAdmin.openCommonDialog("#uc_dialog_import_layouts",null,options);}
this.initImportLayoutDialog=function(){jQuery("#uc_button_import_layout").on("click",openImportLayoutDialog);jQuery("#uc_dialog_import_layouts_action").on("click",function(){var isOverwrite=jQuery("#dialog_import_layouts_file_overwrite").is(":checked");var data={overwrite_addons:isOverwrite};var objData=new FormData();var jsonData=JSON.stringify(data);objData.append("data",jsonData);g_ucAdmin.addFormFilesToData("dialog_import_layouts_form",objData);g_ucAdmin.dialogAjaxRequest("uc_dialog_import_layouts","import_layouts",objData);});}
function initEvents(){if(g_tableObjects){g_tableObjects.on("click",".uc-button-action",onActionButtonClick);}}
function ___________CATEGORIES_____________(){}
function initEventsCats(){jQuery(document).on('click','.uc-catdialog-button-filter-clear',function(){filterClear();});jQuery(document).on('click','.uc-catdialog-button-filter',function(){var val=jQuery('.uc-catdialog-button-clearfilter').val();if(val=='')
{filterClear();return;}
loadCats(g_selectedCatID,g_selectedSort,val);});jQuery(document).on('click','.uc-button-delete-category',function(){var catid=parseInt(jQuery(this).data('catid'));if(isNaN(catid))
catid=jQuery(this).attr('data-catid');deleteCat(catid);});jQuery(document).on('click','a.uc-link-change-cat-sort',function(){var type=jQuery(this).data('type');if(type==g_selectedSort)
return false;g_selectedSort=type;loadCats(g_selectedCatID,type);});jQuery("#uc_dialog_add_category_action").on("click",setCategoryForLayout);jQuery(".uc-layouts-list-category").on("click",onChangeCategoryClick);jQuery(document).on('click','.egn-cancel-inp',function(){var parent=jQuery(this).parent('td').parent('tr');var catid=jQuery(parent).data('catid');closeEdit(catid,g_oldCatTitle);});jQuery(document).on('click','.egn-save-inp',function(){saveCatName(this);});}
function onChangeCategoryClick(){var objButton=jQuery(this);var action=objButton.data("action");var layoutID=objButton.data("layoutid");var catID=objButton.data("catid");catID=parseInt(catID);openManageCategoryDialog(layoutID,catID);}
function openManageCategoryDialog(layoutID,catID){var objDialog=jQuery("#uc_dialog_add_category");objDialog.data("catid",catID);objDialog.data("layoutid",layoutID);g_selectedCatID=catID;g_openedLayout=layoutID;g_ucAdmin.openCommonDialog("#uc_dialog_add_category",function(){loadCats(catID);jQuery("#uc_dialog_add_category_catname").val("").focus();});}
function loadCats(sort,filter_word){var data={};data.type="layout";if(sort=='a-z'||sort=='z-a'){data.sort=sort;}else if(g_selectedSort!=''){data.sort=g_selectedSort;}
if(filter_word!=''){g_searchText=filter_word;data.filter_word=filter_word;}else if(g_searchText!=""){data.filter_word=g_searchText;}
jQuery("#list_layouts_cats").html('Loading...');g_ucAdmin.ajaxRequest("get_layouts_categories",data,function(response){var html="<table>";jQuery.each(response.cats_list,function(key,value){var addHTML="";if(value.id==g_selectedCatID)
addHTML="selected";html+="<tr class='category "+addHTML+"' data-catid='"+value.id+"' data-countl='"+value.num_layouts+"'><td class='cat-name'>"+value.title+"</td><td class='controls'></td></tr>";});html+="</table>";jQuery("#list_layouts_cats").html(html);jQuery("#list_layouts_cats td.controls:gt(0)").append(" <span class='uc_layout_category_rename'>rename</span> | <span class='uc-link-delete-category'>delete</span>")
scrollToCat(g_selectedCatID);});}
function showMsgCats(msg,isError){if(isError==true)
msg="<div class='unite-color-red'>"+msg+"</div>";jQuery("#uc_layout_categories_message").html(msg);jQuery("#uc_layout_categories_message").dialog({minWidth:400,buttons:{"Close":function(){jQuery("#uc_layout_categories_message").dialog("close");}}});}
function hideMsgCats(){jQuery('#uc_layout_categories_message').dialog('close').html("");}
function addCategory(){var data={};data.catname=jQuery("#uc_dialog_add_category_catname").val();data.type="layout";g_ucAdmin.dialogAjaxRequest("uc_dialog_add_category","add_category",data,function(response){loadCats();},{noclose:true});}
function initManageCategoryDialog(){jQuery("#uc_dialog_add_category_button_add").on("click",addCategory);jQuery("#uc_dialog_add_category_catname").keyup(function(event){if(event.keyCode==13)
addCategory();});jQuery(document).on('click','.uc_layout_category_rename',function(){renameCategory(this);});jQuery(document).on('click','#list_layouts_cats tr.category',function(){if(g_selectedCatID!=-1)
jQuery('tr.category[data-catid='+g_selectedCatID+']').removeClass('selected');g_selectedCatID=jQuery(this).data('catid');jQuery(this).addClass('selected')});}
function renameCategory(elem){if(!g_canRename)
return false;g_canRename=false;var parent=jQuery(elem).parent('td').parent('tr');var catid=jQuery(parent).data('catid');var val_form=jQuery(parent).find('td.cat-name').html();g_oldCatTitle=val_form;var html="<input name='egn-change-name' data-catid='"+catid+"' value='"+val_form+"' type='text'><button class='egn-save-inp unite-button-primary'>Save</button><button class='egn-cancel-inp unite-button-secondary'>cancel</button>";jQuery(parent).find('td.cat-name').html(html);}
function closeEdit(catId,txt){jQuery('.category[data-catid='+catId+'] td.cat-name').html(txt);g_canRename=true;g_oldCatTitle="";}
function saveCatName(elem){var parent=jQuery(elem).parent('td');jQuery(elem).attr('disabled','true').html('Saving...');var objInput=jQuery(parent).find('input[name=egn-change-name]');var catid=objInput.data('catid');var newTitle=objInput.val();updateCategoryTitle(catid,newTitle);}
function scrollToCat(catID){if(catID==0||catID==''||catID==-1)
return false;jQuery('#list_layouts_cats').scrollTop(parseInt(jQuery('.category[data-catid='+catID+']').offset().top-134));}
function updateCategoryTitle(catID,newTitle){var data={cat_id:catID,title:newTitle};g_ucAdmin.setErrorMessageID(function(message,operation){jQuery('.egn-save-inp:disabled').removeAttr('disabled').html('Save');showMsgCats(message,true);});g_ucAdmin.ajaxRequest("update_category",data,function(response){jQuery('a.uc-layouts-list-category[data-catid='+catID+']').html(newTitle);closeEdit(catID,newTitle);});}
function getSelectedCatIDFromHtmlTable(){var id=parseInt(jQuery('#list_layouts_cats table tr.category.selected').data('catid'));if(!isNaN(id))
return id;return 0;}
function getCategoryNameFromHtmlTableById(id){var name=jQuery('#list_layouts_cats table tr.category[data-catid='+id+'] td.cat-name').html();return name;}
function deleteCat(catId){jQuery('.egn-btn-del').attr('disabled','true').html('deleting...');var catId=parseInt(catId);if(isNaN(catId))
return false;var data={};data.catID=catId;data.type='layout';g_ucAdmin.ajaxRequest("remove_category",data,function(response){g_isDeleteInProcess=false;jQuery('a.uc-layouts-list-category[data-catid='+catId+']').html('Uncategorized').attr("data-catid",0).data('catid',0);hideMsgCats();if(g_selectedCatID==catId)
g_selectedCatID=-1;loadCats();});}
jQuery(document).on('click','.uc-link-delete-category',function(){if(g_isDeleteInProcess)
return false;g_isDeleteInProcess=true;var parent=jQuery(this).parent('td').parent('tr');var catid=jQuery(parent).data('catid');if(!catid||catid=='')
return false;var count=jQuery(parent).data('countl');if(count>0){showMsgCats('This category contains layouts. Are you sure? <br/><br/><a class="unite-button-primary egn-btn-del uc-button-delete-category" href="javascript:void(0)" data-catid="'+catid+'">Yes, delete category</a>');}else{showMsgCats('deleting...');deleteCat(catid);g_isDeleteInProcess=false;}});function setCategoryForLayout(){var catID=getSelectedCatIDFromHtmlTable();var layoutID=g_openedLayout;data={layoutid:layoutID,catid:catID};g_ucAdmin.dialogAjaxRequest("uc_dialog_add_category","update_layout_category",data,function(){var objTableItem=jQuery('a.uc-layouts-list-category[data-layoutid='+layoutID+']');objTableItem.html(getCategoryNameFromHtmlTableById(catID));objTableItem.attr("data-catid",catID).data('catid',catID);});}
function filterClear(){g_searchText="";jQuery('.uc-catdialog-button-clearfilter').val('');loadCats();}
function initCategories(){g_selectedCatID=-1;initEventsCats();initManageCategoryDialog();}
function ___________INIT_____________(){}
function initOptions(paramsOptions){trace(paramsOptions);}
this.initObjectsListView=function(options){g_tableObjects=jQuery("#uc_table_objects");if(g_tableObjects.length==0)
g_tableObjects=null;var objWrapper=jQuery("#uc_table_objects_wrapper");g_ucAdmin.validateDomElement(objWrapper,"Table Wrapper");var options=objWrapper.data("options");jQuery.extend(g_options,options);initEvents();if(g_options.enable_categories==true)
initCategories();};}