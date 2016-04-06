<?php

namespace Etxt;

class Etxt {
	/**
     * Etxt API password.
     * @var string
     */
    private $api_pass;

    /**
     * Etxt API access token.
     * @var string
     */
    private $token;

    /**
     * Etxt API generated signature.
     * @var string
     */
    private $sing;

    /**
     * Instance curl.
     * @var Resource
     */
    private $ch;

    const JSON_URL = 'https://www.etxt.ru/api/json/';

    public function __construct($token, $api_pass)
    {
        $this->token = $token;
        $this->api_pass = $api_pass;
        $this->ch = curl_init();
    }

    /**
     * Execute API method with parameters and return result.
     * @param   string $method
     * @param   array $params
     */
    public function api($method, $params = [])
    {
        $this->createSing($method, $params);

        curl_setopt($this->ch, CURLOPT_URL, self::JSON_URL."?token=".$this->token."&method=".$method."&sign=".$this->sing);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($params));
        $json = curl_exec($this->ch);
        return json_decode($json, true);
    }

    /**
     * Generated signature.
     * @param   string $method
     * @param   array $params
     * @return  string
     */
    private function createSing($method, $params = [])
    {
        $params['method'] = $method;
        $params['token'] = $this->token;
        ksort($params);
		$str_params = '';
		foreach ($params as $key => $val)
    		$str_params .= $key.'='.$val;

		$this->sing = md5($str_params.md5($this->api_pass.'api-pass'));
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        curl_close($this->ch);
    }
}