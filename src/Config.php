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
    protected   $folder = null;
    protected   $subfolder = "/app/config";

    public function __construct(string $folder = null)
    {
        // @note if we remove ERDIKO_ROOT it will be more portable
        $this->folder = $folder ?? ERDIKO_ROOT;
    }

    public function getContext(): string
    {
        return getenv('ERDIKO_CONTEXT');
    }

    public function setContext(string $context)
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
    public function getConfig(string $name = 'application', string $context = null): array
    {
        $context = $context ?? getenv('ERDIKO_CONTEXT');
        $filename = $this->folder.$this->subfolder."/{$context}/{$name}.json";
        return $this->getConfigFile($filename);
    }

    /**
     * Read JSON config file and return array
     *
     * @param string $file
     * @return array $config
     */
    public function getConfigFile($file): array
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