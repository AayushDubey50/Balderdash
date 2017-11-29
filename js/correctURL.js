function correctURL() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    if (/android/i.test(userAgent))
        window.open("https://play.google.com/store/apps/details?id=com.expimetrics&hl=en", "_blank");
    else if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream)
        window.open("https://itunes.apple.com/us/app/expimetrics/id1070733440", "_blank");
    else window.open("http://app.expimetrics.com/", "_blank");
}
