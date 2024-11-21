function showDetails(card) {
    const projectTitle = card.querySelector('h2').innerText;
    const projectDescription = card.querySelector('p').innerText;

    document.getElementById('modal-title').innerText = projectTitle;
    document.getElementById('modal-description').innerText = projectDescription;
    
    document.getElementById('project-modal').style.display = 'block';
}

function closeModal() {
    document.getElementById('project-modal').style.display = 'none';
}

// Close the modal when the user clicks outside of it
window.onclick = function(event) {
    const modal = document.getElementById('project-modal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
