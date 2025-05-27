<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.hotel.store-items.index')); ?>">Store Items</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Create</a></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(isset($store_item) ? 'Update Store Item' : 'Create Store Item'); ?></h4>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?php echo e(isset($store_item) ? route('dashboard.hotel.store-items.update', $store_item->id) : route('dashboard.hotel.store-items.store')); ?>"
                            enctype="multipart/form-data" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php if(isset($store_item)): ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="store_item_id" value="<?php echo e($store_item->id); ?>">
                            <?php endif; ?>
                            <div class="row justify-content-center">
                                <!-- Item Category -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="item_category_id" class="text-label form-label">Item Category*</label>
                                        <select id="item_category_id" name="item_category_id"
                                            class="form-control <?php $__errorArgs = ['item_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="">Select Category</option>
                                            <?php $__currentLoopData = getModelItems('item-categories'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>"
                                                    <?php echo e(old('item_category_id', $store_item->item_category_id ?? '') == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['item_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Item Sub-Category -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="item_sub_category_id" class="text-label form-label">Item
                                            Sub-Category</label>
                                        <select id="item_sub_category_id" name="item_sub_category_id"
                                            class="form-control <?php $__errorArgs = ['item_sub_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="">Select Sub-Category</option>
                                            <?php $__currentLoopData = getModelItems('item-sub_categories'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($subCategory->id); ?>"
                                                    <?php echo e(old('item_sub_category_id', $store_item->item_sub_category_id ?? '') == $subCategory->id ? 'selected' : ''); ?>>
                                                    <?php echo e($subCategory->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['item_sub_category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="name" class="text-label form-label">Name*</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('name', $store_item->name ?? '')); ?>" required>
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                               <!-- Image -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="image" class="text-label form-label">Image</label>
                                        <input type="file" id="image" name="image"
                                            class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="description" class="text-label form-label">Description</label>
                                        <textarea id="description" name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $store_item->description ?? '')); ?></textarea>
                                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Unit Measurement -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="unit_measurement" class="text-label form-label">Unit
                                            Measurement*</label>
                                        <select id="unit_measurement" name="unit_measurement"
                                            class="form-control <?php $__errorArgs = ['unit_measurement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                            <option value="" disabled
                                                <?php echo e(old('unit_measurement', $store_item->unit_measurement ?? '') == '' ? 'selected' : ''); ?>>
                                                Select Unit Measurement</option>
                                            <option value="kg"
                                                <?php echo e(old('unit_measurement', $store_item->unit_measurement ?? '') == 'kg' ? 'selected' : ''); ?>>
                                                Kilogram (kg)</option>
                                            <option value="g"
                                                <?php echo e(old('unit_measurement', $store_item->unit_measurement ?? '') == 'g' ? 'selected' : ''); ?>>
                                                Gram (g)</option>
                                            <option value="l"
                                                <?php echo e(old('unit_measurement', $store_item->unit_measurement ?? '') == 'l' ? 'selected' : ''); ?>>
                                                Liter (l)</option>
                                            <option value="ml"
                                                <?php echo e(old('unit_measurement', $store_item->unit_measurement ?? '') == 'ml' ? 'selected' : ''); ?>>
                                                Milliliter (ml)</option>
                                            <option value="pcs"
                                                <?php echo e(old('unit_measurement', $store_item->unit_measurement ?? '') == 'pcs' ? 'selected' : ''); ?>>
                                                Pieces (pcs)</option>
                                            <option value="box"
                                                <?php echo e(old('unit_measurement', $store_item->unit_measurement ?? '') == 'box' ? 'selected' : ''); ?>>
                                                Box</option>
                                            <option value="set"
                                                <?php echo e(old('unit_measurement', $store_item->unit_measurement ?? '') == 'set' ? 'selected' : ''); ?>>
                                                Set</option>
                                        </select>
                                        <?php $__errorArgs = ['unit_measurement'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>


                                <!-- Quantity -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="qty" class="text-label form-label">Quantity*</label>
                                        <input type="number" id="qty" name="qty"
                                            class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('qty', $store_item->qty ?? 0)); ?>" required>
                                        <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Prices -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="cost_price" class="text-label form-label">Cost Price</label>
                                        <input type="number" step="0.01" id="cost_price" name="cost_price"
                                            class="form-control <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('cost_price', $store_item->cost_price ?? '')); ?>">
                                        <?php $__errorArgs = ['cost_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="selling_price" class="text-label form-label">Selling Price</label>
                                        <input type="number" step="0.01" id="selling_price" name="selling_price"
                                            class="form-control <?php $__errorArgs = ['selling_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('selling_price', $store_item->selling_price ?? '')); ?>">
                                        <?php $__errorArgs = ['selling_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Low Stock Alert -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="low_stock_alert" class="text-label form-label">Low Stock Alert</label>
                                        <input type="number" id="low_stock_alert" name="low_stock_alert"
                                            class="form-control <?php $__errorArgs = ['low_stock_alert'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('low_stock_alert', $store_item->low_stock_alert ?? '')); ?>">
                                        <?php $__errorArgs = ['low_stock_alert'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- For Sale -->
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="form-group">
                                        <label for="for_sale" class="text-label form-label">For Sale</label>
                                        <select id="for_sale" name="for_sale"
                                            class="form-control <?php $__errorArgs = ['for_sale'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value="1"
                                                <?php echo e(old('for_sale', $store_item->for_sale ?? true) == 1 ? 'selected' : ''); ?>>
                                                Yes</option>
                                            <option value="0"
                                                <?php echo e(old('for_sale', $store_item->for_sale ?? true) == 0 ? 'selected' : ''); ?>>
                                                No</option>
                                        </select>
                                        <?php $__errorArgs = ['for_sale'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-primary"><?php echo e(isset($store_item) ? 'Update' : 'Submit'); ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/store-item/create.blade.php ENDPATH**/ ?>