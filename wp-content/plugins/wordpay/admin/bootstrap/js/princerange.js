(function(jQuery) {
    jQuery(document).ready(function() {

        jQuery(document).ready(function() {

            jQuery("#title").keypress(function() {

                if ((jQuery("#title").val()).length > 50) {
                    alert('Max 50 words allowed');
                    return false;
                }

            });
        });

        //Require post title when adding/editing Project Summaries
        jQuery('body').on('submit.edit-post', '#post', function() {
            var title = jQuery("#title").val();
            if (title.length >= 50) {
                window.alert('Max 50 words allowed');

                // Hide the spinner
                jQuery('#major-publishing-actions .spinner').hide();

                // The buttons get "disabled" added to them on submit. Remove that class.
                jQuery('#major-publishing-actions').find(':button, :submit, a.submitdelete, #post-preview').removeClass('disabled');

                // Focus on the title field.
                jQuery("#title").focus();

                return false;
            }
            // If the title isn't set
            if (jQuery("#title").val().replace(/ /g, '').length === 0) {
                window.alert('A title is required.');
                jQuery(".spinner").removeClass("is-active");
                jQuery("#save-post").removeClass("disabled");
                jQuery("#post-preview").removeClass("disabled");
                jQuery("#publish").removeClass("disabled");
                jQuery("#title").focus();

                return false;
            }
        });
    });
}(jQuery));

jQuery("#post").submit(function() {
    var minval = parseFloat(jQuery("#minprice").val());
    var maxval = parseFloat(jQuery("#maxprice").val());
    var cashprice = parseFloat(jQuery("#cashprice").val());

    if (minval > maxval) {
        alert("Minimum price must be less than maximum price.");
        return false;
    } else if ((cashprice > maxval) || (cashprice < minval)) {
        alert("Fixed price must be less than maximum price and greater than minimum price.");
        return false;
    } else {
        return true;
    }
});
jQuery(document).ready(function() {

    jQuery("#minprice").keypress(function() {

        if ((jQuery("#minprice").val()).length >= 6) {
            alert('Max 6 digits allowed.');
            return false;
        }

    });
    jQuery("#maxprice").keypress(function() {

        if ((jQuery("#maxprice").val()).length >= 6) {
            alert('Max 6 digits allowed.');
            return false;
        }

    });
    jQuery("#cashprice").keypress(function() {

        if ((jQuery("#cashprice").val()).length >= 6) {
            alert('Max 6 digits allowed.');
            return false;
        }

    });
});