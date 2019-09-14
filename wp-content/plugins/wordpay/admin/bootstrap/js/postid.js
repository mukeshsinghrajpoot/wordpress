jQuery(document).ready(function(){
jQuery('#custom_element_grid_class').on('change', function() {
var postid=jQuery(this).val();
 jQuery.ajax({
                type: 'POST',
                url: post_js_object.ajax_url,
                data: {
                'postid':  postid,
                action: 'post_ajax_process_request'
                },
                success: function( data ) {
                var array = JSON.parse(data);
                fixedprice13=array.fixedprice13;
                jQuery('#minprice').val(array.minprice13);
                jQuery('#maxprice').val(array.maxprice13);
                jQuery('#fixedpricenew').val(array.fixedprice13);
                },
                error: function(data) {  
               var message=data.responseJSON.message;
               jQuery("#result").html('<p style="color:red;">'+message+'<p>');
            },
  });
});
});
jQuery(document).ready(function (){
  var cpdid = jQuery("#cpid").val();
  var wpmode = jQuery("#wpmode12").val();
  jQuery.ajax({
        type: 'POST',
        url: postid12_js_object.ajax_url,
        data: {
        'cpdid':cpdid,
        'wpmode':wpmode,
        action: 'postid_curl_responce'
        },
        success: function( data ) {
           var data1 = JSON.parse(data);
           if(data1.status=="failure")
           {
            jQuery('#exampleFormControlSelect1').append( '<option value="'+data1.message+'">'+data1.message+'</option>' );
           }else{ 
            var vat_apply = data1.payload.vat_apply;
            vat = 0;
            jQuery(data1).each(function (index, item) {
                    response=item.payload.country_list;
                     jQuery.each(response, function(key,value) {
                         if(vat_apply==1){
                            vat = value['vat'];  
                         }
                                                  
                        jQuery('#exampleFormControlSelect1').append( '<option pricevat="'+vat+'" value="'+value['country_id']+'">'+value['country_name']+'</option>' );
                     }); 
                });
          }
        },
        error: function(data) {  
            
               
            },
    });
});
jQuery('#exampleFormControlSelect1').on('change', function() {
  var fixedpricenew = jQuery("#fixedpricenew").val();
  var pricevat = jQuery('option:selected', this).attr('pricevat');
  var fixedpricenew1=parseFloat(fixedpricenew);
  var pricevat1=parseFloat(pricevat);
  if(pricevat=='null')
  {
        jQuery('#fixedpricenewibclval').val(fixedpricenew);
  }else
  {
    var inclvat=(fixedpricenew1/100)*pricevat1;
    var totalinclvat=inclvat+fixedpricenew1;
    jQuery('#fixedpricenewibclval').val(totalinclvat);
  }
});
