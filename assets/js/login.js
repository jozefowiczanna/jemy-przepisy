window.addEventListener("DOMContentLoaded", function() {

  const form = document.querySelector(".js-form-register");
  const url = form.getAttribute("action");
  const method = form.getAttribute("method");
  const formInputs = form.querySelectorAll("input");
  const validErrorEl = form.querySelector(".js-valid-error");
  const dbErrorEl = form.querySelector(".js-db-error");

  function addErrorClasses(el) {
    const errorField = el.nextElementSibling;
    el.classList.add("form__input--error");
    errorField.classList.add("visible");
  }

  function removeErrorClasses(el) {
    const errorField = el.nextElementSibling;
    el.classList.remove("form__input--error");
    errorField.classList.remove("visible");
  }

  function sendForm() {

    const formData = new FormData();
    
    for (const el of formInputs) {
      formData.append(el.name, el.value)
    }
    
    fetch(url, {
      method: method.toUpperCase(),
      body: formData
    })
    .then(res => res.json())
    .then(res => {
      console.log(res);
      if (res.errors) { //błędne pola
        validErrorEl.classList.add("visible");
      } else {
        validErrorEl.classList.remove("visible");
      }
      if (res.dberror) {
        dbErrorEl.classList.add("visible");
      }
      if (res.userid) {
        // reload to get session variables
        location.reload();
      }
    }).catch((e) => {
      console.log(e);
      // btnSubmit.disabled = false;
      // btnSubmit.classList.remove("element-is-busy");
    });
  }

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    formErrors = false;

    [].forEach.call(formInputs, function(input) {
      if (input.value == "") {
        formErrors = true;
        addErrorClasses(input);
      } else {
        removeErrorClasses(input);
      }
    });
    
    
    if (formErrors !== true) {
      sendForm();
    }
  })

});