<?php
$CI = &get_instance();
$CI->load->view('templates/neraca/header.php');
$CI->load->view('templates/neraca/navbar.php');
?>
    <div class="col-md-12">
        <h4><i class="fa fa-book"></i> Buku Jurnal</h4>
        <div id="journalTable" data-remote="<?php echo base_url('neraca/journal-json'); ?>" class="table-responsive"> 
        </div>
    </div>
		
<?php
$CI->load->view('templates/neraca/fscript');
?>
<script type="text/javascript">
    requirejs(['jquery', 'watable'], function($){
        $(document).ready(function(){
            loadCss('assets/datepicker/css/datepicker');
            loadCss('assets/animate.css/animate.min');
            loadCss('assets/watable/watable');
            
            var w8 = $('#journalTable').WATable({
              url: $('#journalTable').attr('data-remote'),
              preFill: true,
              filter: true,
              transition: 'slide',
              transitionDuration: 0.5,
              
              actions: {
                filter: true,
                columnPicker: true,
                custom: [$('<a href="#" class="refresh"><span class="glyphicon glyphicon-refresh"></span>&nbsp;Refresh</a>'), $('<a href="#" class="export_all"><span class="glyphicon glyphicon-share"></span>&nbsp;Export rows</a>')]
              },
              'row-cls': 'col-sm-12'
            }).data('WATable');
            console.log(w8)
        });
        
    })
</script>
<?php
// FOOTER
$CI->load->view('templates/neraca/footer.php');
?>

