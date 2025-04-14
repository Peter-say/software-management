<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <!-- Page Breadcrumb -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Expenses</a></li>
                </ol>
            </div>
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    
                </div>
                <div class="d-flex justify-content-end">
                    <form method="GET" action="<?php echo e(route('dashboard.hotel.expenses-dashbaord')); ?>" class="d-inline">
                        <div class="dropdown">
                            <button type="button" class="btn btn-primary btn-sm btn-wave waves-effect waves-light  me-2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Sort Stats By <?php echo e(ucfirst(request()->period ?? 'Day')); ?><i
                                    class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" href="javascript:void(0);" data-period="day">Day</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-period="week">Week</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-period="month">Month</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" data-period="year">Year</a></li>
                            </ul>
                        </div>
                        <!-- Hidden input to capture selected period -->
                        <input type="hidden" name="period" id="selected-period" value="<?php echo e(request('period', 'day')); ?>">
                    </form>
                    <div class="d-flex align-items-center mb-2">
                        <a href="<?php echo e(route('dashboard.hotel.expenses.index')); ?>" class="btn btn-primary me-2">
                            View List</a>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <a href="<?php echo e(route('dashboard.hotel.expenses.create')); ?>" class="btn btn-secondary me-2">+
                            Add New</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-8 col-xl-8 col-md-12 col-sm-12">
                    <div class="row">
                        <?php $__currentLoopData = $expenses_stats['cards']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-xl-6 col-xl-6 col-md-6 col-sm-12 mb-4">
                                <div class="card booking">
                                    <div class="card-body">
                                        <div class="booking-status d-flex align-items-center">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                    viewBox="0 0 28 28">
                                                    <path data-name="Path 1957"
                                                        d="M129.035,178.842v2.8a5.6,5.6,0,0,0,5.6,5.6h14a5.6,5.6,0,0,0,5.6-5.6v-16.8a5.6,5.6,0,0,0-5.6-5.6h-14a5.6,5.6,0,0,0-5.6,5.6v2.8a1.4,1.4,0,0,0,2.8,0v-2.8a2.8,2.8,0,0,1,2.8-2.8h14a2.8,2.8,0,0,1,2.8,2.8v16.8a2.8,2.8,0,0,1-2.8,2.8h-14a2.8,2.8,0,0,1-2.8-2.8v-2.8a1.4,1.4,0,0,0-2.8,0Zm10.62-7-1.81-1.809a1.4,1.4,0,1,1,1.98-1.981l4.2,4.2a1.4,1.4,0,0,1,0,1.981l-4.2,4.2a1.4,1.4,0,1,1-1.98-1.981l1.81-1.81h-12.02a1.4,1.4,0,1,1,0-2.8Z"
                                                        transform="translate(-126.235 -159.242)" fill="var(--primary)"
                                                        fill-rule="evenodd" />
                                                </svg>
                                            </span>
                                            <div class="ms-4">
                                                <h2 class="mb-0 font-w600"><?php echo e($card['value']); ?></h2>
                                                <p class="mb-0"><?php echo e($card['title']); ?></p>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <p class="mb-0 ms-auto text-end text-primary rounded">this <?php echo e($card['period']); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 md-4 col-sm-12">
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12">
                            <div class="row">
                                <div class="col-xl-12 col-xl-6">
                                    <div class="card custom-card">
                                        <div class="card-header  justify-content-between">
                                            <div class="card-title">
                                                Top 5 Expenses
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $top_expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $top_expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td><?php echo e($top_expense->category->name); ?></td>
                                                            <td><?php echo e(currencySymbol()); ?><?php echo e(number_format($top_expense->amount)); ?></td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Expenses Chart</h4>
                            <div class="d-flex d-md-flex d-block align-items-center justify-content-end">
                                <form method="GET" action="<?php echo e(route('dashboard.hotel.expenses-dashbaord')); ?>"
                                    class="d-inline">
                                    <div>
                                        <div class="dropdown">
                                            <button type="button"
                                                class="btn btn-primary btn-sm btn-wave waves-effect waves-light  me-2"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Sort Chart By <?php echo e(ucfirst(request()->chart_period ?? 'Day')); ?><i
                                                    class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                            </button>
                                            <ul class="dropdown-menu  dropdown-menu-custom" role="menu">
                                                <li><a class="chart-dropdown-item" href="javascript:void(0);"
                                                        data-chart-period="day">Day</a></li>
                                                <li><a class="chart-dropdown-item" href="javascript:void(0);"
                                                        data-chart-period="week">Week</a></li>
                                                <li><a class="chart-dropdown-item" href="javascript:void(0);"
                                                        data-chart-period="month">Month</a></li>
                                                <li><a class="chart-dropdown-item" href="javascript:void(0);"
                                                        data-chart-period="year">Year</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Hidden input to capture selected period -->
                                    <input type="hidden" name="chart_period" id="chart-selected-period"
                                        value="<?php echo e(request('chart_period', 'day')); ?>">
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="expenseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <?php echo $__env->make('dashboard.chart.expenses.general', ['expenses_chart_data' => $expenses_chart_data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle dropdown item click
            document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
                item.addEventListener('click', function() {
                    const period = this.getAttribute('data-period');
                    const form = this.closest('form');
                    form.querySelector('#selected-period').value = period;
                    form.submit(); // Submit the form automatically
                });
            });
            document.querySelectorAll('.dropdown-menu .chart-dropdown-item').forEach(item => {
                item.addEventListener('click', function() {
                    const period = this.getAttribute('data-chart-period');
                    const form = this.closest('form');
                    form.querySelector('#chart-selected-period').value = period;
                    form.submit(); // Submit the form automatically
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Web Development\Backend\Laravel\software-management\software-management\resources\views\dashboard\hotel\expenses\dashboard.blade.php ENDPATH**/ ?>