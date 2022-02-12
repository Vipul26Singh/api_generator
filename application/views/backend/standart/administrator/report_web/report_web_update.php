
<?php
        $query_string = $_SERVER['QUERY_STRING'];
?>


<script src="<?= BASE_ASSET; ?>/js/jquery.hotkeys.js"></script>
<script type="text/javascript">
    function domo(){
     
       // Binding keys
       $('*').bind('keydown', 'Ctrl+s', function assets() {
          $('#btn_save').trigger('click');
           return false;
       });
    
       $('*').bind('keydown', 'Ctrl+x', function assets() {
          $('#btn_cancel').trigger('click');
           return false;
       });
    
      $('*').bind('keydown', 'Ctrl+d', function assets() {
          $('.btn_save_back').trigger('click');
           return false;
       });
        
    }
    
    jQuery(document).ready(domo);
function goBack() {
    window.history.back();
}

</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Report Web        <small>Edit Report Web</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/report_web?'.$query_string); ?>">Report Web</a></li>
        <li class="active">Edit</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row" >
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-body ">
                    <!-- Widget: user widget style 1 -->
                    <div class="box box-widget widget-user-2">
                        <!-- Add the bg color to the header using any of the bg-* classes -->
                        <div class="widget-user-header ">
                            <div class="widget-user-image">
                                <img class="img-circle" src="<?= BASE_ASSET; ?>/img/add2.png" alt="User Avatar">
                            </div>
                            <!-- /.widget-user-image -->
                            <h3 class="widget-user-username">Report Web</h3>
                            <h5 class="widget-user-desc">Edit Report Web</h5>
                            <hr>
                        </div>

		          <div class="widget-user-header ">
                                <ul class="nav nav-pills">

			

                                
                				<?php if(!empty($_GET['go_back'])) { ?>
                                        <a class="btn btn-sm btn-success" href="#" onclick="goBack()"><?= $_GET['go_back']; ?></a>
                                <?php } ?>
                                 </ul>
                        </div>

                        <?= form_open(base_url('administrator/report_web/edit_save/'.$this->uri->segment(4)), [
                            'name'    => 'form_report_web', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_report_web', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="report_name" class="col-sm-2 control-label">Report Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="report_name" id="report_name" placeholder="Report Name" value="<?= set_value('report_name', $report_web->report_name); ?>">
                                <small class="info help-block">
                                <b>Input Report Name</b> Max Length : 50.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="table_name" class="col-sm-2 control-label">Table Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="table_name" id="table_name" placeholder="Table Name" value="<?= set_value('table_name', $report_web->table_name); ?>">
                                <small class="info help-block">
                                <b>Input Table Name</b> Max Length : 2048.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="parent_report_id" class="col-sm-2 control-label">Parent Report Id 
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="parent_report_id" id="parent_report_id" data-placeholder="Select Parent Report Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('report_web') as $row): ?>
                                    <option <?=  $row->id ==  $report_web->parent_report_id ? 'selected' : ''; ?> value="<?= $row->id ?>"><?= $row->report_name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Parent Report Id</b> Max Length : 11.</small>
                            </div>
                        </div>

                                                 
                                                <div class="form-group ">
                            <label for="icon" class="col-sm-2 control-label">Icon 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" value="<?= set_value('icon', $report_web->icon); ?>">
                                <small class="info help-block">
                                <b>Input Icon</b> Max Length : 25.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="sequence" class="col-sm-2 control-label">Sequence 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="sequence" id="sequence" placeholder="Sequence" value="<?= set_value('sequence', $report_web->sequence); ?>">
                                <small class="info help-block">
                                <b>Input Sequence</b> Max Length : 11.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="columns" class="col-sm-2 control-label">Columns 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="columns" id="columns" placeholder="Columns" value="<?= set_value('columns', $report_web->columns); ?>">
                                <small class="info help-block">
                                <b>Input Columns</b> Max Length : 4096.</small>
                            </div>
                        </div>
                                                
                        <div class="message"></div>
                        <div class="row-fluid col-md-7">
                            <button class="btn btn-flat btn-primary btn_save btn_action" id="btn_save" data-stype='stay' title="<?= cclang('save_button'); ?> (Ctrl+s)">
                            <i class="fa fa-save" ></i> <?= cclang('save_button'); ?>
                            </button>
                            <a class="btn btn-flat btn-info btn_save btn_action btn_save_back" id="btn_save" data-stype='back' title="<?= cclang('save_and_go_the_list_button'); ?> (Ctrl+d)">
                            <i class="ion ion-ios-list-outline" ></i> <?= cclang('save_and_go_the_list_button'); ?>
                            </a>
                            <a class="btn btn-flat btn-default btn_action" id="btn_cancel" title="<?= cclang('cancel_button'); ?> (Ctrl+x)">
                            <i class="fa fa-undo" ></i> <?= cclang('cancel_button'); ?>
                            </a>
                            <span class="loading loading-hide">
                            <img src="<?= BASE_ASSET; ?>/img/loading-spin-primary.svg"> 
                            <i><?= cclang('loading_saving_data'); ?></i>
                            </span>
                        </div>
                        <?= form_close(); ?>
                    </div>
                </div>
                <!--/box body -->
            </div>
            <!--/box -->
        </div>
    </div>
</section>
<!-- /.content -->
<!-- Page script -->
<script>
    $(document).ready(function(){
      
             
      $('#btn_cancel').click(function(){
        swal({
            title: "Are you sure?",
            text: "the data that you have created will be in the exhaust!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: true,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
              window.location.href = BASE_URL + 'administrator/report_web';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_report_web = $('#form_report_web');
        var data_post = form_report_web.serializeArray();
        var save_type = $(this).attr('data-stype');
        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: form_report_web.attr('action'),
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id = $('#report_web_image_galery').find('li').attr('qq-file-id');
	 

            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            $('.data_file_uuid').val('');
    
          } else {
            $('.message').printMessage({message : res.message, type : 'warning'});
          }
    
        })
        .fail(function() {
          $('.message').printMessage({message : 'Error save data', type : 'warning'});
        })
        .always(function() {
          $('.loading').hide();
          $('html, body').animate({ scrollTop: $(document).height() }, 2000);
        });
    
        return false;
      }); /*end btn save*/
      
       
       
           
    
    }); /*end doc ready*/
</script>
