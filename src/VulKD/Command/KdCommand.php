<?php

namespace VulKD\Command;

use VulKD\VulKD;
use pocketmine\Player;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TF;

class KdCommand extends PluginCommand{

	/**
	 * @param VulKD $plugin
	 */
	public function __construct(VulKD $plugin){
		parent::__construct("kd", $plugin);
		$this->setDescription('Your Stats');
		$this->setUsage("/kd");
		$this->setAliases(['ratio']);
	}

	/**
	 * @param  CommandSender $sender
	 * @param  string        $commandLabel
	 * @param  array         $cmds
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $cmds) {
		if (empty($cmds)) {
			$sender->sendMessage(TF::GRAY . '/--=] ' . TF::YELLOW . 'KD Stats' . TF::GRAY . ' [=--\ ');
			$sender->sendMessage(TF::GOLD . ' Kills: ' . TF::DARK_PURPLE . $this->getPlugin()->getKills($sender->getName()));
			$sender->sendMessage(TF::GOLD . ' Deaths: ' . TF::DARK_PURPLE . $this->getPlugin()->getDeaths($sender->getName()));
			$sender->sendMessage(TF::GOLD . ' KD: ' . TF::DARK_PURPLE . $this->getPlugin()->getKD($sender->getName()));
			$sender->sendMessage(TF::GRAY . '\--=] ------------ [=--/');

			return true;
		}

		if (!$sender->hasPermission('kd.command')) {
			$sender->sendMessage(TF::RED . "You do not have permission to see the statistics of the other players.");
			return true;
		}

		$player = implode(" ", $cmds);
		if (($target = $sender->getServer()->getPlayer($player)) != null) {
			$player = $target->getName();
		}

		$sender->sendMessage(TF::GRAY . '/--=] ' . TF::YELLOW . 'KD Stats' . TF::GRAY . ' [=--\ ');
		$sender->sendMessage(TF::GOLD . ' Kills: ' . TF::DARK_PURPLE . $this->getPlugin()->getKills($player));
		$sender->sendMessage(TF::GOLD . ' Deaths: ' . TF::DARK_PURPLE . $this->getPlugin()->getDeaths($player));
		$sender->sendMessage(TF::GOLD . ' KD: ' . TF::DARK_PURPLE . $this->getPlugin()->getKD($player));
		$sender->sendMessage(TF::GRAY . '\--=] ------------ [=--/ ');
		return true;
	}
}