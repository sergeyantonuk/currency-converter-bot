<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\Commands\CommandsManagerService;

class SendBotCommandsToTelegram extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot-commands-to-telegram:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send bot command to telegram';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(CommandsManagerService $commandsManagerService)
    {
        $commandsManagerService->sendBotCommandsToTelegram();
    }
}
