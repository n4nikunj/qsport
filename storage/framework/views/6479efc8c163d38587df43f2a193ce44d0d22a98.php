<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo e(config('adminlte.name', 'Laravel')); ?> <?php if(@$page_title): ?> - <?php echo e($page_title); ?> <?php endif; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo e(asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')); ?> ">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('admin/bower_components/font-awesome/css/font-awesome.min.css')); ?> ">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo e(asset('admin/bower_components/Ionicons/css/ionicons.min.css')); ?> ">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('admin/dist/css/AdminLTE.min.css')); ?> ">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo e(asset('admin/plugins/iCheck/square/blue.css')); ?> ">
  <link rel="stylesheet" href="<?php echo e(asset('admin/dist/css/skins/_all-skins.min.css')); ?>">
  <!-- CkEditor -->
  <script src="<?php echo e(asset('admin/bower_components/ckeditor/ckeditor.js')); ?>"></script>
  <!-- Toaster -->
  <link rel="stylesheet" href="<?php echo e(asset('css/toastr.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('admin/custom/developer.css')); ?>" />
  <?php echo $__env->yieldContent('css'); ?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

  <?php echo $__env->make('admin.elements.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
  <?php echo $__env->make('admin.elements.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<div class="content-wrapper">
    <?php echo $__env->yieldContent('content'); ?>
</div>
  <?php echo $__env->make('admin.elements.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<!-- ./wrapper -->
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo e(asset('admin/bower_components/jquery/dist/jquery.min.js')); ?> "></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo e(asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')); ?> "></script>
<!-- SlimScroll -->
<script src="<?php echo e(asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>
<!-- FastClick -->
<script src="<?php echo e(asset('admin/bower_components/fastclick/lib/fastclick.js')); ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(asset('admin/dist/js/adminlte.min.js')); ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo e(asset('admin/dist/js/demo.js')); ?>"></script>
<!-- DataTables -->
<script src="<?php echo e(asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
<!--Toaster JS-->
<script src="<?php echo e(asset('js/toastr.min.js')); ?>"></script>
<script type="text/javascript">
    <?php if(Session::has('success')): ?>
      toastr.success("<?php echo e(Session::get('success')); ?>");
    <?php elseif(Session::has('error')): ?>
      toastr.error("<?php echo e(Session::get('error')); ?>");
    <?php elseif(Session::has('warning')): ?>
      toastr.warning("<?php echo e(Session::get('warning')); ?>");
    <?php elseif(Session::has('info')): ?>
      toastr.info("<?php echo e(Session::get('info')); ?>");
    <?php endif; ?>
</script>
<script type="text/javascript"> 
     
  $('.alert-danger').delay(5000).fadeOut();
    
</script>

<script type="text/javascript" src="<?php echo e(asset('admin/custom/jquery.validate.min.js')); ?>"></script>
<?php echo $__env->yieldContent('js'); ?>

</body>
</html>
<?php /**PATH D:\Nikunj\qsport\resources\views/layouts/admin.blade.php ENDPATH**/ ?>