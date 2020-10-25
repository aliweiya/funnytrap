"use strict";
const puppeteer = require('puppeteer');

(async () => {
  var args = process.argv.slice(2);
  process.on('unhandledRejection', up => { throw up })
  var h = parseInt(args[3]);
  var height = 1080;
  if (h > 0) {
    height = h;
  }
  var argarr = ['--no-sandbox', '--disable-setuid-sandbox'];
  if(args[4] !== undefined && args[4] !== 'null')
  {
      argarr.push("--proxy-server=" + args[4]);
  }
  if(args[5] != 'default')
  {
      argarr.push("--user-agent=" + args[5]);
  }
  if(args[6] != 'default')
  {
      var cookies = args[6].split(';').reduce((cookieObject, cookieString) => {
   		let splitCookie = cookieString.split('=')
   		try {
   		  cookieObject[splitCookie[0].trim()] = decodeURIComponent(splitCookie[1])
   		} catch (error) {
   			cookieObject[splitCookie[0].trim()] = splitCookie[1]
   		}
   		return cookieObject
   	  }, []);
      await page.setCookie(cookies);
  }
  if(args[7] != 'default')
  {
      var xres = args[7].split(":");
      if(xres[1] != undefined)
      {
          var user = xres[0];
          var pass = xres[1];
          const auth = new Buffer(`${user}:${pass}`).toString('base64');
          await page.setExtraHTTPHeaders({
              'Authorization': `Basic ${auth}`                    
          });
      }
  }
  const browser = await puppeteer.launch({args: argarr});
  const page = await browser.newPage();
  page.setViewport({ width: parseInt(args[2]), height: height });
  await page.goto(args[0], {waitUntil: 'networkidle0'});
  await page.evaluate(() => window.scrollTo(0, Number.MAX_SAFE_INTEGER));
  await page.waitFor(5000);
  var fP = false;
  if (h == 0) {
	  fP = true;
  }
  await page.screenshot({path: args[1], fullPage: fP});

  await browser.close();
})();

