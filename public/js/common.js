// Display Toast
function showToast(message, type = "primary") {
    // Create a container for the toast if it doesn't exist
    let toastContainer = document.querySelector(".toast-container");
    if (!toastContainer) {
        toastContainer = document.createElement("div");
        toastContainer.className =
            "toast-container position-fixed top-0 end-0 p-3";
        document.body.appendChild(toastContainer);
    }

    // Create the toast element
    const toast = document.createElement("div");
    toast.className = `toast align-items-center text-bg-${type} border-0`; // Use dynamic type
    toast.setAttribute("role", "alert");
    toast.setAttribute("aria-live", "assertive");
    toast.setAttribute("aria-atomic", "true");

    // Add content to the toast
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    // Append the toast to the container
    toastContainer.appendChild(toast);

    // Initialize and show the toast using Bootstrap's JavaScript API
    var bootstrapToast = new bootstrap.Toast(toast);
    bootstrapToast.show();

    // Automatically remove the toast after 5 seconds (5000 milliseconds)
    setTimeout(() => {
        var event = new Event("hidden.bs.toast");
        toast.dispatchEvent(event); // Triggers toast close
    }, 5000);

    // Automatically remove the toast after it hides
    toast.addEventListener("hidden.bs.toast", () => {
        toast.remove();
    });
}
