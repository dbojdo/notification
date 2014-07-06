<?php
namespace Webit\Notification\Recipient;

use Webit\Notification\Recipient\RecipientPushInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @author dbojdo
 *        
 */
class RecipientPush implements RecipientPushInterface
{
    /**
     * 
     * @var string
     */
    private $url;
    
    /**
     * 
     * @var string
     */
    private $method;
    
    /**
     * 
     * @var ArrayCollection
     */
    private $queryParams;
    
    /**
     * 
     * @var ArrayCollection
     */
    private $params;
    
    public function __construct($url = null, $method = self::METHOD_POST, ArrayCollection $queryParams = null, ArrayCollection $params = null)
    {
        $this->setUrl($url);
        $this->setMethod($method);
        if ($queryParams) {
            $this->setQueryParams($queryParams);
        }
        
        if ($params) {
            $this->setParams($params);
        }
    }
    
    /**
     * @return string
     */
    public function getIdentity($media = null)
    {
        $data = sprintf('%s:%s', $this->url, $this->method);
        
        return hash('md5', $data);
    }
    
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * @param string $method
     * @return void
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return ArrayCollection
     */
    public function getQueryParams()
    {
        if ($this->queryParams == null) {
            $this->queryParams = new ArrayCollection();
        }
    
        return $this->queryParams;
    }
    
    /**
     * @param ArrayCollection $queryParams
     */
    public function setQueryParams(ArrayCollection $queryParams)
    {
        $this->queryParams = $queryParams;
    }
    
    /**
     * @param string $queryParam
     * @param string $value
     * @return void
     */
    public function setQueryParam($queryParam, $value)
    {
        $this->getQueryParams()->set($queryParam, $value);
    }
    
    /**
     * @param string $queryParam
     * @return string
     */
    public function getQueryParam($queryParam)
    {
        return $this->getQueryParams()->get($queryParam);
    }
    
    /**
     * @param string $param
     * @return string
     */
    public function getParam($param)
    {
        return $this->getParams()->get($param);
    }
    
    /**
     * @param string $param
     * @param string $value
     */
    public function setParam($param, $value)
    {
        $this->getParams()->set($param, $value);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getParams()
    {
        if ($this->params == null) {
            $this->params = new ArrayCollection();
        }
        
        return $this->params;
    }
    
    /**
     * @param ArrayCollection $params
     * @return void
     */
    public function setParams(ArrayCollection $params)
    {
        $this->params = $params;
    }
}