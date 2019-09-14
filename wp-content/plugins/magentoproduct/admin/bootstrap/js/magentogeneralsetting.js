var postForm = jQuery( '#Apiform' );
postForm.on( 'submit', function( e ) {
    e.preventDefault();
   jQuery.ajax({
        type: 'POST',
        url: magentogeneralsetting_object.ajax_url,
        data: {
        'data':postForm.serialize(),
        action: 'magento_api_key_responce'
        },
       success: function( data ) {
                 jQuery("#result").html(data);
                jQuery("#result").fadeTo(2000, 500).slideUp(500, function(){
                 jQuery("#result").slideUp(500);
                });
                setTimeout(function(){
            location.reload();
          }, 3000)  
                },
    });
});