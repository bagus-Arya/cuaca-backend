<?php $__env->startSection('header'); ?>
    <title>Sistem Monitoring | Machine Log</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table id="table" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">No</th>
                                    <th>Machine ID</th>
                                    <th>Suhu</th>
                                    <th>Kelembaban</th>
                                    <th>Tekanan Udara</th>
                                    <th>Kecepatan Angin</th>
                                    <th>Kondisi Cuaca</th>
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
                    url: "<?php echo e(route('data-machine-logs')); ?>",
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'machine_id',
                        name: 'machine_id'
                    },
                    {
                        data: 'suhu',
                        name: 'suhu'
                    },
                    {
                        data: 'kelembaban',
                        name: 'kelembaban'
                    },
                    {
                        data: 'tekanan_udara',
                        name: 'tekanan_udara'
                    },
                    {
                        data: 'kecepatan_angin',
                        name: 'kecepatan_angin'
                    },
                    {
                        data: 'kondisi_baik',
                        name: 'kondisi_baik'
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

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vandr/project-naga/terapan-backend/resources/views/machine_log.blade.php ENDPATH**/ ?>