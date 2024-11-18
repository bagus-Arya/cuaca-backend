<?php $__env->startSection('header'); ?>
    <title>Sistem Monitoring | Machine</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header text-right">
                        <a class="btn btn-primary" href="<?php echo e(route('show-store-machine')); ?>">
                            <i class="fa fa-plus-circle"></i> Tambah Data
                        </a>
                    </div>

                    <?php if(session() -> has('successMessage')): ?>
                    <div class="px-2 pt-2">
                        <div class="alert alert-info" role="alert">
                            <?php echo e(session('successMessage')); ?>

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <table id="table" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">No</th>
                                    <th>Machine ID</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?php echo e(route('data-machine')); ?>",
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'lat',
                        name: 'lat'
                    },
                    {
                        data: 'lng',
                        name: 'lng'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                oLanguage: {
                    sProcessing: "Memuat Data.."
                },
                fnCreatedRow: function(row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /www/wwwroot/103.171.85.186/terapan-backend/resources/views/machine.blade.php ENDPATH**/ ?>