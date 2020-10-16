var Tabledit = function () {

    var base_url = $('body').data('base_url');

    var handleTabledit = function() {

        // reference links (as of 20190518):
        // https://markcell.github.io/jquery-tabledit/
        // https://www.jqueryscript.net/table/Inline-Table-Editing-jQuery-Tabledit.html
        $('#table-inventory-size_mode-1').Tabledit({
            deleteButton: false,
            editButton: false,
            hideIdentifier: true,
            columns: {
                identifier: [0, 'st_id'],
                editable: [
                    [3, 'size_0'], [4, 'size_2'], [5, 'size_4'], [6, 'size_6'],
                    [7, 'size_8'], [8, 'size_10'], [9, 'size_12'], [10, 'size_14'],
                    [11, 'size_16'], [12, 'size_18'], [13, 'size_20'], [14, 'size_22']
                ]
            },
            inputClass: 'input-inventory',
            url: base_url + 'admin/inventory/live_edit.html',
            onAjax: function(action, serialize){
                // serialize = st_id=5903&size_22=0&action=edit
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
            onSuccess: function(data){
                //alert(JSON.stringify(data));
            },
            onFail: function(jqXHR, textStatus, errorThrown) {
                alert('ERROR1: '+textStatus+'\n'+errorThrown);
                alert('Ooops... Something went wrong. Please contact admin.');
                location.reload();
            }
        });

        $('#table-inventory-size_mode-0').Tabledit({
            deleteButton: false,
            editButton: false,
            hideIdentifier: true,
            columns: {
                identifier: [0, 'st_id'],
                editable: [
                    [3, 'size_ss'], [4, 'size_sm'], [5, 'size_sl'], [6, 'size_sxl'],
                    [7, 'size_sxxl']
                ]
            },
            inputClass: 'input-inventory',
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
                //alert('ERROR0: '+textStatus+'\n'+errorThrown);
                alert('Ooops... Something went wrong. Please contact admin.');
                location.reload();
            }
        });

        $('#table-inventory-size_mode-2').Tabledit({
            deleteButton: false,
            editButton: false,
            hideIdentifier: true,
            columns: {
                identifier: [0, 'st_id'],
                editable: [
                    [3, 'size_sprepack1221']
                ]
            },
            inputClass: 'input-inventory',
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
                //alert('ERROR2: '+textStatus+'\n'+errorThrown);
                alert('Ooops... Something went wrong. Please contact admin.');
                location.reload();
            }
        });

        $('#table-inventory-size_mode-3').Tabledit({
            deleteButton: false,
            editButton: false,
            hideIdentifier: true,
            columns: {
                identifier: [0, 'st_id'],
                editable: [
                    [3, 'size_ssm'], [4, 'size_sml']
                ]
            },
            inputClass: 'input-inventory',
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
                //alert('ERROR3: '+textStatus+'\n'+errorThrown);
                alert('Ooops... Something went wrong. Please contact admin.');
                location.reload();
            }
        });

        $('#table-inventory-size_mode-4').Tabledit({
            deleteButton: false,
            editButton: false,
            hideIdentifier: true,
            columns: {
                identifier: [0, 'st_id'],
                editable: [
                    [3, 'size_sonesizefitsall']
                ]
            },
            inputClass: 'input-inventory',
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
                //alert('ERROR4: '+textStatus+'\n'+errorThrown);
                alert('Ooops... Something went wrong. Please contact admin.');
                location.reload();
            }
        });

        /*
        $('#table-inventory-physical > td').on('change',function(){
            alert('boom');
        });

        $('.tabledit-input.input-inventory').on('change', function(){
            alert($(this).val());
        });
        */
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
