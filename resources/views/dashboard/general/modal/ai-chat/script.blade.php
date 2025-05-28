<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to clear this conversation?
            </div>
            <div class="modal-footer">
                <form method="POST" id="deleteForm" action="{{ route('dashboard.clear-conversation') }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    window.AiChat = {
        chatHistories: @json($chat_histories ?? []),
        containerId: null,
        formId: null,

        renderChat() {
            let html = '';
            this.chatHistories.forEach(item => {
                html += `
                    <div>
                        <h6 class="mb-1">${item.sender === 'user' ? 'You' : 'Gemini'}:</h6>
                        <div class="alert alert-${item.sender === 'user' ? 'info' : 'secondary'} text-dark">
                            ${marked.parse(item.content)}
                        </div>
                    </div>
                `;
            });
            $(this.containerId).html(html);
            $(this.containerId).scrollTop($(this.containerId)[0].scrollHeight);
        },

        init(containerId, formId) {
            this.containerId = containerId;
            this.formId = formId;

            if (!$(this.containerId).length || !$(this.formId).length) return;

            this.renderChat();

            let self = this;

            $(this.formId).on('submit', function(e) {
                e.preventDefault();
                $('#prompt-error').text('');
                let prompt = $('textarea[name="prompt"]', this).val();
                if (!prompt) return;

                self.chatHistories.push({ sender: 'user', content: prompt });
                self.chatHistories.push({ sender: 'ai', content: '_Gemini is typing..._' });
                self.renderChat();

                $.ajax({
                    url: '{{ route('dashboard.ask-gemini') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: { 'X-CSRF-TOKEN': $('input[name="_token"]', this).val() },
                    success: function(res) {
                        self.chatHistories.pop(); // remove loading
                        self.chatHistories.push({ sender: 'ai', content: res.response });
                        self.renderChat();
                        $('textarea[name="prompt"]', self.formId).val('');
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred.';
                        if (xhr.status === 422 && xhr.responseJSON.errors?.prompt) {
                            $('#prompt-error').text(xhr.responseJSON.errors.prompt[0]);
                            return;
                        } else if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        $(self.containerId).append(`<div class="alert alert-danger">${errorMessage}</div>`);
                    }
                });
            });
        },

        bindDeleteForm(formId, modalId) {
            let self = this;
            if (!$(formId).length) return;

            $(formId).on('submit', function(e) {
                e.preventDefault();
                let $form = $(this);

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]', this).val()
                    },
                    success: function(res) {
                        $(modalId).modal('hide');
                        self.chatHistories = [];
                        self.renderChat();
                        $('<div class="alert alert-success mt-3">Conversation cleared.</div>')
                            .insertAfter(self.containerId)
                            .delay(2000).fadeOut(500, function() { $(this).remove(); });
                    },
                    error: function(xhr) {
                        $(modalId).modal('hide');
                        let errorMessage = xhr.responseJSON?.message || 'Failed to clear.';
                        $('<div class="alert alert-danger mt-3">' + errorMessage + '</div>')
                            .insertAfter(self.containerId)
                            .delay(3000).fadeOut(500, function() { $(this).remove(); });
                    }
                });
            });
        }
    };
</script>
