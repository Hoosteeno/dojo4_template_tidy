<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dojo4_template_tidy_acc {

  var $name   = 'dojo4 Template Tidy';
  var $id     = 'dojo4_template_tidy';
  var $version    = '0.1';
  var $description  = 'Tidies Templates';
  
  /**
   * Constructor
   */
  function Dojo4_template_tidy_acc()
  {
    $this->EE =& get_instance();
  }

  /**
   * Set Sections
   *
   * Create script tags, buttons, and add to CP if on 'edit template' screen
   *
   * @access  public
   * @return  void
   */
  function set_sections()
  {

    $this->EE->load->helper('path');
    $script_path = $this->EE->config->default_ini['theme_folder_url'] .  'third_party/dojo4_themes/js/';
    $beautify_html_tag = '<script type="text/javascript" src="'.$script_path.'beautify_html.js"></script>';
    $beautify_js_tag = '<script type="text/javascript" src="'.$script_path.'beautify.js"></script>';
    $button_tag = '<input type="submit" name="dojo4_template_tidy" value="Tidy" class="submit dojo4_template_tidy">'; 

    $this->sections['How do I do it?'] = $button_tag . $beautify_html_tag . $beautify_js_tag; 

    $this->EE->load->library('javascript');

    $str = <<<END

    template_data = $('#template_data');

    if (template_data.length) {
      $('[name=update_and_return]').after('$button_tag');

      $('input.dojo4_template_tidy').click(function() {
        template_data.first().val(style_html(template_data.first().val(), 2, ' ', 999));
        return(false);
      });
    }
    else {
      $('input.dojo4_template_tidy').parent('li').remove();
    }
    
END;

    $this->EE->javascript->output($str);
    
    if($this->EE->input->get('D') == 'cp' AND $this->EE->input->get('C') == 'addons_accessories')
    {
      $this->EE->db->where('class', 'Dojo4_template_tidy_acc');
      $this->EE->db->update('accessories', array('controllers' => 'design'));
    }
  }
}
// END CLASS
