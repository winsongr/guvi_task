localEmail = localStorage.getItem("email");
quote = document.getElementById("quote");
author = document.getElementById("author");
count = document.getElementById("count");
window.onload = function () {
  if (localEmail != null) {
    window.location.assign("./profile.html");
  }
  $.ajax({
    type: "GET",
    url: "https://programming-quotes-api.herokuapp.com/Quotes/random",
    encode: true,
  }).done(function (e) {
    console.log(e.en);
    console.log(e.author);
    quote.innerHTML = e.en;
    author.innerHTML = e.author;
  });
  $.ajax({
    type: "GET",
    url: "./php/redis.php",
    encode: true,
  }).done(function (e) {
    count.innerHTML = e;
    console.log(e);
  });
};
