"use strict"; 
( function( wp ) {
	var registerPlugin = wp.plugins.registerPlugin;
	var PluginSidebar = wp.editPost.PluginSidebar;
	var el = wp.element.createElement;
    
	registerPlugin( 'youtubomatic-sidebar', {
		render: function() {
            function updateMessage( ) {
                var postId = wp.data.select("core/editor").getCurrentPostId();
                if (confirm("Are you sure you want to submit this post now?") == true) {
                    document.getElementById('youtubomatic_submit_post').setAttribute('disabled','disabled');
                    document.getElementById("youtubomatic_span").innerHTML = 'Posting status: Submitting... (please do not close or refresh this page) ';
                    var data = {
                         action: 'youtubomatic_post_now',
                         id: postId
                    };
                    jQuery.post(ajaxurl, data, function(response) {
                        document.getElementById('youtubomatic_submit_post').removeAttribute('disabled');
                        document.getElementById("youtubomatic_span").innerHTML = 'Posting status: Done! ';
                    });
                } else {
                    return;
                }
            }
			return el( PluginSidebar,
				{
					name: 'youtubomatic-sidebar',
					icon: 'video-alt2',
					title: 'Youtubomatic Video Post Publisher',
				},
				el(
                    'div', 
                    { className: 'coderevolution_gutenberg_div' },
                    el(
                        'h4',
                        { className: 'coderevolution_gutenberg_title' },
                        'Publish Video from Post to YouTube '
                    ),
                    el(
                        'input',
                        { type:'button', id:'youtubomatic_submit_post', value:'Post Video To YouTube Now!', onClick: updateMessage, className: 'coderevolution_gutenberg_button button button-primary' }
                    ),
                    el(
                    'br'
                    ),
                    el(
                    'br'
                    ),
                    el(
                        'div', 
                        {id:'youtubomatic_span'},
                        'Posting status: idle'
                    )
				)
			);
		},
	} );
} )( window.wp );