const chatBox = document.getElementById("chat-box");
const faqOptions = document.getElementById("faq-options");
const toggleBtn = document.getElementById("chat-toggle");
const chatBoxContainer = document.querySelector(".chat-box");

const faqs = {
  "How do I adopt a pet?": "You can browse available pets on the homepage and click 'Adopt Me' to start the process.",
  "Where are you located?": "We’re located in Troy, Alabama. Check the Contact page for more info.",
  "How can I volunteer?": "Visit the Volunteer page to sign up and help out!",
  "What are your adoption hours?": "We’re open Monday through Friday, 9am to 5pm.",
  "Can I donate to the shelter?": "Yes! There will be a Donate page or you can contact us directly."
};


for (let question in faqs) {
  const btn = document.createElement("button");
  btn.textContent = question;
  btn.addEventListener("click", () => handleQuestionClick(question));
  faqOptions.appendChild(btn);
}

function handleQuestionClick(question) {
  const userMsg = document.createElement("div");
  userMsg.className = "user-message";
  userMsg.textContent = question;
  chatBox.appendChild(userMsg);

  const botMsg = document.createElement("div");
  botMsg.className = "bot-response";
  botMsg.textContent = faqs[question];
  chatBox.appendChild(botMsg);

  chatBox.scrollTop = chatBox.scrollHeight;
}


toggleBtn.addEventListener("click", () => {
  if (chatBoxContainer.style.display === "none") {
    chatBoxContainer.style.display = "block";
    toggleBtn.textContent = "−";
  } else {
    chatBoxContainer.style.display = "none";
    toggleBtn.textContent = "+";
  }
});
