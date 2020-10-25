"use strict"; 
var { registerBlockType } = wp.blocks;
var gcel = wp.element.createElement;

registerBlockType( 'youtubomatic-youtube-post-generator/youtubomatic-playlist', {
    title: 'Youtubomatic Playlist Embed',
    icon: 'video-alt2',
    category: 'embed',
    attributes: {
        id : {
            default: '',
            type:   'string',
        }
    },
    keywords: ['embed', 'playlist', 'youtubomatic'],
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
                'Youtubomatic Playlist Embed ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to embed a YouTube playlist.'
                    )
                )
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Playlist ID: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Input the ID of the YouTube playlist to be embedded.'
                )
            ),
			gcel(
				'input',
				{ type:'text',placeholder:'Input the playlist ID', value: id, onChange: updateMessage, className: 'coderevolution_gutenberg_input' }
			)
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );