
// DOM element references
const descriptionField = document.getElementById('description');
const charCount = document.getElementById('charCount');
const photoInput = document.getElementById('photo');
const imagePreview = document.getElementById('imagePreview');
const resetModal = document.getElementById('resetModal');
const inactivityModal = document.getElementById('inactivityModal');
const form = document.getElementById('candidateForm');

// Character count functionality
descriptionField.addEventListener('input', function() {
    const remainingChars = 230 - this.value.length;
    charCount.textContent = `${this.value.length} / 230`;
    
    if (remainingChars < 0) {
        charCount.style.color = 'red';
    } else {
        charCount.style.color = 'black';
    }
});

// Image preview functionality
photoInput.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            
            // Ensure the image is loaded before checking its dimensions
            imagePreview.onload = function() {
                if (this.naturalWidth > this.naturalHeight) {
                    this.style.width = '200px';
                    this.style.height = 'auto';
                } else {
                    this.style.width = 'auto';
                    this.style.height = '200px';
                }
            }
        }
        reader.readAsDataURL(file);
    }
});

// Reset confirmation functionality
function showResetConfirmation() {
    resetModal.style.display = 'block';
}

function hideResetConfirmation() {
    resetModal.style.display = 'none';
}

function resetForm() {
    fetch('candidate-reset.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=reset'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            sessionStorage.setItem('successMsg', 'Profile reset successfully.');
        } else {
            sessionStorage.setItem('errorMsg', 'Failed to reset profile.');
        }
        window.location.href = 'candidatehomepage.php';
    })
    .catch(error => {
        console.error('Error:', error);
        sessionStorage.setItem('errorMsg', 'An error occurred. Please try again.');
        window.location.href = 'candidatehomepage.php';
    });

    hideResetConfirmation();
}

// Close the modal if clicked outside
window.onclick = function(event) {
    if (event.target == resetModal) {
        hideResetConfirmation();
    }
}

// Inactivity logout functionality
let inactivityTimer;
const inactivityTimeout = 600000; // 600 seconds = 10 minutes

function resetInactivityTimer() {
    clearTimeout(inactivityTimer);
    inactivityTimer = setTimeout(showInactivityModal, inactivityTimeout);
}

function showInactivityModal() {
    inactivityModal.style.display = 'block';
}

function logout() {
    window.location.href = 'logout.php';
}

// Reset timer on user activity
['mousedown', 'keydown', 'touchstart', 'scroll'].forEach(evt => 
    document.addEventListener(evt, resetInactivityTimer, true)
);

// Initial timer start
resetInactivityTimer();

// Stop propagation on the inactivity modal
inactivityModal.addEventListener('click', function(event) {
    event.stopPropagation();
});

// Ensure the logout happens when the button is clicked
document.querySelector('.inactivity-modal-content button').addEventListener('click', function(event) {
    event.stopPropagation();
    logout();
});

// Message handling functions
function createMessageElement(text, type) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    messageDiv.textContent = text;
    return messageDiv;
}

function addMessage(messageElement) {
    // Insert the message after the form
    form.parentNode.insertBefore(messageElement, form.nextSibling);

    // Set a timeout to start fading out the message after 4 seconds
    setTimeout(() => {
        messageElement.style.animation = 'fadeOut 1s forwards';
    }, 4000);

    // Remove the message from the DOM after the animation completes
    messageElement.addEventListener('animationend', () => {
        messageElement.remove();
    });
}

// Success message fade out and session storage message handling
document.addEventListener('DOMContentLoaded', function() {
    // Handle existing success message
    const existingSuccessMsg = document.querySelector('.message.success');
    if (existingSuccessMsg) {
        // Move the existing success message after the form
        form.parentNode.insertBefore(existingSuccessMsg, form.nextSibling);
        
        setTimeout(() => {
            existingSuccessMsg.style.animation = 'fadeOut 1s forwards';
        }, 4000);

        existingSuccessMsg.addEventListener('animationend', () => {
            existingSuccessMsg.remove();
        });
    }

    // Check for messages in sessionStorage
    const successMsgFromSession = sessionStorage.getItem('successMsg');
    const errorMsgFromSession = sessionStorage.getItem('errorMsg');

    if (successMsgFromSession) {
        const messageElement = createMessageElement(successMsgFromSession, 'success');
        addMessage(messageElement);
        sessionStorage.removeItem('successMsg');
    }

    if (errorMsgFromSession) {
        const messageElement = createMessageElement(errorMsgFromSession, 'error');
        addMessage(messageElement);
        sessionStorage.removeItem('errorMsg');
    }
});