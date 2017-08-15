<?php

namespace solo\sinfo\replacer\world;

use pocketmine\level\Level;

class WorldNameReplacer extends WorldInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{WORLD}") !== false;
  }

  public function replace(string $input, Level $level) : string{
    return str_ireplace("{WORLD}", $level->getFolderName(), $input);
  }
}
