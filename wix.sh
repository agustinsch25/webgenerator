#!/bin/bash

echo $2
if [ -z "$1" ] || [ -z "$2" ]; then
  echo "Por favor, proporcione el nombre del proyecto y el contenido de index.php como argumentos."
  exit 1
fi

# mkdir -p $dominio
proyecto="$1"
contenido_index="$2"

mkdir -p "$proyecto"
echo "$contenido_index" > "$proyecto/index.php"
mkdir -p "$proyecto/css/user"
mkdir -p "$proyecto/css/admin"
echo "" > "$proyecto/css/user/estilo.css"
echo "" > "$proyecto/css/admin/estilo.css"
mkdir -p "$proyecto/img/avatars"
mkdir -p "$proyecto/img/buttons"
mkdir -p "$proyecto/img/products"
mkdir -p "$proyecto/img/pets"
mkdir -p "$proyecto/js/validations"
echo "" > "$proyecto/js/validations/login.js"
echo "" > "$proyecto/js/validations/register.js"
mkdir -p "$proyecto/js/effects"
echo "" > "$proyecto/js/effects/panels.js"
mkdir -p "$proyecto/tpl"
echo "" > "$proyecto/tpl/main.tpl"
echo "" > "$proyecto/tpl/login.tpl"
echo "" > "$proyecto/tpl/register.tpl"
echo "" > "$proyecto/tpl/panel.tpl"
echo "" > "$proyecto/tpl/profile.tpl"
echo "" > "$proyecto/tpl/crud.tpl"
mkdir -p "$proyecto/php"
echo "" > "$proyecto/php/create.tpl"
echo "" > "$proyecto/php/read.tpl"
echo "" > "$proyecto/php/update.tpl"
echo "" > "$proyecto/php/delete.tpl"
echo "" > "$proyecto/php/dbconnect.tpl"

echo "Estructura de directorios y archivos creada con éxito para el proyecto: $proyecto."
