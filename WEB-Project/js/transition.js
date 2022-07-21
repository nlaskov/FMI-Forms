 function openForm(id) {
     location.href = `form?form_id=${id}`;
 }

 function openLoginForm(id) {
     location.href = `form_with_pass?form_id=${id}`;
 }

 function editForm(id) {
     location.href = `new_form_text?form_id=${id}`;
 }

 function newForm() {
     location.assign(`new_form_text`);
 }

 function AddForm() {
     location.assign(`add_form`);
 }

 function ShowData(id) {
     location.href = `show_data?form_id=${id}`;
 }


 function Login() {
     location.href = `login`;
 }

 function Registration() {
     location.href = `register`;
 }

function newFormUI(){
    location.href = `new_form_info`;
}

 function logout() {
     document.cookie = 'auth' + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
     location.assign("login");
 }
