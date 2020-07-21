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

class DiceWinEvent extends PluginEvent implements Cancellable{
	
	/** @var $handlerList */
	public static $handlerList = null;
	
	/** @var Player */
	private $player;
	
	/** @var int */
	private $bet;
	
	/** @var float */
	private $winned;
	
	/** @var string */
	private $message;
	
	public function __construct(Main $main, Player $player, int $bet, float $winned, string $message){
		parent::__construct($main);
		$this->player = $player;
		$this->bet = $bet;
		$this->winned = $winned;
		$this->message = $message;
	}
	
	/**
	 * @return Player
	 */
	public function getPlayer() : ?Player{
		return $this->player;
	}
	
	/**
	 * @return int
	 */
	public function getBet() : int{
		return $this->bet;
	}
	
	/**
	 * @return int
	 */
	public function getWinned() : float{
		return $this->winned;
	}
	
	/**
	 * @return string
	 */
	public function getWinMessage() : string{
		return $this->message;
	}
	
	/**
	 * @param float $winned
	 * @return void
	 */
	public function setWinned(float $winned) : void{
		$this->winned = $winned;
	}
	
	/**
	 * @param string $message
	 * @return void
	 */
	public function setWinMessage(string $message) : void{
		$this->message = $message;
	}
}