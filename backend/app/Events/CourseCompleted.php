<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseCompleted
{
    use Dispatchable, SerializesModels;

    public $studentId;
    public $courseId;
    public $studentName;
    public $courseName;

    /**
     * Create a new event instance.
     */
    public function __construct($studentId, $courseId, $studentName, $courseName)
    {
        $this->studentId = $studentId;
        $this->courseId = $courseId;
        $this->studentName = $studentName;
        $this->courseName = $courseName;
    }
}
