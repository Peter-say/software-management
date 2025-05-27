<!-- Button trigger modal -->

<div class="modal fade" id="upload-bar-items-modal" tabindex="-1" role="dialog" aria-labelledby="upload-bar-items-modal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Bar Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <a href="#" class="btn btn-primary" id="downloadSample">
                        <i class="fas fa-download"></i> Download Bar Item Sample
                    </a>
                    <input type="hidden" name="current_url" value="<?php echo e(request()->url()); ?>" id="currentUrl">
                </div>
            </div>
            <form id="uploadIBartemsForm" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="col-12 m-3">
                        <div class="form-group">
                            <label for="file">Select Excel File to Upload</label>
                            <input type="file" class="form-control" id="file" name="file"
                                accept=".xlsx, .csv" required>
                        </div>
                    </div>
                    <div class="col-12 m-3">
                        <div class="form-group">
                            <label for="description">Comment (Optional)</label>
                            <textarea class="form-control" name="description" id="description" cols="5" rows="2"
                                placeholder="Enter comment if any"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Upload Items</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#uploadIBartemsForm').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            // Create a FormData object to hold the form data
            var formData = new FormData(this);

            $.ajax({
                url: '<?php echo e(route('dashboard.hotel.bar-items.upload')); ?>', // Your route
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Toastify({
                        text: response.message,
                        duration: 5000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #00b09b, #96c93d)',
                    }).showToast();

                    // Optionally redirect after success
                    if (response.success) {
                        setTimeout(function() {
                            window.location.href = response.redirectUrl;
                        }, 2000); // Redirect after 2 seconds
                    }
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseJSON.message || 'An error occurred';
                    Toastify({
                        text: errorMessage,
                        duration: 5000,
                        gravity: 'top',
                        position: 'right',
                        backgroundColor: 'linear-gradient(to right, #ff5f6d, #ffc371)',
                    }).showToast();
                }
            });
        });
    });
   
</script>
<?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/bar-items/upload-modal.blade.php ENDPATH**/ ?>