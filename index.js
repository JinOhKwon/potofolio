var http = require('http');
var fs = require('fs');
var url = require('url');

/**
 * 서버 생성
 */
http.createServer((request, response) => {
    // URL 뒤에 있는 디렉토리/파일이름 파싱
    var pathname = url.parse(request.url).pathname;

    console.log("Request for " + pathname + " received.");

    // 파일 이름이 비어있다면 index.html 로 설정
    if (pathname == "/") {
       pathname = "/index.html";
    }

    // 파일을 읽기
    fs.readFile(pathname.substr(1), (err, data) => {
        if (err) {
            console.log(err);
            // 페이지를 찾을 수 없음
            // HTTP Status: 404 : NOT FOUND
            // Content Type: text/plain
            response.writeHead(404, {
                'Content-Type': 'text/html'
            });
            response.end();
        } else {
            // 페이지를 찾음	  
            // HTTP Status: 200 : OK
            // Content Type: text/plain
            var dotoffset = pathname.lastIndexOf('.');
            var mimetype = dotoffset == -1
                            ? 'text/plain'
                            : {
                                '.html' : 'text/html',
                                '.ico' : 'image/x-icon',
                                '.png' : 'image/png',
                                '.jpg' : 'image/jpeg',
                                '.jpeg' : 'image/jpeg',
                                '.gif' : 'image/gif',
                                '.tiff' : 'image/tiff',
                                '.ttf' : 'application/x-font-ttf',
                                '.woff' : 'application/x-font-woff',
                                '.woff2' : 'application/x-font-woff',
                                '.css' : 'text/css',
                                '.js' : 'text/javascript'
                                }[ pathname.substr(dotoffset) ];
                                
            response.setHeader('Content-type' , mimetype);
        }
        // responseBody 전송
        response.end(data);
    });
}).listen(3000);

console.log('Server running at http://127.0.0.1:3000/');