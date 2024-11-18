<?php $__env->startSection('header'); ?>
    <title>Sistem Monitoring | Machine</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mb-3">Machine Data</h1>
                        <form method="post" action="<?php echo e(route('edit-machine', ['machine' => $machine -> id])); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="form-group">
                                <label for="lat">Latitude</label>
                                <input value="<?php echo e($machine -> lat); ?>" type="text" name="lat" class="form-control" id="lat">
                              </div>
                            <div class="form-group">
                                <label for="lng">Longitude</label>
                                <input value="<?php echo e($machine -> lng); ?>" type="text" name="lng" class="form-control" id="lng">
                              </div>
                            <div class="flex">
                              <button type="submit" class="btn btn-primary">Edit</button>
                                <a href="<?php echo e(route('machine')); ?>" class="btn btn-danger">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/103.171.85.186/terapan-backend/resources/views/edit_machine.blade.php ENDPATH**/ ?>