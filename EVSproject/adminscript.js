document.getElementById("registerBtn").addEventListener("click", function() {
    document.getElementById("registerForm").style.display = "block";
    document.getElementById("announcementForm").style.display = "none";
});

document.getElementById("announceBtn").addEventListener("click", function() {
    document.getElementById("registerForm").style.display = "none";
    document.getElementById("announcementForm").style.display = "block";
});
document.addEventListener('DOMContentLoaded', () => {
    const positionSelect = document.getElementById('position');
    const facultySelect = document.getElementById('faculty');

    // Disable faculty dropdown by default
    facultySelect.disabled = true;

    // Listen to changes on the position select dropdown
    positionSelect.addEventListener('change', function () {
        if (this.value === 'faculty-rep') {
            // Enable the faculty dropdown when Faculty-Rep is selected
            facultySelect.disabled = false; // Explicitly remove the disabled attribute
            facultySelect.style.backgroundColor = ''; // Reset background color
        } else {
            // Disable the faculty dropdown for all other positions
            facultySelect.disabled = true; // Re-add the disabled attribute
            facultySelect.style.backgroundColor = '#e0e0e0'; // Grey out
            facultySelect.selectedIndex = 0; // Reset selection
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const registerMessage = document.getElementById("registerMessage");
    const announcementMessage = document.getElementById("announcementMessage");

    // Toggle forms visibility
    registerBtn.addEventListener("click", () => {
        registerForm.style.display = "block";
        announcementForm.style.display = "none";
    });

    announceBtn.addEventListener("click", () => {
        registerForm.style.display = "none";
        announcementForm.style.display = "block";
    });
    // Register form submission
    registerForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent traditional form submission
        const formData = new FormData(registerForm);
        
        fetch('aprocess_register.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                registerMessage.textContent = data.message;
                registerMessage.style.color = 'green';
                setTimeout(() => {
                    registerMessage.textContent = ''; // Hide the message after 4 seconds
                    registerForm.reset(); // Reset form fields
                }, 4000);
            } else {
                registerMessage.textContent = data.message;
                registerMessage.style.color = 'red';
            }
        })
        .catch(error => {
            registerMessage.textContent = 'An error occurred';
            registerMessage.style.color = 'red';
        });
    });

    // Announcement form submission
    announcementForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent traditional form submission
        const formData = new FormData(announcementForm);
        
        fetch('aprocess_announcement.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                announcementMessage.textContent = data.message;
                announcementMessage.style.color = 'green';
                setTimeout(() => {
                    announcementMessage.textContent = ''; // Hide the message after 4 seconds
                    announcementForm.reset(); // Reset form fields
                }, 2000);
            } else {
                announcementMessage.textContent = data.message;
                announcementMessage.style.color = 'red';
            }
        })
        .catch(error => {
            announcementMessage.textContent = 'An error occurred';
            announcementMessage.style.color = 'red';
        });
    });
});

// Function to delete an announcement (you will need to implement the PHP logic)
function deleteAnnouncement() {
    fetch('delete_announcement.php', {
        method: 'POST',
        body: JSON.stringify({ delete: true }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Announcement deleted successfully');
        } else {
            alert('Error deleting announcement');
        }
    })
    .catch(error => {
        alert('An error occurred while deleting the announcement');
    });
}
