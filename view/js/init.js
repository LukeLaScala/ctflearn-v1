/**
 * Created by luklas on 8/1/16.
 */

$(document).ready(function(){
    $('.tooltipped').tooltip({delay: 50});
    $(".dropdown-button").dropdown();
    $('.modal-trigger').leanModal();

    var slider = document.getElementById('difficulty');
    noUiSlider.create(slider, {
        start: [20, 80],
        connect: true,
        step: 1,
        range: {
            'min': 1,
            'max': 100
        },
        format: wNumb({
            decimals: 0
        })
    });

    $('select').material_select();

});


