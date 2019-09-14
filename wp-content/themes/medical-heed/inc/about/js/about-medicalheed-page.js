jQuery( document ).ready( function ($) {
    "use strict";
    
    // Get URL
    var getURL  = window.location.href,
        baseURL = getURL.substring(0, getURL.indexOf('/wp-admin') + 9);

    // Install and Activate
    $( '#medicalheed-demo-content-inst' ).on( 'click', function() {

            $('#medicalheed-demo-content-inst').html( 'Installing Import Plugin...' );

            var data = {
                action: 'medical_heed_plugin_auto_activation'
            };

            wp.updates.installPlugin({
                slug: 'one-click-demo-import',
                success: function(){
                    $.post(ajaxurl, data, function(response) {
                        $('#medicalheed-demo-content-inst').html( 'Redirecting...' );
                        window.location.replace( baseURL + '/themes.php?page=pt-one-click-demo-import' );
                    })
                }
            });

        }
    );

    // Activate
    $( '#medicalheed-demo-content-act' ).on( 'click', function() {

            $('#medicalheed-demo-content-act').html( 'Installing Import Plugin...' );

            var data = {
                action: 'medical_heed_plugin_auto_activation'
            };

            $.post(ajaxurl, data, function(response) {
                $('#medicalheed-demo-content-act').html( 'Redirecting...' );
                window.location.replace( baseURL + '/themes.php?page=pt-one-click-demo-import' );
            })

        }
    );

});