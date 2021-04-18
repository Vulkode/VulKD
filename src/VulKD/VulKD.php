<?php

namespace VulKD;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;
use VulKD\Command\KdCommand;
use VulKD\Command\KillsCommand;
use VulKD\Command\DeathsCommand;
use VulKD\Event\KillEvent;

class VulKD extends PluginBase{

	/** @var VulKD */
	private static $plugin;

	/** @var Config */
	private $deaths;
	private $kills;

	/**
	* @author VulKode
	*/
	public function onEnable() : void{
		self::$plugin = $this;
		$this->saveDefaultConfig();
		$this->deaths = new Config($this->getDataFolder() . "deaths.yml", Config::YAML);
		$this->kills = new Config($this->getDataFolder() . "kills.yml", Config::YAML);
		if ($this->getConfig()->get('enable-commands', true)) {
			$this->getServer()->getCommandMap()->register(VulKD::class, new KdCommand($this));
			$this->getServer()->getCommandMap()->register(VulKD::class, new KillsCommand($this));
			$this->getServer()->getCommandMap()->register(VulKD::class, new DeathsCommand($this));
			$this->getLogger()->info(TF::DARK_PURPLE."The commands were activated.");
		}
		if ($this->getConfig()->get('enable-events', true)) {
			$this->getServer()->getPluginManager()->registerEvents(new KillEvent(), $this);
			$this->getLogger()->info(TF::DARK_PURPLE."The kill event were activated.");

		}
		$this->getLogger()->info(TF::DARK_PURPLE."This plugin has been created by VulKode");
	}

	/**
	 * @return VulKD
	 */
	public static function getInstance() : self{
		return self::$plugin;
	}

	/**
	 * @param  string $player
	 * @return float
	 */
	public function getKD(string $player) : float{
		return round($this->getKills($player) / max($this->getDeaths($player), 0.1), 2);
	}

	/**
	 * @param string $player
	 * @param int    $amount
	 */
	public function addKills(string $player, int $amount = 1) : void{
		$this->setKills($player, $this->getKills($player) + $amount);
	}

	/**
	 * @param string $player
	 * @param int    $amount
	 */
	public function setKills(string $player, int $amount = 0) : void{
		$this->kills->set(strtolower($player),  $amount);
		$this->kills->save();;
	}

	/**
	 * @param  string $player
	 * @return int
	 */
	public function getKills(string $player) : int{
		return $this->kills->get(strtolower($player));
	}

	/**
	 * @param string $player
	 * @param int    $amount
	 */
	public function addDeaths(string $player, int $amount = 1) : void{
		$this->setDeaths($player, $this->getDeaths($player) + $amount);
	}

	/**
	 * @param string $player
	 * @param int    $amount
	 */
	public function setDeaths(string $player, int $amount = 0) : void{
		$this->deaths->set(strtolower($player),  $amount);
		$this->deaths->save();
	}

	/**
	 * @param  string $player
	 * @return int
	 */
	public function getDeaths(string $player) : int{
		return $this->deaths->get(strtolower($player));
	}

	/**
	 * @param  int|null $amount
	 * @return array
	 */
	public function getTopKills(int $amount = null) : array{
		$kills = $this->kills->getAll();
		arsort($kills);
		return array_slice($kills, 0, $amount, true);
	}

	/**
	 * @param  int|null $amount
	 * @return array
	 */
	public function getTopDeaths(int $amount = null) : array{
		$deaths = $this->deaths->getAll();
		arsort($deaths);
		return array_slice($deaths, 0, $amount, true);
	}
}