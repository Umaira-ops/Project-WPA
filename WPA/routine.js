const promptDiv = document.getElementById('prompt');
const responseTextarea = document.getElementById('response');
const feedbackDiv = document.getElementById('feedback');

document.getElementById('happyBtn').addEventListener('click', () => {
    displayPrompt("What makes you feel happy?");
});

document.getElementById('sadBtn').addEventListener('click', () => {
    displayPrompt("What makes you feel sad? Is there something you want to talk about?");
});

document.getElementById('angryBtn').addEventListener('click', () => {
    displayPrompt("What makes you feel angry? How do you usually handle it?");
});

document.getElementById('excitedBtn').addEventListener('click', () => {
    displayPrompt("What are you excited about right now?");
});

document.getElementById('nervousBtn').addEventListener('click', () => {
    displayPrompt("What makes you feel nervous? Can you think of ways to feel better?");
});

document.getElementById('submitResponse').addEventListener('click', () => {
    const response = responseTextarea.value;
    if (response) {
        feedbackDiv.innerText = "Thank you for sharing your feelings!";
        responseTextarea.value = ''; // Clear the textarea
    } else {
        feedbackDiv.innerText = "Please write something before submitting.";
    }
});

document.getElementById('resetBtn').addEventListener('click', resetGame);

function displayPrompt(message) {
    promptDiv.innerText = message;
    feedbackDiv.innerText = ''; // Clear previous feedback
}

function resetGame() {
    promptDiv.innerText = '';
    responseTextarea.value = '';
    feedbackDiv.innerText = '';
}
