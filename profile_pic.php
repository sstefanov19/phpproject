<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "includes/dbh.inc.php";

$userId = $_SESSION['userid'];
$sql = "SELECT profile_pic FROM users WHERE usersId=?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
} else {
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if ($row && isset($row['profile_pic'])) {
        $imageData = $row['profile_pic'];
        $imageSrc = 'data:image/jpeg;base64,' . base64_encode($imageData);
    } else {
        $imageSrc = 'https://via.placeholder.com/150';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Picture</title>
</head>
<body>
    <img src="<?php echo $imageSrc; ?>" alt="Profile Picture">
   
</body>
</html>
