var postForm = jQuery( '#post-form' );
postForm.on( 'submit', function( e ) {
    e.preventDefault();
   jQuery.ajax({
        type: 'POST',
        url: ajax_script_object.ajax_url,
        data: {
        'data':postForm.serialize(),
        action: 'wordpay_api_key_responce'
        },
        success: function( data ) {
          var data1= JSON.parse(data);
            if(data1.status == "success") {
              apiinsert(data1);               
            } else {
              jQuery("#result").html('<p style="color:red;font-size: 21px;font-weight:900;text-align: center;">'+data1.message+'<p>');
            };
        },
    });
});
function apiinsert(data)
{
  var cpd_id=data.payload.cpd_id;
  var company_id=data.payload.company_id;
  var name=data.payload.name;
  var domain=data.payload.domain;
  jQuery.ajax({
      
                type: 'POST',
                url: js_object.ajax_url,
                data: {
                'test':  postForm.serialize(),
                'userdetalis': {cpd_id:cpd_id,company_id:company_id,name:name,domain:domain},
                action: 'text_ajax_process_request'
                },
                success: function( data ) {
                 jQuery("#result").html(data);
                /*jQuery("#result").fadeTo(2000, 500).slideUp(500, function(){
                 jQuery("#result").slideUp(500);
                });*/
                setTimeout(function(){
        		location.reload();
    			}, 3000)  
                },
                error: function(data) {  
               var message=data.responseJSON.message;
               jQuery("#result").html('<p style="color:red;font-size: 21px;font-weight:900;">'+message+'<p>');
            },
  });

}