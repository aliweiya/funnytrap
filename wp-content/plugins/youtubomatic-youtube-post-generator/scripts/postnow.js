"use strict";
function youtubomatic_post_now(postId)
{
    if (confirm("Are you sure you want to submit this post now?") == true) {
        document.getElementById('youtubomatic_submit_post').setAttribute('disabled','disabled');
        document.getElementById("youtubomatic_span").innerHTML = 'Submitting... (please do not close or refresh this page) ';
        var data = {
             action: 'youtubomatic_post_now',
             id: postId
        };
        jQuery.post(ajaxurl, data, function(response) {
            document.getElementById('youtubomatic_submit_post').removeAttribute('disabled');
            document.getElementById("youtubomatic_span").innerHTML = 'Done! ';
        });
    } else {
        return;
    }
}