<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\MateriProgress;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MateriProgressController extends Controller
{
    /**
     * Update progress for a specific material
     */
    public function updateProgress(Request $request, Materi $materi): JsonResponse
    {
        $request->validate([
            'current_page' => 'required|integer|min:1',
            'total_pages' => 'nullable|integer|min:1',
        ]);

        $user = Auth::user();
        
        // Check if student is enrolled in the class
        if (!$user->enrolledClasses->contains($materi->kelas)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if material is approved
        if (!$materi->isApproved()) {
            return response()->json(['error' => 'Material not approved'], 403);
        }

        // Get or create progress record
        $progress = MateriProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'materi_id' => $materi->id,
            ],
            [
                'current_page' => 1,
                'total_pages' => $request->total_pages,
                'progress_percentage' => 0.00,
                'is_completed' => false,
            ]
        );

        // Update progress
        $progress->updateProgress(
            $request->current_page,
            $request->total_pages ?? $progress->total_pages
        );

        return response()->json([
            'success' => true,
            'progress' => [
                'current_page' => $progress->current_page,
                'total_pages' => $progress->total_pages,
                'progress_percentage' => $progress->progress_percentage,
                'is_completed' => $progress->is_completed,
                'last_read_at' => $progress->last_read_at,
            ]
        ]);
    }

    /**
     * Get progress for a specific material
     */
    public function getProgress(Materi $materi): JsonResponse
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the class
        if (!$user->enrolledClasses->contains($materi->kelas)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $progress = $materi->userProgress($user->id);

        if (!$progress) {
            return response()->json([
                'success' => true,
                'progress' => null
            ]);
        }

        return response()->json([
            'success' => true,
            'progress' => [
                'current_page' => $progress->current_page,
                'total_pages' => $progress->total_pages,
                'progress_percentage' => $progress->progress_percentage,
                'is_completed' => $progress->is_completed,
                'last_read_at' => $progress->last_read_at,
            ]
        ]);
    }

    /**
     * Mark material as completed
     */
    public function markCompleted(Materi $materi): JsonResponse
    {
        $user = Auth::user();
        
        // Check if student is enrolled in the class
        if (!$user->enrolledClasses->contains($materi->kelas)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if material is approved
        if (!$materi->isApproved()) {
            return response()->json(['error' => 'Material not approved'], 403);
        }

        // Get or create progress record
        $progress = MateriProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'materi_id' => $materi->id,
            ],
            [
                'current_page' => 1,
                'total_pages' => 1,
                'progress_percentage' => 0.00,
                'is_completed' => false,
            ]
        );

        $progress->markAsCompleted();

        return response()->json([
            'success' => true,
            'message' => 'Material marked as completed',
            'progress' => [
                'current_page' => $progress->current_page,
                'total_pages' => $progress->total_pages,
                'progress_percentage' => $progress->progress_percentage,
                'is_completed' => $progress->is_completed,
                'last_read_at' => $progress->last_read_at,
            ]
        ]);
    }
}
