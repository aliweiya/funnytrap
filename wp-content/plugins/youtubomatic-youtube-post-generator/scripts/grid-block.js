"use strict"; 
var { registerBlockType } = wp.blocks;
var gcel = wp.element.createElement;

registerBlockType( 'youtubomatic-youtube-post-generator/youtubomatic-grid', {
    title: 'Youtubomatic Grid Embed',
    icon: 'video-alt2',
    category: 'embed',
    attributes: {
        direct_link : {
            default: '0',
            type:   'string',
        },
        max : {
            default: '9',
            type:   'string',
        },
        grids : {
            default: '3',
            type:   'string',
        },
        width : {
            default: '200',
            type:   'string',
        },
        height : {
            default: '200',
            type:   'string',
        },
        list_all : {
            default: '0',
            type:   'string',
        },
        titlelength : {
            default: '20',
            type:   'string',
        }
    },
    keywords: ['embed', 'grid', 'youtubomatic'],
    edit: (function( props ) {
		var direct_link = props.attributes.direct_link;
        var max = props.attributes.max;
        var grids = props.attributes.grids;
        var width = props.attributes.width;
        var height = props.attributes.height;
        var list_all = props.attributes.list_all;
        var titlelength = props.attributes.titlelength;
		function updateMessage( event ) {
            props.setAttributes( { direct_link: event.target.value} );
		}
        function updateMessage2( event ) {
            props.setAttributes( { max: event.target.value} );
		}
        function updateMessage3( event ) {
            props.setAttributes( { grids: event.target.value} );
		}
        function updateMessage4( event ) {
            props.setAttributes( { width: event.target.value} );
		}
        function updateMessage5( event ) {
            props.setAttributes( { height: event.target.value} );
		}
        function updateMessage6( event ) {
            props.setAttributes( { list_all: event.target.value} );
		}
        function updateMessage7( event ) {
            props.setAttributes( { titlelength: event.target.value} );
		}
		return gcel(
			'div', 
			{ className: 'coderevolution_gutenberg_div' },
            gcel(
				'h4',
				{ className: 'coderevolution_gutenberg_title' },
                'Youtubomatic Video Grid Embed ',
                gcel(
                    'div', 
                    {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                    ,
                    gcel(
                        'div', 
                        {className:'bws_hidden_help_text'},
                        'This block is used to embed YouTube videos in a grid.'
                    )
                )
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Direct Link to Video: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Do you want to directly link to the YouTube videos, or the posts from your blog.'
                )
            ),
            gcel(
				'select',
				{ value: direct_link, onChange: updateMessage, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 0},
                    'No'
                ),
                gcel(
                    'option',
                    { value: 1},
                    'Yes'
                )
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
                'Number of Grids: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Number of grids for the embed.'
                )
            ),
            gcel(
				'input',
				{ type:'number',min:1,placeholder:'Number of grids', value: grids, onChange: updateMessage3, className: 'coderevolution_gutenberg_input' }
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
				{ type:'number',min:1,placeholder:'Width of video', value: width, onChange: updateMessage4, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Video Height: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Height of the embedded video.'
                )
            ),
            gcel(
				'input',
				{ type:'number',min:1,placeholder:'Height of video', value: height, onChange: updateMessage5, className: 'coderevolution_gutenberg_input' }
			),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'List Only Own Posts: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'List Only Posts Generated By This Plugin.'
                )
            ),
            gcel(
				'select',
				{ value: list_all, onChange: updateMessage6, className: 'coderevolution_gutenberg_select' }, 
                gcel(
                    'option',
                    { value: 1},
                    'No'
                ),
                gcel(
                    'option',
                    { value: 0},
                    'Yes'
                )
            ),
            gcel(
				'br'
			),
            gcel(
				'label',
				{ className: 'coderevolution_gutenberg_label' },
                'Title Length: '
			),
            gcel(
                'div', 
                {className:'bws_help_box bws_help_box_right dashicons dashicons-editor-help'}
                ,
                gcel(
                    'div', 
                    {className:'bws_hidden_help_text'},
                    'Length of the embedded title.'
                )
            ),
            gcel(
				'input',
				{ type:'number',min:1,placeholder:'Title Length', value: titlelength, onChange: updateMessage7, className: 'coderevolution_gutenberg_input' }
			)
		);
    }),
    save: (function( props ) {
       return null;
    }),
} );