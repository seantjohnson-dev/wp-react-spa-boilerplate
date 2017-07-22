<?php
namespace SeanJohn\Customizer\Panels;

use SeanJohn\Customizer\Lib\BaseCustomizer;
use SeanJohn\Utils\TemplateLoader as Loader;
use Kirki as Kirki;

class Hero extends BaseCustomizer
{
  public function __construct($wp_cust)
  {
    parent::__construct($wp_cust);
    $this->edit_existing($wp_cust);
  }

  public function set_panels()
  {
    Kirki::add_panel('hero_text', array(
      'priority' => 30,
      'title' => __('Hero Options', TEXT_DOMAIN),
      'description' => __('Configure the Hero options here.', TEXT_DOMAIN),
    ));

    return $this;
  }

  public function set_sections()
  {
    Kirki::add_section('home_page', array(
      'title' => __('Home Page Text', TEXT_DOMAIN),
      'panel' => 'hero_text',
      'priority' => 10
    ));

    Kirki::add_section('away_text', array(
      'title' => __('Away Game Text', TEXT_DOMAIN),
      'panel' => 'hero_text',
      'priority' => 20
    ));

    Kirki::add_section('off_game', array(
      'title' => __('Off Game Text', TEXT_DOMAIN),
      'panel' => 'hero_text',
      'priority' => 30
    ));

    Kirki::add_section('open_text', array(
      'title' => __('Roof Open Text', TEXT_DOMAIN),
      'panel' => 'hero_text',
      'priority' => 40
    ));

    Kirki::add_section('closed_text', array(
      'title' => __('Roof Closed Text', TEXT_DOMAIN),
      'panel' => 'hero_text',
      'priority' => 50
    ));

    Kirki::add_section('unknown_text', array(
      'title' => __('Roof Unknown Text', TEXT_DOMAIN),
      'panel' => 'hero_text',
      'priority' => 60
    ));

    return $this;
  }

  public function set_controls()
  {
    $this->set_home_page_controls()
    ->set_away_game_controls()
    ->set_off_game_controls()
    ->set_open_home_game_controls()
    ->set_closed_home_game_controls()
    ->set_unknown_home_game_controls();
    return $this;
  }

  public function set_home_page_controls() {

    Kirki::add_field('home_page_top_text', array(
        'type' => 'text',
        'settings' => 'home_page_top_text',
        'label' => esc_attr__('Top Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the top line text here', TEXT_DOMAIN),
        'section' => 'home_page',
          'default' => 'Is the roof',
        'priority' => 10
    ));

    Kirki::add_field('home_page_middle_text', array(
        'type' => 'text',
        'settings' => 'home_page_middle_text',
        'label' => esc_attr__('Middle Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the middle line text here', TEXT_DOMAIN),
        'section' => 'home_page',
          'default' => 'open',
        'priority' => 20
    ));

    Kirki::add_field('home_page_bottom_text', array(
        'type' => 'text',
        'settings' => 'home_page_bottom_text',
        'label' => esc_attr__('Bottom Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the bottom line text here', TEXT_DOMAIN),
        'section' => 'home_page',
          'default' => 'Game day stadium info for the retractable roofed fans among us.',
        'priority' => 30
    ));

    Kirki::add_field('home_page_stadium_select_text', array(
        'type' => 'text',
        'settings' => 'home_page_stadium_select_text',
        'label' => esc_attr__('Stadium Select Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the stadium select text here', TEXT_DOMAIN),
        'section' => 'home_page',
          'default' => 'Select your stadium below',
        'priority' => 40
    ));

    return $this;
  }

  public function set_away_game_controls() {

    Kirki::add_field('away_game_top_text', array(
        'type' => 'text',
        'settings' => 'away_game_top_text',
        'label' => esc_attr__('Away Game Top Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the top line text here', TEXT_DOMAIN),
        'section' => 'away_text',
          'default' => 'The {{home_team.nickname}} are',
        'priority' => 10
    ));

    Kirki::add_field('away_game_middle_text', array(
        'type' => 'text',
        'settings' => 'away_game_middle_text',
        'label' => esc_attr__('Away Game Middle Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the middle line text here', TEXT_DOMAIN),
        'section' => 'away_text',
          'default' => 'visiting',
        'priority' => 20
    ));

    Kirki::add_field('away_game_bottom_text', array(
        'type' => 'text',
        'settings' => 'away_game_bottom_text',
        'label' => esc_attr__('Away Game Bottom Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the bottom line text here', TEXT_DOMAIN),
        'section' => 'away_text',
          'default' => 'the {{away_team.nickname}}',
        'priority' => 30
    ));

    return $this;
  }

  public function set_off_game_controls() {

    Kirki::add_field('off_game_top_text', array(
        'type' => 'text',
        'settings' => 'off_game_top_text',
        'label' => esc_attr__('Top Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the top line text here', TEXT_DOMAIN),
        'section' => 'off_game',
          'default' => 'Today is an',
        'priority' => 10
    ));

    Kirki::add_field('off_game_middle_text', array(
        'type' => 'text',
        'settings' => 'off_game_middle_text',
        'label' => esc_attr__('Middle Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the middle line text here', TEXT_DOMAIN),
        'section' => 'off_game',
          'default' => 'off day',
        'priority' => 20
    ));

    Kirki::add_field('off_game_bottom_text', array(
        'type' => 'text',
        'settings' => 'off_game_bottom_text',
        'label' => esc_attr__('Bottom Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the bottom line text here', TEXT_DOMAIN),
        'section' => 'off_game',
          'default' => 'for the {{home_team.nickname}}',
        'priority' => 30
    ));

    Kirki::add_field('off_game_washer_lcd_text', array(
        'type' => 'text',
        'settings' => 'off_game_washer_lcd_text',
        'label' => esc_attr__('Washer LCD Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the text that will show in the top-right lcd of the washer image.', TEXT_DOMAIN),
        'section' => 'off_game',
          'default' => 'Check back tomorrow.',
        'priority' => 40
    ));

    return $this;
  }

  public function set_open_home_game_controls() {

    Kirki::add_field('open_top_text', array(
        'type' => 'text',
        'settings' => 'open_top_text',
        'label' => esc_attr__('Top Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the top line text here', TEXT_DOMAIN),
        'section' => 'open_text',
          'default' => 'The roof is',
        'priority' => 10
    ));

    Kirki::add_field('open_middle_text', array(
        'type' => 'text',
        'settings' => 'open_middle_text',
        'label' => esc_attr__('Middle Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the middle line text here', TEXT_DOMAIN),
        'section' => 'open_text',
          'default' => 'open',
        'priority' => 20
    ));

    Kirki::add_field('open_bottom_text', array(
        'type' => 'text',
        'settings' => 'open_bottom_text',
        'label' => esc_attr__('Bottom Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the bottom line text here', TEXT_DOMAIN),
        'section' => 'open_text',
          'default' => 'for today\'s game',
        'priority' => 30
    ));

    return $this;
  }

  public function set_closed_home_game_controls() {

    Kirki::add_field('closed_top_text', array(
        'type' => 'text',
        'settings' => 'closed_top_text',
        'label' => esc_attr__('Top Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the top line text here', TEXT_DOMAIN),
        'section' => 'closed_text',
          'default' => 'The roof is',
        'priority' => 10
    ));

    Kirki::add_field('closed_middle_text', array(
        'type' => 'text',
        'settings' => 'closed_middle_text',
        'label' => esc_attr__('Middle Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the middle line text here', TEXT_DOMAIN),
        'section' => 'closed_text',
          'default' => 'closed',
        'priority' => 20
    ));

    Kirki::add_field('closed_bottom_text', array(
        'type' => 'text',
        'settings' => 'closed_bottom_text',
        'label' => esc_attr__('Bottom Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the bottom line text here', TEXT_DOMAIN),
        'section' => 'closed_text',
          'default' => 'for today\'s game',
        'priority' => 30
    ));

    return $this;
  }

  public function set_unknown_home_game_controls() {

    Kirki::add_field('unknown_top_text', array(
        'type' => 'text',
        'settings' => 'unknown_top_text',
        'label' => esc_attr__('Top Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the top line text here', TEXT_DOMAIN),
        'section' => 'unknown_text',
          'default' => 'The roof is',
        'priority' => 10
    ));

    Kirki::add_field('unknown_middle_text', array(
        'type' => 'text',
        'settings' => 'unknown_middle_text',
        'label' => esc_attr__('Middle Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the middle line text here', TEXT_DOMAIN),
        'section' => 'unknown_text',
          'default' => 'iffy',
        'priority' => 20
    ));

    Kirki::add_field('unknown_bottom_text', array(
        'type' => 'text',
        'settings' => 'unknown_bottom_text',
        'label' => esc_attr__('Bottom Line Text', TEXT_DOMAIN),
        'description' => esc_attr__('Enter the bottom line text here', TEXT_DOMAIN),
        'section' => 'unknown_text',
          'default' => 'for today\'s game',
        'priority' => 30
    ));

    Kirki::add_field('unknown_stadium_image', array(
      'settings' => 'unknown_stadium_image',
      'label' => __('Unknown Stadium Image', TEXT_DOMAIN),
      'description' => __('This image is the image that will show up if the roof status for the game is unknown.', TEXT_DOMAIN),
      'section' => 'unknown_text',
      'type' => 'image',
      'priority' => 40,
      'default' => null,
      'option_type' => 'option'
    ));

    return $this;
  }

  public function edit_existing($wp_cust)
  {
    return $this;
  }

}
