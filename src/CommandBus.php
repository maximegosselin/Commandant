<?php
declare(strict_types = 1);
namespace MaximeGosselin\Commandant\Component;

use Exception;
use MaximeGosselin\Commandant\Api\CommandBusInterface;
use MaximeGosselin\Commandant\Api\CommandHandlerInterface;
use MaximeGosselin\Commandant\Api\CommandInterface;
use MaximeGosselin\Trigger\EventManagerInterface;

class CommandBus implements CommandBusInterface
{
    const EVENT_COMMAND_FAILURE = 'commandbus.command.failure';

    const EVENT_COMMAND_SUCCESS = 'commandbus.command.success';

    const EVENT_COMMAND_UNHANDLED = 'commandbus.command.unhandled';

    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     *
     * @var array
     */
    private $handlers = [];

    /**
     *
     * @var array
     */
    private $queue = [];

    /**
     *
     * @var boolean
     */
    private $isDispatching = false;

    public function registerHandler(CommandHandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    public function dispatch(CommandInterface $command)
    {
        $this->queue[] = $command;

        if ($this->isDispatching) {
            return;
        }
        $this->isDispatching = true;

        while (($command = array_shift($this->queue)) == true) {
            $handled = false;
            foreach ($this->handlers as $handler) {
                try {
                    $handler->handle($command);
                } catch (Exception $e) {
                    $this->isDispatching = false;
                    $this->triggerSelfEvent(self::EVENT_COMMAND_FAILURE, [
                        $command,
                        $handler,
                        $e
                    ]);

                    return;
                }

                $this->triggerSelfEvent(self::EVENT_COMMAND_SUCCESS, [
                    $command,
                    $handler
                ]);
                $handled = true;
            }
            if (!$handled) {
                $this->triggerSelfEvent(self::EVENT_COMMAND_UNHANDLED, [
                    $command
                ]);
            }
        }
        $this->isDispatching = false;
    }

    private function triggerSelfEvent(string $event, array $params = [])
    {
        if ($this->eventManager) {
            $this->eventManager->trigger($event, $params);
        }
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }
}
