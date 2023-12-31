var SideNavi=(function($){var container={},cssElements={},posStep=30,posStart=null,posEnd=null,posDirection='',isSlideing=false,isVisible=false,activeIndex=-1,changeVisibility=false;function getPosStart(){if(posStart===null){posStart=0-$(cssElements.data+':eq(0)',container).width()*1;}
return posStart;}
function getPosEnd(){if(posEnd===null){posEnd=0;}
return posEnd;}
function getPos(){return container.css(posDirection).replace('px','');}
function toggleIsVisible(){isVisible=!(isVisible);}
function isActiveItem(item){return item.hasClass('bdt-active');}
function setActiveTab(){$(cssElements.tab+cssElements.active,container).removeClass(cssElements.active.replace('.',''));$(cssElements.tab+':eq('+activeIndex+')',container).addClass(cssElements.active.replace('.',''));}
function removeActiveItem(){$(cssElements.item+cssElements.active,container).removeClass('bdt-active');}
function setActiveItem(item){removeActiveItem();setActiveTab();item.addClass('bdt-active');}
function setDefaultItem(item){item.removeClass('bdt-active');}
function slideEvent(){var pos=getPos()*1;pos=(isVisible)?pos+posStep:pos-posStep;if(isVisible&&pos+posStep>=getPosEnd()||!isVisible&&pos-posStep<=getPosStart()){pos=(isVisible)?getPosEnd():getPosStart();container.css(posDirection,'translateX('+pos+'px)');isSlideing=false;}else{container.css(posDirection,'translateX('+pos+'px)');setTimeout(function(){slideEvent()},30);}}
function slide(){if(!isSlideing){isSlideing=true;slideEvent();}}
function setEventParam(item){activeIndex=$(cssElements.item,container).index(item);if(isActiveItem(item)){toggleIsVisible();setDefaultItem(item);changeVisibility=true;}else{setActiveItem(item);if(!isVisible){toggleIsVisible();changeVisibility=true;}}}
function eventListener(){$(cssElements.item,container).on('click',function(event){event.preventDefault();setEventParam($(this));if(changeVisibility){slide();}});}
function init(direction,conf){posDirection=direction;cssElements=conf;container=$(cssElements.container);eventListener();}
return{init:init};})(jQuery);