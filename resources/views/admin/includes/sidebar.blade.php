<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <?php if (auth()->guard('admin')->user()->type == 'admin'): ?>
            <li class="{{ Request::is('admin/home') ? 'active' : '' }}">
                <a href="{{ url('admin/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="treeview {{ Request::is('admin/agents*') || Request::is('admin/foreign-agents*') || Request::is('admin/manage-plans*') || Request::is('admin/agent-types*') || Request::is('admin/agent-reviews*') || Request::is('admin/agent-cities*') || Request::is('admin/manage-flights*') || Request::is('admin/travel-news*') || Request::is('admin/airline-updates*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Agents</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/agents') ? 'active' : '' }}">
                        <a href="{{ url('admin/agents') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Agents</span></a>
                    </li>
                      <li class="{{ Request::is('admin/foreign-agents') ? 'active' : '' }}">
                        <a href="{{ url('admin/foreign-agents') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Foreign Agents</span></a>
                    </li>
                    <!--<li class="{{ Request::is('admin/manage-plans') ? 'active' : '' }}">-->
                    <!--    <a href="{{ url('admin/manage-plans')}}"><i class="fa fa-tasks"></i> Agent Status</a>-->
                    <!--</li>-->
                    <li class="{{ Request::is('admin/agent-types') ? 'active' : '' }}">
                        <a href="{{ url('admin/agent-types') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Agents Type</span></a>
                    </li>
                
                    
                    <li class="{{ Request::is('admin/agent-reviews') ? 'active' : '' }}">
                        <a href="{{ url('admin/agent-reviews') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Agents Reviews</span></a>
                    </li>
                    <li class="{{ Request::is('admin/agent-cities') ? 'active' : '' }}">
                        <a href="{{ url('admin/agent-cities') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Agent Cities</span></a>
                    </li>
                    
                    
                
                    <li class="{{ Request::is('admin/travel-news') ? 'active' : '' }}">
                        <a href="{{ url('admin/travel-news') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Travel News</span></a>
                    </li>
                    <li class="{{ Request::is('admin/airline-updates') ? 'active' : '' }}">
                        <a href="{{ url('admin/airline-updates') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Airline circulars</span></a>
                    </li>
                </ul>
            </li>
            <!-- <li class="treeview {{ Request::is('admin/manage-visas*') ? 'active' : '' }}">-->
            <!--    <a href="#"><i class="fa fa-link"></i> <span>Visa</span>-->
            <!--        <span class="pull-right-container">-->
            <!--            <i class="fa fa-angle-left pull-right"></i>-->
            <!--        </span>-->
            <!--    </a>-->
            <!--    <ul class="treeview-menu">-->
            <!--        <li class="{{ Request::is('admin/manage-visas') ? 'active' : '' }}">-->
            <!--            <a href="{{ route('admin.manage-visas') }}"><i class="fa fa-cogs"></i> <span>Manage Visa</span></a>-->
            <!--        </li>-->
            <!--        <li class="{{ Request::is('admin/add-visa') ? 'active' : '' }}">-->
            <!--            <a href="{{ route('admin.add-visa') }}"><i class="fa fa-cc-visa"></i> <span>Add Visa</span></a>-->
            <!--        </li>-->
                    <!--<li class="{{ Request::is('admin/images') ? 'active' : '' }}">-->
                    <!--    <a href="{{ url('admin/images') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Images</span></a>-->
                    <!--</li>-->
                    <!--<li class="{{ Request::is('admin/visa-policy/1') ? 'active' : '' }}">-->
                    <!--    <a href="{{ url('admin/visa-policy') }}/1"><i class="fa fa-puzzle-piece"></i> <span>Manage Visa Policy</span></a>-->
                    <!--</li>-->
                    <!--<li class="{{ Request::is('admin/schengen/1') ? 'active' : '' }}">-->
                    <!--    <a href="{{ url('admin/schengen') }}/1"><i class="fa fa-puzzle-piece"></i> <span>Manage Schengen Visa</span></a>-->
                    <!--</li>-->
            <!--    </ul>-->
            <!--</li> -->
            <!-- <li class="{{ Request::is('admin/manage-home-sidebar') ? 'active' : '' }}">
                <a href="{{ route('admin.manage-home-sidebar') }}"><i class="fa fa-list"></i> <span>Manage Home Sidebar</span></a>
            </li> -->
            <!-- <li class="treeview {{ Request::is('admin/manage-section*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Sections</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/manage-section') ? 'active' : '' }}">
                        <a href="{{ route('admin.manage-section') }}"><i class="fa fa-cogs"></i> <span>Manage Section</span></a>
                    </li>
                    <li class="{{ Request::is('admin/add-section') ? 'active' : '' }}">
                        <a href="{{ route('admin.add-section') }}"><i class="fa fa-puzzle-piece"></i> <span>Add Section</span></a>
                    </li>
                </ul>
            </li> -->
            <li class="treeview {{ Request::is('admin/airline*') || Request::is('admin/cities*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Airlines</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/airline') ? 'active' : '' }}">
                        <a href="{{ url('admin/airline') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Airlines</span></a>
                    </li>
               
                </ul>
            </li>
            <!-- <li class="treeview {{ Request::is('admin/manage-custom-content*') || Request::is('admin/manage-page*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Content</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    
                </ul>
            </li> -->
            <li class="treeview {{ Request::is('admin/packages*') || Request::is('admin/umrah-policy-2019*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Umrah Packages</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/packages') ? 'active' : '' }}">
                        <a href="{{ url('admin/packages') }}"><i class="fa fa-puzzle-piece"></i> <span> Umrah Packages</span></a>
                    </li>
                    <li class="{{ Request::is('admin/umrah-policy-2019/2') ? 'active' : '' }}">
                        <a href="{{ url('admin/umrah-policy-2019') }}/2"><i class="fa fa-puzzle-piece"></i> <span>Manage Umrah Policy {{date('Y')}}</span></a>
                    </li>
                </ul>
            </li>
                <li class="{{ Request::is('admin/manage-sasti-tickets') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-sasti-tickets') }}"><i class="fa fa-puzzle-piece"></i> <span>Sasti Tickets</span></a>
                    </li>
                    <li class="{{ Request::is('admin/manage-flights') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-flights') }}"><i class="fa fa-puzzle-piece"></i> <span>Umrah Tickets</span></a>
                    </li>
             <li class="{{ Request::is('admin/embassy') ? 'active' : '' }}">
                <a href="{{ url('admin/embassy') }}"><i class="fa fa-puzzle-piece"></i> <span>Embassy Pages</span></a>
            </li>
          <li class="treeview {{ Request::is('admin/blogs*') || Request::is('admin/blogs-categories*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Blogs</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/blogs') ? 'active' : '' }}">
                        <a href="{{ url('admin/blogs') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Blogs</span></a>
                    </li>
                    <li class="{{ Request::is('admin/blogs-categories') ? 'active' : '' }}">
                        <a href="{{ url('admin/blogs-categories') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Blogs Category</span></a>
                    </li>                                                                                                                                                                       
                </ul>
            </li>                   
            <li class="treeview {{ Request::is('admin/agent-promotions*') || Request::is('admin/agent-gallery*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Approval Requests</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/agent-promotions') ? 'active' : '' }}">
                        <a href="{{ url('admin/agent-promotions') }}"><i class="fa fa-puzzle-piece"></i> <span>Approve Promotions</span></a>
                    </li>
                    <li class="{{ Request::is('admin/agent-gallery') ? 'active' : '' }}">
                        <a href="{{ url('admin/agent-gallery') }}"><i class="fa fa-puzzle-piece"></i> <span>Approve Gallery</span></a>
                    </li>
                     <li class="{{ Request::is('admin/agent-images-approve') ? 'active' : '' }}">
                        <a href="{{ url('admin/agent-images-approve') }}"><i class="fa fa-puzzle-piece"></i> <span>Approve Banner / Logo</span></a>
                    </li>
                </ul>
            </li>
             <li class="{{ Request::is('admin/manage-hotels') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-hotels') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Hotels</span></a>
                    </li>
             <li class="{{ Request::is('admin/ticket-filters') ? 'active' : '' }}">
                        <a href="{{ url('admin/ticket-filters') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Filter Presets</span></a>
                    </li>
                     <li class="{{ Request::is('admin/manage-links') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-links') }}"><i class="fa fa-puzzle-piece"></i> <span>Useful Links</span></a>
                    </li>
            
            <li class="treeview {{ Request::is('admin/manage-jobs*') || Request::is('admin/jobs-applicants*') || Request::is('admin/job-experiences*') || Request::is('admin/job-categories*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Jobs</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                 
                    <li class="{{ Request::is('admin/manage-jobs') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-jobs') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Jobs</span></a>
                    </li>
                    <li class="{{ Request::is('admin/jobs-applicants') ? 'active' : '' }}">
                        <a href="{{ url('admin/jobs-applicants') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Applicants</span></a>
                    </li>
                    <li class="{{ Request::is('admin/job-experiences') ? 'active' : '' }}">
                        <a href="{{ url('admin/job-experiences') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Job Experience</span></a>
                    </li>
                    <li class="{{ Request::is('admin/job-categories') ? 'active' : '' }}">
                        <a href="{{ url('admin/job-categories') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Job Categories</span></a>
                    </li>
                      <li class="{{ Request::is('admin/job-designations') ? 'active' : '' }}">
                        <a href="{{ url('admin/job-designations') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Job Designations</span></a>
                    </li>
                   
                   
                </ul>
            </li>
            <!-- <li class="treeview {{ Request::is('admin/manage-subscription*') || Request::is('admin/manage-plan-permissions*') || Request::is('admin/manage-permissions*') || Request::is('admin/manage-price*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Agent Subscription</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/manage-subscription') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-subscription')}}"><i class="fa fa-tasks"></i> Manage Subscriptions</a>
                    </li>
                   
                    <li class="{{ Request::is('admin/manage-plan-permissions') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-plan-permissions')}}"><i class="fa fa-key"></i> Plans Permissions</a>
                    </li>
                    <li class="{{ Request::is('admin/manage-permissions') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-permissions')}}"><i class="fa fa-key"></i> Manage Permissions</a>
                    </li>
                    <li class="{{ Request::is('admin/manage-price') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-price')}}"><i class="fa fa-money"></i> Price & discount</a>
                    </li>
                </ul>
            </li> -->
            
            <li class="treeview {{ Request::is('admin/contact*') || Request::is('admin/newsletter*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>User Request</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/contact') ? 'active' : '' }}">
                        <a href="{{ route('admin.contact') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Contact Request</span></a>
                    </li>
                    <li class="{{ Request::is('admin/newsletter') ? 'active' : '' }}">
                        <a href="{{ url('admin/newsletter') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Newsletter</span></a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ Request::is('admin/general-settings*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Website Settings</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('admin/general-settings') ? 'active' : '' }}">
                        <a href="{{ route('admin.general-settings') }}"><i class="fa fa-puzzle-piece"></i> <span>Main Settings</span></a>
                    </li>
                    <li class="{{ Request::is('admin/manage-custom-content') ? 'active' : '' }}">
                        <a href="{{ route('admin.manage-custom-content') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Custom Content</span></a>
                    </li>
                    <li class="{{ Request::is('admin/manage-page') ? 'active' : '' }}">
                        <a href="{{ route('admin.manage-page') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Pages Content</span></a>
                    </li>
                    <!-- <li class="{{ Request::is('admin/related') ? 'active' : '' }}">
                        <a href="{{ url('admin/related') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Related Sites</span></a>
                    </li>
                    <li class="{{ Request::is('admin/assign-embassy') ? 'active' : '' }}">
                        <a href="{{ url('admin/assign-embassy') }}"><i class="fa fa-puzzle-piece"></i> <span>Assign Embassies</span></a>
                    </li> -->
                </ul>
            </li>
            <li class="treeview {{ Request::is('admin/cities*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-link"></i> <span>Settings</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                <li class="{{ Request::is('admin/cities') ? 'active' : '' }}">
                        <a href="{{ url('admin/cities') }}"><i class="fa fa-puzzle-piece"></i> <span>Cities</span></a>
                    </li>
                    <!-- <li class="{{ Request::is('admin/related') ? 'active' : '' }}">
                        <a href="{{ url('admin/related') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Related Sites</span></a>
                    </li>
                    <li class="{{ Request::is('admin/assign-embassy') ? 'active' : '' }}">
                        <a href="{{ url('admin/assign-embassy') }}"><i class="fa fa-puzzle-piece"></i> <span>Assign Embassies</span></a>
                    </li> -->
                </ul>
            </li>
            <?php elseif(auth()->guard('admin')->user()->type == 'content-writer'): ?>
            <!--<li class="{{ Request::is('admin/manage-visas') ? 'active' : '' }}">-->
            <!--    <a href="{{ route('admin.manage-visas') }}"><i class="fa fa-cogs"></i> <span>Manage Visa</span></a>-->
            <!--</li>-->
            <!--<li class="{{ Request::is('admin/cities') ? 'active' : '' }}">-->
            <!--    <a href="{{ url('admin/cities') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Cities</span></a>-->
            <!--</li>-->
              <li class="{{ Request::is('admin/manage-hotels') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-hotels') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Hotels</span></a>
                    </li>
             <li class="treeview active">
                <a href="#"><i class="fa fa-link"></i> <span>Jobs</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                 
                    <li class="{{ Request::is('admin/manage-jobs') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-jobs') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Jobs</span></a>
                    </li>
                     <li class="{{ Request::is('admin/job-categories') ? 'active' : '' }}">
                        <a href="{{ url('admin/job-categories') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Job Categories</span></a>
                    </li>
                       <li class="{{ Request::is('admin/job-designations') ? 'active' : '' }}">
                        <a href="{{ url('admin/job-designations') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Job Designations</span></a>
                    </li>
                    <!--<li class="{{ Request::is('admin/jobs-applicants') ? 'active' : '' }}">-->
                    <!--    <a href="{{ url('admin/jobs-applicants') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Applicants</span></a>-->
                    <!--</li>-->
                    <!--<li class="{{ Request::is('admin/job-experiences') ? 'active' : '' }}">-->
                    <!--    <a href="{{ url('admin/job-experiences') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Job Experience</span></a>-->
                    <!--</li>-->
                   
                   
                   
                </ul>
            </li>
                <li class="{{ Request::is('admin/embassy') ? 'active' : '' }}">
                <a href="{{ url('admin/embassy') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Embassy Pages</span></a>
            </li>
                  <li class="{{ Request::is('admin/manage-links') ? 'active' : '' }}">
                        <a href="{{ url('admin/manage-links') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Useful Links</span></a>
                    </li>
            <?php else: ?>
            <li class="{{ Request::is('admin/home') ? 'active' : '' }}">
                <a href="{{ url('admin/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ Request::is('admin/agents') ? 'active' : '' }}">
                <a href="{{ url('admin/agents') }}"><i class="fa fa-cogs"></i> <span>Manage Agents</span></a>
            </li>
            <!--<li class="{{ Request::is('admin/cities') ? 'active' : '' }}">-->
            <!--    <a href="{{ url('admin/cities') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Cities</span></a>-->
            <!--</li>-->
            <!--<li class="{{ Request::is('admin/embassy') ? 'active' : '' }}">-->
            <!--    <a href="{{ url('admin/embassy') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Embassy Pages</span></a>-->
            <!--</li>-->
            <!--<li class="{{ Request::is('admin/packages') ? 'active' : '' }}">-->
            <!--    <a href="{{ url('admin/packages') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Umrah Packages</span></a>-->
            <!--</li>-->
            <!--<li class="{{ Request::is('admin/images') ? 'active' : '' }}">-->
            <!--    <a href="{{ url('admin/images') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Images</span></a>-->
            <!--</li>-->
            <!--<li class="{{ Request::is('admin/airline') ? 'active' : '' }}">-->
            <!--    <a href="{{ url('admin/airline') }}"><i class="fa fa-puzzle-piece"></i> <span>Manage Airlines</span></a>-->
            <!--</li>-->
            <?php endif; ?>
        </ul>
    </section>
</aside>
