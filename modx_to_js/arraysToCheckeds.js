//Универсальное решение для проставления checked для checkbox-ов при перезагрузке страницы
//на основе input hidden, содержащих массивы с id-шниками, например:
//<input type="hidden" id="get-cities" value="['89','90','91']">
//<input type="hidden" id="get-regions" value="['70']">
//установит chekbox-ы с соответствующими value в положение checked
var arrayToChecked = ['regions', 'cities'];
arrayToChecked.map(function(name){
    if(!$('#get-' + name).val())
        return;

    var values = $.parseJSON($('#get-' + name).val());
    values.map(function(value){
        $('input[name="' + name + '[]"][value="'+value+'"]').attr('checked','checked');
    });
});
