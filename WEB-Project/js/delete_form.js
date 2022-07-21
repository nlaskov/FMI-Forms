function deleteForm(email, owner) {

    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('form_id');

    var formData = new FormData();
    formData.append('id', id);
    formData.append('email', email);
    formData.append('owner', owner);

    let path = window.location.pathname;
    let directory = path.substring(path.indexOf('/'), path.lastIndexOf('/'));
    let urlBase = directory == '/' ? '' : directory;

    fetch("php_scripts/form_delete.php", {
            method: 'POST',
            body: formData,
        }).then(function (response) {
            window.location.replace("index");
        });
   
}
