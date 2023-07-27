;(function($){$.fn.recliner=function(options){var $w=$(window),elements=this,selector=this.selector,loaded,timer,options=$.extend({attrib:'data-src',throttle:300,threshold:100,printable:true,live:true,getScript:false},options);function load(e){var $e=$(e),source=$e.attr(options.attrib),type=$e.prop('tagName');if(source){$e.addClass('lazy-loading');if(/^(IMG|IFRAME|AUDIO|EMBED|SOURCE|TRACK|VIDEO)$/.test(type)){$e.attr('src',source);$e[0].onload=function(ev){onload($e);};}
else if($e.data('script')){$.getScript(source,function(ev){onload($e);});}
else{$e.load(source,function(ev){onload($e);});}}
else{onload($e);}}
function onload(e){e.removeClass('lazy-loading');e.addClass('lazy-loaded');e.trigger('lazyshow');}
function process(){var viewportHeight=(typeof window.innerHeight!=='undefined')?window.innerHeight:$w.height();var eof=(window.innerHeight+window.scrollY)>=document.body.offsetHeight;var inview=elements.filter(function(){var $e=$(this);if($e.css('display')=='none')return;var wt=$w.scrollTop(),wb=wt+viewportHeight,et=$e.offset().top,eb=et+$e.height();return(eb>=wt-options.threshold&&et<=wb+options.threshold)||eof;});loaded=inview.trigger('lazyload');elements=elements.not(loaded);}
function init(els){els.one('lazyload',function(){load(this);});process();}
$w.on('scroll.lazy resize.lazy lookup.lazy',function(ev){if(timer)
clearTimeout(timer);timer=setTimeout(function(){$w.trigger('lazyupdate');},options.throttle);});$w.on('lazyupdate.lazy',function(ev){process();});if(options.live){$(document).on('ajaxSuccess.lazy',function(){var $e=$(selector).not('.lazy-loaded').not('.lazy-loading');elements=elements.add($e);init($e);});}
if(options.printable&&window.matchMedia){window.matchMedia('print').addListener(function(mql){if(mql.matches){$(selector).trigger('lazyload');}});}
init(this);return this;};$.fn.derecliner=function(options){var $w=$(window);$w.off('scroll.lazy resize.lazy lookup.lazy');$w.off('lazyupdate.lazy');$(document).off('ajaxSuccess.lazy');};})(jQuery);