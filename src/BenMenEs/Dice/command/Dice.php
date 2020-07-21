<?php

namespace BenMenEs\Dice\command;

use BenMenEs\Dice\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class Dice extends Command{

	/** @var Main */
	private $main;

	/**
	 * @param Main $main
	 */
	public function __construct(Main $main){
		parent::__construct("dice", "Dice");
		$this->setPermission("dice.cmd");
		$this->main = $main;
	}

	/**
	 * @param CommandSender $sender
	 * @param string $label
	 * @param array $args
	 * @return bool|true|false
	 */
	public function execute(CommandSender $sender, string $label, array $args) : bool{
		if(!$this->testPermission($sender)){
			return false;
		}
		if(!$sender instanceof Player){
			$sender->sendMessage($this->api->getMessage()["console"]);
			return false;
		}
		if($this->main->timerExists($sender->getName())){
			if(!$this->main->checkTimer($sender->getName())){
				$sender->sendMessage($this->main->getMessage()['timer-false']);
				return false;
			} else {
				$this->main->removeTimer($sender->getName());
			}
		}
		$this->main->openForm($sender);
		return true;
	}
}
