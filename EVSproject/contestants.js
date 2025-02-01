function toggleDetails(button) {
    const description = button.nextElementSibling;
    
    if (description.style.display === 'none' || description.style.display === '') {
        description.style.display = 'block';
        button.textContent = 'Hide Details';
    } else {
        description.style.display = 'none';
        button.textContent = 'Details';
    }
}
