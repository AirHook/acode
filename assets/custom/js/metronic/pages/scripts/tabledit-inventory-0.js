var Tabledit = function () {

    var base_url = $('body').data('base_url');

    var handleTabledit = function() {

        // reference links (as of 20190518):
        // https://markcell.github.io/jquery-tabledit/
        // https://www.jqueryscript.net/table/Inline-Table-Editing-jQuery-Tabledit.html
        $('#table-inventory-physical').Tabledit({
            deleteButton: false,
            editButton: false,
            columns: {
                identifier: [0, 'st_id'],
                editable: [
                    [3, 'size_ss'], [4, 'size_sm'], [5, 'size_sl'], [6, 'size_sxl'],
                    [7, 'size_sxxl']
                ]
            },
            inputClass: 'input-invenotry',
            url: base_url + 'admin/inventory/live_edit.html',
            onAjax: function(action, serialize){
                // check if input is empty
                var pairs = serialize.split('+').join('').split('&');
                pairs.forEach(function(pair){
                    pair = pair.split('=');
                    if (pair[0] != 'st_id' && pair[0] != 'action') {
                        if (pair[1] === '') {
                            alert('Empty value is not alowed.\nPlease try again.');
                            location.reload();
                        }
                    }
                });
            },
            onFail: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus+'\n'+errorThrown);
            }
        });

    }

    return {
        //main function to initiate the module
        init: function () {

            handleTabledit();

        }

    };

}();

jQuery(document).ready(function() {
    Tabledit.init();
});
