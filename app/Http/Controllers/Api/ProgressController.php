<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use App\Models\Lesson;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        $lessonId = $request->lesson_id;
        $userId = Auth::id();

        // Get the lesson and its course
        $lesson = Lesson::findOrFail($lessonId);
        $courseId = $lesson->course_id;

        // Check if user has paid for this course
        $payment = Payment::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('status', 'success')
            ->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'You need to purchase this course first',
            ], 403);
        }

        // Create or update progress
        $progress = Progress::updateOrCreate(
            [
                'user_id' => $userId,
                'lesson_id' => $lessonId,
            ],
            [
                'is_completed' => true,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'data' => $progress,
        ]);
    }

    public function getLessonProgress($lessonId)
    {
        $userId = Auth::id();

        $progress = Progress::where('user_id', $userId)
            ->where('lesson_id', $lessonId)
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'is_completed' => $progress ? $progress->is_completed : false,
            ],
        ]);
    }

    public function getCourseProgress($courseId)
    {
        $userId = Auth::id();

        // Get all lessons for this course
        $lessons = Lesson::where('course_id', $courseId)->pluck('id');

        // Get progress for all lessons
        $completedLessons = Progress::where('user_id', $userId)
            ->whereIn('lesson_id', $lessons)
            ->where('is_completed', true)
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_lessons' => $lessons->count(),
                'completed_lessons' => $completedLessons,
                'progress_percentage' => $lessons->count() > 0 
                    ? round(($completedLessons / $lessons->count()) * 100) 
                    : 0,
            ],
        ]);
    }
}
