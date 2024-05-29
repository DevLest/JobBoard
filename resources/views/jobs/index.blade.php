<!DOCTYPE html>
<html>
<head>
    <title>Job Listings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .job-listings {
            margin: 50px auto;
            max-width: 900px;
        }
        .job-card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .job-card h3 {
            color: #007bff;
        }
        .job-card p {
            color: #555;
        }
        .form-inline {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .form-inline .form-control {
            flex-grow: 1;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .modal-header {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="job-listings">
            <h1 class="text-center">Job Listings</h1>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="form-inline mb-4">
                <input type="text" class="form-control" id="search" placeholder="Search for jobs..." onkeyup="filterJobs()">
                <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#postJobModal">
                    <i class="fas fa-plus"></i> Post a Job
                </button>
            </div>

            <ul class="nav nav-tabs" id="jobTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="local-jobs-tab" data-toggle="tab" href="#local-jobs" role="tab" aria-controls="local-jobs" aria-selected="true">Local Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="external-jobs-tab" data-toggle="tab" href="#external-jobs" role="tab" aria-controls="external-jobs" aria-selected="false">External Jobs</a>
                </li>
            </ul>

            <div class="tab-content" id="jobTabsContent">
                <div class="tab-pane fade show active" id="local-jobs" role="tabpanel" aria-labelledby="local-jobs-tab">
                    @foreach ($localJobs as $job)
                        <div class="job-card">
                            <h3>{{ $job->title }}</h3>
                            <p>{{ $job->description }}</p>
                            <div class="text-right">
                                <a href="{{ route('jobs.spam', $job->id) }}" class="btn btn-danger btn-sm">
                                    <i class="fas fa-ban"></i> Mark as Spam
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="external-jobs" role="tabpanel" aria-labelledby="external-jobs-tab">
                    @foreach ($externalJobs as $job)
                        <div class="job-card">
                            <h3>{{ $job['name'] }}</h3>
                            @isset($job['jobDescriptions'])
                                @foreach ($job['jobDescriptions'] as $desc)
                                    <p><strong>{{ $desc['name'] }}:</strong> 
                                        @foreach ($desc['value'] as $value)
                                            {!! nl2br(e($value)) !!}
                                        @endforeach
                                    </p>
                                @endforeach
                            @endisset
                            <p><strong>Employment Type:</strong> {{ $job['employmentType'] ?? 'N/A' }}</p>
                            <p><strong>Location:</strong> {{ $job['location'] ?? 'N/A' }}</p>
                            <p><strong>Created At:</strong> {{ $job['createdAt'] ?? 'N/A' }}</p>
                            @if(isset($job['link']))
                                <p><a href="{{ $job['link'] }}" target="_blank" class="btn btn-info btn-sm">View Full Job Posting</a></p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="postJobModal" tabindex="-1" role="dialog" aria-labelledby="postJobModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postJobModalLabel">Post a Job</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/" method="POST" id="postJobForm">
                        @csrf
                        <div class="form-group">
                            <label for="title">Job Title:</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Job Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Post Job</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function filterJobs() {
            var input, filter, jobCards, jobCard, i, txtValue;
            input = document.getElementById('search');
            filter = input.value.toLowerCase();
            jobCards = document.getElementsByClassName('job-card');

            for (i = 0; i < jobCards.length; i++) {
                jobCard = jobCards[i];
                txtValue = jobCard.textContent || jobCard.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    jobCard.style.display = "";
                } else {
                    jobCard.style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
