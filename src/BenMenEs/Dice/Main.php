<?php

/*
 *
 *
 * ╔══╗─╔═══╗╔═╗─╔╗╔═╗╔═╗╔═══╗╔═╗─╔╗╔═══╗╔═══╗
 * ║╔╗║─║╔══╝║║╚╗║║║║╚╝║║║╔══╝║║╚╗║║║╔══╝║╔═╗║
 * ║╚╝╚╗║╚══╗║╔╗╚╝║║╔╗╔╗║║╚══╗║╔╗╚╝║║╚══╗║╚══╗
 * ║╔═╗║║╔══╝║║╚╗║║║║║║║║║╔══╝║║╚╗║║║╔══╝╚══╗║
 * ║╚═╝║║╚══╗║║─║║║║║║║║║║╚══╗║║─║║║║╚══╗║╚═╝║
 * ╚═══╝╚═══╝╚╝─╚═╝╚╝╚╝╚╝╚═══╝╚╝─╚═╝╚═══╝╚═══╝
 *
 * @author BenMenEs
 * @link https://github.com/benmenes
 *
 *
*/

namespace BenMenEs\Dice;

use BenMenEs\Dice\event\DiceWinEvent;
use BenMenEs\Dice\event\DiceLooseEvent;
use BenMenEs\Dice\event\DiceErrorEvent;
use BenMenEs\Dice\form\DiceForm;
use BenMenEs\Dice\command\Dice;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\Player;

class Main extends PluginBase{

	/** @var Config */
	protected $config;

	/** @var Main */
	private static $instance;

	/** @var Config */
	private $timer;

	/** @var EconomyAPI */
	public $eco;

	/**
	 * @return void
	 */
	public function onLoad() : void{
		self::$instance = $this;
		$this->getServer()->getCommandMap()->register("dice", new Dice($this));
	}

	/**
	 * @return void
	 */
	public function onEnable() : void{
		$this->timer = new Config($this->getDataFolder() . "timer.json", Config::JSON);
		$this->saveDefaultConfig();
		$this->config = $this->getConfig()->getAll();
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
	}

	/**
	 * @return array
	 */
	public function getMessage() : array{
		return $this->config;
	}

	/**
	 * @param string $form = "main"
	 * @param Player $player
	 * @return CustomForm|null
	 */
	public function openForm(Player $player){
		return new DiceForm($this, $player);
	}

	/**
	 * @return Main
	 */
	public static function getInstance() : ?Main{
		return self::$instance;
	}

	/**
	 * @param $player
	 * @return bool|true|false
	 */
	public function timerExists($player) : bool{
		return $this->timer->exists(strtolower($player));
	}

	/**
	 * @param $player
	 * @return void
	 */
	public function startTimer($player) : void{
		$this->timer->set(strtolower($player), time() + 60 * 60 * 24);
		$this->timer->save();
	}

	/**
	 * @param $player
	 * @return bool|true|false
	 */
	public function checkTimer($player) : bool{
		return $this->timer->get(strtolower($player)) <= time();
	}

	/**
	 * @param $player
	 * @return void
	 */
	public function reloadTimer($player) : void{
		$this->startTimer($player);
	}

	/**
	 * @param $player
	 * @return void
	 */
	public function removeTimer($player) : void{
		$this->timer->remove(strtolower($player));
		$this->timer->save();
	}

	/**
	 * @param string $event = "WinEvent"
	 * @param Player $player
	 * @param int $bet = 0
	 * @param float $winned = 0
	 * @return void
	 */
	public function callEvent(string $event = "WinEvent", Player $player, int $bet = 0, float $winned = 0) : void{
		$eco = $this->eco;
		switch($event){
			case "WinEvent":
			    $this->getServer()->getPluginManager()->callEvent($ev = new DiceWinEvent($this, $player, $bet, $winned, str_replace(["{BET}", "{WINNED}"], [$bet, $winned], $this->config["winned"])));
			    if($ev->isCancelled()){
				    return;
				}
				$player->sendMessage($ev->getWinMessage());
				$eco->addMoney($player->getName(), $ev->getWinned());
				$this->startTimer($player->getName());
			break;
			case "LooseEvent":
			    $this->getServer()->getPluginManager()->callEvent($ev = new DiceLooseEvent($this, $player, $bet, str_replace("{LOOSED}", $bet, $this->config["loosed"])));
			    if($ev->isCancelled()){
				    return;
				}
				$player->sendMessage($ev->getLooseMessage());
				$eco->reduceMoney($player->getName(), $ev->getLoosed());
			break;
			case "ErrorEvent":
			    $this->getServer()->getPluginManager()->callEvent($ev = new DiceErrorEvent($this, $player, $this->config["error"]));
			    $player->sendMessage($ev->getErrorMessage());
			break;
		}
	}
}
