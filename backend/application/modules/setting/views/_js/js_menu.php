<script>
  $(document).ready(function(){
	  // ID
	  var tableId = 't_menu';
	  var tableId2 = 't_role';
	  var t_table = $('div#t_table');
	  var t_table2 = $('#t_table2');
	  var t_form_add = $('#t_form_add');
	  var t_form_edit = $('#t_form_edit');
	  var t_form_role = $('#t_form_role');
	  var form1 = $('#form_add');
	  var form2 = $('#form_edit');
	  var form3 = $('#form_role');
	  var cancel1 = $('#cancel1');
	  var cancel2 = $('#cancel2');
	  var cancel3 = $('#cancel3');

	  var form_control = $('.form-control');

	  var parent = $('#parent',form1);
	  var subparent = $('#subparent',form1);
	  var flag = $('#flag',form1);
	  var flag2 = $('#flag2',form1);
	  var control = $('#control',form1);

	  var parent2 = $('#parent',form2);
	  var subparent2 = $('#subparent',form2);
	  var flag22 = $('#flag',form2);
	  var flag222 = $('#flag2',form2);
	  var control2 = $('#control',form2);

	  // DEFAULT ELEMENT
	  var hbody = $('html,body');

	  // HIDE ELEMENT
	  t_form_add.hide();
	  t_form_edit.hide();
	  t_form_role.hide();
	  
	  // BEGIN AJAX START
	  var block = false;

	  $(document).ajaxStart(function(){
		  if(block == false){
			  $.blockUI({
				  message: '<div style="padding:5px 0;">Sedang Proses, Mohon Tunggu...</div>',
				  css: {
					  backgroundColor: '#fff',
					  color: '#000',
					  fontSize: '12px'
				  }
			  });
		  }
	  }).ajaxStop($.unblockUI);

	  $('#add_menu').click(function(){
		  t_table.fadeOut();
		  t_form_add.fadeIn();
		  form1.trigger('reset');
		  form_control.parent('.input-icon').children('i').removeClass('fa-check');
		  form_control.parent('.input-icon').children('i').removeClass('fa-warning');
		  form_control.closest('.form-group').removeClass('has-error');
		  form_control.closest('.form-group').removeClass('has-success');
	  });

	  parent.change(function(){
		  var opsi = $('#parent option:selected',form1).attr('flag');
		  var subopsi = $('#parent option:selected',form1).attr('subparent');
		  
		  if(opsi == 2){
			  flag.attr('disabled',true);
			  flag.val('1');
			  flag2.val(opsi);
			  subparent.val(subopsi);
			  control.attr('readonly',false);
			  control.val('');
		  } else if(opsi == 1) {
			  flag.attr('disabled',false);
			  flag.val('0');
			  flag2.val(opsi);
			  subparent.val(subopsi);
			  control.attr('readonly',true);
			  control.val('');
		  } else {
			  flag.attr('disabled',false);
			  flag.val('0');
			  flag2.val(opsi);
			  subparent.val(subopsi);
			  control.attr('readonly',true);
			  control.val('');
		  }
	  });

	  flag.change(function(){
		  var flags = $(this).val();
		  
		  if(flags == 1){
			  control.attr('readonly',false);
			  control.val('');
		  } else {
			  control.attr('readonly',true);
			  control.val('javascript:;');
		  }
	  });

	  cancel1.click(function(){
		  t_table.fadeIn();
		  t_form_add.fadeOut();
	  });

	  form1.validate({
		  rules: {
			  menu: {
				  required: true
			  },
			  control: {
				  required: true
			  }
		  },

		  //display error alert on form submit
		  invalidHandler: function(event, validator) {
		  	  KTUtil.scrollTop();
		  },

		  submitHandler: function (form){
			  $.ajax({
				  type: 'POST',
				  url: 'setting/pamenu',
				  dataType: 'json',
				  data: form1.serialize(),
				  success: function(response){
					  var result = response.result;
					  var message = response.message;

					  if(result == true){
						  swal.fire({
						  	  title: 'Sukses!',
						  	  text: response.message,
						  	  type: 'success'
	                      });

	                      cancel1.trigger('click');
	                      dTreload(tableId);
					  } else {
						  swal.fire({
						  	  title: 'Maaf!',
						  	  text: response.message,
						  	  type: 'error'
                          });
					  }
				  },
				  error: function(){
					  swal.fire({
					  	  title: 'Maaf!',
					  	  text: 'Tidak ada koneksi internet.',
					  	  type: 'error'
                      });
				  }
			  });
		  }
	  });

	  $('#'+tableId).jqGrid({
		  url: 'setting/apimenu',
		  datatype: 'json',
		  height: '300',
		  rowNum: 15,
		  autowidth: true,
		  shrinkToFit: false,
		  rowList: [15,30,60,120,240],
		  colNames:['ID','Title','URL','Parent','Status','Tindakan'],
		  colModel:[
		  	{name:'id',index:'id',hidden:true},
			{name:'title',index:'title',align:'center'},
			{name:'link',index:'link',align:'center'},
			{name:'parent',index:'parent',align:'center'},
			{name:'status',index:'status',align:'center'},
			{name:'action',index:'action',align:'center'}
		  ],
		  pager: '#pager_menu',
		  viewrecords: true,
		  multiselect: true,
		  grouping: true,
		  rownumbers: false,
		  sortname: 'parent'
	  });

	  $(document).on('click','a#edit_menu',function(){
		  t_table.fadeOut();
		  t_form_add.fadeOut();
		  t_form_edit.fadeIn();

		  form2.trigger('reset');
		  form_control.parent('.input-icon').children('i').removeClass('fa-check');
		  form_control.parent('.input-icon').children('i').removeClass('fa-warning');
		  form_control.closest('.form-group').removeClass('has-error');

		  var m_id = $(this).attr('m_id');

		  var e_id = $('#id',form2);
		  var e_parent = $('#parent',form2);
		  var e_subparent = $('#subparent',form2);
		  var e_menu = $('#menu',form2);
		  var e_flag = $('#flag',form2);
		  var e_flag2 = $('#flag2',form2);
		  var e_control = $('#control',form2);

		  $.ajax({
			  type: 'POST',
			  url: 'setting/get_menu_by_id',
			  data: {m_id:m_id},
			  dataType: 'json',
			  success: function(response){
				  var id = response.id;
				  var parent = response.parent;
				  var menu = response.menu;
				  var control = response.control;
				  var subparent = response.subparent;
				  var flag = response.flag;

				  if(flag == 0){
					  var flag_val = '0';
					  e_control.attr('readonly',true);
				  } else if(flag == 1) {
					  var flag_val = subparent;
					  e_control.attr('readonly',false);
				  } else {
					  var flag_val = subparent;
					  e_control.attr('readonly',false);
				  }

				  if(control == 'javascript:;'){
					  var control_val = '2';
				  } else {
					  var control_val = '1';
				  }

				  e_flag.attr('disabled',true);

				  e_id.val(id);
				  e_parent.val(flag_val).trigger('chosen:updated.chosen');
				  e_menu.val(menu);
				  e_control.val(control);

				  var flag_subparent = $('#parent option:selected',form2).attr('subparent');
				  e_subparent.val(flag_subparent);

				  e_flag.val(control_val);
				  e_flag2.val(flag);
			  },
			  error: function(){
				  swal.fire({
				  	title: 'Maaf!',
				  	text: 'Tidak ada koneksi internet.',
				  	type: 'error'
                  });

				  t_table.fadeIn();
				  t_form_add.fadeOut();
				  t_form_edit.fadeOut();
			  }
		  });
	  });

	  parent2.change(function(){
		  var opsi2 = $('#parent option:selected',form2).attr('flag');
		  var subopsi2 = $('#parent option:selected',form2).attr('subparent');

		  if(opsi2 == 2){
			  flag22.attr('disabled',true);
			  flag22.val('1');
			  flag222.val(opsi2);
			  subparent2.val(subopsi2);
			  control2.attr('readonly',false);
			  control2.val('');
		  } else if(opsi2 == 1) {
			  flag22.attr('disabled',false);
			  flag22.val('0');
			  flag222.val(opsi2);
			  subparent2.val(subopsi2);
			  control2.attr('readonly',true);
			  control2.val('');
		  } else {
			  flag22.attr('disabled',false);
			  flag22.val('0');
			  flag222.val(opsi2);
			  subparent2.val(subopsi2);
			  control2.attr('readonly',true);
			  control2.val('');
		  }
	  });
	  
	  flag22.change(function(){
		  var flags22 = $(this).val();
		  
		  if(flags22 == 1){
			  control2.attr('readonly',false);
			  control2.val('');
		  } else {
			  control2.attr('readonly',true);
			  control2.val('javascript:;');
		  }
	  });

	  // BEGIN FORM EDIT VALIDATION
	  form2.validate({
		  rules: {
			  menu: {
				  required: true
			  },
			  control: {
				  required: true
			  }
		  },

		  //display error alert on form submit
		  invalidHandler: function(event, validator) {
		  	  KTUtil.scrollTop();
		  },

		  submitHandler: function (form){
			  $.ajax({
				  type: 'POST',
				  url: 'setting/pemenu',
				  dataType: 'json',
				  data: form2.serialize(),
				  success: function(response){
					  var result = response.result;
					  var message = response.message;

					  if(result == true){
						  swal.fire({
						  	  title: 'Sukses!',
						  	  text: response.message,
						  	  type: 'success'
	                      });

	                      cancel2.trigger('click');
	                      dTreload(tableId);
					  } else {
						  swal.fire({
						  	  title: 'Maaf!',
						  	  text: response.message,
						  	  type: 'error'
                          });
					  }
				  },
				  error: function(){
					  swal.fire({
					  	  title: 'Maaf!',
					  	  text: 'Tidak ada koneksi internet.',
					  	  type: 'error'
                      });
				  }
			  });
		  }
	  });

	  cancel2.click(function(){
		  t_table.fadeIn();
		  t_form_edit.fadeOut();
	  });

	  $('#delete_menu').click(function(){
		  var rowKey = $('#'+tableId).getGridParam('selrow');

		  if(!rowKey){
			  alert('Item belum dipilih');
		  } else {
			  var conf = confirm('Data ingin dihapus?');
			  var selectedIDs = $('#'+tableId).getGridParam('selarrrow');

			  if(conf){
				  $.ajax({
					  type: 'POST',
					  url: 'setting/pdmenu',
					  data: {object:selectedIDs},
					  dataType: 'json',
					  success: function(response){
						  var result = response.result;
						  var message = response.message;

						  if(result == true){
							  swal.fire({
							  	title: 'Sukses!',
							  	text: response.message,
							  	type: 'success'
		                      });

							  dTreload(tableId);
						  } else {
							  swal.fire({
							  	title: 'Maaf!',
							  	text: response.message,
							  	type: 'error'
		                      });
						  }
					  },
					  error: function(){
						  swal.fire({
						  	title: 'Maaf!',
						  	text: 'Tidak ada koneksi internet.',
						  	type: 'error'
		                  });
					  }
				  });
			  }
		  }
	  });

	  $('#show_menu').click(function(){
		  var rowKey = $('#'+tableId).getGridParam('selrow');

		  if(!rowKey){
			  alert('Item belum dipilih');
		  } else {
			  var conf = confirm('Data ingin diaktifkan?');
			  var selectedIDs = $('#'+tableId).getGridParam('selarrrow');

			  if(conf){
				  $.ajax({
					  type: 'POST',
					  url: 'setting/psmenu',
					  data: {object:selectedIDs},
					  dataType: 'json',
					  success: function(response){
						  var result = response.result;
						  var message = response.message;

						  if(result == true){
							  swal.fire({
							  	title: 'Sukses!',
							  	text: response.message,
							  	type: 'success'
		                      });

							  dTreload(tableId);
						  } else {
							  swal.fire({
							  	title: 'Maaf!',
							  	text: response.message,
							  	type: 'error'
		                      });
						  }
					  },
					  error: function(){
						  swal.fire({
						  	title: 'Maaf!',
						  	text: 'Tidak ada koneksi internet.',
						  	type: 'error'
		                  });
					  }
				  });
			  }
		  }
	  });

	  $('#hide_menu').click(function(){
		  var rowKey = $('#'+tableId).getGridParam('selrow');

		  if(!rowKey){
			  alert('Item belum dipilih');
		  } else {
			  var conf = confirm('Data ingin di-non-aktifkan?');
			  var selectedIDs = $('#'+tableId).getGridParam('selarrrow');

			  if(conf){
				  $.ajax({
					  type: 'POST',
					  url: 'setting/phmenu',
					  data: {object:selectedIDs},
					  dataType: 'json',
					  success: function(response){
						  var result = response.result;
						  var message = response.message;

						  if(result == true){
							  swal.fire({
							  	title: 'Sukses!',
							  	text: response.message,
							  	type: 'success'
		                      });

							  dTreload(tableId);
						  } else {
							  swal.fire({
							  	title: 'Maaf!',
							  	text: response.message,
							  	type: 'error'
		                      });
						  }
					  },
					  error: function(){
						  swal.fire({
						  	title: 'Maaf!',
						  	text: 'Tidak ada koneksi internet.',
						  	type: 'error'
		                  });
					  }
				  });
			  }
		  }
	  });

	  $('#'+tableId2).jqGrid({
		  url: 'setting/apirole',
		  datatype: 'json',
		  height: '300',
		  rowNum: 15,
		  width: '500',
		  shrinkToFit: false,
		  rowList: [15,30,60,120,240],
		  colNames:['ID','Grup','Tindakan'],
		  colModel:[
		  	{name:'id',index:'id',hidden:true},
			{name:'group',index:'group',align:'center'},
			{name:'action',index:'action',align:'center'}
		  ],
		  pager: '#pager_role',
		  viewrecords: true,
		  multiselect: false,
		  grouping: false,
		  rownumbers: true,
		  sortname: '`group`'
	  });

	  cancel3.click(function(){
		  t_table2.fadeIn();
		  t_form_role.fadeOut();
	  });

	  // BEGIN EDIT ROLE
	  $(document).on('click','a#edit_role',function(){
		  t_table2.fadeOut();
		  t_form_role.fadeIn();
		  form3.trigger('reset');
		  form_control.parent('.input-icon').children('i').removeClass('fa-check');
		  form_control.parent('.input-icon').children('i').removeClass('fa-warning');
		  form_control.closest('.form-group').removeClass('has-error');

		  var r_id = $(this).attr('r_id');

		  $.ajax({
			  type: 'POST',
			  url: 'setting/get_role_by_foreign',
			  data: {r_id:r_id},
			  dataType: 'html',
			  success: function(response){
				  $('#permission').html(response);
			  },
			  error: function(){
				  swal.fire({
				  	title: 'Maaf!',
				  	text: 'Tidak ada koneksi internet.',
				  	type: 'error'
                  });

				  t_table2.fadeIn();
				  t_form_role.fadeOut();
			  }
		  });
	  });

<?php
foreach($category as $cat){
	$id = $cat['id'];
?>
	  $(document).on('change','input#<?php echo $id; ?>',function(){
		  if(this.checked){
		  	$('input.<?php echo $id; ?>').attr('checked',true);
		  } else {
		  	$('input.<?php echo $id; ?>').attr('checked',false);
		  }
	  });
<?php } ?>

	  // BEGIN FORM ROLE VALIDATION
	  form3.validate({
		  rules: {
			  idgroup: {
				  required: true
			  }
		  },

		  //display error alert on form submit
		  invalidHandler: function(event, validator) {
		  	  KTUtil.scrollTop();
		  },

		  submitHandler: function (form){
			  $.ajax({
				  type: 'POST',
				  url: 'setting/perole',
				  dataType: 'json',
				  data: form3.serialize(),
				  success: function(response){
					  var result = response.result;
					  var message = response.message;

					  if(result == true){
						  swal.fire({
						  	  title: 'Sukses!',
						  	  text: message,
						  	  type: 'success'
	                      });

	                      cancel3.trigger('click');
	                      dTreload(tableId2);
					  } else {
						  swal.fire({
						  	title: 'Maaf!',
						  	text: 'Tidak ada koneksi internet.',
						  	type: 'error'
		                  });
					  }
				  },
				  error: function(){
					  swal.fire({
					  	title: 'Maaf!',
					  	text: 'Tidak ada koneksi internet.',
					  	type: 'error'
	                  });
				  }
			  });
		  }
	  });

	  // BEGIN MENU POSITION
	  $.ajax({
		  type: 'POST',
		  url: 'setting/peposition',
		  dataType: 'html',
		  success: function(response){
			  $('div#menu_position').html(response);
		  }
	  });

	  $('#menu_nestable').livequery(function(){
	  	alert('Test');
		  $(this).nestable({
			  group: 1,
			  maxDepth: 3
		  }).on('change',function(e){
			  var list = e.length ? e : $(e.target);
			  var conf = confirm('Apakah Anda yakin?');

			  if(conf){
				  $.ajax({
					  type: 'POST',
					  url: 'setting/pcposition',
					  dataType: 'json',
					  data: {data:list.nestable('serialize')},
					  success: function(response){
						  swal.fire({
						  	  title: 'Sukses!',
						  	  text: 'Ganti Posisi Berhasil',
						  	  type: 'success'
	                      });
					  }
				  });
			  }
		  });
	  });
  });

  function dTreload(tableId){
	  $('#'+tableId).trigger('reloadGrid');
  }
  </script>
