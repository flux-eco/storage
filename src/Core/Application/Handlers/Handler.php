<?php


namespace FluxEco\Storage\Core\Application\Handlers;

interface Handler
{
    public function handle(Command $command);
}