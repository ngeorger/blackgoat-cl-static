(function(){"use strict";var __webpack_exports__={};;const browserSupportsPdfs=()=>{if(window.navigator.userAgent.indexOf('Mobi')>-1){return false;}
if(window.navigator.userAgent.indexOf('Android')>-1){return false;}
if(window.navigator.userAgent.indexOf('Macintosh')>-1&&window.navigator.maxTouchPoints&&window.navigator.maxTouchPoints>2){return false;}
if(!!(window.ActiveXObject||'ActiveXObject'in window)&&!(createActiveXObject('AcroPDF.PDF')||createActiveXObject('PDF.PdfCtrl'))){return false;}
return true;};const createActiveXObject=type=>{let ax;try{ax=new window.ActiveXObject(type);}catch(e){ax=undefined;}
return ax;};const hidePdfEmbedsOnUnsupportedBrowsers=()=>{if(!browserSupportsPdfs()){const embeds=document.getElementsByClassName('wp-block-file__embed');Array.from(embeds).forEach(embed=>{embed.style.display='none';});}};;hidePdfEmbedsOnUnsupportedBrowsers();})();