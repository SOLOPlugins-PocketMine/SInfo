<?php

namespace solo\sinfo\replacer\world;

use pocketmine\level\Level;

class WorldPlayersCountReplacer extends WorldInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{WORLDPLAYERS}") !== false;
  }

  public function replace(string $input, Level $level) : string{
    return str_ireplace("{WORLDPLAYERS}", count($level->getPlayers()), $input);
  }
}
