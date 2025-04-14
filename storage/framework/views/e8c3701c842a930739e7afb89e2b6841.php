<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item">Orders</li>
                </ol>
            </div>
            <div class="container-fluid">
                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
                    <div class="card-action coin-tabs mb-2">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#AllOrders">All Orders</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="AllOrders">
                                        <div class="table-responsive">
                                            <table class="table card-table display mb-4 shadow-hover table-responsive-lg"
                                                id="ordersTable">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-none">
                                                            <div class="form-check style-1">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="" id="checkAll">
                                                            </div>
                                                        </th>
                                                        <th>Waitstaff</th>
                                                        <th>Orders</th>
                                                        <th>Status</th>
                                                        <th>Created At</th>
                                                        <th class="bg-none"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if($kitchen_orders && $kitchen_orders->count() > 0): ?>
                                                        <?php $__currentLoopData = $kitchen_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kitchen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check style-1">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            value="">
                                                                    </div>
                                                                </td>
                                                                <td><?php echo e($kitchen->user->name ?? 'Not Available'); ?></td>
                                                                <td>
                                                                    <button type="button" class="btn btn-info"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#orderItemsModal<?php echo e($kitchen->restaurantOrder->id); ?>">
                                                                        View Items
                                                                    </button>

                                                                    <?php echo $__env->make(
                                                                        'dashboard.hotel.kitchen.order-items',
                                                                        ['order' => $kitchen->restaurantOrder->id]
                                                                    , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);"
                                                                        class="btn-md text-<?php echo e($kitchen->status == 'ready' ? 'success' : ($kitchen->status == 'in_progress' ? 'info' : ($kitchen->status == 'pending' ? 'warning' : 'secondary'))); ?>">
                                                                        <i
                                                                            class="<?php echo e($kitchen->status == 'ready' ? 'fas fa-check-circle' : ($kitchen->status == 'in_progress' ? 'fas fa-spinner' : ($kitchen->status == 'pending' ? 'fas fa-hourglass-start' : 'fas fa-question-circle'))); ?>"></i>
                                                                        <?php echo e(strtoupper($kitchen->status ?? 'Pending')); ?>

                                                                    </a>
                                                                </td>
                                                                <td><?php echo e($kitchen->created_at->format('Y-m-d H:i:s')); ?></td>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <button class="btn btn-secondary"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#changeStatusModal-<?php echo e($kitchen->id); ?>">
                                                                            <i class="fas fa-sync-alt"></i> Change Status
                                                                        </button>
                                                                        <a href="" class="btn btn-info btn-xs sharp"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addKitchenNoteModal-<?php echo e($kitchen->id); ?>"
                                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            title="Add Note">
                                                                            <i class="fas fa-sticky-note"></i>
                                                                        </a>
                                                                        <a href="#" class="btn btn-info btn-xs sharp"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addCookModal-<?php echo e($kitchen->id); ?>"
                                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                                            title="Assign this task">
                                                                            <i class="fas fa-pen"></i>
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <?php echo $__env->make(
                                                                    'dashboard.hotel.kitchen.modal.add-note',
                                                                    ['kitchen' => $kitchen]
                                                                , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                <?php echo $__env->make(
                                                                    'dashboard.hotel.kitchen.modal.update-status',
                                                                    ['kitchen' => $kitchen]
                                                                , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="6" class="text-center">No orders found.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted">
                                                Showing <?php echo e($kitchen_orders->firstItem()); ?> to
                                                <?php echo e($kitchen_orders->lastItem()); ?> of <?php echo e($kitchen_orders->total()); ?>

                                                entries
                                            </div>
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination">
                                                    <?php echo e($kitchen_orders->links('pagination::bootstrap-4')); ?>

                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this order?
                </div>
                <div class="modal-footer">
                    <form method="POST" id="deleteForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
    </script>

    <!-- Modal for assigning cook to order -->
    <?php $__currentLoopData = $kitchen_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kitchen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="addCookModal-<?php echo e($kitchen->id); ?>" tabindex="-1"
            aria-labelledby="addCookModalModalLabel-<?php echo e($kitchen->id); ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCookModalModalLabel-<?php echo e($kitchen->id); ?>">Assign Cook to Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="assignCookForm-<?php echo e($kitchen->id); ?>" data-kitchen-id="<?php echo e($kitchen->id); ?>"
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

                            <!-- User Selection Dropdown -->
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
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modals = document.querySelectorAll('.modal');

            modals.forEach((modal) => {
                modal.addEventListener('show.bs.modal', function() { // Listen for when the modal is shown
                    const form = modal.querySelector('form');
                    if (form) { // Check if the form exists
                        const kitchenId = form.getAttribute('data-kitchen-id');
                        const searchInput = document.getElementById(`user-search-${kitchenId}`);
                        const userDropdown = document.getElementById(`user_id-${kitchenId}`);

                        if (searchInput) { // Ensure searchInput exists before adding the event listener
                            searchInput.addEventListener('input', function() {
                                const query = searchInput.value;

                                // Make an AJAX request to fetch users based on the input
                                if (query.length > 0) {
                                    fetch(
                                            `<?php echo e(route('dashboard.hotel-users.search')); ?>?query=${query}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            userDropdown.innerHTML =
                                                '<option value="">-- Select User --</option>';
                                            data.forEach(user => {
                                                const option = document
                                                    .createElement('option');
                                                option.value = user.id;
                                                option.textContent = user.name;
                                                userDropdown.appendChild(
                                                option);
                                            });
                                        })
                                        .catch(error => console.error(
                                            'Error fetching users:', error));
                                } else {
                                    userDropdown.innerHTML =
                                        '<option value="">-- Select User --</option>';
                                }
                            });
                        }
                    }
                });
            });
        });
    </script>

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\hotel\kitchen\orders.blade.php ENDPATH**/ ?>