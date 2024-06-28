<?php

include_once 'includes/dbh.inc.php';

$userId = $_SESSION['userid'];
$sql = "SELECT profile_pic_path FROM users WHERE usersId = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "SQL error.";
    exit();
}
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $imagePath = $row['profile_pic_path'];
    if ($imagePath) {
        $imageSrc = $imagePath;
    } else {
        $imageSrc = 'https://via.placeholder.com/150';
    }
} else {
    $imageSrc = 'https://via.placeholder.com/150';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
</head>
<body>
    <img src="<?php echo htmlspecialchars($imageSrc); ?>" height="150px" width="100%" justify-content="center" alt="Profile Picture">
</body>
</html>
