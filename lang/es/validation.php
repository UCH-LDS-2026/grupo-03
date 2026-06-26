<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'string' => 'El campo :attribute debe ser texto.',
    'email' => 'El campo :attribute debe ser un correo electrónico válido.',
    'max' => [
        'string' => 'El campo :attribute no puede superar los :max caracteres.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'unique' => 'El valor del campo :attribute ya está en uso.',
    'exists' => 'El valor seleccionado en :attribute no es válido.',
    'boolean' => 'El campo :attribute debe ser verdadero o falso.',
    'in' => 'El valor seleccionado en :attribute no es válido.',

    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'role' => 'rol',
        'title' => 'título',
        'description' => 'descripción',
        'area_id' => 'área',
        'ticket_category_id' => 'categoría',
        'requester_id' => 'solicitante',
        'assigned_user_id' => 'usuario asignado',
        'status' => 'estado',
        'priority' => 'prioridad',
        'comment_body' => 'comentario',
        'comment_is_internal' => 'comentario interno',
        'solution_summary' => 'resumen de solución',
        'solution_details' => 'detalle de solución',
    ],
];
