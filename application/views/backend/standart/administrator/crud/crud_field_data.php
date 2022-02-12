
 <div class="table-wrapper">
 <table class="table table-responsive table table-bordered table-striped"  id="diagnosis_list">
   <thead>
      <tr>
                           <th width="20" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;"><?= cclang('no') ?></th>
                           <th width="120" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;"><?= cclang('field'); ?></th>
                           <th width="80" colspan="4" style="text-align: center;"><?= cclang('show_in'); ?></th>
			   <th width="20" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;">Filterable</th>
			   <th width="20" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;">Exportable</th>
                           <th width="100" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;"><?= cclang('input_type'); ?></th>
                           <th width="200" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;"><?= cclang('validation'); ?></th>
                        </tr>
                        <tr>
                           <th width="60" class="module-page-list column" style="vertical-align: middle; text-align: center;"><?= cclang('column'); ?></th>
                           <th width="60" class="module-page-add add_form" style="vertical-align: middle; text-align: center;"><?= cclang('add_form'); ?></th>
                           <th width="60" class="module-page-update update_form" style="vertical-align: middle; text-align: center;"><?= cclang('update_form'); ?></th>
                           <th width="60" class="detail_page" style="vertical-align: middle; text-align: center;"><?= cclang('detail_page'); ?></th>
                        </tr> 
   </thead>
   <tbody>
      <?php $i=0; foreach ($this->db->field_data($table) as $row):  $i++; ?>
      <tr>
         <td  class="dragable">
            <i class="fa fa-bars fa-lg text-muted"></i>
            <input type="hidden" name="crud[<?=$i; ?>][<?=$row->name; ?>][sort]" class="priority" value="<?= $i; ?>" >
            <?php if ($row->primary_key == 1) { ?>
            <input type="hidden" name="primary_key" value="<?= $row->primary_key == 1? $row->name : ''; ?>" >
            <?php } ?>
            <input type="hidden" class="crud-id" id="crud-id" value="<?= $i; ?>" >
            <input type="hidden" class="crud-name" id="crud-name" value="<?= $row->name; ?>" >
            <input type="hidden" class="crud-data-type" id="crud-data-type" value="<?= $row->type; ?>" >
            <input type="hidden" class="crud-primarykey" id="crud-primarykey" value="<?= $row->primary_key; ?>" >
            <input type="hidden" class="crud-max-length" id="crud-max-length" value="<?= $row->max_length; ?>" >
         </td>
         <td>
         <input type="text" class="crud-input-initial" name="crud[<?=$i; ?>][<?=$row->name; ?>][label]" placeholder="<?= $row->name; ?>" value="<?= $row->name; ?>">
               
         </td>
         <td class="column">
            <input class="flat-red check" type="checkbox" <?= in_array($row->name, get_auto_generated_column()) || $row->primary_key ? '' : 'checked' ?> name="crud[<?=$i; ?>][<?=$row->name; ?>][show_in_column]" value="yes">
         </td>
         <td class="add_form">
            <input class="flat-red check" type="checkbox" <?= in_array($row->name, get_auto_generated_column()) || $row->primary_key ? '' : 'checked' ?> name="crud[<?=$i; ?>][<?=$row->name; ?>][show_in_add_form]" value="yes">
         </td>
         <td class="update_form">
            <input class="flat-red check" type="checkbox" <?= in_array($row->name, get_auto_generated_column()) || $row->primary_key ? '' : 'checked' ?> name="crud[<?=$i; ?>][<?=$row->name; ?>][show_in_update_form]" value="yes">
         </td>
         <td class="detail_page">
            <input class="flat-red check" type="checkbox" <?= in_array($row->name, get_auto_generated_column())  ? '' : 'checked' ?> name="crud[<?=$i; ?>][<?=$row->name; ?>][show_in_detail_page]" value="yes">
         </td>
	 <td class="detail_page">
            <center><input class="flat-red check" type="checkbox" <?= in_array($row->name, get_auto_generated_column()) || $row->primary_key ? '' : 'checked' ?> name="crud[<?=$i; ?>][<?=$row->name; ?>][field_filterable]" value="yes"></center>
         </td>
	 <td class="detail_page">
            <center><input class="flat-red check" type="checkbox" <?= in_array($row->name, get_auto_generated_column()) || $row->primary_key ? '' : 'checked' ?> name="crud[<?=$i; ?>][<?=$row->name; ?>][field_exportable]" value="yes"></center>
         </td>
         <td>
            <div class="col-md-12">
               <div class="form-group ">
                  <select  class="form-control chosen chosen-select input_type" name="crud[<?=$i; ?>][<?=$row->name; ?>][input_type]" id="input_type" tabi-ndex="5" data-placeholder="Select Type" >
                     <option value="" class="<?= $this->model_crud->get_input_type(); ?>"></option>
                     <?php foreach (db_get_all_data('crud_input_type') as $input): 
                        if (preg_match('/image|photo|img|file/', $row->name) AND $input->type == 'file') {
                           $selected = 'selected';
                        } elseif ($row->type == $input->type OR ($row->type == 'timestamp' AND $input->type == 'timestamp')) {
                           $selected = 'selected';
                        } elseif ($row->type == 'int' AND $input->type == 'number') {
                           $selected = 'selected';
                        } elseif ($row->type == 'text' AND $input->type == 'editor_wysiwyg') {
                           $selected = 'selected';
                        } elseif ($row->type == 'tinytext' AND $input->type == 'textarea') {
                           $selected = 'selected';
                        } elseif (($row->type == 'varchar' OR $row->type == 'tinyint') AND $input->type == 'input') {
                           $selected = 'selected';
                        } elseif (($row->type == 'decimal') AND $input->type == 'input') {
                           $selected = 'selected';
                        } elseif ($input->type == 'input') {
                           $selected = 'selected';
                        } else {
                           $selected = '';
                        }
                     ?>
                     <option value="<?= $input->type; ?>" class="<?= $input->type; ?>" title="<?= $input->validation_group; ?>" relation="<?= $input->relation; ?>" custom-value="<?= $input->custom_value; ?>" <?= _ent($selected); ?>><?= _ent(ucwords(clean_snake_case($input->type))); ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="custom-option-container display-none">
               <div class="custom-option-contain">
                  <div class="custom-option-item">
                     <div class="box-custom-option padding-left-0 box-top"> 
                        <div class="col-md-3"><?= cclang('value') ?></div>  <input type="text" name="crud[<?=$i; ?>][<?= $row->name; ?>][custom_option][0][value]"></label>
                     </div>
                     <div class="box-custom-option padding-left-0 box-bottom"> 
                        <div class="col-md-3"><?= cclang('label') ?></div>  <input type="text" name="crud[<?=$i; ?>][<?= $row->name; ?>][custom_option][0][label]">
                     </div>
                     <a class="text-red delete-option fa fa-trash" data-original-title="" title=""></a> 
                  </div>
               </div>
                <a class="box-custom-option input btn btn-flat btn-block bg-black  add-option"> 
                <i class="fa fa-plus-circle"></i> <?= cclang('add_new_option') ?>
               </a>
            </div>

            <div class="col-md-12" style="margin:0px !important">
               <div class="form-group display-none ">
                  <label><small class="text-muted"><?= cclang('table_reff') ?></small></label>
                  <select  class="form-control chosen chosen-select relation_table relation_field" name="crud[<?=$i; ?>][<?=$row->name; ?>][relation_table]" id="relation_table" tabi-ndex="5" data-placeholder="Select Table" >
                     <option value=""></option>
                      <?php foreach ($this->db->list_tables() as $table): ?>
                     <option value="<?= $table; ?>"><?= $table; ?></option>
                     <?php endforeach; ?>  
                  </select>
               </div>
            </div>
            <div class="col-md-12" style="margin:0px !important">
               <div class="form-group display-none ">
                  <label><small class="text-muted"><?= cclang('value_field_reff') ?></small></label>
                  <select  class="form-control chosen chosen-select relation_value relation_field" name="crud[<?=$i; ?>][<?=$row->name; ?>][relation_value]" id="relation_value" tabi-ndex="5" data-placeholder="Select ID" >
                     <option value=""></option>
                  </select>
               </div>
            </div>
            <div class="col-md-12" style="margin:0px !important">
               <div class="form-group display-none ">
                  <label><small class="text-muted"><?= cclang('label_field_reff') ?></small></label>
                  <select  class="form-control chosen chosen-select relation_label relation_field" name="crud[<?=$i; ?>][<?=$row->name; ?>][relation_label]" id="relation_label" tabi-ndex="5" data-placeholder="Select Label" >
                     <option value=""></option>
                  </select>
               </div>
            </div>
         </td>
         <td>
            <div class="col-md-12">
               <div class="form-group ">
                  <select  class="form-control chosen chosen-select validation" name="crud[<?=$i; ?>][<?=$row->name; ?>][validation]" id="validation" tabi-ndex="5" data-placeholder="+ Add Rules">
                      <option value="" class="input file number text datetime select"></option>
                      <?php 
                      foreach (db_get_all_data('crud_input_validation') as $input): 
                      ?>
                        <option value="<?= $input->validation; ?>" class="<?= str_replace(',', ' ', $input->group_input); ?>" data-group-validation="<?= str_replace(',', ' ', $input->group_input); ?>" data-placeholder="<?= $input->input_placeholder; ?>" title="<?= $input->input_able; ?>"><?= ucwords(clean_snake_case($input->validation)); ?></option>
                       <?php endforeach; ?> 
                  </select>
               </div>
            </div>
         </td>
      </tr>
      <?php endforeach; ?>
   </tbody>
</table>
</div>

<div class="wrapper-crud col-sm-12">
                        <b>Use {{id}} in url to replace value with generated primary key </b>
                        <div class="form-group col-sm-12">
                                <label for="label" class="col-sm-2 control-label">Redirect on Add</label>
                                <div class="col-sm-8">
                                        <input type="text" class="form-control" name="redirect_add" id="redirect_add" value="">
                                </div>
                        </div>
                        <div class="form-group col-sm-12">
                                <label for="label" class="col-sm-2 control-label">Redirect on Update</label>
                                <div class="col-sm-8">
                                        <input type="text" class="form-control" name="redirect_update" id="redirect_update" value="">
                                </div>
                        </div>
</div>


                <div class="wrapper-crud">
                        <b>Use {{col}} in url to replace value with column of the table. <br> Use go_back=name to add go back link</b>
                        <b>Use {{col_get}} to use get paramter passed in current url. <br> Use go_back=name to add go back link</b>
                        <table class="table table-responsive table table-bordered table-striped"  id="diagnosis_list">
                                <thead>
                        <tr>
                           <th width="20" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;">No</th>
                           <th width="120" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;">Menu Name</th>
                           <th width="80" colspan="4" style="text-align: center;"><?= cclang('show_in'); ?></th>
                           <th width="250" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;">Link</th>
                           <th width="100" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;">Table Column</th>
                           <th width="50" rowspan="2" valign="midle" style="vertical-align: middle; text-align: center;">Active</th>
                        </tr>
                        <tr>
                           <th width="60" class="module-page-list column" style="vertical-align: middle; text-align: center;"><?= cclang('column'); ?></th>
                           <th width="60" class="module-page-add add_form" style="vertical-align: middle; text-align: center;"><?= cclang('add_form'); ?></th>
                           <th width="60" class="module-page-update update_form" style="vertical-align: middle; text-align: center;"><?= cclang('update_form'); ?></th>
                           <th width="60" class="detail_page" style="vertical-align: middle; text-align: center;"><?= cclang('detail_page'); ?></th>
                        </tr>
                     </thead>
                                <tbody>
                                        <?php for($j = 0; $j < 4; $j++) { $i++; ?>
                                        <tr>
                                                <td  class="dragable">
                                                        <i class="fa fa-bars fa-lg text-muted"></i>
                                                        <input type="hidden" name="crud_nav_menu[<?=$i; ?>][sort]" class="priority" value="<?= $i; ?>" >
                                                </td>
                                                <td>
                                                        <div style="margin-bottom: -10px;">
                                                                <span class="fa fa-trash text-danger btn-remove-field " style="margin-top:-20px; left:0px;  position:relative; cursor: pointer;"></span>
                                                        </div>
                                                        <input type="text" class="crud-input-initial" name="crud_nav_menu[<?=$i; ?>][nav_menu_name]">

                                                </td>
                                                <td class="column">
                                                        <input class="flat-red check" type="checkbox" name="crud_nav_menu[<?=$i; ?>][show_list]" value="yes" selected>
                                                </td>
                                                <td class="column">
                                                        <input class="flat-red check" type="checkbox" name="crud_nav_menu[<?=$i; ?>][show_add]" value="yes" >
                                                </td>

                                                <td class="column">
                                                        <input class="flat-red check" type="checkbox" name="crud_nav_menu[<?=$i; ?>][show_edit]" value="yes" selected>
                                                </td>

                                                <td class="column">
                                                        <input class="flat-red check" type="checkbox" name="crud_nav_menu[<?=$i; ?>][show_view]" value="yes" selected>
                                                </td>

                                                <td>
                                                        <input type="text" class="crud-input-initial" name="crud_nav_menu[<?=$i; ?>][nav_menu_link]">
                                                </td>

                                                <td>
                                                        <select  class="form-control" name="crud_nav_menu[<?=$i; ?>][link_column]" tab-index="5" data-placeholder="Select Column" >
                                                                <option value=""></option>
                                                                <?php foreach ($this->db->field_data($table) as $col_detail): ?>
                                                                        <option value="<?= $col_detail->name ?>"><?= $col_detail->name; ?></option>
                                                                <?php endforeach; ?>
                                                        </select>
                                                </td>

                                                <td class="column">
                                                        <input class="flat-red check" type="checkbox" name="crud_nav_menu[<?=$i; ?>][is_active]" value="yes">
                                                </td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                        </table>
                </div>

