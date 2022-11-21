localEmail = localStorage.getItem("email");
quote = document.getElementById("quote");
author = document.getElementById("author");
window.onload = function () {
  if (localEmail != null) {
    window.location.assign("./profile.html");
  }
  $.ajax({
    type: "GET",
    url: "https://programming-quotes-api.herokuapp.com/Quotes/random",
    encode: true,
  }).done(function (e) {
    quote.innerHTML = e.en;
    author.innerHTML = e.author;
  });
};
