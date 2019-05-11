function clipBoard() {
    var copyText = document.getElementById("saveCartLink");
    copyText.select();
    document.execCommand("copy");
}

