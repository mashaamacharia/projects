<?php
$uploadDir = 'uploads/';

if (!is_dir($uploadDir)) {
    // Attempt to create the directory
    if (mkdir($uploadDir, 0755, true)) {
        echo "Directory 'uploads/' created successfully.";
        // Set the permissions
        if (chmod($uploadDir, 0755)) {
            echo " Permissions set to 0755.";
        } else {
            echo " Failed to set permissions.";
        }
    } else {
        echo "Failed to create the directory 'uploads/'.";
    }
} else {
    echo "The directory 'uploads/' already exists.";
}
?>
