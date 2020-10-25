"use strict";
var page = require("webpage").create();

var system = require("system");
var args = system.args;
var fs = require("fs");
var timeout = 2000; // you can set default timeout

var path = args[1];
var url = args[2];
var imageName = args[3];
var w = parseInt(args[4]);
var h = parseInt(args[5]);
fs.changeWorkingDirectory("" + path);
var height = 1080;

if (isNaN(w)) {
    w = 1920; // you can set default width
}

if (h > 0) {
    height = h; // you can set default width
}

page.viewportSize = {
    width: w,
    height: height
};

page.open(url, function() {
	if (h == 0) {
		h = page.evaluate(function(){
			return document.body.scrollHeight;
		});
	}	

    page.viewportSize = {
        width: w,
        height: h
    };

    page.clipRect = {top: 0, left: 0, width: w, height: h};
    window.setTimeout(function () {
        page.render(imageName+".jpg");
        console.log('OK!');
        phantom.exit();
    }, timeout);

});

