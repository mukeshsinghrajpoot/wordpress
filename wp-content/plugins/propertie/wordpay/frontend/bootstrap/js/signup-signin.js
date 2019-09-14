/*! jquery.cookie v1.4.1 | MIT */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?a(require("jquery")):a(jQuery)}(function(a){function b(a){return h.raw?a:encodeURIComponent(a)}function c(a){return h.raw?a:decodeURIComponent(a)}function d(a){return b(h.json?JSON.stringify(a):String(a))}function e(a){0===a.indexOf('"')&&(a=a.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return a=decodeURIComponent(a.replace(g," ")),h.json?JSON.parse(a):a}catch(b){}}function f(b,c){var d=h.raw?b:e(b);return a.isFunction(c)?c(d):d}var g=/\+/g,h=a.cookie=function(e,g,i){if(void 0!==g&&!a.isFunction(g)){if(i=a.extend({},h.defaults,i),"number"==typeof i.expires){var j=i.expires,k=i.expires=new Date;k.setTime(+k+864e5*j)}return document.cookie=[b(e),"=",d(g),i.expires?"; expires="+i.expires.toUTCString():"",i.path?"; path="+i.path:"",i.domain?"; domain="+i.domain:"",i.secure?"; secure":""].join("")}for(var l=e?void 0:{},m=document.cookie?document.cookie.split("; "):[],n=0,o=m.length;o>n;n++){var p=m[n].split("="),q=c(p.shift()),r=p.join("=");if(e&&e===q){l=f(r,g);break}e||void 0===(r=f(r))||(l[q]=r)}return l};h.defaults={},a.removeCookie=function(b,c){return void 0===a.cookie(b)?!1:(a.cookie(b,"",a.extend({},c,{expires:-1})),!a.cookie(b))}});
/*close cookies js*/
jQuery(document).ready(function() {
    FunctionContinouReading();
});
function FunctionContinouReading(){
        var token1 = $.cookie("token");
        if($.cookie("token") == "null" || typeof token1 === 'undefined')
        {
         //showlogin();
         jQuery("#login").show();
         jQuery("#Bst").show();
        }
        else {
          validatCoin(0);
          jQuery("#Bst").show();
        }
}
function showlogin()
{
  var postForm1 = jQuery('#post-form1');
  postForm1.on( 'submit', function( e ) {
      e.preventDefault();
      var email= $('#email1').val();
      var password= $('#password').val();
      var domain= $('#domain').val();
      var user_type= $('#user_type1').val();
      var wordpress_min_price= $('#minprice').val();
      var wordpress_max_price= $('#maxprice').val();
      var wordpress_fixed_coins= $('#fixedprice').val();
      var wordpress_post_id= $('#postid').val();
      var wordpress_title= $('#posttitle').val();
      var wordpress_post_url=$('#post_url1').val();
      var wordpress_article_type=$('#article_type1').val();
      var cpd_id = $('#cpd_id').val();
      var publish_date=$('#publish_date1').val();
      var server_details=$('#server_details').val();
      var wpmode=$('#wpmodes').val();
      var regEx = /\S+@\S+\.\S+/;
      var count = 0;
      /*error code client side*/
      jQuery(".error").remove();
      if(email == "" || email.length < 1 ){
       jQuery('#email1').before('<span class="error">This field is required</span>'); 
        count = count +1;
      }else if(!regEx.test(email)){
        count = count + 1;
         jQuery('#email1').before('<span class="error">Invalid Email </span>');
      }
      if(password == "" || password.length < 1){
        count = count + 1;
        jQuery('#password').before('<span class="error">This field is required</span>');
      }
      if(count == 0){
         /*close code client side*/
       jQuery.ajax({
            type: 'POST',
            url: login_signin_object.ajax_url,
            data: {
            'data':{email:email,password:password,domain:domain,user_type:user_type,wordpress_min_price:wordpress_min_price,wordpress_max_price:wordpress_max_price,
            wordpress_fixed_coins:wordpress_fixed_coins,wordpress_post_id:wordpress_post_id,wordpress_title:wordpress_title,wordpress_post_url:wordpress_post_url,wordpress_article_type:wordpress_article_type,
            cpd_id:cpd_id,publish_date:publish_date,server_details:server_details,wpmode:wpmode},
            action: 'login_curl_responce'
            },
             success: function(data) {
              var data1= JSON.parse(data);
              var token=data1.payload.token;
              var firstname=data1.payload.first_name;
              var balance_coins= data1.payload.balance_coins;
              var baseurl = jQuery(location).attr('hostname'); 
              jQuery.cookie("token", token, { expires : 10, path : '/' });
              jQuery.cookie("firstname", firstname, { expires : 10, path : '/' });           
              if(data1.status=="success")
              {
                jQuery("#login").hide();
                validatCoin(0);
                location.reload();
                
              }else
              {
                jQuery("#results").html("<p style='color:red;'>"+data1.message+"</p>");
              }
          },
        });
      }
    });      
}

function getcoin()
{
  var token= jQuery.cookie("token");   
  var wpmode=$('#wpmodes').val();
  var wordpress_fixed_coins= $('#fixedprice').val();  
  jQuery.ajax({
            type: 'POST',
            url: getcoin_signin_object.ajax_url,
            data: {
            'token':token,
            action: 'getcoin_curl_responce'
            },
             success: function(data) {
               var data1= JSON.parse(data);
               var balance_coins=data1.payload.coins;
               if(balance_coins >= wordpress_fixed_coins)
               {
                jQuery("#readmore").show();
                jQuery("#byecoins").hide();
                jQuery("#blance_coin").html("<div class='coinvalue'>"+balance_coins+'</div>'+'<br>COIN BALANCE');
              }else
              {
                jQuery("#readmore").hide();
                jQuery("#byecoins").show();
                jQuery("#buy_coin").html("<div class='coinvalue'>"+balance_coins+'</div>'+'<br>COIN BALANCE');
              }
               
          },
        });
}

function validatCoin(status)
{   
      var token= jQuery.cookie("token");
      var cpd_id = jQuery('#cpd_id12').val();
      var article_type=jQuery('#article_type123').val();
      var publish_date=jQuery('#publish_date').val();
      var title=  jQuery('#posttitle12').val();
      var post_id= jQuery('#postid12').val();
      var post_url=jQuery('#post_url12').val();
      var max_price=  jQuery('#maxprice12').val();
      var min_price= jQuery('#minprice12').val();
      var fixed_coins= jQuery('#fixedprice12').val();
      var purchase=status;
      var wpmode= jQuery('#wpmodes123').val();
      $.ajax({
            type: 'POST',
            url: articles_signin_object.ajax_url,
            data: {
            'token1':token,
            'data_articles':{cpd_id:cpd_id,article_type:article_type,publish_date:publish_date,title:title,post_id:post_id,post_url:post_url,
            min_price:min_price,max_price:max_price,fixed_coins:fixed_coins,purchase:purchase,wpmode:wpmode},
            action: 'articles_curl_responce'
            },
             success: function(data) {
              var data1= JSON.parse(data);
               var is_purchased=data1.payload.is_purchased;
                if(is_purchased)
                {
                  showFullContent(is_purchased);
                  
                }else
                {
                  getcoin();                 
                }  
            
          },
        });
}

function showFullContent(p_status)
{
var post_id= jQuery('#postid12').val();
      if(p_status) 
      {
                // Hit ajex
                jQuery.ajax({
                url: post_object.ajax_url,
                method: 'POST',
                data: {
                'post_id1':  post_id,
                action: 'post_curl_responce'
                },
                beforeSend: function(){
          jQuery("#Bst").show();
          },
          complete: function(){
          jQuery("#Bst").hide();
          },
                success: function( data ) {
                 jQuery("#readmore").hide();
                 jQuery("#wordpay_cId").html(data);
                },
                error: function(data) {  
               /*var message=data.responseJSON.message;*/
               jQuery("#resulted").html('<p style="color:red;">'+data+'<p>');
            },
  });
      } 
}

function logoutcokes()
{
  var pageURL = '/';
  jQuery.cookie("token", null, { path: pageURL });
  jQuery.cookie("firstname", null, { path: pageURL });
  if(!!jQuery.cookie("token")!="")
  {
    jQuery("#readmore").hide();
    jQuery("#byecoins").hide();
    jQuery("#Bst").show();
    jQuery("#login").show();
    location.reload();
  }
}