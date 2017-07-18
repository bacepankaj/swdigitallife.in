
/**
* Theme: SimpleAdmin Template
* Author: Coderthemes
* Main Js File
*
*/


(function ($) {

    'use strict';

    function initSlimscroll() {
        $('.slimscroll').slimscroll({
            height: 'auto',
            position: 'right',
            size: "5px",
            color: '#9ea5ab'
        });
    }

    function initMenu() {
        //toggle
        $('.navbar-toggle').on('click', function (event) {
            $(this).toggleClass('open');
            $('#navigation').slideToggle(400);
        });

        $('.navigation-menu>li').slice(-1).addClass('last-elements');

        $('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
            if ($(window).width() < 1025) {
                e.preventDefault();
                $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
            }
        });
    }

    function initLeftMenuCollapse() {
        // Left menu collapse
        $('.button-menu-mobile').on('click', function (event) {
            event.preventDefault();
            $("body").toggleClass("nav-collapse");
        });
    }

    function initComponents() {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();

        $('[data-plugin="switchery"]').each(function (idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
    }

    function initActiveMenu() {
        // === following js will activate the menu in left side bar based on url ====
        $(".navigation-menu a").each(function () {
            if (this.href == window.location.href) {
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this).parent().parent().parent().addClass("active"); // add active class to an anchor
                $(this).parent().parent().parent().parent().parent().addClass("active"); // add active class to an anchor
            }
        });
    }
    
    function ajaxSetup() {
        // global ajax setup
        $.ajaxSetup({			
            async: true,
            beforeSend: function(){
                /*if(!check_session())
                {
                    bootbox.alert('Oops! your session has expired. Please <a href="<?=$redirectUrl?>">click</a> to login again');
                    return false;
                }
                else*/
                $("#ajax_loader").css("display", "table").fadeIn('fast');					
            },
            complete: function(){				
                $("#ajax_loader").fadeOut('fast');
            }
        });
    }
    
    // check session
    function check_session(){
        var state = true;
        
        $.ajax({					
            async: false,
            url: "<?=AJAX_BASE_URL?>/login/check_session",				
            success: function(r){				
                state = r;
            },
            beforeSend: function(){},
            complete: function(){}		
        });
        
        return state;
    }
    
    function clone(){
        $(this).parent(".cloned")
            .clone().attr('id', 'cloned')               
            .find("input:text, input:hidden, textarea, select").val("").end()
            //.appendTo('#cloned_container')
            .insertAfter($(this).parent(".cloned"))
            .on('click', 'button.clone', clone)
            .on('click', 'button.remove', remove);
    }
    
    function remove(){
        $(this).parents(".cloned").remove();
    }

    function init() {
        initSlimscroll();
        initMenu();
        initLeftMenuCollapse();
        initComponents();
        initActiveMenu();
        ajaxSetup();
        
        $("button.clone").on("click", clone);
        $("button.remove").on("click", remove);
    }

    init();

})(jQuery)