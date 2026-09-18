<?php
// app/Http/Controllers/CancellationController.php

namespace App\Http\Controllers;

use App\Models\MemberSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancellationController extends Controller
{

    /**
     * Show cancellation management page
     */
    public function manage(Request $request)
    {
        $query = MemberSchedule::with(['member', 'schedule.course', 'schedule.trainer'])
            ->where('status', 'active');

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Course filter
        if ($request->has('course_id') && $request->course_id) {
            $query->whereHas('schedule.course', function ($q) use ($request) {
                $q->where('id', $request->course_id);
            });
        }

        // Payment status filter
        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        $enrollments = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get courses for filter dropdown
        $courses = \App\Models\Course::where('status', 1)->get();

        return view('cancellation.manage', compact('enrollments', 'courses'));
    }

    /**
     * Show refund preview before cancellation
     */
    public function refundPreview($enrollmentId)
    {
        $enrollment = MemberSchedule::with(['member', 'schedule.course', 'schedule.trainer'])
            ->findOrFail($enrollmentId);

        $refundInfo = $enrollment->calculateRefund();

        return view('cancellation.refund_preview', compact('enrollment', 'refundInfo'));
    }
    /**
     * Show cancellation form for a specific enrollment
     */
    public function showCancelForm($enrollmentId)
    {
        $enrollment = MemberSchedule::with(['member', 'schedule.course', 'schedule.trainer', 'payments'])
            ->findOrFail($enrollmentId);

        // Check if already cancelled
        if ($enrollment->status == 'cancelled') {
            return redirect()->back()->with('error', 'This enrollment is already cancelled.');
        }

        // Calculate refund eligibility
        $refundInfo = $enrollment->calculateRefund();

        return view('cancellation.cancel_form', compact('enrollment', 'refundInfo'));
    }

    /**
     * Process cancellation
     */
    public function processCancellation(Request $request, $enrollmentId)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|min:5|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $enrollment = MemberSchedule::findOrFail($enrollmentId);

        // Check if already cancelled
        if ($enrollment->status == 'cancelled') {
            return redirect()->back()->with('error', 'This enrollment is already cancelled.');
        }

        try {
            $refundInfo = $enrollment->processCancellation(
                $request->cancellation_reason,
                $request->notes
            );

            $message = "Enrollment cancelled successfully.";
            if ($refundInfo['eligible']) {
                $message .= " Refund of $" . number_format($refundInfo['amount'], 2) . " has been processed.";
            } else {
                $message .= " No refund is applicable.";
            }

            return redirect()->route('cancellation.history')
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Cancellation error: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Error processing cancellation: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show cancellation history
     */
    public function history()
    {
        $cancellations = MemberSchedule::with(['member', 'schedule.course'])
            ->where('status', 'cancelled')
            ->orderBy('cancelled_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_cancelled' => MemberSchedule::where('status', 'cancelled')->count(),
            'total_refunded' => \App\Models\Refund::sum('refund_amount'),
            'cancelled_this_month' => MemberSchedule::where('status', 'cancelled')
                ->whereMonth('cancelled_at', now()->month)
                ->count(),
        ];

        return view('cancellation.history', compact('cancellations', 'stats'));
    }

    /**
     * Show refund details
     */
    public function refundDetails($refundId)
    {
        $refund = \App\Models\Refund::with(['member', 'payment', 'memberSchedule.schedule.course', 'processor'])
            ->findOrFail($refundId);

        return view('cancellation.refund_details', compact('refund'));
    }
}
