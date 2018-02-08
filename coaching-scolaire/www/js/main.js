"use strict";

$(function(){

    if (typeof FormFilter === 'function') {
        var formFilter = new FormFilter($('form'));
        formFilter.run()
    }
    $(document).scroll(onScrollPage);
});

function onScrollPage(){
    if(scrollY>= 1){
        $("#discover").slideUp(200);
    }else {
        $("#discover").slideDown(200);
    }
}