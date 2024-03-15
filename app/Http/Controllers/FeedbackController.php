<?php

namespace App\Http\Controllers;

use App\Enum\FeedbackSourceEnum;
use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Feedback::class);
        $feedbacks = Feedback::withTrashed()->get();

        return inertia()->render('Feedbacks/Index', ['feedbacks' => $feedbacks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia()->render('Feedbacks/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedbackRequest $request)
    {
        // Default values
        $email = $request->email;
        $userId = null;

        // Link to user if logged in
        if (Auth::check()) {
            $currentUser = Auth::User();
            $email = $currentUser->email;
            $userId = $currentUser->id;
        }

        $lastFeedback = Feedback::where('email', $email)
            ->where('created_at', '>=', Carbon::now()->subHour())
            ->exists();

        if ($lastFeedback) {
            return redirect()
                ->back()
                ->dangerBanner('You have already created a feedback within the last hour. Please try again later.');
        }

        Feedback::create([
            'content' => $request['content'],
            'source' => FeedbackSourceEnum::DASHBOARD,
            'email' => $email,
            'user_id' => $userId
        ]);

        return redirect()->route('feedbacks.create')->banner('Feedback submitted successfully!');
    }

    public function delete($id) {
        $this->authorize('delete', Feedback::class);

        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('feedbacks.index')->with('success', 'Feedback deleted successfully!');
    }

    public function restore($id) {
        $this->authorize('restore', Feedback::class);

        $feedback = Feedback::withTrashed()->findOrFail($id);
        $feedback->restore();

        return redirect()->route('feedbacks.index')->with('success', 'Feedback restored successfully!');
    }
}
