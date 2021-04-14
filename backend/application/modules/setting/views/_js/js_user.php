<script>
  $(document).ready(function(){
	  // ID
	  var tableId = 't_user';
	  var t_table = $('div#t_table');
	  var t_form_add = $('#t_form_add');
	  var t_form_edit = $('#t_form_edit');
	  var form1 = $('#form_add');
	  var form2 = $('#form_edit');
	  var cancel1 = $('#cancel1');
	  var cancel2 = $('#cancel2');

	  var form_control = $('.form-control');

	  t_form_add.hide();
	  t_form_edit.hide();

	  // BLOCK UI
	  var block = false;

	  $(document).ajaxStart(function(){
	  	if(block == false){
	  		$.blockUI({
	  			message: '<div style="padding:5px 0;">Mohon Tunggu...</div>',
	  			css: {
	  				backgroundColor: '#fff',
	  				color: '#000',
	  				fontSize: '12px'
	      		}
	    	});
	  	}
	  }).ajaxStop($.unblockUI);

	  $('#add_user').click(function(){
		  t_table.fadeOut();
		  t_form_add.fadeIn();
		  form1.trigger('reset');
		  form_control.parent('.input-icon').children('i').removeClass('fa-check');
		  form_control.parent('.input-icon').children('i').removeClass('fa-warning');
		  form_control.closest('.form-group').removeClass('has-error');
		  form_control.closest('.form-group').removeClass('has-success');
	  });

	  cancel1.click(function(){
		  t_table.fadeIn();
		  t_form_add.fadeOut();
	  });

	  form1.validate({
	  	// define validation rules
	  	rules: {
	  		idgroup: {
	  			required: true 
            },
            email: {
            	required: true
            },
            password: {
            	required: true
            },
            repassword: {
            	required: true
            },
            nama: {
            	required: true
            } 
        },

        //display error alert on form submit
        invalidHandler: function(event, validator) {     
            KTUtil.scrollTop();
        },

        submitHandler: function (form) {
            form1.ajaxSubmit({
                url: 'setting/pauser',
                dataType: 'json',
                data: 'POST',
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
                        text: 'Mohon periksa kembali koneksi internet Anda!',
                        type: 'error'
                    });
                }
            });
        }
      });

	  // JQGRID REQUEST
	  $('#'+tableId).jqGrid({
		  url: 'setting/apiuser',
		  datatype: 'json',
		  height: '300',
		  rowNum: 15,
		  autowidth: true,
		  shrinkToFit: false,
		  rowList: [15,30,60,120,240],
		  colNames:['ID','Nama','Email','Grup','Status','Tindakan'],
		  colModel:[
		  	{name:'id',index:'id',hidden:true},
			{name:'name',index:'name',align:'center'},
			{name:'email',index:'email',align:'center'},
			{name:'group',index:'group',align:'center'},
			{name:'status',index:'status',align:'center'},
			{name:'action',index:'action',align:'center'}
		  ],
		  pager: '#pager_user',
		  viewrecords: true,
		  multiselect: true,
		  grouping: true,
		  rownumbers: false,
		  sortname: 'username'
	  });

	  $(document).on('click','a#edit_user',function(){
		  t_table.fadeOut();
		  t_form_add.fadeOut();
		  t_form_edit.fadeIn();

		  form2.trigger('reset');
		  form_control.parent('.input-icon').children('i').removeClass('fa-check');
		  form_control.parent('.input-icon').children('i').removeClass('fa-warning');
		  form_control.closest('.form-group').removeClass('has-error');

		  var u_id = $(this).attr('u_id');

		  var e_id = $('#id',form2);
		  var e_idgroup = $('#idgroup',form2);
		  var e_username = $('#username',form2);
		  var e_password = $('#oldpass',form2);
		  var e_name = $('#name',form2);
		  var e_email = $('#email',form2);
		  var e_photo = $('#oldp',form2);
		  var e_attach = $('#olda',form2);

		  $.ajax({
			  type: 'POST',
			  url: 'setting/get_user_by_id',
			  data: {u_id:u_id},
			  dataType: 'json',
			  success: function(response){
				  var id = response.id;
				  var idgroup = response.idgroup;
				  var username = response.username;
				  var password = response.password;
				  var name = response.name;
				  var email = response.email;
				  var photo = response.photo;
				  var attach = response.attach;

				  e_id.val(id);
				  e_idgroup.val(idgroup).attr('selected',true);
				  e_username.val(username);
				  e_password.val(password);
				  e_name.val(name);
				  e_email.val(email);
				  e_photo.val(photo);
				  e_attach.val(attach);
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

	  cancel2.click(function(){
		  t_table.fadeIn();
		  t_form_edit.fadeOut();
	  });

	  // BEGIN FORM EDIT VALIDATION
	  form2.validate({
	  	// define validation rules
	  	rules: {
	  		idgroup: {
	  			required: true 
            },
            email: {
            	required: true
            },
            nama: {
            	required: true
            } 
        },

        //display error alert on form submit
        invalidHandler: function(event, validator) {     
            KTUtil.scrollTop();
        },

        submitHandler: function (form) {
            form2.ajaxSubmit({
                url: 'setting/peuser',
                dataType: 'json',
                data: 'POST',
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
                        text: 'Mohon periksa kembali koneksi internet Anda!',
                        type: 'error'
                    });
                }
            });
        }
	  });

	  $('#delete_user').click(function(){
		  var rowKey = $('#'+tableId).getGridParam('selrow');

		  if(!rowKey){
			  alert('Item belum dipilih');
		  } else {
			  var conf = confirm('Data ingin dihapus?');
			  var selectedIDs = $('#'+tableId).getGridParam('selarrrow');

			  if(conf){
				  $.ajax({
					  type: 'POST',
					  url: 'setting/pduser',
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

	  $('#show_user').click(function(){
		  var rowKey = $('#'+tableId).getGridParam('selrow');

		  if(!rowKey){
			  alert('Item belum dipilih');
		  } else {
			  var conf = confirm('Data ingin diaktifkan?');
			  var selectedIDs = $('#'+tableId).getGridParam('selarrrow');

			  if(conf){
				  $.ajax({
					  type: 'POST',
					  url: 'setting/psuser',
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

	  $('#hide_user').click(function(){
		  var rowKey = $('#'+tableId).getGridParam('selrow');

		  if(!rowKey){
			  alert('Item belum dipilih');
		  } else {
			  var conf = confirm('Data ingin di-non-aktifkan?');
			  var selectedIDs = $('#'+tableId).getGridParam('selarrrow');

			  if(conf){
				  $.ajax({
					  type: 'POST',
					  url: 'setting/phuser',
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
  });

  function dTreload(tableId){
	  $('#'+tableId).trigger('reloadGrid');
  }
</script>
