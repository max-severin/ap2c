$(function(){
    
    $("#active_category_subcategories").change(function() {
        
        $('.choice-string').show();
        $('.active_category_subcategory').hide();
        $('.active_category_subcategory[rel="'+$(this).val()+'"]').show();

    });
    
    $(".active_category_subcategory").change(function() {

        $('#additional_product_id').val($(this).val());        

    });

    $('.add2cart input[type="submit"]').click(function() {

        var apId = $('#additional_product_id').val();

        if (apId > 0) {
            $.post("{$cart_url}add/?html=1", 'product_id='+apId+'&quantity=1', function (response) { });
        }
        
    });

});
