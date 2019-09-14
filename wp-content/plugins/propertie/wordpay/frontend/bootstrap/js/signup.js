var postForm12 = jQuery( '#signup' );
postForm12.on( 'submit', function( e ) {
    e.preventDefault();
      var first_name= $('#first_name').val();
      var last_name= $('#last_name').val();
      var email= $('#email2').val();
      var password= $('#password1').val();
      var domain= $('#website').val();
      var user_type= $('#user_type').val();
      var wordpress_min_price= $('#minprice1').val();
      var wordpress_max_price= $('#maxprice1').val();
      var wordpress_fixed_coins= $('#fixedprice1').val();
      var wordpress_post_id= $('#postid1').val();
      var wordpress_title= $('#posttitle1').val();
      var wordpress_post_url=$('#post_url1').val();
      var wordpress_article_type=$('#article_type1').val();
      var cpd_id = $('#cpd_id1').val();
      var count = 0;
      /*error code client side*/
      $(".error").remove();
      if (first_name!="" || last_name!="",email!=null || password!="")
    {
        if (first_name.length < 1) {
        $('#first_name').before('<span class="error">This field is required</span>');
        count = count +1;
      }
      if (last_name.length < 1) {
        $('#last_name').before('<span class="error">This field is required</span>');
        count = count +1;
      }
      if (email.length < 1) {
        $('#email2').before('<span class="error">This field is required</span>');
        count = count +1;
      } else {
        var regEx = /\S+@\S+\.\S+/;
        var validEmail = regEx.test(email);
        if (!validEmail) {
          $('#email2').before('<span class="error">Enter a valid email</span>');
          count = count +1;
        }
      }
      if (password.length < 8) {
        $('#password1').before('<span class="error">Password must be at least 8 characters long</span>');
        count = count +1;
      }
    }
    if(count == 0){
      
      /*close code client side*/
   jQuery.ajax({
        type: 'POST',
        url: signup_signin_object.ajax_url,
        data: {
        'data': {first_name:first_name,last_name:last_name,email:email,password:password,domain:domain,
        user_type:user_type,wordpress_min_price:wordpress_min_price,wordpress_max_price:wordpress_max_price,wordpress_fixed_coins:wordpress_fixed_coins,wordpress_post_id:wordpress_post_id,
        wordpress_title:wordpress_title,wordpress_post_url:wordpress_post_url,wordpress_article_type:wordpress_article_type,cpd_id:cpd_id},
        action: 'signup_curl_responce'
        },
        success: function( data ) {
          var data1= JSON.parse(data);
          if(data1.status == "failure")
          {
          var message1=data1.message;
          var message11=data1.payload.email;
          jQuery("#result1").html('<p style="color:red;">'+message1+"</br>"+message11+'</p>');
          }else
          {
            var data1= JSON.parse(data);
            message=data1.message;
             jQuery("#result1").html('<p style="color:red;">'+message+'</p>');
          }
        
        },
    });
 }
});
