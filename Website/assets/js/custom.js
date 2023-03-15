var fetchedImages = [];
var currentIndex = 0;

function getImages() {
  fetch("/assets/img/crop")
    .then(response => response.text())
    .then(text => {
      var parser = new DOMParser();
      var htmlDocument = parser.parseFromString(text, "text/html");
      var links = htmlDocument.getElementsByTagName("a");
      for (var i = 0; i < links.length; i++) {
        var link = links[i].getAttribute("href");
        if (link.endsWith(".png") || link.endsWith(".jpg") || link.endsWith(".jpeg")) {
          var decodedLink = decodeURIComponent(link);
          fetchedImages.push(decodedLink);
        }
      }
    })
    .catch(error => {
      console.error("Failed to get images: " + error);
    });
}

function changeImage() {
  if (fetchedImages.length === 0) {
    console.warn("No images found in the fetchedImages.");
    return;
  }
  currentIndex++;
  if (currentIndex >= fetchedImages.length) {
    currentIndex = 0;
  }
  var imageElement = document.querySelector('.carousel-container h2 img');
  var imagePath = fetchedImages[currentIndex];
  imageElement.src = imagePath;
}

getImages();