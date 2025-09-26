function toasterDisplay(message, type) {
    let toaster = document.getElementById('display-validation');
    let toasterMessage = document.getElementById('display-validation_message');

    toasterMessage.innerHTML = message;

    //waits 100ms before showing the toaster
    setTimeout(() => {
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

function openWelcomeMessage($message) {
    let welcomeMessage = document.getElementById('display-welcome');
    let welcomeMessageText = document.getElementById('display-welcome_message');
    let pageContent = document.getElementById('overlay');

    pageContent.classList.add("active");

    welcomeMessageText.innerHTML = $message;

    setTimeout(() => {
        welcomeMessage.classList.add("welcome-message_push");
    }, 100);
}

function closeWelcomeMessage() {
    let welcomeMessage = document.getElementById('display-welcome');
    let pageContent = document.getElementById('overlay');

    pageContent.classList.remove("active");
    welcomeMessage.classList.remove("welcome-message_push");

}
    
