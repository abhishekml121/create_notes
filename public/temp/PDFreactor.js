/*!
 * RealObjects PDFreactor JavaScript Client version 9
 * https://www.pdfreactor.com
 * 
 * Released under the following license:
 * 
 * The MIT License (MIT)
 * 
 * Copyright (c) 2015-2021 RealObjects GmbH
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

var PDFreactor = function(url) {
var self = this;
var apiKey = '';
var serviceUrl;
if (url) {
    if (url.substr(-1) === '/') {
        url = url.substr(0, url.length - 1);
    }
    serviceUrl = url;
} else {
    serviceUrl = 'http://localhost:9423/service/rest';
}
this.convert = function(configuration, connectionSettings) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/convert.json';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('POST', url, true);
        var contentType = 'application/json';
        if (configuration) {
            configuration.clientName = "JAVASCRIPT";
            configuration.clientVersion = PDFreactor.VERSION;
        }
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve(JSON.parse(xhr.response));
            } else {
                var responseText = xhr.responseText;
                var result = JSON.parse(responseText);
                var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                var err;
                if (xhr.status == 422) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: result.error, result: result });
                } else if (xhr.status == 400) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Invalid client data. " + result.error, result: result });
                } else if (xhr.status == 401) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + result.error, result: result });
                } else if (xhr.status == 413) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "The configuration is too large to process.", result: result });
                } else if (xhr.status == 500) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: result.error, result: result });
                } else if (xhr.status == 503) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "PDFreactor Web Service is unavailable.", result: result });
                } else {
                    err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", result: result, event: e });
                }
                return reject(err);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send(JSON.stringify(configuration));
    });
}
this.convertAsBinary = function(configuration, connectionSettings) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/convert.bin';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('POST', url, true);
        var contentType = 'application/json';
        if (configuration) {
            configuration.clientName = "JAVASCRIPT";
            configuration.clientVersion = PDFreactor.VERSION;
        }
        xhr.responseType = 'blob';
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve(new Blob([xhr.response], {type: xhr.getResponseHeader('content-type') || 'application/octet-stream'}));
            } else {
                var blob = new Blob([xhr.response], {type: 'text/plain'});
                var reader = new FileReader();
                reader.addEventListener('loadend', function(e) {
                    var responseText = e.srcElement.result;
                    var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                    var err;
                    if (xhr.status == 422) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: responseText });
                    } else if (xhr.status == 400) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Invalid client data. " + responseText });
                    } else if (xhr.status == 401) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + responseText });
                    } else if (xhr.status == 413) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "The configuration is too large to process." });
                    } else if (xhr.status == 500) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: responseText });
                    } else if (xhr.status == 503) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "PDFreactor Web Service is unavailable." });
                    } else {
                        err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", event: e });
                    }
                    return reject(err);
                });
                reader.addEventListener('error', function(e) {
                    return reject(new PDFreactor.ClientError({ message: 'Could not process Blob', event: e}))
                });
                reader.readAsText(blob);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send(JSON.stringify(configuration));
    });
}
this.convertAsync = function(configuration, connectionSettings) {
    return new Promise(function(resolve, reject) {
        var documentId;
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/convert/async.json';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('POST', url, true);
        var contentType = 'application/json';
        var payload;
        if (window.FormData && configuration instanceof FormData) {
            if (configuration.get) {
                var conf = configuration.get('configuration');
                if (conf) {
                    conf.clientName = "JAVASCRIPT";
                    conf.clientVersion = PDFreactor.VERSION;
                }
            }
            contentType = 'multipart/form-data';
            payload = configuration;
        } else if (configuration) {
            configuration.clientName = "JAVASCRIPT";
            configuration.clientVersion = PDFreactor.VERSION;
            payload = JSON.stringify(configuration);
        }
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            var progressUrl = e.target.getResponseHeader("Location");
            if (progressUrl) {
                documentId = progressUrl.substring(progressUrl.lastIndexOf("/") + 1);
            }
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve(documentId);
            } else {
                var responseText = xhr.responseText;
                var result = JSON.parse(responseText);
                var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                var err;
                if (xhr.status == 422) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: result.error, result: result });
                } else if (xhr.status == 400) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Invalid client data. " + result.error, result: result });
                } else if (xhr.status == 401) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + result.error, result: result });
                } else if (xhr.status == 413) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "The configuration is too large to process.", result: result });
                } else if (xhr.status == 500) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: result.error, result: result });
                } else if (xhr.status == 503) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Asynchronous conversions are unavailable.", result: result });
                } else {
                    err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", result: result, event: e });
                }
                return reject(err);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send(payload);
    });
}
this.getProgress = function(documentId, connectionSettings) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/progress/' + documentId + '.json';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('GET', url, true);
        var contentType = 'application/json';
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve(JSON.parse(xhr.response));
            } else {
                var responseText = xhr.responseText;
                var result = JSON.parse(responseText);
                var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                var err;
                if (xhr.status == 422) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: result.error, result: result });
                } else if (xhr.status == 404) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Document with the given ID was not found. " + result.error, result: result });
                } else if (xhr.status == 401) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + result.error, result: result });
                } else if (xhr.status == 503) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "PDFreactor Web Service is unavailable.", result: result });
                } else {
                    err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", result: result, event: e });
                }
                return reject(err);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send();
    });
}
this.getDocument = function(documentId, connectionSettings) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/document/' + documentId + '.json';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('GET', url, true);
        var contentType = 'application/json';
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve(JSON.parse(xhr.response));
            } else {
                var responseText = xhr.responseText;
                var result = JSON.parse(responseText);
                var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                var err;
                if (xhr.status == 422) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: result.error, result: result });
                } else if (xhr.status == 404) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Document with the given ID was not found. " + result.error, result: result });
                } else if (xhr.status == 401) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + result.error, result: result });
                } else if (xhr.status == 503) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "PDFreactor Web Service is unavailable.", result: result });
                } else {
                    err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", result: result, event: e });
                }
                return reject(err);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send();
    });
}
this.getDocumentAsBinary = function(documentId, connectionSettings) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/document/' + documentId + '.bin';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('GET', url, true);
        var contentType = 'application/json';
        xhr.responseType = 'blob';
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve(new Blob([xhr.response], {type: xhr.getResponseHeader('content-type') || 'application/octet-stream'}));
            } else {
                var blob = new Blob([xhr.response], {type: 'text/plain'});
                var reader = new FileReader();
                reader.addEventListener('loadend', function(e) {
                    var responseText = e.srcElement.result;
                    var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                    var err;
                    if (xhr.status == 422) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: responseText });
                    } else if (xhr.status == 404) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Document with the given ID was not found. " + responseText });
                    } else if (xhr.status == 401) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + responseText });
                    } else if (xhr.status == 503) {
                        err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "PDFreactor Web Service is unavailable." });
                    } else {
                        err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", event: e });
                    }
                    return reject(err);
                });
                reader.addEventListener('error', function(e) {
                    return reject(new PDFreactor.ClientError({ message: 'Could not process Blob', event: e}))
                });
                reader.readAsText(blob);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send();
    });
}
this.getDocumentMetadata = function(documentId, connectionSettings) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/document/metadata/' + documentId + '.json';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('GET', url, true);
        var contentType = 'application/json';
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve(JSON.parse(xhr.response));
            } else {
                var responseText = xhr.responseText;
                var result = JSON.parse(responseText);
                var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                var err;
                if (xhr.status == 422) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: result.error, result: result });
                } else if (xhr.status == 404) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Document with the given ID was not found. " + result.error, result: result });
                } else if (xhr.status == 401) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + result.error, result: result });
                } else if (xhr.status == 503) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "PDFreactor Web Service is unavailable.", result: result });
                } else {
                    err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", result: result, event: e });
                }
                return reject(err);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send();
    });
}
this.deleteDocument = function(documentId, connectionSettings) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/document/' + documentId + '.json';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('DELETE', url, true);
        var contentType = 'application/json';
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve();
            } else {
                var responseText = xhr.responseText;
                var result = JSON.parse(responseText);
                var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                var err;
                if (xhr.status == 404) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Document with the given ID was not found. " + result.error, result: result });
                } else if (xhr.status == 401) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + result.error, result: result });
                } else if (xhr.status == 503) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "PDFreactor Web Service is unavailable.", result: result });
                } else {
                    err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", result: result, event: e });
                }
                return reject(err);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send();
    });
}
this.getStatus = function(connectionSettings) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/status.json';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('GET', url, true);
        var contentType = 'application/json';
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve();
            } else {
                var responseText = xhr.responseText;
                var result = JSON.parse(responseText);
                var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                var err;
                if (xhr.status == 401) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + result.error, result: result });
                } else if (xhr.status == 503) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "PDFreactor Web Service is unavailable.", result: result });
                } else {
                    err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", result: result, event: e });
                }
                return reject(err);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send();
    });
}
this.getVersion = function(connectionSettings) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var url = serviceUrl + '/version.json';
        if (apiKey) {
            url += '?apiKey=' + apiKey;
        }
        xhr.open('GET', url, true);
        var contentType = 'application/json';
        xhr.setRequestHeader('Content-Type', contentType);
        xhr.setRequestHeader('X-RO-User-Agent','PDFreactor JavaScript API v9');
        xhr.withCredentials = true;
        if (connectionSettings && connectionSettings.headers) {
            for (var name in connectionSettings.headers) {
                if (connectionSettings.headers.hasOwnProperty(name)) {
                    xhr.setRequestHeader(name, connectionSettings.headers[name]);
                }
            }
        }
        xhr.addEventListener('load', function(e) {
            if (xhr.status >= 200 && xhr.status <= 204) {
                return resolve(JSON.parse(xhr.response));
            } else {
                var responseText = xhr.responseText;
                var result = JSON.parse(responseText);
                var errorId = xhr.getResponseHeader('X-RO-Error-ID');
                var err;
                if (xhr.status == 401) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "Unauthorized. " + result.error, result: result });
                } else if (xhr.status == 503) {
                    err = PDFreactor._createServerError({ errorId: errorId, event: e, message: "PDFreactor Web Service is unavailable.", result: result });
                } else {
                    err = PDFreactor._createServerError({ errorId: errorId, message: "PDFreactor Web Service error (status: " + xhr.status + ").", result: result, event: e });
                }
                return reject(err);
            }
        }, true);
        xhr.addEventListener('error', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection failed)', event: e }));
        }, true);
        xhr.addEventListener('abort', function(e) {
            return reject(new PDFreactor.UnreachableServiceError({ message: 'Error connecting to PDFreactor Web Service at ' + serviceUrl + '. Please make sure the PDFreactor Web Service is installed and running (Error: Connection canceled)', event: e }));
        }, true);
        xhr.send();
    });
}
this.getDocumentUrl = function(documentId) {
    if (documentId) {
        return serviceUrl + "/document/" + documentId;
    }
}
this.getProgressUrl = function(documentId) {
    if (documentId) {
        return serviceUrl + "/progress/" + documentId;
    }
}
Object.defineProperty(self, 'apiKey', {
    set: function(value) {
        apiKey = value
    },
    get: function() {
        return apiKey
    }
});
}
PDFreactor.PDFreactorWebserviceError = function(data) {
    data = data || {};
    this.message = data.message || 'Unknown PDFreactor Web Service error';
    this.event = data.event;
}
PDFreactor.ClientError = function(data) {
    PDFreactor.PDFreactorWebserviceError.call(this, data);
}
PDFreactor.ClientError.prototype = PDFreactor.PDFreactorWebserviceError.prototype;
PDFreactor.ServerError = function(data) {
    data = data || {};
    PDFreactor.PDFreactorWebserviceError.call(this, data);
    this.errorId = data.errorId;
    this.result = data.result;
}
PDFreactor.ServerError.prototype = PDFreactor.PDFreactorWebserviceError.prototype;
PDFreactor.AsyncUnavailableError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.AsyncUnavailableError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.BadRequestError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.BadRequestError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.CommandRejectedError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.CommandRejectedError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.ConversionAbortedError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.ConversionAbortedError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.ConversionFailureError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.ConversionFailureError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.DocumentNotFoundError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.DocumentNotFoundError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.ResourceNotFoundError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.ResourceNotFoundError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.InvalidClientError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.InvalidClientError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.InvalidConfigurationError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.InvalidConfigurationError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.NoConfigurationError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.NoConfigurationError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.NoInputDocumentError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.NoInputDocumentError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.RequestRejectedError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.RequestRejectedError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.ServiceUnavailableError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.ServiceUnavailableError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.UnauthorizedError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.UnauthorizedError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.UnprocessableConfigurationError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.UnprocessableConfigurationError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.UnprocessableInputError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.UnprocessableInputError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.NotAcceptableError = function(data) {
    PDFreactor.ServerError.call(this, data);
}
PDFreactor.NotAcceptableError.prototype = PDFreactor.ServerError.prototype;
PDFreactor.UnreachableServiceError = function(data) {
    PDFreactor.ClientError.call(this, data);
}
PDFreactor.UnreachableServiceError.prototype = PDFreactor.ClientError.prototype;
PDFreactor.InvalidServiceError = function(data) {
    PDFreactor.ClientError.call(this, data);
}
PDFreactor.InvalidServiceError.prototype = PDFreactor.ClientError.prototype;
PDFreactor._createServerError = function(data) {
    switch (data.errorId) {
        case 'asyncUnavailable':
            return new PDFreactor.AsyncUnavailableError(data);
        case 'badRequest':
            return new PDFreactor.BadRequestError(data);
        case 'commandRejected':
            return new PDFreactor.CommandRejectedError(data);
        case 'conversionAborted':
            return new PDFreactor.ConversionAbortedError(data);
        case 'conversionFailure':
            return new PDFreactor.ConversionFailureError(data);
        case 'documentNotFound':
            return new PDFreactor.DocumentNotFoundError(data);
        case 'resourceNotFound':
            return new PDFreactor.ResourceNotFoundError(data);
        case 'invalidClient':
            return new PDFreactor.InvalidClientError(data);
        case 'invalidConfiguration':
            return new PDFreactor.InvalidConfigurationError(data);
        case 'noConfiguration':
            return new PDFreactor.NoConfigurationError(data);
        case 'noInputDocument':
            return new PDFreactor.NoInputDocumentError(data);
        case 'requestRejected':
            return new PDFreactor.RequestRejectedError(data);
        case 'serviceUnavailable':
            return new PDFreactor.ServiceUnavailableError(data);
        case 'unauthorized':
            return new PDFreactor.UnauthorizedError(data);
        case 'unprocessableConfiguration':
            return new PDFreactor.UnprocessableConfigurationError(data);
        case 'unprocessableInput':
            return new PDFreactor.UnprocessableInputError(data);
        case 'notAcceptable':
            return new PDFreactor.NotAcceptableError(data);
        default:
            return new PDFreactor.ServerError(data);
    }
}
Object.defineProperty(PDFreactor, 'CallbackType', {
    value: {}
});
Object.defineProperty(PDFreactor.CallbackType, 'FINISH', {
    value: 'FINISH'
});
Object.defineProperty(PDFreactor.CallbackType, 'PROGRESS', {
    value: 'PROGRESS'
});
Object.defineProperty(PDFreactor.CallbackType, 'START', {
    value: 'START'
});
Object.defineProperty(PDFreactor, 'Cleanup', {
    value: {}
});
Object.defineProperty(PDFreactor.Cleanup, 'CYBERNEKO', {
    value: 'CYBERNEKO'
});
Object.defineProperty(PDFreactor.Cleanup, 'JTIDY', {
    value: 'JTIDY'
});
Object.defineProperty(PDFreactor.Cleanup, 'NONE', {
    value: 'NONE'
});
Object.defineProperty(PDFreactor.Cleanup, 'TAGSOUP', {
    value: 'TAGSOUP'
});
Object.defineProperty(PDFreactor, 'ColorSpace', {
    value: {}
});
Object.defineProperty(PDFreactor.ColorSpace, 'CMYK', {
    value: 'CMYK'
});
Object.defineProperty(PDFreactor.ColorSpace, 'RGB', {
    value: 'RGB'
});
Object.defineProperty(PDFreactor, 'Conformance', {
    value: {}
});
Object.defineProperty(PDFreactor.Conformance, 'PDF', {
    value: 'PDF'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA1A', {
    value: 'PDFA1A'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA1A_PDFUA1', {
    value: 'PDFA1A_PDFUA1'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA1B', {
    value: 'PDFA1B'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA2A', {
    value: 'PDFA2A'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA2A_PDFUA1', {
    value: 'PDFA2A_PDFUA1'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA2B', {
    value: 'PDFA2B'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA2U', {
    value: 'PDFA2U'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA3A', {
    value: 'PDFA3A'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA3A_PDFUA1', {
    value: 'PDFA3A_PDFUA1'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA3B', {
    value: 'PDFA3B'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFA3U', {
    value: 'PDFA3U'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFUA1', {
    value: 'PDFUA1'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFX1A_2001', {
    value: 'PDFX1A_2001'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFX1A_2003', {
    value: 'PDFX1A_2003'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFX3_2002', {
    value: 'PDFX3_2002'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFX3_2003', {
    value: 'PDFX3_2003'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFX4', {
    value: 'PDFX4'
});
Object.defineProperty(PDFreactor.Conformance, 'PDFX4P', {
    value: 'PDFX4P'
});
Object.defineProperty(PDFreactor, 'ContentType', {
    value: {}
});
Object.defineProperty(PDFreactor.ContentType, 'BINARY', {
    value: 'BINARY'
});
Object.defineProperty(PDFreactor.ContentType, 'BMP', {
    value: 'BMP'
});
Object.defineProperty(PDFreactor.ContentType, 'GIF', {
    value: 'GIF'
});
Object.defineProperty(PDFreactor.ContentType, 'HTML', {
    value: 'HTML'
});
Object.defineProperty(PDFreactor.ContentType, 'JPEG', {
    value: 'JPEG'
});
Object.defineProperty(PDFreactor.ContentType, 'JSON', {
    value: 'JSON'
});
Object.defineProperty(PDFreactor.ContentType, 'NONE', {
    value: 'NONE'
});
Object.defineProperty(PDFreactor.ContentType, 'PDF', {
    value: 'PDF'
});
Object.defineProperty(PDFreactor.ContentType, 'PNG', {
    value: 'PNG'
});
Object.defineProperty(PDFreactor.ContentType, 'TEXT', {
    value: 'TEXT'
});
Object.defineProperty(PDFreactor.ContentType, 'TIFF', {
    value: 'TIFF'
});
Object.defineProperty(PDFreactor.ContentType, 'XML', {
    value: 'XML'
});
Object.defineProperty(PDFreactor, 'CssPropertySupport', {
    value: {}
});
Object.defineProperty(PDFreactor.CssPropertySupport, 'ALL', {
    value: 'ALL'
});
Object.defineProperty(PDFreactor.CssPropertySupport, 'HTML', {
    value: 'HTML'
});
Object.defineProperty(PDFreactor.CssPropertySupport, 'HTML_THIRD_PARTY', {
    value: 'HTML_THIRD_PARTY'
});
Object.defineProperty(PDFreactor.CssPropertySupport, 'HTML_THIRD_PARTY_LENIENT', {
    value: 'HTML_THIRD_PARTY_LENIENT'
});
Object.defineProperty(PDFreactor, 'Doctype', {
    value: {}
});
Object.defineProperty(PDFreactor.Doctype, 'AUTODETECT', {
    value: 'AUTODETECT'
});
Object.defineProperty(PDFreactor.Doctype, 'HTML5', {
    value: 'HTML5'
});
Object.defineProperty(PDFreactor.Doctype, 'XHTML', {
    value: 'XHTML'
});
Object.defineProperty(PDFreactor.Doctype, 'XML', {
    value: 'XML'
});
Object.defineProperty(PDFreactor, 'Encryption', {
    value: {}
});
Object.defineProperty(PDFreactor.Encryption, 'NONE', {
    value: 'NONE'
});
Object.defineProperty(PDFreactor.Encryption, 'TYPE_128', {
    value: 'TYPE_128'
});
Object.defineProperty(PDFreactor.Encryption, 'TYPE_40', {
    value: 'TYPE_40'
});
Object.defineProperty(PDFreactor, 'ErrorPolicy', {
    value: {}
});
Object.defineProperty(PDFreactor.ErrorPolicy, 'CONFORMANCE_VALIDATION_UNAVAILABLE', {
    value: 'CONFORMANCE_VALIDATION_UNAVAILABLE'
});
Object.defineProperty(PDFreactor.ErrorPolicy, 'LICENSE', {
    value: 'LICENSE'
});
Object.defineProperty(PDFreactor.ErrorPolicy, 'MISSING_RESOURCE', {
    value: 'MISSING_RESOURCE'
});
Object.defineProperty(PDFreactor.ErrorPolicy, 'UNCAUGHT_JAVASCRIPT_EXCEPTION', {
    value: 'UNCAUGHT_JAVASCRIPT_EXCEPTION'
});
Object.defineProperty(PDFreactor, 'ExceedingContentAgainst', {
    value: {}
});
Object.defineProperty(PDFreactor.ExceedingContentAgainst, 'NONE', {
    value: 'NONE'
});
Object.defineProperty(PDFreactor.ExceedingContentAgainst, 'PAGE_BORDERS', {
    value: 'PAGE_BORDERS'
});
Object.defineProperty(PDFreactor.ExceedingContentAgainst, 'PAGE_CONTENT', {
    value: 'PAGE_CONTENT'
});
Object.defineProperty(PDFreactor.ExceedingContentAgainst, 'PARENT', {
    value: 'PARENT'
});
Object.defineProperty(PDFreactor, 'ExceedingContentAnalyze', {
    value: {}
});
Object.defineProperty(PDFreactor.ExceedingContentAnalyze, 'CONTENT', {
    value: 'CONTENT'
});
Object.defineProperty(PDFreactor.ExceedingContentAnalyze, 'CONTENT_AND_BOXES', {
    value: 'CONTENT_AND_BOXES'
});
Object.defineProperty(PDFreactor.ExceedingContentAnalyze, 'CONTENT_AND_STATIC_BOXES', {
    value: 'CONTENT_AND_STATIC_BOXES'
});
Object.defineProperty(PDFreactor.ExceedingContentAnalyze, 'NONE', {
    value: 'NONE'
});
Object.defineProperty(PDFreactor, 'HttpsMode', {
    value: {}
});
Object.defineProperty(PDFreactor.HttpsMode, 'LENIENT', {
    value: 'LENIENT'
});
Object.defineProperty(PDFreactor.HttpsMode, 'STRICT', {
    value: 'STRICT'
});
Object.defineProperty(PDFreactor, 'JavaScriptDebugMode', {
    value: {}
});
Object.defineProperty(PDFreactor.JavaScriptDebugMode, 'EXCEPTIONS', {
    value: 'EXCEPTIONS'
});
Object.defineProperty(PDFreactor.JavaScriptDebugMode, 'FUNCTIONS', {
    value: 'FUNCTIONS'
});
Object.defineProperty(PDFreactor.JavaScriptDebugMode, 'LINES', {
    value: 'LINES'
});
Object.defineProperty(PDFreactor.JavaScriptDebugMode, 'NONE', {
    value: 'NONE'
});
Object.defineProperty(PDFreactor.JavaScriptDebugMode, 'POSITIONS', {
    value: 'POSITIONS'
});
Object.defineProperty(PDFreactor, 'JavaScriptMode', {
    value: {}
});
Object.defineProperty(PDFreactor.JavaScriptMode, 'DISABLED', {
    value: 'DISABLED'
});
Object.defineProperty(PDFreactor.JavaScriptMode, 'ENABLED', {
    value: 'ENABLED'
});
Object.defineProperty(PDFreactor.JavaScriptMode, 'ENABLED_NO_LAYOUT', {
    value: 'ENABLED_NO_LAYOUT'
});
Object.defineProperty(PDFreactor.JavaScriptMode, 'ENABLED_REAL_TIME', {
    value: 'ENABLED_REAL_TIME'
});
Object.defineProperty(PDFreactor.JavaScriptMode, 'ENABLED_TIME_LAPSE', {
    value: 'ENABLED_TIME_LAPSE'
});
Object.defineProperty(PDFreactor, 'KeystoreType', {
    value: {}
});
Object.defineProperty(PDFreactor.KeystoreType, 'JKS', {
    value: 'JKS'
});
Object.defineProperty(PDFreactor.KeystoreType, 'PKCS12', {
    value: 'PKCS12'
});
Object.defineProperty(PDFreactor, 'LogLevel', {
    value: {}
});
Object.defineProperty(PDFreactor.LogLevel, 'DEBUG', {
    value: 'DEBUG'
});
Object.defineProperty(PDFreactor.LogLevel, 'FATAL', {
    value: 'FATAL'
});
Object.defineProperty(PDFreactor.LogLevel, 'INFO', {
    value: 'INFO'
});
Object.defineProperty(PDFreactor.LogLevel, 'NONE', {
    value: 'NONE'
});
Object.defineProperty(PDFreactor.LogLevel, 'PERFORMANCE', {
    value: 'PERFORMANCE'
});
Object.defineProperty(PDFreactor.LogLevel, 'WARN', {
    value: 'WARN'
});
Object.defineProperty(PDFreactor, 'MediaFeature', {
    value: {}
});
Object.defineProperty(PDFreactor.MediaFeature, 'ASPECT_RATIO', {
    value: 'ASPECT_RATIO'
});
Object.defineProperty(PDFreactor.MediaFeature, 'COLOR', {
    value: 'COLOR'
});
Object.defineProperty(PDFreactor.MediaFeature, 'COLOR_INDEX', {
    value: 'COLOR_INDEX'
});
Object.defineProperty(PDFreactor.MediaFeature, 'DEVICE_ASPECT_RATIO', {
    value: 'DEVICE_ASPECT_RATIO'
});
Object.defineProperty(PDFreactor.MediaFeature, 'DEVICE_HEIGHT', {
    value: 'DEVICE_HEIGHT'
});
Object.defineProperty(PDFreactor.MediaFeature, 'DEVICE_WIDTH', {
    value: 'DEVICE_WIDTH'
});
Object.defineProperty(PDFreactor.MediaFeature, 'GRID', {
    value: 'GRID'
});
Object.defineProperty(PDFreactor.MediaFeature, 'HEIGHT', {
    value: 'HEIGHT'
});
Object.defineProperty(PDFreactor.MediaFeature, 'MONOCHROME', {
    value: 'MONOCHROME'
});
Object.defineProperty(PDFreactor.MediaFeature, 'ORIENTATION', {
    value: 'ORIENTATION'
});
Object.defineProperty(PDFreactor.MediaFeature, 'RESOLUTION', {
    value: 'RESOLUTION'
});
Object.defineProperty(PDFreactor.MediaFeature, 'WIDTH', {
    value: 'WIDTH'
});
Object.defineProperty(PDFreactor, 'MergeMode', {
    value: {}
});
Object.defineProperty(PDFreactor.MergeMode, 'APPEND', {
    value: 'APPEND'
});
Object.defineProperty(PDFreactor.MergeMode, 'ARRANGE', {
    value: 'ARRANGE'
});
Object.defineProperty(PDFreactor.MergeMode, 'OVERLAY', {
    value: 'OVERLAY'
});
Object.defineProperty(PDFreactor.MergeMode, 'OVERLAY_BELOW', {
    value: 'OVERLAY_BELOW'
});
Object.defineProperty(PDFreactor.MergeMode, 'PREPEND', {
    value: 'PREPEND'
});
Object.defineProperty(PDFreactor, 'OutputIntentDefaultProfile', {
    value: {}
});
Object.defineProperty(PDFreactor.OutputIntentDefaultProfile, 'FOGRA39', {
    value: 'Coated FOGRA39'
});
Object.defineProperty(PDFreactor.OutputIntentDefaultProfile, 'GRACOL', {
    value: 'Coated GRACoL 2006'
});
Object.defineProperty(PDFreactor.OutputIntentDefaultProfile, 'IFRA', {
    value: 'ISO News print 26% (IFRA)'
});
Object.defineProperty(PDFreactor.OutputIntentDefaultProfile, 'JAPAN', {
    value: 'Japan Color 2001 Coated'
});
Object.defineProperty(PDFreactor.OutputIntentDefaultProfile, 'JAPAN_NEWSPAPER', {
    value: 'Japan Color 2001 Newspaper'
});
Object.defineProperty(PDFreactor.OutputIntentDefaultProfile, 'JAPAN_UNCOATED', {
    value: 'Japan Color 2001 Uncoated'
});
Object.defineProperty(PDFreactor.OutputIntentDefaultProfile, 'JAPAN_WEB', {
    value: 'Japan Web Coated (Ad)'
});
Object.defineProperty(PDFreactor.OutputIntentDefaultProfile, 'SWOP', {
    value: 'US Web Coated (SWOP) v2'
});
Object.defineProperty(PDFreactor.OutputIntentDefaultProfile, 'SWOP_3', {
    value: 'Web Coated SWOP 2006 Grade 3 Paper'
});
Object.defineProperty(PDFreactor, 'OutputType', {
    value: {}
});
Object.defineProperty(PDFreactor.OutputType, 'BMP', {
    value: 'BMP'
});
Object.defineProperty(PDFreactor.OutputType, 'GIF', {
    value: 'GIF'
});
Object.defineProperty(PDFreactor.OutputType, 'GIF_DITHERED', {
    value: 'GIF_DITHERED'
});
Object.defineProperty(PDFreactor.OutputType, 'JPEG', {
    value: 'JPEG'
});
Object.defineProperty(PDFreactor.OutputType, 'PDF', {
    value: 'PDF'
});
Object.defineProperty(PDFreactor.OutputType, 'PNG', {
    value: 'PNG'
});
Object.defineProperty(PDFreactor.OutputType, 'PNG_AI', {
    value: 'PNG_AI'
});
Object.defineProperty(PDFreactor.OutputType, 'PNG_TRANSPARENT', {
    value: 'PNG_TRANSPARENT'
});
Object.defineProperty(PDFreactor.OutputType, 'PNG_TRANSPARENT_AI', {
    value: 'PNG_TRANSPARENT_AI'
});
Object.defineProperty(PDFreactor.OutputType, 'TIFF_CCITT_1D', {
    value: 'TIFF_CCITT_1D'
});
Object.defineProperty(PDFreactor.OutputType, 'TIFF_CCITT_1D_DITHERED', {
    value: 'TIFF_CCITT_1D_DITHERED'
});
Object.defineProperty(PDFreactor.OutputType, 'TIFF_CCITT_GROUP_3', {
    value: 'TIFF_CCITT_GROUP_3'
});
Object.defineProperty(PDFreactor.OutputType, 'TIFF_CCITT_GROUP_3_DITHERED', {
    value: 'TIFF_CCITT_GROUP_3_DITHERED'
});
Object.defineProperty(PDFreactor.OutputType, 'TIFF_CCITT_GROUP_4', {
    value: 'TIFF_CCITT_GROUP_4'
});
Object.defineProperty(PDFreactor.OutputType, 'TIFF_CCITT_GROUP_4_DITHERED', {
    value: 'TIFF_CCITT_GROUP_4_DITHERED'
});
Object.defineProperty(PDFreactor.OutputType, 'TIFF_LZW', {
    value: 'TIFF_LZW'
});
Object.defineProperty(PDFreactor.OutputType, 'TIFF_PACKBITS', {
    value: 'TIFF_PACKBITS'
});
Object.defineProperty(PDFreactor.OutputType, 'TIFF_UNCOMPRESSED', {
    value: 'TIFF_UNCOMPRESSED'
});
Object.defineProperty(PDFreactor, 'OverlayRepeat', {
    value: {}
});
Object.defineProperty(PDFreactor.OverlayRepeat, 'ALL_PAGES', {
    value: 'ALL_PAGES'
});
Object.defineProperty(PDFreactor.OverlayRepeat, 'LAST_PAGE', {
    value: 'LAST_PAGE'
});
Object.defineProperty(PDFreactor.OverlayRepeat, 'NONE', {
    value: 'NONE'
});
Object.defineProperty(PDFreactor.OverlayRepeat, 'TRIM', {
    value: 'TRIM'
});
Object.defineProperty(PDFreactor, 'PageOrder', {
    value: {}
});
Object.defineProperty(PDFreactor.PageOrder, 'BOOKLET', {
    value: 'BOOKLET'
});
Object.defineProperty(PDFreactor.PageOrder, 'BOOKLET_RTL', {
    value: 'BOOKLET_RTL'
});
Object.defineProperty(PDFreactor.PageOrder, 'EVEN', {
    value: 'EVEN'
});
Object.defineProperty(PDFreactor.PageOrder, 'ODD', {
    value: 'ODD'
});
Object.defineProperty(PDFreactor.PageOrder, 'REVERSE', {
    value: 'REVERSE'
});
Object.defineProperty(PDFreactor, 'PagesPerSheetDirection', {
    value: {}
});
Object.defineProperty(PDFreactor.PagesPerSheetDirection, 'DOWN_LEFT', {
    value: 'DOWN_LEFT'
});
Object.defineProperty(PDFreactor.PagesPerSheetDirection, 'DOWN_RIGHT', {
    value: 'DOWN_RIGHT'
});
Object.defineProperty(PDFreactor.PagesPerSheetDirection, 'LEFT_DOWN', {
    value: 'LEFT_DOWN'
});
Object.defineProperty(PDFreactor.PagesPerSheetDirection, 'LEFT_UP', {
    value: 'LEFT_UP'
});
Object.defineProperty(PDFreactor.PagesPerSheetDirection, 'RIGHT_DOWN', {
    value: 'RIGHT_DOWN'
});
Object.defineProperty(PDFreactor.PagesPerSheetDirection, 'RIGHT_UP', {
    value: 'RIGHT_UP'
});
Object.defineProperty(PDFreactor.PagesPerSheetDirection, 'UP_LEFT', {
    value: 'UP_LEFT'
});
Object.defineProperty(PDFreactor.PagesPerSheetDirection, 'UP_RIGHT', {
    value: 'UP_RIGHT'
});
Object.defineProperty(PDFreactor, 'PdfScriptTriggerEvent', {
    value: {}
});
Object.defineProperty(PDFreactor.PdfScriptTriggerEvent, 'AFTER_PRINT', {
    value: 'AFTER_PRINT'
});
Object.defineProperty(PDFreactor.PdfScriptTriggerEvent, 'AFTER_SAVE', {
    value: 'AFTER_SAVE'
});
Object.defineProperty(PDFreactor.PdfScriptTriggerEvent, 'BEFORE_PRINT', {
    value: 'BEFORE_PRINT'
});
Object.defineProperty(PDFreactor.PdfScriptTriggerEvent, 'BEFORE_SAVE', {
    value: 'BEFORE_SAVE'
});
Object.defineProperty(PDFreactor.PdfScriptTriggerEvent, 'CLOSE', {
    value: 'CLOSE'
});
Object.defineProperty(PDFreactor.PdfScriptTriggerEvent, 'OPEN', {
    value: 'OPEN'
});
Object.defineProperty(PDFreactor, 'ProcessingPreferences', {
    value: {}
});
Object.defineProperty(PDFreactor.ProcessingPreferences, 'SAVE_MEMORY_IMAGES', {
    value: 'SAVE_MEMORY_IMAGES'
});
Object.defineProperty(PDFreactor, 'QuirksMode', {
    value: {}
});
Object.defineProperty(PDFreactor.QuirksMode, 'DETECT', {
    value: 'DETECT'
});
Object.defineProperty(PDFreactor.QuirksMode, 'QUIRKS', {
    value: 'QUIRKS'
});
Object.defineProperty(PDFreactor.QuirksMode, 'STANDARDS', {
    value: 'STANDARDS'
});
Object.defineProperty(PDFreactor, 'ResolutionUnit', {
    value: {}
});
Object.defineProperty(PDFreactor.ResolutionUnit, 'DPCM', {
    value: 'DPCM'
});
Object.defineProperty(PDFreactor.ResolutionUnit, 'DPI', {
    value: 'DPI'
});
Object.defineProperty(PDFreactor.ResolutionUnit, 'DPPX', {
    value: 'DPPX'
});
Object.defineProperty(PDFreactor.ResolutionUnit, 'TDPCM', {
    value: 'TDPCM'
});
Object.defineProperty(PDFreactor.ResolutionUnit, 'TDPI', {
    value: 'TDPI'
});
Object.defineProperty(PDFreactor.ResolutionUnit, 'TDPPX', {
    value: 'TDPPX'
});
Object.defineProperty(PDFreactor, 'ResourceType', {
    value: {}
});
Object.defineProperty(PDFreactor.ResourceType, 'ATTACHMENT', {
    value: 'ATTACHMENT'
});
Object.defineProperty(PDFreactor.ResourceType, 'DOCUMENT', {
    value: 'DOCUMENT'
});
Object.defineProperty(PDFreactor.ResourceType, 'FONT', {
    value: 'FONT'
});
Object.defineProperty(PDFreactor.ResourceType, 'ICC_PROFILE', {
    value: 'ICC_PROFILE'
});
Object.defineProperty(PDFreactor.ResourceType, 'IFRAME', {
    value: 'IFRAME'
});
Object.defineProperty(PDFreactor.ResourceType, 'IMAGE', {
    value: 'IMAGE'
});
Object.defineProperty(PDFreactor.ResourceType, 'LICENSEKEY', {
    value: 'LICENSEKEY'
});
Object.defineProperty(PDFreactor.ResourceType, 'MERGE_DOCUMENT', {
    value: 'MERGE_DOCUMENT'
});
Object.defineProperty(PDFreactor.ResourceType, 'OBJECT', {
    value: 'OBJECT'
});
Object.defineProperty(PDFreactor.ResourceType, 'RUNNING_DOCUMENT', {
    value: 'RUNNING_DOCUMENT'
});
Object.defineProperty(PDFreactor.ResourceType, 'SCRIPT', {
    value: 'SCRIPT'
});
Object.defineProperty(PDFreactor.ResourceType, 'STYLESHEET', {
    value: 'STYLESHEET'
});
Object.defineProperty(PDFreactor.ResourceType, 'UNKNOWN', {
    value: 'UNKNOWN'
});
Object.defineProperty(PDFreactor.ResourceType, 'XHR', {
    value: 'XHR'
});
Object.defineProperty(PDFreactor, 'SigningMode', {
    value: {}
});
Object.defineProperty(PDFreactor.SigningMode, 'SELF_SIGNED', {
    value: 'SELF_SIGNED'
});
Object.defineProperty(PDFreactor.SigningMode, 'VERISIGN_SIGNED', {
    value: 'VERISIGN_SIGNED'
});
Object.defineProperty(PDFreactor.SigningMode, 'WINCER_SIGNED', {
    value: 'WINCER_SIGNED'
});
Object.defineProperty(PDFreactor, 'ViewerPreferences', {
    value: {}
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'CENTER_WINDOW', {
    value: 'CENTER_WINDOW'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'DIRECTION_L2R', {
    value: 'DIRECTION_L2R'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'DIRECTION_R2L', {
    value: 'DIRECTION_R2L'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'DISPLAY_DOC_TITLE', {
    value: 'DISPLAY_DOC_TITLE'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'DUPLEX_FLIP_LONG_EDGE', {
    value: 'DUPLEX_FLIP_LONG_EDGE'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'DUPLEX_FLIP_SHORT_EDGE', {
    value: 'DUPLEX_FLIP_SHORT_EDGE'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'DUPLEX_SIMPLEX', {
    value: 'DUPLEX_SIMPLEX'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'FIT_WINDOW', {
    value: 'FIT_WINDOW'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'HIDE_MENUBAR', {
    value: 'HIDE_MENUBAR'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'HIDE_TOOLBAR', {
    value: 'HIDE_TOOLBAR'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'HIDE_WINDOW_UI', {
    value: 'HIDE_WINDOW_UI'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'NON_FULLSCREEN_PAGE_MODE_USE_NONE', {
    value: 'NON_FULLSCREEN_PAGE_MODE_USE_NONE'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'NON_FULLSCREEN_PAGE_MODE_USE_OC', {
    value: 'NON_FULLSCREEN_PAGE_MODE_USE_OC'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'NON_FULLSCREEN_PAGE_MODE_USE_OUTLINES', {
    value: 'NON_FULLSCREEN_PAGE_MODE_USE_OUTLINES'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'NON_FULLSCREEN_PAGE_MODE_USE_THUMBS', {
    value: 'NON_FULLSCREEN_PAGE_MODE_USE_THUMBS'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_LAYOUT_ONE_COLUMN', {
    value: 'PAGE_LAYOUT_ONE_COLUMN'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_LAYOUT_SINGLE_PAGE', {
    value: 'PAGE_LAYOUT_SINGLE_PAGE'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_LAYOUT_TWO_COLUMN_LEFT', {
    value: 'PAGE_LAYOUT_TWO_COLUMN_LEFT'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_LAYOUT_TWO_COLUMN_RIGHT', {
    value: 'PAGE_LAYOUT_TWO_COLUMN_RIGHT'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_LAYOUT_TWO_PAGE_LEFT', {
    value: 'PAGE_LAYOUT_TWO_PAGE_LEFT'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_LAYOUT_TWO_PAGE_RIGHT', {
    value: 'PAGE_LAYOUT_TWO_PAGE_RIGHT'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_MODE_FULLSCREEN', {
    value: 'PAGE_MODE_FULLSCREEN'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_MODE_USE_ATTACHMENTS', {
    value: 'PAGE_MODE_USE_ATTACHMENTS'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_MODE_USE_NONE', {
    value: 'PAGE_MODE_USE_NONE'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_MODE_USE_OC', {
    value: 'PAGE_MODE_USE_OC'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_MODE_USE_OUTLINES', {
    value: 'PAGE_MODE_USE_OUTLINES'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PAGE_MODE_USE_THUMBS', {
    value: 'PAGE_MODE_USE_THUMBS'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PICKTRAYBYPDFSIZE_FALSE', {
    value: 'PICKTRAYBYPDFSIZE_FALSE'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PICKTRAYBYPDFSIZE_TRUE', {
    value: 'PICKTRAYBYPDFSIZE_TRUE'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PRINTSCALING_APPDEFAULT', {
    value: 'PRINTSCALING_APPDEFAULT'
});
Object.defineProperty(PDFreactor.ViewerPreferences, 'PRINTSCALING_NONE', {
    value: 'PRINTSCALING_NONE'
});
Object.defineProperty(PDFreactor, 'XmpPriority', {
    value: {}
});
Object.defineProperty(PDFreactor.XmpPriority, 'HIGH', {
    value: 'HIGH'
});
Object.defineProperty(PDFreactor.XmpPriority, 'LOW', {
    value: 'LOW'
});
Object.defineProperty(PDFreactor.XmpPriority, 'NONE', {
    value: 'NONE'
});
Object.defineProperty(PDFreactor, 'VERSION', {
    value: 9
});
