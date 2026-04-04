<?php

namespace App\Http\Controllers;

use App\Enums\JobPositionStatus;
use App\Mail\CandidateApplicationReceivedMail;
use App\Models\Candidate;
use App\Models\JobPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class PublicCandidateController extends Controller
{
    public function create()
    {
        $positions = JobPosition::query()
            ->where('status', JobPositionStatus::OPEN->value)
            ->orderBy('title')
            ->get();

        return view('public.candidates.apply', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'job_position_id' => [
                'required',
                Rule::exists('job_positions', 'id')->where('status', JobPositionStatus::OPEN->value),
            ],
            'cv' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        // Keep name split behavior unchanged to avoid breaking existing data format.
        $nameParts = explode(' ', $request->full_name);
        $lastName = array_shift($nameParts);
        $firstName = implode(' ', $nameParts);

        if (empty($firstName)) {
            $firstName = $lastName;
            $lastName = '';
        }

        $data = [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $request->email,
            'phone' => $request->phone,
            'job_position_id' => $request->job_position_id,
            'cv_path' => $request->hasFile('cv') ? $request->file('cv')->store('cvs', 'public') : 'Không có',
            'status' => '1',
        ];

        $candidate = Candidate::create($data);

        $positionTitle = JobPosition::query()
            ->whereKey($candidate->job_position_id)
            ->value('title') ?? 'vi tri ung tuyen';

        Mail::to($candidate->email)->queue(
            new CandidateApplicationReceivedMail($request->full_name, $positionTitle)
        );

        return redirect()->back()->with('success', 'Hồ sơ của bạn đã được gửi thành công!');
    }
}