<template>
    <div class="">

<section class="bottomMenu dir-il-top-fix">
		<div class="container top-search-main">
			<div class="row">
				<div class="col-sm-3">
						<router-link to="/" class="t-bb"> <img src="assets/images/logo.png"></router-link>
					 </div>
	                <div class="col-sm-8">
						<div class="">
							<form class="tourz-search-form tourz-top-search-form" method="GET" action="<?php echo BASE_PATH; ?>mosquelisting">
									
								<div class="input-field headernamesearch stiky_head">
									<input type="text" id="top-select-search" name="name" class="select-search" placeholder="Search Mosque by name - area or council" autocomplete="off">
								</div>
								<div class="input-field">
									<button type="submit" value="" name="search" class="btn btn-primary searchbutton"><i class="fa fa-search"></i></button>
								</div>
							</form>
						</div>
				
					</div>
					<div class="col-sm-1 removecircel">

						<ul>
							<!-- <?php if ( isset($_SESSION['auth']) && $_SESSION['auth'] == 'aBcDeFg7861') { ?> -->
							 <li class="nav-item dropdown notification-list" style="margin-top: 7px;">
                                <router-link class="nav-link dropdown-toggle arrow-none waves-effect waves-light nav-user" data-toggle="dropdown" to="#" role="button"
                                   aria-haspopup="false" aria-expanded="false" shape="circle" style="width: 50px;height: 50px;">
                                    <!-- <?php if (!empty($img->logo)) { ?>
                                    <img src="<?php echo BASE_PATH ?>images/uploades/<?php echo $img->logo; ?>" alt="user" class="img-circle" style="width: 100%;height: 45px;object-fit: cover;">
                                    <?php }else{ ?> -->
                                    <img src="assets/images/s10.jpeg" alt="user" class="img-circle" style="width: 100%;height: 45px;object-fit: cover;">
                                    <!-- <?php } ?> -->
                                </router-link>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow profile-dropdown " aria-labelledby="Preview" style="    width: 289% !important;">
                                  
                                 <ul style="padding: 25px;padding-top: 35px; line-height: 25px;">
                                 		<!-- <?php if (!empty($_SESSION['user_mosque'])) { ?> -->
                                 	<router-link to="/user/detail"><li style=" margin-top: -18px; margin-bottom: 5px;">Mosque Detail</li></router-link>
                                 	<router-link to="/user/updatemosque"><li style="margin-bottom: 5px;">Update Mosque</li></router-link>
                                 	<router-link to="/user/event"><li style="margin-bottom: 5px;">Events In Mosque</li></router-link>
                                 	<router-link to="/user/mosqueimages"><li style="margin-bottom: 5px;">Mosque Images</li></router-link>
                                    <router-link to="/user/check-participants"><li style="margin-bottom: 5px;">Participants  </li></router-link>
									<!-- <?php }else{ ?>
									<router-link to="/user/participated-days"><li style="margin-bottom: 5px;">Participated </li></router-link>
								<?php } ?> -->
                                 	<router-link to="/logout"><li style="color: red;">Log Out</li></router-link>
                                 </ul>
                           

                                </div>
                            </li>
							<!-- <?php }else{ ?>
							<li style="margin-top: 14px;"><router-link to="/login" style="color: white;">Sign In</router-link> </li>
							<?php } ?> -->
						</ul>
						
					</div>
			
				</div>
			</div>
		
	</section>
</div>
</template>