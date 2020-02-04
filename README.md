# symfony-base

Base pour projet symfony 5

## Étapes
* Modif du .env avec les infos de la DB
* Création du HomeController pour affichage de la home page (/)
* Installation de package encore (`composer require encore` et `npm install`)
* Config encore SASS `npm install sass-loader@^7.0.1 node-sass --save-dev`
* Config encore jquery `npm install jquery --save-dev`
* Config encore bootstrap `npm install bootstrap --save-dev`
* Config encore popper.js `npm install --save popper.js`
* Config encore édition du fichier app.css -> app.scss et app.js
* Mise en place de la base, du header et du footer

---
* Création de la base de donnée `php bin/console doctrine:database:create`