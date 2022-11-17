// Regular Array
var random = new Array();
random[0] = "http://google.com";
random[1] = "http://yahoo.com";
random[2] = "http://bing.com";
random[3] = "http://cnn.com";

function randomlink() {
window.location = random[Math.floor(Math.random()*random.length)];
}