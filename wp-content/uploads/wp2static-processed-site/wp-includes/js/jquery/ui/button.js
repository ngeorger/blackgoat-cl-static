/*!
* jQuery UI Button 1.13.2
* http://jqueryui.com
*
* Copyright jQuery Foundation and other contributors
* Released under the MIT license.
* http://jquery.org/license
*/(function(factory){"use strict";if(typeof define==="function"&&define.amd){define(["jquery","./controlgroup","./checkboxradio","./core"],factory);}else{factory(jQuery);}})(function($){"use strict";$.widget("ui.button",{version:"1.13.2",defaultElement:"<button>",options:{classes:{"ui-button":"ui-corner-all"},disabled:null,icon:null,iconPosition:"beginning",label:null,showLabel:true},_getCreateOptions:function(){var disabled,options=this._super()||{};this.isInput=this.element.is("input");disabled=this.element[0].disabled;if(disabled!=null){options.disabled=disabled;}
this.originalLabel=this.isInput?this.element.val():this.element.html();if(this.originalLabel){options.label=this.originalLabel;}
return options;},_create:function(){if(!this.option.showLabel&!this.options.icon){this.options.showLabel=true;}
if(this.options.disabled==null){this.options.disabled=this.element[0].disabled||false;}
this.hasTitle=!!this.element.attr("title");if(this.options.label&&this.options.label!==this.originalLabel){if(this.isInput){this.element.val(this.options.label);}else{this.element.html(this.options.label);}}
this._addClass("ui-button","ui-widget");this._setOption("disabled",this.options.disabled);this._enhance();if(this.element.is("a")){this._on({"keyup":function(event){if(event.keyCode===$.ui.keyCode.SPACE){event.preventDefault();if(this.element[0].click){this.element[0].click();}else{this.element.trigger("click");}}}});}},_enhance:function(){if(!this.element.is("button")){this.element.attr("role","button");}
if(this.options.icon){this._updateIcon("icon",this.options.icon);this._updateTooltip();}},_updateTooltip:function(){this.title=this.element.attr("title");if(!this.options.showLabel&&!this.title){this.element.attr("title",this.options.label);}},_updateIcon:function(option,value){var icon=option!=="iconPosition",position=icon?this.options.iconPosition:value,displayBlock=position==="top"||position==="bottom";if(!this.icon){this.icon=$("<span>");this._addClass(this.icon,"ui-button-icon","ui-icon");if(!this.options.showLabel){this._addClass("ui-button-icon-only");}}else if(icon){this._removeClass(this.icon,null,this.options.icon);}
if(icon){this._addClass(this.icon,null,value);}
this._attachIcon(position);if(displayBlock){this._addClass(this.icon,null,"ui-widget-icon-block");if(this.iconSpace){this.iconSpace.remove();}}else{if(!this.iconSpace){this.iconSpace=$("<span> </span>");this._addClass(this.iconSpace,"ui-button-icon-space");}
this._removeClass(this.icon,null,"ui-wiget-icon-block");this._attachIconSpace(position);}},_destroy:function(){this.element.removeAttr("role");if(this.icon){this.icon.remove();}
if(this.iconSpace){this.iconSpace.remove();}
if(!this.hasTitle){this.element.removeAttr("title");}},_attachIconSpace:function(iconPosition){this.icon[/^(?:end|bottom)/.test(iconPosition)?"before":"after"](this.iconSpace);},_attachIcon:function(iconPosition){this.element[/^(?:end|bottom)/.test(iconPosition)?"append":"prepend"](this.icon);},_setOptions:function(options){var newShowLabel=options.showLabel===undefined?this.options.showLabel:options.showLabel,newIcon=options.icon===undefined?this.options.icon:options.icon;if(!newShowLabel&&!newIcon){options.showLabel=true;}
this._super(options);},_setOption:function(key,value){if(key==="icon"){if(value){this._updateIcon(key,value);}else if(this.icon){this.icon.remove();if(this.iconSpace){this.iconSpace.remove();}}}
if(key==="iconPosition"){this._updateIcon(key,value);}
if(key==="showLabel"){this._toggleClass("ui-button-icon-only",null,!value);this._updateTooltip();}
if(key==="label"){if(this.isInput){this.element.val(value);}else{this.element.html(value);if(this.icon){this._attachIcon(this.options.iconPosition);this._attachIconSpace(this.options.iconPosition);}}}
this._super(key,value);if(key==="disabled"){this._toggleClass(null,"ui-state-disabled",value);this.element[0].disabled=value;if(value){this.element.trigger("blur");}}},refresh:function(){var isDisabled=this.element.is("input, button")?this.element[0].disabled:this.element.hasClass("ui-button-disabled");if(isDisabled!==this.options.disabled){this._setOptions({disabled:isDisabled});}
this._updateTooltip();}});if($.uiBackCompat!==false){$.widget("ui.button",$.ui.button,{options:{text:true,icons:{primary:null,secondary:null}},_create:function(){if(this.options.showLabel&&!this.options.text){this.options.showLabel=this.options.text;}
if(!this.options.showLabel&&this.options.text){this.options.text=this.options.showLabel;}
if(!this.options.icon&&(this.options.icons.primary||this.options.icons.secondary)){if(this.options.icons.primary){this.options.icon=this.options.icons.primary;}else{this.options.icon=this.options.icons.secondary;this.options.iconPosition="end";}}else if(this.options.icon){this.options.icons.primary=this.options.icon;}
this._super();},_setOption:function(key,value){if(key==="text"){this._super("showLabel",value);return;}
if(key==="showLabel"){this.options.text=value;}
if(key==="icon"){this.options.icons.primary=value;}
if(key==="icons"){if(value.primary){this._super("icon",value.primary);this._super("iconPosition","beginning");}else if(value.secondary){this._super("icon",value.secondary);this._super("iconPosition","end");}}
this._superApply(arguments);}});$.fn.button=(function(orig){return function(options){var isMethodCall=typeof options==="string";var args=Array.prototype.slice.call(arguments,1);var returnValue=this;if(isMethodCall){if(!this.length&&options==="instance"){returnValue=undefined;}else{this.each(function(){var methodValue;var type=$(this).attr("type");var name=type!=="checkbox"&&type!=="radio"?"button":"checkboxradio";var instance=$.data(this,"ui-"+name);if(options==="instance"){returnValue=instance;return false;}
if(!instance){return $.error("cannot call methods on button"+
" prior to initialization; "+
"attempted to call method '"+options+"'");}
if(typeof instance[options]!=="function"||options.charAt(0)==="_"){return $.error("no such method '"+options+"' for button"+
" widget instance");}
methodValue=instance[options].apply(instance,args);if(methodValue!==instance&&methodValue!==undefined){returnValue=methodValue&&methodValue.jquery?returnValue.pushStack(methodValue.get()):methodValue;return false;}});}}else{if(args.length){options=$.widget.extend.apply(null,[options].concat(args));}
this.each(function(){var type=$(this).attr("type");var name=type!=="checkbox"&&type!=="radio"?"button":"checkboxradio";var instance=$.data(this,"ui-"+name);if(instance){instance.option(options||{});if(instance._init){instance._init();}}else{if(name==="button"){orig.call($(this),options);return;}
$(this).checkboxradio($.extend({icon:false},options));}});}
return returnValue;};})($.fn.button);$.fn.buttonset=function(){if(!$.ui.controlgroup){$.error("Controlgroup widget missing");}
if(arguments[0]==="option"&&arguments[1]==="items"&&arguments[2]){return this.controlgroup.apply(this,[arguments[0],"items.button",arguments[2]]);}
if(arguments[0]==="option"&&arguments[1]==="items"){return this.controlgroup.apply(this,[arguments[0],"items.button"]);}
if(typeof arguments[0]==="object"&&arguments[0].items){arguments[0].items={button:arguments[0].items};}
return this.controlgroup.apply(this,arguments);};}
return $.ui.button;});