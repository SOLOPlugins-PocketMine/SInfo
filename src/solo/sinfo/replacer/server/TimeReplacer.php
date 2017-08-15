<?php

namespace solo\sinfo\replacer\server;

use pocketmine\Server;

class TimeReplacer extends ServerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{TIME}") !== false;
  }

  public function replace(string $input, Server $server) : string{
    return str_ireplace("{TIME}", date("g:i a"), $input);
  }
}
