"use strict";
jQuery(document).ready(function(){
    jQuery(".youtubomatic_slidingDiv").hide();
    jQuery(".youtubomatic_show_hide").show();
    jQuery(".youtubomatic_show_hide").on('click', function(){
        jQuery(".youtubomatic_slidingDiv").slideToggle();
        jQuery("#youtubomatic_video").hide();
    });
});