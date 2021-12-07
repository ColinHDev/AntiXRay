<?php

namespace ColinHDev\AntiXRay;

use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class ResourceManager {

    use SingletonTrait;

    private bool $antiXRayStandard;
    private array $worlds;

    public function __construct() {
        self::$instance = $this;

        if (!is_dir(AntiXRay::getInstance()->getDataFolder())) mkdir(AntiXRay::getInstance()->getDataFolder());

        AntiXRay::getInstance()->saveResource("config.yml");

        $config = new Config(AntiXRay::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        $this->antiXRayStandard = $config->get("antixray.standard", true);
        $this->worlds = $config->get("antixray.worlds", []);
    }

    /**
     * @return bool
     */
    public function getAntiXRayStandard() : bool {
        return $this->antiXRayStandard;
    }

    /**
     * @return string[]
     */
    public function getWorlds() : array {
        return $this->worlds;
    }
}