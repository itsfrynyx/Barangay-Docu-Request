// Real-time form validation for document request form
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("request-form");
    const submitButton = form.querySelector("button[type='submit']");
    
    // Function to validate form
    function validateForm() {
        const documentType = form.querySelector("select[name='document_type']");
        const purpose = form.querySelector("textarea[name='purpose']");
        
        // Check if both fields are filled
        if (documentType.value === "" || purpose.value.trim() === "") {
            submitButton.disabled = true;
            submitButton.style.backgroundColor = "#ccc";
        } else {
            submitButton.disabled = false;
            submitButton.style.backgroundColor = "#007BFF";
        }
    }

    // Listen for input change to validate
    form.querySelector("select[name='document_type']").addEventListener("change", validateForm);
    form.querySelector("textarea[name='purpose']").addEventListener("input", validateForm);

    // Initial validation when the page loads
    validateForm();
});
