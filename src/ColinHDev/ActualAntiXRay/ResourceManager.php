<?php

namespace ColinHDev\ActualAntiXRay;

use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use function is_array;
use function is_string;

class ResourceManager {
    use SingletonTrait;

    private bool $default;
    /** @var array<string, true> */
    private array $worlds = [];

    public function __construct() {
        ActualAntiXRay::getInstance()->saveResource("config.yml");
        $config = new Config(ActualAntiXRay::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        $mode = $config->get("mode", "blacklist");
        if ($mode === "blacklist") {
            $this->default = true;
        } else {
            $this->default = false;
        }
        $worlds = $config->get("worlds", []);
        if (is_array($worlds)) {
            foreach($worlds as $worldName) {
                if (is_string($worldName)) {
                    $this->worlds[$worldName] = true;
                }
            }
        }
    }

    public function isEnabledForWorld(string $worldName) : bool {
        return
            ($this->default && !isset($this->worlds[$worldName])) ||
            (!$this->default && isset($this->worlds[$worldName]));
    }
}