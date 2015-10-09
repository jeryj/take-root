/**
 * scripts.js
 *
 * General site scripts
 */

jQuery( document ).ready( function( $ ) {

    //js check
    $('body').removeClass('no-js');


    // checks for window width and sets heights for css transitions

        // calculate our menu heights so we can use css transitions
        function calculateMenuHeights() {
            // Set the heights and data for each submenu-container
            $('.sub-menu').each(function(){
                var submenuHeight = $(this).outerHeight();
                $(this).data('containerHeight', submenuHeight);
                // set the height
                $(this).css('height','0');
            });
        }

        function menuResizedWindow(){
            // get window width in EMs
            menuWindowWidth = $(window).width() / parseFloat($("html").css("font-size"));
            // set the data attribute on the window for it
            $(window).data('windowWidth', menuWindowWidth);

            // remove all classes and clicks
            unbindEverything();
            // recalculate the menu heights
            calculateMenuHeights();
            // add a class to the body
            if(48 < menuWindowWidth) {
                $('body').addClass('desktop');
            } else if(menuWindowWidth < 48 && menuWindowWidth > 34) {
                $('body').addClass('tablet');
            } else if (menuWindowWidth < 34) {
                $('body').addClass('mobile');
            } else {
                console.log(menuWindowWidth);
            }
            //build the menus
            buildMenus(menuWindowWidth);
        }

        // Resize delay
        var menuFireResize;
        $(window).resize(function(){
          clearTimeout(menuFireResize);
          // what to do when the resize is finished - fire our resizeWindow function
          menuFireResize = setTimeout(menuResizedWindow, 250);
        });

        function unbindEverything(){
            // Reset .subcontainer heights
            $('.sub-menu').css('height','').removeClass('active');
            // Remove active class from everything
            $('.main-navigation').removeClass('toggled');
            $('.headroom').removeClass('toggled');
            $('.menu-toggle .bar').removeClass('animate');
            $('.main-navigation li').removeClass('active').removeClass('active-bars');

            // remove our classes for identifying screen size
            $('body').removeClass('desktop');
            $('body').removeClass('tablet');
            $('body').removeClass('mobile');
        }

    // run the function to set window with on load
    menuResizedWindow();

    // create the close sub-menu buttons
    $('<i class="icon-xcircle close-submenu"></i>').insertBefore('.sub-menu');


    // build the menus
    function buildMenus(menuWindowWidth) {

        // if  we're using the hamburger menu and something is active, open it
            // should I just check the visibility of the hamburger menu item? Would that be easier?

        // find the current menu item. that's the only one we care about
        if( $('.main-navigation li').hasClass('current-menu-item')) {
            // one of them has a current item, so let's use it
            var currentItem = $('.main-navigation .current-menu-item');


            // check if we're in the submenu or top level
            if(currentItem.parent().hasClass('sub-menu')) {
                itemOrParent = 'parent';
            } else {
                itemOrParent = 'item';
            }
            // add the active bars class to the item or parent
            $('.current-menu-'+itemOrParent).addClass('active-bars');

            // if mobile
            if(menuWindowWidth < 48) {
                // find the sub-menu
                if(currentItem.hasClass('menu-item-has-children')) {
                    currentSubMenu = $('.current-menu-'+itemOrParent+' .sub-menu');
                    // $('.current-menu-item .sub-menu');
                } else {
                    currentSubMenu = $('.current-menu-'+itemOrParent+' .sub-menu');
                    // $('.current-menu-parent .sub-menu');
                }

                // add active class to sub menu
                // set height of submenu
                // add active class to parent if it's submenu, the item if it's top level
                $('.current-menu-'+itemOrParent).addClass('active');

                var theContainerHeight = currentSubMenu.data('containerHeight');

                currentSubMenu.css('height',theContainerHeight).addClass('active');
            }


        } else {
            // whatcha wanna do when nothing is active?
        }
    }

    // hamburger click to reveal menu
    // using tappy.js

    $('.menu-toggle').on('tap', function() {
        $('.main-navigation').toggleClass('toggled');
        $('.headroom').toggleClass('toggled');
        $(this).toggleClass('animate');
        $('.bar', this).toggleClass('animate');
    });

    // menu anchor click functions
    // using tappy.js

    $('.menu-item-has-children a').on('tap', function(e) {
        e.preventDefault();
        // record the parent item
        if($(this).parent().hasClass('menu-item-has-children')) {
            // top level
            topLevel = $(this).parent();
            subMenu = false;
        } else {
            // it's in the subMenu
            topLevel = $(this).parent().parent().parent();
            subMenu = true;
        }

        if(topLevel.hasClass('active')) {

            // go to the link
            window.location = $(this).attr('href');

        } else {
            $('.sub-menu').css('height','0').removeClass('active');
            $(topLevel).siblings().removeClass('active').removeClass('active-bars');
            $(topLevel).addClass('active');
            if(!topLevel.hasClass('active-bars')) {
                topLevel.addClass('active-bars');
            }
            var theContainerHeight = $('.sub-menu', topLevel).data('containerHeight');
            $('.sub-menu', topLevel).css('height',theContainerHeight).addClass('active');
        }
    });

    $('.close-submenu').on('tap', function() {
        $(this).siblings('.sub-menu').css('height','0').removeClass('active');
        $(this).parent().removeClass('active-bars').removeClass('active');

        if( $('.main-navigation li').hasClass('current-menu-item')) {
            // one of them has a current item, so let's use it
            var currentItem = $('.main-navigation .current-menu-item');

            // check if we're in the submenu or top level
            if(currentItem.hasClass('menu-item-has-children')) {
                itemOrParent = 'item';
                // $('.current-menu-item').addClass('active-bars');
            } else {
                itemOrParent = 'parent';
                // $('.current-menu-parent').addClass('active-bars');
            }
            // add the active bars class to the item or parent
            $('.current-menu-'+itemOrParent).addClass('active-bars');
        } else {
            // whatcha wanna do when nothing is active?

        }
    });

});
