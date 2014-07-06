<?php
namespace Webit\Notification\Tests\Recipient;

use Webit\Notification\Recipient\RecipientPush;
use Webit\Notification\Recipient\RecipientPushInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class RecipientPushTest
 *
 * @namespace Webit\Notification\Test\Notification
 * @author Daniel Bojdo <daniel@bojdo.eu>
 */
class RecipientPushTest extends \PHPUnit_Framework_TestCase
{
    const RECIPIENT_URL = 'http://test.url';
    const RECIPIENT_METHOD = RecipientPushInterface::METHOD_GET;
    const RECIPIENT_QUERY_PARAM_KEY = 'testQueryParam';
    const RECIPIENT_QUERY_PARAM_VALUE = 'testQueryParamValue';
    const RECIPIENT_PARAM_KEY = 'testParam';
    const RECIPIENT_PARAM_VALUE = 'testQueryParamValue';
    
    /**
     * @test
     */
    public function shouldBeIdentifable()
    {
        $recipient = new RecipientPush(self::RECIPIENT_URL, self::RECIPIENT_METHOD);
        $this->assertNotEmpty($recipient->getIdentity());
    }
    
    /**
     * @test
     */
    public function setInitPropertiesValuesWithConstructorTest()
    {
       $queryParams = new ArrayCollection(array(self::RECIPIENT_QUERY_PARAM_KEY => self::RECIPIENT_QUERY_PARAM_VALUE));
       $params = new ArrayCollection(array(self::RECIPIENT_PARAM_KEY => self::RECIPIENT_PARAM_VALUE));
       
       $recipient = new RecipientPush(self::RECIPIENT_URL, self::RECIPIENT_METHOD, $queryParams, $params);
       
       $this->assertEquals(self::RECIPIENT_URL, $recipient->getUrl());
       $this->assertEquals(self::RECIPIENT_METHOD, $recipient->getMethod());
       $this->assertSame($queryParams, $recipient->getQueryParams());
       $this->assertSame($params, $recipient->getParams());
       
       $this->assertEquals(self::RECIPIENT_QUERY_PARAM_VALUE, $recipient->getQueryParam(self::RECIPIENT_QUERY_PARAM_KEY));
       $this->assertEquals(self::RECIPIENT_PARAM_VALUE, $recipient->getParam(self::RECIPIENT_PARAM_KEY));
    }
    
    /**
     * @test
     */
    public function setPropertiesWithSettersTest()
    {
        $queryParams = new ArrayCollection(array(self::RECIPIENT_QUERY_PARAM_KEY => self::RECIPIENT_QUERY_PARAM_VALUE));
        $params = new ArrayCollection(array(self::RECIPIENT_PARAM_KEY=>self::RECIPIENT_PARAM_VALUE));
        
        $recipient = new RecipientPush();
        $recipient->setUrl(self::RECIPIENT_URL);
        $recipient->setMethod(self::RECIPIENT_METHOD);
        $recipient->setQueryParams($queryParams);
        $recipient->setParams($params);

        $this->assertEquals(self::RECIPIENT_URL, $recipient->getUrl());
        $this->assertEquals(self::RECIPIENT_METHOD, $recipient->getMethod());
        $this->assertSame($queryParams, $recipient->getQueryParams());
        $this->assertSame($params, $recipient->getParams());
        $this->assertEquals(self::RECIPIENT_QUERY_PARAM_VALUE, $recipient->getQueryParam(self::RECIPIENT_QUERY_PARAM_KEY));
        $this->assertEquals(self::RECIPIENT_PARAM_VALUE, $recipient->getParam(self::RECIPIENT_PARAM_KEY));
    }
    
    /**
     * @test
     */
    public function setParamWithSetterTest()
    {
        $recipient = new RecipientPush();
        $recipient->setQueryParam(self::RECIPIENT_QUERY_PARAM_KEY, self::RECIPIENT_QUERY_PARAM_VALUE);
        $recipient->setParam(self::RECIPIENT_PARAM_KEY, self::RECIPIENT_PARAM_VALUE);
        
        $this->assertEquals(self::RECIPIENT_QUERY_PARAM_VALUE, $recipient->getQueryParam(self::RECIPIENT_QUERY_PARAM_KEY));
        $this->assertEquals(self::RECIPIENT_PARAM_VALUE, $recipient->getParam(self::RECIPIENT_PARAM_KEY));
    }
    
    /**
     * @test
     */
    public function paramsGetterShouldAlwaysReturnsCollectionTest()
    {
        $recipient = new RecipientPush();
        
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $recipient->getQueryParams());
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $recipient->getParams());
    }
}