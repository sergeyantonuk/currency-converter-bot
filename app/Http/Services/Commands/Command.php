<?php

namespace App\Http\Services\Commands;

abstract class Command
{

    protected $name;
    protected $description;
    protected $aliases = [];
    protected $params;
    protected $chatId;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAliases()
    {
        return $this->aliases;
    }

    public function getParams(): string
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getChatId(): string
    {
        return $this->chatId;
    }

    public function setChatId(string $chatId)
    {
        $this->chatId = $chatId;
    }

    abstract public function process($chat, $user, $commandParams = null);
}