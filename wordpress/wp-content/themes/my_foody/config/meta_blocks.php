<?php
function add_ingredient_metabox() {
  // Enregistrer un metabox qui apparaîtra sur les articles
  add_meta_box(
      'ingredient_metabox',            // ID unique
      'Ingrédients',                   // Titre du metabox
      'render_ingredient_metabox',     // Fonction pour afficher le metabox
      'post',                          // Type de post auquel cela s'applique
      'side',                          // Positionnement (ici à gauche dans la barre latérale)
      'high'                           // Priorité d'affichage
  );
}
add_action('add_meta_boxes', 'add_ingredient_metabox');

function render_ingredient_metabox($post) {
  // Récupérer la valeur actuelle des ingrédients
  $ingredients = get_post_meta($post->ID, '_ingredients', true);
  
  // Récupérer la valeur du nombre de personnes
  $people_count = get_post_meta($post->ID, '_people_count', true);
  
  // Si aucun ingrédient n'est défini, initialiser un tableau vide
  if (!$ingredients) {
      $ingredients = [];
  }

  // Affichage du formulaire
  ?>
  <style>
    .item:not(:first-child) {
      border-top: 1px solid lightgray;
      padding-top: 0.25rem;
      margin-top: 1.5rem;
    }
    .first-box {
      position: relative;
      padding-bottom: 1.5rem;
    }

    .first-box:after {
      position: absolute;
      height: 1px;
      width: 200%;
      background-color: lightgray;
      content: '';
      bottom: 0;
      left: -50%;
      right: -50%;
    }
  </style>
  <div id="ingredient-metabox">
      <div class="acf-field acf-field-number first-box">
        <!-- Champ pour le nombre de personnes -->
         <div class="acf-label">
          <label for="people_count">Nombre de personnes :</label>
        </div>
        <div class="acf-input">
          <input type="number" id="people_count" name="people_count" value="<?php echo esc_attr($people_count); ?>" placeholder="Entrez le nombre de personnes" />
        </div>
      </div>
      <ul id="ingredient-list" class="flex flex-col gap-4">
          <?php foreach ($ingredients as $index => $ingredient) : ?>
              <li class="item">
                <div class="acf-field acf-field-number">
                  <div class="acf-label">
                    <label for="ingredient-name-<?php echo $index; ?>">Nom de l'ingrédient</label>
                  </div>
                  <div class="acf-input">
                    <input type="text" id="ingredient-name-<?php echo $index; ?>" name="ingredient[<?php echo $index; ?>][name]" value="<?php echo esc_attr($ingredient['name']); ?>" placeholder="Nom de l'ingrédient" />
                  </div>
                </div>
                <div class="acf-field acf-field-number">
                  <div class="acf-label">
                    <label for="ingredient-quantity-<?php echo $index; ?>">Quantité</label>
                  </div>
                  <div class="acf-input">
                    <input type="number" id="ingredient-quantity-<?php echo $index; ?>" name="ingredient[<?php echo $index; ?>][quantity]" value="<?php echo esc_attr($ingredient['quantity']); ?>" placeholder="Quantité" />
                  </div>
                </div>
                <div class="acf-field acf-field-number">
                  <div class="acf-label">
                    <label for="ingredient-name-<?php echo $index; ?>">Unité</label>
                  </div>
                  <div class="acf-input">
                    <input type="text" id="ingredient-unit-<?php echo $index; ?>" name="ingredient[<?php echo $index; ?>][unit]" value="<?php echo esc_attr($ingredient['unit']); ?>" placeholder="Unité" />
                  </div>
                </div>
                <button type="button" class="remove-ingredient">Supprimer</button>
              </li>
          <?php endforeach; ?>
      </ul>
      <button type="button" id="add-ingredient-button">Ajouter un ingrédient</button>
  </div>
  <script>
      document.getElementById('add-ingredient-button').addEventListener('click', function() {
          let ingredientList = document.getElementById('ingredient-list');
          let newIndex = ingredientList.children.length;
          let newIngredient = document.createElement('li');
          newIngredient.classList.add('item');
          newIngredient.innerHTML = `
              <div class="acf-field acf-field-number">
                  <div class="acf-label">
                    <label for="ingredient-name-${newIndex}">Nom de l'ingrédient</label>
                  </div>
                  <div class="acf-input">
                    <input type="text" id="ingredient-name-${newIndex}" name="ingredient[${newIndex}][name]" placeholder="Nom de l'ingrédient" />
                  </div>
                </div>
                <div class="acf-field acf-field-number">
                  <div class="acf-label">
                    <label for="ingredient-quantity-${newIndex}">Quantité</label>
                  </div>
                  <div class="acf-input">
                    <input type="number" id="ingredient-quantity-${newIndex}" name="ingredient[${newIndex}][quantity]" placeholder="Quantité" />
                  </div>
                </div>
                <div class="acf-field acf-field-number">
                  <div class="acf-label">
                    <label for="ingredient-name-${newIndex}">Unité</label>
                  </div>
                  <div class="acf-input">
                    <input type="text" id="ingredient-unit-${newIndex}" name="ingredient[${newIndex}][unit]" placeholder="Unité" />
                  </div>
                </div>
                <button type="button" class="remove-ingredient">Supprimer</button>
          `;
          ingredientList.appendChild(newIngredient);
      });

      document.getElementById('ingredient-list').addEventListener('click', function(event) {
          if (event.target && event.target.classList.contains('remove-ingredient')) {
              event.target.closest('li').remove();
          }
      });
  </script>
  <?php
}


// Enregistrer les données du metabox
function save_ingredient_metabox($post_id) {
  if (isset($_POST['ingredient'])) {
      update_post_meta($post_id, '_ingredients', $_POST['ingredient']);
  }

  // Enregistrer le nombre de personnes
  if (isset($_POST['people_count'])) {
    update_post_meta($post_id, '_people_count', sanitize_text_field($_POST['people_count']));
  }
}
add_action('save_post', 'save_ingredient_metabox');
