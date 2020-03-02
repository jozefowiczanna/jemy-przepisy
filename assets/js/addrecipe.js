window.addEventListener("DOMContentLoaded", function() {

// property name must match element id (loop validation)
addRecipeRegex = {
  ['recipe_name']: /^[^<>]{3,100}$/,
  ['ingredients']: /[^\s\\]/,
  ['preparation']: /[^\s\\]/,
  ['prep_time']: /^(\d{1,4})$/
}

const form = document.querySelector(".js-form-add");
const url = form.getAttribute("action");
const method = form.getAttribute("method");
const container = form.parentElement;
const formFields = document.querySelectorAll(".js-form-add .js-check");
const btnSubmit = form.querySelector("[type=submit]");

// prevent Validation API from showing popup error message
form.noValidate = true;

function appendMessage(status) {
  form.remove();
  const frag = document.createDocumentFragment();
  const el = document.createElement("p");
  if (status === "success") {
    el.textContent = "Przepis został dodany!";
  } else if (status === "fail") {
    el.textContent = "Błąd po stronie serwera. Spróbuj później.";
  }
  el.classList.add("form__msg");
  frag.appendChild(el);
  if (status === "success") {
    const link = document.createElement("a");
    link.textContent = "Przejdź do profilu";
    link.classList.add("link");
    link.classList.add("form__link");
    link.href = "profile.php";
    frag.appendChild(link);
  }
  container.appendChild(frag);
}

function sendForm() {
  const formFields = document.querySelectorAll(".js-form-add .js-check, #category_id, #difficulty");
  const formData = new FormData();
  const btnSubmit = form.querySelector("[type=submit]");
  
  for (const el of formFields) {
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
    if (res.status) {
      appendMessage(res.status);
    }
  }).catch((e) => {
    console.log(e);
    btnSubmit.disabled = false;
    btnSubmit.classList.remove("element-is-busy");
  });
}

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

function checkElValidity(el) {
  const id = el.id;
  const regex = addRecipeRegex[id];
  const isValid = regex.test(el.value);
  let error = false;

  if (isValid) {
    removeErrorClasses(el);
  } else {
    addErrorClasses(el);
    error = true;
  }
  
  return error;
}


[].forEach.call(formFields, function(input) {
  input.addEventListener("change", (e) => {
    checkElValidity(e.target);
  })
});

form.addEventListener("submit", (e) => {
  e.preventDefault();
  formErrors = false;

  [].forEach.call(formFields, function(input) {
    inputError = checkElValidity(input);
    if (inputError) {
      formErrors = true;
    }
  });

  if (!formErrors) {
    sendForm();
  }
})

});
