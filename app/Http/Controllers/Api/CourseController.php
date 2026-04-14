<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query()->with('category')->orderBy('title');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        return $query->get();
    }

    public function myCourses(Request $request)
    {
        $user = $request->user();
        
        $courses = Course::query()
            ->with(['category', 'payments' => function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->latest();
            }])
            ->whereHas('payments', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->whereIn('status', ['success', 'pending']);
            })
            ->orderBy('title')
            ->get()
            ->map(function ($course) use ($user) {
                $userPayment = $course->payments->first();
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'price' => $course->price,
                    'thumbnail' => $course->thumbnail,
                    'category_id' => $course->category_id,
                    'category' => $course->category,
                    'payment_status' => $userPayment ? $userPayment->status : null,
                    'created_at' => $course->created_at,
                    'updated_at' => $course->updated_at,
                ];
            });

        return response()->json($courses);
    }

    public function lessons(Request $request, Course $course)
    {
        // Return lessons regardless of access (they can see the list but not access content)
        // Access control will be enforced at the individual lesson level
        $lessons = $course->lessons()
            ->orderBy('id')
            ->get();

        return response()->json($lessons);
    }

    public function show($id)
    {
        $course = Course::with(['category', 'lessons'])
            ->findOrFail($id);

        return response()->json($course);
    }
}
