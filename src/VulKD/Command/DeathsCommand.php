<?php

namespace VulKD\Command;

use VulKD\VulKD;
use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TF;

class DeathsCommand extends PluginCommand{

	/**
	 * @param VulKD $plugin
	 */
	public function __construct(VulKD $plugin){
		parent::__construct("deaths", $plugin);
		$this->setDescription('Your deaths');
		$this->setUsage("/deaths");
	}

	/**
	 * @param  CommandSender $sender
	 * @param  string        $commandLabel
	 * @param  array         $cmds
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $cmds) {
		if (empty($cmds)) {
			$sender->sendMessage(TF::GOLD . 'Your deaths: ' . TF::DARK_PURPLE . $this->getPlugin()->getDeaths($sender->getName()));
			return true;
		}

		if (!$sender->hasPermission('deaths.command')) {
			$sender->sendMessage(TF::RED . "You do not have permission to see the statistics of the other players.");
			return true;
		}

		$player = implode(" ", $cmds);
		if (($target = $sender->getServer()->getPlayer($player)) instanceof Player) {
			$player = $target->getName();
		}

		$sender->sendMessage(TF::GOLD . ucwords($player) . ' deaths: ' . TF::DARK_PURPLE . $this->getPlugin()->getDeaths($player));
		return true;
	}
}