class HttpStatusCodes {
    // [Informational 1xx]
    static HTTP_CONTINUE = 100;
    static HTTP_SWITCHING_PROTOCOLS = 101;
  
    // [Successful 2xx]
    static HTTP_OK = 200;
    static HTTP_CREATED = 201;
    static HTTP_ACCEPTED = 202;
    static HTTP_NONAUTHORITATIVE_INFORMATION = 203;
    static HTTP_NO_CONTENT = 204;
    static HTTP_RESET_CONTENT = 205;
    static HTTP_PARTIAL_CONTENT = 206;
  
    // [Redirection 3xx]
    static HTTP_MULTIPLE_CHOICES = 300;
    static HTTP_MOVED_PERMANENTLY = 301;
    static HTTP_FOUND = 302;
    static HTTP_SEE_OTHER = 303;
    static HTTP_NOT_MODIFIED = 304;
    static HTTP_USE_PROXY = 305;
    static HTTP_UNUSED = 306;
    static HTTP_TEMPORARY_REDIRECT = 307;
  
    // [Client Error 4xx]
    static errorCodesBeginAt = 400;
    static HTTP_BAD_REQUEST = 400;
    static HTTP_UNAUTHORIZED = 401;
    static HTTP_PAYMENT_REQUIRED = 402;
    static HTTP_FORBIDDEN = 403;
    static HTTP_NOT_FOUND = 404;
    static HTTP_METHOD_NOT_ALLOWED = 405;
    static HTTP_NOT_ACCEPTABLE = 406;
    static HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    static HTTP_REQUEST_TIMEOUT = 408;
    static HTTP_CONFLICT = 409;
    static HTTP_GONE = 410;
    static HTTP_LENGTH_REQUIRED = 411;
    static HTTP_PRECONDITION_FAILED = 412;
    static HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    static HTTP_REQUEST_URI_TOO_LONG = 414;
    static HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    static HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    static HTTP_EXPECTATION_FAILED = 417;
  
    // [Server Error 5xx]
    static HTTP_INTERNAL_SERVER_ERROR = 500;
    static HTTP_NOT_IMPLEMENTED = 501;
    static HTTP_BAD_GATEWAY = 502;
    static HTTP_SERVICE_UNAVAILABLE = 503;
    static HTTP_GATEWAY_TIMEOUT = 504;
    static HTTP_VERSION_NOT_SUPPORTED = 505;
  
    static messages = {
      // [Informational 1xx]
      100: '100 Continue',
      101: '101 Switching Protocols',
      // [Successful 2xx]
      200: '200 OK',
      201: '201 Created',
      202: '202 Accepted',
      203: '203 Non-Authoritative Information',
      204: '204 No Content',
      205: '205 Reset Content',
      206: '206 Partial Content',
      // [Redirection 3xx]
      300: '300 Multiple Choices',
      301: '301 Moved Permanently',
      302: '302 Found',
      303: '303 See Other',
      304: '304 Not Modified',
      305: '305 Use Proxy',
      306: '306 (Unused)',
      307: '307 Temporary Redirect',
      // [Client Error 4xx]
      400: '400 Bad Request',
      401: '401 Unauthorized',
      402: '402 Payment Required',
      403: '403 Forbidden',
      404: '404 Not Found',
      405: '405 Method Not Allowed',
      406: '406 Not Acceptable',
      407: '407 Proxy Authentication Required',
      408: '408 Request Timeout',
      409: '409 Conflict',
      410: '410 Gone',
      411: '411 Length Required',
      412: '412 Precondition Failed',
      413: '413 Request Entity Too Large',
      414: '414 Request-URI Too Long',
      415: '415 Unsupported Media Type',
      416: '416 Requested Range Not Satisfiable',
      417: '417 Expectation Failed',
      // [Server Error 5xx]
      500: '500 Internal Server Error',
      501: '501 Not Implemented',
      502: '502 Bad Gateway',
      503: '503 Service Unavailable',
      504: '504 Gateway Timeout',
      505: '505 HTTP Version Not Supported'
    };
  
    static getMessageForCode(code) {
      return this.messages[code] || null;
    }
  }
  