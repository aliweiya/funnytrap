"use strict";
jQuery( document ).ready(function() {
    jQuery('#echo_container').children().mouseover(function(e){
        jQuery(".echo_hova").removeClass("echo_hova");     
        jQuery(e.target).addClass("echo_hova");
      return false;
    }).mouseout(function(e) {
        jQuery(this).removeClass("echo_hova");
    });
});
var mastermind = document.getElementById('echo_container');
if(mastermind != null)
{
    document.getElementById('echo_container').onclick = function(event) {
        if (event===undefined) event = window.event;
        var target = 'target' in event? event.target : event.srcElement;
        var a = document.getElementById("echo_crawl_type");
        var val = a.options[a.selectedIndex].value;
        if(val == 'class')
        {
            var path = getClassTo(target);
            var message = 'Element CLASS is: ' + path;
        }
        else 
        {
            if(val == 'id')
            {
                var path = getIdTo(target);
                var message = 'Element ID is: ' + path;
            }
            else
            {
                if(val == 'xpath')
                {
                    var path = getPathTo(target);
                    var message = 'Element XPATH is: ' + path;
                }
                else
                {
                    var path = getPathTo(target);
                    var message = '[?]Element XPATH is: ' + path;
                }
            }
        }
        alert(message);
        event.preventDefault();    
    }
}
function getPathTo(element) {
    if (element.id!=='')
    {
        if(element.id != 'echo_container')
        {
            return "//*[@id='"+element.id+"']";
        }
        else
        {
            return '//body/*';
        }
    }
    var res = element.className;
    if (res !=='' && res != 'echo_hova')
    {
        res = res.replace('echo_hova ', "");
        res = res.replace(' echo_hova ', " ");
        res = res.replace(' echo_hova', "");
        if(res !== '' && res != ' ')
        {
            res = jQuery.trim(res);
            return "//*[@class='"+res+"']";
        }
    }
    var itempropz = element.getAttribute("itemprop");
    if (itempropz!=='' && itempropz!==null)
    {
        return "//*[@itemprop='"+itempropz+"']";
    }
    if (element===document.body)
    {
        return '//body/*';
    }
    return getPathTo(element.parentNode);
}
function getIdTo(element) {
    if (element.id!=='')
    {
        if(element.id != 'echo_container')
        {
            return element.id;
        }
        else
        {
            return 'Id attribute not found for the clicked element. Please select another "Query Type" from the upper dropdown.';
        }
    }
    if (element===document.body)
    {
        return 'Id attribute not found for the clicked element. Please select another "Query Type" from the upper dropdown.';
    }
    return getIdTo(element.parentNode);
}
function getClassTo(element) {
    var res = element.className;
    if (res !=='' && res != 'echo_hova')
    {
        res = res.replace('echo_hova ', "");
        res = res.replace(' echo_hova ', " ");
        res = res.replace(' echo_hova', "");
        if(res !== '' && res != ' ')
        {
            res = jQuery.trim(res);
            return res;
        }
    }
    if (element===document.body)
    {
        return 'Class attribute not found for the clicked element. Please select another "Query Type" from the upper dropdown.';
    }
    return getClassTo(element.parentNode);
}