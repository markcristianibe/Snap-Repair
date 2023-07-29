<?php
include("../connection/db_connection.php");

function GenerateAssetID(){
    include("../connection/db_connection.php");

    $date = date("ym");    
    $result = mysqli_query($conn, "SELECT COUNT(*) as row_count FROM tbl_assets WHERE ID LIKE '$date%' AND STATUS != 'Archived'");

    // Fetch the result as an associative array
    $row = $result->fetch_assoc();
    
    // Get the row count from the result
    $rowCount = $row['row_count'];
    $newID = $rowCount + 1;
    $id = $date . $newID;
    return $id;
}

if(isset($_POST["create_asset"])){
    $assetID = GenerateAssetID();
    $category = mysqli_real_escape_string($conn, $_POST["asset_category"]);
    $asset = mysqli_real_escape_string($conn, $_POST["asset_name"]);

    $query = mysqli_query($conn, "INSERT INTO tbl_assets (ID, CATEGORY, ASSET, STATUS) VALUES ('$assetID', '$category', '$asset', 'Active')");
    if($query){
        header("location:../../?page=asset-info&id=" . $assetID);
    }
}

if(isset($_POST["add_asset_component"])){
    $assetID = mysqli_real_escape_string($conn, $_GET["assetid"]);
    $component = mysqli_real_escape_string($conn, $_POST["component_name"]);

    $query = mysqli_query($conn, "INSERT INTO tbl_components (ASSET_ID, COMPONENT) VALUES ('$assetID', '$component')");
    if($query){
        header("location:../../?page=asset-info&id=" . $assetID);
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "archive-asset"){
    $assetID = mysqli_real_escape_string($conn, $_GET["id"]);

    $query = mysqli_query($conn, "UPDATE tbl_assets SET STATUS = 'Archived' WHERE ID = '$assetID'");
    if($query){
        header("location:../../?page=assets");
    }
}
if(isset($_GET["action"]) && $_GET["action"] == "unarchive-asset"){
    $assetID = mysqli_real_escape_string($conn, $_GET["id"]);

    $query = mysqli_query($conn, "UPDATE tbl_assets SET STATUS = 'Active' WHERE ID = '$assetID'");
    if($query){
        header("location:../../?page=asset-info&id=" . $assetID);
    }
}

if(isset($_POST["add_asset"])){
    $category = mysqli_real_escape_string($conn, $_GET["id"]);
    $assetName = mysqli_real_escape_string($conn, $_POST["asset_name"]);
    $purchaseDate = mysqli_real_escape_string($conn, $_POST["purchase_date"]);
    $purchaseCost = mysqli_real_escape_string($conn, $_POST["purchase_cost"]);
    $utilization = mysqli_real_escape_string($conn, $_POST["utilization"]);
    $intensity = mysqli_real_escape_string($conn, $_POST["intensity"]);

    $query = mysqli_query($conn, "INSERT INTO tbl_inventory (CATEGORY, ASSET_NAME, PURCHASE_DATE, PURCHASE_COST, UTILIZATION, INTENSITY, STATUS) VALUES ('$category', '$assetName', '$purchaseDate', '$purchaseCost', '$utilization', '$intensity', 'Functional')");
    if($query){
        header("location:../../?page=asset-info&id=" . $category);
    }
}

if(isset($_POST["inventory_in"])){
    $category = mysqli_real_escape_string($conn, $_POST["asset_type"]);
    $assetName = mysqli_real_escape_string($conn, $_POST["asset_name"]);
    $purchaseDate = mysqli_real_escape_string($conn, $_POST["purchase_date"]);
    $purchaseCost = mysqli_real_escape_string($conn, $_POST["purchase_cost"]);
    $utilization = mysqli_real_escape_string($conn, $_POST["utilization"]);
    $intensity = mysqli_real_escape_string($conn, $_POST["intensity"]);

    $query = mysqli_query($conn, "INSERT INTO tbl_inventory (CATEGORY, ASSET_NAME, PURCHASE_DATE, PURCHASE_COST, UTILIZATION, INTENSITY, STATUS) VALUES ('$category', '$assetName', '$purchaseDate', '$purchaseCost', '$utilization', '$intensity', 'Functional')");
    if($query){
        header("location:../../?page=asset-info&id=" . $category);
    }
}

if(isset($_POST["report_damage"])){
    $assetID = mysqli_real_escape_string($conn, $_POST["asset_id"]);
    $damagedPart = mysqli_real_escape_string($conn, $_POST["damaged_part"]);
    $damageType = mysqli_real_escape_string($conn, $_POST["damaged_type"]);
    $repairCost = mysqli_real_escape_string($conn, $_POST["repair_cost"]);
    $damageDate = mysqli_real_escape_string($conn, $_POST["damage_date"]);

    $query = mysqli_query($conn, "INSERT INTO tbl_damagereports (ASSET_ID, DAMAGE_TYPE, PARTS, REPAIR_COST, DAMAGE_DATE) VALUES ('$assetID', '$damageType', '$damagedPart', '$repairCost', '$damageDate')");
    if($query){
        header("location:../../?page=damage-reports");
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "working-asset"){
    $assetID = mysqli_real_escape_string($conn, $_GET["id"]);

    $query = mysqli_query($conn, "UPDATE tbl_inventory SET STATUS = 'non functional' WHERE SERIAL_NO = '$assetID'");
    if($query){
        header("location:../../?page=inventory-info&id=". $assetID);
    }
}

if(isset($_GET["action"]) && $_GET["action"] == "damaged-asset"){
    $assetID = mysqli_real_escape_string($conn, $_GET["id"]);

    $query = mysqli_query($conn, "UPDATE tbl_inventory SET STATUS = 'functional' WHERE SERIAL_NO = '$assetID'");
    if($query){
        header("location:../../?page=inventory-info&id=". $assetID);
    }
}

if(isset($_POST["exportdata"])){
    $datatype = mysqli_real_escape_string($conn, $_POST["datatype"]);
    $output = '';
    $datefrom = '';
    $dateto = '';

    if($datatype == 'assets'){
        $query = mysqli_query($conn, "SELECT * FROM tbl_assets");
        if(mysqli_num_rows($query) > 0){
            $output .= "
                <table class='table' bordered='1'>
                    <tr>
                        <th>ID</th>
                        <th>ASSET NAME</th>
                        <th>CATEGORY</th>
                        <th>STATUS</th>
                    </tr>
            ";

            while($row = mysqli_fetch_array($query)){
                $output .= "
                    <tr>
                        <td>" . $row["ID"] . "</td>
                        <td>" . $row["ASSET"] . "</td>
                        <td>" . $row["CATEGORY"] . "</td>
                        <td>" . $row["STATUS"] . "</td>
                    </tr>
                ";
            }

            $output .= "</table>";

            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=Snap-Repair_Assets.xls");
            echo $output;
        }
    }
    else if($datatype == 'inventory'){
        $datefrom = mysqli_real_escape_string($conn, $_POST["datefrom"]);
        $dateto = mysqli_real_escape_string($conn, $_POST["dateto"]);

        $query = mysqli_query($conn, "SELECT tbl_inventory.SERIAL_NO, tbl_assets.ASSET, tbl_inventory.ASSET_NAME, tbl_inventory.PURCHASE_DATE, tbl_inventory.PURCHASE_COST, tbl_inventory.UTILIZATION, tbl_inventory.INTENSITY, tbl_inventory.STATUS FROM tbl_assets, tbl_inventory WHERE tbl_assets.ID = tbl_inventory.CATEGORY AND tbl_inventory.PURCHASE_DATE BETWEEN '$datefrom' AND '$dateto'");
        if(mysqli_num_rows($query) > 0){
            $output .= "
                <table class='table' bordered='1'>
                    <tr>
                        <th>SERIAL_NO</th>
                        <th>CATEGORY</th>
                        <th>ASSET NAME</th>
                        <th>PURCHASE DATE</th>
                        <th>PURCHASE COST</th>
                        <th>UTILIZATION</th>
                        <th>INTENSITY</th>
                        <th>STATUS</th>
                    </tr>
            ";

            while($row = mysqli_fetch_array($query)){
                $output .= "
                    <tr>
                        <td>" . $row["SERIAL_NO"] . "</td>
                        <td>" . $row["ASSET"] . "</td>
                        <td>" . $row["ASSET_NAME"] . "</td>
                        <td>" . $row["PURCHASE_DATE"] . "</td>
                        <td>" . $row["PURCHASE_COST"] . "</td>
                        <td>" . $row["UTILIZATION"] . "</td>
                        <td>" . $row["INTENSITY"] . "</td>
                        <td>" . $row["STATUS"] . "</td>
                    </tr>
                ";
            }

            $output .= "</table>";

            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=Snap-Repair_Inventory.xls");
            echo $output;
        }
        else{
            $output .= "
                <table class='table' bordered='1'>
                    <tr>
                        <th>SERIAL_NO</th>
                        <th>CATEGORY</th>
                        <th>ASSET NAME</th>
                        <th>PURCHASE DATE</th>
                        <th>PURCHASE COST</th>
                        <th>UTILIZATION</th>
                        <th>INTENSITY</th>
                        <th>STATUS</th>
                    </tr>
                    <tr>
                        <td colspan=8>No Records Found</td>
                    </tr>
                </table>";

            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=Snap-Repair_Inventory.xls");
            echo $output;
        }
    }
    else if($datatype == 'damagereports'){
        $datefrom = mysqli_real_escape_string($conn, $_POST["datefrom"]);
        $dateto = mysqli_real_escape_string($conn, $_POST["dateto"]);
        $query = mysqli_query($conn, "SELECT tbl_damagereports.DAMAGE_DATE, tbl_assets.ASSET, tbl_inventory.ASSET_NAME, tbl_damagereports.DAMAGE_TYPE, tbl_damagereports.PARTS, tbl_damagereports.REPAIR_COST FROM tbl_assets, tbl_inventory, tbl_damagereports WHERE tbl_assets.ID = tbl_inventory.CATEGORY AND tbl_inventory.SERIAL_NO = tbl_damagereports.ASSET_ID AND tbl_inventory.PURCHASE_DATE BETWEEN '$datefrom' AND '$dateto' ORDER BY tbl_damagereports.DAMAGE_DATE DESC");
        if(mysqli_num_rows($query) > 0){
            $output .= "
                <table class='table' bordered='1'>
                    <tr>
                        <th>DAMAGE DATE</th>
                        <th>CATEGORY</th>
                        <th>ASSET NAME</th>
                        <th>CAUSE OF DAMAGE</th>
                        <th>DAMAGED COMPONENT</th>
                        <th>REPAIR COST</th>
                    </tr>
            ";

            while($row = mysqli_fetch_array($query)){
                $output .= "
                    <tr>
                        <td>" . $row["DAMAGE_DATE"] . "</td>
                        <td>" . $row["ASSET"] . "</td>
                        <td>" . $row["ASSET_NAME"] . "</td>
                        <td>" . $row["DAMAGE_TYPE"] . "</td>
                        <td>" . $row["PARTS"] . "</td>
                        <td>PHP " . number_format($row["REPAIR_COST"], 2) . "</td>
                    </tr>
                ";
            }

            $output .= "</table>";

            header("Content-Type: application/xlsx");
            header("Content-Disposition: attachment; filename=Snap-Repair_DAMAGE_REPORTS.xls");
            echo $output;
        }
        else{
            $output .= "
                <table class='table' bordered='1'>
                    <tr>
                        <th>DAMAGE DATE</th>
                        <th>CATEGORY</th>
                        <th>ASSET NAME</th>
                        <th>CAUSE OF DAMAGE</th>
                        <th>DAMAGED COMPONENT</th>
                        <th>REPAIR COST</th>
                    </tr>
                    <tr>
                        <td colspan=6>No Records Found</td>
                    </tr>
                </table>";

            header("Content-Type: application/xlsx");
            header("Content-Disposition: attachment; filename=Snap-Repair_DAMAGE_REPORTS.xls");
            echo $output;
        }
    }
}
?>