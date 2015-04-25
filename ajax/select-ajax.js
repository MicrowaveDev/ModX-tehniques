if($('select.ajax').length){
    var $parents = $('select.ajax');
    $parents.each(function(){
        var $parent = $(this);

        function onParentChange($_parent){
            var $child = $('select[name="'+$_parent.data('to')+'"]');
            var id = parseInt($_parent.val());
            if(!id) {
                $child.prop('disabled', 'disabled');
                return;
            }
            $.post($_parent.data('url') || 'ajax/children-names', {
                parent: id,
                template: $_parent.data('template'),
                context: $_parent.data('context'),
                depth: $_parent.data('depth')
            }, function(data){
                var notSelect = $child.data('not-select') || 'Не выбрано';
                var result = '<option value="">' + notSelect + '</option>';
                var selected = $('#' + $_parent.data('to') + '-hidden').val();
                for (var id in data) {
                    if (data.hasOwnProperty(id)) {
                       result += '<option value="'
                                    + id + '"'
                                    + ((selected==id) ? 'selected="selected"' : '') + '>'
                                    + data[id] + '</option>';
                    }
                }

                $child.html(result);
                $child.removeAttr("disabled");
            });
        }

        $parent.change(function(){
            onParentChange($(this));
        });

        onParentChange($parent);
    });
}
