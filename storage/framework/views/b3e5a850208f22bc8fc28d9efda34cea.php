  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              Are you sure you want to delete this guest?
          </div>
          <div class="modal-footer">
              <form method="POST" id="deleteForm">
                  <?php echo csrf_field(); ?>
                  <?php echo method_field('DELETE'); ?>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
          </div>
      </div>
  </div>
</div>

<script>
  function confirmDelete(url) {
      $('#deleteForm').attr('action', url);
      $('#deleteModal').modal('show');
  }
</script><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/guest/delete-modal.blade.php ENDPATH**/ ?>