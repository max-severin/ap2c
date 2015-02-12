$(function(){
    
    $(".category-name").keyup(function(){

        var t = $(this);

        if ( t.val().length >= 2 ) {
            var resultBlock = $('<div/>').addClass("category-result loading");

            if ($(".category-result").length > 0) {
                $(".category-result").remove();
            } 

            t.after(resultBlock);

            $.ajax({
                type: "POST",
                url: "?plugin=ap2c&action=getcategories",
                data: "query="+t.val(),
                success: function(response){
                    var result = $.parseJSON(response);
                    if (result.status === 'ok') {
                        resultBlock.removeClass("loading");
                        if (result.data.categories.length > 0) {
                            for(var key in result.data.categories) {
                                var categoryWrapper = $('<div/>').addClass("category-result-wrapper");
                                var categoryId = $('<input/>').attr("type", "hidden").addClass("category-result-id").val(result.data.categories[key].id);
                                var categoryName = $('<span/>').addClass("category-result-name").html(result.data.categories[key].name);
                                var categoryDescription = $('<span/>').addClass("category-result-description").html(result.data.categories[key].description);
                                
                                categoryWrapper.append(categoryId).append(categoryName).append(categoryDescription);
                                resultBlock.append(categoryWrapper);                  
                            }                                      
                        } else {
                            resultBlock.addClass("no-categories").html("Извините, ничего не было найдено, попробуйте изменить свой запрос");
                        }                       
                    }
                }
            }, 'json');
        } else {
            $(".category-result").remove();
            t.closest(".value").find("input.category-id").val('');
        }
        
    });

});

$(document).on('click', ".category-result-wrapper", function() {

    var t = $(this);
    var tId = t.find(".category-result-id").val();
    var tName = t.find(".category-result-name").html();
    
    if (tId && tName) {
        t.closest(".value").find("input.category-id").val(tId);
        t.closest(".value").find("input.category-name").val(tName);
        $(".category-result").remove();
    }

});