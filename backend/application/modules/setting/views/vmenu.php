<div class="kt-container kt-grid__item kt-grid__item--fluid">
              <!-- BEGIN ROW -->
              <div class="row">
                <div class="col-xl-8 order-lg-1 order-xl-1">
                  <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                      <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                          Pengaturan Menu
                        </h3>
                      </div>
                      <div class="kt-portlet__head-toolbar" id="t_table">
                        <div class="kt-portlet__head-wrapper">
                          <div class="dropdown dropdown-inline">
                            <a href="javascript:;" class="btn btn-primary" id="add_menu"><i class="fa fa-plus"></i> Tambah</a>
                            <a href="javascript:;" class="btn btn-success" id="show_menu"><i class="fa fa-check"></i> Aktifkan</a>
                            <a href="javascript:;" class="btn btn-warning" id="hide_menu"><i class="fa fa-times"></i> Non-Aktifkan</a>
                            <a href="javascript:;" class="btn btn-danger" id="delete_menu"><i class="fa fa-trash-alt"></i> Hapus</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="kt-portlet__body">
                      <ul class="nav nav-tabs nav-fill" role="tablist">
                        <li class="nav-item">
                          <a href="#category" data-toggle="tab" class="nav-link active"><i class="fa fa-bars"></i> Kategori</a>
                        </li>
                        <li class="nav-item">
                          <a href="#role" data-toggle="tab" class="nav-link"><i class="fa fa-check"></i> Akses</a>
                        </li>
                        <li class="nav-item">
                          <a href="#order" data-toggle="tab" class="nav-link"><i class="fa fa-sort"></i> Posisi</a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="category" role="tabpanel">
                          <div id="t_table">
                            <table id="t_menu"></table>
                            <div id="pager_menu"></div>
                          </div>
                          <div id="t_form_add">
                            <form action="javascript:;" method="post" class="kt-form kt-form--label-right" id="form_add">
                              <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Parent </label>
                                <div class="col-lg-4">
                                  <select name="parent" class="form-control" id="parent">
                                    <option value="" selected="selected">-- Pilih --</option>
                                    <option value="0" flag="0" subparent="0">Is Flag</option>
                                    <?php
                                    foreach($category as $cat){
                                      $flag = $cat['flag'];
                                      $parent = $cat['parent'];
                                      $menu = $cat['menu'];

                                      if($flag == 0){
                                    ?>
                                    <option value="<?php echo $parent; ?>" flag="1" subparent="0"><?php echo $menu; ?></option>
                                    <?php
                                    }

                                    foreach($category as $cat2){
                                      $flag2 = $cat2['flag'];
                                      $parent2 = $cat2['parent'];
                                      $menu2 = $cat2['menu'];
                                      $subparent2 = $cat2['subparent'];

                                      if($flag2 == 1 and $subparent2 == $parent){
                                    ?>
                                    <option value="<?php echo $parent2; ?>" flag="2" subparent="0"><?php echo $menu.' &raquo; '.$menu2; ?></option>
                                    <?php
                                    }

                                    foreach($category as $cat3){
                                      $flag3 = $cat3['flag'];
                                      $parent3 = $cat3['parent'];
                                      $subparent3 = $cat3['subparent'];
                                      $menu3 = $cat3['menu'];

                                      if($flag3 == 2 and $subparent2 == $parent and $subparent3 == $parent2){
                                    ?>
                                    <option value="<?php echo $parent2; ?>" flag="2" subparent="1"><?php echo $menu.' &raquo; '.$menu2.' &raquo; '.$menu3; ?></option>
                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                  </select>
                                  <input name="subparent" type="hidden" id="subparent">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Menu</label>
                                <div class="col-lg-4">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon2"><i class="fa fa-bars"></i></span>
                                    </div>
                                    <input name="menu" type="text" id="menu" class="form-control">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Flag </label>
                                <div class="col-lg-4">
                                  <select name="flag" class="form-control" id="flag">
                                    <option value="0" selected="selected">-- Pilih --</option>
                                    <option value="1">Memiliki URL</option>
                                    <option value="2">Tidak Memiliki URL</option>
                                  </select>
                                  <input name="flag2" type="hidden" id="flag2">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-lg-3 col-form-label">URL</label>
                                <div class="col-lg-4">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon2"><i class="fa fa-link"></i></span>
                                    </div>
                                    <input name="control" type="text" id="control" class="form-control" readonly="readonly">
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
                            <form action="javascript:;" method="post" class="kt-form kt-form--label-right" id="form_edit">
                              <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Parent </label>
                                <div class="col-lg-4">
                                  <input name="id" type="hidden" id="id">
                                  <select name="parent" class="form-control" id="parent">
                                    <option value="">-- Pilih --</option>
                                    <option value="0" flag="0" subparent="0">Is Flag</option>
                                    <?php
                                    foreach($category as $cat){
                                      $flag = $cat['flag'];
                                      $parent = $cat['parent'];
                                      $menu = $cat['menu'];

                                      if($flag == 0){
                                    ?>
                                    <option value="<?php echo $parent; ?>" flag="1" subparent="0"><?php echo $menu; ?></option>
                                    <?php
                                        }

                                      foreach($category as $cat2){
                                        $flag2 = $cat2['flag'];
                                        $parent2 = $cat2['parent'];
                                        $menu2 = $cat2['menu'];
                                        $subparent2 = $cat2['subparent'];

                                        if($flag2 == 1 and $subparent2 == $parent){
                                    ?>
                                    <option value="<?php echo $parent2; ?>" flag="2" subparent="0"><?php echo $menu.' &raquo; '.$menu2; ?></option>
                                    <?php
                                          }

                                        foreach($category as $cat3){
                                          $flag3 = $cat3['flag'];
                                          $parent3 = $cat3['parent'];
                                          $subparent3 = $cat3['subparent'];
                                          $menu3 = $cat3['menu'];

                                          if($flag3 == 2 and $subparent2 == $parent and $subparent3 == $parent2){
                                    ?>
                                    <option value="<?php echo $parent2; ?>" flag="2" subparent="1"><?php echo $menu.' &raquo; '.$menu2.' &raquo; '.$menu3; ?></option>
                                    <?php
                                            }
                                        }
                                      }
                                    }
                                    ?>
                                  </select>
                                  <input name="subparent" type="hidden" id="subparent">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Menu </label>
                                <div class="col-lg-4">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon2"><i class="fa fa-bars"></i></span>
                                    </div>
                                    <input name="menu" type="text" id="menu" class="form-control">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-lg-3 col-form-label">Flag </label>
                                <div class="col-lg-4">
                                  <select name="flag" class="form-control" id="flag">
                                    <option value="0" selected="selected">-- Pilih --</option>
                                    <option value="1">Memiliki URL</option>
                                    <option value="2">Tidak Memiliki URL</option>
                                  </select>
                                  <input name="flag2" type="hidden" id="flag2">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-lg-3 col-form-label">URL </label>
                                <div class="col-lg-4">
                                  <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="basic-addon2"><i class="fa fa-link"></i></span>
                                    </div>
                                    <input name="control" type="text" id="control" class="form-control" readonly="readonly">
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
                        <div class="tab-pane" id="role" role="tabpanel">
                          <div id="t_table2">
                            <table id="t_role"></table>
                            <div id="pager_role"></div>
                          </div>
                          <div id="t_form_role">
                            <form action="javascript:;" method="post" class="kt-form kt-form--label-right" id="form_role">
                              <div class="form-group row">
                                <div class="col-lg-7">
                                  <div id="permission">
                                  </div>
                                </div>
                              </div>
                              <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                  <div class="col-lg-3">&nbsp;</div>
                                  <div class="col-lg-4">
                                    <button type="button" class="btn btn-secondary" id="cancel3"><i class="fa fa-arrow-left"></i> Kembali</button>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-edit"></i> Ubah</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="tab-pane" id="order" role="tabpanel">
                          <div id="menu_position">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END ROW -->
            </div>
