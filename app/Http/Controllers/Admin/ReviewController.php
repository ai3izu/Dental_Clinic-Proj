<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController
{
    public function editReview($id)
    {
        $review = Review::with(['doctor.user', 'patient.user'])->findOrFail($id);
        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();

        return view('admin.review-form', [
            'review' => $review,
            'doctors' => $doctors,
            'patients' => $patients
        ]);
    }

    public function destroyReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'reviews']);
    }

    public function update(UpdateReviewRequest $request, $id)
    {
        $reviews = Review::findOrFail($id);
        $validated = $request->validated();

        $reviews->update([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => $validated['patient_id'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'reviews'])
            ->with('success', 'Dane recenzji zostały zaktualizowane.');
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();
        $patients = Patient::with('user')->get();

        return view('admin.review-form', compact('doctors', 'patients'));
    }

    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();

        Review::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => $validated['patient_id'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'reviews'])
            ->with('success', 'Recenzja została dodana.');
    }
}
