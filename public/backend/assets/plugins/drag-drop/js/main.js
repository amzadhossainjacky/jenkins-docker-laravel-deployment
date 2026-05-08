function handleFiles(files) {
    const fileList = document.getElementById("fileList");
    for (const file of files) {
        const listItem = document.createElement("div");
        listItem.textContent = file.name;
        const removeButton = document.createElement("button");
        removeButton.textContent = "Remove"; // Assuming it submits a form
        removeButton.classList.add("add-btn"); // Add the class for styling
        removeButton.addEventListener("click", () => {
            listItem.remove();
            // Remove the file from the input element
            const input = document.getElementById("fileInput");
            const dt = new DataTransfer();
            for (const f of input.files) {
                if (f !== file) {
                    dt.items.add(f);
                }
            }
            input.files = dt.files.length > -1 ? dt.files : null;
        });
        listItem.appendChild(removeButton);
        fileList.appendChild(listItem);
    }
}

// Function to handle drag and drop events
function handleDrop(e) {
    e.preventDefault();
    const files = e.dataTransfer.files;
    handleFiles(files);
}

// Function to handle file selection through input
function handleInputChange() {
    const files = document.getElementById("fileInput").files;
    handleFiles(files);
}

// Initialize event listeners for drag and drop
const dropArea = document.getElementById("dropArea");
dropArea.addEventListener("dragover", (e) => {
    e.preventDefault();
});
dropArea.addEventListener("drop", handleDrop);

// Initialize event listener for file input change
document
    .getElementById("fileInput")
    .addEventListener("change", handleInputChange);
