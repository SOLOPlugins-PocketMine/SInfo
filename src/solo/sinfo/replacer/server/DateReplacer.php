<?php

namespace solo\sinfo\replacer\server;

use pocketmine\Server;

class DateReplacer extends ServerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{DATE}") !== false;
  }

  public function replace(string $input, Server $server) : string{
    return str_ireplace("{DATE}", date("m월 d일"), $input);
  }
}
