$(document).ready(function () {
    let $body = $('body');
    let $csrfToken = $('meta[name="csrf-token"]').attr("content");
    $('.datepicker').datepicker({dateFormat: 'dd-mm-yy'});
    $body.on('change', '#complectation-warehouse_id', function () {
        var ware_id = $(this).val();
        var date_create = $('#complectation-created_at').val();

        if (ware_id) {

            $.ajax({
                url: '/product/get-product-info',
                method: 'get',
                dataType: 'json',
                data: {wId: ware_id, date_: date_create},
                success: function (data) {
                    $('.hide-block').hide();
                    var opt = '';
                    if (data.length) {
                        opt += '<option>Ընտրել</option>';
                        for (var i = 0; i < data.length; i++) {
                            if (data[i].namiclature_data.individual != 'true') {
                                opt += '<option data-max="' + data[i].count + '" data-individual="' + data[i].namiclature_data.individual + '" value="' + data[i].id + '">' + data[i].namiclature_data.name + ' (' + data[i].count + ' ' + data[i].namiclature_data.qty_type + ') </option>';
                            } else {
                                opt += '<option data-max="' + data[i].count + '" data-individual="' + data[i].namiclature_data.individual + '" value="' + data[i].id + '">' + data[i].namiclature_data.name + ' - ' + data[i].mac_address + ' (' + data[i].count + ' ' + data[i].namiclature_data.qty_type + ')</option>';
                            }
                        }
                    }
                    $('#nomenclature_product').html(opt);
                }
            });
        } else {
            $('.hide-block').show();
        }
    });
    $body.on('change', '#complectation-created_at', function () {
        $('#complectation-warehouse_id').trigger('change');
    });
    $body.on('change', '.nm_products', function () {
        var product_id = $(this).val();
        var max = $(this).find(':selected').data('max');
        var individual = $(this).find(':selected').data('individual');

        if(individual){
            $(this).closest('.product-block').find('.field-complectationproducts-n_product_count input').val(1).attr('disabled','disabled');
            $(this).closest('.product-block').find('.field-complectationproducts-n_product_count input').attr('max',1);
        } else {
            $(this).closest('.product-block').find('.field-complectationproducts-n_product_count input').val('').removeAttr('disabled').attr('max',max);
        }
        var v = $(this).val();

        $(".nm_products").not($(this)).find("option[value='"+v+"']").attr('disabled','disabled');


    });
    $body.on('change', '.counts-input input', function () {
        var rc = 0;
        if(parseInt($(this).val())> parseInt($(this).attr('max'))){
            $(this).closest('.counts-input').find('.help-block').text('Ապրանքների քանակը պահեստում '+$(this).attr('max')+' Է չեք կարող տեղափոխել ' +$(this).val());
            $(this).css('border','1px solid red');
            $('.check-counts').attr('disabled','disabled');
            rc++;
        } else {
            $(this).css('border','1px solid #ccc');
            $(this).closest('.counts-input').find('.help-block').text('');
        }
        if(rc==0){
            $('.counts-input input').css('border','1px solid #ccc');
            $('.check-counts').removeAttr('disabled');
        }
    });
    $body.on('click', '.btn-add-product', function () {

        $(this).closest('.module-service-form-card').find('select').select2('destroy');
        let addressBlock = $(this).closest('.module-service-form-card');
        let rowCount = addressBlock.find('.row').length + 1;

        let firstRow = $('.product-block').first();
        let clone = firstRow.clone(true).removeClass('hide');
        let randomId = makeid(5);

        clone.find('select.form-control').attr('id', function () {
            $(this).val(null).trigger('change');
            return $(this).attr('id') + '_' + (rowCount);
        });
        clone.insertAfter(addressBlock.find('.row').last());

        let $nm_products = $('.module-service-form-card select.form-control');
        let $elCom = $nm_products,
            settingsCom = $elCom.attr('data-krajee-select2'),
            idCom = $elCom.attr('id');
        settingsCom = window[settingsCom];
        $nm_products.select2(settingsCom);

    });
    $body.on('click', '.check-counts', function () {
        $('.nm_products option,input').removeAttr('disabled');
        $('.counts-input input').each(function(){
            if($(this).val()>$(this).attr('max')){
                $(this).css('border','1px solid red');
                return false;
            }
        });
    });
});