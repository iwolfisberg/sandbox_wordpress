document.addEventListener("DOMContentLoaded", function () {
  const submitFilterForm = () => {
    const filterForm = document.querySelector("#filter-form");
    const filterInputs = filterForm.querySelectorAll("select");
    filterInputs.forEach((input) => {
      input.addEventListener("change", function () {
        filterForm.submit();
      });
    });
  };

  const resizeIngredients = () => {
    const btns = document.querySelectorAll(".btn-quantity");

    btns.forEach((btn) => {
      btn.addEventListener("click", function (e) {
        e.preventDefault();

        // Vérifie si c'est un bouton d'augmentation ou de diminution
        const isIncrease = btn.classList.contains("btn-increase");

        // Récupère l'élément affichant le nombre de personnes
        const numberPersonEl = document.querySelector("#number-person");

        // Lit et valide le nombre actuel de personnes
        const numberPersonInitial = parseInt(numberPersonEl.dataset.person, 10);
        if (isNaN(numberPersonInitial) || numberPersonInitial <= 0) {
          console.error("Nombre initial de personnes invalide.");
          return;
        }

        // Calcule le nouveau nombre de personnes, en empêchant de descendre en dessous de 1
        const newNumberPerson = isIncrease
          ? numberPersonInitial + 1
          : Math.max(1, numberPersonInitial - 1);

        // Met à jour le nombre de personnes dans le DOM
        numberPersonEl.textContent = newNumberPerson;
        numberPersonEl.dataset.person = newNumberPerson;

        // Met à jour toutes les quantités des ingrédients
        const quantities = document.querySelectorAll(".quantity");
        quantities.forEach((el) => {
          // Lit et valide la quantité et l'unité actuelle
          const quantity = parseFloat(el.dataset.quantity);
          const unit = el.dataset.unit || "";

          if (isNaN(quantity)) {
            console.error("Quantité invalide pour l'élément:", el);
            return;
          }

          // Calcule et met à jour la nouvelle quantité
          const newQuantity = quantity * newNumberPerson;

          el.textContent = `${newQuantity} ${unit}`;
        });
      });
    });
  };

  resizeIngredients();
  submitFilterForm();
});
