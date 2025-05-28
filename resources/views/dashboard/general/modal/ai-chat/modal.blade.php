<!-- AI Chat Modal -->
<div class="modal fade" id="aiChatModal" tabindex="-1" aria-labelledby="aiChatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aiChatModalLabel">Gemini AI Assistant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body d-flex flex-column" style="height: 70vh;">
                <div id="modal-chat-display" class="mb-4"
                    style="height:200px; overflow-y:auto; border:1px solid #eee; padding:15px; background:#fafbfc;">
                    @if (isset($chat_histories) && is_array($chat_histories) && count($chat_histories) > 0)
                        @foreach ($chat_histories as $msg)
                            <div>
                                <h6 class="mb-1 text-dark">{{ ucfirst($msg['sender']) }}:</h6>
                                <div
                                    class="alert alert-{{ $msg['sender'] === 'user' ? 'info' : 'secondary' }} text-dark">
                                    {!! nl2br(e($msg['content'])) !!}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <form id="modal-gemini-form" method="POST">
                    @csrf
                    <input type="hidden" name="ai_type" value="gemini">
                    <input type="hidden" name="conversation_id"
                        value="{{ old('conversation_id', $conversation_id ?? '') }}">

                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="prompt" class="mb-0">Enter your prompt:</label>
                            <button type="button" id="clear-chat" class="btn btn-link ms-3 d-flex align-items-center"
                                title="Clear Conversation" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AiChat.init('#modal-chat-display', '#modal-gemini-form');
        AiChat.bindDeleteForm('#modal-deleteForm', '#modal-deleteModal');
    });
</script>
