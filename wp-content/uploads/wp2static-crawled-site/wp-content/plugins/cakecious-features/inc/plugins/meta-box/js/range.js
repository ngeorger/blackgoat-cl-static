jQuery(function($){'use strict';function update(){var $this=$(this),$output=$this.siblings('.rwmb-output');$this.on('input propertychange change',function(e){$output.html($this.val());});}
$('.rwmb-range').each(update);$(document).on('clone','.rwmb-range',update);});