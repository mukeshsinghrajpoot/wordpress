jQuery(document).ready(function(){
	jQuery("#myForm45 input[type=radio]").on("change",function(){
	var production =jQuery("input[name='production']:checked").val();
	var selected = jQuery('select[name=selected]').val();
	jQuery.ajax({
                type: 'POST',
                url: wordpaygeneralsetiong_object.ajax_url,
                data: {
                'production1': {production:production,selected:selected},
                action: 'wordpaygeneralsetiong_ajax_process_request'
                },
                success: function( data ) {
                 jQuery("#result").html(data);
                 jQuery("#result").fadeTo(2000, 500).slideUp(500, function(){
                 jQuery("#result").slideUp(500);
                }); 
                 /*setTimeout(function(){
                 location.reload(true);
                }, 2000)*/
                },
                error: function(data) {  
               var message=data.responseJSON.message;
               jQuery("#result").html('<p style="color:red;">'+message+'<p>');
            },
  });
  });
   });