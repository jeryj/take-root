readme.md
================

If you want to use Headroom.js for your header, add these lines and replace these files.

- Add headroom.min.js to the js folder.
- Add jQuery.headroom.min.js to the js folder.
- Add this code to the end of the js/scripts.js file

    // headroom.js for header
    // grab an element
    $("#masthead").headroom({
                                offset: 0,
                                tolerance : 10,
                                // hide menu options on unpin
                                onUnpin : function() { unPinHeader(); },
                            });

    function unPinHeader() {
        if($('body').hasClass('desktop')) {
            // close the menu
            $('.main-navigation li.active .close-submenu').trigger('tap');
        } else {
            if($('.main-navigation').hasClass('toggled')) {
                //if nav is open, trigger click to close it
                $('.menu-toggle').trigger('tap');
            }

        }
    }

- Add the _headroom.scss file to the stylesheets folder and @import it on ie.scss and style.scss
- Add this code to the osteo_scripts function in functions.php to enqueue the scripts

    // headroom
    wp_enqueue_script( 'osteo-headroom', get_template_directory_uri() . '/js/headroom.min.js', array(), '20120206', true );
    wp_enqueue_script( 'osteo-headroom-jQuery', get_template_directory_uri() . '/js/jQuery.headroom.min.js', array(), '20120206', true );

