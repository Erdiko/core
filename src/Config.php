<?php
/**
 * Erdiko Config
 *
 * Read from json configs
 *
 * @package     erdiko
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko;


class Config
{
    /**
     *
     */
    public static function getContext(): string
    {
        return getenv('ERDIKO_CONTEXT') ?? 'default';
    }

    /**
     *
     */
    public static function setContext(string $context)
    {
        putenv("ERDIKO_CONTEXT={$context}");
    }

    /**
     * Get configuration
     *
     * @param string $name
     * @param string $context
     * @return array $config
     */
    public static function get(string $name = 'application', string $context = null): array
    {
        $context = $context ?? static::getContext();

        // @note if we remove ERDIKO_ROOT it will be more portable
        $subfolder = "config";
        $filename = ERDIKO_ROOT."/contexts/{$context}/{$subfolder}/{$name}.json";

        return static::getConfigFile($filename);
    }

    /**
     * Read JSON config file and return array
     *
     * @param string $file
     * @return array $config
     */
    public static function getConfigFile($file): array
    {
        $file = addslashes($file);
        if (is_file($file)) {
            $data = str_replace("\\", "\\\\", file_get_contents($file));
            $json = json_decode($data, true);

            if (empty($json)) {
                throw new \Exception("Config file has a json parse error, $file");
            }

        } else {
            throw new \Exception("Config file not found, $file");
        }
        
        return $json;
    }
}