document.getElementById('colorForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var bgColor = document.getElementById('bgColor').value;
    document.documentElement.style.setProperty('--kolor-tla-ramki', bgColor);
});