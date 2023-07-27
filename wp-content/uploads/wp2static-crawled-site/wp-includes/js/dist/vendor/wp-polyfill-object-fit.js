(function(){'use strict';if(typeof window==='undefined')return;var edgeMatch=window.navigator.userAgent.match(/Edge\/(\d{2})\./);var edgeVersion=edgeMatch?parseInt(edgeMatch[1],10):null;var edgePartialSupport=edgeVersion?edgeVersion>=16&&edgeVersion<=18:false;var hasSupport='objectFit'in document.documentElement.style!==false;if(hasSupport&&!edgePartialSupport){window.objectFitPolyfill=function(){return false;};return;}
var checkParentContainer=function($container){var styles=window.getComputedStyle($container,null);var position=styles.getPropertyValue('position');var overflow=styles.getPropertyValue('overflow');var display=styles.getPropertyValue('display');if(!position||position==='static'){$container.style.position='relative';}
if(overflow!=='hidden'){$container.style.overflow='hidden';}
if(!display||display==='inline'){$container.style.display='block';}
if($container.clientHeight===0){$container.style.height='100%';}
if($container.className.indexOf('object-fit-polyfill')===-1){$container.className=$container.className+' object-fit-polyfill';}};var checkMediaProperties=function($media){var styles=window.getComputedStyle($media,null);var constraints={'max-width':'none','max-height':'none','min-width':'0px','min-height':'0px',top:'auto',right:'auto',bottom:'auto',left:'auto','margin-top':'0px','margin-right':'0px','margin-bottom':'0px','margin-left':'0px',};for(var property in constraints){var constraint=styles.getPropertyValue(property);if(constraint!==constraints[property]){$media.style[property]=constraints[property];}}};var setPosition=function(axis,$media,objectPosition){var position,other,start,end,side;objectPosition=objectPosition.split(' ');if(objectPosition.length<2){objectPosition[1]=objectPosition[0];}
if(axis==='x'){position=objectPosition[0];other=objectPosition[1];start='left';end='right';side=$media.clientWidth;}else if(axis==='y'){position=objectPosition[1];other=objectPosition[0];start='top';end='bottom';side=$media.clientHeight;}else{return;}
if(position===start||other===start){$media.style[start]='0';return;}
if(position===end||other===end){$media.style[end]='0';return;}
if(position==='center'||position==='50%'){$media.style[start]='50%';$media.style['margin-'+start]=side/-2+'px';return;}
if(position.indexOf('%')>=0){position=parseInt(position,10);if(position<50){$media.style[start]=position+'%';$media.style['margin-'+start]=side*(position/-100)+'px';}else{position=100-position;$media.style[end]=position+'%';$media.style['margin-'+end]=side*(position/-100)+'px';}
return;}
else{$media.style[start]=position;}};var objectFit=function($media){var fit=$media.dataset?$media.dataset.objectFit:$media.getAttribute('data-object-fit');var position=$media.dataset?$media.dataset.objectPosition:$media.getAttribute('data-object-position');fit=fit||'cover';position=position||'50% 50%';var $container=$media.parentNode;checkParentContainer($container);checkMediaProperties($media);$media.style.position='absolute';$media.style.width='auto';$media.style.height='auto';if(fit==='scale-down'){if($media.clientWidth<$container.clientWidth&&$media.clientHeight<$container.clientHeight){fit='none';}else{fit='contain';}}
if(fit==='none'){setPosition('x',$media,position);setPosition('y',$media,position);return;}
if(fit==='fill'){$media.style.width='100%';$media.style.height='100%';setPosition('x',$media,position);setPosition('y',$media,position);return;}
$media.style.height='100%';if((fit==='cover'&&$media.clientWidth>$container.clientWidth)||(fit==='contain'&&$media.clientWidth<$container.clientWidth)){$media.style.top='0';$media.style.marginTop='0';setPosition('x',$media,position);}else{$media.style.width='100%';$media.style.height='auto';$media.style.left='0';$media.style.marginLeft='0';setPosition('y',$media,position);}};var objectFitPolyfill=function(media){if(typeof media==='undefined'||media instanceof Event){media=document.querySelectorAll('[data-object-fit]');}else if(media&&media.nodeName){media=[media];}else if(typeof media==='object'&&media.length&&media[0].nodeName){media=media;}else{return false;}
for(var i=0;i<media.length;i++){if(!media[i].nodeName)continue;var mediaType=media[i].nodeName.toLowerCase();if(mediaType==='img'){if(edgePartialSupport)continue;if(media[i].complete){objectFit(media[i]);}else{media[i].addEventListener('load',function(){objectFit(this);});}}else if(mediaType==='video'){if(media[i].readyState>0){objectFit(media[i]);}else{media[i].addEventListener('loadedmetadata',function(){objectFit(this);});}}else{objectFit(media[i]);}}
return true;};if(document.readyState==='loading'){document.addEventListener('DOMContentLoaded',objectFitPolyfill);}else{objectFitPolyfill();}
window.addEventListener('resize',objectFitPolyfill);window.objectFitPolyfill=objectFitPolyfill;})();