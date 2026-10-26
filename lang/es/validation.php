<?php

// Mensajes de validación en español (solo las reglas que usa la aplicación)
return [
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'current_password' => 'La contraseña no es correcta.',
    'email' => ':Attribute debe ser un correo válido.',
    'exists' => ':Attribute seleccionado no existe.',
    'integer' => ':Attribute debe ser un número entero.',
    'lowercase' => ':Attribute debe estar en minúsculas.',
    'max' => [
        'numeric' => ':Attribute no puede ser mayor que :max.',
        'string' => ':Attribute no puede tener más de :max caracteres.',
        'file' => ':Attribute no puede pesar más de :max kilobytes.',
    ],
    'mimes' => ':Attribute debe ser un archivo de tipo: :values.',
    'min' => [
        'numeric' => ':Attribute debe ser al menos :min.',
        'string' => ':Attribute debe tener al menos :min caracteres.',
    ],
    'numeric' => ':Attribute debe ser un número.',
    'password' => [
        'letters' => ':Attribute debe tener al menos una letra.',
        'mixed' => ':Attribute debe tener mayúsculas y minúsculas.',
        'numbers' => ':Attribute debe tener al menos un número.',
        'symbols' => ':Attribute debe tener al menos un símbolo.',
        'uncompromised' => 'Esta contraseña apareció en una filtración de datos. Usa otra.',
    ],
    'required' => 'Falta :attribute.',
    'string' => ':Attribute debe ser texto.',
    'unique' => 'Ya existe un registro con ese :attribute.',

    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo',
        'password' => 'contraseña',
        'current_password' => 'contraseña actual',
        'description' => 'descripción',
        'category_id' => 'categoría',
        'sku' => 'SKU',
        'price' => 'precio',
        'stock' => 'stock',
        'min_stock_alert' => 'stock mínimo',
        'product_id' => 'producto',
        'type' => 'tipo de movimiento',
        'quantity' => 'cantidad',
        'reference_note' => 'nota',
        'file' => 'archivo',
    ],
];
