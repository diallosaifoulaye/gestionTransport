



<!-- /.container-fluid -->
<footer class="footer text-center"> © 2019 BY NUMHERIT SA</footer>
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

<script src="<?= ASSETS; ?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?= ASSETS; ?>bootstrap/dist/js/bootstrap.min.js"></script>
<!--<script src="<?/*= WEBROOT */?>assets/plugins/bootstrap-3.3.7/js/bootstrap.js"></script>-->
<!-- Menu Plugin JavaScript -->
<script src="<?= ASSETS; ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
<!--slimscroll JavaScript -->
<script src="<?= ASSETS; ?>js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?= ASSETS; ?>js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= ASSETS; ?>js/custom.min.js"></script>
<!--Style Switcher -->
<script src="<?= ASSETS; ?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!-- FormValidation plugin and the class supports validating Bootstrap form -->
<script src="<?= ASSETS; ?>plugins/jquery-wizard-master/formValidation.min.js"></script>
<script src="<?= ASSETS; ?>plugins/jquery-wizard-master/bootstrap.min.js"></script>
<!-- Datatables JavaScript -->
<script src="<?= ASSETS; ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= ASSETS; ?>plugins/datatables/dataTables.bootstrap.js"></script>
<script src="<?= ASSETS; ?>plugins/datatables/extensions/Responsive/js/dataTables.responsive.js"></script>
<!-- Telephone -->
<script src="<?= ASSETS; ?>plugins/telPlug/js/intlTelInput.js"></script>
<script src="<?= ASSETS; ?>plugins/telPlug/js/utils.js"></script>
<!-- Custom tab JavaScript -->
<script src="<?= ASSETS; ?>ampleadmin-minimal/js/cbpFWTabs.js"></script>
<!-- Jquery-confirm JS -->
<script type="text/javascript" src="<?= ASSETS ?>plugins/jconfirm/js/jquery-confirm.js"></script>

<!-- Sweet-Alert  -->
<script src="<?= ASSETS; ?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>

<script src="<?= ASSETS; ?>plugins/select2/select2.full.min.js"></script>

<script src="<?= ASSETS; ?>plugins/passtrength/jquery.passtrength.js"></script>
<script src="<?= ASSETS; ?>plugins/jquery-timepicker-1.3.5/jquery.timepicker.min.js"></script>
<script src="<?= ASSETS; ?>js/bootstrap-datepicker.min.js"></script>
<script src="<?= ASSETS; ?>datetimepicker/build/jquery.datetimepicker.full.js"></script>

<!-- SunuFramework JavaScript -->
<script src="<?= ASSETS; ?>_main_/main.js"></script>

<!-- Date picker plugin-->
<script src="<?= ASSETS; ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= ASSETS; ?>plugins/jquery-ui/insertion_document.js"></script>

<script src="<?= ASSETS; ?>js/dropify.min.js"></script>
<!-- jQuery file upload -->
<script src="<?= ASSETS; ?>plugins/bower_components/dropify/dist/js/dropify.min.js"></script>

<!-- hightcharts -->
<script src="<?= ASSETS; ?>js/accessibility.js"></script>
<script src="<?= ASSETS; ?>js/data.js"></script>
<script src="<?= ASSETS; ?>js/drilldown.js"></script>
<script src="<?= ASSETS; ?>js/export-data.js"></script>
<script src="<?= ASSETS; ?>js/exporting.js"></script>
<script src="<?= ASSETS; ?>js/highcharts.js"></script>


<script>

    $(function () {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });

        $(".date_field").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });

        $("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });



    $(".select2").select2();

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








</body>

</html>