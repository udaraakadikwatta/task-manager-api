<?php

namespace App\Enums;

/**
 * Enum representing the status of a task.
 */
enum TaskStatus: string
{
    /**
     * Task is pending and not yet completed.
     */
    case Pending = 'pending';

    /**
     * Task has been completed.
     */
    case Completed = 'completed';
}
