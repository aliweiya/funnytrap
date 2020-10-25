"use strict"; 
var { registerBlockType } = wp.blocks;
var gcel = wp.element.createElement;

registerBlockType( 'youtubomatic-youtube-post-generator/youtubomatic-video', {
    title: 'Youtubomatic Video Embed',
    icon: 'video-alt2',
    category: 'embed',
    attributes: {
        id : {
            default: '',
            type:   'string',
        }
    },
    keywords: ['embed', 'video', 'youtubomatic'],
    edit: (function( props ) {
		var id = props.attributes.id;
		function updateMessage( event ) {
            props.setAttributes( { id: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'Youtubomatic Video Embed ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to embed a YouTube video.'
                    )
                )
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Video ID: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Input the video ID to be embedded.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Input the video ID', value: id, onChange: updateMessage, className: 'coderevolution_gutenberg_input' }
			)
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );