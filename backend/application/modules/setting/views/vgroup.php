<!--begin::Row-->
  <div class="row">
    <div class="col-lg-12">
      <!--begin::Mixed Widget 14-->
      <div class="card card-custom card-stretch gutter-b">
        <div class="card-header">
          <div class="card-title">
            <h3 class="card-label" id="title_form">&nbsp;</h3>
          </div>
          <div class="card-toolbar" id="t_table">
            <a href="javascript:;" id="add" class="btn btn-primary font-weight-bolder"><i class="icon-md fas fa-plus"></i> Tambah</a>&nbsp;
            <a href="javascript:;" id="active" class="btn btn-success font-weight-bolder"><i class="icon-md far fa-eye"></i> Aktif</a>&nbsp;
            <a href="javascript:;" id="inactive" class="btn btn-warning font-weight-bolder"><i class="icon-md far fa-eye-slash"></i> Non-Aktif</a>&nbsp;
            <a href="javascript:;" id="delete" class="btn btn-danger font-weight-bolder"><i class="icon-md far fa-trash-alt"></i> Hapus</a>
          </div>
        </div>
        <!--begin::Body-->
        <div class="card-body d-flex flex-column">
          <div id="t_table">
            <table id="t_group"></table>
            <div id="pager_group"></div>
          </div>
          <div id="t_form_add">
            <form action="javascript:;" method="post" id="form_add">
              <div class="form-group row">
                <label class="col-lg-1 col-form-label">Grup :</label>
                <div class="col-lg-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="la la-users icon-lg"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" name="group" id="group" tabindex="1">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-1 col-form-label">&nbsp;</label>
                <div class="col-lg-4">
                  <button type="button" class="btn btn-secondary" id="cancel1" tabindex="3"><i class="icon-md fas fa-arrow-left"></i> Kembali</button>
                  <button type="submit" class="btn btn-primary mr-2" tabindex="2"><i class="icon-md fas fa-save"></i> Simpan</button>
                </div>
              </div>
            </form>
          </div>
          <div id="t_form_edit">
            <form action="javascript:;" method="post" id="form_edit">
              <div class="form-group row">
                <label class="col-lg-1 col-form-label">Grup :</label>
                <div class="col-lg-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="la la-users icon-lg"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" name="group" id="group" tabindex="1">
                    <input name="id" type="hidden" id="id">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-1 col-form-label">&nbsp;</label>
                <div class="col-lg-4">
                  <button type="button" class="btn btn-secondary" id="cancel2" tabindex="3"><i class="icon-md fas fa-arrow-left"></i> Kembali</button>
                  <button type="submit" class="btn btn-primary mr-2" tabindex="2"><i class="icon-md fas fa-save"></i> Simpan</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!--end::Body-->
      </div>
      <!--end::Mixed Widget 14-->
    </div>
  </div>
  <!--end::Row-->
