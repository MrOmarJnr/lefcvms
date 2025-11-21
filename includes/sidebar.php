<!-- Sidebar -->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="dashboard.php">
            <img src="images/lef-logo.png" alt="LEF Logo" style="height: 55px;" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">

                <!-- Dashboard -->
                <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
                    <a href="dashboard.php">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>

                <!-- Visitors -->
                <li class="has-sub <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['visitors-form.php', 'manage-newvisitors.php'])) ? 'active' : ''; ?>">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-users"></i>Visitors</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li><a href="visitors-form.php">Add Visitor</a></li>
                        <li><a href="manage-newvisitors.php">Manage Visitors</a></li>
                    </ul>
                </li>

                <!-- Departments -->
                <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'department.php') ? 'active' : ''; ?>">
                    <a href="department.php">
                        <i class="fas fa-sitemap"></i>Departments</a>
                </li>

                <!-- Employee Management -->
                <li class="has-sub <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['employee-attendance.php', 'add-employee.php'])) ? 'active' : ''; ?>">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-id-badge"></i>Employees</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li><a href="add-employee.php">Add Employee</a></li>
                        <li><a href="employee-attendance.php">Clock In / Out</a></li>
                    </ul>
                </li>

                <!-- Reports -->
                <li class="has-sub <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['bwdates-reports.php', 'attendance-reports.php'])) ? 'active' : ''; ?>">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-chart-bar"></i>Reports</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li><a href="bwdates-reports.php">Visitor Reports</a></li>
                        <li><a href="attendance-reports.php">Attendance Reports</a></li>
                    </ul>
                </li>

                <!-- Admin -->
                <li class="has-sub <?php echo (in_array(basename($_SERVER['PHP_SELF']), ['profile.php', 'change-password.php'])) ? 'active' : ''; ?>">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-user-cog"></i>Admin</a>
                    <ul class="list-unstyled navbar__sub-list js-sub-list">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="change-password.php">Change Password</a></li>
                    </ul>
                </li>

                <!-- Logout -->
                <li>
                    <a href="logout.php">
                        <i class="fas fa-sign-out-alt"></i>Logout</a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
<!-- End Sidebar -->
