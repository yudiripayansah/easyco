<script>
$(document).ajaxStart(function(){
	var block = false;

	if(block == false){
		KTApp.blockPage();
	}
}).ajaxStop(
	KTApp.unblockPage
);

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
	var form_add = KTUtil.getById('form_add');
	var form_edit = KTUtil.getById('form_edit');

	var form_control = $('.form-control');

	t_form_add.hide();
	t_form_edit.hide();

	$('#add').click(function(){
		t_table.fadeOut();
		t_form_add.fadeIn();
		form1.trigger('reset');
		form_control.parent('.input-icon').children('i').removeClass('fa-check');
		form_control.parent('.input-icon').children('i').removeClass('fa-warning');
		form_control.closest('.form-group').removeClass('has-error');
		form_control.closest('.form-group').removeClass('has-success');
		$('#title_form').text('Tambah User');
	});

	FormValidation.formValidation(
		form_add, {
			fields: {
				id_group: {
					validators: {
						notEmpty: {
							message: 'Grup wajib dipilih'
						}
					}
				},
				nama_user: {
					validators: {
						notEmpty: {
							message: 'Username wajib diisi'
						}
					}
				},
				password: {
					validators: {
						notEmpty: {
							message: 'Password wajib diisi'
						}
					}
				},
				kode_cabang: {
					validators: {
						notEmpty: {
							message: 'Kantor Cabang wajib dipilih'
						}
					}
				},
				kode_pgw: {
					validators: {
						notEmpty: {
							message: 'Nama Pegawai wajib dipilih'
						}
					}
				}
			},
			plugins: {
				trigger: new FormValidation.plugins.Trigger(),
				submitButton: new FormValidation.plugins.SubmitButton(),
				bootstrap: new FormValidation.plugins.Bootstrap({})
			}
		}).on('core.form.valid', function() {
			form1.ajaxSubmit({
				url: 'setting/pauser',
				dataType: 'json',
				data: 'POST',
				success: function(response){
					var status = response.status;
					var message = response.message;

					if(status == 'success'){
						Swal.fire({
							text: message,
							icon: 'success',
							timer: 1000,
							allowOutsideClick: false,
							onOpen: function(){
								Swal.showLoading()
							}
						}).then(function() {
							$('#cancel1').trigger('click');
						});
					} else {
						Swal.fire({
							text: message,
							icon: 'error',
							buttonsStyling: false,
							confirmButtonText: 'OK!',
							allowOutsideClick: false,
							customClass: {
								confirmButton: 'btn font-weight-bold btn-light-primary'
							}
						}).then(function() {
							KTUtil.scrollTop();
						});
					}
				},
				error: function(){
					Swal.fire({
						text: 'Maaf! Jaringan Anda tidak stabil.',
						icon: 'error',
						buttonsStyling: false,
						confirmButtonText: 'OK!',
						customClass: {
							confirmButton: 'btn font-weight-bold btn-light-primary'
						}
					}).then(function() {
						KTUtil.scrollTop();
					});
				}
			});
		}).on('core.form.invalid', function() {
			Swal.fire({
				text: 'Maaf! Pengisian form Anda belum lengkap. Silakkan dicoba lagi.',
				icon: 'error',
				buttonsStyling: false,
				confirmButtonText: 'OK!',
				customClass: {
					confirmButton: 'btn font-weight-bold btn-light-primary'
				}
			}).then(function() {
				KTUtil.scrollTop();
			});
		}
	);

	cancel1.click(function(){
		t_table.fadeIn();
		t_form_add.fadeOut();
	});

	// JQGRID REQUEST
	$('#'+tableId).jqGrid({
		url: 'setting/read_user',
		datatype: 'json',
		height: '300',
		rowNum: 15,
		autowidth: true,
		shrinkToFit: false,
		rowList: [15,30,60,120,240],
		colNames:['ID','Grup','Username','Kantor Cabang','Nama Pegawai','Foto','Status','Tindakan'],
		colModel:[
		{name:'id_user',index:'id_user',hidden:true},
		{name:'group_name',index:'group_name',align:'center'},
		{name:'username',index:'nama_user',align:'center'},
		{name:'branch_name',index:'branch_name',align:'center'},
		{name:'staff_name',index:'staff_name',align:'center'},
		{name:'photo',index:'photo',align:'center'},
		{name:'status',index:'status',align:'center'},
		{name:'action',index:'action',align:'center'}
		],
		pager: '#pager_user',
		viewrecords: true,
		multiselect: true,
		grouping: true,
		rownumbers: false,
		sortname: 'nama_user'
	});

	$(document).on('click','a#edit',function(){
		t_table.fadeOut();
		t_form_add.fadeOut();
		t_form_edit.fadeIn();

		form2.trigger('reset');
		form_control.parent('.input-icon').children('i').removeClass('fa-check');
		form_control.parent('.input-icon').children('i').removeClass('fa-warning');
		form_control.closest('.form-group').removeClass('has-error');

		var u_id = $(this).attr('u_id');

		var e_id = $('#id',form2);
		var e_idgroup = $('#id_group',form2);
		var e_username = $('#nama_user',form2);
		var e_password = $('#oldpass',form2);
		var e_branch_code = $('#kode_cabang',form2);
		var e_staff_code = $('#kode_pgw',form2);
		var e_photo = $('#oldp',form2);

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
				var branch_code = response.branch_code;
				var staff_code = response.staff_code;
				var photo = response.photo;

				e_id.val(id);
				e_idgroup.val(idgroup).attr('selected',true);
				e_username.val(username);
				e_password.val(password);
				e_branch_code.val(branch_code);
				e_staff_code.val(staff_code);
				e_photo.val(photo);
			},
			error: function(){
				Swal.fire({
					text: 'Maaf! Jaringan Anda tidak stabil.',
					icon: 'error',
					buttonsStyling: false,
					confirmButtonText: 'OK!',
					customClass: {
						confirmButton: 'btn font-weight-bold btn-light-primary'
					}
				}).then(function() {
					KTUtil.scrollTop();
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

	FormValidation.formValidation(
		form_edit, {
			fields: {
				id_group: {
					validators: {
						notEmpty: {
							message: 'Grup wajib dipilih'
						}
					}
				},
				nama_user: {
					validators: {
						notEmpty: {
							message: 'Username wajib diisi'
						}
					}
				},
				kode_cabang: {
					validators: {
						notEmpty: {
							message: 'Kantor Cabang wajib dipilih'
						}
					}
				},
				kode_pgw: {
					validators: {
						notEmpty: {
							message: 'Nama Pegawai wajib dipilih'
						}
					}
				}
			},
			plugins: {
				trigger: new FormValidation.plugins.Trigger(),
				submitButton: new FormValidation.plugins.SubmitButton(),
				bootstrap: new FormValidation.plugins.Bootstrap({})
			}
		}).on('core.form.valid', function() {
			form2.ajaxSubmit({
				url: 'setting/peuser',
				dataType: 'json',
				data: 'POST',
				success: function(response){
					var status = response.status;
					var message = response.message;

					if(status == 'success'){
						Swal.fire({
							text: message,
							icon: 'success',
							timer: 1000,
							allowOutsideClick: false,
							onOpen: function(){
								Swal.showLoading()
							}
						}).then(function() {
							$('#cancel2').trigger('click');
						});
					} else {
						Swal.fire({
							text: message,
							icon: 'error',
							buttonsStyling: false,
							confirmButtonText: 'OK!',
							allowOutsideClick: false,
							customClass: {
								confirmButton: 'btn font-weight-bold btn-light-primary'
							}
						}).then(function() {
							KTUtil.scrollTop();
						});
					}
				},
				error: function(){
					Swal.fire({
						text: 'Maaf! Jaringan Anda tidak stabil.',
						icon: 'error',
						buttonsStyling: false,
						confirmButtonText: 'OK!',
						customClass: {
							confirmButton: 'btn font-weight-bold btn-light-primary'
						}
					}).then(function() {
						KTUtil.scrollTop();
					});
				}
			});
		}).on('core.form.invalid', function() {
			Swal.fire({
				text: 'Maaf! Pengisian form Anda belum lengkap. Silakkan dicoba lagi.',
				icon: 'error',
				buttonsStyling: false,
				confirmButtonText: 'OK!',
				customClass: {
					confirmButton: 'btn font-weight-bold btn-light-primary'
				}
			}).then(function() {
				KTUtil.scrollTop();
			});
		}
	);

	$('#active').click(function(){
		var rowKey = $('#'+tableId).getGridParam('selrow');

		if(!rowKey){
			Swal.fire({
				text: 'Item belum dipilih',
				icon: 'error',
				buttonsStyling: false,
				confirmButtonText: 'OK!',
				allowOutsideClick: false,
				customClass: {
					confirmButton: 'btn font-weight-bold btn-light-primary'
				}
			}).then(function() {
				KTUtil.scrollTop();
			});
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
							Swal.fire({
								text: message,
								icon: 'success',
								timer: 1000,
								allowOutsideClick: false,
								onOpen: function(){
									Swal.showLoading()
								}
							}).then(function() {
								dTreload(tableId);
							});
						} else {
							Swal.fire({
								text: message,
								icon: 'error',
								buttonsStyling: false,
								confirmButtonText: 'OK!',
								allowOutsideClick: false,
								customClass: {
									confirmButton: 'btn font-weight-bold btn-light-primary'
								}
							}).then(function() {
								KTUtil.scrollTop();
							});
						}
					},
					error: function(){
						Swal.fire({
							text: 'Jaringan Anda tidak stabil',
							icon: 'error',
							buttonsStyling: false,
							confirmButtonText: 'OK!',
							allowOutsideClick: false,
							customClass: {
								confirmButton: 'btn font-weight-bold btn-light-primary'
							}
						}).then(function() {
							KTUtil.scrollTop();
						});
					}
				});
			}
		}
	});

	$('#inactive').click(function(){
		var rowKey = $('#'+tableId).getGridParam('selrow');

		if(!rowKey){
			Swal.fire({
				text: 'Item belum dipilih',
				icon: 'error',
				buttonsStyling: false,
				confirmButtonText: 'OK!',
				allowOutsideClick: false,
				customClass: {
					confirmButton: 'btn font-weight-bold btn-light-primary'
				}
			}).then(function() {
				KTUtil.scrollTop();
			});
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
							Swal.fire({
								text: message,
								icon: 'success',
								timer: 1000,
								allowOutsideClick: false,
								onOpen: function(){
									Swal.showLoading()
								}
							}).then(function() {
								dTreload(tableId);
							});
						} else {
							Swal.fire({
								text: message,
								icon: 'error',
								buttonsStyling: false,
								confirmButtonText: 'OK!',
								allowOutsideClick: false,
								customClass: {
									confirmButton: 'btn font-weight-bold btn-light-primary'
								}
							}).then(function() {
								KTUtil.scrollTop();
							});
						}
					},
					error: function(){
						Swal.fire({
							text: 'Jaringan Anda tidak stabil',
							icon: 'error',
							buttonsStyling: false,
							confirmButtonText: 'OK!',
							allowOutsideClick: false,
							customClass: {
								confirmButton: 'btn font-weight-bold btn-light-primary'
							}
						}).then(function() {
							KTUtil.scrollTop();
						});
					}
				});
			}
		}
	});

	$('#delete').click(function(){
		var rowKey = $('#'+tableId).getGridParam('selrow');

		if(!rowKey){
			Swal.fire({
				text: 'Item belum dipilih',
				icon: 'error',
				buttonsStyling: false,
				confirmButtonText: 'OK!',
				allowOutsideClick: false,
				customClass: {
					confirmButton: 'btn font-weight-bold btn-light-primary'
				}
			}).then(function() {
				KTUtil.scrollTop();
			});
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
							Swal.fire({
								text: message,
								icon: 'success',
								timer: 1000,
								allowOutsideClick: false,
								onOpen: function(){
									Swal.showLoading()
								}
							}).then(function() {
								dTreload(tableId);
							});
						} else {
							Swal.fire({
								text: message,
								icon: 'error',
								buttonsStyling: false,
								confirmButtonText: 'OK!',
								allowOutsideClick: false,
								customClass: {
									confirmButton: 'btn font-weight-bold btn-light-primary'
								}
							}).then(function() {
								KTUtil.scrollTop();
							});
						}
					},
					error: function(){
						Swal.fire({
							text: 'Jaringan Anda tidak stabil',
							icon: 'error',
							buttonsStyling: false,
							confirmButtonText: 'OK!',
							allowOutsideClick: false,
							customClass: {
								confirmButton: 'btn font-weight-bold btn-light-primary'
							}
						}).then(function() {
							KTUtil.scrollTop();
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
