jQuery(function($){'use strict';var frame,$doc=$(document);$doc.on('click','.rwmb-file-input-select',function(e){e.preventDefault();var $el=$(this);if(!frame){frame=wp.media({className:'media-frame rwmb-file-frame',multiple:false,title:rwmbFileInput.frameTitle});}
frame.open();frame.off('select');frame.on('select',function(){var url=frame.state().get('selection').first().toJSON().url;$el.siblings('input').val(url).siblings('a').removeClass('hidden');});});$doc.on('click','.rwmb-file-input-remove',function(e){e.preventDefault();$(this).addClass('hidden').siblings('input').val('');});$doc.on('clone','.rwmb-file_input',function(){$(this).siblings('.rwmb-file-input-remove').addClass('hidden');});});