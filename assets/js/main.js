/* Global Variables */
"use strict";
let base_url = window.location.origin;

/* Load Data into DataTables */
function loadDataTable(tableId,url='',translate='',tools=false,search=false, order = [],columnDefs = [],buttonTrans= []){
    let buttons = [];
    if(tools === true){
        buttons = [{ extend: 'copyHtml5', text: '<i class="la la-copy"></i> '+buttonTrans[0], exportOptions: { columns: [ 0, ':visible' ] } },{ text: '<i class="la la-print"></i> '+buttonTrans[1], extend: 'print', autoPrint: true },{ text: '<i class="la la-download"></i> '+buttonTrans[2], extend: 'excelHtml5', autoPrint: true },{ text: '<i class="la la-download"></i> '+buttonTrans[3], extend: 'pdfHtml5', orientation: 'landscape', autoPrint: true, pageSize: 'A4' }];
    }
    if(translate !== ''){
        translate = base_url+translate;
    }
    if(url !== ''){
        $('#'+tableId).DataTable({
            "responsive": true,
            "dom": 'Bfrtip',
            "order": order,
            "columnDefs": columnDefs,
            "buttons": buttons,
            "iDisplayLength": 10,
            "aaSorting": [],
            "bJQueryUI": true,
            "searching": search,
            "bLengthChange": true,
            "bPaginate": true,
            "bInfo": true,
            "bSort": true,
            "ajax": url,
            "language": {
                "url": translate,
            },
            "success": function (data) {
                data = data || [];
            }
        });
    }else{
        $('#'+tableId).DataTable({
            "responsive": true,
            "dom": 'Bfrtip',
            "order": order,
            "columnDefs": columnDefs,
            "buttons": buttons,
            "iDisplayLength": 10,
            "aaSorting": [],
            "bJQueryUI": true,
            "searching": search,
            "bLengthChange": true,
            "bPaginate": true,
            "bInfo": true,
            "bSort": true,
            "language": {
                "url": translate,
            },
            "success": function (data) {
                data = data || [];
            }
        });
    }
}

/* Load Data into DataTables AJAX */
function loadDataTableAjax(tableId,url='',translate='',tools=false,search=false, order = [],columnRet = [],columnDefs = [],buttonTrans= []){
    let buttons = [];
    if(tools === true){
        buttons = [{ extend: 'copyHtml5', text: '<i class="la la-copy"></i> '+buttonTrans[0], exportOptions: { columns: [ 0, ':visible' ] } },{ text: '<i class="la la-print"></i> '+buttonTrans[1], extend: 'print', autoPrint: true },{ text: '<i class="la la-download"></i> '+buttonTrans[2], extend: 'excelHtml5', autoPrint: true },{ text: '<i class="la la-download"></i> '+buttonTrans[3], extend: 'pdfHtml5', orientation: 'landscape', autoPrint: true, pageSize: 'A4' }];
    }
    if(translate !== ''){
        translate = base_url+translate;
    }
    $('#'+tableId).DataTable({
        "responsive": true,
        "dom": 'Bfrtip',
        "order": order,
        "buttons": buttons,
        "iDisplayLength": 10,
        "aaSorting": [],
        "bJQueryUI": true,
        "searching": search,
        "bLengthChange": true,
        "bPaginate": true,
        "bInfo": true,
        "bSort": true,
        "language": {
            "url": translate,
        },
        "processing": false,
        "serverSide": true,
        "serverMethod": "post",
        "ajax": {
            'url':url,
            "contentType": "application/json",
            'data': function(data){
                let csrfName = $('.txt_csrfname').attr('name'); // CSRF Token name
                let csrfHash = $('.txt_csrfname').val(); // CSRF hash
                return JSON.stringify({
                    data: data,
                    [csrfName]: csrfHash // CSRF Token
                });
            },
            dataSrc: function(data){
                $('.txt_csrfname').val(data.token);
                return data.aaData;
            }
        },
        columns: columnRet,
        columnDefs: columnDefs
    });
}