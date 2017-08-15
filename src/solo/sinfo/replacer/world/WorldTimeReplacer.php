<?php

namespace solo\sinfo\replacer\world;

use pocketmine\level\Level;
use solo\sinfo\SInfo;

class WorldTimeReplacer extends WorldInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{WORLDTIME}") !== false;
  }

  public function replace(string $input, Level $level) : string{
    return str_ireplace("{WORLDTIME}", SInfo::getTimeString($level->getTime()), $input);
  }
}
