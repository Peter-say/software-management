<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
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
                            <?php if(isset($chat_histories) && is_array($chat_histories) && count($chat_histories) > 0): ?>
                                <?php $__currentLoopData = $chat_histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <h6 class="mb-1"><?php echo e(ucfirst($msg['sender'])); ?>:</h6>
                                        <div class="alert alert-<?php echo e($msg['sender'] === 'user' ? 'info' : 'secondary'); ?>">
                                            <?php echo nl2br(e($msg['content'])); ?>

                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>

                        <form id="gemini-form" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="ai_type" value="gemini">
                            <input type="hidden" name="conversation_id"
                                value="<?php echo e(old('conversation_id', $conversation_id ?? '')); ?>">

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
                                <textarea name="prompt" class="form-control" rows="5" required><?php echo e(old('prompt', $prompt ?? '')); ?></textarea>
                                <small class="text-danger" id="prompt-error"></small>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Send to Gemini</button>
                                <a href="<?php echo e(route('dashboard.home')); ?>" class="btn btn-danger light ms-3">Cancel</a>
                            </div>
                        </form>

                        <!-- Delete Confirmation Modal moved outside the main form -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to clear this conversation?
                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST" id="deleteForm"
                                            action="<?php echo e(route('dashboard.clear-conversation')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<script>
    // Store conversation in JS
    let chat_histories = <?php echo json_encode($chat_histories ?? [], 15, 512) ?>;

    function renderChat() {
        let html = '';
        chat_histories.forEach(item => {
            // marked.parse will handle markdown formatting like asterisks, bold, etc.
            html += `
                <div>
                    <h6 class="mb-1">${item.sender === 'user' ? 'You' : 'Gemini'}:</h6>
                    <div class="alert alert-${item.sender === 'user' ? 'info' : 'secondary'}">
                        ${marked.parse(item.content)}
                    </div>
                </div>
            `;
        });
        $('#chat-display').html(html);
        $('#chat-display').scrollTop($('#chat-display')[0].scrollHeight);
    }
    document.addEventListener('DOMContentLoaded', function() {
        $(document).ready(function() {
            renderChat();

            $('#gemini-form').on('submit', function(e) {
                e.preventDefault();
                $('#prompt-error').text('');

                // Get the prompt and clear the textarea
                let prompt = $('textarea[name="prompt"]').val();
                if (!prompt) return;

                // Add user prompt to chat immediately
                chat_histories.push({
                    sender: 'user',
                    content: prompt
                });
                // Add loading indicator for AI response
                chat_histories.push({
                    sender: 'ai',
                    content: '_Gemini is typing..._'
                });
                renderChat();
                $.ajax({
                    url: '<?php echo e(route('dashboard.ask-gemini')); ?>',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    success: function(res) {
                        if (res.response && res.prompt) {
                            // Remove the last loading message
                            chat_histories.pop();
                            // Add AI response
                            chat_histories.push({
                                sender: 'ai',
                                content: res.response
                            });
                            renderChat();
                            $('textarea[name="prompt"]').val('');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred. Please try again.';
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors && errors.prompt) {
                                $('#prompt-error').text(errors.prompt[0]);
                                return;
                            }
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        $('#chat-display').append(
                            `<div class="alert alert-danger">${errorMessage}</div>`
                        );
                    }
                });
                $('textarea[name="prompt"]').val('');

            });
        });
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();
            let $form = $(this);
            let action = $form.attr('action');
            let data = $form.serialize();

            $.ajax({
                url: action,
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(res) {
                    // Hide modal
                    $('#deleteModal').modal('hide');
                    // Clear chat histories and re-render
                    chat_histories = [];
                    renderChat();
                    // Show success message
                    $('<div class="alert alert-success mt-3">Conversation cleared successfully.</div>')
                        .insertAfter('#chat-display')
                        .delay(2000).fadeOut(500, function() {
                            $(this).remove();
                        });
                },
                error: function(xhr) {
                    $('#deleteModal').modal('hide');
                    let errorMessage = 'Failed to clear conversation.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    $('<div class="alert alert-danger mt-3">' + errorMessage + '</div>')
                        .insertAfter('#chat-display')
                        .delay(3000).fadeOut(500, function() {
                            $(this).remove();
                        });
                }
            });
        });
    });
</script>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/chat/gemini/ask.blade.php ENDPATH**/ ?>