jQuery(document).ready(function (){
   var cpdid = jQuery("#cpd_id").val();
   var wpmode = jQuery("#wpmode1").val();
  jQuery.ajax({
        type: 'POST',
        url: revenue_object.ajax_url,
        data: {
         'wpmode':wpmode,   
        'cpdid':cpdid,
        action: 'revenue_responce'
        },
        success: function( data ) {
         var data1= JSON.parse(data);
         if(data1.status == 'failure')
         {
             jQuery("#fontpublic").html('<p style="color:red;font-size: 21px;font-weight:900;text-align: center;">'+data1.message+'<p>');
         }else{
         jQuery(data1).each(function (index, item) {
                    response=item.payload;
                     jQuery.each(response, function(key,value) {
                        var test= '<tr><td>' +'<input type="checkbox" value="">'+
                        '</td><td>' + value['publish_date'] +
                        '</td><td>' + value['title']+
                        '</td><td>' + value['visitors']+
                        '</td><td>' + value['purchased']+
                        '</td><td>' + '2'+
                        '</td><td>' + value['min_price']+
                        '</td><td>' + value['max_price']+
                        '</td><td>' + value['fixed_coins']+
                        '</td><td>' + value['total_revenue']+ 
                        '</td></tr>';
                        jQuery("#myTable").append(test);

                     }); 
                      jQuery('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:10});
                });
            }
        },
        error: function(data) {  
               jQuery("#fontpublic").html('<p style="color:red;font-size: 21px;font-weight:900;">'+data.responseJSON.message+'<p>');
            },
    });
});

jQuery.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 7,
            showPrevNext: false,
            hidePageNumbers: false
        },
        settings = jQuery.extend(defaults, opts);
    
    var listElement = $this;
    var perPage = settings.perPage; 
    var children = listElement.children();
    var pager = jQuery('.pager');
    
    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }
    
    if (typeof settings.pagerSelector!="undefined") {
        pager = jQuery(settings.pagerSelector);
    }
    
    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    pager.data("curr",0);
    
    if (settings.showPrevNext){
        jQuery('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }
    
    var curr = 0;
    while(numPages > curr && (settings.hidePageNumbers==false)){
        jQuery('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }
    
    if (settings.showPrevNext){
        jQuery('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }
    
    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
      pager.children().eq(1).addClass("active");
    
    children.hide();
    children.slice(0, perPage).show();
    
    pager.find('li .page_link').click(function(){
        var clickedPage = jQuery(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });
    
    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }
     
    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }
    
    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;
        
        children.css('display','none').slice(startAt, endOn).show();
        
        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }
        
        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }
        
        pager.data("curr",page);
        pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");
    
    }
};