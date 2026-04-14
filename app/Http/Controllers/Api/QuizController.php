<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuizController extends Controller
{
    public function submit(Request $request, Lesson $lesson)
    {
        $user = $request->user();
        $lesson->load('course', 'quizzes');

        if (! $user->hasAccessToCourse($lesson->course)) {
            abort(403, 'You do not have access to this course.');
        }

        $quizIds = $lesson->quizzes->modelKeys();
        if ($quizIds === []) {
            return response()->json([
                'message' => 'This lesson has no quiz questions.',
                'correct' => 0,
                'total' => 0,
                'all_correct' => true,
            ]);
        }

        $request->validate([
            'answers' => ['required', 'array'],
            'answers.*' => [Rule::in(['a', 'b', 'c', 'd'])],
        ]);

        $answers = $request->input('answers', []);
        $missing = array_diff($quizIds, array_map('intval', array_keys($answers)));
        if ($missing !== []) {
            return response()->json([
                'message' => 'Provide an answer for every question in this lesson.',
                'missing_quiz_ids' => array_values($missing),
            ], 422);
        }

        $correct = 0;
        $details = [];

        foreach ($lesson->quizzes as $quiz) {
            $given = strtolower((string) ($answers[(string) $quiz->id] ?? $answers[$quiz->id] ?? ''));
            $isCorrect = $given === $quiz->correct_answer;
            if ($isCorrect) {
                $correct++;
            }
            $details[] = [
                'quiz_id' => $quiz->id,
                'correct' => $isCorrect,
            ];
        }

        $total = count($quizIds);
        $allCorrect = $correct === $total;

        if ($allCorrect) {
            Progress::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                ['is_completed' => true]
            );
        }

        return response()->json([
            'correct' => $correct,
            'total' => $total,
            'all_correct' => $allCorrect,
            'details' => $details,
        ]);
    }
}
