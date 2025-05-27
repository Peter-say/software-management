<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    
                    <li class="breadcrumb-item "><a href="<?php echo e(route('dashboard.hotel.purchases.index')); ?>">List</a>

                    </li>
                    <li class="breadcrumb-item"><?php echo e(isset($purchase) ? 'Update purchases' : 'Create purchases'); ?></li>
                </ol>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(isset($purchase) ? 'Update Purchases' : 'Create purchases'); ?></h4>
                    </div>

                    <div class="card-body">
                        <form id="purchasesForm"
                            action="<?php echo e(isset($purchase) ? route('dashboard.hotel.purchases.update', $purchase->id) : route('dashboard.hotel.purchases.store')); ?>"
                            method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php if(isset($purchase)): ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="purchase_id" value="<?php echo e($purchase->id); ?>">
                            <?php endif; ?>

                            <div class="row">
                                <!-- purchases Details -->
                                <div class="col-lg-12">
                                    <h5>purchases Details</h5>
                                    <div class="row">

                                        <!-- Name Field -->
                                        <div class="col-xl-3 col-md-4 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="form-label">Item Category*</label>
                                                <select id="category" name="item_category_id"
                                                    class="form-control <?php $__errorArgs = ['item_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option value="">Select Category</option>
                                                    <?php $__currentLoopData = getModelItems('item-categories'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category->id); ?>"
                                                            <?php echo e(old('item_category_id', $purchase->item_category_id ?? '') == $category->id ? 'selected' : ''); ?>>
                                                            <?php echo e($category->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['item_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        <!-- Date Field -->
                                        <div class="col-xl-3 col-md-4  col-12 mb-3">
                                            <div class="form-group">
                                                <label for="purchases_date" class="text-label form-label">
                                                    Date*</label>
                                                <input type="date" id="purchase-date" name="purchase_date"
                                                    class="form-control  <?php $__errorArgs = ['purchases_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('purchase_date', isset($purchase) && $purchase->purchase_date ? $purchase->purchase_date->format('Y-m-d') : '')); ?>"
                                                    required>

                                                <?php $__errorArgs = ['exapense_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- Supplier Field -->
                                        <div class="col-xl-3 col-md-4  col-12 mb-3">
                                            <div class="form-group">
                                                <label for="supplier_id" class="form-label">Supplier
                                                    <span>
                                                        <a href="<?php echo e(route('dashboard.hotel.suppliers.create')); ?>"
                                                            class="text-primary">(Add)</a>
                                                    </span>
                                                </label>
                                                <select id="supplier_id" name="supplier_id"
                                                    class="form-control <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option value="">Select Supplier</option>
                                                    <?php $__currentLoopData = getModelItems('suppliers'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($supplier->id); ?>"
                                                            <?php echo e(old('supplier_id', $purchase->supplier_id ?? '') == $supplier->id ? 'selected' : ''); ?>>
                                                            <?php echo e($supplier->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['supplier_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                        </div>
                                        <div class="col-xl-3 col-md-4  col-12 mb-3">
                                            <div class="form-group">
                                                <label for="status" class="form-label">Status</label>
                                                <select id="status" name="status"
                                                    class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <option value="">Select Status</option>
                                                    <?php $__currentLoopData = ['pending', 'partial', 'ordered']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($status); ?>"
                                                            <?php echo e(old('status', $purchase->status ?? '') == $status ? 'selected' : ''); ?>>
                                                            <?php echo e(ucfirst($status)); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                        </div>
                                        <!-- Other Photo Field -->
                                        <div class="col-xl-3 col-md-4  col-12 mb-3">
                                            <div class="form-group">
                                                <label for="file_path" class="form-label">File</label>
                                                <input type="file" id="file_path" name="file_path"
                                                    class="form-control <?php $__errorArgs = ['file_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('file_path', $purchase->file_path ?? '')); ?>">
                                                <?php $__errorArgs = ['file_path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- note Field -->
                                        <div class="col-xl-9 col-md-9  col-12 mb-3">
                                            <div class="form-group">
                                                <label for="note" class="form-label">Note</label>
                                                <input type="text" id="note" name="note"
                                                    class="form-control <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    value="<?php echo e(old('note', isset($purchase) ? $purchase->note : '')); ?>">
                                                <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row no-gutters">
                                <div id="input-container" class="col-lg card-form__body card-body">
                                    <?php if(isset($purchase) && $purchase->items->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $purchase->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $purchaseItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div id="input-template" class="row align-items-center">
                                                <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="store_item_id_0"
                                                            class="text-label form-label">Item/Description</label>
                                                        <select id="store_item_id_0" name="store_item_id[]"
                                                            class="form-control <?php $__errorArgs = ['store_item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                            <option value="" disabled selected>Select an item</option>
                                                            <?php $__currentLoopData = getModelItems('store-items'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($item->id); ?>"
                                                                    <?php echo e(old('store_item_id.' . $key, $purchaseItem->pivot->store_item_id) == $item->id ? 'selected' : ''); ?>>
                                                                    <?php echo e($item->name); ?>

                                                                </option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                        <?php $__errorArgs = ['store_item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="purchases_date"
                                                            class="text-label form-label">Quantity</label>
                                                        <input id="qty_<?php echo e($key); ?>" name="qty[]"
                                                            type="number" onkeyup="updateAmount(<?php echo e($key); ?>)"
                                                            inputmode="decimal" min="0" step="any"
                                                            class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            placeholder="Qty"
                                                            value="<?php echo e(old('qty.' . $key, $purchaseItem->pivot->qty)); ?>">
                                                        <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="purchases_date"
                                                            class="text-label form-label">Rate</label>
                                                        <input type="number" id="rate_<?php echo e($key); ?>"
                                                            name="rate[]" onkeyup="updateAmount(<?php echo e($key); ?>)"
                                                            inputmode="decimal" min="0" step="any"
                                                            class="form-control <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            placeholder="Rate"
                                                            value="<?php echo e(old('rate.' . $key, $purchaseItem->pivot->rate)); ?>">
                                                        <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="received_<?php echo e($key); ?>"
                                                            class="text-label form-label">Received</label>
                                                        <input type="number" id="received_<?php echo e($key); ?>"
                                                            name="received[]" inputmode="decimal" min="0"
                                                            step="any"
                                                            class="form-control <?php $__errorArgs = ['received'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            placeholder="Received"
                                                            value="<?php echo e(old('received.' . $key, $purchaseItem->pivot->received)); ?>">
                                                        <?php $__errorArgs = ['received'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="purchases_date"
                                                            class="text-label form-label">Amount</label>
                                                        <input type="number" id="amount_<?php echo e($key); ?>"
                                                            name="amount[]"
                                                            class="form-control money <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            placeholder="Amount"
                                                            value="<?php echo e(old('amount.' . $key, $purchaseItem->pivot->amount)); ?>">
                                                        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="purchases_date" class="text-label form-label">Unit
                                                            Quantity</label>
                                                        <input type="number" id="unitQty_<?php echo e($key); ?>"
                                                            name="unit_qty[]" inputmode="decimal" min="0"
                                                            step="any"
                                                            class="form-control money <?php $__errorArgs = ['unit_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                            placeholder="Unit Qty"
                                                            value="<?php echo e(old('unit_qty.' . $key, $purchaseItem->pivot->unit_qty)); ?>">
                                                        <?php $__errorArgs = ['unit_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <div class="col-2 d-flex justify-content-end">
                                                    <!-- Remove Button -->
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger remove-button d-flex align-items-center justify-content-center"
                                                        style="border-radius: 50%; width: 40px; height: 40px;">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div id="input-template" class="row align-items-center">
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="store_item_id_0"
                                                        class="text-label form-label">Item/Description</label>
                                                    <select id="store_item_id_0" name="store_item_id[]"
                                                        class="form-control <?php $__errorArgs = ['store_item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                        <option value="" disabled selected>Select an item</option>
                                                        <?php $__currentLoopData = getModelItems('store-items'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($item->id); ?>"
                                                                <?php echo e(old('store_item_id.0') == $item->id ? 'selected' : ''); ?>>
                                                                <?php echo e($item->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <?php $__errorArgs = ['store_item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>

                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="purchases_date"
                                                        class="text-label form-label">Quantity</label>
                                                    <input id="qty_0" name="qty[]" type="number"
                                                        onkeyup="updateAmount(0)" inputmode="decimal" min="0"
                                                        step="any"
                                                        class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="Qty" value="<?php echo e(old('qty.0')); ?>">
                                                    <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="purchases_date" class="text-label form-label">Rate</label>
                                                    <input type="number" id="rate_0" name="rate[]"
                                                        onkeyup="updateAmount(0)" inputmode="decimal" min="0"
                                                        step="any"
                                                        class="form-control <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="Rate" value="<?php echo e(old('rate.0')); ?>">
                                                    <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="received" class="text-label form-label">Received</label>
                                                    <input type="number" id="received_0" name="received[]"
                                                        inputmode="decimal" min="0" step="any"
                                                        class="form-control <?php $__errorArgs = ['received'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="Received" value="<?php echo e(old('received.0')); ?>">
                                                    <?php $__errorArgs = ['received'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="purchases_date"
                                                        class="text-label form-label">Amount</label>
                                                    <input type="number" id="amount_0" name="amount[]"
                                                        class="form-control money <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="Amount" value="<?php echo e(old('amount.0')); ?>">
                                                    <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="purchases_date" class="text-label form-label">Unit
                                                        Quantity</label>
                                                    <input type="number" id="unitQty_0" name="unit_qty[]"
                                                        inputmode="decimal" min="0" step="any"
                                                        class="form-control money <?php $__errorArgs = ['unit_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="Unit Qty" value="<?php echo e(old('unit_qty.0')); ?>">
                                                    <?php $__errorArgs = ['unit_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-4 col-12 mb-3 d-flex align-items-center">
                                                <!-- Remove Button -->
                                                <button type="button"
                                                    class="btn btn-sm btn-danger remove-button d-flex align-items-center justify-content-center"
                                                    style="border-radius: 50%; width: 40px; height: 40px;">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div style="display: none">
                                <div id="input-template" class="row">
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="store_item_id_0"
                                                class="text-label form-label">Item/Description</label>
                                            <select id="store_item_id_0" name="store_item_id[]"
                                                class="form-control <?php $__errorArgs = ['store_item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                <option value="" disabled selected>Select an item</option>
                                                <?php $__currentLoopData = getModelItems('store-items'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>"
                                                        <?php echo e(old('store_item_id.0') == $item->id ? 'selected' : ''); ?>>
                                                        <?php echo e($item->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['store_item_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <div class="col-xl-2 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Quantity</label>
                                            <input id="qty_0" name="qty[]" type="number"
                                                onkeyup="updateAmount(0)" inputmode="decimal" min="0"
                                                step="any" class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Qty" value="<?php echo e(old('qty[]')); ?>">

                                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Rate</label>
                                            <input type="number" id="rate_0" name="rate[]" type="number"
                                                onkeyup="updateAmount(0)" inputmode="decimal" min="0"
                                                step="any" class="form-control <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Rate" value="<?php echo e(old('rate[]')); ?>">
                                            <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="received_0" class="text-label form-label">Received</label>
                                            <input type="number" id="received_0" name="received[]" inputmode="decimal"
                                                min="0" step="any"
                                                class="form-control <?php $__errorArgs = ['received'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Received" value="<?php echo e(old('received[]')); ?>">
                                            <?php $__errorArgs = ['received'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Amount</label>
                                            <input type="number" id="amount_0" name="amount[]" type="number"
                                                class="form-control money <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Amount" value="<?php echo e(old('amount[]')); ?>">
                                            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-4  col-12 mb-3">
                                        <div class="form-group">
                                            <label for="purchases_date" class="text-label form-label">
                                                Unit Quantity</label>
                                            <input type="number" id="unitQty_0" name="unit_qty[]" type="number"
                                                inputmode="decimal" min="0" step="any"
                                                class="form-control money <?php $__errorArgs = ['unit_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Unit Qty" value="<?php echo e(old('unit_qty[]')); ?>">
                                            <?php $__errorArgs = ['unit_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-2 d-flex justify-content-end mt-3">
                                        <!-- Remove Button -->
                                        <button type="button"
                                            class="btn btn-sm btn-danger remove-button d-flex align-items-center justify-content-center"
                                            style="border-radius: 50%; width: 40px; height: 40px; display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <!-- Left-aligned Buttons (Submit and Cancel) -->
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(isset($purchase) ? 'Update purchases' : 'Create purchases'); ?>

                                    </button>
                                    <a href="<?php echo e(route('dashboard.hotel.purchases.index')); ?>"
                                        class="btn btn-danger light ms-3">
                                        Cancel
                                    </a>
                                </div>

                                <!-- Right-aligned Add Button -->
                                <button type="button" id="add-input"
                                    class="btn btn-sm btn-dark d-flex align-items-center justify-content-center"
                                    style="border-radius: 50%; width: 40px; height: 40px;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        let inputCounter =
            <?php echo e(isset($purchase->items) ? count($purchase->items) : 0); ?>; // Start counter from existing items count

        // Function to update the amount field based on quantity and rate
        function updateAmount(index) {
            var qty = parseFloat($("#qty_" + index).val()) || 0;
            var rate = parseFloat($("#rate_" + index).val()) || 0;
            var amount = qty * rate;
            $("#amount_" + index).val(amount.toFixed(2)); // Format the amount
            $("#unitQty_" + index).val(qty); // Set unit qty
        }

        // Wait until the DOM is fully loaded
        $(document).ready(function() {
            // Hide the remove button on the initial input
            $("#input-container .remove-button:first").hide();

            // Event handler for adding a new cloned input section
            $("#add-input").click(function() {
                inputCounter++;

                // Clone the input template and update attributes
                var newInput = $("#input-template").first().clone();
                newInput.find("input, select").each(function() {
                    var oldName = $(this).attr("name");
                    var oldId = $(this).attr("id");

                    // Update name and id attributes
                    if (oldName) $(this).attr("name", oldName.replace(/\[\]/g, "[" + inputCounter +
                        "]"));
                    if (oldId) $(this).attr("id", oldId.replace(/_0$/, "_" + inputCounter));

                    // Clear values for cloned inputs
                    $(this).val('');
                });

                // Update the remove button and show it
                newInput.find(".remove-button").show().click(function() {
                    newInput.remove();
                });

                // Append the new input element to the container
                $("#input-container").append(newInput);

                // Trigger initial calculation for amount in the new input section
                newInput.find("input[type='number']").on('keyup', function() {
                    var index = $(this).attr("id").split("_")[1];
                    updateAmount(index);
                });

                updateAmount(inputCounter);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/purchases/create.blade.php ENDPATH**/ ?>