<?php

namespace solo\sinfo\replacer\server;

use pocketmine\Server;

class ServerAverageTPSReplacer extends ServerInfoReplacer{

  public function canReplace(string $input) : bool{
    return stripos($input, "{AVERAGETPS}") !== false;
  }

  public function replace(string $input, Server $server) : string{
    return str_ireplace("{AVERAGETPS}", $server->getTicksPerSecondAverage(), $input);
  }
}
