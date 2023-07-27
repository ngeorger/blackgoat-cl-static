function UCWooIntegrate(){var t=this;function trace(str){console.log(str);}
function onSelectFilterChange(){var objSelect=jQuery(this);var objForm=objSelect.parents("form");objForm.submit();}
this.init=function(){var objFilterSelects=jQuery("select.uc-woo-filter");objFilterSelects.on("change",onSelectFilterChange);}}
jQuery(document).ready(function(){var objUCWoo=new UCWooIntegrate();objUCWoo.init();});