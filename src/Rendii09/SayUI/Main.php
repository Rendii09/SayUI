<?php

namespace Rendii09\SayUI;

/*
 *
 * SayUI, a plugin for PocketMine-MP
 * Copyright (c) 2019 Rendii09  <rendiansyahbagus@gmail.com>
 *
 * Poggit: https://poggit.pmmp.io/ci/Rendii09/
 * Github: https://github.com/Rendii09
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * SayUI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 *
 */

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\utils\TextFormat as C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

use jojoe77777\FormAPI;

class Main extends PluginBase implements Listener {
    
	public function onEnable(){
          $this->getLogger()->info(C::GREEN . "Enable!");
          
          @mkdir($this->getDataFolder());
          $this->saveDefaultConfig();
          $this->getResource("config.yml");
    }

	public function onDisable(){
          $this->getLogger()->info(C::RED . "Disable!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
           switch($command->getName()){
                   case "sui":
                          if(!($sender instanceof Player)){
                                 $sender->sendMessage($this->getConfig()->get("use_in_game"));
                                   return true;
                   }
                         if(!$sender->hasPermission("sui.cmd")){
                   return true;
          }
          $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
          $form = $api->createCustomForm(function(Player $sender, array $data){
              $result = $data[0];
                if($data !== null){
				     $command = "say " . $data[1];
                     $this->getServer()->getCommandMap()->dispatch($sender, $command);
              }
         });
         $form->setTitle($this->getConfig()->get("sui.title"));
         $form->addLabel($this->getConfig()->get("sui.label"));
         $form->addInput($this->getConfig()->get("sui.input"));
         $form->sendToPlayer($sender);
         }
         return true;
    }
}
