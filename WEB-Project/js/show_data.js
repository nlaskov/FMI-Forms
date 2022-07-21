function showData(title) {

    var display = document.getElementById(title).style.display;
    if (display == "") display = "none";
    if (display == "none") {
        document.getElementById(title).style.display = "block";
    } else {
        document.getElementById(title).style.display = "none";
    }

}
