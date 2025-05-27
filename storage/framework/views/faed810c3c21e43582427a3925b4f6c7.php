<?php $__env->startSection('contents'); ?>
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="<?php echo e(route('dashboard.home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard.hotel.restaurant-items.index')); ?>">Restaurant Item</a></li>
                    <li class="breadcrumb-item"><?php echo e(isset($item) ? 'Update' : 'Create'); ?></li>
                </ol>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(isset($item) ? 'Update Item' : 'Create Item'); ?></h4>
                    </div>
                    <div class="card-body">
                        <form
                            action="<?php echo e(isset($item) ? route('dashboard.hotel.restaurant-items.update', $item->id) : route('dashboard.hotel.restaurant-items.store')); ?>"
                            enctype="multipart/form-data" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php if(isset($item)): ?>
                                <?php echo method_field('PUT'); ?>
                                <input type="hidden" name="item_id" value="<?php echo e($item->id); ?>">
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6 col-12 mb-3">
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
unset($__errorArgs, $__bag); ?>" placeholder="Name"
                                                    value="<?php echo e(old('name', $item->name ?? '')); ?>" required>
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
                                        <div class="col-lg-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="price" class="text-label form-label">Price*</label>
                                                <input type="text" id="price" name="price"
                                                    class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    placeholder="Price" value="<?php echo e(old('price', $item->price ?? '')); ?>" required>
                                                <?php $__errorArgs = ['price'];
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

                                        <div class="col-lg-6 col-12 mb-3">
                                            <div class="form-group">
                                                <div class="d-flex justify-content-between">
                                                    <label for="image" class="text-label form-label">File Upload</label>
                                                    <span>
                                                        <?php if(isset($item) && $item->image): ?>
                                                        <a href="#" class="" type="button" data-bs-toggle="modal" data-bs-target="#item-modal">
                                                           <?php echo e('View existing image'); ?> 
                                                        </a>
                                                    <?php endif; ?>
                                                    </span>
                                                </div>
                                                <input type="file" id="image" name="image" class="form-control <?php $__errorArgs = ['image'];
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

                                        <div class="col-lg-6 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="outlet" class="text-label form-label">Outlet*</label>
                                                <select id="outlet" name="outlet_id"
                                                    class="form-control <?php $__errorArgs = ['outlet_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                                    <option value="" disabled>Select Outlet</option>
                                                    <?php $__currentLoopData = getModelItems('restaurant-outlets'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($outlet->id); ?>"
                                                            <?php echo e(old('outlet_id', $item->outlet_id ?? '') == $outlet->id ? 'selected' : ''); ?>>
                                                            <?php echo e($outlet->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['outlet_id'];
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
                                        <div class="col-lg-12 col-12 mb-3">
                                            <div class="form-group">
                                                <label for="description" class="text-label form-label">Description</label>
                                                <textarea id="description" name="description"
                                                    class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $item->description ?? '')); ?></textarea>
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
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="col-lg-6 col-12 mb-3">
                                        <div class="form-group">
                                            <label for="category" class="text-label form-label">Category*</label>
                                            <input list="categoryList" id="category" name="category"
                                                   class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   value="<?php echo e(old('category', $item->category ?? '')); ?>" required>
                                            <datalist id="categoryList">
                                                <?php $__currentLoopData = getModelItems('item-categories'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($category->name); ?>"><?php echo e($category->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </datalist>
                                            <?php $__errorArgs = ['category'];
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
                                    <h6 class="card-header ">Publish Box</h6>
                                    <div class="card-body">
                                        <div class="form-check mb-3">
                                            <input type="checkbox" class="form-check-input border-danger" id="publish"
                                                name="publish" value="1" <?php echo e(old('publish', $item->is_available ?? false) ? 'checked' : ''); ?>

                                                style="border-width: 2px;">
                                            <label class="form-check-label" for="publish">Make available?</label>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <button class="btn btn-primary" type="submit">
                                            <?php echo e(isset($item) ? 'Update' : 'Publish'); ?>

                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="item-modal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               <div class="d-flex justify-content-center">
                <?php if(isset($item) && $item->image): ?>
                <a href="<?php echo e($item->itemImage()); ?>"
                    data-fancybox="gallery_<?php echo e($item->id); ?>"
                    data-caption="<?php echo e($item->name); ?>">
                    <img src="<?php echo e($item->itemImage()); ?>"
                        alt="Image" class="img-thumbnail">
                </a>
            <?php endif; ?>
               </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/swifbayo/public_html/software-management/resources/views/dashboard/hotel/restaurant-item/create.blade.php ENDPATH**/ ?>