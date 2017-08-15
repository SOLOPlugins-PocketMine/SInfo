<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;

class PlayerNameReplacer extends PlayerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{NAME}") !== false;
  }

  public function replace(string $input, Player $player) : string{
    return str_ireplace("{NAME}", $player->getDisplayName(), $input);
  }
}
