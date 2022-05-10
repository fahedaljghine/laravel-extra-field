<?php

return [

    /*
     * The class name of the extra model that holds all extras.
     *
     * The model must be or extend `Fahedaljghine\ExtraField\Extra`.
     */
    'extra_model' => Fahedaljghine\ExtraField\Extra::class,

    /*
     * The class name of the extra value model that holds all values.
     *
     * The model must be or extend `Fahedaljghine\ExtraField\ExtraValue`.
     */
    'extra_value_model' => Fahedaljghine\ExtraField\ExtraValue::class,

    /*
     * The name of the column which holds the ID of the model related to the extra values.
     *
     * You can change this value if you have set a different name in the migration for the extra_values table.
     */
    'model_primary_key_attribute' => 'model_id',


    /*
     * The name of the column which holds the Class Name of the model related to the extras.
     *
     * You can change this value if you have set a different name in the migration for the extras table.
     */
    'model_name_attribute' => 'model_class',
];
