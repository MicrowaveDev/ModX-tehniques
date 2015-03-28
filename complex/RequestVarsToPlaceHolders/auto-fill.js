var arrayToChecked = ['cities', 'langs'];
//arrayToChecked - name of checkbox and hidden inputs(plus '#get-')
arrayToChecked.map(function(name){
   if($('#get-' + name).val()){
      var values = $.parseJSON($('#get-' + name).val());
      values.map(function(value){
         $('input[name="' + name + '[]"][value="'+value+'"]').attr('checked','checked');
      });
   }
});
