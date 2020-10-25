(function($) {

  'use strict';

  $(document).ready(function() {

    $('a[data-autolink-id]').mousedown(function() {

      //save the click with an ajax request
      trackClick($(this));

    });

  });

  //track the link with an ajax request
  function trackClick(callerElement) {

    //get autolink data
    var autolinkId = callerElement.attr('data-autolink-id');
    var postId = $('#daam-post-id').val();

    //prepare the ajax request
    var data = {
      'action': 'daam_track_click',
      'security': window.daamNonce,
      'autolink_id': autolinkId,
      'post_id': postId,
    };

    //send the ajax request
    $.post(window.daamAjaxUrl, data, function() {
    });

  }

}(window.jQuery));