var http = require('http');//require the http module within Node.js
var url = require('url');

function start(route, handle){
    function onRequest(request,response){
        var pathname = url.parse(request.url).pathname;
        console.log("Request for " + pathname + " received.");
        route(handle, pathname, response);
    }
http.createServer(onRequest).listen(3000);
console.log("Server has Started");
}

exports.start = start;