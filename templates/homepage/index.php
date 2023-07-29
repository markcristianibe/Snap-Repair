<?php
include("server/connection/db_connection.php");
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">

<link rel="stylesheet" href="templates/homepage/style.css" type="text/css">

<body id="body-pd" class="body-pd">
    <header class="header body-pd" id="header">
        <div class="header_toggle"> <!--<i class='bx bx-menu bx-x text-light' id="header-toggle"></i>--> </div>
        <div class="dropdown">
            <button class="btn align-items-center text-white dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; width: 75px">
                <img src="img/user-1.png" alt="" width="35" height="35" class="rounded-circle me-2">
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><i class='bx bx-user nav_icon'></i>  Profile</a></li>
                <li><a class="dropdown-item" href="server/user_auth/user-auth.php?action=logout"><i class='bx bx-log-out nav_icon'></i> Sign Out</a></li>
            </ul>
          </div>
    </header>
    <div class="l-navbar show" id="nav-bar">
        <nav class="nav">
            <div> 
                <a href="../Snap-Repair" class="nav_logo" style="text-decoration: none"> 
                    <img src="img/logo.png" width="25px" style="border-radius: 50%"> 
                    <span class="nav_logo-name">Snap Repair</span> 
                </a>
                <div class="nav_list"> 
                    <a href="#" class="nav_link active" id="dashboard"> 
                        <i class='bx bx-grid-alt nav_icon'></i> 
                        <span class="nav_name">Dashboard</span> 
                    </a> 
                    <a href="#" class="nav_link" id="assets"> 
                        <i class='bx bxs-dollar-circle nav_icon'></i> 
                        <span class="nav_name">Assets</span> 
                    </a> 
                    <a href="#" class="nav_link" id="inventory"> 
                        <i class='bx bxs-component nav_icon'></i> 
                        <span class="nav_name">Inventory</span> 
                    </a> 
                    <a href="#" class="nav_link" id="damageReports"> 
                        <i class='bx bxs-report nav_icon'></i> 
                        <span class="nav_name">Damage Reports</span> 
                    </a> 
                </div>
            </div> 
            <a href="#" class="nav_link" id="settings"> 
                <i class='bx bx-cog nav_icon'></i> 
                <span class="nav_name">Settings</span> 
            </a>
        </nav>
    </div>
    <!--Container Main start-->
    <br>
    <div id="main-content" class="text-light">
        <?php
        if(isset($_GET["page"])){
            if($_GET["page"] == "dashboard"){
                include("templates/dashboard/index.php");
            }
            elseif($_GET["page"] == "assets"){
                include("templates/assets/index.php");
            }
            else if($_GET["page"] == 'asset-info'){
                include("templates/assets/asset-info.php");
            }
            else if($_GET["page"] == "inventory"){
                include("templates/inventory/index.php");
            }
            else if($_GET["page"] == 'damage-reports'){
                include("templates/damage-reports/index.php");
            }
            else if($_GET["page"] == 'inventory-info'){
                include("templates/inventory/inventory-info.php");
            }
            else if($_GET["page"] == 'reports'){
                include("templates/reports/index.php");
            }
            else if($_GET["page"] == 'logs'){
                include("templates/logs/index.php");
            }else if($_GET["page"] == 'settings'){
                include("templates/settings/index.php");
            }
        }
        else{
            include("templates/dashboard/index.php");
        }
        ?>
    </div>
    <!--Container Main end-->
    <script src="templates/homepage/script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>