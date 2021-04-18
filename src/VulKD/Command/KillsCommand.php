<?php

namespace VulKD\Command;

use VulKD\VulKD;
use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TF;

class KillsCommand extends PluginCommand{

	/**
	 * @param VulKD $plugin
	 */
	public function __construct(VulKD $plugin){
		parent::__construct("kills", $plugin);
		$this->setDescription('Your kills');
		$this->setUsage("/kills");
	}

	/**
	 * @param  CommandSender $sender
	 * @param  string        $commandLabel
	 * @param  array         $cmds
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $cmds) {
		if (empty($cmds)) {
			$sender->sendMessage(TF::GOLD . 'Your kills: ' . TF::DARK_PURPLE . $this->getPlugin()->getKills($sender->getName()));
			return true;
		}

		if (!$sender->hasPermission('kills.command')) {
			$sender->sendMessage(TF::RED . "You do not have permission to see the statistics of the other players.");
			return true;
		}

		$player = implode(" ", $cmds);
		if (($target = $sender->getServer()->getPlayer($player)) instanceof Player) {
			$player = $target->getName();
		}

		$sender->sendMessage(TF::GOLD . ucwords($player) . ' kills: ' . TF::DARK_PURPLE . $this->getPlugin()->getKills($player));
		return true;
	}
}