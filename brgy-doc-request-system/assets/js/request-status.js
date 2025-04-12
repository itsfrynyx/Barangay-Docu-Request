document.addEventListener("DOMContentLoaded", function() {
    // Function to refresh the request status table
    function loadRequests() {
        const table = document.querySelector("table");
        fetch('../requests/load_requests.php')
            .then(response => response.json())
            .then(data => {
                table.innerHTML = ""; // Clear existing table rows
                // Add table headers
                table.innerHTML = `
                    <tr>
                        <th>User</th>
                        <th>Document</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Requested On</th>
                    </tr>
                `;
                
                // Add each request to the table
                data.forEach(row => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${row.full_name}</td>
                        <td>${row.document_type}</td>
                        <td>${row.purpose}</td>
                        <td>${row.status}</td>
                        <td>${row.request_date}</td>
                    `;
                    table.appendChild(tr);
                });
            })
            .catch(error => console.log(error));
    }

    // Call loadRequests on page load
    loadRequests();
});
