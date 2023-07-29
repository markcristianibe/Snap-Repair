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
?>