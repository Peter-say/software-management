@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item">Resume Generator</li>
                </ol>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Resume Builder</h4>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('dashboard.generate.resume.store') }}" method="POST" id="resumeForm">
                                @csrf

                                <h5 class="mb-3">Personal Information</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Full Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Email Address</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label>Professional Summary</label>
                                        <textarea name="summary" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <hr>
                                <h5 class="mb-3">Education</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>School / University</label>
                                        <input type="text" name="education[]" class="form-control"
                                            placeholder="e.g. University of Lagos">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Degree</label>
                                        <input type="text" name="degree[]" class="form-control"
                                            placeholder="e.g. B.Sc. Computer Science">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Years Attended</label>
                                        <input type="text" name="years[]" class="form-control"
                                            placeholder="e.g. 2017 - 2021">
                                    </div>
                                </div>

                                <hr>
                                <h5 class="mb-3">Work Experience</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label>Company</label>
                                        <input type="text" name="company[]" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Role / Position</label>
                                        <input type="text" name="position[]" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>Description</label>
                                        <textarea name="job_description[]" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>

                                <hr>
                                <h5 class="mb-3">Skills</h5>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Skills (comma-separated)</label>
                                        <input type="text" name="skills" class="form-control"
                                            placeholder="e.g. PHP, Laravel, React, SEO">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Generate Resume</button>
                                    <a href="{{ route('dashboard.home') }}" class="btn btn-danger ms-3">Cancel</a>
                                </div>
                            </form>

                            <div id="resumeResult" class="mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    window.ResumeBuilder = {
        formId: '#resumeForm',
        resultContainer: '#resumeResult',

        init() {
            const form = document.querySelector(this.formId);
            const resultContainer = document.querySelector(this.resultContainer);

            if (!form || !resultContainer) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent form from reloading the page

                resultContainer.innerHTML = `<div class="alert alert-info">Generating resume...</div>`;

                const formData = new FormData(form); // Handles arrays and complex data correctly

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        },
                        body: formData // DO NOT manually stringify FormData
                    })
                    .then(response => {
                        if (!response.ok) throw response;
                        return response.json();
                    })
                    .then(res => {
                        resultContainer.innerHTML = `
        <div class="card mt-4">
            <div class="card-body">
                <pre style="white-space: pre-wrap;">${marked.parse(res.full_response)}</pre>
            </div>
        </div>
    `;
                    })

                    .catch(async error => {
                        let message = 'An error occurred. Please try again.';

                        if (error.json) {
                            const err = await error.json();
                            message = err.message || message;
                        }

                        resultContainer.innerHTML =
                            `<div class="alert alert-danger">${message}</div>`;
                    });
            });
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        ResumeBuilder.init();
    });
</script>
