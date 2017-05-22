<?php
/**
 * Created by PhpStorm.
 * Date: 2017/5/22
 * Time: 20:33
 *
 * @author limi
 */

namespace Zeroleaf\Bati\Config;

use Symfony\Component\Yaml\Yaml as YamlComponent;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Class Yaml.
 *
 * @package Zeroleaf\Bati\Config
 */
class Yaml implements Repository
{
    /**
     * @var array
     */
    protected $config;

    /**
     * Yaml constructor.
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * 初始化.
     */
    protected function initialize()
    {
        try {
            $this->config = YamlComponent::parse(file_get_contents($this->getConfigPath()));
        } catch (ParseException $e) {
            sprintf("解析 Yaml 出错: %s", $e->getMessage());
            exit(1);
        }
    }

    /**
     * @return string|null
     */
    protected function getConfigPath()
    {
        $cwd       = rtrim(getcwd(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $configDir = $cwd . 'config' . DIRECTORY_SEPARATOR;
        $paths     = [
            $cwd . 'bati.yml',
            $configDir . 'bati.yml',
            __DIR__ . '/../../config/bati.yml',
        ];

        foreach ($paths as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * @return static
     */
    public static function instance()
    {
        return new static();
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_has($this->config, $key);
    }

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_get($this->config, $key, $default);
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->config;
    }

}