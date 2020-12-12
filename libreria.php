<?php
/*Leer el archivo que contiene la informacion*/
function leerDatos(){
  $data_file = fopen('./data-1.json', 'r'); 
  $data = fread($data_file, filesize('./data-1.json')); 
  $data = json_decode($data, true); 
  fclose($data_file); 
  return ($data);
};

/*Inicializar los input select*/
function obtnciudad($getData){ 
  $getCities = Array(); 
  foreach ($getData as $cities => $city) { 
    if(in_array($city['Ciudad'], $getCities)){ 
      //Continuar
    }else{
      array_push($getCities, $city['Ciudad']); 
    }
  }
  echo json_encode($getCities); 
}

function obtnTipo($getData){ 
  $getTipo = Array(); 
  foreach ($getData as $tipos => $tipo) { 
    if(in_array($tipo['Tipo'], $getTipo)){ 
      
    }else{
      array_push($getTipo, $tipo['Tipo']); 
    }
  }
  echo json_encode($getTipo); 
}

/*Filtrar la información*/
function filtrarDatos($filtroCiudad, $filtroTipo, $filtroPrecio,$data){
  $itemList = Array(); 
  if($filtroCiudad == "" and $filtroTipo=="" and $filtroPrecio==""){ 
    foreach ($data as $index => $item) {
      array_push($itemList, $item); 
    }
  }else{ 

    $menor = $filtroPrecio[0]; 
    $mayor = $filtroPrecio[1]; 

      if($filtroCiudad == "" and $filtroTipo == ""){ 
        foreach ($data as $items => $item) {
            $precio = precioNumero($item['Precio']);
        if ( $precio >= $menor and $precio <= $mayor){ 
            array_push($itemList,$item ); 
          }
        }
      }

      if($filtroCiudad != "" and $filtroTipo == ""){ //Comparar si el precio se encuentra dentro de los valores del filtro
          foreach ($data as $index => $item) {
            $precio = precioNumero($item['Precio']);
            if ($filtroCiudad == $item['Ciudad'] and $precio > $menor and $precio < $mayor){ //Comparar si el precio se encuentra dentro de los valores del filtro
              array_push($itemList,$item ); //Devolver el objeto cuyo precio se encuentra dentro del rango establecido.
            }
        }
      }

      if($filtroCiudad == "" and $filtroTipo != ""){ //Comparar si el precio se encuentra dentro de los valores del filtro
          foreach ($data as $index => $item) {
            $precio = precioNumero($item['Precio']);
            if ($filtroTipo == $item['Tipo'] and $precio > $menor and $precio < $mayor){ //Comparar si el precio se encuentra dentro de los valores del filtro
              array_push($itemList,$item ); //Devolver el objeto cuyo precio se encuentra dentro del rango establecido.
            }
        }
      }

      if($filtroCiudad != "" and $filtroTipo != ""){ //Comparar si el precio se encuentra dentro de los valores del filtro
          foreach ($data as $index => $item) {
            $precio = precioNumero($item['Precio']);
            if ($filtroTipo == $item['Tipo'] and $filtroCiudad == $item['Ciudad'] and $precio > $menor and $precio < $mayor){ //Comparar si el precio se encuentra dentro de los valores del filtro
              array_push($itemList,$item ); //Devolver el objeto cuyo precio se encuentra dentro del rango establecido.
            }
        }
      }


  }
  echo json_encode($itemList); //Devolver el arreglo en formato JSON
};

function precioNumero($itemPrecio){ //Convertir la cadena de caracteres en numero
  $precio = str_replace('$','',$itemPrecio); //Eliminar el símbolo Dolar
  $precio = str_replace(',','',$precio); //Eliminar la coma (separador de miles)
  return $precio; //Devolver el falor de tipo Numero
}
?>
