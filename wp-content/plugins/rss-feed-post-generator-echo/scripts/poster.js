"use strict";
jQuery(document).ready(function(){
					jQuery('span.wpecho-delete').on('click', function(){
						var confirm_delete = confirm('Delete This Rule?');
						if (confirm_delete) {
							jQuery(this).parent().parent().remove();
							jQuery('#myForm').submit();						
						}
					});
				});
                var unsaved = false;
                jQuery(document).ready(function () {
                    jQuery(":input").change(function(){
                        var classes = this.className;
                        var classes = this.className.split(' ');
                        var found = jQuery.inArray('actions', classes) > -1;
                        if(this.id != 'select-shortcode' && this.id != 'PreventChromeAutocomplete' && !found)
                            unsaved = true;
                    });
                    function unloadPage(){ 
                        if(unsaved){
                            return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
                        }
                    }
                    window.onbeforeunload = unloadPage;
                });
                jQuery("#myForm").on('submit', function () {
                    jQuery(this).on('submit', function() {
                        return false;
                    });
                    var this_master = jQuery(this);
jQuery('button[type=submit], input[type=submit]').prop('disabled',true);
                    this_master.find('input[type="checkbox"]').each( function () {
                        var checkbox_this = jQuery(this);

                        if (checkbox_this.attr("id") !== "exclusion")
                        {
                            if( checkbox_this.is(":checked") == true ) {
                                checkbox_this.attr('value','1');
                            } else {
                                checkbox_this.prop('checked',true);  
                                checkbox_this.attr('value','0');
                            }
                        }
                    });
if (typeof mycustomsettings.max_input_vars !== 'undefined' && jQuery('input, textarea, select, button').length >= mycustomsettings.max_input_vars) {
        this_master.append("<span style='color:red;'>Saving settings, please wait...</span>");
        var coderevolution_max_input_var_data = this_master.serialize();
        this_master.find("table").remove();
        this_master.append("<input type='hidden' class='coderevolution_max_input_var_data' name='coderevolution_max_input_var_data'/>");
        this_master.find("input.coderevolution_max_input_var_data").val(coderevolution_max_input_var_data);
    }
                })