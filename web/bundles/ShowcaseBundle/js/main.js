'use strict';

$(document).ready(function(){
    $( "#select-category" ).change(function(e) {
        var cards = $('.service-card');
        cards.removeClass('disabled');

        var category = $(this).find("option:selected").attr('value');

        if (category != 'Все') {
            cards
                .filter(function (index, element) {
                    return $(element).find('.service-category').text() !== category;
                })
                .addClass('disabled');
        }
    });
});