/*close cookies js*/
jQuery(document).ready(function() {
   var sku2=jQuery('#sku2').val();
        jQuery.ajax({
            type: 'POST',
            url: magentoproductcurl_object.ajax_url,
            data: {
            'data':{sku2:sku2},
            action: 'magento_project_curl_responce'
            },
             success: function(data) {
              /* console.log(data);*/
             	jQuery('#products11').html(data);
          },
        });
});
