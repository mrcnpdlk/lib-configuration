<?php
/**
 * Created by Marcin.
 * Date: 30.03.2019
 * Time: 20:05
 */

namespace Mrcnpdlk\Lib;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class ConfigurationOptionsAbstract
 *
 * @package Mrcnpdlk\Lib
 */
abstract class ConfigurationOptionsAbstract
{
    /** @noinspection PhpUndefinedClassInspection */
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * ConfigurationOptions constructor.
     *
     * @param array $config
     *
     * @throws \Mrcnpdlk\Lib\ConfigurationException
     */
    public function __construct(array $config = [])
    {
        /* @noinspection PhpUndefinedClassInspection */
        $this->logger = new NullLogger();

        foreach ($config as $key => $value) {
            $funName = sprintf('set%s', ucfirst($key));
            if (method_exists($this, $funName)) {
                $this->$funName($value);
            } elseif (property_exists($this, $key)) {
                $this->{$key} = $value;
            } else {
                throw new ConfigurationException(sprintf('Property "%s" not defined in Config class "%s"', $key, __CLASS__));
            }
        }
    }

    /** @noinspection PhpUndefinedClassInspection */

    /**
     * @return \Psr\Log\LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }
}
