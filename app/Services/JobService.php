<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;

class JobService
{
    public function fetchExternalJobs()
    {
        $response = Http::get('https://mrge-group-gmbh.jobs.personio.de/xml');
        $xml = simplexml_load_string($response->body());

        $jobs = [];
        foreach ($xml->position as $position) {
            $jobDescriptions = [];
            foreach ($position->jobDescriptions->jobDescription as $desc) {
                $jobDescriptions[] = [
                    'name' => (string) $desc->name,
                    'value' => (array) $desc->value
                ];
            }

            $jobs[] = [
                'name' => (string) $position->name,
                'jobDescriptions' => $jobDescriptions,
                'employmentType' => (string) $position->employmentType,
                'location' => (string) $position->office,
                'link' => (string) $position->url,
                'createdAt' => (string) $position->createdAt
            ];
        }

        return $jobs;
    }
}

?>