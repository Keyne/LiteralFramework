<?php
/**
 * Literal Framework
 */
namespace Literal\EventHandler;

/**
 * Event - Used when notifying event listeners
 */
class AbstractEvent implements EventInterface
{
    /**
     * @var string This event's name
     */
    private $name;

    /**
     * @var bool Whether to notify the next listeners or stop the propagation
     */
    private $stopPropagation = false;

    /**
     * Returns whether the next listeners should be notified
     * @return bool
     */
    public function isPropagationStopped()
    {
        return $this->stopPropagation;
    }

    /**
     * Sets the propagation flag to false
     */
    public function stopPropagation()
    {
        $this->stopPropagation = true;
    }

    /**
     * Returns the event name.
     * @return string
     */
    public function getName()
    {
        if(!$this->name) {
            throw new \RuntimeException('The event name is not set');
        }
        return $this->name;
    }

    /**
     * Sets the event name
     * @param string $name
     */
    protected function setName($name)
    {
        $this->name = $name;
    }
}
