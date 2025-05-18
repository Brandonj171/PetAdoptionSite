const chatContainer = document.getElementById("chat-container");
const chatBox = document.getElementById("chat-box");
const userInput = document.getElementById("user-input");
const pawsIcon = document.getElementById("paws-icon");

// Show chat on dog click
pawsIcon.addEventListener("click", () => {
  chatContainer.style.display = (chatContainer.style.display === "none" || chatContainer.style.display === "") ? "block" : "none";
});

const responses = {
  adopt: "🐾 Woof! You can click 'view available pets' on the homepage and then click 'Meet' to start!",
  volunteer: "🐾 Woof! We love helpers! Visit the Volunteer page to learn how to get involved.",
  donate: "🐾 Woof! Thank you! You can donate through the Donate page or contact us.",
  location: "🐾 Woof! We're based in Troy, Alabama! Visit our Contact page for more information.",
  hours: "🐾 Woof! We’re open Monday to Friday, 8am to 5pm!",
  about: "🐾 Woof! You can visit our About Us page to learn about PetAdopt and who we are",
  contact: "🐾 Woof! You can visit the Contact Us page to get in touch with us here at PetAdopt",
  stories: "🐾 Woof! You can visit the Happy Tails page to read successful adoption stories", 
  tails: "🐾 Woof! You can visit the Happy Tails page to read successful adoption stories"
};

userInput.addEventListener("keypress", function (e) {
  if (e.key === "Enter") {
    const input = userInput.value.trim();
    if (!input) return;
    appendMessage("user", input);
    userInput.value = "";

    const lowerInput = input.toLowerCase();
    let response = "🐾 Hmm... I don't know that one yet! Try asking about adoption, volunteering, or hours.";

    for (let keyword in responses) {
      if (lowerInput.includes(keyword)) {
        response = responses[keyword];
        break;
      }
    }

    setTimeout(() => {
      appendMessage("bot", response);
    }, 600);
  }
});

function appendMessage(sender, message) {
  const msg = document.createElement("div");
  msg.className = sender + "-message";
  msg.innerText = message;
  chatBox.appendChild(msg);
  chatBox.scrollTop = chatBox.scrollHeight;
}
