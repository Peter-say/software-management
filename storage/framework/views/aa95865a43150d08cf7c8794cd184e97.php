<div class="modal fade" id="generalItemDescriptionModal" tabindex="-1" role="dialog" aria-labelledby="generalItemDescriptionModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea class="form-control" id="itemDescriptionContent" disabled cols="30" rows="5"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.show-body').forEach(function(button) {
            button.addEventListener('click', function() {
                const itemContent = this.getAttribute('data-item-content');
                // Set the content to the modal's textarea
                document.getElementById('itemDescriptionContent').value = itemContent;
            });
        });
    });
</script>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/general/modal/item-description-modal.blade.php ENDPATH**/ ?>