<script type="text/javascript">
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
	var tableId = 't_group';
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

	$('#add_group').click(function(){
		t_table.fadeOut();
		t_form_add.fadeIn();
		form1.trigger('reset');
		form_control.parent('.input-icon').children('i').removeClass('fa-check');
		form_control.parent('.input-icon').children('i').removeClass('fa-warning');
		form_control.closest('.form-group').removeClass('has-error');
		form_control.closest('.form-group').removeClass('has-success');
		$('#title_form').text('Tambah Grup');
	});

	FormValidation.formValidation(
		form_add, {
			fields: {
				group: {
					validators: {
						notEmpty: {
							message: 'Grup wajib diisi'
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
			$.ajax({
				type: 'POST',
				url: 'setting/pagroup',
				dataType: 'json',
				data: form1.serialize(),
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
		$('#title_form').text('');
		dTreload(tableId);
	});

	// JQGRID REQUEST
	$('#'+tableId).jqGrid({
		url: 'setting/read_group',
		datatype: 'json',
		height: '300',
		rowNum: 15,
		autowidth: true,
		shrinkToFit: false,
		rowList: [15,30,60,120,240],
		colNames:['ID','Grup','Status','Tindakan'],
		colModel:[
			{name:'id',index:'id',hidden:true},
			{name:'group',index:'group',align:'center'},
			{name:'status',index:'status',align:'center'},
			{name:'action',index:'action',align:'center'}
		],
		pager: '#pager_group',
		viewrecords: true,
		multiselect: true,
		grouping: true,
		rownumbers: false,
		sortname: 'nama_grup'
	});

	$(document).on('click','a#edit_group',function(){
		t_table.fadeOut();
		t_form_add.fadeOut();
		t_form_edit.fadeIn();

		form2.trigger('reset');
		form_control.parent('.input-icon').children('i').removeClass('fa-check');
		form_control.parent('.input-icon').children('i').removeClass('fa-warning');
		form_control.closest('.form-group').removeClass('has-error');

		var g_id = $(this).attr('g_id');

		var e_id = $('#id',form2);
		var e_group = $('#group',form2);

		$.ajax({
			type: 'POST',
			url: 'setting/get_group_by_id',
			data: {g_id:g_id},
			dataType: 'json',
			success: function(response){
				var id = response.id;
				var group = response.group;

				e_id.val(id);
				e_group.val(group);
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

	FormValidation.formValidation(
		form_edit, {
			fields: {
				group: {
					validators: {
						notEmpty: {
							message: 'Grup wajib diisi'
						}
					}
				}
			},
			plugins: {
				trigger: new FormValidation.plugins.Trigger(),
				bootstrap: new FormValidation.plugins.Bootstrap({}),
				submitButton: new FormValidation.plugins.SubmitButton()
			}
		}).on('core.form.valid', function() {
			$.ajax({
				type: 'POST',
				url: 'setting/pegroup',
				dataType: 'json',
				data: form2.serialize(),
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

	cancel2.click(function(){
		t_table.fadeIn();
		t_form_edit.fadeOut();
		$('#title_form').text('');
		dTreload(tableId);
	});

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
					url: 'setting/psgroup',
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
					url: 'setting/phgroup',
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
					url: 'setting/pdgroup',
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
