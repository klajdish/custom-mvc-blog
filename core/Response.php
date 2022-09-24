<?php 
namespace Core;

class Response
{
	private $headers = [];
	private $httpResponseCode = 200;
	private $body;

    

	private static $httpCodes = [
		200 => "OK",
		304 => "Not Modified",
		403 => "Forbidden",
		404 => "Not Found"
	];

	public function send()
	{
		header("HTTP/1.1 {$this->httpResponseCode} " . self::$httpCodes[$this->httpResponseCode]);
        // foreach($this->headers as $header){
        //     header( $header);

        // }
		echo $this->body;
	}

    /**
     * Gets the value of headers.
     *
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Sets the value of headers.
     *
     * @param mixed $headers the headers
     *
     * @return self
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Gets the value of httpResponseCode.
     *
     * @return mixed
     */
    public function getHttpResponseCode()
    {
        return $this->httpResponseCode;
    }

    /**
     * Sets the value of httpResponseCode.
     *
     * @param mixed $httpResponseCode the http response code
     *
     * @return self
     */
    public function setHttpResponesCode($httpResponseCode)
    {
        $this->httpResponseCode = $httpResponseCode;

        return $this;
    }

    /**
     * Gets the value of body.
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Sets the value of body.
     *
     * @param mixed $body the body
     *
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}