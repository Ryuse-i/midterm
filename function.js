function toasterDisplay(message, type) {
    let toaster = document.getElementById('display-validation');
    let toasterMessage = document.getElementById('display-validation_message');

    // show immediately
    toaster.classList.add("display-validation_message_push");
    toasterMessage.innerHTML = message;

    if (type === "error") {
        toaster.style.backgroundColor = "red"; // error message
    } else {
        toaster.style.backgroundColor = "green"; // success message
    }

    // hide after 3 seconds
    setTimeout(() => {
        toaster.classList.remove("display-validation_message_push");
    }, 3000);
}
