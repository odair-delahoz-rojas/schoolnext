<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class TestController extends AppController
{
  // $this->module_name, $this->controller_name, $this->action_name, 
  // $this->parameters, $this->limit_params, $this->scaffold, $this->data
  protected function before_filter() 
  {
    View::template('layout_adminlte4');
  }

  public function index()
  {
    $this->page_action = 'Test Page';
    $id_photo = (Session::get('documento') !=$this->user_id) ? Session::get('documento') : $this->user_id;
    $this->user = [
      'username' => $this->user_name,
      'name' => $this->user_nombre_completo,
      'image' => 'img/upload/users/'.$id_photo.'.png',
      'title' => '',
      'profile_link' => 'pages/miperfil',
      'signout_link' => 'logout'
    ];
  }

  
  public function api_dolibarr()
  {
    try {
      $this->page_action = 'Test Dolibarr';
      $this->action_name = 'api_dolibarr';
      $this->page_title = 'Test API Dolibarr';
      
      $endpoint_lists = [
        'userlist' => 
          [
            'title' => 'Listar Usuarios',
            'url' => 'users?sortfield=t.rowid&sortorder=ASC&limit=100',
            'fields' => ['lastname', 'firstname', 'email', 'address', 'user_mobile', 'town', 'login', 'job', 'country_id', 'gender', 'office_phone', 'note_private' ],
          ],
        'agendaevents' => 
          [
            'title' => 'Get a list of Agenda Events',
            'url' => 'agendaevents?sortfield=t.id&sortorder=ASC&limit=100',
            'fields' => ['label', 'note_private', 'type', 'type_code', 'type_label', 'code', 'datec', 'datem', 'datep', 'datef', 'fulldayevent', 'location', 'priority', 'percentage' ],
          ],
        'setupcompany' => 
          [
            'title' => 'Get Info Company',
            'url' => 'setup/company',
            'fields' => ['module', 'country_id', 'country_code', 'state_id', 'note_private', 'name', 'address', 'town', 'phone', 'phone_mobile', 'email', 'url'],
          ],
      ];

      
      $endpoint_name = 'userlist';
      $this->arrData = [
        'title' => 'Test API Dolibarr',
        'content' => 'Probando conexion con API Dolibarr',
        'apiUrl' => Config::get('dolibarr.'.$this->_instituto_id.'.api_url'),
        'apiKey' => Config::get('dolibarr.'.$this->_instituto_id.'.api_key'),
        'endpoint' => 
          [
            'name' => $endpoint_name,
            'title' => $endpoint_lists[$endpoint_name]['title'],
            'url' => $endpoint_lists[$endpoint_name]['url'],
            'fields' => $endpoint_lists[$endpoint_name]['fields'],
          ],
      ];

      $apiClient = new ApiClient(apiUrl: $this->arrData['apiUrl'], apiToken: $this->arrData['apiKey'] );
      $this->data = $apiClient->get(endpoint: $this->arrData['endpoint']['url']);
      
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th, true);
    }
  }
  

}