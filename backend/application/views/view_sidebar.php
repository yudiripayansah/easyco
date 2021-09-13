<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
						<!--begin::Menu Container-->
						<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
							<!--begin::Menu Nav-->
							<ul class="menu-nav">
								<li class="menu-item<?php echo ($uri == 'dashboard') ? ' menu-item-active' : ''; ?>" aria-haspopup="true">
									<a href="." class="menu-link">
										<span class="svg-icon menu-icon">
											<i class="icon-md fas fa-home"></i>
										</span>
										<span class="menu-text">Dashboard</span>
									</a>
								</li>
                                <?php
                                $subur = $suburi['subparent'];
                                foreach($menu as $cat){
                                    $flag = $cat['flag'];
                                    $parent = $cat['parent'];
                                    $menus = $cat['menu'];
                                    $icon = $cat['icon'];
                                    $control = $cat['url_link'];

                                    if($flag == 0 and $control != 'javascript:;'){
                                ?>
								<li class="menu-item<?php echo ($uri == $control) ? ' menu-item-active' : ''; ?>" aria-haspopup="true">
									<a href="<?php echo $control; ?>" class="menu-link">
										<span class="svg-icon menu-icon">
											<i class="icon-md <?php echo $icon; ?>"></i>
										</span>
										<span class="menu-text"><?php echo $menus; ?></span>
									</a>
								</li>
                                <?php } else if($flag == 0 and $control == 'javascript:;'){ ?>
								<li class="menu-section">
									<h4 class="menu-text"><?php echo $menus; ?></h4>
									<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
								</li>
                                <?php
                                foreach($menu as $cat2){
                                    $flag2 = $cat2['flag'];
                                    $parent2 = $cat2['parent'];
                                    $menus2 = $cat2['menu'];
                                    $icon2 = $cat2['icon'];
                                    $control2 = $cat2['url_link'];
                                    $subparent2 = $cat2['subparent'];

                                    if($flag2 == 1 and $subparent2 == $parent and $control2 != 'javascript:;'){
                                ?>
								<li class="menu-item<?php echo ($uri == $control2) ? ' menu-item-active' : ''; ?>" aria-haspopup="true">
									<a href="<?php echo $control2; ?>" class="menu-link">
										<span class="menu-icon">
											<i class="icon-md <?php echo $icon2; ?>"></i>
										</span>
										<span class="menu-text"><?php echo $menus2; ?></span>
									</a>
								</li>
                                <?php } else if($flag2 == 1 and $subparent2 == $parent and $control2 == 'javascript:;'){ ?>
								<li class="menu-item menu-item-submenu<?php echo ($subur == $parent2) ? ' menu-item-open menu-item-here' : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">
									<a href="<?php echo $control2; ?>" class="menu-link menu-toggle">
										<span class="menu-icon">
											<i class="icon-md <?php echo $icon2; ?>"></i>
										</span>
										<span class="menu-text"><?php echo $menus2; ?></span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu">
										<i class="menu-arrow"></i>
										<ul class="menu-subnav">
                                            <?php
                                            foreach($menu as $cat3){
                                                $flag3 = $cat3['flag'];
                                                $parent3 = $cat3['parent'];
                                                $menus3 = $cat3['menu'];
                                                $icon3 = $cat3['icon'];
                                                $control3 = $cat3['url_link'];
                                                $subparent3 = $cat3['subparent'];

                                                if($flag3 == 2 and $subparent2 == $parent and $subparent3 == $parent2){
                                            ?>
											<li class="menu-item<?php echo ($uri == $control3) ? ' menu-item-active' : ''; ?>" aria-haspopup="true">
												<a href="<?php echo $control3; ?>" class="menu-link">
													<i class="menu-bullet menu-bullet-line">
														<span></span>
													</i>
													<span class="menu-text"><?php echo $menus3; ?></span>
												</a>
											</li>
                                            <?php } } ?>
										</ul>
									</div>
								</li>
                                <?php } } } } ?>
							</ul>
							<!--end::Menu Nav-->
						</div>
						<!--end::Menu Container-->
					</div>
