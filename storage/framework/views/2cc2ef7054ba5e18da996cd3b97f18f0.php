<!-- Modal for assigning cook to order -->
<div class="modal fade" id="addCookModal-<?php echo e($kitchen->id); ?>" tabindex="-1"
    aria-labelledby="addCookModalModalLabel-<?php echo e($kitchen->id); ?>" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="addCookModalModalLabel-<?php echo e($kitchen->id); ?>">
                   Assign Cook to Order
               </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
               <form id="assignCookForm-<?php echo e($kitchen->id); ?>"
                     data-kitchen-id="<?php echo e($kitchen->id); ?>"
                     action="<?php echo e(route('dashboard.hotel.kitchen.orders.assign-task', ['id' => $kitchen->id])); ?>"
                     method="POST">
                   <?php echo csrf_field(); ?>
                   <?php echo method_field('PUT'); ?>

                   <!-- Search Users -->
                   <div class="form-group mb-3">
                       <label for="user-search-<?php echo e($kitchen->id); ?>">Search Users</label>
                       <input type="text" id="user-search-<?php echo e($kitchen->id); ?>" class="form-control"
                              placeholder="Start typing to search for users...">
                   </div>

                   <!-- User Selection Dropdown (populated by AJAX) -->
                   <div class="form-group mb-3">
                       <label for="user_id-<?php echo e($kitchen->id); ?>">Select User</label>
                       <select name="user_id" id="user_id-<?php echo e($kitchen->id); ?>" class="form-control">
                           <option value="">-- Select User --</option>
                       </select>
                   </div>

                   <div class="modal-footer">
                       <button type="submit" class="btn btn-primary">Assign</button>
                   </div>
               </form>
           </div>
       </div>
   </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll('.modal');

    modals.forEach((modal) => {
        const kitchenId = modal.querySelector('form').getAttribute('data-kitchen-id');
        const searchInput = document.getElementById(`user-search-${kitchenId}`);
        const userDropdown = document.getElementById(`user_id-${kitchenId}`);

        searchInput.addEventListener('input', function() {
            const query = searchInput.value;

            if (query.length >= 2) { // Start searching after 2 characters
                fetch(`/dashboard/hotel-users/search?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        userDropdown.innerHTML = '<option value="">-- Select User --</option>';
                        data.forEach(user => {
                            const option = document.createElement('option');
                            option.value = user.id;
                            option.text = user.name;
                            userDropdown.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching users:', error);
                    });
            } else {
                userDropdown.innerHTML = '<option value="">-- Select User --</option>';
            }
        });
    });
});

</script><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\hotel\kitchen\modal\assign-cook.blade.php ENDPATH**/ ?>