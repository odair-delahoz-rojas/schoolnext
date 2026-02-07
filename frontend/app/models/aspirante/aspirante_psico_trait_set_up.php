<?php

trait AspirantePsicoTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar, AspiranteTraitProps;

  private function setUp() {
    $date = date("Y-m-d");

    self::$_fields_show = [
      'all'      => [ 'afecto', 'antecfami', 'aprendizaje', 'aspirante_id', 'autocuidado', 'comporta', 'created_at', 'created_by', 'cumplnormas', 'desfisico', 
                      'especialista', 'extra', 'fortalezas', 'id', 'lenguaje', 'manejoautor', 'nucleofamil', 'porquedesea', 'proceso_acad', 'reforzar', 
                      'rel_pad_mad', 'rel_pad_mad_desc', 'reldocentes', 'relhermanos', 'relpadres', 'relpares', 'updated_at', 'updated_by', 'uuid', 'vive_con' 
                    ],

      'index'    => [ 'id', 'aspirante_id', 'uuid' ],

      'create'   => [ 'afecto', 'antecfami', 'aprendizaje', 'aspirante_id', 'autocuidado', 'comporta', 'created_at', 'created_by', 'cumplnormas', 'desfisico', 
                      'especialista', 'extra', 'fortalezas', 'id', 'lenguaje', 'manejoautor', 'nucleofamil', 'porquedesea', 'proceso_acad', 'reforzar', 
                      'rel_pad_mad', 'rel_pad_mad_desc', 'reldocentes', 'relhermanos', 'relpadres', 'relpares', 'updated_at', 'updated_by', 'uuid', 'vive_con' 
                    ],

      'edit'     => [ 'afecto', 'antecfami', 'aprendizaje', 'aspirante_id', 'autocuidado', 'comporta', 'created_at', 'created_by', 'cumplnormas', 'desfisico', 
                      'especialista', 'extra', 'fortalezas', 'lenguaje', 'manejoautor', 'nucleofamil', 'porquedesea', 'proceso_acad', 'reforzar', 
                      'rel_pad_mad', 'rel_pad_mad_desc', 'reldocentes', 'relhermanos', 'relpadres', 'relpares', 'updated_at', 'updated_by', 'vive_con'
                    ],

      'editUuid' => [ 'afecto', 'antecfami', 'aprendizaje', 'aspirante_id', 'autocuidado', 'comporta', 'created_at', 'created_by', 'cumplnormas', 'desfisico', 
                      'especialista', 'extra', 'fortalezas', 'lenguaje', 'manejoautor', 'nucleofamil', 'porquedesea', 'proceso_acad', 'reforzar', 
                      'rel_pad_mad', 'rel_pad_mad_desc', 'reldocentes', 'relhermanos', 'relpadres', 'relpares', 'updated_at', 'updated_by', 'vive_con'
                    ],
    ];
  
    self::$_attribs = [
      'afecto' =>  ' maxlength="1024" ',
      'antecfami' =>  ' maxlength="1024" ',
      'aprendizaje' =>  ' maxlength="1024" ',
      //'aspirante_id' =>  '',
      'autocuidado' =>  ' maxlength="1024" ',
      'comporta' =>  ' maxlength="1024" ',
      //'created_at' =>  '',
      //'created_by' =>  '',
      'cumplnormas' =>  'maxlength="1024" ',
      'desfisico' =>  ' maxlength="1024" ',
      'especialista' => ' maxlength="1024" ',
      //'extra' =>  '',
      'fortalezas' =>  ' maxlength="1024" ',
      'id' =>  'required',
      'lenguaje' =>  ' maxlength="1024" ',
      'manejoautor' =>  ' maxlength="1024" ',
      'nucleofamil' =>  ' maxlength="1024" ',
      'porquedesea' =>  ' required maxlength="1024" ',
      'proceso_acad' =>  ' maxlength="1024" ',
      'reforzar' =>  ' maxlength="1024" ',
      'rel_pad_mad' =>  ' maxlength="1024" ',
      'rel_pad_mad_desc' =>  '',
      'reldocentes' =>  ' maxlength="1024" ',
      'relhermanos' =>  ' maxlength="1024" ',
      'relpadres' =>  ' maxlength="1024" ',
      'relpares' =>  ' maxlength="1024" ',
      //'updated_at' =>  '',
      //'updated_by' =>  '',
      'uuid' =>  ' required ',
      'vive_con' =>  ' maxlength="1024" ',
    ];
  
    self::$_defaults = [
      //'afecto' =>  '',
      //'antecfami' =>  '',
      //'aprendizaje' =>  '',
      //'aspirante_id' =>  '',
      //'autocuidado' =>  '',
      //'comporta' =>  '',
      //'created_at' =>  '',
      //'created_by' =>  '',
      //'cumplnormas' =>  '',
      //'desfisico' =>  '',
      //'especialista' =>  '',
      //'extra' =>  '',
      //'fortalezas' =>  '',
      //'id' =>  '',
      //'lenguaje' =>  '',
      //'manejoautor' =>  '',
      //'nucleofamil' =>  '',
      //'porquedesea' =>  '',
      //'proceso_acad' =>  '',
      //'reforzar' =>  '',
      //'rel_pad_mad' =>  '',
      //'rel_pad_mad_desc' =>  '',
      //'reldocentes' =>  '',
      //'relhermanos' =>  '',
      //'relpadres' =>  '',
      //'relpares' =>  '',
      //'updated_at' =>  '',
      //'updated_by' =>  '',
      //'uuid' =>  '',
      //'vive_con' =>  '',

    ];
    
    self::$_widgets = [
      'afecto' =>  'textarea',
      'antecfami' =>  'textarea',
      'aprendizaje' =>  'textarea',
      'aspirante_id' =>  'textarea',
      'autocuidado' =>  'textarea',
      'comporta' =>  'textarea',
      //'created_at' =>  '',
      //'created_by' =>  '',
      'cumplnormas' =>  'textarea',
      'desfisico' =>  'textarea',
      'especialista' =>  'textarea',
      //'extra' =>  '',
      'fortalezas' =>  'textarea',
      //'id' =>  '',
      'lenguaje' =>  'textarea',
      'manejoautor' =>  'textarea',
      'nucleofamil' =>  'textarea',
      'porquedesea' =>  'textarea',
      'proceso_acad' =>  'textarea',
      'reforzar' =>  'textarea',
      'rel_pad_mad' =>  'textarea',
      'rel_pad_mad_desc' =>  'textarea',
      'reldocentes' =>  'textarea',
      'relhermanos' =>  'textarea',
      'relpadres' =>  'textarea',
      'relpares' =>  'textarea',
      //'updated_at' =>  '',
      //'updated_by' =>  '',
      //'uuid' =>  '',
      'vive_con' =>  'textarea',
    ];

    self::$_helps = [
      'afecto' =>  'Escriba si manifiesta expresiones de afecto con los demás, o si se le dificulta y cómo es el control de sus emociones',
      'antecfami' =>  'Antecedentes de Enfermedades Familiares',
      'aprendizaje' =>  'Escriba cómo ha sido su aprendizaje, si ha manifestado dificultades en procesos como: atención, memoria, concentración, motricidad, lectura, escritura, si capta con facilidad o no, si sigue instrucciones o no, si ha recibido algún diagnóstico en ésta área',
      //'aspirante_id' =>  '',
      'autocuidado' =>  'Cuidado de sí mismo: Es capaz o no de realizar actividades por sí mismo tales como: comer, ir al baño, amarrarse los zapatos, vestirse, hacer tareas',
      'comporta' =>  'Escriba cómo es su comportamiento en general, acata normas, se relaciona con otros, si ha manifestado dificultades, en su comportamiento consigo mismo o con los demás y si recibe o recibió algún tratamiento',
      'cumplnormas' =>  'Describa cómo ha sido el comportamiento de su hijo en el colegio',
      'desfisico' =>  'Escriba cómo ha sido la salud del niño en general, si ha sufrido enfermedades físicas y si recibe o recibió tratamiento, si toma o no medicamentos y el nombre del medicamento',
      'especialista' =>  'Escriba si el estudiante ha requerido evaluación y tratamiento de algún especialista (Terapia Ocupacional, Terapia de Lenguaje, Psicológica, Psiquiátrica)? ¿por sugerencia de quién?',
      //'extra' =>  '',
      'fortalezas' =>  'Fortalezas',
      'lenguaje' =>  'Escriba el desarollo del lenguaje, edad a la que comenzó a hablar, si ha sufrido alteraciones del lenguaje, de qué tipo y si recibe tratamiento',
      'manejoautor' =>  'Escriba cómo es el manejo del niño con respecto a sus autoridades y las reglas',
      'nucleofamil' =>  'Escriba los miembros del núcleo familiar',
      'porquedesea' =>  '¿Por qué desea que su hijo(a) ingrese a este colegio?',
      'proceso_acad' =>  'Describa el proceso Académico de su hijo hasta el momento: Si ha sido Excelente, Bueno, con dificultades y ¿porqué?',
      'reforzar' =>  'Áreas en las que necesita refuerzo',
      //'rel_pad_mad' =>  '',
      'rel_pad_mad_desc' =>  'Escriba cómo es la relación entre los padres',
      'reldocentes' =>  'Describa cómo ha sido la relación con docentes en general, si ha presentado dificultad en las relaciones y el abordaje del mismo',
      'relhermanos' =>  'Escriba cómo es la relación del niño con sus hermanos.',
      'relpadres' =>  'Escriba cómo es la relación con los padres, manejo de autoridad, afecto',
      'relpares' =>  'Escriba cómo ha sido la relación con sus compañeros de clase, si ha presentado dificultad en las relaciones y el abordaje del mismo',
      'vive_con' =>  '(Si están separados)<br/> personas con las que vive',
    ];
  
    self::$_labels = [
      'afecto' =>  'Expresiones de Afecto',
      'antecfami' =>  'Antecedentes de Enfermedades',
      'aprendizaje' =>  'Aprendizaje',
      'aspirante_id' =>  'Aspirante',
      'autocuidado' =>  'Autocuidado',
      'comporta' =>  'Comportamiento',
      //'created_at' =>  '',
      //'created_by' =>  '',
      'cumplnormas' =>  'Comportamiento Escolar',
      'desfisico' =>  'Desarrollo Físico',
      'especialista' =>  'Remisiones a Especialistas',
      //'extra' =>  '',
      'fortalezas' =>  'Fortalezas',
      //'id' =>  '',
      'lenguaje' =>  'Desarrollo del Lenguaje',
      'manejoautor' =>  'Manejo de Autoridad',
      'nucleofamil' =>  'Núcleo Familiar',
      'porquedesea' =>  'Por qué Windsor?',
      'proceso_acad' =>  'Proceso Académico',
      'reforzar' =>  'Reforzar',
      'rel_pad_mad' =>  'Los Padres están',
      'rel_pad_mad_desc' =>  'Relación entre Padres',
      'reldocentes' =>  'Relación con sus Docentes',
      'relhermanos' =>  'Relación con Hermanos',
      'relpadres' =>  'Relación con sus Padres',
      'relpares' =>  'Relación con sus Compañeros',
      //'updated_at' =>  '',
      //'updated_by' =>  '',
      //'uuid' =>  '',
      'vive_con' =>  'Vive con',
    ];
  
    self::$_placeholders = [
      //'afecto' =>  '',
      //'antecfami' =>  '',
      //'aprendizaje' =>  '',
      //'aspirante_id' =>  '',
      //'autocuidado' =>  '',
      //'comporta' =>  '',
      //'created_at' =>  '',
      //'created_by' =>  '',
      //'cumplnormas' =>  '',
      //'desfisico' =>  '',
      //'especialista' =>  '',
      //'extra' =>  '',
      //'fortalezas' =>  '',
      //'id' =>  '',
      //'lenguaje' =>  '',
      //'manejoautor' =>  '',
      //'nucleofamil' =>  '',
      //'porquedesea' =>  '',
      //'proceso_acad' =>  '',
      //'reforzar' =>  '',
      //'rel_pad_mad' =>  '',
      //'rel_pad_mad_desc' =>  '',
      //'reldocentes' =>  '',
      //'relhermanos' =>  '',
      //'relpadres' =>  '',
      //'relpares' =>  '',
      //'updated_at' =>  '',
      //'updated_by' =>  '',
      //'uuid' =>  '',
      //'vive_con' =>  '',
    ];
  
    $rules = [
      // 'numeric', 'int', 'maxlength', 'length', 'range', 'select', 'email', 'equal',
      // 'url', 'ip', 'required', 'alphanum', 'alpha', 'date', 'pattern', 'decimal',   
    ];
    self::$_rules_validators = array_merge(self::$_rules_validators, $rules);


  }



}