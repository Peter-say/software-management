<!-- Modal for Adding Notes -->
<div class="modal fade" id="notesModal" tabindex="-1" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notesModalLabel">Add Notes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="orderNotes" rows="5" placeholder="Enter your notes here..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveNotesBtn">Save Notes</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Ensure the script runs when the DOM is fully loaded
    $(document).ready(function() {
        // Show/Hide Walk-In Customer Form
        $('#addWalkInCustomerBtn').on('click', function() {
            $('#walkInCustomerForm').toggle();
        });

        // Function to load notes from localStorage
        function loadNotes() {
            const notes = localStorage.getItem('orderNotes');
            if (notes) {
                // Set notes in the main textarea
                $('#orderNotesDisplay').val(notes);
                // Set notes in the modal textarea when opening the modal
                $('#orderNotes').val(notes);
            }
        }

        // Load notes on page load
        loadNotes();

        // Save notes to localStorage when the save button in the modal is clicked
        $('#saveNotesBtn').on('click', function() {
            const notes = $('#orderNotes').val();
            localStorage.setItem('orderNotes', notes);
            // Update the display textarea
            $('#orderNotesDisplay').val(notes);
            // Display a success message and close the modal
            Toastify({
                                    text: 'Notes saved successfully.',
                                    duration: 5000,
                                    gravity: 'top',
                                    position: 'right',
                                    backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                                }).showToast();
            var modal = new bootstrap.Modal($('#notesModal'));
            modal.hide();
        });

        // When submitting the form, retrieve notes from localStorage and include it in the form submission
        $('form').on('submit', function() {
            const notes = localStorage.getItem('orderNotes');
            if (notes) {
                // Create a hidden input field for notes
                const notesField = $('<input>').attr({
                    type: 'hidden',
                    name: 'orderNotes',
                    value: notes
                });
                $(this).append(notesField);
            }
        });
    });
</script>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/bar-items/order/notes-modal.blade.php ENDPATH**/ ?>