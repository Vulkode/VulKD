<?php

namespace VulKD\Event;

use VulKD\VulKD;
use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerDeathEvent;

class KillEvent implements Listener{

	/**
	* @param PlayerDeathEvent $event
	*/
	public function death(PlayerDeathEvent $event) : void{
		$player = $event->getPlayer();
		$deathCause = $player->getLastDamageCause();
		VulKD::getInstance()->addDeaths($player->getName());
		if ($deathCause instanceof EntityDamageByEntityEvent) {
			if (($killer = $deathCause->getDamager()) instanceof Player) {
				VulKD::getInstance()->addKills($killer->getName());
			}
		}
	}
}