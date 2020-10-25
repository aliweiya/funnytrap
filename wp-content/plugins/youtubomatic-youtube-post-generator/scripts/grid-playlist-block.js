"use strict"; 
var { registerBlockType } = wp.blocks;
var gcel = wp.element.createElement;

registerBlockType( 'youtubomatic-youtube-post-generator/youtubomatic-grid-playlist', {
    title: 'Youtubomatic Grid Playlist Embed',
    icon: 'video-alt2',
    category: 'embed',
    attributes: {
        id : {
            default: '',
            type:   'string',
        },
        max : {
            default: '9',
            type:   'string',
        },
        width : {
            default: '200',
            type:   'string',
        },
        background_color : {
            default: 'eeeeee',
            type:   'string',
        }
    },
    keywords: ['embed', 'grid', 'youtubomatic'],
    edit: (function( props ) {
		var id = props.attributes.id;
        var max = props.attributes.max;
        var width = props.attributes.width;
        var background_color = props.attributes.background_color;
		function updateMessage( event ) {
            props.setAttributes( { id: event.target.value} );
		}
        function updateMessage2( event ) {
            props.setAttributes( { max: event.target.value} );
		}
        function updateMessage3( event ) {
            props.setAttributes( { width: event.target.value} );
		}
        function updateMessage4( event ) {
            props.setAttributes( { background_color: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'Youtubomatic Playlist Grid Embed ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to embed YouTube playlists in a grid.'
                    )
                )
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'YouTube Playlist ID: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Input the YouTube playlist ID you wish to embed in the post.'
                )
            ),
            gcel(
				'input',
				{ type:'text',placeholder:'YouTube playlist ID', value: id, onChange: updateMessage, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Maximum Number of Videos: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Maximum number of videos to include.'
                )
            ),
            gcel(
				'input',
				{ type:'number',min:1,placeholder:'Maximum number of videos', value: max, onChange: updateMessage2, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Video Width: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Width of the embedded video.'
                )
            ),
            gcel(
				'input',
				{ type:'number',min:1,placeholder:'Width of video', value: width, onChange: updateMessage3, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Background Color: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Select the background color of the embed.'
                )
            ),
            gcel(
				'input',
				{ type:'text',placeholder:'Background color', value: background_color, onChange: updateMessage4, className: 'coderevolution_gutenberg_input' }
			)
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );