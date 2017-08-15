<?php

namespace solo\sinfo\replacer\server;

use pocketmine\Server;
use solo\sinfo\replacer\Replacer;

abstract class ServerInfoReplacer extends Replacer{

  abstract public function replace(string $input, Server $server) : string;

}
