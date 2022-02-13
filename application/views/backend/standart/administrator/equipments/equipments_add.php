
<?php
        $query_string = $_SERVER['QUERY_STRING'];
?>

<!-- Fine Uploader Gallery CSS file
    ====================================================================== -->
<link href="<?= BASE_ASSET; ?>/fine-upload/fine-uploader-gallery.min.css" rel="stylesheet">
<!-- Fine Uploader jQuery JS file
    ====================================================================== -->
<script src="<?= BASE_ASSET; ?>/fine-upload/jquery.fine-uploader.js"></script>
<?php $this->load->view('core_template/fine_upload'); ?>
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
        Equipments        <small><?= cclang('new', ['Equipments']); ?> </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=""><a  href="<?= site_url('administrator/equipments?'.$query_string); ?>">Equipments</a></li>
        <li class="active"><?= cclang('new'); ?></li>
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
                            <h3 class="widget-user-username">Equipments</h3>
                            <h5 class="widget-user-desc"><?= cclang('new', ['Equipments']); ?></h5>
                            <hr>
                        </div>

			<div class="widget-user-header ">
                                <ul class="nav nav-pills">

			
				<?php 
					if(!empty($_GET)){
				?>
                                
				<?php
					}
				?>

                			<?php if(!empty($_GET['go_back'])) { ?>
                                        <a class="btn btn-sm btn-success" href="#" onclick="goBack()"><?= $_GET['go_back']; ?></a>
                                <?php } ?>
                                 </ul>
                        </div>

                        <?= form_open('', [
                            'name'    => 'form_equipments', 
                            'class'   => 'form-horizontal', 
                            'id'      => 'form_equipments', 
                            'enctype' => 'multipart/form-data', 
                            'method'  => 'POST'
                            ]); ?>
                         
                                                <div class="form-group ">
                            <label for="equipment_image" class="col-sm-2 control-label">Equipment Image 
                            </label>
                            <div class="col-sm-8">
                                <div id="equipments_equipment_image_galery"></div>
                                <input class="data_file" name="equipments_equipment_image_uuid" id="equipments_equipment_image_uuid" type="hidden" value="<?= set_value('equipments_equipment_image_uuid'); ?>">
                                <input class="data_file" name="equipments_equipment_image_name" id="equipments_equipment_image_name" type="hidden" value="<?= set_value('equipments_equipment_image_name'); ?>">
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="equipment_name" class="col-sm-2 control-label">Equipment Name 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="equipment_name" id="equipment_name" placeholder="Equipment Name" value="<?= set_value('equipment_name'); ?>">
                                <small class="info help-block">
                                <b>Input Equipment Name</b> Max Length : 4096.</small>
                            </div>
                        </div>
                                                 
                                                 

			<?php 
				if(!empty($_GET['equipment_category_id'])){
			?>
				<input type="hidden" name="equipment_category_id" id="equipment_category_id" value="<?= $_GET['equipment_category_id'] ?>" >
			 <?php
				} else {
			?>
			
			<div class="form-group ">
                            <label for="equipment_category_id" class="col-sm-2 control-label">Equipment Category Id 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select-deselect" name="equipment_category_id" id="equipment_category_id" data-placeholder="Select Equipment Category Id" >
                                    <option value=""></option>
                                    <?php foreach (db_get_all_data('equipment_category') as $row): ?>
                                    <option value="<?= $row->id ?>"><?= $row->name; ?></option>
                                    <?php endforeach; ?>  
                                </select>
                                <small class="info help-block">
                                <b>Input Equipment Category Id</b> Max Length : 11.</small>
                            </div>
                        </div>
			<?php } ?>
                                                 
                                                <div class="form-group ">
                            <label for="equipment_condition" class="col-sm-2 control-label">Equipment Condition 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select" name="equipment_condition" id="equipment_condition" data-placeholder="Select Equipment Condition" >
                                    <option value=""></option>
                                    <option value="NEW">NEW</option>
                                    <option value="OLD">OLD</option>
                                    <option value="BAD">BAD</option>
                                    <option value="FAIR">FAIR</option>
                                    </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="equipment_size" class="col-sm-2 control-label">Equipment Size 
                            <i class="required">*</i>
                            </label>
                            <div class="col-sm-8">
                                <select  class="form-control chosen chosen-select" name="equipment_size" id="equipment_size" data-placeholder="Select Equipment Size" >
                                    <option value=""></option>
                                    <option value="LONG">LONG</option>
                                    <option value="VERY LONG">VERY LONG</option>
                                    <option value="SHORT">SHORT</option>
                                    <option value="VERY SHORT">VERY SHORT</option>
                                    <option value="NA">NA</option>
                                    </select>
                                <small class="info help-block">
                                </small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="equipment_barcode" class="col-sm-2 control-label">Equipment Barcode 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="equipment_barcode" id="equipment_barcode" placeholder="Equipment Barcode" value="<?= set_value('equipment_barcode'); ?>">
                                <small class="info help-block">
                                <b>Input Equipment Barcode</b> Max Length : 4096.</small>
                            </div>
                        </div>
                                                 
                                                <div class="form-group ">
                            <label for="equipment_description" class="col-sm-2 control-label">Equipment Description 
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="equipment_description" id="equipment_description" placeholder="Equipment Description" value="<?= set_value('equipment_description'); ?>">
                                <small class="info help-block">
                                <b>Input Equipment Description</b> Max Length : 4096.</small>
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
            title: "<?= cclang('are_you_sure'); ?>",
            text: "<?= cclang('data_to_be_deleted_can_not_be_restored'); ?>",
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
              window.location.href = BASE_URL + 'administrator/equipments';
            }
          });
    
        return false;
      }); /*end btn cancel*/
    
      $('.btn_save').click(function(){
        $('.message').fadeOut();
            
        var form_equipments = $('#form_equipments');
        var data_post = form_equipments.serializeArray();
        var save_type = $(this).attr('data-stype');

        data_post.push({name: 'save_type', value: save_type});
    
        $('.loading').show();
    
        $.ajax({
          url: BASE_URL + '/administrator/equipments/add_save',
          type: 'POST',
          dataType: 'json',
          data: data_post,
        })
        .done(function(res) {
          if(res.success) {
            var id_equipment_image = $('#equipments_equipment_image_galery').find('li').attr('qq-file-id');
            

		redirect_forced = '';
		 
	
            if (save_type == 'back') {
              window.location.href = res.redirect;
              return;
            }
    
            $('.message').printMessage({message : res.message});
            $('.message').fadeIn();
            resetForm();

            if (typeof id_equipment_image !== 'undefined') {
                    $('#equipments_equipment_image_galery').fineUploader('deleteFile', id_equipment_image);
                }
            $('.chosen option').prop('selected', false).trigger('chosen:updated');
                
          } else {
            $('.message').printMessage({message : res.message, type : 'warning'});
          }
    
        })
        .fail(function(XMLHttpRequest, textStatus, errorThrown) {
	  console.log(XMLHttpRequest.responseText);
          $('.message').printMessage({message : 'Error save data', type : 'warning'});
        })
        .always(function() {
          $('.loading').hide();
          $('html, body').animate({ scrollTop: $(document).height() }, 2000);
        });
    
        return false;
      }); /*end btn save*/
      
              var params = {};
       params[csrf] = token;

       $('#equipments_equipment_image_galery').fineUploader({
          template: 'qq-template-gallery',
          request: {
              endpoint: BASE_URL + '/administrator/equipments/upload_equipment_image_file',
              params : params
          },
          deleteFile: {
              enabled: true, 
              endpoint: BASE_URL + '/administrator/equipments/delete_equipment_image_file',
          },
          thumbnails: {
              placeholders: {
                  waitingPath: BASE_URL + '/asset/fine-upload/placeholders/waiting-generic.png',
                  notAvailablePath: BASE_URL + '/asset/fine-upload/placeholders/not_available-generic.png'
              }
          },
          multiple : false,
          validation: {
              allowedExtensions: ["*"],
              sizeLimit : 0,
                        },
          showMessage: function(msg) {
              toastr['error'](msg);
          },
          callbacks: {
              onComplete : function(id, name, xhr) {
                if (xhr.success) {
                   var uuid = $('#equipments_equipment_image_galery').fineUploader('getUuid', id);
                   $('#equipments_equipment_image_uuid').val(uuid);
                   $('#equipments_equipment_image_name').val(xhr.uploadName);
                } else {
                   toastr['error'](xhr.error);
                }
              },
              onSubmit : function(id, name) {
                  var uuid = $('#equipments_equipment_image_uuid').val();
                  $.get(BASE_URL + '/administrator/equipments/delete_equipment_image_file/' + uuid);
              },
              onDeleteComplete : function(id, xhr, isError) {
                if (isError == false) {
                  $('#equipments_equipment_image_uuid').val('');
                  $('#equipments_equipment_image_name').val('');
                }
              }
          }
      }); /*end equipment_image galery*/
              
 
       
    
    
    }); /*end doc ready*/
</script>
