<?php

namespace solo\sinfo\replacer\world;

use pocketmine\level\Level;
use solo\sinfo\replacer\Replacer;

abstract class WorldInfoReplacer extends Replacer{

  abstract public function replace(string $input, Level $level) : string;

}
