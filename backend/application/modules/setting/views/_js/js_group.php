<script type="text/javascript">
var form_add = KTUtil.getById('form_add');
var form_edit = KTUtil.getById('form_edit');
var formSubmitAdd = KTUtil.attr(form_add,'action');
var formSubmitEdit = KTUtil.attr(form_edit,'action');
var formSubmitButtonAdd = KTUtil.getById('submit1');
var formSubmitButtonEdit = KTUtil.getById('submit2');

// BLOCK UI
var block = false;

$(document).ajaxStart(function(){
	if(block == false){
		KTApp.blockPage();
	}
}).ajaxStop(
	KTApp.unblockPage
);

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
		FormValidation.utils.fetch(formSubmitAdd, {
			method: 'POST',
			dataType: 'json',
			params: {
				group: form_add.querySelector('[name="group"]').value,
			},
		}).then(function(response) { // Return valid JSON
			// Release button
			KTUtil.btnRelease(formSubmitButtonAdd);

			if(response && typeof response === 'object' && response.status && response.status == 'success') {
				Swal.fire({
					text: response.message,
					icon: 'success',
					timer: 1000,
					onOpen: function(){
						Swal.showLoading()
					},
					allowOutsideClick: false
				}).then(function() {
					$('#cancel1').trigger('click');
				});
			} else {
				Swal.fire({
					text: response.message,
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
		FormValidation.utils.fetch(formSubmitEdit, {
			method: 'POST',
			dataType: 'json',
			params: {
				group: form_edit.querySelector('[name="group"]').value,
				id: form_edit.querySelector('[name="id"]').value,
			},
		}).then(function(response) { // Return valid JSON
			// Release button
			KTUtil.btnRelease(formSubmitButtonEdit);

			if(response && typeof response === 'object' && response.status && response.status == 'success') {
				Swal.fire({
					text: response.message,
					icon: 'success',
					timer: 1000,
					onOpen: function(){
						Swal.showLoading()
					},
					allowOutsideClick: false
				}).then(function() {
					$('#cancel2').trigger('click');
				});
			} else {
				Swal.fire({
					text: response.message,
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

	cancel2.click(function(){
		t_table.fadeIn();
		t_form_edit.fadeOut();
		$('#title_form').text('');
		dTreload(tableId);
	});

	$('#delete_group').click(function(){
		var rowKey = $('#'+tableId).getGridParam('selrow');

		if(!rowKey){
			alert('Item belum dipilih');
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

	$('#show_group').click(function(){
		var rowKey = $('#'+tableId).getGridParam('selrow');

		if(!rowKey){
			alert('Item belum dipilih');
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

	$('#hide_group').click(function(){
		var rowKey = $('#'+tableId).getGridParam('selrow');

		if(!rowKey){
			alert('Item belum dipilih');
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
