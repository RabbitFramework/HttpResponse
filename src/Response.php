<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 28/11/2018
 * Time: 17:42
 */

namespace Rabbit\Http\Response;

class Response
{

    protected $headers = [];
    protected $content;
    protected $statusCode;
    protected $statusText;
    protected $cacheControl;
    protected $protocol = '1.1';

    public function __construct(string $content = '', int $status = 200, array $headers = [])
    {
        $this->setContent($content);
        $this->setStatus($status);
        $this->setHeaders($headers);
    }

    public function setContent(string $content) {
        $this->content = $content;
        return $this;
    }

    public function setStatus(int $status = 200, string $text = '') {
        $this->statusCode = $status;
        $this->statusText = $text;

        return $this;
    }

    public function setHeaders(array $headers = []) {
        $this->headers = $headers;
        return $this;
    }

    public function sendHeaders() {
        if(headers_sent()) {
            return $this;
        }

        foreach($this->headers as $header => $value) {
            header($header.': '.$value, true, $this->statusCode);
        }

        if(isset($this->headers['cookies'])) {
            foreach ($this->headers['cookies'] as $name) {
                header('Set-Cookie: '.$name, false, $this->statusCode);
            }
        }

        header(sprintf('HTTP/%s %s %s',$this->protocol, $this->statusCode, $this->statusText), true, $this->statusCode);
        return $this;
    }

    public function sendContent() {
        echo $this->content;

        return $this;
    }

    public function send() {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getStatus() {
        return $this->statusCode;
    }

    public function setProtocol(string $protocol) {
        $this->protocol = $protocol;

        return $this;
    }

    public function getProtocol() {
        return $this->protocol;
    }

    public function setNotModified() {
        $this->setStatus(304);
        $this->setContent('');

        foreach (['Allow', 'Content-Encoding',  'Content-Language', 'Content-Length', 'Content-MD5', 'Content-Type', 'Last-Modified'] as $header) {
            if(array_key_exists($header, $this->headers)) {
                unset($this->headers[$header]);
            }
        }

        return $this;
    }

    public function isNotModified() {
        return $this->statusCode === 304;
    }

    public function isSuccess() {
        return $this->statusCode >= 200 && $this->statusCode < 300;
    }

    public function isRedirect() : bool {
        return $this->statusCode >= 300 && $this->statusCode < 400;
    }

    public function isClientError() : bool {
        return $this->statusCode >= 400 && $this->statusCode < 500;
    }

    public function isServerError() : bool {
        return $this->statusCode >= 500 && $this->statusCode < 600;
    }

    public function isOk() : bool {
        return $this->statusCode === 200;
    }

    public function isNotFound() : bool {
        return $this->statusCode === 404;
    }

    public function isEmpty() : bool {
        return \in_array($this->statusCode, array(204, 304));
    }

}