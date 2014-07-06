<?php
namespace Webit\Notification\Recipient;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface RecipientPushInterface
 * 
 * @namespace Webit\Notification\Recipient
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
interface RecipientPushInterface extends RecipientInterface
{
    
    /**
     * 
     * Method const
     */
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PATCH = 'PATCH';
    
    /**
     * 
     * @return string
     */
    public function getUrl();
    
    /**
     * 
     * @param string $url
     */
    public function setUrl($url);
    
    /**
     * 
     * @return string
     */
    public function getMethod();
    
    /**
     * 
     * @param string $method
     */
    public function setMethod($method);
    
    /**
     * 
     * @return ArrayCollection
     */
    public function getQueryParams();
    
    /**
     * 
     * @param ArrayCollection $queryParams
     */
    public function setQueryParams(ArrayCollection $queryParams);
    
    /**
     * 
     * @param string $queryParam
     */
    public function getQueryParam($queryParam);
    
    /**
     * 
     * @param string $queryParam
     * @param string $value
     */
    public function setQueryParam($queryParam, $value);
    
    /**
     * @return array
     */
    public function getParams();
    
    /**
     * 
     * @param ArrayCollection $params
     */
    public function setParams(ArrayCollection $params);
    
    /**
     * 
     * @param string $param
     */
    public function getParam($param);
    
    /**
     * 
     * @param string $param
     * @param string $value
     */
    public function setParam($param, $value);
}
