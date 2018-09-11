<?php
declare(strict_types=1);

namespace projects\app;

class validatorGetAndPost
{
    /*/**
     * type of http request
     * @var string
     *
    private $requestType;*/
    
    /**
     * array of the request params
     * @var array
     */
    private $requestParams = [];

    /**
     * array of cookies
     * @var array
     */
    private $cookie = [];

    /**
     * validatorGetAndPost constructor
     * @param array $request
     * @param $cookie
     */
    public function __construct( array $request, array $cookie)
    {
        $this->handleRequest($request)
             ->handleCookie(isset($_COOKIE) ? $_COOKIE : null);
    }

    /**
     * @param string $value
     * @return string
     */
    private function delGaps(string $value)
    {
        if (!empty($value)) {
            return trim($value);
        } else {
            return '';
        }
    }

    /**
     * remove html tags
     * @param string $value
     * @return null|string
     */
    private function delTags(string $value)
    {
        if (!empty($value)) {
            return strip_tags($value);
        } else {
            return '';
        }
    }

    /**
     * @param array $request
     * @return $this
     */
    private function handleRequest(array $request)
    {
        foreach ($request as $key => $value) {
            $this->requestParams[$key] = $this->delGaps($this->delTags($value));
        }
        return $this;
    }

    /**
     * @param $cookie
     * @return $this
     */
    private function handleCookie($cookie)
    {
        foreach ($cookie as $key => $value) {
            $this->cookie[$key] = $this->delGaps($this->delTags($value));
        }
        return $this;
    }

    /**
     * get all of params
     * @return array
     */
    public function getParams()
    {
        $params = [];
        foreach ($this->requestParams as $key => $value) {
            $params[$key] = $value;
        }

        foreach ($this->cookie as $key => $value) {
            $params[$key] = $value;
        }
        return $params;
    }

    /**
     * get only 1 param
     * @param $param
     * @return mixed|null
     */
    public function getParam($param)
    {
        $params = $this->getParams();
        foreach ($params as $key => $value) {
            if ($key == $param) {
                return $params[$key];
            }
        }
        return null;
    }
}