document.addEventListener('DOMContentLoaded', function () {
    const positions = ['president', 'deputy', 'faculty-rep', 'residence-rep', 'non-resident-rep', 'environment-rep', 'sports-rep'];

    // Load candidates dynamically based on the user's faculty
    positions.forEach(position => {
        loadCandidates(position, userFaculty);
    });

    function loadCandidates(position, faculty) {
        const container = document.getElementById(`${position}-candidates`);

        // Fetch candidates via an AJAX call
        fetch(`fetch_candidates.php?position=${position}&faculty=${faculty}`)
            .then(response => response.json())
            .then(candidates => {
                candidates.forEach(candidate => {
                    const candidateDiv = document.createElement('div');
                    candidateDiv.classList.add('candidate');

                    const img = document.createElement('img');
                    img.src = candidate.photo_path ? candidate.photo_path : ''; // Set image if available
                    img.alt = ''; // No alternative text if no image

                    const label = document.createElement('label');
                    label.textContent = candidate.name;

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = position;
                    checkbox.value = candidate.id;

                    candidateDiv.appendChild(img);
                    candidateDiv.appendChild(label);
                    candidateDiv.appendChild(checkbox);

                    container.appendChild(candidateDiv);
                });

                // Ensure only one checkbox is selected per position
                container.addEventListener('change', function (event) {
                    const checkboxes = container.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach(checkbox => {
                        if (checkbox !== event.target) {
                            checkbox.checked = false;
                        }
                    });
                });
            })
            .catch(error => console.error('Error loading candidates:', error));
    }

    // Form validation and submission
    const form = document.getElementById('voting-form');
    const errorMessage = document.getElementById('error-message');

    form.addEventListener('submit', function (event) {
        event.preventDefault();  // Prevent the default form submission

        let allChecked = true;
        const formData = new FormData(form);

        positions.forEach(position => {
            const checkboxes = document.querySelectorAll(`input[name="${position}"]`);
            const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            if (!isChecked) {
                allChecked = false;
            }
        });

        if (!allChecked) {
            errorMessage.textContent = 'Please select a candidate for each position before submitting.';
            errorMessage.style.display = 'block';  // Show the error message
            return;
        }

        // Submit the form data via an AJAX POST request
        fetch('submit_vote.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    showSuccessMessage('Vote submitted successfully!');
                } else {
                    showErrorMessage(result.message || 'An error occurred while submitting your vote.');
                }
            })
            .catch(error => {
                showErrorMessage('An error occurred while submitting your vote.');
                console.error('Error submitting vote:', error);
            });
    });

    function showSuccessMessage(message) {
        errorMessage.textContent = message;
        errorMessage.style.color = 'green';
        errorMessage.style.display = 'block';
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false; // Uncheck each checkbox
        });
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 5000);  // Hide after 4 seconds
    }

    function showErrorMessage(message) {
        errorMessage.textContent = message;
        errorMessage.style.color = 'red';
        errorMessage.style.display = 'block';
    }

    // Toggle navigation menu
    const navToggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.nav-menu');

    navToggle.addEventListener('click', () => {
        navMenu.classList.toggle('show');
    });
});
