<div class="kt-container kt-grid__item kt-grid__item--fluid">
              <!-- BEGIN ROW -->
              <div class="row">
                <div class="col-xl-8 order-lg-1 order-xl-1">
                  <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                      <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                          Pengaturan User
                        </h3>
                      </div>
                      <div class="kt-portlet__head-toolbar" id="t_table">
                        <div class="kt-portlet__head-wrapper">
                          <div class="dropdown dropdown-inline">
                            <a href="javascript:;" class="btn btn-primary" id="add_user"><i class="fa fa-plus"></i> Tambah</a>
                            <a href="javascript:;" class="btn btn-success" id="show_user"><i class="fa fa-check"></i> Aktifkan</a>
                            <a href="javascript:;" class="btn btn-warning" id="hide_user"><i class="fa fa-times"></i> Non-Aktifkan</a>
                            <a href="javascript:;" class="btn btn-danger" id="delete_user"><i class="fa fa-trash-alt"></i> Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="kt-portlet__body">
                      <div id="t_table">
                        <table id="t_user"></table>
                        <div id="pager_user"></div>
                      </div>
                      <div id="t_form_add">
                        <form class="kt-form kt-form--label-right" action="javascript:;" method="post" enctype="multipart/form-data" id="form_add">
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Grup :</label>
                            <div class="col-lg-4">
                              <select name="idgroup" class="form-control" id="idgroup">
                                <option value="" selected="selected">-- Pilih --</option>
                                <?php
                                foreach($group as $gr){
                                  $id = $gr['id'];
                                  $group = $gr['group'];
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo $group; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Email :</label>
                            <div class="col-lg-4">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon2"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input name="email" type="email" id="email" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Password :</label>
                            <div class="col-lg-4">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon2"><i class="fa fa-ellipsis-h"></i></span>
                                </div>
                                <input name="password" type="password" id="password" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Ulang Password :</label>
                            <div class="col-lg-4">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon2"><i class="fa fa-ellipsis-h"></i></span>
                                </div>
                                <input name="repassword" type="password" id="repassword" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nama :</label>
                            <div class="col-lg-4">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon2"><i class="fa fa-address-card"></i></span>
                                </div>
                                <input name="name" type="text" id="name" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Foto :</label>
                            <div class="col-lg-4">
                              <div class="custom-file">
                                <input name="userfile" type="file" class="custom-file-input" id="userfile">
                                <label class="custom-file-label" for="userfile" style="text-align:left;">Telusuri</label>
                              </div>
                            </div>
                          </div>
                          <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                              <div class="row">
                                <div class="col-lg-3">&nbsp;</div>
                                <div class="col-lg-4">
                                  <button type="button" class="btn btn-secondary" id="cancel1"><i class="fa fa-arrow-left"></i> Kembali</button>
                                  <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div id="t_form_edit">
                        <form class="kt-form kt-form--label-right" action="javascript:;" method="post" enctype="multipart/form-data" id="form_edit">
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Grup :</label>
                            <div class="col-lg-4">
                              <input name="id" type="hidden" id="id">
                              <select name="idgroup" class="form-control" id="idgroup">
                                <option value="">-- Pilih --</option>
                                <?php
                                foreach($e_group as $e_gr){
                                  $id = $e_gr['id'];
                                  $group = $e_gr['group'];
                                ?>
                                <option value="<?php echo $id; ?>"><?php echo $group; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Email :</label>
                            <div class="col-lg-4">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon2"><i class="fa fa-envelope"></i></span>
                                </div>
                                <input name="email" type="email" id="email" class="form-control" readonly="readonly">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Password :</label>
                            <div class="col-lg-4">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon2"><i class="fa fa-ellipsis-h"></i></span>
                                </div>
                                <input name="password" type="password" id="password" class="form-control">
                                <input name="oldpass" type="hidden" id="oldpass">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Ulang Password :</label>
                            <div class="col-lg-4">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon2"><i class="fa fa-ellipsis-h"></i></span>
                                </div>
                                <input name="repassword" type="password" id="repassword" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Nama :</label>
                            <div class="col-lg-4">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon2"><i class="fa fa-address-card"></i></span>
                                </div>
                                <input name="name" type="text" id="name" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Foto :</label>
                            <div class="col-lg-4">
                              <div class="custom-file">
                                <input name="userfile" type="file" class="custom-file-input" id="userfile">
                                <label class="custom-file-label" for="userfile" style="text-align:left;">Telusuri</label>
                                <input name="oldp" type="hidden" id="oldp">
                                <input name="olda" type="hidden" id="olda">
                              </div>
                            </div>
                          </div>
                          <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                              <div class="row">
                                <div class="col-lg-3">&nbsp;</div>
                                <div class="col-lg-4">
                                  <button type="button" class="btn btn-secondary" id="cancel2"><i class="fa fa-arrow-left"></i> Kembali</button>
                                  <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Ubah</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END ROW -->
            </div>
