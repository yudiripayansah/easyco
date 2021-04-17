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
            <table id="t_user"></table>
            <div id="pager_user"></div>
          </div>
          <div id="t_form_add">
            <form action="javascript:;" method="post" enctype="multipart/form-data" id="form_add">
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Grup :</label>
                <div class="col-lg-4">
                  <select name="id_group" class="form-control" id="id_group" tabindex="1">
                    <option value="" selected="selected">-- Pilih --</option>
                    <?php
                    foreach($group as $gr){
                      $id = $gr['id_group'];
                      $group = $gr['nama_grup'];
                    ?>
                    <option value="<?php echo $id; ?>"><?php echo $group; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Username :</label>
                <div class="col-lg-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="la la-users icon-lg"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" name="nama_user" id="nama_user" tabindex="2">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Password :</label>
                <div class="col-lg-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="la la-users icon-lg"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" tabindex="3">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Kantor Cabang :</label>
                <div class="col-lg-4">
                  <select name="kode_cabang" class="form-control" id="kode_cabang" tabindex="4">
                    <option value="" selected="selected">-- Pilih --</option>
                    <?php
                    foreach($branch as $br){
                      $branch_code = $br['kode_cabang'];
                      $branch_name = $br['nama_cabang'];
                    ?>
                    <option value="<?php echo $branch_code; ?>"><?php echo $branch_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Nama Pegawai :</label>
                <div class="col-lg-4">
                  <select name="kode_pgw" class="form-control" id="kode_pgw" tabindex="5">
                    <option value="" selected="selected">-- Pilih --</option>
                    <?php
                    foreach($staff as $st){
                      $staff_code = $st['kode_pgw'];
                      $staff_name = $st['nama_pgw'];
                    ?>
                    <option value="<?php echo $staff_code; ?>"><?php echo $staff_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Foto :</label>
                <div class="col-lg-4">
                  <input name="userfile" type="file" id="userfile" tabindex="6">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">&nbsp;</label>
                <div class="col-lg-4">
                  <button type="button" class="btn btn-secondary" id="cancel1" tabindex="7"><i class="icon-md fas fa-arrow-left"></i> Kembali</button>
                  <button type="submit" class="btn btn-primary mr-2" tabindex="8"><i class="icon-md fas fa-save"></i> Simpan</button>
                </div>
              </div>
            </form>
          </div>
          <div id="t_form_edit">
            <form action="javascript:;" method="post" enctype="multipart/form-data" id="form_edit">
            <div class="form-group row">
                <label class="col-lg-2 col-form-label">Grup :</label>
                <div class="col-lg-4">
                  <select name="id_group" class="form-control" id="id_group" tabindex="1">
                    <option value="">-- Pilih --</option>
                    <?php
                    foreach($group as $gr){
                      $id = $gr['id_group'];
                      $group = $gr['nama_grup'];
                    ?>
                    <option value="<?php echo $id; ?>"><?php echo $group; ?></option>
                    <?php } ?>
                  </select>
                  <input name="id" type="hidden" id="id">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Username :</label>
                <div class="col-lg-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="la la-users icon-lg"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control" name="nama_user" id="nama_user" tabindex="2">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Password :</label>
                <div class="col-lg-4">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="la la-users icon-lg"></i>
                      </span>
                    </div>
                    <input type="password" class="form-control" name="password" id="password" tabindex="3">
                    <input name="oldpass" type="hidden" id="oldpass">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Kantor Cabang :</label>
                <div class="col-lg-4">
                  <select name="kode_cabang" class="form-control" id="kode_cabang" tabindex="4">
                    <option value="">-- Pilih --</option>
                    <?php
                    foreach($branch as $br){
                      $branch_code = $br['kode_cabang'];
                      $branch_name = $br['nama_cabang'];
                    ?>
                    <option value="<?php echo $branch_code; ?>"><?php echo $branch_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Nama Pegawai :</label>
                <div class="col-lg-4">
                  <select name="kode_pgw" class="form-control" id="kode_pgw" tabindex="5">
                    <option value="">-- Pilih --</option>
                    <?php
                    foreach($staff as $st){
                      $staff_code = $st['kode_pgw'];
                      $staff_name = $st['nama_pgw'];
                    ?>
                    <option value="<?php echo $staff_code; ?>"><?php echo $staff_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">Foto :</label>
                <div class="col-lg-4">
                  <input name="userfile" type="file" id="userfile" tabindex="6">
                  <input name="oldp" type="hidden" id="oldp">
                  <input name="olda" type="hidden" id="olda">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-lg-2 col-form-label">&nbsp;</label>
                <div class="col-lg-4">
                  <button type="button" class="btn btn-secondary" id="cancel2" tabindex="7"><i class="icon-md fas fa-arrow-left"></i> Kembali</button>
                  <button type="submit" class="btn btn-primary mr-2" tabindex="8"><i class="icon-md fas fa-save"></i> Simpan</button>
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
