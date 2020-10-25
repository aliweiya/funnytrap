
    class WPH_Class {
            
               
            replace_text_add_row   () {
                
                var html    =   jQuery('#replacer_read_root').html();
                
                jQuery( html ).insertBefore( '#replacer_insert_root' );    
                
            }
            
            replace_text_remove_row   ( element ) {
                                
                jQuery( element ).remove();    
                
            }
            
            
            options_field_changed  ( field_id ) {
                
                switch (field_id)
                    {
                        case 'nginx_generate_simple_rewrite'    :
                                                                    var field_value =   jQuery( '#' + field_id  + ' option:selected').val();
                                                                    if  ( field_value == 'yes' )
                                                                        jQuery('#allow_every_site_to_change_options').val('no');
                                                                    break;
                        
                        case 'allow_every_site_to_change_options'    :
                                                                    var field_value =   jQuery( '#' + field_id  + ' option:selected').val();
                                                                    if  ( field_value == 'yes' )
                                                                        jQuery('#nginx_generate_simple_rewrite').val('no');
                                                                    break;
                        
                        
                    }
                
            }
            
            
            showAdvanced( element )
                {
                    jQuery( element ).closest('.wph_input').find('tr.advanced').show('fast');
                    jQuery( element ).closest('.advanced_notice').slideUp('fast', function() { jQuery(this).hide()  });
                    
                    
                }
                
            randomWord( element, extension ) 
                {
                    var length  =   7;
                    var consonants = 'bcdfghjlmnpqrstv',
                        vowels = 'aeiou',
                        rand = function(limit) {
                            return Math.floor(Math.random()*limit);
                        },
                        i, word='', length = parseInt(length,10),
                        consonants = consonants.split(''),
                        vowels = vowels.split('');
                        
                    for (i=0;i<length/2;i++) 
                        {
                            var randConsonant = consonants[rand(consonants.length)],
                                randVowel = vowels[rand(vowels.length)];
                            word += randConsonant;
                            word += i*2<length-1 ? randVowel : '';
                        }
                    
                    if ( extension != '' )
                        word    =   word.concat( '.' + extension );
                    
                    jQuery( element ).closest('.wph_input').find('.entry input.text').val( word );                    
                }
                
            
            clear ( element )
                {
                    jQuery( element ).closest('.wph_input').find('.entry input.text').val( '' );    
                }
            
            
    }
    
    var WPH = new WPH_Class();
    
    
    jQuery( document ).ready( function() {
        
        jQuery('.tips').tipsy({fade: false, gravity: 's', html: true });    
    })
