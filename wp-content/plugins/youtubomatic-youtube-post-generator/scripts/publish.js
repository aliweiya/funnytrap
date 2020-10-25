"use strict";
function careeromaticIsGutenbergActive() {
    return typeof wp !== 'undefined' && typeof wp.blocks !== 'undefined';
}
if(!careeromaticIsGutenbergActive())
{
    document.getElementById("publish").onclick = function() {
      var elem = document.getElementById("myBar");
      var elem2 = document.getElementById("notVisibleID");
      elem2.style.display = 'block'; 
      var width = 0;
      var id = setInterval(frame, 50);
      function frame() {
        if (width >= 100) {
          width = 0;
        } else {
          width++; 
          elem.style.width = width + '%'; 
        }
      }
    }
}