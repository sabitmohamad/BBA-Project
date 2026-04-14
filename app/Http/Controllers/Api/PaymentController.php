<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class PaymentController extends Controller
{
    public function store(Request $request)
{
    $data = $request->validate([
        'course_id' => ['required', 'exists:courses,id'],
        'amount' => ['required', 'numeric', 'min:0'],
        'proof_image' => ['required', File::types(['jpg', 'jpeg', 'png', 'webp', 'gif'])->max(5120)],
    ]);

    $userId = $request->user()->id;
    $courseId = $data['course_id'];

    // 1. CEK APAKAH USER SUDAH PERNAH BAYAR (Pending atau Success)
    $existingPayment = Payment::where('user_id', $userId)
        ->where('course_id', $courseId)
        ->whereIn('status', ['pending', 'success']) // Cek status yang aktif
        ->first();

    if ($existingPayment) {
        return response()->json([
            'message' => 'Anda sudah melakukan pembayaran untuk kursus ini. Silakan tunggu konfirmasi admin.',
            'status' => $existingPayment->status,
        ], 422);
    }

    /** @var Course $course */
    $course = Course::query()->findOrFail($courseId);

    // 2. CEK APAKAH KURSUS GRATIS
    if ((float) $course->price <= 0) {
        return response()->json([
            'message' => 'Kursus ini gratis, tidak memerlukan bukti pembayaran.',
        ], 422);
    }

    // Simpan gambar
    $path = $request->file('proof_image')->store('payment-proofs', 'public');

    // Buat data payment baru
    $payment = Payment::create([
        'user_id' => $userId,
        'course_id' => $course->id,
        'amount' => $data['amount'],
        'proof_image' => $path,
        'status' => 'pending',
    ]);

    return response()->json($payment->load('course'), 201);
}

    public function getPaymentByCourse(Request $request, $courseId)
    {
        $user = $request->user();
        
        $payment = Payment::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->whereIn('status', ['pending', 'success', 'failed'])
            ->latest()
            ->first();

        if (!$payment) {
            return response()->json(['message' => 'No payment found'], 404);
        }

        return response()->json($payment);
    }
}
