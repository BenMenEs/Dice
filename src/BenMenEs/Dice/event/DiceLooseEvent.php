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
use pocketmine\event\Cancellable;
use pocketmine\Player;

class DiceLooseEvent extends PluginEvent implements Cancellable{
	
	/** @var $handlerList */
	public static $handlerList = null;
	
	/** @var Player */
	private $player;
	
	/** @var int */
	private $loosed;
	
	/** @var string */
	private $message;
	
	public function __construct(Main $main, Player $player, int $loosed, string $message){
		parent::__construct($main);
		$this->player = $player;
		$this->loosed = $loosed;
		$this->message = $message;
	}
	
	public function getPlayer() : ?Player{
		return $this->player;
	}
	
	public function getLoosed() : int{
		return $this->loosed;
	}
	
	public function getLooseMessage() : string{
		return $this->message;
	}
	
	public function setLoosed(int $loosed) : void{
		$this->loosed = $loosed;
	}
	
	public function setLooseMessage(string $message) : void{
		$this->message = $message;
	}
}