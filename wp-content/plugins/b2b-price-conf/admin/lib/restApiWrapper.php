<?php

namespace raw;

/**
 * @method mixed post(String $endpoint, Array $params, Array $headers, String $returnType, Boolean $fileUpload)
 * @method mixed get(String $endpoint, Array $params, Array $headers, String $returnType)
 * @method mixed patch(String $endpoint, Array $params, Array $headers, String $returnType)
 * @method mixed head(String $endpoint, Array $params, Array $headers, String $returnType)
 * @method mixed options(String $endpoint, Array $params, Array $headers, String $returnType)
 * @method mixed put(String $endpoint, Array $params, Array $headers, String $returnType)
 * @method mixed delete(String $endpoint, Array $params, Array $headers, String $returnType)
 * @method mixed ftp(String $endpoint, Array $params, Array $headers, String $returnType, String $file, String $userPaswd)
 */
class restApiWrapper
{
    /**
     * Avaialable Methods
     */
    /** @const */
    private static $METHODS = array('POST', 'GET', 'PATCH', 'HEAD', 'OPTIONS', 'PUT', 'DELETE', 'FTP');

    /**
     * Curl Resource
     * @var Resource
     */
    private $ch;

    /**
     * Api Url to call
     * @var String
     */
    private $url;

    /**
     * @var String
     */
    private $proxy_host;

    /**
     * @var String
     */
    private $proxy_port;

    /**
     *
     * @param String $url
     */
    public function __construct($url)
    {
        $this->url = is_string($url) ? $url : '';
    }

    /**
     * Call any of the avaialbe HTTP method
     * @param String $name
     * @param Array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($name, $arguments)
    {
        $this->curlInit();
//        $this->sslVerify(false);
        if (!empty($arguments[2])) {
            $this->setHeader($arguments[2]);
        }
        $name = strtoupper($name);
        $query = $arguments[1];
        if ($name == 'GET') {
            $query = http_build_query($arguments[1]);
        } elseif ($name == 'POST') {
            //curl_setopt($this->ch, CURLOPT_HEADER, 1);
            if (version_compare(PHP_VERSION, '7.0.0', '<')) {
                if(isset($arguments[4])){
                    curl_setopt($this->ch, CURLOPT_SAFE_UPLOAD, $arguments[4]);
                }
            }
            curl_setopt($this->ch, CURLOPT_POST, 1);
        } elseif ($name == 'HEAD') {
            //curl_setopt($this->ch, CURLOPT_HEADER, 1);
            curl_setopt($this->ch, CURLOPT_NOBODY, true);
        } elseif ($name == 'FTP') {
            $localFile = $arguments[4];
            $fp = fopen($localFile, 'r');
            //$arguments[5] == 'email@email.org:password'
            curl_setopt($this->ch, CURLOPT_USERPWD, $arguments[5]);
            curl_setopt($this->ch, CURLOPT_UPLOAD, 1);
            curl_setopt($this->ch, CURLOPT_TIMEOUT, 86400); // 1 Day Timeout
            curl_setopt($this->ch, CURLOPT_INFILE, $fp);
            curl_setopt($this->ch, CURLOPT_BUFFERSIZE, 128);
            curl_setopt($this->ch, CURLOPT_INFILESIZE, filesize($localFile));
        } elseif (in_array($name, $this::METHODS)) {
            curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $name);
        } else {
            throw new Exception('Method does not exist.');
        }

        if ($this->proxy_host && $this->proxy_port) {
            curl_setopt($this->ch, CURLOPT_PROXY, $this->proxy_host . ':' . $this->proxy_port);
        }

        $data = $this->request($arguments[0], $query);
        return ($arguments[3] == 'json') ? json_decode($data) : $data;
    }

    /**
     * Initiate a Curl Resource
     * @return Resource
     */
    private function curlInit()
    {
        $this->ch = curl_init();
        return $this->ch;
    }

    /**
     * Setto i parametri per il proxy
     *
     * @param $proxy_host
     * @param $proxy_port
     */
    public function setProxy($proxy_host, $proxy_port)
    {
        $this->proxy_host = $proxy_host;
        $this->proxy_port = $proxy_port;
    }

    /**
     * Set custom Headers
     * @param Array $headers
     */
    private function setHeader($headers)
    {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
    }

    /**
     *
     * @param Boolean $verify
     */
    private function sslVerify($verify)
    {
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $verify);
    }

    /**
     *
     * @param String $endpoint
     * @param Mixed $params
     * @param String $method
     * @return mixed
     */
    private function request($endpoint, $params)
    {
        if (is_string($params)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
        } else {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        //echo "{$this->url}{$endpoint}";
        curl_setopt($this->ch, CURLOPT_URL, $this->url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_VERBOSE, true);
        $response = curl_exec($this->ch);

        $curl_errno = curl_errno($this->ch);
        $error = [];
        if ($curl_errno) {
            $error = [
                'num' => curl_errno($this->ch),
                'descr' => curl_error($this->ch),
            ];
        }
        $info = curl_getinfo($this->ch);
        curl_close($this->ch);

        $return  = array(
            'result'=> ($curl_errno)?false:true,
            'response' => $response,
            'info' => $info,
            'error' => $error
        );
        return $return;
    }

}
