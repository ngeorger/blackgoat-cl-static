jQuery(function($){'use strict';function update(){var $this=$(this),options=$this.data('options'),$inline=$this.siblings('.rwmb-datetime-inline'),current=$this.val();$this.siblings('.ui-datepicker-append').remove();if($inline.length){options.altField='#'+$this.attr('id');$inline.removeClass('hasDatepicker').empty().prop('id','').timepicker(options).timepicker("setTime",current);}
else{$this.removeClass('hasDatepicker').timepicker(options);}}
$.timepicker.setDefaults($.timepicker.regional[""]);if($.timepicker.regional.hasOwnProperty(RWMB_Time.locale)){$.timepicker.setDefaults($.timepicker.regional[RWMB_Time.locale]);}
else if($.timepicker.regional.hasOwnProperty(RWMB_Time.localeShort)){$.timepicker.setDefaults($.timepicker.regional[RWMB_Time.localeShort]);}
$('.rwmb-time').each(update);$('.rwmb-input').on('clone','.rwmb-time',update);});