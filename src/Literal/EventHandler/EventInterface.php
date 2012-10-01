<?php
/**
 * Literal Framework
 */
namespace Literal\EventHandler;

/**
 * Event - Used when notifying event listeners
 */
interface EventInterface
{

    /**
     * Returns whether the next listeners should be notified
     * @return bool
     */
    public function isPropagationStopped();

    /**
     * Sets the propagation flag to false
     */
    public function stopPropagation();

    /**
     * Returns the event name.
     * @return string
     */
    public function getName();
}
