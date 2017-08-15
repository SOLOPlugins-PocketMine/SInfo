<?php

namespace solo\sinfo\replacer\player;

use pocketmine\Player;
use solo\sinfo\replacer\Replacer;

abstract class PlayerInfoReplacer extends Replacer{

  abstract public function replace(string $input, Player $player) : string;

}
