let searchField = $('#textSearch');
let searchButton = $('#searchButton');

searchButton.click(function(){

    let divs = $('.advertBody');
    let spans = $('.advertTitle');
    divs.each(function(){
        $(this).hide();
    })

    if(searchField.val().length > 0){
        divs = divs.filter(":contains('" + searchField.val() + "')");
    }

    divs.each(function(){
        $(this).show();
    })

    searchField.val('');
});
