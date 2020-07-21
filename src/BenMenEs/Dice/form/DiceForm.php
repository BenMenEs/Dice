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

namespace BenMenEs\Dice\form;

use BenMenEs\Dice\Main;
use pocketmine\Player;
use jojoe77777\FormAPI\CustomForm;

class DiceForm{

    /** @var Main */
    private $main;
    
    /** @var array */
    private $chance = ["5", "10", "15", "20"];

    /**
     * @param Main $main
     * @param Player $player
     */
    public function __construct(Main $main, Player $player){
        $this->main = $main;

        $form = new CustomForm(function(Player $player, array $data = null){
            $m = $this->main->getMessage();
            if($data == null){
                return;
            }
            if(empty($data[1])){
                $player->sendMessage($m['df-e-i']);
                return;
            }
            if(!is_numeric($data[1])){
                $player->sendMessage($m['df-n-i']);
                return;
            }
            if($data[1] < $m['min-bet']){
                $player->sendMessage(str_replace("{MIN}", $m['min-bet'], $m['df-mb']));
                return;
            }
            if($data[1] > $m['max-bet']){
                $player->sendMessage(str_replace("{MAX}", $m['max-bet'], $m['df-mmb']));
                return;
            }
            $s = 2.0;
            switch($this->chance[$data[2]]){
                case "5":
                    $s = 2.0;
                break;
                case "10":
                    $s = 1.75;
                break;
                case "15":
                    $s = 1.50;
                break;
                case "20":
                    $s = 1.25;
                break;
            }
            $win = $data[1] * $s;
            if($this->main->eco->myMoney($player->getName()) < $data[1]){
                $player->sendMessage(str_replace(["{BET}", "{MONEY}"], [$data[1], $this->main->api->myMoney($player->getName())], $m['df-m']));
                return;
            }
            if(mt_rand(1, 100) <= $this->chance[$data[2]]){
                $this->main->callEvent("WinEvent", $player, $data[1], $win);
                return;
            }
            $this->main->callEvent("LooseEvent", $player, $data[1]);
            return;
        });
        $form->setTitle($main->getMessage()['df-title']);
        $form->addLabel($main->getMessage()['df-l-description']);
        $form->addInput($main->getMessage()['df-i-description'], $main->getMessage()['df-i--description']);
        $form->addDropdown($main->getMessage()['df-s-description'], $this->chance);
        $form->sendToPlayer($player);
    }
}
