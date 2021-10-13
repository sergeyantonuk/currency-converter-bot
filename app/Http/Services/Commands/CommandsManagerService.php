<?php

namespace App\Http\Services\Commands;

use Log;
use App\Http\Services\Commands;
use App\Http\Services\TelegramApis\TelegramApiBotService;
use Illuminate\Container\Container;
use App\Http\Services\Commands\CommandException;

class CommandsManagerService
{
    private const commands = ['start', 'list', 'exchange'];
    private $container;
    private $telegramApiBotService;
    private $commandObjects;

    public function __construct(Container $container, TelegramApiBotService $telegramApiBotService)
    {
        $this->container = $container;
        $this->telegramApiBotService = $telegramApiBotService;
        $this->createCommandInstances();
    }

    public function processCommand($chat, $user, string $command, $commandParams = null)
    {
        Log::info('CommandsManagerService->processCommand()->command:' . $command);

        $commandInstance = null;
        foreach ($this->commandObjects as $commandObject) {
            $commandAliases = $commandObject->getAliases();
            if ($commandObject->getName() === $command || in_array($command, $commandAliases)) {
                $commandInstance = $commandObject;
            }
        }

        if (!$commandInstance) {
            throw new CommandException('Command does not exist');
        }

        return $commandInstance->process($chat, $user, $commandParams);
    }

    public function parseCommand($message)
    {
        $regexPattern = '/\/([a-z0-9]+)(\ )*(.*)/';
        $matches = array();
        preg_match($regexPattern, $message, $matches);

        $command = isset($matches[1]) ? $matches[1] : null;
        $command = trim(strtolower($command));

        return ['command' => $command, 'params' => isset($matches[3]) ? $matches[3] : null];

    }

    public function sendBotCommandsToTelegram()
    {
        $preparedCommands = [];
        foreach (self::commands as $command) {
            $commandInstance = $this->createCommandInstance($command);
            $preparedCommands[] = [
                'command' => $command,
                'description' => $commandInstance->getDescription()
            ];
        }

        try {
            $this->telegramApiBotService->setMyCommands($preparedCommands, 'BotCommandScopeChat');

        } catch (\Exception $e) {
            throw new CommandException('Unable to send commands to telegram');
        }
    }

    private function createCommandInstances()
    {
        $this->commandObjects = [];
        foreach (self::commands as $command) {
            $commandInstance = $this->createCommandInstance($command);
            $this->commandObjects[] = $commandInstance;
        }
    }

    private function createCommandInstance($command)
    {
        try {
            $filename = 'Command' . ucfirst($command);
            return $this->container->make('App\Http\Services\Commands\\' . $filename);
        } catch (Exception $e) {
            throw CommandException('Command instance cannot be found');
        }
    }
}