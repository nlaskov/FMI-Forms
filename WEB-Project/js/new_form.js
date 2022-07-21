 window.addEventListener("load", async function () {
  let reader = new FileReader();

  let params = (new URL(document.location)).searchParams;
  let form_id = params.get("form_id");
    
  if (form_id !== null) {
     
    let path = window.location.pathname;
      
    let directory = path.substring(path.indexOf('/'), path.lastIndexOf('/'));
    let urlBase = directory == '/' ? '' : directory;
    var formData = new FormData();
     console.log(form_id)
    formData.append('id', form_id);
       
    const response = await fetch(
      "php_scripts/load.php",
      {
        method: 'POST',
        body: formData
      }
    );
      
     const data = JSON.parse(await response.text());

    document.getElementById('gform').value = JSON.stringify(data.json, null, 2);
    document.getElementById('form-content').value = data.txt; 
  }
});