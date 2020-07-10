document.addEventListener("DOMContentLoaded", function (event) {
    setTimeout(addScript, 10000)
});

function addScript() {
    [
        '',
        '',
        '',
    ].forEach(function (src) {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = src;
        script.async = true;
        script.onload = function () {
            console.log("Added Script");
        };
        document.getElementsByTagName('head')[0].appendChild(script);
    });
}