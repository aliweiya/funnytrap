"use strict";
function mainChanged()
    {
        if(jQuery('.input-checkbox').is(":checked"))
        {            
            jQuery(".hideMain").show();
        }
        else
        {
            jQuery(".hideMain").hide();
        }
        toggleCats();
    }
    window.onload = mainChanged;
    var unsaved = false;
    jQuery(document).ready(function () {
        jQuery(":input").change(function(){
            if (this.id != 'PreventChromeAutocomplete')
                unsaved = true;
        });
        function unloadPage(){ 
            if(unsaved){
                return "You have unsaved changes on this page. Do you want to leave this page and discard your changes or stay on this page?";
            }
        }
        window.onbeforeunload = unloadPage;
    });
    function toggleCats()
    {
        if(jQuery('#hideCats').is(":visible"))
        {            
            jQuery(".hideCats").hide();
        }
        else
        {
            jQuery(".hideCats").show();
        }
    }
    function uncheckAll()
    {
        jQuery("#PagesSelect option:selected").prop("selected", false);
    }