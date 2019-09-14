<?php 
if ( class_exists('WP_Customize_Control') ) :

  /**
   * Switch Controller ( Enable or Disable )
  */
  class medical_heed_switch_control extends WP_Customize_Control{

      public $type = 'switch';

      public $switch_label = array();

      public function __construct($manager, $id, $args = array() ){
          $this->switch_label = $args['switch_label'];
          parent::__construct( $manager, $id, $args );
      }

      public function render_content(){
      ?>
          <span class="customize-control-title">
              <?php echo esc_html( $this->label ); ?>
          </span>

          <?php if($this->description){ ?>
              <span class="description customize-control-description">
                <?php echo wp_kses_post( $this->description ); ?>
              </span>
          <?php } ?>

          <?php
              $switch_class = ($this->value() == 'enable') ? 'switch-on' : '';
              $switch_label = $this->switch_label;
          ?>
          <div class="onoffswitch <?php echo esc_attr( $switch_class ); ?>">
              <div class="onoffswitch-inner">
                  <div class="onoffswitch-active">
                      <div class="onoffswitch-switch"><?php echo esc_html( $switch_label['enable'] ) ?></div>
                  </div>

                  <div class="onoffswitch-inactive">
                      <div class="onoffswitch-switch"><?php echo esc_html( $switch_label['disable'] ) ?></div>
                  </div>
              </div>  
          </div>
          <input <?php $this->link(); ?> type="hidden" value="<?php echo esc_attr($this->value()); ?>"/>
          <?php
      }
  }

  /**
   * Multiple Check
  */
   class medical_heed_multiple_check_control extends WP_Customize_Control {

       /**
        * The type of customize control being rendered.
        *
        * @since  1.0.0
        * @access public
        * @var    string
        */
       public $type = 'checkbox-multiple';

       /**
        * Displays the control content.
        *
        * @since  1.0.0
        * @access public
        * @return void
        */
       public function render_content() {

           if ( empty( $this->choices ) )
               return; ?>
             
           <?php if ( !empty( $this->label ) ) : ?>
               <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
           <?php endif; ?>

           <?php if ( !empty( $this->description ) ) : ?>
               <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
           <?php endif; ?>

           <?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>
           <ul>
               <?php foreach ( $this->choices as $value => $label ) : ?>
                   <li>
                       <label>
                           <input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> /> 
                           <?php echo esc_html( $label ); ?>
                       </label>
                   </li>
               <?php endforeach; ?>
           </ul>
           <input type="hidden" <?php esc_url( $this->link() ); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
       <?php } 
    }

  /**
   * repeater field for customizer
  */
  class medical_heed_Repeater extends WP_Customize_Control {

        public $type = 'repeater';

        public $medical_heed_box_label = '';

        public $medical_heed_box_add_control = ''; 

        //fields that each container row will contain.
        public $fields = array();

        public function __construct ($manager, $id, $args = array(), $fields = array() ){

          $this->fields = $fields;
          $this->medical_heed_box_label = $args['medical_heed_box_label'] ;
          $this->medical_heed_box_add_control = $args['medical_heed_box_add_control'] ;
          parent::__construct( $manager, $id, $args );

        }

        public function render_content() {

        $values = json_decode($this->value()); ?>

          <ul class="medical-heed-repeater-field-control-wrap">
            <?php $this->medical_heed_get_fields(); ?>
          </ul>

          <input type="hidden" <?php esc_attr( $this->link() ); ?> class="medical-heed-repeater-collector" value="<?php echo esc_attr( $this->value() ); ?>" />
          <button type="button" class="button medical-heed-repeater-add-control-field">
            <?php echo esc_html( $this->medical_heed_box_add_control ); ?>
          </button>
        <?php }

         private function medical_heed_get_fields(){
            $fields = $this->fields;
            $values = json_decode($this->value());

            if(is_array($values)){

              foreach($values as $value){ ?>

                <li class="medical-heed-repeater-field-control">
                  <h3 class="medical-heed-repeater-field-title accordion-section-title">
                    <?php echo esc_html( $this->medical_heed_box_label ); ?>  
                  </h3>

                  <div class="medical-heed-repeater-fields">
                    <?php
                      foreach ($fields as $key => $field) {
                      $class = isset( $field['class'] ) ? $field['class'] : '';
                    ?>
                        <div class="medical-heed-fields medical-heed-type-<?php echo esc_attr( $field['type'] ).' '.esc_attr( $class ); ?>">
                          <?php
                            $label        = isset($field['label']) ? $field['label'] : '';
                            $description  = isset($field['description']) ? $field['description'] : '';

                            if($field['type'] != 'checkbox'){ ?>
                              <span class="customize-control-title">
                                <?php echo esc_html( $label ); ?>  
                              </span>
                              <span class="description customize-control-description">
                                <?php echo esc_html( $description ); ?> 
                              </span>
                          <?php }

                            $new_value  = isset($value->$key) ? $value->$key : '';
                            $default    = isset($field['default']) ? $field['default'] : '';

                            switch ( $field['type'] ) {

                              case 'url':
                                echo '<input data-default="'.esc_attr($default).'" data-name="'.esc_attr($key).'" type="text" value="'.esc_attr($new_value).'"/>';
                                break;

                              case 'icon':
                                echo '<div class="medical-heed-repeater-selected-icon">';
                                echo '<i class="'.esc_attr($new_value).'"></i>';
                                echo '<span><i class="fa fa-angle-down"></i></span>';
                                echo '</div>';
                                echo '<ul class="medical-heed-repeater-icon-list clearfix">';
                                  $medical_heed_awesome_icon_array = medical_heed_awesome_icon_array();

                                  foreach ($medical_heed_awesome_icon_array as $medical_heed_awesome_icon) {
                                    $icon_class = $new_value == $medical_heed_awesome_icon ? 'icon-active' : '';
                                    echo '<li class='.esc_attr( $icon_class ).'><i class="'.esc_attr( $medical_heed_awesome_icon ).'"></i></li>';
                                  }
                                echo '</ul>';
                                echo '<input data-default="'.esc_attr($default).'" type="hidden" value="'.esc_attr($new_value).'" data-name="'.esc_attr($key).'"/>';
                                break;
                                
                                case 'select':
                                  $options = $field['options'];
                                  echo '<select  data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'">';
                                        foreach ( $options as $option => $val )
                                        {
                                            printf('<option value="%s" %s>%s</option>', esc_attr($option), selected($new_value, $option, false), esc_html($val));
                                        }
                                  echo '</select>';
                                break;

                                case 'text':
                                  echo '<input data-default="'.esc_attr($default).'"  data-name="'.esc_attr($key).'" type="text"value="'.esc_attr($new_value).'"/>';
                                  break;

                              default:

                                break;
                            }
                          ?>
                        </div>
                    <?php } ?>
                    <div class="clearfix medical-heed-repeater-footer">
                      <div class="alignright">
                        <a class="medical-heed-repeater-field-remove" href="#remove">
                          <?php esc_html_e('Delete', 'medical-heed') ?>
                        </a> |
                        <a class="medical-heed-repeater-field-close" href="#close">
                          <?php esc_html_e('Close', 'medical-heed') ?>
                        </a>
                      </div>
                    </div>
                  </div>
                </li>
              <?php }
          }
        }
  }

endif;

/**
* repeater icons function
*/
if(!function_exists('medical_heed_awesome_icon_array') ){
  function medical_heed_awesome_icon_array(){
    return array("fas fa-ambulance","fas fa-hands","fas fa-pills","far fa-plus-square","fas fa-building","fas fa-briefcase","fas fa-medkit","fas fa-award","fas fa-bed","fas fa-band-aid","fas fa-assistive-listening-systems","fas fa-wheelchair","fas fa-hospital","fas fa-landmark","fas fa-address-card","fas fa-blind","fas fa-prescription-bottle-alt","fas fa-tablets","fas fa-file-medical-alt","fas fa-file-medical","fas fa-user-md","fas fa-mortar-pestle","fas fa-stethoscope","fas fa-prescription-bottle","fas fa-venus","fas fa-mars");
  }
}

/**
 * Switch Sanitization Function.
 *
 * @since 1.1
 */
function medical_heed_sanitize_switch($input) {
   $valid_keys = array(
        'enable'  => esc_html__( 'Enable', 'medical-heed' ),
        'disable' => esc_html__( 'Disable', 'medical-heed' )
   );
   if ( array_key_exists( $input, $valid_keys ) ) {
      return $input;
   } else {
      return '';
   }
}

  /**
* Repeat Fields Sanitization
*/
function medical_heed_sanitize_repeater($input){        
  $input_decoded = json_decode( $input, true );
  $allowed_html = array(
    'br' => array(),
    'em' => array(),
    'strong' => array(),
    'a' => array(
      'href' => array(),
      'class' => array(),
      'id' => array(),
      'target' => array()
    ),
    'button' => array(
      'class' => array(),
      'id' => array()
    )
  ); 

  if(!empty($input_decoded)) {
    foreach ($input_decoded as $boxes => $box ){
      foreach ($box as $key => $value){
        $input_decoded[$boxes][$key] = sanitize_text_field( $value );
      }
    }
    return json_encode($input_decoded);
  }      
  return $input;
}

/**
* select sanitization
*/
function medical_heed_sanitize_select( $input, $setting ){
   //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
  $input = sanitize_key($input);
  //get the list of possible select options 
  $choices = $setting->manager->get_control( $setting->id )->choices;
  //return input if valid or return default option
  return ( array_key_exists( $input, $choices ) ? $input : $setting->default );  
}

/**
 * Sanitize checkbox.
 *
 * @param  $input Whether the checkbox is input.
 */
function medical_heed_sanitize_checkbox( $input ) {
  return ( ( isset( $input ) && true === $input ) ? true : false );
}

/*
 *  Topbar Social Icons Active Callback Function.
*/
function medical_heed_social_active (){
  $social = get_theme_mod('medical_heed_social','enable');
  if ($social == 'enable') {
    return true;
  }
  else {
    return false;
  }
}
