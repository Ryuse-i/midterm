function toasterDisplay(message, type) {
    let toaster = document.getElementById('display-validation');
    let toasterMessage = document.getElementById('display-validation_message');

    toasterMessage.innerHTML = message;

    toaster.classList.remove("display-validation_message");

    //waits 100ms before showing the toaster
    setTimeout(() => {
        toaster.classList.add("display-validation_message");
        toaster.classList.add("display-validation_message_push");
    }, 100); 
    

    // set background color based on type
    if (type === "error") {
        toaster.style.backgroundColor = "red"; // error message
    } else if (type === "warning") {
        toaster.style.backgroundColor = "orange"; // warning message
    }else {
        toaster.style.backgroundColor = "green"; // success message
    }

    // hide after 3 seconds
    setTimeout(() => {
        toaster.classList.remove("display-validation_message_push");
    }, 3000);
}
