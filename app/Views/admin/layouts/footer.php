<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.0.0-rc.1
  </div>
</footer>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url().'/public/';?>design/AdminLTE/plugins/jquery/jquery.min.js"></script>

<!-- Lazy Load -->
<script src="<?php echo base_url().'/public/';?>design/AdminLTE/plugins/lazyload/lazyload.js"></script>


<!-- Bootstrap 4 rtl -->
<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url().'/public/';?>design/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- Bootstrap -->
<script src="<?php echo base_url().'/public/';?>design/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="<?php echo base_url().'/public/';?>design/AdminLTE/dist/js/adminlte.js"></script>

<!-- Bootstrap 4 rtl -->
<link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.5.3/css/bootstrap.min.css" integrity="sha384-JvExCACAZcHNJEc7156QaHXTnQL3hQBixvj5RV5buE7vgnNEzzskDtx9NQ4p6BJe" crossorigin="anonymous">



<!-- tostar -->
<script src="<?php echo base_url() . '/public/'; ?>design/js/toastr.js"></script>

<script>
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "7000",
    "extendedTimeOut": "4000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut",
    "toastClass": 'toastr'
  };

  // pdfMake.fonts = {
  //   Tajawal: {
  //     normal: '<?php echo base_url() . '/public/'; ?>design/fonts/Tajawal/Tajawal-Black.ttf',
  //     bold: '<?php echo base_url() . '/public/'; ?>design/fonts/Tajawal/Tajawal-Bold.ttf',
  //   },

    
  // }
</script>

<script>
  $("img.lazyload").lazyload();
</script>

</body>

</html>