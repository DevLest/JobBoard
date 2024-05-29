<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Services\JobService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(JobService $jobService)
    {
        $externalJobs = $jobService->fetchExternalJobs();
        $localJobs = Job::where('is_approved', true)->get();

        return view('jobs.index', compact('externalJobs', 'localJobs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'email' => 'required|email'
        ]);

        try {
            $job = Job::create($request->all());
            return redirect()->route('jobs.index')->with('status', 'Job posted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('jobs.index')->with('error', 'An error occurred while posting the job.');
        }
    }

    public function approve($id)
    {
        $job = Job::findOrFail($id);
        $job->is_approved = true;
        $job->save();

        return redirect()->back()->with('status', 'Job approved successfully.');
    }

    public function markAsSpam($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return redirect()->back()->with('status', 'Job marked as spam and deleted.');
    }
}