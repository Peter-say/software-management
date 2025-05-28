@extends('dashboard.layouts.app')

@section('contents')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('dashboard.home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="#">AI Assistant</a></li>
                    <li class="breadcrumb-item">Gemini Prompt</li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ask Gemini AI</h4>
                    </div>
                    <div class="card-body">
                        <div id="chat-display" class="mb-4"
                            style="height:200px; overflow-y:auto; border:1px solid #eee; padding:15px; background:#fafbfc;">
                            <!-- Chat messages will be rendered by JavaScript -->
                        </div>

                        <form id="gemini-form" method="POST">
                            @csrf
                            <input type="hidden" name="ai_type" value="gemini">
                            <input type="hidden" name="conversation_id"
                                value="{{ old('conversation_id', $conversation_id ?? '') }}">

                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="prompt" class="mb-0">Enter your prompt:</label>
                                    <button type="button" id="clear-chat"
                                        class="btn btn-link ms-3 d-flex align-items-center" title="Clear Conversation"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                        <i class="fa fa-trash"></i>
                                        <span class="ms-1">Clear Conversation</span>
                                    </button>
                                </div>
                                <textarea name="prompt" class="form-control" rows="5" required>{{ old('prompt', $prompt ?? '') }}</textarea>
                                <small class="text-danger" id="prompt-error"></small>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Send to Gemini</button>
                                <a href="{{ route('dashboard.home') }}" class="btn btn-danger light ms-3">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AiChat.init('#chat-display', '#gemini-form');
            AiChat.bindDeleteForm('#deleteForm', '#deleteModal');
            
        });
    </script>
@endsection
