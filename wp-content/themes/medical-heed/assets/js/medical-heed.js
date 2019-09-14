jQuery(document).ready(function($){

    /**
      * Function for repeater field
     */
    function medical_heed_refresh_repeater_values(){
        $(".medical-heed-repeater-field-control-wrap").each(function(){
            
            var values = []; 
            var $this = $(this);
            
            $this.find(".medical-heed-repeater-field-control").each(function(){
            var valueToPush = {};   

            $(this).find('[data-name]').each(function(){
                var dataName = $(this).attr('data-name');
                var dataValue = $(this).val();
                valueToPush[dataName] = dataValue;
            });

            values.push(valueToPush);
            });

            $this.next('.medical-heed-repeater-collector').val(JSON.stringify(values)).trigger('change');
        });
    }

    $('#customize-theme-controls').on('click','.medical-heed-repeater-field-title',function(){
        $(this).next().slideToggle();
        $(this).closest('.medical-heed-repeater-field-control').toggleClass('expanded');
    });

    $('#customize-theme-controls').on('click', '.medical-heed-repeater-field-close', function(){
        $(this).closest('.medical-heed-repeater-fields').slideUp();;
        $(this).closest('.medical-heed-repeater-field-control').toggleClass('expanded');
    });

    $("body").on("click",'.medical-heed-repeater-add-control-field', function(){

        var $this = $(this).parent();
        if(typeof $this != 'undefined') {

            var field = $this.find(".medical-heed-repeater-field-control:first").clone();
            if(typeof field != 'undefined'){
                
                field.find("input[type='text'][data-name]").each(function(){
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });

                field.find("textarea[data-name]").each(function(){
                    var defaultValue = $(this).attr('data-default');
                    $(this).val(defaultValue);
                });
                
                field.find(".medical-heed-repeater-icon-list").each(function(){
                    var defaultValue = $(this).next('input[data-name]').attr('data-default');
                    $(this).next('input[data-name]').val(defaultValue);
                    $(this).prev('.medical-heed-repeater-selected-icon').children('i').attr('class','').addClass(defaultValue);
                    
                    $(this).find('li').each(function(){
                        var icon_class = $(this).find('i').attr('class');
                        if(defaultValue == icon_class ){
                            $(this).addClass('icon-active');
                        }else{
                            $(this).removeClass('icon-active');
                        }
                    });
                });

                field.find(".attachment-media-view").each(function(){
                    var defaultValue = $(this).find('input[data-name]').attr('data-default');
                    $(this).find('input[data-name]').val(defaultValue);
                    if(defaultValue){
                        $(this).find(".thumbnail-image").html('<img src="'+defaultValue+'"/>').prev('.placeholder').addClass('hidden');
                    }else{
                        $(this).find(".thumbnail-image").html('').prev('.placeholder').removeClass('hidden');   
                    }
                });

                field.find('.medical-heed-repeater-fields').show();

                $this.find('.medical-heed-repeater-field-control-wrap').append(field);

                field.addClass('expanded').find('.medical-heed-repeater-fields').show(); 
                $('.accordion-section-content').animate({ scrollTop: $this.height() }, 1000);
                medical_heed_refresh_repeater_values();
            }

        }
        return false;
     });
    
    $("#customize-theme-controls").on("click", ".medical-heed-repeater-field-remove",function(){
        if( typeof  $(this).parent() != 'undefined'){
            $(this).closest('.medical-heed-repeater-field-control').slideUp('normal', function(){
                $(this).remove();
                medical_heed_refresh_repeater_values();
            });
        }
        return false;
    });

    $("#customize-theme-controls").on('keyup change', '[data-name]',function(){
        medical_heed_refresh_repeater_values();
        return false;
    });

    // Set all variables to be used in scope
    var frame;
    // ADD IMAGE LINK
    $('.customize-control-repeater').on( 'click', '.medical-heed-upload-button', function( event ){
        event.preventDefault();
        var imgContainer = $(this).closest('.medical-heed-fields-wrap').find( '.thumbnail-image'),
        placeholder = $(this).closest('.medical-heed-fields-wrap').find( '.placeholder'),
        imgIdInput = $(this).siblings('.upload-id');

        // Create a new media frame
        frame = wp.media({
            title: 'Select or Upload Image',
            button: {
            text: 'Use Image'
            },
            multiple: false  // Set to true to allow multiple files to be selected
        });

        // When an image is selected in the media frame...
        frame.on( 'select', function() {
            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();
            // Send the attachment URL to our custom image input field.
            imgContainer.html( '<img src="'+attachment.url+'" style="max-width:100%;"/>' );
            placeholder.addClass('hidden');
            // Send the attachment id to our hidden input
            imgIdInput.val( attachment.url ).trigger('change');
        });

        // Finally, open the modal on click
        frame.open();
    });


    // DELETE IMAGE LINK
    $('.customize-control-repeater').on( 'click', '.medical-heed-delete-button', function( event ){

        event.preventDefault();
        var imgContainer = $(this).closest('.medical-heed-fields-wrap').find( '.thumbnail-image'),
        placeholder = $(this).closest('.medical-heed-fields-wrap').find( '.placeholder'),
        imgIdInput = $(this).siblings('.upload-id');

        // Clear out the preview image
        imgContainer.find('img').remove();
        placeholder.removeClass('hidden');

        // Delete the image id from the hidden input
        imgIdInput.val( '' ).trigger('change');

    });

     /*Drag and drop to change order*/
    $(".medical-heed-repeater-field-control-wrap").sortable({
        orientation: "vertical",
        update: function( event, ui ) {
            medical_heed_refresh_repeater_values();
        }
    });

    $('body').on('click', '.medical-heed-repeater-icon-list li', function(){
        var icon_class = $(this).find('i').attr('class');
        $(this).addClass('icon-active').siblings().removeClass('icon-active');
        $(this).parent('.medical-heed-repeater-icon-list').prev('.medical-heed-repeater-selected-icon').children('i').attr('class','').addClass(icon_class);
        $(this).parent('.medical-heed-repeater-icon-list').next('input').val(icon_class).trigger('change');
        medical_heed_refresh_repeater_values();
    });

    $('body').on('click', '.medical-heed-repeater-selected-icon', function(){
        $(this).next().slideToggle();
    });

     /**
    * Select Multiple Category
    */
    $( '.customize-control-checkbox-multiple input[type="checkbox"]' ).on( 'change', function() {

            var checkbox_values = $( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
                function() {
                    return $( this ).val();
                }
            ).get().join( ',' );

            $( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
        
        }
    );
 /*
 * Switch Enable/Disable Control.
*/
    $('body').on('click', '.onoffswitch', function(){
        var $this = $(this);
        if($this.hasClass('switch-on')){
            $(this).removeClass('switch-on');
            $this.next('input').val('disable').trigger('change')
        }else{
            $(this).addClass('switch-on');
            $this.next('input').val('enable').trigger('change')
        }
    }); 

});

