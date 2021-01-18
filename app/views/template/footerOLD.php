<!-- /.container-fluid -->
<footer class="footer text-center"> © 2018 BY NUMHERIT SA</footer>
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<!-- jQuery -->

<script src="<?= WEBROOT ?>assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?= WEBROOT ?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= WEBROOT ?>assets/plugins/bootstrap-3.3.7/js/bootstrap.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?= WEBROOT ?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?= WEBROOT ?>assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?= WEBROOT ?>assets/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= WEBROOT ?>assets/js/custom.min.js"></script>
<!--Style Switcher -->
<script src="<?= WEBROOT ?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!-- FormValidation plugin and the class supports validating Bootstrap form -->
<script src="<?= WEBROOT; ?>assets/plugins/jquery-wizard-master/formValidation.min.js"></script>
<script src="<?= WEBROOT; ?>assets/plugins/jquery-wizard-master/bootstrap.min.js"></script>
<!-- Datatables JavaScript -->
<script src="<?= WEBROOT ?>assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= WEBROOT ?>assets/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?= WEBROOT ?>assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.js"></script>
<!-- Telephone -->
<script src="<?= WEBROOT ?>assets/plugins/telPlug/js/intlTelInput.js"></script>
<script src="<?= WEBROOT ?>assets/plugins/telPlug/js/utils.js"></script>
<!-- Custom tab JavaScript -->
<script src="<?= WEBROOT; ?>assets/ampleadmin-minimal/js/cbpFWTabs.js"></script>
<!-- Jquery-confirm JS -->
<script type="text/javascript" src="<?= ASSETS ?>plugins/jconfirm/js/jquery-confirm.js"></script>
<script type="text/javascript" src="<?= ASSETS ?>plugins/select2/select2.full.js"></script>
<!-- Sweet-Alert  -->
<script src="<?= WEBROOT; ?>assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script src="<?= WEBROOT; ?>assets/js/jQuery.style.switcher.js"></script>

<script src="<?= WEBROOT; ?>assets/js/dropify.min.js"></script>
<!-- jQuery file upload -->
<script src="<?= WEBROOT ?>assets/plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
<script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: '<?= $this->lang['default'];  ?>',
                replace: '<?= $this->lang['replace'];  ?>',
                remove:  '<?= $this->lang['remove'];  ?>',
                error:   '<?= $this->lang['error'];  ?>'
            },
            error: {
                'fileSize': 'The file size is too big ({{ value }} max).',
                'minWidth': 'The image width is too small ({{ value }}}px min).',
                'maxWidth': 'The image width is too big ({{ value }}}px max).',
                'minHeight': 'The image height is too small ({{ value }}}px min).',
                'maxHeight': 'The image height is too big ({{ value }}px max).',
                'imageFormat': 'The image format is not allowed ({{ value }} only).'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
</script>
<script src="<?= WEBROOT; ?>assets/js/kendo.all.min.js"></script>
<script src="<?= WEBROOT; ?>assets/js/typeahead.js"></script>

<script src="<?= WEBROOT; ?>assets/plugins/passtrength/jquery.passtrength.js"></script>
<!-- SunuFramework JavaScript -->
<script src="<?= WEBROOT ?>assets/_main_/main.js"></script>


</body>

</html>