document.addEventListener("DOMContentLoaded", function() {
    // Update status without page refresh
    document.querySelectorAll(".approve, .decline").forEach(button => {
        button.addEventListener("click", function(event) {
            event.preventDefault();
            const action = this.classList.contains('approve') ? 'approve' : 'decline';
            const requestId = this.getAttribute('data-id');
            
            fetch(`manage_requests.php?action=${action}&id=${requestId}`, {
                method: 'GET',
            })
            .then(response => response.text())
            .then(() => {
                alert(`Request has been ${action}d.`);
                // Reload the table after update
                location.reload();
            })
            .catch(error => console.log(error));
        });
    });
});
