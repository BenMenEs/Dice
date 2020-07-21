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

namespace BenMenEs\Dice\event;

use BenMenEs\Dice\Main;
use pocketmine\event\plugin\PluginEvent;
use pocketmine\Player;

class DiceErrorEvent extends PluginEvent{
	
	/** @var $handlerList */
	public static $handlerList = null;
	
	/** @var Player */
	private $player;
	
	/** @var string */
	private $message;
	
	/**
	 * @param Player $player
	 * @param string $message
	 */
	public function __construct(Main $main, Player $player, string $message){
		parent::__construct($main);
		$this->player = $player;
		$this->message = $message;
	}
	
	/**
	 * @return Player
	 */
	public function getPlayer() : ?Player{
		return $this->player;
	}
	
	/**
	 * @return string
	 */
	public function getErrorMessage() : string{
		return $this->message;
	}
	
	/**
	 * @param string $message
	 * @return void
	 */
	public function setErrorMessage(string $message) : void{
		$this->message = $message;
	}
}