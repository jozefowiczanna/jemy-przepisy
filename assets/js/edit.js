const queryString = window.location.search;
const query = queryString.search("id") + 3;
// id has to be last url param
const id = queryString.substr(query);
console.log(id);

// input/textarea field id values
const fieldsToCompare = ["recipe_name", "description", "ingredients", "preparation", "prep_time"];

let recipe;

const url = "private/handlers/get_recipe_handler.php";

function getRecipe(url, data) {
  fetch(url, {
    method: 'POST',
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(res => {
    if (res.recipe) {
      recipe = res.recipe;
      console.log(recipe);

      // if input/textarea field id matches column name, apply column value to field value
      for (const field of fieldsToCompare) {
        if (recipe.hasOwnProperty(field)) {
          const sel = "#" + field;
          const el = document.querySelector(sel);
          let val = recipe[field];
          // remove <br />
          val = val.replace(/<br\s*[\/]?>/gi, "");
          el.value = val;
        }
      }
    } else {
      console.log("NO RECIPE FOUND");
    }
    
  }).catch((e) => {
    console.log(e);
  });
}

getRecipe(url, { id: 4 });

// TODO dodać resztę js z addrecipe.js
// pamiętać o zmodyfikowaniu handlera - UPDATE zamiast INSERT
// do handlera php trzeba przekazać id przepisu
// może wykorzystać input type="hidden", wtedy trzeba dodać query selectora, gdzie pobieram ich nazwy