<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <?php if (auth()->guard('admin')->user()->type == 'admin'): ?>
            <li>
                <a href="{{ url('admin/home') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li>
                <a href=""><i class="fa fa-cc-visa"></i> <span>Add Visa</span></a>
            </li>
            <li>
                <a href=""><i class="fa fa-cogs"></i> <span>Manage Visa</span></a>
            </li>
            <li>
                <a href=""><i class="fa fa-list"></i> <span>Manage Home Sidebar</span></a>
            </li>
            <li>
                <a href=""><i class="fa fa-puzzle-piece"></i> <span>Add Section</span></a>
            </li>
            <li>
                <a href=""><i class="fa fa-cogs"></i> <span>Manage Section</span></a>
            </li>
            <?php else: ?>
            <li>
                <a href=""><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            
            <li>
                <a href=""><i class="fa fa-cogs"></i> <span>Manage Visa</span></a>
            </li>
            <?php endif; ?>
        </ul>
    </section>
</aside>
