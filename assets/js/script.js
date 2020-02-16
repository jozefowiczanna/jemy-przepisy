// ***** js-form-register in register.php *****

registerRegex = {
  fusername: /^[^<>]{3,50}$/,
  femail: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
  fpassword: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,30}$/,
  fpassword2: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,30}$/
}

function sendForm() {
  const form = document.querySelector(".js-form-register");
  const url = form.getAttribute("action");
  const method = form.getAttribute("method");
  const formInputs = document.querySelectorAll(".js-form-register .form__input");
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
      const inputs = res.errors;
      for (input of inputs) {
        const el = document.querySelector("#" + input)
        addErrorClasses(el);
      }
    }
  }).catch((e) => {
    console.log(e);
    btnSubmit.disabled = false;
    btnSubmit.classList.remove("element-is-busy");
  });
}

if (document.querySelector(".js-form-register")) {
  const form = document.querySelector(".js-form-register");
  const formInputs = document.querySelectorAll(".js-form-register .form__input");
  const btnSubmit = form.querySelector("[type=submit]");

  // prevent Validation API from showing popup error message
  form.noValidate = true;
  
  
  function addErrorClasses(el) {
    const errorField = el.nextElementSibling;
    el.classList.add("form__input--error");
    errorField.classList.add("visible");
    el.dataset.error = "error";
  }
  function removeErrorClasses(el) {
    const errorField = el.nextElementSibling;
    el.classList.remove("form__input--error");
    errorField.classList.remove("visible");
    el.dataset.error = "";
  }
  
  function customCheckValidity(el) {
    const id = el.id;
    const regex = registerRegex[id];
    const isValid = regex.test(el.value);

    let error = false;

    if (id === "fpassword") {
      const pass2 = document.querySelector("#fpassword2");
      // show error only if passwords don't match AND if user typed something in second password field
      if (el.value !== pass2.value && pass2.value != "") {
        addErrorClasses(pass2);
        error = true;
      } else {
        removeErrorClasses(pass2);
      }
      if (isValid && el.value != "") {
        removeErrorClasses(el);
      } else {
        addErrorClasses(el);
        error = true;
      }
    } else if (id === "fpassword2") {
      const pass1 = document.querySelector("#fpassword");
      if (el.value === pass1.value) {
        removeErrorClasses(el);
      } else {
        addErrorClasses(el);
        error = true;
      }
    } else {
      if (isValid && el.value != "") {
        removeErrorClasses(el);
      } else {
        addErrorClasses(el);
        error = true;
      }
    }

    return error;
    
  }
  
  [].forEach.call(formInputs, function(input) {
    input.addEventListener("change", (e) => {
      customCheckValidity(e.target);
    })
  });
  
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    formErrors = false;

    [].forEach.call(formInputs, function(input) {
      inputError = customCheckValidity(input, true);
      if (inputError) {
        formErrors = true;
      }
    });

    const test = document.querySelector("#fusername");
    
    // if (formErrors !== true) {
      sendForm();
    // }
  })
}