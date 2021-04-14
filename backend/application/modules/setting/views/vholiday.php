<div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="glyphicon glyphicon-calendar"></i> Daftar Hari Libur</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="nav-tabs-custom">
                <div class="tab-content">
                  <div class="box-header" id="t_table">
                    <h3 class="box-title">&nbsp;</h3>
                    <div class="box-tools">
                      <span class="no-margin pull-right">
                        <button class="btn btn-sm btn-primary" type="button" id="add_holiday"><i class="fa fa-plus"></i> Tambah</button>
                        <button class="btn btn-sm btn-success" type="button" id="show_holiday"><i class="fa fa-thumbs-up"></i> Aktifkan</button>
                        <button class="btn btn-sm btn-warning" type="button" id="hide_holiday"><i class="fa fa-thumbs-down"></i> Non-Aktifkan</button>
                        <button class="btn btn-sm btn-danger" type="button" id="delete_holiday"><i class="fa fa-times"></i> Hapus</button>
                      </span>
                    </div>
                  </div>
                  <div class="box-body no-padding">
                    <div id="t_table">
                      <table id="t_holiday"></table>
                      <div id="pager_holiday"></div>
                    </div>
                    <div id="t_form_add">
                      <form action="javascript:;" method="post" class="form-horizontal" id="form_add">
                      	<div class="alert alert-success" id="success">
                          <button class="close" data-close="alert"></button>
                          Berhasil! Terima kasih.
                        </div>
                        <div class="alert alert-danger" id="error">
                          <button class="close" data-close="alert"></button>
                          Gagal! Silakkan cek kembali.
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Tanggal Libur <span class="required">*</span></label>
                          <div class="col-md-4">
                            <div class="input-icon right">
                              <i class="fa"></i>
                              <input name="holiday" type="text" id="holiday" class="form-control datepicker" required="required">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Deskripsi <span class="required">*</span></label>
                          <div class="col-md-4">
                            <div class="input-icon right">
                              <i class="fa"></i>
                              <textarea name="description" class="form-control" id="description" required="required"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Libur / Cuti Nasional? <span class="required">*</span></label>
                          <div class="col-md-4">
                            <select name="isnational" class="form-control" id="isnational">
                              <option value="">-- Pilih --</option>
                              <option value="0" selected="selected">Tidak</option>
                              <option value="1">Ya</option>
                            </select>
                          </div>
                        </div>
                        <hr />
                        <div class="form-actions">
                          <div class="row">
                          	<div class="col-md-offset-3 col-md-9">
                              <a href="javascript:" class="btn btn-info" id="cancel1"><i class="fa fa-arrow-left"></i> Kembali</a>
                              <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Proses</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div id="t_form_edit">
                      <form action="javascript:;" method="post" class="form-horizontal" id="form_edit">
                      	<div class="alert alert-success" id="success">
                          <button class="close" data-close="alert"></button>
                          Berhasil! Terima kasih.
                        </div>
                        <div class="alert alert-danger" id="error">
                          <button class="close" data-close="alert"></button>
                          Gagal! Silakkan cek kembali.
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Tanggal Libur <span class="required">*</span></label>
                          <div class="col-md-4">
                            <div class="input-icon right">
                              <i class="fa"></i>
                              <input name="holiday" type="text" id="holiday" class="form-control datepicker" required="required">
                              <input name="id" type="hidden" id="id">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Deskripsi <span class="required">*</span></label>
                          <div class="col-md-4">
                            <div class="input-icon right">
                              <i class="fa"></i>
                              <textarea name="description" class="form-control" id="description" required="required"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-md-3">Libur / Cuti Nasional? <span class="required">*</span></label>
                          <div class="col-md-4">
                            <select name="isnational" class="form-control" id="isnational">
                              <option value="">-- Pilih --</option>
                              <option value="0">Tidak</option>
                              <option value="1">Ya</option>
                            </select>
                          </div>
                        </div>
                        <hr />
                        <div class="form-actions">
                          <div class="row">
                          	<div class="col-md-offset-3 col-md-9">
                              <a href="javascript:" class="btn btn-info" id="cancel2"><i class="fa fa-arrow-left"></i> Kembali</a>
                              <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Proses</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
