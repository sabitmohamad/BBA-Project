<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show(Request $request, Lesson $lesson)
    {
        $user = $request->user();
        $lesson->load('course');

        if (! $user->hasAccessToCourse($lesson->course)) {
            abort(403, 'You do not have access to this course.');
        }

        $lesson->load(['quizzes' => function ($q) {
            $q->select(['id', 'lesson_id', 'question', 'a', 'b', 'c', 'd']);
        }]);

        return $lesson;
    }
}
