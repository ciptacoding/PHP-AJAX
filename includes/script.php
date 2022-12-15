<!-- Bootstrap core JavaScript-->
<script src="<?= URL_ROOT ?>/assets/jquery/jquery.min.js"></script>
<script src="<?= URL_ROOT ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= URL_ROOT ?>/assets/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= URL_ROOT ?>/assets/js/sb-admin-2.min.js"></script>

<script>
    // upload file name
    $('input[type="file"]').change(function(e) {
        let fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
</script>