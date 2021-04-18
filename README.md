# VulKD
KD api for servers of minecraft pe (bedrock edition)

## ¿How to usage the API?

- Added Instance:
```PHP
use VulKD\VulKD;
```
- Getting methods:
```PHP
# Get player KD
VulKD::getInstance()->getKills(string $player) : int;
VulKD::getInstance()->getDeaths(string $player) : int;
VulKD::getInstance()->getKD(string $player) : float;

# Get desc top players
VulKD::getInstance()->getTopKills(string $player, int $amount) : array;
VulKD::getInstance()->getTopDeaths(string $player, int $amount) : array;
```
- Setting methods:
```PHP
VulKD::getInstance()->setKills(string $player, int $amount);
VulKD::getInstance()->addKills(string $player, int $amount);
VulKD::getInstance()->setDeaths(string $player, int $amount);
VulKD::getInstance()->addDeaths(string $player, int $amount);
```

### ¿Features?

- Config
```TEXT
# disable command /kills /deaths and /kd
enable-commands: false

# disable events on death
enable-events: true
```

### Credits
This plugin create by **VulKode**.
