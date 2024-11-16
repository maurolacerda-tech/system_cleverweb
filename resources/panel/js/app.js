import './bootstrap';

import.meta.glob([
    '../images/**',
]);



function openmenu_active(){
    $('.menu-link').each(function(){
        var thielen2 = $(this);
        if (thielen2.hasClass("active")) {
            thielen2.closest('.menu-accordion').addClass('show');
            thielen2.closest('.menu-accordion').addClass('hover');
        }
    });
}

window.navigatemenu = function(){

    var nodeList = document.querySelectorAll('*[data-kt-menu-trigger="click"]');
    for (let i = 0; i < nodeList.length; i++) {
        $(nodeList[i]).unbind('click');
        $(nodeList[i]).on('click',function(){
            var thielen = $(this);
            thielen.parent().parent().parent().parent().find('[data-kt-menu-trigger="click"]').each(function(){
                if(thielen.attr('id') != $(this).attr('id')){
                    $(this).removeClass('show');
                    $(this).removeClass('hover');
                }
                
            });
            if (!thielen.hasClass("show")) {
                thielen.addClass('show');
                thielen.addClass('hover');
                thielen.parent().find('.menu-sub-dropdown').addClass('show');
            }else{
                thielen.removeClass('show');
                thielen.removeClass('hover');
                thielen.parent().find('.menu-sub-dropdown').removeClass('show');
            }
        });
    }
}


$(document).ready(function(){
    
    navigatemenu();
    openmenu_active();
    $('select[data-control=select2]').select2();

    document.addEventListener('livewire:navigated', () => {
        navigatemenu();
        openmenu_active();
        $('select[data-control=select2]').select2();
        
    });

   
    Livewire.hook('morph.updated', ({ el, component }) => {
        navigatemenu();
        openmenu_active();
        $('select[data-control=select2]').select2();
    })
    
    
    Livewire.hook('morph.added', ({ el, component }) => {
        setTimeout(() => {
            navigatemenu();
            openmenu_active();
            $('select[data-control=select2]').select2();
        }, 300);
    });

 

    $('#kt_aside_toggle').on('click',function(){

        var attr = $('body').attr('data-kt-aside-minimize');

        if (typeof attr !== 'undefined' && attr !== false) {
            $('body').removeAttr('data-kt-aside-minimize');
            $(this).removeClass('active');
        }else{
            $('body').attr('data-kt-aside-minimize','on');
            $(this).addClass('active');
        }

        
    });

});