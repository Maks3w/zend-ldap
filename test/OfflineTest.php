<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Ldap;

use Zend\Config;
use Zend\Ldap;
use Zend\Ldap\Exception;

/**
 * @group      Zend_Ldap
 */
class OfflineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Zend\Ldap\Ldap instance
     *
     * @var Ldap\Ldap
     */
    protected $ldap = null;

    /**
     * Setup operations run prior to each test method:
     *
     * * Creates an instance of Zend\Ldap\Ldap
     *
     * @return void
     */
    public function setUp()
    {
        if (!extension_loaded('ldap')) {
            $this->markTestSkipped('LDAP is not enabled');
        }
        $this->ldap = new Ldap\Ldap();
    }

    /**
     * @return void
     */
    public function testInvalidOptionResultsInException()
    {
        $optionName = 'invalid';
        try {
            $this->ldap->setOptions([$optionName => 'irrelevant']);
            $this->fail('Expected Zend\Ldap\Exception\LdapException not thrown');
        } catch (Exception\LdapException $e) {
            $this->assertEquals("Unknown Zend\Ldap\Ldap option: $optionName", $e->getMessage());
        }
    }

    public function testException()
    {
        $e = new Exception\LdapException(null, '', 0);
        $this->assertEquals('no exception message', $e->getMessage());
        $this->assertEquals(0, $e->getCode());

        $e = new Exception\LdapException(null, '', 15);
        $this->assertEquals('0xf: no exception message', $e->getMessage());
        $this->assertEquals(15, $e->getCode());
    }

    public function testOptionsGetter()
    {
        $options = [
            'host'     => getenv('TESTS_ZEND_LDAP_HOST'),
            'username' => getenv('TESTS_ZEND_LDAP_USERNAME'),
            'password' => getenv('TESTS_ZEND_LDAP_PASSWORD'),
            'baseDn'   => getenv('TESTS_ZEND_LDAP_BASE_DN'),
        ];
        $ldap    = new Ldap\Ldap($options);
        $this->assertEquals([
                                 'host'                   => getenv('TESTS_ZEND_LDAP_HOST'),
                                 'port'                   => 0,
                                 'useSsl'                 => false,
                                 'username'               => getenv('TESTS_ZEND_LDAP_USERNAME'),
                                 'password'               => getenv('TESTS_ZEND_LDAP_PASSWORD'),
                                 'bindRequiresDn'         => false,
                                 'baseDn'                 => getenv('TESTS_ZEND_LDAP_BASE_DN'),
                                 'accountCanonicalForm'   => null,
                                 'accountDomainName'      => null,
                                 'accountDomainNameShort' => null,
                                 'accountFilterFormat'    => null,
                                 'allowEmptyPassword'     => false,
                                 'useStartTls'            => false,
                                 'optReferrals'           => false,
                                 'tryUsernameSplit'       => true,
                                 'networkTimeout'         => null,
                            ], $ldap->getOptions()
        );
    }

    public function testConfigObject()
    {
        $config = new Config\Config([
                                         'host'     => getenv('TESTS_ZEND_LDAP_HOST'),
                                         'username' => getenv('TESTS_ZEND_LDAP_USERNAME'),
                                         'password' => getenv('TESTS_ZEND_LDAP_PASSWORD'),
                                         'baseDn'   => getenv('TESTS_ZEND_LDAP_BASE_DN'),
                                    ]);
        $ldap   = new Ldap\Ldap($config);
        $this->assertEquals([
                                 'host'                   => getenv('TESTS_ZEND_LDAP_HOST'),
                                 'port'                   => 0,
                                 'useSsl'                 => false,
                                 'username'               => getenv('TESTS_ZEND_LDAP_USERNAME'),
                                 'password'               => getenv('TESTS_ZEND_LDAP_PASSWORD'),
                                 'bindRequiresDn'         => false,
                                 'baseDn'                 => getenv('TESTS_ZEND_LDAP_BASE_DN'),
                                 'accountCanonicalForm'   => null,
                                 'accountDomainName'      => null,
                                 'accountDomainNameShort' => null,
                                 'accountFilterFormat'    => null,
                                 'allowEmptyPassword'     => false,
                                 'useStartTls'            => false,
                                 'optReferrals'           => false,
                                 'tryUsernameSplit'       => true,
                                 'networkTimeout'         => null,
                            ], $ldap->getOptions()
        );
    }
}